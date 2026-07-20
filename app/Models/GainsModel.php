<?php

namespace App\Models;

use CodeIgniter\Model;

class GainsModel extends Model
{
    protected $table = 'gains';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'transaction_id',
        'operator_type_id',
        'amount',
        'date'
    ];
}
