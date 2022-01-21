<?php

namespace App\Http\Controllers\Common;

use App\Models\screening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Mail\JoiningFormMail;
use App\Mail\OfferLetterMail;
use App\Mail\ReviewMail;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\master_employee;
use App\Models\CandidateJoining;
use Illuminate\Support\Facades\Mail;

use function App\Helpers\getCompanyCode;
use function App\Helpers\getCompanyName;
use function App\Helpers\getDepartmentCode;
use function App\Helpers\getEmployeeEmailId;
use function App\Helpers\getGradeValue;

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

        if (Auth::user()->role == 'R') {

            $usersQuery->where('jobpost.CreatedBy', Auth::user()->id);
        }

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
            if ($Status == 'Pending') {
                $usersQuery->where('offerletterbasic.OfferLetterSent', 'Yes')->where("offerletterbasic.Answer", null);
            } else {
                $usersQuery->where("offerletterbasic.Answer", $Status);
            }
        }

        if ($Name != '') {
            $usersQuery->where("jobcandidates.FName", 'like', "%$Name%");
        }

        $candidate_list = $usersQuery->select('jobapply.JAId', 'jobcandidates.FName', 'jobcandidates.MName', 'jobcandidates.LName', 'jobcandidates.ReferenceNo', 'jobcandidates.CandidateImage', 'screening.SelectedForC', 'screening.SelectedForD', 'offerletterbasic.OfferLetterSent', 'offerletterbasic.JoiningFormSent', 'offerletterbasic.Answer', 'offerletterbasic.OfferLtrGen', 'offerletterbasic.OfferLetter', 'candjoining.EmpCode', 'candjoining.JoinOnDt', 'offerletterbasic.SendReview', 'jobpost.JobCode')
            ->Join('jobapply', 'screening.JAId', '=', 'jobapply.JAId')
            ->Join('jobpost', 'jobpost.JPId', '=', 'jobapply.JPId')
            ->Join('manpowerrequisition', 'manpowerrequisition.MRFId', '=', 'jobpost.MRFId')
            ->Join('jobcandidates', 'jobapply.JCId', '=', 'jobcandidates.JCId')
            ->leftJoin('offerletterbasic', 'jobapply.JAId', '=', 'offerletterbasic.JAId')
            ->leftJoin('candjoining', 'jobapply.JAId', '=', 'candjoining.JAId')
            ->where('manpowerrequisition.CountryId', session('Set_Country'))
            ->whereNotNull('screening.SelectedForC')
            ->whereNotNull('screening.SelectedForD')
            ->orderBy('ScId', 'DESC')->paginate(20);
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
        $JAId = $request->Of_JAId;
        $Grade = $request->Grade;
        $Designation = $request->Designation;
        $permanent_chk = $request->permanent_chk ?? 0;
        $PermState = $request->Of_PermState;
        $PermHQ = $request->PermHQ;
        $PermCity = $request->Of_PermCity;
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

        $query = DB::table('offerletterbasic')->where('JAId', $jaid)->update(
            [
                'CTC' => $total_ctc,
                'LastUpdated' => now(),
                'UpdatedBy' => Auth::user()->id
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
            $postfix_ltr = 'A';
        } elseif ($seq == 2) {
            $postfix_ltr = 'B';
        } elseif ($seq == 3) {
            $postfix_ltr = 'C';
        } elseif ($seq == 4) {
            $postfix_ltr = 'D';
        } elseif ($seq == 5) {
            $postfix_ltr = 'E';
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
        $query = DB::table('offerletterbasic_history')->select('offerletterbasic_history.*', DB::raw('DATE_FORMAT(offerletterbasic_history.LtrDate, "%d-%b-%Y") as OfDate'))->where('JAId', $JAId)->get();
        return response()->json(['status' => 200, 'data' => $query]);
    }

    public function offer_ltr_history(Request $request)
    {
        return view('offer_letter.offer_ltr_history');
    }

    public function getDetailForReview(Request $request)
    {
        $JAId = $request->JAId;
        $query = DB::table('jobapply')->join('jobcandidates', 'jobcandidates.JCId', '=', 'jobapply.JCId')->join('jobpost', 'jobpost.JPId', '=', 'jobapply.JPId')->select('jobcandidates.FName', 'jobcandidates.MName', 'jobcandidates.LName', 'jobpost.Title')->where('JAId', $JAId)->first();
        return response()->json(['status' => 200, 'data' => $query]);
    }

    public function saveJoinDate(Request $request)
    {
        $JAId = $request->JAId;
        $JoinDate = $request->JoinDate;
        $chk = DB::table('candjoining')->select('*')->where('JAId', $JAId)->count();
        if ($chk > 0) {
            $update_query = DB::table('candjoining')->where('JAId', $JAId)->update(
                [
                    'JoinOnDt' => $JoinDate,
                    'UpdatedBy' => Auth::user()->id,
                    'LastUpdated' => now()
                ]
            );  //update
        } else {
            $update_query = DB::table('candjoining')->insert(
                [
                    'JAId' => $JAId,
                    'JoinOnDt' => $JoinDate,
                    'CreatedBy' => Auth::user()->id,
                    'CreatedTime' => now()
                ]
            );  //insert
        }
        if ($update_query) {
            return response()->json(['status' => 200, 'msg' => 'Join Date Updated Successfully']);
        } else {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        }
    }

    public function candidate_offer_letter(Request $request)
    {
        return view('jobportal.offer_letter');
    }

    public function SendOfferLtr(Request $request)
    {
        $JAId = $request->JAId;
        $sendId = base64_encode($JAId);
        $query = DB::table('jobapply')->join('jobcandidates', 'jobcandidates.JCId', '=', 'jobapply.JCId')->join('jobpost', 'jobpost.JPId', '=', 'jobapply.JPId')->join('offerletterbasic', 'offerletterbasic.JAId', '=', 'jobapply.JAId')->select('jobcandidates.ReferenceNo', 'jobcandidates.FName', 'jobcandidates.MName', 'jobcandidates.LName', 'jobcandidates.Email', 'jobpost.Title', 'offerletterbasic.Company', 'offerletterbasic.Grade')->where('jobapply.JAId', $JAId)->first();
        $update = DB::table('offerletterbasic')->where('JAId', $JAId)->update(
            [
                'OfferLetterSent' => 'Yes',
                'UpdatedBy' => Auth::user()->id,
                'LastUpdated' => now()
            ]
        );

        $chk = DB::table('candjoining')->select('*')->where('JAId', $JAId)->count();
        if ($chk > 0) {
            $candJoin = DB::table('candjoining')->where('JAId', $JAId)->update(
                [
                    'LinkValidityStart' => now(),
                    'LinkValidityEnd' => now()->addDays(7),
                    'LinkStatus' => 'A',
                    'UpdatedBy' => Auth::user()->id,
                    'LastUpdated' => now()
                ]
            );  //update
        } else {
            $candJoin = DB::table('candjoining')->insert(
                [
                    'JAId' => $JAId,
                    'LinkValidityStart' => now(),
                    'LinkValidityEnd' => now()->addDays(7),
                    'LinkStatus' => 'A',
                    'CreatedBy' => Auth::user()->id,
                    'CreatedTime' => now()
                ]
            );  //insert
        }


        if ($update && $candJoin) {

            $details = [
                "candidate_name" => $query->FName . ' ' . $query->MName . ' ' . $query->LName,
                "reference_no" => $query->ReferenceNo,
                "job_title" => $query->Title,
                "company" => getCompanyName($query->Company),
                "grade" => getGradeValue($query->Grade),
                "subject" => "Job Offer Letter for the post of " . $query->Title,
                "offer_link" => route('candidate-offer-letter') . '?jaid=' . $sendId
            ];

            Mail::to($query->Email)->send(new OfferLetterMail($details));
            return response()->json(['status' => 200, 'msg' => 'Offer Letter Sent Successfully']);
        } else {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        }
    }

    public function OfferResponse(Request $request)
    {
        $Answer = $request->Answer;
        $JAId = $request->JAId;
        $JoinOnDt = $request->JoinOnDt ?? null;
        $Place = $request->Place ?? null;
        $Date = $request->Date ?? null;
        $RejReason = $request->RejReason ?? null;

        $query = DB::table('offerletterbasic')->where('JAId', $JAId)->update(
            [
                'Answer' => $Answer,
                'RejReason' => $RejReason,
                'LastUpdated' => now()
            ]
        );

        $query1 = DB::table('candjoining')->where('JAId', $JAId)->update(
            [
                'Answer' => $Answer,
                'JoinOnDt' => $JoinOnDt,
                'Place' => $Place,
                'Date' => $Date,
                'RejReason' => $RejReason,
                'LastUpdated' => now()
            ]
        );

        if ($Answer == 'Accepted') {
            $sendId = base64_encode($JAId);
            $row = DB::table('jobapply')->join('jobcandidates', 'jobcandidates.JCId', '=', 'jobapply.JCId')
                ->select('jobcandidates.ReferenceNo', 'jobcandidates.FName', 'jobcandidates.MName', 'jobcandidates.LName', 'jobcandidates.Email')
                ->where('jobapply.JAId', $JAId)->first();
            $details = [
                "candidate_name" => $row->FName . ' ' . $row->MName . ' ' . $row->LName,
                "reference_no" => $row->ReferenceNo,
                "subject" => "Complete your Onboarding Process",
                "link" => route('candidate-joining-form') . '?jaid=' . $sendId
            ];

            Mail::to($row->Email)->send(new JoiningFormMail($details));
            $update = DB::table('offerletterbasic')->where('JAId', $JAId)->update(
                [
                    'JoiningFormSent' => 'Yes',
                    'LastUpdated' => now()
                ]
            );
        }
        if ($query && $query1) {
            return response()->json(['status' => 200, 'msg' => 'Response Submitted Successfully']);
        } else {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        }
    }

    public function OfferLetterResponse(Request $request)
    {
        return view('jobportal.offer_response_msg');
    }

    public function offerReopen(Request $request)
    {
        $JAId = $request->JAId;
        $query = DB::table('offerletterbasic')->where('JAId', $JAId)->update(
            [
                'Answer' => null,
                'OfferLetterSent' => null,
                'LastUpdated' => now()
            ]
        );

        $query1 = DB::table('candjoining')->where('JAId', $JAId)->update(
            [
                'LinkValidityStart' => null,
                'LinkValidityEnd' => null,
                'LinkStatus' => 'D',
                'Answer' => '',
                'JoinOnDt' => null,
                'Place' => '',
                'Date' => null,
                'RejReason' => '',
                'LastUpdated' => now()
            ]
        );

        if ($query && $query1) {
            return response()->json(['status' => 200, 'msg' => 'Offer Letter Reopen Successfully']);
        } else {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        }
    }

    public function send_for_review(Request $request)
    {
        $JAId = $request->ReviewJaid;
        $Company = $request->ReviewCompany;
        $Employee = $request->review_to;

        $update_query = DB::table('offerletterbasic')->where('JAId', $JAId)->update(
            [
                'SendReview' => '1',
                'LastUpdated' => now()
            ]
        );

        $getData = DB::table('offerletterbasic')->where('JAId', $JAId)->first();
        $Final = array();
        for ($i = 0; $i < Count($Employee); $i++) {
            $data = array(
                'JAId' => $JAId,
                'EmpCompany' => $Company,
                'OfferLetterNo' => $getData->LtrNo,
                'EmpId' => $Employee[$i],
                'EmpMail' =>  getEmployeeEmailId($Employee[$i]),
                'CreatedTime' => date('Y-m-d')
            );

            array_push($Final, $data);
        }

        $query = DB::table('offerletter_review')->insert($Final);

        $getData = DB::table('jobapply')->join('jobcandidates', 'jobcandidates.JCId', '=', 'jobapply.JCId')->join('jobpost', 'jobpost.JPId', '=', 'jobapply.JPId')->select('jobcandidates.FName', 'jobcandidates.MName', 'jobcandidates.LName', 'jobpost.Title')->where('jobapply.JAId', $JAId)->first();
        if ($update_query && $query) {
            for ($j = 0; $j < count($Employee); $j++) {
                $Fullname = $getData->FName . ' ' . $getData->MName . ' ' . $getData->LName;
                $details = [
                    "candidate_name" => $Fullname,
                    "subject" => "For review - Offer Letter of " . $Fullname . " for the post of " . $getData->Title,
                    "offer_link" => route('offer-letter-review') . '?jaid=' . $JAId . '&E=' . $Employee[$j]
                ];

                Mail::to(getEmployeeEmailId($Employee[$j]))->send(new ReviewMail($details));
            }
            return response()->json(['status' => 200, 'msg' => 'Offer Letter Sent for Review Successfully']);
        } else {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        }
    }

    public function viewReview(Request $request)
    {
        $JAId = $request->JAId;
        $query = DB::table('offerletter_review')->join('master_employee', 'master_employee.EmployeeID', '=', 'offerletter_review.EmpId')->where('JAId', $JAId)->select('offerletter_review.*', DB::raw("CONCAT(master_employee.Fname,' ',master_employee.Lname) AS full_name"))->get();
        return response()->json(['status' => 200,  'data' => $query]);
    }

    public function offer_letter_review(Request $request)
    {
        return view('jobportal.review_offer_letter');
    }

    public function ReviewResponse(Request $request)
    {
        $JAId = $request->JAId;
        $EmpId = $request->EmpId;
        $Answer = $request->Answer;
        $RejReason = $request->RejReason ?? null;
        $query = DB::table('offerletter_review')->where('JAId', $JAId)->where('EmpId', $EmpId)->where('Status', null)->update(
            [
                'Status' => $Answer,
                'RejReason' => $RejReason,
            ]
        );
        if ($query) {
            return response()->json(['status' => 200, 'msg' => 'Response Submitted Successfully']);
        } else {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        }
    }

    public function saveEmpCode(Request $request)
    {
        $JAId = $request->JAId;
        $EmpCode = $request->EmpCode;

        $update_query = DB::table('candjoining')->where('JAId', $JAId)->update(
            [
                'EmpCode' => $EmpCode,
                'UpdatedBy' => Auth::user()->id,
                'LastUpdated' => now()
            ]
        );  //update

        if ($update_query) {
            return response()->json(['status' => 200, 'msg' => 'Employee Code Updated Successfully']);
        } else {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        }
    }

    public function candidate_joining(Request $request)
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

        $usersQuery = CandidateJoining::query();

        if (Auth::user()->role == 'R') {

            $usersQuery->where('jobpost.CreatedBy', Auth::user()->id);
        }

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


        if ($Status != '') {
            $usersQuery->where("candjoining.Joined", $Status);
        }

        if ($Name != '') {
            $usersQuery->where("jobcandidates.FName", 'like', "%$Name%");
        }

        $candidate_list = $usersQuery->select(
            'jobapply.JAId',
            'jobcandidates.FName',
            'jobcandidates.MName',
            'jobcandidates.LName',
            'jobcandidates.ReferenceNo',
            'jobcandidates.FinalSubmit',
            'screening.SelectedForC',
            'screening.SelectedForD',
            'candjoining.Verification',
            'candjoining.Joined',
            'candjoining.ForwardToESS'
        )
            ->Join('jobapply', 'candjoining.JAId', '=', 'jobapply.JAId')
            ->Join('jobpost', 'jobpost.JPId', '=', 'jobapply.JPId')
            ->Join('screening', 'screening.JAId', '=', 'jobapply.JAId')
            ->Join('offerletterbasic', 'offerletterbasic.JAId', '=', 'jobapply.JAId')
            ->Join('manpowerrequisition', 'manpowerrequisition.MRFId', '=', 'jobpost.MRFId')
            ->Join('jobcandidates', 'jobapply.JCId', '=', 'jobcandidates.JCId')
            ->where('manpowerrequisition.Status', 'Approved')
            ->where('manpowerrequisition.CountryId', session('Set_Country'))
            ->where('offerletterbasic.Answer', 'Accepted')
            ->paginate(20);
        return view('onboarding.candidate_joining', compact('company_list', 'months', 'candidate_list'));
    }
}
