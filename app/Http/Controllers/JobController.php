<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;




class JobController extends Controller
{
    function jobs()
    {
        return view('jobs');
    }
}
