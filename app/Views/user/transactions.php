<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Transactions</h4>
                </div>
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
                    <div class="table-responsive">
                        <table class="table" id="tlist">
                            <thead class="text-primary">
                                <th width="5%" scope="col">No.</th>
                                <th width="5%" scope="col">Transaction ID</th>
                                <th width="10%" scope="col">Pocket</th>
                                <th width="10%" scope="col">Created At</th>
                                <th width="10%" scope="col">Merchant Name</th>
                                <th width="10%" scope="col">Amount (RM)</th>
                                <th width="10%" scope="col">Purchased Item</th>
                                <th width="10%" scope="col">Actions</th>
                            </thead>
                            <tbody>
                            <?php
                            if($result){
                            $count = 1;
                            foreach ($result as $transaction){ ?>
                            <tr>
                                <td><?php echo $count++;?></td>
                                <td><?php echo $transaction_id = $transaction['transaction_id'];?></td>
                                <td><?php echo $card['card_num_last_4_digits'];?></td>
                                <td><a href="edit_card/<?php echo $user_id;?>" class="btn btn-primary btn-sm" role="button">Edit</a>
                                <a href="delete_card/<?php echo $user_id;?>" class="btn btn-danger btn-sm" role="button">Delete</a></td>
                            </tr>
                            <?php
                            }
                            }else{ ?>
                            <tr>
                                <td colspan="4">No transactions available</td>
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
      