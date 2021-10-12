<?php

namespace App\Http\Controllers\Hod;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Mail\MrfCreationMail;
use App\Models\master_mrf;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

use function App\Helpers\convertData;
use function App\Helpers\getCompanyCode;
use function App\Helpers\getDepartmentCode;
use function App\Helpers\getDesignationCode;
use function App\Helpers\getFullName;

class MrfController extends Controller
{
    public $company_list;
    public $department_list;
    public $state_list;
    public $institute_list;

    function mrf()
    {
        return view('hod.mrf');
    }


    public function __construct()
    {
        $this->company_list = DB::table("master_company")->where('Status', 'A')->orderBy('CompanyCode', 'desc')->pluck("CompanyCode", "CompanyId");
        $this->department_list = DB::table("master_department")->where('DeptStatus', 'A')->where('CompanyId', session('Set_Company'))->orderBy('DepartmentName', 'asc')->pluck("DepartmentName", "DepartmentId");
        $this->state_list = DB::table("states")->orderBy('StateName', 'asc')->pluck("StateName", "StateId");
        $this->institute_list = DB::table("master_institute")->orderBy('InstituteName', 'asc')->pluck("InstituteName", "InstituteId");
    }


    function new_mrf()
    {
        
        $params = array(
            'company_list'=>$this->company_list,
            'department_list'=>$this->department_list,
            'state_list' => $this->state_list,
            "institute_list" => $this->institute_list
            );
        return view('hod.hod_new_mrf', compact('params'));
    }
    function sip_mrf()
    {
        $company_list = $this->company_list;
        $department_list = $this->department_list;
        $state_list = $this->state_list;
        $institute_list = $this->institute_list;
        return view('hod.hod_sip_mrf', compact('company_list', 'department_list', 'state_list', 'institute_list'));
    }
    function campus_mrf()
    {
        $company_list = $this->company_list;
        $department_list = $this->department_list;
        $state_list = $this->state_list;
        $institute_list = $this->institute_list;
        return view('hod.hod_campus_mrf', compact('company_list', 'department_list', 'state_list', 'institute_list'));
    }


