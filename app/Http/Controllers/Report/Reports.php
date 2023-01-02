<?php

namespace App\Http\Controllers\Report;

use App\Models\jobapply;
use App\Models\master_mrf;
use App\Models\OfferLetter;
use App\Models\jobcandidate;
use Illuminate\Http\Request;
use App\Models\CandidateJoining;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use function App\Helpers\getFullName;
use function App\Helpers\getDepartment;
use function App\Helpers\getCompanyCode;
use function App\Helpers\getDesignation;
use App\Models\Admin\resumesource_master;
use function App\Helpers\getDepartmentCode;
use function App\Helpers\getDesignationCode;

class Reports extends Controller
{
    public function Firob_Reports()
    {
        $report_list = DB::table('jobcandidates')->join('firob_user', 'firob_user.userid', '=', 'jobcandidates.JCId')->where('FIROB_Test', 1)->orderBy('SubDate', 'desc')->groupBy('userid')->get();
        return view('reports.firob_reports', compact(['report_list']));
    }

    public function reports_download()
    {
        return view('reports.reports_download');
    }

    public function mrfs_report()
    {

        session()->put('submenu', 'mrfs_report');
        $company_list = DB::table("master_company")->where('Status', 'A')->orderBy('CompanyCode', 'desc')->pluck("CompanyCode", "CompanyId");
        $department_list = DB::table("master_department")->where('DeptStatus', 'A')->orderBy('DepartmentName', 'asc')->pluck("DepartmentName", "DepartmentId");
        $months = [1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'];
        return view('reports.mrfs_report', compact(['company_list', 'department_list', 'months']));
    }

    public function getMrfReport(Request $request)
    {

        $usersQuery = master_mrf::query();
        $Company = $request->Company;
        $Department = $request->Department;
        $Year = $request->Year;
        $Month = $request->Month;
        if ($Company != '') {
            $usersQuery->where("CompanyId", $Company);
        }
        if ($Department != '') {
            $usersQuery->where("DepartmentId", $Department);
        }
        if ($Year != '') {
            $usersQuery->whereBetween('CreatedTime', [$Year . '-01-01', $Year . '-12-31']);
        }
        if ($Month != '') {
            if ($Year != '') {
                $usersQuery->whereBetween('CreatedTime', [$Year . '-' . $Month . '-01', $Year . '-' . $Month . '-31']);
            } else {
                $usersQuery->whereBetween('CreatedTime', [date('Y') . '-' . $Month . '-01', date('Y') . '-' . $Month . '-31']);
            }
        }

        $mrf =  $usersQuery->select('*')
            ->orderBy('CreatedTime', 'desc');
        return datatables()->of($mrf)
            ->addIndexColumn()
            ->editColumn('Type', function ($mrf) {
                if ($mrf->Type == 'N' || $mrf->Type == 'N_HrManual') {
                    return 'New MRF';
                } elseif ($mrf->Type == 'SIP' || $mrf->Type == 'SIP_HrManual') {
                    return 'SIP/Internship MRF';
                } elseif ($mrf->Type == 'Campus' || $mrf->Type == 'Campus_HrManual') {
                    return 'Campus MRF';
                } elseif ($mrf->Type == 'R' || $mrf->Type == 'R_HrManual') {
                    return 'Replacement MRF';
                }
            })
            ->editColumn('ReplacementFor', function ($mrf) {
                if ($mrf->RepEmployeeID == '0') {
                    return '-';
                } else {
                    return getFullName($mrf->RepEmployeeID);
                }
            })

            ->editColumn('Department', function ($mrf) {
                return getDepartmentCode($mrf->DepartmentId);
            })
            ->editColumn('Designation', function ($mrf) {
                return getDesignation($mrf->DesigId);
            })
            ->editColumn('CreatedBy', function ($mrf) {
                return getFullName($mrf->CreatedBy);
            })
            ->editColumn('OnBehalf', function ($mrf) {
                return getFullName($mrf->OnBehalf);
            })
            ->editColumn('Allocated', function ($mrf) {
                return getFullName($mrf->Allocated);
            })
            ->editColumn('CreatedTime', function ($mrf) {
                return date('d-m-Y', strtotime($mrf->CreatedTime));
            })
            ->editColumn('Status', function ($mrf) {
                if ($mrf->Status == 'Approved') {
                    return 'Active';
                } elseif ($mrf->Status == 'Close') {
                    return 'Close';
                } else {
                    return 'Active';
                }
            })

            ->editColumn('CloseDt', function ($mrf) {
                if ($mrf->Status == 'Close') {
                    return date('d-m-Y', strtotime($mrf->CloseDt));
                } else {
                    return '-';
                }
            })

            ->make(true);
    }

    public function application_source_report()
    {
        session()->put('submenu', 'application_source_report');
        $company_list = DB::table("master_company")->where('Status', 'A')->orderBy('CompanyCode', 'desc')->pluck("CompanyCode", "CompanyId");
        $department_list = DB::table("master_department")->where('DeptStatus', 'A')->orderBy('DepartmentName', 'asc')->pluck("DepartmentName", "DepartmentId");
        return view('reports.application_source_report', compact(['company_list', 'department_list']));
    }

    public function getApplicationSource(Request $request)
    {

        $usersQuery = resumesource_master::query();
        $Company = $request->Company;
        $Department = $request->Department;

        if ($Company != '') {
            $usersQuery->where("jobapply.Company", $Company);
        }
        if ($Department != '') {
            $usersQuery->where("jobapply.Department", $Department);
        }

        $query =  $usersQuery->select('jobapply.Department', 'master_resumesource.ResumeSource', DB::raw("'COUNT'(JAId) as total"))
            ->join('jobapply', 'jobapply.ResumeSource', '=', 'resumesource_master.ResumeSouId')
            ->groupBy('jobapply.ResumeSource');

        return datatables()->of($query)
            ->addIndexColumn()

            ->editColumn('Department', function ($query) {
                return getDepartment($query->Department);
            })


            ->make(true);
    }

    public function hr_screening_report()
    {
        session()->put('submenu', 'hr_screening_report');
        $company_list = DB::table("master_company")->where('Status', 'A')->orderBy('CompanyCode', 'desc')->pluck("CompanyCode", "CompanyId");
        $department_list = DB::table("master_department")->where('DeptStatus', 'A')->orderBy('DepartmentName', 'asc')->pluck("DepartmentName", "DepartmentId");
        $months = [1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'];
        return view('reports.hr_screening_report', compact(['company_list', 'department_list', 'months']));
    }

    public function get_hr_screening_report(Request $request)
    {
        $usersQuery = jobcandidate::query();
        $Company = $request->Company;
        $Department = $request->Department;
        $Year = $request->Year;
        $Month = $request->Month;
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

        $mrf =  $usersQuery->select('ReferenceNo', 'FName', 'MName', 'LName', 'Department', 'jobapply.Status', 'JobCode','master_resumesource.ResumeSource','users.name')
            ->join('jobapply', 'jobapply.JCId', '=', 'jobcandidates.JCId')
            ->leftJoin('jobpost', 'jobpost.JPId', '=', 'jobapply.JPId')
            ->leftJoin('master_resumesource', 'master_resumesource.ResumeSouId', '=', 'jobapply.ResumeSource')
            ->leftJoin('users', 'users.id', '=', 'jobapply.SelectedBy')
         
            ->whereNotNull('jobapply.Status')
            ->orderBy('JAId', 'desc');
        return datatables()->of($mrf)
            ->addIndexColumn()
            ->editColumn('Name', function ($mrf) {
                return $mrf->FName . ' ' . $mrf->MName . ' ' . $mrf->LName;
            })
            ->editColumn('Department', function ($mrf) {
                return getDepartmentCode($mrf->Department);
            })
            ->make(true);
    }
    public function tech_screening_report()
    {
        session()->put('submenu', 'tech_screening_report');
        $company_list = DB::table("master_company")->where('Status', 'A')->orderBy('CompanyCode', 'desc')->pluck("CompanyCode", "CompanyId");
        $department_list = DB::table("master_department")->where('DeptStatus', 'A')->orderBy('DepartmentName', 'asc')->pluck("DepartmentName", "DepartmentId");
        $months = [1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'];
        return view('reports.tech_screening_report', compact(['company_list', 'department_list', 'months']));
    }

    public function get_tech_screening_report(Request $request)
    {
        $usersQuery = jobapply::query();
        $Company = $request->Company;
        $Department = $request->Department;
        $Year = $request->Year;
        $Month = $request->Month;
        if ($Company != '') {
            $usersQuery->where("screening.ScrCmp", $Company);
        }
        if ($Department != '') {
            $usersQuery->where("screening.ScrDpt", $Department);
        }
        if ($Year != '') {
            $usersQuery->whereBetween('screening.ReSentForScreen', [$Year . '-01-01', $Year . '-12-31']);
        }
        if ($Month != '') {
            if ($Year != '') {
                $usersQuery->whereBetween('screening.ReSentForScreen', [$Year . '-' . $Month . '-01', $Year . '-' . $Month . '-31']);
            } else {
                $usersQuery->whereBetween('screening.ReSentForScreen', [date('Y') . '-' . $Month . '-01', date('Y') . '-' . $Month . '-31']);
            }
        }

        $mrf =  $usersQuery->select('jobcandidates.ReferenceNo', 'screening.ScrDpt', 'jobpost.JobCode', 'jobpost.DesigId', 'jobcandidates.FName', 'jobcandidates.MName', 'jobcandidates.LName', 'screening.ReSentForScreen', 'screening.ScreeningBy', 'screening.ResScreened', 'screening.ScreenStatus', 'screening.RejectionRem','master_resumesource.ResumeSource','users.name')
            ->join('jobcandidates', 'jobcandidates.JCId', '=', 'jobapply.JCId')
            ->leftJoin('jobpost', 'jobpost.JPId', '=', 'jobapply.JPId')
            ->leftJoin('screening', 'screening.JAId', '=', 'jobapply.JAId')
            ->leftJoin('master_resumesource', 'master_resumesource.ResumeSouId', '=', 'jobapply.ResumeSource')
            ->leftJoin('users', 'users.id', '=', 'jobapply.SelectedBy')
            ->where('jobapply.FwdTechScr', 'Yes')
            ->orderBy('jobapply.JAId', 'desc');
        return datatables()->of($mrf)
            ->addIndexColumn()
            ->editColumn('Name', function ($mrf) {
                return $mrf->FName . ' ' . $mrf->MName . ' ' . $mrf->LName;
            })
            ->editColumn('Department', function ($mrf) {
                return getDepartmentCode($mrf->ScrDpt);
            })
            ->editColumn('Designation', function ($mrf) {
                return getDesignationCode($mrf->DesigId);
            })
            ->editColumn('ReSentForScreen', function ($mrf) {
                return date('d-m-Y', strtotime($mrf->ReSentForScreen));
            })
            ->editColumn('ScreeningBy', function ($mrf) {
                return getFullName($mrf->ScreeningBy);
            })
            ->editColumn('ResScreened', function ($mrf) {
                return date('d-m-Y', strtotime($mrf->ResScreened));
            })
            ->make(true);
    }

    public function interview_tracker_report()
    {
        session()->put('submenu', 'interview_tracker_report');
        $company_list = DB::table("master_company")->where('Status', 'A')->orderBy('CompanyCode', 'desc')->pluck("CompanyCode", "CompanyId");
        $department_list = DB::table("master_department")->where('DeptStatus', 'A')->orderBy('DepartmentName', 'asc')->pluck("DepartmentName", "DepartmentId");
        $months = [1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'];
        return view('reports.interview_tracker_report', compact(['company_list', 'department_list', 'months']));
    }

    public function get_interview_tracker_report(Request $request)
    {
        $usersQuery = jobapply::query();
        $Company = $request->Company;
        $Department = $request->Department;
        $Year = $request->Year;
        $Month = $request->Month;
        if ($Company != '') {
            $usersQuery->where("screening.ScrCmp", $Company);
        }
        if ($Department != '') {
            $usersQuery->where("screening.ScrDpt", $Department);
        }
        if ($Year != '') {
            $usersQuery->whereBetween('screening.ReSentForScreen', [$Year . '-01-01', $Year . '-12-31']);
        }
        if ($Month != '') {
            if ($Year != '') {
                $usersQuery->whereBetween('screening.ReSentForScreen', [$Year . '-' . $Month . '-01', $Year . '-' . $Month . '-31']);
            } else {
                $usersQuery->whereBetween('screening.ReSentForScreen', [date('Y') . '-' . $Month . '-01', date('Y') . '-' . $Month . '-31']);
            }
        }

        $mrf =  $usersQuery->select('jobcandidates.ReferenceNo', 'jobapply.JAId', 'screening.ScrDpt', 'jobpost.JobCode', 'jobpost.DesigId', 'jobcandidates.FName', 'jobcandidates.LName', 'screening.IntervDt', 'screening.IntervLoc', 'screening.IntervStatus', 'screen2ndround.IntervDt2', 'screen2ndround.IntervLoc2', 'screen2ndround.IntervStatus2', 'screening.SelectedForC', 'screening.SelectedForD', 'intervcost.Travel', 'intervcost.Lodging', 'intervcost.Relocation', 'intervcost.Other','master_resumesource.ResumeSource','users.name')
            ->join('jobcandidates', 'jobcandidates.JCId', '=', 'jobapply.JCId')
            ->leftJoin('jobpost', 'jobpost.JPId', '=', 'jobapply.JPId')
            ->leftJoin('screening', 'screening.JAId', '=', 'jobapply.JAId')
            ->leftJoin('screen2ndround', 'screen2ndround.ScId', '=', 'screening.ScId')
            ->leftJoin('intervcost', 'intervcost.JAId', '=', 'jobapply.JAId')
            ->leftJoin('master_resumesource', 'master_resumesource.ResumeSouId', '=', 'jobapply.ResumeSource')
            ->leftJoin('users', 'users.id', '=', 'jobapply.SelectedBy')
            ->where('screening.ScreenStatus', 'Shortlist')
            ->orderBy('jobapply.JAId', 'desc');
        return datatables()->of($mrf)
            ->addIndexColumn()
            ->editColumn('Name', function ($mrf) {
                return $mrf->FName . ' ' . $mrf->MName . ' ' . $mrf->LName;
            })
            ->editColumn('Department', function ($mrf) {
                return getDepartmentCode($mrf->ScrDpt);
            })
            ->editColumn('Designation', function ($mrf) {
                return getDesignationCode($mrf->DesigId);
            })
            ->editColumn('IntervDt', function ($mrf) {
                if ($mrf->IntervDt == '' || $mrf->IntervDt == null || $mrf->IntervDt == '0000-00-00') {
                    return '';
                } else {
                    return date('d-m-Y', strtotime($mrf->IntervDt));
                }
            })
            ->editColumn('IntervDt2', function ($mrf) {
                if ($mrf->IntervDt2 == '' || $mrf->IntervDt2 == null || $mrf->IntervDt2 == '0000-00-00') {
                    return '';
                } else {
                    return date('d-m-Y', strtotime($mrf->IntervDt2));
                }
            })
            ->editColumn('SelectedForC', function ($mrf) {
                return getCompanyCode($mrf->SelectedForC);
            })
            ->editColumn('SelectedForD', function ($mrf) {
                return getDepartmentCode($mrf->SelectedForD);
            })

            ->make(true);
    }

    public function job_offer_report()
    {
        session()->put('submenu', 'job_offer_report');
        $company_list = DB::table("master_company")->where('Status', 'A')->orderBy('CompanyCode', 'desc')->pluck("CompanyCode", "CompanyId");
        $department_list = DB::table("master_department")->where('DeptStatus', 'A')->orderBy('DepartmentName', 'asc')->pluck("DepartmentName", "DepartmentId");
        $months = [1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'];
        return view('reports.job_offer_report', compact(['company_list', 'department_list', 'months']));
    }

    public function get_job_offer_report(Request $request)
    {
        $usersQuery = OfferLetter::query();
        $Company = $request->Company;
        $Department = $request->Department;
        $Year = $request->Year;
        $Month = $request->Month;
        if ($Company != '') {
            $usersQuery->where("offerletterbasic.Company", $Company);
        }
        if ($Department != '') {
            $usersQuery->where("offerletterbasic.Department", $Department);
        }
        if ($Year != '') {
            $usersQuery->whereBetween('offerletterbasic.LtrDate', [$Year . '-01-01', $Year . '-12-31']);
        }
        if ($Month != '') {
            if ($Year != '') {
                $usersQuery->whereBetween('offerletterbasic.LtrDate', [$Year . '-' . $Month . '-01', $Year . '-' . $Month . '-31']);
            } else {
                $usersQuery->whereBetween('offerletterbasic.LtrDate', [date('Y') . '-' . $Month . '-01', date('Y') . '-' . $Month . '-31']);
            }
        }

        $mrf =  $usersQuery->select(
            'offerletterbasic.Company',
            'offerletterbasic.Department',
            'offerletterbasic.Designation',
            'jobpost.JobCode',
            'jobcandidates.ReferenceNo',
            'jobcandidates.FName',
            'jobcandidates.MName',
            'jobcandidates.LName',
            'offerletter_review.CreatedTime as review_date',
            'offerletter_review.EmpId',
            'offerletter_review.Status as review_status',
            'candjoining.LinkValidityStart as of_sent_dt',
            'offerletterbasic.Answer',
            'offerletterbasic.RejReason',
            'candjoining.JoinOnDt',
            'master_resumesource.ResumeSource','users.name'
        )
            ->join('jobapply', 'jobapply.JAId', '=', 'offerletterbasic.JAId')
            ->join('jobcandidates', 'jobcandidates.JCId', '=', 'jobapply.JCId')
            ->leftJoin('jobpost', 'jobpost.JPId', '=', 'jobapply.JPId')
            ->leftJoin('offerletter_review', 'offerletter_review.JAId', '=', 'offerletterbasic.JAId')
            ->leftJoin('candjoining', 'candjoining.JAId', '=', 'offerletterbasic.JAId')
            ->leftJoin('master_resumesource', 'master_resumesource.ResumeSouId', '=', 'jobapply.ResumeSource')
            ->leftJoin('users', 'users.id', '=', 'jobapply.SelectedBy')
            ->where('LtrNo', '!=', null)
            ->groupBy('offerletterbasic.JAId')
            ->orderBy('offerletterbasic.JAId', 'desc');
        return datatables()->of($mrf)
            ->addIndexColumn()
            ->editColumn('Company', function ($mrf) {
                return getCompanyCode($mrf->Company);
            })
            ->editColumn('Department', function ($mrf) {
                return getDepartmentCode($mrf->Department);
            })
            ->editColumn('Name', function ($mrf) {
                return $mrf->FName . ' ' . $mrf->MName . ' ' . $mrf->LName;
            })


            ->editColumn('Designation', function ($mrf) {
                return getDesignationCode($mrf->Designation);
            })
            ->editColumn('review_date', function ($mrf) {
                if ($mrf->review_date == '' || $mrf->review_date == null || $mrf->review_date == '0000-00-00') {
                    return '';
                } else {
                    return date('d-m-Y', strtotime($mrf->review_date));
                }
            })
            ->editColumn('of_sent_dt', function ($mrf) {
                if ($mrf->of_sent_dt == '' || $mrf->of_sent_dt == null || $mrf->of_sent_dt == '0000-00-00') {
                    return '';
                } else {
                    return date('d-m-Y', strtotime($mrf->of_sent_dt));
                }
            })
            ->editColumn('JoinOnDt', function ($mrf) {
                if ($mrf->JoinOnDt == '' || $mrf->JoinOnDt == null || $mrf->JoinOnDt == '0000-00-00') {
                    return '';
                } else {
                    return date('d-m-Y', strtotime($mrf->JoinOnDt));
                }
            })

            ->editColumn('review_by', function ($mrf) {
                return getFullName($mrf->EmpId);
            })


            ->editColumn('SelectedForD', function ($mrf) {
                return getDepartmentCode($mrf->SelectedForD);
            })

            ->make(true);
    }

    public function candidate_joining_report()
    {
        session()->put('submenu', 'candidate_joining_report');
        $candidate_list = DB::table('candjoining')
            ->select('jobcandidates.ReferenceNo', 'jobcandidates.FName', 'jobcandidates.LName', 'offerletterbasic.Company', 'offerletterbasic.Department', 'offerletterbasic.Designation', 'jobpost.JobCode', 'candjoining.Joined', 'candjoining.JoinOnDt', 'jobcandidates.FinalSubmit', 'candjoining.Verification', 'candjoining.ForwardToESS')
            ->join('jobapply', 'jobapply.JAId', '=', 'candjoining.JAId')
            ->join('jobcandidates', 'jobcandidates.JCId', '=', 'jobapply.JCId')
            ->join('offerletterbasic', 'offerletterbasic.JAId', '=', 'candjoining.JAId')
            ->join('jobpost', 'jobpost.JPId', '=', 'jobapply.JPId')
            ->get();
        $company_list = DB::table("master_company")->where('Status', 'A')->orderBy('CompanyCode', 'desc')->pluck("CompanyCode", "CompanyId");
        $department_list = DB::table("master_department")->where('DeptStatus', 'A')->orderBy('DepartmentName', 'asc')->pluck("DepartmentName", "DepartmentId");
        $months = [1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'];
        return view('reports.candidate_joining_report', compact(['company_list', 'department_list', 'months']));
    }

    public function get_candidate_joining_report(Request $request)
    {
        $usersQuery = CandidateJoining::query();
        $Company = $request->Company;
        $Department = $request->Department;
        $Year = $request->Year;
        $Month = $request->Month;
        if ($Company != '') {
            $usersQuery->where("offerletterbasic.Company", $Company);
        }
        if ($Department != '') {
            $usersQuery->where("offerletterbasic.Department", $Department);
        }
        if ($Year != '') {
            $usersQuery->whereBetween('offerletterbasic.LtrDate', [$Year . '-01-01', $Year . '-12-31']);
        }
        if ($Month != '') {
            if ($Year != '') {
                $usersQuery->whereBetween('offerletterbasic.LtrDate', [$Year . '-' . $Month . '-01', $Year . '-' . $Month . '-31']);
            } else {
                $usersQuery->whereBetween('offerletterbasic.LtrDate', [date('Y') . '-' . $Month . '-01', date('Y') . '-' . $Month . '-31']);
            }
        }

        $mrf =  $usersQuery->select(
            'jobcandidates.ReferenceNo',
            'jobcandidates.FName',
            'jobcandidates.LName',
            'offerletterbasic.Company',
            'offerletterbasic.Department',
            'offerletterbasic.Designation',
            'offerletterbasic.ServiceBond',
            'offerletterbasic.ServiceBondYears',
            'jobapply.ResumeSource',
            'jobpost.JobCode',
            'candjoining.Joined',
            'candjoining.JoinOnDt',
            'jobcandidates.FinalSubmit',
            'candjoining.Verification',
            'candjoining.ForwardToESS',
            'master_resumesource.ResumeSource as r1','users.name'
        )
            ->join('jobapply', 'jobapply.JAId', '=', 'candjoining.JAId')
            ->join('jobcandidates', 'jobcandidates.JCId', '=', 'jobapply.JCId')
            ->join('offerletterbasic', 'offerletterbasic.JAId', '=', 'candjoining.JAId')
            ->join('jobpost', 'jobpost.JPId', '=', 'jobapply.JPId')
            ->leftJoin('master_resumesource', 'master_resumesource.ResumeSouId', '=', 'jobapply.ResumeSource')
            ->leftJoin('users', 'users.id', '=', 'jobapply.SelectedBy')
            ->where('offerletterbasic.Answer', 'Accepted')
            ->orderby('candjoining.JoinOnDt', 'desc');
        return datatables()->of($mrf)
            ->addIndexColumn()
            ->editColumn('Company', function ($mrf) {
                return getCompanyCode($mrf->Company);
            })
            ->editColumn('Department', function ($mrf) {
                return getDepartmentCode($mrf->Department);
            })
            ->editColumn('Name', function ($mrf) {
                return $mrf->FName . ' ' . $mrf->MName . ' ' . $mrf->LName;
            })


            ->editColumn('Designation', function ($mrf) {
                return getDesignationCode($mrf->Designation);
            })

            ->editColumn('JoinOnDt', function ($mrf) {
                if ($mrf->JoinOnDt == '' || $mrf->JoinOnDt == null || $mrf->JoinOnDt == '0000-00-00') {
                    return '';
                } else {
                    return date('d-m-Y', strtotime($mrf->JoinOnDt));
                }
            })
            ->editColumn('FinalSubmit', function ($mrf) {
                if ($mrf->FinalSubmit == '1') {
                    return 'Yes';
                } else {
                    return 'No';
                }
            })
            ->editColumn('Verification', function ($mrf) {
                if ($mrf->Verification == 'Verified') {
                    return 'Yes';
                } else {
                    return 'No';
                }
            })

            ->editColumn('hiring_from',function($mrf){
                if($mrf->ResumeSource == '7'){
                    return 'Campus';
                }else{
                    return 'Non Campus';
                }
        
            })

            ->make(true);
    }

    public function getActiveMRFWiesData(Request $request)
    {
        $MRFId = $request->MRFId;
        $result = [];
        $total_applicant = jobapply::where('manpowerrequisition.MRFId', $MRFId)
            ->join('jobpost', 'jobpost.JPId', '=', 'jobapply.JPId')
            ->join('manpowerrequisition', 'manpowerrequisition.MRFId', '=', 'jobpost.MRFId')
            ->count();
        $result['Applications'] = $total_applicant;
        $hr_screening = jobapply::where('manpowerrequisition.MRFId', $MRFId)->where('jobapply.Status', 'Selected')
            ->join('jobpost', 'jobpost.JPId', '=', 'jobapply.JPId')
            ->join('manpowerrequisition', 'manpowerrequisition.MRFId', '=', 'jobpost.MRFId')
            ->count();
        $result['HR Screening'] = $hr_screening;
        $technical_screening = jobapply::where('manpowerrequisition.MRFId', $MRFId)->where('screening.ScreenStatus', 'Shortlist')
            ->join('jobpost', 'jobpost.JPId', '=', 'jobapply.JPId')
            ->join('screening', 'screening.JAId', '=', 'jobapply.JAId')
            ->join('manpowerrequisition', 'manpowerrequisition.MRFId', '=', 'jobpost.MRFId')
            ->count();
        $result['Technical Screening'] = $technical_screening;

        $first_interview = jobapply::where('manpowerrequisition.MRFId', $MRFId)->where('screening.IntervStatus', 'Selected')
            ->join('jobpost', 'jobpost.JPId', '=', 'jobapply.JPId')
            ->join('screening', 'screening.JAId', '=', 'jobapply.JAId')
            ->join('manpowerrequisition', 'manpowerrequisition.MRFId', '=', 'jobpost.MRFId')
            ->count();
        $result['1st Interview'] = $first_interview;

        $second_interview = jobapply::where('manpowerrequisition.MRFId', $MRFId)->where('screening.IntervStatus', '2nd Round Interview')->where('screen2ndround.IntervStatus2', 'Selected')
            ->join('jobpost', 'jobpost.JPId', '=', 'jobapply.JPId')
            ->join('screening', 'screening.JAId', '=', 'jobapply.JAId')
            ->join('screen2ndround', 'screen2ndround.ScId', '=', 'screening.ScId')
            ->join('manpowerrequisition', 'manpowerrequisition.MRFId', '=', 'jobpost.MRFId')
            ->count();
        $result['2nd Interview'] = $second_interview;

        $offer = jobapply::where('manpowerrequisition.MRFId', $MRFId)->where('offerletterbasic.OfferLetterSent', 'Yes')
            ->join('jobpost', 'jobpost.JPId', '=', 'jobapply.JPId')
            ->join('offerletterbasic', 'offerletterbasic.JAId', '=', 'jobapply.JAId')
            ->join('manpowerrequisition', 'manpowerrequisition.MRFId', '=', 'jobpost.MRFId')
            ->count();
        $result['Offer'] = $offer;

        $Joined = jobapply::where('manpowerrequisition.MRFId', $MRFId)->where('candjoining.Joined', 'Yes')
            ->join('jobpost', 'jobpost.JPId', '=', 'jobapply.JPId')
            ->join('candjoining', 'candjoining.JAId', '=', 'jobapply.JAId')
            ->join('manpowerrequisition', 'manpowerrequisition.MRFId', '=', 'jobpost.MRFId')
            ->count();
        $result['Joined'] = $Joined;
        $final = array();
        foreach ($result as $key => $value) {
            if ($value != 0) {
                $final[] = ['label' => $key, 'y' => $value];
            }
        }
        return $final;
    }

    public function mrf_status_open_days(Request $request)
    {
        $UserId = $request->UserId;
        $mrf_open_days = DB::table('jobpost')
            ->select('JobCode', DB::raw("DATEDIFF(CURRENT_DATE(), CreatedTime) as date_difference"))
            ->where('Status', '=', 'Open')
            /*   ->where('JobPostType', '=', 'Regular') */
            ->where('CreatedBy', '=', $UserId)
            ->get()->toArray();
        $dataPoints1 = array();
        foreach ($mrf_open_days as $key => $value) {
            $dataPoints1[] = ['label' => $value->JobCode, 'y' => $value->date_difference];
        }

        return $dataPoints1;
    }
}
