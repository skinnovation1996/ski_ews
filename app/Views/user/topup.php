<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Top Up</h4>
                </div>
                <div class="card-body">
                    <?php if(isset($message)){ ?>
                        <div class="alert <?php echo $alertType;?> alert-dismissible fade show" role="alert">
                            <span class="alert-inner--icon"><i class="ni <?php echo $alertIcon;?>"></i> </span>
                            <span class="alert-inner--text"><strong><?php echo $alertStart;?></strong> <?php echo $message;?></span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php } ?>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
      