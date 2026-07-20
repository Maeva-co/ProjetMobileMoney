<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TransactionModel;
use App\Models\OperatorTypesModel;

class GainsController extends BaseController
{
    public function index()
    {
        $transactionModel = new TransactionModel();
        $operatorModel = new OperatorTypesModel();
        
        // gain total
        $totalGains = $transactionModel
            ->selectSum('frais')
            ->get()
            ->getRow()
            ->frais ?? 0;
        
        // gain du jour
        $todayGains = $transactionModel
            ->where('DATE(transaction_date)', date('Y-m-d'))
            ->selectSum('frais')
            ->get()
            ->getRow()
            ->frais ?? 0;
        
        // gain du mois
        $monthGains = $transactionModel
            ->where('transaction_date >=', date('Y-m-01'))
            ->selectSum('frais')
            ->get()
            ->getRow()
            ->frais ?? 0;
        
        // gain de l'annee
        $yearGains = $transactionModel
            ->where('transaction_date >=', date('Y-01-01'))
            ->selectSum('frais')
            ->get()
            ->getRow()
            ->frais ?? 0;
        
        // gain par operateur
        $gainsByOperator = $transactionModel
            ->select('
                operator_type_id,
                COUNT(*) as count,
                SUM(frais) as total_fees
            ')
            ->groupBy('operator_type_id')
            ->findAll();
        
        // gain par type de transaction
        $gainsByType = $transactionModel
            ->select('
                transaction_type_id,
                COUNT(*) as count,
                SUM(frais) as total_fees
            ')
            ->groupBy('transaction_type_id')
            ->findAll();
        
        // evolution des gains sur l'annee
        $monthlyGains = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = date('Y-m', strtotime("-$i months"));
            $startDate = date('Y-m-01', strtotime($month));
            $endDate = date('Y-m-t', strtotime($month));
            
            $gains = $transactionModel
                ->where('transaction_date >=', $startDate)
                ->where('transaction_date <=', $endDate)
                ->selectSum('frais')
                ->get()
                ->getRow()
                ->frais ?? 0;
            
            $count = $transactionModel
                ->where('transaction_date >=', $startDate)
                ->where('transaction_date <=', $endDate)
                ->countAllResults();
            
            $monthlyGains[] = [
                'month' => $month,
                'month_label' => date('M Y', strtotime($month)),
                'gains' => $gains,
                'count' => $count
            ];
        }
        
        $data = [
            'totalGains' => $totalGains,
            'todayGains' => $todayGains,
            'monthGains' => $monthGains,
            'yearGains' => $yearGains,
            'gainsByOperator' => $gainsByOperator,
            'gainsByType' => $gainsByType,
            'monthlyGains' => $monthlyGains,
            'operators' => $operatorModel->findAll()
        ];
        
        return view('admin/gains/index', $data);
    }
}