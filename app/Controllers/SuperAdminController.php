<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\SuperAdmin;
use App\Models\SuperAdminDB;
use App\Models\User;
use App\Models\UserParent;
use App\Models\Merchant;
use App\Models\Transaction;

class SuperAdminController extends Controller
{
    public function __construct()
    {
        $session = session();
        $sqldb = new SuperAdminDB();
        date_default_timezone_set('Asia/Kuala_Lumpur');
    }

    public function index()
    {
        $data = ['navactive' => 'index', 'pagetitle' => 'Dashboard', 
        'numofusers' => $this->countNumOfUsers(), 'numofmerchants' => $this->countNumOfMerchants(), 'numoftransactions' => $this->countNumOfUserTransactrions()];

        echo view('templates/header', $data);
        echo view('sidebars/superadmin', $data);
        echo view('navbars/superadmin', $data);

        echo view('superadmin/index');
        echo view('templates/footer');
        
    }

    public function logout()
    {
        session_destroy();
        return redirect()->to('..'); 
    }

    public function userMgmtIndex()
    {
        $userModel = new User();
        
        $data = ['navactive' => 'usermgmt', 'pagetitle' => 'User Management', 'result' => $userModel->orderBy('user_id','DESC')->findAll()];

        echo view('templates/header', $data);
        echo view('sidebars/superadmin', $data);
        echo view('navbars/superadmin', $data);

        echo view('superadmin/usermgmt');
        echo view('templates/footer');
    }

    public function newUser()
    {
        $data = ['navactive' => 'usermgmt', 'pagetitle' => 'Add New User', 'backbutton' => "usermgmt"];

        echo view('templates/header', $data);
        echo view('sidebars/superadmin', $data);
        echo view('navbars/superadmin', $data);

        echo view('superadmin/new_user');
        echo view('templates/footer');
    }

    public function newUserAction()
    {

        $userModel = new User();

        $user_id = $this->request->getVar('user_id');

        //Check exists
        $sqlresult = $userModel->where('user_id', $user_id)->first();

        if($sqlresult == NULL){

            $data = [
                'user_id' => $user_id,
                'name' => $this->request->getVar('name'),
                'email'  => $this->request->getVar('email'),
                'age'  => $this->request->getVar('age'),
                'password'  => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                'parent_code' => $this->request->getVar('parent_code'),
            ];

            try{
                $userModel->insert($data);
            }catch(\Exception $e) {
                $_SESSION['message'] = 'Database error. Please try again';
                $_SESSION['alertType'] = 'alert-danger';
                $_SESSION['alertIcon'] = 'nc-simple-remove';
                $_SESSION['alertStart'] = 'Error!';
                return $this->response->redirect(site_url('superadmin/new_user'));
            }
            $_SESSION['message'] = 'You have successfully added the user to the system.';
            $_SESSION['alertType'] = 'alert-success';
            $_SESSION['alertIcon'] = 'nc-check-2';
            $_SESSION['alertStart'] = 'Success!';
            return $this->response->redirect(site_url('superadmin/usermgmt'));
        
        }else{
            $_SESSION['message'] = 'This User ID already exists! Please enter a different user ID!';
            $_SESSION['alertType'] = 'alert-danger';
            $_SESSION['alertIcon'] = 'nc-simple-remove';
            $_SESSION['alertStart'] = 'Error!';
            return $this->response->redirect(site_url('superadmin/new_user'));
        }
    }

    public function editUser($user_id = null)
    {
        $userModel = new User();
        $sqlresult = $userModel->where('user_id', $user_id)->first();

        if($sqlresult == TRUE){
            
            $data = ['navactive' => 'usermgmt', 'pagetitle' => 'Edit User', 'user' => $sqlresult, 'backbutton' => "usermgmt"];

            echo view('templates/header', $data);
            echo view('sidebars/superadmin', $data);
            echo view('navbars/superadmin', $data);

            echo view('superadmin/edit_user');
            echo view('templates/footer');
        }else{
            return $this->response->redirect(site_url('superadmin/usermgmt'));
        }
    }

