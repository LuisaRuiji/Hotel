<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('Dashboards.Admin.dashboard');
    }

    public function rooms()
    {
        return view('Dashboards.Admin.rooms');
    }

    public function receptionist()
    {
        return view('Dashboards.Admin.receptionist');
    }

    public function services()
    {
        return view('Dashboards.Admin.services');
    }
}