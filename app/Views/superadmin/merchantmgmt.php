<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Merchant Management</h4>
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
                        <a href="new_merchant" class="btn btn-sm btn-success" role="button">+ Add New Merchant</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table" id="tlist">
                            <thead class="text-primary">
                                <th width="5%" scope="col">No.</th>
                                <th width="5%" scope="col">Merchant ID</th>
                                <th width="60%" scope="col">Merchant Name</th>
                                <th width="10%" scope="col">Type</th>
                                <th width="10%" scope="col">E-Mail</th>
                                <th width="10%" scope="col">Registration Date</th>
                                <th width="10%" scope="col">Actions</th>
                            </thead>
                            <tbody>
                            <?php
                            if($result){
                            $count = 1;
                            foreach ($result as $row){?>
                            <tr>
                                <td><?php echo $count++;?></td>
                                <td><?php echo $merchant_id = $row['merchant_id'];?></td>
                                <td><?php echo $row['name'];?></td>
                                <td><?php echo $row['type'];?></td>
                                <td><?php echo $row['email'];?></td>
                                <td><?php echo date_format(date_create($row['created_at']), "d M Y, H:i:sa");?></td>
                                <td><a href="edit_merchant/<?php echo $merchant_id;?>" class="btn btn-primary btn-sm" role="button">Edit</a>
                                <a href="delete_merchant/<?php echo $merchant_id;?>" class="btn btn-danger btn-sm" role="button">Delete</a></td>
                            </tr>
                            <?php
                            }
                            }else{ ?>
                            <tr>
                                <td colspan="7">No merchants available</td>
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
      