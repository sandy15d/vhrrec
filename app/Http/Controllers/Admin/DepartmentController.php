<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Admin\master_department;
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
            ->where('master_department.CompanyId', '=', session('Set_Company'))
            ->select(['master_department.*', 'master_company.CompanyCode']);

        return datatables()->of($department)
            ->addIndexColumn()
            ->make(true);
    }

    public function syncDepartment()
    {

        $query =  master_department::truncate();
        
        $response1 = Http::get('https://www.vnrseeds.co.in/hrims/RcdDetails.php?action=Details&val=Department')->json();
        $data1 = array();
        foreach ($response1['department_list'] as $key => $value) {

            $temp = array();
            $temp['DepartmentId'] = $value['DepartmentId'];
            $temp['DepartmentName'] = $value['DepartmentName'];
            $temp['DepartmentCode'] = $value['DepartmentCode'];
            
            $temp['CompanyId'] = 11;
            $temp['DeptStatus'] = $value['DeptStatus'];
            array_push($data1, $temp);
        }
       
        $query1 = master_department::insert($data1);
        
        
        
        $response = Http::get('https://www.vnress.in/RcdDetails.php?action=Details&val=Department')->json();
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
