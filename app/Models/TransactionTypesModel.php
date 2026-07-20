<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionTypesModel extends Model
{
    protected $table = 'transaction_types';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'type'
    ];
}
