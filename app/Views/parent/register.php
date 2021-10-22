<!--
=========================================================
 Paper Dashboard - v2.0.0
=========================================================

 Product Page: https://www.creative-tim.com/product/paper-dashboard
 Copyright 2019 Creative Tim (https://www.creative-tim.com)
 UPDIVISION (https://updivision.com)
 Licensed under MIT (https://github.com/creativetimofficial/paper-dashboard/blob/master/LICENSE)

 Coded by Creative Tim

=========================================================

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url('assets/img/apple-icon.png');?>">
    <link rel="icon" type="image/png" href="<?php echo base_url('assets/img/favicon.png');?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <!-- Extra details for Live View on GitHub Pages -->
    
    <title>Register - Smart Adaptive E-Wallet System</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <!-- CSS Files -->
    <link href="<?php echo base_url('assets/css2/bootstrap.min.css');?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/css2/paper-dashboard.css?v=2.0.0');?>" rel="stylesheet" />
    <!-- Datatable Files -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
        <div class="container">
            <div class="navbar-wrapper">
                <div class="navbar-toggle">
                    <button type="button" class="navbar-toggler">
                        <span class="navbar-toggler-bar bar1"></span>
                        <span class="navbar-toggler-bar bar2"></span>
                        <span class="navbar-toggler-bar bar3"></span>
                    </button>
                </div>
                <a class="navbar-brand" href="#pablo">Smart Adaptive E-Wallet</a>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-bar navbar-kebab"></span>
                <span class="navbar-toggler-bar navbar-kebab"></span>
                <span class="navbar-toggler-bar navbar-kebab"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navigation">
                <ul class="navbar-nav">
                    <li class="nav-item btn-rotate dropdown active">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink2"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="nc-icon nc-book-bookmark"></i>Register
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink2">
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="../user/register">User</a>
                                <a class="dropdown-item" href="../parent/register">Parent</a>
                                <a class="dropdown-item" href="../merchant/register">Merchant</a>
                                
                            </div>
                        </div>
                    </li>
                    <li class="nav-item btn-rotate dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink2"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="nc-icon nc-tap-01"></i>Login
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink2">
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="../user/login">User</a>
                                <a class="dropdown-item" href="../parent/login">Parent</a>
                                <a class="dropdown-item" href="../merchant/login">Merchant</a>
                                
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="wrapper wrapper-full-page ">
        <div class="full-page section-image" filter-color="black" data-image="<?php echo base_url('assets/img/bg/jan-sendereks.jpg');?>">
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 ml-auto">
                            <div class="info-area info-horizontal mt-5">
                                <div class="icon icon-primary">
                                    <i class="nc-icon nc-tv-2"></i>
                                </div>
                                <div class="description">
                                    <h5 class="info-title">Pockets</h5>
                                    <p class="description">Unlike any other e-wallets, our Smart Adaptive E-Wallet have the pockets.</p>
                                </div>
                            </div>
                            <div class="info-area info-horizontal">
                                <div class="icon icon-primary">
                                    <i class="nc-icon nc-html5"></i>
                                </div>
                                <div class="description">
                                    <h5 class="info-title">Fully Coded in HTML5</h5>
                                    <p class="description">We\'ve developed the website with HTML5 and CSS3. The client has access to the code using GitHub.</p>
                                </div>
                            </div>
                            <div class="info-area info-horizontal">
                                <div class="icon icon-info">
                                    <i class="nc-icon nc-atom"></i>
                                </div>
                                <div class="description">
                                    <h5 class="info-title">Built Audience</h5>
                                    <p class="description">There is also a Fully Customizable CMS Admin Dashboard for this product
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 mr-auto">
                            <div class="card card-signup text-center">
                                <div class="card-header ">
                                    <h4 class="card-title">Parent Register</h4>
                                </div>
                                <div class="card-body ">
                                    <form class="form" method="POST" action='register' aria-label="Register">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="nc-icon nc-single-02"></i>
                                                </span>
                                            </div>
                                            <input name="parent_code" type="text" class="form-control" placeholder="Parent Code (from User)" value="<?= set_value('parent_code') ?>" required autofocus>
                                        </div>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="nc-icon nc-single-02"></i>
                                                </span>
                                            </div>
                                            <input name="name" type="text" class="form-control" placeholder="Name" value="<?= set_value('name') ?>" required autofocus>
                                        </div>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="nc-icon nc-single-02"></i>
                                                </span>
                                            </div>
                                            <input name="user_id" type="text" class="form-control" placeholder="User ID" value="<?= set_value('user_id') ?>" required autofocus>
                                        </div>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="nc-icon nc-email-85"></i>
                                                </span>
                                            </div>
                                            <input name="email" type="email" class="form-control" placeholder="Email" required value="<?= set_value('email') ?>">
                                        </div>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="nc-icon nc-key-25"></i>
                                                </span>
                                            </div>
                                            <input name="password" type="password" class="form-control" placeholder="Password" required>
                                        </div>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="nc-icon nc-key-25"></i>
                                                </span>
                                            </div>
                                            <input name="password_confirmation" type="password" class="form-control" placeholder="Password confirmation" required>
                                        </div>
                                        <div class="form-check text-left">
                                            <label class="form-check-label">
                                                <input class="form-check-input" name="agree_terms_and_conditions" type="checkbox">
                                                <span class="form-check-sign"></span>
                                                    I agree to the
                                                <a href="#something">terms and conditions</a>.
                                            </label>
                                        </div>
                                        <div class="card-footer ">
                                            <button type="submit" class="btn btn-info btn-round">Get Started</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <footer class="footer footer-black  footer-white ">
                <div class="container-fluid">
                    <div class="row">
                        <nav class="footer-nav">
                            <ul>
                                <li>
                                    <a href="https://www.ukm.my" target="_blank">UKM</a>
                                </li>
                            </ul>
                        </nav>
                        <div class="credits ml-auto">
                            <span class="copyright">
                                ©
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> SK Innovation, made with <i class="fa fa-heart heart"></i> by <a class="text-white" href="https://www.creative-tim.com" target="_blank">Creative Tim</a> and <a class="text-white" target="_blank" href="https://updivision.com">UPDIVISION</a>
                            </span>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    

<!-- SCRIPTS -->

<!--   Core JS Files   -->
    <script src="<?php echo base_url('assets/js2/core/jquery.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js2/core/popper.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js2/core/bootstrap.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js2/plugins/perfect-scrollbar.jquery.min.js');?>"></script>
    <!--  Google Maps Plugin    -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
    <!-- Chart JS -->
    <script src="<?php echo base_url('assets/js2/plugins/chartjs.min.js');?>"></script>
    <!--  Notifications Plugin    -->
    <script src="<?php echo base_url('assets/js2/plugins/bootstrap-notify.js');?>"></script>
    <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="<?php echo base_url('assets/js2/paper-dashboard.min.js?v=2.0.0');?>" type="text/javascript"></script>
    <!-- DataTables Plugin -->
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <!-- Paper Dashboard DEMO methods, don't include it in your project! -->
    <script src="<?php echo base_url('assets/demo2/demo.js');?>"></script>
    <script>
        $(document).ready(function() {
            demo.checkFullPageBackgroundImage();
        });
    </script>
<!-- -->

</body>
</html>
