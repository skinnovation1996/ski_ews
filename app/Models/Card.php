<?php

namespace App\Models;
use CodeIgniter\Model;

class Card extends Model
{
    protected $table = 'ews_cards';
    protected $primaryKey = 'card_id';
    
    protected $allowedFields = [
        'user_id',
        'card_num',
        'type',
        'cvv',
        'expiry_date',
        'primary_card'
    ];
    
}
