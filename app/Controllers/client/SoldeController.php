<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;

use App\Models\SoldeMouvementModel;

class SoldeController extends BaseController {

    public function index(){
        $model = new SoldeMouvementModel();
        $userId = session()->get('user_id');

        // $credit = $model
        //     ->selectSum('amount')
        //     ->where('userId', $userId)
        //     ->where('type', 'credit')
        //     ->first();

        // $debit = $model
        //     ->selectSum('amount')
        //     ->where('userId', $userId)
        //     ->where('type', 'debit')
        //     ->first();

        // $credit = $credit['amount'] ?? 0;
        // $debit = $debit['amount'] ?? 0;

        // $data['solde'] = $credit - $debit;

        $data['solde'] = $model->getSolde($userId);

        return view('client/solde', $data);

    }

}
