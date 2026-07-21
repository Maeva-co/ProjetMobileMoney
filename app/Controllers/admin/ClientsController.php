<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UsersModel;
use App\Models\TransactionModel;
use App\Models\SoldeMouvementModel;

class ClientsController extends BaseController
{
    public function index()
    {
        $userModel = new UsersModel();
        $soldeModel = new SoldeMouvementModel();
        
        // Récupérer tous les clients
        $clients = $userModel->where('role', 'client')->findAll();
        
        // Ajouter le solde pour chaque client
        foreach ($clients as &$client) {
            $client['solde'] = $soldeModel->getBalance($client['id']);
        }
        
        $data = [
            'clients' => $clients,
            'totalClients' => count($clients)
        ];
        
        return view('admin/clients/list', $data);
    }

    public function show($id)
    {
        $userModel = new UsersModel();
        $transactionModel = new TransactionModel();
        $soldeModel = new SoldeMouvementModel();
        
        // Récupérer le client
        $client = $userModel->find($id);
        
        if (!$client || $client['role'] != 'client') {
            return redirect()->to('/admin/clients')->with('error', 'Client non trouvé');
        }
        
        // Solde du client
        $solde = $soldeModel->getBalance($id);
        
        // Transactions du client
        $transactions = $transactionModel
            ->select('
                transactions.*,
                transaction_types.type as transaction_type_name,
                operator_types.name as operator_name
            ')
            ->join('transaction_types', 'transaction_types.id = transactions.transaction_type_id')
            ->join('operator_types', 'operator_types.id = transactions.operator_type_id')
            ->where('transactions.userId', $id)
            ->orderBy('transactions.id', 'DESC')
            ->findAll();
        
        // Mouvements de solde
        $movements = $soldeModel
            ->where('userId', $id)
            ->orderBy('movement_date', 'DESC')
            ->findAll();
        
        $data = [
            'client' => $client,
            'solde' => $solde,
            'transactions' => $transactions,
            'movements' => $movements,
            'totalTransactions' => count($transactions)
        ];
        
        return view('admin/clients/show', $data);
    }
}