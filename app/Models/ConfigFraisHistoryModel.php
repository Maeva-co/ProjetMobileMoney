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
    
    // Historique d'une configuration
    public function getHistoryByConfig($configId)
    {
        return $this->where('idConfigFrais', $configId)
                    ->orderBy('change_date', 'DESC')
                    ->findAll();
    }
    
    // Historique avec détails utilisateur
    public function getHistoryWithUser()
    {
        return $this->select('
                config_frais_history.*,
                users.name as user_name,
                users.number as user_number
            ')
            ->join('users', 'users.id = config_frais_history.created_by')
            ->orderBy('change_date', 'DESC')
            ->findAll();
    }
    
    // Dernières modifications
    public function getRecentChanges($limit = 10)
    {
        return $this->select('
                config_frais_history.*,
                users.name as user_name,
                transaction_types.type as transaction_type,
                oprator_types.name as operator_name
            ')
            ->join('users', 'users.id = config_frais_history.created_by')
            ->join('transaction_types', 'transaction_types.id = config_frais_history.transaction_type_id')
            ->join('oprator_types', 'oprator_types.id = config_frais_history.operator_type_id')
            ->orderBy('change_date', 'DESC')
            ->limit($limit)
            ->findAll();
    }
    
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
}