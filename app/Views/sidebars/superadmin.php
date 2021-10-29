<div class="sidebar" data-color="superadmin" data-active-color="user">
    <div class="logo">
        <a href="<?php echo base_url("superadmin/index");?>" class="simple-text logo-normal" style="text-align:center">
            Smart Adaptive E-Wallet<br>Super Admin
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li <?php if($navactive == "index") echo "class='active'";?>>
                <a href="<?php echo base_url("superadmin/index");?>">
                    <i class="nc-icon nc-bank"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li <?php if($navactive == "usermgmt") echo "class='active'";?>>
                <a href="<?php echo base_url("superadmin/usermgmt");?>">
                    <i class="nc-icon nc-single-02"></i>
                    <p>User Management</p>
                </a>
            </li>
            <li <?php if($navactive == "merchantmgmt") echo "class='active'";?>>
                <a href="<?php echo base_url("superadmin/merchantmgmt");?>">
                <i class="nc-icon nc-bank"></i>
                <p>Merchant Management</p>
                </a>
            </li>
            <li <?php if($navactive == "securitymgmt") echo "class='active'";?>>
                <a href="<?php echo base_url("superadmin/securitymgmt");?>">
                <i class="nc-icon nc-lock-circle-open"></i>
                <p>Security Management</p>
                </a>
            </li>
            <li <?php if($navactive == "analytics") echo "class='active'";?>>
                <a href="<?php echo base_url("superadmin/analytics");?>">
                <i class="nc-icon nc-chart-bar-32"></i>
                <p>Analytics</p>
                </a>
            </li>
        </ul>
    </div>
</div>