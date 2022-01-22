<?php

namespace App\Http\Controllers\Common;

use App\Helpers\CandidateActivityLog;
use App\Models\jobpost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Mail\InterviewMail;
use App\Models\jobapply;
use App\Models\jobcandidate;
use App\Models\OfferLetter;
use App\Models\screen2ndround;
use App\Models\screening;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use function App\Helpers\getCompanyCode;
use function App\Helpers\getCompanyName;
use function App\Helpers\getDepartment;
use function App\Helpers\getDepartmentCode;
use function App\Helpers\getFullName;


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

        $data =  $usersQuery->select('screening.*', 'jobapply.FwdTechScr', 'jobcandidates.JCId', 'jobcandidates.FName', 'jobcandidates.MName', 'jobcandidates.LName', 'jobcandidates.ReferenceNo', 'jobpost.JobCode', 'jobcandidates.BlackList')
            ->join('jobapply', 'jobapply.JAId', '=', 'screening.JAId')
            ->join('jobpost', 'jobapply.JPId', '=', 'jobpost.JPId')
            ->join('manpowerrequisition', 'manpowerrequisition.MRFId', '=', 'jobpost.MRFId')
            ->Join('jobcandidates', 'jobapply.JCId', '=', 'jobcandidates.JCId')
            ->where('manpowerrequisition.CountryId', session('Set_Country'))
            ->where('jobapply.FwdTechScr', 'Yes')
            ->where('jobpost.Status', 'Open')
            ->orderBy('ScId', 'DESC');

        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('chk', function ($data) {
                return '<input type="checkbox" class="japchks" data-id="' . $data->JAId . '" name="selectCand" id="selectCand" value="' . $data->JAId . '">';
            })
            ->addColumn('Name', function ($data) {
                $sendingId = base64_encode($data->JAId);
                return '<a href="' . route("candidate_detail", "jaid=$sendingId") . '" target="_blank">' . $data->FName . ' ' . $data->MName . ' ' . $data->LName . '</a>';
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
                if ($data->BlackList == 1) {
                    return '';
                } else {
                    return '<i class="fa fa-pencil text-dark" style="cursor:pointer" onclick="return EditTracker(' . $data->JAId . ');"></i>';
                }
            })
            ->editColumn('travelElg', function ($data) {
                return unserialize($data->travelEligibility);
            })
            ->editColumn('interviewTime', function ($data) {
                return date('h:i a', strtotime($data->IntervTime));
            })
            ->rawColumns(['chk', 'Name', 'InterviewMail', 'Action'])
            ->make(true);
    }


    public function getScreenDetail(Request $request)
    {
        $JAId = $request->JAId;
        $sql = DB::table('screening')->select('screening.*', 'master_employee.Fname', 'master_employee.Sname', 'master_employee.Lname')->join('master_employee', 'screening.ScreeningBy', '=', 'master_employee.EmployeeID')->where('JAId', $JAId)->get();
        $travelDetail = unserialize($sql[0]->travelEligibility);
        return response()->json(['CandidateDetail' => $sql[0], 'travelDetail' => $travelDetail]);
    }

    public function CandidateTechnicalScreening(Request $request)
    {

        $JAId = $request->JAId;
        $sendingId = base64_encode($JAId);
        $TechScreenStatus = $request->TechScreenStatus;
        $InterviewSchedule = $request->InterviewSchedule;
        $RejectRemark = $request->RejectRemark;
        $InterviewDate = $request->InterviewDate;
        $InterviewTime = $request->InterviewTime;
        $InterviewLocation = $request->InterviewLocation;
        $InterviewPannel = $request->InterviewPannel;
        $TravelElg = serialize($request->TravelElg);
        $InterviewMail = $request->InterviewMail;
        $BlackList = $request->BlackList;
        $BlackListRemark = $request->BlackListRemark;

        $curDate = date('Y-m-d');
        $sql = DB::table('screening')
            ->where('JAId', $JAId)
            ->update(['ResScreened' => $curDate, 'ScreenStatus' => $TechScreenStatus, 'InterviewMode' => $InterviewSchedule, 'RejectionRem' => $RejectRemark, 'IntervDt' => $InterviewDate, 'IntervTime' => $InterviewTime, 'IntervLoc' => $InterviewLocation, 'IntervPanel' => $InterviewPannel, 'travelEligibility' => $TravelElg, 'SendInterMail' => $InterviewMail, 'UpdatedBy' => Auth::user()->id, 'LastUpdated' => now()]);

        $jobapply = jobapply::find($JAId);
        $JCId = $jobapply->JCId;
        $firobid = base64_encode($JCId);
        $JPId = $jobapply->JPId;

        $jobpost = jobpost::find($JPId);
        $Title = $jobpost->Title;

        $jobcandidates = jobcandidate::find($JCId);
        $Aadhaar = $jobcandidates->Aadhaar;
        $CandidateEmail = $jobcandidates->Email;
        $Company = $jobapply->Company;
        $CompanyName = getCompanyName($Company);

        if ($BlackList == 1) {
            $query1 = jobcandidate::find($JCId);
            $query1->BlackList = $BlackList;
            $query1->BlackListRemark = $BlackListRemark;
            $query1->save();
            CandidateActivityLog::addToCandLog($JCId, $query1->Aadhaar, 'Candidate is BlackListed because ' . $BlackListRemark);
        }

        if ($TechScreenStatus == 'Shortlist' && $InterviewMail == 'Yes') {
            $details = [
                "subject" => 'Interview Call Letter-' . $CompanyName,
                "name" => $jobcandidates->FName . ' ' . $jobcandidates->MName . ' ' . $jobcandidates->LName,
                "reference_no" => $jobcandidates->ReferenceNo,
                "title" => $jobpost->Title,
                "interview_date"   => $InterviewDate,
                "interview_time" => $InterviewTime,
                "interview_venue" => $InterviewLocation,
                "contact_person" => getFullName(Auth::user()->id),
                'interview_form' => route("candidate-interview-form", "jaid=$sendingId"),
                'firob' =>  route("firo_b", "jcid=$firobid")
            ];
            Mail::to($CandidateEmail)->send(new InterviewMail($details));
        }

        if (isset($request->RegretMail) && $request->RegretMail == 'Yes') {
            $details = [];
            //  Mail::to($CandidateEmail)->send(new RegretMail($details));
        }

        if (!$sql) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {
            CandidateActivityLog::addToCandLog($JCId, $Aadhaar, 'Candidate Technical Screening Status- ' . $TechScreenStatus);
            return response()->json(['status' => 200, 'msg' => 'Technical Screening Data has been changed successfully.']);
        }
    }

    public function interview_tracker()
    {
        $company_list = DB::table("master_company")->where('Status', 'A')->orderBy('CompanyCode', 'desc')->pluck("CompanyCode", "CompanyId");
        $months = [1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'];
        return view('common.interview_tracker', compact('company_list', 'months'));
    }

    public function getInterviewTrackerCandidate(Request $request)
    {
        $usersQuery = screening::query();
        $Company = $request->Company;
        $Department = $request->Department;
        $Mrf = $request->Mrf;


        if (Auth::user()->role == 'R') {
            $usersQuery->where('jp.CreatedBy', Auth::user()->id);
        }
        if ($Company != '') {
            $usersQuery->where("screening.ScrCmp", $Company);
        }
        if ($Department != '') {
            $usersQuery->where("screening.ScrDpt", $Department);
        }
        if ($Mrf != '') {
            $usersQuery->where("jp.JPId", $Mrf);
        }

        $data = $usersQuery->select('screening.*', 'jc.ReferenceNo', 'jc.FName', 'jc.MName', 'jc.LName', 'jp.JobCode', 'sc.IntervDt2', 'sc.IntervLoc2', 'sc.IntervPanel2', 'sc.IntervStatus2')
            ->Join('jobapply as ja', 'ja.JAId', '=', 'screening.JAId')
            ->Join('jobcandidates as jc', 'ja.JCId', '=', 'jc.JCId')
            ->Join('jobpost as jp', 'ja.JPId', '=', 'jp.JPId')
            ->join('manpowerrequisition as mp', 'mp.MRFId', '=', 'jp.MRFId')
            ->join('screen2ndround as sc', 'screening.ScId', '=', 'sc.ScId', 'left')
            ->where('mp.CountryId', session('Set_Country'))
            ->where('jp.JobPostType', 'Regular')
            ->where('jp.Status', 'Open')
            ->where('screening.ScreenStatus', 'Shortlist')
            ->orderBy('ScId', 'DESC');

        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('chk', function () {
                return '<input type="checkbox" class="select_all">';
            })
            ->editColumn('Department', function ($data) {
                return getDepartmentCode($data->ScrDpt);
            })


            ->addColumn('Name', function ($data) {
                $sendingId = base64_encode($data->JAId);
                return '<a href="' . route("candidate_detail", "jaid=$sendingId") . '" target="_blank">' . $data->FName . ' ' . $data->MName . ' ' . $data->LName . '</a>';
            })

            ->editColumn('IntervEdit', function ($data) {
                return '<i class="fa fa-pencil-square-o text-primary d-inline" aria-hidden="true" id="editInt' . $data->JAId . '" onclick="editInt(' . $data->JAId . ',' . $data->ScId . ')" style="font-size: 16px;cursor: pointer;"></i>';
            })
            ->editColumn('IntervDt2', function ($data) {
                if ($data->IntervDt2 != null) {
                    return $data->IntervDt2;
                } else {
                    return '';
                }
            })
            ->editColumn('IntervLoc2', function ($data) {
                if ($data->IntervLoc2 != null) {
                    return $data->IntervLoc2;
                } else {
                    return '';
                }
            })
            ->editColumn('IntervPanel2', function ($data) {
                if ($data->IntervPanel2 != null) {
                    return $data->IntervPanel2;
                } else {
                    return '';
                }
            })
            ->editColumn('IntervStatus2', function ($data) {
                if ($data->IntervStatus2 != null) {
                    return $data->IntervStatus2;
                } else {
                    return '';
                }
            })
            ->editColumn('IntervEdit2', function ($data) {
                if ($data->IntervStatus == '2nd Round Interview') {
                    return '<i class="fa fa-pencil-square-o text-primary d-inline" aria-hidden="true" id="editInt_2nd' . $data->JAId . '" onclick="editInt_2nd(' . $data->JAId . ',' . $data->ScId . ')" style="font-size: 16px;cursor: pointer;"></i>';
                } else {
                    return '';
                }
            })
            ->editColumn('CompanyEdit', function ($data) {
                if ($data->IntervStatus == 'Selected' || $data->IntervStatus2 == 'Selected') {
                    return '<i class="fa fa-pencil-square-o text-primary d-inline" aria-hidden="true" id="companyedit' . $data->JAId . '" onclick="editCompany(' . $data->JAId . ',' . $data->ScId . ')" style="font-size: 16px;cursor: pointer;"></i>';
                } else {
                    return '';
                }
            })

            ->editColumn('SelectedForC', function ($data) {
                if ($data->SelectedForC != null) {
                    return getCompanyCode($data->SelectedForC);
                } else {
                    return '';
                }
            })
            ->editColumn('SelectedForD', function ($data) {
                if ($data->SelectedForD != null) {
                    return getDepartmentCode($data->SelectedForD);
                } else {
                    return '';
                }
            })
            ->rawColumns(['chk', 'Name', 'IntervEdit', 'IntervEdit2', 'CompanyEdit'])
            ->make(true);
    }

    public function first_round_interview(Request $request)
    {
        $sql = screening::find($request->ScId);
        $sql->InterAtt = 'Yes';
        $sql->IntervStatus = $request->IntervStatus;
        $sql->save();
        $JAId = $sql->JAId;
        $query = DB::table('jobapply')->join('jobcandidates', 'jobcandidates.JCId', '=', 'jobapply.JCId')->select('jobcandidates.JCId', 'jobcandidates.Aadhaar')->where('JAId', $JAId)->first();

        if (!$sql) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {
            CandidateActivityLog::addToCandLog($query->JCId, $query->Aadhaar, 'Candidate Interview Status - ' . $request->IntervStatus);
            return response()->json(['status' => 200, 'msg' => '1st Interview Data has been changed successfully.']);
        }
    }

    public function second_round_interview(Request $request)
    {

        $SCId = $request->ScId_2nd;
        $IntervDt2 = $request->IntervDt2;
        $IntervLoc2 = $request->IntervLoc2;
        $IntervPanel2 = $request->IntervPanel2;
        $IntervStatus2 = $request->IntervStatus2;


        $query = DB::table('screen2ndround')->select('*')->where('ScId', $SCId)->get();
        $count =    $query->count();
        if ($count > 0) {
            $sql = DB::table('screen2ndround')
                ->where('ScId', $SCId)
                ->update(['IntervStatus2' => $IntervStatus2, 'IntervDt2' => $IntervDt2, 'IntervLoc2' => $IntervLoc2, 'IntervPanel2' => $IntervPanel2, 'LastUpdated' => now(), 'UpdatedBy' => Auth::user()->id]);
        } else {
            //insert
            $sql = new screen2ndround;
            $sql->InterAtt2 = 'Yes';
            $sql->ScId = $SCId;
            $sql->IntervDt2 = $IntervDt2;
            $sql->IntervLoc2 = $IntervLoc2;
            $sql->IntervPanel2 = $IntervPanel2;
            $sql->IntervStatus2 = $IntervStatus2;
            $sql->CreatedTime = now();
            $sql->CreatedBy = Auth::user()->id;
            $sql->save();
        }

        $sql = screening::find($SCId);
        $JAId = $sql->JAId;
        $query = DB::table('jobapply')->join('jobcandidates', 'jobcandidates.JCId', '=', 'jobapply.JCId')->select('jobcandidates.JCId', 'jobcandidates.Aadhaar')->where('JAId', $JAId)->first();
        CandidateActivityLog::addToCandLog($query->JCId, $query->Aadhaar, 'Candidate 2nd Round Interview Status - ' . $IntervStatus2);
        if (!$sql) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {
            return response()->json(['status' => 200, 'msg' => '2nd Interview Data has been changed successfully.']);
        }
    }

    public function select_cmp_dpt_for_candidate(Request $request)
    {
        $sql = screening::find($request->ScId_cmp);
        $sql->SelectedForC = $request->SelectedForC;
        $sql->SelectedForD = $request->SelectedForD;
        $sql->save();

        $JAId = $sql->JAId;

        $query = new OfferLetter;
        $query->JAId = $JAId;
        $query->Company = $request->SelectedForC;
        $query->Department = $request->SelectedForD;
        $query->CreatedTime = now();
        $query->Year = date('Y');
        $query->CreatedBy = Auth::user()->id;
        $query->save();

        $query = DB::table('jobapply')->join('jobcandidates', 'jobcandidates.JCId', '=', 'jobapply.JCId')->select('jobcandidates.JCId', 'jobcandidates.Aadhaar')->where('JAId', $JAId)->first();
      
        if (!$query) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {
            CandidateActivityLog::addToCandLog($query->JCId, $query->Aadhaar, 'Candidate Slected For - ' . getDepartmentCode($request->SelectedForD) . ' - ' . getCompanyCode($request->SelectedForC));
            return response()->json(['status' => 200, 'msg' => 'Data has been changed successfully.']);
        }
    }
}
