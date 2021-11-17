<?php

namespace App\Http\Controllers\Common;

use App\Models\master_mrf;
use App\Models\ThemeDetail;
use App\Models\Notification;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\jobcandidate;
use Illuminate\Support\Facades\Auth;

use function App\Helpers\convertData;
use function App\Helpers\getCompanyCode;
use function App\Helpers\getDepartmentCode;

use function App\Helpers\getDesignationCode;


class CommonController extends Controller
{


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

    public function getDesignation(Request $request)
    {
        $designation = DB::table("master_designation")->orderBy('DesigName', 'asc')
            ->where("DepartmentId", $request->DepartmentId)
            ->pluck("DesigId", "DesigName");
        return response()->json($designation);
    }
    public function getState()
    {
        $State = DB::table("states")->orderBy('StateName', 'asc')->pluck("StateId", "StateName");
        return response()->json($State);
    }

    public function getDistrict(Request $request)
    {
        $District = DB::table("master_district")->orderBy('DistrictName', 'asc')
            ->where("StateId", $request->StateId)
            ->pluck("DistrictId", "DistrictName");
        return response()->json($District);
    }


    public function getEducation()
    {
        $Education = DB::table("master_education")->orderBy('EducationName', 'asc')->pluck("EducationId", "EducationCode");
        return response()->json($Education);
    }

    public function getSpecialization(Request $request)
    {
        $Specialization = DB::table("master_specialization")->orderBy('Specialization', 'asc')
            ->where("EducationId", $request->EducationId)
            ->pluck("EducationId", "Specialization");
        return response()->json($Specialization);
    }


    public function getDepartment(Request $request)
    {
        $Department = DB::table("master_department")->orderBy('DepartmentName', 'asc')
            ->where("CompanyId", $request->CompanyId)
            ->pluck("DepartmentId", "DepartmentName");
        return response()->json($Department);
    }



    public function getReportingManager(Request $request)
    {
        $employee = DB::table('master_employee')->orderBy('FullName', 'ASC')
            ->where('DepartmentId', $request->DepartmentId)
            ->where('EmpStatus', 'A')
            ->select('EmployeeID', DB::raw('CONCAT(Fname, " ", Lname) AS FullName'))
            ->pluck("EmployeeID", "FullName");
        return response()->json($employee);
    }

    public function getResignedEmployee(Request $request)
    {
        $employee = DB::table('master_employee')->orderBy('FullName', 'ASC')
            ->where('DepartmentId', $request->DepartmentId)
            ->where('EmpStatus', 'D')
            ->where('DateOfSepration', '>=', '2021-01-01')
            ->select('EmployeeID', DB::raw('CONCAT(Fname, " ", Lname) AS FullName'))
            ->pluck("EmployeeID", "FullName");
        return response()->json($employee);
    }

    public function getResignedEmpDetail(Request $request)
    {
        $EmpId = $request->EmpId;
        $empDetails = DB::table('master_employee')
            ->Join('master_designation', 'master_employee.DesigId', '=', 'master_designation.DesigId')
            ->Join('master_headquater', 'master_employee.Location', '=', 'master_headquater.HqId')
            ->Join('master_grade', 'master_employee.GradeId', '=', 'master_grade.GradeId')
            ->where('EmployeeID', $EmpId)
            ->select('master_designation.DesigName', 'master_headquater.HqName', 'master_grade.GradeValue', 'master_employee.CTC')
            ->get();
        return response()->json(['empDetails' => $empDetails]);
    }

    public function getAllDistrict()
    {
        $AllDistrict = DB::table("master_district")->orderBy('DistrictName', 'asc')->pluck("DistrictId", "DistrictName");
        return response()->json($AllDistrict);
    }

    public function getAllSP()
    {
        $Sp = DB::table("master_specialization")->orderBy('Specialization', 'asc')->pluck("SpId", "Specialization");
        return response()->json($Sp);
    }

    function getMRFDetails(Request $request)
    {
        $MRFId = $request->MRFId;
        $MRFDetails = master_mrf::find($MRFId);
        $LocationDetail = unserialize($MRFDetails->LocationIds);
        $UniversityDetail = unserialize($MRFDetails->EducationInsId);
        $KPDetail = unserialize($MRFDetails->KeyPositionCriteria);
        $EducationDetail = unserialize($MRFDetails->EducationId);
        return response()->json(['MRFDetails' => $MRFDetails, 'LocationDetails' => $LocationDetail, 'UniversityDetails' => $UniversityDetail, 'KPDetails' => $KPDetail, 'EducationDetails' => $EducationDetail]);
    }

    public function notificationMarkRead(Request $request)
    {
        $notification = Notification::find($request->id);
        $notification->notification_read = 1;
        $query = $notification->save();
        if (!$query) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {
            return response()->json(['status' => 200, 'msg' => 'Task has been allocated to recruiter successfully.']);
        }
    }