    public function editUserAction()
    {
        $userModel = new User();
        $user_id = $this->request->getVar('user_id');
        $data = [
            'name' => $this->request->getVar('name'),
            'email'  => $this->request->getVar('email'),
            'age'  => $this->request->getVar('age'),
            'parent_code' => $this->request->getVar('parent_code'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        try{
            $userModel->update($user_id, $data);
        }catch(\Exception $e) {
            $_SESSION['message'] = 'Database error. Please try again';
            $_SESSION['alertType'] = 'alert-danger';
            $_SESSION['alertIcon'] = 'nc-simple-remove';
            $_SESSION['alertStart'] = 'Error!';
            return $this->response->redirect(site_url('superadmin/usermgmt'));
        }
        $_SESSION['message'] = 'You have successfully edited the user.';
        $_SESSION['alertType'] = 'alert-success';
        $_SESSION['alertIcon'] = 'nc-check-2';
        $_SESSION['alertStart'] = 'Success!';
        return $this->response->redirect(site_url('superadmin/usermgmt'));
    }

    public function deleteUser($user_id = null)
    {
        $userModel = new User();
        $sqlresult = $userModel->where('user_id', $user_id)->first();

        if($sqlresult != NULL){
            
            $data = ['navactive' => 'usermgmt', 'pagetitle' => 'Delete User', 'user' => $sqlresult, 'backbutton' => "usermgmt"];

            echo view('templates/header', $data);
            echo view('sidebars/superadmin', $data);
            echo view('navbars/superadmin', $data);

            echo view('superadmin/delete_user');
            echo view('templates/footer');
        }else{
            return $this->response->redirect(site_url('superadmin/usermgmt'));
        }
    }

    public function deleteUserAction($user_id)
    {
        $userModel = new User();
        $sqlresult = $userModel->where('user_id', $user_id)->delete($user_id);
        $_SESSION['message'] = 'You have successfully removed the user from the system.';
        $_SESSION['alertType'] = 'alert-success';
        $_SESSION['alertIcon'] = 'nc-check-2';
        $_SESSION['alertStart'] = 'Success!';
        return $this->response->redirect(site_url('superadmin/usermgmt'));
    }

    public function merchantMgmtIndex()
    {
        $merchantModel = new Merchant();

        $data = ['navactive' => 'merchantmgmt', 'pagetitle' => 'Merchant Management', 'result' => $merchantModel->orderBy('merchant_id','ASC')->findAll()];

        echo view('templates/header', $data);
        echo view('sidebars/superadmin', $data);
        echo view('navbars/superadmin', $data);

        echo view('superadmin/merchantmgmt');
        echo view('templates/footer');
    }

    public function newMerchant()
    {
        $data = ['navactive' => 'merchantmgmt', 'pagetitle' => 'Add New Merchant', 'backbutton' => "merchantmgmt"];

        echo view('templates/header', $data);
        echo view('sidebars/superadmin', $data);
        echo view('navbars/superadmin', $data);

        echo view('superadmin/new_merchant');
        echo view('templates/footer');
    }

    public function newMerchantAction()
    {
        $merchantModel = new Merchant();

        $merchant_id = $this->request->getVar('merchant_id');

        //Check exists
        $sqlresult = $merchantModel->where('merchant_id', $merchant_id)->first();

        if($sqlresult == NULL){

            $data = [
                'merchant_id' => $this->request->getVar('merchant_id'),
                'name' => $this->request->getVar('name'),
                'type'  => $this->request->getVar('type'),
                'account_num' => $this->request->getVar('account_num'),
                'email'  => $this->request->getVar('email'),
                'password'  => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            ];

            try{
                $merchantModel->insert($data);
            }catch(\Exception $e) {
                $_SESSION['message'] = 'Database error. Please try again';
                $_SESSION['alertType'] = 'alert-danger';
                $_SESSION['alertIcon'] = 'nc-simple-remove';
                $_SESSION['alertStart'] = 'Error!';
                return $this->response->redirect(site_url('superadmin/new_merchant'));
            }
            $_SESSION['message'] = 'You have successfully added the merchant to the system.';
            $_SESSION['alertType'] = 'alert-success';
            $_SESSION['alertIcon'] = 'nc-check-2';
            $_SESSION['alertStart'] = 'Success!';
            return $this->response->redirect(site_url('superadmin/merchantmgmt'));
        }else{
            $_SESSION['message'] = 'This Merchant ID already exists! Please enter a different merchant ID!';
            $_SESSION['alertType'] = 'alert-danger';
            $_SESSION['alertIcon'] = 'nc-simple-remove';
            $_SESSION['alertStart'] = 'Error!';
            return $this->response->redirect(site_url('superadmin/new_merchant'));
        }
    }

    public function editMerchant($merchant_id = NULL)
    {
        $merchantModel = new Merchant();
        $sqlresult = $merchantModel->where('merchant_id', $merchant_id)->first();

        if($sqlresult == TRUE){
            
            $data = ['navactive' => 'merchantmgmt', 'pagetitle' => 'Edit Merchant', 'merchant' => $sqlresult, 'backbutton' => "merchantmgmt"];

            echo view('templates/header', $data);
            echo view('sidebars/superadmin', $data);
            echo view('navbars/superadmin', $data);

            echo view('superadmin/edit_merchant');
            echo view('templates/footer');
        }else{
            return $this->response->redirect(site_url('superadmin/merchantmgmt'));
        }
    }

    public function editMerchantAction()
    {
        $merchantModel = new Merchant();
        $merchant_id = $this->request->getVar('merchant_id');

        $data = [
            'name' => $this->request->getVar('name'),
            'email'  => $this->request->getVar('email'),
            'type'  => $this->request->getVar('type'),
            'account_num' => $this->request->getVar('account_num'),
        ];
        try{
            $merchantModel->update($merchant_id, $data);
        }catch(\Exception $e) {
            $_SESSION['message'] = 'Database error. Please try again';
            $_SESSION['alertType'] = 'alert-danger';
            $_SESSION['alertIcon'] = 'nc-simple-remove';
            $_SESSION['alertStart'] = 'Error!';
            return $this->response->redirect(site_url('superadmin/merchantmgmt'));
        }
        $_SESSION['message'] = 'You have successfully edited the merchant';
        $_SESSION['alertType'] = 'alert-success';
        $_SESSION['alertIcon'] = 'nc-check-2';
        $_SESSION['alertStart'] = 'Success!';
        return $this->response->redirect(site_url('superadmin/merchantmgmt'));
    }

    public function deleteMerchant($merchant_id = NULL)
    {
        $merchantModel = new Merchant();
        $sqlresult = $merchantModel->where('merchant_id', $merchant_id)->first();

        if($sqlresult != NULL){
            
            $data = ['navactive' => 'merchantmgmt', 'pagetitle' => 'Delete Merchant', 'merchant' => $sqlresult, 'backbutton' => "merchantmgmt"];

            echo view('templates/header', $data);
            echo view('sidebars/superadmin', $data);
            echo view('navbars/superadmin', $data);

            echo view('superadmin/delete_merchant');
            echo view('templates/footer');
        }else{
            return $this->response->redirect(site_url('superadmin/merchantmgmt'));
        }
    }

    public function deleteMerchantAction($merchant_id)
    {
        $merchantModel = new Merchant();
        $sqlresult = $merchantModel->where('merchant_id', $merchant_id)->delete($merchant_id);
        $_SESSION['message'] = 'You have successfully removed the merchant from the system.';
        $_SESSION['alertType'] = 'alert-success';
        $_SESSION['alertIcon'] = 'nc-check-2';
        $_SESSION['alertStart'] = 'Success!';
        return $this->response->redirect(site_url('superadmin/merchantmgmt'));
    }

    public function securityMgmtIndex()
    {
        $data = ['navactive' => 'securitymgmt', 'pagetitle' => 'Security Management'];

        echo view('templates/header', $data);
        echo view('sidebars/superadmin', $data);
        echo view('navbars/superadmin', $data);

        echo view('superadmin/securitymgmt');
        echo view('templates/footer');
    }

    public function analyticsIndex()
    {
        $data = ['navactive' => 'analytics', 'pagetitle' => 'Analytics'];

        echo view('templates/header', $data);
        echo view('sidebars/superadmin', $data);
        echo view('navbars/superadmin', $data);

        echo view('superadmin/analytics');
        echo view('templates/footer');
    }


    public function countNumOfUsers(){
        $userModel = new User();
        $numOfUsers = $userModel->countAll();
        return $numOfUsers;
    }

    public function countNumOfMerchants(){
        $merchantModel = new Merchant();
        $numOfMerchants = $merchantModel->countAll();
        return $numOfMerchants;
    }

    public function countNumOfUserTransactrions(){
        $transactionModel = new Transaction();
        $numOfUserTransactions = $transactionModel->where("created_at >= DATE(NOW()) - INTERVAL 30 DAY")->countAll();
        return $numOfUserTransactions;
    }
}
