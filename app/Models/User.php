<?php

namespace App\Models;
use CodeIgniter\Model;

class User extends Model
{
    protected $table = 'ews_user';
    protected $primaryKey = 'user_id';
    
    protected $allowedFields = [
        'user_id',
        'name',
        'card_number',
        'age',
        'email',
        'password',
        'parent_code'
    ];
    
}
