<?php

namespace App\Http\Controllers\recruiter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManualEntryController extends Controller
{
    function recruiter_mrf_entry(){
        return view('recruiter.recruiter_mrf_entry');
    }
}
