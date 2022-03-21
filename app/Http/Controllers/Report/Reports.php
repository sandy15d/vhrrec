<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Reports extends Controller
{
    public function Firob_Reports()
    {
        $report_list = DB::table('jobcandidates')->join('firob_user', 'firob_user.userid', '=', 'jobcandidates.JCId')->where('FIROB_Test', 1)->orderBy('SubDate', 'asc')->groupBy('userid')->peginate(10);
        return view('reports.firob_reports', compact(['report_list']));
    }
}
