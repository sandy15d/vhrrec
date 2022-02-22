<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\Admin\master_company;
use App\Models\Admin\master_designation;
use App\Models\PositionCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use function App\Helpers\getCompanyCode;
use function App\Helpers\getDepartmentCode;
use function App\Helpers\getDesignationCode;
use function App\Helpers\getFullName;
use function App\Helpers\getGradeValue;

class PositionCodeController extends Controller
{
    public function show_position_code()
    {
        $company_list = master_company::where('Status', 'A')->orderBy('CompanyCode', 'desc')->pluck("CompanyCode", "CompanyId");
        return view('common.position_code', compact('company_list'));
    }

    public function SyncPositionCode()
    {
        $query =  PositionCode::truncate();
        $response = Http::get('https://www.vnrseeds.co.in/hrims/RcdDetails?action=Details&val=getPositionCode')->json();
        $data = array();
        foreach ($response['PositionCode_List'] as $key => $value) {
            $temp = array();
            $temp['employee_id'] = $value['EmployeeID'];
            $temp['emp_code'] = $value['EmpCode'];
            $temp['company_id'] = $value['CompanyId'];
            $temp['department_id'] = $value['DepartmentId'];
            $temp['designation_id'] = $value['DesigId'];
            $temp['grade_id'] = $value['GradeId'];
            $temp['vertical'] = $value['PosVR'];
            $temp['position_code'] = $value['PositionCode'];
            $temp['sequence'] = $value['PosSeq'];


            array_push($data, $temp);
        }
        $query = PositionCode::insert($data);


        if ($query) {
            return response()->json(['status' => 200, 'msg' => 'Position Code data has been Synchronized.']);
        } else {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        }
    }

    public function show_all_position_code(Request $request)
    {

        $userQuery = PositionCode::query();
        $Company = $request->Company;
        $Department = $request->Department;
        $Designation = $request->Designation;
        if ($Company != '') {

            $userQuery->where("master_position_code.company_id", $Company);
        }
        if ($Department != '') {
            $userQuery->where("master_position_code.department_id", $Department);
        }
        if ($Designation != '') {
            $userQuery->where("master_position_code.designation_id", $Designation);
        }
        if ($request->Status != '') {
            $userQuery->where("master_employee.EmpStatus", $request->Status);
        }

        $sql = $userQuery->select('master_position_code.*', 'master_employee.Fname', 'master_employee.EmpStatus')->join('master_employee', 'master_employee.EmployeeID', '=', 'master_position_code.employee_id')->orderBy('department_id', 'asc')->get();
        return datatables()->of($sql)
            ->addIndexColumn()
            ->addColumn('fullname', function ($sql) {
                return getFullName($sql->employee_id);
            })
            ->addColumn('Company', function ($sql) {
                return getCompanyCode($sql->company_id);
            })
            ->addColumn('Department', function ($sql) {
                return getDepartmentCode($sql->department_id);
            })
            ->addColumn('Designation', function ($sql) {
                return getDesignationCode($sql->designation_id);
            })
            ->addColumn('Grade', function ($sql) {
                return getGradeValue($sql->grade_id);
            })
            ->make(true);
    }

    public function unused_position_code(Request $request)
    {

        $userQuery = DB::table('position_codes');
        $Company = $request->Company;
        $Department = $request->Department;
        $Designation = $request->Designation;
        if ($Company != '') {

            $userQuery->where("company_id", $Company);
        }
        if ($Department != '') {
            $userQuery->where("department_id", $Department);
        }
        if ($Designation != '') {
            $userQuery->where("designation_id", $Designation);
        }


        $sql = $userQuery->select('*')->where('is_available', 'Yes')->orderBy('department_id', 'asc')->get();
        return datatables()->of($sql)
            ->addIndexColumn()

            ->addColumn('Company', function ($sql) {
                return getCompanyCode($sql->company_id);
            })
            ->addColumn('Department', function ($sql) {
                return getDepartmentCode($sql->department_id);
            })
            ->addColumn('Designation', function ($sql) {
                return getDesignationCode($sql->designation_id);
            })
            ->addColumn('Grade', function ($sql) {
                return getGradeValue($sql->grade_id);
            })
            ->make(true);
    }

    public function add_position_code(Request $request)
    {

        $Company = $request->Company;
        $Department = $request->Department;
        $Designation = $request->Designation;
        $Grade = $request->Grade;
        $Vertical = $request->Vertical;
        $ShortCode = master_designation::find($Designation)->Desig_ShortCode;
        if ($ShortCode) {
            $check = DB::table('position_codes')->where('company_id', $Company)->where('department_id', $Department)->where('designation_id', $Designation)->where('grade_id', $Grade)->where('vertical', $Vertical)->first();

            if ($check) {
                $max_seq = DB::table('position_codes')->where('company_id', $Company)->where('department_id', $Department)->where('grade_id', $Grade)->where('vertical', $Vertical)->max('sequence');
                $seq = $max_seq + 1;
                $query = DB::table('position_codes')->insert([
                    'company_id' => $Company,
                    'department_id' => $Department,
                    'designation_id' => $Designation,
                    'grade_id' => $Grade,
                    'vertical' => $Vertical,
                    'position_code' => getDepartmentCode($Department) . '_' . $Vertical . '_' . $ShortCode . '_' . $seq,
                    'sequence' => $seq,
                    'is_available' => 'Yes',
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            } else {

                $seq = 1;
                $query = DB::table('position_codes')->insert([
                    'company_id' => $request->Company,
                    'department_id' => $request->Department,
                    'designation_id' => $request->Designation,
                    'grade_id' => $request->Grade,
                    'vertical' => $request->Vertical,
                    'position_code' => getDepartmentCode($Department) . '_' . $Vertical . '_' . $ShortCode . '_' . $seq,
                    'sequence' => 1,
                    'is_available' => 'Yes',
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }
            if ($query) {
                return response()->json(['status' => 200, 'msg' => 'Position Code has been added.']);
            } else {
                return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
            }
        } else {
            return response()->json(['status' => 400, 'msg' => 'Designation Short Code not found..!!']);
        }
    }
}
