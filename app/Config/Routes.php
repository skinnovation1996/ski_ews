<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
//HOME ROUTES
$routes->get('/', 'Home::index');

/*
======================================================================
SUPER ADMIN ROUTES
======================================================================
*/

//LOGIN
$routes->get('/superadmin/login', 'LoginController::superAdminIndex');
$routes->post('/superadmin/login', 'LoginController::loginSuperAdmin');

//DASHBOARD
$routes->get('/superadmin/index', 'SuperAdminController::index',['filter' => 'authSuperAdmin']);
$routes->get('/superadmin/logout', 'SuperAdminController::logout',['filter' => 'authSuperAdmin']);

//USER MANAGEMENT
$routes->get('/superadmin/usermgmt', 'SuperAdminController::userMgmtIndex',['filter' => 'authSuperAdmin']);
$routes->get('/superadmin/new_user', 'SuperAdminController::newUser',['filter' => 'authSuperAdmin']);
$routes->post('/superadmin/new_user', 'SuperAdminController::newUserAction',['filter' => 'authSuperAdmin']);
$routes->get('/superadmin/edit_user/(:alphanum)', 'SuperAdminController::editUser/$1',['filter' => 'authSuperAdmin']);
$routes->post('/superadmin/edit_user/(:alphanum)', 'SuperAdminController::editUserAction',['filter' => 'authSuperAdmin']);
$routes->get('/superadmin/delete_user/(:alphanum)', 'SuperAdminController::deleteUser/$1',['filter' => 'authSuperAdmin']);
$routes->post('/superadmin/delete_user/(:alphanum)', 'SuperAdminController::deleteUserAction',['filter' => 'authSuperAdmin']);

//MERCHANT MANAGEMENT
$routes->get('/superadmin/merchantmgmt', 'SuperAdminController::merchantMgmtIndex',['filter' => 'authSuperAdmin']);
$routes->get('/superadmin/new_merchant', 'SuperAdminController::newMerchant',['filter' => 'authSuperAdmin']);
$routes->post('/superadmin/new_merchant', 'SuperAdminController::newMerchantAction',['filter' => 'authSuperAdmin']);
$routes->get('/superadmin/edit_merchant/(:alphanum)', 'SuperAdminController::editMerchant/$1',['filter' => 'authSuperAdmin']);
$routes->post('/superadmin/edit_merchant/(:alphanum)', 'SuperAdminController::editMerchantAction',['filter' => 'authSuperAdmin']);
$routes->get('/superadmin/delete_merchant/(:alphanum)', 'SuperAdminController::deleteUser/$1',['filter' => 'authSuperAdmin']);
$routes->post('/superadmin/delete_merchant/(:alphanum)', 'SuperAdminController::deleteMerchantAction',['filter' => 'authSuperAdmin']);

//SECURITY MANAGEMENT
$routes->get('/superadmin/securitymgmt', 'SuperAdminController::securityMgmtIndex',['filter' => 'authSuperAdmin']);

//ANALYTICS
$routes->get('/superadmin/analytics', 'SuperAdminController::analyticsIndex',['filter' => 'authSuperAdmin']);

/*
======================================================================
USER ROUTES
======================================================================
*/

//LOGIN
$routes->get('/user/login', 'LoginController::userIndex');
$routes->post('/user/login', 'LoginController::loginUser');

//REGISTER
$routes->get('/user/register', 'RegisterController::userIndex');
$routes->post('/user/register', 'RegisterController::registerUser');

//FORGOT PASSWORD
$routes->get('/user/forgotpass', 'ForgotPasswordController::userIndex');
$routes->post('/user/forgotpass', 'ForgotPasswordController::userForgotPass');

//DASHBOARD
$routes->get('/user/index', 'UserController::index',['filter' => 'authUser']);
$routes->get('/user/logout', 'UserController::logout',['filter' => 'authUser']);

//SCAN QR
$routes->get('/user/scanqr', 'UserController::scanQRIndex',['filter' => 'authUser']);
$routes->post('/user/scanqr', 'UserController::scanQRPayment',['filter' => 'authUser']);

//PAYMENT GATEWAY
$routes->get('/user/payment', 'UserController::paymentIndex',['filter' => 'authUser']);
$routes->post('/user/payment', 'UserController::makePayment',['filter' => 'authUser']);

//TOPUP
$routes->get('/user/topup', 'UserController::topUpIndex',['filter' => 'authUser']);
$routes->post('/user/topup', 'UserController::topUpAction',['filter' => 'authUser']);

//VIEW TRANSACTION
$routes->get('/user/transactions', 'UserController::transactionIndex',['filter' => 'authUser']);
$routes->get('/user/view_transaction', 'UserController::viewTransactionById',['filter' => 'authUser']);

//MANAGE CARDS
$routes->get('/user/cardmgmt', 'UserController::cardMgmtIndex',['filter' => 'authUser']);
$routes->get('/user/add_card', 'UserController::addCard',['filter' => 'authUser']);
$routes->post('/user/add_card', 'UserController::addCardAction',['filter' => 'authUser']);
$routes->get('/user/edit_card/(:alphanum)', 'UserController::editCard/$1',['filter' => 'authUser']);
$routes->post('/user/edit_card/(:alphanum)', 'UserController::editCardAction',['filter' => 'authUser']);

