<?php

namespace App\Http\Controllers;

use App\Models\master_department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use DataTables;
class DepartmentController extends Controller
{
    public function department()
    {
        return view('admin.department');
    }
    public function getAllDepartment()
    {
        $department = DB::table('master_department')
            ->join('master_company', 'master_department.CompanyId', '=', 'master_company.CompanyId')
            ->select(['master_department.*', 'master_company.CompanyCode']);

        return Datatables::of($department)
            ->addIndexColumn()
            ->make(true);
    }

    public function syncDepartment()
    {

        $query =  master_department::truncate();
        $response = Http::get('https://www.vnrseeds.co.in/hrims/RcdDetails?action=Details&val=Department')->json();
        $data = array();
        foreach ($response['department_list'] as $key => $value) {
           
            $temp = array();
            $temp['DepartmentId'] = $value['DepartmentId'];
            $temp['DepartmentName'] = $value['DepartmentName'];
            $temp['DepartmentCode'] = $value['DepartmentCode'];
            $temp['CompanyId'] = $value['CompanyId'];
            $temp['DeptStatus'] = $value['DeptStatus'];
            array_push($data, $temp);
        }
        $query = master_department::insert($data);


        if ($query) {
            return response()->json(['status' => 200, 'msg' => 'Department data has been Synchronized.']);
        } else {
            return response()->json(['status' => 500, 'msg' => 'Something went wrong..!!']);
        }
    }
}
