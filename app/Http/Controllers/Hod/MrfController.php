<?php

namespace App\Http\Controllers\Hod;

use App\Http\Controllers\Controller;
use App\Models\master_mrf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use function App\Helpers\getCompanyCode;
use function App\Helpers\getDepartmentCode;
use function App\Helpers\getDesignationCode;
use function App\Helpers\getFullName;

use DataTables;
use PHPUnit\Framework\Constraint\Count;

class MrfController extends Controller
{
    function newmrf()
    {
        $company_list = DB::table("master_company")->where('Status', 'A')->orderBy('CompanyCode', 'desc')->pluck("CompanyCode", "CompanyId");
        $department_list = DB::table("master_department")->where('DeptStatus', 'A')->orderBy('DepartmentName', 'asc')->pluck("DepartmentName", "DepartmentId");
        $state_list = DB::table("states")->orderBy('StateName', 'asc')->pluck("StateName", "StateId");
        $institute_list = DB::table("master_institute")->orderBy('InstituteName', 'asc')->pluck("InstituteName", "InstituteId");
        return view('hod.newmrf', compact('company_list', 'department_list', 'state_list', 'institute_list'));
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
                        "city" => $City[$lc],
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
            $UniversityArray = serialize($request->University);




            $MRF = new master_mrf;
            $MRF->Type = 'N';
            $MRF->Reason = $request->Reason;
            $MRF->CompanyId = $request->Company;
            $MRF->DepartmentId = $request->Department;
            $MRF->DesigId = $request->Designation;
            $MRF->Positions = array_sum($ManPower);
            $MRF->LocationIds = $locArray_str;
            $MRF->Reporting = $request->ReportingManager;
            $MRF->MinCTC = $request->MinCTC;
            $MRF->MaxCTC = $request->MaxCTC;
            $MRF->WorkExp = $request->WorkExp;
            $MRF->Remarks = $request->Remark;
            $MRF->Info = $request->JobInfo;
            $MRF->EducationId = $EduArray_str;
            $MRF->EducationInsId = $UniversityArray;
            $MRF->KeyPositionCriteria = $KpArray_str;
            $MRF->CreatedBy =  Auth::user()->id;
            $MRF->Status = 'New';
            $query = $MRF->save();

            $InsertId = $MRF->MRFId;

            $jobCode = getCompanyCode($request->Company) . '/' . getDepartmentCode($request->Department) . '/' . getDesignationCode($request->Designation) . '/' . $InsertId . '-' . date('Y');
            $query1 = DB::table('manpowerrequisition')
                ->where('MRFId', $InsertId)
                ->update(['JobCode' => $jobCode]);

            if (!$query1) {
                return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
            } else {
                return response()->json(['status' => 200, 'msg' => 'New MRF has been successfully created.']);
            }
        }
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


    public function getAllMRFCreatedByMe()
    {
        $mrf = DB::table('manpowerrequisition')
            ->Join('master_designation', 'manpowerrequisition.DesigId', '=', 'master_designation.DesigId')
            ->where('CreatedBy',Auth::user()->id)
            ->select('manpowerrequisition.MRFId', 'manpowerrequisition.Type', 'manpowerrequisition.JobCode', 'manpowerrequisition.CreatedBy', 'master_designation.DesigName', 'manpowerrequisition.Status', 'manpowerrequisition.CreatedTime');
        return Datatables::of($mrf)
            ->addIndexColumn()
            ->addColumn('MRFDate', function ($mrf) {
                return date('d-m-Y', strtotime($mrf->CreatedTime));
            })
            ->addColumn('CreatedBy', function ($mrf) {
                if ($mrf->Type == 'N_HrManual' || $mrf->Type == 'R_HrManual') {
                    return 'HR';
                } else {
                    return getFullName($mrf->CreatedBy);
                }
            })

            ->editColumn('Type', function ($mrf) {
                if ($mrf->Type == 'N' || $mrf->Type == 'N_HrManual') {
                    return 'New';
                } else {
                    return 'Replacement';
                }
            })

            ->addColumn('actions', function ($mrf) {
                if ($mrf->Status == 'New') {
                    return '<button class="btn btn-sm  btn-outline-info font-13 view" data-id="' . $mrf->MRFId . '" id="viewBtn"><i class="fadeIn animated lni lni-eye"></i></button> <button class="btn btn-sm  btn-outline-primary font-13 edit" data-id="' . $mrf->MRFId . '" id="editBtn"><i class="fadeIn animated bx bx-pencil"></i></button>  
                <button class="btn btn-sm btn btn-outline-danger font-13 delete" data-id="' . $mrf->MRFId . '" id="deleteBtn"><i class="fadeIn animated bx bx-trash"></i></button>';
                } else {
                    return '<button class="btn btn-sm  btn-outline-primary font-13 view" data-id="' . $mrf->MRFId . '" id="viewBtn"><i class="fadeIn animated lni lni-eye"></i></button>';
                }
            })

      
            ->rawColumns(['actions'])
            ->make(true);
    }
}
