<div class="sidebar" data-color="white" data-active-color="danger">
    <div class="logo">
        <a href="<?php echo base_url("superadmin/user");?>" class="simple-text logo-normal" style="text-align:center">
            Smart Adaptive E-Wallet<br>User
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li <?php if($navactive == "index") echo "class='active'";?>>
                <a href="<?php echo base_url("user/index");?>">
                    <i class="nc-icon nc-bank"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li <?php if($navactive == "scanqr") echo "class='active'";?>>
                <a href="<?php echo base_url("user/scanqr");?>">
                    <i class="nc-icon nc-camera-compact"></i>
                    <p>Scan QR</p>
                </a>
            </li>
            <li <?php if($navactive == "topup") echo "class='active'";?>>
                <a href="<?php echo base_url("user/topup");?>">
                <i class="nc-icon nc-money-coins"></i>
                <p>Top Up</p>
                </a>
            </li>
            <li <?php if($navactive == "transactions") echo "class='active'";?>>
                <a href="<?php echo base_url("user/transactions");?>">
                <i class="nc-icon nc-bell-55"></i>
                <p>Transactions</p>
                </a>
            </li>
            <li <?php if($navactive == "cardmgmt") echo "class='active'";?>>
                <a href="<?php echo base_url("user/cardmgmt");?>">
                <i class="fa fa-credit-card"></i>
                <p>Manage Cards</p>
                </a>
            </li>
            <li <?php if($navactive == "pockets") echo "class='active'";?>>
                <a href="<?php echo base_url("user/pockets");?>">
                <i class="nc-icon nc-single-02"></i>
                <p>Manage Pockets</p>
                </a>
            </li>
            <li <?php if($navactive == "adaptivebudget") echo "class='active'";?>>
                <a href="<?php echo base_url("user/adaptivebudget");?>">
                <i class="nc-icon nc-single-02"></i>
                <p>Adaptive Budget</p>
                </a>
            </li>
            <li <?php if($navactive == "profile") echo "class='active'";?>>
                <a href="<?php echo base_url("user/profile");?>">
                <i class="nc-icon nc-single-02"></i>
                <p>Profile</p>
                </a>
            </li>
        </ul>
    </div>
</div>