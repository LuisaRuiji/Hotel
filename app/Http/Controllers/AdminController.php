<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('Dashboards.admin');
    }

    public function rooms()
    {
        return view('Dashboards.rooms');
    }

    public function receptionist()
    {
        return view('Dashboards.receptionist');
    }

    public function services()
    {
        return view('Dashboards.services');
    }
}