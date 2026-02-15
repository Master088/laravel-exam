<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Only logged-in users can access
    }

    public function index()
    {
        return view('dashboard'); // resources/views/dashboard.blade.php
    }
}
