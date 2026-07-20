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

    public function getGainsTotalByOperator($operatorId)
    {
        return $this->select('
                operator_type_id,
                COUNT(*) as transaction_count,
                SUM(amount) as total_gains
            ')
            ->where('operator_type_id', $operatorId)
            ->groupBy('operator_type_id')
            ->first();
    }
    public function getGainsTotalOtherOperators($excludedOperatorId)
    {
        return $this->select('
                operator_type_id,
                COUNT(*) as transaction_count,
                SUM(amount) as total_gains
            ')
            ->where('operator_type_id !=', $excludedOperatorId)
            ->groupBy('operator_type_id')
            ->findAll();
    }
}
