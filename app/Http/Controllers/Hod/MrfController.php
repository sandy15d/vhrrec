<?php

namespace App\Http\Controllers\Hod;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class MrfController extends Controller
{
    function newmrf()
    {
        $company_list = DB::table("master_company")->where('Status', 'A')->orderBy('CompanyCode', 'desc')->pluck("CompanyCode", "CompanyId");
        $department_list = DB::table("master_department")->where('DeptStatus', 'A')->orderBy('DepartmentName', 'asc')->pluck("DepartmentName", "DepartmentId");
        $state_list = DB::table("states")->orderBy('StateName', 'asc')->pluck("StateName", "StateId");
        $institute_list = DB::table("master_institute")->orderBy('InstituteName', 'asc')->pluck("InstituteName", "InstituteId");
        return view('hod.newmrf', compact('company_list', 'department_list','state_list','institute_list'));
    }


    public function addNewMrf(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Reason' => 'required',
            'Company' => 'required',
            'Department' => 'required',
            'Designation' => 'required',
            'ReportingManager' => 'required',
           

        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'error' => $validator->errors()->toArray()]);
        } else {
            /* $Institute = new master_institute;
            $Institute->InstituteName = $request->InstituteName;
            $Institute->InstituteCode = $request->InstituteCode;
            $Institute->StateId = $request->State;
            $Institute->DistrictId = $request->District;
            $Institute->Category = $request->Category;
            $Institute->Type = $request->Type;
            $Institute->Status = $request->Status;
            $query = $Institute->save();

            if (!$query) {
                return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
            } else {
                return response()->json(['status' => 200, 'msg' => 'New Institute has been successfully created.']);
            } */
        }
    }
    public function getState(Request $request)
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


    public function getEducation(Request $request)
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

    public function getDesignation(Request $request)
    {
        $designation = DB::table("master_designation")->orderBy('DesigName', 'asc')
            ->where("DepartmentId", $request->DepartmentId)
            ->pluck("DesigId", "DesigName");
        return response()->json($designation);
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
}
