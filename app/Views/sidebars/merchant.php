<div class="sidebar" data-color="white" data-active-color="danger">
    <div class="logo">
        <a href="<?php echo base_url("merchant/index");?>" class="simple-text logo-normal" style="text-align:center">
            Smart Adaptive E-Wallet<br>Merchant
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li <?php if($navactive == "index") echo "class='active'";?>>
                <a href="<?php echo base_url("merchant/index");?>">
                    <i class="nc-icon nc-bank"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li <?php if($navactive == "displayqr") echo "class='active'";?>>
                <a href="<?php echo base_url("merchant/displayqr");?>">
                <i class="nc-icon nc-money-coins"></i>
                <p>Display QR</p>
                </a>
            </li>
            <li <?php if($navactive == "transactions") echo "class='active'";?>>
                <a href="<?php echo base_url("merchant/transactions");?>">
                <i class="nc-icon nc-bell-55"></i>
                <p>View Transactions</p>
                </a>
            </li>
            <li <?php if($navactive == "earnings") echo "class='active'";?>>
                <a href="<?php echo base_url("merchant/totalearning");?>">
                <i class="nc-icon nc-bell-55"></i>
                <p>View Total Earnings</p>
                </a>
            </li>
            <li <?php if($navactive == "setupbank") echo "class='active'";?>>
                <a href="<?php echo base_url("merchant/setupbank");?>">
                <i class="nc-icon nc-single-02"></i>
                <p>Setup/Link Bank</p>
                </a>
            </li>
        </ul>
    </div>
</div>