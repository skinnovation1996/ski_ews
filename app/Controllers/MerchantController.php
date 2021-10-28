<?php

namespace App\Controllers;
use CodeIgniter\Controller;
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
        $data = ['navactive' => 'totalearnings', 'pagetitle' => 'Total Earnings', 'totalearnings' => $this->calculateTotalEarnings()];

        echo view('templates/header', $data);
        echo view('sidebars/merchant', $data);
        echo view('navbars/merchant', $data);

        echo view('merchant/total_earnings');
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

    public function addBankDetailsAction()
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

    public function editBankDetailsAction()
    {
        //coming soon
    }

    public function profileIndex()
    {
        $session = session();
        $data = ['navactive' => 'profile', 'pagetitle' => 'User Profile', 'totalearnings' => $this->calculateTotalEarnings()];

        echo view('templates/header', $data);
        echo view('sidebars/merchant', $data);
        echo view('navbars/merchant', $data);

        echo view('merchant/profile');
        echo view('templates/footer');
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
