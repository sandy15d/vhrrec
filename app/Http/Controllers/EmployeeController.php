<?php

namespace App\Http\Controllers;

use App\Models\master_employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
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
        $employee = master_employee::all();
        return Datatables::of($employee)
            ->addIndexColumn()
            ->addColumn('fullname', function ($employee) {
                return $employee['Fname'] . ' ' . $employee['Sname'] . ' ' . $employee['Lname'];
            })
            ->addColumn('actions', function ($employee) {
                return '<button class="btn btn-sm  btn-outline-primary font-13 edit" data-id="' . $employee['EmployeeID'] . '" id="editBtn"><i class="fadeIn animated bx bx-pencil"></i></button>  
                <button class="btn btn-sm btn btn-outline-danger font-13 delete" data-id="' . $employee['EmployeeID'] . '" id="deleteBtn"><i class="fadeIn animated bx bx-trash"></i></button>';
            })
            ->rawColumns(['actions'])
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
            return response()->json(['code' => 1, 'msg' => 'Employee data has been Synchronized.']);
        } else {
            return response()->json(['code' => 0, 'msg' => 'Something went wrong..!!']);
        }
    }
}
