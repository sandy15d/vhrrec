<?php

namespace App\Http\Controllers\Common;

use App\Models\screening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\master_employee;

class OfferLtrController extends Controller
{
    public function offer_letter(Request $request)
    {

        $company_list = DB::table("master_company")->where('Status', 'A')->orderBy('CompanyCode', 'desc')->pluck("CompanyCode", "CompanyId");
        $months = [1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'];
        $Company = $request->Company;
        $Department = $request->Department;
        $Year = $request->Year;
        $Month = $request->Month;
        $Gender = $request->Gender;
        $Status = $request->Status;
        $Name = $request->Name;
        $usersQuery = screening::query();
        if ($Company != '') {
            $usersQuery->where("screening.SelectedForC", $Company);
        }
        if ($Department != '') {
            $usersQuery->where("screening.SelectedForD", $Department);
        }
        if ($Year != '') {
            $usersQuery->whereBetween('jobapply.ApplyDate', [$Year . '-01-01', $Year . '-12-31']);
        }
        if ($Month != '') {
            if ($Year != '') {
                $usersQuery->whereBetween('jobapply.ApplyDate', [$Year . '-' . $Month . '-01', $Year . '-' . $Month . '-31']);
            } else {
                $usersQuery->whereBetween('jobapply.ApplyDate', [date('Y') . '-' . $Month . '-01', date('Y') . '-' . $Month . '-31']);
            }
        }

        if ($Gender != '') {
            $usersQuery->where("jobcandidates.Gender", $Gender);
        }
        if ($Status != '') {
            $usersQuery->where("offerletterbasic.Answer", $Status);
        }

        if ($Name != '') {
            $usersQuery->where("jobcandidates.FName", 'like', "%$Name%");
        }

        $candidate_list = $usersQuery->select('jobapply.JAId', 'jobcandidates.FName', 'jobcandidates.MName', 'jobcandidates.LName', 'jobcandidates.ReferenceNo', 'jobcandidates.CandidateImage', 'screening.SelectedForC', 'screening.SelectedForD', 'offerletterbasic.OfferLetterSent', 'offerletterbasic.JoiningFormSent', 'offerletterbasic.Answer', 'offerletterbasic.OfferLtrGen', 'offerletterbasic.OfferLetter', 'candjoining.JoinOnDt', 'offerletterbasic.SendReview', 'jobpost.JobCode')
            ->Join('jobapply', 'screening.JAId', '=', 'jobapply.JAId')
            ->Join('jobpost', 'jobpost.JPId', '=', 'jobapply.JPId')
            ->Join('jobcandidates', 'jobapply.JCId', '=', 'jobcandidates.JCId')
            ->leftJoin('offerletterbasic', 'jobapply.JAId', '=', 'offerletterbasic.JAId')
            ->leftJoin('candjoining', 'jobapply.JAId', '=', 'candjoining.JAId')
            ->whereNotNull('screening.SelectedForC')
            ->whereNotNull('screening.SelectedForD')
            ->orderBy('ScId', 'DESC')->paginate(10);
        return view('common.offer_letter', compact('company_list', 'months', 'candidate_list'));
    }

    public function get_offerltr_basic_detail(Request $request)
    {
        $JAId = $request->JAId;

        $candidate_detail = DB::table('screening')->select('offerletterbasic.*', 'screening.SelectedForC', 'screening.SelectedForD', 'master_department.DepartmentName', 'jobcandidates.FName', 'jobcandidates.MName', 'jobcandidates.LName', 'jobcandidates.FatherName')
            ->join('jobapply', 'jobapply.JAId', '=', 'screening.JAId')
            ->join('jobcandidates', 'jobcandidates.JCId', '=', 'jobapply.JCId')
            ->leftJoin('offerletterbasic', 'offerletterbasic.JAId', '=', 'jobapply.JAId')
            ->leftJoin('master_department', 'master_department.DepartmentId', '=', 'screening.SelectedForD')
            ->where('screening.JAId', $JAId)
            ->get();
        $company = $candidate_detail[0]->SelectedForC;
        $Department = $candidate_detail[0]->SelectedForD;
        if ($company == 1) {
            $grade_list = DB::table("master_grade")->where('GradeStatus', 'A')->where('CompanyId', $company)->where('GradeId', '>=', '61')->orderBy('GradeValue', 'ASC')->pluck("GradeId", "GradeValue");
        } else {
            $grade_list = DB::table("master_grade")->where('GradeStatus', 'A')->where('CompanyId', $company)->orderBy('GradeValue', 'desc')->orderBy('GradeValue', 'ASC')->pluck("GradeId", "GradeValue");
        }

        $designation_list = DB::table("master_designation")->where('DesigStatus', 'A')->where('CompanyId', $company)->where('DepartmentId', $Department)->orderBy('DesigName', 'ASC')->pluck("DesigId", "DesigName");
        $department_list = DB::table("master_department")->where('DeptStatus', 'A')->where('CompanyId', $company)->orderBy('DepartmentName', 'ASC')->pluck("DepartmentId", "DepartmentName");
        $employee_list = master_employee::select(DB::raw("CONCAT(Fname,' ',Lname) AS name"), 'EmployeeID')->where('CompanyId', $company)->pluck('name', 'EmployeeID');
        $headquarter_list = DB::table("master_headquater")->where('CompanyId', $company)->orderBy('HqName', 'ASC')->pluck("HqId", "HqName");
        $state_list = DB::table("master_state")->leftJoin('master_headquater', 'master_headquater.StateId', '=', 'master_state.StateId')->where('master_headquater.CompanyId', $company)->orderBy('StateName', 'ASC')->pluck("master_state.StateId", "master_state.StateName");
        return response(array('candidate_detail' => $candidate_detail[0], 'grade_list' => $grade_list, 'designation_list' => $designation_list, 'department_list' => $department_list, 'employee_list' => $employee_list, 'headquarter_list' => $headquarter_list, 'state_list' => $state_list, 'status' => 200));
    }

    public function update_offerletter_basic(Request $request)
    {
        $JAId = $request->JAId;
        $Grade = $request->Grade;
        $Designation = $request->Designation;
        $permanent_chk = $request->permanent_chk ?? 0;
        $PermState = $request->PermState;
        $PermHQ = $request->PermHQ;
        $PermCity = $request->PermCity;
        $temporary_chk = $request->temporary_chk ?? 0;
        $TempState = $request->TempState;
        $TempHQ = $request->TempHQ ?? null;
        $TempCity = $request->TempCity;
        $TemporaryMonth = $request->TemporaryMonth ?? null;
        $administrative_chk = $request->administrative_chk ?? 0;
        $AdministrativeDepartment = $request->AdministrativeDepartment;
        $AdministrativeEmployee = $request->AdministrativeEmployee;
        $functional_chk = $request->functional_chk ?? 0;
        $FunctionalDepartment = $request->FunctionalDepartment;
        $FunctionalEmployee = $request->FunctionalEmployee ?? null;
        $CTC = $request->CTC;
        $ServiceCond = $request->ServiceCond;
        $OrientationPeriod = $request->OrientationPeriod ?? null;
        $Stipend = $request->Stipend ?? null;
        $AftGrade = $request->AftGrade ?? 0;
        $AftDesignation = $request->AftDesignation ?? 0;
        $ServiceBond = $request->ServiceBond ?? null;
        $ServiceBondDuration = $request->ServiceBondDuration;
        $ServiceBondRefund = $request->ServiceBondRefund;
        $MedicalCheckup = $request->MedicalCheckup;
        $SignAuth = $request->SignAuth;
        $Remark = $request->Remark;

        $query = DB::table('offerletterbasic')
            ->where('JAId', $JAId)
            ->update(
                [
                    'Grade' => $Grade,
                    'Designation' => $Designation,
                    'TempS' => $temporary_chk,
                    'T_StateHq' => $TempState,
                    'T_LocationHq' => $TempHQ,
                    'T_City' => $TempCity,
                    'TempM' => $TemporaryMonth,
                    'FixedS' => $permanent_chk,
                    'F_StateHq' => $PermState,
                    'F_LocationHq' => $PermHQ,
                    'F_City' => $PermCity,
                    'Functional_R' => $functional_chk,
                    'Functional_Dpt' => $FunctionalDepartment,
                    'F_ReportingManager' => $FunctionalEmployee,
                    'Admins_R' => $administrative_chk,
                    'Admins_Dpt' => $AdministrativeDepartment,
                    'A_ReportingManager' => $AdministrativeEmployee,
                    'CTC' => $CTC,
                    'ServiceCondition' => $ServiceCond,
                    'OrientationPeriod' => $OrientationPeriod,
                    'Stipend' => $Stipend,
                    'AFT_Grade' => $AftGrade,
                    'AFT_Designation' => $AftDesignation,
                    'ServiceBond' => $ServiceBond,
                    'ServiceBondRefund' => $ServiceBondRefund,
                    'ServiceBondYears' => $ServiceBondDuration,
                    'PreMedicalCheckUp' => $MedicalCheckup,
                    'Remarks' => $Remark,
                    'SigningAuth' => $SignAuth,
                    'OfferLetter' => 1,
                    'LastUpdated' => now(),
                    'UpdatedBy' => Auth::user()->id
                ]
            );

        if (!$query) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {

            return response()->json(['status' => 200, 'msg' => 'Data has been changed successfully']);
        }
    }


    public function offer_letter_generate(Request $request)
    {

        return view('common.offer_ltr_gen');
    }
}
