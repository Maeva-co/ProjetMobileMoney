<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ConfigFraisModel;
use App\Models\ConfigFraisHistoryModel;
use App\Models\OperatorTypesModel;
use App\Models\TransactionTypesModel;

class ConfigController extends BaseController
{
    public function index()
    {
        $configModel = new ConfigFraisModel();
        $operatorModel = new OperatorTypesModel();
        $typeModel = new TransactionTypesModel();
        
        $data = [
            'configs' => $configModel->getConfigWithDetails(),
            'operators' => $operatorModel->findAll(),
            'types' => $typeModel->findAll()
        ];
        
        return view('admin/config/list', $data);
    }

    public function create()
    {
        $operatorModel = new OperatorTypesModel();
        $typeModel = new TransactionTypesModel();
        
        $data = [
            'operators' => $operatorModel->findAll(),
            'types' => $typeModel->findAll()
        ];
        
        return view('admin/config/create', $data);
    }

    public function store()
    {
        $configModel = new ConfigFraisModel();
        $historyModel = new ConfigFraisHistoryModel();
        $userId = session()->get('user_id');
        
        $data = [
            'minAmount' => $this->request->getPost('minAmount'),
            'maxAmount' => $this->request->getPost('maxAmount'),
            'transaction_type_id' => $this->request->getPost('transaction_type_id'),
            'operator_type_id' => $this->request->getPost('operator_type_id'),
            'frais' => $this->request->getPost('frais'),
            'isActive' => 1
        ];
        
        $configId = $configModel->insert($data);
        
        if ($configId) {
            $historyModel->logCreate($configId, $data, $userId);
            return redirect()->to('/admin/config')->with('success', 'Configuration ajoutée');
        }
        
        return redirect()->back()->withInput()->with('error', 'Erreur lors de l\'ajout');
    }

    public function edit($id)
    {
        $configModel = new ConfigFraisModel();
        $operatorModel = new OperatorTypesModel();
        $typeModel = new TransactionTypesModel();
        
        $data = [
            'config' => $configModel->find($id),
            'operators' => $operatorModel->findAll(),
            'types' => $typeModel->findAll()
        ];
        
        return view('admin/config/edit', $data);
    }

    public function update($id)
    {
        $configModel = new ConfigFraisModel();
        $historyModel = new ConfigFraisHistoryModel();
        $userId = session()->get('id');
        
        $oldConfig = $configModel->find($id);
        
        if (!$oldConfig) {
            return redirect()->to('/admin/config')->with('error', 'Configuration non trouvée');
        }
        
        // Désactiver l'ancienne
        $configModel->update($id, ['isActive' => 0]);
        $historyModel->logUpdate($id, $oldConfig, $userId);
        
        // Créer la nouvelle
        $newData = [
            'minAmount' => $this->request->getPost('minAmount'),
            'maxAmount' => $this->request->getPost('maxAmount'),
            'transaction_type_id' => $this->request->getPost('transaction_type_id'),
            'operator_type_id' => $this->request->getPost('operator_type_id'),
            'frais' => $this->request->getPost('frais'),
            'isActive' => 1
        ];
        
        $newId = $configModel->insert($newData);
        $historyModel->logCreate($newId, $newData, $userId);
        
        return redirect()->to('/admin/config')->with('success', 'Configuration mise à jour');
    }

    public function delete($id)
    {
        $configModel = new ConfigFraisModel();
        $historyModel = new ConfigFraisHistoryModel();
        $userId = session()->get('id');
        
        $config = $configModel->find($id);
        
        if (!$config) {
            return redirect()->to('/admin/config')->with('error', 'Configuration non trouvée');
        }
        
        $historyModel->logDelete($id, $config, $userId);
        $configModel->update($id, ['isActive' => 0]);
        
        return redirect()->to('/admin/config')->with('success', 'Configuration désactivée');
    }

    public function history()
    {
        $historyModel = new ConfigFraisHistoryModel();
        $data['history'] = $historyModel->getHistoryWithDetails();
        return view('admin/config/history', $data);
    }
}