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

            $data = [
                'name'     => $this->request->getVar('name'),
                'user_id'     => $this->request->getVar('user_id'),
                'age'    => $this->request->getVar('age'),
                'email'    => $this->request->getVar('email'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
            ];

            $userModel->save($data);

            //reserve for send e-mail to user

            $data['register_success'] = "You have successfully registered as user! You can log in to our system";
            return redirect()->to('/user/login');
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
            'parent_code'   => 'required|min_length[2]|max_length[255]|is_unique[ews_parent.parent_id]',
            'user_id'       => 'required|min_length[2]|max_length[255]|',
            'email'         => 'required|min_length[4]|max_length[255]|valid_email|is_unique[ews_parent.email]',
            'password'      => 'required|min_length[4]|max_length[50]',
            'password_confirmation'  => 'matches[password]',
            'agree_terms_and_conditions' => 'required',
        ];

        if($this->validate($rules)){
            $parentModel = new UserParent();

            $data = [
                'name'     => $this->request->getVar('name'),
                'parent_code'     => $this->request->getVar('parent_code'),
                'user_id'     => $this->request->getVar('user_id'),
                'email'    => $this->request->getVar('email'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
            ];

            $parentModel->save($data);

            //reserve for send e-mail to user

            $data['register_success'] = "You have successfully registered as parent! You can log in to our system";
            return redirect()->to('/parent/login');
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
            'type'          => 'required|min_length[2]|max_length[255]|',
            'email'         => 'required|min_length[4]|max_length[255]|valid_email|is_unique[ews_merchant.email]',
            'password'      => 'required|min_length[4]|max_length[50]',
            'password_confirmation'  => 'matches[password]',
            'agree_terms_and_conditions' => 'required',
        ];

        if($this->validate($rules)){
            $merchantModel = new Merchant();

            $data = [
                'name'     => $this->request->getVar('name'),
                'merchant_id'     => $this->request->getVar('merchant_id'),
                'type'     => $this->request->getVar('type'),
                'email'    => $this->request->getVar('email'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
            ];

            $merchantModel->save($data);

            //reserve for send e-mail to user

            $data['register_success'] = "You have successfully registered as merchant! You can log in to our system";
            return redirect()->to('/merchant/login');
        }else{
            $data['validation'] = $this->validator;
            echo view('/merchant/register', $data);
        }
          
    }

}