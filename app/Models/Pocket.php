<?php

namespace App\Models;
use CodeIgniter\Model;

class Pocket extends Model
{
    protected $table = 'ews_pocket';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
        'pocket_id',
        'user_id',
        'budget_amt',
        'total_spent_amt',
        'merchant_type',
        'purchase_item_type',
        'purchase_item_name'
    ];
    
}
