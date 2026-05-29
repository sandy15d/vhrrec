<?php

namespace App\Http\Controllers;
use App\Helpers\CandidateActivityLog;
use App\Models\jobpost;
use App\Models\jobapply;
use App\Models\screening;
use App\Models\jobcandidate;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Image;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\master_mrf;
class RequisitionController extends Controller
{
     public function candidateRequisitionForm(Request $request,$JCId = null)
    {
        $state_list = DB::table("states")->orderBy('StateName', 'asc')->pluck("StateName", "StateId");
        $district_list = DB::table("master_district")->orderBy('DistrictName', 'asc')->pluck("DistrictName", "DistrictId");
        $education_list = DB::table("master_education")->orderBy('EducationCode', 'asc')->pluck("EducationCode", "EducationId");
        $specialization_list = DB::table("master_specialization")->orderBy('Specialization', 'asc')->pluck("Specialization", "SpId");
        $institute_list = DB::table("master_institute")->orderBy('InstituteName', 'asc')->pluck("InstituteName", "InstituteId");
        $JCId = $JCId ?? $request->JCId;
        
        return view('jobportal.requisition.candidate_requisition_form', compact('JCId','state_list', 'district_list', 'education_list', 'specialization_list', 'institute_list'));
        
    }
    public function SaveRequisitionPersonalInfo(Request $request)
    {
        try {

            $JCId = $request->JCId ?? null;

            $Title = $request->Title;
            $FName = $request->FName;
            $MName = $request->MName ?? null;
            $LName = $request->LName ?? null;
            $DOB = $request->DOB;
            $Gender = $request->Gender;
            $Nationality = $request->Nationality;
            $Religion = $request->Religion;
            $OtherReligion = $request->OtherReligion ?? null;
            $Category = $request->Category;
            $OtherCategory = $request->OtherCategory ?? null;
            $MaritalStatus = $request->MaritalStatus;
            $MarriageDate = $request->MarriageDate ?? null;
            $SpouseName = $request->SpouseName ?? null;

            $CandidateImage = $request->old_image ?? null;

            if ($request->hasFile('CandidateImage')) {

                $CandidateImage = $FName . '_' . time() . '.' . $request->CandidateImage->extension();

                // local
                // $request->CandidateImage->storeAs(
                //     'VVNR_Recruitment/Picture',
                //     $CandidateImage,
                //     'public'
                // );

                // live
                $request->CandidateImage->storeAs(
                    'VVNR_Recruitment/Picture',
                    $CandidateImage,
                    's3'
                );
            }

            $data = [

                'Title' => $Title,
                'FName' => $FName,
                'MName' => $MName,
                'LName' => $LName,
                'DOB' => $DOB,
                'Gender' => $Gender,
                'Nationality' => $Nationality,
                'Religion' => $Religion,
                'OtherReligion' => $OtherReligion,
                'Caste' => $Category,
                'OtherCaste' => $OtherCategory,
                'MaritalStatus' => $MaritalStatus,
                'MarriageDate' => $MarriageDate,
                'SpouseName' => $SpouseName,
                'CandidateImage' => $CandidateImage,
                'isRequisition' => 1
            ];

            if ($JCId != null) {

                DB::table('jobcandidates')
                    ->where('JCId', $JCId)
                    ->update($data);

            } else {

                $JCId = DB::table('jobcandidates')
                    ->insertGetId($data);
            }

            return response()->json([
                'status' => 200,
                'msg' => 'Saved Successfully',
                'JCId' => $JCId
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => 500,
                'msg' => $e->getMessage(),
                'line' => $e->getLine()
            ]);
        }
    }

