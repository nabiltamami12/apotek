<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;

class DashboardController extends HomeController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view('home');
    }
}
