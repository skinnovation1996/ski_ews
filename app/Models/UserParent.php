<?php

namespace App\Models;
use CodeIgniter\Model;

class UserParent extends Model
{
    protected $table = 'ews_parent';
    
    protected $allowedFields = [
        'parent_id',
        'name',
        'user_id',
        'card_number',
        'email',
        'password'
    ];
    
}
