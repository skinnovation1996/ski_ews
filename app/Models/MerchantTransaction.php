<?php

namespace App\Models;
use CodeIgniter\Model;

class MerchantTransaction extends Model
{
    protected $table = 'ews_merchant_transaction';
    protected $primaryKey = 'merch_trans_id';
    
    protected $allowedFields = [
        'transaction_amt',
        'purchase_item_type',
        'purchase_item_name'
    ];
    
}
