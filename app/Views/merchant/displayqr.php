<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Display QR</h4>
                </div>
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
                    You can generate the QR code of the merchant here...
                    
                </div>
            </div>
        </div>
    </div>
</div>
      