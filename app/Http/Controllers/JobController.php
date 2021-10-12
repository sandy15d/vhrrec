<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;




class JobController extends Controller
{
    function jobs()
    {
        return view('jobportal.jobs');
    }
    public function job_apply()
    {
        return view('jobportal.job_apply');
    }
}
