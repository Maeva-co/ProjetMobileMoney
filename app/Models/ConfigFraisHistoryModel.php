<?php

namespace App\Models;

use CodeIgniter\Model;

class ConfigFraisHistoryModel extends Model
{
    protected $table = 'config_frais_history';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'idConfigFrais',
        'minAmount',
        'maxAmount',
        'transaction_type_id',
        'operator_type_id',
        'frais',
        'isActive',
        'change_date',
        'created_by',
        'action'
    ];
    protected $useTimestamps = false;
    protected $createdField = 'change_date';
    
    // Enregistrer une action CREATE
    public function logCreate($configId, $data, $userId)
    {
        $data['idConfigFrais'] = $configId;
        $data['created_by'] = $userId;
        $data['action'] = 'CREATE';
        return $this->insert($data);
    }
    
    // Enregistrer une action UPDATE
    public function logUpdate($configId, $data, $userId)
    {
        $data['idConfigFrais'] = $configId;
        $data['created_by'] = $userId;
        $data['action'] = 'UPDATE';
        return $this->insert($data);
    }
    
    // Enregistrer une action DELETE
    public function logDelete($configId, $data, $userId)
    {
        $data['idConfigFrais'] = $configId;
        $data['created_by'] = $userId;
        $data['action'] = 'DELETE';
        return $this->insert($data);
    }

    public function getHistoryWithDetails()
    {
        return $this->select('
                config_frais_history.*,
                users.name as user_name,
                operator_types.name as operator_name,
                transaction_types.type as transaction_type
            ')
            ->join('users', 'users.id = config_frais_history.created_by')
            ->join('operator_types', 'operator_types.id = config_frais_history.operator_type_id')
            ->join('transaction_types', 'transaction_types.id = config_frais_history.transaction_type_id')
            ->orderBy('change_date', 'DESC')
            ->findAll();
    }
}