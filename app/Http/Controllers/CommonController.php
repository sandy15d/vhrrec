<?php

namespace App\Http\Controllers;

use App\Helpers\UserNotification;
use App\Models\master_mrf;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
}