    public function SaveRequisitionContact(Request $request)
    {

    try {
        $JCId = $request->JCId;
            $Email = $request->Email1;
            $Email2 = $request->Email2 ?? null;
            $Contact = $request->Contact1;
            $Contact2 = $request->Contact2 ?? null;
            $PreAddress = $request->PreAddress;
            $PreState = $request->PreState;
            $PreDistrict = $request->PreDistrict;
            $PreCity = $request->PreCity;
            $PrePin = $request->PrePin;
            $PermAddress = $request->PermAddress;
            $PermState = $request->PermState;
            $PermDistrict = $request->PermDistrict;
            $PermCity = $request->PermCity;
            $PermPin = $request->PermPin;

            $query = DB::table('jobcandidates')
                ->where('JCId', $JCId)
                ->update(
                    [
                        'Email' => $Email,
                        'Email2' => $Email2,
                        'Phone' => $Contact,
                        'Phone2' => $Contact2,
                        'LastUpdated' => now(),

                    ]
                );

            $chk = DB::table('jf_contact_det')->where('JCId', $JCId)->first();

            if ($chk == null) {
                $query1 = DB::table('jf_contact_det')
                    ->insert(
                        [
                            'JCId' => $JCId,
                            'pre_address' => $PreAddress,
                            'pre_state' => $PreState,
                            'pre_dist' => $PreDistrict,
                            'pre_city' => $PreCity,
                            'pre_pin' => $PrePin,
                            'perm_address' => $PermAddress,
                            'perm_state' => $PermState,
                            'perm_dist' => $PermDistrict,
                            'perm_city' => $PermCity,
                            'perm_pin' => $PermPin,
                            'LastUpdated' => now(),

                        ]
                    );
            } else {
                $query1 = DB::table('jf_contact_det')
                    ->where('JCId', $JCId)
                    ->update(
                        [
                            'pre_address' => $PreAddress,
                            'pre_state' => $PreState,
                            'pre_dist' => $PreDistrict,
                            'pre_city' => $PreCity,
                            'pre_pin' => $PrePin,
                            'perm_address' => $PermAddress,
                            'perm_state' => $PermState,
                            'perm_dist' => $PermDistrict,
                            'perm_city' => $PermCity,
                            'perm_pin' => $PermPin,
                            'LastUpdated' => now(),

                        ]
                    );
            }

            if (isset($request->EmgName1)) {
                $EmgName1 = $request->EmgName1;
                $EmgRel1 = $request->EmgRel1;
                $EmgContact1 = $request->EmgContact1;

                $EmgName2 = $request->EmgName2 ?? null;
                $EmgRel2 = $request->EmgRel2 ?? null;
                $EmgContact2 = $request->EmgContact2 ?? null;
                $sql = DB::table('jf_contact_det')->where('JCId', $JCId)->update(
                    [
                        'cont_one_name' => $EmgName1,
                        'cont_one_relation' => $EmgRel1,
                        'cont_one_number' => $EmgContact1,
                        'cont_two_name' => $EmgName2,
                        'cont_two_relation' => $EmgRel2,
                        'cont_two_number' => $EmgContact2,
                        'LastUpdated' => now(),

                    ]
                );
            }

            if (!$query || !$query1) {
                return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
            } else {
                return response()->json(['status' => 200, 'msg' => 'Data has been changed successfully']);
            }
    } catch (\Throwable $e) {
        return response()->json([
                'status' => 500,
                'msg' => $e->getMessage(),
                'line' => $e->getLine()
            ]);
    }
            
    }

     public function RequisitionFormSubmit(Request $request)
    {
        $JCId = $request->JCId;
        $query = DB::table('jobcandidates')->where('JCId', $JCId)->update(
            [
                'FinalSubmit' => '1',
                'LastUpdated' => now()
            ]
        );
        $sql = DB::table('jobcandidates')
            ->Join('jobapply', 'jobcandidates.JCId', '=', 'jobapply.JCId')
            ->Join('jobpost', 'jobapply.JPId', '=', 'jobpost.JPId')
            ->where('jobcandidates.JCId', $JCId)
            ->select('jobpost.CreatedBy', 'jobcandidates.FName', 'jobcandidates.Aadhaar')->first();
        // $CreatedBy = $sql->CreatedBy;
        // $FName = $sql->FName;
        // UserNotification::notifyUser($CreatedBy, 'Joining Form', $FName . ' has submitted the joining form');
        if ($query) {
            // CandidateActivityLog::addToCandLog($JCId, $sql->Aadhaar, 'Requisition Form has been submitted');
            return response()->json(['status' => 200, 'msg' => 'Requisition Form has been submitted successfully']);
        } else {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        }
    }


