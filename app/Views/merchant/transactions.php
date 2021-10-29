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
                            <span class="alert-inner--icon"><i class="nc-icon <?php echo $_SESSION['alertIcon'];?>"></i> </span>
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
                                <th width="10%" scope="col">Created At</th>
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
                                <td><?php echo $transaction_id = $transaction['merch_trans_id'];?></td>
                                <td><?php echo date_format(date_create($transaction['created_at']), "d M Y, H:i:sa");?></td>
                                <td><?php echo $transaction['transaction_amt'];?></td>
                                <td><?php echo $transaction['purchase_item_name'];?></td>
                                <td><a href="view_transcation/<?php echo $transaction_id;?>" class="btn btn-primary btn-sm" role="button">View</a></td>
                            </tr>
                            <?php
                            }
                            }else{ ?>
                            <tr>
                                <td colspan="6">No transactions available</td>
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
      