<?php

namespace App\Http\Controllers\Recruiter;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RecruiterController extends Controller
{
    function index()
    {
        $AlCount = DB::table('manpowerrequisition')->where('CountryId',session('Set_Country'))->where('Allocated', Auth::user()->id)->count();
        $allCreated = DB::table('jobpost')->join('manpowerrequisition','jobpost.MRFId','=','manpowerrequisition.MRFId')->where('CountryId',session('Set_Country'))->where('jobpost.CreatedBy', Auth::user()->id)->count();
        $PendingTechScr = DB::table('jobapply')
            ->Join('jobpost', 'jobpost.JPId', '=', 'jobapply.JPId')
            ->Join('manpowerrequisition', 'jobpost.MRFId', '=', 'manpowerrequisition.MRFId')
            ->Join('screening', 'jobapply.JAId', '=', 'screening.JAId')
            ->where('manpowerrequisition.Allocated', Auth::user()->id)
            ->where('jobpost.Status', 'Open')
            ->where('jobapply.Status', 'Selected')
            ->whereNull('screening.ScreenStatus')
            ->count();
        return view('recruiter.index', ["allocatedmrf" => $AlCount, "JobPosting" => $allCreated,'PendingTechScr'=>$PendingTechScr]);
    }
}
