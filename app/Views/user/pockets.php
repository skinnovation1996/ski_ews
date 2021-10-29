<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Manage Pockets</h4>
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
                        <a href="add_pocket" class="btn btn-sm btn-success" role="button">+ Add New Pocket</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table" id="tlist">
                            <thead class="text-primary">
                                <th width="5%" scope="col">No.</th>
                                <th width="10%" scope="col">Pocket ID</th>
                                <th width="10%" scope="col">Type</th>
                                <th width="70%" scope="col">Pocket Name</th>
                                <th width="10%" scope="col">Budget Value (RM)</th>
                                <th width="10%" scope="col">Total Spent (RM)</th>
                                <th width="10%" scope="col">Actions</th>
                            </thead>
                            <tbody>
                            <?php
                            if($result){
                            $count = 1;
                            foreach ($result as $pocket){ ?>
                            <tr>
                                <td><?php echo $count++;?></td>
                                <td><?php echo $pocket_id = $pocket['pocket_id'];?></td>
                                <td><?php echo $pocket['purchase_item_type'];?></td>
                                <td><?php echo $pocket['purchase_item_name'];?></td>
                                <td><?php echo $pocket['budget_amt'];?></td>
                                <td><?php echo $pocket['total_spent_amt'];?></td>
                                <td><a href="edit_pocket/<?php echo $pocket_id;?>" class="btn btn-primary btn-sm" role="button">Edit</a>
                                <a href="delete_pocket/<?php echo $pocket_id;?>" class="btn btn-danger btn-sm" role="button">Delete</a></td>
                            </tr>
                            <?php
                            }
                            }else{ ?>
                            <tr>
                                <td colspan="7">No pockets available</td>
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
      