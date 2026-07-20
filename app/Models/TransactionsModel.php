<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionsModel extends Model
{
    protected $table = 'transactions';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'userId',
        'operator_type_id',
        'transaction_type_id',
        'amount',
        'idUserReceiver',
        'transaction_date'
    ];

}
