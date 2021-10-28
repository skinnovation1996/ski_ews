<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\User;
use App\Models\Card;
use App\Models\Transaction;
use App\Models\Pocket;
use App\Models\Wallet;

class UserController extends Controller
{
    public function __construct()
    {
        $session = session();
        date_default_timezone_set('Asia/Kuala_Lumpur');
    }

    public function index()
    {
        $my_user_id = $_SESSION['user_id'];
        $data = ['navactive' => 'index', 'pagetitle' => 'Dashboard', 'balance' => $this->yourBalance(), 'numOfTransactions' => $this->countNumOfTransactrions(), 
        'numOfPockets' => $this->countNumOfPockets()];

        echo view('templates/header', $data);
        echo view('sidebars/user', $data);
        echo view('navbars/user', $data);
        echo view('user/index');
        echo view('templates/footer');
        
    }

    public function logout()
    {
        session_destroy();
        return redirect()->to('..');
        
    }  

    public function scanQRIndex()
    {
        $data = ['navactive' => 'scanqr', 'pagetitle' => 'Scan QR', 'balance' => $this->yourBalance()];

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
        $data = ['navactive' => 'topup', 'pagetitle' => 'Top Up', 'balance' => $this->yourBalance()];

        echo view('templates/header', $data);
        echo view('sidebars/user', $data);
        echo view('navbars/user', $data);

        echo view('user/topup');
        echo view('templates/footer');
    }

    public function transactionIndex()
    {
        $transactionModel = new Transaction();
        $my_user_id = $_SESSION['user_id'];
        $data = ['navactive' => 'transactions', 'pagetitle' => 'Transactions', 'balance' => $this->yourBalance(), 
        'result' => $transactionModel->where('user_id',$my_user_id)->orderBy('transaction_id','DESC')->findAll()];

        echo view('templates/header', $data);
        echo view('sidebars/user', $data);
        echo view('navbars/user', $data);

        echo view('user/transactions');
        echo view('templates/footer');
    }

