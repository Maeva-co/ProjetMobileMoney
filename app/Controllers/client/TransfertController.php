<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\ConfigFraisModel;
use App\Models\OperatorTypesModel;
use App\Models\SoldeMouvementModel;
use App\Models\TransactionTypesModel;
use App\Models\TransactionsModel;
use App\Models\UsersModel;

class TransfertController extends BaseController {

    public function index() {
        return view('client/transfert');
    }


    public function store() {
        $rules = [
            'number' => [
                'label' => 'Numéro',
                'rules' => 'required|regex_match[/^[0-9]{10}$/]',
                'errors' => [
                    'required' => 'Veuillez entrer un numéro.',
                    'regex_match' => 'Le numéro doit contenir exactement 10 chiffres.'
                ]
            ],
            'amount' => [
                'label' => 'Montant',
                'rules' => 'required|numeric|greater_than[0]',
                'errors' => [
                    'required' => 'Veuillez entrer un montant.',
                    'numeric' => 'Le montant doit être un nombre.',
                    'greater_than' => 'Le montant doit être supérieur à 0.'
                ]
            ]
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $userModel = new UsersModel();

        $receiver = $userModel
            ->where('number', $this->request->getPost('number'))
            ->first();

        if (! $receiver) {
            return redirect()->back()
                ->withInput()
                ->with('error', "Le numéro entré n'est pas attribué.");
        }

        if ($receiver['id'] == session()->get('user_id')) {
            return redirect()->back()
                ->withInput()
                ->with('error', "Vous ne pouvez pas effectuer un transfert vers votre propre compte.");
        }

        $operatorModel = new OperatorTypesModel();

        $prefix = substr(session()->get('number'), 0, 3);

        $operator = $operatorModel
            ->where('type', $prefix)
            ->first();

        $transactionType = (new TransactionTypesModel())
            ->where('type', 'transfert')
            ->first();

        $amount = $this->request->getPost('amount');

        $config = (new ConfigFraisModel())
            ->where('transaction_type_id', $transactionType['id'])
            ->where('operator_type_id', $operator['id'])
            ->where('minAmount <=', $amount)
            ->where('maxAmount >=', $amount)
            ->where('isActive', 1)
            ->first();

        if (! $config) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Aucun frais configuré pour ce montant.');
        }

        $frais = $config['frais'];

        $soldeModel = new SoldeMouvementModel();

        $solde = $soldeModel->getSolde(session()->get('user_id'));

        if (($amount + $frais) > $solde) {
            return redirect()->back()
                ->withInput()
                ->with('error', "Solde insuffisant pour ce montant et les frais engendrés.");
        }

        $db = \Config\Database::connect();

        $db->transStart();

        (new TransactionsModel())->insert([
            'userId' => session()->get('user_id'),
            'operator_type_id' => $operator['id'],
            'transaction_type_id' => $transactionType['id'],
            'amount' => $amount,
            'frais' => $frais,
            'idUserReceiver' => $receiver['id']
        ]);

        $soldeModel->insert([
            'userId' => session()->get('user_id'),
            'type' => 'debit',
            'amount' => $amount
        ]);

        $soldeModel->insert([
            'userId' => session()->get('user_id'),
            'type' => 'debit',
            'amount' => $frais
        ]);

        $soldeModel->insert([
            'userId' => $receiver['id'],
            'type' => 'credit',
            'amount' => $amount
        ]);

        $db->transComplete();

        if (! $db->transStatus()) {
            return redirect()->back()
                ->withInput()
                ->with('error', "Une erreur est survenue lors du transfert.");
        }

        return redirect()->to('/client/solde')
            ->with('success', 'Transfert effectué avec succès.');
    }
    
}
