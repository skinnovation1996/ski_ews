<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Card</h4>
                </div>
                <form role="form" action="" method="post" enctype="multipart/form-data">
                    <div class="card-body">
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
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="card_num">Card Number</label>
                                        <input type="num" maxlength="16" id="card_num" name="card_num" class="form-control form-control-alternative" placeholder="Card Number..." value="<?php echo $card['card_num'];?>" required>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-control-label" for="type">Card Type</label>
                                        <input type="name" id="type" name="type" class="form-control form-control-alternative" placeholder="Determined by card number..." value="<?php echo $card['type'];?>" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-control-label" for="name">Card Holder Name</label>
                                        <input type="text" id="name" name="name" class="form-control form-control-alternative" placeholder="Card Holder Name..." value="<?php echo $card['name'];?>" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-control-label" for="cvv2">CVV2/CID</label>
                                        <input type="password" maxlength="6" id="cvv2" name="cvv2" class="form-control form-control-alternative" placeholder="CVV2/CID" required>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-control-label" for="expiry_date">Expiry Date</label>
                                        <input type="month" id="expiry_date" name="expiry_date" class="form-control form-control-alternative" placeholder="Expiry Date..." value="<?php echo $card['expiry_date'];?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="card_id" id="card_id" value="<?php echo $card['card_id'];?>" />
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
      