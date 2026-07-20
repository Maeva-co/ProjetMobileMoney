<?php

namespace App\Controllers;
use App\Models\UsersModel;
use App\Models\OperatorTypesModel;


class UsersController extends BaseController {

    public function index() {
        return view('login');
    }


    public function login() {
        $usersModel = new UsersModel();
        $data = [
            'number' => $this->request->getPost('number')
        ];
        if (!$userModel->validate($data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $userModel->errors());
        }

        $operatorModel = new OperatorTypesModel();
        $prefix = substr($data['number'], 0, 3);
        $operator = $operatorModel
            ->where('type', $prefix)
            ->first();

        if (!$operator) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Cet opérateur téléphonique n\'est pas pris en charge.');
        }

        $number = $data['number'];
        $user = $userModel
            ->where('number', $number)
            ->first();

        if (!$user) {
            $userModel->insert([
                'name'   => null,
                'role'   => 'client',
                'number' => $number
            ]);

            $user = $userModel
                ->where('number', $number)
                ->first();
        }

        // Vérification du rôle
        if ($user['role'] !== 'client') {
            return redirect()->back()
                ->withInput()
                ->with('error', "Ce compte n'est pas un client.");
        }

        // Session
        session()->set([
            'user_id' => $user['id'],
            'number'  => $user['number'],
            'role'    => $user['role'],
            'logged'  => true
        ]);

        return redirect()->to('/client/solde');
    }


    public function logout() {
        session()->destroy();
        return redirect()->to('/login');
    }


}