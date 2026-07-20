<?php

namespace App\Controllers\admin;

use App\Models\UsersModel;
use App\Models\TransactionModel;
use App\Models\ConfigFraisModel;
use App\Models\OperatorTypesModel;
use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        $userModel = new UsersModel();
        $transactionModel = new TransactionModel();
        $configModel = new ConfigFraisModel();
        $operatorModel = new OperatorTypesModel();
        
        $data = [
            'totalClients' => $userModel->countClients(),
            'totalRevenue' => $transactionModel->getTotalRevenue(),
            'totalCommission' => $transactionModel->getTotalCommission(),
            'recentTransactions' => $transactionModel->getRecentTransactions(10),
            'recentClients' => $userModel->getRecentClients(5),
            'activeConfigs' => $configModel->getActiveConfigs()
        ];
        
        return view('admin/dashboard', $data);
    }
}