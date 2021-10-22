<?php

namespace App\Models;
use CodeIgniter\Model;

class SuperAdmin extends Model
{
    protected $table = 'ews_user';
    protected $primaryKey = 'user_id';
    
    protected $allowedFields = [
        'user_id',
        'name',
        'age',
        'card_number',
        'email',
        'password',
        'parent_code',
        'created_at'
    ];
    
}
