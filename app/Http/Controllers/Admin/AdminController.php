<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Models\master_mrf;
use App\Models\ThemeDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function App\Helpers\getDepartmentCode;
use function App\Helpers\getDesignationCode;
use function App\Helpers\getDistrictName;
use function App\Helpers\getFullName;
use function App\Helpers\getStateCode;

class AdminController extends Controller
{
    function index()
    {
        return view('admin.index');
    }


    function setting(){
        return view('admin.settings');
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
        return view('admin.mrf', compact('company_list', 'department_list', 'state_list', 'institute_list', 'designation_list', 'employee_list'));
    }




    function getAllMRF()
    {
        $mrf = DB::table('manpowerrequisition as mr')
            ->where('MRFId', '!=', 0)
            ->where('Status', '!=', 'Close')
            ->orderBy('CreatedTime', 'DESC')
            ->select(['mr.*']);

        return datatables()->of($mrf)
            ->addIndexColumn()
            ->editColumn('Type', function ($mrf) {
                if ($mrf->Type == 'N' || $mrf->Type == 'N_HrManual') {
                    return 'New';
                } else {
                    return 'Replacement';
                }
            })
            ->editColumn('DepartmentId', function ($mrf) {
                return getDepartmentCode($mrf->DepartmentId);
            })
            ->editColumn('DesigId', function ($mrf) {
                return getDesignationCode($mrf->DesigId);
            })
            ->editColumn('LocationIds', function ($mrf) {
                $location = unserialize($mrf->LocationIds);
                $loc = '';
                foreach ($location as $key => $value) {
                    $loc .= getDistrictName($value['city']) . ' ';
                    $loc .= getStateCode($value['state']) . ' - ';
                    $loc .= $value['nop'] . ', ';
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
                $x .= '</select>  <i class="fa fa-pencil-square-o text-primary d-inline" aria-hidden="true" id="msedit' . $mrf->MRFId . '" onclick="editmstst(' . $mrf->MRFId . ',this)" style="font-size: 16px;cursor: pointer;"></i>';
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
                    $x .= '</select> <i class="fa fa-pencil-square-o text-primary d-inline" aria-hidden="true" id="mrfedit' . $mrf->MRFId . '" onclick="editmrf(' . $mrf->MRFId . ')" style="font-size: 16px;cursor: pointer;"></i>';
                    return $x;
                } else {
                    return '';
                }
            })
            ->addColumn('Details', function ($mrf) {
                return '<i class="fa fa-eye text-info" style="font-size: 16px;cursor: pointer;" id="viewMRF" data-id=' . $mrf->MRFId . '></i>';
            })
            ->rawColumns(['Status', 'Allocated', 'Details'])
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
            LogActivity::addToLog('MRF '.$jobCode . ' is '.$request->va,'Update');
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
        if (!$query) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {
            $jobCode = $MRF->JobCode;
            LogActivity::addToLog('MRF '.$jobCode . ' is allocated to '.$request->va,'Update');
            return response()->json(['status' => 200, 'msg' => 'Task has been allocated to recruiter successfully.']);
        }
    }

    public function getDepartmentMRFAdmin(Request $request)
    {
        $Department = DB::table("master_department")->orderBy('DepartmentName', 'asc')
            ->where("CompanyId", $request->CompanyId)
            ->pluck("DepartmentId", "DepartmentName");
        return response()->json($Department);
    }

    public function getDesignationMRFAdmin(Request $request)
    {
        $designation = DB::table("master_designation")->orderBy('DesigName', 'asc')
            ->where("DepartmentId", $request->DepartmentId)
            ->pluck("DesigId", "DesigName");
        return response()->json($designation);
    }

    public function getRepMgrMRFAdmin(Request $request)
    {
        $employee = DB::table('master_employee')->orderBy('FullName', 'ASC')
            ->where('DepartmentId', $request->DepartmentId)
            ->where('EmpStatus', 'A')
            ->select('EmployeeID', DB::raw('CONCAT(Fname, " ", Lname) AS FullName'))
            ->pluck("EmployeeID", "FullName");
        return response()->json($employee);
    }

    function getMRFDetails(Request $request)
    {
        $MRFId = $request->MRFId;
        $MRFDetails = master_mrf::find($MRFId);
        $LocationDetail = unserialize($MRFDetails->LocationIds);
        $UniversityDetail = unserialize($MRFDetails->EducationInsId);
        $KPDetail = unserialize($MRFDetails->KeyPositionCriteria);
        $EducationDetail = unserialize($MRFDetails->EducationId);
        return response()->json(['MRFDetails' => $MRFDetails, 'LocationDetails' => $LocationDetail, 'UniversityDetails' => $UniversityDetail, 'KPDetails' => $KPDetail,'EducationDetails'=>$EducationDetail]);
    }

