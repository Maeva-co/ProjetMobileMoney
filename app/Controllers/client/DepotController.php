<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\TransactionsModel;
use App\Models\TransactionTypeModel;
use App\Models\OperatorTypesModel;
use App\Models\SoldeMouvementModel;


class DepotController extends BaseController {

    public function index() {
        return view('client/depot');
    }


    public function store()
    {
        $rules = [
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

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $userId = session()->get('user_id');
        $amount = $this->request->getPost('amount');

        // Récupération de l'opérateur

        $operatorModel = new OperatorTypesModel();
        $number = session()->get('number');
        $prefix = substr($number,0,3);

        $operator = $operatorModel
            ->where('type',$prefix)
            ->first();

        if (!$operator) {
            return redirect()->back()
                ->with('error',
                "Opérateur non reconnu.");
        }

        // Type transaction : depot
        $transactionTypeModel = new TransactionTypeModel();
        $transactionType = $transactionTypeModel
            ->where('type','Deposit')
            ->first();

        if (!$transactionType) {

            return redirect()->back()
                ->with('error',
                "Type de transaction introuvable.");
        }

        // Insertion transaction

        $transactionModel = new TransactionsModel();
        $transactionModel->insert([
            'userId' => $userId,
            'operator_type_id' => $operator['id'],
            'transaction_type_id' => $transactionType['id'],
            'amount' => $amount,
            'idUserReceiver' => null
        ]);

        // Mise à jour solde
        $soldeModel = new SoldeMouvementModel();
        $soldeModel->insert([
            'userId' => $userId,
            'type' => 'credit',
            'amount' => $amount
        ]);

        return redirect()
            ->to('/client/solde')
            ->with('success',
            'Dépôt effectué avec succès.');

    }

}
