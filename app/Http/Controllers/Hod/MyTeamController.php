<?php

namespace App\Http\Controllers\Hod;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DataTables;

class MyTeamController extends Controller
{
    function myteam()
    {
        return view('hod.myteam');
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
                return $employee->Fname . ' ' . $employee->Sname . ' ' . $employee->Lname;
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

            ->make(true);
    }

}
