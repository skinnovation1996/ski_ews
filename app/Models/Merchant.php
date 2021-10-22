<?php

namespace App\Models;
use CodeIgniter\Model;

class Merchant extends Model
{
    protected $table = 'ews_merchant';
    protected $primaryKey = 'merchant_id';
    
    protected $allowedFields = [
        'merchant_id',
        'name',
        'type',
        'account_num',
        'email',
        'password'
    ];
    
}
