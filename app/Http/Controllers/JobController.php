<?php

namespace App\Http\Controllers;

use App\Helpers\CandidateActivityLog;
use App\Http\Controllers\Controller;
use App\Mail\AppSubOTPMail;
use App\Mail\AppSuccessMaill;
use App\Models\jobapply;
use App\Models\jobcandidate;

use App\Models\Recruiter\master_post;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use function App\Helpers\getCompanyCode;
use function App\Helpers\getDesignation;
use function App\Helpers\SendOTP;

class JobController extends Controller
{
    function jobs()
    {

        return view('jobportal.jobs');
    }

    public function job_apply_form()
    {
        $state_list = DB::table("states")->orderBy('StateName', 'asc')->pluck("StateName", "StateId");
        $institute_list = DB::table("master_institute")->orderBy('InstituteName', 'asc')->pluck("InstituteName", "InstituteId");
        $education_list = DB::table("master_education")->where('Status', 'A')->orderBy('EducationCode', 'asc')->pluck("EducationCode", "EducationId");
        $resume_list = DB::table("master_resumesource")->where('Status', 'A')->where('ResumeSouId', '!=', '7')->orderBy('ResumeSouId', 'asc')->pluck("ResumeSource", "ResumeSouId");
        return view('jobportal.job_apply', compact('state_list', 'institute_list', 'education_list', 'resume_list'));
    }
    public function job_apply_form_manual()
    {
        $state_list = DB::table("states")->orderBy('StateName', 'asc')->pluck("StateName", "StateId");
        $institute_list = DB::table("master_institute")->orderBy('InstituteName', 'asc')->pluck("InstituteName", "InstituteId");
        $education_list = DB::table("master_education")->where('Status', 'A')->orderBy('EducationCode', 'asc')->pluck("EducationCode", "EducationId");
        $resume_list = DB::table("master_resumesource")->where('Status', 'A')->where('ResumeSouId', '!=', '7')->orderBy('ResumeSouId', 'asc')->pluck("ResumeSource", "ResumeSouId");
        return view('jobportal.job_apply_form_manual', compact('state_list', 'institute_list', 'education_list', 'resume_list'));
    }

    public function job_apply(Request $request)
    {

        $JPId = $request->JPId;
        $jobPost = master_post::find($JPId);
        $CompanyId = $jobPost->CompanyId;
        $DepartmentId = $jobPost->DepartmentId;
        $Title = $jobPost->Title;

        $EmailOTP = rand(100000, 999999);
        $SmsOTP = rand(100000, 999999);

        $query = new jobcandidate;
        $query->Title = $request->Title;
        $query->FName = $request->FName;
        $query->MName = $request->MName;
        $query->LName = $request->LName;
        $query->DOB = $request->DOB;
        $query->Gender = $request->Gender;
        $query->FatherTitle = $request->FatherTitle;
        $query->FatherName = $request->FatherName;
        $query->Email = $request->Email;
        $query->Phone = $request->Phone;
        $query->AddressLine1 = $request->AddressLine1;
        $query->AddressLine2 = $request->AddressLine2;
        $query->AddressLine3 = $request->AddressLine3;
        $query->State = $request->State;
        $query->District = $request->District;
        $query->City = $request->City;
        $query->PinCode = $request->PinCode;
        $query->Aadhaar = $request->Aadhaar;
        $query->Education = $request->Education;
        $query->CGPA = $request->CGPA;
        $query->Specialization = $request->Specialization;
        $query->PassingYear = $request->PassingYear;
        $query->College = $request->College;
        $query->OtherCollege = $request->OtherCollege;
        $query->Professional = $request->ProfCheck;
        $query->PresentCompany = $request->PresentCompany;
        $query->Designation = $request->Designation;
        $query->JobStartDate = $request->JobStartDate;
        $query->JobEndDate = $request->JobEndDate;
        $query->StillEmp = $request->StillEmp;
        $query->GrossSalary = $request->GrossSalary;
        $query->CTC = $request->CTC;
        $query->NoticePeriod = $request->NoticePeriod;
        $query->ResignReason = $request->ResignReason;
        $query->Reference = $request->RefCheck;
        $query->RefPerson = $request->RefPerson;
        $query->RefCompany = $request->RefCompany;
        $query->RefDesignation = $request->RefDesignation;
        $query->RefContact = $request->RefContact;
        $query->RefMail = $request->RefMail;
        $query->EmailOTP = $EmailOTP;
        $query->SmsOTP = $SmsOTP;
        $query->save();

        $JCId = $query->JCId;

        $Resume = 'resume_' . $JCId . '.' . $request->Resume->extension();
        $request->Resume->move(public_path('uploads/Resume'), $Resume);
        $CandidateImage = '';
        if ($request->CandidateImage != '' || $request->CandidateImage != null) {
            $CandidateImage = $JCId . '.' . $request->CandidateImage->extension();
            $request->CandidateImage->move(public_path('uploads/Picture'), $CandidateImage);
        }

        $ReferenceNo = rand(1000, 9999) . date('Y') . $JCId;

        $query1 = jobcandidate::find($JCId);
        $query1->ReferenceNo = $ReferenceNo;
        $query1->Resume = $Resume;
        $query1->CandidateImage = $CandidateImage;
        $query1->save();

        $jobApply = new jobapply;
        $jobApply->JCId = $JCId;
        $jobApply->JPId = $JPId;
        $jobApply->Type = 'Regular';
        $jobApply->ResumeSource = $request->resumesource;
        $jobApply->OtherResumeSource = $request->OtherResumeSource;
        $jobApply->Company = $CompanyId;
        $jobApply->Department = $DepartmentId;
        $jobApply->save();

        CandidateActivityLog::addToCandLog($JCId, $request->Aadhaar, 'Applied for ' . $Title . ' in ' . getCompanyCode($CompanyId));
        if (!$jobApply) {
          //  return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {
            $details = [
                "subject" => 'OTP to verify your email address for Application submission',
                "Candidate" => $request->Title . ' ' . $request->FName . ' ' . $request->LName,
                "EmailOTP" => $EmailOTP,
            ];
            Mail::to($request->Email)->send(new AppSubOTPMail($details));
            SendOTP($request->Phone, $SmsOTP);
         //   return response()->json(['status' => 200, 'msg' => ' successfully created.', 'jcid' => $JCId]);
        }
    }
    public function campus_placement_registration()
    {
        return view('jobportal.campus_placement_registration');
    }

