<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\User;
use App\Models\UserParent;
use App\Models\Card;
use App\Models\Transaction;
use App\Models\Pocket;
use App\Models\Wallet;

class ParentController extends Controller
{
    public function __construct()
    {
        $session = session();
        date_default_timezone_set('Asia/Kuala_Lumpur');
    }

    public function index()
    {
        $parentModel = new UserParent();
        $data = ['navactive' => 'index', 'pagetitle' => 'Dashboard', 'balance' => $this->yourBalance(), 'numOfTransactions' => $this->countNumOfTransactrions(), 
        'numOfPockets' => $this->countNumOfPockets()];

        echo view('templates/header', $data);
        echo view('sidebars/parent', $data);
        echo view('navbars/parent', $data);
        echo view('parent/index');
        echo view('templates/footer');
        
    }

    public function logout()
    {
        session_destroy();
        return redirect()->to('..');
        
    }
    
    public function getUserID(){
        $parentModel = new UserParent();
        $my_user_id = $_SESSION['parent_id'];
        $parentUserId = $parentModel->select("user_id")->where("parent_id",$my_user_id)->first();
        return $parentUserId['user_id'];
    }

    public function transactionIndex()
    {
        $transactionModel = new Transaction();
        $my_user_id = $_SESSION['parent_id'];
        $parentUserId = $this->getUserID();

        $data = ['navactive' => 'transactions', 'pagetitle' => 'Transactions', 'balance' => $this->yourBalance(), 
        'result' => $transactionModel->where('user_id',$parentUserId)->orderBy('transaction_id','DESC')->findAll()];

        echo view('templates/header', $data);
        echo view('sidebars/parent', $data);
        echo view('navbars/parent', $data);

        echo view('parent/transactions');
        echo view('templates/footer');
    }

    public function viewTransactionById($transaction_id = NULL)
    {
        $transactionModel = new Transaction();
        $my_user_id = $_SESSION['parent_id'];
        $parentUserId = $this->getUserID();
        $sqlresult = $transactionModel->where('user_id',$parentUserId)->where('transaction_id', $transaction_id)->first();
        if($sqlresult == TRUE){
            $data = ['navactive' => 'transactions', 'pagetitle' => 'View Transaction', 'balance' => $this->yourBalance(), 'backbutton' => "transactions", 'transaction' => $sqlresult];

            echo view('templates/header', $data);
            echo view('sidebars/parent', $data);
            echo view('navbars/parent', $data);

            echo view('parent/view_transaction');
            echo view('templates/footer');
        }else{
            return $this->response->redirect(site_url('parent/transactions'));
        }
        
    }

    public function viewPocketTransactionbyId($pocket_id = NULL)
    {
        $pocketModel = new Pocket();
        $transactionModel = new transactionIndex();
        $parentUserId = $this->getUserID();
        $sqlresult = $pocketModel->where('user_id',$parentUserId)->where('pocket_id', $pocket_id)->first();
        if($sqlresult == TRUE){
            $sqlresult2 = $transactionModel->where('user_id',$parentUserId)->where('pocket_id', $pocket_id)->orderBy('transaction_id','DESC')->findAll();
            $data = ['navactive' => 'transactions', 'balance' => $this->yourBalance(), 'pagetitle' => 'View Pocket Transactions', 'backbutton' => "transactions", "transactions" => $sqlresult2];

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
        $userModel = new User();
        $parentModel = new UserParent();
        $my_user_id = $_SESSION['parent_id'];
        $parentUserId = $this->getUserID();
        $sqlresult = $userModel->where('user_id', $parentUserId)->first();
        $data = ['navactive' => 'topup', 'pagetitle' => 'Top Up', 'balance' => $this->yourBalance(), 'cards' => $this->listCards(), 'user' => $sqlresult];

        echo view('templates/header', $data);
        echo view('sidebars/parent', $data);
        echo view('navbars/parent', $data);

        echo view('parent/topup');
        echo view('templates/footer');
    }

    public function topUpAction()
    {
        $walletModel = new Wallet();
        $my_user_id = $_SESSION['user_id'];
        $parentUserId = $this->getUserID();
        $yourBalance = number_format($this->yourBalance(), 2);

        $amount = $this->request->getVar('amount');
        $payment_type = $this->request->getVar('payment_select');
        $wallet_id = $this->request->getVar('wallet_id');

        if($payment_type == "Online Banking"){
            $_SESSION['message'] = 'Online banking coming soon.';
            $_SESSION['alertType'] = 'alert-danger';
            $_SESSION['alertIcon'] = 'nc-simple-remove';
            $_SESSION['alertStart'] = 'Error!';
            return $this->response->redirect(site_url('parent/topup'));
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
                return $this->response->redirect(site_url('parent/topup'));
            }
            $_SESSION['message'] = "You have successfully topped up RM $amount to your user's wallet!";
            $_SESSION['alertType'] = 'alert-success';
            $_SESSION['alertIcon'] = 'nc-check-2';
            $_SESSION['alertStart'] = 'Success!';
            return $this->response->redirect(site_url('parent/topup'));

        
        }

    }

