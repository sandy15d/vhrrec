<?php

namespace App\Http\Controllers\recruiter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManualEntryController extends Controller
{
    function recruiter_mrf_entry(){
        $institute_list = DB::table("master_institute")->orderBy('InstituteName', 'asc')->pluck("InstituteName", "InstituteId");
        return view('recruiter.recruiter_mrf_entry',compact( 'institute_list'));
    }
}
