<?php

namespace App\Http\Controllers\Hod;

use App\Http\Controllers\Controller;
use App\Models\master_mrf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DataTables;

use function App\Helpers\CheckReplacementMRF;

class MyTeamController extends Controller
{
    function myteam()
    {
        return view('hod.myteam');
    }

    function repmrf()
    {
        return view('hod.replacementmrf');
    }

    function getAllMyTeamMember()
    {
        $employee = DB::table('master_employee as e')
            ->Join('master_company as c', 'e.CompanyId', '=', 'c.CompanyId')
            ->Join('master_employee as e1', 'e1.EmployeeID', '=', 'e.RepEmployeeID')
            ->join('master_department as d', 'd.DepartmentId', '=', 'e.DepartmentId')
            ->join('master_designation as dg', 'dg.DesigId', '=', 'e.DesigId')
            ->join('master_grade as g', 'g.GradeId', '=', 'e.GradeId')
            ->join('master_headquater as h', 'h.HqId', '=', 'e.Location')
            ->orWhere(function ($query) {
                $query->orWhere(function ($query) {
                    $query->where('e.EmpStatus', 'D')
                        ->where('e.DateOfSepration', '>=', '2021-01-01');
                })
                    ->orWhere('e.Empstatus', 'A');
            })

            ->where('e.RepEmployeeID', Auth::user()->id)
            ->select(['e.*', 'e1.Fname as RFname', 'e1.Sname as RSname', 'e1.Lname as RLname', 'c.CompanyCode', 'd.DepartmentCode', 'dg.DesigName', 'g.GradeValue', 'h.HqName']);
        return datatables()::of($employee)
            ->addIndexColumn()
            ->addColumn('fullname', function ($employee) {
                return '<a href="javascript:void(0)" data-id="' . $employee->EmployeeID . '" class=" getMyTeam">' . $employee->Fname . ' ' . $employee->Sname . ' ' . $employee->Lname . '</a>';
            })

            ->addColumn('chk', function () {
                return '<input type="checkbox" class="select_all">';
            })
            ->addColumn('Reporting', function ($employee) {
                return $employee->RFname . ' ' . $employee->RSname . ' ' . $employee->RLname;
            })
            ->addColumn('Status', function ($employee) {
                if ($employee->EmpStatus == 'A') {
                    return 'Active';
                } elseif ($employee->EmpStatus == 'D') {
                    return 'Resigned';
                } elseif ($employee->EmpStatus == 'De') {
                    return 'Resigned';
                }
            })
            ->addColumn('MStatus', function ($employee) {
                if ($employee->EmpStatus == 'D') {
                    $check = CheckReplacementMRF($employee->EmployeeID);
                    if ($check == 0) {
                        return '<a href="javascript:void(0)" data-id="' . $employee->EmployeeID . '" class="text-primary addRepMRF">Vacant</a>';
                    } else {
                        return 'MRF Submitted';
                    }
                }
            })
            ->rawColumns(['chk', 'fullname', 'MStatus'])
            ->make(true);
    }



    public function getMyTeam(Request $request)
    {
        $emp = DB::table('master_employee as e')
            ->Join('master_company as c', 'e.CompanyId', '=', 'c.CompanyId')
            ->Join('master_employee as e1', 'e1.EmployeeID', '=', 'e.RepEmployeeID')
            ->join('master_department as d', 'd.DepartmentId', '=', 'e.DepartmentId')
            ->join('master_designation as dg', 'dg.DesigId', '=', 'e.DesigId')
            ->join('master_grade as g', 'g.GradeId', '=', 'e.GradeId')
            ->join('master_headquater as h', 'h.HqId', '=', 'e.Location')
            ->orWhere(function ($query) {
                $query->orWhere(function ($query) {
                    $query->where('e.EmpStatus', 'D')
                        ->where('e.DateOfSepration', '>=', '2021-01-01');
                })
                    ->orWhere('e.Empstatus', 'A');
            })

            ->where('e.RepEmployeeID', $request->EmployeeID)
            ->select(['e.*', 'e1.Fname as RFname', 'e1.Sname as RSname', 'e1.Lname as RLname', 'c.CompanyCode', 'd.DepartmentCode', 'dg.DesigName', 'g.GradeValue', 'h.HqName']);
        return datatables()::of($emp)
            ->addIndexColumn()
            ->addColumn('fullname', function ($emp) {
                return $emp->Fname . ' ' . $emp->Sname . ' ' . $emp->Lname;
            })
            ->addColumn('chk1', function () {
                return '<input type="checkbox" class="select_all">';
            })
            ->addColumn('Reporting', function ($emp) {
                return $emp->RFname . ' ' . $emp->RSname . ' ' . $emp->RLname;
            })
            ->addColumn('Status', function ($emp) {
                if ($emp->EmpStatus == 'A') {
                    return 'Active';
                } elseif ($emp->EmpStatus == 'D') {
                    return 'Resigned';
                } elseif ($emp->EmpStatus == 'De') {
                    return 'Resigned';
                }
            })
            ->addColumn('MStatus', function ($emp) {
                if ($emp->EmpStatus == 'D') {
                    $check = CheckReplacementMRF($emp->EmployeeID);
                    if ($check == 0) {
                        return '<a href="javascript:void(0)" data-id="' . $emp->EmployeeID . '" class="text-primary addRepMRF">Vacant</a>';
                    } else {
                        return 'MRF Submitted';
                    }
                }
            })
            ->rawColumns(['chk1','fullname', 'MStatus'])
            ->make(true);
    }
}