    public function requisitionCandidateApplication(Request $request)
    {
        $months = [
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
        ];
        $company_list = DB::table("core_company")->orderBy('company_code', 'desc')->pluck("company_code", "id");

        $education_list = DB::table("master_education")
            ->where('Status', 'A')
            ->orderBy('EducationCode', 'asc')
            ->pluck("EducationCode", "EducationId");

        $Year = $request->Year;
        $Month = $request->Month;
        $Gender = $request->Gender;
        $Education = $request->Education;
        $Name = $request->Name;
        $Company = $request->Company;
        $Department = $request->Department;
        $MRFMapped = $request->mrf_mapped;

        $candidateQuery = DB::table('jobcandidates')
            ->where('jobcandidates.Nationality', session('Set_Country'))->where('isRequisition',1);

        if ($Company != '' || $Department != '') {

            $candidateQuery->whereExists(function ($q) use ($Company, $Department) {
                $q->select(DB::raw(1))
                    ->from('jobapply')
                    ->whereColumn('jobapply.JCId', 'jobcandidates.JCId');

                if ($Company != '') {
                    $q->where('jobapply.Company', $Company);
                }

                if ($Department != '') {
                    $q->where('jobapply.Department', $Department);
                }
            });
        }
        if ($MRFMapped == 'yes') {

            $candidateQuery->whereExists(function ($q) {
                $q->select(DB::raw(1))
                    ->from('jobapply')
                    ->whereColumn('jobapply.JCId', 'jobcandidates.JCId');
            });

        } elseif ($MRFMapped == 'no') {

            $candidateQuery->whereNotExists(function ($q) {
                $q->select(DB::raw(1))
                    ->from('jobapply')
                    ->whereColumn('jobapply.JCId', 'jobcandidates.JCId');
            });
        }

        if ($Year != '') {
            $candidateQuery->whereBetween('jobcandidates.CreatedTime', [
                $Year . '-01-01',
                $Year . '-12-31'
            ]);
        }

        if ($Month != '') {
            $filterYear = $Year != '' ? $Year : date('Y');

            $candidateQuery->whereMonth('jobcandidates.CreatedTime', $Month)
                ->whereYear('jobcandidates.CreatedTime', $filterYear);
        }

        if ($Gender != '') {
            $candidateQuery->where("jobcandidates.Gender", $Gender);
        }

        if ($Education != '') {
            $candidateQuery->where("jobcandidates.Education", $Education);
        }

        if ($Name != '') {
            $candidateQuery->where(function ($q) use ($Name) {
                $q->where("jobcandidates.FName", 'like', "%$Name%")
                ->orWhere("jobcandidates.MName", 'like', "%$Name%")
                ->orWhere("jobcandidates.LName", 'like', "%$Name%");
            });
        }
        

        $candidate_list = $candidateQuery
            ->select(
                'jobcandidates.JCId',
                'jobcandidates.FName',
                'jobcandidates.MName',
                'jobcandidates.LName',
                'jobcandidates.ReferenceNo',
                'jobcandidates.FatherName',
                'jobcandidates.Email',
                'jobcandidates.DOB',
                'jobcandidates.Phone',
                'jobcandidates.City',
                'jobcandidates.Education',
                'jobcandidates.Specialization',
                'jobcandidates.Professional',
                'jobcandidates.JobStartDate',
                'jobcandidates.JobEndDate',
                'jobcandidates.PresentCompany',
                'jobcandidates.Designation',
                'jobcandidates.Verified',
                'jobcandidates.CandidateImage',
                'jobcandidates.BlackList',
                'jobcandidates.BlackListRemark',
                'jobcandidates.UnBlockRemark',
                'jobcandidates.Gender',
                'jobcandidates.Nationality',
                'jobcandidates.CreatedTime',
            )
            ->orderBy('jobcandidates.CreatedTime', 'desc');

        $total_candidate = $candidate_list->count();

        $candidate_list = $candidate_list->paginate(10);

        $candidate_list->appends([
            'Company' => $Company,
            'Department' => $Department,
            'Year' => $Year,
            'Month' => $Month,
            'Gender' => $Gender,
            'Education' => $Education,
            'Name' => $Name,
            'mrf_mapped' => $MRFMapped
        ]);

        $total_available = DB::table('jobcandidates')
            ->where('Nationality', session('Set_Country'))
            ->count();

        $total_pending_mrf = DB::table('jobcandidates')
            ->where('jobcandidates.Nationality', session('Set_Country'))
            ->where('jobcandidates.isRequisition', 1)
            ->whereNotExists(function ($q) {
                $q->select(DB::raw(1))
                    ->from('jobapply')
                    ->whereColumn('jobapply.JCId', 'jobcandidates.JCId');
            })
        ->count();
        $job = jobpost::query();
        if (Auth::user()->role == 'R') {
            $job->where('jobpost.CreatedBy', Auth::user()->id);
        }
        $jobpost_list = $job->join('manpowerrequisition', 'manpowerrequisition.MRFId', '=', 'jobpost.MRFId')->select('JPId', 'jobpost.JobCode')
            ->where('manpowerrequisition.CountryId', session('Set_Country'))
            ->where('jobpost.Status', 'Open')
            ->where('JobPostType', 'Regular')
            ->get();
        

        return view('jobportal.requisition.job_applications', compact(
            'months',
            'education_list',
            'candidate_list',
            'total_candidate',
            'total_available',
            'company_list',
            'jobpost_list',
            'total_pending_mrf'
        ));
    }

