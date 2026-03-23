<?php

namespace App\Http\Controllers;

use App\Models\jobapply;
use App\Models\OfferLetter;
use Illuminate\Http\Request;
use App\Models\CandidateJoining;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProcessToEss extends Controller
{


    public function processDataToEss(Request $request)
    {
        DB::beginTransaction();

        $connection = DB::connection(name: 'mysql2');
        $JAId = $request->JAId;
        $JCId = jobapply::where('JAId', $JAId)->first()->JCId;
        $EmpCode = CandidateJoining::where('JAId', $JAId)->value('EmpCode');
        $CompanyId = OfferLetter::where('JAId', $JAId)->value('Company');
        $offer_basic = OfferLetter::where('JAId', $JAId)->first();
        // check if the data is already processed to ESS
        $check = $connection->table('employee_general')->where('EmpCode', $EmpCode)->where('CompanyId', $CompanyId)->first();

        if ($check) {
            DB::rollBack();
            return response()->json(['status' => 400, 'msg' => 'EmpCode already existed and processed to ESS']);
        } else {

            $ctc_query = DB::table('candidate_ctc')->where('JAId', $JAId)->first();
            $education_query = DB::table('candidateeducation')->where('JCId', $JCId)->get();
            $family_query = DB::table('jf_family_det')->where('JCId', $JCId)->get();
            $lang_query = DB::table('jf_language')->where('JCId', $JCId)->get();
            $address_query = DB::table('jf_contact_det')->where('JCId', $JCId)->first();
            $elg_query = DB::table('candidate_entitlement')->where('JAId', $JAId)->first();
            $pf_esic_query = DB::table('jf_pf_esic')->where('JCId', $JCId)->first();
            $jobcandidate = DB::table('jobcandidates')->select('jobcandidates.*', 'jobcandidates.Designation as PresentDesignation', 'offerletterbasic.*', 'candjoining.JoinOnDt', 'candjoining.PositionCode', 'candjoining.PosSeq', 'candjoining.PosVR', 'about_answer.DLNo', 'about_answer.LValidity')->join('jobapply', 'jobapply.JCId', '=', 'jobcandidates.JCId')->join('offerletterbasic', 'offerletterbasic.JAId', '=', 'jobapply.JAId')->leftjoin('candjoining', 'candjoining.JAId', '=', 'jobapply.JAId')->leftjoin('about_answer', 'about_answer.JCId', 'jobcandidates.JCId')->where('jobcandidates.JCId', $JCId)->first();

            $workexp_query = DB::table('jf_work_exp')->where('JCId', $JCId)->get();
            $training_query = DB::table('jf_tranprac')->select('*')->where('JCId', $JCId)->get();
            $pre_ref = DB::table('jf_reference')->where('JCId', $JCId)->where('from', 'Previous Organization')->get();
            $vnr_ref = DB::table('jf_reference')->where('JCId', $JCId)->where('from', 'VNR')->get();


            $connection->table('employee_ctc')->insert([
                'EmpCode' => $EmpCode,
                'CompanyId' => $CompanyId,
                'basic' => $ctc_query->basic,
                'hra' => $ctc_query->hra,
                'bonus' => $ctc_query->bonus,
                'special_alw' => $ctc_query->special_alw,
                'grsM_salary' => $ctc_query->grsM_salary,
                'emplyPF' => $ctc_query->emplyPF,
                'emplyESIC' => $ctc_query->emplyESIC,
                'netMonth' => $ctc_query->netMonth,
                'lta' => $ctc_query->lta,
                'childedu' => $ctc_query->childedu,
                'anualgrs' => $ctc_query->anualgrs,
                'gratuity' => $ctc_query->gratuity,
                'emplyerPF' => $ctc_query->emplyerPF,
                'emplyerESIC' => $ctc_query->emplyerESIC,
                'medical' => $ctc_query->medical,
                'total_ctc' => $ctc_query->total_ctc,
                'communication_allowance' => $ctc_query->communication_allowance_amount,
                'total_gross_ctc' => $ctc_query->total_gross_ctc
            ]);

            $edu_array = [];
            foreach ($education_query as $key => $value) {
                // Only add if YearOfPassing is not null or empty
                if (!empty($value->YearOfPassing)) {
                    $temp = array();
                    $temp['EmpCode'] = $EmpCode;
                    $temp['CompanyId'] = $CompanyId;
                    $temp['Qualification'] = $value->Qualification;
                    $temp['Course'] = $value->Course == null ? '' : getEducationCodeById($value->Course);
                    $temp['Specialization'] = $value->Specialization == null ? '' : getSpecializationbyId($value->Specialization);
                    $temp['Institute'] = $value->Institute == null ? '' : ($value->Institute == 637 ? $value->OtherInstitute : getCollegeById($value->Institute));
                    $temp['YearOfPassing'] = $value->YearOfPassing;
                    $temp['CGPA'] = $value->CGPA ?? '';
                    $edu_array[] = $temp;
                }
            }

            $connection->table('employee_education')->insert($edu_array);

            $connection->table('employee_address')->insert(['EmpCode' => $EmpCode, 'CompanyId' => $CompanyId, 'pre_address' => $address_query->pre_address, 'pre_state' => getStateName($address_query->pre_state), 'pre_dist' => getDistrictName($address_query->pre_dist), 'pre_city' => $address_query->pre_city, 'pre_pin' => $address_query->pre_pin, 'perm_address' => $address_query->perm_address, 'perm_state' => getStateName($address_query->perm_state), 'perm_dist' => getDistrictName($address_query->perm_dist), 'perm_city' => $address_query->perm_city, 'perm_pin' => $address_query->perm_pin,]);


            $connection->table('employee_elg')->insert([
                'EmpCode' => $EmpCode,
                'CompanyId' => $CompanyId,
                'LoadCityA' => $elg_query->LoadCityA ?? '',
                'LoadCityB' => $elg_query->LoadCityB ?? '',
                'LoadCityC' => $elg_query->LoadCityC ?? '',
                'DAOut' => $elg_query->DAOut ?? '',
                'DAHq' => $elg_query->DAHq ?? '',
                'TwoWheel' => $elg_query->TwoWheel ?? '',
                'FourWheel' => $elg_query->FourWheel ?? '',
                'Train' => $elg_query->Train ?? '',
                'Train_Class' => $elg_query->Train_Class ?? '',
                'Flight' => $elg_query->Flight ?? '',
                'Flight_Class' => $elg_query->Flight_Class ?? '',
                'Flight_Remark' => $elg_query->Flight_Remark ?? '',
                'Mobile' => $elg_query->Mobile  ?? '',
                'MExpense' => $elg_query->MExpense ?? '',
                'MTerm' => $elg_query->MTerm ?? '',
                'GPRS' => $elg_query->GPRS ?? '',
                'Laptop' => $elg_query->Laptop ?? '',
                'HealthIns' => $elg_query->HealthIns ?? '',
                'Helth_CheckUp' => $elg_query->Helth_CheckUp ?? '',
                'Term_Insurance' => 500000,
            ]);


            $family_array = [];
            foreach ($family_query as $key => $value) {
                $temp = array();
                $temp['EmpCode'] = $EmpCode;
                $temp['CompanyId'] = $CompanyId;
                $temp['Relation'] = $value->relation;
                $temp['Name'] = $value->name;
                $temp['Dob'] = $value->dob ?? '';
                $temp['Qualification'] = $value->qualification ?? '';
                $temp['Occupation'] = $value->occupation ?? '';
                $family_array[] = $temp;
            }
            $connection->table('employee_family')->insert($family_array);

            $language_array = [];
            foreach ($lang_query as $key => $value) {
                $temp = array();
                $temp['EmpCode'] = $EmpCode;
                $temp['CompanyId'] = $CompanyId;
                $temp['language'] = $value->language;
                $temp['read'] = $value->read;
                $temp['write'] = $value->write;
                $temp['speak'] = $value->speak;
                $language_array[] = $temp;
            }

            $connection->table('employee_language')->insert($language_array);


            $connection->table('employee_pf')->insert(['EmpCode' => $EmpCode, 'CompanyId' => $CompanyId, 'UAN' => $pf_esic_query->UAN ?? '', 'pf_acc_no' => $pf_esic_query->PFNumber ?? '', 'esic_no' => $pf_esic_query->ESICNumber ?? '', 'bank_name' => $pf_esic_query->BankName ?? '', 'branch_name' => $pf_esic_query->BranchName ?? '', 'acc_number' => $pf_esic_query->AccountNumber ?? '', 'ifsc_code' => $pf_esic_query->IFSCCode ?? '', 'pan' => $pf_esic_query->PAN ?? '', 'passport' => $pf_esic_query->Passport ?? '',]);

            if ($jobcandidate->Professional == 'P') {
                $work_array = [];
                $work_array[0]['EmpCode'] = $EmpCode;
                $work_array[0]['CompanyId'] = $CompanyId;
                $work_array[0]['company'] = $jobcandidate->PresentCompany;
                $work_array[0]['desgination'] = $jobcandidate->PresentDesignation;
                $work_array[0]['job_start'] = $jobcandidate->JobStartDate;
                $work_array[0]['job_end'] = $jobcandidate->JobEndDate;
                $work_array[0]['gross_mon_sal'] = $jobcandidate->GrossSalary;
                $work_array[0]['annual_ctc'] = $jobcandidate->CTC;

                foreach ($workexp_query as $key => $value) {
                    $temp = array();
                    $temp['EmpCode'] = $EmpCode;
                    $temp['CompanyId'] = $CompanyId;
                    $temp['company'] = $value->company;
                    $temp['desgination'] = $value->desgination;
                    $temp['job_start'] = $value->job_start;
                    $temp['job_end'] = $value->job_end;
                    $temp['gross_mon_sal'] = $value->gross_mon_sal;
                    $temp['annual_ctc'] = $value->annual_ctc;
                    $work_array[] = $temp;
                }

                $connection->table('employee_workexp')->insert($work_array);

                $pre_ref_array = [];
                foreach ($pre_ref as $key => $value) {
                    $temp = array();
                    $temp['EmpCode'] = $EmpCode;
                    $temp['CompanyId'] = $CompanyId;
                    $temp['name'] = $value->name;
                    $temp['designation'] = $value->designation;
                    $temp['company'] = $value->company;
                    $temp['contact'] = $value->contact;
                    $temp['email'] = $value->email;
                    $pre_ref_array[] = $temp;
                }
                $connection->table('employee_preref')->insert($pre_ref_array);
            }

            if ($training_query->count() > 0) {
                if ($training_query[0]->training != null || $training_query[0]->training != '') {
                    $training_array = [];
                    foreach ($training_query as $key => $value) {
                        $temp = array();
                        $temp['EmpCode'] = $EmpCode;
                        $temp['CompanyId'] = $CompanyId;
                        $temp['training'] = $value->training;
                        $temp['organization'] = $value->organization;
                        $temp['from'] = $value->from;
                        $temp['to'] = $value->to;
                        $training_array[] = $temp;
                    }

                   $connection->table('employee_training')->insert($training_array);
                }
            }

            if ($vnr_ref->count() > 0) {
                if ($vnr_ref[0]->name != null || $vnr_ref[0]->name != '') {
                    $vnr_array = [];
                    foreach ($vnr_ref as $key => $value) {
                        $temp = array();
                        $temp['EmpCode'] = $EmpCode;
                        $temp['CompanyId'] = $CompanyId;
                        $temp['name'] = $value->name;
                        $temp['designation'] = $value->designation;
                        $temp['company'] = $value->company == 'Other' ? $value->other_company : $value->company;
                        $temp['contact'] = $value->contact;
                        $temp['email'] = $value->email;
                        $temp['rel_with_person'] = $value->rel_with_person;
                        $vnr_array[] = $temp;
                    }
                   $connection->table('employee_vnrref')->insert($vnr_array);
                }
            }

           

            $ConfirmationDate = '';
            $JoinOnDt = $jobcandidate->JoinOnDt;
            if ($jobcandidate->ServiceCondition == 'Probation') {
                //add 6months to join date
                $ConfirmationDate = date('Y-m-d', strtotime($JoinOnDt . ' + 6 months'));
            } elseif ($jobcandidate->ServiceCondition == 'Training') {
                //Add 12 months to join date
                $ConfirmationDate = date('Y-m-d', strtotime($JoinOnDt . ' + 12 months'));
            } elseif ($jobcandidate->ServiceCondition == 'nopnot') {
                $ConfirmationDate = $jobcandidate->JoinOnDt;
            }
            $connection->table('employee_general')->insert([
                'EmpCode' => $EmpCode,
                'CandidateId' => $JCId,
                'DataMove' => 'N',
                'EmpPass' => '',
                'EmpType' => 'E',
                'EmpStatus' => 'A',
                'NameTitle' => $jobcandidate->Title,
                'FName' => $jobcandidate->FName,
                'MName' => $jobcandidate->MName,
                'LName' => $jobcandidate->LName,
                'DOB' => $jobcandidate->DOB,
                'Gender' => $jobcandidate->Gender,
                'Aadhar' => $jobcandidate->Aadhaar,
                'Email1' => $jobcandidate->Email,
                'Email2' => $jobcandidate->Email2 ?? '',
                'Contact1' => $jobcandidate->Phone,
                'Contact2' => $jobcandidate->Phone2 ?? '',
                'Religion' => $jobcandidate->Religion == 'Others' ? $jobcandidate->OtherReligion : $jobcandidate->Religion,
                'Caste' => $jobcandidate->Caste == 'Other' ? $jobcandidate->OtherCaste : $jobcandidate->Caste,
                'MaritalStatus' => $jobcandidate->MaritalStatus,
                'marriage_dt' => $jobcandidate->MarriageDate ?? '',
                'DrivingLicense' => $jobcandidate->DLNo ?? '',
                'LValidity' => $jobcandidate->LValidity ?? '',
                'BloodGroup' => $jobcandidate->bloodgroup,
                'Skill' => $offer_basic->MW,
                'Function'=>$offer_basic->Function,
                'BU' => $offer_basic->BU,
                'Zone' => $offer_basic->Zone,
                'Region' => $offer_basic->Region,
                'Territory' => $offer_basic->Territory,
                'EmgContName_One' => $address_query->cont_one_name,
                'EmgContRelation_One' => $address_query->cont_one_relation,
                'EmgContPhone_One' => $address_query->cont_one_number,
                'EmgContName_Two' => $address_query->cont_two_name ?? '',
                'EmgContRelation_Two' => $address_query->cont_two_relation ?? '',
                'EmgContPhone_Two' => $address_query->cont_two_number ?? '',
                'CompanyId' => $CompanyId,
                'Grade' => $jobcandidate->Grade,
                'DepartmentId' => $jobcandidate->Department,
                'DesigId' => $jobcandidate->Designation,
                'SubDepartment' => $jobcandidate->SubDepartment ?? '',
                'Section' => $jobcandidate->Section ?? '',
              //  'DesigSuffix' => $jobcandidate->DesigSuffix ?? '',
                //'PositionCode' => $jobcandidate->PositionCode ?? '',
                'PosSeq' => $jobcandidate->PosSeq ?? '',
                'PosVR' => $jobcandidate->PosVR ?? '',
                'Vertical' => $jobcandidate->VerticalId ?? '',

                'T_StateHq' => $jobcandidate->T_StateHq ?? '',
                'T_LocationHq' => $jobcandidate->T_LocationHq ?? '',
                'F_StateHq' => $jobcandidate->F_StateHq ?? '',
                'F_LocationHq' => $jobcandidate->F_LocationHq ?? '',

                'F_ReportingManager' => $jobcandidate->F_ReportingManager ?? '',
                'A_ReportingManager' => $jobcandidate->A_ReportingManager ?? '',
                'ServiceCondition' => $jobcandidate->ServiceCondition ?? '',
                'OrientationPeriod' => $jobcandidate->OrientationPeriod ?? '',
                'Stipend' => $jobcandidate->Stipend ?? '',
                'AFT_Grade' => $jobcandidate->AFT_Grade ?? '',
                'AFT_Designation' => $jobcandidate->AFT_Designation ?? '',
                'ServiceBond' => $jobcandidate->ServiceBond ?? '',
                'ServiceBondYears' => $jobcandidate->ServiceBondYears ?? '',
                'ServiceBondRefund' => $jobcandidate->ServiceBondRefund ?? '',
                'JoinOnDt' => $jobcandidate->JoinOnDt ?? '',
                'ConfirmationDate' => $ConfirmationDate ?? '',
                'NoticePeriod' => $jobcandidate->NoticePeriod ?? '',
                'ProbationNoticePeriod' => $jobcandidate->ProbationNoticePeriod ?? '',
                'PositionId' => '',
                'CreatedBy' => Auth::user()->id,
                'CreatedDate' => now(),
                'YearId' => '0',



            ]);
            DB::commit();
            DB::table('candjoining')->where('JAId', $JAId)->update(['ForwardToESS' => 'Yes']);
            return response()->json(array('status' => 200, 'message' => 'Employee Created Successfully'));
        }
    }

    public function previewDataToEss($JAId)
    {

        try {
            $JCId = jobapply::where('JAId', $JAId)->first()->JCId;
            $EmpCode = CandidateJoining::where('JAId', $JAId)->value('EmpCode');
            $CompanyId = OfferLetter::where('JAId', $JAId)->value('Company');
            $offer_basic = OfferLetter::where('JAId', $JAId)->first();

            // Fetch all the data that will be transferred
            $ctc_data = DB::table('candidate_ctc')->where('JAId', $JAId)->first();
            $education_data = DB::table('candidateeducation')
                ->leftJoin('master_education', 'candidateeducation.Course', '=', 'master_education.EducationId')
                ->leftJoin('master_specialization', 'candidateeducation.Specialization', '=', 'master_specialization.SpId')
                ->leftJoin('master_institute', 'candidateeducation.Institute', '=', 'master_institute.InstituteId')
                ->select('candidateeducation.*',
                    'master_education.EducationName as course_name',
                    'master_specialization.Specialization as specialization_name',
                    'master_institute.InstituteName as institute_name')
                ->where('candidateeducation.JCId', $JCId)
                ->get();
            $family_data = DB::table('jf_family_det')->where('JCId', $JCId)->get();
            $lang_data = DB::table('jf_language')->where('JCId', $JCId)->get();
            $address_data = DB::table('jf_contact_det')->where('JCId', $JCId)->first();
            $elg_data = DB::table('candidate_entitlement')->where('JAId', $JAId)->first();
            $pf_esic_data = DB::table('jf_pf_esic')->where('JCId', $JCId)->first();
            $jobcandidate = DB::table('jobcandidates')
                ->select('jobcandidates.*', 'jobcandidates.Designation as PresentDesignation', 'offerletterbasic.*',
                    'department_name', 'sub_department_name', 'vertical_name', 'grade_name', 'designation_name',
                    'candjoining.JoinOnDt', 'candjoining.PositionCode', 'candjoining.PosSeq', 'candjoining.PosVR', 'about_answer.DLNo', 'about_answer.LValidity')
                ->join('jobapply', 'jobapply.JCId', '=', 'jobcandidates.JCId')
                ->join('offerletterbasic', 'offerletterbasic.JAId', '=', 'jobapply.JAId')
                ->leftJoin('core_department', 'core_department.id', '=', 'offerletterbasic.Department')
                ->leftJoin('core_sub_department', 'core_sub_department.id', '=', 'offerletterbasic.SubDepartment')
                ->leftJoin('core_vertical', 'core_vertical.id', '=', 'offerletterbasic.VerticalId')
                ->leftJoin('core_grade', 'core_grade.id', '=', 'offerletterbasic.Grade')
                ->leftJoin('core_designation', 'core_designation.id', '=', 'offerletterbasic.Designation')
                ->leftjoin('candjoining', 'candjoining.JAId', '=', 'jobapply.JAId')
                ->leftjoin('about_answer', 'about_answer.JCId', 'jobcandidates.JCId')
                ->where('jobcandidates.JCId', $JCId)
                ->first();

            $workexp_data = DB::table('jf_work_exp')->where('JCId', $JCId)->get();
            $training_data = DB::table('jf_tranprac')->select('*')->where('JCId', $JCId)->get();
            $pre_ref_data = DB::table('jf_reference')->where('JCId', $JCId)->where('from', 'Previous Organization')->get();
            $vnr_ref_data = DB::table('jf_reference')->where('JCId', $JCId)->where('from', 'VNR')->get();
         

            return view('common.preview_ess_data', compact(
                'JAId',
                'EmpCode',
                'CompanyId',
                'ctc_data',
                'education_data',
                'family_data',
                'lang_data',
                'address_data',
                'elg_data',
                'pf_esic_data',
                'jobcandidate',
                'workexp_data',
                'training_data',
                'pre_ref_data',
                'vnr_ref_data',
          
                'offer_basic'
            ));
        } catch (\Exception $e) {
            Log::info($e->getMessage());

            return back()->with('error', 'Error loading preview: '.$e->getMessage());
        }
    }

    public function transferToHrims(Request $request)
    {
        try {
            DB::beginTransaction();

            // STEP 1: Store in recruitment_to_ess using existing method
            $essResult = $this->processDataToEss($request);
            $essData = json_decode($essResult->getContent(), true);

            if ($essData['status'] != 200) {
                DB::rollBack();

                return $essResult; // Return the error from processDataToEss
            }

            // STEP 2: Now transfer from recruitment_to_ess to HRIMS
            $JAId = $request->JAId;
            $JCId = jobapply::where('JAId', $JAId)->first()->JCId;
            $EmpCode = CandidateJoining::where('JAId', $JAId)->value('EmpCode');
            $CompanyId = OfferLetter::where('JAId', $JAId)->value('Company');
            $UserId = Auth::user()->id;

            $essConnection = DB::connection('mysql2');
            $hrimsConnection = DB::connection('mysql3');

            // Check if employee already exists in HRIMS
            $existingEmp = $hrimsConnection->table('hrm_employee')
                ->where('EmpCode', $EmpCode)
                ->where('EmpStatus', '!=', 'De')
                ->where('CompanyId', $CompanyId)
                ->first();

            if ($existingEmp) {
                DB::rollBack();

                return response()->json(['status' => 400, 'msg' => 'Employee already exists in HRIMS']);
            }

            // Fetch data from recruitment_to_ess
            $empGeneral = $essConnection->table('employee_general')
                ->where('EmpCode', $EmpCode)
                ->where('CompanyId', $CompanyId)
                ->first();

            $empPf = $essConnection->table('employee_pf')->where('EmpCode', $EmpCode)->where('CompanyId', $CompanyId)->first();
            $empAddress = $essConnection->table('employee_address')->where('EmpCode', $EmpCode)->where('CompanyId', $CompanyId)->first();
            $empCtc = $essConnection->table('employee_ctc')->where('EmpCode', $EmpCode)->where('CompanyId', $CompanyId)->first();
            $empElg = $essConnection->table('employee_elg')->where('EmpCode', $EmpCode)->where('CompanyId', $CompanyId)->first();
            $empPreRef = $essConnection->table('employee_preref')->where('EmpCode', $EmpCode)->where('CompanyId', $CompanyId)->first();
            $empVnrRef = $essConnection->table('employee_vnrref')->where('EmpCode', $EmpCode)->where('CompanyId', $CompanyId)->first();
            $empLanguages = $essConnection->table('employee_language')->where('EmpCode', $EmpCode)->where('CompanyId', $CompanyId)->get();
            $empEducation = $essConnection->table('employee_education')->where('EmpCode', $EmpCode)->where('CompanyId', $CompanyId)->get();
            $empWorkExp = $essConnection->table('employee_workexp')->where('EmpCode', $EmpCode)->where('CompanyId', $CompanyId)->get();
            $empFamily = $essConnection->table('employee_family')->where('EmpCode', $EmpCode)->where('CompanyId', $CompanyId)->get();
            

            // Get reporting manager details from HRIMS
            $reportingManager = null;
            $reportingName = '';
            if (! empty($empGeneral->A_ReportingManager)) {
                $reportingManager = $hrimsConnection->table('hrm_employee as e')
                    ->leftJoin('hrm_employee_general as g', 'e.EmployeeID', '=', 'g.EmployeeID')
                    ->select('e.Fname', 'e.Sname', 'e.Lname', 'g.DesigId', 'g.MobileNo_Vnr', 'g.EmailId_Vnr')
                    ->where('e.EmployeeID', $empGeneral->A_ReportingManager)
                    ->first();

                if ($reportingManager) {
                    $reportingName = trim($reportingManager->Fname ?? '').' '.trim($reportingManager->Sname ?? '').' '.trim($reportingManager->Lname ?? '');
                }
            }

            // Generate next EmployeeID in HRIMS
            $maxEmpId = $hrimsConnection->table('hrm_employee')
                ->max('EmployeeID');
            $nextEmpId = ($maxEmpId ?? 0) + 1;

            // Determine state and HQ
            $state = ! empty($empGeneral->T_StateHq) ? $empGeneral->T_StateHq : ($empGeneral->F_StateHq ?? '');
            $hq = ! empty($empGeneral->T_LocationHq) ? $empGeneral->T_LocationHq : ($empGeneral->F_LocationHq ?? '');

            // Transformations
            $esicAllow = ! empty($empPf->esic_no ?? '') ? 'Y' : 'N';
            $dl = ! empty($empGeneral->DrivingLicense) ? 'Y' : 'N';
            $married = ($empGeneral->MaritalStatus == 'Married') ? 'Y' : 'N';
            $isDoctor = ($empGeneral->NameTitle == 'Dr.') ? 'Y' : 'N';
            $serviceBond = ($empGeneral->ServiceBond == 'Yes') ? 'Y' : 'N';

            // Convert bond years
            $bondYears = 0;
            $bondYearText = strtolower($empGeneral->ServiceBondYears ?? '');
            $yearMapping = ['one' => 1, 'two' => 2, 'three' => 3, 'four' => 4, 'five' => 5, 'six' => 6, 'seven' => 7, 'eight' => 8, 'nine' => 9, '10' => 10];
            $bondYears = $yearMapping[$bondYearText] ?? 0;

            // Wage category
            $wageCategory = 0;
            $skillMapping = ['Highly Skilled' => 1, 'Skilled' => 2, 'Semi Skilled' => 3, 'Unskilled' => 4];
            $wageCategory = $skillMapping[$empGeneral->Skill ?? ''] ?? 0;

            // Confirmation
            $confirmYN = ($empGeneral->ServiceCondition == 'nopnot') ? 'Y' : 'N';

            // Addresses
            $currAdd = ($empAddress->pre_address ?? '').' - '.($empAddress->pre_city ?? '').' - '.($empAddress->pre_dist ?? '').' ('.($empAddress->pre_state ?? '').')';
            $parAdd = ($empAddress->perm_address ?? '').' - '.($empAddress->perm_city ?? '').' - '.($empAddress->perm_dist ?? '').' ('.($empAddress->perm_state ?? '').')';

            // Caste category
            $casteCategory = ($empGeneral->Caste == 'General') ? 'UR' : ($empGeneral->Caste ?? '');

            // Insert into hrm_employee
            $hrimsConnection->table('hrm_employee')->insert([
                'EmployeeID' => $nextEmpId,
                'EmpCode' => $EmpCode,
                //'ECode' => $EmpCode,
                //'EmpCode_New' => $EmpCode,
                'CandidateId' => $empGeneral->CandidateId ?? '',
                'EmpType' => $empGeneral->EmpType ?? 'E',
                'EmpStatus' => $empGeneral->EmpStatus ?? 'A',
                'Fname' => trim($empGeneral->FName ?? ''),
                'Sname' => trim($empGeneral->MName ?? ''),
                'Lname' => trim($empGeneral->LName ?? ''),
                'CompanyId' => $CompanyId,
                'CreatedBy' => $UserId,
                'CreatedDate' => now(),
                'YearId' => $UserId,
            ]);

           

            // Insert into hrm_employee_general
            $hrimsConnection->table('hrm_employee_general')->insert([
                'EmployeeID' => $nextEmpId,
                'EC' => $EmpCode,
                'FileNo' => $EmpCode,
                'DateJoining' => $empGeneral->JoinOnDt ?? null,
                'DOB' => $empGeneral->DOB ?? null,
                'DOB_dm' => ! empty($empGeneral->DOB) ? date('0000-m-d', strtotime($empGeneral->DOB)) : null,
                'GradeId' => $empGeneral->Grade ?? '',
                'CostCenter' => $state,
                'HqId' => $hq,
                'DepartmentId' => $empGeneral->DepartmentId ?? '',
                'SubDepartmentId' => $empGeneral->SubDepartment ?? '',
                'Section' => $empGeneral->Section ?? '',
                'DesigId' => $empGeneral->DesigId ?? '',
                'DesigSuffix' => $empGeneral->DesigSuffix ?? '',
                'PositionCode' => $empGeneral->PositionCode ?? '',
                'PosSeq' => $empGeneral->PosSeq ?? '',
                'PosVR' => $empGeneral->PosVR ?? '',
                'MobileNo_Vnr' => $empGeneral->Contact1 ?? '',
                'MobileNo2_Vnr' => $empGeneral->Contact2 ?? '',
                'Apply_Bond' => $serviceBond,
                'Bond_Year' => $bondYears,
                'BankName' => $empPf->bank_name ?? '',
                'BranchName' => $empPf->branch_name ?? '',
                'AccountNo' => $empPf->acc_number ?? '',
                'BankIfscCode' => $empPf->ifsc_code ?? '',
                'PfAccountNo' => $empPf->pf_acc_no ?? '',
                'PF_UAN' => $empPf->UAN ?? '',
                'EsicAllow' => $esicAllow,
                'EsicNo' => $empPf->esic_no ?? '',
                'RepEmployeeID' => $empGeneral->A_ReportingManager ?? '',
                'ReportingName' => $reportingName,
                'ReportingDesigId' => $reportingManager->DesigId ?? '',
                'ReportingContactNo' => $reportingManager->MobileNo_Vnr ?? '',
                'ReportingEmailId' => $reportingManager->EmailId_Vnr ?? '',
                'EmpFunction'=>$empGeneral->Function ?? '',
                'EmpVertical' => $empGeneral->Vertical ?? '',
                'BUId' => $empGeneral->BU ?? '',
                'ZoneId' => $empGeneral->Zone ?? '',
                'RegionId' => $empGeneral->Region ?? '',
                'TerrId' => $empGeneral->Territory ?? '',
                'BWageId' => $wageCategory,
                'DateConfirmation' => $empGeneral->ConfirmationDate ?? null,
                'DateConfirmationYN' => $confirmYN,
                'ConfirmHR' => $confirmYN,
                'NoticeDay_Conf' => $empGeneral->NoticePeriod ?? '',
                'NoticeDay_Prob' => $empGeneral->ProbationNoticePeriod ?? '',
                //'asset_per_mobile' => 'N',
               // 'asset_per_laptop' => 'N',
                'CreatedBy' => $UserId,
                'CreatedDate' => now(),
                'SysDate' => now(),
            ]);

            // Update reporting if exists
            if (! empty($empGeneral->A_ReportingManager)) {
                $hrimsConnection->table('hrm_employee_reporting')->where('EmployeeID', $nextEmpId)
                    ->update(['AppraiserId' => $empGeneral->A_ReportingManager]);
            }

            // Insert/Update hrm_sales_verhq
            $existingVerhq = $hrimsConnection->table('hrm_sales_verhq')
                ->where('HqId', $hq)
                ->where('Vertical', $empGeneral->Vertical ?? 0)
                ->where('DeptId', $empGeneral->DepartmentId ?? 0)
                ->where('CompanyId', $CompanyId)
                ->exists();

            if ($existingVerhq) {
                $hrimsConnection->table('hrm_sales_verhq')
                    ->where('HqId', $hq)
                    ->where('Vertical', $empGeneral->Vertical ?? 0)
                    ->where('DeptId', $empGeneral->DepartmentId ?? 0)
                    ->where('CompanyId', $CompanyId)
                    ->update(['RegionId' => $empGeneral->Region ?? '', 'CreatedBy' => $UserId, 'CreatedDate' => now()]);
            } else {
                $hrimsConnection->table('hrm_sales_verhq')->insert([
                    'Vertical' => $empGeneral->Vertical ?? 0,
                    'HqId' => $hq,
                    'RegionId' => $empGeneral->Region ?? '',
                    'CompanyId' => $CompanyId,
                    'DeptId' => $empGeneral->DepartmentId ?? 0,
                    'Status' => 'A',
                    'CreatedBy' => $UserId,
                    'CreatedDate' => now(),
                ]);
            }

            // Insert into hrm_employee_personal
            $hrimsConnection->table('hrm_employee_personal')->insert([
                'EmployeeID' => $nextEmpId,
                'EC' => $EmpCode,
                'Gender' => $empGeneral->Gender ?? '',
                'Religion' => $empGeneral->Religion ?? '',
                'AadharNo' => $empGeneral->Aadhar ?? '',
                'PanNo' => $empPf->pan ?? '',
                'PassportNo' => $empPf->passport ?? '',
                'DR' => $isDoctor,
                'MobileNo' => $empGeneral->Contact1 ?? '',
                'EmailId_Self' => $empGeneral->Email1 ?? '',
                'Categoryy' => $casteCategory,
                'DrivingLicNo' => $empGeneral->DrivingLicense ?? '',
                'DrivingLicNo_YN' => $dl,
                'Driv_ExpiryDateFrom' => $empGeneral->LValidityFrom ?? null,
                'Driv_ExpiryDateTo' => $empGeneral->LValidity ?? null,
                'Married' => $married,
                'MarriageDate' => $empGeneral->marriage_dt ?? null,
                'MarriageDate_dm' => ! empty($empGeneral->marriage_dt) ? date('0000-m-d', strtotime($empGeneral->marriage_dt)) : null,
                'BloodGroup' => $empGeneral->BloodGroup ?? '',
                'CreatedBy' => $UserId,
                'CreatedDate' => now(),
            ]);

            // Insert into hrm_employee_contact
            $hrimsConnection->table('hrm_employee_contact')->insert([
                'EmployeeID' => $nextEmpId,
                'EC' => $EmpCode,
                'Curradd' => $currAdd,
                'CurrAdd_PinNo' => $empAddress->pre_pin ?? '',
                'ParAdd' => $parAdd,
                'ParAdd_PinNo' => $empAddress->perm_pin ?? '',
                'EmgContactNo' => $empGeneral->EmgContPhone_One ?? '',
                'EmgRelation' => $empGeneral->EmgContRelation_One ?? '',
                'EmgName' => $empGeneral->EmgContName_One ?? '',
                'Emg_Contact1' => $empGeneral->EmgContPhone_One ?? '',
                'Emg_Person1' => $empGeneral->EmgContName_One ?? '',
                'Emp_Relation1' => $empGeneral->EmgContRelation_One ?? '',
                'Emg_Contact2' => $empGeneral->EmgContPhone_Two ?? '',
                'Emg_Person2' => $empGeneral->EmgContName_Two ?? '',
                'Emp_Relation2' => $empGeneral->EmgContRelation_Two ?? '',
                'Personal_RefName' => $empVnrRef->name ?? '',
                'Personal_RefContactNo' => $empVnrRef->contact ?? '',
                'Personal_RefDesig' => $empVnrRef->designation ?? '',
                'Personal_RefEmailId' => $empVnrRef->email ?? '',
                'Personal_RefRelation' => $empVnrRef->rel_with_person ?? '',
                'Personal_RefCompany' => $empVnrRef->company ?? '',
                'Personal_RefAdd' => '',
                'Prof_RefName' => $empPreRef->name ?? '',
                'Prof_RefContactNo' => $empPreRef->contact ?? '',
                'Prof_RefDesig' => $empPreRef->designation ?? '',
                'Prof_RefEmailId' => $empPreRef->email ?? '',
                'Prof_RefCompany' => $empPreRef->company ?? '',
                'CreatedBy' => $UserId,
                'CreatedDate' => now(),
                'YearId' => $UserId,
                'CurrAdd_State' => $empAddress->pre_state ?? '',
                'ParAdd_State' => $empAddress->perm_state ?? '',
                'CurrAdd_City' => $empAddress->pre_city ?? '',
                'ParAdd_City' => $empAddress->perm_city ?? '',
            ]);

            // Insert into hrm_employee_ctc
            if ($empCtc) {
                $hrimsConnection->table('hrm_employee_ctc')->insert([
                    'EmployeeID' => $nextEmpId,
                    'EC' => $EmpCode,
                    'CHILD_EDU_ALL_Value' => $empCtc->childedu ?? 0,
                    'LTA_Value' => $empCtc->lta ?? 0,
                    'BAS_Value' => $empCtc->basic ?? 0,
                    'HRA_Value' => $empCtc->hra ?? 0,
                    'Bonus_Month' => $empCtc->bonus ?? 0,
                    'SPECIAL_ALL_Value' => $empCtc->special_alw ?? 0,
                    'NetMonthSalary_Value' => $empCtc->netMonth ?? 0,
                    'GrossSalary_PostAnualComponent_Value' => $empCtc->grsM_salary ?? 0,
                    'GRATUITY_Value' => $empCtc->gratuity ?? 0,
                    'Tot_GrossMonth' => $empCtc->grsM_salary ?? 0,
                    'Tot_Gross_Annual' => $empCtc->anualgrs ?? 0,
                    'PF_Employee_Contri_Value' => $empCtc->emplyPF ?? 0,
                    'PF_Employee_Contri_Annul' => $empCtc->emplyerPF ?? 0,
                    'PF_Employer_Contri_Value' => $empCtc->emplyPF ?? 0,
                    'PF_Employer_Contri_Annul' => $empCtc->emplyerPF ?? 0,
                    'Mediclaim_Policy' => $empCtc->medical ?? 0,
                    'Tot_CTC' => $empCtc->fixed_ctc ?? 0,
                   // 'VariablePay' => $empCtc->performance_pay ?? 0,
                   // 'TotCtc' => $empCtc->total_ctc ?? 0,
                   // 'Car_Allowance' => $empCtc->car_allowance_amount ?? 0,
                    'Communication_Allowance' => $empCtc->communication_allowance_amount ?? 0,
                   // 'Vehicle_Allowance' => $empCtc->vehicle_allowance_amount ?? 0,
                    'Total_Gross_CTC' => $empCtc->total_gross_ctc ?? 0,
                    'ESCI' => $empCtc->emplyESIC ?? 0,
                    'AnnualESCI' => $empCtc->emplyerESIC ?? 0,
                    'Status' => 'A',
                    'CtcCreatedBy' => $UserId,
                    'CtcCreatedDate' => ! empty($empGeneral->JoinOnDt) ? date('Y-m-d', strtotime($empGeneral->JoinOnDt)) : now(),
                    'CtcYearId' => $UserId,
                    'SalChangeDate' => ! empty($empGeneral->JoinOnDt) ? date('Y-m-d', strtotime($empGeneral->JoinOnDt)) : now(),
                    'SystDate' => now(),
                ]);
            }

          

            // Insert into hrm_employee_eligibility
            if ($empElg) {
                $mExpYN = ! empty($empElg->MExpense) && $empElg->MExpense > 0 ? 'Y' : 'N';
                $mobYN = ! empty($empElg->Mobile) && $empElg->Mobile > 0 ? 'Y' : 'N';
                $checkup = ! empty($empElg->Helth_CheckUp) && $empElg->Helth_CheckUp > 0 ? 'Y' : 'N';
                $gprs = ! empty($empElg->GPRS) && $empElg->GPRS == 1 ? 'Y' : 'N';

                // Check for four_wheel_flat_rate adjustment
                $fourWheel = $empElg->FourWheel ?? '';
                if (isset($empElg->four_wheel_flat_rate) && $empElg->four_wheel_flat_rate == 'Yes') {
                    $fourWheel = '0.00';
                }

                $hrimsConnection->table('hrm_employee_eligibility')->insert([
                    'EmployeeID' => $nextEmpId,
                    'EC' => $EmpCode,
                    'Lodging_CategoryA' => $empElg->LoadCityA ?? '',
                    'Lodging_CategoryB' => $empElg->LoadCityB ?? '',
                    'Lodging_CategoryC' => $empElg->LoadCityC ?? '',
                    'DA_Outside_Hq' => $empElg->DAOut ?? '',
                    //'DA_Outside_Hq_Rmk' => $empElg->DAOut_Rmk ?? '',
                    'DA_Inside_Hq' => $empElg->DAHq ?? '',
                    //'DA_Inside_Hq_Rmk' => $empElg->DAHq_Rmk ?? '',
                    'Travel_TwoWeeKM' => $empElg->TwoWheel ?? '',
                    'Travel_TwoWeeKM_Rmk' => $empElg->TwoWheel_Rmk ?? '',
                    'Travel_FourWeeKM' => $fourWheel,
                    'Travel_FourWeeKM_Rmk' => $empElg->FourWheel_Rmk ?? '',
                   // 'Flight_Allow' => $empElg->Flight ?? '',
                   // 'Flight_Class' => $empElg->Flight_Class ?? '',
                   // 'Flight_Rmk' => $empElg->Flight_Remark ?? '',
                   // 'Train_Allow' => $empElg->Train ?? '',
                    //'Train_Class' => $empElg->Train_Class ?? '',
                   // 'Train_Rmk' => $empElg->Train_Remark ?? '',
                    'Mobile_Exp_Rem' => $mExpYN,
                    'Mobile_Exp_Rem_Rs' => $empElg->MExpense ?? '',
                    'Prd' => $empElg->MTerm ?? '',
                    'Mobile_Company_Hand' => 'N',
                    'Mobile_Hand_Elig' => $mobYN,
                    'GPSSet' => $gprs,
                    'Mobile_Hand_Elig_Rs' => $empElg->Mobile ?? '',
                    //'Mobile_Hand_Elig_Rmk' => $gprs == 'Y' ? '(Once in 2 yrs)' : '(Once in 3 yrs)',
                    'Health_Insurance' => $empElg->HealthIns ?? '',
                    'HelthCheck' => $checkup,
                    //'HelthCheck_Amt' => $empElg->Helth_CheckUp ?? '',
                    'CostOfVehicle' => $empElg->CostOfVehicle ?? '',
                    'VehiclePolicy' => $empElg->Vehicle_Policy ?? '',
                    'Term_Insurance' => $empElg->Term_Insurance ?? '',
                    'Term_Insurance_Rmk' => $empElg->Term_Insurance_Rmk ?? '',
                   // 'Laptop_Amt' => $empElg->Laptop ?? '',
                   // 'Laptop_Remark' => $empElg->Laptop_Remark ?? '',
                   // 'Mobile_Exp_Rem_Rmk' => $empElg->Mobile_Remb_Period_Rmk ?? '',
                  //  'Mobile_Exp_RemPost_Rs' => $empElg->Mobile_RembPost ?? '',
                  //  'PrdPost' => $empElg->Mobile_RembPost_Period ?? '',
                  //  'Mobile_Exp_RemPost_Rmk' => $empElg->Mobile_RembPost_Period_Rmk ?? '',
                    'Status' => 'A',
                    'EligCreatedBy' => $UserId,
                    'EligCreatedDate' => now(),
                    'EligYearId' => $UserId,
                    'SysDate' => now(),
                ]);
            }

            // Insert into hrm_employee_langproficiency
            if ($empLanguages && count($empLanguages) > 0) {
                // Check if languages don't already exist
                $existingLang = $hrimsConnection->table('hrm_employee_langproficiency')
                    ->where('EmployeeID', $nextEmpId)
                    ->exists();

                if (! $existingLang) {
                    foreach ($empLanguages as $lang) {
                        $langCheck = 'L'; // Default to Local
                        if ($lang->language == 'English') {
                            $langCheck = 'E';
                        } elseif ($lang->language == 'Hindi') {
                            $langCheck = 'H';
                        }

                        $read = ($lang->read == 1) ? 'Y' : 'N';
                        $write = ($lang->write == 1) ? 'Y' : 'N';
                        $speak = ($lang->speak == 1) ? 'Y' : 'N';

                        $hrimsConnection->table('hrm_employee_langproficiency')->insert([
                            'EmployeeID' => $nextEmpId,
                            'Language' => $lang->language,
                            'LangCheck' => $langCheck,
                            'Write_lang' => $write,
                            'Read_lang' => $read,
                            'Speak_lang' => $speak,
                            'LangProCreatedBy' => $UserId,
                            'LangProCreatedDate' => now(),
                            'LangProYearId' => $UserId,
                        ]);
                    }
                }
            }

            // Insert into hrm_employee_qualification
            if ($empEducation && count($empEducation) > 0) {
                // Check if qualification doesn't already exist
                $existingQual = $hrimsConnection->table('hrm_employee_qualification')
                    ->where('EmployeeID', $nextEmpId)
                    ->exists();

                if (! $existingQual) {
                    foreach ($empEducation as $edu) {
                        $hrimsConnection->table('hrm_employee_qualification')->insert([
                            'EmployeeID' => $nextEmpId,
                            'Qualification' => $edu->Qualification ?? '',
                            'Specialization' => $edu->Course ?? '',
                            'Institute' => $edu->Institute ?? '',
                            'Subject' => $edu->Specialization ?? '',
                            'PassOut' => $edu->YearOfPassing ?? '',
                            'Grade_Per' => $edu->CGPA ?? '',
                            'QuaCreatedBy' => $UserId,
                            'QuaCreatedDate' => now(),
                            'QuaYearId' => $UserId,
                        ]);
                    }
                }
            }

            // Check and insert standard qualifications (10th, 12th, Graduation, Post_Graduation) if not present
            $standardQualifications = ['10th', '12th', 'Graduation', 'Post_Graduation'];
            foreach ($standardQualifications as $qual) {
                $exists = $hrimsConnection->table('hrm_employee_qualification')
                    ->where('Qualification', $qual)
                    ->where('EmployeeID', $nextEmpId)
                    ->exists();

                if (! $exists) {
                    $hrimsConnection->table('hrm_employee_qualification')->insert([
                        'EmployeeID' => $nextEmpId,
                        'MaxQuali' => 'N',
                        'Qualification' => $qual,
                        'QuaCreatedBy' => $UserId,
                        'QuaCreatedDate' => now(),
                        'QuaYearId' => $UserId,
                    ]);
                }
            }

            // Insert into hrm_employee_experience
            if ($empWorkExp && count($empWorkExp) > 0) {
                // Check if experience doesn't already exist
                $existingExp = $hrimsConnection->table('hrm_employee_experience')
                    ->where('EmployeeID', $nextEmpId)
                    ->exists();

                if (! $existingExp) {
                    foreach ($empWorkExp as $exp) {
                        // Calculate experience years
                        $expMain = '0.00';
                        if (! empty($exp->job_start) && ! empty($exp->job_end)) {
                            $dos = date('d-m-Y', strtotime($exp->job_start));
                            $today = date('d-m-Y', strtotime($exp->job_end));
                            $dob_a = explode('-', $dos);
                            $today_a = explode('-', $today);

                            $dob_d = $dob_a[0];
                            $dob_m = $dob_a[1];
                            $dob_y = $dob_a[2];
                            $today_d = $today_a[0];
                            $today_m = $today_a[1];
                            $today_y = $today_a[2];

                            $years = $today_y - $dob_y;
                            $months = $today_m - $dob_m;

                            if ($today_m.$today_d < $dob_m.$dob_d) {
                                $years--;
                                $months = 12 + $today_m - $dob_m;
                            }

                            if ($today_d < $dob_d) {
                                $months--;
                            }

                            $mnt = str_pad($months, 2, '0', STR_PAD_LEFT);
                            $expMain = $years.'.'.$mnt;
                        }

                        $hrimsConnection->table('hrm_employee_experience')->insert([
                            'EmployeeID' => $nextEmpId,
                            'EC' => $EmpCode,
                            'ExpComName' => $exp->company ?? '',
                            'ExpDesignation' => $exp->desgination ?? '',
                            'ExpFromDate' => $exp->job_start ?? null,
                            'ExpToDate' => $exp->job_end ?? null,
                            'ExpTotalYear' => $expMain,
                            'ExpGrossSalary' => $exp->gross_mon_sal ?? '',
                            'ExpCreatedBy' => $UserId,
                            'ExpCreatedDate' => now(),
                            'ExpYearId' => $UserId,
                        ]);
                    }
                }
            } else {
                // Insert empty experience record if no experience exists
                $existingExp = $hrimsConnection->table('hrm_employee_experience')
                    ->where('EmployeeID', $nextEmpId)
                    ->exists();

                if (! $existingExp) {
                    $hrimsConnection->table('hrm_employee_experience')->insert([
                        'EmployeeID' => $nextEmpId,
                        'EC' => $EmpCode,
                        'ExpCreatedBy' => $UserId,
                        'ExpCreatedDate' => now(),
                        'ExpYearId' => $UserId,
                    ]);
                }
            }

            // Insert into hrm_employee_family (Father, Mother, Spouse)
            $father = null;
            $mother = null;
            $spouse = null;
            $otherFamily = [];

            foreach ($empFamily as $family) {
                if ($family->Relation == 'Father') {
                    $father = $family;
                } elseif ($family->Relation == 'Mother') {
                    $mother = $family;
                } elseif ($family->Relation == 'Spouse') {
                    $spouse = $family;
                } else {
                    $otherFamily[] = $family;
                }
            }

            // Determine HW_SN based on gender
            $hwSn = ($empGeneral->Gender == 'M') ? 'Ms' : 'Mr';

            $hrimsConnection->table('hrm_employee_family')->insert([
                'EmployeeID' => $nextEmpId,
                'EC' => $EmpCode,
                'Fa_SN' => 'Mr',
                'FatherName' => $father->Name ?? '',
                'FatherDOB' => ! empty($father->Dob ?? '') ? date('Y-m-d', strtotime($father->Dob)) : '',
                'FatherOccupation' => $father->Occupation ?? '',
                'FatherQuali' => $father->Qualification ?? '',
                'Mo_SN' => 'Ms',
                'MotherName' => $mother->Name ?? '',
                'MotherDOB' => ! empty($mother->Dob ?? '') ? date('Y-m-d', strtotime($mother->Dob)) : '',
                'MotherOccupation' => $mother->Occupation ?? '',
                'MotherQuali' => $mother->Qualification ?? '',
                'HW_SN' => $hwSn,
                'HusWifeName' => $spouse->Name ?? '',
                'HusWifeDOB' => ! empty($spouse->Dob ?? '') ? date('Y-m-d', strtotime($spouse->Dob)) : '',
                'HusWifeOccupation' => $spouse->Occupation ?? '',
                'HusWifeQuali' => $spouse->Qualification ?? '',
                'CreatedBy' => $UserId,
                'CreatedDate' => now(),
                'YearId' => $UserId,
            ]);

            // Insert into hrm_employee_family2 (Other family members)
            if (count($otherFamily) > 0) {
                // Check if other family members don't already exist
                $existingFamily2 = $hrimsConnection->table('hrm_employee_family2')
                    ->where('EmployeeID', $nextEmpId)
                    ->exists();

                if (! $existingFamily2) {
                    foreach ($otherFamily as $fam) {
                        $hrimsConnection->table('hrm_employee_family2')->insert([
                            'EmployeeID' => $nextEmpId,
                            'FamilyRelation' => $fam->Relation ?? '',
                            'FamilyName' => $fam->Name ?? '',
                            'FamilyDOB' => ! empty($fam->Dob ?? '') ? date('Y-m-d', strtotime($fam->Dob)) : '',
                            'FamilyQualification' => $fam->Qualification ?? '',
                            'FamilyOccupation' => $fam->Occupation ?? '',
                            'CreatedBy' => $UserId,
                            'CreatedDate' => now(),
                            'YearId' => $UserId,
                        ]);
                    }
                }
            }

            // Insert required tables for HRIMS
            $hrimsConnection->table('hrm_employee_photo')->insert(['EmployeeID' => $nextEmpId, 'EC' => $EmpCode]);
            $hrimsConnection->table('hrm_employee_reporting')->insert(['EmployeeID' => $nextEmpId]);
            $hrimsConnection->table('hrm_employee_checklist')->insert(['EmployeeID' => $nextEmpId, 'EC' => $EmpCode]);
            $hrimsConnection->table('hrm_employee_reporting_pmskra')->insert(['EmployeeID' => $nextEmpId]);

            // Get PMS setting year
            $pmsSetting = $hrimsConnection->table('hrm_pms_setting')
                ->where('CompanyId', $CompanyId)
                ->where('Process', 'KRA')
                ->first();
            $currYear = $pmsSetting->CurrY ?? $UserId;

            $hrimsConnection->table('hrm_employee_pms')->insert([
                'AssessmentYear' => $currYear,
                'CompanyId' => $CompanyId,
                'EmployeeID' => $nextEmpId,
                'HR_Curr_DepartmentId' => $empGeneral->DepartmentId ?? '',
                'YearId' => $currYear,
            ]);

            // Insert leave balance
            if (! empty($empGeneral->JoinOnDt)) {
                $joinMonth = date('m', strtotime($empGeneral->JoinOnDt));
                $joinYear = date('Y', strtotime($empGeneral->JoinOnDt));

                $leaveDistribution = $hrimsConnection->table('hrm_leavedistributed')
                    ->where('LeaveDisMonth', $joinMonth)
                    ->where('CompanyId', $CompanyId)
                    ->first();

                $cl = $leaveDistribution->CL ?? 0;
                $sl = $leaveDistribution->SL ?? 0;

                $hrimsConnection->table('hrm_employee_monthlyleave_balance')->insert([
                    'EmployeeID' => $nextEmpId,
                    'EC' => $EmpCode,
                    'Month' => $joinMonth,
                    'Year' => $joinYear,
                    'OpeningCL' => $cl,
                    'OpeningSL' => $sl,
                    'TotCL' => $cl,
                    'TotSL' => $sl,
                    'BalanceCL' => $cl,
                    'BalanceSL' => $sl,
                    'CreatedBy' => $UserId,
                    'CreatedDate' => now(),
                ]);
            }

            // Update DataMove flag in recruitment_to_ess
            $essConnection->table('employee_general')
                ->where('EmpCode', $EmpCode)
                ->where('CompanyId', $CompanyId)
                ->update(['DataMove' => 'Y']);

            // Copy employee files from recruitment S3 bucket to HRIMS S3 bucket
            $fileCopyResult = $this->copyEmployeeFilesToHrimsS3($JAId, $JCId, $EmpCode);

            if (! $fileCopyResult['success']) {
                Log::error("File copy failed for EmpCode: {$EmpCode}. Error: ".($fileCopyResult['error'] ?? 'Unknown error'));
                // Note: We're not rolling back the transaction even if file copy fails
                // Because the employee data is more important than the files
                // Files can be copied manually later if needed
            }

            DB::commit();

            $message = 'Data successfully transferred to both recruitment_to_ess and HRIMS';
            if ($fileCopyResult['success'] && $fileCopyResult['copied_count'] > 0) {
                $message .= ". {$fileCopyResult['copied_count']} file(s) copied to HRIMS S3 bucket";
                if ($fileCopyResult['failed_count'] > 0) {
                    $message .= ", {$fileCopyResult['failed_count']} file(s) failed to copy";
                }
            }

            return response()->json([
                'status' => 200,
                'message' => $message,
                'file_copy_details' => $fileCopyResult,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['status' => 400, 'msg' => 'Error: '.$e->getMessage()]);
        }
    }

      /**
     * Copy employee files from recruitment S3 bucket to HRIMS S3 bucket
     *
     * EACH DOCUMENT HAS INDEPENDENT CONTROL OVER:
     *   - source_dir      : Directory in source S3 bucket where file is stored
     *   - dest_disk       : Destination S3 disk (bucket) to copy to
     *   - dest_dir        : Directory in destination bucket
     *   - dest_filename   : Filename in destination (supports placeholders)
     *
     * PLACEHOLDERS (use in dest_dir and dest_filename):
     *   {EmpCode}    = Employee Code (e.g., VNR001)
     *   {CompanyId}  = Company ID (e.g., 1)
     *   {JCId}       = Job Candidate ID
     *   {JAId}       = Job Application ID
     *   {filename}   = Original filename with extension
     *   {extension}  = File extension with dot (e.g., .jpg, .pdf)
     *
     * @param  int  $JAId  Job Application ID
     * @param  int  $JCId  Job Candidate ID
     * @param  string  $EmpCode  Employee Code
     * @return array Array with success status and copied files count
     */
    private function copyEmployeeFilesToHrimsS3($JAId, $JCId, $EmpCode)
    {
        try {
            $sourceDisk = 's3'; // Recruitment bucket (same for all)
            $copiedFiles = [];
            $failedFiles = [];
            $userId = Auth::user()->id ?? null;
            $CompanyId = OfferLetter::where('JAId', $JAId)->value('Company');

            // ================================================================
            // PER-DOCUMENT CONFIGURATION
            // ================================================================
            // Each document has its own source_dir, dest_disk, dest_dir, dest_filename
            // Update dest_disk, dest_dir and dest_filename for each document as needed
            // ================================================================

            $documentConfig = [

                

                //  CANDIDATE PHOTO
                'CandidateImage' => [
                    'source' => 'jobcandidates',
                    'source_dir' => 'VVNR_Recruitment/Picture/',
                    'dest_disk' => 's3-hrims',
                    'dest_dir' => 'Employee_Image/{CompanyId}/',
                    'dest_filename' => '{EmpCode}{extension}',
                ],
                 // 1. AADHAAR CARD
                'Aadhar' => [
                    'source' => 'jf_docs',
                    'source_dir' => 'VVNR_Recruitment/Documents/',
                    'dest_disk' => 's3-hrims',
                    'dest_dir' => 'Employee_Document/{CompanyId}/',
                    'dest_filename' => '{EmpCode}_aadhar{extension}',
                ],

                // 2. PAN CARD
                'PanCard' => [
                    'source' => 'jf_docs',
                    'source_dir' => 'VVNR_Recruitment/Documents/',
                    'dest_disk' => 's3-hrims',
                    'dest_dir' => 'Employee_Document/{CompanyId}/',
                    'dest_filename' => '{EmpCode}_pan{extension}',
                ],

                // 3. PASSPORT
                'Passport' => [
                    'source' => 'jf_docs',
                    'source_dir' => 'VVNR_Recruitment/Documents/',
                    'dest_disk' => 's3-hrims',
                    'dest_dir' => 'Employee_Document/{CompanyId}/',
                    'dest_filename' => '{EmpCode}_passport{extension}',
                ],

                // 4. DRIVING LICENSE
                'DL' => [
                    'source' => 'jf_docs',
                    'source_dir' => 'VVNR_Recruitment/Documents/',
                    'dest_disk' => 's3-hrims',
                    'dest_dir' => 'Employee_Document/{CompanyId}/',
                    'dest_filename' => '{EmpCode}_dl{extension}',
                ],

                // 5. UAN DOCUMENT
                'UAN' => [
                    'source' => 'jf_docs',
                    'source_dir' => 'VVNR_Recruitment/Documents/',
                    'dest_disk' => 's3-hrims',
                    'dest_dir' => 'Employee_Document/{CompanyId}/',
                    'dest_filename' => '{EmpCode}_uan{extension}',
                ],

                // 6. BANK PASSBOOK / DOCUMENT
                'BankDoc' => [
                    'source' => 'jf_docs',
                    'source_dir' => 'VVNR_Recruitment/Documents/',
                    'dest_disk' => 's3-hrims',
                    'dest_dir' => 'Employee_Document/{CompanyId}/',
                    'dest_filename' => '{EmpCode}_bank{extension}',
                ],

                // 7. PF FORM 2
                'PF_Form2' => [
                    'source' => 'jf_docs',
                    'source_dir' => 'VVNR_Recruitment/Documents/',
                    'dest_disk' => 's3-hrims',
                    'dest_dir' => 'Employee_Document/{CompanyId}/',
                    'dest_filename' => '{EmpCode}_pf_form2{extension}',
                ],

                // 8. PF FORM 11
                'PF_Form11' => [
                    'source' => 'jf_docs',
                    'source_dir' => 'VVNR_Recruitment/Documents/',
                    'dest_disk' => 's3-hrims',
                    'dest_dir' => 'Employee_Document/{CompanyId}/',
                    'dest_filename' => '{EmpCode}_pf_form11{extension}',
                ],

                // 9. GRATUITY FORM
                'Gratutity' => [
                    'source' => 'jf_docs',
                    'source_dir' => 'VVNR_Recruitment/Documents/',
                    'dest_disk' => 's3-hrims',
                    'dest_dir' => 'Employee_Document/{CompanyId}/',
                    'dest_filename' => '{EmpCode}_gratuity{extension}',
                ],

                // 10. ESIC FORM
                'ESIC' => [
                    'source' => 'jf_docs',
                    'source_dir' => 'VVNR_Recruitment/Documents/',
                    'dest_disk' => 's3-hrims',
                    'dest_dir' => 'Employee_Document/{CompanyId}/',
                    'dest_filename' => '{EmpCode}_esic{extension}',
                ],

                // 11. ESIC FAMILY FORM
                'ESIC_Family' => [
                    'source' => 'jf_docs',
                    'source_dir' => 'VVNR_Recruitment/Documents/',
                    'dest_disk' => 's3-hrims',
                    'dest_dir' => 'Employee_Document/{CompanyId}/',
                    'dest_filename' => '{EmpCode}_esic_family{extension}',
                ],

                // 12. HEALTH DECLARATION
                'Health' => [
                    'source' => 'jf_docs',
                    'source_dir' => 'VVNR_Recruitment/Documents/',
                    'dest_disk' => 's3-hrims',
                    'dest_dir' => 'Employee_Document/{CompanyId}/',
                    'dest_filename' => '{EmpCode}_health{extension}',
                ],

                // 13. ETHICAL DECLARATION
                'Ethical' => [
                    'source' => 'jf_docs',
                    'source_dir' => 'VVNR_Recruitment/Documents/',
                    'dest_disk' => 's3-hrims',
                    'dest_dir' => 'Employee_Document/{CompanyId}/',
                    'dest_filename' => '{EmpCode}_ethical{extension}',
                ],

                // 14. BLOOD GROUP REPORT
                'BloodGroup' => [
                    'source' => 'jf_docs',
                    'source_dir' => 'VVNR_Recruitment/Documents/',
                    'dest_disk' => 's3-hrims',
                    'dest_dir' => 'Employee_Document/{CompanyId}/',
                    'dest_filename' => '{EmpCode}_bloodgroup{extension}',
                ],

                // 15. INVESTMENT DECLARATION
                'Invst_Decl' => [
                    'source' => 'jf_docs',
                    'source_dir' => 'VVNR_Recruitment/Documents/',
                    'dest_disk' => 's3-hrims',
                    'dest_dir' => 'Employee_Document/{CompanyId}/',
                    'dest_filename' => '{EmpCode}_invst_decl{extension}',
                ],

                // 16. FORM 16
                'Form16' => [
                    'source' => 'jf_docs',
                    'source_dir' => 'VVNR_Recruitment/Documents/',
                    'dest_disk' => 's3-hrims',
                    'dest_dir' => 'Employee_Document/{CompanyId}/',
                    'dest_filename' => '{EmpCode}_form16{extension}',
                ],

                // 17. VACCINATION CERTIFICATE
                'VaccinationCert' => [
                    'source' => 'jf_docs',
                    'source_dir' => 'VVNR_Recruitment/Documents/',
                    'dest_disk' => 's3-hrims',
                    'dest_dir' => 'Employee_Document/{CompanyId}/',
                    'dest_filename' => '{EmpCode}_vaccination{extension}',
                ],

                // 18. PF e-NOMINATION
                'PFeNomination' => [
                    'source' => 'jf_docs',
                    'source_dir' => 'VVNR_Recruitment/Documents/',
                    'dest_disk' => 's3-hrims',
                    'dest_dir' => 'Employee_Document/{CompanyId}/',
                    'dest_filename' => '{EmpCode}_pf_enomination{extension}',
                ],

                // 19. EPFO JOINT DECLARATION
                'Epfo_Joint' => [
                    'source' => 'jf_docs',
                    'source_dir' => 'VVNR_Recruitment/Documents/',
                    'dest_disk' => 's3-hrims',
                    'dest_dir' => 'Employee_Document/{CompanyId}/',
                    'dest_filename' => '{EmpCode}_epfo_joint{extension}',
                ],

                // 20. OFFER LETTER
                'OfferLtr' => [
                    'source' => 'jf_docs',
                    'source_dir' => 'VVNR_Recruitment/Documents/',
                    'dest_disk' => 's3-hrims',
                    'dest_dir' => 'Employee_Document/{CompanyId}/',
                    'dest_filename' => '{EmpCode}_offer_letter{extension}',
                ],

                // 21. RELIEVING LETTER
                'RelievingLtr' => [
                    'source' => 'jf_docs',
                    'source_dir' => 'VVNR_Recruitment/Documents/',
                    'dest_disk' => 's3-hrims',
                    'dest_dir' => 'Employee_Document/{CompanyId}/',
                    'dest_filename' => '{EmpCode}_relieving_letter{extension}',
                ],

                // 22. SALARY SLIP
                'SalarySlip' => [
                    'source' => 'jf_docs',
                    'source_dir' => 'VVNR_Recruitment/Documents/',
                    'dest_disk' => 's3-hrims',
                    'dest_dir' => 'Employee_Document/{CompanyId}/',
                    'dest_filename' => '{EmpCode}_salary_slip{extension}',
                ],

                // 23. APPRAISAL LETTER
                'AppraisalLtr' => [
                    'source' => 'jf_docs',
                    'source_dir' => 'VVNR_Recruitment/Documents/',
                    'dest_disk' => 's3-hrims',
                    'dest_dir' => 'Employee_Document/{CompanyId}/',
                    'dest_filename' => '{EmpCode}_appraisal_letter{extension}',
                ],

                // 24. RESIGNATION
                'Resignation' => [
                    'source' => 'jf_docs',
                    'source_dir' => 'VVNR_Recruitment/Documents/',
                    'dest_disk' => 's3-hrims',
                    'dest_dir' => 'Employee_Document/{CompanyId}/',
                    'dest_filename' => '{EmpCode}_resignation{extension}',
                ],

                // 25. RESIGNATION ACCEPTANCE
                'Resignation_Accept' => [
                    'source' => 'jf_docs',
                    'source_dir' => 'VVNR_Recruitment/Documents/',
                    'dest_disk' => 's3-hrims',
                    'dest_dir' => 'Employee_Document/{CompanyId}/',
                    'dest_filename' => '{EmpCode}_resignation_accept{extension}',
                ],

                // 26. FAMILY PHOTO
                'Family_Photo' => [
                    'source' => 'jf_docs',
                    'source_dir' => 'VVNR_Recruitment/Documents/',
                    'dest_disk' => 's3-hrims',
                    'dest_dir' => 'Employee_Document/{CompanyId}/',
                    'dest_filename' => '{EmpCode}_family_photo{extension}',
                ],

                // 27. TEST PAPER
                'Test_Paper' => [
                    'source' => 'jf_docs',
                    'source_dir' => 'VVNR_Recruitment/Documents/',
                    'dest_disk' => 's3-hrims',
                    'dest_dir' => 'Employee_Document/{CompanyId}/',
                    'dest_filename' => '{EmpCode}_test_paper{extension}',
                ],

                // 28. INTERVIEW ASSESSMENT
                'IntervAssessment' => [
                    'source' => 'jf_docs',
                    'source_dir' => 'VVNR_Recruitment/Documents/',
                    'dest_disk' => 's3-hrims',
                    'dest_dir' => 'Employee_Document/{CompanyId}/',
                    'dest_filename' => '{EmpCode}_interview_assessment{extension}',
                ], 



            ];

            // ================================================================
            // FETCH DATA FROM ALL SOURCE TABLES
            // ================================================================

            // jf_docs table
            $jfDocs = DB::table('jf_docs')->where('JCId', $JCId)->first();

            // jobcandidates table
            $jobcandidate = DB::table('jobcandidates')
                ->join('jobapply', 'jobapply.JCId', '=', 'jobcandidates.JCId')
                ->where('jobcandidates.JCId', $JCId)
                ->first();

           


            // ================================================================
            // BUILD FILE LIST FROM EACH SOURCE
            // ================================================================

            $filesToCopy = [];

          //  --- jf_docs columns ---
            $jfDocsColumns = [
                'Aadhar', 'PanCard', 'Passport', 'DL', 'UAN', 'BankDoc',
                'PF_Form2', 'PF_Form11', 'Gratutity', 'ESIC', 'ESIC_Family',
                'Health', 'Ethical', 'BloodGroup', 'Invst_Decl', 'Form16',
                'VaccinationCert', 'PFeNomination', 'Epfo_Joint',
                'OfferLtr', 'RelievingLtr', 'SalarySlip', 'AppraisalLtr',
                'Resignation', 'Resignation_Accept', 'Family_Photo',
                'Test_Paper', 'IntervAssessment',
            ];

            if ($jfDocs) {
                foreach ($jfDocsColumns as $column) {
                    if (!empty($jfDocs->$column) && isset($documentConfig[$column])) {
                        $config = $documentConfig[$column];
                        $filesToCopy[] = [
                            'source_filename' => $jfDocs->$column,
                            'source_dir'      => $config['source_dir'],
                            'dest_disk'       => $config['dest_disk'],
                            'dest_dir'        => $config['dest_dir'],
                            'dest_filename'   => $config['dest_filename'],
                            'file_type'       => $column,
                        ];
                    }
                }
            }

            // --- jobcandidates columns ---
            $jobcandidateColumns = ['CandidateImage'];
            if ($jobcandidate) {
                foreach ($jobcandidateColumns as $column) {
                    if (! empty($jobcandidate->$column) && isset($documentConfig[$column])) {
                        $config = $documentConfig[$column];
                        $filesToCopy[] = [
                            'source_filename' => $jobcandidate->$column,
                            'source_dir' => $config['source_dir'],
                            'dest_disk' => $config['dest_disk'],
                            'dest_dir' => $config['dest_dir'],
                            'dest_filename' => $config['dest_filename'],
                            'file_type' => $column,
                        ];
                    }
                }
            }

          



            // ================================================================
            // COPY EACH FILE
            // ================================================================

            foreach ($filesToCopy as $file) {
                $logId = null;
                try {
                    $sourceFilename = $file['source_filename'];
                    $sourcePath = $file['source_dir'].$sourceFilename;

                    // Extract extension from source filename
                    $pathInfo = pathinfo($sourceFilename);
                    $extension = isset($pathInfo['extension']) ? '.'.$pathInfo['extension'] : '';
                    $originalFilename = $pathInfo['basename'] ?? $sourceFilename;

                    // Replace placeholders in dest_dir
                    $destDir = str_replace(
                        ['{EmpCode}', '{CompanyId}', '{JAId}', '{JCId}'],
                        [$EmpCode, $CompanyId, $JAId, $JCId],
                        $file['dest_dir']
                    );

                    // Replace placeholders in dest_filename
                    $destFilename = str_replace(
                        ['{EmpCode}', '{CompanyId}', '{JAId}', '{JCId}', '{filename}', '{extension}'],
                        [$EmpCode, $CompanyId, $JAId, $JCId, $originalFilename, $extension],
                        $file['dest_filename']
                    );

                    $destinationPath = $destDir.$destFilename;
                    $destDisk = $file['dest_disk'];

                    // Create log entry
                    $logId = DB::table('employee_file_copy_logs')->insertGetId([
                        'JAId' => $JAId,
                        'JCId' => $JCId,
                        'EmpCode' => $EmpCode,
                        'file_path' => $sourcePath,
                        'destination_path' => $destinationPath,
                        'file_type' => $file['file_type'],
                        'status' => 'pending',
                        'source_bucket' => $sourceDisk,
                        'destination_bucket' => $destDisk,
                        'created_by' => $userId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    // Check if file exists in source bucket
                    if (Storage::disk($sourceDisk)->exists($sourcePath)) {
                        // Get file contents from source
                        $fileContents = Storage::disk($sourceDisk)->get($sourcePath);

                        // Put file in destination bucket
                        Storage::disk($destDisk)->put($destinationPath, $fileContents);

                        // Set file visibility to public
                        Storage::disk($destDisk)->setVisibility($destinationPath, 'public');

                        // Update log entry as success
                        DB::table('employee_file_copy_logs')->where('id', $logId)->update([
                            'status' => 'success',
                            'copied_at' => now(),
                            'updated_at' => now(),
                        ]);

                        $copiedFiles[] = [
                            'source' => $sourcePath,
                            'destination' => $destinationPath,
                            'type' => $file['file_type'],
                        ];

                        Log::info("S3 Copy [{$file['file_type']}]: {$sourcePath} -> {$destinationPath} (disk: {$destDisk})");
                    } else {
                        DB::table('employee_file_copy_logs')->where('id', $logId)->update([
                            'status' => 'failed',
                            'error_message' => 'File not found in source bucket',
                            'updated_at' => now(),
                        ]);

                        $failedFiles[] = [
                            'source' => $sourcePath,
                            'type' => $file['file_type'],
                            'reason' => 'File not found in source bucket',
                        ];

                        Log::warning("S3 Copy [{$file['file_type']}]: File not found - {$sourcePath}");
                    }
                } catch (\Exception $e) {
                    if ($logId) {
                        DB::table('employee_file_copy_logs')->where('id', $logId)->update([
                            'status' => 'failed',
                            'error_message' => $e->getMessage(),
                            'updated_at' => now(),
                        ]);
                    }

                    $failedFiles[] = [
                        'source' => $file['source_dir'].$file['source_filename'],
                        'type' => $file['file_type'],
                        'reason' => $e->getMessage(),
                    ];

                    Log::error("S3 Copy [{$file['file_type']}]: Failed - ".$e->getMessage());
                }
            }

            return [
                'success' => true,
                'copied_count' => count($copiedFiles),
                'failed_count' => count($failedFiles),
                'copied_files' => $copiedFiles,
                'failed_files' => $failedFiles,
            ];

        } catch (\Exception $e) {
            Log::error("Error in copyEmployeeFilesToHrimsS3 for EmpCode: {$EmpCode}. Error: ".$e->getMessage());

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'copied_count' => 0,
                'failed_count' => 0,
            ];
        }
    }

    /**
     * Display file copy logs admin page
     */
    public function fileCopyLogs(Request $request)
    {
        $query = DB::table('employee_file_copy_logs as logs')
            ->leftJoin('jobcandidates as jc', 'logs.JCId', '=', 'jc.JCId')
            ->select(
                'logs.*',
                DB::raw("CONCAT(jc.FName, ' ', COALESCE(jc.MName, ''), ' ', jc.LName) as candidate_name")
            );

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('logs.status', $request->status);
        }

        // Filter by EmpCode
        if ($request->has('emp_code') && $request->emp_code != '') {
            $query->where('logs.EmpCode', 'like', '%'.$request->emp_code.'%');
        }

        // Filter by file type
        if ($request->has('file_type') && $request->file_type != '') {
            $query->where('logs.file_type', 'like', '%'.$request->file_type.'%');
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('logs.created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('logs.created_at', '<=', $request->date_to);
        }

        // Order by latest first
        $query->orderBy('logs.created_at', 'desc');

        $logs = $query->paginate(50);

        // Get statistics
        $stats = [
            'total' => DB::table('employee_file_copy_logs')->count(),
            'success' => DB::table('employee_file_copy_logs')->where('status', 'success')->count(),
            'failed' => DB::table('employee_file_copy_logs')->where('status', 'failed')->count(),
            'pending' => DB::table('employee_file_copy_logs')->where('status', 'pending')->count(),
        ];

        return view('admin.file_copy_logs', compact('logs', 'stats'));
    }

    /**
     * Retry a single failed file copy
     */
    public function retryFileCopy(Request $request, $logId)
    {
        try {
            $log = DB::table('employee_file_copy_logs')->where('id', $logId)->first();

            if (!$log) {
                return response()->json(['status' => 400, 'msg' => 'Log entry not found']);
            }

            $sourceDisk = $log->source_bucket;
            $destinationDisk = $log->destination_bucket;
            $sourcePath = $log->file_path;
            $destinationPath = $log->destination_path;

            if (empty($destinationPath)) {
                return response()->json(['status' => 400, 'msg' => 'Destination path not found in log. This entry was created before the fix. Please re-transfer the employee.']);
            }

            // Check if file exists in source bucket
            if (!Storage::disk($sourceDisk)->exists($sourcePath)) {
                DB::table('employee_file_copy_logs')->where('id', $logId)->update([
                    'status' => 'failed',
                    'error_message' => 'File not found in source bucket',
                    'retry_count' => $log->retry_count + 1,
                    'last_retry_at' => now(),
                    'updated_at' => now(),
                ]);

                return response()->json(['status' => 400, 'msg' => 'File not found in source bucket']);
            }

            // Copy file from source to destination
            $fileContents = Storage::disk($sourceDisk)->get($sourcePath);
            Storage::disk($destinationDisk)->put($destinationPath, $fileContents);
            Storage::disk($destinationDisk)->setVisibility($destinationPath, 'public');

            // Update log as success
            DB::table('employee_file_copy_logs')->where('id', $logId)->update([
                'status' => 'success',
                'copied_at' => now(),
                'error_message' => null,
                'retry_count' => $log->retry_count + 1,
                'last_retry_at' => now(),
                'updated_at' => now(),
            ]);

            Log::info("File copy retry successful: {$sourcePath} -> {$destinationPath} (Log ID: {$logId})");

            return response()->json(['status' => 200, 'msg' => 'File copied successfully']);

        } catch (\Exception $e) {
            // Update retry count and error
            DB::table('employee_file_copy_logs')->where('id', $logId)->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
                'retry_count' => DB::raw('retry_count + 1'),
                'last_retry_at' => now(),
                'updated_at' => now(),
            ]);

            Log::error("File copy retry failed (Log ID: {$logId}). Error: " . $e->getMessage());

            return response()->json(['status' => 400, 'msg' => 'Error: ' . $e->getMessage()]);
        }
    }

    /**
     * Retry all failed file copies for a specific employee
     */
    public function retryAllFailedForEmployee(Request $request, $empCode)
    {
        try {
            $failedLogs = DB::table('employee_file_copy_logs')
                ->where('EmpCode', $empCode)
                ->where('status', 'failed')
                ->get();

            if ($failedLogs->count() == 0) {
                return response()->json(['status' => 400, 'msg' => 'No failed files found for this employee']);
            }

            $successCount = 0;
            $failedCount = 0;

            foreach ($failedLogs as $log) {
                $result = $this->retryFileCopy($request, $log->id);
                $resultData = json_decode($result->getContent(), true);

                if ($resultData['status'] == 200) {
                    $successCount++;
                } else {
                    $failedCount++;
                }
            }

            return response()->json([
                'status' => 200,
                'msg' => "Retry complete: {$successCount} succeeded, {$failedCount} failed",
                'success_count' => $successCount,
                'failed_count' => $failedCount,
            ]);

        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'msg' => 'Error: '.$e->getMessage()]);
        }
    }

    /**
     * TEST ONLY: Test file copy without any database insertions
     * URL: /test-file-copy/{JAId}
     * Remove this method after testing
     */
    public function testFileCopyOnly($JAId)
    {
        try {
            $jobapply = jobapply::where('JAId', $JAId)->first();
            if (! $jobapply) {
                return '<h2 style="color:red;">JAId '.$JAId.' not found</h2>';
            }

            $JCId = $jobapply->JCId;
            $EmpCode = CandidateJoining::where('JAId', $JAId)->value('EmpCode');
            $CompanyId = OfferLetter::where('JAId', $JAId)->value('Company');

            if (! $EmpCode) {
                return '<h2 style="color:red;">EmpCode not found for JAId: '.$JAId.'</h2>';
            }

            $result = $this->copyEmployeeFilesToHrimsS3($JAId, $JCId, $EmpCode);

            // Build HTML output
            $html = '<!DOCTYPE html><html><head><title>File Copy Test - JAId: '.$JAId.'</title>';
            $html .= '<style>
                body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
                .card { background: white; border-radius: 8px; padding: 20px; margin-bottom: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
                .header { display: flex; gap: 15px; flex-wrap: wrap; margin-bottom: 20px; }
                .stat { padding: 15px 25px; border-radius: 8px; color: white; font-size: 18px; }
                .stat-info { background: #3498db; }
                .stat-success { background: #27ae60; }
                .stat-danger { background: #e74c3c; }
                table { width: 100%; border-collapse: collapse; }
                th, td { padding: 10px 12px; text-align: left; border-bottom: 1px solid #eee; font-size: 14px; }
                th { background: #f8f9fa; font-weight: 600; }
                .badge { padding: 3px 10px; border-radius: 12px; font-size: 12px; color: white; }
                .badge-success { background: #27ae60; }
                .badge-danger { background: #e74c3c; }
                .path { font-family: monospace; font-size: 12px; color: #555; word-break: break-all; }
            </style></head><body>';

            $html .= '<h1>S3 File Copy Test Result</h1>';

            // Info badges
            $html .= '<div class="header">';
            $html .= '<div class="stat stat-info">JAId: '.$JAId.'</div>';
            $html .= '<div class="stat stat-info">JCId: '.$JCId.'</div>';
            $html .= '<div class="stat stat-info">EmpCode: '.$EmpCode.'</div>';
            $html .= '<div class="stat stat-info">CompanyId: '.$CompanyId.'</div>';
            $html .= '<div class="stat stat-success">Copied: '.$result['copied_count'].'</div>';
            $html .= '<div class="stat stat-danger">Failed: '.$result['failed_count'].'</div>';
            $html .= '</div>';

            // Copied files table
            if (count($result['copied_files']) > 0) {
                $html .= '<div class="card"><h3 style="color:#27ae60;">Copied Files</h3><table>';
                $html .= '<tr><th>#</th><th>Type</th><th>Source Path</th><th>Destination Path</th><th>Status</th></tr>';
                foreach ($result['copied_files'] as $i => $file) {
                    $html .= '<tr>';
                    $html .= '<td>'.($i + 1).'</td>';
                    $html .= '<td><strong>'.$file['type'].'</strong></td>';
                    $html .= '<td class="path">'.$file['source'].'</td>';
                    $html .= '<td class="path">'.$file['destination'].'</td>';
                    $html .= '<td><span class="badge badge-success">Copied</span></td>';
                    $html .= '</tr>';
                }
                $html .= '</table></div>';
            }

            // Failed files table
            if (count($result['failed_files']) > 0) {
                $html .= '<div class="card"><h3 style="color:#e74c3c;">Failed Files</h3><table>';
                $html .= '<tr><th>#</th><th>Type</th><th>Source Path</th><th>Reason</th><th>Status</th></tr>';
                foreach ($result['failed_files'] as $i => $file) {
                    $html .= '<tr>';
                    $html .= '<td>'.($i + 1).'</td>';
                    $html .= '<td><strong>'.$file['type'].'</strong></td>';
                    $html .= '<td class="path">'.$file['source'].'</td>';
                    $html .= '<td style="color:red;">'.$file['reason'].'</td>';
                    $html .= '<td><span class="badge badge-danger">Failed</span></td>';
                    $html .= '</tr>';
                }
                $html .= '</table></div>';
            }

            if ($result['copied_count'] == 0 && $result['failed_count'] == 0) {
                $html .= '<div class="card"><h3>No files found to copy for this candidate.</h3></div>';
            }

            $html .= '</body></html>';

            return $html;

        } catch (\Exception $e) {
            return '<h2 style="color:red;">Error: '.$e->getMessage().'</h2><pre>'.$e->getTraceAsString().'</pre>';
        }
    }

    /**
     * Delete a file copy log entry
     */
    public function deleteFileCopyLog($logId)
    {
        try {
            DB::table('employee_file_copy_logs')->where('id', $logId)->delete();

            return response()->json(['status' => 200, 'msg' => 'Log entry deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'msg' => 'Error: '.$e->getMessage()]);
        }
    }
}
