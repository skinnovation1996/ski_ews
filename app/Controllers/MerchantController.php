<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\MerchantTransaction;

class MerchantController extends Controller
{
    public function index()
    {
        $session = session();
        $data = ['navactive' => 'index', 'pagetitle' => 'Dashboard'];

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
        $data = ['navactive' => 'displayqr', 'pagetitle' => 'Display QR'];

        echo view('templates/header', $data);
        echo view('sidebars/merchant', $data);
        echo view('navbars/merchant', $data);

        echo view('merchant/displayqr');
        echo view('templates/footer');
    }

    public function transactionsIndex()
    {
        $session = session();
        $data = ['navactive' => 'transactions', 'pagetitle' => 'Transactions'];

        echo view('templates/header', $data);
        echo view('sidebars/merchant', $data);
        echo view('navbars/merchant', $data);

        echo view('merchant/transactions');
        echo view('templates/footer');
    }

    public function viewTransactionById($transaction_id = NULL)
    {
        $transactionModel = new Transaction();
        $sqlresult = $transactionModel->where('transaction_id', $transaction_id)->first();
        if($sqlresult == TRUE){
            $session = session();
            $data = ['navactive' => 'transactions', 'pagetitle' => 'Transactions', 'backbutton' => "transactions"];

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
        $data = ['navactive' => 'totalearnings', 'pagetitle' => 'Total Earnings'];

        echo view('templates/header', $data);
        echo view('sidebars/merchant', $data);
        echo view('navbars/merchant', $data);

        echo view('merchant/total_earnings');
        echo view('templates/footer');
    }

    public function setUpBankIndex()
    {
        $session = session();
        $data = ['navactive' => 'setupbank', 'pagetitle' => 'Set Up/Link Bank'];

        echo view('templates/header', $data);
        echo view('sidebars/merchant', $data);
        echo view('navbars/merchant', $data);

        echo view('merchant/setupbank');
        echo view('templates/footer');
    }

    public function addBankDetailsIndex()
    {
        $session = session();
        $data = ['navactive' => 'setupbank', 'pagetitle' => 'Set Up/Link Bank'];

        echo view('templates/header', $data);
        echo view('sidebars/merchant', $data);
        echo view('navbars/merchant', $data);

        echo view('merchant/add_bank_details');
        echo view('templates/footer');
    }

    public function addBankDetails()
    {
        $session = session();
        $data = ['navactive' => 'setupbank', 'pagetitle' => 'Set Up/Link Bank'];

        echo view('templates/header', $data);
        echo view('sidebars/merchant', $data);
        echo view('navbars/merchant', $data);

        echo view('merchant/add_bank_details');
        echo view('templates/footer');
    }

    public function profileIndex()
    {
        $session = session();
        $data = ['navactive' => 'profile', 'pagetitle' => 'User Profile'];

        echo view('templates/header', $data);
        echo view('sidebars/merchant', $data);
        echo view('navbars/merchant', $data);

        echo view('merchant/profile');
        echo view('templates/footer');
    }
}
