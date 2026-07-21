<?php

namespace App\Models;

use CodeIgniter\Model;

class ConfigFraisModel extends Model
{
    protected $table = 'config_frais';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'minAmount',
        'maxAmount',
        'transaction_type_id',
        'operator_type_id',
        'frais',
        'isActive'
    ];
    protected $useTimestamps = false;

    // Configuration active
    public function getActiveGainsWithOperator()
    {
        return $this->select('
            config_frais.*,
            operator_types.name as operator_name
        ')
            ->join('operator_types', 'operator_types.id = config_frais.operator_type_id', 'left')
            ->where('config_frais.isActive', 1)
            ->findAll();
    }

    public function getConfigWithDetails()
    {
        return $this->select('
                config_frais.*,
                operator_types.name as operator_name,
                transaction_types.type as transaction_type
            ')
            ->join('operator_types', 'operator_types.id = config_frais.operator_type_id')
            ->join('transaction_types', 'transaction_types.id = config_frais.transaction_type_id')
            ->where('config_frais.isActive', 1)
            ->findAll();
    }
}
