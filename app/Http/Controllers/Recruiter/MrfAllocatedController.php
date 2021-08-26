<?php

namespace App\Http\Controllers\recruiter;

use App\Http\Controllers\Controller;
use App\Models\master_mrf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function App\Helpers\getStateCode;
use function App\Helpers\getDistrictName;

class MrfAllocatedController extends Controller
{
    function mrf_allocated()
    {
        return view('recruiter.mrf_allocated');
    }

    function getAllAllocatedMRF(Request $request)
    {

        $usersQuery = master_mrf::query();

        $Company = $request->Company;
        $Department = $request->Department;
        $Year = $request->Year;
        $Month = $request->Month;
        if ($Company != '') {

            $usersQuery->where("manpowerrequisition.CompanyId", $Company);
        }
        if ($Department != '') {
            $usersQuery->where("manpowerrequisition.DepartmentId", $Department);
        }
        if ($Year != '') {
            $usersQuery->whereBetween('manpowerrequisition.CreatedTime', [$Year . '-01-01', $Year . '-12-31']);
        }
        if ($Month != '') {
            if ($Year != '') {
                $usersQuery->whereBetween('manpowerrequisition.CreatedTime', [$Year . '-' . $Month . '-01', $Year . '-' . $Month . '-31']);
            } else {
                $usersQuery->whereBetween('manpowerrequisition.CreatedTime', [date('Y') . '-' . $Month . '-01', date('Y') . '-' . $Month . '-31']);
            }
        }
        $mrf = $usersQuery->select('*')->Join('master_designation', 'manpowerrequisition.DesigId', '=', 'master_designation.DesigId')->Join('master_department', 'manpowerrequisition.DepartmentId', '=', 'master_department.DepartmentId')->where('Allocated', Auth::user()->id);
        return datatables()->of($mrf)
            ->addIndexColumn()
            ->addColumn('chk', function () {
                return '<input type="checkbox" class="select_all">';
            })
            ->editColumn('Type', function ($mrf) {
                if ($mrf->Type == 'N' || $mrf->Type == 'N_HrManual') {
                    return 'New';
                } else {
                    return 'Replacement';
                }
            })
            ->editColumn('LocationIds', function ($mrf) {
                $location = unserialize($mrf->LocationIds);
                $loc = '';
                foreach ($location as $key => $value) {
                    $loc .= getDistrictName($value['city']) . ' ';
                    $loc .= getStateCode($value['state']) . ' - ';
                    $loc .= $value['nop'] . ', ';
                    $loc . '<br>';
                }
                return $loc;
            })
            ->addColumn('details', function ($mrf) {

                return '<button class="btn btn-xs  btn-outline-primary font-13 view" data-id="' . $mrf->MRFId . '" id="viewBtn"><i class="fadeIn animated lni lni-eye"></i></button>';
            })


            ->rawColumns(['chk', 'details'])
            ->make(true);
    }


    public function getDepartmentForRec(Request $request)
    {
        $Department = DB::table("master_department")->orderBy('DepartmentName', 'asc')
            ->where("CompanyId", $request->CompanyId)
            ->pluck("DepartmentId", "DepartmentName");
        return response()->json($Department);
    }
}
