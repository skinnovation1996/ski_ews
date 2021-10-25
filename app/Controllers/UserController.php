<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $session = session();
        $data = ['navactive' => 'index', 'pagetitle' => 'Dashboard'];

        echo view('templates/header', $data);
        echo view('sidebars/user', $data);
        echo view('navbars/user', $data);
        echo view('user/index');
        echo view('templates/footer');
        
    }

    public function logout()
    {
        $session = session();
        session_destroy();
        return redirect()->to('..');
        
    }  

    public function scanQRIndex()
    {
        $session = session();
        $data = ['navactive' => 'scanqr', 'pagetitle' => 'Scan QR'];

        echo view('templates/header', $data);
        echo view('sidebars/user', $data);
        echo view('navbars/user', $data);

        echo view('user/scanqr');
        echo view('templates/footer');
    }

    public function scanQRPayment()
    {
        
    }

    public function topUpIndex()
    {
        $session = session();
        $data = ['navactive' => 'topup', 'pagetitle' => 'Top Up'];

        echo view('templates/header', $data);
        echo view('sidebars/user', $data);
        echo view('navbars/user', $data);

        echo view('user/topup');
        echo view('templates/footer');
    }

    public function transactionIndex()
    {
        $session = session();
        $data = ['navactive' => 'transactions', 'pagetitle' => 'Transactions'];

        echo view('templates/header', $data);
        echo view('sidebars/user', $data);
        echo view('navbars/user', $data);

        echo view('user/transactions');
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
            echo view('sidebars/user', $data);
            echo view('navbars/user', $data);

            echo view('user/view_transaction');
            echo view('templates/footer');
        }else{
            return $this->response->redirect(site_url('user/transactions'));
        }
        
    }

    public function cardMgmtIndex()
    {
        $session = session();
        $data = ['navactive' => 'cardmgmt', 'pagetitle' => 'Manage Cards'];

        echo view('templates/header', $data);
        echo view('sidebars/user', $data);
        echo view('navbars/user', $data);

        echo view('user/cardmgmt');
        echo view('templates/footer');
    }

    public function addCard()
    {
        $session = session();
        $data = ['navactive' => 'cardmgmt', 'pagetitle' => 'Add New Card', 'backbutton' => "cardmgmt"];

        echo view('templates/header', $data);
        echo view('sidebars/user', $data);
        echo view('navbars/user', $data);

        echo view('user/add_card');
        echo view('templates/footer');
    }

    public function editCard($card_id = NULL)
    {
        $card_id = $this->uri->segment(3);
        $cardModel = new PaymentCard();
        $sqlresult = $cardModel->where('card_id', $card_id)->first();

        if($sqlresult == TRUE){
            $session = session();
            $data = ['navactive' => 'cardmgmt', 'pagetitle' => 'Edit Card', 'backbutton' => "cardmgmt"];

            echo view('templates/header', $data);
            echo view('sidebars/user', $data);
            echo view('navbars/user', $data);

            echo view('user/edit_card');
            echo view('templates/footer');
        }else{
            return $this->response->redirect(site_url('user/cardmgmt'));
        }
    }

    public function profileIndex()
    {
        $session = session();
        $data = ['navactive' => 'profile', 'pagetitle' => 'User Profile'];

        echo view('templates/header', $data);
        echo view('sidebars/user', $data);
        echo view('navbars/user', $data);

        echo view('user/profile');
        echo view('templates/footer');
    }

    public function pocketsIndex()
    {
        $session = session();
        $data = ['navactive' => 'pockets', 'pagetitle' => 'Create Pockets'];

        echo view('templates/header', $data);
        echo view('sidebars/user', $data);
        echo view('navbars/user', $data);

        echo view('user/pockets');
        echo view('templates/footer');
    }

    public function addPocket()
    {
        $session = session();
        $data = ['navactive' => 'pockets', 'pagetitle' => 'Add New Pocket', 'backbutton' => "pockets"];

        echo view('templates/header', $data);
        echo view('sidebars/user', $data);
        echo view('navbars/user', $data);

        echo view('user/add_pocket');
        echo view('templates/footer');
    }

    public function editPocket($pocket_id = NULL)
    {
        $pocketModel = new Pocket();
        $sqlresult = $pocketModel->where('pocket_id', $pocket_id)->first();

        if($sqlresult == TRUE){
            $session = session();
            $data = ['navactive' => 'pockets', 'pagetitle' => 'Edit Pocket', 'backbutton' => "pockets"];

            echo view('templates/header', $data);
            echo view('sidebars/user', $data);
            echo view('navbars/user', $data);

            echo view('user/edit_pocket');
            echo view('templates/footer');
        }else{
            return $this->response->redirect(site_url('user/pockets'));
        }
    }

    public function viewPocketTransactionbyId($pocket_id = NULL)
    {
        $pocketModel = new Pocket();
        $sqlresult = $pocketModel->where('pocket_id', $pocket_id)->first();

        if($sqlresult == TRUE){
            $session = session();
            $data = ['navactive' => 'pockets', 'pagetitle' => 'View Pocket Transactions', 'backbutton' => "pockets"];

            echo view('templates/header', $data);
            echo view('sidebars/user', $data);
            echo view('navbars/user', $data);

            echo view('user/pocket_transcations');
            echo view('templates/footer');
        }else{
            return $this->response->redirect(site_url('user/pockets'));
        }
    }

    public function adaptiveBudgetIndex()
    {
        $session = session();
        $data = ['navactive' => 'adaptivebudget', 'pagetitle' => 'View Adaptive Master Budget'];

        echo view('templates/header', $data);
        echo view('sidebars/user', $data);
        echo view('navbars/user', $data);

        echo view('user/adaptivebudget');
        echo view('templates/footer');
    }
}
