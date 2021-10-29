<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Set Up/Link Bank</h4>
                </div>
                <div class="card-body">
                    <form role="form" action="" method="post" enctype="multipart/form-data">
                        <?php if(isset($_SESSION['message'])){ ?>
                            <div class="alert <?php echo $_SESSION['alertType'];?> alert-dismissible fade show" role="alert">
                                <span class="alert-inner--icon"><i class="nc-icon <?php echo $_SESSION['alertIcon'];?>"></i> </span>
                                <span class="alert-inner--text"><strong><?php echo $_SESSION['alertStart'];?></strong> <?php echo $_SESSION['message'];?></span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php 
                        $_SESSION['message'] = NULL;
                        } ?>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="account_num">Your Account Number</label>
                                        <input type="text" id="account_num" name="account_num" class="form-control form-control-alternative" placeholder="Your Account Number..." value="<?php echo $pocket['pocket_id'];?>" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label class="form-control-label" for="bank_name">Bank Name</label>
                                        <input type="text" id="bank_name" name="bank_name" class="form-control form-control-alternative" placeholder="Bank Name..." value="<?php echo $pocket['budget_amt'];?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="your_earnings">Your Earnings (RM) </label>
                                        <input type="number" id="your_earnings" name="your_earnings" class="form-control form-control-alternative" value="<?php echo number_format($totalearnings, 2); ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="merchant_id" id="merchant_id" value="<?php echo $_SESSION['user_id'];?>" />
                    </div>
                    <div class="card-footer py-5">
                        <button type="submit" role="button" class="btn btn-primary pull-right" name="submit-button">Update Bank Details</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
      