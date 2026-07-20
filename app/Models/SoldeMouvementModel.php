<?php

namespace App\Models;

use CodeIgniter\Model;

class SoldeMouvementModel extends Model
{
    protected $table = 'solde_mouvement';
    protected $primaryKey = 'id';
    protected $allowedFields = ['userId', 'type', 'amount', 'movement_date'];
    protected $useTimestamps = false;
    protected $createdField = 'movement_date';
    
    public function credit($userId, $amount)
    {
        return $this->insert([
            'userId' => $userId,
            'type' => 'credit',
            'amount' => $amount
        ]);
    }
    
    public function debit($userId, $amount)
    {
        return $this->insert([
            'userId' => $userId,
            'type' => 'debit',
            'amount' => $amount
        ]);
    }
    
    public function getBalance($userId)
    {
        $credits = $this->where('userId', $userId)
                        ->where('type', 'credit')
                        ->selectSum('amount')
                        ->get()
                        ->getRow()
                        ->amount ?? 0;
        
        $debits = $this->where('userId', $userId)
                       ->where('type', 'debit')
                       ->selectSum('amount')
                       ->get()
                       ->getRow()
                       ->amount ?? 0;
        
        return $credits - $debits;
    }
    
    public function getUserMovements($userId)
    {
        return $this->where('userId', $userId)
                    ->orderBy('movement_date', 'DESC')
                    ->findAll();
    }
}