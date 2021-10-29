<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Manage Cards</h4>
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
                        <a href="add_card" class="btn btn-sm btn-success" role="button">+ Add New Card</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table" id="tlist">
                            <thead class="text-primary">
                                <th width="5%" scope="col">No.</th>
                                <th width="5%" scope="col">Card</th>
                                <th width="70%" scope="col">Card Number</th>
                                <th width="10%" scope="col">Expiry Date</th>
                                <th width="10%" scope="col">Actions</th>
                            </thead>
                            <tbody>
                            <?php
                            if($result){
                            $count = 1;
                            foreach ($result as $card){ ?>
                            <tr>
                                <td><?php echo $count++;?></td>
                                <td><?php
                                switch($card['type']){
                                    case "Visa":
                                        echo "<b style='color:#1A1F71'>VISA</b>";
                                        break;
                                    case "Mastercard":
                                        echo "<b style='color:#FF5F00'>MasterCard</b>";
                                        break;
                                    case "AMEX":
                                        echo "<b style='color:#2671B9'>American Express</b>";
                                        break;
                                    default:
                                        echo "<b style='color:green'>Others</b>";
                                }
                                ?></td>
                                <td><?php 
                                $card_id = $card['card_id'];
                                $card_num = $card['card_num'];
                                
                                echo substr_replace($card_num,"xxxxxxxxxxxx",1,11);?></td>
                                <td><?php 
                                echo date_format(date_create($card['expiry_date']), "F Y");?></td>
                                <td><a href="edit_card/<?php echo $card_id;?>" class="btn btn-primary btn-sm" role="button">Edit</a>
                                <a href="delete_card/<?php echo $card_id;?>" class="btn btn-danger btn-sm" role="button">Delete</a></td>
                            </tr>
                            <?php
                            }
                            }else{ ?>
                            <tr>
                                <td colspan="4">No card available</td>
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
      