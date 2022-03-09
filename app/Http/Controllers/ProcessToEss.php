<?php

namespace App\Http\Controllers;

use App\Models\CandidateJoining;
use App\Models\jobapply;
use App\Models\OfferLetter;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use function App\Helpers\getCollegeById;
use function App\Helpers\getDistrictName;
use function App\Helpers\getEducationById;
use function App\Helpers\getSpecializationbyId;
use function App\Helpers\getStateName;

class ProcessToEss extends Controller
{


    public function processDataToEss(Request $request)
    {
        DB::beginTransaction();

        $connection = DB::connection('mysql2');
        $JAId = $request->JAId;
        $JCId = jobapply::where('JAId', $JAId)->first()->JCId;
        $EmpCode = CandidateJoining::where('JAId', $JAId)->value('EmpCode');
        $CompanyId = OfferLetter::where('JAId', $JAId)->value('Company');

        $ctc_query = DB::table('candidate_ctc')->where('JAId', $JAId)->first();
        $education_query = DB::table('candidateeducation')->where('JCId', $JCId)->get();
        $family_query = DB::table('jf_family_det')->where('JCId', $JCId)->get();
        $lang_query = DB::table('jf_language')->where('JCId', $JCId)->get();
        $address_query = DB::table('jf_contact_det')->where('JCId', $JCId)->first();
        $elg_query = DB::table('candidate_entitlement')->where('JAId', $JAId)->first();
        $pf_esic_query = DB::table('jf_pf_esic')->where('JCId', $JCId)->first();
        $jobcandidate = DB::table('jobcandidates')->join('jobapply', 'jobapply.JCId', '=', 'jobcandidates.JCId')->join('offerletterbasic', 'offerletterbasic.JAId', '=', 'jobapply.JAId')->leftjoin('candjoining', 'candjoining.JAId', '=', 'jobapply.JAId')->where('jobcandidates.JCId', $JCId)->leftjoin('about_answer', 'about_answer.JCId', 'jobcandidates.JCId')->select('jobcandidates.*', 'offerletterbasic.*', 'candjoining.JoinOnDt', 'candjoining.PositionCode', 'candjoining.PosSeq','candjoining.PosVR', 'about_answer.DLNo', 'about_answer.LValidity')->first();

        $workexp_query = DB::table('jf_work_exp')->where('JCId', $JCId)->get();
        $training_query = DB::table('jf_tranprac')->select('*')->where('JCId', $JCId)->get();
        $pre_ref = DB::table('jf_reference')->where('JCId', $JCId)->where('from', 'Previous Organization')->get();
        $vnr_ref = DB::table('jf_reference')->where('JCId', $JCId)->where('from', 'VNR')->get();





        $SendCTC = $connection->table('employee_ctc')->insert([
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
        ]);

        $edu_array = [];
        foreach ($education_query as $key => $value) {
            $temp = array();
            $temp['EmpCode'] = $EmpCode;
            $temp['CompanyId'] = $CompanyId;
            $temp['Qualification'] = $value->Qualification;
            $temp['Course'] = $value->Course == null ? '' : getEducationById($value->Course);
            $temp['Specialization'] = $value->Specialization == null ? '' : getSpecializationbyId($value->Specialization);
            $temp['Institute'] = $value->Institute == null ? '' : ($value->Institute == 637 ? $value->OtherInstitute : getCollegeById($value->Institute));
            $temp['YearOfPassing'] = $value->YearOfPassing ?? '';
            $temp['CGPA'] = $value->CGPA ?? '';
            $edu_array[] = $temp;
        }

        $SendEducation = $connection->table('employee_education')->insert($edu_array);

        $SendContact = $connection->table('employee_address')->insert([
            'EmpCode' => $EmpCode,
            'CompanyId' => $CompanyId,
            'pre_address' => $address_query->pre_address,
            'pre_state' => getStateName($address_query->pre_state),
            'pre_dist' => getDistrictName($address_query->pre_dist),
            'pre_city' => $address_query->pre_city,
            'pre_pin' => $address_query->pre_pin,
            'perm_address' => $address_query->perm_address,
            'perm_state' => getStateName($address_query->perm_state),
            'perm_dist' => getDistrictName($address_query->perm_dist),
            'perm_city' => $address_query->perm_city,
            'perm_pin' => $address_query->perm_pin,
        ]);

        $SendElg = $connection->table('employee_elg')->insert([
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
        $SendFamily = $connection->table('employee_family')->insert($family_array);

        $language_array = [];
        foreach ($lang_query as $key => $value) {
            $temp = array();
            $temp['EmpCode'] = $EmpCode;
            $temp['CompanyId'] = $CompanyId;
            $temp['language']   = $value->language;
            $temp['read']   = $value->read;
            $temp['write']   = $value->write;
            $temp['speak']   = $value->speak;
            $language_array[] = $temp;
        }

        $SendLanguage = $connection->table('employee_language')->insert($language_array);


        $SendPF = $connection->table('employee_pf')->insert([
            'EmpCode' => $EmpCode,
            'CompanyId' => $CompanyId,
            'UAN' => $pf_esic_query->UAN ?? '',
            'pf_acc_no' => $pf_esic_query->PFNumber ?? '',
            'esic_no' => $pf_esic_query->ESICNumber ?? '',
            'bank_name' => $pf_esic_query->BankName ?? '',
            'branch_name' => $pf_esic_query->BranchName ?? '',
            'acc_number' => $pf_esic_query->AccountNumber ?? '',
            'ifsc_code' => $pf_esic_query->IFSCCode ?? '',
            'pan' => $pf_esic_query->PAN ?? '',
            'passport' => $pf_esic_query->Passport ?? '',
        ]);

        if ($jobcandidate->Professional  == 'P') {
            $work_array = [];
            $work_array[0]['EmpCode'] = $EmpCode;
            $work_array[0]['CompanyId'] = $CompanyId;
            $work_array[0]['company'] = $jobcandidate->PresentCompany;
            $work_array[0]['desgination'] = $jobcandidate->Designation;
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

            $SendWorkExp = $connection->table('employee_workexp')->insert($work_array);

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
            $SendPreRef = $connection->table('employee_preref')->insert($pre_ref_array);
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

                $SendTraining = $connection->table('employee_training')->insert($training_array);
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
                $SendVNRRef = $connection->table('employee_vnrref')->insert($vnr_array);
            }
        }

        $SendGeneral = $connection->table('employee_general')->insert([
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
            'PositionCode' => $jobcandidate->PositionCode ?? '',
            'PosSeq' => $jobcandidate->PosSeq ?? '',
            'PosVR' => $jobcandidate->PosVR ?? '',


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
            'PositionId' => '',
            'CreatedBy' => Auth::user()->id,
            'CreatedDate' => now(),
            'YearId' => '0'


        ]);


        $postData = array();

        $employee_address = $connection->table('employee_address')->where('EmpCode', $EmpCode)->get();
        $employee_address = json_decode(json_encode($employee_address), true);
        $postData['employee_address'] = $employee_address;

        $employee_ctc = $connection->table('employee_ctc')->where('EmpCode', $EmpCode)->get();
        $employee_ctc = json_decode(json_encode($employee_ctc), true);
        $postData['employee_ctc'] = $employee_ctc;

        $employee_education = $connection->table('employee_education')->where('EmpCode', $EmpCode)->get();
        $employee_education = json_decode(json_encode($employee_education), true);
        $postData['employee_education'] = $employee_education;

        $employee_elg = $connection->table('employee_elg')->where('EmpCode', $EmpCode)->get();
        $employee_elg = json_decode(json_encode($employee_elg), true);
        $postData['employee_elg'] = $employee_elg;

        $employee_family = $connection->table('employee_family')->where('EmpCode', $EmpCode)->get();
        $employee_family = json_decode(json_encode($employee_family), true);
        $postData['employee_family'] = $employee_family;

        $employee_general = $connection->table('employee_general')->where('EmpCode', $EmpCode)->get();
        $employee_general = json_decode(json_encode($employee_general), true);
        $postData['employee_general'] = $employee_general;

        $employee_language = $connection->table('employee_language')->where('EmpCode', $EmpCode)->get();
        $employee_language = json_decode(json_encode($employee_language), true);
        $postData['employee_language'] = $employee_language;

        $employee_pf = $connection->table('employee_pf')->where('EmpCode', $EmpCode)->get();
        $employee_pf = json_decode(json_encode($employee_pf), true);
        $postData['employee_pf'] = $employee_pf;

        $employee_preref = $connection->table('employee_preref')->where('EmpCode', $EmpCode)->get();
        $employee_preref = json_decode(json_encode($employee_preref), true);
        $postData['employee_preref'] = $employee_preref;

        $employee_training = $connection->table('employee_training')->where('EmpCode', $EmpCode)->get();
        $employee_training = json_decode(json_encode($employee_training), true);
        $postData['employee_training'] = $employee_training;

        $employee_vnrref = $connection->table('employee_vnrref')->where('EmpCode', $EmpCode)->get();
        $employee_vnrref = json_decode(json_encode($employee_vnrref), true);
        $postData['employee_vnrref'] = $employee_vnrref;

        $employee_workexp = $connection->table('employee_workexp')->where('EmpCode', $EmpCode)->get();
        $employee_workexp = json_decode(json_encode($employee_workexp), true);
        $postData['employee_workexp'] = $employee_workexp;


        $json_response = json_encode($postData);
        $url = 'https://vnrseeds.co.in/hrims/api/recruitmentToEss/get_data_from_rec.php';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_response);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type:application/json'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $rdata = json_decode($result);
        $Status = $rdata->Status;
        if ($Status == 200) {
            DB::commit();
            $query = DB::table('candjoining')->where('JAId', $JAId)->update(['ForwardToESS' => '1']);
            return response()->json(['status' => 200, 'msg' => 'Data Send to ESS Successfully..!!']);
        } else {
            DB::rollBack();
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        }
    }
}
