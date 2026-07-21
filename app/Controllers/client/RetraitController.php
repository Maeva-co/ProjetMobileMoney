<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;

use App\Models\TransactionsModel;
use App\Models\TransactionTypesModel;
use App\Models\OperatorTypesModel;
use App\Models\ConfigFraisModel;
use App\Models\SoldeMouvementModel;
use App\Models\GainsModel;


class RetraitController extends BaseController {

    public function index() {
        return view('client/retrait');
    }


    public function store() {
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

        // Récupération opérateur
        $operatorModel = new OperatorTypesModel();


        $prefix = substr(
            session()->get('number'),
            0,
            3
        );

        $operator = $operatorModel
            ->where('type', $prefix)
            ->first();

        if (!$operator) {
            return redirect()->back()
                ->with('error',
                "Opérateur non supporté.");
        }

        // Type transaction retrait         
        $transactionTypeModel = new TransactionTypesModel();

        $type = $transactionTypeModel
            ->where('type', 'retrait')
            ->first();

        if (!$type) {
            return redirect()->back()
                ->with('error',
                "Type de transaction introuvable.");
        }

        // Recherche du frais
        $fraisModel = new ConfigFraisModel();

        $configFrais = $fraisModel
            ->where('transaction_type_id', $type['id'])
            ->where('operator_type_id', $operator['id'])
            ->where('minAmount <=', $amount)
            ->where('maxAmount >=', $amount)
            ->where('isActive', 1)
            ->first();

        if (!$configFrais) {
            return redirect()->back()
                ->with('error',
                "Aucun frais configuré pour ce montant.");
        }
        $frais = $configFrais['frais'];
        $totalDebit = $amount + $frais;

        // Vérification solde
        $soldeModel = new SoldeMouvementModel();
        $solde = $soldeModel->getSolde($userId);
        if ($totalDebit > $solde) {
            return redirect()->back()
                ->with('error',
                "Solde insuffisant pour ce montant et les frais engendrés.");
        }

        $db = \Config\Database::connect();
        $db->transStart();
        // Insertion transaction
        $transactionModel = new TransactionsModel();

        $transactionModel->insert([
            'userId' => $userId,
            'operator_type_id' => $operator['id'],
            'transaction_type_id' => $type['id'],
            'amount' => $amount,
            'frais' => $frais,
            'idUserReceiver' => null
        ]);
        
        // Mouvement montant retrait
        $soldeModel->insert([
            'userId' => $userId,
            'type' => 'debit',
            'amount' => $amount
        ]);

        // Mouvement frais
        $soldeModel->insert([
            'userId' => $userId,
            'type' => 'debit',
            'amount' => $frais
        ]);

        $transactionId = $transactionModel->getInsertID();
        $gainModel = new GainsModel();
        $gainModel->insert([
            'transaction_id' => $transactionId,
            'operator_type_id' => $operator['id'],
            'amount' => $frais
        ]);

        $db->transComplete();

        if (!$db->transStatus()) {
            return redirect()->back()
                ->withInput()
                ->with('error', "Une erreur est survenue.");
        }

        return redirect()
            ->to('/client/solde')
            ->with(
                'success',
                'Retrait effectué avec succès.'
            );

    }

}
