<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Admin\master_employee;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use DataTables;

class EmployeeController extends Controller
{

    public function employee()
    {
        return view('admin.employee');
    }
    public function getAllEmployeeData()
    {
        $employee = DB::table('master_employee as e')
            ->join('master_company as c', 'e.CompanyId', '=', 'c.CompanyId')
            ->join('master_employee as e1', 'e1.EmployeeID', '=', 'e.RepEmployeeID')
            ->join('master_department as d', 'd.DepartmentId', '=', 'e.DepartmentId')
            ->join('master_designation as dg', 'dg.DesigId', '=', 'e.DesigId')
            ->join('master_grade as g', 'g.GradeId', '=', 'e.GradeId')
            ->select(['e.*', 'e1.Fname as RFname', 'e1.Sname as RSname', 'e1.Lname as RLname', 'c.CompanyCode', 'd.DepartmentCode', 'dg.DesigName', 'g.GradeValue']);

        return datatables()->of($employee)
            ->addIndexColumn()
            ->addColumn('chk',function(){
                return '<input type="checkbox" class="select_all">';
            })
            ->addColumn('fullname', function ($employee) {
                return $employee->Fname . ' ' . $employee->Sname . ' ' . $employee->Lname;
            })
            ->addColumn('Reporting', function ($employee) {
                return $employee->RFname . ' ' . $employee->RSname . ' ' . $employee->RLname;
            })
            ->rawColumns(['chk'])
            ->make(true);
    }

    public function syncEmployee()
    {

        $query =  master_employee::truncate();
        $response = Http::get('https://www.vnrseeds.co.in/hrims/RcdDetails?action=Details&val=Employee')->json();
        $data = array();
        foreach ($response['employee_list'] as $key => $value) {
            if ($value['DateJoining'] == '0000-00-00' or $value['DateJoining'] == '') {
                $value['DateJoining'] = NULL;
            }
            if ($value['DateOfSepration'] == '0000-00-00' or $value['DateOfSepration'] == '') {
                $value['DateOfSepration'] = NULL;
            }
            $temp = array();
            $temp['EmployeeID'] = $value['EmployeeID'];
            $temp['EmpCode'] = $value['EmpCode'];
            $temp['EmpStatus'] = $value['EmpStatus'];
            $temp['Fname'] = $value['Fname'];
            $temp['Sname'] = $value['Sname'];
            $temp['Lname'] = $value['Lname'];
            $temp['CompanyId'] = $value['CompanyId'];
            $temp['GradeId'] = $value['GradeId'];
            $temp['DepartmentId'] = $value['DepartmentId'];
            $temp['DesigId'] = $value['DesigId'];
            $temp['RepEmployeeID'] = $value['RepEmployeeID'];
            $temp['DOJ'] = $value['DateJoining'];
            $temp['DateOfSepration'] = $value['DateOfSepration'];
            $temp['Contact'] = $value['Contact'];
            $temp['Email'] = $value['Email'];
            $temp['Gender'] = $value['Gender'];
            $temp['Married'] = $value['Married'];
            $temp['DR'] = $value['DR'];
            $temp['Location'] = $value['HqId'];
            $temp['CTC'] = $value['Tot_CTC'];
            $temp['Title'] = $value['Title'];

            array_push($data, $temp);
        }
        $query = master_employee::insert($data);


        if ($query) {
            return response()->json(['status' => 200, 'msg' => 'Employee data has been Synchronized.']);
        } else {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        }
    }
}
