<?php

namespace App\Controllers\admin;

use App\Models\UserModel;
use App\Controllers\BaseController;
class DashboardController extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $users = $userModel->findAll();
        $data['users'] = $users;
        return view('admin/dashboard', $data);
    }
}