    public function campus_apply_form()
    {
        $state_list = DB::table("states")->orderBy('StateName', 'asc')->pluck("StateName", "StateId");
        $institute_list = DB::table("master_institute")->orderBy('InstituteName', 'asc')->pluck("InstituteName", "InstituteId");
        $education_list = DB::table("master_education")->where('Status', 'A')->orderBy('EducationCode', 'asc')->pluck("EducationCode", "EducationId");
        return view('jobportal.campus_apply', compact('state_list', 'institute_list', 'education_list'));
    }

    public function campus_apply(Request $request)
    {

        $JPId = $request->JPId;
        $jobPost = master_post::find($JPId);
        $CompanyId = $jobPost->CompanyId;
        $DepartmentId = $jobPost->DepartmentId;

        $EmailOTP = rand(100000, 999999);
        $SmsOTP = rand(100000, 999999);

        $query = new jobcandidate;
        $query->Title = $request->Title;
        $query->FName = $request->FName;
        $query->MName = $request->MName;
        $query->LName = $request->LName;
        $query->DOB = $request->DOB;
        $query->Gender = $request->Gender;
        $query->FatherTitle = $request->FatherTitle;
        $query->FatherName = $request->FatherName;
        $query->Email = $request->Email;
        $query->Phone = $request->Phone;
        $query->AddressLine1 = $request->AddressLine1;
        $query->AddressLine2 = $request->AddressLine2;
        $query->AddressLine3 = $request->AddressLine3;
        $query->State = $request->State;
        $query->District = $request->District;
        $query->City = $request->City;
        $query->PinCode = $request->PinCode;
        $query->Aadhaar = $request->Aadhaar;
        $query->Education = $request->Education;
        $query->CGPA = $request->CGPA;
        $query->Specialization = $request->Specialization;
        $query->PassingYear = $request->PassingYear;
        $query->College = $request->College;
        $query->Professional = $request->ProfCheck;
        $query->PresentCompany = $request->PresentCompany;
        $query->Designation = $request->Designation;
        $query->JobStartDate = $request->JobStartDate;
        $query->JobEndDate = $request->JobEndDate;
        $query->StillEmp = $request->StillEmp;
        $query->GrossSalary = $request->GrossSalary;
        $query->CTC = $request->CTC;
        $query->NoticePeriod = $request->NoticePeriod;
        $query->ResignReason = $request->ResignReason;
        $query->Reference = $request->RefCheck;
        $query->RefPerson = $request->RefPerson;
        $query->RefCompany = $request->RefCompany;
        $query->RefDesignation = $request->RefDesignation;
        $query->RefContact = $request->RefContact;
        $query->RefMail = $request->RefMail;
        $query->EmailOTP = $EmailOTP;
        $query->SmsOTP = $SmsOTP;
        $query->save();

        $JCId = $query->JCId;

        $Resume = 'resume_' . $JCId . '.' . $request->Resume->extension();
        $request->Resume->move(public_path('uploads/Resume'), $Resume);
        $CandidateImage = '';
        if ($request->CandidateImage != '' || $request->CandidateImage != null) {
            $CandidateImage = $JCId . '.' . $request->CandidateImage->extension();
            $request->CandidateImage->move(public_path('uploads/Picture'), $CandidateImage);
        }

        $ReferenceNo = rand(1000, 9999) . date('Y') . $JCId;

        $query1 = jobcandidate::find($JCId);
        $query1->ReferenceNo = $ReferenceNo;
        $query1->Resume = $Resume;
        $query1->CandidateImage = $CandidateImage;
        $query1->save();

        $jobApply = new jobapply;
        $jobApply->JCId = $JCId;
        $jobApply->JPId = $JPId;
        $jobApply->Type = 'Campus';
        $jobApply->ResumeSource = 7;   //College Campus
        $jobApply->Company = $CompanyId;
        $jobApply->Department = $DepartmentId;
        $jobApply->save();

        if (!$jobApply) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {
            $details = [
                "subject" => 'OTP to verify your email address for Application submission',
                "Candidate" => $request->Title . ' ' . $request->FName . ' ' . $request->LName,
                "EmailOTP" => $EmailOTP,
            ];
            Mail::to($request->Email)->send(new AppSubOTPMail($details));
            SendOTP($request->Phone, $SmsOTP);
            return response()->json(['status' => 200, 'msg' => ' successfully created.', 'jcid' => $JCId]);
        }
    }

