<?php

namespace App\Http\Controllers\Hod;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use function App\Helpers\getFullName;

class HodController extends Controller
{
    function index()
    {
        $company_list = DB::table("master_company")->where('Status', 'A')->orderBy('CompanyCode', 'desc')->pluck("CompanyCode", "CompanyId");
        $department_list = DB::table("master_department")->where('DeptStatus', 'A')->orderBy('DepartmentName', 'asc')->pluck("DepartmentName", "DepartmentId");
        $state_list = DB::table("states")->orderBy('StateName', 'asc')->pluck("StateName", "StateId");
        $institute_list = DB::table("master_institute")->orderBy('InstituteName', 'asc')->pluck("InstituteName", "InstituteId");
        $designation_list = DB::table("master_designation")->where('DesigName', '!=', '')->orderBy('DesigName', 'asc')->pluck("DesigName", "DesigId");
        $employee_list = DB::table('master_employee')->orderBy('FullName', 'ASC')
            ->where('EmpStatus', 'A')
            ->select('EmployeeID', DB::raw('CONCAT(Fname, " ", Lname) AS FullName'))
            ->pluck("FullName", "EmployeeID");
        return view('hod.index', compact('company_list', 'department_list', 'state_list', 'institute_list', 'designation_list', 'employee_list'));
    }



    public function mrfbyme()
    {
        $mrf = DB::table('manpowerrequisition')
            ->Join('master_designation', 'manpowerrequisition.DesigId', '=', 'master_designation.DesigId')
            ->where('manpowerrequisition.CreatedBy', Auth::user()->id)
            ->orWhere('manpowerrequisition.OnBehalf', Auth::user()->id)
            ->select('manpowerrequisition.MRFId', 'manpowerrequisition.Type', 'manpowerrequisition.JobCode', 'manpowerrequisition.CreatedBy', 'master_designation.DesigName', 'manpowerrequisition.Status', 'manpowerrequisition.CreatedTime');

        return datatables()::of($mrf)
            ->addIndexColumn()
            ->addColumn('MRFDate', function ($mrf) {
                return date('d-m-Y', strtotime($mrf->CreatedTime));
            })
            ->addColumn('CreatedBy', function ($mrf) {
                if ($mrf->Type == 'N_HrManual' || $mrf->Type == 'R_HrManual') {
                    return 'HR';
                } else {
                    return getFullName($mrf->CreatedBy);
                }
            })

            ->editColumn('Type', function ($mrf) {
                if ($mrf->Type == 'N' || $mrf->Type == 'N_HrManual') {
                    return 'New MRF';
                } else {
                    return 'Replacement MRF';
                }
            })

            ->addColumn('actions', function ($mrf) {
                if ($mrf->Status == 'New') {
                    return '<button class="btn btn-xs  btn-outline-info font-13 view" data-id="' . $mrf->MRFId . '" id="viewBtn"><i class="fadeIn animated lni lni-eye"></i></button> <button class="btn btn-sm  btn-outline-primary font-13 edit" data-id="' . $mrf->MRFId . '" id="editBtn"><i class="fadeIn animated bx bx-pencil"></i></button>  
                <button class="btn btn-xs btn btn-outline-danger font-13 delete" data-id="' . $mrf->MRFId . '" id="deleteBtn"><i class="fadeIn animated bx bx-trash"></i></button>';
                } else {
                    return '<button class="btn btn-xs  btn-outline-primary font-13 view" data-id="' . $mrf->MRFId . '" id="viewBtn"><i class="fadeIn animated lni lni-eye"></i></button>';
                }
            })
            ->addColumn('chk', function () {
                return '<input type="checkbox" class="select_all">';
            })
            ->rawColumns(['actions', 'chk'])
            ->make(true);
    }

    public function interviewschedule()
    {
       return view('hod.interviewschedule');
    }
}
