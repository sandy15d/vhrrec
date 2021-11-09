<?php

namespace App\Http\Controllers\Common;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Mail\MrfCreationMail;
use App\Models\jobpost;
use App\Models\master_mrf;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

use function App\Helpers\convertData;
use function App\Helpers\getCollegeById;
use function App\Helpers\getCompanyCode;
use function App\Helpers\getDepartment;
use function App\Helpers\getDepartmentCode;
use function App\Helpers\getDesignation;
use function App\Helpers\getDesignationCode;
use function App\Helpers\getEducationById;
use function App\Helpers\getFullName;
use function App\Helpers\getSpecializationbyId;
use function App\Helpers\ResumeSourceCount;

class JobApplicationController extends Controller
{
    public function job_response()
    {
        $company_list = DB::table("master_company")->where('Status', 'A')->orderBy('CompanyCode', 'desc')->pluck("CompanyCode", "CompanyId");
        $months = [1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'];
        return view('common.job_response', compact('company_list', 'months'));
    }


    public  function getJobResponseSummary(Request $request)
    {

        $usersQuery = jobpost::query();
        $Company = $request->Company;
        $Department = $request->Department;
        $Year = $request->Year;
        $Month = $request->Month;

        if (Auth::user()->role == 'R') {
            $usersQuery->where('jobpost.CreatedBy', Auth::user()->id);
        }
        if ($Company != '') {
            $usersQuery->where("jobpost.CompanyId", $Company);
        }
        if ($Department != '') {
            $usersQuery->where("jobpost.DepartmentId", $Department);
        }
        if ($Year != '') {
            $usersQuery->whereBetween('jobpost.CreatedTime', [$Year . '-01-01', $Year . '-12-31']);
        }
        if ($Month != '') {
            if ($Year != '') {
                $usersQuery->whereBetween('jobpost.CreatedTime', [$Year . '-' . $Month . '-01', $Year . '-' . $Month . '-31']);
            } else {
                $usersQuery->whereBetween('jobpost.CreatedTime', [date('Y') . '-' . $Month . '-01', date('Y') . '-' . $Month . '-31']);
            }
        }



        $data = $usersQuery->select('jobpost.JPId', 'jobapply.Company', 'jobapply.Department', 'JobCode', 'jobpost.DesigId','jobapply.ResumeSource',DB::raw('COUNT(jobapply.JAId) AS Response'))
            ->Join('jobapply', 'jobpost.JPId', '=', 'jobapply.JPId')
            ->where('jobapply.Type', '!=', 'Campus')
            ->groupBy('jobpost.JPId');


        return datatables()->of($data)
            ->addIndexColumn()

            ->addColumn('chk', function () {
                return '<input type="checkbox" class="select_all">';
            })

            ->editColumn('Department', function ($data) {
                return getDepartment($data->Department);
            })
            ->editColumn('Designation', function ($data) {
                if ($data->DesigId != 0 || $data->DesigId != null) {
                    return getDesignation($data->DesigId);
                } else {
                    return '';
                }
            })

            ->editColumn('Response', function ($data) {
                return '<a href="javascript:void(0);" class="btn btn-sm btn-warning" onclick="return getCandidate(' . $data->JPId . ');">' . $data->Response . '</a>';
            })
            ->addColumn('Source', function ($data) {
                return ResumeSourceCount($data->JPId,$data->ResumeSource);
            })

            ->rawColumns(['chk', 'Response','Source'])
            ->make(true);
    }

    public function getCandidates(Request $request)
    {
        $data =  DB::table('jobapply')
            ->Join('jobcandidates', 'jobapply.JCId', '=', 'jobcandidates.JCId')
            ->where('jobapply.JPId', $request->JPId);

        return '';
      
    }
}
