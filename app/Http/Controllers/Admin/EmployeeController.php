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

    master_employee::truncate();

    $response = Http::get('https://vnress.in/RcdDetails.php?action=Details&val=Employee')->json();

    $data = [];
    $employeeIds = [];

    foreach ($response['employee_list'] as $rowNo => $value) {

        if (empty($value['DateJoining']) || $value['DateJoining'] == '0000-00-00') {
            $value['DateJoining'] = null;
        }

        if (empty($value['DateOfSepration']) || $value['DateOfSepration'] == '0000-00-00') {
            $value['DateOfSepration'] = null;
        }

        $empId = $value['EmployeeID'];

        // Log duplicates coming from API
        if (isset($employeeIds[$empId])) {
            \Log::info('Duplicate EmployeeID found in API', [
                'EmployeeID' => $empId,
                'first_row'  => $employeeIds[$empId],
                'duplicate_row' => $value,
                'row_no' => $rowNo
            ]);
        } else {
            $employeeIds[$empId] = $value;
        }

        $data[] = [
            'EmployeeID'      => $empId,
            'VCode'           => $value['VCode'],
            'EmpCode'         => $value['EmpCode'],
            'EmpStatus'       => $value['EmpStatus'],
            'Fname'           => $value['Fname'],
            'Sname'           => $value['Sname'],
            'Lname'           => $value['Lname'],
            'CompanyId'       => $value['CompanyId'],
            'GradeId'         => $value['GradeId'],
            'DepartmentId'    => $value['DepartmentId'],
            'DesigId'         => $value['DesigId'],
            'RepEmployeeID'   => $value['RepEmployeeID'],
            'DOJ'             => $value['DateJoining'],
            'DateOfSepration' => $value['DateOfSepration'],
            'Contact'         => $value['Contact'],
            'Email'           => $value['Email'],
            'Gender'          => $value['Gender'],
            'Married'         => $value['Married'],
            'DR'              => $value['DR'],
            'Location'        => $value['HqId'],
            'CTC'             => $value['Tot_CTC'],
            'Title'           => $value['Title'],
            'CountryId'       => 11,
        ];
    }

    try {
        master_employee::insert($data);

        return response()->json([
            'status' => 200,
            'msg' => 'Employee data has been Synchronized.'
        ]);

    } catch (\Illuminate\Database\QueryException $e) {

        // Log MySQL duplicate key error
        \Log::info('Employee insert failed', [
            'error' => $e->getMessage(),
            'sql' => $e->getSql(),
            'bindings' => $e->getBindings()
        ]);

        return response()->json([
            'status' => 500,
            'msg' => 'Duplicate key error. Check laravel.log for details.'
        ]);
    }
}

}
