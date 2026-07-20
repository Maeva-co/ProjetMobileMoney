<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OperatorTypesModel;

class OperatorsController extends BaseController
{
    public function index()
    {
        $model = new OperatorTypesModel();
        $data['operators'] = $model->findAll();
        return view('admin/operators/list', $data);
    }

    public function create()
    {
        return view('admin/operators/create');
    }

    public function store()
    {
        $model = new OperatorTypesModel();
        
        $data = [
            'name' => $this->request->getPost('name'),
            'type' => $this->request->getPost('type')
        ];
        
        if ($model->insert($data)) {
            return redirect()->to('/admin/operators')->with('success', 'Opérateur ajouté avec succès');
        }
        
        return redirect()->back()->with('errors', $model->errors());
    }

    public function edit($id)
    {
        $model = new OperatorTypesModel();
        $data['operator'] = $model->find($id);
        return view('admin/operators/edit', $data);
    }

    public function update($id)
    {
        $model = new OperatorTypesModel();
        
        $data = [
            'name' => $this->request->getPost('name'),
            'type' => $this->request->getPost('type')
        ];
        
        if ($model->update($id, $data)) {
            return redirect()->to('/admin/operators')->with('success', 'Opérateur modifié avec succès');
        }
        
        return redirect()->back()->with('errors', $model->errors());
    }

    public function delete($id)
    {
        $model = new OperatorTypesModel();
        $model->delete($id);
        return redirect()->to('/admin/operators')->with('success', 'Opérateur supprimé avec succès');
    }
}