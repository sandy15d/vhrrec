@php
use Illuminate\Support\Carbon;
use function App\Helpers\getDistrictName;
use function App\Helpers\getStateName;
use function App\Helpers\getEducationById;
use function App\Helpers\getSpecializationbyId;
use function App\Helpers\getCollegeById;
use function App\Helpers\getDepartment;
use function App\Helpers\getCompanyCode;
use function App\Helpers\getDesignation;
use function App\Helpers\getGradeValue;
use function App\Helpers\getFullName;
$sendingId = request()->query('jaid');
$JAId = base64_decode($sendingId);
$Rec = DB::table('jobapply')
    ->join('jobcandidates', 'jobapply.JCId', '=', 'jobcandidates.JCId')
    ->leftJoin('screening', 'screening.JAId', '=', 'jobapply.JAId')
    ->leftJoin('screen2ndround', 'screen2ndround.ScId', '=', 'screening.ScId')
    ->leftJoin('jobpost', 'jobapply.JPId', '=', 'jobpost.JPId')
    ->leftJoin('jf_contact_det', 'jobcandidates.JCId', '=', 'jf_contact_det.JCId')
    ->leftJoin('jf_pf_esic', 'jobcandidates.JCId', '=', 'jf_pf_esic.JCId')
    ->leftJoin('master_country', 'jobcandidates.Nationality', '=', 'master_country.CountryId')
    ->leftJoin('appointing', 'appointing.JAId', '=', 'jobapply.JAId')
    ->where('jobapply.JAId', $JAId)
    ->select(
        'jobapply.*',
        'jobcandidates.*',
        'screening.ReSentForScreen',
        'screening.ScreenStatus',
        'screening.IntervStatus',
        'screening.IntervDt',
        'screen2ndround.IntervDt2',
        'screen2ndround.IntervStatus2',
        'screening.SelectedForD',
        'jobpost.Title as JobTitle',
        'jobpost.JobCode',
        'jf_contact_det.pre_address',
        'jf_contact_det.pre_city',
        'jf_contact_det.pre_state',
        'jf_contact_det.pre_pin',
        'jf_contact_det.pre_dist',
        'jf_contact_det.perm_address',
        'jf_contact_det.perm_city',
        'jf_contact_det.perm_state',
        'jf_contact_det.perm_pin',
        'jf_contact_det.perm_dist',
        'jf_contact_det.cont_one_name',
        'jf_contact_det.cont_one_relation',
        'jf_contact_det.cont_one_number',
        'jf_contact_det.cont_two_name',
        'jf_contact_det.cont_two_relation',
        'jf_contact_det.cont_two_number',
        'jf_pf_esic.UAN',
        'jf_pf_esic.PFNumber',
        'jf_pf_esic.ESICNumber',
        'jf_pf_esic.BankName',
        'jf_pf_esic.BranchName',
        'jf_pf_esic.IFSCCode',
        'jf_pf_esic.AccountNumber',
        'jf_pf_esic.PAN',
        'jf_pf_esic.Passport',
        'master_country.CountryName',
        'appointing.AppLtrGen',
        'appointing.AgrLtrGen',
        'appointing.BLtrGen',
    )
    ->first();

$JCId = $Rec->JCId;
$firobid = base64_encode($Rec->JCId);

$OfBasic = DB::table('offerletterbasic')
    ->leftJoin('candjoining', 'candjoining.JAId', '=', 'offerletterbasic.JAId')
    ->select('offerletterbasic.*', 'candjoining.JoinOnDt', 'candjoining.RejReason', 'candjoining.EmpCode', 'candjoining.Verification', 'candjoining.Joined', 'candjoining.PositionCode', 'candjoining.ForwardToESS')
    ->where('offerletterbasic.JAId', $JAId)
    ->first();

$FamilyInfo = DB::table('jf_family_det')
    ->where('JCId', $JCId)
    ->get();
$Education = DB::table('candidateeducation')
    ->where('JCId', $JCId)
    ->get();
$Experience = DB::table('jf_work_exp')
    ->where('JCId', $JCId)
    ->get();

$Training = DB::table('jf_tranprac')
    ->where('JCId', $JCId)
    ->get();

$PreRef = DB::table('jf_reference')
    ->where('JCId', $JCId)
    ->where('from', 'Previous Organization')
    ->get();

$VnrRef = DB::table('jf_reference')
    ->where('JCId', $JCId)
    ->where('from', 'VNR')
    ->get();
$Year = Carbon::now()->year;
$sql = DB::table('offerletterbasic_history')
    ->where('JAId', $JAId)
    ->get();
$lang = DB::table('jf_language')
    ->where('JCId', $JCId)
    ->get();
$count = count($sql);
$OtherSeed = DB::table('relation_other_seed_cmp')
    ->where('JCId', $JCId)
    ->get();
$VnrBusinessRef = DB::table('vnr_business_ref')
    ->where('JCId', $JCId)
    ->get();
$AboutAns = DB::table('about_answer')
    ->where('JCId', $JCId)
    ->first();
$Docs = DB::table('jf_docs')
    ->where('JCId', $JCId)
    ->first();

$country_list = DB::table('master_country')->pluck('CountryName', 'CountryId');
$candidate_log = DB::table('candidate_log')
    ->where('JCId', $JCId)
    ->get();
