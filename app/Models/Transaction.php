<?php

namespace App\Models;
use CodeIgniter\Model;

class Transaction extends Model
{
    protected $table = 'ews_transaction';
    protected $primaryKey = 'transaction_id';
    
    protected $allowedFields = [
        'user_id',
        'pocket_id',
        'created_at',
        'updated_at',
        'merchant_name',
        'merchant_type',
        'transaction_amt',
        'purchase_item_type',
        'purchase_item_name'
    ];
    
}
