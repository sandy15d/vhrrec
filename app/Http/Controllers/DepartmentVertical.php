<?php

namespace App\Http\Controllers;

use App\Models\Admin\master_vertical;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class DepartmentVertical extends Controller
{
    public function department_vertical()
    {
        return view('admin.department_vertical');
    }

    public function getAllVertical()
    {
        $vertical = DB::table('master_vertical')
            ->join('master_company', 'master_vertical.CompanyId', '=', 'master_company.CompanyId')
            ->join('master_department', 'master_vertical.DepartmentId', '=', 'master_department.DepartmentId')
            ->select(['master_vertical.*', 'master_company.CompanyCode','master_department.DepartmentCode']);

        return datatables()->of($vertical)
            ->addIndexColumn()
            ->make(true);
    }

    public function syncVertical()
    {

        $query =  master_vertical::truncate();
        $response = Http::get('https://www.vnress.in/RcdDetails.php?action=Details&val=Vertical')->json();
        $data = array();
        foreach ($response['vertical_list'] as $key => $value) {

            $temp = array();
            $temp['VerticalId'] = $value['VerticalId'];
            $temp['CompanyId'] = $value['ComId'];
            $temp['DepartmentId'] = $value['DeptId'];
            $temp['VerticalName'] = $value['VerticalName'];
            array_push($data, $temp);
        }
        $query = master_vertical::insert($data);


        if ($query) {
            return response()->json(['status' => 200, 'msg' => 'Vertical data has been Synchronized.']);
        } else {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        }
    }
}
