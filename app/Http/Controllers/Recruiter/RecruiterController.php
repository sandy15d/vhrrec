<?php

namespace App\Http\Controllers\Recruiter;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RecruiterController extends Controller
{
    function index()
    {
        $allocatedMrf = DB::table('manpowerrequisition')->where('Allocated', Auth::user()->id)->get();
        $AlCount = $allocatedMrf->count();

        $CreatePost = DB::table('jobpost')->where('CreatedBy', Auth::user()->id)->get();
        $allCreated = $CreatePost->count();
        return view('recruiter.index', ["allocatedmrf" => $AlCount,"JobPosting"=>$allCreated]);
    }



}
