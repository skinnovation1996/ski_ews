<div class="sidebar" data-color="white" data-active-color="danger">
    <div class="logo">
        <a href="index" class="simple-text logo-normal" style="text-align:center">
            Smart Adaptive E-Wallet<br>Super Admin
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li <?php if($navactive == "index") echo "class='active'";?>>
                <a href="index">
                    <i class="nc-icon nc-bank"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li <?php if($navactive == "usermgmt") echo "class='active'";?>>
                <a href="usermgmt">
                    <i class="nc-icon nc-diamond"></i>
                    <p>User Management</p>
                </a>
            </li>
            <li <?php if($navactive == "merchantmgmt") echo "class='active'";?>>
                <a href="merchantmgmt">
                <i class="nc-icon nc-pin-3"></i>
                <p>Merchant Management</p>
                </a>
            </li>
            <li <?php if($navactive == "securitymgmt") echo "class='active'";?>>
                <a href="securitymgmt">
                <i class="nc-icon nc-bell-55"></i>
                <p>Security Management</p>
                </a>
            </li>
            <li <?php if($navactive == "analytics") echo "class='active'";?>>
                <a href="analytics">
                <i class="nc-icon nc-single-02"></i>
                <p>Analytics</p>
                </a>
            </li>
        </ul>
    </div>
</div>