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

    public function viewTransactionById()
    {
        $transaction_id = $this->uri->segment(3);
        if($transaction_id != NULL){
            $session = session();
            $data = ['navactive' => 'transactions', 'pagetitle' => 'Transactions'];

            echo view('templates/header', $data);
            echo view('sidebars/user', $data);
            echo view('navbars/user', $data);

            echo view('user/view_transaction');
            echo view('templates/footer');
        }else{
            redirect('user/transactions'); 
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
        $data = ['navactive' => 'cardmgmt', 'pagetitle' => 'Add New Card'];

        echo view('templates/header', $data);
        echo view('sidebars/user', $data);
        echo view('navbars/user', $data);

        echo view('user/add_card');
        echo view('templates/footer');
    }

    public function editCard()
    {
        $card_id = $this->uri->segment(3);
        if($card_id != NULL){
            $session = session();
            $data = ['navactive' => 'cardmgmt', 'pagetitle' => 'Edit Card'];

            echo view('templates/header', $data);
            echo view('sidebars/user', $data);
            echo view('navbars/user', $data);

            echo view('user/edit_card');
            echo view('templates/footer');
        }else{
            redirect('user/cardmgmt'); 
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
        $data = ['navactive' => 'pockets', 'pagetitle' => 'Add New Pocket'];

        echo view('templates/header', $data);
        echo view('sidebars/user', $data);
        echo view('navbars/user', $data);

        echo view('user/add_pocket');
        echo view('templates/footer');
    }

    public function editPocket()
    {
        $pocket_id = $this->uri->segment(3);
        if($pocket_id != NULL){
            $session = session();
            $data = ['navactive' => 'pockets', 'pagetitle' => 'Edit Pocket'];

            echo view('templates/header', $data);
            echo view('sidebars/user', $data);
            echo view('navbars/user', $data);

            echo view('user/edit_pocket');
            echo view('templates/footer');
        }else{
            redirect('user/pockets'); 
        }
    }

    public function viewPocketTransactionbyId()
    {
        $pocket_id = $this->uri->segment(3);
        if($pocket_id != NULL){
            $session = session();
            $data = ['navactive' => 'pockets', 'pagetitle' => 'View Pocket Transactions'];

            echo view('templates/header', $data);
            echo view('sidebars/user', $data);
            echo view('navbars/user', $data);

            echo view('user/pocket_transcations');
            echo view('templates/footer');
        }else{
            redirect('user/pockets'); 
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
