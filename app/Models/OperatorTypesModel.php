<?php

namespace App\Models;

use CodeIgniter\Model;

class OperatorTypesModel extends Model
{
    protected $table = 'operator_types';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'type', 'commission'];
    protected $useTimestamps = false;
}