<?php

namespace App\Models;

use CodeIgniter\Model;

class SoldeMouvementModel extends Model
{
    protected $table = 'solde_mouvement';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'userId',
        'type',
        'amount',
        'movement_date'
    ];

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
