<?php

namespace App\Controllers;
use CodeIgniter\Controller;

class ParentController extends Controller
{
    public function index()
    {
        $session = session();
        $data = ['navactive' => 'index', 'pagetitle' => 'Dashboard'];

        echo view('templates/header', $data);
        echo view('sidebars/parent', $data);
        echo view('navbars/parent', $data);
        echo view('parent/index');
        echo view('templates/footer');
        
    }

    public function logout()
    {
        $session = session();
        session_destroy();
        return redirect()->to('..');
        
    }  

    public function transactionIndex()
    {
        $session = session();
        $data = ['navactive' => 'transactions', 'pagetitle' => 'Transactions'];

        echo view('templates/header', $data);
        echo view('sidebars/parent', $data);
        echo view('navbars/parent', $data);

        echo view('parent/transactions');
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
            echo view('sidebars/parent', $data);
            echo view('navbars/parent', $data);

            echo view('parent/view_transaction');
            echo view('templates/footer');
        }else{
            return $this->response->redirect(site_url('parent/transactions'));
        }
        
    }

    public function viewTransactionByPocket($pocket_id = NULL)
    {
        $pocketModel = new Pocket();
        $sqlresult = $pocketModel->where('pocket_id', $pocket_id)->first();
        if($sqlresult == TRUE){
            $session = session();
            $data = ['navactive' => 'transactions', 'pagetitle' => 'Transactions', 'backbutton' => "transactions"];

            echo view('templates/header', $data);
            echo view('sidebars/parent', $data);
            echo view('navbars/parent', $data);

            echo view('parent/view_transaction_by_pocket');
            echo view('templates/footer');
        }else{
            return $this->response->redirect(site_url('parent/transactions'));
        }
        
    }

    public function topUpIndex()
    {
        $session = session();
        $data = ['navactive' => 'topup', 'pagetitle' => 'Top Up'];

        echo view('templates/header', $data);
        echo view('sidebars/parent', $data);
        echo view('navbars/parent', $data);

        echo view('parent/topup');
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
}
