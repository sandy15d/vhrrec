<?php

namespace App\Http\Controllers\recruiter;

use App\Helpers\LogActivity;
use App\Helpers\UserNotification;
use App\Http\Controllers\Controller;
use App\Models\master_mrf;
use App\Models\Recruiter\master_post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function App\Helpers\CheckJobPostCreated;
use function App\Helpers\convertData;
use function App\Helpers\getDepartment;
use function App\Helpers\getDesignation;
use function App\Helpers\getDesignationCode;
use function App\Helpers\getStateCode;
use function App\Helpers\getDistrictName;
use function App\Helpers\getFullName;
use function App\Helpers\GetJobPostId;

class MrfAllocatedController extends Controller
{
    function mrf_allocated()
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

        $CloseActive = DB::table('manpowerrequisition')
            ->where('Type', '!=', 'Campus')
            ->where('Type', '!=', 'Campus_HrManual')
            ->where('Allocated', Auth::user()->id)
            ->where('Status', 'Close')
            ->get();
        $CloseMRF = $CloseActive->count();

        $OpenMRFSQL = DB::table('manpowerrequisition')
            ->where('Type', '!=', 'Campus')
            ->where('Type', '!=', 'Campus_HrManual')
            ->where('Allocated', Auth::user()->id)
            ->where('Status', '!=', 'Close')

