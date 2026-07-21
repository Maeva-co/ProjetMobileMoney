<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model 
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name',
        'role',
        'number',
        'operator_type_id'
    ];

    protected $validationRules = [
        'number' => [
            'label' => 'Numéro de téléphone',
            'rules' => 'required|regex_match[/^[0-9]{10}$/]'
        ]
    ];

    protected $validationMessages = [
        'number' => [
            'required'    => 'Veuillez entrer votre numéro.',
            'regex_match' => 'Le numéro doit contenir exactement 10 chiffres.'
        ]
    ];

    public function countClients()
    {
        return $this->where('role', 'client')->countAllResults();
    }
    
    public function getRecentClients($limit = 5)
    {
        return $this->where('role', 'client')
                    ->orderBy('id', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }
    
    public function countAdmins()
    {
        return $this->where('role', 'admin')->countAllResults();
    }
    public function isYas($number)
    {
        $indicator = substr($number, 0, 3);
        if ($indicator === '034') {
            return true;
        }
        return false;
    }
}