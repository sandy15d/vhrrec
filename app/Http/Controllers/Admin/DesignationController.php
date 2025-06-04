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
        $designation = DB::table('master_grade_designation')
        ->select('master_designation.DesigName', 'master_designation.DesigCode', 'master_department.DepartmentCode')
        ->leftJoin('master_department','master_department.DepartmentId','=','master_grade_designation.department_id')
        ->leftJoin('master_designation','master_designation.DesigId','=','master_grade_designation.designation_id')
        ->where('company_id',session('Set_Company'))
        ->whereNotNull('master_designation.DesigName');

        return datatables()->of($designation)
            ->addIndexColumn()
            ->make(true);
    }

    public function syncDesignation()
    {

     

        $query2 = DB::table('master_grade_designation')->truncate();
        $response2 = Http::get('https://vnress.in/RcdDetails.php?action=Details&val=grade_desig')->json();
        $data2 = array();
        foreach ($response2['grade_designation_list'] as $key => $value) {

            $temp2 = array();
            $temp2['department_id'] = $value['DepartmentId'];
            $temp2['designation_id'] = $value['DesigId'];
            $temp2['company_id'] = $value['CompanyId'];
            $temp2['grade_1'] = $value['GradeId'];
            $temp2['grade_2'] = $value['GradeId_2'];
            $temp2['grade_3'] = $value['GradeId_3'];
            $temp2['grade_4'] = $value['GradeId_4'];
            $temp2['grade_5'] = $value['GradeId_5'];
            $temp2['status'] = $value['DGDStatus'];
        
            array_push($data2, $temp2);
        }
        $query2 = DB::table('master_grade_designation')->insert($data2);
        if ($query2) {
            return response()->json(['status' => 200, 'msg' => 'Designation data has been Synchronized.']);
        } else {
            return response()->json(['status' => 500, 'msg' => 'Something went wrong..!!']);
        }
    }
}
