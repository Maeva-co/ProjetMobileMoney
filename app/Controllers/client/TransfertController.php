<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\ConfigFraisModel;
use App\Models\OperatorTypesModel;
use App\Models\SoldeMouvementModel;
use App\Models\TransactionTypesModel;
use App\Models\TransactionsModel;
use App\Models\UsersModel;
use App\Models\GainsModel;

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

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $amount = $this->request->getPost('amount');
        $includeRetraitFee = $this->request->getPost('include_retrait_fee') ? true : false;

        $receiverNumber = $this->request->getPost('number');

        $operatorModel = new OperatorTypesModel();

        $senderOperator = $operatorModel
            ->where('type', substr(session()->get('number'), 0, 3))
            ->first();

        $receiverOperator = $operatorModel
            ->where('type', substr($receiverNumber, 0, 3))
            ->first();

        if (!$receiverOperator) {
            return redirect()->back()
                ->withInput()
                ->with('error', "Cet opérateur n'est pas pris en charge.");
        }

        $transactionType = (new TransactionTypesModel())
            ->where('type', 'transfert')
            ->first();

        $config = (new ConfigFraisModel())
            ->where('transaction_type_id', $transactionType['id'])
            ->where('operator_type_id', $senderOperator['id'])
            ->where('minAmount <=', $amount)
            ->where('maxAmount >=', $amount)
            ->where('isActive', 1)
            ->first();

        if (!$config) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Aucun frais configuré.');
        }

        $frais = $config['frais'];

        if ($senderOperator['id'] == $receiverOperator['id']) {
            return $this->transfertInterne(
                $receiverNumber,
                $amount,
                $frais,
                $senderOperator,
                $transactionType,
                $includeRetraitFee
            );
        }

        return $this->transfertInterOperateur(
            $receiverNumber,
            $amount,
            $frais,
            $senderOperator,
            $receiverOperator,
            $transactionType
        );
    }



    private function transfertInterne($receiverNumber, $amount, $frais, $operator, $transactionType, $includeRetraitFee) {

        $receiver = (new UsersModel())
            ->where('number', $receiverNumber)
            ->first();

        if (!$receiver) {
            return redirect()->back()
                ->withInput()
                ->with('error', "Le numéro entré n'est pas attribué.");
        }

        if ($receiver['id'] == session()->get('user_id')) {
            return redirect()->back()
                ->withInput()
                ->with('error', "Vous ne pouvez pas effectuer un transfert vers votre propre compte.");
        }

        $retraitFee = 0;
        if($includeRetraitFee){
            $retraitType = (new TransactionTypesModel())
                ->where('type','retrait')
                ->first();

            $configRetrait = (new ConfigFraisModel())
                ->where('transaction_type_id',$retraitType['id'])
                ->where('operator_type_id',$operator['id'])
                ->where('minAmount <=',$amount)
                ->where('maxAmount >=',$amount)
                ->where('isActive',1)
                ->first();

            if($configRetrait){
                $retraitFee = $configRetrait['frais'];
            }

        }

        $soldeModel = new SoldeMouvementModel();
        $solde = $soldeModel->getSolde(session()->get('user_id'));

        $total = $amount + $frais + $retraitFee;

        if ($total > $solde) {
            return redirect()->back()
                ->withInput()
                ->with('error', "Solde insuffisant pour ce montant et les frais engendrés.");
        }

        $db = \Config\Database::connect();

        $db->transStart();

        $transactionModel = new TransactionsModel();

        $transactionModel->insert([
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

        if ($includeRetraitFee) {
            $soldeModel->insert([
                'userId' => session()->get('user_id'),
                'type' => 'debit',
                'amount' => $retraitFee
            ]);
        }

        $montantReceiver = $amount;
        if ($includeRetraitFee) {
            $montantReceiver += $retraitFee;
        }

        $soldeModel->insert([
            'userId' => $receiver['id'],
            'type' => 'credit',
            'amount' => $montantReceiver
        ]);


        $db->transComplete();

        if (!$db->transStatus()) {
            return redirect()->back()
                ->withInput()
                ->with('error', "Une erreur est survenue.");
        }

        return redirect()->to('/client/solde')
            ->with('success', 'Transfert effectué avec succès.');
    }


    private function transfertInterOperateur($receiverNumber, $amount, $frais, $senderOperator, $receiverOperator, $transactionType) {

        $commission = ($amount * $receiverOperator['commission']) / 100;
        $gainAutreOperateur = $amount + $commission;

        $soldeModel = new SoldeMouvementModel();
        $solde = $soldeModel->getSolde(session()->get('user_id'));
        if (($amount + $frais) > $solde) {
            return redirect()->back()
                ->withInput()
                ->with('error', "Solde insuffisant pour ce montant et les frais engendrés.");
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $transactionModel = new TransactionsModel();

        $transactionModel->insert([
            'userId' => session()->get('user_id'),
            'operator_type_id' => $senderOperator['id'],
            'transaction_type_id' => $transactionType['id'],
            'amount' => $amount,
            'frais' => $frais,
            'idUserReceiver' => null
        ]);

        $transactionId = $transactionModel->getInsertID();


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

        $gainModel = new GainsModel();

        $gainModel->insert([
            'transaction_id' => $transactionId,
            'operator_type_id' => $receiverOperator['id'],
            'amount' => $gainAutreOperateur
        ]);

        $gainModel->insert([
            'transaction_id' => $transactionId,
            'operator_type_id' => $senderOperator['id'],
            'amount' => $frais
        ]);

        $db->transComplete();

        if (!$db->transStatus()) {
            return redirect()->back()
                ->withInput()
                ->with('error', "Une erreur est survenue.");
        }

        return redirect()->to('/client/solde')
            ->with('success', 'Transfert inter-opérateur effectué avec succès.');
    }


}
