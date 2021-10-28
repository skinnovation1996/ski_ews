<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Top Up</h4>
                </div>
                <form role="form" action="" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                        <?php if(isset($_SESSION['message'])){ ?>
                            <div class="alert <?php echo $_SESSION['alertType'];?> alert-dismissible fade show" role="alert">
                                <span class="alert-inner--icon"><i class="ni <?php echo $_SESSION['alertIcon'];?>"></i> </span>
                                <span class="alert-inner--text"><strong><?php echo $_SESSION['alertStart'];?></strong> <?php echo $_SESSION['message'];?></span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php 
                        $_SESSION['message'] = NULL;
                        } ?>
                        <h3>Enter your top-up amount and choose the payment method</h3>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-control-label" for="amount">Top Up Amount (RM)</label>
                                        <input type="num" min="0" id="amount" name="amount" class="form-control form-control-alternative" placeholder="Top Up Amount..." required>
                                    </div>
                                </div>
                                <div class="col-lg-9">
                                    <div class="form-group">
                                        <label class="form-control-label" for="payment_select">Select Card</label>
                                        <select name="payment_select" id="payment_select" class="form-control form-control-alternative" required>
                                            <?php
                                            
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="user_id" id="user_id" value="<?php echo $_SESSION['user_id'];?>" />
                        <input type="hidden" name="wallet_id" id="wallet_id" value="<?php echo "WALLET-".$_SESSION['user_id'];?>" />
                    </div>
                    <div class="card-footer py-5">
                        <button type="submit" role="button" class="btn btn-primary pull-right" name="submit-button">Submit</button>
                    </div>
                </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
      