    function getTaskList(Request $request)
    {
        $sql = DB::table('manpowerrequisition')
            ->where('Status', 'Approved')
            ->where('Status', '!=', 'Close')
            ->where('Allocated', $request->Uid)
            ->get();

        return datatables()->of($sql)
            ->addIndexColumn()
            ->addColumn('actions', function ($sql) {
                return '<button class="btn btn-sm  btn-outline-primary font-13 edit" data-id="' . $sql->MRFId . '" id="editBtn"><i class="fadeIn animated bx bx-pencil"></i></button>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }


    function getRecruiterName(Request $request)
    {
        $result = getFullName($request->Uid);
        return response()->json(['details' => $result]);
    }

    public function getStateAdmin()
    {
        $State = DB::table("states")->orderBy('StateName', 'asc')->pluck("StateId", "StateName");
        return response()->json($State);
    }




    public function getCityAdmin()
    {
        $State = DB::table("master_district")->orderBy('DistrictName', 'asc')->pluck("DistrictId", "DistrictName");
        return response()->json($State);
    }


    public function getEducationAdmin()
    {
        $Education = DB::table("master_education")->orderBy('EducationName', 'asc')->pluck("EducationId", "EducationCode");
        return response()->json($Education);
    }
    public function getSpecializationAdmin(Request $request)
    {
        $Specialization = DB::table("master_specialization")->orderBy('Specialization', 'asc')
            ->where("EducationId", $request->EducationId)
            ->pluck("EducationId", "Specialization");
        return response()->json($Specialization);
    }
    public function getAllSP()
    {
        $Sp = DB::table("master_specialization")->orderBy('Specialization', 'asc')->pluck("SpId", "Specialization");
        return response()->json($Sp);
    }

    function setTheme(Request $request)
    {
        $ThemeStyle = $request->ThemeStyle;
        if ($ThemeStyle != '') {
            if ($ThemeStyle == 'lightmode') {
                $Style = 'light-theme';
                $SidebarColor = '';
            } elseif ($ThemeStyle == 'darkmode') {
                $Style = 'dark-theme';
                $SidebarColor = '';
            } elseif ($ThemeStyle == 'semidark') {
                $Style = 'semi-dark';
                $SidebarColor = '';
            } elseif ($ThemeStyle == 'minimaltheme') {
                $Style = 'minimal-theme';
                $SidebarColor = '';
            } elseif ($ThemeStyle == 'sidebarcolor1') {
                $Style = '';
                $SidebarColor = 'color-sidebar sidebarcolor1';
            } elseif ($ThemeStyle == 'sidebarcolor2') {
                $Style = '';
                $SidebarColor = 'color-sidebar sidebarcolor2';
            } elseif ($ThemeStyle == 'sidebarcolor3') {
                $Style = '';
                $SidebarColor = 'color-sidebar sidebarcolor3';
            } elseif ($ThemeStyle == 'sidebarcolor4') {
                $Style = '';
                $SidebarColor = 'color-sidebar sidebarcolor4';
            } elseif ($ThemeStyle == 'sidebarcolor5') {
                $Style = '';
                $SidebarColor = 'color-sidebar sidebarcolor5';
            } elseif ($ThemeStyle == 'sidebarcolor6') {
                $Style = '';
                $SidebarColor = 'color-sidebar sidebarcolor6';
            } elseif ($ThemeStyle == 'sidebarcolor7') {
                $Style = '';
                $SidebarColor = 'color-sidebar sidebarcolor7';
            } elseif ($ThemeStyle == 'sidebarcolor8') {
                $Style = '';
                $SidebarColor = 'color-sidebar sidebarcolor8';
            }


            $data = array(
                'ThemeStyle' => $Style,
                'SidebarColor' => $SidebarColor,
                'UserId' => Auth::user()->id,
            );
            $query =  ThemeDetail::updateOrCreate(['UserId' => Auth::user()->id], $data);

            if (!$query) {
                return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
            } else {
                $request->session()->forget('ThemeStyle');
                $request->session()->forget('SidebarColor');
                $request->session()->put('ThemeStyle', $Style);
                $request->session()->put('SidebarColor', $SidebarColor);
                return response()->json(['status' => 200, 'msg' => 'New Theme has been successfully Applied.']);
            }
        }
    }

    function eduinstitute()
    {
        return view('admin.eduinstitute');
    }

    function resumesource()
    {
        return view('admin.resumesource');
    }
}
