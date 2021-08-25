<?php

namespace App\Http\Controllers\recruiter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MrfAllocatedController extends Controller
{
    function mrf_allocated(){
        return view('recruiter.mrf_allocated');
    }

    function getAllAllocatedMRF(Request $request){
        
    }
}
