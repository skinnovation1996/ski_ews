<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add New Pocket</h4>
                </div>
                <form role="form" action="add_pocket" method="post" enctype="multipart/form-data">
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
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-control-label" for="pocket_id">Pocket ID</label>
                                        <input type="text" maxlength="16" id="pocket_id" name="pocket_id" class="form-control form-control-alternative" placeholder="Pocket ID..." required>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-control-label" for="budget_amt">Budget Amount (RM)</label>
                                        <input type="num" id="budget_amt" name="budget_amt" class="form-control form-control-alternative" placeholder="Budget Amount (RM)..." required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="purchase_item_name">Pocket Item Name</label>
                                        <input type="text" id="purchase_item_name" name="purchase_item_name" class="form-control form-control-alternative" placeholder="Pocket Item Name..." required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="purchase_item_type">Item Type</label>
                                        <input type="text" id="purchase_item_type" name="purchase_item_type" class="form-control form-control-alternative" placeholder="Item Type..." required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="merchant_type">Merchant Type</label>
                                        <input type="text" id="merchant_type" name="merchant_type" class="form-control form-control-alternative" placeholder="Merchant Type..." required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="user_id" id="user_id" value="<?php echo $_SESSION['user_id'];?>" />
                    </div>
                    <div class="card-footer py-5">
                        <button type="submit" role="button" class="btn btn-primary pull-right" name="submit-button">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
      