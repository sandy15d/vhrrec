<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

    public function campus_placement_registration()
    {
        return view('jobportal.campus_placement_registration');
    }
    public function campus_apply_form()
    {
        return view('jobportal.campus_apply');
    }
    public function campus_apply(Request $request)
    {
        # code...
    }
}
