<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Admin\master_designation;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use DataTables;

class DesignationController extends Controller
{
    public function designation()
    {
        return view('admin.designation');
    }
    public function getAllDesignation()
    {
        $designation = DB::table('master_designation')
            ->join('master_company', 'master_designation.CompanyId', '=', 'master_company.CompanyId')
            ->join('master_department', 'master_designation.DepartmentId', '=', 'master_department.DepartmentId')
            ->select(['master_designation.*', 'master_company.CompanyCode', 'master_department.DepartmentCode']);

        return datatables()::of($designation)
            ->addIndexColumn()
            ->make(true);
    }

    public function syncDesignation()
    {

        $query =  master_designation::truncate();
        $response = Http::get('https://www.vnrseeds.co.in/hrims/RcdDetails?action=Details&val=Designation')->json();
        $data = array();
        foreach ($response['Designation_list'] as $key => $value) {

            $temp = array();
            $temp['DesigId'] = $value['DesigId'];
            $temp['DesigName'] = $value['DesigName'];
            $temp['DesigCode'] = $value['DesigCode'];
            $temp['CompanyId'] = $value['CompanyId'];
            $temp['DesigStatus'] = $value['DesigStatus'];
            array_push($data, $temp);
        }
        $query = master_designation::insert($data);
        $response1 = Http::get('https://www.vnrseeds.co.in/hrims/RcdDetails?action=Details&val=DeptDesig')->json();

        foreach ($response1['Department_Designation_list'] as $key => $value) {
            $data1 = DB::table('master_designation')
                ->where('DesigId', $value['DesigId'])
                ->update(['DepartmentId' => $value['DepartmentId']]);
        }

        if ($query) {
            return response()->json(['status' => 200, 'msg' => 'Designation data has been Synchronized.']);
        } else {
            return response()->json(['status' => 500, 'msg' => 'Something went wrong..!!']);
        }
    }
}
