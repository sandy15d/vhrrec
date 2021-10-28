<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $state_list = DB::table("states")->orderBy('StateName', 'asc')->pluck("StateName", "StateId");
        $institute_list = DB::table("master_institute")->orderBy('InstituteName', 'asc')->pluck("InstituteName", "InstituteId");
        $education_list = DB::table("master_education")->where('Status', 'A')->orderBy('EducationCode', 'asc')->pluck("EducationCode", "EducationId");
        return view('jobportal.campus_apply', compact('state_list','institute_list','education_list'));
    }
    public function campus_apply(Request $request)
    {
        # code...
    }
}
