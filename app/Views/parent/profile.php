<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">My Profile</h4>
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
                    <div class="pl-lg-4">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="id">Parent ID</label>
                                    <input type="text" id="parent_id" name="parent_id" class="form-control form-control-alternative" placeholder="Autogenerated..." value="<?php echo $result['parent_id'];?>" readonly>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <label class="form-control-label" for="name">User Name</label>
                                    <input type="text" id="name" name="name" class="form-control form-control-alternative" placeholder="User Name..." value="<?php echo $result['name'];?>"  required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="email">E-Mail Address</label>
                                    <input type="email" id="email" name="email" class="form-control form-control-alternative" placeholder="E-Mail Address..." value="<?php echo $result['email'];?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer py-5">
                        <button type="submit" role="button" class="btn btn-primary pull-right" name="submit-button">Submit</button>
                    </div>
                </form>
                    
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">My User's Profile</h4>
                </div>
                <form role="form" action="" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                    <div class="pl-lg-4">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="id">User ID</label>
                                    <input type="text" id="user_id" name="user_id" class="form-control form-control-alternative" placeholder="Autogenerated..." value="<?php echo $user['user_id'];?>" readonly>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <label class="form-control-label" for="name">User Name</label>
                                    <input type="text" id="name" name="name" class="form-control form-control-alternative" placeholder="User Name..." value="<?php echo $user['name'];?>"  readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="age">Age</label>
                                    <input type="number" id="age" name="age" min="1" max="150" class="form-control form-control-alternative" placeholder="Age..." value="<?php echo $user['age'];?>" readonly>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="email">E-Mail Address</label>
                                    <input type="email" id="email" name="email" class="form-control form-control-alternative" placeholder="E-Mail Address..." value="<?php echo $user['email'];?>" readonly>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="parent_code">Parent Code</label>
                                    <input type="text" id="parent_code" name="parent_code" class="form-control form-control-alternative" placeholder="Parent Code..." value="<?php echo $user['parent_code'];?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                    
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Change Password</h4>
                </div>
                <form role="form" action="changepass" method="post" enctype="multipart/form-data">
                    <div class="pl-lg-4">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="old_password">Old Password</label>
                                    <input type="password" id="old_password" name="old_password" class="form-control form-control-alternative" placeholder="Enter your old password..." required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="new_password">New Password</label>
                                    <input type="password" id="new_password" name="new_password" class="form-control form-control-alternative" placeholder="Enter your new password..." required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="confirm_password">Confirm Password</label>
                                    <input type="password" id="confirm_password" name="confirm_password" class="form-control form-control-alternative" placeholder="Confirm password..." required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer py-5">
                        <button type="submit" role="button" class="btn btn-primary pull-right" name="submit-button">Submit</button>
                    </div>
                </form>  
            </div>
        </div>
    </div>
</div>
      