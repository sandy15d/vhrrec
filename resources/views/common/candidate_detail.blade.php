@php
use Illuminate\Support\Carbon;
use function App\Helpers\getDistrictName;
use function App\Helpers\getStateName;
use function App\Helpers\getEducationById;
use function App\Helpers\getSpecializationbyId;
use function App\Helpers\getCollegeById;
$sendingId = request()->query('jaid');
$JAId = base64_decode($sendingId);
$Rec = DB::table('jobapply')
    ->join('jobcandidates', 'jobapply.JCId', '=', 'jobcandidates.JCId')
    ->leftJoin('jobpost', 'jobapply.JPId', '=', 'jobpost.JPId')
    ->leftJoin('jf_contact_det', 'jobcandidates.JCId', '=', 'jf_contact_det.JCId')
    ->leftJoin('jf_pf_esic', 'jobcandidates.JCId', '=', 'jf_pf_esic.JCId')
    ->where('JAId', $JAId)
    ->select('jobapply.*', 'jobcandidates.*', 'jobpost.Title', 'jobpost.JobCode', 'jf_contact_det.pre_address', 'jf_contact_det.pre_city', 'jf_contact_det.pre_state', 'jf_contact_det.pre_pin', 'jf_contact_det.pre_dist', 'jf_contact_det.perm_address', 'jf_contact_det.perm_city', 'jf_contact_det.perm_state', 'jf_contact_det.perm_pin', 'jf_contact_det.perm_dist', 'jf_contact_det.cont_one_name', 'jf_contact_det.cont_one_relation', 'jf_contact_det.cont_one_number', 'jf_contact_det.cont_two_name', 'jf_contact_det.cont_two_relation', 'jf_contact_det.cont_two_number', 'jf_pf_esic.UAN', 'jf_pf_esic.PFNumber', 'jf_pf_esic.ESICNumber', 'jf_pf_esic.BankName', 'jf_pf_esic.BranchName', 'jf_pf_esic.IFSCCode', 'jf_pf_esic.AccountNumber', 'jf_pf_esic.PAN')
    ->first();

$JCId = $Rec->JCId;

$FamilyInfo = DB::table('jf_family_det')
    ->where('JCId', $JCId)
    ->get();
$Education = DB::table('candidateeducation')
    ->where('JCId', $JCId)
    ->get();
$Experience = DB::table('jf_work_exp')
    ->where('JCId', $JCId)
    ->get();
