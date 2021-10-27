<?php 

namespace App\Controllers;  
use CodeIgniter\Controller;

use App\Models\User;
use App\Models\UserParent;
use App\Models\SuperAdmin;
use App\Models\Merchant;
  
class RegisterController extends Controller
{
    public function userIndex()
    {
        helper(['form']);
        $data = [];
        echo view('user/register', $data);
    }

    public function parentIndex()
    {
        helper(['form']);
        $data = [];
        echo view('parent/register', $data);
    }

    public function merchantIndex()
    {
        helper(['form']);
        $data = [];
        echo view('merchant/register', $data);
    }

    public function generateParentCode($length = 10){
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
  
    public function registerUser()
    {
        helper(['form']);
        $rules = [
            'name'          => 'required|min_length[2]|max_length[255]',
            'user_id'       => 'required|min_length[2]|max_length[255]|is_unique[ews_user.user_id]',
            'email'         => 'required|min_length[4]|max_length[255]|valid_email|is_unique[ews_user.email]',
            'age'           => 'required|integer|min_length[1]|max_length[300]',
            'password'      => 'required|min_length[4]|max_length[50]',
            'password_confirmation'  => 'matches[password]',
            'agree_terms_and_conditions' => 'required',
        ];

        if($this->validate($rules)){
            $userModel = new User();
            $user_id = $this->request->getVar('user_id');

            //Check User ID Exists
            $sqlresult = $userModel->where('user_id', $user_id)->first();

            if($sqlresult == NULL){

                $data = [
                    'name'     => $this->request->getVar('name'),
                    'user_id'     => $this->request->getVar('user_id'),
                    'age'    => $this->request->getVar('age'),
                    'email'    => $this->request->getVar('email'),
                    'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                    'parent_code' => "PRT-".$this->generateParentCode()
                ];

                try{
                    $userModel->insert($data);
                }catch(\Exception $e) {
                    $data['notmatch'] = 'Database error. Please try again';
                    echo view('/user/register', $data);
                }
                //reserve for send e-mail to user

                $data['register_success'] = "You have successfully registered as user! You can log in to our system";
                echo view('/user/register', $data);
            }else{
                $data['notmatch'] = 'User ID already exists! Please enter a new one.';
                echo view('/user/register', $data);
            }
        }else{
            $data['validation'] = $this->validator;
            echo view('/user/register', $data);
        }
          
    }

    public function registerParent()
    {
        helper(['form']);
        $rules = [
            'name'          => 'required|min_length[2]|max_length[255]',
            'parent_code'   => 'required|min_length[2]|max_length[255]',
            'user_id'       => 'required|min_length[2]|max_length[255]|is_unique[ews_parent.parent_id]',
            'email'         => 'required|min_length[4]|max_length[255]|valid_email|is_unique[ews_parent.email]',
            'password'      => 'required|min_length[4]|max_length[50]',
            'password_confirmation'  => 'matches[password]',
            'agree_terms_and_conditions' => 'required',
        ];

        if($this->validate($rules)){
            $parentModel = new UserParent();
            $parent_code = $this->request->getVar('parent_code');
            $parent_id = $this->request->getVar('user_id');

            //Check User ID Exists
            $sqlresult = $parentModel->where('parent_id', $parent_id)->first();

            if($sqlresult == NULL){

                //Match parent_code with user
                $userModel = new User();
                $match = $userModel->where('parent_code',$parent_code)->first();
        
                if($match == TRUE){
                    //now add the parent to the system
                    $data = [
                        'name'     => $this->request->getVar('name'),
                        'parent_id'     => $this->request->getVar('user_id'),
                        'user_id'   => $match['user_id'],
                        'email'    => $this->request->getVar('email'),
                        'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
                    ];

                    try{
                        $parentModel->insert($data);
                    }catch(\Exception $e) {
                        $data['notmatch'] = 'Database error. Please try again';
                        echo view('/parent/register', $data);
                    }
                    //reserve for send e-mail to user

                    $data['register_success'] = "You have successfully registered as parent! You can log in to our system";
                    echo view('/parent/register', $data);
        
                }else{
                    $data['notmatch'] = "Invalid parent code. Make sure you entered the parent code from the registered user. Please contact system administrator.";
                    echo view('/parent/register', $data);
                }
            }else{
                $data['notmatch'] = 'Parent ID already exists! Please enter a new one.';
                echo view('/parent/register', $data);
            }
            
        }else{
            $data['validation'] = $this->validator;
            echo view('/parent/register', $data);
        }
          
    }

    public function registerMerchant()
    {
        helper(['form']);
        $rules = [
            'name'          => 'required|min_length[2]|max_length[255]',
            'merchant_id'   => 'required|min_length[2]|max_length[255]|is_unique[ews_merchant.merchant_id]',
            'type'          => 'required|min_length[2]|max_length[255]',
            'email'         => 'required|min_length[4]|max_length[255]|valid_email|is_unique[ews_merchant.email]',
            'password'      => 'required|min_length[4]|max_length[50]',
            'password_confirmation'  => 'matches[password]',
            'agree_terms_and_conditions' => 'required',
        ];

        if($this->validate($rules)){
            $merchantModel = new Merchant();
            $merchant_id = $this->request->getVar('merchant_id');

            //Check User ID Exists
            $sqlresult = $merchantModel->where('merchant_id', $merchant_id)->first();

            if($sqlresult == NULL){

                $data = [
                    'name'     => $this->request->getVar('name'),
                    'merchant_id'     => $this->request->getVar('merchant_id'),
                    'type'     => $this->request->getVar('type'),
                    'email'    => $this->request->getVar('email'),
                    'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
                ];

                try{
                    $merchantModel->insert($data);
                }catch(\Exception $e) {
                    $data['notmatch'] = 'Database error. Please try again';
                    echo view('/merchant/register', $data);
                }
                //reserve for send e-mail to user

                $data['register_success'] = "You have successfully registered as merchant! You can log in to our system";
                echo view('/merchant/register', $data);
            }else{
                $data['notmatch'] = 'Merchant ID already exists! Please enter a new one.';
                echo view('/merchant/register', $data);
            }
        }else{
            $data['validation'] = $this->validator;
            echo view('/merchant/register', $data);
        }
          
    }

}