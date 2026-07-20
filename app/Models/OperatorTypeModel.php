<?php

namespace App\Models;

use CodeIgniter\Model;

class OperatorTypesModel extends Model
{
    protected $table = 'oprator_types';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'name',
        'type'
    ];
}
