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
        'frais',
        'idUserReceiver',
        'transaction_date'
    ];


    public function getHistorique(int $userId) {
        return $this->select("
                transactions.*,
                transaction_types.type AS transaction_type,
                oprator_types.name AS operator_name,
                users.name AS receiver_name,
                users.number AS receiver_number
            ")
            ->join(
                'transaction_types',
                'transaction_types.id = transactions.transaction_type_id'
            )
            ->join(
                'oprator_types',
                'oprator_types.id = transactions.operator_type_id'
            )
            ->join(
                'users',
                'users.id = transactions.idUserReceiver',
                'left'
            )
            ->where('transactions.userId', $userId)
            ->orderBy('transaction_date', 'DESC')
            ->findAll();
    }


}
