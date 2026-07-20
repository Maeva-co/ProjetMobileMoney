<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model {
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name',
        'role',
        'number'
    ];

    protected $validationRules = [
        'number' => [
            'label' => 'Numéro de téléphone',
            'rules' => 'required|regex_match[/^[0-9]{9}$/]'
        ]
    ];

    protected $validationMessages = [
        'number' => [
            'required'    => 'Veuillez entrer votre numéro.',
            'regex_match' => 'Le numéro doit contenir exactement 9 chiffres.'
        ]
    ];

}