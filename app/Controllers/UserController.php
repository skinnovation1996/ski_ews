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
        //coming soon
    }

    public function topUpIndex()
    {
        $data = ['navactive' => 'topup', 'pagetitle' => 'Top Up', 'balance' => $this->yourBalance(), 'cards' => $this->listCards()];

        echo view('templates/header', $data);
        echo view('sidebars/user', $data);
        echo view('navbars/user', $data);

        echo view('user/topup');
        echo view('templates/footer');
    }

    public function topUpAction()
    {
        $walletModel = new Wallet();
        $my_user_id = $_SESSION['user_id'];
        $yourBalance = number_format($this->yourBalance(), 2);

        $amount = $this->request->getVar('amount');
        $payment_type = $this->request->getVar('payment_select');
        $wallet_id = $this->request->getVar('wallet_id');

        if($payment_type == "Online Banking"){
            $_SESSION['message'] = 'Online banking coming soon.';
            $_SESSION['alertType'] = 'alert-danger';
            $_SESSION['alertIcon'] = 'nc-simple-remove';
            $_SESSION['alertStart'] = 'Error!';
            return $this->response->redirect(site_url('user/topup'));
        }else{
            //reserved for calling topup from card

            //add amount to the User Wallet
            $data = [
                'total_amt'  => $yourBalance + $amount,
            ];

            try{
                $walletModel->update($wallet_id, $data);
            }catch(\Exception $e) {
                $_SESSION['message'] = 'Database error. Please try again';
                $_SESSION['alertType'] = 'alert-danger';
                $_SESSION['alertIcon'] = 'nc-simple-remove';
                $_SESSION['alertStart'] = 'Error!';
                return $this->response->redirect(site_url('user/topup'));
            }
            $_SESSION['message'] = "You have successfully topped up RM $amount to your wallet!";
            $_SESSION['alertType'] = 'alert-success';
            $_SESSION['alertIcon'] = 'nc-check-2';
            $_SESSION['alertStart'] = 'Success!';
            return $this->response->redirect(site_url('user/topup'));

        
        }

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
        //$primary_card = $this->request->getVar('primary_card');

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
        $my_user_id = $_SESSION['user_id'];
        $sqlresult = $cardModel->where('user_id',$my_user_id)->where('card_id', $card_id)->first();

        if($sqlresult != NULL){
            
            $data = ['navactive' => 'cardmgmt', 'pagetitle' => 'Delete Card', 'card' => $sqlresult, 'backbutton' => "cardmgmt", 'balance' => $this->yourBalance()];

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
        $my_user_id = $_SESSION['user_id'];
        $sqlresult = $cardModel->where('user_id',$my_user_id)->where('card_id', $card_id)->first();
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

    public function profileChangeAction()
    {
        $userModel = new User();
        $user_id = $this->request->getVar('user_id');
        $data = [
            'name' => $this->request->getVar('name'),
            'email'  => $this->request->getVar('email'),
            'age'  => $this->request->getVar('age'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        try{
            $userModel->update($user_id, $data);
        }catch(\Exception $e) {
            $_SESSION['message'] = 'Database error. Please try again';
            $_SESSION['alertType'] = 'alert-danger';
            $_SESSION['alertIcon'] = 'nc-simple-remove';
            $_SESSION['alertStart'] = 'Error!';
            return $this->response->redirect(site_url('user/profile'));
        }
        $_SESSION['message'] = 'You have successfully edited your profile.';
        $_SESSION['alertType'] = 'alert-success';
        $_SESSION['alertIcon'] = 'nc-check-2';
        $_SESSION['alertStart'] = 'Success!';
        return $this->response->redirect(site_url('user/profile'));
    }

    public function changePasswordAction()
    {
        $userModel = new User();
        $user_id = $this->request->getVar('user_id');

        $old_password = $this->request->getVar('old_password');

        $checkOldPass = $userModel->where('user_id', $user_id)->first();
        
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
                        $userModel->update($user_id, $data);
                    }catch(\Exception $e) {
                        $_SESSION['message'] = 'Database error. Please try again';
                        $_SESSION['alertType'] = 'alert-danger';
                        $_SESSION['alertIcon'] = 'nc-simple-remove';
                        $_SESSION['alertStart'] = 'Error!';
                        return $this->response->redirect(site_url('user/profile'));
                    }
                    $_SESSION['message'] = 'You have successfully updated your password.';
                    $_SESSION['alertType'] = 'alert-success';
                    $_SESSION['alertIcon'] = 'nc-check-2';
                    $_SESSION['alertStart'] = 'Success!';
                    return $this->response->redirect(site_url('user/profile'));

                }else{
                    $_SESSION['message'] = 'New and confirm password do not match.';
                    $_SESSION['alertType'] = 'alert-danger';
                    $_SESSION['alertIcon'] = 'nc-simple-remove';
                    $_SESSION['alertStart'] = 'Error!';
                    return $this->response->redirect(site_url('user/profile'));
                }
            }else{
                $_SESSION['message'] = 'Invalid old password.';
                $_SESSION['alertType'] = 'alert-danger';
                $_SESSION['alertIcon'] = 'nc-simple-remove';
                $_SESSION['alertStart'] = 'Error!';
                return $this->response->redirect(site_url('user/profile'));
            }
        }else{
            return $this->response->redirect(site_url('user/profile'));
        }
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

            //update to wallet count too
            $walletModel = new Wallet();
            $numOfPockets = $walletModel->select("num_of_pockets")->where("user_id", $my_user_id)->first();
            $data2 = ['num_of_pockets' => $numOfPockets + 1];
        
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
            $data = ['navactive' => 'pockets', 'balance' => $this->yourBalance(), 'pagetitle' => 'View Pocket Transactions', 'backbutton' => "pockets", "transactions" => $sqlresult2];

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
            $yourBalanceSql = $walletModel->select("total_amt")->where("user_id", $my_user_id)->first();
            return $yourBalanceSql['total_amt'];
        }else{
            $walletSql = $this->createWalletDefault();
            $yourBalance = $walletModel->select("total_amt")->where("user_id", $my_user_id)->first();
            return $yourBalance['total_amt'];
        }

        
    }

    public function listCards(){
        $cardModel = new Card();
        $my_user_id = $_SESSION['user_id'];
        $listCard = $cardModel->where('user_id',$my_user_id)->orderBy('card_id','ASC')->findAll();
        return $listCard;
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
