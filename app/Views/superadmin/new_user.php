<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add New User</h4>
                </div>
                <form role="form" action="new_user" method="post" enctype="multipart/form-data">
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
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-control-label" for="id">User ID</label>
                                        <input type="text" id="user_id" name="user_id" class="form-control form-control-alternative" placeholder="User ID (must be unique)..." required>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-control-label" for="password">Login Password</label>
                                        <input type="password" id="password" name="password" class="form-control form-control-alternative" placeholder="Password will be sent to E-Mail..." required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="name">User Name</label>
                                        <input type="text" id="name" name="name" class="form-control form-control-alternative" placeholder="User Name..." required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="age">Age</label>
                                        <input type="number" id="age" name="age" min="1" max="150" class="form-control form-control-alternative" placeholder="Age..." required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="email">E-Mail Address</label>
                                        <input type="email" id="email" name="email" class="form-control form-control-alternative" placeholder="E-Mail Address..." required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="parent_code">Parent Code</label>
                                        <input type="text" id="parent_code" name="parent_code" class="form-control form-control-alternative" placeholder="Parent Code..." required>
                                    </div>
                                </div>
                            </div>
                            <!--
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="phone-no">Phone Number</label>
                                        <input type="number" id="phone-no" name="phone-no" class="form-control form-control-alternative" placeholder="Phone Number..." required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group form-file-upload form-file-multiple">
                                        <input type="file" name="file_name" id="file_name" multiple="" class="inputFileHidden" required>
                                        <div class="input-group">
                                            <input type="text" class="form-control inputFileVisible" placeholder="Profile Picture (max 3MB, JPG/PNG/BMP only)">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-fab btn-round btn-primary">
                                                    <i class="nc-icon nc-single-copy-04"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            -->
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
      