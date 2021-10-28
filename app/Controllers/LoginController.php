<?php 

namespace App\Controllers;  
use CodeIgniter\Controller;

use App\Models\User;
use App\Models\UserParent;
use App\Models\SuperAdmin;
use App\Models\Merchant;
  
class LoginController extends Controller
{
    public function userIndex()
    {
        helper(['form']);
        $data = [];
        echo view('user/login', $data);
    }

    public function superAdminIndex()
    {
        helper(['form']);
        $data = [];
        echo view('superadmin/login', $data);
    }

    public function parentIndex()
    {
        helper(['form']);
        $data = [];
        echo view('parent/login', $data);
    }

    public function merchantIndex()
    {
        helper(['form']);
        $data = [];
        echo view('merchant/login', $data);
    }
  
    public function loginUser()
    {
        $session = session();

        $userModel = new User();

        $user_id  = $this->request->getVar('user_id');
        $password = $this->request->getVar('password');
        
        $data = $userModel->where('user_id', $user_id)->first();
        
        if($data){
            $pass = $data['password'];
            $authenticatePassword = password_verify($password, $pass);
            if($authenticatePassword){
                if($user_id == "super_admin"){
                    $ses_data = [
                        'user_id' => $data['user_id'],
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'ewsUserRole' => FALSE,
                        'ewsAdminRole' => TRUE,
                        'ewsParentRole' => FALSE,
                        'ewsMerchantRole' => FALSE,
                        'ewsLoggedIn' => TRUE
                    ];
                    $session->set($ses_data);
                    return redirect()->to('superadmin/index');
                }else{
                    $ses_data = [
                        'user_id' => $data['user_id'],
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'ewsUserRole' => TRUE,
                        'ewsAdminRole' => FALSE,
                        'ewsParentRole' => FALSE,
                        'ewsMerchantRole' => FALSE,
                        'ewsLoggedIn' => TRUE
                    ];
                    $session->set($ses_data);
                    return redirect()->to('user/index');
                }
                
            
            }else{
                $session->setFlashdata('msg', 'Password is incorrect.');
                return redirect()->to('user/login');
            }

        }else{
            $session->setFlashdata('msg', 'User ID does not exist.');
            return redirect()->to('user/login');
        }
          
    }

    public function loginSuperAdmin()
    {
        $session = session();

        $user_id  = $this->request->getVar('user_id');
        $password = $this->request->getVar('password');

        $userModel = new SuperAdmin();

        if($user_id == "super_admin"){
            $data = $userModel->where('user_id', $user_id)->first();
        
            if($data){
                $pass = $data['password'];
                $authenticatePassword = password_verify($password, $pass);
                if($authenticatePassword){
                    $ses_data = [
                        'user_id' => $data['user_id'],
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'ewsUserRole' => FALSE,
                        'ewsAdminRole' => TRUE,
                        'ewsParentRole' => FALSE,
                        'ewsMerchantRole' => FALSE,
                        'ewsLoggedIn' => TRUE
                    ];

                    $session->set($ses_data);
                    return redirect()->to('superadmin/index');
                
                }else{
                    $session->setFlashdata('msg', 'Password is incorrect.');
                    return redirect()->to('superadmin/login');
                }

            }else{
                $session->setFlashdata('msg', 'Super Admin ID does not exist.');
                return redirect()->to('superadmin/login');
            }
        }else{
                $session->setFlashdata('msg', "You don't have permission to access this page");
                return redirect()->to('superadmin/login');
        }
    
    }

    public function loginParent()
    {
        $session = session();

        $userModel = new UserParent();

        $parent_id  = $this->request->getVar('parent_id');
        $password = $this->request->getVar('password');
        
        $data = $userModel->where('parent_id', $parent_id)->first();
        
        if($data){
            $pass = $data['password'];
            $authenticatePassword = password_verify($password, $pass);
            if($authenticatePassword){
                $ses_data = [
                    'parent_id' => $data['parent_id'],
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'ewsUserRole' => FALSE,
                    'ewsAdminRole' => FALSE,
                    'ewsParentRole' => TRUE,
                    'ewsMerchantRole' => FALSE,
                    'ewsLoggedIn' => TRUE
                ];

                $session->set($ses_data);
                return redirect()->to('parent/index');
            
            }else{
                $session->setFlashdata('msg', 'Password is incorrect.');
                return redirect()->to('parent/login');
            }

        }else{
            $session->setFlashdata('msg', 'Parent ID does not exist.');
            return redirect()->to('parent/login');
        }
          
    }
  
    public function loginMerchant()
    {
        $session = session();

        $userModel = new Merchant();

        $merchant_id  = $this->request->getVar('merchant_id');
        $password = $this->request->getVar('password');
        
        $data = $userModel->where('merchant_id', $merchant_id)->first();
        
        if($data){
            $pass = $data['password'];
            $authenticatePassword = password_verify($password, $pass);
            if($authenticatePassword){
                $ses_data = [
                    'merchant_id' => $data['merchant_id'],
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'ewsUserRole' => FALSE,
                    'ewsAdminRole' => FALSE,
                    'ewsParentRole' => FALSE,
                    'ewsMerchantRole' => TRUE,
                    'ewsLoggedIn' => TRUE
                ];

                $session->set($ses_data);
                return redirect()->to('merchant/index');
            
            }else{
                $session->setFlashdata('msg', 'Password is incorrect.');
                return redirect()->to('merchant/login');
            }

        }else{
            $session->setFlashdata('msg', 'Merchant ID does not exist.');
            return redirect()->to('merchant/login');
        }
          
    }
}