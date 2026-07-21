<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionTypeModel extends Model
{
    protected $table = 'transaction_types';
    protected $primaryKey = 'id';
    protected $allowedFields = ['type', 'promotion'];
    protected $useTimestamps = false;
}