    public function MapRequisitionCandidateToJob(Request $request)
{
    try {
        $JCId = $request->AddJobPost_JCId;
    $JPId = $request->JPId;

    $candidate = jobcandidate::find($JCId);

    if (!$candidate) {
        return response()->json([
            'status' => 400,
            'msg' => 'Candidate not found.'
        ]);
    }

    $jobpost = jobpost::find($JPId);

    if (!$jobpost) {
        return response()->json([
            'status' => 400,
            'msg' => 'Job post not found.'
        ]);
    }

    $Company = $jobpost->CompanyId;
    $Department = $jobpost->DepartmentId;
    $Designation = $jobpost->DesigId;


    $title = $jobpost->Title;
    $Aadhaar = $candidate->Aadhaar;

    DB::table('jobcandidates')
        ->where('JCId', $JCId)
        ->update([
            'ReferenceNo' => rand(1000, 9999) . date('Y') . $JCId
        ]);

    $JAId = DB::table('jobapply')->insertGetId([
        'JCId' => $JCId,
        'JPId' => $JPId,
        'Type' => 'HR_ManualEntry',
        'ResumeSource' => '1',
        'Company' => $Company,
        'Department' => $Department,
        'ApplyDate' => date('Y-m-d'),
        'Status' => 'Selected',
        'SelectedBy' => '1',
        'FwdTechScr' => 'Yes',
        'CreatedBy' => '1',
    ]);

    DB::table('screening')->insert([
        'JAId' => $JAId,
        'ReSentForScreen' => date('Y-m-d'),
        'ScrCmp' => $Company,
        'ScrDpt' => $Department,
        'ScreeningBy' => '1',
        'ResScreened' => date('Y-m-d'),
        'ScreenStatus' => 'Shortlist',
        'InterviewMode' => 'Offline',
        'SendInterMail' => 'No',
        'IntervStatus' => 'Selected',
        'SelectedForC' => $Company,
        'SelectedForD' => $Department,
        'CreatedTime' => date('Y-m-d'),
        'CreatedBy' => '1',
    ]);

     $insert_offerbasic = DB::table('offerletterbasic')->insert([
                'JAId' => $JAId,
                'Company' => $Company,
                'Department' => $Department,
                'Designation' => $Designation,
                'LtrNo' => '',
                'LtrDate' => date('Y-m-d'),
                'TempS' => '0',
                'T_StateHq' => '0',
                'T_LocationHq' => '0',
                'TempM' => '0',
                'FixedS' => '1',
                'Functional_R' => '0',
                'Functional_Dpt' => '0',
                'F_ReportingManager' => '0',

                'Admins_R' => '1',
                'Admins_Dpt' => '0',
                'SigningAuth' => 'General Manager HR',
                'OfferLtrGen' => '1',
                'OfferLetterSent' => 'No',
                'JoiningFormSent' => 'No',
                'Answer' => 'Accepted',
                'RejReason' => '',
                'CreatedTime' => date('Y-m-d'),
                'CreatedBy' => '1280',
            ]);

    return response()->json([
        'status' => 200,
        'msg' => 'Candidate Successfully Mapped to JobPost.'
    ]);
    } catch (\Throwable $e) {
        return response()->json([
            'status' => 500,
            'msg' => $e->getMessage(),
            'line' => $e->getLine()
        ]);
    }
}
 


   public function requisition_candidate_detail()
   {
        $state_list = DB::table("states")->orderBy('StateName', 'asc')->pluck("StateName", "StateId");
        $district_list = DB::table("master_district")->orderBy('DistrictName', 'asc')->pluck("DistrictName", "DistrictId");
        $education_list = DB::table("master_education")->orderBy('EducationCode', 'asc')->pluck("EducationCode", "EducationId");
        $specialization_list = DB::table("master_specialization")->orderBy('Specialization', 'asc')->pluck("Specialization", "SpId");
        $institute_list = DB::table("master_institute")->orderBy('InstituteName', 'asc')->pluck("InstituteName", "InstituteId");
        $company_list = DB::table("core_company")->orderBy('id', 'asc')->pluck("company_code", "id");
        $department_list = DB::table("core_department")->orderBy('department_name', 'asc')->pluck("department_name", "id");

        return view('jobportal.requisition.candidate_detail', compact('state_list', 'district_list', 'education_list', 'institute_list', 'specialization_list', 'company_list', 'department_list'));
    
   }



}
