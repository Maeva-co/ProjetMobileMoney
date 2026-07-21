<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
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
    protected $useTimestamps = false;
    protected $createdField = 'transaction_date';
    
    // Nombre total de transactions
    public function countAllTransactions()
    {
        return $this->countAllResults();
    }
    
    // Revenu total (somme des montants)
    public function getTotalRevenue()
    {
        $result = $this->selectSum('amount')->get()->getRow();
        return $result->amount ?? 0;
    }
    
    // Commission totale (somme des frais)
    public function getTotalCommission()
    {
        $result = $this->selectSum('frais')->get()->getRow();
        return $result->frais ?? 0;
    }
    
    // Dernières transactions avec infos client
    public function getRecentTransactions($limit = 10)
    {
        return $this->select('transactions.*, users.number as client_number, users.name as client_name')
                    ->join('users', 'users.id = transactions.userId')
                    ->orderBy('transactions.id', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }
}