            ->get();
        $OpenMRF = $OpenMRFSQL->count();
        return view('recruiter.mrf_allocated', compact('company_list', 'department_list', 'state_list', 'institute_list', 'designation_list', 'employee_list', 'months', 'CloseMRF', 'OpenMRF'));
    }

    function campus_mrf_allocated()
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

        $CloseActive = DB::table('manpowerrequisition')
            ->where('Allocated', Auth::user()->id)
            ->where('Status', 'Close')
            ->where(function ($query) {
                $query->where('Type', 'Campus')
                    ->orWhere('Type', 'Campus_HrManual');
            })
            ->get();
        $CloseMRF = $CloseActive->count();

        $OpenMRFSQL = DB::table('manpowerrequisition')
            ->where('Allocated', Auth::user()->id)
            ->where('Status', '!=', 'Close')
            ->where(function ($query) {
                $query->where('Type', 'Campus')
                    ->orWhere('Type', 'Campus_HrManual');
            })
            ->get();
        $OpenMRF = $OpenMRFSQL->count();
        return view('recruiter.campus_mrf_allocated ', compact('company_list', 'department_list', 'state_list', 'institute_list', 'designation_list', 'employee_list', 'months', 'CloseMRF', 'OpenMRF'));
    }

    function getAllAllocatedMRF(Request $request)
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

        if ($request->MrfStatus == 'Open') {
            $usersQuery->where('manpowerrequisition.Status', '!=', 'Close');
        } else {
            $usersQuery->where('manpowerrequisition.Status', 'Close');
        }

        $mrf = $usersQuery->select('*')->Join('master_designation', 'manpowerrequisition.DesigId', '=', 'master_designation.DesigId', 'left')
            ->Join('master_department', 'manpowerrequisition.DepartmentId', '=', 'master_department.DepartmentId')
            ->where('Allocated', Auth::user()->id)
            ->where('Type', '!=', 'Campus')
            ->where('Type', '!=', 'Campus_HrManual');

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

                return '<i  class="fadeIn animated lni lni-eye  text-primary view" aria-hidden="true" data-id="' . $mrf->MRFId . '" id="viewMRF"  style="font-size: 18px;cursor: pointer;"></i>';
            })


            ->rawColumns(['chk', 'details', 'JobShow', 'JobPost'])
            ->make(true);
    }

    function getAllCampusAllocatedMrf(Request $request)
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

        if ($request->MrfStatus == 'Open') {
            $usersQuery->where('manpowerrequisition.Status', '!=', 'Close');
        } else {
            $usersQuery->where('manpowerrequisition.Status', 'Close');
        }

        $mrf = $usersQuery->select('*')
            ->Join('master_designation', 'manpowerrequisition.DesigId', '=', 'master_designation.DesigId', 'left')
            ->Join('master_department', 'manpowerrequisition.DepartmentId', '=', 'master_department.DepartmentId')
            ->where('Allocated', Auth::user()->id)
            ->where(function ($query) {
                $query->where('manpowerrequisition.Type', 'Campus')
                    ->orWhere('manpowerrequisition.Type', 'Campus_HrManual');
            });


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

            ->addColumn('details', function ($mrf) {
                return '<i  class="fadeIn animated lni lni-eye  text-primary view" aria-hidden="true" data-id="' . $mrf->MRFId . '" id="viewMRF"  style="font-size: 18px;cursor: pointer;"></i>';
            })
            ->addColumn('Link', function ($mrf) {
                 $JPId = GetJobPostId($mrf->MRFId);
                 if($JPId>0){
                    $PostId = base64_encode($JPId);
                   
                    $x = '<input type="text" id="link'.$JPId.'" value="' . url('jobportal/campus_placement_registration?job='.$PostId.'') . '">  <button onclick="copylink('.$JPId.')" class="btn btn-sm btn-primary"> Copy</button>';
                    return $x;
                 }else{
                     return 'Job Post Not Created Yet';
                 }
                
            })


            ->rawColumns(['chk', 'details', 'JobShow', 'JobPost','Link'])
            ->make(true);
    }

    public function getDetailForJobPost(Request $request)
    {
        $MRFId = $request->MRFId;
        $MRFDetails = master_mrf::find($MRFId);
        $KPDetail = unserialize($MRFDetails->KeyPositionCriteria);
        $Designation = $MRFDetails['DesigId'] == 0 ? 'SIP Trainee' : getDesignationCode($MRFDetails['DesigId']);
        $EducationDetail = unserialize($MRFDetails->EducationId);
        $LocationDetail = unserialize($MRFDetails->LocationIds);
        return response()->json(['MRFDetails' => $MRFDetails, 'KPDetails' => $KPDetail, 'Designation' => $Designation, 'LocationDetails' => $LocationDetail, 'EducationDetails' => $EducationDetail]);
    }

    public function createJobPost(Request $request)
    {

        $MRFId = $request->MRFId;
        $KeyPosition = $request->KeyPosition;
        $JobCode = $request->JobCode;
        $KpArray = array();
        if ($KeyPosition != '') {
            for ($i = 0; $i < Count($KeyPosition); $i++) {
                $KP = addslashes($KeyPosition[$i]);
                array_push($KpArray, $KP);
            }
        }
        $KpArray_str = serialize($KpArray);
        $MRFDetails = master_mrf::find($MRFId);
        $Company = $MRFDetails['CompanyId'];
        $Department = $MRFDetails['DepartmentId'];

        $Desig = $MRFDetails['DesigId'] == 0 ? 0 : $MRFDetails['DesigId'];
        $Title = $MRFDetails['DesigId'] == 0 ? 'SIP Trainee' : getDesignation($MRFDetails['DesigId']);

        $Education = $MRFDetails['EducationId'];
        $Location = $MRFDetails['Location'];
        $Status = 'Open';

        $SQL = new master_post;
        $SQL->MRFId = $MRFId;
        $SQL->CompanyId = $Company;
        $SQL->DepartmentId = $Department;
        $SQL->DesigId = $Desig;
        $SQL->JobCode = $JobCode;
        $SQL->Title = $Title;
        $SQL->ReqQualification = $Education;
        $SQL->Description = convertData($request->JobInfo);
        $SQL->Location = $Location;
        $SQL->KeyPositionCriteria = $KpArray_str;
        $SQL->PostingView = 'Hidden';
        $SQL->Status = $Status;
        $SQL->CreatedBy =  Auth::user()->id;
        $query = $SQL->save();


        $sql1 = master_mrf::find($MRFId);
        $sql1->info = convertData($request->JobInfo);
        $sql1->KeyPositionCriteria = $KpArray_str;
        $sql1->UpdatedBy = Auth::user()->id;
        $sql1->LastUpdated = now();
        $query = $sql1->save();

        if (!$query) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {
            LogActivity::addToLog('New JobPost ' . $JobCode . ' is created by ' . getFullName(Auth::user()->id), 'Create');
            UserNotification::notifyUser(1, 'Job Post Create', $JobCode);
            return response()->json(['status' => 200, 'msg' => 'New JobPost has been successfully created.']);
        }
    }
    public function createJobPost_Campus(Request $request)
    {

        $MRFId = $request->MRFId;
        $KeyPosition = $request->KeyPosition;
        $JobCode = $request->JobCode;
        $State = $request->State;
        $City = $request->City;
        $ManPower = $request->ManPower;
        $Education = $request->Education;
        $Specialization = $request->Specialization;


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

        $MRFDetails = master_mrf::find($MRFId);
        $Company = $MRFDetails['CompanyId'];
        $Department = $MRFDetails['DepartmentId'];
        $Desig = $MRFDetails['DesigId'];
        $Title =  getDesignation($MRFDetails['DesigId']);

        $Status = 'Open';

        $SQL = new master_post;
        $SQL->MRFId = $MRFId;
        $SQL->CompanyId = $Company;
        $SQL->DepartmentId = $Department;
        $SQL->DesigId = $Desig;
        $SQL->JobCode = $JobCode;
        $SQL->Title = $Title;
        $SQL->PayPackage = $request->PayPackage;
        $SQL->LastDate = $request->LastDate;
        $SQL->ReqQualification = $EduArray_str;
        $SQL->Description = convertData($request->JobInfo);
        $SQL->Location = $locArray_str;
        $SQL->KeyPositionCriteria = $KpArray_str;
        $SQL->PostingView = 'Hidden';
        $SQL->JobPostType = 'Campus';
        $SQL->Status = $Status;
        $SQL->CreatedBy =  Auth::user()->id;
        $query = $SQL->save();


        $sql1 = master_mrf::find($MRFId);
        $sql1->info = convertData($request->JobInfo);
        $sql1->KeyPositionCriteria = $KpArray_str;
        $sql1->LocationIds = $locArray_str;
        $sql1->EducationId = $EduArray_str;
        $sql1->UpdatedBy = Auth::user()->id;
        $sql1->LastUpdated = now();
        $query = $sql1->save();

        if (!$query) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {
            LogActivity::addToLog('Campus JobPost ' . $JobCode . ' is created by ' . getFullName(Auth::user()->id), 'Create');
            UserNotification::notifyUser(1, 'Job Post Create', $JobCode);
            return response()->json(['status' => 200, 'msg' => 'Campus JobPost has been successfully created.']);
        }
    }

    public function ChngPostingView(Request $request)
    {
        $SQL = master_post::find($request->JPId);
        $SQL->PostingView = $request->va;
        $SQL->UpdatedBy = Auth::user()->id;
        $SQL->LastUpdated = now();
        $query = $SQL->save();
        if (!$query) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {
            $jobCode = $SQL->JobCode;
            LogActivity::addToLog('Job Posting ' . $jobCode . ' is now ' . $request->va . ' in Ess/Site', 'Update');
            return response()->json(['status' => 200, 'msg' => 'Job Posting Viewing Status has been changed successfully.']);
        }
    }
}