    public function verification()
    {
        return view('jobportal.verification');
    }

    public function confirmation()
    {
        return view('jobportal.confirmation');
    }

    public function otpverify(Request $request)
    {
        $JCId = $request->JCId;
        $validator = Validator::make($request->all(), [
            'SmsOTP' => 'required',
            'EmailOTP' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'error' => $validator->errors()->toArray()]);
        } else {
            $cand = jobcandidate::find($JCId);
            $EmailOTP = $cand->EmailOTP;
            $SmsOTP = $cand->SmsOTP;
            $ReferenceNo = $cand->ReferenceNo;
            $Email = $cand->Email;
            $Candidate = $cand->Title . ' ' . $cand->FName . ' ' . $cand->LName;
            
            if ($EmailOTP == $request->EmailOTP && $SmsOTP == $request->SmsOTP) {
                $query = jobcandidate::find($JCId);
                $query->Verified = 'Y';
                $query->save();
                $details = [
                    "subject" => 'Thank You for your application!',
                    "Candidate" => $Candidate,
                    "ReferenceNo" => $ReferenceNo,
                ];
                Mail::to($Email)->send(new AppSuccessMaill($details));
                return response()->json(['status' => 200, 'msg' => 'You have successfully verified.', 'JCId' => $JCId]);
            } else {
                return response()->json(['status' => 400, 'msg' => 'OTP Does Not Match Please try again...!!']);
            }
        }
    }

    public function job_apply_manual(Request $request)
    {

        $JCId = $request->JCId;

        $EmailOTP = rand(100000, 999999);
        $SmsOTP = rand(100000, 999999);

        $query = jobcandidate::find($JCId);
        $CandidateImage = $query->CandidateImage;

        $query->Title = $request->Title;
        $query->FName = $request->FName;
        $query->MName = $request->MName;
        $query->LName = $request->LName;
        $query->DOB = $request->DOB;
        $query->Gender = $request->Gender;
        $query->FatherTitle = $request->FatherTitle;
        $query->FatherName = $request->FatherName;
        $query->Email = $request->Email;
        $query->Phone = $request->Phone;
        $query->AddressLine1 = $request->AddressLine1;
        $query->AddressLine2 = $request->AddressLine2;
        $query->AddressLine3 = $request->AddressLine3;
        $query->State = $request->State;
        $query->District = $request->District;
        $query->City = $request->City;
        $query->PinCode = $request->PinCode;
        $query->Aadhaar = $request->Aadhaar;
        $query->Education = $request->Education;
        $query->CGPA = $request->CGPA;
        $query->Specialization = $request->Specialization;
        $query->PassingYear = $request->PassingYear;
        $query->College = $request->College;
        $query->Professional = $request->ProfCheck;
        $query->PresentCompany = $request->PresentCompany;
        $query->Designation = $request->Designation;
        $query->JobStartDate = $request->JobStartDate;
        $query->JobEndDate = $request->JobEndDate;
        $query->StillEmp = $request->StillEmp;
        $query->GrossSalary = $request->GrossSalary;
        $query->CTC = $request->CTC;
        $query->NoticePeriod = $request->NoticePeriod;
        $query->ResignReason = $request->ResignReason;
        $query->Reference = $request->RefCheck;
        $query->RefPerson = $request->RefPerson;
        $query->RefCompany = $request->RefCompany;
        $query->RefDesignation = $request->RefDesignation;
        $query->RefContact = $request->RefContact;
        $query->RefMail = $request->RefMail;
        $query->EmailOTP = $EmailOTP;
        $query->SmsOTP = $SmsOTP;

        if ($request->CandidateImage != '' || $request->CandidateImage != null) {
            $CandidateImage = $JCId . '.' . $request->CandidateImage->extension();
            $request->CandidateImage->move(public_path('uploads/Picture'), $CandidateImage);
        }
        $query->CandidateImage = $CandidateImage;
        $query->save();



        CandidateActivityLog::addToCandLog($JCId, $request->Aadhaar, 'Candidate Filled Application Form');
        if (!$query) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {
            $details = [
                "subject" => 'OTP to verify your email address for Application submission',
                "Candidate" => $request->Title . ' ' . $request->FName . ' ' . $request->LName,
                "EmailOTP" => $EmailOTP,
            ];
            Mail::to($request->Email)->send(new AppSubOTPMail($details));
            SendOTP($request->Phone, $SmsOTP);
            return response()->json(['status' => 200, 'msg' => ' successfully created.', 'jcid' => $JCId]);
        }
    }
}
