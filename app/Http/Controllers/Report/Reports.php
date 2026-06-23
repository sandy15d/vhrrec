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
use App\Exports\CandidateAptitudeReportExport;
use App\Exports\EmployeeFirobReportExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Admin\resumesource_master;


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
        $company_list = DB::table("core_company")->orderBy('company_code', 'desc')->pluck("company_code", "id");
        $department_list = DB::table("core_department")->where('is_active', '1')->orderBy('department_name', 'asc')->pluck("department_name", "id");
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
        $company_list = DB::table("core_company")->orderBy('company_code', 'desc')->pluck("company_code", "id");
        $department_list = DB::table("core_department")->where('is_active', '1')->orderBy('department_name', 'asc')->pluck("department_name", "id");
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
        $company_list = DB::table("core_company")->orderBy('company_code', 'desc')->pluck("company_code", "id");
        $department_list = DB::table("core_department")->where('is_active', '1')->orderBy('department_name', 'asc')->pluck("department_name", "id");
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
        $company_list = DB::table("core_company")->orderBy('company_code', 'desc')->pluck("company_code", "id");
        $department_list = DB::table("core_department")->where('is_active', '1')->orderBy('department_name', 'asc')->pluck("department_name", "id");
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
        $company_list = DB::table("core_company")->orderBy('company_code', 'desc')->pluck("company_code", "id");
        $department_list = DB::table("core_department")->where('is_active', '1')->orderBy('department_name', 'asc')->pluck("department_name", "id");
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
                return getcompany_code($mrf->SelectedForC);
            })
            ->editColumn('SelectedForD', function ($mrf) {
                return getDepartmentCode($mrf->SelectedForD);
            })

            ->make(true);
    }

    public function job_offer_report()
    {
        session()->put('submenu', 'job_offer_report');
        $company_list = DB::table("core_company")->orderBy('company_code', 'desc')->pluck("company_code", "id");
        $department_list = DB::table("core_department")->where('is_active', '1')->orderBy('department_name', 'asc')->pluck("department_name", "id");
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
                return getcompany_code($mrf->Company);
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
        $company_list = DB::table("core_company")->orderBy('company_code', 'desc')->pluck("company_code", "id");
        $department_list = DB::table("core_department")->where('is_active', '1')->orderBy('department_name', 'asc')->pluck("department_name", "id");
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
                return getcompany_code($mrf->Company);
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
    public function EmpFirobReports()
    {
        $company_list = DB::table('core_company')->orderBy('company_code')->pluck('company_code', 'id');
        $department_list = DB::table('core_department')->orderBy('department_name')->pluck('department_name', 'id');
        $grade_list = DB::table('core_grade')->orderBy('grade_name')->pluck('grade_name', 'id');
        $designation_list = DB::table('core_designation')->orderBy('designation_name')->pluck('designation_name', 'id');

        return view('reports.emp-firob-report', compact(
            'company_list',
            'department_list',
            'grade_list',
            'designation_list'
        ));
    }

    public function getEmpFirobSubDepartments(Request $request)
    {
        $request->validate([
            'Department' => ['required', 'integer'],
            'Company' => ['nullable', 'integer'],
        ]);

        $employeeSubDepartment = $this->employeeFirobSubDepartmentSummary();

        $subDepartments = DB::table('master_employee as employee')
            ->joinSub($employeeSubDepartment, 'employee_sub_department', function ($join) {
                $join->on('employee_sub_department.EmpCode', '=', 'employee.EmpCode');
            })
            ->join('core_sub_department as sub_department', 'sub_department.id', '=', 'employee_sub_department.SubDepartmentId')
            ->where('employee.EmpStatus', 'A')
            ->where('employee.DepartmentId', $request->Department)
            ->when($request->filled('Company'), function ($query) use ($request) {
                $query->where('employee.CompanyId', $request->Company);
            })
            ->select('sub_department.id', 'sub_department.sub_department_name')
            ->distinct()
            ->orderBy('sub_department.sub_department_name')
            ->get();

        return response()->json($subDepartments);
    }

    public function getEmpFirobReports(Request $request)
    {
        $firobSummary = DB::table('firob_user')
            ->select(
                'userid',
                DB::raw('COUNT(DISTINCT FirobId) as answer_count'),
                DB::raw('MAX(SubDate) as firob_date')
            )
            ->groupBy('userid');

        $employeeSubDepartment = $this->employeeFirobSubDepartmentSummary();

        $employees = DB::table('master_employee as employee')
            ->leftJoinSub($firobSummary, 'firob_summary', function ($join) {
                $join->on('firob_summary.userid', '=', 'employee.CandidateId');
            })
            ->leftJoin('core_company as company', 'company.id', '=', 'employee.CompanyId')
            ->leftJoin('core_grade as grade', 'grade.id', '=', 'employee.GradeId')
            ->leftJoin('core_designation as designation', 'designation.id', '=', 'employee.DesigId')
            ->leftJoin('core_department as department', 'department.id', '=', 'employee.DepartmentId')
            ->leftJoinSub($employeeSubDepartment, 'employee_sub_department', function ($join) {
                $join->on('employee_sub_department.EmpCode', '=', 'employee.EmpCode');
            })
            ->leftJoin('core_sub_department as sub_department', 'sub_department.id', '=', 'employee_sub_department.SubDepartmentId')
            ->where('employee.EmpStatus', 'A')
            ->select(
                'employee.EmployeeID',
                'employee.EmpCode',
                'employee.Fname',
                'employee.Sname',
                'employee.Lname',
                'employee.DOJ',
                'company.company_code',
                'grade.grade_name',
                'designation.designation_name',
                'department.department_name',
                'sub_department.sub_department_name',
                'employee.CandidateId as JCId',
                DB::raw('COALESCE(firob_summary.answer_count, 0) as answer_count'),
                'firob_summary.firob_date'
            );

        if ($request->filled('Company')) {
            $employees->where('employee.CompanyId', $request->Company);
        }
        if ($request->filled('Department')) {
            $employees->where('employee.DepartmentId', $request->Department);
        }
        if ($request->filled('SubDepartment')) {
            $employees->where('employee_sub_department.SubDepartmentId', $request->SubDepartment);
        }

        if ($request->filled('Designation')) {
            $employees->where('employee.DesigId', $request->Designation);
        }
        if ($request->FirobStatus === 'completed') {
            $employees->where('firob_summary.answer_count', '>=', 54);
        } elseif ($request->FirobStatus === 'incomplete') {
            $employees->whereBetween('firob_summary.answer_count', [1, 53]);
        } elseif ($request->FirobStatus === 'not_taken') {
            $employees->whereNull('firob_summary.answer_count');
        }

        return datatables()->of($employees)
            ->addIndexColumn()
            ->addColumn('employee_name', function ($employee) {
                return trim(implode(' ', array_filter([$employee->Fname, $employee->Sname, $employee->Lname])));
            })
            ->filterColumn('employee_name', function ($query, $keyword) {
                $query->whereRaw(
                    "CONCAT_WS(' ', employee.Fname, employee.Sname, employee.Lname) LIKE ?",
                    ['%'.$keyword.'%']
                );
            })
            ->editColumn('DOJ', function ($employee) {
                return $employee->DOJ ? date('d-m-Y', strtotime($employee->DOJ)) : '-';
            })
            ->editColumn('firob_date', function ($employee) {
                return $employee->firob_date ? date('d-m-Y', strtotime($employee->firob_date)) : '-';
            })
            ->addColumn('firob_result', function ($employee) {
                if ((int) $employee->answer_count >= 54 && $employee->JCId) {
                    $detailUrl = route('firob_result', ['jcid' => $employee->JCId]);

                    return '<a href="'.$detailUrl.'" target="_blank" class="text-success">Detail</a>';
                }

                if ((int) $employee->answer_count > 0) {
                    return '<span class="badge bg-warning text-dark">Incomplete ('.$employee->answer_count.'/54)</span>';
                }

                if ($employee->EmployeeID && $employee->EmpCode) {
                    $yarmsUrl = 'https://www.yarms.in/reg/vspl/findtreslt.php?'.http_build_query([
                        'tid' => 2,
                        'ei' => $employee->EmployeeID,
                        'ut' => 'intvi',
                        'ec' => $employee->EmpCode,
                    ]);

                    return '<a href="'.htmlspecialchars($yarmsUrl, ENT_QUOTES, 'UTF-8').'" '
                        .'target="_blank" rel="noopener" class="text-success">Detail</a>';
                }

                return '<span class="badge bg-secondary">Not Available</span>';
            })
            ->rawColumns(['firob_result'])
            ->make(true);
    }

    private function employeeFirobSubDepartmentSummary()
    {
        return DB::table('candjoining as joining')
            ->join('offerletterbasic as offer', 'offer.JAId', '=', 'joining.JAId')
            ->whereNotNull('joining.EmpCode')
            ->whereNotNull('offer.SubDepartment')
            ->where('offer.SubDepartment', '<>', '')
            ->where('offer.SubDepartment', '<>', 0)
            ->select(
                'joining.EmpCode',
                DB::raw('MAX(offer.SubDepartment) as SubDepartmentId')
            )
            ->groupBy('joining.EmpCode');
    }

    public function exportEmpFirobReports(Request $request)
    {
        $filters = $request->only([
            'Company',
            'Department',
            'SubDepartment',
            'Grade',
            'Designation',
            'FirobStatus',
        ]);

        return Excel::download(
            new EmployeeFirobReportExport($filters),
            'Employee_FIRO_B_Report_'.date('Ymd_His').'.xlsx'
        );
    }

}
