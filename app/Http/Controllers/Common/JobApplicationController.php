<?php

namespace App\Http\Controllers\Common;


use App\Http\Controllers\Controller;
use App\Models\jobapply;
use App\Models\jobpost;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function App\Helpers\getDepartment;
use function App\Helpers\getDesignation;
use function App\Helpers\getResumeSourceById;
use function App\Helpers\ResumeSourceCount;

class JobApplicationController extends Controller
{


    public function job_response()
    {
        $company_list = DB::table("master_company")->where('Status', 'A')->orderBy('CompanyCode', 'desc')->pluck("CompanyCode", "CompanyId");
        $months = [1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'];
        $source_list = DB::table("master_resumesource")->where('Status', 'A')->Where('ResumeSouId', '!=', '7')->pluck('ResumeSource', 'ResumeSouId');
        return view('common.job_response', compact('company_list', 'months','source_list'));
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

        $data = $usersQuery->select('jobpost.JPId', 'jobapply.Company', 'jobapply.Department', 'JobCode', 'jobpost.DesigId', 'jobapply.ResumeSource', DB::raw('COUNT(jobapply.JAId) AS Response'))
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
                return ResumeSourceCount($data->JPId, $data->ResumeSource);
            })

            ->rawColumns(['chk', 'Response', 'Source'])
            ->make(true);
    }

    public function getCandidates(Request $request)
    {
        $usersQuery = jobapply::query();
        $Gender = $request->Gender;
        $Source = $request->Source;
        if ($Gender != '') {
            $usersQuery->where("jobcandidates.Gender", $Gender);
        }
        if ($Source != '') {
            $usersQuery->where("jobapply.ResumeSource", $Source);
        }

        $data =  $usersQuery->select('*')
            ->Join('jobcandidates', 'jobapply.JCId', '=', 'jobcandidates.JCId')
            ->where('jobapply.JPId', $request->JPId);

        return datatables()->of($data)
            ->addIndexColumn()

            ->addColumn('chk', function ($data) {
                return '<input type="checkbox" class="japchks" data-id="'.$data->JAId.'" name="selectCand" id="selectCand" value="'.$data->JAId.'">';
            })
            ->addColumn('Name', function ($data) {
                return $data->FName . ' ' . $data->MName . ' ' . $data->LName;
            })
            ->editColumn('Phone', function ($data) {
                if ($data->Verified == 'Y') {
                    return $data->Phone . '<i class="fa fa-check-circle text-success" aria-hidden="true"></i>';
                } else {
                    return $data->Phone;
                }
            })
            ->editColumn('Email', function ($data) {
                if ($data->Verified == 'Y') {
                    return $data->Email . '<i class="fa fa-check-circle text-success" aria-hidden="true"></i>';
                } else {
                    return $data->Email;
                }
            })
            ->editColumn('Professional', function ($data) {
                if ($data->Professional == 'F') {
                    return 'Fresher';
                } else {
                    return 'Experienced';
                }
            })
            ->editColumn('Gender', function ($data) {
                if ($data->Gender == 'F') {
                    return 'Female';
                } elseif ($data->Gender == 'M') {
                    return 'Male';
                } else {
                    return 'Other';
                }
            })
            ->editColumn('ApplyDate', function ($data) {
                return Carbon::parse($data->ApplyDate)->format('d-m-Y');
            })
            ->addColumn('ScreenedBy', function ($data) {
                return '';
            })
            ->addColumn('Source', function ($data) {
                return getResumeSourceById($data->ResumeSource);
            })
            ->rawColumns(['chk', 'Phone', 'Email'])
            ->make(true);
    }
}
