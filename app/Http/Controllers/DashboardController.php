<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $logout = route('logout');
        return "dashboard <a href='$logout'>logout</a>";
    }
}
