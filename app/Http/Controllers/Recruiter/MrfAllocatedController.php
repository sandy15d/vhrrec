<?php

namespace App\Http\Controllers\recruiter;

use App\Helpers\LogActivity;
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

class MrfAllocatedController extends Controller
{
    function mrf_allocated()
    {
        return view('recruiter.mrf_allocated');
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

        $mrf = $usersQuery->select('*')->Join('master_designation', 'manpowerrequisition.DesigId', '=', 'master_designation.DesigId')->Join('master_department', 'manpowerrequisition.DepartmentId', '=', 'master_department.DepartmentId')->where('Allocated', Auth::user()->id);

        return datatables()->of($mrf)
            ->addIndexColumn()
            ->addColumn('chk', function () {
                return '<input type="checkbox" class="select_all">';
            })
            ->editColumn('Type', function ($mrf) {
                if ($mrf->Type == 'N' || $mrf->Type == 'N_HrManual') {
                    return 'New';
                } else {
                    return 'Replacement';
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
                    return '<b class="text-success">Created</b>';
                } else {
                    return '<a class="btn btn-warning btn-xs"  href="javascript:void(0);" data-bs-toggle="modal"
                    data-bs-target="#createpostmodal" onclick="getDetailForJobPost(' . $mrf->MRFId . ')"><i class="fa fa-plus-square-o"></i>Create</a>';
                }
            })
            ->addColumn('JobShow', function ($mrf) {
                $check = CheckJobPostCreated($mrf->MRFId);
                if ($check == 1) {
                    $sql = Db::table('jobpost')->select('PostingView')->where('MRFId', $mrf->MRFId)->first();
                    $PostView = $sql->PostingView;

                    $x = '<select name="PostingView" id="postStatus' . $mrf->MRFId . '" class="form-control form-select form-select-sm  d-inline" disabled style="width: 100px;" onchange="ChngPostingView(' . $mrf->MRFId . ',this.value)">' ;
                    
                    if($PostView == 'Show'){
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

                return '<i id="viewBtn" class="fadeIn animated lni lni-eye  text-primary view" aria-hidden="true" data-id="' . $mrf->MRFId . '"  style="font-size: 18px;cursor: pointer;"></i>';
            })


            ->rawColumns(['chk', 'details', 'JobShow', 'JobPost'])
            ->make(true);
    }




    public function getDetailForJobPost(Request $request)
    {
        $MRFId = $request->MRFId;
        $MRFDetails = master_mrf::find($MRFId);
        $KPDetail = unserialize($MRFDetails->KeyPositionCriteria);
        return response()->json(['MRFDetails' => $MRFDetails, 'KPDetails' => $KPDetail, 'Designation' => getDesignationCode($MRFDetails['DesigId'])]);
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

        $Desig = $MRFDetails['DesigId'];
        $Title = getDesignation($MRFDetails['DesigId']);

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
        if (!$query) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {
            LogActivity::addToLog('New JobPost ' . $JobCode . ' is created by ' . getFullName(Auth::user()->id), 'Create');

            return response()->json(['status' => 200, 'msg' => 'New JobPost has been successfully created.']);
        }
    }
}
