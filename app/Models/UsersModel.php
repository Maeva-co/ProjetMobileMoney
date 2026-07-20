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
    
    public function getAllClients()
    {
        return $this->where('role', 'client')->findAll();
    }
    
    public function countAdmins()
    {
        return $this->where('role', 'admin')->countAllResults();
    }
    public function getAllAdmins()
    {
        return $this->where('role', 'admin')->findAll();
    }
    public function getUserByNumber($number)
    {
        return $this->where('number', $number)->first();
    }
    public function numberExists($number)
    {
        return $this->where('number', $number)->countAllResults() > 0;
    }
    
    public function createClient($number)
    {
        return $this->insert([
            'name' => null,
            'role' => 'client',
            'number' => $number
        ]);
    }
    
    public function countAllUsers()
    {
        return $this->countAllResults();
    }
    
    public function getUsersByRole($role)
    {
        return $this->where('role', $role)->findAll();
    }
    
    public function getStats()
    {
        return [
            'totalClients' => $this->countClients(),
            'totalAdmins' => $this->countAdmins(),
            'totalUsers' => $this->countAllUsers(),
            'recentClients' => $this->getRecentClients(5)
        ];
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