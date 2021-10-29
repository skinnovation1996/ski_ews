<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Delete Card</h4>
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
                                <div class="col-lg-12">
                                    <h3>Are you sure to remove your payment card from this system?</h3>
                                    <h4><b>Card Number:</b> <td><?php 
                                    $card_id = $card['card_id'];
                                    $card_num = $card['card_num'];
                                    
                                    echo substr_replace($card_num,"xxxxxxxxxxxx",1,11);?></td>
                                    <input type="hidden" id="card_id" name="card_id" value="<?php echo $card_id;?>">
                                    <input type="hidden" name="user_id" id="user_id" value="<?php echo $_SESSION['user_id'];?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer py-5">
                        <button type="submit" role="button" class="btn btn-danger pull-right" name="submit-button">YES, Delete it!</button>
                        <a href="<?php echo base_url('user/cardmgmt');?>"  role="button" class="btn btn-primary pull-left">No</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
      