<?php

namespace App\Http\Controllers\Hod;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MrfController extends Controller
{
    function newmrf(){
        return view('hod.newmrf');
    }
}