    public function addNewMrf(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Reason' => 'required',
            'Company' => 'required',
            'Department' => 'required',
            'Designation' => 'required',
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


            $UniversityArray = array();
            if ($request->University != '') {
                $UniversityArray = serialize($request->University);
            }
            $MRF = new master_mrf;
            $MRF->Type = 'N';
            $MRF->Reason = $request->Reason;
            $MRF->CompanyId = $request->Company;
            $MRF->DepartmentId = $request->Department;
            $MRF->DesigId = $request->Designation;
            $MRF->Positions = array_sum($ManPower);
            $MRF->LocationIds = $locArray_str;
            $MRF->MinCTC = $request->MinCTC;
            $MRF->MaxCTC = $request->MaxCTC;
            $MRF->WorkExp = $request->WorkExp;
            $MRF->Remarks = $request->Remark;
            $MRF->Info = convertData($request->JobInfo);
            $MRF->EducationId = $EduArray_str;
            $MRF->EducationInsId = $UniversityArray;
            $MRF->KeyPositionCriteria = $KpArray_str;
            $MRF->CreatedBy =  Auth::user()->id;
            $MRF->Status = 'New';

            $MRF->save();

            $InsertId = $MRF->MRFId;

            $jobCode = getCompanyCode($request->Company) . '/' . getDepartmentCode($request->Department) . '/' . getDesignationCode($request->Designation) . '/' . $InsertId . '-' . date('Y');
            $query1 = DB::table('manpowerrequisition')
                ->where('MRFId', $InsertId)
                ->update(['JobCode' => $jobCode]);

            if (!$query1) {
                return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
            } else {
                LogActivity::addToLog('New MRF ' . $jobCode . ' is created by ' . getFullName(Auth::user()->id), 'Create');
                $details = [
                    "subject" => 'New MRF ' . $jobCode . ' is created by ' . getFullName(Auth::user()->id),
                    "Employee" => getFullName(Auth::user()->id),
                ];
                Mail::to("sandeepdewangan.vspl@gmail.com")->send(new MrfCreationMail($details));
                return response()->json(['status' => 200, 'msg' => 'New MRF has been successfully created.']);
            }
        }
    }


    public function addSipMrf(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Reason' => 'required',
            'Company' => 'required',
            'Department' => 'required',
          
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


            $UniversityArray = array();
            if ($request->University != '') {
                $UniversityArray = serialize($request->University);
            }
            $MRF = new master_mrf;
            $MRF->Type = 'SIP';
            $MRF->Reason = $request->Reason;
            $MRF->CompanyId = $request->Company;
            $MRF->DepartmentId = $request->Department;
            $MRF->Positions = array_sum($ManPower);
            $MRF->LocationIds = $locArray_str;
            $MRF->LocationIds = $request->stipend;
            $MRF->TwoWheeler = $request->two_wheeler;
            $MRF->DA = $request->da;
            $MRF->MinCTC = $request->MinCTC;
            $MRF->MaxCTC = $request->MaxCTC;
            $MRF->Remarks = $request->Remark;
            $MRF->Info = convertData($request->JobInfo);
            $MRF->EducationId = $EduArray_str;
            $MRF->EducationInsId = $UniversityArray;
            $MRF->KeyPositionCriteria = $KpArray_str;
            $MRF->CreatedBy =  Auth::user()->id;
            $MRF->Status = 'New';

            $MRF->save();

            $InsertId = $MRF->MRFId;

            $jobCode = getCompanyCode($request->Company) . '/' . getDepartmentCode($request->Department) . '/SIP/' . $InsertId . '-' . date('Y');
            $query1 = DB::table('manpowerrequisition')
                ->where('MRFId', $InsertId)
                ->update(['JobCode' => $jobCode]);

            if (!$query1) {
                return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
            } else {
                LogActivity::addToLog('SIP MRF ' . $jobCode . ' is created by ' . getFullName(Auth::user()->id), 'Create');
                $details = [
                    "subject" => 'SIP MRF ' . $jobCode . ' is created by ' . getFullName(Auth::user()->id),
                    "Employee" => getFullName(Auth::user()->id),
                ];
                Mail::to("sandeepdewangan.vspl@gmail.com")->send(new MrfCreationMail($details));
                return response()->json(['status' => 200, 'msg' => 'SIP/Internship MRF has been successfully created.']);
            }
        }
    }

    public function addRepMrf(Request $request)
    {
        $sql = DB::table('master_employee')->select('CompanyId', 'GradeId', 'DepartmentId', 'DesigId')->where('EmployeeID', $request->ReplacementFor)->first();
        $CompanyId = $sql->CompanyId;
        $GradeId = $sql->GradeId;
        $DepartmentId = $sql->DepartmentId;
        $DesigId = $sql->DesigId;

        $State = $request->State;
        $City = $request->City;

        $Education = $request->Education;
        $Specialization = $request->Specialization;
        $KeyPosition = $request->KeyPosition;

        $locArray = array();
        if ($State != '') {
            $location = array(
                "state" => $State,
                "city" => $City,
                "nop" => '1',
            );
            array_push($locArray, $location);
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


        $MRF = new master_mrf;
        $MRF->Type = 'R';
        $MRF->Reason = "For Replacment Of " . getFullName($request->ReplacementFor);
        $MRF->CompanyId = $CompanyId;
        $MRF->DepartmentId = $DepartmentId;
        $MRF->DesigId = $DesigId;
        $MRF->GradeId = $GradeId;
        $MRF->RepEmployeeID = $request->ReplacementFor;
        $MRF->Positions = 1;
        $MRF->LocationIds = $locArray_str;
        $MRF->Reporting = '';
        $MRF->ExistCTC = $request->ExCTC;
        $MRF->MinCTC = $request->MinCTC;
        $MRF->MaxCTC = $request->MaxCTC;
        $MRF->WorkExp = $request->WorkExp;
        $MRF->Remarks = $request->Remark;
        $MRF->Info = convertData($request->JobInfo);
        $MRF->EducationId = $EduArray_str;
        $MRF->EducationInsId = $UniversityArray;
        $MRF->KeyPositionCriteria = $KpArray_str;
        $MRF->CreatedBy =  Auth::user()->id;
        $MRF->Status = 'New';
        $MRF->Reporting = 0;

        $query = $MRF->save();

        $InsertId = $MRF->MRFId;

        $jobCode = getCompanyCode($CompanyId) . '/' . getDepartmentCode($DepartmentId) . '/' . getDesignationCode($DesigId) . '/' . $InsertId . '-' . date('Y');
        $query1 = DB::table('manpowerrequisition')
            ->where('MRFId', $InsertId)
            ->update(['JobCode' => $jobCode]);

        if (!$query1) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {
            LogActivity::addToLog('Replacement MRF ' . $jobCode . ' is created by ' . getFullName(Auth::user()->id), 'Create');
            $details = [
                "subject" => 'Replacement MRF ' . $jobCode . ' is created by ' . getFullName(Auth::user()->id),
                "Employee" => getFullName(Auth::user()->id),
            ];
            Mail::to("sandeepdewangan.vspl@gmail.com")->send(new MrfCreationMail($details));
            return response()->json(['status' => 200, 'msg' => 'New MRF has been successfully created.']);
        }
    }


    public function getAllMRFCreatedByMe()
    {
        $mrf = DB::table('manpowerrequisition')
            ->Join('master_designation', 'manpowerrequisition.DesigId', '=', 'master_designation.DesigId')
            ->where('CreatedBy', Auth::user()->id)
            ->select('manpowerrequisition.MRFId', 'manpowerrequisition.Type', 'manpowerrequisition.JobCode', 'manpowerrequisition.CreatedBy', 'master_designation.DesigName', 'manpowerrequisition.Status', 'manpowerrequisition.CreatedTime');
        return datatables()->of($mrf)
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
                    return 'New MRF';
                } elseif ($mrf->Type == 'SIP' || $mrf->Type == 'SIP_HrManual') {
                    return 'SIP/Internship MRF';
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
