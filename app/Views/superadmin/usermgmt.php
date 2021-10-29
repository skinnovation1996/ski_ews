<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">User Management</h4>
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
                    <div class="col text-right">
                        <a href="new_user" class="btn btn-sm btn-success" role="button">+ Add New User</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table" id="tlist">
                            <thead class="text-primary">
                                <th width="5%" scope="col">No.</th>
                                <th width="10%" scope="col">Profile Pic.</th>
                                <th width="5%" scope="col">User ID</th>
                                <th width="60%" scope="col">User Name</th>
                                <th width="10%" scope="col">E-Mail</th>
                                <th width="10%" scope="col">Registration Date</th>
                                <th width="10%" scope="col">Actions</th>
                            </thead>
                            <tbody>
                            <?php
                            if($result){
                            $count = 1;
                            foreach ($result as $user){
                                if($user['user_id'] != "super_admin"){?>
                            <tr>
                                <td><?php echo $count++;?></td>
                                <td>coming soon</td>
                                <td><?php echo $user_id = $user['user_id'];?></td>
                                <td><?php echo $user['name'];?></td>
                                <td><?php echo $user['email'];?></td>
                                <td><?php echo date_format(date_create($user['created_at']), "d M Y, H:i:sa");?></td>
                                <td><a href="edit_user/<?php echo $user_id;?>" class="btn btn-primary btn-sm" role="button">Edit</a>
                                <a href="delete_user/<?php echo $user_id;?>" class="btn btn-danger btn-sm" role="button">Delete</a></td>
                            </tr>
                            <?php
                            } }
                            }else{ ?>
                            <tr>
                                <td colspan="7">No users available</td>
                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
      