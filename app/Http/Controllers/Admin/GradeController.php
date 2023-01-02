<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Admin\master_grade;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use DataTables;

class GradeController extends Controller
{
    public function grade()
    {
        return view('admin.grade');
    }
    public function getAllGrade()
    {
        $grade = DB::table('master_grade')
            ->join('master_company', 'master_grade.CompanyId', '=', 'master_company.CompanyId')
            ->where('master_grade.CompanyId', '=', session('Set_Company'))
            ->select(['master_grade.*', 'master_company.CompanyCode']);

        return datatables()->of($grade)
            ->addIndexColumn()
            ->make(true);
    }

    public function syncGrade()
    {

        $query =  master_grade::truncate();
        $response = Http::get('https://www.vnress.in/RcdDetails.php?action=Details&val=Grade')->json();
        $data = array();
        foreach ($response['grade_list'] as $key => $value) {

            $temp = array();
            $temp['GradeId'] = $value['GradeId'];
            $temp['GradeValue'] = $value['GradeValue'];
            $temp['CompanyId'] = $value['CompanyId'];
            $temp['GradeStatus'] = $value['GradeStatus'];
            array_push($data, $temp);
        }
        $query = master_grade::insert($data);


        if ($query) {
            return response()->json(['status' => 200, 'msg' => 'Grade data has been Synchronized.']);
        } else {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        }
    }
}