    public function markAllRead()
    {
        $query = DB::table('notification')->where('userid', '=', Auth::user()->id)->update(array('notification_read' => 1));
        if (!$query) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {
            return response()->json(['status' => 200]);
        }
    }


    public function updateMRF(Request $request)
    {

        $State = $request->State;
        $City = $request->City;
        $ManPower = $request->ManPower;
        $Education = $request->Education;
        $Specialization = $request->Specialization;
        $KeyPosition = $request->KeyPosition;

        $locArray = array();
        if ($State != '') {
            for ($lc = 0; $lc < Count($State); $lc++) {
                $location = array(
                    "state" => $State[$lc],
                    "city" => $City[$lc] == '' ? '' : $City[$lc],
                    "nop" => $ManPower[$lc],
                );
                array_push($locArray, $location);
            }
        }
        $locArray_str = serialize($locArray);

        $Eduarray = array();
        if ($Education != '') {
            for ($count = 0; $count < Count($Education); $count++) {

                $e = array(
                    "e" => $Education[$count],
                    "s" => $Specialization[$count]
                );
                array_push($Eduarray, $e);
            }
        }
        $EduArray_str = serialize($Eduarray);

        $KpArray = array();
        if ($KeyPosition != '') {
            for ($i = 0; $i < Count($KeyPosition); $i++) {
                $KP = addslashes($KeyPosition[$i]);
                array_push($KpArray, $KP);
            }
        }

        $KpArray_str = serialize($KpArray);


        $UniversityArray = array();
        if ($request->University != '') {
            $UniversityArray = serialize($request->University);
        }

        $MRF = master_mrf::find($request->MRFId);
        $MRF->Type = $request->MRF_Type;
        $MRF->Reason = $request->Reason;
        $MRF->CompanyId = $request->Company;
        $MRF->DepartmentId = $request->Department;
        $MRF->DesigId = $request->Designation == '' ? 0 : $request->Designation;
        $MRF->Positions = array_sum($ManPower);
        $MRF->LocationIds = $locArray_str;
        $MRF->MinCTC = $request->MinCTC == '' ? NULL : $request->MinCTC;
        $MRF->MaxCTC = $request->MaxCTC == '' ? NULL : $request->MaxCTC;
        $MRF->Stipend = $request->Stipend == '' ? NULL : $request->Stipend;
        $MRF->DA = $request->da == '' ? NULL : $request->da;
        $MRF->TwoWheeler = $request->two_wheeler == '' ? NULL : $request->two_wheeler;
        $MRF->WorkExp = $request->WorkExp == '' ? NULL : $request->WorkExp;
        $MRF->Remarks = $request->Remark;
        $MRF->Info = convertData($request->JobInfo);
        $MRF->EducationId = $EduArray_str;
        $MRF->EducationInsId = $UniversityArray;
        $MRF->KeyPositionCriteria = $KpArray_str;
        $MRF->Tr_Frm_Date = $request->Tr_Frm_Date == '' ? NULL : $request->Tr_Frm_Date;
        $MRF->Tr_To_Date = $request->Tr_To_Date == '' ? NULL : $request->Tr_To_Date;
        $MRF->UpdatedBy = Auth::user()->id;
        $MRF->LastUpdated = now();
        $query = $MRF->save();
        $InsertId = $MRF->MRFId;
        if ($request->MRF_Type == 'SIP' || $request->MRF_Type == 'SIP_HrManual') {
            $jobCode = getCompanyCode($request->Company) . '/' . getDepartmentCode($request->Department) . '/SIP/' . $InsertId . '-' . date('Y');
        } else {
            $jobCode = getCompanyCode($request->Company) . '/' . getDepartmentCode($request->Department) . '/' . getDesignationCode($request->Designation) . '/' . $InsertId . '-' . date('Y');
        }

        $query1 = DB::table('manpowerrequisition')
            ->where('MRFId', $InsertId)
            ->update(['JobCode' => $jobCode]);
        if (!$query) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {
            return response()->json(['status' => 200, 'msg' => 'MRF Status has been changed successfully.']);
        }
    }

    public function deleteMRF(Request $request)
    {
        $MRFId = $request->MRFId;
        $query = master_mrf::find($MRFId)->delete();
        if (!$query) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {
            return response()->json(['status' => 200, 'msg' => 'MRF data has been Deleted.']);
        }
    }

    public function getMRFByDepartment(Request $request)
    {
        $JobCode = DB::table("jobpost")->orderBy('JobCode', 'asc')
            ->where("DepartmentId", $request->DepartmentId)
            ->where('Status', 'Open')
            ->pluck("JPId", "JobCode");
        return response()->json($JobCode);
    }
    public function getCandidateName(Request $request)
    {

     print_r('AAA');die;
        $sql = jobcandidate::find($request->JCId);
        return $sql->FName;
    }
}
