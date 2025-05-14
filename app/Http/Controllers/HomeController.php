<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $rooms = Room::where('status', 'Available')
            ->orderBy('type')
            ->get()
            ->groupBy('type');

        return view('home', compact('rooms'));
    }
}
