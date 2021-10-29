<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Delete User</h4>
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
                                    <h3>Are you sure to remove this user from this system?</h3>
                                    <h4><b>User ID:</b> <?php echo $user['user_id'];?></br>
                                    <b>Name:</b> <?php echo $user['name'];?></h4>
                                    <input type="hidden" id="user_id" name="user_id" value="<?php echo $user['user_id'];?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer py-5">
                        <button type="submit" role="button" class="btn btn-danger pull-right" name="submit-button">YES, Delete it!</button>
                        <a href="<?php echo base_url('superadmin/usermgmt');?>"  role="button" class="btn btn-primary pull-left">No</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
      