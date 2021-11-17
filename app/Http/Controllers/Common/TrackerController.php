<?php

namespace App\Http\Controllers\Common;

use App\Models\jobpost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\jobapply;
use App\Models\screening;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

use function App\Helpers\getDepartmentCode;
use function App\Helpers\getFullName;
use function App\Helpers\getResumeSourceById;

class TrackerController extends Controller
{
    public function TechnicalScreening()
    {
        $company_list = DB::table("master_company")->where('Status', 'A')->orderBy('CompanyCode', 'desc')->pluck("CompanyCode", "CompanyId");
        $JobQuery = jobpost::query();
        if (Auth::user()->role == 'R') {
            $JobQuery->where('CreatedBy', Auth::user()->id);
        }

        return view('common.technical_screening', compact('company_list'));
    }

    public function getTechnicalSceeningCandidate(Request $request)
    {
        $usersQuery = screening::query();
        $Company = $request->Company;
        $Department = $request->Department;
        $JPId = $request->JPId;
        if ($Company != '') {
            $usersQuery->where("screening.ScrCmp", $Company);
        }
        if ($Department != '') {
            $usersQuery->where("screening.ScrDpt", $Department);
        }
        if ($JPId != '') {
            $usersQuery->where("jobpost.JPId", $JPId);
        }

        $data =  $usersQuery->select('screening.*','jobapply.FwdTechScr','jobcandidates.JCId','jobcandidates.FName','jobcandidates.MName','jobcandidates.LName','jobcandidates.ReferenceNo','jobpost.JobCode')
            ->join('jobapply', 'jobapply.JAId', '=', 'screening.JAId')
            ->join('jobpost', 'jobapply.JPId', '=', 'jobpost.JPId')
            ->Join('jobcandidates', 'jobapply.JCId', '=', 'jobcandidates.JCId')
            ->where('jobapply.FwdTechScr', 'Yes')
            ->orderBy('ScId','DESC');

        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('chk', function ($data) {
                return '<input type="checkbox" class="japchks" data-id="' . $data->JAId . '" name="selectCand" id="selectCand" value="' . $data->JAId . '">';
            })
            ->addColumn('Name', function ($data) {
                return $data->FName . ' ' . $data->MName . ' ' . $data->LName;
            })
            ->editColumn('Department', function ($data) {
                return getDepartmentCode($data->ScrDpt);
            })
            ->editColumn('ScreenedBy', function ($data) {
                return getFullName($data->ScreeningBy);
            })
            ->addColumn('InterviewMail', function ($data) {
                return '';
            })
            ->addColumn('Action', function ($data) {
                return '<i class="fa fa-pencil text-danger" style="cursor:pointer" onclick="return EditTracker(' . $data->JAId . ');"></i>';
            })
            ->rawColumns(['chk', 'InterviewMail', 'Action'])
            ->make(true);
    }


}
