<?php

namespace App\Http\Controllers\Common;

use App\Models\jobpost;
use App\Models\jobapply;
use App\Models\screening;
use App\Models\jobcandidate;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Helpers\CandidateActivityLog;
use function App\Helpers\getDepartment;
use function App\Helpers\getDesignation;
use function App\Helpers\ResumeSourceCount;
use function App\Helpers\getResumeSourceById;

class JobApplicationController extends Controller
{


    public function job_response()
    {
        $company_list = DB::table("master_company")->where('Status', 'A')->orderBy('CompanyCode', 'desc')->pluck("CompanyCode", "CompanyId");
        $months = [1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'];
        $source_list = DB::table("master_resumesource")->where('Status', 'A')->Where('ResumeSouId', '!=', '7')->pluck('ResumeSource', 'ResumeSouId');
        return view('common.job_response', compact('company_list', 'months', 'source_list'));
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
                return '<input type="checkbox" class="japchks" data-id="' . $data->JAId . '" name="selectCand" id="selectCand" value="' . $data->JAId . '">';
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
            ->addColumn('Details', function ($data) {
                return '<i class="fa fa-eye text-info" style="cursor:pointer" onclick="return ViewCandidate(' . $data->JCId . ');"></i>';
            })
            ->rawColumns(['chk', 'Phone', 'Email', 'Details'])
            ->make(true);
    }

    public function job_applications(Request $request)
    {
        $company_list = DB::table("master_company")->where('Status', 'A')->orderBy('CompanyCode', 'desc')->pluck("CompanyCode", "CompanyId");
        $months = [1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'];
        $source_list = DB::table("master_resumesource")->where('Status', 'A')->Where('ResumeSouId', '!=', '7')->pluck('ResumeSource', 'ResumeSouId');
        $education_list = DB::table("master_education")->where('Status', 'A')->orderBy('EducationCode', 'asc')->pluck("EducationCode", "EducationId");

        $Company = $request->Company;
        $Department = $request->Department;
        $Year = $request->Year;
        $Month = $request->Month;
        $Source = $request->Source;
        $Gender = $request->Gender;
        $Education = $request->Education;
        $Name = $request->Name;

        $usersQuery = jobapply::query();
        if ($Company != '') {
            $usersQuery->where("jobapply.Company", $Company);
        }
        if ($Department != '') {
            $usersQuery->where("jobapply.Department", $Department);
        }
        if ($Year != '') {
            $usersQuery->whereBetween('jobapply.ApplyDate', [$Year . '-01-01', $Year . '-12-31']);
        }
        if ($Month != '') {
            if ($Year != '') {
                $usersQuery->whereBetween('jobapply.ApplyDate', [$Year . '-' . $Month . '-01', $Year . '-' . $Month . '-31']);
            } else {
                $usersQuery->whereBetween('jobapply.ApplyDate', [date('Y') . '-' . $Month . '-01', date('Y') . '-' . $Month . '-31']);
            }
        }
        if ($Source != '') {
            $usersQuery->where("jobapply.ResumeSource", $Source);
        }
        if ($Gender != '') {
            $usersQuery->where("jobcandidates.Gender", $Gender);
        }
        if ($Education != '') {
            $usersQuery->where("jobcandidates.Education", $Education);
        }
        if ($Name != '') {
            $usersQuery->where("jobcandidates.FName", 'like', "%$Name%");
        }

        $candidate_list = $usersQuery->select('jobapply.JAId', 'jobapply.ResumeSource', 'jobapply.ApplyDate', 'jobapply.Status', 'jobapply.FwdTechScr', 'jobcandidates.JCId', 'jobcandidates.ReferenceNo', 'jobcandidates.FName', 'jobcandidates.MName', 'jobcandidates.LName', 'jobcandidates.Phone', 'jobcandidates.Email', 'jobcandidates.City', 'jobcandidates.Education', 'jobcandidates.Specialization', 'jobcandidates.Professional', 'jobcandidates.JobStartDate', 'jobcandidates.JobEndDate', 'jobcandidates.PresentCompany', 'jobcandidates.Designation', 'jobcandidates.Verified', 'jobcandidates.CandidateImage', 'jobpost.DesigId')
            ->Join('jobcandidates', 'jobapply.JCId', '=', 'jobcandidates.JCId')
            ->leftJoin('jobpost', 'jobapply.JPId', '=', 'jobpost.JPId')
            ->leftJoin('screening', 'jobapply.JAId', '=', 'screening.JAId')
            ->where('jobapply.Type', '!=', 'Campus');

        $total_candidate = $candidate_list->count();
        $candidate_list = $candidate_list->paginate(10);

        $total_available = DB::table('jobapply')
            ->where('Type', '!=', 'Campus')
            ->where('Status', null);
        $total_available = $total_available->count();

        $total_hr_scr = DB::table('jobapply')
            ->where('Type', '!=', 'Campus')
            ->where('Status', '!=', null);
        $total_hr_scr = $total_hr_scr->count();

        $total_fwd = DB::table('jobapply')
            ->where('Type', '!=', 'Campus')
            ->where('FwdTechScr', 'Yes');
        $total_fwd = $total_fwd->count();
        return view('common.job_applications', compact('company_list', 'months', 'source_list', 'education_list', 'candidate_list', 'total_candidate', 'total_available', 'total_hr_scr', 'total_fwd'));
    }

    public function update_hrscreening(Request $request)
    {
        $JAId = $request->JAId;
        $Status = $request->Status;

        $query = jobapply::find($JAId);
        $query->Status = $Status;
        $query->SelectedBy = Auth::user()->id;
        $query->save();
        if (!$query) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {
            return response()->json(['status' => 200, 'msg' => 'HR Screening Status has been changed successfully.']);
        }
    }

    public function SendForTechScreening(Request $request)
    {
        $JAId = $request->JAId;
        $sql = 0;
        for ($i = 0; $i < Count($JAId); $i++) {
            $query = jobapply::find($JAId[$i]);
            $query->FwdTechScr = 'Yes';
            $query->SelectedBy = Auth::user()->id;
            $query->save();


            $res = new screening;
            $res->JAId = $query->JAId;
            $res->ScrCmp = $query->Company;
            $res->ScrDpt = $query->Department;
            $res->ScreeningBy = $request->ScreeningBy;
            $res->CreatedBy = Auth::user()->id;
            $res->ReSentForScreen = now();
            $res->CreatedTime = now();
            $res->save();


            //Need to send mail for Firo B   , do it later after firo b is completed
            $sql = 1;
        }

        if ($sql == 0) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {
            return response()->json(['status' => 200, 'msg' => 'Candidate Successfully Forwaded for Technical Screening.']);
        }
    }

    public function job_application_manual_entry_form()
    {
        $resume_list = DB::table("master_resumesource")->where('Status', 'A')->where('ResumeSouId', '!=', '7')->orderBy('ResumeSouId', 'asc')->pluck("ResumeSource", "ResumeSouId");
        return view('common.job_application_manual_entry_form', compact('resume_list'));
    }

    public function job_application_manual(Request $request)
    {

        $query = new jobcandidate;
        $query->Title = $request->Title;
        $query->FName = $request->FName;
        $query->MName = $request->MName;
        $query->LName = $request->LName;
        $query->Gender = $request->Gender;
        $query->FatherTitle = $request->FatherTitle;
        $query->FatherName = $request->FatherName;
        $query->Email = $request->Email;
        $query->Phone = $request->Phone;
        $query->Aadhaar = $request->Aadhaar;
        $query->save();
        $JCId = $query->JCId;

        $Resume = 'resume_' . $JCId . '.' . $request->Resume->extension();
        $request->Resume->move(public_path('uploads/Resume'), $Resume);
        $CandidateImage = '';
        if ($request->CandidateImage != '' || $request->CandidateImage != null) {
            $CandidateImage = $JCId . '.' . $request->CandidateImage->extension();
            $request->CandidateImage->move(public_path('uploads/Picture'), $CandidateImage);
        }

        $ReferenceNo = rand(1000, 9999) . date('Y') . $JCId;

        $query1 = jobcandidate::find($JCId);
        $query1->ReferenceNo = $ReferenceNo;
        $query1->Resume = $Resume;
        $query1->CandidateImage = $CandidateImage;
        $query1->save();

        $jobApply = new jobapply;
        $jobApply->JCId = $JCId;
        $jobApply->JPId = '0';   //Without Any Job Post
        $jobApply->Type = 'Manual Entry';
        $jobApply->ResumeSource = $request->ResumeSource;
        $jobApply->OtherResumeSource = $request->OtherResumeSource;
        $jobApply->Company = '0';
        $jobApply->Department = '0';
        $jobApply->CreatedBy = Auth::user()->id;
        $jobApply->save();

        CandidateActivityLog::addToCandLog($JCId, $request->Aadhaar, 'Candidate Manual Entry');
        if (!$jobApply) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {
            return response()->json(['status' => 200, 'msg' => ' successfully created.']);
        }
    }

    public function getManualEntryCandidate()
    {
        $usersQuery = jobapply::query();

        if (Auth::user()->role == 'R') {
            $usersQuery->where('jobapply.CreatedBy', Auth::user()->id);
        }

        $data =  $usersQuery->select('*')
            ->Join('jobcandidates', 'jobapply.JCId', '=', 'jobcandidates.JCId');

        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('chk', function ($data) {
                return '<input type="checkbox" class="japchks" data-id="' . $data->JCId . '" name="selectCand" id="selectCand" value="' . $data->JCId . '">';
            })
            ->addColumn('Name', function ($data) {
                return $data->FName . ' ' . $data->MName . ' ' . $data->LName;
            })



            ->editColumn('ApplyDate', function ($data) {
                return Carbon::parse($data->ApplyDate)->format('d-m-Y');
            })

            ->addColumn('Link', function ($data) {
                $JCId = base64_encode($data->JCId);
                $x = '<input type="text" id="link' . $data->JCId . '" value="' . url('jobportal/jobapply?jcid=' . $JCId . '') . '">  <button onclick="copylink(' . $data->JCId . ')" class="btn btn-sm btn-primary"> Copy</button>';
                return $x;
            })
            ->rawColumns(['chk', 'Link'])
            ->make(true);
    }
}
