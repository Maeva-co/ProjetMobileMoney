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
    public function getActiveConfigs()
    {
        return $this->where('isActive', 1)->findAll();
    }

        public function getConfigWithDetails()
    {
        return $this->select('
                config_frais.*,
                oprator_types.name as operator_name,
                transaction_types.type as transaction_type
            ')
            ->join('oprator_types', 'oprator_types.id = config_frais.operator_type_id')
            ->join('transaction_types', 'transaction_types.id = config_frais.transaction_type_id')
            ->where('config_frais.isActive', 1)
            ->findAll();
    }
    
    // Configuration par opérateur et type
    public function getConfigByOperatorAndType($operatorId, $typeId)
    {
        return $this->where('operator_type_id', $operatorId)
                    ->where('transaction_type_id', $typeId)
                    ->where('isActive', 1)
                    ->orderBy('minAmount', 'ASC')
                    ->findAll();
    }
    
    // Trouver les frais pour un montant donné
    public function getFrais($operatorId, $typeId, $amount)
    {
        $config = $this->where('operator_type_id', $operatorId)
                       ->where('transaction_type_id', $typeId)
                       ->where('minAmount <=', $amount)
                       ->where('maxAmount >=', $amount)
                       ->where('isActive', 1)
                       ->first();
        
        return $config ? $config['frais'] : 0;
    }
    
    // Désactiver toutes les configurations
    public function deactivateAll()
    {
        return $this->set('isActive', 0)->update();
    }
    
    // Activer une configuration
    public function activate($id)
    {
        return $this->update($id, ['isActive' => 1]);
    }
}