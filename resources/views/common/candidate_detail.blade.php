@php
use Illuminate\Support\Carbon;
$sendingId = request()->query('jaid');
$JAId = base64_decode($sendingId);
$Rec = DB::table('jobapply')
    ->join('jobcandidates', 'jobapply.JCId', '=', 'jobcandidates.JCId')
    ->leftJoin('jobpost', 'jobapply.JPId', '=', 'jobpost.JPId')
    ->leftJoin('jf_contact_det', 'jobcandidates.JCId', '=', 'jf_contact_det.JCId')
    ->where('JAId', $JAId)
    ->select('jobapply.*', 'jobcandidates.*', 'jobpost.Title', 'jobpost.JobCode', 'jf_contact_det.*')
    ->first();
$Fimaly = DB::table('jf_family_det')
    ->where('JCId', $Rec->JCId)
    ->get();

@endphp
@extends('layouts.master')
@section('title', 'Campus Screening Tracker')
@section('PageContent')
    <div class="page-content">
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
                            <div class="pro-edit"><a data-bs-target="#profile_info" data-bs-toggle="modal"
                                    class="edit-icon" href="#"><i class="fa fa-pencil"></i></a></div>
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
                                class="nav-link">Experience</a></li>

                        <li class="nav-item"><a href="#cand_reference" data-bs-toggle="tab"
                                class="nav-link">Reference</a></li>

                        <li class="nav-item"><a href="#cand_other" data-bs-toggle="tab"
                                class="nav-link">Other</a></li>

                        <li class="nav-item"><a href="#cand_history" data-bs-toggle="tab"
                                class="nav-link">Candidate History</a></li>

                        <li class="nav-item"><a href="#cand_log" data-bs-toggle="tab" class="nav-link">Candidate
                                Log</a></li>

                        <li class="nav-item"><a href="#cand_document" data-bs-toggle="tab"
                                class="nav-link">Documents</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="tab-content">
            <div id="cand_profile" class="pro-overview tab-pane fade show active">
                <div class="row">
                    <div class="col-md-6 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h3 class="card-title">Personal Informations <a href="#" class="edit-icon"
                                        data-bs-toggle="modal" data-bs-target="#personal_info_modal"><i
                                            class="fa fa-pencil"></i></a></h3>
                                <ul class="personal-info">
                                    <li>
                                        <div class="title">Gender<span style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->Gender == 'M' ? 'Male' : 'Female' }}</div>
                                    </li>

                                    <li>
                                        <div class="title">Aadhhar No.<span style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->Aadhaar }}</div>
                                    </li>

                                    <li>
                                        <div class="title">Nationality<span style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->Nationality ?? '-' }}</div>
                                    </li>

                                    <li>
                                        <div class="title">Religion<span style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->Religion ?? '-' }}</div>
                                    </li>

                                    <li>
                                        <div class="title">Marital Status<span style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->MaritalStatus ?? '-' }}</div>
                                    </li>
                                    <li>
                                        <div class="title">Marriage Date<span style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->MarriageDate ?? '-' }}</div>
                                    </li>
                                    <li>
                                        <div class="title">Spouse Name<span style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->MarriageDate ?? '-' }}</div>
                                    </li>
                                    <li>
                                        <div class="title">Category<span style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->Caste ?? '-' }}</div>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h3 class="card-title">Emergency Contact <a href="#" class="edit-icon"
                                        data-bs-toggle="modal" data-bs-target="#emergency_contact_modal"><i
                                            class="fa fa-pencil"></i></a></h3>
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
                                <h3 class="card-title">Bank information</h3>
                                <ul class="personal-info">
                                    <li>
                                        <div class="title">Bank name</div>
                                        <div class="text">ICICI Bank</div>
                                    </li>
                                    <li>
                                        <div class="title">Bank account No.</div>
                                        <div class="text">159843014641</div>
                                    </li>
                                    <li>
                                        <div class="title">IFSC Code</div>
                                        <div class="text">ICI24504</div>
                                    </li>
                                    <li>
                                        <div class="title">PAN No</div>
                                        <div class="text">TC000Y56</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h3 class="card-title">Family Informations <a href="#" class="edit-icon"
                                        data-bs-toggle="modal" data-bs-target="#family_info_modal"><i
                                            class="fa fa-pencil"></i></a></h3>
                                <div class="table-responsive">
                                    <table class="table table-nowrap">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Relationship</th>
                                                <th>Date of Birth</th>
                                                <th>Phone</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Leo</td>
                                                <td>Brother</td>
                                                <td>Feb 16th, 2019</td>
                                                <td>9876543210</td>

                                            </tr>
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
                                        data-bs-target="#personal_info_modal">
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
                                        <div class="text">{{ $Rec->pre_dist ?? '-' }}</div>
                                    </li>
                                    <li>
                                        <div class="title">State <span style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->pre_state ?? '-' }}</div>
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
                                        data-bs-target="#personal_info_modal">
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
                                        <div class="text">{{ $Rec->perm_dist ?? '-' }}</div>
                                    </li>
                                    <li>
                                        <div class="title">State <span style="float: right">:</span></div>
                                        <div class="text">{{ $Rec->perm_state ?? '-' }}</div>
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
                                    data-bs-target="#personal_info_modal">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </h3>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td>S.No</td>
                                        <td>Course</td>
                                        <td>Specialization</td>
                                        <td>Board/University</td>
                                        <td>Passing Year</td>
                                        <td>Percentage/Grade</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>B.Tech</td>
                                        <td>Computer Science</td>
                                        <td>B.S.R. Engineering College</td>
                                        <td>2018</td>
                                        <td>85%</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>B.Tech</td>
                                        <td>Computer Science</td>
                                        <td>B.S.R. Engineering College</td>
                                        <td>2018</td>
                                        <td>85%</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>B.Tech</td>
                                        <td>Computer Science</td>
                                        <td>B.S.R. Engineering College</td>
                                        <td>2018</td>
                                        <td>85%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="cand_experience">

                <div class="col-md-12 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">Details of Work Experience
                                <a href="#" class="edit-icon" data-bs-toggle="modal"
                                    data-bs-target="#personal_info_modal">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </h3>
                            <p>
                                Total Work Experience : <span style="float: right">{{ $Rec->total_exp ?? '-' }}</span>
                            </p>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td>S.No</td>
                                            <td>Company Name</td>
                                            <td>Designation</td>
                                            <td>Gross Salary</td>
                                            <td>From</td>
                                            <td>To</td>
                                            <td>Reason for Leaving</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>B.S.R. Engineering College</td>
                                            <td>Assistant Professor</td>
                                            <td>Rs. 5,00,000</td>
                                            <td>2018</td>
                                            <td>2018</td>
                                            <td>Reason for Leaving</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>B.S.R. Engineering College</td>
                                            <td>Assistant Professor</td>
                                            <td>Rs. 5,00,000</td>
                                            <td>2018</td>
                                            <td>2018</td>
                                            <td>Reason for Leaving</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>B.S.R. Engineering College</td>
                                            <td>Assistant Professor</td>
                                            <td>Rs. 5,00,000</td>
                                            <td>2018</td>
                                            <td>2018</td>
                                            <td>Reason for Leaving</td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>B.S.R. Engineering College</td>
                                            <td>Assistant Professor</td>
                                            <td>Rs. 5,00,000</td>
                                            <td>2018</td>
                                            <td>2018</td>
                                            <td>Reason for Leaving</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h3 class="card-title">Current Employement Detail <a href="#" class="edit-icon"
                                        data-bs-toggle="modal" data-bs-target="#family_info_modal"><i
                                            class="fa fa-pencil"></i></a></h3>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="cand_reference">
                <div class="card">
                    <div class="card-body">
                        Reference
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="cand_other">
                <div class="card">
                    <div class="card-body">
                        Other
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

@endsection
@section('scriptsection')

@endsection
