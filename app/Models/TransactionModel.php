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
    
    // Transactions du jour
    public function countTodayTransactions()
    {
        return $this->where('DATE(transaction_date)', date('Y-m-d'))
                    ->countAllResults();
    }
    
    // Transactions du mois
    public function countMonthTransactions()
    {
        return $this->where('transaction_date >=', date('Y-m-01'))
                    ->countAllResults();
    }
    
    // Revenu total (somme des montants)
    public function getTotalRevenue()
    {
        $result = $this->selectSum('amount')->get()->getRow();
        return $result->amount ?? 0;
    }
    
    // Revenu du jour
    public function getTodayRevenue()
    {
        $result = $this->where('DATE(transaction_date)', date('Y-m-d'))
                       ->selectSum('amount')
                       ->get()
                       ->getRow();
        return $result->amount ?? 0;
    }
    
    // Revenu du mois
    public function getMonthRevenue()
    {
        $result = $this->where('transaction_date >=', date('Y-m-01'))
                       ->selectSum('amount')
                       ->get()
                       ->getRow();
        return $result->amount ?? 0;
    }
    
    // Commission totale (somme des frais)
    public function getTotalCommission()
    {
        $result = $this->selectSum('frais')->get()->getRow();
        return $result->frais ?? 0;
    }
    
    // Commission du jour
    public function getTodayCommission()
    {
        $result = $this->where('DATE(transaction_date)', date('Y-m-d'))
                       ->selectSum('frais')
                       ->get()
                       ->getRow();
        return $result->frais ?? 0;
    }
    
    // Commission du mois
    public function getMonthCommission()
    {
        $result = $this->where('transaction_date >=', date('Y-m-01'))
                       ->selectSum('frais')
                       ->get()
                       ->getRow();
        return $result->frais ?? 0;
    }
    
    // Montant moyen par transaction
    public function getAverageAmount()
    {
        $total = $this->getTotalRevenue();
        $count = $this->countAllTransactions();
        return $count > 0 ? $total / $count : 0;
    }
    
    // Commission moyenne par transaction
    public function getAverageCommission()
    {
        $total = $this->getTotalCommission();
        $count = $this->countAllTransactions();
        return $count > 0 ? $total / $count : 0;
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
    
    // Statistiques par type de transaction
    public function getStatsByType()
    {
        return $this->select('
                transaction_type_id,
                COUNT(*) as count,
                SUM(amount) as total_amount,
                SUM(frais) as total_fees
            ')
            ->groupBy('transaction_type_id')
            ->findAll();
    }
    
    // Statistiques par opérateur
    public function getStatsByOperator()
    {
        return $this->select('
                operator_type_id,
                COUNT(*) as count,
                SUM(amount) as total_amount,
                SUM(frais) as total_fees
            ')
            ->groupBy('operator_type_id')
            ->findAll();
    }
    
    // Transactions d'un utilisateur
    public function getUserTransactions($userId)
    {
        return $this->where('userId', $userId)
                    ->orderBy('id', 'DESC')
                    ->findAll();
    }
    
    // Transactions d'un utilisateur avec détails
    public function getUserTransactionsWithDetails($userId)
    {
        return $this->select('
                transactions.*,
                users.number as client_number,
                users.name as client_name,
                transaction_types.type as transaction_type_name,
                operator_types.name as operator_name
            ')
            ->join('users', 'users.id = transactions.userId')
            ->join('transaction_types', 'transaction_types.id = transactions.transaction_type_id')
            ->join('oprator_types', 'oprator_types.id = transactions.operator_type_id')
            ->where('transactions.userId', $userId)
            ->orderBy('transactions.id', 'DESC')
            ->findAll();
    }
}