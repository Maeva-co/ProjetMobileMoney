<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;

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
        if (!$usersModel->validate($data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $usersModel->errors());
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
        $user = $usersModel
            ->where('number', $number)
            ->first();

        if (!$user) {
            $usersModel->insert([
                'name'   => null,
                'role'   => 'client',
                'number' => $number
            ]);

            $user = $usersModel
                ->where('number', $number)
                ->first();
        }

        // Session
        if($user['role'] === 'client') {
            session()->set([
                'user_id' => $user['id'],
                'number'  => $user['number'],
                'role'    => $user['role'],
                'isLoggedIn'  => true
            ]);

            return redirect()->to(base_url('client/solde'));
        } else if($user['role'] === 'admin') {
            session()->set([
                'user_id' => $user['id'],
                'number'  => $user['number'],
                'role'    => $user['role'],
                'isLoggedIn'  => true
            ]);

            return redirect()->to(base_url('admin/dashboard'));
        }
    }


    public function logout() {
        session()->destroy();
        return redirect()->to('/');
    }


}