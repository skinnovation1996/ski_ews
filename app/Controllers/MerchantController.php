<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\Merchant;
use App\Models\Transaction;
use App\Models\MerchantTransaction;

class MerchantController extends Controller
{
    public function index()
    {
        $session = session();
        $data = ['navactive' => 'index', 'pagetitle' => 'Dashboard', 'totalearnings' => $this->calculateTotalEarnings()];

        echo view('templates/header', $data);
        echo view('sidebars/merchant', $data);
        echo view('navbars/merchant', $data);
        echo view('merchant/index');
        echo view('templates/footer');
        
    }

    public function logout()
    {
        $session = session();
        session_destroy();
        return redirect()->to('..');
        
    }  

    public function displayQR()
    {
        $session = session();
        $data = ['navactive' => 'displayqr', 'pagetitle' => 'Display QR', 'totalearnings' => $this->calculateTotalEarnings()];

        echo view('templates/header', $data);
        echo view('sidebars/merchant', $data);
        echo view('navbars/merchant', $data);

        echo view('merchant/displayqr');
        echo view('templates/footer');
    }

    public function transactionsIndex()
    {
        $transactionModel = new MerchantTransaction();
        $my_merchant_id = $_SESSION['user_id'];
        $sqlresult = $transactionModel->where('merchant_id',$my_merchant_id)->orderBy('merch_trans_id','DESC')->findAll();
        $session = session();
        $data = ['navactive' => 'transactions', 'pagetitle' => 'Transactions', 'result' => $sqlresult, 'totalearnings' => $this->calculateTotalEarnings()];

        echo view('templates/header', $data);
        echo view('sidebars/merchant', $data);
        echo view('navbars/merchant', $data);

        echo view('merchant/transactions');
        echo view('templates/footer');
    }

    public function viewTransactionById($transaction_id = NULL)
    {
        $transactionModel = new MerchantTransaction();
        $my_merchant_id = $_SESSION['user_id'];
        $sqlresult = $transactionModel->where('merchant_id',$my_merchant_id)->where('transaction_id', $transaction_id)->first();
        if($sqlresult == TRUE){
            $session = session();
            $data = ['navactive' => 'transactions', 'pagetitle' => 'Transactions', 'backbutton' => "transactions", 'totalearnings' => $this->calculateTotalEarnings()];

            echo view('templates/header', $data);
            echo view('sidebars/merchant', $data);
            echo view('navbars/merchant', $data);

            echo view('merchant/view_transaction');
            echo view('templates/footer');
        }else{
            return $this->response->redirect(site_url('merchant/transactions'));
        }
        
    }

    public function viewTotalEarnings()
    {
        $session = session();
        $data = ['navactive' => 'earnings', 'pagetitle' => 'Total Earnings', 'earnings' => $this->calculateTotalEarnings()];

        echo view('templates/header', $data);
        echo view('sidebars/merchant', $data);
        echo view('navbars/merchant', $data);

        echo view('merchant/totalearning');
        echo view('templates/footer');
    }

    public function setUpBankIndex()
    {
        $session = session();
        $data = ['navactive' => 'setupbank', 'pagetitle' => 'Set Up/Link Bank', 'totalearnings' => $this->calculateTotalEarnings()];

        echo view('templates/header', $data);
        echo view('sidebars/merchant', $data);
        echo view('navbars/merchant', $data);

        echo view('merchant/setupbank');
        echo view('templates/footer');
    }

    public function addBankDetailsIndex()
    {
        $session = session();
        $data = ['navactive' => 'setupbank', 'pagetitle' => 'Set Up/Link Bank', 'totalearnings' => $this->calculateTotalEarnings()];

        echo view('templates/header', $data);
        echo view('sidebars/merchant', $data);
        echo view('navbars/merchant', $data);

        echo view('merchant/add_bank_details');
        echo view('templates/footer');
    }

    public function updateBankDetailsAction()
    {
        //coming soon
    }

    public function editBankDetailsIndex()
    {
        $session = session();
        $data = ['navactive' => 'setupbank', 'pagetitle' => 'Set Up/Link Bank', 'totalearnings' => $this->calculateTotalEarnings()];

        echo view('templates/header', $data);
        echo view('sidebars/merchant', $data);
        echo view('navbars/merchant', $data);

        echo view('merchant/edit_bank_details');
        echo view('templates/footer');
    }


    public function changePassword()
    {
        $session = session();
        $data = ['navactive' => 'index', 'pagetitle' => 'Change Password', 'totalearnings' => $this->calculateTotalEarnings()];

        echo view('templates/header', $data);
        echo view('sidebars/merchant', $data);
        echo view('navbars/merchant', $data);

        echo view('merchant/changepass');
        echo view('templates/footer');
    }

    public function changePasswordAction()
    {
        $merchantModel = new Merchant();
        $merchant_id = $this->request->getVar('merchant_id');

        $old_password = $this->request->getVar('old_password');

        $checkOldPass = $merchantModel->where('merchant_id', $merchant_id)->first();
        
        if($checkOldPass){
            $pass = $checkOldPass['password'];
            $authenticatePassword = password_verify($old_password, $pass);
            if($authenticatePassword){
                $new_password = $this->request->getVar('new_password');
                $confirm_password = $this->request->getVar('confirm_password');

                if($new_password == $confirm_password){
                    $data = [
                        'password' => password_hash($this->request->getVar('new_password'), PASSWORD_DEFAULT),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                    try{
                        $merchantModel->update($merchant_id, $data);
                    }catch(\Exception $e) {
                        $_SESSION['message'] = 'Database error. Please try again';
                        $_SESSION['alertType'] = 'alert-danger';
                        $_SESSION['alertIcon'] = 'nc-simple-remove';
                        $_SESSION['alertStart'] = 'Error!';
                        return $this->response->redirect(site_url('merchant/changepass'));
                    }
                    $_SESSION['message'] = 'You have successfully updated your password.';
                    $_SESSION['alertType'] = 'alert-success';
                    $_SESSION['alertIcon'] = 'nc-check-2';
                    $_SESSION['alertStart'] = 'Success!';
                    return $this->response->redirect(site_url('merchant/changepass'));

                }else{
                    $_SESSION['message'] = 'New and confirm password do not match.';
                    $_SESSION['alertType'] = 'alert-danger';
                    $_SESSION['alertIcon'] = 'nc-simple-remove';
                    $_SESSION['alertStart'] = 'Error!';
                    return $this->response->redirect(site_url('merchant/changepass'));
                }
            }else{
                $_SESSION['message'] = 'Invalid old password.';
                $_SESSION['alertType'] = 'alert-danger';
                $_SESSION['alertIcon'] = 'nc-simple-remove';
                $_SESSION['alertStart'] = 'Error!';
                return $this->response->redirect(site_url('merchant/changepass'));
            }
        }else{
            return $this->response->redirect(site_url('merchant/changepass'));
        }
    }

    public function calculateTotalEarnings()
    {
        $transactionModel = new MerchantTransaction();
        $my_merchant_id = $_SESSION['user_id'];
        $sqlresult = $transactionModel->select("transaction_amt")->where("merchant_id", $my_merchant_id);
        $totalEarnings = 0.00;
        foreach($sqlresult as $trst){
            $totalEarnings = $totalEarnings + $trst['transaction_amt'];
        }
        return $totalEarnings;
        
    }
}
