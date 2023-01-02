<?php

namespace App\Imports;

use App\Models\jobcandidate;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use function App\Helpers\getStateIdByName;

class UserImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)

    {
        foreach ($rows as $row) {

            $JPId = DB::table('jobpost')->where('DesigId', $row['desigid'])->select('JPId')->first();
            $JPId = $JPId->JPId;

            $insert_jobcandidate = DB::table('jobcandidates')->insert([
                'Title' => $row['title'],
                'FName' => $row['fname'],
                'MName' => $row['mname'],
                'LName' => $row['lname'],
                'FatherTitle' => $row['fathertitle'] ?? 'Mr.',
                'FatherName' => $row['fathername'] ?? '',
                'AddressLine1' => $row['addressline1'],
                'City' => $row['city'],
                'District' => $row['district'],
                'State' => getStateIdByName($row['state']),
                'PinCode' => $row['pincode'],
                'Email' => $row['email'],
                'Phone' => $row['phone'],
                'Nationality' => '11',
                'Aadhaar' => $row['aadhaar'],
            ]);
            $JCId = DB::getPdo()->lastInsertId();

            $update_reference = DB::table('jobcandidates')->where('JCId', $JCId)->update(['ReferenceNo' => rand(1000, 9999) . date('Y') . $JCId]);

            $insert_jobapply = DB::table('jobapply')->insert([
                'JCId' => $JCId,
                'JPId' => $JPId,
                'Type' => 'HR_ManualEntry',
                'ResumeSource' => '1',
                'Company' => $row['company'],
                'Department' => $row['department'],
                'ApplyDate' => date('Y-m-d'),
                'Status' => 'Selected',
                'SelectedBy' => '1',
                'FwdTechScr' => 'Yes',
                'CreatedBy' => '1',
            ]);
            $JAId = DB::getPdo()->lastInsertId();

            $insert_screening = DB::table('screening')->insert([
                'JAId' => $JAId,
                'ReSentForScreen' => date('Y-m-d'),
                'ScrCmp' => $row['company'],
                'ScrDpt' => $row['department'],
                'ScreeningBy' => '1',
                'ResScreened' => date('Y-m-d'),
                'ScreenStatus' => 'Shortlist',
                'InterviewMode' => 'Offline',
                'SendInterMail' => 'No',
                'IntervStatus' => 'Selected',
                'SelectedForC' => $row['company'],
                'SelectedForD' => $row['department'],
                'CreatedTime' =>  date('Y-m-d'),
                'CreatedBy' => '1',
            ]);

            $insert_contact = DB::table('jf_contact_det')->insert([
                'JCId' => $JCId,
                'perm_address' => $row['addressline1'],
                'perm_state' => getStateIdByName($row['state']),
                'perm_dist' => $row['district'],
                'perm_city' => $row['city'],
                'perm_pin' => $row['pincode'],
                'LastUpdated' => date('Y-m-d'),
            ]);

            $insert_offerbasic = DB::table('offerletterbasic')->insert([
                'JAId' => $JAId,
                'Company' => $row['company'],
                'Department' => $row['department'],
                'Grade' => $row['gradeid'],
                'Designation' => $row['desigid'],
                'LtrNo' => '',
                'LtrDate' => date('Y-m-d'),
                'TempS' => '0',
                'T_StateHq' => '0',
                'T_LocationHq' => '0',
                'TempM' => '0',
                'FixedS' => '1',
                'F_StateHq' => $row['hqstate'],
                'F_LocationHq' => $row['hq'],
                'Functional_R' => '0',
                'Functional_Dpt' => '0',
                'F_ReportingManager' => '0',

                'Admins_R' => '1',
                'Admins_Dpt' => '0',
                'A_ReportingManager' => $row['reporting'],
                'CTC' => $row['ctc'],
                'ServiceCondition' => ($row['date_diff'] == 12) ? 'Training' : 'Probation',
                'NoticePeriod' => null,
                'ServiceBond' => $row['service_bond'],
                'ServiceBondYears' => $row['service_bond_year'],
                'ServiceBondRefund' => $row['refund'],
                'PreMedicalCheckUp' => 'No',
                'SigningAuth' => 'General Manager HR',
                'OfferLtrGen' => '1',
                'OfferLetterSent' => 'Yes',
                'JoiningFormSent' => 'Yes',
                'Answer' => 'Accepted',
                'RejReason' => '',
                'CreatedTime' => date('Y-m-d'),
                'CreatedBy' => '1280',
            ]);

            $insert_ctc = DB::table('candidate_ctc')->insert([
                'JAId' => $JAId,
                'ctcLetterNo' => 'aaaa',
                'ctc_date' => date('Y-m-d'),
                'basic' => $row['basic'],
                'hra' => $row['hra'],
                'bonus' => $row['bonus'],
                'special_alw' => $row['special_alw'],
                'grsM_salary' => $row['month_gross'],
                'emplyPF' => $row['employeepf'],
                'emplyESIC' => $row['esic'],
                'netMonth' => $row['netmonth'],
                'lta' => '0',
                'childedu' => '0',
                'anualgrs' => $row['gross_annual'],
                'gratuity' => $row['gratuity'],
                'emplyerPF' => $row['employerpf'],
                'emplyerESIC' => $row['employeresic'],
                'medical' => $row['insurance_premium'],
                'total_ctc' => $row['ctc'],
            ]);

            $insert_ent = DB::table('candidate_entitlement')->insert([
                'JAId' => $JAId,
                'EntLetterNo' => 'aaaa',
                'EntDate' => date('Y-m-d'),
                'LoadCityA' => $row['loadg_a'],
                'LoadCityB' => $row['loadg_b'],
                'LoadCityC' => $row['loadg_c'],
                'DAOut' => $row['da_out'] ?? '',
                'DAHq' => $row['da'] ?? '',
                'TwoWheel' => '',
                'FourWheel' => '',
                'Train' => $row['travel_mode'] == 'Train' ? 'Y' : 'N',
                'Train_Class' => $row['travel_class'] ?? '',
                'Flight' => 'N',
                'Flight_Class' => '',
                'Flight_Remark' => '',
                'Mobile' => '',
                'MExpense' => $row['mob_exp'] ?? '',
                'MTerm' => $row['prd'] == 'Mnt' ? 'Monthly' : '',
                'GPRS' => $row['gps'],
                'Laptop' => '',
                'HealthIns' => $row['health_insurance'],
                'Helth_CheckUp' => '',
                'TravelLine' => '0',
                'TwoWheelLine' => '0',
                'FourWheelLine' => '0',
                'Created_on' => date('Y-m-d'),
                'Created_by' => '1280',





            ]);

            $insert_joining = DB::table('candjoining')->insert([
                'JAId' => $JAId,
                'LinkValidityStart' => date('Y-m-d'),
                'LinkValidityEnd' => date('Y-m-d'),
                'LinkStatus' => 'Active',
                'JoinOnDt' => $row['appointment_date'],
                'Place' => 'Raipur',
                'Date' => $row['appointment_date'],
                'Answer' => 'Accepted',
                'RefCheck' => 'No',
                'PositionCode' => '',
                'PosSeq' => '',
                'PosVR' => '',
                'EmpCode' => $row['empcode'],
                'Verification' => 'Verified',
                'Joined' => 'Yes',
                'ForwardToEss' => 'Yes',
                'CreatedTime' => date('Y-m-d H:i:s'),
                'CreatedBy' => '1280',
            ]);

            $insert_appoint = DB::table('appointing')->insert([
                'JAId' => $JAId,
                'A_Date' => $row['appointment_date'],
                'AppLetterNo' => $row['app_ltr'],
                'AppLtrGen' => 'Yes',
                'Agr_Date' => $row['appointment_date'],
                'AgrLtrNo' => $row['app_ltr'],
                'AgrLtrGen' => 'Yes',
                'B_Date' => null,
                'BLtrNo' => null,
                'BLtrGen' => null,
                'CreatedTime' => date('Y-m-d H:i:s'),
                'CreatedBy' => '1280',
            ]);
        }
    }
}
