<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionTypeModel extends Model
{
    protected $table = 'transaction_types';
    protected $primaryKey = 'id';
    protected $allowedFields = ['type'];
    protected $useTimestamps = false;
    
    public function getTypeByName($name)
    {
        return $this->where('type', $name)->first();
    }
    
    public function getAllTypes()
    {
        return $this->findAll();
    }
    
    public function getTypeIdByName($name)
    {
        $type = $this->where('type', $name)->first();
        return $type ? $type['id'] : null;
    }
}