//SETTINGS
$routes->get('/user/profile', 'UserController::profileIndex',['filter' => 'authUser']);
$routes->post('/user/profile', 'UserController::profileChangeAction',['filter' => 'authUser']);

//POCKET MANAGEMENT
$routes->get('/user/pockets', 'UserController::pocketsIndex',['filter' => 'authUser']);
$routes->get('/user/add_pocket', 'UserController::addPocket',['filter' => 'authUser']);
$routes->post('/user/add_pocket', 'UserController::addPocketAction',['filter' => 'authUser']);
$routes->get('/user/edit_pocket/(:alphanum)', 'UserController::editPocket/$1',['filter' => 'authUser']);
$routes->post('/user/edit_pocket/(:alphanum)', 'UserController::editPocketAction/$1',['filter' => 'authUser']);
$routes->get('/user/pocket_transaction/(:alphanum)', 'UserController::viewPocketTransactionbyId/$1',['filter' => 'authUser']);

//ADAPTIVE MASTER BUDGET
$routes->get('/user/adaptive_budget', 'UserController::adaptiveBudgetIndex',['filter' => 'authUser']);

/*
======================================================================
PARENT ROUTES
======================================================================
*/

//LOGIN
$routes->get('/parent/login', 'LoginController::parentIndex');
$routes->post('/parent/login', 'LoginController::loginParent');

//REGISTER
$routes->get('/parent/register', 'RegisterController::parentIndex');
$routes->post('/parent/register', 'RegisterController::registerParent');

//FORGOT PASSWORD
$routes->get('/parent/forgotpass', 'ForgotPasswordController::parentIndex');
$routes->post('/parent/forgotpass', 'ForgotPasswordController::parentForgotPass');

//DASHBOARD
$routes->get('/parent/index', 'ParentController::index',['filter' => 'authParent']);
$routes->get('/parent/logout', 'ParentController::logout',['filter' => 'authParent']);

//TOPUP
$routes->get('/parent/topup', 'ParentController::topUpIndex',['filter' => 'authParent']);
$routes->post('/parent/topup', 'ParentController::topUpAction',['filter' => 'authParent']);

//PAYMENT GATEWAY
$routes->get('/parent/payment', 'ParentController::paymentIndex',['filter' => 'authParent']);
$routes->post('/parent/payment', 'ParentController::makepayment',['filter' => 'authParent']);

//VIEW TRANSACTION
$routes->get('/parent/transactions', 'ParentController::transactionIndex',['filter' => 'authParent']);
$routes->get('/parent/view_transaction/(:alphanum)', 'ParentController::viewTransactionById/$1',['filter' => 'authParent']);
$routes->get('/parent/view_transaction_by_pocket/(:alphanum)', 'ParentController::viewTransactionByPocket/$1',['filter' => 'authParent']);

/*
======================================================================
MERCHANT ROUTES
======================================================================
*/

//LOGIN
$routes->get('/merchant/login', 'LoginController::merchantIndex');
$routes->post('/merchant/login', 'LoginController::loginMerchant');

//REGISTER
$routes->get('/merchant/register', 'RegisterController::merchantIndex');
$routes->post('/merchant/register', 'RegisterController::registerMerchant');

//FORGOT PASSWORD
$routes->get('/merchant/forgotpass', 'ForgotPasswordController::merchantIndex');

//DASHBOARD
$routes->get('/merchant/index', 'MerchantController::index',['filter' => 'authMerchant']);
$routes->get('/merchant/logout', 'MerchantController::logout',['filter' => 'authMerchant']);

//DISPLAY QR
$routes->get('/merchant/displayQR', 'MerchantController::displayQR',['filter' => 'authMerchant']);

//VIEW TRANSACTION & TOTAL EARNINGS
$routes->get('/merchant/transactions', 'MerchantController::transactionsIndex',['filter' => 'authMerchant']);
$routes->get('/merchant/view_transaction', 'MerchantController::viewTransactionById',['filter' => 'authMerchant']);
$routes->get('/merchant/total_earnings', 'MerchantController::viewTotalEarnings',['filter' => 'authMerchant']);

//SETUP LINK BANK
$routes->get('/merchant/setupbank', 'MerchantController::setUpBankIndex',['filter' => 'authMerchant']);
$routes->get('/merchant/add_bank_details', 'MerchantController::addBankDetails',['filter' => 'authMerchant']);
$routes->post('/merchant/transfer_amount', 'MerchantController::transferAmount',['filter' => 'authMerchant']);

//PAYMENT GATEWAY
$routes->get('/merchant/payment', 'MerchantController::paymentIndex',['filter' => 'authMerchant']);
$routes->post('/merchant/payment', 'MerchantController::makepayment',['filter' => 'authMerchant']);

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
