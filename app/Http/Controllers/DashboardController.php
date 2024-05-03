<?php

namespace App\Http\Controllers;

use App\Models\Map;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index', ['destination' => Map::count()]);
    }
}
