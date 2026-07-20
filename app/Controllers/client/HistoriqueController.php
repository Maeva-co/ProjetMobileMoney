<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\TransactionsModel;

class HistoriqueController extends BaseController {

    public function index() {
        $model = new TransactionsModel();

        $data['transactions'] = $model->getHistorique(
            session()->get('user_id')
        );

        return view('client/historique', $data);
    }
}
