<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HodController extends Controller
{
    function index()
    {
        return view('hod.index');
    }
}
