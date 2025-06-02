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

        ini_set('memory_limit', '-1');
        $employee = DB::table('master_employee as e')
            ->leftJoin('core_company as c', 'e.CompanyId', '=', 'c.id')
            ->leftJoin('master_employee as e1', 'e1.EmployeeID', '=', 'e.RepEmployeeID')
            ->leftJoin('core_department as d', 'd.id', '=', 'e.DepartmentId')
            ->leftJoin('core_designation as dg', 'dg.id', '=', 'e.DesigId')
            ->leftJoin('core_grade as g', 'g.id', '=', 'e.GradeId')
            ->where('e.CountryId', session('Set_Country'))
            ->where('e.EmployeeId','>','100000')
              ->select(['e.*', 'e1.Fname as RFname', 'e1.Sname as RSname', 'e1.Lname as RLname', 'c.company_code', 'd.department_code', 'dg.designation_name', 'g.grade_name']);

        return datatables()->of($employee)
            ->addIndexColumn()
            ->addColumn('chk', function ($employee) {
                return '<input type="checkbox" class="select_all" value="' . $employee->EmployeeID . '">';
            })
            ->addColumn('fullname', function ($employee) {
                return trim("{$employee->Fname} {$employee->Sname} {$employee->Lname}");
            })
            ->addColumn('Reporting', function ($employee) {
                return trim("{$employee->RFname} {$employee->RSname} {$employee->RLname}");
            })
            ->rawColumns(['chk'])
            ->make(true);
    }

    public function syncEmployee()
    {
        ini_set('memory_limit', '-1');

        $query =  master_employee::truncate();
        $response = Http::get('https://www.vnress.in/RcdDetails.php?action=Details&val=Employee')->json();
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
            $temp['VCode'] = $value['VCode'];
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
            $temp['CountryId'] = 11;
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
