<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\master_mrf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function App\Helpers\CheckJobPostCreated;
use function App\Helpers\getDistrictName;
use function App\Helpers\getStateCode;

class TraineeController extends Controller
{
    public function trainee_mrf_allocated()
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


        $close =  DB::table('manpowerrequisition');
        if (Auth::user()->role == 'R') {

            $close->where('Allocated', Auth::user()->id);
        }
        $close->where(function ($query) {
            $query->where('Type', 'SIP')
                ->orWhere('Type', 'SIP_HrManual');
        })
            ->where('status', 'Close')
            ->select('MRFId')
            ->get();
        $CloseMRF = $close->count();



        $open = DB::table('manpowerrequisition');
        if (Auth::user()->role == 'R') {
            $open->where('Allocated', Auth::user()->id);
        }
        $open->where(function ($query1) {
            $query1->where('Type', 'SIP')
                ->orWhere('Type', 'SIP_HrManual');
        })
            ->where('status', '!=', 'Close')
            ->select('MRFId')
            ->get();
        $OpenMRF = $open->count();
        return view('recruiter.trainee_mrf_allocated ', compact('company_list', 'department_list', 'state_list', 'institute_list', 'designation_list', 'employee_list', 'months', 'CloseMRF', 'OpenMRF'));
    }

    public function getAllTraineeAllocatedMrf(Request $request)
    {

        $usersQuery = master_mrf::query();
        $Company = $request->Company;
        $Department = $request->Department;
        $Year = $request->Year;
        $Month = $request->Month;

        if (Auth::user()->role == 'R') {
            $usersQuery->where('Allocated', Auth::user()->id);
        }
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
            ->where(function ($query) {
                $query->where('manpowerrequisition.Type', 'SIP')
                    ->orWhere('manpowerrequisition.Type', 'SIP_HrManual');
            });


        return datatables()->of($mrf)
            ->addIndexColumn()
            ->addColumn('chk', function () {
                return '<input type="checkbox" class="select_all">';
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
          
            ->rawColumns(['chk', 'details', 'JobPost' ])
            ->make(true);
    }
}
