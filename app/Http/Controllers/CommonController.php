<?php

namespace App\Http\Controllers;

use App\Helpers\UserNotification;
use App\Models\master_mrf;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function App\Helpers\convertData;
use function App\Helpers\getCompanyCode;
use function App\Helpers\getDepartmentCode;
use function App\Helpers\getDesignationCode;

class CommonController extends Controller
{


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
        $MRF->WorkExp = $request->WorkExp;
        $MRF->Remarks = $request->Remark;
        $MRF->Info = convertData($request->JobInfo);
        $MRF->EducationId = $EduArray_str;
        $MRF->EducationInsId = $UniversityArray;
        $MRF->KeyPositionCriteria = $KpArray_str;
        $MRF->UpdatedBy = Auth::user()->id;
        $MRF->LastUpdated = now();
        $query = $MRF->save();
        $InsertId = $MRF->MRFId;
        if ($request->MRF_Type == 'SIP' || $request->MRF_Type =='SIP_HrManual') {
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
}