    public function viewTransactionById($transaction_id = NULL)
    {
        $transactionModel = new Transaction();
        $my_user_id = $_SESSION['user_id'];
        $sqlresult = $transactionModel->where('transaction_id', $transaction_id)->where('user_id',$my_user_id)->first();
        if($sqlresult == TRUE){
            $data = ['navactive' => 'transactions', 'pagetitle' => 'Transactions', 'balance' => $this->yourBalance(), 'backbutton' => "transactions", 'transaction' => $sqlresult];

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
        $cardModel = new Card();
        $my_user_id = $_SESSION['user_id'];
        $data = ['navactive' => 'cardmgmt', 'pagetitle' => 'Manage Cards', 'balance' => $this->yourBalance(), 'result' => $cardModel->where('user_id',$my_user_id)->orderBy('card_id','ASC')->findAll()];

        echo view('templates/header', $data);
        echo view('sidebars/user', $data);
        echo view('navbars/user', $data);

        echo view('user/cardmgmt');
        echo view('templates/footer');
    }

    public function addCard()
    {
        $data = ['navactive' => 'cardmgmt', 'pagetitle' => 'Add New Card', 'backbutton' => "cardmgmt", 'balance' => $this->yourBalance()];

        echo view('templates/header', $data);
        echo view('sidebars/user', $data);
        echo view('navbars/user', $data);

        echo view('user/add_card');
        echo view('templates/footer');
    }

    public function addCardAction()
    {
        $cardModel = new Card();

        $card_number = $this->request->getVar('card_num');

        //get type
        if(preg_match("/^4[0-9]{12}(?:[0-9]{3})?/", $card_number)){
            $type = "Visa";
        }else if(preg_match("/^(5[1-5][0-9]{14}|2(22[1-9][0-9]{12}|2[3-9][0-9]{13}|[3-6][0-9]{14}|7[0-1][0-9]{13}|720[0-9]{12}))/", $card_number)){
            $type = "MasterCard";
        }else if(preg_match("/^3[47][0-9]{13}/", $card_number)){
            $type = "AMEX";
        }else{
            $type = "Others";
        }
        $data = [
            'user_id' => $this->request->getVar('user_id'),
            'card_num' => $card_number,
            'type' => $type,
            'cvv'  => $this->request->getVar('cvv2'),
            'expiry_date'  => date_format(date_create($this->request->getVar('expiry_date')), "Y-m-01"),
        ];
        
        try{
            $cardModel->insert($data);
        }catch(\Exception $e) {
            $_SESSION['message'] = 'Database error. Please try again';
            $_SESSION['alertType'] = 'alert-danger';
            $_SESSION['alertIcon'] = 'nc-simple-remove';
            $_SESSION['alertStart'] = 'Error!';
            return $this->response->redirect(site_url('user/add_card'));
        }
        $_SESSION['message'] = 'You have successfully added your card to the system.';
        $_SESSION['alertType'] = 'alert-success';
        $_SESSION['alertIcon'] = 'nc-check-2';
        $_SESSION['alertStart'] = 'Success!';
        return $this->response->redirect(site_url('user/cardmgmt'));
    }

    public function editCard($card_id = NULL)
    {
        $cardModel = new Card();
        $my_user_id = $_SESSION['user_id'];
        $sqlresult = $cardModel->where('user_id',$my_user_id)->where('card_id', $card_id)->first();
    
        if($sqlresult == TRUE){
            $data = ['navactive' => 'cardmgmt', 'pagetitle' => 'Edit Card', 'backbutton' => "cardmgmt", 'balance' => $this->yourBalance(), 'card' => $sqlresult];

            echo view('templates/header', $data);
            echo view('sidebars/user', $data);
            echo view('navbars/user', $data);

            echo view('user/edit_card');
            echo view('templates/footer');
        }else{
            return $this->response->redirect(site_url('user/cardmgmt'));
        }
    }

    public function editCardAction()
    {
        $card_id = $this->request->getVar('card_id');
        $cardModel = new Card();

        $card_number = $this->request->getVar('card_num');

        //get type
        if(preg_match("/^4[0-9]{12}(?:[0-9]{3})?/", $card_number)){
            $type = "Visa";
        }else if(preg_match("/^(5[1-5][0-9]{14}|2(22[1-9][0-9]{12}|2[3-9][0-9]{13}|[3-6][0-9]{14}|7[0-1][0-9]{13}|720[0-9]{12}))/", $card_number)){
            $type = "MasterCard";
        }else if(preg_match("/^3[47][0-9]{13}/", $card_number)){
            $type = "AMEX";
        }else{
            $type = "Others";
        }
        $data = [
            'user_id' => $this->request->getVar('user_id'),
            'card_num' => $card_number,
            'type' => $type,
            'cvv'  => $this->request->getVar('cvv2'),
            'expiry_date'  => date_format(date_create($this->request->getVar('expiry_date')), "Y-m-01"),
        ];


        try{
            $cardModel->update($card_id, $data);
        }catch(\Exception $e) {
            $_SESSION['message'] = 'Database error. Please try again';
            $_SESSION['alertType'] = 'alert-danger';
            $_SESSION['alertIcon'] = 'nc-simple-remove';
            $_SESSION['alertStart'] = 'Error!';
            return $this->response->redirect(site_url("user/edit_card/$card_id"));
        }
        $_SESSION['message'] = 'You have successfully updated your card information.';
        $_SESSION['alertType'] = 'alert-success';
        $_SESSION['alertIcon'] = 'nc-check-2';
        $_SESSION['alertStart'] = 'Success!';
        return $this->response->redirect(site_url('user/cardmgmt'));
    }

    public function deleteCard($card_id = null)
    {
        $cardModel = new Card();
        $sqlresult = $cardModel->where('card_id', $card_id)->first();

        if($sqlresult != NULL){
            
            $data = ['navactive' => 'usermgmt', 'pagetitle' => 'Delete Card', 'card' => $sqlresult, 'backbutton' => "cardmgmt", 'balance' => $this->yourBalance()];

            echo view('templates/header', $data);
            echo view('sidebars/user', $data);
            echo view('navbars/user', $data);

            echo view('user/delete_card');
            echo view('templates/footer');
        }else{
            return $this->response->redirect(site_url('user/cardmgmt'));
        }
    }

    public function deleteCardAction($card_id)
    {
        $cardModel = new Card();
        $sqlresult = $cardModel->where('card_id', $card_id)->delete($card_id);
        $_SESSION['message'] = 'You have successfully removed your payment card from the system.';
        $_SESSION['alertType'] = 'alert-success';
        $_SESSION['alertIcon'] = 'nc-check-2';
        $_SESSION['alertStart'] = 'Success!';
        return $this->response->redirect(site_url('user/cardmgmt'));
    }

    public function profileIndex()
    {
        $userModel = new User();
        $my_user_id = $_SESSION['user_id'];
        $sqlresult = $userModel->where('user_id', $my_user_id)->first();
        
        $data = ['navactive' => 'profile', 'pagetitle' => 'User Profile', 'balance' => $this->yourBalance(), 'result' => $sqlresult];

        echo view('templates/header', $data);
        echo view('sidebars/user', $data);
        echo view('navbars/user', $data);

        echo view('user/profile');
        echo view('templates/footer');
    }

    public function updateProfile()
    {
        $userModel = new User();
        $my_user_id = $_SESSION['user_id'];
        $sqlresult = $userModel->where('user_id', $my_user_id)->first();
        
        $data = ['navactive' => 'profile', 'pagetitle' => 'User Profile', 'balance' => $this->yourBalance(), 'result' => $sqlresult];

        echo view('templates/header', $data);
        echo view('sidebars/user', $data);
        echo view('navbars/user', $data);

        echo view('user/profile');
        echo view('templates/footer');
    }

    public function pocketsIndex()
    {
        $pocketModel = new Pocket();
        $my_user_id = $_SESSION['user_id'];
        $data = ['navactive' => 'pockets', 'pagetitle' => 'Manage Pockets', 'balance' => $this->yourBalance(), 'result' => $pocketModel->where('user_id', $my_user_id)->orderBy('pocket_id','ASC')->findAll()];

        echo view('templates/header', $data);
        echo view('sidebars/user', $data);
        echo view('navbars/user', $data);

        echo view('user/pockets');
        echo view('templates/footer');
    }

    public function addPocket()
    {
        $data = ['navactive' => 'pockets', 'pagetitle' => 'Add New Pocket', 'balance' => $this->yourBalance(), 'backbutton' => "pockets"];

        echo view('templates/header', $data);
        echo view('sidebars/user', $data);
        echo view('navbars/user', $data);

        echo view('user/add_pocket');
        echo view('templates/footer');
    }

    public function addPocketAction()
    {

        $pocketModel = new Pocket();
        $pocket_id = $this->request->getVar('pocket_id');

        //Check exists
        $sqlresult = $pocketModel->where('pocket_id', $pocket_id)->first();

        if($sqlresult == NULL){

            $data = [
                'pocket_id' => $this->request->getVar('pocket_id'),
                'user_id' => $this->request->getVar('user_id'),
                'budget_amt' => $this->request->getVar('budget_amt'),
                'total_spent_amt' => 0,
                'merchant_type'  => $this->request->getVar('merchant_type'),
                'purchase_item_name' => $this->request->getVar('purchase_item_name'),
                'purchase_item_type'  => $this->request->getVar('purchase_item_type'),
            ];

            try{
                $pocketModel->insert($data);
            }catch(\Exception $e) {
                $_SESSION['message'] = 'Database error. Please try again';
                $_SESSION['alertType'] = 'alert-danger';
                $_SESSION['alertIcon'] = 'nc-simple-remove';
                $_SESSION['alertStart'] = 'Error!';
                return $this->response->redirect(site_url('user/add_pocket'));
            }
            $_SESSION['message'] = 'You have successfully added your pocket!';
            $_SESSION['alertType'] = 'alert-success';
            $_SESSION['alertIcon'] = 'nc-check-2';
            $_SESSION['alertStart'] = 'Success!';
            return $this->response->redirect(site_url('user/pockets'));
        }else{
            $_SESSION['message'] = 'This Pocket ID already exists in our system! Please enter a different pocket ID!';
            $_SESSION['alertType'] = 'alert-danger';
            $_SESSION['alertIcon'] = 'nc-simple-remove';
            $_SESSION['alertStart'] = 'Error!';
            return $this->response->redirect(site_url('user/pockets'));
        }
    }

    public function editPocket($pocket_id = NULL)
    {
        $pocketModel = new Pocket();
        $my_user_id = $_SESSION['user_id'];
        $sqlresult = $pocketModel->where('user_id',$my_user_id)->where('pocket_id', $pocket_id)->first();

        if($sqlresult == TRUE){
            $data = ['navactive' => 'pockets', 'pagetitle' => 'Edit Pocket', 'balance' => $this->yourBalance(), 'backbutton' => "pockets", 'pocket' => $sqlresult];

            echo view('templates/header', $data);
            echo view('sidebars/user', $data);
            echo view('navbars/user', $data);

            echo view('user/edit_pocket');
            echo view('templates/footer');
        }else{
            return $this->response->redirect(site_url('user/pockets'));
        }
    }

    public function editPocketAction()
    {

        $pocketModel = new Pocket();
        $pocket_id = $this->request->getVar('pocket_id');

        $data = [
            'user_id' => $this->request->getVar('user_id'),
            'budget_amt' => $this->request->getVar('budget_amt'),
            'merchant_type'  => $this->request->getVar('merchant_type'),
            'purchase_item_name' => $this->request->getVar('purchase_item_name'),
            'purchase_item_type'  => $this->request->getVar('purchase_item_type'),
            'updated_at' => date("Y-m-d H:i:s"),
        ];

        try{
            $pocketModel->update($pocket_id, $data);
        }catch(\Exception $e) {
            $_SESSION['message'] = 'Database error. Please try again';
            $_SESSION['alertType'] = 'alert-danger';
            $_SESSION['alertIcon'] = 'nc-simple-remove';
            $_SESSION['alertStart'] = 'Error!';
            return $this->response->redirect(site_url("user/edit_pocket/$pocket_id"));
        }
        $_SESSION['message'] = 'You have successfully updated your pocket!';
        $_SESSION['alertType'] = 'alert-success';
        $_SESSION['alertIcon'] = 'nc-check-2';
        $_SESSION['alertStart'] = 'Success!';
        return $this->response->redirect(site_url('user/pockets'));
    }

    public function deletePocket($pocket_id = null)
    {
        $pocketModel = new Pocket();
        $my_user_id = $_SESSION['user_id'];
        $sqlresult = $pocketModel->where('user_id',$my_user_id)->where('pocket_id', $pocket_id)->first();

        if($sqlresult != NULL){
            
            $data = ['navactive' => 'pockets', 'pagetitle' => 'Delete Pocket', 'balance' => $this->yourBalance(), 'backbutton' => "pockets", 'pocket' => $sqlresult];

            echo view('templates/header', $data);
            echo view('sidebars/user', $data);
            echo view('navbars/user', $data);

            echo view('user/delete_pocket');
            echo view('templates/footer');
        }else{
            return $this->response->redirect(site_url('user/pocket'));
        }
    }

    public function deletePocketAction($card_id)
    {
        $pocketModel = new Pocket();
        $sqlresult = $pocketModel->where('pocket_id', $pocket_id)->delete($pocket_id);
        $_SESSION['message'] = 'You have successfully removed your pocket from the system.';
        $_SESSION['alertType'] = 'alert-success';
        $_SESSION['alertIcon'] = 'nc-check-2';
        $_SESSION['alertStart'] = 'Success!';
        return $this->response->redirect(site_url('user/pocket'));
    }

    public function viewPocketTransactionbyId($pocket_id = NULL)
    {
        $pocketModel = new Pocket();
        $transactionModel = new transactionIndex();
        $my_user_id = $_SESSION['user_id'];
        $sqlresult = $pocketModel->where('user_id',$my_user_id)->where('pocket_id', $pocket_id)->first();

        if($sqlresult == TRUE){
            $sqlresult2 = $transactionModel->where('user_id',$my_user_id)->where('pocket_id', $pocket_id)->orderBy('transaction_id','DESC')->findAll();
            $data = ['navactive' => 'pockets', 'balance' => $this->yourBalance(), 'pagetitle' => 'View Pocket Transactions', 'backbutton' => "pockets"];

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
        $data = ['navactive' => 'adaptivebudget', 'balance' => $this->yourBalance(), 'pagetitle' => 'View Adaptive Master Budget'];

        echo view('templates/header', $data);
        echo view('sidebars/user', $data);
        echo view('navbars/user', $data);

        echo view('user/adaptivebudget');
        echo view('templates/footer');
    }

    public function createWalletDefault(){
        $walletModel = new Wallet();
        $my_user_id = $_SESSION['user_id'];
        $data = [
            'wallet_id' => "WALLET-$my_user_id",
            'user_id' => $my_user_id,
            'num_of_pockets' => 0,
            'total_amt'  => "0.00"
        ];
        $walletModel->insert($data);
        return TRUE;
    }

    public function yourBalance(){
        $walletModel = new Wallet();
        $my_user_id = $_SESSION['user_id'];
        $yourBalance = 0.00;
        //Check your wallet exists
        $sqlresult = $walletModel->where('user_id',$my_user_id)->first();

        if($sqlresult == TRUE){
            $yourBalanceSql = $walletModel->select("total_amt")->where("user_id", $my_user_id)->get();
            return $yourBalanceSql;
        }else{
            $walletSql = $this->createWalletDefault();
            $yourBalance = $walletModel->select("total_amt")->where("user_id", $my_user_id)->get();
            return $yourBalance;
        }

        
    }

    public function countNumOfTransactrions(){
        $transactionModel = new Transaction();
        $my_user_id = $_SESSION['user_id'];
        $numOfUserTransactions = $transactionModel->where("user_id", $my_user_id)->where("created_at >= DATE(NOW()) - INTERVAL 30 DAY")->countAll();
        return $numOfUserTransactions;
    }

    public function countNumOfPockets(){
        $pocketModel = new Pocket();
        $my_user_id = $_SESSION['user_id'];
        $numOfPockets = $pocketModel->where("user_id", $my_user_id)->countAll();
        return $numOfPockets;
    }
}
