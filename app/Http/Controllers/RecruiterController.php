<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecruiterController extends Controller
{
    function index()
    {
        return view('recruiter.index');
    }
}
