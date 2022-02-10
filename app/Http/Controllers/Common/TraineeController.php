<?php

namespace App\Http\Controllers\Common;

use App\Helpers\CandidateActivityLog;
use App\Http\Controllers\Controller;
use App\Models\jobcandidate;
use App\Models\jobpost;
use App\Models\master_mrf;
use App\Models\screening;
use App\Models\trainee_apply;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function App\Helpers\CheckJobPostCreated;
use function App\Helpers\convertData;
use function App\Helpers\getDepartment;
use function App\Helpers\getDistrictName;
use function App\Helpers\getEducationById;
use function App\Helpers\getFullName;
use function App\Helpers\getSpecializationbyId;
use function App\Helpers\getStateCode;

class TraineeController extends Controller
{
    public function trainee_mrf_allocated()
    {
        $company_list = DB::table("master_company")->where('Status', 'A')->orderBy('CompanyCode', 'desc')->pluck("CompanyCode", "CompanyId");
        $department_list = DB::table("master_department")->where('DeptStatus', 'A')->orderBy('DepartmentName', 'asc')->pluck("DepartmentName", "DepartmentId");
        $state_list = DB::table("states")->orderBy('StateName', 'asc')->pluck("StateName", "StateId");
        $institute_list = DB::table("master_institute")->orderBy('InstituteName', 'asc')->pluck("InstituteName", "InstituteId");
        $designation_list = DB::table("master_designation")->where('DesigName', '!=', '')->orderBy('DesigName', 'asc')->pluck("DesigName", "DesigId");
        $employee_list = DB::table('master_employee')->orderBy('FullName', 'ASC')
            ->where('EmpStatus', 'A')
            ->select('EmployeeID', DB::raw('CONCAT(Fname, " ", Lname) AS FullName'))
            ->pluck("FullName", "EmployeeID");
        $months = [1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'];


        $close =  DB::table('manpowerrequisition');
        if (Auth::user()->role == 'R') {

            $close->where('Allocated', Auth::user()->id);
        }
        $close->where(function ($query) {
            $query->where('Type', 'SIP')
                ->orWhere('Type', 'SIP_HrManual');
        })
            ->where('status', 'Close')
            ->select('MRFId')
            ->get();
        $CloseMRF = $close->count();



        $open = DB::table('manpowerrequisition');
        if (Auth::user()->role == 'R') {
            $open->where('Allocated', Auth::user()->id);
        }
        $open->where(function ($query1) {
            $query1->where('Type', 'SIP')
                ->orWhere('Type', 'SIP_HrManual');
        })
            ->where('status', '!=', 'Close')
            ->select('MRFId')
            ->get();
        $OpenMRF = $open->count();
        return view('recruiter.trainee_mrf_allocated ', compact('company_list', 'department_list', 'state_list', 'institute_list', 'designation_list', 'employee_list', 'months', 'CloseMRF', 'OpenMRF'));
    }

    public function getAllTraineeAllocatedMrf(Request $request)
    {

        $usersQuery = master_mrf::query();
        $Company = $request->Company;
        $Department = $request->Department;
        $Year = $request->Year;
        $Month = $request->Month;

        if (Auth::user()->role == 'R') {
            $usersQuery->where('Allocated', Auth::user()->id);
        }
        if ($Company != '') {
            $usersQuery->where("manpowerrequisition.CompanyId", $Company);
        }
        if ($Department != '') {
            $usersQuery->where("manpowerrequisition.DepartmentId", $Department);
        }
        if ($Year != '') {
            $usersQuery->whereBetween('manpowerrequisition.CreatedTime', [$Year . '-01-01', $Year . '-12-31']);
        }
        if ($Month != '') {
            if ($Year != '') {
                $usersQuery->whereBetween('manpowerrequisition.CreatedTime', [$Year . '-' . $Month . '-01', $Year . '-' . $Month . '-31']);
            } else {
                $usersQuery->whereBetween('manpowerrequisition.CreatedTime', [date('Y') . '-' . $Month . '-01', date('Y') . '-' . $Month . '-31']);
            }
        }

        if ($request->MrfStatus == 'Open') {
            $usersQuery->where('manpowerrequisition.Status', '!=', 'Close');
        } else {
            $usersQuery->where('manpowerrequisition.Status', 'Close');
        }

        $mrf = $usersQuery->select('*')
            ->Join('master_designation', 'manpowerrequisition.DesigId', '=', 'master_designation.DesigId', 'left')
            ->Join('master_department', 'manpowerrequisition.DepartmentId', '=', 'master_department.DepartmentId')
            ->where(function ($query) {
                $query->where('manpowerrequisition.Type', 'SIP')
                    ->orWhere('manpowerrequisition.Type', 'SIP_HrManual');
            });


        return datatables()->of($mrf)
            ->addIndexColumn()
            ->addColumn('chk', function () {
                return '<input type="checkbox" class="select_all">';
            })

            ->editColumn('LocationIds', function ($mrf) {
                if ($mrf->LocationIds != '') {

                    $location = unserialize($mrf->LocationIds);
                    $loc = '';
                    foreach ($location as $key => $value) {
                        if ($value['city'] != '') {
                            $city = $value['city'];
                        } else {
                            $city = 0;
                        }
                        $loc .= getDistrictName($city) . ' ';
                        $loc .= getStateCode($value['state']) . ' - ';
                        $loc .= $value['nop'];
                        $loc . '<br>';
                    }
                    return $loc;
                } else {
                    return '';
                }
            })

            ->addColumn('JobPost', function ($mrf) {
                $check = CheckJobPostCreated($mrf->MRFId);
                if ($check == 1) {
                    return 'Created';
                } else {
                    return '<a  href="javascript:void(0);" data-bs-toggle="modal"
                    data-bs-target="#createpostmodal" onclick="getDetailForJobPost(' . $mrf->MRFId . ')"><i class="fa fa-plus-square-o"></i>Create</a>';
                }
            })

            ->addColumn('JobShow', function ($mrf) {
                $check = CheckJobPostCreated($mrf->MRFId);
                if ($check == 1) {
                    $sql = Db::table('jobpost')->select('PostingView', 'JPId')->where('MRFId', $mrf->MRFId)->first();
                    $PostView = $sql->PostingView;

                    $x = '<select name="PostingView" id="postStatus' . $mrf->MRFId . '" class="form-control form-select form-select-sm  d-inline" disabled style="width: 100px;" onchange="ChngPostingView(' . $sql->JPId . ',this.value)">';

                    if ($PostView == 'Show') {
                        $x .= '<option value="Show" selected>Show</option><option value="Hidden">Hidden</option>';
                    } else {
                        $x .= '<option value="Show">Show</option><option value="Hidden" selected>Hidden</option>';
                    }

                    $x .= '</select> <i class="fa fa-pencil-square-o text-primary d-inline" aria-hidden="true" id="mrfedit' . $mrf->MRFId . '" onclick="editmrf(' . $mrf->MRFId . ')" style="font-size: 16px;cursor: pointer;"></i>';
                    return $x;
                } else {
                    return '';
                }
            })

            ->addColumn('details', function ($mrf) {
                $x = '';
                $x .= '<i  class="fadeIn animated lni lni-eye  text-primary view" aria-hidden="true" data-id="' . $mrf->MRFId . '" id="viewMRF" title="View MRF" style="font-size: 18px;cursor: pointer;"></i> ';
                if ($mrf->Status == 'Approved') {
                    $x .= '   <i  class="fadeIn animated bx bx-window-close  text-danger closemrf" aria-hidden="true" data-id="' . $mrf->MRFId . '" id="closemrf"  style="font-size: 18px;cursor: pointer;" title="Close MRF"></i>';
                }
                return $x;
            })

            ->rawColumns(['chk', 'details', 'JobPost', 'JobShow'])
            ->make(true);
    }

    public function trainee_applications()
    {
        $company_list = DB::table("master_company")->where('Status', 'A')->orderBy('CompanyCode', 'desc')->pluck("CompanyCode", "CompanyId");
        $months = [1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'];
        return view('common.trainee_applications', compact('company_list', 'months'));
    }

    public  function getTraineeSummary(Request $request)
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



        $data = $usersQuery->select('jobpost.JPId', 'trainee_apply.Company', 'trainee_apply.Department', 'JobCode',  DB::raw('COUNT(trainee_apply.TId) AS TraineeApplied'))
            ->Join('trainee_apply', 'jobpost.JPId', '=', 'trainee_apply.JPId')
            ->groupBy('jobpost.JPId');


        return datatables()->of($data)
            ->addIndexColumn()

            ->addColumn('chk', function () {
                return '<input type="checkbox" class="select_all">';
            })

            ->editColumn('Department', function ($data) {
                return getDepartment($data->Department);
            })


            ->editColumn('TraineeApplied', function ($data) {
                return '<a href="javascript:void(0);" class="btn btn-xs btn-warning" onclick="return getCandidate(' . $data->JPId . ');">' . $data->TraineeApplied . '</a>';
            })

            ->rawColumns(['chk', 'TraineeApplied'])
            ->make(true);
    }

    public function getTraieeCandidates(Request $request)
    {
        $data =  DB::table('trainee_apply')
            ->Join('jobcandidates', 'trainee_apply.JCId', '=', 'jobcandidates.JCId')

            ->where('trainee_apply.JPId', $request->JPId);

        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('chk', function ($data) {


                if ($data->FwdTechScr == 1) {
                    return '';
                } else {
                    return "<input type='checkbox' class='japchks' data-id='$data->TId' name='selectCand' id='selectCand' value='$data->TId'>";
                }
            })


            ->addColumn('CandidateName', function ($data) {
                return $data->FName . ' ' . $data->MName . ' ' . $data->LName;
            })
            ->addColumn('Qualification', function ($data) {
                $x = getEducationById($data->Education);
                if ($data->Specialization != 0) {
                    $x .= '-' . getSpecializationbyId($data->Specialization);
                }
                return $x;
            })

            ->rawColumns(['chk'])
            ->make(true);
    }

    public function SendTraineeForScreening(Request $request)
    {
        $TId = $request->TId;
        $sql = 0;
        for ($i = 0; $i < Count($TId); $i++) {

            $query = trainee_apply::find($TId[$i]);
            $query->FwdTechScr = 1;
            $query->ResSentDate = $request->ResumeSent;
            $query->ScrCmp = $request->TechScrCompany;
            $query->ScreeningBy = $request->ScreeningBy;
            $query->save();
            $sql = 1;
        }

        if ($sql == 0) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {
            return response()->json(['status' => 200, 'msg' => 'Candidate Successfully Forwaded for Technical Screening.']);
        }
    }

    public function trainee_screening_tracker()
    {
        $company_list = DB::table("master_company")->where('Status', 'A')->orderBy('CompanyCode', 'desc')->pluck("CompanyCode", "CompanyId");
        $months = [1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'];
        return view('common.trainee_screening_tracker', compact('company_list', 'months'));
    }

    public  function getTraineeScreeningCandidates(Request $request)
    {

        $usersQuery = trainee_apply::query();
        $Company = $request->Company;
        $Department = $request->Department;
        $Year = $request->Year;
        $Month = $request->Month;

        if (Auth::user()->role == 'R') {
            $usersQuery->where('jobpost.CreatedBy', Auth::user()->id);
        }
        if ($Company != '') {
            $usersQuery->where("trainee_apply.Company", $Company);
        }
        if ($Department != '') {
            $usersQuery->where("trainee_apply.Department", $Department);
        }
        if ($Year != '') {
            $usersQuery->whereBetween('trainee_apply.ApplyDate', [$Year . '-01-01', $Year . '-12-31']);
        }
        if ($Month != '') {
            if ($Year != '') {
                $usersQuery->whereBetween('trainee_apply.ApplyDate', [$Year . '-' . $Month . '-01', $Year . '-' . $Month . '-31']);
            } else {
                $usersQuery->whereBetween('trainee_apply.ApplyDate', [date('Y') . '-' . $Month . '-01', date('Y') . '-' . $Month . '-31']);
            }
        }

        $data = $usersQuery->select('trainee_apply.*', 'jc.ReferenceNo', 'jc.FName', 'jc.MName', 'jc.LName', 'jobpost.JobCode')
            ->Join('jobcandidates as jc', 'trainee_apply.JCId', '=', 'jc.JCId')
            ->Join('jobpost', 'jobpost.JPId', '=', 'trainee_apply.JPId')
            ->where('trainee_apply.FwdTechScr', '1');

        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('chk', function () {
                return '<input type="checkbox" class="select_all">';
            })
            ->editColumn('Department', function ($data) {
                return getDepartment($data->Department);
            })

            ->addColumn('CandidateName', function ($data) {
                return $data->FName . ' ' . $data->MName . ' ' . $data->LName;
            })

            ->editColumn('ScreenStatus', function ($data) {
                $x = '<select id="ScreenStatus' . $data->TId . '" class="form-control form-select form-select-sm  d-inline" disabled style="width: 100px;" onchange="ChngScreenStatus(' . $data->TId . ',this.value)">';

                $x .= '<option value="" selected></option>';
                $x .= '<option value="Shortlist"';
                $x .= ($data->ScreenStatus == 'Shortlist') ? 'selected' : '';
                $x .= '>Shortlist</option>';
                $x .= '<option value="Reject"';
                $x .= ($data->ScreenStatus == 'Reject') ? 'selected' : '';
                $x .= '>Reject</option>';
                $x .= '</select> <i class="fa fa-pencil-square-o text-primary d-inline" aria-hidden="true" id="ScreenStatusEdit' . $data->TId . '" onclick="editScreenStatus(' . $data->TId . ')" style="font-size: 16px;cursor: pointer;"></i>';
                return $x;
            })
            ->editColumn('ScreenBy', function ($data) {
                $x = getFullName($data->ScreeningBy);
                return $x;
            })

            ->editColumn('IntervEdit', function ($data) {
                if ($data->ScreenStatus == 'Shortlist') {
                    return '<i class="fa fa-pencil-square-o text-primary d-inline" aria-hidden="true" id="editInt' . $data->TId . '" onclick="editInt(' . $data->TId . ')" style="font-size: 16px;cursor: pointer;"></i>';
                } else {
                    return '';
                }
            })

            ->rawColumns(['chk', 'ScreenStatus', 'ScreenBy', 'IntervEdit'])
            ->make(true);
    }

    public function ChngTraineeScreenStatus(Request $request)
    {
        $query = trainee_apply::where('TId', $request->TId)
            ->update(['ScreenStatus' => $request->va, 'LastUpdated' => now(), 'UpdatedBy' => Auth::user()->id]);
        if (!$query) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {

            return response()->json(['status' => 200, 'msg' => 'Screening Status has been changed successfully.']);
        }
    }


    public function getTraineeName(Request $request)
    {
        $sql = DB::table('trainee_apply')
            ->Join('jobcandidates', 'trainee_apply.JCId', '=', 'jobcandidates.JCId')
            ->where('trainee_apply.TId', $request->TId)
            ->select('jobcandidates.FName', 'jobcandidates.MName', 'jobcandidates.LName')
            ->get();

        return $sql[0]->FName . ' ' . $sql[0]->MName . ' ' . $sql[0]->LName;
    }

    public function SaveTraineeInterview(Request $request)
    {
        $sql = trainee_apply::find($request->TId);
        $sql->IntervDt = $request->IntervDt;
        $sql->IntervLoc = $request->IntervLoc;
        $sql->IntervPanel = $request->IntervPanel;
        $sql->IntervStatus = $request->IntervStatus;
        $sql->save();
        if (!$sql) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {
            return response()->json(['status' => 200, 'msg' => 'Interview Data has been changed successfully.']);
        }
    }

    public function active_trainee()
    {
        $company_list = DB::table("master_company")->where('Status', 'A')->orderBy('CompanyCode', 'desc')->pluck("CompanyCode", "CompanyId");
        $months = [1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'];
        return view('common.active_trainee', compact('company_list', 'months'));
    }

    public function get_active_trainee(Request $request)
    {
        $usersQuery = trainee_apply::query();
        $Company = $request->Company;
        $Department = $request->Department;
        $Year = $request->Year;
        $Month = $request->Month;

        if (Auth::user()->role == 'R') {
            $usersQuery->where('jobpost.CreatedBy', Auth::user()->id);
        }
        if ($Company != '') {
            $usersQuery->where("trainee_apply.Company", $Company);
        }
        if ($Department != '') {
            $usersQuery->where("trainee_apply.Department", $Department);
        }
        if ($Year != '') {
            $usersQuery->whereBetween('trainee_apply.ApplyDate', [$Year . '-01-01', $Year . '-12-31']);
        }
        if ($Month != '') {
            if ($Year != '') {
                $usersQuery->whereBetween('trainee_apply.ApplyDate', [$Year . '-' . $Month . '-01', $Year . '-' . $Month . '-31']);
            } else {
                $usersQuery->whereBetween('trainee_apply.ApplyDate', [date('Y') . '-' . $Month . '-01', date('Y') . '-' . $Month . '-31']);
            }
        }

        $data = $usersQuery->select('trainee_apply.*', 'jc.ReferenceNo', 'jc.FName', 'jc.MName', 'jc.LName', 'jobpost.JobCode')
            ->Join('jobcandidates as jc', 'trainee_apply.JCId', '=', 'jc.JCId')
            ->Join('jobpost', 'jobpost.JPId', '=', 'trainee_apply.JPId')
            ->where('trainee_apply.IntervStatus', 'Selected')
            ->where('trainee_apply.TrainingComplete', '0');

        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('chk', function () {
                return '<input type="checkbox" class="select_all">';
            })
            ->editColumn('Department', function ($data) {
                return getDepartment($data->Department);
            })

            ->addColumn('CandidateName', function ($data) {
                return $data->FName . ' ' . $data->MName . ' ' . $data->LName;
            })

            ->addColumn('Action', function ($data) {
                return ' <i class="fa fa-pencil-square-o text-primary d-inline" aria-hidden="true" onclick="edit_detail(' . $data->TId . ')" style="font-size: 16px;cursor: pointer; margin-right:20px;"></i>  <i class="fas fa-rupee-sign text-danger d-inline" aria-hidden="true" onclick="addexpense(' . $data->TId . ')" style="font-size: 16px;cursor: pointer; margin-right:20px;"></i> <i class="fas fa-eye text-success d-inline" aria-hidden="true" onclick="view_expense(' . $data->TId . ')" style="font-size: 16px;cursor: pointer;"></i>';
            })

            ->editColumn('OtherBenefit', function ($data) {
                if ($data->OtherBenefit != null) {
                    return $data->OtherBenefit;
                } else {
                    return '-';
                }
            })


            ->rawColumns(['chk', 'Action', 'OtherBenefit'])
            ->make(true);
    }

    public function getTraineeDetail(Request $request)
    {
        $TId = $request->TId;
        $query = DB::table('trainee_apply')->Join('jobcandidates', 'jobcandidates.JCId', '=', 'trainee_apply.JCId')->where('TId', $TId)->first();
        return $query;
    }

    public function save_trainee_detail(Request $request)
    {
        $TId = $request->TId;
        $Stipend = $request->Stipend;
        $Doj = $request->Doj;
        $Doc = $request->Doc;
        $OtherBenefit = convertData($request->OtherBenefit);
        $TrainingComplete = $request->TrainingComplete;
        $query = trainee_apply::where('TId', $TId)->update(['Stipend' => $Stipend, 'Doj' => $Doj, 'Doc' => $Doc, 'OtherBenefit' => $OtherBenefit, 'TrainingComplete' => $TrainingComplete, 'LastUpdated' => date('Y-m-d H:i:s')]);
        if (!$query) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {
            return response()->json(['status' => 200, 'msg' => 'Trainee Detail has been changed successfully.']);
        }
    }

    public function old_trainee()
    {
        $company_list = DB::table("master_company")->where('Status', 'A')->orderBy('CompanyCode', 'desc')->pluck("CompanyCode", "CompanyId");
        $months = [1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'];
        $job = jobpost::query();
        if (Auth::user()->role == 'R') {
            $job->where('CreatedBy', Auth::user()->id);
        }
        $jobpost_list = $job->select('JPId', 'JobCode')
            ->where('Status', 'Open')
            ->where('JobPostType', 'Regular')
            ->get();
        return view('common.old_trainee', compact('company_list', 'months', 'jobpost_list'));
    }

    public function get_old_trainee(Request $request)
    {
        $usersQuery = trainee_apply::query();
        $Company = $request->Company;
        $Department = $request->Department;
        $Year = $request->Year;
        $Month = $request->Month;

        if (Auth::user()->role == 'R') {
            $usersQuery->where('jobpost.CreatedBy', Auth::user()->id);
        }
        if ($Company != '') {
            $usersQuery->where("trainee_apply.Company", $Company);
        }
        if ($Department != '') {
            $usersQuery->where("trainee_apply.Department", $Department);
        }
        if ($Year != '') {
            $usersQuery->whereBetween('trainee_apply.ApplyDate', [$Year . '-01-01', $Year . '-12-31']);
        }
        if ($Month != '') {
            if ($Year != '') {
                $usersQuery->whereBetween('trainee_apply.ApplyDate', [$Year . '-' . $Month . '-01', $Year . '-' . $Month . '-31']);
            } else {
                $usersQuery->whereBetween('trainee_apply.ApplyDate', [date('Y') . '-' . $Month . '-01', date('Y') . '-' . $Month . '-31']);
            }
        }

        $data = $usersQuery->select('trainee_apply.*', 'jc.ReferenceNo', 'jc.FName', 'jc.MName', 'jc.LName', 'jobpost.JobCode')
            ->Join('jobcandidates as jc', 'trainee_apply.JCId', '=', 'jc.JCId')
            ->Join('jobpost', 'jobpost.JPId', '=', 'trainee_apply.JPId')
            ->where('trainee_apply.IntervStatus', 'Selected')
            ->where('trainee_apply.TrainingComplete', '1');

        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('chk', function ($data) {
                if ($data->MappedToJob == 0) {
                    return '<input type="checkbox" class="select_all japchks" name="selectCand" onclick="checkAllorNot()" value="' . $data->TId . '">';
                } else {
                    return '';
                }
            })
            ->editColumn('Department', function ($data) {
                return getDepartment($data->Department);
            })

            ->addColumn('CandidateName', function ($data) {
                return $data->FName . ' ' . $data->MName . ' ' . $data->LName;
            })

            ->addColumn('Action', function ($data) {
                return '<i class="fas fa-eye text-success d-inline" aria-hidden="true" onclick="view_expense(' . $data->TId . ')" style="font-size: 16px;cursor: pointer;"></i>';
            })

            ->editColumn('OtherBenefit', function ($data) {
                if ($data->OtherBenefit != null) {
                    return $data->OtherBenefit;
                } else {
                    return '-';
                }
            })


            ->rawColumns(['chk', 'Action', 'OtherBenefit'])
            ->make(true);
    }

    public function add_expense(Request $request)
    {


        $TId = $request->Add_TId;
        $Stipend = $request->Stipend;
        $Expense = $request->Expense;
        $Year = explode('-', $request->Month)[0];
        $Month = explode('-', $request->Month)[1];
        $Total = $Stipend + $Expense;
        $query = DB::table('trainee_stipend')->insert(['TId' => $TId, 'Stipend' => $Stipend, 'Year' => $Year, 'Month' => $Month, 'Expense' => $Expense, 'Total' => $Total, 'UpdatedBy' => Auth::user()->id]);
        if ($query) {
            return response()->json(['status' => 200, 'msg' => 'Expense has been added successfully.']);
        } else {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        }
    }


    public function get_expense_list(Request $request)
    {
        $sql = DB::table('trainee_stipend')
            ->where('TId', $request->TId)
            ->get();

        return datatables()->of($sql)
            ->addIndexColumn()
            ->editColumn('Month', function ($data) {
                $dateObj   = DateTime::createFromFormat('!m', $data->Month);
                $monthName = $dateObj->format('F');
                return $monthName;
            })
            ->make(true);
    }

    public function map_trainee_to_job(Request $request)
    {
        $TId = $request->TId;
        $JPId = $request->JPId;

        $jobpost = jobpost::find($JPId);
        $Company = $jobpost->CompanyId;
        $Department = $jobpost->DepartmentId;
        $title = $jobpost->Title;

        $sql = 0;
        for ($i = 0; $i < count($TId); $i++) {
            $data = trainee_apply::find($TId[$i]);
            $JCId = $data->JCId;

            $sql_query = DB::table('jobapply')->insert(['JCId' => $JCId, 'JPId' => $JPId, 'Company' => $Company, 'Department' => $Department, 'ResumeSource' => 1, 'ApplyDate' => now(), 'CreatedBy' => Auth::user()->id]);
            $query = DB::table('trainee_apply')
                ->where('TId', $TId[$i])
                ->update(['MappedToJob' => 1, 'LastUpdated' => now(), 'UpdatedBy' => Auth::user()->id]);
            $candidate = jobcandidate::find($JCId);
            $Aadhaar = $candidate->Aadhaar;
            CandidateActivityLog::addToCandLog($JCId, $Aadhaar, 'Candidate Mapped to JobPost, ' . $title);
            $sql = 1;
        }
        if ($sql == 0) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {
            return response()->json(['status' => 200, 'msg' => 'Candidate Successfully Mapped again JobPost.']);
        }
    }
}
