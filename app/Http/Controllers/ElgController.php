<?php

namespace App\Http\Controllers;

use App\Models\Admin\master_elg;
use App\Models\Admin\master_vertical;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ElgController extends Controller
{
    public function lodging()
    {
        $department_list = DB::table("master_department")->where('DeptStatus', 'A')->where('CompanyId', session('Set_Company'))->orderBy('DepartmentName', 'asc')->pluck("DepartmentName", "DepartmentId");
        return view('admin.lodging', compact('department_list'));
    }

    public function travel()
    {
        $department_list = DB::table("master_department")->where('DeptStatus', 'A')->where('CompanyId', session('Set_Company'))->orderBy('DepartmentName', 'asc')->pluck("DepartmentName", "DepartmentId");
        return view('admin.travel', compact('department_list'));
    }

    public function getAllLodging(Request $request)
    {
        $usersQuery = master_elg::query();
        $Department = $request->Department;
        if ($Department != '') {
            $usersQuery->where("master_eligibility.DepartmentId", $Department);
        }
        $elg = $usersQuery->select(['master_eligibility.*', 'core_company.company_code', 'core_department.department_code', 'core_vertical.vertical_name'])
            ->leftjoin('core_company', 'master_eligibility.CompanyId', '=', 'core_company.id')
            ->leftjoin('core_department', 'master_eligibility.DepartmentId', '=', 'core_department.id')
            ->leftjoin('core_vertical', 'master_eligibility.VerticalId', '=', 'core_vertical.id')
            ->orderBy('core_department.id', 'ASC')
            ->orderBy('master_eligibility.GradeId', 'ASC');


        return datatables()->of($elg)
            ->addIndexColumn()
            ->make(true);
    }


    public function getAllTravel(Request $request)
    {
        $usersQuery = master_elg::query();
        $Department = $request->Department;
        if ($Department != '') {
            $usersQuery->where("master_eligibility.DepartmentId", $Department);
        }
        $elg = $usersQuery->select(['master_eligibility.*', 'master_company.CompanyCode', 'master_department.DepartmentCode', 'master_vertical.VerticalName'])
            ->leftjoin('master_company', 'master_eligibility.CompanyId', '=', 'master_company.CompanyId')
            ->leftjoin('master_department', 'master_eligibility.DepartmentId', '=', 'master_department.DepartmentId')
            ->leftjoin('master_vertical', 'master_eligibility.VerticalId', '=', 'master_vertical.VerticalId')
            ->orderBy('master_department.DepartmentId', 'ASC')
            ->orderBy('master_eligibility.GradeId', 'ASC');


        return datatables()->of($elg)
            ->addIndexColumn()
            ->make(true);
    }

    public function syncELg()
    {

        $query =  master_elg::truncate();
        $response = Http::get('https://www.vnress.in/RcdDetails.php?action=Details&val=elg')->json();
        $data = array();

        $query = master_elg::insert($response['eligibility_list']);


        if ($query) {
            return response()->json(['status' => 200, 'msg' => 'Eligibility data has been Synchronized.']);
        } else {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        }
    }
}
