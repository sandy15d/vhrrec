@php
use Illuminate\Support\Carbon;
$Year = Carbon::now()->year;
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>VNR On-boarding</title>

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://smarthr.dreamguystech.com/light/assets/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/b0b5b1cf9f.js" crossorigin="anonymous"></script>

    <link href="{{ URL::to('/') }}/assets/css/icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/mystyle1.css">
    <script src="{{ URL::to('/') }}/assets/js/jquery.min.js"></script>
    <style>
        .card {
            margin-bottom: 0px;
        }

        .col-form-label {
            /* text-align: end; */
        }
        .order-actions a{
            font-size: 18px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="main-wrapper">
        <div class="header">
            <div class="page-title-box">
                <h3>VNR On-boarding</h3>
            </div>
            <a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa fa-bars"></i></a>
            <ul class="nav user-menu">
                <li class="nav-item dropdown has-arrow main-drop">
                    <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">

                        <span>Admin</span>
                    </a>
                    <div class="dropdown-menu">

                        <a class="dropdown-item" href="login.html">Logout</a>
                    </div>
                </li>
            </ul>


            <div class="dropdown mobile-user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i
                        class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="login.html">Logout</a>
                </div>
            </div>

        </div>


        <div class="page-wrapper">
            <div class="content container-fluid">
                <div class="alert alert-primary alert-dismissible fade show d-none" role="alert">
                    <strong>Hi Sandeep Kumar Dewangan,</strong>Welcome to VNR, We are eagerly waiting to have you
                    onboarded. But before that, please
                    complete the onboarding process by furnishing below.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>
                <div class="card mb-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="profile-view">
                                    <div class="profile-basic">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                                                <div class="card dash-widget bg-primary">
                                                    <div class="card-body">

                                                        <div class="dash-widget-info">
                                                            <h4 class="text-light">Total Task: 4</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                                                <div class="card dash-widget">
                                                    <div class="card-body bg-warning">
                                                        <div class="dash-widget-info">
                                                            <h4>Pending Task: 4</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                                                <div class="card dash-widget bg-success">
                                                    <div class="card-body">
                                                        <div class="dash-widget-info">
                                                            <h4 class="text-light">Completed Task: 0</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

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
                                        class="nav-link active">Personal Info</a></li>

                                <li class="nav-item"><a href="#cand_contact" data-bs-toggle="tab"
                                        class="nav-link">Contact Details</a></li>

                                <li class="nav-item"><a href="#cand_education" data-bs-toggle="tab"
                                        class="nav-link">Education Details</a></li>

                                <li class="nav-item"><a href="#cand_experience" data-bs-toggle="tab"
                                        class="nav-link">Work Experience</a></li>

                                <li class="nav-item"><a href="#cand_other" data-bs-toggle="tab"
                                        class="nav-link">Other Info</a></li>

                                <li class="nav-item"><a href="#cand_doc" data-bs-toggle="tab"
                                        class="nav-link">Documents Upload</a></li>

                                <li class="nav-item"><a href="#final" data-bs-toggle="tab"
                                        class="nav-link">Final Step</a></li>


                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-content">
                    <div id="cand_profile" class=" tab-pane fade pro-overview show active">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">Personal Information</h4>
                                    </div>
                                    <div class="card-body">
                                        <form action="#">
                                            <div class="row">
                                                <div class="col-md-8 col-sm-12">
                                                    <div class="form-group row">
                                                        <label class="col-form-label col-md-2">Title</label>
                                                        <div class="col-md-10">
                                                            <label><input type="radio" name="Title" value="Mr."
                                                                    class="reqinp" checked>
                                                                Mr.</label>&emsp;
                                                            <label><input type="radio" name="Title" value="Ms.">
                                                                Ms.</label>&emsp;
                                                            <label><input type="radio" name="Title" value="Mrs.">
                                                                Mrs.</label>&emsp;
                                                            <label><input type="radio" name="Title" value="Dr.">
                                                                Dr.</label>

                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-form-label col-md-2">First Name</label>
                                                        <div class="col-md-10 col-sm-12">
                                                            <input type="text" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-form-label col-md-2">Middle Name</label>
                                                        <div class="col-md-10">
                                                            <input type="text" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-form-label col-md-2">Last Name</label>
                                                        <div class="col-md-10">
                                                            <input type="text" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-form-label col-md-2">Date of Birth</label>
                                                        <div class="col-md-10">
                                                            <input type="date" class="form-control form-control-sm">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="" class="col-form-label col-md-2">Gender</label>
                                                        <div class="col-md-10">
                                                            <select name="Gender" id="Gender"
                                                                class="form-select form-select-sm reqinp">
                                                                <option value="">Select</option>
                                                                <option value="M">Male</option>
                                                                <option value="F">Female</option>
                                                                <option value="O">Other</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-form-label col-md-2">Nationality</label>
                                                        <div class="col-md-10">
                                                            <input type="text" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-form-label col-md-2">Religion</label>
                                                        <div class="col-md-10">
                                                            <input type="text" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-form-label col-md-2">Caste</label>
                                                        <div class="col-md-10">
                                                            <input type="text" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-form-label col-md-2">Marital Status</label>
                                                        <div class="col-md-10">
                                                            <input type="text" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-form-label col-md-2">Marriage Anniversary
                                                            Date</label>
                                                        <div class="col-md-10">
                                                            <input type="text" class="form-control form-control-sm">
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-12">
                                                    <div style="border: 1px solid #195999;vertical-align:top"
                                                        class=" mt-3 d-inline-block" style="width: 150; height: 150;">
                                                        <span id="preview">
                                                            <center>
                                                                <img src="{{ URL::to('/') }}/assets/images/user.png"
                                                                    style="width: 150px; height: 150px;" id="img1"
                                                                    name="img1" class="img1" />
                                                            </center>
                                                        </span>
                                                        <center>
                                                            <label>
                                                                <input type="file" name="CandidateImage"
                                                                    id="CandidateImage" class="btn btn-sm mb-1 "
                                                                    style="width: 100px;display: none;"
                                                                    accept="image/png, image/gif, image/jpeg"><span
                                                                    class="btn btn-sm btn-light shadow-sm text-primary">Upload
                                                                    Photo</span>
                                                            </label>
                                                        </center>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="submit-section">
                                                <button class="btn btn-primary submit-btn">Save Personal Info</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div id="cand_contact" class="tab-pane fade pro-overview show ">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">Contact Details</h4>
                                    </div>
                                    <div class="card-body">
                                        <form action="#">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="form-group row">
                                                        <label class="col-form-label col-md-1">Email 1:</label>
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control form-control-sm">
                                                        </div>
                                                        <label class="col-form-label col-md-1">Email 2:</label>
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control form-control-sm">
                                                        </div>
                                                        <label class="col-form-label col-md-1">Contact 1:</label>
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control form-control-sm">
                                                        </div>
                                                        <label class="col-form-label col-md-1">Contact 2:</label>
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <p class="fw-bold">Present Address</p>
                                                        <div class="form-group row">
                                                            <label class="col-form-label col-md-1">Line 1</label>
                                                            <div class="col-md-2">
                                                                <input type="text"
                                                                    class="form-control form-control-sm">
                                                            </div>
                                                            <label class="col-form-label col-md-1">Line 2</label>
                                                            <div class="col-md-2">
                                                                <input type="text"
                                                                    class="form-control form-control-sm">
                                                            </div>
                                                            <label class="col-form-label col-md-1">Line 3</label>
                                                            <div class="col-md-2">
                                                                <input type="text"
                                                                    class="form-control form-control-sm">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-form-label col-md-1">State</label>
                                                            <div class="col-md-2">
                                                                <select name="PreState" id="PreState"
                                                                    class="form-select form-select-sm"></select>
                                                            </div>
                                                            <label class="col-form-label col-md-1">District</label>
                                                            <div class="col-md-2">
                                                                <select name="PreDist" id="PreDist"
                                                                    class="form-select form-select-sm"></select>
                                                            </div>
                                                            <label class="col-form-label col-md-1">City</label>
                                                            <div class="col-md-2">
                                                                <input type="text" name="PreCity" id="PreCity"
                                                                    class="form-control form-control-sm">
                                                            </div>
                                                            <label class="col-form-label col-md-1"
                                                                style="float: right">Pin Code</label>
                                                            <div class="col-md-2">
                                                                <input type="text" name="PrePin" id="PrePin"
                                                                    class="form-control form-control-sm">
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <p><input type="checkbox" name="AddChk" id="AddChk"> Tick if your
                                                        Present address and Permanent address are the same</p>
                                                    <div class="col-md-12">
                                                        <p class="fw-bold">Permanent Address</p>
                                                        <div class="form-group row">
                                                            <label class="col-form-label col-md-1">Line 1</label>
                                                            <div class="col-md-2">
                                                                <input type="text"
                                                                    class="form-control form-control-sm">
                                                            </div>
                                                            <label class="col-form-label col-md-1">Line 2</label>
                                                            <div class="col-md-2">
                                                                <input type="text"
                                                                    class="form-control form-control-sm">
                                                            </div>
                                                            <label class="col-form-label col-md-1">Line 3</label>
                                                            <div class="col-md-2">
                                                                <input type="text"
                                                                    class="form-control form-control-sm">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-form-label col-md-1">State</label>
                                                            <div class="col-md-2">
                                                                <select name="PermState" id="PermState"
                                                                    class="form-select form-select-sm"></select>
                                                            </div>
                                                            <label class="col-form-label col-md-1">District</label>
                                                            <div class="col-md-2">
                                                                <select name="PermDist" id="PermDist"
                                                                    class="form-select form-select-sm"></select>
                                                            </div>
                                                            <label class="col-form-label col-md-1">City</label>
                                                            <div class="col-md-2">
                                                                <input type="text" name="PermCity" id="PermCity"
                                                                    class="form-control form-control-sm">
                                                            </div>
                                                            <label class="col-form-label col-md-1"
                                                                style="float: right">Pin Code</label>
                                                            <div class="col-md-2">
                                                                <input type="text" name="PermPin" id="PermPin"
                                                                    class="form-control form-control-sm">
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="submit-section">
                                                <button class="btn btn-primary submit-btn">Save Contact
                                                    Details</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div id="cand_education" class="tab-pane fade pro-overview show ">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">Educational Details</h4>
                                    </div>
                                    <div class="card-body">
                                        <form id="EducationInfoForm" action="{{ route('Candidate_Education_Save') }}"
                                            method="POST">
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
                                                                <input type="text" name="Qualification[]"
                                                                    id="Qualification1"
                                                                    class="form-control form-control-sm"
                                                                    value="Below 10th" readonly>
                                                            </td>
                                                            <td>
                                                                <select name="Course[]" id="Course1"
                                                                    class="form-select form-select-sm"
                                                                    onchange="getSpecialization(this.value,1)">
                                                                    <option value="">Select</option>
                                                                    @foreach ($education_list as $key => $value)
                                                                        <option value="{{ $key }}">
                                                                            {{ $value }}</option>
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
                                                                            {{ $value }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="Collage[]" id="Collage1"
                                                                    class="form-select form-select-sm">
                                                                    <option value="">Select</option>
                                                                    @foreach ($institute_list as $key => $value)
                                                                        <option value="{{ $key }}">
                                                                            {{ $value }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="PassingYear[]" id="PassingYear1"
                                                                    class="form-select form-select-sm">
                                                                    <option value="">Select</option>
                                                                    @for ($i = 1980; $i <= $Year; $i++)
                                                                        <option value="{{ $i }}">
                                                                            {{ $i }}</option>
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
                                                                <input type="text" name="Qualification[]"
                                                                    id="Qualification2"
                                                                    class="form-control form-control-sm" value="10th"
                                                                    readonly>
                                                            </td>
                                                            <td>
                                                                <select name="Course[]" id="Course2"
                                                                    class="form-select form-select-sm"
                                                                    onchange="getSpecialization(this.value,2)">
                                                                    <option value="">Select</option>
                                                                    @foreach ($education_list as $key => $value)
                                                                        <option value="{{ $key }}">
                                                                            {{ $value }}</option>
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
                                                                            {{ $value }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="Collage[]" id="Collage2"
                                                                    class="form-select form-select-sm">
                                                                    <option value="">Select</option>
                                                                    @foreach ($institute_list as $key => $value)
                                                                        <option value="{{ $key }}">
                                                                            {{ $value }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="PassingYear[]" id="PassingYear2"
                                                                    class="form-select form-select-sm">
                                                                    <option value="">Select</option>
                                                                    @for ($i = 1980; $i <= $Year; $i++)
                                                                        <option value="{{ $i }}">
                                                                            {{ $i }}</option>
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
                                                                <input type="text" name="Qualification[]"
                                                                    id="Qualification3"
                                                                    class="form-control form-control-sm" value="12th"
                                                                    readonly>
                                                            </td>
                                                            <td>
                                                                <select name="Course[]" id="Course3"
                                                                    class="form-select form-select-sm"
                                                                    onchange="getSpecialization(this.value,3)">
                                                                    <option value="">Select</option>
                                                                    @foreach ($education_list as $key => $value)
                                                                        <option value="{{ $key }}">
                                                                            {{ $value }}</option>
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
                                                                            {{ $value }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="Collage[]" id="Collage3"
                                                                    class="form-select form-select-sm">
                                                                    <option value="">Select</option>
                                                                    @foreach ($institute_list as $key => $value)
                                                                        <option value="{{ $key }}">
                                                                            {{ $value }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="PassingYear[]" id="PassingYear3"
                                                                    class="form-select form-select-sm">
                                                                    <option value="">Select</option>
                                                                    @for ($i = 1980; $i <= $Year; $i++)
                                                                        <option value="{{ $i }}">
                                                                            {{ $i }}</option>
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
                                                                <input type="text" name="Qualification[]"
                                                                    id="Qualification4"
                                                                    class="form-control form-control-sm"
                                                                    value="Graduation" readonly>
                                                            </td>
                                                            <td>
                                                                <select name="Course[]" id="Course4"
                                                                    class="form-select form-select-sm"
                                                                    onchange="getSpecialization(this.value,4)">
                                                                    <option value="">Select</option>
                                                                    @foreach ($education_list as $key => $value)
                                                                        <option value="{{ $key }}">
                                                                            {{ $value }}</option>
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
                                                                            {{ $value }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="Collage[]" id="Collage4"
                                                                    class="form-select form-select-sm">
                                                                    <option value="">Select</option>
                                                                    @foreach ($institute_list as $key => $value)
                                                                        <option value="{{ $key }}">
                                                                            {{ $value }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="PassingYear[]" id="PassingYear4"
                                                                    class="form-select form-select-sm">
                                                                    <option value="">Select</option>
                                                                    @for ($i = 1980; $i <= $Year; $i++)
                                                                        <option value="{{ $i }}">
                                                                            {{ $i }}</option>
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
                                                                <input type="text" name="Qualification[]"
                                                                    id="Qualification5"
                                                                    class="form-control form-control-sm"
                                                                    value="Post_Graduation" readonly>
                                                            </td>
                                                            <td>
                                                                <select name="Course[]" id="Course5"
                                                                    class="form-select form-select-sm"
                                                                    onchange="getSpecialization(this.value,5)">
                                                                    <option value="">Select</option>
                                                                    @foreach ($education_list as $key => $value)
                                                                        <option value="{{ $key }}">
                                                                            {{ $value }}</option>
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
                                                                            {{ $value }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="Collage[]" id="Collage5"
                                                                    class="form-select form-select-sm">
                                                                    <option value="">Select</option>
                                                                    @foreach ($institute_list as $key => $value)
                                                                        <option value="{{ $key }}">
                                                                            {{ $value }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="PassingYear[]" id="PassingYear5"
                                                                    class="form-select form-select-sm">
                                                                    <option value="">Select</option>
                                                                    @for ($i = 1980; $i <= $Year; $i++)
                                                                        <option value="{{ $i }}">
                                                                            {{ $i }}</option>
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
                                                                <input type="text" name="Qualification[]"
                                                                    id="Qualification6"
                                                                    class="form-control form-control-sm"
                                                                    value="Doctorate" readonly>
                                                            </td>
                                                            <td>
                                                                <select name="Course[]" id="Course6"
                                                                    class="form-select form-select-sm"
                                                                    onchange="getSpecialization(this.value,6)">
                                                                    <option value="">Select</option>
                                                                    @foreach ($education_list as $key => $value)
                                                                        <option value="{{ $key }}">
                                                                            {{ $value }}</option>
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
                                                                            {{ $value }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="Collage[]" id="Collage6"
                                                                    class="form-select form-select-sm">
                                                                    <option value="">Select</option>
                                                                    @foreach ($institute_list as $key => $value)
                                                                        <option value="{{ $key }}">
                                                                            {{ $value }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="PassingYear[]" id="PassingYear6"
                                                                    class="form-select form-select-sm">
                                                                    <option value="">Select</option>
                                                                    @for ($i = 1980; $i <= $Year; $i++)
                                                                        <option value="{{ $i }}">
                                                                            {{ $i }}</option>
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

                                            <input type="button" value="Add Qualification" id="addEducation"
                                                class="btn btn-primary btn-sm">
                                            <div class="submit-section">
                                                <button class="btn btn-primary submit-btn">Save Educational
                                                    Details</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="tab-pane fade pro-overview show " id="cand_experience">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">Work Experience</h4>
                                    </div>
                                    <div class="card-body">
                                        <form action="#">
                                            <div style="text-align: center">
                                                <p>Are you a working Professional or Fresher?</p>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="ProfCheck"
                                                        id="Professional" value="P">
                                                    <label class="form-check-label" for="Professional">I am a Working
                                                        professional</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="ProfCheck"
                                                        id="Fresher" value="F">
                                                    <label class="form-check-label" for="Fresher"> I am a
                                                        Fresher</label>
                                                </div>
                                            </div>
                                            <p class="fw-bold mt-3">Previous Employement Records (Except the present)
                                            </p>
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
                                                                <input type="text" name="WorkExpCompany[]"
                                                                    id="WorkExpCompany1"
                                                                    class="form-control form-control-sm">
                                                            </td>
                                                            <td>
                                                                <input type="text" name="WorkExpDesignation[]"
                                                                    id="WorkExpDesignation1"
                                                                    class="form-control form-control-sm">
                                                            </td>
                                                            <td>
                                                                <input type="text" name="WorkExpGrossMonthlySalary[]"
                                                                    id="WorkExpGrossMonthlySalary1"
                                                                    class="form-control form-control-sm">
                                                            </td>
                                                            <td>
                                                                <input type="text" name="WorkExpAnualCTC[]"
                                                                    id="WorkExpAnualCTC1"
                                                                    class="form-control form-control-sm">
                                                            </td>
                                                            <td>
                                                                <input type="date" name="WorkExpJobStartDate[]"
                                                                    id="WorkExpJobStartDate1"
                                                                    class="form-control form-control-sm datepicker">
                                                            </td>
                                                            <td>
                                                                <input type="date" name="WorkExpJobEndDate[]"
                                                                    id="WorkExpJobEndDate1"
                                                                    class="form-control form-control-sm datepicker">
                                                            </td>
                                                            <td>
                                                                <input type="text" name="WorkExpReasonForLeaving[]"
                                                                    id="WorkExpReasonForLeaving1"
                                                                    class="form-control form-control-sm">
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <input type="button" value="Add Experience" id="addExperience"
                                                class="btn btn-primary btn-sm">

                                            <p class="fw-bold mt-3">Training & Practical Experience (Other than
                                                regular jobs)</p>
                                            <div class="table-responsive mt-3">
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
                                                                <input type="text" name="TrainingNature[]"
                                                                    id="TrainingNature1"
                                                                    class="form-control form-control-sm">
                                                            </td>
                                                            <td>
                                                                <input type="text" name="TrainingOrganization[]"
                                                                    id="TrainingOrganization1"
                                                                    class="form-control form-control-sm">
                                                            </td>
                                                            <td>
                                                                <input type="date" name="TrainingFromDate[]"
                                                                    id="TrainingFromDate1"
                                                                    class="form-control form-control-sm datepicker">
                                                            </td>
                                                            <td>
                                                                <input type="date" name="TrainingToDate[]"
                                                                    id="TrainingToDate1"
                                                                    class="form-control form-control-sm datepicker">
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <input type="button" value="Add Training" id="addTraining"
                                                class="btn btn-primary btn-sm">


                                            <div class="submit-section">
                                                <button class="btn btn-primary submit-btn">Save </button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://smarthr.dreamguystech.com/light/assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://smarthr.dreamguystech.com/light/assets/js/jquery.slimscroll.min.js"></script>
    <script src="https://smarthr.dreamguystech.com/light/assets/js/app.js"></script>
    <script>
        var MemberCount = 1;
        var EducationCount = 6;
        var WorkExpCount = 1;
        var TrainingCount = 1;
        var RefCount = 1;
        var VRefCount = 1;
        var EducationList = '';
        var SpecializationList = '';
        var CollegeList = '';
        var YearList = '';
       




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
        } //Qualification


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
    </script>
</body>

</html>
