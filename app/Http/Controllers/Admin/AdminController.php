<?php

namespace App\Http\Controllers\Admin;


use App\Models\master_mrf;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use App\Helpers\UserNotification;

use App\Mail\MrfStatusChangeMail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\CandidateJoining;
use App\Models\jobapply;
use App\Models\LogBookActivity;
use App\Models\OfferLetter;
use App\Models\screen2ndround;
use App\Models\screening;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class AdminController extends Controller
{
    function index()
    {
        $active_mrf = master_mrf::where('Type', '!=', 'SIP_HrManual')->orderBy('MRFID', 'desc')->pluck("JobCode", "MRFId");
        $recruiter = User::where('role', 'R')->where('Status', 'A')->pluck("name", "id");

        $result = [];
        $total_applicant = jobapply::where('JPId', '!=', '0')->where('JPId', '!=', null)->count();
        $result['Applications'] = $total_applicant;
        $hr_screening = jobapply::where('Status', 'Selected')->count();
        $result['HR Screening'] = $hr_screening;
        $technical_screening = screening::where('ScreenStatus', 'Shortlist')->count();
        $result['Technical Screening'] = $technical_screening;
        $first_interview = screening::where('IntervStatus', 'Selected')->count();
        $result['1st Interview'] = $first_interview;
        $second_interview = screen2ndround::where('IntervStatus2', 'Selected')->count();
        $result['2nd Interview'] = $second_interview;
        $offer = OfferLetter::where('OfferLetterSent', 'Yes')->count();
        $result['Offer'] = $offer;
        $Joined = CandidateJoining::where('Joined', 'Yes')->count();
        $result['Joined'] = $Joined;
        $dataPoints = array();
        foreach ($result as $key => $value) {
            if ($value != 0) {
                $dataPoints[] = ['label' => $key, 'y' => $value];
            }
        }

        $mrf_open_days = DB::table('jobpost')
            ->select('JobCode', DB::raw("DATEDIFF(CURRENT_DATE(), CreatedTime) as date_difference"))
            ->where('Status', '=', 'Open')
            ->get()->toArray();
        $dataPoints1 = array();
        foreach ($mrf_open_days as $key => $value) {
            $dataPoints1[] = ['label' => $value->JobCode, 'y' => $value->date_difference];
        }

        return view('admin.index', compact('active_mrf', 'dataPoints', 'recruiter', 'dataPoints1'));
    }

    function mrf()
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

        return view('admin.mrf', compact('company_list', 'department_list', 'state_list', 'institute_list', 'designation_list', 'employee_list', 'months'));
    }

    function active_mrf()
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
        return view('admin.activemrf', compact('company_list', 'department_list', 'state_list', 'institute_list', 'designation_list', 'employee_list', 'months'));
    }

    function closedmrf()
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
        return view('admin.closedmrf', compact('company_list', 'department_list', 'state_list', 'institute_list', 'designation_list', 'employee_list', 'months'));
    }

    function getNewMrf(Request $request)
    {

        $usersQuery = master_mrf::query();
        $Company = $request->Company;
        $Department = $request->Department;
        $Year = $request->Year;
        $Month = $request->Month;

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

        $mrf = $usersQuery->select('*')
            ->where('manpowerrequisition.CountryId', session('Set_Country'))
            ->where('manpowerrequisition.Status', 'New')
            ->orWhere(function ($query) {
                $query->where('manpowerrequisition.Status', 'Approved')
                    ->whereNull('manpowerrequisition.Allocated');
            })

            ->orderBy('CreatedTime', 'DESC')
            ->select(['manpowerrequisition.*']);


        return datatables()->of($mrf)
            ->addIndexColumn()
            ->addColumn('chk', function () {
                return '<input type="checkbox" class="select_all">';
            })
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
            ->editColumn('DepartmentId', function ($mrf) {
                return getDepartmentCode($mrf->DepartmentId);
            })
            ->editColumn('DesigId', function ($mrf) {
                if ($mrf->Type == 'SIP' || $mrf->Type == 'SIP_HrManual') {
                    return 'SIP Trainee';
                } else {
                    return getDesignationCode($mrf->DesigId);
                }
            })
            ->editColumn('LocationIds', function ($mrf) {
                $loc = '';
                if ($mrf->LocationIds != '' || $mrf->LocationIds != null) {

                    $location = unserialize($mrf->LocationIds);

                    foreach ($location as $key => $value) {
                        $loc .= getDistrictName($value['city']) . ' ';
                        $loc .= getStateCode($value['state']) . ' - ';
                        $loc .= $value['nop'];
                        $loc . '<br>';
                    }
                }
                return $loc;
            })
            ->addColumn('MRFDate', function ($mrf) {
                return date('d-m-Y', strtotime($mrf->CreatedTime));
            })

            ->addColumn('CreatedBy', function ($mrf) {

                return getFullName($mrf->CreatedBy);
            })

            ->addColumn('Status', function ($mrf) {
                $list = array('New' => 'New', 'Approved' => 'Approved', 'Hold' => 'On Hold', 'Rejected' => 'Rejected');

                $x = '<select name="mrfstatus" id="mrfstatus' . $mrf->MRFId . '" class="form-control form-select form-select-sm  d-inline" disabled onchange="chngmrfsts(' . $mrf->MRFId . ',this.value)" style="width: 100px; ">';
                foreach ($list as $key => $value) {
                    if ($mrf->Status == $key) {
                        $x .= '<option value=' . $key . ' selected>' . $value . '</option>';
                    } else {
                        $x .= '<option value=' . $key . '>' . $value . '</option>';
                    }
                }
                $x .= '</select>  <i class="fa fa-pencil-square-o text-success d-inline" aria-hidden="true" id="msedit' . $mrf->MRFId . '" onclick="editmstst(' . $mrf->MRFId . ',this)" style="font-size: 16px;cursor: pointer;"></i>';
                return $x;
            })

            ->addColumn('Allocated', function ($mrf) {
                if ($mrf->Status == 'Approved') {
                    $user_list = DB::table('users')
                        ->where('role', 'R')
                        ->where('Status', 'A')
                        ->orderBy('name', 'ASC')
                        ->get();


                    $x = '<select name="allocate" id="allocate' . $mrf->MRFId . '" class="form-control form-select form-select-sm  d-inline" disabled style="width: 100px;" onchange="allocatemrf(' . $mrf->MRFId . ',this.value)"><option value="">Select</option>';
                    foreach ($user_list as $list) {
                        if ($mrf->Allocated == $list->id) {
                            $x .= '<option value=' . $list->id . ' selected>' . substr($list->name, 0, strrpos($list->name, ' ')) . '</option>';
                        } else {
                            $x .= '<option value=' . $list->id . '>' . substr($list->name, 0, strrpos($list->name, ' ')) . '</option>';
                        }
                    }
                    $x .= '</select> <i class="fa fa-pencil-square-o text-success d-inline" aria-hidden="true" id="mrfedit' . $mrf->MRFId . '" onclick="editmrf(' . $mrf->MRFId . ')" style="font-size: 16px;cursor: pointer;"></i>';
                    return $x;
                } else {
                    return '';
                }
            })
            ->addColumn('Details', function ($mrf) {
                return '<i class="fa fa-eye text-info" style="font-size: 16px;cursor: pointer;" id="viewMRF" data-id=' . $mrf->MRFId . '></i>';
            })
            ->rawColumns(['chk', 'Status', 'Allocated', 'Details'])
            ->make(true);
    }

    function getActiveMrf(Request $request)
    {

        $usersQuery = master_mrf::query();
        $Company = $request->Company;
        $Department = $request->Department;
        $Year = $request->Year;
        $Month = $request->Month;
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

        $mrf =  $usersQuery->select('*')
            ->where('CountryId', session('Set_Country'))
            ->where('Status', 'Approved')
            ->where('Allocated', '!=', null)
            ->orderBy('CreatedTime', 'DESC');

        return datatables()->of($mrf)
            ->addIndexColumn()
            ->addColumn('chk', function () {
                return '<input type="checkbox" class="select_all">';
            })
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
            ->editColumn('DepartmentId', function ($mrf) {
                return getDepartmentCode($mrf->DepartmentId);
            })
            ->editColumn('DesigId', function ($mrf) {
                if ($mrf->DesigId == '' or $mrf->DesigId == null) {
                    return '';
                } else {
                    return getDesignationCode($mrf->DesigId);
                }
            })
            ->editColumn('LocationIds', function ($mrf) {
                // $location = unserialize($mrf->LocationIds);
                $location = DB::table('mrf_location_position')->where('MRFId', $mrf->MRFId)->get()->toArray();
                $loc = '';
                foreach ($location as $key => $value) {
                    $loc .= getDistrictName($value->City) . ' ';
                    $loc .= getStateCode($value->State) . ' - ';
                    $loc .= $value->Nop;
                    $loc . '<br>';
                }
                return $loc;
            })
            ->addColumn('MRFDate', function ($mrf) {
                return date('d-m-Y', strtotime($mrf->CreatedTime));
            })

            ->addColumn('CreatedBy', function ($mrf) {

                return getFullName($mrf->CreatedBy);
            })

            ->addColumn('Status', function ($mrf) {
                $list = array('New' => 'New', 'Approved' => 'Approved', 'Hold' => 'On Hold', 'Rejected' => 'Rejected');

                $x = '<select name="mrfstatus" id="mrfstatus' . $mrf->MRFId . '" class="form-control form-select form-select-sm  d-inline" disabled onchange="chngmrfsts(' . $mrf->MRFId . ',this.value)" style="width: 100px; ">';
                foreach ($list as $key => $value) {
                    if ($mrf->Status == $key) {
                        $x .= '<option value=' . $key . ' selected>' . $value . '</option>';
                    } else {
                        $x .= '<option value=' . $key . '>' . $value . '</option>';
                    }
                }
                $x .= '</select>  <i class="fa fa-pencil-square-o text-success d-inline" aria-hidden="true" id="msedit' . $mrf->MRFId . '" onclick="editmstst(' . $mrf->MRFId . ',this)" style="font-size: 16px;cursor: pointer;"></i>';
                return $x;
            })

            ->addColumn('Allocated', function ($mrf) {
                if ($mrf->Status == 'Approved') {
                    $user_list = DB::table('users')
                        ->where('role', 'R')
                        ->where('Status', 'A')
                        ->orderBy('name', 'ASC')
                        ->get();

                    $x = '<select name="allocate" id="allocate' . $mrf->MRFId . '" class="form-control form-select form-select-sm  d-inline" disabled style="width: 100px;" onchange="allocatemrf(' . $mrf->MRFId . ',this.value)"><option value="">Select</option>';
                    foreach ($user_list as $list) {
                        if ($mrf->Allocated == $list->id) {
                            $x .= '<option value=' . $list->id . ' selected>' . substr($list->name, 0, strrpos($list->name, ' ')) . '</option>';
                        } else {
                            $x .= '<option value=' . $list->id . '>' . substr($list->name, 0, strrpos($list->name, ' ')) . '</option>';
                        }
                    }
                    $x .= '</select> <i class="fa fa-pencil-square-o text-success d-inline" aria-hidden="true" id="mrfedit' . $mrf->MRFId . '" onclick="editmrf(' . $mrf->MRFId . ')" style="font-size: 16px;cursor: pointer;"></i>';
                    return $x;
                } else {
                    return '';
                }
            })
            ->addColumn('Details', function ($mrf) {
                return '<i class="fa fa-eye text-success" style="font-size: 16px;cursor: pointer;" id="viewMRF" data-id=' . $mrf->MRFId . '></i>';
            })
            ->rawColumns(['chk', 'Status', 'Allocated', 'Details'])
            ->make(true);
    }

    function getCloseMrf(Request $request)
    {

        $usersQuery = master_mrf::query();
        $Company = $request->Company;
        $Department = $request->Department;
        $Year = $request->Year;
        $Month = $request->Month;

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

        $mrf = $usersQuery->select('*')
            ->where('CountryId', session('Set_Country'))
            ->where('Status', 'Close')
            ->orderBy('CreatedTime', 'DESC');

        return datatables()->of($mrf)
            ->addIndexColumn()
            ->addColumn('chk', function () {
                return '<input type="checkbox" class="select_all">';
            })
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
            ->editColumn('DepartmentId', function ($mrf) {
                return getDepartmentCode($mrf->DepartmentId);
            })
            ->editColumn('DesigId', function ($mrf) {
                return getDesignationCode($mrf->DesigId);
            })

            ->addColumn('MRFDate', function ($mrf) {
                return date('d-m-Y', strtotime($mrf->CreatedTime));
            })
            ->addColumn('AllocatedDt', function ($mrf) {
                return date('d-m-Y', strtotime($mrf->AllocatedDt));
            })
            ->addColumn('CloseDt', function ($mrf) {
                return date('d-m-Y', strtotime($mrf->CloseDt));
            })
            ->addColumn('CreatedBy', function ($mrf) {

                return getFullName($mrf->CreatedBy);
            })

            ->addColumn('Allocated', function ($mrf) {
                return getFullName($mrf->Allocated);
            })
            ->addColumn('Position_Filled', function ($mrf) {
                return $mrf->Hired;
            })
            ->addColumn('Details', function ($mrf) {
                return '<i class="fa fa-eye text-success" style="font-size: 16px;cursor: pointer;" id="viewMRF" data-id=' . $mrf->MRFId . '></i>';
            })

            ->addColumn('daystofill', function ($mrf) {
                return   \Carbon\Carbon::parse($mrf->AllocatedDt)->diff($mrf->CloseDt)->format('%d days');
            })
            ->rawColumns(['chk', 'Allocated', 'Details', 'daystofill'])
            ->make(true);
    }


    function updateMRFStatus(Request $request)
    {
        $MRF = master_mrf::find($request->MRFId);
        $MRF->Status = $request->va;
        $MRF->RemarkHr = $request->RemarkHr;
        $MRF->UpdatedBy = Auth::user()->id;
        $MRF->LastUpdated = now();
        $query = $MRF->save();
        if (!$query) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {
            $jobCode = $MRF->JobCode;
            LogActivity::addToLog('MRF ' . $jobCode . ' is ' . $request->va, 'Update');
            $CreatedBy = $MRF->CreatedBy;


            if ($MRF->Type == 'N' || $MRF->Type == 'N_HrManual') {
                $type = 'New';
            } elseif ($MRF->Type == 'SIP' || $MRF->Type == 'SIP_HrManual') {
                $type = 'SIP/Internship';
            } elseif ($MRF->Type == 'Campus' || $MRF->Type == 'Campus_HrManual') {
                $type = 'Campus';
            } elseif ($MRF->Type == 'R' || $MRF->Type == 'R_HrManual') {
                $type = 'Replacement';
            }

            $details = [
                "subject" => 'MRF (' . $type . ') - ' . $jobCode . ', Status - ' . $request->va,
                "Status" => $request->va,
                "Type" => $type,
            ];
            if ($request->va != 'New') {
                if (CheckCommControl(4) == 1 ||  CheckCommControl(4) == 1) {  //Action taken by admin on MRF 
                    Mail::to(getEmailID($CreatedBy))->send(new MrfStatusChangeMail($details)); // Need to active when s/w is live

                    UserNotification::notifyUser($CreatedBy, 'MRF Status Change', 'MRF (' . $type . ') - ' . $jobCode . ', Status - ' . $request->va,);
                }
            }
            return response()->json(['status' => 200, 'msg' => 'MRF Status has been changed successfully.']);
        }
    }

    function allocateMRF(Request $request)
    {
        $MRF = master_mrf::find($request->MRFId);
        $MRF->Allocated = $request->va;
        $MRF->UpdatedBy = Auth::user()->id;
        $MRF->AllocatedDt = now();
        $MRF->LastUpdated = now();
        $query = $MRF->save();

        $query1 = DB::table('jobpost')->where('MRFId', $request->MRFId)->update([
            'CreatedBy' => $request->va,
            'LastUpdated' => now(),
            'UpdatedBy' => Auth::user()->id,
        ]);


        if (!$query) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {
            $jobCode = $MRF->JobCode;
            LogActivity::addToLog('MRF ' . $jobCode . ' is allocated to ' . getFullName($request->va), 'Update');
            UserNotification::notifyUser($request->va, 'MRF Allocated',  $jobCode);
            return response()->json(['status' => 200, 'msg' => 'Task has been allocated to recruiter successfully.']);
        }
    }


    function getTaskList(Request $request)
    {
        $sql = DB::table('manpowerrequisition')
            ->where('CountryId', session('Set_Country'))
            ->where('Allocated', $request->Uid)
            ->where('Status', '!=', 'New')
            ->get();

        return datatables()->of($sql)
            ->addIndexColumn()
            ->addColumn('actions', function ($sql) {
                return '<button class="btn btn-sm  btn-outline-primary font-13 edit" data-id="' . $sql->MRFId . '" id="editBtn"><i class="fadeIn animated bx bx-pencil"></i></button>';
            })
            ->addColumn('status', function ($sql) {
                if ($sql->Status != 'Close') {
                    return 'Active';
                } else {
                    return 'Closed';
                }
            })
            ->addColumn('days_to_fill', function ($sql) {
                if ($sql->Status == 'Close') {
                    return    \Carbon\Carbon::parse($sql->AllocatedDt)->diff($sql->CloseDt)->format('%d days');
                } else {
                    return '';
                }
            })
            ->rawColumns(['actions', 'days_to_fill'])
            ->make(true);
    }


    function getRecruiterName(Request $request)
    {
        $result = getFullName($request->Uid);
        return response()->json(['details' => $result]);
    }

    public function userlogs()
    {
        $months = [1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'];
        $user = User::pluck('name', 'id');
        return view('admin.userlogs', compact('months', 'user'));
    }

    public function getAllLogs(Request $request)
    {
        $usersQuery = LogBookActivity::query();
        $User = $request->User;
        $Year = $request->Year;
        $Month = $request->Month;

        if ($User != '') {
            $usersQuery->where("user_id", $User);
        }

        if ($Year != '') {
            $usersQuery->whereBetween('created_at', [$Year . '-01-01', $Year . '-12-31']);
        }
        if ($Month != '') {
            if ($Year != '') {
                $usersQuery->whereBetween('created_at', [$Year . '-' . $Month . '-01', $Year . '-' . $Month . '-31']);
            } else {
                $usersQuery->whereBetween('created_at', [date('Y') . '-' . $Month . '-01', date('Y') . '-' . $Month . '-31']);
            }
        }

        $query = $usersQuery->select('*')
            ->orderBy('id', 'DESC');
        return datatables()->of($query)
            ->addIndexColumn()
            ->editColumn('date', function ($query) {
                return date('d-m-Y', strtotime($query->created_at));
            })
            ->make(true);
    }
}
