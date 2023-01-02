<?php

namespace App\Http\Controllers;

use App\Imports\UserImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

use function App\Helpers\getDepartmentCode;

class ImportController extends Controller
{
    public function importview()
    {
        return view('admin.import');
    }

    public function createmrf()
    {
        $query = DB::select("SELECT * FROM `master_designation` WHERE DesigId IN (SELECT DesigId FROM master_employee WHERE EmployeeID>100000)");
        $location = 'a:1:{i:0;a:3:{s:5:"state";s:1:"7";s:4:"city";s:3:"123";s:3:"nop";s:1:"3";}}';
        foreach ($query as $key => $value) {
            $DepartmentCode = getDepartmentCode($value->DepartmentId);
            $insert = DB::table('manpowerrequisition')->insert([
                'Type' => 'N_HrManual',
                'CountryId' => '11',
                'RepEmployeeID' => '0',
                'CompanyId' => '11',
                'DepartmentId' => $value->DepartmentId,
                'DesigId' => $value->DesigId,
                'Positions' => '10',
                'LocationIds' => $location,
                'Reporting' => '0',
                'Remarks' => 'For Outsource Employee Offer Letter',
                'Status' => 'Approved',
                'Allocated' => '1280',
                'AllocatedDt' => date('Y-m-d'),
                'OnBehalf' => '1',
                'CreatedTime' => date('Y-m-d H:i:s'),
                'CreatedBy' => '1280',
            ]);

            $MRFId = DB::getPdo()->lastInsertId();
            $update = DB::table('manpowerrequisition')->where('MRFId', $MRFId)->update([
                'JobCode' => 'VSPL/' . $DepartmentCode . '-' . $value->DesigCode . '/' . $MRFId . '-' . Date('Y'),
            ]);

            $insert_Jobpost = DB::table('jobpost')->insert([
                'MRFId'=>$MRFId,
                'CompanyId'=>'11',
                'DepartmentId'=>$value->DepartmentId,
                'DesigId'=>$value->DesigId,
                'JobCode'=>'VSPL/' . $DepartmentCode . '-' . $value->DesigCode . '/' . $MRFId . '-' . Date('Y'),
                'Title'=>$value->DesigName,
                'PostingView'=>'Hidden',
                'Status'=>'Open',
                'JobPostType'=>'Regular',
                'CreatedBy'=>'1280',
                'CreatedTime'=>date('Y-m-d H:i:s'),
            ]);
        }
    }


    public function import()
    {
        Excel::import(new UserImport, request()->file('file'));
        return back();
    }
}
