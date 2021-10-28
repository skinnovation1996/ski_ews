<?php

namespace App\Models;
use CodeIgniter\Model;

class Wallet extends Model
{
    protected $table = 'ews_wallet';
    protected $primaryKey = 'wallet_id';
    
    protected $allowedFields = [
        'wallet_id',
        'user_id',
        'num_of_pockets',
        'total_amt'
    ];
    
}
