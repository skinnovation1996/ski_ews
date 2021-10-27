<div class="sidebar" data-color="white" data-active-color="danger">
    <div class="logo">
        <a href="<?php echo base_url("parent/index");?>" class="simple-text logo-normal" style="text-align:center">
            Smart Adaptive E-Wallet<br>Parent
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li <?php if($navactive == "index") echo "class='active'";?>>
                <a href="<?php echo base_url("parent/index");?>">
                    <i class="nc-icon nc-bank"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li <?php if($navactive == "topup") echo "class='active'";?>>
                <a href="<?php echo base_url("parent/topup");?>">
                <i class="nc-icon nc-money-coins"></i>
                <p>Top Up</p>
                </a>
            </li>
            <li <?php if($navactive == "transactions") echo "class='active'";?>>
                <a href="<?php echo base_url("parent/transactions");?>">
                <i class="nc-icon nc-bell-55"></i>
                <p>Transactions</p>
                </a>
            </li>
            <li <?php if($navactive == "profile") echo "class='active'";?>>
                <a href="<?php echo base_url("parent/profile");?>">
                <i class="nc-icon nc-single-02"></i>
                <p>Profile</p>
                </a>
            </li>
        </ul>
    </div>
</div>