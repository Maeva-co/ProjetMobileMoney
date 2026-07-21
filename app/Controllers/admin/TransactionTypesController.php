<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TransactionTypeModel;

class TransactionTypesController extends BaseController
{
    public function index()
    {
        $model = new TransactionTypeModel();
        $data['types'] = $model->findAll();
        return view('admin/transaction_types/list', $data);
    }

    public function create()
    {
        return view('admin/transaction_types/create');
    }

    public function store()
    {
        $model = new TransactionTypeModel();
        
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
        $model = new TransactionTypeModel();
        $data['type'] = $model->find($id);
        return view('admin/transaction_types/edit', $data);
    }

    public function update($id)
    {
        $model = new TransactionTypeModel();
        
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
        $model = new TransactionTypeModel();
        $model->delete($id);
        return redirect()->to('/admin/transaction-types')
            ->with('success', 'Type d\'opération supprimé avec succès');
    }

    public function updateTransfert() {
        $number = $this->request->getPost('number');

        $model = new TransactionTypeModel();
        $transactionType = $model->where('type', 'Transfer')->first();
        if ($transactionType['promotion'] != $number) {
            $model->update();
        }
    }
}