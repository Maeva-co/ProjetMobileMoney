<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TransactionTypesModel;

class TransactionTypesController extends BaseController
{
    public function index()
    {
        $model = new TransactionTypesModel();
        $data['types'] = $model->findAll();
        return view('admin/transaction_types/list', $data);
    }

    public function create()
    {
        return view('admin/transaction_types/create');
    }

    public function store()
    {
        $model = new TransactionTypesModel();
        
        $data = [
            'type' => $this->request->getPost('type')
        ];
        
        if ($model->insert($data)) {
            return redirect()->to('/admin/transaction-types')
                ->with('success', 'Type d\'opération ajouté avec succès');
        }
        
        return redirect()->back()
            ->withInput()
            ->with('errors', $model->errors());
    }

    public function edit($id)
    {
        $model = new TransactionTypesModel();
        $data['type'] = $model->find($id);
        return view('admin/transaction_types/edit', $data);
    }

    public function update($id)
    {
        $model = new TransactionTypesModel();
        
        $data = [
            'type' => $this->request->getPost('type')
        ];
        
        if ($model->update($id, $data)) {
            return redirect()->to('/admin/transaction-types')
                ->with('success', 'Type d\'opération modifié avec succès');
        }
        
        return redirect()->back()
            ->withInput()
            ->with('errors', $model->errors());
    }

    public function delete($id)
    {
        $model = new TransactionTypesModel();
        $model->delete($id);
        return redirect()->to('/admin/transaction-types')
            ->with('success', 'Type d\'opération supprimé avec succès');
    }
}