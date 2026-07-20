<?php

namespace App\Models;

use CodeIgniter\Model;

class OperatorTypesModel extends Model
{
    protected $table = 'oprator_types';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'type'];
    protected $useTimestamps = false;
    
    public function getOperatorByType($type)
    {
        return $this->where('type', $type)->first();
    }
    public function getAllOperators()
    {
        return $this->findAll();
    }
    public function getOperatorIdByType($type)
    {
        $operator = $this->where('type', $type)->first();
        return $operator ? $operator['id'] : null;
    }
}