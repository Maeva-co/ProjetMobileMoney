<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;

use App\Models\EpargneModel;
use App\Models\UsersModel;
class EpargneController extends BaseController {

    public function index(){
        $epargneModel = new EpargneModel();
        $userModel = new UsersModel();
        $userEpargne = $userModel->getEpargne(session()->get('user_id'));
        $data = [
            'epargne' => $userEpargne
        ];
        return view('client/epargne', $data);

    }

    public function store() {
        $userModel = new UsersModel();
        $epargne = $this->request->getPost('epargne');
        $userModel->update('epargne',$epargne)->where('id', session()->get('user_id'));
    }

}
