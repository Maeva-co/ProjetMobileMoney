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
    public function getSolde(int $userId): float {
        $result = $this->db->query("
            SELECT
                SUM(
                    CASE
                        WHEN type = 'credit' THEN amount
                        ELSE -amount
                    END
                ) AS solde
            FROM solde_mouvement
            WHERE userId = ?
        ", [$userId])->getRowArray();

        return $result['solde'] ?? 0;
    }
}