$Year = Carbon::now()->year;
@endphp
@extends('layouts.master')
@section('title', 'Candidate Detail')
@section('PageContent')
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
                                            <h5 class="user-name m-t-0 mb-0"> {{ $Rec->FName }} {{ $Rec->MName }}
                                                {{ $Rec->LName }}</h5>
                                            <h6 class="staff-id">Applied For: {{ $Rec->Title }}</h6>

                                            <div class="staff-id">ReferenceNo : {{ $Rec->ReferenceNo }}</div>
                                            <div class="staff-id">Date of Apply :
                                                {{ date('d-M-Y', strtotime($Rec->ApplyDate)) }}</div>
                                            <div class="staff-msg"><a class="btn btn-custom btn-sm"
                                                    href="https://smarthr.dreamguystech.com/light/chat.html">View Resume</a>
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
                                                <div class="title">
                                                    <a class="text-danger" href="#">Interview Form</a>
                                                </div>
                                                <div class="title">
                                                    <a class="text-danger" href="#">Joining Form</a>
                                                </div>
                                            </li>


                                        </ul>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="pro-edit"><a data-bs-target="#profile_info" data-bs-toggle="modal"
                                    class="edit-icon" href="#"><i class="fa fa-pencil"></i></a></div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card tab-box">
            <div class="row user-tabs">
                <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                    <ul class="nav nav-tabs nav-tabs-bottom">
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

                        <li class="nav-item"><a href="#cand_other" data-bs-toggle="tab"
                                class="nav-link">Other</a></li>

                        <li class="nav-item"><a href="#cand_history" data-bs-toggle="tab"
                                class="nav-link">History</a></li>

                        <li class="nav-item"><a href="#cand_log" data-bs-toggle="tab" class="nav-link">Candidate
                                Log</a></li>

                        <li class="nav-item"><a href="#cand_document" data-bs-toggle="tab"
                                class="nav-link">Documents</a></li>
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
                                <h3 class="card-title">Personal Informations <a href="#" class="edit-icon"
                                        data-bs-toggle="modal" data-bs-target="#personal_info_modal"
                                        onclick="GetPersonalData();"><i class="fa fa-pencil"></i></a></h3>
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
                                        <div class="text">{{ $Rec->Nationality ?? '-' }}</div>
                                    </li>

                                    <li>
                                        <div class="title">Religion<span style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->Religion ?? '-' }} @if ($Rec->Religion == 'Others')<span class="text-danger">({{ $Rec->OtherReligion }})</span> @endif
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
                                        <div class="text">{{ $Rec->Caste ?? '-' }}@if ($Rec->Caste == 'Other')<span class="text-danger">({{ $Rec->OtherCaste }})</span> @endif
                                        </div>
                                    </li>
                                    <li>
                                        <div class="title">Driving License<span style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->DrivingLicense ?? '-' }}
                                            @if ($Rec->DrivingLicense != null)
                                                <br>Validity Upto
                                                - <span>{{ date('d-M-Y', strtotime($Rec->LValidity)) }}</span>
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
                                <h3 class="card-title">Emergency Contact <a href="#" class="edit-icon"
                                        data-bs-toggle="modal" data-bs-target="#emergency_contact_modal"
                                        onclick="GetEmergencyContact();"><i class="fa fa-pencil"></i></a></h3>
                                <h5 class="section-title">Primary</h5>
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
                                <h5 class="section-title">Secondary</h5>
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
                    <div class="col-md-6 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h3 class="card-title">Bank Informations <a href="#" class="edit-icon"
                                        data-bs-toggle="modal" data-bs-target="#bank_info_modal" onclick="GetBankInfo();"><i
                                            class="fa fa-pencil"></i></a></h3>
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
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h3 class="card-title">Family Informations <a href="#" class="edit-icon"
                                        data-bs-toggle="modal" data-bs-target="#family_info_modal" onclick="GetFamily();"><i
                                            class="fa fa-pencil"></i></a></h3>
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
                                <h3 class="card-title">Current Address
                                    <a href="#" class="edit-icon" data-bs-toggle="modal"
                                        data-bs-target="#current_address_modal" onclick="GetCurrentAddress();">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                </h3>
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
                                <h3 class="card-title">Permanent Address
                                    <a href="#" class="edit-icon" data-bs-toggle="modal"
                                        data-bs-target="#permanent_address_modal" onclick="GetPermanentAddress();">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                </h3>
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
                            <h3 class="card-title">Educational Details
                                <a href="#" class="edit-icon" data-bs-toggle="modal"
                                    data-bs-target="#education_info_modal" onclick="GetQualification();">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </h3>
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
                                <h3 class="card-title">Current Employement
                                    <a href="#" class="edit-icon" data-bs-toggle="modal"
                                        data-bs-target="#current_emp_modal" onclick="GetCurrentEmployementData();"><i
                                            class="fa fa-pencil"></i></a>
                                </h3>
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
                                        <div class="title" style="width: 150px;">Department <span
                                                style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->PresentDepartment ?? '-' }}</div>
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
                                <h3 class="card-title">Present Salary Details <a href="#" class="edit-icon"
                                        data-bs-toggle="modal" data-bs-target="#family_info_modal"><i
                                            class="fa fa-pencil"></i></a></h3>
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
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">Previous Employement Records <small>(except the present)</small>
                                <a href="#" class="edit-icon" data-bs-toggle="modal" data-bs-target="#work_exp_modal"
                                    onclick="getWorkExp();">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </h3>

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
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">Training & Practical Experience <small>(Other than regular
                                    jobs)</small>
                                <a href="#" class="edit-icon" data-bs-toggle="modal" data-bs-target="#work_exp_modal"
                                    onclick="getWorkExp();">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </h3>

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
            </div>

            <div class="tab-pane fade" id="cand_reference">
                <div class="col-md-12 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">Previous Organization Reference
                                <a href="#" class="edit-icon" data-bs-toggle="modal"
                                    data-bs-target="#personal_info_modal">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </h3>

                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td>S.No</td>
                                            <td>Organization Name</td>
                                            <td>Designation</td>
                                            <td>Contact No.</td>
                                            <td>Email</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>B.S.R. Engineering College</td>
                                            <td>Assistant Professor</td>
                                            <td>+91-9876543210</td>
                                            <td>abc@gmail.com</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>B.S.R. Engineering College</td>
                                            <td>Assistant Professor</td>
                                            <td>+91-9876543210</td>
                                            <td>xyx@gmail.com</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h3 class="card-title">Acquaintances / Relatives associated with the VNR Group<a
                                        href="#" class="edit-icon" data-bs-toggle="modal"
                                        data-bs-target="#family_info_modal"><i class="fa fa-pencil"></i></a></h3>

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td>S.No</td>
                                            <td>Name</td>
                                            <td>Company</td>
                                            <td>Designation</td>
                                            <td>Relationship</td>
                                            <td>Email</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Sandeep</td>
                                            <td>VNR</td>
                                            <td>Exe IT</td>
                                            <td>Brother</td>
                                            <td>aaa@gmail.com</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Sandeep</td>
                                            <td>VNR</td>
                                            <td>Exe IT</td>
                                            <td>Brother</td>
                                            <td>abc@gmail.com</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="cand_other">
                <div class="col-md-12 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">Language Proficiency
                                <a href="#" class="edit-icon" data-bs-toggle="modal"
                                    data-bs-target="#personal_info_modal">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </h3>
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
                                        <tr>
                                            <td>1</td>
                                            <td>English</td>
                                            <td>Excellent</td>
                                            <td>Excellent</td>
                                            <td>Excellent</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Hindi</td>
                                            <td>Excellent</td>
                                            <td>Excellent</td>
                                            <td>Excellent</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Marathi</td>
                                            <td>Excellent</td>
                                            <td>Excellent</td>
                                            <td>Excellent</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h3 class="card-title">About Yourself<a href="#" class="edit-icon"
                                        data-bs-toggle="modal" data-bs-target="#family_info_modal"><i
                                            class="fa fa-pencil"></i></a></h3>

                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr style="background-color: #F1F8E9">
                                                <td>
                                                    What is your aim in life?
                                                </td>
                                            </tr>
                                            <tr style="background-color: #F9FBE7">
                                                <td>
                                                    &ensp;&ensp;&ensp;I am a good person.
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
                <div class="card">
                    <div class="card-body">
                        History
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="cand_log">
                <div class="card">
                    <div class="card-body">
                        Log
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="cand_document">
                <div class="card">
                    <div class="card-body">
                        Document
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div id="personal_info_modal" class="modal custom-modal fade" role="dialog" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Personal Information</h5>
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
                            <input type="text" name="Nationality" id="Nationality" class="form-control form-control-sm">
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
                        <div class="form-group">
                            <label for="DrivingLicense">Driving License</label>
                            <input type="text" name="DrivingLicense" id="DrivingLicense"
                                class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label for="LValidity">Driving License Validity</label>
                            <input type="date" name="LValidity" id="LValidity" class="form-control form-control-sm">
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
                    <h5 class="modal-title">Emergency Contact</h5>
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
                    <h5 class="modal-title">Bank Information</h5>
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
                    <h5 class="modal-title">Family Information</h5>
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
                    <h5 class="modal-title">Current Address</h5>
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
                    <h5 class="modal-title">Current Address</h5>
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
                    <h5 class="modal-title">Educational Qualification</h5>
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
                                        <td>Qualification</td>
                                        <td style="width: 20%">Course</td>
                                        <td style="width: 20%">Specialization</td>
                                        <td>Board/University</td>
                                        <td>Passing Year</td>
                                        <td style="width: 10%">Percentage</td>
                                        <td style="width: 5%"></td>
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
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="Specialization[]" id="Specialization1"
                                                class="form-select form-select-sm">
                                                <option value="">Select</option>
                                                <option value="0">Other</option>
                                                @foreach ($specialization_list as $key => $value)
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="Collage[]" id="Collage1" class="form-select form-select-sm">
                                                <option value="">Select</option>
                                                @foreach ($institute_list as $key => $value)
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="PassingYear[]" id="PassingYear1"
                                                class="form-select form-select-sm">
                                                <option value="">Select</option>
                                                @for ($i = 1980; $i <= $Year; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
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
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="Specialization[]" id="Specialization2"
                                                class="form-select form-select-sm">
                                                <option value="">Select</option>
                                                <option value="0">Other</option>
                                                @foreach ($specialization_list as $key => $value)
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="Collage[]" id="Collage2" class="form-select form-select-sm">
                                                <option value="">Select</option>
                                                @foreach ($institute_list as $key => $value)
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="PassingYear[]" id="PassingYear2"
                                                class="form-select form-select-sm">
                                                <option value="">Select</option>
                                                @for ($i = 1980; $i <= $Year; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
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
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="Specialization[]" id="Specialization3"
                                                class="form-select form-select-sm">
                                                <option value="">Select</option>
                                                <option value="0">Other</option>
                                                @foreach ($specialization_list as $key => $value)
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="Collage[]" id="Collage3" class="form-select form-select-sm">
                                                <option value="">Select</option>
                                                @foreach ($institute_list as $key => $value)
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="PassingYear[]" id="PassingYear3"
                                                class="form-select form-select-sm">
                                                <option value="">Select</option>
                                                @for ($i = 1980; $i <= $Year; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
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
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="Specialization[]" id="Specialization4"
                                                class="form-select form-select-sm">
                                                <option value="">Select</option>
                                                <option value="0">Other</option>
                                                @foreach ($specialization_list as $key => $value)
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="Collage[]" id="Collage4" class="form-select form-select-sm">
                                                <option value="">Select</option>
                                                @foreach ($institute_list as $key => $value)
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="PassingYear[]" id="PassingYear4"
                                                class="form-select form-select-sm">
                                                <option value="">Select</option>
                                                @for ($i = 1980; $i <= $Year; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
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
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="Specialization[]" id="Specialization5"
                                                class="form-select form-select-sm">
                                                <option value="">Select</option>
                                                <option value="0">Other</option>
                                                @foreach ($specialization_list as $key => $value)
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="Collage[]" id="Collage5" class="form-select form-select-sm">
                                                <option value="">Select</option>
                                                @foreach ($institute_list as $key => $value)
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="PassingYear[]" id="PassingYear5"
                                                class="form-select form-select-sm">
                                                <option value="">Select</option>
                                                @for ($i = 1980; $i <= $Year; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
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
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="Specialization[]" id="Specialization6"
                                                class="form-select form-select-sm">
                                                <option value="">Select</option>
                                                <option value="0">Other</option>
                                                @foreach ($specialization_list as $key => $value)
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="Collage[]" id="Collage6" class="form-select form-select-sm">
                                                <option value="">Select</option>
                                                @foreach ($institute_list as $key => $value)
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="PassingYear[]" id="PassingYear6"
                                                class="form-select form-select-sm">
                                                <option value="">Select</option>
                                                @for ($i = 1980; $i <= $Year; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
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
                    <h5 class="modal-title">Work Experience</h5>
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
                    <h5 class="modal-title">Personal Information</h5>
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
                            <label for="">Department</label>
                            <input type="text" name="CurrDepartment" id="CurrDepartment" class="form-control form-control-sm">
                        </div>
                      
                        <div class="form-group">
                            <label for="">Designation</label>
                            <input type="text" name="CurrDesignation" id="CurrDesignation" class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label for="">Date of Joining</label>
                            <input type="date" name="CurrDateOfJoining" id="CurrDateOfJoining" class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label for="">Reporting To</label>
                            <input type="text" name="CurrReportingTo" id="CurrReportingTo" class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label for="">Reporting Manager Designation</label>
                            <input type="text" name="CurrRepDesig" id="CurrRepDesig" class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label for="">Job Responsibility</label>
                           <textarea name="CurrJobResponsibility" id="CurrJobResponsibility" class="form-control form-control-sm"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Notice Period</label>
                            <input type="text" name="CurrNoticePeriod" id="CurrNoticePeriod" class="form-control form-control-sm">
                        </div>

                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scriptsection')
    <script>
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

        var MemberCount = 1;
        var EducationCount = 6;
        var WorkExpCount = 1;
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
        }

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
        }

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
        }

        function getYearList() {
            var year = new Date().getFullYear();
            YearList = '<option value="">Select</option>';
            for (var i = 1980; i <= year; i++) {
                YearList = YearList + '<option value="' + i + '">' + i + '</option>';
            }
        }

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
        }

        function GetQualification() {
            var JCId = $('#JCId').val();
            $.ajax({
                url: "{{ route('Candidate_Education') }}",
                type: "POST",
                data: {
                    JCId: JCId
                },
                dataType: "json",
                success: function(data) {
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

                    }
                }
            });
        }

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
                '">' + CollegeList +
                '</select>' +
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
        }


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
                    EducationCount = data.data.length;
                    for (var i = 1; i <= EducationCount; i++) {
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
        }

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
        }

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
        }

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
        }

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
        }

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
        }

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
        }

        function GetCurrentEmployementData() {
            var JCId = $('#JCId').val();
            $.ajax({
                url: "{{ route('Candidate_CurrentEmployement') }}",
                type: "POST",
                data: {
                    JCId: JCId
                },
                dataType: "json",
                success: function(data) {
                    $('#CurrentEmployement_JCId').val($('#JCId').val());
                    $('#CurrentEmployementCompanyName').val(data.data.company_name);
                    $('#CurrentEmployementDesignation').val(data.data.designation);
                    $('#CurrentEmployementJoiningDate').val(data.data.joining_date);
                    $('#CurrentEmployementLeavingDate').val(data.data.leaving_date);
                    $('#CurrentEmployementReasonForLeaving').val(data.data.reason_for_leaving);
                }
            });
        }

        $(document).on('click', '#addMember', function() {
            MemberCount++;
            familymember(MemberCount);
        });

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
            if (confirm('Are you sure you want to delete this member?')) {
                $(this).closest('tr').remove();
                EducationCount--;
            }
        });

        $(document).on('click', '#addExperience', function() {
            WorkExpCount++;
            WorkExperience(WorkExpCount);
        });

        $(document).on('click', '#removeWorkExp', function() {
            if (confirm('Are you sure you want to delete this member?')) {
                $(this).closest('tr').remove();
                WorkExpCount--;
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
                    if (data.status == 400) {
                        toastr.error(data.message);
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
                        toastr.error(data.message);
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
                        toastr.error(data.message);
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
                        toastr.error(data.message);
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
                        toastr.error(data.message);
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
                        toastr.error(data.message);
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
                        toastr.error(data.message);
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
                        toastr.error(data.message);
                    } else {
                        $(form)[0].reset();
                        $('#work_exp_modal').modal('hide');
                        toastr.success(data.msg);
                        window.location.reload();
                    }
                }
            });
        });
    </script>
@endsection
