<?php

namespace App\Http\Controllers\Common;

use App\Models\screening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\master_employee;
use App\Models\jobapply;

use function App\Helpers\getCompanyCode;
use function App\Helpers\getDepartmentCode;

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
        return view('offer_letter.offer_letter', compact('company_list', 'months', 'candidate_list'));
    }

    public function get_offerltr_basic_detail(Request $request)
    {
        $JAId = $request->JAId;

        $candidate_detail = DB::table('screening')->select('offerletterbasic.*', 'screening.SelectedForC', 'screening.SelectedForD', 'master_department.DepartmentName', 'jobcandidates.JCId', 'jobcandidates.FName', 'jobcandidates.MName', 'jobcandidates.LName', 'jobcandidates.FatherName')
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
        $employee_list = master_employee::select(DB::raw("CONCAT(Fname,' ',Lname) AS name"), 'EmployeeID')->where('CompanyId', $company)->where('EmpStatus', 'A')->pluck('name', 'EmployeeID');
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
                    'T_City' => $TempCity ?? null,
                    'TempM' => $TemporaryMonth,
                    'FixedS' => $permanent_chk,
                    'F_StateHq' => $PermState,
                    'F_LocationHq' => $PermHQ,
                    'F_City' => $PermCity ?? null,
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

        $sql = DB::table('candidate_ctc')->where('JAId', $JAId)->first();
        if ($sql === null) {
            $query = DB::table('candidate_ctc')->insert(
                [
                    'JAId' => $JAId,
                    'created_by' => Auth::user()->id,
                    'created_on' => now()
                ]
            );
        }

        $sql2 = DB::table('candidate_entitlement')->where('JAId', $JAId)->first();
        if ($sql2 === null) {
            $query = DB::table('candidate_entitlement')->insert(
                [
                    'JAId' => $JAId,
                    'Created_by' => Auth::user()->id,
                    'Created_on' => now()
                ]
            );
        }

        if (!$query) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {

            return response()->json(['status' => 200, 'msg' => 'Data has been changed successfully']);
        }
    }

    public function insert_ctc(Request $request)
    {
        $jaid = $request->jaid;
        $basic = $request->basic;
        $hra = $request->hra;
        $bonus = $request->bonus;
        $special_alw = $request->special_alw;
        $grsM_salary = $request->grsM_salary;
        $emplyPF = $request->emplyPF;
        $emplyESIC = $request->emplyESIC;
        $netMonth = $request->netMonth;
        $lta = $request->lta;
        $childedu = $request->childedu;
        $anualgrs = $request->anualgrs;
        $gratuity = $request->gratuity;
        $emplyerPF = $request->emplyerPF;
        $emplyerESIC = $request->emplyerESIC;
        $medical = $request->medical;
        $total_ctc = $request->total_ctc;
        $query1 = DB::table('candidate_ctc')->where('JAId', $jaid)->update(
            [
                'ctc_date' => now(),
                'basic' => $basic,
                'hra' => $hra,
                'bonus' => $bonus,
                'special_alw' => $special_alw,
                'grsM_salary' => $grsM_salary,
                'emplyPF' => $emplyPF,
                'emplyESIC' => $emplyESIC,
                'netMonth' => $netMonth,
                'lta' => $lta,
                'childedu' => $childedu,
                'anualgrs' => $anualgrs,
                'gratuity' => $gratuity,
                'emplyerPF' => $emplyerPF,
                'emplyerESIC' => $emplyerESIC,
                'medical' => $medical,
                'total_ctc' => $total_ctc,
                'created_on' => now(),
                'created_by' => Auth::user()->id
            ]
        );

        if ($query1) {
            return response()->json(['status' => 200, 'msg' => 'CTC Data has been changed successfully']);
        } else {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        }
    }

    public function insert_ent(Request $request)
    {
        $jaid = $request->jaid;
        $LoadCityA =     $request->LoadCityA;
        $LoadCityB = $request->LoadCityB;
        $LoadCityC = $request->LoadCityC;
        $DAOut = $request->DAOut;
        $DAHq = $request->DAHq;
        $TwoWheel = $request->TwoWheel;
        $FourWheel = $request->FourWheel;
        $TravelMode = $request->TravelMode;
        $TravelClass = $request->TravelClass;
        $Mobile = $request->Mobile;
        $MExpense = $request->MExpense;
        $MTerm = $request->MTerm;
        $Laptop = $request->Laptop;
        $HealthIns = $request->HealthIns;
        $tline = $request->tline;
        $two_wheel_line = $request->two_wheel_line;
        $four_wheel_line = $request->four_wheel_line;
        $GPRS = $request->GPRS;
        $flight = $request->flight;
        $query1 = DB::table('candidate_entitlement')->where('JAId', $jaid)->update(
            [
                'EntDate' => now(),
                'LoadCityA' => $LoadCityA,
                'LoadCityB' => $LoadCityB,
                'LoadCityC' => $LoadCityC,
                'DAOut' => $DAOut,
                'DAHq' => $DAHq,
                'TwoWheel' => $TwoWheel,
                'FourWheel' => $FourWheel,
                'TravelMode' => $TravelMode,
                'TravelClass' => $TravelClass,
                'Mobile' => $Mobile,
                'MExpense' => $MExpense,
                'MTerm' => $MTerm,
                'GPRS' => $GPRS,
                'Laptop' => $Laptop,
                'HealthIns' => $HealthIns,
                'TravelLine' => $tline,
                'TwoWheelLine' => $two_wheel_line,
                'FourWheelLine' => $four_wheel_line,
                'Flight' => $flight,
                'created_on' => now(),
                'created_by' => Auth::user()->id
            ]
        );

        if ($query1) {
            return response()->json(['status' => 200, 'msg' => 'Entitlement Data has been changed successfully']);
        } else {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        }
    }

    public function offer_letter_generate(Request $request)
    {

        return view('offer_letter.offer_ltr_gen');
    }

    public function offer_ltr_gen(Request $request)
    {
        $JAId = $request->jaid;
        $RemarkHr = $request->RemarkHr ?? '';
        $jobapply = DB::table('jobapply')->where('JAId', $JAId)->first();
        $JCId = $jobapply->JCId;
        $sql = DB::table('screening')->where('JAId', $JAId)->first();
        $SelectedForC = $sql->SelectedForC;
        $SelectedForD = $sql->SelectedForD;
        $chk = DB::table('offerletterbasic_history')->select('Seq')->where('JAId', $JAId)->latest('CreatedTime')->first();
        if (is_null($chk)) {
            $seq = '0';
        } else {
            $seq = $chk->Seq;
        }
        if ($seq == 0) {
            $postfix_ltr = '';
        } elseif ($seq == 1) {
            $postfix_ltr = '-A';
        } elseif ($seq == 2) {
            $postfix_ltr = '-B';
        } elseif ($seq == 3) {
            $postfix_ltr = '-C';
        } elseif ($seq == 4) {
            $postfix_ltr = '-D';
        } elseif ($seq == 5) {
            $postfix_ltr = '-E';
        }

        $Month = date('M');
        $Year = date('Y');
        $LtrNo = getCompanyCode($SelectedForC) . '_OL/' . getDepartmentCode($SelectedForD) . '/' . $Month . '-' . $Year . '/' . $JCId . $postfix_ltr;
        $LtrDate = now();
        $update_query = DB::table('offerletterbasic')->where('JAId', $JAId)->update(
            [
                'LtrNo' => $LtrNo,
                'LtrDate' => $LtrDate,
                'OfferLtrGen' => 1,
                'LastUpdated' => Auth::user()->id,
                'UpdatedBy' => now()
            ]
        );

        $ofltr  = DB::table('offerletterbasic')->where('JAId', $JAId)->first();
        $ctc = DB::table('candidate_ctc')->where('JAId', $JAId)->first();
        $ent = DB::table('candidate_entitlement')->where('JAId', $JAId)->first();
        if ($chk == null) {
            $max_seq = 1;
        } else {
            $max_seq = $chk->Seq + 1;
        }

        $query1 = DB::table('offerletterbasic_history')->insert(
            [
                'Seq' => $max_seq,
                'JAId' => $JAId,
                'RevisionRemark' => $RemarkHr,
                'Company' => $ofltr->Company,
                'Grade' => $ofltr->Grade,
                'Department' => $ofltr->Department,
                'Designation' => $ofltr->Designation,
                'LtrNo' => $ofltr->LtrNo,
                'LtrDate' => $ofltr->LtrDate,
                'TempS' => $ofltr->TempS,
                'T_StateHq' => $ofltr->T_StateHq,
                'T_LocationHq' => $ofltr->T_LocationHq,
                'T_City' => $ofltr->T_City,
                'TempM' => $ofltr->TempM,
                'FixedS' => $ofltr->FixedS,
                'F_StateHq' => $ofltr->F_StateHq,
                'F_LocationHq' => $ofltr->F_LocationHq,
                'F_City' => $ofltr->F_City,
                'Functional_R' => $ofltr->Functional_R,
                'Functional_Dpt' => $ofltr->Functional_Dpt,
                'F_ReportingManager' => $ofltr->F_ReportingManager,
                'Admins_R' => $ofltr->Admins_R,
                'Admins_Dpt' => $ofltr->Admins_Dpt,
                'A_ReportingManager' => $ofltr->A_ReportingManager,
                'CTC' => $ofltr->CTC,
                'ServiceCondition' => $ofltr->ServiceCondition,
                'OrientationPeriod' => $ofltr->OrientationPeriod,
                'Stipend' => $ofltr->Stipend,
                'AFT_Grade' => $ofltr->AFT_Grade,
                'AFT_Designation' => $ofltr->AFT_Designation,
                'ServiceBond' => $ofltr->ServiceBond,
                'ServiceBondRefund' => $ofltr->ServiceBondRefund,
                'ServiceBondYears' => $ofltr->ServiceBondYears,
                'PreMedicalCheckUp' => $ofltr->PreMedicalCheckUp,
                'Remarks' => $ofltr->Remarks,
                'SigningAuth' => $ofltr->SigningAuth,

                'basic' => $ctc->basic,
                'hra' => $ctc->hra,
                'bonus' => $ctc->bonus,
                'special_alw' => $ctc->special_alw,
                'grsM_salary' => $ctc->grsM_salary,
                'emplyPF' => $ctc->emplyPF,
                'emplyESIC' => $ctc->emplyESIC,
                'netMonth' => $ctc->netMonth,
                'lta' => $ctc->lta,
                'childedu' => $ctc->childedu,
                'anualgrs' => $ctc->anualgrs,
                'gratuity' => $ctc->gratuity,
                'emplyerPF' => $ctc->emplyerPF,
                'emplyerESIC' => $ctc->emplyerESIC,
                'medical' => $ctc->medical,
                'total_ctc' => $ctc->total_ctc,

                'LoadCityA' => $ent->LoadCityA,
                'LoadCityB' => $ent->LoadCityB,
                'LoadCityC' => $ent->LoadCityC,
                'DAOut' => $ent->DAOut,
                'DAHq' => $ent->DAHq,
                'TwoWheel' => $ent->TwoWheel,
                'FourWheel' => $ent->FourWheel,
                'TravelMode' => $ent->TravelMode,
                'TravelClass' => $ent->TravelClass,
                'Mobile' => $ent->Mobile,
                'MExpense' => $ent->MExpense,
                'MTerm' => $ent->MTerm,
                'GPRS' => $ent->GPRS,
                'Laptop' => $ent->Laptop,
                'HealthIns' => $ent->HealthIns,
                'TravelLine' => $ent->TravelLine,
                'TwoWheelLine' => $ent->TwoWheelLine,
                'FourWheelLine' => $ent->FourWheelLine,
                'Flight' => $ent->Flight,
                'CreatedTime' => now(),
                'CreatedBy' => Auth::user()->id
            ]
        );

        if ($update_query) {
            return response()->json(['status' => 200, 'msg' => 'Offer Letter Generated Successfully']);
        } else {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        }
    }

    public function offer_ltr_print(Request $request)
    {
        return view('offer_letter.offer_ltr_print');
    }

    function offerLtrHistory(Request $request)
    {
        $JAId = $request->jaid;
        $query = DB::table('offerletterbasic_history')->select('offerletterbasic_history.*',DB::raw('DATE_FORMAT(offerletterbasic_history.LtrDate, "%d-%b-%Y") as OfDate'))->where('JAId', $JAId)->get();
        return response()->json(['status' => 200, 'data' => $query]);
    }
    public function offer_ltr_history(Request $request)
    {
        return view('offer_letter.offer_ltr_history');
    }
}