@endphp
@extends('layouts.master')
@section('title', 'Candidate Detail')
@section('PageContent')
    <style>
        .table>:not(caption)>*>* {
            padding: 2px 1px;
        }

        .frminp {
            padding: 4 px !important;
            height: 25 px;
            border-radius: 4 px;
            font-size: 11px;
            font-weight: 550;
        }

        .frmbtn {
            padding: 2px 4px !important;
            font-size: 11px;
            cursor: pointer;
        }

        .iframe-container {
            padding-bottom: 60%;
            padding-top: 30px;
            height: 0;
            overflow: hidden;
        }

        .iframe-container iframe,
        .iframe-container object,
        .iframe-container embed {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

    </style>
    <div class="page-content">
        <input type="hidden" name="JAId" id="JAId" value="{{ $JAId }}">
        <input type="hidden" name="JCId" id="JCId" value="{{ $JCId }}">

        <div class="card mb-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="profile-view">
                            <div class="profile-img-wrap">
                                <div class="profile-img">
                                    @if ($Rec->CandidateImage == null)
                                        <img src="{{ URL::to('/') }}/assets/images/user1.png" />
                                    @else
                                        <img src="{{ URL::to('/') }}/uploads/Picture/{{ $Rec->CandidateImage }}" />
                                    @endif
                                </div>
                            </div>
                            <div class="profile-basic">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="profile-info-left">
                                            <h6 class="user-name m-t-0 mb-0"> {{ $Rec->FName }} {{ $Rec->MName }}
                                                {{ $Rec->LName }}</h6>
                                            <h6 class="staff-id">Applied For: {{ $Rec->JobTitle }}</h6>
                                            <h6 class="staff-id text-primary">MRF: {{ $Rec->JobCode }}</h6>

                                            <div class="staff-id">ReferenceNo : {{ $Rec->ReferenceNo }}</div>
                                            <div class="staff-id">Date of Apply :
                                                {{ date('d-M-Y', strtotime($Rec->ApplyDate)) }}</div>
                                            <div class="staff-msg"><a class="btn btn-custom btn-sm"
                                                    href="javascript:void(0);" data-bs-toggle="modal"
                                                    data-bs-target="#resume_modal">View Resume</a>
                                                <a href="javascript:;" class="btn btn-primary btn-sm compose-mail-btn">Send
                                                    Mail</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <ul class="personal-info">
                                            <li>
                                                <div class="title">Phone:</div>
                                                <div class="text"><a href="#">{{ $Rec->Phone }}</a></div>
                                            </li>
                                            <li>
                                                <div class="title">Email:</div>
                                                <div class="text text-primary">{{ $Rec->Email }}</div>

                                            </li>
                                            <li>
                                                <div class="title">Birthday:</div>
                                                <div class="text  text-dark">{{ date('d-M-Y', strtotime($Rec->DOB)) }}
                                                    (Age:
                                                    {{ \Carbon\Carbon::parse($Rec->DOB)->diff(\Carbon\Carbon::now())->format('%y years, %m months and %d days') }})
                                                </div>
                                            </li>
                                            <li style="margin-bottom: 0px">
                                                <div class="title">Address:</div>
                                                <div class="text  text-dark">{{ $Rec->AddressLine1 }},
                                                    {{ $Rec->AddressLine2 }}, {{ $Rec->AddressLine3 }}</div>
                                            </li>
                                            <li>
                                                @if ($Rec->InterviewSubmit == 1)
                                                    <div class="title">
                                                        @php
                                                            $sendingId = base64_encode($Rec->JAId);
                                                        @endphp
                                                        <a class="text-danger" href="javascript:void(0);"
                                                            onclick="printInterviewForm('{{ route('interview_form_detail') }}?jaid={{ $sendingId }}');">Interview
                                                            Form</a>
                                                    </div>
                                                @endif
                                                @if ($Rec->FinalSubmit == 1)
                                                    <div class=" title">
                                                        <a class="text-danger" href="javascript:void(0);"
                                                            onclick="printJoiningForm('{{ route('joining_form_print') }}?jaid={{ $sendingId }}')">Joining
                                                            Form</a>
                                                    </div>
                                                @endif

                                                @if ($OfBasic != null && $OfBasic->OfferLtrGen == 1)
                                                    <div class="title">
                                                        <a href="javascript:void(0);" class="text-danger"
                                                            onclick="OfferLetterPrint('{{ route('offer_ltr_print') }}?jaid={{ $Rec->JAId }}');">Offer
                                                            Letter</a>
                                                    </div>
                                                @endif



                                            </li>



                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="pro-edit"><a data-bs-target="#profile_info" data-bs-toggle="modal"
                                    class="edit-icon" onclick="GetProfileData();" href="javascript:void(0);"><i
                                        class="fa fa-pencil"></i></a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card tab-box">
            <div class="row user-tabs">
                <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                    <ul class="nav nav-tabs nav-tabs-bottom" id="myTab">
                        <li class="nav-item"><a href="#cand_profile" data-bs-toggle="tab"
                                class="nav-link active">Profile</a></li>

                        <li class="nav-item"><a href="#cand_contact" data-bs-toggle="tab"
                                class="nav-link">Contact</a></li>

                        <li class="nav-item"><a href="#cand_education" data-bs-toggle="tab"
                                class="nav-link">Education</a></li>

                        <li class="nav-item"><a href="#cand_experience" data-bs-toggle="tab"
                                class="nav-link">Employement</a></li>

                        <li class="nav-item"><a href="#cand_reference" data-bs-toggle="tab"
                                class="nav-link">Reference</a></li>

                        <li class="nav-item"><a href="#cand_other" data-bs-toggle="tab" class="nav-link"> Other
                            </a></li>

                        <li class="nav-item"><a href="#cand_document" data-bs-toggle="tab"
                                class="nav-link">Documents</a></li>

                        <li class="nav-item"><a href="#cand_history" data-bs-toggle="tab"
                                class="nav-link">History</a></li>

                        <li class="nav-item"><a href="#job_offer" data-bs-toggle="tab" class="nav-link">Job
                                Offer</a></li>

                        <li class="nav-item">
                            <a href="#cand_family" data-bs-toggle="tab" class="nav-link">Changes <small
                                    class="text-danger">(Admin Only)</small></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="tab-content">

            <div id="cand_profile" class=" tab-pane fade pro-overview show active">
                <div class="row">
                    <div class="col-md-6 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h6 class="card-title">Personal Informations <a href="#" class="edit-icon"
                                        data-bs-toggle="modal" data-bs-target="#personal_info_modal"
                                        onclick="GetPersonalData();"><i class="fa fa-pencil"></i></a></h6>
                                <ul class="personal-info">
                                    <li>
                                        <div class="title">Gender<span style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->Gender == 'M' ? 'Male' : 'Female' }}</div>
                                    </li>

                                    <li>
                                        <div class="title">Aadhaar No.<span style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->Aadhaar }}</div>
                                    </li>

                                    <li>
                                        <div class="title">Nationality<span style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->CountryName ?? '-' }}</div>
                                    </li>

                                    <li>
                                        <div class="title">Religion<span style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->Religion ?? '-' }} @if ($Rec->Religion == 'Others')
                                                <span class="text-danger">({{ $Rec->OtherReligion }})</span>
                                            @endif
                                        </div>
                                    </li>

                                    <li>
                                        <div class="title">Marital Status<span style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->MaritalStatus ?? '-' }}</div>
                                    </li>
                                    <li>
                                        <div class="title">Marriage Date<span style="float: right">:</span></div>
                                        <div class="text">
                                            @if ($Rec->MarriageDate != null)
                                                {{ date('d-M-Y', strtotime($Rec->MarriageDate)) }}

                                            @else
                                                -
                                            @endif
                                        </div>
                                    </li>
                                    <li>
                                        <div class="title">Spouse Name<span style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->SpouseName ?? '-' }}</div>
                                    </li>
                                    <li>
                                        <div class="title">Category<span style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->Caste ?? '-' }}@if ($Rec->Caste == 'Other')
                                                <span class="text-danger">({{ $Rec->OtherCaste }})</span>
                                            @endif
                                        </div>
                                    </li>


                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h6 class="card-title">Emergency Contact <a href="#" class="edit-icon"
                                        data-bs-toggle="modal" data-bs-target="#emergency_contact_modal"
                                        onclick="GetEmergencyContact();"><i class="fa fa-pencil"></i></a></h6>
                                <h6 class="section-title">Primary</h6>
                                <ul class="personal-info">
                                    <li>
                                        <div class="title">Name</div>
                                        <div class="text">{{ $Rec->cont_one_name ?? '-' }}</div>
                                    </li>
                                    <li>
                                        <div class="title">Relationship</div>
                                        <div class="text">{{ $Rec->cont_one_relation ?? '-' }}</div>
                                    </li>
                                    <li>
                                        <div class="title">Phone </div>
                                        <div class="text">{{ $Rec->cont_one_number ?? '-' }}</div>
                                    </li>
                                </ul>

                                <hr>
                                <h6 class="section-title">Secondary</h6>
                                <ul class="personal-info">
                                    <li>
                                        <div class="title">Name</div>
                                        <div class="text">{{ $Rec->cont_two_name ?? '-' }}</div>
                                    </li>
                                    <li>
                                        <div class="title">Relationship</div>
                                        <div class="text">{{ $Rec->cont_two_relation ?? '-' }}</div>
                                    </li>
                                    <li>
                                        <div class="title">Phone </div>
                                        <div class="text">{{ $Rec->cont_two_number ?? '-' }}</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h6 class="card-title">Bank Informations <a href="#" class="edit-icon"
                                        data-bs-toggle="modal" data-bs-target="#bank_info_modal" onclick="GetBankInfo();"><i
                                            class="fa fa-pencil"></i></a></h6>
                                <ul class="personal-info">
                                    <li>
                                        <div class="title">Bank Name<span style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->BankName ?? '-' }}</div>
                                    </li>
                                    <li>
                                        <div class="title">Branch Name<span style="float: right">:</span>
                                        </div>
                                        <div class="text">{{ $Rec->BranchName }}</div>
                                    </li>
                                    <li>
                                        <div class="title">Bank account No.<span style="float: right">:</span>
                                        </div>
                                        <div class="text">{{ $Rec->AccountNumber ?? '-' }}</div>
                                    </li>
                                    <li>
                                        <div class="title">IFSC Code<span style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->IFSCCode ?? '-' }}</div>
                                    </li>
                                    <li>
                                        <div class="title">PAN No<span style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->PAN ?? '-' }}</div>
                                    </li>
                                    <li>
                                        <div class="title">PF Account No<span style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->PFNumber ?? '-' }}</div>
                                    </li>
                                    <li>
                                        <div class="title">UAN No<span style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->UAN ?? '-' }}</div>
                                    </li>
                                    <li>
                                        <div class="title">ESIC No<span style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->ESICNumber ?? '-' }}</div>
                                    </li>
                                    <li>
                                        <div class="title">Passport<span style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->Passport ?? '-' }}</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h6 class="card-title">Family Informations <a href="#" class="edit-icon"
                                        data-bs-toggle="modal" data-bs-target="#family_info_modal" onclick="GetFamily();"><i
                                            class="fa fa-pencil"></i></a></h6>
                                <div class="table-responsive">
                                    <table class="table table-nowrap">
                                        <thead>
                                            <tr>
                                                <th>Relation</th>
                                                <th>Name</th>
                                                <th>DOB</th>
                                                <th>Qulification</th>
                                                <th>Occupation</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($FamilyInfo != null)
                                                @foreach ($FamilyInfo as $item)
                                                    <tr>
                                                        <td>{{ $item->relation }}</td>
                                                        <td>{{ $item->name }}</td>
                                                        <td>{{ date('d-M-Y', strtotime($item->dob)) }}</td>
                                                        <td>{{ $item->qualification }}</td>
                                                        <td>{{ $item->occupation }}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="cand_contact">
                <div class="row">
                    <div class="col-md-6 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h6 class="card-title">Current Address
                                    <a href="#" class="edit-icon" data-bs-toggle="modal"
                                        data-bs-target="#current_address_modal" onclick="GetCurrentAddress();">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                </h6>
                                <ul class="personal-info">
                                    <li>
                                        <div class="title">Address <span style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->pre_address ?? '-' }}</div>
                                    </li>
                                    <li>
                                        <div class="title">City <span style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->pre_city ?? '-' }}</div>
                                    </li>
                                    <li>
                                        <div class="title">District <span style="float: right">:</span></div>
                                        <div class="text">
                                            @if ($Rec->pre_dist != null)
                                                {{ getDistrictName($Rec->pre_dist) }}
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </li>
                                    <li>
                                        <div class="title">State <span style="float: right">:</span></div>
                                        <div class="text">
                                            @if ($Rec->pre_state != null)
                                                {{ getStateName($Rec->pre_state) }}

                                            @else
                                                -
                                            @endif
                                        </div>
                                    </li>
                                    <li>
                                        <div class="title">PinCode <span style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->pre_pin ?? '-' }}</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h6 class="card-title">Permanent Address
                                    <a href="#" class="edit-icon" data-bs-toggle="modal"
                                        data-bs-target="#permanent_address_modal" onclick="GetPermanentAddress();">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                </h6>
                                <ul class="personal-info">
                                    <li>
                                        <div class="title">Address <span style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->perm_address ?? '-' }}</div>
                                    </li>
                                    <li>
                                        <div class="title">City <span style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->perm_city ?? '-' }}</div>
                                    </li>
                                    <li>
                                        <div class="title">District <span style="float: right">:</span></div>
                                        <div class="text">
                                            @if ($Rec->perm_dist != null)
                                                {{ getDistrictName($Rec->perm_dist) }}

                                            @else
                                                -
                                            @endif
                                        </div>
                                    </li>
                                    <li>
                                        <div class="title">State <span style="float: right">:</span></div>
                                        <div class="text">
                                            @if ($Rec->perm_state != null)
                                                {{ getStateName($Rec->perm_state) }}

                                            @else
                                                -
                                            @endif
                                        </div>
                                    </li>
                                    <li>
                                        <div class="title">PinCode <span style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->perm_pin ?? '-' }}</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="cand_education">
                <div class="col-md-12 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h6 class="card-title">Educational Details
                                <a href="#" class="edit-icon" data-bs-toggle="modal"
                                    data-bs-target="#education_info_modal" onclick="GetQualification();">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </h6>
                            <div class="table-responsive">
                                <table class="table text-center">
                                    <thead>
                                        <tr>
                                            <td>Qualification</td>
                                            <td>Course</td>
                                            <td>Specialization</td>
                                            <td>Board/University</td>
                                            <td>Passing Year</td>
                                            <td>Percentage/Grade</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($Education as $item)
                                            <tr>
                                                <td>{{ $item->Qualification }}</td>
                                                <td>
                                                    @if ($item->Course != null)
                                                        {{ getEducationById($item->Course) }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (is_null($item->Specialization))
                                                        -
                                                    @else
                                                        {{ getSpecializationbyId($item->Specialization) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->Institute != null)
                                                        {{ getCollegeById($item->Institute) }}

                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>{{ $item->YearOfPassing ?? '-' }}</td>
                                                <td>{{ $item->CGPA ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="cand_experience">
                <div class="row">
                    <div class="col-md-6 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h6 class="card-title">Current Employement
                                    <a href="#" class="edit-icon" data-bs-toggle="modal"
                                        data-bs-target="#current_emp_modal" onclick="GetCurrentEmployementData();"><i
                                            class="fa fa-pencil"></i></a>
                                </h6>
                                <ul class="personal-info">
                                    <li>
                                        <div class="title" style="width: 150px;">Name of Company <span
                                                style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->PresentCompany ?? '-' }}</div>
                                    </li>
                                    <li>
                                        <div class="title" style="width: 150px;">Date of Joining <span
                                                style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->JobStartDate ?? '-' }}</div>
                                    </li>
                                    <li>
                                        <div class="title" style="width: 150px;">Designation <span
                                                style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->Designation ?? '-' }}</div>
                                    </li>

                                    <li>
                                        <div class="title" style="width: 150px;">Reporting to<span
                                                style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->Reporting ?? '-' }} ,
                                            {{ $Rec->RepDesig ?? '-' }} </div>
                                    </li>
                                    <li>
                                        <div class="title" style="width: 150px;">Job Responsibility <span
                                                style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->JobResponsibility ?? '-' }}</div>
                                    </li>
                                    <li>
                                        <div class="title" style="width: 150px;">Job Change Reason<span
                                                style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->ResignReason ?? '-' }}</div>
                                    </li>
                                    <li>
                                        <div class="title" style="width: 150px;">Notice Period<span
                                                style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->NoticePeriod ?? '-' }}</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h6 class="card-title">Present Salary Details <a href="#" class="edit-icon"
                                        data-bs-toggle="modal" data-bs-target="#current_salary_modal"
                                        onclick="GetPresentSalaryDetails();"><i class="fa fa-pencil"></i></a></h6>
                                <ul class="personal-info">
                                    <li>
                                        <div class="title" style="width: 200px;">Salary (Per Month)<span
                                                style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->GrossSalary ?? '-' }}</div>
                                    </li>
                                    <li>
                                        <div class="title" style="width: 200px;">Annual Package (CTC)<span
                                                style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->CTC ?? '-' }}</div>
                                    </li>
                                    <li>
                                        <div class="title" style="width: 200px;">DA@ headquarter<span
                                                style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->DAHq ?? '-' }}</div>
                                    </li>
                                    <li>
                                        <div class="title" style="width: 200px;">DA outside headquarter <span
                                                style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->DAOutHq ?? '-' }}</div>
                                    </li>
                                    <li>
                                        <div class="title" style="width: 200px;">Petrol Allowances <span
                                                style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->PetrolAlw ?? '-' }}</div>
                                    </li>
                                    <li>
                                        <div class="title" style="width: 200px;">Phone Allowances <span
                                                style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->PhoneAlw ?? '-' }}</div>
                                    </li>
                                    <li>
                                        <div class="title" style="width: 200px;">Hotel Eligibility<span
                                                style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->HotelElg ?? '-' }}</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <h6 class="card-title">Previous Employement Records <small>(except the present)</small>
                                <a href="#" class="edit-icon" data-bs-toggle="modal" data-bs-target="#work_exp_modal"
                                    onclick="getWorkExp();">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </h6>

                            <div class="table-responsive">
                                <table class="table text-center">
                                    <thead>
                                        <tr>
                                            <td style="width: 5%">S.No</td>
                                            <td style="width: 20%">Company Name</td>
                                            <td style="width: 15%">Designation</td>
                                            <td style="width: 10%">Gross Monthly Salary</td>
                                            <td style="width: 10%">Anual CTC</td>
                                            <td style="width: 10%">From</td>
                                            <td style="width: 10%">To</td>
                                            <td style="width: 20%">Reason for Leaving</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($Experience as $item)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $item->company }}</td>
                                                <td>{{ $item->desgination }}</td>
                                                <td>{{ $item->gross_mon_sal }}</td>
                                                <td>{{ $item->annual_ctc }}</td>
                                                <td>{{ $item->job_start }}</td>
                                                <td>{{ $item->job_end }}</td>
                                                <td>{{ $item->reason_fr_leaving }}</td>
                                            </tr>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-12 d-flex">
                    <div class="card  flex-fill">
                        <div class="card-body">
                            <h6 class="card-title">Training & Practical Experience <small>(Other than regular
                                    jobs)</small>
                                <a href="#" class="edit-icon" data-bs-toggle="modal" data-bs-target="#training_modal"
                                    onclick="getTraining();">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </h6>

                            <div class="table-responsive">
                                <table class="table text-center">
                                    <thead>
                                        <tr>
                                            <td style="width: 5%">S.No</td>
                                            <td style="width: 20%">Training Nature</td>
                                            <td style="width: 15%">Organization</td>
                                            <td style="width: 10%">From</td>
                                            <td style="width: 10%">To</td>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($Training as $item)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $item->training }}</td>
                                                <td>{{ $item->organization }}</td>
                                                <td>{{ $item->from }}</td>
                                                <td>{{ $item->to }}</td>
                                            </tr>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="cand_reference">
                <div class="col-md-12 d-flex">
                    <div class="card  flex-fill">
                        <div class="card-body">
                            <h6 class="card-title">Previous Organization Reference
                                <a href="#" class="edit-icon" data-bs-toggle="modal"
                                    data-bs-target="#pre_org_ref_modal" onclick="getPreOrgRef();">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </h6>

                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td>S.No</td>
                                            <td>Name</td>
                                            <td>Company</td>
                                            <td>Designation</td>
                                            <td>Contact No.</td>
                                            <td>Email</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($PreRef as $item)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->company }}</td>
                                                <td>{{ $item->designation }}</td>
                                                <td>{{ $item->contact }}</td>
                                                <td>{{ $item->email }}</td>
                                            </tr>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 d-flex">
                        <div class="card  flex-fill">
                            <div class="card-body">
                                <h6 class="card-title">Acquaintances or relatives working with
                                    VNR Group Companies<a href="#" class="edit-icon" data-bs-toggle="modal"
                                        data-bs-target="#vnr_ref_modal" onclick="getVnrRef();"><i
                                            class="fa fa-pencil"></i></a></h6>

                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th>Name</th>
                                            <th>Mobile </th>
                                            <th>Email</th>
                                            <th>VNR Group /<br>Company Name</th>
                                            <th>Designation</th>
                                            <th>Location</th>
                                            <th>Your Relationship <br>with person mentioned</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @foreach ($VnrRef as $item)
                                            <tr>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->contact }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>{{ $item->company }}
                                                    {{ $item->company == 'Other' ? '/ ' . $item->other_company : '' }}
                                                </td>
                                                </td>
                                                <td>{{ $item->designation }}</td>
                                                <td>{{ $item->location }}</td>
                                                <td>{{ $item->rel_with_person }}</td>



                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 d-flex">
                        <div class="card  flex-fill">
                            <div class="card-body">
                                <h6 class="card-title">Acquaintances or relatives associated with
                                    VNR as business associates<a href="#" class="edit-icon" data-bs-toggle="modal"
                                        data-bs-target="#vnr_business_ref_modal" onclick="getVnrRef_Business();"><i
                                            class="fa fa-pencil"></i></a></h6>

                                <table class="table">
                                    <thead>
                                        <tr class="text-center">
                                            <th>Name</th>
                                            <th>Mobile </th>
                                            <th>Email</th>
                                            <th>Business Relation <br>With VNR</th>
                                            <th>Location of Business /
                                                acquaintances</th>
                                            <th>Your Relationship <br>with person mentioned</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @foreach ($VnrBusinessRef as $item)
                                            <tr>
                                                <td>{{ $item->Name ?? '' }}</td>
                                                <td>{{ $item->Mobile ?? '' }}</td>
                                                <td>{{ $item->Email ?? '' }}</td>
                                                <td>{{ $item->BusinessRelation ?? '' }}</td>
                                                </td>
                                                <td>{{ $item->Location ?? '' }}</td>
                                                <td>{{ $item->PersonRelation ?? '' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 d-flex">
                        <div class="card  flex-fill">
                            <div class="card-body">
                                <h6 class="card-title">Relatives or acquaintances is/are working
                                    or associated with any other Seed Company<a href="#" class="edit-icon"
                                        data-bs-toggle="modal" data-bs-target="#other_seed_modal"
                                        onclick="getOtherSeed();"><i class="fa fa-pencil"></i></a></h6>

                                <table class="table">
                                    <thead>
                                        <tr class="text-center">
                                            <th>Name</th>
                                            <th>Mobile </th>
                                            <th>Email</th>
                                            <th>Company Name</th>
                                            <th>Designation</th>
                                            <th>Location</th>
                                            <th>Your Relationship <br>with person mentioned</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @foreach ($OtherSeed as $item)
                                            <tr>
                                                <td>{{ $item->Name ?? '' }}</td>
                                                <td>{{ $item->Mobile ?? '' }}</td>
                                                <td>{{ $item->Email ?? '' }}</td>
                                                <td>{{ $item->CompanyName ?? '' }}</td>
                                                <td>{{ $item->Designation ?? '' }}</td>
                                                <td>{{ $item->Location ?? '' }}</td>
                                                <td>{{ $item->Relation ?? '' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="cand_other">
                <div class="row">
                    <div class="col-md-12 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body">
                                <h6 class="card-title">Language Proficiency
                                    <a href="#" class="edit-icon" data-bs-toggle="modal"
                                        data-bs-target="#language_modal" onclick="getLanguageProficiency();">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                </h6>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <td>S.No</td>
                                                <td>Language</td>
                                                <td>Reading</td>
                                                <td>Writing</td>
                                                <td>Speaking</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach ($lang as $item)
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td>{{ $item->language }}</td>
                                                    <td>{{ $item->read == 1 ? 'Yes' : 'No' }}</td>
                                                    <td>{{ $item->write == 1 ? 'Yes' : 'No' }}</td>
                                                    <td>{{ $item->speak == 1 ? 'Yes' : 'No' }}</td>
                                                </tr>
                                                @php
                                                    $i++;
                                                @endphp
                                            @endforeach
                                        </tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h6 class="card-title">About Yourself<a href="#" class="edit-icon"
                                        data-bs-toggle="modal" data-bs-target="#about_modal"><i
                                            class="fa fa-pencil"></i></a></h6>

                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr style="background-color: #F1F8E9">
                                                <td class="fw-bold">
                                                    Q1. What is your aim in life?
                                                </td>
                                            </tr>
                                            <tr style="background-color: #F9FBE7">
                                                <td>
                                                    &ensp;&ensp;&ensp;{{ $AboutAns->AboutAim ?? '' }}
                                                </td>
                                            </tr>
                                            <tr style="background-color: #F1F8E9">
                                                <td class="fw-bold">
                                                    Q2. What are you hobbies and interest?
                                                </td>
                                            </tr>
                                            <tr style="background-color: #F9FBE7">
                                                <td>
                                                    &ensp;&ensp;&ensp;{{ $AboutAns->AboutHobbi ?? '' }}
                                                </td>
                                            </tr>
                                            <tr style="background-color: #F1F8E9">
                                                <td class="fw-bold">
                                                    Q3. Where do you see yourself 5 Years from now?
                                                </td>
                                            </tr>
                                            <tr style="background-color: #F9FBE7">
                                                <td>
                                                    &ensp;&ensp;&ensp;{{ $AboutAns->About5Year ?? '' }}
                                                </td>
                                            </tr>
                                            <tr style="background-color: #F1F8E9">
                                                <td class="fw-bold">
                                                    Q4. What are your greatest personal assets (qualities, skills,
                                                    abilities) which make you successful in the jobs you take up?
                                                </td>
                                            </tr>
                                            <tr style="background-color: #F9FBE7">
                                                <td>
                                                    &ensp;&ensp;&ensp;{{ $AboutAns->AboutAssets ?? '' }}
                                                </td>
                                            </tr>
                                            <tr style="background-color: #F1F8E9">
                                                <td class="fw-bold">
                                                    Q5. What are your areas where you think you need to improve yourself?
                                                </td>
                                            </tr>
                                            <tr style="background-color: #F9FBE7">
                                                <td>
                                                    &ensp;&ensp;&ensp;{{ $AboutAns->AboutImprovement ?? '' }}
                                                </td>
                                            </tr>
                                            <tr style="background-color: #F1F8E9">
                                                <td class="fw-bold">
                                                    Q6. What are your Strengths?
                                                </td>
                                            </tr>
                                            <tr style="background-color: #F9FBE7">
                                                <td>
                                                    &ensp;&ensp;&ensp;{{ $AboutAns->AboutStrength ?? '' }}
                                                </td>
                                            </tr>
                                            <tr style="background-color: #F1F8E9">
                                                <td class="fw-bold">
                                                    Q7. In the past or at present, have/are you suffered /suffering from,
                                                    any form of physical disability or any minor or major illness or
                                                    deficiency?
                                                </td>
                                            </tr>
                                            <tr style="background-color: #F9FBE7">
                                                <td>
                                                    &ensp;&ensp;&ensp;{{ $AboutAns->AboutDeficiency ?? '' }}
                                                </td>
                                            </tr>
                                            <tr style="background-color: #F1F8E9">
                                                <td class="fw-bold">
                                                    Q8. Have you Been criminally prosecuted? if so, give details separately.
                                                </td>
                                            </tr>
                                            <tr style="background-color: #F9FBE7">
                                                <td>
                                                    &ensp;&ensp;&ensp;
                                                    @if ($AboutAns != null)
                                                        {{ $AboutAns->CriminalChk == 'Y' ? 'Yes' : 'No' }}
                                                    @endif

                                                </td>
                                            </tr>
                                            <tr style="background-color: #F1F8E9">
                                                <td class="fw-bold">
                                                    Q9. Do You have a valid driving licence?
                                                </td>
                                            </tr>
                                            <tr style="background-color: #F9FBE7">
                                                <td>
                                                    &ensp;&ensp;&ensp;{{ $AboutAns->AboutDeficiency ?? '' }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="cand_document">

                <div class="row">
                    <div class="col-md-12 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h6 class="card-title">Documents
                                    <a href="#" class="edit-icon" data-bs-toggle="modal"
                                        data-bs-target="#document_modal">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                </h6>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%" class=" text-center">S.No</th>
                                                <th class="text-center" style="width: 20%">Document Name</th>
                                                <th class="text-center">View</th>
                                                <th style="width: 5%" class=" text-center">S.No</th>
                                                <th class="text-center" style="width: 20%">Document Name</th>
                                                <th>View</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class=" text-center">1</td>
                                                <td>Aadhaar Card</td>
                                                <td style="width: 10%; text-align:center">
                                                    @if ($Docs != null && $Docs->Aadhar != null)
                                                        <a href="{{ URL::to('/') }}/uploads/Documents/{{ $Docs->Aadhar }}"
                                                            class="view-pdf">View</a>
                                                    @endif
                                                </td>

                                                <td class=" text-center">10</td>
                                                <td>Ethical</td>
                                                <td style="width: 10%; text-align:center">
                                                    @if ($Docs != null && $Docs->Ethical != null)
                                                        <a href="{{ URL::to('/') }}/uploads/Documents/{{ $Docs->Ethical }}"
                                                            class="view-pdf">View</a>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=" text-center">2</td>
                                                <td>PAN Card</td>
                                                <td style="width: 10%; text-align:center">
                                                    @if ($Docs != null && $Docs->PanCard != null)
                                                        <a href="{{ URL::to('/') }}/uploads/Documents/{{ $Docs->PanCard }}"
                                                            class="view-pdf">View</a>
                                                    @endif
                                                </td>

                                                <td class=" text-center">11</td>
                                                <td>DL</td>
                                                <td style="width: 10%; text-align:center">
                                                    @if ($Docs != null && $Docs->DL != null)
                                                        <a href="{{ URL::to('/') }}/uploads/Documents/{{ $Docs->DL }}"
                                                            class="view-pdf">View</a>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=" text-center">3</td>
                                                <td>Passport</td>
                                                <td style="width: 10%; text-align:center">
                                                    @if ($Docs != null && $Docs->Passport != null)
                                                        <a href="{{ URL::to('/') }}/uploads/Documents/{{ $Docs->Passport }}"
                                                            class="view-pdf">View</a>
                                                    @endif
                                                </td>

                                                <td class=" text-center">12</td>
                                                <td>BloodGroup</td>
                                                <td style="width: 10%; text-align:center">
                                                    @if ($Docs != null && $Docs->BloodGroup != null)
                                                        <a href="{{ URL::to('/') }}/uploads/Documents/{{ $Docs->BloodGroup }}"
                                                            class="view-pdf">View</a>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=" text-center">4</td>
                                                <td>PF Form2</td>
                                                <td style="width: 10%; text-align:center">
                                                    @if ($Docs != null && $Docs->PF_Form2 != null)
                                                        <a href="{{ URL::to('/') }}/uploads/Documents/{{ $Docs->PF_Form2 }}"
                                                            class="view-pdf">View</a>
                                                    @endif
                                                </td>

                                                <td class=" text-center">13</td>
                                                <td>OfferLtr</td>
                                                <td style="width: 10%; text-align:center">
                                                    @if ($Docs != null && $Docs->OfferLtr != null)
                                                        <a href="{{ URL::to('/') }}/uploads/Documents/{{ $Docs->OfferLtr }}"
                                                            class="view-pdf">View</a>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=" text-center">5</td>
                                                <td>PF Form11</td>
                                                <td style="width: 10%; text-align:center">
                                                    @if ($Docs != null && $Docs->PF_Form11 != null)
                                                        <a href="{{ URL::to('/') }}/uploads/Documents/{{ $Docs->PF_Form11 }}"
                                                            class="view-pdf">View</a>
                                                    @endif
                                                </td>

                                                <td class=" text-center">14</td>
                                                <td>RelievingLtr</td>
                                                <td style="width: 10%; text-align:center">
                                                    @if ($Docs != null && $Docs->RelievingLtr != null)
                                                        <a href="{{ URL::to('/') }}/uploads/Documents/{{ $Docs->RelievingLtr }}"
                                                            class="view-pdf">View</a>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=" text-center">6</td>
                                                <td>Gratutity</td>
                                                <td style="width: 10%; text-align:center">
                                                    @if ($Docs != null && $Docs->Gratutity != null)
                                                        <a href="{{ URL::to('/') }}/uploads/Documents/{{ $Docs->Gratutity }}"
                                                            class="view-pdf">View</a>
                                                    @endif
                                                </td>

                                                <td class=" text-center">15</td>
                                                <td>SalarySlip</td>
                                                <td style="width: 10%; text-align:center">
                                                    @if ($Docs != null && $Docs->SalarySlip != null)
                                                        <a href="{{ URL::to('/') }}/uploads/Documents/{{ $Docs->SalarySlip }}"
                                                            class="view-pdf">View</a>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=" text-center">7</td>
                                                <td>ESIC</td>
                                                <td style="width: 10%; text-align:center">
                                                    @if ($Docs != null && $Docs->ESIC != null)
                                                        <a href="{{ URL::to('/') }}/uploads/Documents/{{ $Docs->ESIC }}"
                                                            class="view-pdf">View</a>
                                                    @endif
                                                </td>

                                                <td class=" text-center">16</td>
                                                <td>AppraisalLtr</td>
                                                <td style="width: 10%; text-align:center">
                                                    @if ($Docs != null && $Docs->AppraisalLtr != null)
                                                        <a href="{{ URL::to('/') }}/uploads/Documents/{{ $Docs->AppraisalLtr }}"
                                                            class="view-pdf">View</a>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=" text-center">8</td>
                                                <td>ESIC_Family</td>
                                                <td style="width: 10%; text-align:center">
                                                    @if ($Docs != null && $Docs->ESIC_Family != null)
                                                        <a href="{{ URL::to('/') }}/uploads/Documents/{{ $Docs->ESIC_Family }}"
                                                            class="view-pdf">View</a>
                                                    @endif
                                                </td>

                                                <td class=" text-center">17</td>
                                                <td>VaccinationCert</td>
                                                <td style="width: 10%; text-align:center">
                                                    @if ($Docs != null && $Docs->VaccinationCert != null)
                                                        <a href="{{ URL::to('/') }}/uploads/Documents/{{ $Docs->VaccinationCert }}"
                                                            class="view-pdf">View</a>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=" text-center">9</td>
                                                <td>Health</td>
                                                <td style="width: 10%; text-align:center">
                                                    @if ($Docs != null && $Docs->Health != null)
                                                        <a href="{{ URL::to('/') }}/uploads/Documents/{{ $Docs->Health }}"
                                                            class="view-pdf">View</a>
                                                    @endif
                                                </td>

                                                <td class=" text-center">18</td>
                                                <td>BankDoc</td>
                                                <td style="width: 10%; text-align:center">
                                                    @if ($Docs != null && $Docs->BankDoc != null)
                                                        <a href="{{ URL::to('/') }}/uploads/Documents/{{ $Docs->BankDoc }}"
                                                            class="view-pdf">View</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <div class="tab-pane fade" id="cand_history">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h6 class="card-title">Job Application History </h6>
                                <div class="table-responsive">
                                    <table class="table table-bordered text-center">
                                        <thead>
                                            <th>Action</th>
                                            <th>Date</th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Job Applied</td>
                                                <td> {{ date('d-M-Y', strtotime($Rec->ApplyDate)) }}</td>
                                            </tr>
                                            @if ($Rec->Status != null)
                                                <tr>
                                                    <td>HR Screening Status</td>
                                                    <td>{{ $Rec->Status }}</td>
                                                </tr>
                                            @endif
                                            @if ($Rec->Status == 'Selected')
                                                <tr>
                                                    <td>Forwarded for Technical Screening</td>
                                                    <td>{{ $Rec->FwdTechScr }}</td>
                                                </tr>
                                                @if ($Rec->FwdTechScr == 'Yes')
                                                    <tr>
                                                        <td>Technical Screening Sent Date</td>
                                                        <td> {{ date('d-M-Y', strtotime($Rec->ReSentForScreen)) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Technical Screening Status</td>
                                                        <td>{{ $Rec->ScreenStatus }}</td>
                                                    </tr>
                                                @endif
                                            @endif

                                            @if ($Rec->ScreenStatus == 'Shortlist')
                                                <tr>
                                                    <td>Inderview Date</td>
                                                    <td>{{ date('d-M-Y', strtotime($Rec->IntervDt)) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Interview Status</td>
                                                    <td>{{ $Rec->IntervStatus }}</td>
                                                </tr>
                                            @endif
                                            @if ($Rec->IntervStatus == '2nd Round Interview')
                                                <tr>
                                                    <td>2nd Round Interview Date</td>
                                                    <td>{{ date('d-M-Y', strtotime($Rec->IntervDt2)) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>2nd Round Interview Status</td>
                                                    <td>{{ $Rec->IntervStatus2 }}</td>
                                                </tr>
                                            @endif
                                            @if ($Rec->SelectedForD != null)
                                                <tr>
                                                    <td>Offer Letter Sent</td>
                                                    <td>{{ $OfBasic->OfferLetterSent ?? '' }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Offer Letter Status</td>
                                                    <td>{{ $OfBasic->Answer ?? '' }}</td>
                                                </tr>
                                            @endif

                                            @if ($OfBasic != null && $OfBasic->Answer == 'Rejected')
                                                <tr>
                                                    <td>Offer Letter Rejected Reason</td>
                                                    <td>{{ $OfBasic->RejReason }}</td>
                                                </tr>
                                            @endif
                                            @if ($OfBasic != null && $OfBasic->Answer == 'Accepted')
                                                <tr>
                                                    <td>Joining Form Sent</td>
                                                    <td>{{ $OfBasic->JoiningFormSent }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Joining Form Status</td>
                                                    <td>{{ $Rec->FinalSubmit == 1 ? 'Submitted' : 'Not Submitted' }}
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="card">
                            <div class="card-body ">
                                <h6 class="card-title">Candidate Log</h6>
                                <table class="table table-bordered text-center table-striped " id="CandLogTable">
                                    <thead>
                                        <th>S.No</th>
                                        <th style="width: 20%">Date</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 0;
                                        @endphp
                                        @foreach ($candidate_log as $item => $value)
                                            <tr>
                                                <td>{{ ++$i }}</td>
                                                <td>{{ date('d-M-Y', strtotime($value->Date)) }}</td>
                                                <td>{{ $value->Description }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="job_offer">

                <div class="row">
                    <div class="col-md-5 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h6 class="card-title">Offer Letter Basic Details
                                    @if ($OfBasic == null || $OfBasic->Answer == 'Rejected')
                                        <a href="#" class="edit-icon" data-bs-toggle="modal"
                                            data-bs-target="#OfferLtrModal" id="offerltredit"
                                            data-id="{{ $Rec->JAId }}">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    @endif
                                </h6>
                                <ul class="personal-info">
                                    <li>
                                        <div class="title" style="width: 150px;">Department<span
                                                style="float: right">:</span></div>
                                        <div class="text">
                                            @if ($OfBasic != null)
                                                {{ getDepartment($OfBasic->Department) ?? '-' }}
                                                ({{ getCompanyCode($OfBasic->Company) }})
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </li>
                                    <li>
                                        <div class="title" style="width: 150px;">Designation<span
                                                style="float: right">:</span></div>
                                        <div class="text">
                                            @if ($OfBasic != null)
                                                @if ($OfBasic->Designation == 0)
                                                    -
                                                @else
                                                    {{ getDesignation($OfBasic->Designation) ?? '-' }}
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </li>
                                    <li>
                                        <div class="title" style="width: 150px;">Grade<span
                                                style="float: right">:</span></div>
                                        <div class="text">
                                            @if ($OfBasic != null)
                                                @if ($OfBasic->Grade == 0)
                                                    -
                                                @else
                                                    {{ getGradeValue($OfBasic->Grade) ?? '-' }}
                                                @endif

                                            @else
                                                -
                                            @endif
                                        </div>
                                    </li>
                                    <li>
                                        <div class="title" style="width: 150px;">Reporting Mgr.<span
                                                style="float: right">:</span></div>
                                        <div class="text">
                                            @if ($OfBasic != null)
                                                @if ($OfBasic->A_ReportingManager == '' || $OfBasic->A_ReportingManager == null)
                                                    -
                                                @else
                                                    {{ getFullName($OfBasic->A_ReportingManager) ?? '-' }}
                                                @endif

                                            @else
                                                -
                                            @endif
                                        </div>
                                    </li>
                                    <li>
                                        <div class="title" style="width: 150px;">CTC<span
                                                style="float: right">:</span></div>
                                        <div class="text">
                                            @if ($OfBasic != null)
                                                @if ($OfBasic->CTC == '' || $OfBasic->CTC == null)
                                                    -
                                                @else
                                                    {{ $OfBasic->CTC ?? '-' }}
                                                @endif

                                            @else
                                                -
                                            @endif
                                        </div>
                                    </li>
                                    <li>
                                        <div class="title" style="width: 150px;">Service Condition<span
                                                style="float: right">:</span></div>
                                        <div class="text">
                                            @if ($OfBasic != null)
                                                @if ($OfBasic->ServiceCondition == 'Training')
                                                    Training
                                                @elseif($OfBasic->ServiceCondition == 'Probation')
                                                    Probation
                                                @elseif($OfBasic->ServiceCondition == 'nopnot')
                                                    No Probation No Training
                                                @else
                                                    -
                                                @endif
                                            @endif
                                        </div>
                                    </li>

                                    <li>
                                        <div class="title" style="width: 150px;">Service Bond<span
                                                style="float: right">:</span></div>
                                        <div class="text">
                                            @if ($OfBasic != null)
                                                @if ($OfBasic->ServiceBond == 'Yes')
                                                    Yes
                                                @elseif($OfBasic->ServiceBond == 'No')
                                                    No
                                                @else
                                                    -
                                                @endif
                                            @endif
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                @if ($OfBasic == null || $OfBasic->Answer == 'Rejected')
                                    <h6 class="card-title">Offer Letter Generation & Review
                                        <a href="javascript:void(0);" class="edit-icon" id="offerltrgen"
                                            data-id="{{ $Rec->JAId }}">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    </h6>
                                @endif
                                <ul class="personal-info">
                                    <li>
                                        <div class="title" style="width: 150px;">Offer Letter Generate<span
                                                style="float: right">:</span></div>
                                        <div class="text">
                                            @if ($OfBasic != null && $OfBasic->OfferLtrGen == 1)
                                                <span class="text-dark">Yes</span>
                                            @else
                                                <span class="text-danger">No</span>
                                            @endif
                                            @if ($count > 1)
                                                ( <a href="javascript:vaoid(0);" class="offer-history-btn"
                                                    data-bs-toggle="modal" data-bs-target="#HistoryModal"
                                                    onclick="getOfHistory({{ $Rec->JAId }});"> View History</a>)
                                            @endif

                                        </div>
                                    </li>
                                    <li>
                                        <div class="title" style="width: 150px;">Offer Letter Send<span
                                                style="float: right">:</span></div>
                                        <div class="text">
                                            @if ($OfBasic != null && $OfBasic->OfferLetterSent == 'Yes')
                                                <span class="text-dark">Yes</span>
                                            @else
                                                <span class="text-danger">No</span> ( <a href="javascript:void(0);"
                                                    class="" onclick="sendOfferLtr({{ $Rec->JAId }});">
                                                    Send Now</a>)
                                            @endif
                                        </div>
                                    </li>
                                    <li>
                                        <div class="title" style="width: 150px;">Acceptance Status<span
                                                style="float: right">:</span></div>
                                        <div class="text"> <span
                                                class="text-danger">{{ $OfBasic->Answer ?? '-' }}</span>
                                            @if ($OfBasic != null && $OfBasic->Answer == 'Rejected')
                                                ( <a href="javascript:void(0);" class=""
                                                    onclick="offerReopen({{ $Rec->JAId }});"> Offer Reopen</a>)
                                            @endif
                                        </div>
                                    </li>

                                    @if ($OfBasic != null && $OfBasic->Answer == 'Rejected')
                                        <li>
                                            <div class="title" style="width: 150px;">Rejection Reason<span
                                                    style="float: right">:</span></div>
                                            <div class="text text-danger">
                                                @if ($OfBasic != null)
                                                    {{ $OfBasic->RejReason ?? '-' }}
                                                @endif
                                            </div>
                                        </li>

                                    @endif
                                    <li>
                                        <div class="title" style="width: 150px;">Date of Joining<span
                                                style="float: right">:</span></div>
                                        <div class="text">
                                            <input type="date" class="form-control frminp form-control-sm d-inline-block"
                                                id="dateofJoin" name="" readonly="" style="width: 130px;"
                                                value="{{ $OfBasic->JoinOnDt ?? '' }}">
                                            <i class="fa fa-pencil text-primary" aria-hidden="true" id="joindtenable"
                                                onclick="joinDateEnbl()"
                                                style="font-size: 16px;cursor: pointer; display: "></i>
                                            <button class="btn btn-sm frmbtn btn-primary" style="display: none;"
                                                id="JoinSave" onclick="saveJoinDate()">Save</button>
                                            <button class="btn btn-sm frmbtn btn-danger" style="display: none;"
                                                id="JoinCanc" onclick="window.location.reload();">Cancel</button>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="title" style="width: 150px;">Joining Form Sent<span
                                                style="float: right">:</span></div>
                                        <div class="text">
                                            @if ($OfBasic != null && $OfBasic->JoiningFormSent == 'Yes')
                                                <span class="text-dark">Yes</span>
                                            @else
                                                <span class="text-danger">No</span> ( <a href="javascript:void(0);"
                                                    class=""
                                                    onclick="sendJoiningForm({{ $Rec->JAId }});"> Send Now</a>)
                                            @endif
                                    </li>
                                    <li>
                                        <div class="title" style="width: 150px;">Send for Review<span
                                                style="float: right">:</span></div>
                                        <div class="text">
                                            @if ($OfBasic != null && $OfBasic->SendReview == 1)
                                                <span class="text-dark">Yes</span> ( <a href="javascript:void(0);"
                                                    onclick="viewReview({{ $Rec->JAId }});" data-bs-toggle="modal"
                                                    data-bs-target="#view_review">View</a>)
                                            @else
                                                <span class="text-danger">No</span>
                                            @endif
                                            (<a href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#review_modal">
                                                Send Now</a>)
                                        </div>
                                    </li>
                                    <li>
                                        <div class="title" style="width: 150px;">Ref. Check <span
                                                style="float: right">:</span>
                                        </div>
                                        <div class="text">
                                            @if ($OfBasic != null && $OfBasic->SendForRefChk == 1)
                                                <span class="text-dark">Yes</span>
                                                (<a href="{{ route('view_reference_check') }}?jaid={{ base64_encode($Rec->JAId) }}"
                                                    target="_blank">View</a>)
                                            @else
                                                <span class="text-danger">No</span>( <a href="javascript:void(0);"
                                                    class="" data-bs-toggle="modal"
                                                    data-bs-target="#ref_modal">
                                                    Send Now</a>)
                                            @endif
                                        </div>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    @if ($OfBasic != null && $OfBasic->Answer == 'Accepted')
                        <div class="col-md-5 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="card-body">
                                    <h6 class="card-title">Joining Details </h6>
                                    <ul class="personal-info">
                                        <li>
                                            <div class="title" style="width: 150px;"> Appointment Letter <span
                                                    style="float: right">:</span> </div>

                                            <div class="text  text-dark">
                                                @if ($Rec->AppLtrGen == 'No' || $Rec->AppLtrGen == null)
                                                    <i class="fa fa-pencil text-primary" aria-hidden="true"
                                                        onclick="appointmentGen({{ $Rec->JAId }})"
                                                        style="font-size: 16px;cursor: pointer; display: ">Generate </i>
                                                @else
                                                    <a href="{{ route('appointment_letter') }}?jaid={{ base64_encode($JAId) }}"
                                                        target="_blank"> View</a> | <a href="javascript:void(0);"
                                                        onclick="PrintAppointmentLetter('{{ route('appointment_ltr_print') }}?jaid={{ $Rec->JAId }}');">
                                                        Print</a>
                                                @endif

                                            </div>
                                        </li>
                                        <li>
                                            <div class="title" style="width: 150px;"> Service Agreement <span
                                                    style="float: right">:</span> </div>
                                            <div class="text  text-dark">
                                                @if ($Rec->AgrLtrGen == 'No' || $Rec->AgrLtrGen == null)
                                                    <i class="fa fa-pencil text-primary" aria-hidden="true"
                                                        onclick="ServiceAgrGen({{ $Rec->JAId }})"
                                                        style="font-size: 16px;cursor: pointer; display: ">Generate </i>
                                                @else
                                                    <a href="{{ route('service_agreement') }}?jaid={{ base64_encode($JAId) }}"
                                                        target="_blank"> View</a> | <a href="javascript:void(0);"
                                                        onclick="PrintServiceAgreementLetter('{{ route('service_agreement_print') }}?jaid={{ base64_encode($Rec->JAId) }}');">
                                                        Print</a>
                                                @endif

                                            </div>
                                        </li>
                                        <li>
                                            <div class="title" style="width: 150px;"> Service Bond <span
                                                    style="float: right">:</span> </div>
                                            <div class="text  text-dark">
                                                @if ($Rec->BLtrGen == 'No' || $Rec->BLtrGen == null)
                                                    <i class="fa fa-pencil text-primary" aria-hidden="true"
                                                        onclick="ServiceBondGen({{ $Rec->JAId }})"
                                                        style="font-size: 16px;cursor: pointer; display: ">Generate </i>
                                                @else
                                                    <a href="{{ route('service_agreement') }}?jaid={{ base64_encode($JAId) }}"
                                                        target="_blank"> View</a> | <a href="javascript:void(0);"
                                                        onclick="PrintServiceBondLetter('{{ route('service_bond_print') }}?jaid={{ base64_encode($Rec->JAId) }}');">
                                                        Print</a>
                                                @endif
                                            </div>
                                        </li>

                                        <li>
                                            <div class="title" style="width: 150px;"> Verify Joining Form <span
                                                    style="float: right">:</span> </div>
                                            <div class="text  text-dark">
                                                <select name="Verification" id="Verification"
                                                    class="form-select form-select-sm frminp d-inline" disabled
                                                    style="width: 100px;">
                                                    <option value="Not Verified">Not Verified</option>
                                                    <option value="Verified"
                                                        {{ $OfBasic->Verification == 'Verified' ? 'selected' : '' }}>
                                                        Verified
                                                    </option>
                                                </select>
                                                <i class="fa fa-pencil text-primary" aria-hidden="true"
                                                    id="VerificationEnable" onclick="VerificationEnable()"
                                                    style="font-size: 16px;cursor: pointer; display: "></i>
                                                <button class="btn btn-sm frmbtn btn-primary" style="display: none;"
                                                    id="SaveVerification">Save</button>
                                                <button class="btn btn-sm frmbtn btn-danger" style="display: none;"
                                                    id="verificationCancle"
                                                    onclick="window.location.reload();">Cancel</button>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="title" style="width: 150px;"> Candidate Joined <span
                                                    style="float: right">:</span> </div>
                                            <div class="text  text-dark">
                                                <select name="Joined" id="Joined"
                                                    class="form-select form-select-sm frminp d-inline" disabled
                                                    style="width: 100px;">
                                                    <option value="No">No</option>
                                                    <option value="Yes"
                                                        {{ $OfBasic->Joined == 'Yes' ? 'selected' : '' }}>Yes
                                                    </option>
                                                </select>
                                                <i class="fa fa-pencil text-primary" aria-hidden="true" id="JoinedEnbl"
                                                    onclick="JoinedEnbl()"
                                                    style="font-size: 16px;cursor: pointer; display: "></i>
                                                <button class="btn btn-sm frmbtn btn-primary" style="display: none;"
                                                    id="SaveJoined">Save</button>
                                                <button class="btn btn-sm frmbtn btn-danger" style="display: none;"
                                                    id="JoinedCancle" onclick="window.location.reload();">Cancel</button>
                                            </div>
                                        </li>
                                        @if ($OfBasic->Joined == 'Yes')
                                            <li>
                                                <div class="title" style="width: 150px;">Emp Code<span
                                                        style="float: right">:</span></div>
                                                <div class="text">
                                                    <input type="text"
                                                        class="form-control frminp form-control-sm d-inline-block"
                                                        id="empCode" name="" readonly="" style="width: 100px;"
                                                        value="{{ $OfBasic->EmpCode ?? '' }}">
                                                    <i class="fa fa-pencil text-primary" aria-hidden="true"
                                                        id="empCodeEnable" onclick="empCodeEnable()"
                                                        style="font-size: 16px;cursor: pointer; display: "></i>
                                                    <button class="btn btn-sm frmbtn btn-primary" style="display: none;"
                                                        id="EmpCodeSave" onclick="saveEmpCode()">Save</button>
                                                    <button class="btn btn-sm frmbtn btn-danger" style="display: none;"
                                                        id="empCancle" onclick="window.location.reload();">Cancel</button>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="title" style="width: 150px;">Position Code<span
                                                        style="float: right">:</span></div>
                                                <div class="text">
                                                    <input type="text"
                                                        class="form-control frminp form-control-sm d-inline-block"
                                                        id="PositionCode" name="PositionCode" readonly=""
                                                        style="width: 100px;"
                                                        value="{{ $OfBasic->PositionCode ?? '' }}">
                                                    <i class="fa fa-pencil text-primary" aria-hidden="true" id="PosEnbl"
                                                        onclick="PosEnbl()"
                                                        style="font-size: 16px;cursor: pointer; display: "></i>
                                                    <button class="btn btn-sm frmbtn btn-primary" style="display: none;"
                                                        id="PositionCodeSave" onclick="PositionCodeSave()">Save</button>
                                                    <button class="btn btn-sm frmbtn btn-danger" style="display: none;"
                                                        id="posCancle" onclick="window.location.reload();">Cancel</button>
                                                </div>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="col-md-7 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h6 class="card-title">Links

                                </h6>
                                <ul class="personal-info">
                                    @if ($OfBasic != null && $OfBasic->OfferLtrGen == '1')
                                        <li>
                                            <div class="title" style="width: 150px;">Offer Letter<span
                                                    style="float: right">:</span></div>
                                            <div class="text"><input type="text" name="" id="oflink"
                                                    class="frminp d-inline"
                                                    value="{{ route('candidate-offer-letter') }}?jaid={{ $sendingId }}">
                                                <button class="frmbtn btn btn-sm btn-secondary"
                                                    onclick="copyOfLink();">Copy
                                                    Link</button>
                                            </div>
                                        </li>
                                    @endif

                                    <li>
                                        <div class="title" style="width: 150px;">Interview Form<span
                                                style="float: right">:</span></div>
                                        <div class="text"><input type="text" name="" id="interviewlink"
                                                class="frminp d-inline"
                                                value="{{ route('candidate-interview-form') }}?jaid={{ $sendingId }}">
                                            <button class="frmbtn btn btn-sm btn-secondary"
                                                onclick="copyJIntFrmLink();">Copy
                                                Link</button>
                                        </div>
                                    </li>
                                    @if ($Rec->InterviewSubmit == 1)
                                        <li>
                                            <div class="title" style="width: 150px;">Joining Form<span
                                                    style="float: right">:</span></div>
                                            <div class="text"><input type="text" name="" id="jflink"
                                                    class="frminp d-inline"
                                                    value="{{ route('candidate-joining-form') }}?jaid={{ $sendingId }}">
                                                <button class="frmbtn btn btn-sm btn-secondary"
                                                    onclick="copyJFrmLink();">Copy
                                                    Link</button>
                                            </div>
                                        </li>
                                    @endif
                                    <li>
                                        <div class="title" style="width: 150px;">FIRO B Test<span
                                                style="float: right">:</span></div>
                                        <div class="text">

                                            <input type="text" name="" id="firoblink" class="frminp d-inline"
                                                value="{{ route('firo_b') }}?jcid={{ $firobid }}">
                                            <button class="frmbtn btn btn-sm btn-secondary" onclick="copyFiroBlink();">Copy
                                                Link</button>



                                            @if ($Rec->FIROB_Test == 1)
                                                <span style="margin-left: 20px;"><a href="javascript:void(0);"
                                                        onclick='window.open("{{ route('firob_result') }}?jcid={{ $JCId }}", "", "width=750,height=900");'>Result
                                                        1</a> </span> | <span style="margin-left: 20px;"><a
                                                        href="javascript:void(0);"
                                                        onclick='window.open("{{ route('firob_result_summery') }}?jcid={{ $JCId }}", "", "width=750,height=900");'>Result
                                                        2</a> </span>
                                            @endif
                                        </div>
                                    </li>
                                </ul>
                                <br>
                                <br>
                                @if ($OfBasic != null)
                                    @if ($OfBasic->ForwardToESS == 'No' || ($OfBasic->ForwardToESS == null && $OfBasic->Joined == 'Yes'))
                                        <center><button class="btn btn-sm btn-primary" id="ProcessToEss">Process Data to
                                                Ess
                                            </button>
                                        </center>
                                    @endif
                                @endif
                                @if ($OfBasic != null && $OfBasic->ForwardToESS == 'Yes')
                                    <center>
                                        <h3 class="text-success">Data Forwarded to ESS</h3>
                                    </center>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="compose-mail-popup" style="display: none;">
        <div class="card">
            <div class="card-header bg-dark text-white py-2 cursor-pointer">
                <div class="d-flex align-items-center">
                    <div class="compose-mail-title">New Message</div>
                    <div class="compose-mail-close ms-auto">x</div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('sendMailToCandidate') }}" method="POST" id="SendMailForm">
                    <div class="email-form">
                        <div class="mb-3">
                            <input type="hidden" name="CandidateName" id="CandidateName"
                                value="{{ $Rec->FName }} {{ $Rec->LName }}">
                            <input type="text" class="form-control" value="{{ $Rec->Email }}" readonly name="eMailId"
                                id="eMailId">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Subject" name="Subject" id="Subject">
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" placeholder="Message" rows="10" cols="10" name="eMailMsg"
                                id="eMailMsg"></textarea>
                        </div>
                        <div class="mb-0">
                            <div style="float: right">
                                <button class="btn btn-primary submit-btn" id="send_mail_btn">Send</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="overlay email-toggle-btn-mobile"></div>

    <div id="profile_info" class="modal custom-modal fade" role="dialog" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Profile Information</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="CandidateProfileForm" action="{{ route('Candidate_ProfileData_Save') }}" method="POST">
                        <input type="hidden" name="Pro_JCId" id="Pro_JCId">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="FName" id="FName" class="form-control form-control-sm">
                        </div>

                        <div class="form-group">
                            <label>Middle Name</label>
                            <input class="form-control form-control-sm" type="text" id="MName" name="MName">
                        </div>

                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="LName" id="LName" class="form-control form-control-sm">
                        </div>

                        <div class="form-group">
                            <label>Date of Birth</label>
                            <input class="form-control form-control-sm" type="date" id="DOB" name="DOB">
                        </div>

                        <div class="form-group">
                            <label>Mobile</label>
                            <input type="text" name="Mobile" id="Mobile" class="form-control form-control-sm">
                        </div>

                        <div class="form-group">
                            <label>Email ID</label>
                            <input type="text" name="EMail" id="EMail" class="form-control form-control-sm">
                        </div>

                        <div class="form-group">
                            <label>Candidate Image</label>

                            <input type="file" name="CandidateImage" id="CandidateImage"
                                class="form-control form-control-sm">
                        </div>

                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="personal_info_modal" class="modal custom-modal fade" role="dialog" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Personal Information</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="CandidatePersonalForm" action="{{ route('Candidate_PersonalData_Save') }}" method="POST">

                        <input type="hidden" name="P_JCId" id="P_JCId">
                        <div class="form-group">
                            <label>Gender</label>
                            <select name="Gender" id="Gender" class="form-select form-select-sm">
                                <option value="">Select</option>
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Aadhaar No</label>
                            <input class="form-control form-control-sm" type="text" id="Aadhaar" name="Aadhaar">
                        </div>
                        <div class="form-group">
                            <label>Nationality</label>
                            <select name="Nationality" id="Nationality" class="form-select form-select-sm">
                                <option value="">Select</option>
                                @foreach ($country_list as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="form-group">
                            <label>Religion</label>
                            <select name="Religion" id="Religion" class="form-select form-select-sm">
                                <option value="Hinduism">Hinduism</option>
                                <option value="Islam">Islam</option>
                                <option value="Christianity">Christianity</option>
                                <option value="Sikhism">Sikhism</option>
                                <option value="Buddhism">Buddhism</option>
                                <option value="Jainism">Jainism</option>
                                <option value="Others">Others</option>
                            </select>
                            <input type="text" name="OtherReligion" id="OtherReligion"
                                class="form-control form-control-sm d-none mt-2" placeholder="Other Religion">
                        </div>
                        <div class="form-group">
                            <label>Marital Status</label>
                            <select name="MaritalStatus" id="MaritalStatus" class="form-select form-select-sm">
                                <option value=""></option>
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Divorced">Divorced</option>
                                <option value="Widowed">Widowed</option>
                            </select>
                        </div>
                        <div class="form-group d-none" id="MDate">
                            <label>Marriage Date</label>
                            <input type="date" name="MarriageDate" id="MarriageDate" class="form-select form-select-sm">
                        </div>
                        <div class="form-group d-none" id="Spouse">
                            <label>spouse Name</label>
                            <input class="form-control form-control-sm" type="text" id="SpouseName" name="SpouseName">
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <select name="Category" id="Category" class="form-select form-select-sm">
                                <option value="ST">ST</option>
                                <option value="SC">SC</option>
                                <option value="OBC">OBC</option>
                                <option value="General">General</option>
                                <option value="Other">Other</option>
                            </select>
                            <input type="text" name="OtherCategory" id="OtherCategory"
                                class="form-control form-control-sm d-none mt-2" placeholder="Other Category">
                        </div>

                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="emergency_contact_modal" class="modal custom-modal fade" role="dialog" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Emergency Contact</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="EmergencyContactForm" action="{{ route('Candidate_EmergencyContact_Save') }}"
                        method="POST">
                        <input type="hidden" name="Emr_JCId" id="Emr_JCId">
                        <p class="mb-1 fw-bold">Primary Emergency Contact ---------------------------</p>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="PrimaryName">Name</label>
                                    <input type="text" name="PrimaryName" id="PrimaryName"
                                        class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="PrimaryRelation">Relationship</label>
                                    <input type="text" name="PrimaryRelation" id="PrimaryRelation"
                                        class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="PrimaryPhone">Phone No</label>
                                    <input type="text" name="PrimaryPhone" id="PrimaryPhone"
                                        class="form-control form-control-sm">
                                </div>
                            </div>
                        </div>
                        <p class="mb-1 fw-bold mt-2">Secondary Emergency Contact <small class="text-danger"> (optional)
                            </small></p>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="SecondaryName">Name</label>
                                    <input type="text" name="SecondaryName" id="SecondaryName"
                                        class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="SecondaryRelation">Relationship</label>
                                    <input type="text" name="SecondaryRelation" id="SecondaryRelation"
                                        class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="SecondaryPhone">Phone No</label>
                                    <input type="text" name="SecondaryPhone" id="SecondaryPhone"
                                        class="form-control form-control-sm">
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="bank_info_modal" class="modal custom-modal fade" role="dialog" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Bank Information</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="BankInfoForm" action="{{ route('Candidate_BankInfo_Save') }}" method="POST">
                        <input type="hidden" name="Bank_JCId" id="Bank_JCId">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="BankName">Bank Name</label>
                                    <input type="text" name="BankName" id="BankName" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="BranchName">Branch</label>
                                    <input type="text" name="BranchName" id="BranchName"
                                        class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="IFSCCode">IFSC Code</label>
                                    <input type="text" name="IFSCCode" id="IFSCCode" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="AccountNumber">Account Number</label>
                                    <input type="text" name="AccountNumber" id="AccountNumber"
                                        class="form-control form-control-sm">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="PAN">PAN Number</label>
                                    <input type="text" name="PAN" id="PAN" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="UAN">UAN Number</label>
                                    <input type="text" name="UAN" id="UAN" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="PFNumber">PF Number</label>
                                    <input type="text" name="PFNumber" id="PFNumber" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="ESICNumber">ESIC Number</label>
                                    <input type="text" name="ESICNumber" id="ESICNumber"
                                        class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="Passport">Passport</label>
                                    <input type="text" name="Passport" id="Passport" class="form-control form-control-sm">
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="family_info_modal" class="modal custom-modal fade" role="dialog" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Family Information</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="FamilyInfoForm" action="{{ route('Candidate_Family_Save') }}" method="POST">
                        <input type="hidden" name="Family_JCId" id="Family_JCId">
                        <table class="table table-bordered">
                            <thead class="text-center">
                                <tr>
                                    <td style="width: 20%">Relation</td>
                                    <td style="width: 20%">Name</td>
                                    <td style="10%">DOB</td>
                                    <td style="width: 20%">Qualification</td>
                                    <td style="width: 20%">Occupation</td>
                                    <td style="width: 10%">Delete</td>
                                </tr>
                            </thead>
                            <tbody id="FamilyData">

                            </tbody>
                        </table>
                        <input type="button" value="Add Member" id="addMember" class="btn btn-primary btn-sm">
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="current_address_modal" class="modal custom-modal fade" role="dialog" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Current Address</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="CurrentAddressForm" action="{{ route('Candidate_CurrentAddress_Save') }}" method="POST">
                        <input type="hidden" name="Current_JCId" id="Current_JCId">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="PreAddress">Address</label>
                                    <input type="text" name="PreAddress" id="PreAddress"
                                        class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="PreCity">City</label>
                                    <input type="text" name="PreCity" id="PreCity" class="form-control form-control-sm">
                                </div>
                            </div>

                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="PreState">State</label>
                                    <select name="PreState" id="PreState" class="form-select form-select-sm"
                                        onchange="getLocation(this.value);">
                                        <option value="">Select State</option>
                                        @foreach ($state_list as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="spinner-border text-primary d-none" role="status" id="PreDistLoader"><span
                                        class="visually-hidden">Loading...</span></div>
                                <div class="form-group">
                                    <label for="PreDistrict">District</label>
                                    <select name="PreDistrict" id="PreDistrict" class="form-select form-select-sm">
                                        @foreach ($district_list as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="PrePinCode">Pin Code</label>
                                    <input type="text" name="PrePinCode" id="PrePinCode"
                                        class="form-control form-control-sm">
                                </div>
                            </div>

                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="permanent_address_modal" class="modal custom-modal fade" role="dialog" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Current Address</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="PermanentAddressForm" action="{{ route('Candidate_PermanentAddress_Save') }}"
                        method="POST">
                        <input type="hidden" name="Permanent_JCId" id="Permanent_JCId">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="PermAddress">Address</label>
                                    <input type="text" name="PermAddress" id="PermAddress"
                                        class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="PermCity">City</label>
                                    <input type="text" name="PermCity" id="PermCity" class="form-control form-control-sm">
                                </div>
                            </div>

                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="PermState">State</label>
                                    <select name="PermState" id="PermState" class="form-select form-select-sm"
                                        onchange="getLocation1(this.value);">
                                        <option value="">Select State</option>
                                        @foreach ($state_list as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="spinner-border text-primary d-none" role="status" id="PermDistLoader"><span
                                        class="visually-hidden">Loading...</span></div>
                                <div class="form-group">
                                    <label for="PermDistrict">District</label>
                                    <select name="PermDistrict" id="PermDistrict" class="form-select form-select-sm">
                                        @foreach ($district_list as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="PermPinCode">Pin Code</label>
                                    <input type="text" name="PermPinCode" id="PermPinCode"
                                        class="form-control form-control-sm">
                                </div>
                            </div>

                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="education_info_modal" class="modal custom-modal fade" role="dialog" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Educational Qualification</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="EducationInfoForm" action="{{ route('Candidate_Education_Save') }}" method="POST">
                        <input type="hidden" name="Edu_JCId" id="Edu_JCId">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="text-center">
                                    <tr>
                                        <th>Qualification</th>
                                        <th style="width: 20%">Course</th>
                                        <th style="width: 20%">Specialization
                                        </th>
                                        <th>Board/University</th>
                                        <th>Passing Year</th>
                                        <th style="width: 10%">Percentage</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="EducationData">
                                    <tr>
                                        <td>
                                            <input type="text" name="Qualification[]" id="Qualification1"
                                                class="form-control form-control-sm" value="Below 10th" readonly>
                                        </td>
                                        <td>
                                            <select name="Course[]" id="Course1" class="form-select form-select-sm"
                                                onchange="getSpecialization(this.value,1)">
                                                <option value="">Select</option>

                                                @foreach ($education_list as $key => $value)
                                                    <option value="{{ $key }}">
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="Specialization[]" id="Specialization1"
                                                class="form-select form-select-sm">
                                                <option value="">Select</option>
                                                <option value="0">Other</option>
                                                @foreach ($specialization_list as $key => $value)
                                                    <option value="{{ $key }}">
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="Collage[]" id="Collage1" class="form-select form-select-sm"
                                                onchange="getOtherInstitute(1);">
                                                <option value="">Select</option>
                                                <option value="637">Other</option>
                                                @foreach ($institute_list as $key => $value)
                                                    <option value="{{ $key }}">
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <input type="text" name="OtherInstitute[]" id="OtherInstitute1"
                                                class="form-control form-control-sm mt-1 d-none">
                                        </td>
                                        <td>
                                            <select name="PassingYear[]" id="PassingYear1"
                                                class="form-select form-select-sm">
                                                <option value="">Select</option>
                                                @for ($i = 1980; $i <= $Year; $i++)
                                                    <option value="{{ $i }}">
                                                        {{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="Percentage[]" id="Percentage1"
                                                class="form-control form-control-sm">
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" name="Qualification[]" id="Qualification2"
                                                class="form-control form-control-sm" value="10th" readonly>
                                        </td>
                                        <td>
                                            <select name="Course[]" id="Course2" class="form-select form-select-sm"
                                                onchange="getSpecialization(this.value,2)">
                                                <option value="">Select</option>
                                                @foreach ($education_list as $key => $value)
                                                    <option value="{{ $key }}">
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="Specialization[]" id="Specialization2"
                                                class="form-select form-select-sm">
                                                <option value="">Select</option>
                                                <option value="0">Other</option>
                                                @foreach ($specialization_list as $key => $value)
                                                    <option value="{{ $key }}">
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="Collage[]" id="Collage2" class="form-select form-select-sm"
                                                onchange="getOtherInstitute(2);">
                                                <option value="">Select</option>
                                                <option value="637">Other</option>
                                                @foreach ($institute_list as $key => $value)
                                                    <option value="{{ $key }}">
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <input type="text" name="OtherInstitute[]" id="OtherInstitute2"
                                                class="form-control form-control-sm mt-1 d-none">
                                        </td>
                                        <td>
                                            <select name="PassingYear[]" id="PassingYear2"
                                                class="form-select form-select-sm">
                                                <option value="">Select</option>
                                                @for ($i = 1980; $i <= $Year; $i++)
                                                    <option value="{{ $i }}">
                                                        {{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="Percentage[]" id="Percentage2"
                                                class="form-control form-control-sm">
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" name="Qualification[]" id="Qualification3"
                                                class="form-control form-control-sm" value="12th" readonly>
                                        </td>
                                        <td>
                                            <select name="Course[]" id="Course3" class="form-select form-select-sm"
                                                onchange="getSpecialization(this.value,3)">
                                                <option value="">Select</option>
                                                @foreach ($education_list as $key => $value)
                                                    <option value="{{ $key }}">
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="Specialization[]" id="Specialization3"
                                                class="form-select form-select-sm">
                                                <option value="">Select</option>
                                                <option value="0">Other</option>
                                                @foreach ($specialization_list as $key => $value)
                                                    <option value="{{ $key }}">
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="Collage[]" id="Collage3" class="form-select form-select-sm"
                                                onchange="getOtherInstitute(3);">
                                                <option value="">Select</option>
                                                <option value="637">Other</option>
                                                @foreach ($institute_list as $key => $value)
                                                    <option value="{{ $key }}">
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <input type="text" name="OtherInstitute[]" id="OtherInstitute3"
                                                class="form-control form-control-sm mt-1 d-none">
                                        </td>
                                        <td>
                                            <select name="PassingYear[]" id="PassingYear3"
                                                class="form-select form-select-sm">
                                                <option value="">Select</option>
                                                @for ($i = 1980; $i <= $Year; $i++)
                                                    <option value="{{ $i }}">
                                                        {{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="Percentage[]" id="Percentage3"
                                                class="form-control form-control-sm">
                                        </td>
                                        <td></td>

                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" name="Qualification[]" id="Qualification4"
                                                class="form-control form-control-sm" value="Graduation" readonly>
                                        </td>
                                        <td>
                                            <select name="Course[]" id="Course4" class="form-select form-select-sm"
                                                onchange="getSpecialization(this.value,4)">
                                                <option value="">Select</option>
                                                @foreach ($education_list as $key => $value)
                                                    <option value="{{ $key }}">
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="Specialization[]" id="Specialization4"
                                                class="form-select form-select-sm">
                                                <option value="">Select</option>
                                                <option value="0">Other</option>
                                                @foreach ($specialization_list as $key => $value)
                                                    <option value="{{ $key }}">
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="Collage[]" id="Collage4" class="form-select form-select-sm"
                                                onchange="getOtherInstitute(4);">
                                                <option value="">Select</option>
                                                <option value="637">Other</option>
                                                @foreach ($institute_list as $key => $value)
                                                    <option value="{{ $key }}">
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <input type="text" name="OtherInstitute[]" id="OtherInstitute4"
                                                class="form-control form-control-sm mt-1 d-none">
                                        </td>
                                        <td>
                                            <select name="PassingYear[]" id="PassingYear4"
                                                class="form-select form-select-sm">
                                                <option value="">Select</option>
                                                @for ($i = 1980; $i <= $Year; $i++)
                                                    <option value="{{ $i }}">
                                                        {{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="Percentage[]" id="Percentage4"
                                                class="form-control form-control-sm">
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" name="Qualification[]" id="Qualification5"
                                                class="form-control form-control-sm" value="Post_Graduation" readonly>
                                        </td>
                                        <td>
                                            <select name="Course[]" id="Course5" class="form-select form-select-sm"
                                                onchange="getSpecialization(this.value,5)">
                                                <option value="">Select</option>
                                                @foreach ($education_list as $key => $value)
                                                    <option value="{{ $key }}">
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="Specialization[]" id="Specialization5"
                                                class="form-select form-select-sm">
                                                <option value="">Select</option>
                                                <option value="0">Other</option>
                                                @foreach ($specialization_list as $key => $value)
                                                    <option value="{{ $key }}">
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="Collage[]" id="Collage5" class="form-select form-select-sm"
                                                onchange="getOtherInstitute(5);">
                                                <option value="">Select</option>
                                                <option value="637">Other</option>
                                                @foreach ($institute_list as $key => $value)
                                                    <option value="{{ $key }}">
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <input type="text" name="OtherInstitute[]" id="OtherInstitute5"
                                                class="form-control form-control-sm mt-1 d-none">
                                        </td>
                                        <td>
                                            <select name="PassingYear[]" id="PassingYear5"
                                                class="form-select form-select-sm">
                                                <option value="">Select</option>
                                                @for ($i = 1980; $i <= $Year; $i++)
                                                    <option value="{{ $i }}">
                                                        {{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="Percentage[]" id="Percentage5"
                                                class="form-control form-control-sm">
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" name="Qualification[]" id="Qualification6"
                                                class="form-control form-control-sm" value="Doctorate" readonly>
                                        </td>
                                        <td>
                                            <select name="Course[]" id="Course6" class="form-select form-select-sm"
                                                onchange="getSpecialization(this.value,6)">
                                                <option value="">Select</option>
                                                @foreach ($education_list as $key => $value)
                                                    <option value="{{ $key }}">
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="Specialization[]" id="Specialization6"
                                                class="form-select form-select-sm">
                                                <option value="">Select</option>
                                                <option value="0">Other</option>
                                                @foreach ($specialization_list as $key => $value)
                                                    <option value="{{ $key }}">
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="Collage[]" id="Collage6" class="form-select form-select-sm"
                                                onchange="getOtherInstitute(6);">
                                                <option value="">Select</option>
                                                @foreach ($institute_list as $key => $value)
                                                    <option value="{{ $key }}">
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <input type="text" name="OtherInstitute[]" id="OtherInstitute6"
                                                class="form-control form-control-sm mt-1 d-none">
                                        </td>
                                        <td>
                                            <select name="PassingYear[]" id="PassingYear6"
                                                class="form-select form-select-sm">
                                                <option value="">Select</option>
                                                @for ($i = 1980; $i <= $Year; $i++)
                                                    <option value="{{ $i }}">
                                                        {{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="Percentage[]" id="Percentage6"
                                                class="form-control form-control-sm">
                                        </td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <input type="button" value="Add Qualification" id="addEducation" class="btn btn-primary btn-sm">
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="work_exp_modal" class="modal custom-modal fade" role="dialog" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Work Experience</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="WorkExpForm" action="{{ route('Candidate_Experience_Save') }}" method="POST">
                        <input type="hidden" name="Work_JCId" id="Work_JCId">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="text-center">
                                    <tr>
                                        <td>Company</td>
                                        <td>Designation</td>
                                        <td>Gross Monthly Salary</td>
                                        <td>Anual CTC</td>
                                        <td>Job Start Date</td>
                                        <td>Job End Date</td>
                                        <td>Reason for Leaving</td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody id="WorkExpData">
                                    <tr>
                                        <td>
                                            <input type="text" name="WorkExpCompany[]" id="WorkExpCompany1"
                                                class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <input type="text" name="WorkExpDesignation[]" id="WorkExpDesignation1"
                                                class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <input type="text" name="WorkExpGrossMonthlySalary[]"
                                                id="WorkExpGrossMonthlySalary1" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <input type="text" name="WorkExpAnualCTC[]" id="WorkExpAnualCTC1"
                                                class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <input type="date" name="WorkExpJobStartDate[]" id="WorkExpJobStartDate1"
                                                class="form-control form-control-sm datepicker">
                                        </td>
                                        <td>
                                            <input type="date" name="WorkExpJobEndDate[]" id="WorkExpJobEndDate1"
                                                class="form-control form-control-sm datepicker">
                                        </td>
                                        <td>
                                            <input type="text" name="WorkExpReasonForLeaving[]"
                                                id="WorkExpReasonForLeaving1" class="form-control form-control-sm">
                                        </td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <input type="button" value="Add Experience" id="addExperience" class="btn btn-primary btn-sm">
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="current_emp_modal" class="modal custom-modal fade" role="dialog" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Current Employement</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="CurrentEmpForm" action="{{ route('Candidate_CurrentEmployement_Save') }}" method="POST">
                        <input type="hidden" name="Curr_JCId" id="Curr_JCId">
                        <div class="form-group">
                            <label>Name of Company</label>
                            <input type="text" name="CurrCompanyName" id="CurrCompanyName"
                                class="form-control form-control-sm">
                        </div>


                        <div class="form-group">
                            <label for="">Designation</label>
                            <input type="text" name="CurrDesignation" id="CurrDesignation"
                                class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label for="">Date of Joining</label>
                            <input type="date" name="CurrDateOfJoining" id="CurrDateOfJoining"
                                class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label for="">Reporting To</label>
                            <input type="text" name="CurrReportingTo" id="CurrReportingTo"
                                class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label for="">Reporting Manager Designation</label>
                            <input type="text" name="CurrRepDesig" id="CurrRepDesig" class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label for="">Job Responsibility</label>
                            <textarea name="CurrJobResponsibility" id="CurrJobResponsibility"
                                class="form-control form-control-sm"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Job Change Reason</label>
                            <textarea name="CurrReason" id="CurrReason" class="form-control form-control-sm"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Notice Period</label>
                            <input type="text" name="CurrNoticePeriod" id="CurrNoticePeriod"
                                class="form-control form-control-sm">
                        </div>

                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="current_salary_modal" class="modal custom-modal fade" role="dialog" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Present Salary Details</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="CurrentSalaryForm" action="{{ route('Candidate_CurrentSalary_Save') }}" method="POST">
                        <input type="hidden" name="Sal_JCId" id="Sal_JCId">
                        <div class="form-group">
                            <label>Salary (Per Month)</label>
                            <input type="text" name="CurrSalary" id="CurrSalary" class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label for="">Annual Package (CTC)</label>
                            <input type="text" name="CurrCTC" id="CurrCTC" class="form-control form-control-sm">
                        </div>

                        <div class="form-group">
                            <label for="">DA @ headquarter</label>
                            <input type="text" name="CurrDA" id="CurrDA" class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label for="">DA Outside Headquarter</label>
                            <input type="text" name="DAOutHq" id="DAOutHq" class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label for="">Petrol Allowances</label>
                            <input type="text" name="PetrolAlw" id="PetrolAlw" class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label for="">Phone Allowances</label>
                            <input type="text" name="PhoneAlw" id="PhoneAlw" class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label for="">Hotel Eligibility</label>
                            <input type="text" name="HotelElg" id="HotelElg" class="form-control form-control-sm">
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="training_modal" class="modal custom-modal fade" role="dialog" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Training & Practical Experience</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="TrainingForm" action="{{ route('Candidate_Training_Save') }}" method="POST">
                        <input type="hidden" name="Training_JCId" id="Training_JCId">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="text-center">
                                    <tr>
                                        <td>Nature of Training</td>
                                        <td>Organization / Institution</td>
                                        <td>From Date</td>
                                        <td>To Date</td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody id="TrainingData">
                                    <tr>
                                        <td>
                                            <input type="text" name="TrainingNature[]" id="TrainingNature1"
                                                class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <input type="text" name="TrainingOrganization[]" id="TrainingOrganization1"
                                                class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <input type="date" name="TrainingFromDate[]" id="TrainingFromDate1"
                                                class="form-control form-control-sm datepicker">
                                        </td>
                                        <td>
                                            <input type="date" name="TrainingToDate[]" id="TrainingToDate1"
                                                class="form-control form-control-sm datepicker">
                                        </td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <input type="button" value="Add Experience" id="addTraining" class="btn btn-primary btn-sm">
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="pre_org_ref_modal" class="modal custom-modal fade" role="dialog" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Previous Organization Reference</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="PreOrgRefForm" action="{{ route('Candidate_PreOrgRef_Save') }}" method="POST">
                        <input type="hidden" name="PreOrgRef_JCId" id="PreOrgRef_JCId">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="text-center">
                                    <tr>
                                        <td>Name</td>
                                        <td>Name of Company</td>
                                        <td>Email Id</td>
                                        <td>Contact No</td>
                                        <td>Designation</td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody id="PreOrgRefData">
                                    <tr>
                                        <td>
                                            <input type="text" name="PreOrgName[]" id="PreOrgName1"
                                                class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <input type="text" name="PreOrgCompany[]" id="PreOrgCompany1"
                                                class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <input type="text" name="PreOrgEmail[]" id="PreOrgEmail1"
                                                class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <input type="text" name="PreOrgContact[]" id="PreOrgContact1"
                                                class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <input type="text" name="PreOrgDesignation[]" id="PreOrgDesignation1"
                                                class="form-control form-control-sm">
                                        </td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <input type="button" value="Add Reference" id="addPreOrgRef" class="btn btn-primary btn-sm">
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="vnr_ref_modal" class="modal custom-modal fade" role="dialog" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Acquaintances or relatives working with VNR Group Companies</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="VNRRefForm" action="{{ route('Candidate_VnrRef_Save') }}" method="POST">
                        <input type="hidden" name="Vnr_JCId" id="Vnr_JCId">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="text-center">
                                    <tr>
                                        <td>Name</td>
                                        <td>Mobile No</td>
                                        <td>Email</td>
                                        <td>VNR Group <br>Company Name</td>
                                        <td>Designation</td>
                                        <td>Location</td>
                                        <td>Your Relationship <br>with person mentioned
                                        </td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody id="VNRRefData">
                                    <tr>
                                        <td>
                                            <input type="text" name="VnrRefName[]" id="VnrRefName1"
                                                class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <input type="text" name="VnrRefContact[]" id="VnrRefContact1"
                                                class="form-control form-control-sm">
                                        </td>

                                        <td>
                                            <input type="text" name="VnrRefEmail[]" id="VnrRefEmail1"
                                                class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <select name="VnrRefCompany[]" id="VnrRefCompany1"
                                                class="form-select form-select-sm" onchange="GetOtherCompany(1);">
                                                <option value="">Select</option>
                                                <option value="VNR Seeds Pvt. Ltd.">VNR
                                                    Seeds Pvt. Ltd.</option>
                                                <option value="VNR Nursery Pvt. Ltd.">
                                                    VNR Nursery Pvt. Ltd.</option>
                                                <option value="Other">Other</option>
                                            </select>

                                            <input type="text" name="OtherCompany[]" id="OtherCompany1"
                                                class="d-none form-control form-control-sm"
                                                placeholder="Other Company Name">
                                        </td>
                                        <td>
                                            <input type="text" name="VnrRefDesignation[]" id="VnrRefDesignation1"
                                                class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <input type="text" name="VnrRefLocation[]" id="VnrRefLocation1"
                                                class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <input type="text" name="VnrRefRelWithPerson[]" id="VnrRefRelWithPerson1"
                                                class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <div class="d-flex order-actions"><a href="javascript:;"
                                                    class="ms-3" id="removeVnrRef"><i
                                                        class="bx bxs-trash text-danger"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <input type="button" value="Add Reference" id="addVnrRef" class="btn btn-primary btn-sm">
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="vnr_business_ref_modal" class="modal custom-modal fade" role="dialog" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Acquaintances or relatives associated with VNR as business associates</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="BusinessForm" action="{{ route('Candidate_VnrRef_Business_Save') }}" method="POST">
                        <input type="hidden" name="Business_JCId" id="Business_JCId">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="text-center">
                                    <tr>
                                        <td>Name</td>
                                        <td>Mobile No</td>
                                        <td>Email</td>
                                        <td>Business relation with <br>VNR</td>
                                        <td>Location of Business / <br>acquaintances
                                        </td>

                                        <td>Your Relationship <br>with person mentioned
                                        </td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody id="VNR_Business_AcqData">
                                    <tr>
                                        <td>
                                            <input type="text" name="VnrRefBusiness_Name[]" id="VnrRefBusiness_Name1"
                                                class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <input type="text" name="VnrRefBusiness_Contact[]" id="VnrRefBusiness_Contact1"
                                                class="form-control form-control-sm">
                                        </td>

                                        <td>
                                            <input type="text" name="VnrRefBusiness_Email[]" id="VnrRefBusiness_Email1"
                                                class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <select name="VnrRefBusinessRelation[]" id="VnrRefBusinessRelation1"
                                                class="form-select form-select-sm">
                                                <option value="">Select</option>
                                                <option value="Dealer">Dealer</option>
                                                <option value="Distributor">Distributor
                                                </option>
                                                <option value="Retailer">Retailer
                                                </option>
                                                <option value="Organizer">Organizer
                                                </option>
                                                <option value="Vendor">Vendor</option>

                                            </select>
                                        </td>

                                        <td>
                                            <input type="text" name="VnrRefBusiness_Location[]"
                                                id="VnrRefBusiness_Location1" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <input type="text" name="VnrRefBusiness_RelWithPerson[]"
                                                id="VnrRefBusiness_RelWithPerson1" class="form-control form-control-sm">
                                        </td>


                                        <td>
                                            <div class="d-flex order-actions"><a href="javascript:;"
                                                    class="ms-3" id="removeVnrRef_Business"><i
                                                        class="bx bxs-trash text-danger"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <input type="button" value="Add Reference" id="addVnrRef_Business" class="btn btn-primary btn-sm">
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="other_seed_modal" class="modal custom-modal fade" role="dialog" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Relatives or acquaintances is/are working or associated with any other Seed
                        Company</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="OtherSeedForm" action="{{ route('Candidate_Other_Seed_Relation_Save') }}" method="POST">
                        <input type="hidden" name="OtherSeed_JCId" id="OtherSeed_JCId">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="text-center">
                                    <tr>
                                        <td>Name</td>
                                        <td>Mobile No</td>
                                        <td>Email</td>
                                        <td>Company Name</td>
                                        <td>Designation</td>
                                        <td>Location </td>
                                        <td>Your Relationship <br>with person mentioned
                                        </td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody id="OtherSeed">
                                    <tr>
                                        <td><input type="text" name="OtherSeedName[]" id="OtherSeedName1"
                                                class="form-control form-control-sm">
                                        </td>
                                        <td><input type="text" name="OtherSeedMobile[]" id="OtherSeedMobile1"
                                                class="form-control form-control-sm">
                                        </td>
                                        <td><input type="text" name="OtherSeedEMail[]" id="OtherSeedEMail1"
                                                class="form-control form-control-sm">
                                        </td>
                                        <td><input type="text" name="OtherSeedCompany[]" id="OtherSeedCompany1"
                                                class="form-control form-control-sm">
                                        </td>
                                        <td><input type="text" name="OtherSeedDesignation[]" id="OtherSeedDesignation1"
                                                class="form-control form-control-sm">
                                        </td>
                                        <td><input type="text" name="OtherSeedLocation[]" id="OtherSeedLocation1"
                                                class="form-control form-control-sm">
                                        </td>
                                        <td><input type="text" name="OtherSeedRelation[]" id="OtherSeedRelation1"
                                                class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <div class="d-flex order-actions"><a href="javascript:;"
                                                    class="ms-3" id="removeOtherSeed"><i
                                                        class="bx bxs-trash text-danger"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <input type="button" value="Add Reference" id="addOtherSeed" class="btn btn-primary btn-sm">
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="resume_modal" class="modal custom-modal fade" role="dialog" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Resume</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <object width="760" height="500" data="{{ URL::to('/') }}/uploads/Resume/{{ $Rec->Resume }}"
                        id="{{ $Rec->JCId }}"></object>
                </div>
            </div>
        </div>
    </div>

    <div id="language_modal" class="modal custom-modal fade" role="dialog" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Language Proficiency</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <input type="hidden" name="Language_JCId" id="Language_JCId">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center" style="vertical-align: middle">
                            <thead class="text-center">
                                <tr>
                                    <td>Language</td>
                                    <td>Reading</td>
                                    <td>Writing</td>
                                    <td>Speaking</td>
                                    <td style="width:30px;"></td>
                                </tr>
                            </thead>
                            <tbody id="LanguageData">
                                <tr>
                                    <td>
                                        <input type="text" id="Language1" class="form-control form-control-sm"
                                            value="Hindi" readonly>
                                    </td>
                                    <td>
                                        <input type="checkbox" id="Read1" value="0">
                                    </td>
                                    <td>
                                        <input type="checkbox" id="Write1" value="0">
                                    </td>
                                    <td>
                                        <input type="checkbox" id="Speak1" value="0">
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" id="Language2" class="form-control form-control-sm"
                                            value="English" readonly>
                                    </td>
                                    <td>
                                        <input type="checkbox" id="Read2" value="0">
                                    </td>
                                    <td>
                                        <input type="checkbox" id="Write2" value="0">
                                    </td>
                                    <td>
                                        <input type="checkbox" id="Speak2" value="0">
                                    </td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <input type="button" value="Add Language" id="addLanguage" class="btn btn-primary btn-sm">
                    <div class="submit-section">
                        <button class="btn btn-primary" id="save_language">Submit</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="OfferLtrModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('update_offerletter_basic') }}" method="POST" id="offerletterbasicform">
                <input type="hidden" name="Of_JAId" id="Of_JAId">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h6 class="modal-title text-light" id="exampleModalLabel">Offer Letter Basic Details</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered" style="vertical-align: middle;">
                            <tbody>
                                <tr>
                                    <input type="hidden" name="JCId" id="JCId">
                                    <input type="hidden" name="SelectedForC" id="SelectedForC">
                                    <input type="hidden" name="SelectedForD" id="SelectedForD">
                                </tr>

                                <tr>
                                    <td style="width:150px;">Grade</td>
                                    <td>
                                        <select name="Grade" id="Grade" class="form-select form-select-sm"
                                            style="width: 200px;">
                                            <option value="">Select</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:150px;">Department</td>
                                    <td>

                                        <input type="text" name="SelectedDepartment" id="SelectedDepartment" disabled
                                            style="background-color: white;border:aliceblue; width: 160px; color:black">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:150px;">Designation</td>
                                    <td>
                                        <select name="Designation" id="Designation" class="form-select form-select-sm"
                                            style="width: 200px;">
                                            <option value="">Select</option>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="width:150px;">Vertical</td>
                                    <td>
                                        <select name="Vertical" id="Vertical" class="form-select form-select-sm"
                                            style="width: 200px;">
                                            <option value="">Select</option>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Location(HQ)</td>
                                    <td>
                                        <table class="table borderless" style="margin-bottom: 0px;">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input " type="checkbox"
                                                                id="permanent_chk" name="permanent_chk" value="1">
                                                            <label class="form-check-label" for="permanent_chk">Permanent
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline d-none"
                                                            id="permanent_div">
                                                            <select name="Of_PermState" id="Of_PermState"
                                                                class="form-select form-select-sm d-inline"
                                                                style="width: 130px;">
                                                                <option value="">Select State</option>
                                                            </select>
                                                            <select name="PermHQ" id="PermHQ"
                                                                class="form-select form-select-sm d-inline"
                                                                style="width: 130px;">
                                                                <option value="">Select HQ</option>
                                                            </select>
                                                            <input type="text" name="Of_PermCity" id="Of_PermCity"
                                                                class="form-control form-control-sm d-inline"
                                                                style="width: 130px;" placeholder="City">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input " type="checkbox"
                                                                id="temporary_chk" name="temporary_chk" value="1">
                                                            <label class="form-check-label" for="temporary_chk">Temporary
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline d-none" id="temporary_div"
                                                            style="margin-right:0px;">
                                                            <select name="TempState" id="TempState"
                                                                class="form-select form-select-sm d-inline"
                                                                style="width: 130px;">
                                                                <option value="">Select State</option>

                                                            </select>
                                                            <select name="TempHQ" id="TempHQ"
                                                                class="form-select form-select-sm d-inline"
                                                                style="width: 130px;">
                                                                <option value="">Select HQ</option>

                                                            </select>
                                                            <input type="text" name="TempCity" id="TempCity"
                                                                class="form-control form-control-sm d-inline"
                                                                style="width: 100px;" placeholder="City">

                                                            <select name="TemporaryMonth" id="TemporaryMonth"
                                                                class="form-select form-select-sm d-inline"
                                                                style="width: 90px;">
                                                                <option value="0">Select Months</option>
                                                                <option value="One">1</option>
                                                                <option value="Two">2</option>
                                                                <option value="Three">3</option>
                                                                <option value="Four">4</option>
                                                                <option value="Five">5</option>
                                                                <option value="Six">6</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>

                                    </td>
                                </tr>

                                <tr>
                                    <td>Reporting</td>
                                    <td>
                                        <table class="table borderless" style="margin-bottom: 0px;">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input " type="checkbox"
                                                                id="administrative_chk" name="administrative_chk" value="1">
                                                            <label class="form-check-label"
                                                                for="administrative_chk">Administrative
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline d-none"
                                                            id="administrative_div">
                                                            <select name="AdministrativeDepartment"
                                                                id="AdministrativeDepartment"
                                                                class="form-select form-select-sm d-inline"
                                                                style="width: 160px;">
                                                                <option value="">Select Department</option>
                                                            </select>
                                                            <select name="AdministrativeEmployee"
                                                                id="AdministrativeEmployee"
                                                                class="form-select form-select-sm d-inline"
                                                                style="width: 160px;">
                                                                <option value="">Select Employee</option>
                                                            </select>

                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input " type="checkbox"
                                                                id="functional_chk" name="functional_chk" value="1">
                                                            <label class="form-check-label"
                                                                for="functional_chk">Functional
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline d-none"
                                                            style="padding-left: 43px;" id="functional_div">
                                                            <select name="FunctionalDepartment" id="FunctionalDepartment"
                                                                class="form-select form-select-sm d-inline"
                                                                style="width: 160px;">
                                                                <option value="">Select Department</option>
                                                            </select>
                                                            <select name="FunctionalEmployee" id="FunctionalEmployee"
                                                                class="form-select form-select-sm d-inline"
                                                                style="width: 160px;">
                                                                <option value="">Select Employee</option>
                                                            </select>

                                                        </div>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>

                                    </td>
                                </tr>

                                <tr>
                                    <td>CTC</td>
                                    <td>CTC:Rs. <input type="text" name="CTC" id="CTC"
                                            class="form-control form-control-sm d-inline" style="width: 200px;"></td>
                                </tr>

                                <tr>
                                    <td>Service Condition</td>
                                    <td>
                                        <div class="form-check form-check-inline scon">
                                            <input class="form-check-input" type="radio" id="Training" value="Training"
                                                name="ServiceCond" onclick="$('#training_tr').removeClass('d-none');">
                                            <label class="form-check-label" for="Training">Training</label>
                                        </div>
                                        <div class="form-check form-check-inline scon">
                                            <input class="form-check-input" type="radio" id="Probation" value="Probation"
                                                name="ServiceCond" onclick="$('#training_tr').addClass('d-none');">
                                            <label class="form-check-label" for="Probation">Probation</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="nopnot" value="nopnot"
                                                name="ServiceCond" onclick="$('#training_tr').addClass('d-none');">
                                            <label class="form-check-label" for="nopnot">No Probation / No
                                                Training</label>
                                        </div>

                                    </td>
                                </tr>

                                <tr id="training_tr" class="d-none">
                                    <td></td>
                                    <td>
                                        <table class="table table-borderless">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="form-check form-check-inline">

                                                            <label>
                                                                Orientation Period:
                                                            </label>
                                                        </div>
                                                        <div class="d-inline" style="padding-left: 112px;">

                                                            <select name="OrientationPeriod" id="OrientationPeriod"
                                                                class="form-select form-select-sm d-inline"
                                                                style="width: 130px;">
                                                                <option value="">Select </option>
                                                                <option value="One">1</option>
                                                                <option value="Two">2</option>
                                                                <option value="Three">3</option>
                                                                <option value="Four">4</option>
                                                                <option value="Five">5</option>
                                                                <option value="Six">6</option>
                                                            </select>
                                                            <span>Months</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="form-check form-check-inline">

                                                            <label>
                                                                Stipend during Orientation Period:
                                                            </label>
                                                        </div>
                                                        <div class="d-inline" style="padding-left: 18px;">

                                                            <input type="text" name="Stipend" id="Stipend"
                                                                class="form-control form-control-sm d-inline"
                                                                style="width: 130px;">
                                                            <span>per months</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="form-check form-check-inline">

                                                            <label>Designation & Grade <br>After Training Completion
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline" id="permanent_div"
                                                            style="padding-left: 71px;">
                                                            <select name="AftDesignation" id="AftDesignation"
                                                                class="form-select form-select-sm d-inline"
                                                                style="width: 130px;">
                                                                <option value="">Select Designation</option>
                                                            </select>
                                                            <select name="AftGrade" id="AftGrade"
                                                                class="form-select form-select-sm d-inline"
                                                                style="width: 130px;">
                                                                <option value="">Select Grade</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Service Bond</td>
                                    <td>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="ServiceBond"
                                                id="ServiceBondYes" value="Yes"
                                                onclick="$('#bond_tr').removeClass('d-none');">
                                            <label class="form-check-label" for="ServiceBondYes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="ServiceBond"
                                                id="ServiceBondNo" value="No" checked
                                                onclick="$('#bond_tr').addClass('d-none');">
                                            <label class="form-check-label" for="ServiceBondNo">No</label>
                                        </div>
                                    </td>
                                </tr>

                                <tr id="bond_tr" class="d-none">
                                    <td></td>
                                    <td>
                                        <table class="table table-borderless">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="form-check form-check-inline">

                                                            <label>
                                                                Service Bond Duration
                                                            </label>
                                                        </div>
                                                        <div class="d-inline">

                                                            <select name="ServiceBondDuration" id="ServiceBondDuration"
                                                                class="form-select form-select-sm d-inline"
                                                                style="width: 130px;">
                                                                <option value="">Select </option>
                                                                <option value="One">1</option>
                                                                <option value="Two">2</option>
                                                                <option value="Three">3</option>
                                                                <option value="Four">4</option>
                                                                <option value="Five">5</option>
                                                                <option value="Six">6</option>
                                                                <option value="Seven">7</option>
                                                                <option value="Eight">8</option>
                                                                <option value="Nine">9</option>
                                                                <option value="Ten">10</option>
                                                            </select>
                                                            <span>Years</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="form-check form-check-inline">

                                                            <label>
                                                                Service Bond Refund
                                                            </label>
                                                        </div>
                                                        <div class="d-inline">
                                                            &nbsp;
                                                            <input type="text" name="ServiceBondRefund"
                                                                id="ServiceBondRefund"
                                                                class="form-control form-control-sm d-inline"
                                                                style="width: 130px;" value="50">
                                                            <span>% of CTC</span>
                                                        </div>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Pre-Medical Check-up</td>
                                    <td>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="MedicalCheckup"
                                                id="MedicalCheckupYes" value="Yes">
                                            <label class="form-check-label" for="MedicalCheckupYes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="MedicalCheckup"
                                                id="MedicalCheckupNo" value="No" checked>
                                            <label class="form-check-label" for="MedicalCheckupNo">No</label>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        Signing Authority
                                    </td>
                                    <td>
                                        <select name="SignAuth" id="SignAuth" class="form-select form-select-sm"
                                            style="width: 170px">
                                            <option value="General Manager HR">General Manager HR</option>
                                            <option value="Managing Director">Managing Director</option>
                                            <option value="Director">Director</option>
                                            <option value="Business Head">Business Head</option>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Remarks / Reason for Rivision</td>
                                    <td>
                                        <input type="text" name="Remark" id="Remark" class="form-control form-control-sm">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="HistoryModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h6 class="modal-title text-light" id="exampleModalLabel">Offer Letter History</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered text-center" style="vertical-align: middle;">
                        <thead>
                            <tr>
                                <th>Date Generate</th>
                                <th>Offer Letter Ref.No</td>
                                <th>Offer Letter</th>
                                <th>Reason for Change</td>
                            </tr>
                        </thead>
                        <tbody id="offerHistory">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="review_modal" class="modal custom-modal fade" role="dialog" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Send Offer Letter for review</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('send_for_review') }}" method="POST" id="reviewForm">
                        @csrf
                        <div class="form-group mb-2">
                            <input type="hidden" name="ReviewJaid" value="{{ $JAId }}">
                            <label for="ReviewCompany">Company</label>
                            <select name="ReviewCompany" id="ReviewCompany" class="form-select form-select-sm"
                                onchange="getEmployee(this.value)">
                                <option value="">Select</option>
                                @foreach ($company_list as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="spinner-border text-primary d-none" role="status" id="EmpLoader"> <span
                                class="visually-hidden">Loading...</span></div>
                        <div class="form-group">
                            <label>Select Employee</label>
                            <select name="review_to[]" id="review_to" class="form-select form-select-sm multiple-select"
                                multiple>

                            </select>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="view_review" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h6 class="modal-title text-light" id="exampleModalLabel">Offer Letter Review Status</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered text-center" style="vertical-align: middle;">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Offer Letter Ref.No</td>
                                <th>Reviwed By</th>
                                <th>Status</td>
                                <th>Reason for Rejection</td>
                            </tr>
                        </thead>
                        <tbody id="viewReviewData">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="about_modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h6 class="modal-title text-light" id="exampleModalLabel">About Yourself </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('SaveAbout') }}" id="about_form" method="POST">
                        <div class="col-lg-12">
                            <h6>Q1. What is your aim in life? </h6>
                            <div class="form-group row mb-2">
                                <div class="col-md-12">
                                    <input type="text" name="AboutAim" id="AboutAim"
                                        class="form-control form-control-sm reqinp_abt"
                                        value="{{ $AboutAns->AboutAim ?? '' }}">
                                </div>
                            </div>
                            <h6>Q2. What are you hobbies and interest? </h6>
                            <div class="form-group row mb-2">
                                <div class="col-md-12">

                                    <input type="text" name="AboutHobbi" id="AboutHobbi"
                                        class="form-control form-control-sm reqinp_abt"
                                        value="{{ $AboutAns->AboutHobbi ?? '' }}">
                                </div>
                            </div>
                            <h6>Q3. Where do you see yourself 5 Years from now? </h6>
                            <div class="form-group row mb-2">
                                <div class="col-md-12">

                                    <input type="text" name="About5Year" id="About5Year"
                                        class="form-control form-control-sm reqinp_abt"
                                        value="{{ $AboutAns->About5Year ?? '' }}">
                                </div>
                            </div>
                            <h6>Q4. What are your greatest personal assets (qualities,
                                skills,
                                abilities) which make you successful
                                in the jobs you take up? </h6>
                            <div class="form-group row mb-2">
                                <div class="col-md-12">

                                    <input type="text" name="AboutAssets" id="AboutAssets"
                                        class="form-control form-control-sm reqinp_abt"
                                        value="{{ $AboutAns->AboutAssets ?? '' }}">
                                </div>
                            </div>
                            <h6>Q5. What are your areas where you think you need to improve
                                yourself? </h6>
                            <div class="form-group row mb-2">
                                <div class="col-md-12">

                                    <input type="text" name="AboutImprovement" id="AboutImprovement"
                                        class="form-control form-control-sm reqinp_abt"
                                        value="{{ $AboutAns->AboutImprovement ?? '' }}">
                                </div>
                            </div>
                            <h6>Q6. What are your Strengths? </h6>
                            <div class="form-group row mb-2">
                                <div class="col-md-12">

                                    <input type="text" name="AboutStrength" id="AboutStrength"
                                        class="form-control form-control-sm reqinp_abt"
                                        value="{{ $AboutAns->AboutStrength ?? '' }}">
                                </div>
                            </div>


                            <h6>Q7. In the past or at present, have/are you suffered
                                /suffering
                                from, any form of physical disability
                                or any minor or major illness or deficiency? </h6>
                            <div class="form-group row mb-2">
                                <div class="col-md-12">

                                    <input type="text" name="AboutDeficiency" id="AboutDeficiency"
                                        class="form-control form-control-sm reqinp_abt"
                                        value="{{ $AboutAns->AboutDeficiency ?? '' }}">
                                </div>
                            </div>
                            <h6>Q8. Have you Been criminally prosecuted? if so, give details
                                separately. </h6>
                            <div style="text-align: left">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input crime" type="radio" name="CriminalChk" id="YesCriminal"
                                        value="Y" data-value="Y" @php
                                            if ($AboutAns != null) {
                                                if ($AboutAns->CriminalChk == 'Y') {
                                                    echo 'checked';
                                                }
                                            }
                                        @endphp>
                                    <label class="form-check-label" for="YesCriminal">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input crime" type="radio" name="CriminalChk" id="NoCriminal"
                                        value="N" data-value="N" @php
                                            if ($AboutAns != null) {
                                                if ($AboutAns->CriminalChk == 'N') {
                                                    echo 'checked';
                                                }
                                            }
                                        @endphp>
                                    <label class="form-check-label" for="NoCriminal">
                                        No</label>
                                </div>
                            </div>
                            <div class="form-group row mb-2 
                                 
                                    @php
                                        if($AboutAns != null){
                                            if($AboutAns->CriminalChk == 'Y'){
                                                echo '';
                                            }else{
                                                echo 'd-none';
                                            }
                                        }
                                    @endphp "
                                id="crime_div">
                                <div class="col-md-12">
                                    <input type="text" name="AboutCriminal" id="AboutCriminal"
                                        class="form-control form-control-sm"
                                        value="{{ $AboutAns->AboutCriminal ?? '' }}">
                                </div>
                            </div>

                            <h6>Q9. Do You have a valid driving licence? </h6>
                            <div style="text-align: left">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input dlchk" type="radio" name="LicenseChk" id="YesLicense"
                                        value="Y" data-value="Y" @php
                                            if ($AboutAns != null) {
                                                if ($AboutAns->LicenseChk == 'Y') {
                                                    echo 'checked';
                                                }
                                            }
                                        @endphp>
                                    <label class="form-check-label" for="YesLicense">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input dlchk" type="radio" name="LicenseChk" id="NoLicense"
                                        value="N" data-value="N" @php
                                            if ($AboutAns != null) {
                                                if ($AboutAns->LicenseChk == 'N') {
                                                    echo 'checked';
                                                }
                                            }
                                        @endphp>
                                    <label class="form-check-label" for="NoLicense">
                                        No</label>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <div class="form-group row 
                                     
                                    @php
                                        if($AboutAns != null){
                                            if($AboutAns->LicenseChk == 'Y'){
                                                echo '';
                                            }else{
                                                echo 'd-none';
                                            }
                                        }
                                    @endphp "
                                    id="dl_div">
                                    <label class="col-form-label col-md-1">License
                                        No:</label>
                                    <div class="col-md-2 col-sm-12">
                                        <input type="text" class="form-control form-control-sm" id="DLNo" name="DLNo"
                                            value="{{ $AboutAns->DLNo ?? '' }}">
                                    </div>
                                    <label class="col-form-label col-md-1">Validity:</label>
                                    <div class="col-md-2 col-sm-12">
                                        <input type="date" class="form-control form-control-sm" name="LValidity"
                                            id="LValidity" value="{{ $AboutAns->LValidity ?? '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="submit-section text-center">
                            <button class="btn btn-primary submit-btn">Save Details
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="document_modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h6 class="modal-title text-light" id="exampleModalLabel">Document Upload</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead class="text-center">

                            <th>Document Name</th>
                            <th>Upload Document</th>
                            <th>View</th>
                        </thead>
                        <tbody>
                            @if ($Rec->Professional == 'P')
                                <tr>
                                    <td style="width: 25%">Offer or appointment letter
                                        (previous company)</td>
                                    <td style="width: 60%">
                                        <input type="file" name="OfferLtr" id="OfferLtr"
                                            class="form-control form-control-sm d-inline" style="width: 80%"
                                            accept="application/pdf">
                                        <button class="btn btn-warning btn-sm d-inline"
                                            id="OfferLtrUpload">Upload</button>
                                    </td>
                                    <td style="width: 10%; text-align:center">
                                        @if ($Docs != null && $Docs->OfferLtr != null)
                                            <a href="{{ URL::to('/') }}/uploads/Documents/{{ $Docs->OfferLtr }}"
                                                target="_blank" class="btn btn-primary btn-sm">View</a>
                                        @endif
                                    </td>
                                </tr>
                                <tr>

                                    <td>Resignation or Relieving Letter (previous
                                        company)
                                    </td>
                                    <td>
                                        <input type="file" name="RelievingLtr" id="RelievingLtr"
                                            class="form-control form-control-sm d-inline" style="width: 80%"
                                            accept="application/pdf">
                                        <button class="btn btn-warning btn-sm d-inline"
                                            id="RelievingLtrUpload">Upload</button>
                                    </td>
                                    <td style="width: 10%; text-align:center">
                                        @if ($Docs != null && $Docs->RelievingLtr != null)
                                            <a href="{{ URL::to('/') }}/uploads/Documents/{{ $Docs->RelievingLtr }}"
                                                target="_blank" class="btn btn-primary btn-sm">View</a>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Last drawn salary pay slip (previous company)
                                    </td>
                                    <td>
                                        <input type="file" name="SalarySlip" id="SalarySlip"
                                            class="form-control form-control-sm d-inline" style="width: 80%"
                                            accept="application/pdf">
                                        <button class="btn btn-warning btn-sm d-inline"
                                            id="SalarySlipUpload">Upload</button>
                                    </td>
                                    <td style="width: 10%; text-align:center">
                                        @if ($Docs != null && $Docs->SalarySlip != null)
                                            <a href="{{ URL::to('/') }}/uploads/Documents/{{ $Docs->SalarySlip }}"
                                                target="_blank" class="btn btn-primary btn-sm">View</a>
                                        @endif
                                    </td>
                                </tr>
                                <tr>

                                    <td>Increment or appraisal letter with revised CTC
                                        details</td>
                                    <td>
                                        <input type="file" name="AppraisalLtr" id="AppraisalLtr"
                                            class="form-control form-control-sm d-inline" style="width: 80%"
                                            accept="application/pdf">
                                        <button class="btn btn-warning btn-sm d-inline"
                                            id="AppraisalLtrUpload">Upload</button>
                                    </td>
                                    <td style="width: 10%; text-align:center">
                                        @if ($Docs != null && $Docs->AppraisalLtr != null)
                                            <a href="{{ URL::to('/') }}/uploads/Documents/{{ $Docs->AppraisalLtr }}"
                                                target="_blank" class="btn btn-primary btn-sm">View</a>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                            <tr>

                                <td>COVID Vaccine Certificate (Final Certificate)
                                </td>
                                <td>
                                    <input type="file" name="VaccinationCert" id="VaccinationCert"
                                        class="form-control form-control-sm d-inline" style="width: 80%"
                                        accept="application/pdf">
                                    <button class="btn btn-warning btn-sm d-inline"
                                        id="VaccinationCertUpload">Upload</button>
                                </td>
                                <td style="width: 10%; text-align:center">
                                    @if ($Docs != null && $Docs->VaccinationCert != null)
                                        <a href="{{ URL::to('/') }}/uploads/Documents/{{ $Docs->VaccinationCert }}"
                                            target="_blank" class="btn btn-primary btn-sm">View</a>
                                    @endif
                                </td>
                            </tr>
                            <tr>

                                <td style="width: 25%">Aadhaar Card</td>
                                <td style="width: 60%">
                                    <input type="file" name="AadhaarCard" id="AadhaarCard"
                                        class="form-control form-control-sm d-inline" style="width: 80%"
                                        accept="application/pdf">
                                    <button class="btn btn-warning btn-sm d-inline" id="AadhaarUpload">Upload</button>
                                </td>
                                <td style="width: 10%; text-align:center">
                                    @if ($Docs != null && $Docs->Aadhar != null)
                                        <a href="{{ URL::to('/') }}/uploads/Documents/{{ $Docs->Aadhar }}"
                                            target="_blank" class="btn btn-primary btn-sm">View</a>
                                    @endif
                                </td>
                            </tr>

                            <tr>

                                <td>Driving License</td>
                                <td>
                                    <input type="file" name="DLCard" id="DLCard"
                                        class="form-control form-control-sm d-inline" style="width: 80%"
                                        accept="application/pdf">
                                    <button class="btn btn-warning btn-sm d-inline" id="DLCardUpload">Upload</button>
                                </td>
                                <td style="width: 10%; text-align:center">
                                    @if ($Docs != null && $Docs->DL != null)
                                        <a href="{{ URL::to('/') }}/uploads/Documents/{{ $Docs->DL }}"
                                            target="_blank" class="btn btn-primary btn-sm">View</a>
                                    @endif
                                </td>
                            </tr>
                            <tr>

                                <td>PF Nomination Form 2
                                </td>
                                <td>
                                    <input type="file" name="PFForm2" id="PFForm2"
                                        class="form-control form-control-sm d-inline" style="width: 80%"
                                        accept="application/pdf">
                                    <button class="btn btn-warning btn-sm d-inline" id="PFForm2Upload">Upload</button>
                                </td>
                                <td style="width: 10%; text-align:center">
                                    @if ($Docs != null && $Docs->PF_Form2 != null)
                                        <a href="{{ URL::to('/') }}/uploads/Documents/{{ $Docs->PF_Form2 }}"
                                            target="_blank" class="btn btn-primary btn-sm">View</a>
                                    @endif
                                </td>
                            </tr>
                            <tr>

                                <td>PF Declaration Form 11
                                </td>
                                <td>
                                    <input type="file" name="PF_Form11" id="PF_Form11"
                                        class="form-control form-control-sm d-inline" style="width: 80%"
                                        accept="application/pdf">
                                    <button class="btn btn-warning btn-sm d-inline" id="PFForm11Upload">Upload</button>
                                </td>
                                <td style="width: 10%; text-align:center">
                                    @if ($Docs != null && $Docs->PF_Form2 != null)
                                        <a href="{{ URL::to('/') }}/uploads/Documents/{{ $Docs->PF_Form11 }}"
                                            target="_blank" class="btn btn-primary btn-sm">View</a>
                                    @endif
                                </td>
                            </tr>
                            <tr>

                                <td>Gratuity Nomination Form
                                </td>
                                <td>
                                    <input type="file" name="GratuityForm" id="GratuityForm"
                                        class="form-control form-control-sm d-inline" style="width: 80%"
                                        accept="application/pdf">
                                    <button class="btn btn-warning btn-sm d-inline" id="GratuityUpload">Upload</button>
                                </td>
                                <td style="width: 10%; text-align:center">
                                    @if ($Docs != null && $Docs->Gratutity != null)
                                        <a href="{{ URL::to('/') }}/uploads/Documents/{{ $Docs->Gratutity }}"
                                            target="_blank" class="btn btn-primary btn-sm">View</a>
                                    @endif
                                </td>
                            </tr>
                            <tr>

                                <td>ESIC Declaration Form 1
                                </td>
                                <td>
                                    <input type="file" name="ESICForm" id="ESICForm"
                                        class="form-control form-control-sm d-inline" style="width: 80%"
                                        accept="application/pdf">
                                    <button class="btn btn-warning btn-sm d-inline" id="ESICFormUpload">Upload</button>
                                </td>
                                <td style="width: 10%; text-align:center">
                                    @if ($Docs != null && $Docs->ESIC != null)
                                        <a href="{{ URL::to('/') }}/uploads/Documents/{{ $Docs->ESIC }}"
                                            target="_blank" class="btn btn-primary btn-sm">View</a>
                                    @endif
                                </td>
                            </tr>
                            <tr>

                                <td>Family Declaration Form 1(A)
                                </td>
                                <td>
                                    <input type="file" name="ESIC_Family" id="ESIC_Family"
                                        class="form-control form-control-sm d-inline" style="width: 80%"
                                        accept="application/pdf">
                                    <button class="btn btn-warning btn-sm d-inline" id="ESIC_FamilyUpload">Upload</button>
                                </td>
                                <td style="width: 10%; text-align:center">
                                    @if ($Docs != null && $Docs->ESIC_Family != null)
                                        <a href="{{ URL::to('/') }}/uploads/Documents/{{ $Docs->ESIC_Family }}"
                                            target="_blank" class="btn btn-primary btn-sm">View</a>
                                    @endif
                                </td>
                            </tr>

                            <tr>

                                <td>Health Declaration Form
                                </td>
                                <td>
                                    <input type="file" name="Health" id="Health"
                                        class="form-control form-control-sm d-inline" style="width: 80%"
                                        accept="application/pdf">
                                    <button class="btn btn-warning btn-sm d-inline" id="HealthUpload">Upload</button>
                                </td>
                                <td style="width: 10%; text-align:center">
                                    @if ($Docs != null && $Docs->Health != null)
                                        <a href="{{ URL::to('/') }}/uploads/Documents/{{ $Docs->Health }}"
                                            target="_blank" class="btn btn-primary btn-sm">View</a>
                                    @endif
                                </td>
                            </tr>
                            <tr>

                                <td>Declaration for Compliance to Ethical Financial
                                    Dealings
                                </td>
                                <td>
                                    <input type="file" name="Ethical" id="Ethical"
                                        class="form-control form-control-sm d-inline" style="width: 80%"
                                        accept="application/pdf">
                                    <button class="btn btn-warning btn-sm d-inline" id="EthicalUpload">Upload</button>
                                </td>
                                <td style="width: 10%; text-align:center">
                                    @if ($Docs != null && $Docs->Ethical != null)
                                        <a href="{{ URL::to('/') }}/uploads/Documents/{{ $Docs->Ethical }}"
                                            target="_blank" class="btn btn-primary btn-sm">View</a>
                                    @endif
                                </td>
                            </tr>
                            <tr>

                                <td>Blood Group Certificate
                                </td>
                                <td>
                                    <input type="file" name="BloodGroup" id="BloodGroup"
                                        class="form-control form-control-sm d-inline" style="width: 80%"
                                        accept="application/pdf">
                                    <button class="btn btn-warning btn-sm d-inline" id="BloodGroupUpload">Upload</button>
                                </td>
                                <td style="width: 10%; text-align:center">
                                    @if ($Docs != null && $Docs->BloodGroup != null)
                                        <a href="{{ URL::to('/') }}/uploads/Documents/{{ $Docs->BloodGroup }}"
                                            target="_blank" class="btn btn-primary btn-sm">View</a>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="ref_modal" class="modal custom-modal fade" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Send for Reference Check</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('send_for_ref_chk') }}" method="POST" id="ref_chk_form">
                        @csrf
                        <div class="form-group mb-2">
                            <input type="hidden" name="ReferenceChkJAId" value="{{ $JAId }}">
                            <label for="RefChkMail">Ref. Person Mail ID <i class="text-danger">*</i></label>
                            <input type="text" name="RefChkMail" id="RefChkMail" class="form-control form-control-sm">
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Send Mail</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scriptsection')
    <script>
        $(document).ready(function() {
            $("#CandLogTable").DataTable({
                pageLength: 10,
                searching: false,
                bLengthChange: false,
                ordering: false,

            });
        });

        function GetProfileData() {
            var JCId = $('#JCId').val();
            $.ajax({
                url: "{{ route('Candidate_ProfileData') }}",
                type: "POST",
                data: {
                    JCId: JCId
                },
                dataType: "json",
                success: function(data) {
                    if (data.status == 200) {
                        $('#Pro_JCId').val(data.data.JCId);
                        $('#FName').val(data.data.FName);
                        $('#MName').val(data.data.MName);
                        $('#LName').val(data.data.LName);
                        $('#DOB').val(data.data.DOB);
                        $('#Mobile').val(data.data.Phone);
                        $('#EMail').val(data.data.Email);


                    } else {
                        alert('error');
                    }
                }
            });
        }

        function GetPersonalData() {
            var JCId = $('#JCId').val();
            $.ajax({
                url: "{{ route('Candidate_PersonalData') }}",
                type: "POST",
                data: {
                    JCId: JCId
                },
                dataType: "json",
                success: function(data) {
                    if (data.status == 200) {
                        $('#P_JCId').val(data.data.JCId);
                        $('#Gender').val(data.data.Gender);
                        $('#Aadhaar').val(data.data.Aadhaar);
                        $('#Nationality').val(data.data.Nationality);
                        $('#Religion').val(data.data.Religion);
                        $('#OtherReligion').val(data.data.OtherReligion);
                        $('#MaritalStatus').val(data.data.MaritalStatus);
                        $('#MarriageDate').val(data.data.MarriageDate);
                        $('#SpouseName').val(data.data.SpouseName);
                        $('#Category').val(data.data.Caste);
                        $('#OtherCategory').val(data.data.OtherCaste);
                        $('#DrivingLicense').val(data.data.DrivingLicense);
                        $('#LValidity').val(data.data.LValidity);
                        if (data.data.MaritalStatus == 'Married') {
                            $('#MDate').removeClass('d-none');
                            $('#Spouse').removeClass('d-none');
                        } else {
                            $('#MDate').addClass('d-none');
                            $('#Spouse').addClass('d-none');
                        }
                    } else {
                        alert('error');
                    }
                }
            });
        }

        function GetEmergencyContact() {
            var JCId = $('#JCId').val();
            $.ajax({
                url: "{{ route('Candidate_EmergencyContact') }}",
                type: "POST",
                data: {
                    JCId: JCId
                },
                dataType: "json",
                success: function(data) {
                    $('#Emr_JCId').val($('#JCId').val());
                    $('#PrimaryName').val(data.data.cont_one_name);
                    $('#PrimaryRelation').val(data.data.cont_one_relation);
                    $('#PrimaryPhone').val(data.data.cont_one_number);
                    $('#SecondaryName').val(data.data.cont_two_name);
                    $('#SecondaryRelation').val(data.data.cont_two_relation);
                    $('#SecondaryPhone').val(data.data.cont_two_number);
                }
            });
        }

        function GetBankInfo() {
            var JCId = $('#JCId').val();
            $.ajax({
                url: "{{ route('Candidate_BankInfo') }}",
                type: "POST",
                data: {
                    JCId: JCId
                },
                dataType: "json",
                success: function(data) {
                    $('#Bank_JCId').val($('#JCId').val());
                    $('#BankName').val(data.data.BankName);
                    $('#BranchName').val(data.data.BranchName);
                    $('#AccountNumber').val(data.data.AccountNumber);
                    $('#IFSCCode').val(data.data.IFSCCode);
                    $('#PAN').val(data.data.PAN);
                    $('#UAN').val(data.data.UAN);
                    $('#PFNumber').val(data.data.PFNumber);
                    $('#ESICNumber').val(data.data.ESICNumber);
                    $('#Passport').val(data.data.Passport);
                }
            });
        }

        function GetFamily() {
            var JCId = $('#JCId').val();
            $.ajax({
                url: "{{ route('Candidate_Family') }}",
                type: "POST",
                data: {
                    JCId: JCId
                },
                dataType: "json",
                success: function(data) {
                    $('#Family_JCId').val($('#JCId').val());
                    MemberCount = data.data.length;
                    for (var i = 1; i <= MemberCount; i++) {

                        familymember(i);
                        $('#Relation' + i).val(data.data[i - 1].relation);
                        $('#RelationName' + i).val(data.data[i - 1].name);
                        $('#RelationDOB' + i).val(data.data[i - 1].dob);
                        $('#RelationQualification' + i).val(data.data[i - 1].qualification);
                        $('#RelationOccupation' + i).val(data.data[i - 1].occupation);
                    }
                }
            });
        }

        function getEmployee(ComapnyId) {
            var ComapnyId = ComapnyId;
            $.ajax({
                type: "GET",
                url: "{{ route('getEmpByCompany') }}?ComapnyId=" + ComapnyId,
                async: false,
                beforeSend: function() {
                    $('#EmpLoader').removeClass('d-none');
                    $('#review_to').addClass('d-none');
                },

                success: function(res) {
                    if (res) {
                        $('#EmpLoader').addClass('d-none');
                        $('#review_to').removeClass('d-none');
                        $("#review_to").empty();

                        $.each(res, function(key, value) {
                            $("#review_to").append('<option value="' + value + '">' + key +
                                '</option>');
                        });
                    } else {
                        $("#review_to").empty();
                    }
                }
            });
        }

        var MemberCount = 1;
        var EducationCount = 6;
        var WorkExpCount = 1;
        var TrainingCount = 1;
        var RefCount = 1;
        var VRefCount = 1;
        var LanguageCount = 2;
        var EducationList = '';
        var SpecializationList = '';
        var CollegeList = '';
        var YearList = '';
        getEducationList();
        getAllSP();
        getCollegeList();
        getYearList();

        function getEducationList() {
            $.ajax({
                type: "GET",
                url: "{{ route('getEducation') }}",
                async: false,
                success: function(res) {

                    if (res) {
                        EducationList = '<option value="">Select</option>';
                        $.each(res, function(key, value) {
                            EducationList = EducationList + '<option value="' + key + '">' + key +
                                '</option>';
                        });

                    }
                }
            });
        } //getEducationList

        function getCollegeList() {
            $.ajax({
                type: "GET",
                url: "{{ route('getCollege') }}",
                async: false,
                success: function(res) {

                    if (res) {
                        CollegeList = '<option value="">Select</option>';
                        $.each(res, function(key, value) {
                            CollegeList = CollegeList + '<option value="' + value + '">' + key +
                                '</option>';
                        });

                    }
                }
            });
        } //getCollegeList

        function getAllSP() {
            $.ajax({
                type: "GET",
                url: "{{ route('getAllSP') }}",
                async: false,
                success: function(res) {
                    if (res) {
                        SpecializationList = '<option value="">Select</option>';
                        $.each(res, function(key, value) {
                            SpecializationList = SpecializationList + '<option value="' + value + '">' +
                                key +
                                '</option>';
                        });
                    }
                }
            });
        } //getAllSP

        function getYearList() {
            var year = new Date().getFullYear();
            YearList = '<option value="">Select</option>';
            for (var i = 1980; i <= year; i++) {
                YearList = YearList + '<option value="' + i + '">' + i + '</option>';
            }
        } //getYearList

        function familymember(number) {

            var x = '';
            x += '<tr>';
            x += '<td>' + '<select class="form-select form-select-sm" name="Relation[]" id="Relation' + number + '">' +
                '<option value=""></option>' +
                '<option value="Father">Father</option>' +
                '<option value="Mother">Mother</option>' + '<option value="Brother">Brother</option>' +
                '<option value="Sister">Sister</option>' +
                '<option value="Spouse">Spouse</option>' + '<option value="Son">Son</option>' +
                '<option value="Daughter">Daughter</option>' + '</select>' +
                '</td>';
            x += '<td>' +
                '<input type="text" name="RelationName[]" id="RelationName' + number +
                '" class="form-control form-control-sm">' +
                '</td>';
            x += '<td>' +
                '<input type="date" name="RelationDOB[]" id="RelationDOB' + number +
                '" class="form-control form-control-sm">' +
                '</td>';
            x += '<td>' +

                ' <select  name="RelationQualification[]" id="RelationQualification' +
                number +
                '" class="form-control form-select form-select-sm" >' +
                '  <option value="" selected disabled>Select Education</option>' + EducationList +
                '</select>' +
                '</td>';
            x += '<td>' +
                '<input type="text" name="RelationOccupation[]" id="RelationOccupation' + number +
                '" class="form-control form-control-sm">' +
                '</td>';
            x += '<td>' + '<button class="btn btn-sm btn-danger" id="removeMember">Delete</button>' + '</td>';
            x += '</tr>';
            $('#FamilyData').append(x);
        } //familymember

        function GetQualification() {
            var JCId = $('#JCId').val();
            $.ajax({
                url: "{{ route('Candidate_Education') }}",
                type: "POST",
                data: {
                    JCId: JCId,
                },
                dataType: "json",
                success: function(data) {
                    if (data.status == 200) {
                        $('#Edu_JCId').val($('#JCId').val());
                        EducationCount = data.data.length;
                        for (var i = 1; i <= EducationCount; i++) {
                            if (i >= 7) {
                                Qualification(i);
                            }
                            $('#Qualification' + i).val(data.data[i - 1].Qualification);
                            $('#Course' + i).val(data.data[i - 1].Course);
                            $('#Specialization' + i).val(data.data[i - 1].Specialization);
                            $('#Collage' + i).val(data.data[i - 1].Institute);
                            $('#PassingYear' + i).val(data.data[i - 1].YearOfPassing);
                            $('#Percentage' + i).val(data.data[i - 1].CGPA);
                            if (data.data[i - 1].Institute == '637') {
                                $('#OtherInstitute' + i).removeClass('d-none');
                                $('#OtherInstitute' + i).addClass('reqinp');
                                $('#OtherInstitute' + i).val(data.data[i - 1].OtherInstitute);
                            }

                        }
                    }
                }
            });
        } //GetQualification

        function Qualification(num) {
            var a = '';
            a += '<tr>';
            a += '<td>' + '<input type="text" name="Qualification[]" id="Qualification' + num +
                '" class="form-control form-control-sm">' + '</td>' +
                '<td>' + '<select class="form-select form-select-sm" name="Course[]" id="Course' + num +
                '" onchange="getSpecialization(this.value,' + num + ')">' + EducationList +
                '</select>' +
                '</td>' +
                '<td>' + '<select class="form-select form-select-sm" name="Specialization[]" id="Specialization' + num +
                '">' + SpecializationList +
                '</select>' +
                '</td>' +
                '<td>' + '<select class="form-select form-select-sm" name="Collage[]" id="Collage' + num +
                '" onchange="getOtherInstitute(' + num + ')">' + CollegeList +
                '</select>' +
                '<input type="text" name="OtherInstitute[]" id="OtherInstitute' + num +
                '" class="form-control form-control-sm mt-1 d-none">' +
                '</td>' +
                '<td>' + '<select class="form-select form-select-sm" name="PassingYear[]" id="PassingYear' + num +
                '">' +
                YearList +
                '</select>' +
                '</td>' +
                '<td>' + '<input type="text" name="Percentage[]" id="Percentage' + num +
                '" class="form-control form-control-sm">' + '</td>' +
                '<td>' +
                '<div class="d-flex order-actions"><a href="javascript:;" class="ms-3" id="removeQualification"><i class="bx bxs-trash text-danger"></i></a></div>' +
                '</td>';

            a += '</tr>';

            $('#EducationData').append(a);
        } //Qualification

        function getWorkExp() {
            var JCId = $('#JCId').val();
            $.ajax({
                url: "{{ route('Candidate_Experience') }}",
                type: "POST",
                data: {
                    JCId: JCId
                },
                dataType: "json",
                success: function(data) {
                    $('#Work_JCId').val($('#JCId').val());
                    WorkExpCount = data.data.length;
                    for (var i = 1; i <= WorkExpCount; i++) {
                        if (i >= 2) {
                            WorkExperience(i);
                        }
                        $('#WorkExpCompany' + i).val(data.data[i - 1].company);
                        $('#WorkExpDesignation' + i).val(data.data[i - 1].desgination);
                        $('#WorkExpGrossMonthlySalary' + i).val(data.data[i - 1].gross_mon_sal);
                        $('#WorkExpAnualCTC' + i).val(data.data[i - 1].annual_ctc);
                        $('#WorkExpJobStartDate' + i).val(data.data[i - 1].job_start);
                        $('#WorkExpJobEndDate' + i).val(data.data[i - 1].job_end);
                        $('#WorkExpReasonForLeaving' + i).val(data.data[i - 1].reason_fr_leaving);

                    }
                }
            });
        } //getWorkExp

        function WorkExperience(num) {
            var b = '';
            b += '<tr>';
            b += '<td>' + '<input type="text" name="WorkExpCompany[]" id="WorkExpCompany' + num +
                '" class="form-control form-control-sm">' + '</td>' +
                '<td>' + '<input type="text" name="WorkExpDesignation[]" id="WorkExpDesignation' + num +
                '" class="form-control form-control-sm">' + '</td>' +
                '<td>' + '<input type="text" name="WorkExpGrossMonthlySalary[]" id="WorkExpGrossMonthlySalary' + num +
                '" class="form-control form-control-sm">' + '</td>' +
                '<td>' + '<input type="text" name="WorkExpAnualCTC[]" id="WorkExpAnualCTC' + num +
                '" class="form-control form-control-sm">' + '</td>' +
                '<td>' + '<input type="date" name="WorkExpJobStartDate[]" id="WorkExpJobStartDate' + num +
                '" class="form-control form-control-sm">' + '</td>' +
                '<td>' + '<input type="date" name="WorkExpJobEndDate[]" id="WorkExpJobEndDate' + num +
                '" class="form-control form-control-sm">' + '</td>' +
                '<td>' + '<input type="text" name="WorkExpReasonForLeaving[]" id="WorkExpReasonForLeaving' + num +
                '" class="form-control form-control-sm">' + '</td>' +
                '<td>' +
                '<div class="d-flex order-actions"><a href="javascript:;" class="ms-3" id="removeWorkExp"><i class="bx bxs-trash text-danger"></i></a></div>' +
                '</td>';
            b += '</tr>';
            $('#WorkExpData').append(b);
        } //WorkExperience

        function getTraining() {
            $('#Training_JCId').val($('#JCId').val());
            var JCId = $('#JCId').val();
            $.ajax({
                url: "{{ route('Candidate_Training') }}",
                type: "POST",
                data: {
                    JCId: JCId
                },
                dataType: "json",
                success: function(data) {

                    TrainingCount = data.data.length;
                    for (var i = 1; i <= TrainingCount; i++) {
                        if (i >= 2) {
                            Training(i);
                        }
                        $('#TrainingNature' + i).val(data.data[i - 1].training);
                        $('#TrainingOrganization' + i).val(data.data[i - 1].organization);
                        $('#TrainingFromDate' + i).val(data.data[i - 1].from);
                        $('#TrainingToDate' + i).val(data.data[i - 1].to);


                    }
                }
            });
        } //getTraining

        function Training(num) {
            var b = '';
            b += '<tr>';
            b += '<td>' + '<input type="text" name="TrainingNature[]" id="TrainingNature' + num +
                '" class="form-control form-control-sm">' + '</td>' +
                '<td>' + '<input type="text" name="TrainingOrganization[]" id="TrainingOrganization' + num +
                '" class="form-control form-control-sm">' + '</td>' +
                '<td>' + '<input type="date" name="TrainingFromDate[]" id="TrainingFromDate' + num +
                '" class="form-control form-control-sm">' + '</td>' +
                '<td>' + '<input type="date" name="TrainingToDate[]" id="TrainingToDate' + num +
                '" class="form-control form-control-sm">' + '</td>' +
                '<td>' +
                '<div class="d-flex order-actions"><a href="javascript:;" class="ms-3" id="removeTraining"><i class="bx bxs-trash text-danger"></i></a></div>' +
                '</td>';
            b += '</tr>';
            $('#TrainingData').append(b);
        } //Training

        function getPreOrgRef() {
            $('#PreOrgRef_JCId').val($('#JCId').val());
            var JCId = $('#JCId').val();
            $.ajax({
                url: "{{ route('Candidate_PreOrgRef') }}",
                type: "POST",
                data: {
                    JCId: JCId
                },
                dataType: "json",
                success: function(data) {

                    RefCount = data.data.length;
                    for (var i = 1; i <= RefCount; i++) {
                        if (i >= 2) {
                            PreviousOrgReference(i);
                        }
                        $('#PreOrgName' + i).val(data.data[i - 1].name);
                        $('#PreOrgCompany' + i).val(data.data[i - 1].company);
                        $('#PreOrgEmail' + i).val(data.data[i - 1].email);
                        $('#PreOrgContact' + i).val(data.data[i - 1].contact);
                        $('#PreOrgDesignation' + i).val(data.data[i - 1].designation);


                    }
                }
            });
        } //getPreOrgRef

        function PreviousOrgReference(num) {
            var b = '';
            b += '<tr>';
            b += '<td>' + '<input type="text" name="PreOrgName[]" id="PreOrgName' + num +
                '" class="form-control form-control-sm">' + '</td>' +
                '<td>' + '<input type="text" name="PreOrgCompany[]" id="PreOrgCompany' + num +
                '" class="form-control form-control-sm">' + '</td>' +
                '<td>' + '<input type="text" name="PreOrgEmail[]" id="PreOrgEmail' + num +
                '" class="form-control form-control-sm">' + '</td>' +
                '<td>' + '<input type="text" name="PreOrgContact[]" id="PreOrgContact' + num +
                '" class="form-control form-control-sm">' + '</td>' +
                '<td>' + '<input type="text" name="PreOrgDesignation[]" id="PreOrgDesignation' + num +
                '" class="form-control form-control-sm">' + '</td>' +
                '<td>' +
                '<div class="d-flex order-actions"><a href="javascript:;" class="ms-3" id="removePreOrgRef"><i class="bx bxs-trash text-danger"></i></a></div>' +
                '</td>';
            b += '</tr>';
            $('#PreOrgRefData').append(b);
        } //PreviousOrgReference

        function getVnrRef() {
            $('#Vnr_JCId').val($('#JCId').val());
            var JCId = $('#JCId').val();
            $.ajax({
                url: "{{ route('Candidate_VnrRef') }}",
                type: "POST",
                data: {
                    JCId: JCId
                },
                dataType: "json",
                success: function(data) {

                    RefCount = data.data.length;
                    for (var i = 1; i <= RefCount; i++) {
                        if (i >= 2) {
                            VNRReference(i);
                        }
                        $('#VnrRefName' + i).val(data.data[i - 1].name);
                        $('#VnrRefRelWithPerson' + i).val(data.data[i - 1].rel_with_person);
                        $('#VnrRefEmail' + i).val(data.data[i - 1].email);
                        $('#VnrRefContact' + i).val(data.data[i - 1].contact);
                        $('#VnrRefDesignation' + i).val(data.data[i - 1].designation);
                        $('#VnrRefCompany' + i).val(data.data[i - 1].company);
                        $('#OtherCompany' + i).val(data.data[i - 1].other_company);
                        $('#VnrRefLocation' + i).val(data.data[i - 1].location);
                        if (data.data[i - 1].company == 'Other') {
                            $('#OtherCompany' + i).removeClass('d-none');
                        }


                    }
                }
            });
        } //getVnrRef

        function VNRReference(num) {
            var b = '';
            b += '<tr>';
            b += '<td>' + '<input type="text" name="VnrRefName[]" id="VnrRefName' + num +
                '" class="form-control form-control-sm">' + '</td>' +
                '<td>' + '<input type="text" name="VnrRefContact[]" id="VnrRefContact' + num +
                '" class="form-control form-control-sm">' + '</td>' +
                '<td>' + '<input type="text" name="VnrRefEmail[]" id="VnrRefEmail' + num +
                '" class="form-control form-control-sm">' + '</td>' +
                '<td>' + '<select name="VnrRefCompany[]" id="VnrRefCompany' + num +
                '" class="form-select form-select-sm" onchange="GetOtherCompany(' + num + ')">' +
                '<option value="">Select</option>' + '<option value="VNR Seeds Pvt. Ltd.">VNR Seeds Pvt. Ltd.</option>' +
                '<option value="VNR Nursery Pvt. Ltd.">VNR Nursery Pvt. Ltd.</option>' +
                '<option value="Other">Other</option>' +
                '</select>  <input type="text" name="OtherCompany[]" id="OtherCompany' + num +
                '" class="d-none form-control form-control-sm" placeholder="Enter Other Company Name">' + '</td>' +
                '<td>' + '<input type="text" name="VnrRefDesignation[]" id="VnrRefDesignation' + num +
                '" class="form-control form-control-sm">' + '</td>' +
                '<td>' + '<input type="text" name="VnrRefLocation[]" id="VnrRefLocation' + num +
                '" class="form-control form-control-sm">' + '</td>' +
                '<td>' + '<input type="text" name="VnrRefRelWithPerson[]" id="VnrRefRelWithPerson' + num +
                '" class="form-control form-control-sm">' + '</td>' +
                '<td>' +
                '<div class="d-flex order-actions"><a href="javascript:;" class="ms-3" id="removeVnrRef"><i class="bx bxs-trash text-danger"></i></a></div>' +
                '</td>';
            b += '</tr>';
            $('#VNRRefData').append(b);
        } //VNRReference

        function getVnrRef_Business() {
            $('#Business_JCId').val($('#JCId').val());
            var JCId = $('#JCId').val();
            $.ajax({
                url: "{{ route('Candidate_VnrRef_Business') }}",
                type: "POST",
                data: {
                    JCId: JCId
                },
                dataType: "json",
                success: function(data) {
                    if (data.status == 200) {
                        VRef_Business_Count = data.data.length;
                        for (var i = 1; i <= VRef_Business_Count; i++) {
                            if (i >= 2) {
                                VNRReference_Business(i);
                            }
                            $('#VnrRefBusiness_Name' + i).val(data.data[i - 1].Name);
                            $('#VnrRefBusiness_Contact' + i).val(data.data[i - 1].Mobile);
                            $('#VnrRefBusiness_Email' + i).val(data.data[i - 1].Email);
                            $('#VnrRefBusinessRelation' + i).val(data.data[i - 1].BusinessRelation);
                            $('#VnrRefBusiness_Location' + i).val(data.data[i - 1].Location);
                            $('#VnrRefBusiness_RelWithPerson' + i).val(data.data[i - 1].PersonRelation);

                        }
                    }
                }
            });
        } //getVnrRef

        function VNRReference_Business(num) {
            var b = '';
            b += '<tr>';
            b += '<td>' + '<input type="text" name="VnrRefBusiness_Name[]" id="VnrRefBusiness_Name' + num +
                '" class="form-control form-control-sm">' + '</td>' +
                '<td>' + '<input type="text" name="VnrRefBusiness_Contact[]" id="VnrRefBusiness_Contact' + num +
                '" class="form-control form-control-sm">' + '</td>' +
                '<td>' + '<input type="text" name="VnrRefBusiness_Email[]" id="VnrRefBusiness_Email' + num +
                '" class="form-control form-control-sm">' + '</td>' +
                '<td>' + '<select name="VnrRefBusinessRelation[]" id="VnrRefBusinessRelation' + num +
                '" class="form-select form-select-sm">' +
                '<option value="">Select</option>' + '<option value="Dealer">Dealer</option>' +
                '<option value="Distributor">Distributor</option>' +
                '<option value="Retailer">Retailer</option>' +
                '<option value="Organizer">Organizer</option>' +
                '<option value="Vendor">Vendor</option>' +
                '</select>' + '</td>' +
                '<td>' + '<input type="text" name="VnrRefBusiness_Location[]" id="VnrRefBusiness_Location' + num +
                '" class="form-control form-control-sm">' + '</td>' +
                '<td>' + '<input type="text" name="VnrRefBusiness_RelWithPerson[]" id="VnrRefBusiness_RelWithPerson' + num +
                '" class="form-control form-control-sm">' + '</td>' +
                '<td>' +
                '<div class="d-flex order-actions"><a href="javascript:;" class="ms-3" id="removeVnrRef"><i class="bx bxs-trash text-danger"></i></a></div>' +
                '</td>';
            b += '</tr>';
            $('#VNR_Business_AcqData').append(b);
        } //VNRReference

        function getOtherSeed() {
            var JCId = $('#JCId').val();
            $('#OtherSeed_JCId').val(JCId);
            $.ajax({
                url: "{{ route('Candidate_Other_Seed_Relation') }}",
                type: "POST",
                data: {
                    JCId: JCId
                },
                dataType: "json",
                success: function(data) {
                    if (data.status == 200) {
                        OtherSeedCount = data.data.length;
                        for (var x = 1; x <= OtherSeedCount; x++) {
                            if (x >= 2) {
                                OtherSeed(x);
                            }
                            $('#OtherSeedName' + x).val(data.data[x - 1].Name);
                            $('#OtherSeedMobile' + x).val(data.data[x - 1].Mobile);
                            $('#OtherSeedEMail' + x).val(data.data[x - 1].Email);
                            $('#OtherSeedCompany' + x).val(data.data[x - 1].CompanyName);
                            $('#OtherSeedDesignation' + x).val(data.data[x - 1].Designation);
                            $('#OtherSeedLocation' + x).val(data.data[x - 1].Location);
                            $('#OtherSeedRelation' + x).val(data.data[x - 1].Relation);

                        }
                    }
                }
            });
        }

        function OtherSeed(num) {
            var c = '';
            c += '<tr>';
            c += '<td>' + '<input type="text" name="OtherSeedName[]" id="OtherSeedName' + num +
                '" class="form-control form-control-sm">' + '</td>' +
                '<td>' + '<input type="text" name="OtherSeedMobile[]" id="OtherSeedMobile' + num +
                '" class="form-control form-control-sm">' + '</td>' +
                '<td>' + '<input type="text" name="OtherSeedEMail[]" id="OtherSeedEMail' + num +
                '" class="form-control form-control-sm">' + '</td>' +
                '<td>' + '<input type="text" name="OtherSeedCompany[]" id="OtherSeedCompany' + num +
                '" class="form-control form-control-sm">' + '</td>' +
                '<td>' + '<input type="text" name="OtherSeedDesignation[]" id="OtherSeedDesignation' + num +
                '" class="form-control form-control-sm">' + '</td>' +
                '<td>' + '<input type="text" name="OtherSeedLocation[]" id="OtherSeedLocation' + num +
                '" class="form-control form-control-sm">' + '</td>' +
                '<td>' + '<input type="text" name="OtherSeedRelation[]" id="OtherSeedRelation' + num +
                '" class="form-control form-control-sm">' + '</td>' +
                '<td>' +
                '<div class="d-flex order-actions"><a href="javascript:;" class="ms-3" id="removeOtherSeed"><i class="bx bxs-trash text-danger"></i></a></div>' +
                '</td>';
            c += '</tr>';
            $('#OtherSeed').append(c);
        }

        function GetOtherCompany(num) {
            var VnrRefCompany = $('#VnrRefCompany' + num).val();
            if (VnrRefCompany == 'Other') {
                $('#OtherCompany' + num).removeClass('d-none');
            } else {
                $('#OtherCompany' + num).addClass('d-none');
            }
        }

        function getLanguageProficiency() {
            $('#Language_JCId').val($('#JCId').val());
            var JCId = $('#JCId').val();
            $.ajax({
                url: "{{ route('Candidate_Language') }}",
                type: "POST",
                data: {
                    JCId: JCId
                },
                dataType: "json",
                success: function(data) {

                    LanguageCount = data.data.length;

                    for (var i = 1; i <= LanguageCount; i++) {

                        if (i > 2) {
                            LaguageProficiency(i);
                        }

                        $('#Language' + i).val(data.data[i - 1].language);

                        if (data.data[i - 1].read == 1) {
                            $('#Read' + i).prop('checked', true);
                            $('#Read' + i).val(1);
                        }
                        if (data.data[i - 1].write == 1) {
                            $('#Write' + i).prop('checked', true);
                            $('#Write' + i).val(1);
                        }
                        if (data.data[i - 1].speak == 1) {
                            $('#Speak' + i).prop('checked', true);
                            $('#Speak' + i).val(1);
                        }


                    }
                }
            });
        } //getLanguageProficiency

        function LaguageProficiency(num) {
            var b = '';
            b += '<tr class="text-center">';
            b += '<td>' + '<input type="text" name="Language[]" id="Language' + num +
                '" class="form-control form-control-sm">' + '</td>' +
                '<td>' + '<input type="checkbox" name="Read[]" id="Read' + num + '" value="0">' + '</td>' +
                '<td>' + '<input type="checkbox" name="Write[]" id="Write' + num + '" value="0">' + '</td>' +
                '<td>' + '<input type="checkbox" name="Speak[]" id="Speak' + num + '" value="0">' + '</td>' +
                '<td>' +

                '<div class="d-flex order-actions"><a href="javascript:;" class="ms-3" id="removeLanguage"><i class="bx bxs-trash text-danger"></i></a></div>' +
                '</td>';

            b += '</tr>';
            $('#LanguageData').append(b);
        } //LanguageProficiency

        function getSpecialization(EducationId, No) {
            var EducationId = EducationId;
            var No = No;
            $.ajax({
                type: "GET",
                url: "{{ route('getSpecialization') }}?EducationId=" + EducationId,
                async: false,

                success: function(res) {

                    if (res) {

                        $("#Specialization" + No).empty();
                        $("#Specialization" + No).append(
                            '<option value="" selected disabled >Select Specialization</option>');
                        $.each(res, function(key, value) {
                            $("#Specialization" + No).append('<option value="' + value + '">' + key +
                                '</option>');
                        });
                        $("#Specialization" + No).append('<option value="0">Other</option>');


                    } else {
                        $("#Specialization" + No).empty();
                    }
                }
            });
        } //getSpecialization   

        function getLocation(StateId) {
            var StateId = StateId;
            $.ajax({
                type: "GET",
                url: "{{ route('getDistrict') }}?StateId=" + StateId,
                async: false,
                beforeSend: function() {
                    $('#PreDistLoader').removeClass('d-none');
                    $('#PreDistrict').addClass('d-none');
                },
                success: function(res) {
                    if (res) {
                        setTimeout(function() {
                                $('#PreDistLoader').addClass('d-none');
                                $('#PreDistrict').removeClass('d-none');
                                $("#PreDistrict").empty();
                                $("#PreDistrict").append(
                                    '<option value="" selected disabled >Select District</option>');
                                $.each(res, function(key, value) {
                                    $("#PreDistrict").append('<option value="' + value + '">' +
                                        key +
                                        '</option>');
                                });
                            },
                            500);
                    } else {
                        $("#PreDistrict").empty();
                    }
                }
            });
        } //getLocation

        function getLocation1(StateId) {
            var StateId = StateId;
            $.ajax({
                type: "GET",
                url: "{{ route('getDistrict') }}?StateId=" + StateId,
                async: false,
                beforeSend: function() {
                    $('#PermDistLoader').removeClass('d-none');
                    $('#PermDistrict').addClass('d-none');
                },
                success: function(res) {
                    if (res) {
                        setTimeout(function() {
                                $('#PermDistLoader').addClass('d-none');
                                $('#PermDistrict').removeClass('d-none');
                                $("#PermDistrict").empty();
                                $("#PermDistrict").append(
                                    '<option value="" selected disabled >Select District</option>');
                                $.each(res, function(key, value) {
                                    $("#PermDistrict").append('<option value="' + value + '">' +
                                        key +
                                        '</option>');
                                });
                            },
                            500);
                    } else {
                        $("#PermDistrict").empty();
                    }
                }
            });
        } // getLocation1

        function GetCurrentAddress() {
            var JCId = $('#JCId').val();
            $.ajax({
                url: "{{ route('Candidate_CurrentAddress') }}",
                type: "POST",
                data: {
                    JCId: JCId
                },
                dataType: "json",
                success: function(data) {
                    $('#Current_JCId').val($('#JCId').val());
                    $('#PreAddress').val(data.data.pre_address);
                    $('#PreCity').val(data.data.pre_city);
                    $('#PreState').val(data.data.pre_state);
                    $('#PrePinCode').val(data.data.pre_pin);
                    $('#PreDistrict').val(data.data.pre_dist);
                }
            });
        } // GetCurrentAddress

        function GetPermanentAddress() {
            var JCId = $('#JCId').val();
            $.ajax({
                url: "{{ route('Candidate_PermanentAddress') }}",
                type: "POST",
                data: {
                    JCId: JCId
                },
                dataType: "json",
                success: function(data) {
                    $('#Permanent_JCId').val($('#JCId').val());
                    $('#PermAddress').val(data.data.perm_address);
                    $('#PermCity').val(data.data.perm_city);
                    $('#PermState').val(data.data.perm_state);
                    $('#PermPinCode').val(data.data.perm_pin);
                    $('#PermDistrict').val(data.data.perm_dist);
                }
            });
        } // GetPermanentAddress

        function GetCurrentEmployementData() {
            var JCId = $('#JCId').val();
            $.ajax({
                url: "{{ route('Candidate_PersonalData') }}",
                type: "POST",
                data: {
                    JCId: JCId
                },
                dataType: "json",
                success: function(data) {
                    $('#Curr_JCId').val($('#JCId').val());
                    $('#CurrCompanyName').val(data.data.PresentCompany);
                    $('#CurrDepartment').val(data.data.PresentDepartment);
                    $('#CurrDesignation').val(data.data.Designation);
                    $('#CurrDateOfJoining').val(data.data.JobStartDate);
                    $('#CurrReportingTo').val(data.data.Reporting);
                    $('#CurrRepDesig').val(data.data.RepDesig);
                    $('#CurrJobResponsibility').val(data.data.JobResponsibility);
                    $('#CurrReason').val(data.data.ResignReason);
                    $('#CurrNoticePeriod').val(data.data.NoticePeriod);
                }
            });
        } // GetCurrentEmployementData

        function GetPresentSalaryDetails() {
            var JCId = $('#JCId').val();
            $.ajax({
                url: "{{ route('Candidate_PersonalData') }}",
                type: "POST",
                data: {
                    JCId: JCId
                },
                dataType: "json",
                success: function(data) {
                    $('#Sal_JCId').val($('#JCId').val());
                    $('#CurrSalary').val(data.data.GrossSalary);
                    $('#CurrCTC').val(data.data.CTC);
                    $('#CurrDA').val(data.data.DAHq);
                    $('#DAOutHq').val(data.data.DAOutHq);
                    $('#PetrolAlw').val(data.data.PetrolAlw);
                    $('#PhoneAlw').val(data.data.PhoneAlw);
                    $('#HotelElg').val(data.data.HotelElg);
                }
            });
        } // GetPresentSalaryDetails


        $(document).on('click', '.dlchk', function() {
            var val = $(this).data('value');

            if (val == 'Y') {
                $('#dl_div').removeClass('d-none');
                $('#DLNo').addClass('reqinp_abt');
                $('#LValidity').addClass('reqinp_abt');
                $('.tab-content').height('auto');
            } else {
                $('#dl_div').addClass('d-none');
                $('#DLNo').removeClass('reqinp_abt');
                $('#LValidity').removeClass('reqinp_abt');
                $('.tab-content').height('auto');
            }
        });

        $(document).on('click', '.crime', function() {
            var val = $(this).data('value');
            if (val == 'Y') {
                $('#crime_div').removeClass('d-none');
                $('#AboutCriminal').addClass('reqinp_abt');
                $('.tab-content').height('auto');
            } else {
                $('#crime_div').addClass('d-none');
                $('#AboutCriminal').removeClass('reqinp_abt');
                $('.tab-content').height('auto');
            }
        });
        $(document).on('click', '#addMember', function() {
            MemberCount++;
            familymember(MemberCount);
        }); // addMember

        $(document).on('click', '#removeMember', function() {
            if (confirm('Are you sure you want to delete this member?')) {
                $(this).closest('tr').remove();
                MemberCount--;
            }
        });

        $(document).on('click', '#addEducation', function() {
            EducationCount++;
            Qualification(EducationCount);
        });

        $(document).on('click', '#removeQualification', function() {
            if (confirm('Are you sure you want to delete this record?')) {
                $(this).closest('tr').remove();
                EducationCount--;
            }
        });

        $(document).on('click', '#addExperience', function() {
            WorkExpCount++;
            WorkExperience(WorkExpCount);
        });

        $(document).on('click', '#removeWorkExp', function() {
            if (confirm('Are you sure you want to delete this record?')) {
                $(this).closest('tr').remove();
                WorkExpCount--;
            }
        });

        $(document).on('click', '#addTraining', function() {
            TrainingCount++;
            Training(TrainingCount);
        });

        $(document).on('click', '#removeTraining', function() {
            if (confirm('Are you sure you want to delete this record?')) {
                $(this).closest('tr').remove();
                TrainingCount--;
            }
        });

        $(document).on('click', '#addPreOrgRef', function() {
            RefCount++;
            PreviousOrgReference(RefCount);
        });

        $(document).on('click', '#removePreOrgRef', function() {
            if (confirm('Are you sure you want to delete this record?')) {
                $(this).closest('tr').remove();
                RefCount--;
            }
        });

        $(document).on('click', '#addVnrRef', function() {
            VRefCount++;
            VNRReference(VRefCount);
        });

        $(document).on('click', '#removeVnrRef', function() {
            if (confirm('Are you sure you want to delete this record?')) {
                $(this).closest('tr').remove();
                VRefCount--;
            }
        });

        $(document).on('click', '#addLanguage', function() {
            LanguageCount++;
            LaguageProficiency(LanguageCount);
        });

        $(document).on('click', '#removeLanguage', function() {
            if (confirm('Are you sure you want to delete this record?')) {
                $(this).closest('tr').remove();
                LanguageCount--;
            }
        });

        $(document).on('click', '#addOtherSeed', function() {
            OtherSeedCount++;

            OtherSeed(OtherSeedCount);
            $(".tab-content").height('auto');
        });

        $(document).on('click', '#removeOtherSeed', function() {
            if (confirm('Are you sure you want to delete this record?')) {
                $(this).closest('tr').remove();
                OtherSeedCount--;
                $(".tab-content").height('auto');
            }
        });

        $(document).on('click', '#addVnrRef_Business', function() {
            VRef_Business_Count++;

            VNRReference_Business(VRef_Business_Count);
            $(".tab-content").height('auto');
        });

        $(document).on('click', '#removeVnrRef_Business', function() {
            if (confirm('Are you sure you want to delete this record?')) {
                $(this).closest('tr').remove();
                VRef_Business_Count--;
                $(".tab-content").height('auto');
            }
        });


        $(document).on('change', '#Religion', function() {
            var Religion = $(this).val();
            if (Religion == 'Others') {
                $('#OtherReligion').removeClass('d-none');
            } else {
                $('#OtherReligion').addClass('d-none');
            }
        });

        $(document).on('change', '#Category', function() {
            var Category = $(this).val();
            if (Category == 'Other') {
                $('#OtherCategory').removeClass('d-none');
            } else {
                $('#OtherCategory').addClass('d-none');
            }
        });

        $(document).on('change', '#MaritalStatus', function() {
            var MaritalStatus = $(this).val();
            if (MaritalStatus == 'Married') {
                $('#MDate').removeClass('d-none');
                $('#Spouse').removeClass('d-none');
            } else {
                $('#MDate').addClass('d-none');
                $('#Spouse').addClass('d-none');
            }
        });

        $('#CandidatePersonalForm').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                success: function(data) {
                    console.log(data);
                    if (data.status == 400) {
                        toastr.error(data.msg);
                    } else {
                        $(form)[0].reset();
                        $('#createpostmodal').modal('hide');
                        toastr.success(data.msg);
                        window.location.reload();
                    }
                }
            });
        });
        $('#CandidateProfileForm').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                success: function(data) {
                    console.log(data);
                    if (data.status == 400) {
                        toastr.error(data.msg);
                    } else {
                        $(form)[0].reset();
                        $('#createpostmodal').modal('hide');
                        toastr.success(data.msg);
                        window.location.reload();
                    }
                }
            });
        });

        $('#EmergencyContactForm').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                success: function(data) {
                    if (data.status == 400) {
                        toastr.error(data.msg);
                    } else {
                        $(form)[0].reset();
                        $('#emergency_contact_modal').modal('hide');
                        toastr.success(data.msg);
                        window.location.reload();
                    }
                }
            });
        });

        $('#BankInfoForm').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                success: function(data) {
                    if (data.status == 400) {
                        toastr.error(data.msg);
                    } else {
                        $(form)[0].reset();
                        $('#bank_info_modal').modal('hide');
                        toastr.success(data.msg);
                        window.location.reload();
                    }
                }
            });
        });

        $('#FamilyInfoForm').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                success: function(data) {
                    if (data.status == 400) {
                        toastr.error(data.msg);
                    } else {
                        $(form)[0].reset();
                        $('#family_info_modal').modal('hide');
                        toastr.success(data.msg);
                        window.location.reload();
                    }
                }
            });
        });

        $('#CurrentAddressForm').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                success: function(data) {
                    if (data.status == 400) {
                        toastr.error(data.msg);
                    } else {
                        $(form)[0].reset();
                        $('#current_address_modal').modal('hide');
                        toastr.success(data.msg);
                        window.location.reload();
                    }
                }
            });
        });

        $('#PermanentAddressForm').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                success: function(data) {
                    if (data.status == 400) {
                        toastr.error(data.msg);
                    } else {
                        $(form)[0].reset();
                        $('#permanent_address_modal').modal('hide');
                        toastr.success(data.msg);
                        window.location.reload();
                    }
                }
            });
        });

        $('#EducationInfoForm').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                success: function(data) {
                    if (data.status == 400) {
                        toastr.error(data.msg);
                    } else {
                        $(form)[0].reset();
                        $('#education_info_modal').modal('hide');
                        toastr.success(data.msg);
                        window.location.reload();
                    }
                }
            });
        });

        $('#WorkExpForm').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                success: function(data) {
                    if (data.status == 400) {
                        toastr.error(data.msg);
                    } else {
                        $(form)[0].reset();
                        $('#work_exp_modal').modal('hide');
                        toastr.success(data.msg);
                        window.location.reload();
                    }
                }
            });
        });

        $('#CurrentEmpForm').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                success: function(data) {
                    if (data.status == 400) {
                        toastr.error(data.msg);
                    } else {
                        $(form)[0].reset();
                        $('#current_emp_modal').modal('hide');
                        toastr.success(data.msg);
                        window.location.reload();
                    }
                }
            });
        });

        $('#CurrentSalaryForm').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                success: function(data) {
                    if (data.status == 400) {
                        toastr.error(data.msg);
                    } else {
                        $(form)[0].reset();
                        $('#current_salary_modal').modal('hide');
                        toastr.success(data.msg);
                        window.location.reload();
                    }
                }
            });
        });

        $('#TrainingForm').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                success: function(data) {
                    if (data.status == 400) {
                        toastr.error(data.msg);
                    } else {
                        $(form)[0].reset();
                        $('#training_modal').modal('hide');
                        toastr.success(data.msg);
                        window.location.reload();
                    }
                }
            });
        });

        $('#PreOrgRefForm').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                success: function(data) {
                    if (data.status == 400) {
                        toastr.error(data.msg);
                    } else {
                        $(form)[0].reset();
                        $('#pre_org_ref_modal').modal('hide');
                        toastr.success(data.msg);
                        window.location.reload();
                    }
                }
            });
        });

        $('#VNRRefForm').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                success: function(data) {
                    if (data.status == 400) {
                        toastr.error(data.msg);
                    } else {
                        $(form)[0].reset();
                        $('#vnr_ref_modal').modal('hide');
                        toastr.success(data.msg);
                        window.location.reload();
                    }
                }
            });
        });

        $('#OtherSeedForm').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                success: function(data) {
                    if (data.status == 400) {
                        toastr.error(data.msg);
                    } else {
                        $(form)[0].reset();
                        $('#other_seed_modal').modal('hide');
                        toastr.success(data.msg);
                        window.location.reload();
                    }
                }
            });
        });

        $('#BusinessForm').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                success: function(data) {
                    if (data.status == 400) {
                        toastr.error(data.msg);
                    } else {
                        $(form)[0].reset();
                        $('#vnr_business_ref_modal').modal('hide');
                        toastr.success(data.msg);
                        window.location.reload();
                    }
                }
            });
        });

        $('#about_form').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            var formData = new FormData(this);
            formData.append('JCId', $('#JCId').val());
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: formData,
                processData: false,
                dataType: 'json',
                contentType: false,
                success: function(data) {
                    if (data.status == 400) {
                        toastr.error(data.msg);
                    } else {
                        $(form)[0].reset();
                        $('#vnr_business_ref_modal').modal('hide');
                        toastr.success(data.msg);
                        window.location.reload();
                    }
                }
            });
        });

        $('#SendMailForm').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {
                    $('#send_mail_btn').html('<i class="fa fa-spinner fa-spin"></i> Sending...');
                },
                success: function(data) {
                    if (data.status == 400) {
                        toastr.error(data.msg);
                    } else {
                        $(form)[0].reset();
                        $('.compose-mail-popup').hide();
                        toastr.success(data.msg);
                    }
                }
            });
        });

        function printInterviewForm(url) {
            $("<iframe>") // create a new iframe element
                .hide() // make it invisible
                .attr("src", url) // point the iframe to the page you want to print
                .appendTo("body");
        }

        function printJoiningForm(url) {
            $("<iframe>") // create a new iframe element
                .hide() // make it invisible
                .attr("src", url) // point the iframe to the page you want to print
                .appendTo("body");
        }

        $("#permanent_chk").change(function() {
            if (!this.checked) {
                $("#permanent_div").addClass("d-none");
            } else {
                $("#permanent_div").removeClass("d-none");
            }
        });

        $("#temporary_chk").change(function() {
            if (!this.checked) {
                $("#temporary_div").addClass("d-none");
            } else {
                $("#temporary_div").removeClass("d-none");
            }
        });

        $("#administrative_chk").change(function() {
            if (!this.checked) {
                $("#administrative_div").addClass("d-none");
            } else {
                $("#administrative_div").removeClass("d-none");
            }
        });

        $("#functional_chk").change(function() {
            if (!this.checked) {
                $("#functional_div").addClass("d-none");
            } else {
                $("#functional_div").removeClass("d-none");
            }
        });

        $(document).on('change', '#Grade', function() {
            var Grade = $(this).val();
            var value = 'nopnot';
            if (Grade >= 70) {
                $('.scon').css('display', 'none');
                $("input[name=ServiceCond][value=" + value + "]").prop('checked', true);
            } else {
                $('.scon').css('display', 'inline-block');
                $("input[name=ServiceCond][value=" + value + "]").prop('checked', false);
            }
        });

        $(document).on('click', '#offerltredit', function() {
            var JAId = $(this).data('id');
            $.ajax({
                type: "GET",
                url: "{{ route('get_offerltr_basic_detail') }}?JAId=" + JAId,
                success: function(res) {
                    if (res.status == 200) {
                        $('#Of_JAId').val(JAId);
                        $('#JCId').val(res.candidate_detail.JCId);
                        $('#SelectedForC').val(res.candidate_detail.SelectedForC);
                        $('#SelectedForD').val(res.candidate_detail.SelectedForD);
                        $("#Grade").empty();
                        $("#Grade").append(
                            '<option value="0">Select Grade</option>');
                        $.each(res.grade_list, function(key, value) {
                            $("#Grade").append('<option value="' + value + '">' + key +
                                '</option>');
                        });
                        $('#Grade').val(res.candidate_detail.Grade);
                        var name = res.candidate_detail.FName;
                        if (res.candidate_detail.MName != null) {
                            name += ' ' + res.candidate_detail.MName;
                        }
                        name += ' ' + res.candidate_detail.LName;
                        $('#CandidateName').val(name);
                        $('#Father').val(res.candidate_detail.FatherName);
                        $('#SelectedDepartment').val(res.candidate_detail.DepartmentName);

                        $("#Designation").empty();
                        $("#Designation").append(
                            '<option value="0">Select Designation</option>');
                        $.each(res.designation_list, function(key, value) {
                            $("#Designation").append('<option value="' + value + '">' + key +
                                '</option>');
                        });

                        $('#Designation').val(res.candidate_detail.Designation);


                        $("#Vertical").empty();
                        $("#Vertical").append(
                            '<option value="0">Select Vertical</option>');
                        $.each(res.vertical_list, function(key, value) {
                            $("#Vertical").append('<option value="' + value + '">' + key +
                                '</option>');
                        });

                        $('#Vertical').val(res.candidate_detail.VerticalId);



                        $("#AdministrativeDepartment").empty();
                        $("#AdministrativeDepartment").append(
                            '<option value="">Select Department</option>');
                        $.each(res.department_list, function(key, value) {
                            $("#AdministrativeDepartment").append('<option value="' + value +
                                '">' + key +
                                '</option>');
                        });


                        $("#FunctionalDepartment").empty();
                        $("#FunctionalDepartment").append(
                            '<option value="">Select Department</option>');
                        $.each(res.department_list, function(key, value) {
                            $("#FunctionalDepartment").append('<option value="' + value + '">' +
                                key +
                                '</option>');
                        });

                        $("#AdministrativeEmployee").empty();
                        $("#AdministrativeEmployee").append(
                            '<option value="">Select Employee</option>');
                        $.each(res.employee_list, function(key, value) {
                            $("#AdministrativeEmployee").append('<option value="' + key + '">' +
                                value +
                                '</option>');
                        });

                        $("#FunctionalEmployee").empty();
                        $("#FunctionalEmployee").append(
                            '<option value="">Select Employee</option>');
                        $.each(res.employee_list, function(key, value) {
                            $("#FunctionalEmployee").append('<option value="' + key + '">' +
                                value +
                                '</option>');
                        });

                        $("#AftDesignation").empty();
                        $("#AftDesignation").append(
                            '<option value="0">Select Designation</option>');
                        $.each(res.designation_list, function(key, value) {
                            $("#AftDesignation").append('<option value="' + value + '">' + key +
                                '</option>');
                        });

                        $("#AftGrade").empty();
                        $("#AftGrade").append(
                            '<option value="0">Select Grade</option>');
                        $.each(res.grade_list, function(key, value) {
                            $("#AftGrade").append('<option value="' + value + '">' + key +
                                '</option>');
                        });

                        $("#Of_PermState").empty();
                        $("#Of_PermState").append(
                            '<option value="0">Select State</option>');
                        $.each(res.state_list, function(key, value) {
                            $("#Of_PermState").append('<option value="' + value + '">' + key +
                                '</option>');
                        });

                        $("#PermHQ").empty();
                        $("#PermHQ").append(
                            '<option value="0">Select State</option>');
                        $.each(res.headquarter_list, function(key, value) {
                            $("#PermHQ").append('<option value="' + value + '">' + key +
                                '</option>');
                        });

                        $("#TempState").empty();
                        $("#TempState").append(
                            '<option value="0">Select State</option>');
                        $.each(res.state_list, function(key, value) {
                            $("#TempState").append('<option value="' + value + '">' + key +
                                '</option>');
                        });

                        $("#TempHQ").empty();
                        $("#TempHQ").append(
                            '<option value="0">Select State</option>');
                        $.each(res.headquarter_list, function(key, value) {
                            $("#TempHQ").append('<option value="' + value + '">' + key +
                                '</option>');
                        });

                        if (res.candidate_detail.FixedS == 1) {
                            $('#permanent_chk').prop('checked', true);
                            $("#permanent_div").removeClass("d-none");
                            $('#Of_PermState').val(res.candidate_detail.F_StateHq);
                            $('#PermHQ').val(res.candidate_detail.F_LocationHq);
                            $('#Of_PermCity').val(res.candidate_detail.F_City);
                        } else {
                            $("#permanent_div").addClass("d-none");
                        }
                        if (res.candidate_detail.TempS == 1) {
                            $('#temporary_chk').prop('checked', true);
                            $("#temporary_div").removeClass("d-none");
                            $('#TempState').val(res.candidate_detail.T_StateHq);
                            $('#TempHQ').val(res.candidate_detail.T_LocationHq);
                            $('#TempCity').val(res.candidate_detail.T_City);
                            $('#TemporaryMonth').val(res.candidate_detail.TempM);
                        } else {
                            $("#temporary_div").addClass("d-none");
                        }

                        if (res.candidate_detail.Functional_R == 1) {
                            $('#functional_chk').prop('checked', true);
                            $("#functional_div").removeClass("d-none");
                            $('#FunctionalDepartment').val(res.candidate_detail.Functional_Dpt);
                            $('#FunctionalEmployee').val(res.candidate_detail.F_ReportingManager);

                        } else {
                            $("#functional_div").addClass("d-none");
                        }

                        if (res.candidate_detail.Admins_R == 1) {
                            $('#administrative_chk').prop('checked', true);
                            $("#administrative_div").removeClass("d-none");
                            $('#AdministrativeDepartment').val(res.candidate_detail.Admins_Dpt);
                            $('#AdministrativeEmployee').val(res.candidate_detail.A_ReportingManager);

                        } else {
                            $("#administrative_div").addClass("d-none");
                        }

                        $('#CTC').val(res.candidate_detail.CTC);
                        if (res.candidate_detail.ServiceCondition != '') {
                            $("input[name=ServiceCond][value=" + res.candidate_detail.ServiceCondition +
                                "]").prop('checked', true);
                        }

                        if (res.candidate_detail.ServiceCondition === 'Training') {
                            $('#training_tr').removeClass('d-none');
                            $("#OrientationPeriod").val(res.candidate_detail.OrientationPeriod);
                            $("#Stipend").val(res.candidate_detail.Stipend);
                            $("#AftDesignation").val(res.candidate_detail.AFT_Designation);
                            $("#AftGrade").val(res.candidate_detail.AFT_Grade);
                        } else {
                            $('#training_tr').addClass('d-none');
                        }

                        if (res.candidate_detail.ServiceBond != '') {
                            $("input[name=ServiceBond][value=" + res.candidate_detail.ServiceBond +
                                "]").prop('checked', true);
                        }

                        if (res.candidate_detail.ServiceBond === 'Yes') {
                            $('#bond_tr').removeClass('d-none');
                            $('#ServiceBondDuration').val(res.candidate_detail.ServiceBondYears);
                            $('#ServiceBondRefund').val(res.candidate_detail.ServiceBondRefund);
                        } else {
                            $('#bond_tr').addClass('d-none');
                        }

                        if (res.candidate_detail.PreMedicalCheckUp != '') {
                            $("input[name=MedicalCheckup][value=" + res.candidate_detail
                                .PreMedicalCheckUp +
                                "]").prop('checked', true);
                        }

                        $('#SignAuth').val(res.candidate_detail.SigningAuth);
                        $('#Remark').val(res.candidate_detail.Remarks);

                    } else {
                        alert('something went wrong..!!');
                    }
                }
            });
        });

        $('#OfferLtrModal').on('hidden.bs.modal', function() {
            $('#offerletterbasicform')[0].reset();
        });

        $(document).on('change', '#AdministrativeDepartment', function() {
            var DepartmentId = $(this).val();
            $.ajax({
                type: "GET",
                url: "{{ route('getReportingManager') }}?DepartmentId=" + DepartmentId,
                success: function(res) {
                    if (res) {
                        $("#AdministrativeEmployee").empty();
                        $("#AdministrativeEmployee").append(
                            '<option value="">Select Reporting</option>');
                        $.each(res, function(key, value) {
                            $("#AdministrativeEmployee").append('<option value="' + value +
                                '">' +
                                key +
                                '</option>');
                        });
                        $('#AdministrativeEmployee').val();
                    } else {
                        $("#AdministrativeEmployee").empty();
                    }
                }
            });
        });

        $(document).on('change', '#FunctionalDepartment', function() {
            var DepartmentId = $(this).val();
            $.ajax({
                type: "GET",
                url: "{{ route('getReportingManager') }}?DepartmentId=" + DepartmentId,
                success: function(res) {
                    if (res) {
                        $("#FunctionalEmployee").empty();
                        $("#FunctionalEmployee").append(
                            '<option value="">Select Reporting</option>');
                        $.each(res, function(key, value) {
                            $("#FunctionalEmployee").append('<option value="' + value + '">' +
                                key +
                                '</option>');
                        });
                        $('#FunctionalEmployee').val();
                    } else {
                        $("#FunctionalEmployee").empty();
                    }
                }
            });
        });

        $('#offerletterbasicform').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {
                    $(form).find('span.error-text').text('');
                    $("#loader").modal('show');
                },
                success: function(data) {
                    if (data.status == 400) {
                        $("#loader").modal('hide');
                        $.each(data.error, function(prefix, val) {
                            $(form).find('span.' + prefix + '_error').text(val[0]);
                        });
                    } else {
                        $(form)[0].reset();
                        $('#loader').modal('hide');
                        $('#OfferLtrModal').modal('hide');
                    }
                }
            });
        });

        $('#reviewForm').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {
                    $(form).find('span.error-text').text('');
                    $('#review_modal').modal('hide');
                    $("#loader").modal('show');
                },
                success: function(data) {
                    if (data.status == 400) {
                        $("#loader").modal('hide');
                        $('#review_modal').modal('show');
                        $.each(data.error, function(prefix, val) {
                            $(form).find('span.' + prefix + '_error').text(val[0]);
                        });
                    } else {
                        $(form)[0].reset();
                        $('#loader').modal('hide');
                        $('#review_modal').modal('hide');
                        toastr.success(data.msg);
                        window.location.reload();
                    }
                }
            });
        });

        $('#ref_chk_form').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {
                    $(form).find('span.error-text').text('');
                    $('#ref_modal').modal('hide');
                    $("#loader").modal('show');
                },
                success: function(data) {
                    if (data.status == 400) {
                        $("#loader").modal('hide');
                        $('#ref_modal').modal('show');
                        $.each(data.error, function(prefix, val) {
                            $(form).find('span.' + prefix + '_error').text(val[0]);
                        });
                    } else {
                        $(form)[0].reset();
                        $('#loader').modal('hide');
                        $('#ref_modal').modal('hide');
                        toastr.success(data.msg);
                        window.location.reload();
                    }
                }
            });
        });

        $(document).on('click', '#offerltrgen', function() {
            var JAId = $(this).data('id');
            sendingId = btoa(JAId);
            window.open("{{ route('offer_letter_generate') }}?jaid=" + sendingId, '_blank');
        });

        function OfferLetterPrint(url) {
            $("<iframe>") // create a new iframe element
                .hide() // make it invisible
                .attr("src", url) // point the iframe to the page you want to print
                .appendTo("body");
        }

        function PrintAppointmentLetter(url) {
            $("<iframe>") // create a new iframe element
                .hide() // make it invisible
                .attr("src", url) // point the iframe to the page you want to print
                .appendTo("body");
        }

        function PrintServiceAgreementLetter(url) {
            $("<iframe>") // create a new iframe element
                .hide() // make it invisible
                .attr("src", url) // point the iframe to the page you want to print
                .appendTo("body");
        }

        function PrintServiceBondLetter(url) {
            $("<iframe>") // create a new iframe element
                .hide() // make it invisible
                .attr("src", url) // point the iframe to the page you want to print
                .appendTo("body");
        }

        function getOfHistory(JAId) {
            var JAId = JAId;
            var route = "{{ route('offer_ltr_history') }}";
            $.ajax({
                type: "GET",
                url: "{{ route('offerLtrHistory') }}?jaid=" + JAId,
                success: function(res) {
                    var x = '';
                    $.each(res.data, function(key, value) {
                        x += '<tr>';
                        x += '<td>' + value.OfDate + '</td>';
                        x += '<td>' + value.LtrNo + '</td>';
                        x += '<td><a href="' + route + '?LtrId=' + value.LtrId +
                            '" target="_blank">View Offer</a></td>';
                        x += '<td>' + value.RevisionRemark + '</td>';
                    });
                    $('#offerHistory').html(x);
                }
            });
        }

        function joinDateEnbl(jaid, th) {
            $('#dateofJoin').prop('readonly', false);
            $('#joindtenable').hide(500);
            $('#JoinSave').show(500);
            $('#JoinCanc').show(500);
        }

        function saveJoinDate() {
            var joinDate = $('#dateofJoin').val();
            var JAId = $('#JAId').val();
            $.ajax({
                type: "POST",
                url: "{{ route('saveJoinDate') }}?JAId=" + JAId + "&JoinDate=" + joinDate,
                success: function(res) {
                    if (res.status == 200) {
                        $('#joindtenable').show(500);
                        $('#JoinSave').hide(500);
                        $('#JoinCanc').hide(500);
                        $('#dateofJoin').prop('readonly', true);
                        toastr.success(res.msg);
                    } else {
                        toastr.error(res.msg);
                    }
                }
            });
        }

        function empCodeEnable() {
            $('#empCode').prop('readonly', false);
            $('#empCodeEnable').hide(500);
            $('#EmpCodeSave').show(500);
            $('#empCancle').show(500);
        }

        function saveEmpCode() {
            var EmpCode = $('#empCode').val();
            var JAId = $('#JAId').val();
            $.ajax({
                type: "POST",
                url: "{{ route('saveEmpCode') }}?JAId=" + JAId + "&EmpCode=" + EmpCode,
                success: function(res) {
                    if (res.status == 200) {
                        $('#empCodeEnable').show(500);
                        $('#EmpCodeSave').hide(500);
                        $('#empCancle').hide(500);
                        $('#empCode').prop('readonly', true);
                        toastr.success(res.msg);
                    } else {
                        toastr.error(res.msg);
                        window.location.reload();
                    }
                }
            });
        }

        function copyOfLink() {
            var copyText = document.getElementById("oflink");
            copyText.select();
            copyText.setSelectionRange(0, 99999)
            document.execCommand("copy");
            alert("Copied Link: " + copyText.value);
        }

        function copyJFrmLink() {
            var copyText = document.getElementById("jflink");
            copyText.select();
            copyText.setSelectionRange(0, 99999)
            document.execCommand("copy");
            alert("Copied Link: " + copyText.value);
        }

        function copyJIntFrmLink() {
            var copyText = document.getElementById("interviewlink");
            copyText.select();
            copyText.setSelectionRange(0, 99999)
            document.execCommand("copy");
            alert("Copied Link: " + copyText.value);
        }

        function copyFiroBlink() {
            var copyText = document.getElementById("firoblink");
            copyText.select();
            copyText.setSelectionRange(0, 99999)
            document.execCommand("copy");
            alert("Copied Link: " + copyText.value);
        }

        function sendOfferLtr(JAId) {
            var JAId = JAId;
            $.ajax({
                url: "{{ route('SendOfferLtr') }}",
                type: "POST",
                data: {
                    "JAId": JAId
                },
                beforeSend: function() {
                    $('#loader').modal('show');
                },
                success: function(data) {
                    if (data.status == 400) {
                        toastr.error(data.msg);
                    } else {
                        $('#loader').modal('hide');
                        toastr.success(data.msg);
                        window.location.reload();
                    }
                }
            });
        }

        function offerReopen(JAId) {
            var JAId = JAId;
            var url = '<?= route('offerReopen') ?>';
            swal.fire({
                title: 'Are you sure?',
                html: 'You want to <b>Open</b> this Offer',
                showCancelButton: true,
                showCloseButton: true,
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Yes',
                cancelButtonColor: '#d33',
                confirmButtonColor: '#556ee6',
                width: 400,
                allowOutsideClick: false

            }).then(function(result) {
                if (result.value) {
                    $.post(url, {
                        JAId: JAId
                    }, function(data) {
                        if (data.status == 200) {
                            toastr.success(data.msg);
                            window.location.reload();
                        } else {
                            toastr.error(data.msg);
                        }
                    }, 'json');
                }
            });
        }

        function viewReview(JAId) {

            var JAId = JAId;
            var url = '<?= route('viewReview') ?>';
            $.get(url, {
                JAId: JAId
            }, function(data) {
                if (data.status == 200) {
                    $('#view_review').modal('show');
                    $x = '';
                    $i = 1;
                    var reason = '';
                    $.each(data.data, function(key, value) {

                        if (value.RejReason == null) {
                            reason = '-';
                        } else {
                            reason = value.RejReason;
                        }
                        $x += '<tr>';
                        $x += '<td>' + $i + '</td>';
                        $x += '<td>' + value.OfferLetterNo + '</td>';
                        $x += '<td>' + value.full_name + '</td>';
                        $x += '<td>' + value.Status + '</td>';
                        $x += '<td>' + reason + '</td>';
                        $x += '</tr>';
                        $i++;
                    });
                    $('#viewReviewData').html($x);

                } else {
                    toastr.error(data.msg);
                }
            }, 'json');
        }

        for (i = 1; i <= 10; i++) {

            $(document).on('change', '#Read' + i, function() {

                if ($(this).prop('checked')) {
                    $(this).val('1');
                } else {
                    $(this).val('0');
                }
            });

            $(document).on('change', '#Write' + i, function() {
                if ($(this).prop('checked')) {
                    $(this).val('1');
                } else {
                    $(this).val('0');
                }
            });



            $(document).on('change', '#Speak' + i, function() {
                if ($(this).prop('checked')) {
                    $(this).val('1');
                } else {
                    $(this).val('0');
                }
            });


        }

        $(document).on('click', '#save_language', function() {
            var language_array = [];
            for (i = 1; i <= 10; i++) {
                var lang = $('#Language' + i).val();
                var read = $('#Read' + i).val();
                var write = $('#Write' + i).val();
                var speak = $('#Speak' + i).val();
                language_array.push({
                    'language': lang,
                    'read': read,
                    'write': write,
                    'speak': speak
                });
            }

            var url = '<?= route('Candidate_Language_Save') ?>';
            $.post(url, {
                language_array: language_array,
                JCId: $('#JCId').val()
            }, function(data) {
                if (data.status == 200) {
                    toastr.success(data.msg);
                    window.location.reload();
                } else {
                    toastr.error(data.msg);
                }
            }, 'json');

        });


        function getOtherInstitute(num) {
            var Collage = $('#Collage' + num).val();
            console.log(Collage);
            if (Collage == '637') {
                $('#OtherInstitute' + num).removeClass('d-none');
            } else {
                $('#OtherInstitute' + num).addClass('d-none');
            }
        }

        function appointmentGen(JAId) {
            var JAId = btoa(JAId);
            $.ajax({
                url: "{{ route('appointmentGen') }}",
                type: "POST",
                data: {
                    "JAId": JAId
                },

                success: function(data) {
                    if (data.status == 400) {
                        toastr.error(data.msg);
                    } else {
                        window.open('{{ route('appointment_letter') }}?jaid=' + JAId, '_blank');
                    }
                }
            });
        }

        function ServiceAgrGen(JAId) {
            var JAId = btoa(JAId);
            window.open('{{ route('service_agreement') }}?jaid=' + JAId, '_blank');
        }

        function ServiceBondGen(JAId) {
            var JAId = btoa(JAId);
            window.open('{{ route('service_bond') }}?jaid=' + JAId, '_blank');
        }
    </script>
    <script>
        /*
         * This is the plugin
         */
        (function(a) {
            a.createModal = function(b) {
                defaults = {
                    title: "",
                    message: "Your Message Goes Here!",
                    closeButton: true,
                    scrollable: false
                };
                var b = a.extend({}, defaults, b);
                var c = (b.scrollable === true) ? 'style="max-height: 420px;overflow-y: auto;"' : "";
                html =
                    '<div class="modal fade custom-modal" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false">';
                html += '<div class="modal-dialog">';
                html += '<div class="modal-content">';
                html +=
                    '<div class="modal-header"><button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
                html += '<div class="modal-body" ' + c + ">";
                html += b.message;
                html += "</div>";
                html += '<div class="modal-footer">';

                html += "</div>";
                html += "</div>";
                html += "</div>";
                html += "</div>";
                a("body").prepend(html);
                a("#myModal").modal('show').on("hidden.bs.modal", function() {
                    a(this).remove()
                })
            }
        })(jQuery);

        /*
         * Here is how you use it
         */
        $(function() {
            $('.view-pdf').on('click', function() {
                var pdf_link = $(this).attr('href');

                var iframe = '<div class="iframe-container"><iframe src="' + pdf_link + '"></iframe></div>'
                $.createModal({
                    title: 'My Title',
                    message: iframe,
                    closeButton: true,
                    scrollable: false
                });
                return false;
            });
        })
    </script>

    <script>
        $(document).on('click', '#RelievingLtrUpload', function() {
            var JCId = $('#JCId').val();
            var url = '<?= route('RelievingLtrFileUpload') ?>';
            var RelievingLtr = $('#RelievingLtr')[0].files;
            var formData = new FormData();
            formData.append('JCId', JCId);
            formData.append('RelievingLtr', RelievingLtr[0]);
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    if (data.status == 400) {
                        toastr.error(data.msg);
                    } else {
                        toastr.success(data.msg);
                        window.location.reload();

                    }
                },
                error: function(data) {
                    var errors = data.responseJSON;
                    var errorsHtml = '';
                    $.each(errors.errors, function(key, value) {
                        errorsHtml += value[0] + '<br>';
                    });
                    toastr.error(errorsHtml)
                }
            });
        });

        $(document).on('click', '#SalarySlipUpload', function() {
            var JCId = $('#JCId').val();
            var url = '<?= route('SalarySlipFileUpload') ?>';
            var SalarySlip = $('#SalarySlip')[0].files;
            var formData = new FormData();
            formData.append('JCId', JCId);
            formData.append('SalarySlip', SalarySlip[0]);
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    if (data.status == 200) {
                        toastr.success(data.msg);
                        window.location.reload();
                    } else {
                        toastr.error(data.msg);
                    }

                },
                error: function(data) {
                    var errors = data.responseJSON;
                    var errorsHtml = '';
                    $.each(errors.errors, function(key, value) {
                        errorsHtml += value[0] + '<br>';
                    });
                    toastr.error(errorsHtml)
                }
            });
        });

        $(document).on('click', '#AppraisalLtrUpload', function() {
            var JCId = $('#JCId').val();
            var url = '<?= route('AppraisalLtrFileUpload') ?>';
            var AppraisalLtr = $('#AppraisalLtr')[0].files;
            var formData = new FormData();
            formData.append('JCId', JCId);
            formData.append('AppraisalLtr', AppraisalLtr[0]);
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    if (data.status == 400) {
                        toastr.error(data.msg);
                    } else {
                        toastr.success(data.msg);
                        window.location.reload();

                    }
                },
                error: function(data) {
                    var errors = data.responseJSON;
                    var errorsHtml = '';
                    $.each(errors.errors, function(key, value) {
                        errorsHtml += value[0] + '<br>';
                    });
                    toastr.error(errorsHtml)
                }
            });
        });

        $(document).on('click', '#VaccinationCertUpload', function() {
            var JCId = $('#JCId').val();
            var url = '<?= route('VaccinationCertFileUpload') ?>';
            var VaccinationCert = $('#VaccinationCert')[0].files;
            var formData = new FormData();
            formData.append('JCId', JCId);
            formData.append('VaccinationCert', VaccinationCert[0]);
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    if (data.status == 400) {
                        toastr.error(data.msg);
                    } else {
                        toastr.success(data.msg);
                        window.location.reload();

                    }
                },
                error: function(data) {
                    var errors = data.responseJSON;
                    var errorsHtml = '';
                    $.each(errors.errors, function(key, value) {
                        errorsHtml += value[0] + '<br>';
                    });
                    toastr.error(errorsHtml)
                }
            });
        });

        $(document).on('click', '#AadhaarUpload', function() {
            var JCId = $('#JCId').val();
            var url = '<?= route('AadhaarUpload') ?>';
            var AadhaarCard = $('#AadhaarCard')[0].files;
            var formData = new FormData();
            formData.append('JCId', JCId);
            formData.append('AadhaarCard', AadhaarCard[0]);
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    if (data.status == 400) {
                        toastr.error(data.msg);

                    } else {

                        toastr.success(data.msg);
                        window.location.reload();

                    }
                },
                error: function(data) {
                    var errors = data.responseJSON;
                    var errorsHtml = '';
                    $.each(errors.errors, function(key, value) {
                        errorsHtml += value[0] + '<br>';
                    });
                    toastr.error(errorsHtml);

                }
            });
        });

        $(document).on('click', '#PANCardUpload', function() {
            var JCId = $('#JCId').val();
            var url = '<?= route('PanCardUpload') ?>';
            var PANCard = $('#PANCard')[0].files;
            var PanCardNumber = $('#PanCardNumber').val();
            var formData = new FormData();
            formData.append('JCId', JCId);
            formData.append('PANCard', PANCard[0]);
            formData.append('PanCardNumber', PanCardNumber);
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    if (data.status == 400) {
                        toastr.error(data.msg);

                    } else {

                        toastr.success(data.msg);
                        window.location.reload();

                    }
                },
                error: function(data) {
                    var errors = data.responseJSON;
                    var errorsHtml = '';
                    $.each(errors.errors, function(key, value) {
                        errorsHtml += value[0] + '<br>';
                    });
                    toastr.error(errorsHtml);

                }
            });
        });

        $(document).on('click', '#PassportUpload', function() {
            var JCId = $('#JCId').val();
            var url = '<?= route('PassportUpload') ?>';
            var Passport = $('#Passport')[0].files;
            var PassportNumber = $('#PassportNumber').val();
            var formData = new FormData();
            formData.append('JCId', JCId);
            formData.append('Passport', Passport[0]);
            formData.append('PassportNumber', PassportNumber);
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    if (data.status == 200) {

                        toastr.success(data.msg);
                        window.location.reload();
                    } else {
                        toastr.error(data.msg);

                    }

                },
                error: function(data) {
                    var errors = data.responseJSON;
                    var errorsHtml = '';
                    $.each(errors.errors, function(key, value) {
                        errorsHtml += value[0] + '<br>';
                    });
                    toastr.error(errorsHtml);

                }
            });
        });

        $(document).on('click', '#DLCardUpload', function() {
            var JCId = $('#JCId').val();
            var url = '<?= route('DlUpload') ?>';
            var DLCard = $('#DLCard')[0].files;
            var formData = new FormData();
            formData.append('JCId', JCId);
            formData.append('DLCard', DLCard[0]);
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    if (data.status == 400) {
                        toastr.error(data.msg);

                    } else {

                        toastr.success(data.msg);
                        window.location.reload();

                    }
                },
                error: function(data) {
                    var errors = data.responseJSON;
                    var errorsHtml = '';
                    $.each(errors.errors, function(key, value) {
                        errorsHtml += value[0] + '<br>';
                    });
                    toastr.error(errorsHtml);

                }
            });
        });

        $(document).on('click', '#PFForm2Upload', function() {
            var JCId = $('#JCId').val();
            var url = '<?= route('PF_Form2Upload') ?>';
            var PFForm2 = $('#PFForm2')[0].files;
            var formData = new FormData();
            formData.append('JCId', JCId);
            formData.append('PFForm2', PFForm2[0]);
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    if (data.status == 400) {
                        toastr.error(data.msg);

                    } else {

                        toastr.success(data.msg);
                        window.location.reload();

                    }
                },
                error: function(data) {
                    var errors = data.responseJSON;
                    var errorsHtml = '';
                    $.each(errors.errors, function(key, value) {
                        errorsHtml += value[0] + '<br>';
                    });
                    toastr.error(errorsHtml);

                }
            });
        });

        $(document).on('click', '#PFForm11Upload', function() {
            var JCId = $('#JCId').val();
            var url = '<?= route('PF_Form11Upload') ?>';
            var PF_Form11 = $('#PF_Form11')[0].files;
            var formData = new FormData();
            formData.append('JCId', JCId);
            formData.append('PF_Form11', PF_Form11[0]);
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    if (data.status == 400) {
                        toastr.error(data.msg);

                    } else {

                        toastr.success(data.msg);
                        window.location.reload();

                    }
                },
                error: function(data) {
                    var errors = data.responseJSON;
                    var errorsHtml = '';
                    $.each(errors.errors, function(key, value) {
                        errorsHtml += value[0] + '<br>';
                    });
                    toastr.error(errorsHtml);

                }
            });
        });

        $(document).on('click', '#GratuityUpload', function() {
            var JCId = $('#JCId').val();
            var url = '<?= route('GratuityUpload') ?>';
            var GratuityForm = $('#GratuityForm')[0].files;
            var formData = new FormData();
            formData.append('JCId', JCId);
            formData.append('GratuityForm', GratuityForm[0]);
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    if (data.status == 400) {
                        toastr.error(data.msg);

                    } else {

                        toastr.success(data.msg);
                        window.location.reload();

                    }
                },
                error: function(data) {
                    var errors = data.responseJSON;
                    var errorsHtml = '';
                    $.each(errors.errors, function(key, value) {
                        errorsHtml += value[0] + '<br>';
                    });
                    toastr.error(errorsHtml);

                }
            });
        });

        $(document).on('click', '#ESICFormUpload', function() {
            var JCId = $('#JCId').val();
            var url = '<?= route('ESICUpload') ?>';
            var ESICForm = $('#ESICForm')[0].files;
            var formData = new FormData();
            formData.append('JCId', JCId);
            formData.append('ESICForm', ESICForm[0]);
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    if (data.status == 400) {
                        toastr.error(data.msg);

                    } else {

                        toastr.success(data.msg);
                        window.location.reload();

                    }
                },
                error: function(data) {
                    var errors = data.responseJSON;
                    var errorsHtml = '';
                    $.each(errors.errors, function(key, value) {
                        errorsHtml += value[0] + '<br>';
                    });
                    toastr.error(errorsHtml);

                }
            });
        });

        $(document).on('click', '#ESIC_FamilyUpload', function() {
            var JCId = $('#JCId').val();
            var url = '<?= route('FamilyUpload') ?>';
            var ESIC_Family = $('#ESIC_Family')[0].files;
            var formData = new FormData();
            formData.append('JCId', JCId);
            formData.append('ESIC_Family', ESIC_Family[0]);
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    if (data.status == 400) {
                        toastr.error(data.msg);

                    } else {

                        toastr.success(data.msg);
                        window.location.reload();

                    }
                },
                error: function(data) {
                    var errors = data.responseJSON;
                    var errorsHtml = '';
                    $.each(errors.errors, function(key, value) {
                        errorsHtml += value[0] + '<br>';
                    });
                    toastr.error(errorsHtml);

                }
            });
        });

        $(document).on('click', '#HealthUpload', function() {
            var JCId = $('#JCId').val();
            var url = '<?= route('HealthUpload') ?>';
            var Health = $('#Health')[0].files;
            var formData = new FormData();
            formData.append('JCId', JCId);
            formData.append('Health', Health[0]);
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    if (data.status == 400) {
                        toastr.error(data.msg);

                    } else {

                        toastr.success(data.msg);
                        window.location.reload();

                    }
                },
                error: function(data) {
                    var errors = data.responseJSON;
                    var errorsHtml = '';
                    $.each(errors.errors, function(key, value) {
                        errorsHtml += value[0] + '<br>';
                    });
                    toastr.error(errorsHtml);

                }
            });
        });

        $(document).on('click', '#EthicalUpload', function() {
            var JCId = $('#JCId').val();
            var url = '<?= route('EthicalUpload') ?>';
            var Ethical = $('#Ethical')[0].files;
            var formData = new FormData();
            formData.append('JCId', JCId);
            formData.append('Ethical', Ethical[0]);
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    if (data.status == 400) {
                        toastr.error(data.msg);

                    } else {

                        toastr.success(data.msg);
                        window.location.reload();

                    }
                },
                error: function(data) {
                    var errors = data.responseJSON;
                    var errorsHtml = '';
                    $.each(errors.errors, function(key, value) {
                        errorsHtml += value[0] + '<br>';
                    });
                    toastr.error(errorsHtml);

                }
            });
        });

        $(document).on('click', '#BloodGroupUpload', function() {
            var JCId = $('#JCId').val();
            var url = '<?= route('BloodGroupUpload') ?>';
            var BloodGroup = $('#BloodGroup')[0].files;
            var formData = new FormData();
            formData.append('JCId', JCId);
            formData.append('BloodGroup', BloodGroup[0]);
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    if (data.status == 400) {
                        toastr.error(data.msg);

                    } else {

                        toastr.success(data.msg);
                        window.location.reload();

                    }
                },
                error: function(data) {
                    var errors = data.responseJSON;
                    var errorsHtml = '';
                    $.each(errors.errors, function(key, value) {
                        errorsHtml += value[0] + '<br>';
                    });
                    toastr.error(errorsHtml);

                }
            });
        });

        $(document).on('click', '#BankPassBookUpload', function() {
            var JCId = $('#JCId').val();
            var url = '<?= route('BankUpload') ?>';
            var BankPassBook = $('#BankPassBook')[0].files;
            var BankName = $('#BankName').val();
            var AccNumber = $('#AccNumber').val();
            var IFSC = $('#IFSC').val();
            var BranchName = $('#BranchName').val();
            var formData = new FormData();
            formData.append('JCId', JCId);
            formData.append('BankPassBook', BankPassBook[0]);
            formData.append('BankName', BankName);
            formData.append('AccNumber', AccNumber);
            formData.append('IFSC', IFSC);
            formData.append('BranchName', BranchName);
            if (BankName == '') {
                toastr.error('Please Enter Bank Name');
                return false;
            }
            if (BranchName == '') {
                toastr.error('Please Enter Branch Name');
                return false;
            }
            if (AccNumber == '') {
                toastr.error('Please Enter Account Number');
                return false;
            }
            if (IFSC == '') {
                toastr.error('Please Enter IFSC Code');
                return false;
            }

            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    if (data.status == 400) {
                        toastr.error(data.msg);

                    } else {

                        toastr.success(data.msg);
                        window.location.reload();

                    }
                },
                error: function(data) {
                    var errors = data.responseJSON;
                    var errorsHtml = '';
                    $.each(errors.errors, function(key, value) {
                        errorsHtml += value[0] + '<br>';
                    });
                    toastr.error(errorsHtml);

                }
            });
        });

        function VerificationEnable() {
            $('#Verification').prop('disabled', false);
            $('#VerificationEnable').hide(500);
            $('#SaveVerification').show(500);
            $('#verificationCancle').show(500);
        }

        $(document).on('click', '#SaveVerification', function() {
            var JAId = $('#JAId').val();
            var Verification = $('#Verification').val();
            $.ajax({
                url: '<?= route('VerificationSave') ?>',
                method: 'POST',
                data: {
                    JAId: JAId,
                    Verification: Verification
                },
                dataType: 'json',
                success: function(data) {
                    if (data.status == 400) {
                        toastr.error(data.msg);
                    } else {
                        toastr.success(data.msg);
                        window.location.reload();

                    }
                },

            });
        });

        function JoinedEnbl() {
            $('#Joined').prop('disabled', false);
            $('#JoinedEnbl').hide(500);
            $('#SaveJoined').show(500);
            $('#JoinedCancle').show(500);
        }

        $(document).on('click', '#SaveJoined', function() {
            var JAId = $('#JAId').val();
            var Joined = $('#Joined').val();
            $.ajax({
                url: '<?= route('JoinedSave') ?>',
                method: 'POST',
                data: {
                    JAId: JAId,
                    Joined: Joined
                },
                dataType: 'json',
                success: function(data) {
                    if (data.status == 400) {
                        toastr.error(data.msg);
                    } else {
                        toastr.success(data.msg);
                        window.location.reload();

                    }
                },

            });
        });

        function PosEnbl() {
            $('#PositionCode').prop('readonly', false);
            $('#PosEnbl').hide(500);
            $('#PositionCodeSave').show(500);
            $('#posCancle').show(500);
        }

        $(document).on('click', '#PositionCodeSave', function() {
            var JAId = $('#JAId').val();
            var PositionCode = $('#PositionCode').val();
            $.ajax({
                url: '<?= route('AssignPositionCode') ?>',
                method: 'POST',
                data: {
                    JAId: JAId,
                    PositionCode: PositionCode
                },
                dataType: 'json',
                success: function(data) {
                    if (data.status == 400) {
                        toastr.error(data.msg);
                    } else {
                        toastr.success(data.msg);
                        window.location.reload();

                    }
                },

            });
        });

        $(document).on('click', '#ProcessToEss', function() {
            var JAId = $('#JAId').val();
            $.ajax({
                url: '<?= route('processDataToEss') ?>',
                method: 'POST',
                data: {
                    JAId: JAId
                },
                dataType: 'json',
                beforeSend: function() {
                    $("#loader").modal('show');
                },
                success: function(data) {
                    if (data.status == 400) {
                        $("#loader").modal('hide');
                        toastr.error(data.msg);
                    } else {

                        $("#loader").modal('hide');
                        toastr.success(data.msg);

                        window.location.reload();
                    }
                },

            });
        });
    </script>
@endsection