    public function profileIndex()
    {
        $userModel = new User();
        $parentModel = new UserParent();
        $my_user_id = $_SESSION['parent_id'];
        $parentUserId = $this->getUserID();

        
        $sqlresult = $userModel->where('user_id', $parentUserId)->first();
        $sqlresult2 = $parentModel->where('parent_id', $my_user_id)->first();

        $data = ['navactive' => 'profile', 'pagetitle' => 'User Profile', 'balance' => $this->yourBalance(), 'user' => $sqlresult, 'parent' => $sqlresult2];

        echo view('templates/header', $data);
        echo view('sidebars/parent', $data);
        echo view('navbars/parent', $data);

        echo view('parent/profile');
        echo view('templates/footer');
    }

    public function profileChangeAction()
    {
        $parentModel = new UserParent();
        $parent_id = $this->request->getVar('parent_id');
        $data = [
            'name' => $this->request->getVar('name'),
            'email'  => $this->request->getVar('email'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        try{
            $parentModel->update($parent_id, $data);
        }catch(\Exception $e) {
            $_SESSION['message'] = 'Database error. Please try again';
            $_SESSION['alertType'] = 'alert-danger';
            $_SESSION['alertIcon'] = 'nc-simple-remove';
            $_SESSION['alertStart'] = 'Error!';
            return $this->response->redirect(site_url('parent/profile'));
        }
        $_SESSION['message'] = 'You have successfully edited your profile.';
        $_SESSION['alertType'] = 'alert-success';
        $_SESSION['alertIcon'] = 'nc-check-2';
        $_SESSION['alertStart'] = 'Success!';
        return $this->response->redirect(site_url('parent/profile'));
    }

    public function changePasswordAction()
    {
        $parentModel = new UserParent();
        $parent_id = $this->request->getVar('parent_id');

        $old_password = $this->request->getVar('old_password');

        $checkOldPass = $parentModel->where('parent_id', $parent_id)->first();
        
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
                        $parentModel->update($parent_id, $data);
                    }catch(\Exception $e) {
                        $_SESSION['message'] = 'Database error. Please try again';
                        $_SESSION['alertType'] = 'alert-danger';
                        $_SESSION['alertIcon'] = 'nc-simple-remove';
                        $_SESSION['alertStart'] = 'Error!';
                        return $this->response->redirect(site_url('parent/profile'));
                    }
                    $_SESSION['message'] = 'You have successfully updated your password.';
                    $_SESSION['alertType'] = 'alert-success';
                    $_SESSION['alertIcon'] = 'nc-check-2';
                    $_SESSION['alertStart'] = 'Success!';
                    return $this->response->redirect(site_url('parent/profile'));

                }else{
                    $_SESSION['message'] = 'New and confirm password do not match.';
                    $_SESSION['alertType'] = 'alert-danger';
                    $_SESSION['alertIcon'] = 'nc-simple-remove';
                    $_SESSION['alertStart'] = 'Error!';
                    return $this->response->redirect(site_url('parent/profile'));
                }
            }else{
                $_SESSION['message'] = 'Invalid old password.';
                $_SESSION['alertType'] = 'alert-danger';
                $_SESSION['alertIcon'] = 'nc-simple-remove';
                $_SESSION['alertStart'] = 'Error!';
                return $this->response->redirect(site_url('parent/profile'));
            }
        }else{
            return $this->response->redirect(site_url('parent/profile'));
        }
    }

    public function createWalletDefault(){
        $walletModel = new Wallet();
        $my_user_id = $_SESSION['parent_id'];
        $parentUserId = $this->getUserID();
        $data = [
            'wallet_id' => "WALLET-$parentUserId",
            'user_id' => $my_user_id,
            'num_of_pockets' => 0,
            'total_amt'  => "0.00"
        ];
        $walletModel->insert($data);
        return TRUE;
    }

    public function yourBalance(){
        $walletModel = new Wallet();
        $my_user_id = $_SESSION['parent_id'];
        $parentUserId = $this->getUserID();
        $yourBalance = 0.00;
        //Check your wallet exists
        $sqlresult = $walletModel->where('user_id',$parentUserId)->first();

        if($sqlresult == TRUE){
            $yourBalanceSql = $walletModel->select("total_amt")->where("user_id", $parentUserId)->first();
            return $yourBalanceSql['total_amt'];
        }else{
            $walletSql = $this->createWalletDefault();
            $yourBalance = $walletModel->select("total_amt")->where("user_id", $parentUserId)->first();
            return $yourBalance['total_amt'];
        }
        
    }

    public function listCards(){
        $cardModel = new Card();
        $my_user_id = $_SESSION['parent_id'];
        $parentUserId = $this->getUserID();
        $listCard = $cardModel->where('user_id',$parentUserId)->orderBy('card_id','ASC')->findAll();
        return $listCard;
    }

    public function countNumOfTransactrions(){
        $transactionModel = new Transaction();
        $my_user_id = $_SESSION['parent_id'];
        $parentUserId = $this->getUserID();
        $numOfUserTransactions = $transactionModel->where("user_id", $parentUserId)->where("created_at >= DATE(NOW()) - INTERVAL 30 DAY")->countAll();
        return $numOfUserTransactions;
    }

    public function countNumOfPockets(){
        $pocketModel = new Pocket();
        $my_user_id = $_SESSION['parent_id'];
        $parentUserId = $this->getUserID();
        $numOfPockets = $pocketModel->where("user_id", $parentUserId)->countAll();
        return $numOfPockets;
    }
}
