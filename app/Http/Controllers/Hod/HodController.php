<?php

namespace App\Http\Controllers\Hod;

use App\Http\Controllers\Controller;
use App\Models\ThemeDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DataTables;

class HodController extends Controller
{
    function index()
    {
        return view('hod.index');
    }

    function myteam()
    {
        return view('hod.myteam');
    }

    function getAllMyTeamMember()
    {
     
      /*   $employee = DB::table('master_employee as e')
            ->join('master_company as c', 'e.CompanyId', '=', 'c.CompanyId')
            ->join('master_employee as e1', 'e1.EmployeeID', '=', 'e.RepEmployeeID')
            ->join('master_department as d', 'd.DepartmentId', '=', 'e.DepartmentId')
            ->join('master_designation as dg', 'dg.DesigId', '=', 'e.DesigId')
            ->join('master_grade as g', 'g.GradeId', '=', 'e.GradeId')
            ->join('master_headquater as h', 'h.HqId', '=', 'e.Location')
            ->where('e.RepEmployeeID', Auth::user()->id)

            ->where('e.EmpStatus', 'A')
            ->orWhere(function ($query) {
                $query->where('e.EmpStatus', 'D')
                    ->where('e.DateOfSepration', '>=', '2021-01-01');
            })
            
            ->select(['e.*', 'e1.Fname as RFname', 'e1.Sname as RSname', 'e1.Lname as RLname', 'c.CompanyCode', 'd.DepartmentCode', 'dg.DesigName', 'g.GradeValue', 'h.HqName'])->toSql();
            print_r($employee);
      */

        
        return Datatables::of($employee)
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


































    function setTheme(Request $request)
    {
        $ThemeStyle = $request->ThemeStyle;
        if ($ThemeStyle != '') {
            if ($ThemeStyle == 'lightmode') {
                $Style = 'light-theme';
                $SidebarColor = '';
            } elseif ($ThemeStyle == 'darkmode') {
                $Style = 'dark-theme';
                $SidebarColor = '';
            } elseif ($ThemeStyle == 'semidark') {
                $Style = 'semi-dark';
                $SidebarColor = '';
            } elseif ($ThemeStyle == 'minimaltheme') {
                $Style = 'minimal-theme';
                $SidebarColor = '';
            } elseif ($ThemeStyle == 'sidebarcolor1') {
                $Style = '';
                $SidebarColor = 'color-sidebar sidebarcolor1';
            } elseif ($ThemeStyle == 'sidebarcolor2') {
                $Style = '';
                $SidebarColor = 'color-sidebar sidebarcolor2';
            } elseif ($ThemeStyle == 'sidebarcolor3') {
                $Style = '';
                $SidebarColor = 'color-sidebar sidebarcolor3';
            } elseif ($ThemeStyle == 'sidebarcolor4') {
                $Style = '';
                $SidebarColor = 'color-sidebar sidebarcolor4';
            } elseif ($ThemeStyle == 'sidebarcolor5') {
                $Style = '';
                $SidebarColor = 'color-sidebar sidebarcolor5';
            } elseif ($ThemeStyle == 'sidebarcolor6') {
                $Style = '';
                $SidebarColor = 'color-sidebar sidebarcolor6';
            } elseif ($ThemeStyle == 'sidebarcolor7') {
                $Style = '';
                $SidebarColor = 'color-sidebar sidebarcolor7';
            } elseif ($ThemeStyle == 'sidebarcolor8') {
                $Style = '';
                $SidebarColor = 'color-sidebar sidebarcolor8';
            }


            $data = array(
                'ThemeStyle' => $Style,
                'SidebarColor' => $SidebarColor,
                'UserId' => Auth::user()->id,
            );
            $query =  ThemeDetail::updateOrCreate(['UserId' => Auth::user()->id], $data);

            if (!$query) {
                return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
            } else {
                $request->session()->forget('ThemeStyle');
                $request->session()->forget('SidebarColor');
                $request->session()->put('ThemeStyle', $Style);
                $request->session()->put('SidebarColor', $SidebarColor);
                return response()->json(['status' => 200, 'msg' => 'New Theme has been successfully Applied.']);
            }
        }
    }
}
