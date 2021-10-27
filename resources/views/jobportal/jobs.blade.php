@php
use function App\Helpers\getDepartment;
use function App\Helpers\getEducationById;
use function App\Helpers\getSpecializationbyId;
use function App\Helpers\getDistrictName;
use function App\Helpers\getStateName;

$sql = DB::table('jobpost')
    ->Join('manpowerrequisition', 'manpowerrequisition.MRFId', '=', 'jobpost.MRFId')
    ->where('manpowerrequisition.CompanyId', 1)
    ->Where('jobpost.Status', 'Open')
    ->Where('jobpost.PostingView', 'Show')
    ->orderBy('JPId', 'desc')
    ->get();

@endphp
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="{{ URL::to('/') }}/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="{{ URL::to('/') }}/assets/css/app.css" rel="stylesheet">
    <title>Jobs at VNR</title>
</head>

<body>
    <!--wrapper-->
    <div class="wrapper">
        <header class="login-header shadow">
            <nav class="navbar navbar-expand-lg rounded fixed-top rounded-0 shadow-sm"
                style=" background-color: #f09a3e;">
                <div class="container-fluid">
                    <a class="navbar-brand" href="javascript:void(0);" style="height: 30px;">
                    </a>
                </div>
            </nav>
        </header>
        <div class="d-flex align-items-center justify-content-center my-5">
            <div class="container">
                <div class="row ">
                    <div class="col mx-auto">
                        <div class="card mt-3">
                            <div class="card-body">
                                <div class="border p-4 rounded">
                                    <div class="text-center">
                                        <h3 class="___class_+?13___"><img
                                                src="https://www.vnrseeds.com/wp-content/uploads/2018/12/vnr-logo-69x90.png">
                                        </h3>
                                        <h4 class="font-weight-bold" style="color: #f09a3e">Engage, Train & Retain</h4>
                                    </div>
                                    <div class="login-separater text-center mb-4"> <span
                                            style="font-size: 14px; color: #00823b;">At
                                            VNR, our most valuable assets are its people</span>
                                        <hr style="margin-top: -10px" />
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-12 text-center">
                                            <button id="bntSip" class="btn btn-warning btn-lg center-block"
                                                OnClick="btnSip_Click()">SIP/Internship</button>
                                            <button id="btnJob" class="btn btn-success btn-lg center-block"
                                                OnClick="btnJob_Click()">Job Opportunities</button>
                                        </div>
                                    </div>

                                    <div class="form-body d-none" id="sip_internship">
                                        <h5 style="font-size: 24px; color: #008000; font-weight: 700;letter-spacing: 0px;"
                                            class="font-weight-bold">Current Openings for SIP/Internship at VNR</h5>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" style="width: 100%" id="myTable">
                                                <thead>
                                                    <th>#</th>
                                                    <th>Type</th>
                                                    <th>Job Title</th>
                                                    <th>Department</th>
                                                    <th>Apply</th>
                                                </thead>
                                                <tbody>
                                                    @for ($i = 0; $i < count($sql); $i++)
                                                        <tr data-bs-toggle="collapse"
                                                            data-bs-target="#detail{{ $sql[$i]->JPId }}"
                                                            data-parent="#myTable" class="accordion-toggle"
                                                            style="cursor: pointer">
                                                            <td>{{ $i + 1 }}</td>
                                                            <td>{{ $sql[$i]->JobCode }}</td>
                                                            <td>{{ $sql[$i]->Title }}</td>
                                                            <td>{{ getDepartment($sql[$i]->DepartmentId) }}</td>
                                                            <td><a href="javascript:void(0);"
                                                                    style="color: #0008ff">View Details</a></td>
                                                        </tr>
                                                        <tr id="detail{{ $sql[$i]->JPId }}"
                                                            class="collapse accordion-collapse">
                                                            <td colspan="6" class="hiddenRow">
                                                                <div>
                                                                    <table
                                                                        class="table table-bordered table-striped table-sm">
                                                                        @php
                                                                            $res = DB::table('jobpost')
                                                                                ->Join('manpowerrequisition', 'manpowerrequisition.MRFId', '=', 'jobpost.MRFId')
                                                                                ->where('jobpost.Status', 'Open')
                                                                                ->where('jobpost.JPId', $sql[$i]->JPId)
                                                                                ->orderBy('JPId', 'desc')
                                                                                ->get();
                                                                        @endphp
                                                                        @foreach ($res as $item)
                                                                            <tr>
                                                                                <th style="width: 250px;">Department</th>
                                                                                <td></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Job Description</th>
                                                                                <td></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Required Qualification</th>
                                                                                <td></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Training Location</th>
                                                                                <td></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Training Duration</th>
                                                                                <td></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Stipend(in Rs. Per Month)</th>
                                                                                <td></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Other Benifits</th>
                                                                                <td></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Any Other Information</th>
                                                                                <td></td>
                                                                            </tr>

                                                                        @endforeach
                                                                    </table>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endfor
                                                </tbody>
                                            </table>
                                        </div>

                                        <p style="font-size: 15px;">Thanks for checking out our job openings. if you
                                            don't see any opportunities for SIP / Internship, please submit your resume
                                            & we'll get back to you if there are any suitable openings available that
                                            match your profile. <a href="javascript:void(0);"
                                                class="text-danger"><b>Submit your
                                                    resume</b></a></p>

                                    </div>
                                    <div class="form-body d-none" id="regular_job">
                                        <h5 style="font-size: 24px; color: #008000; font-weight: 700;letter-spacing: 0px;"
                                            class="font-weight-bold">Current Openings at VNR</h5>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" style="width: 100%" id="myTable">
                                                <thead>
                                                    <th>#</th>
                                                    <th>Job Code</th>
                                                    <th>Job Title</th>
                                                    <th>Department</th>
                                                    <th>Apply</th>
                                                </thead>
                                                <tbody>
                                                    @for ($i = 0; $i < count($sql); $i++)
                                                        <tr data-bs-toggle="collapse"
                                                            data-bs-target="#detail{{ $sql[$i]->JPId }}"
                                                            data-parent="#myTable" class="accordion-toggle"
                                                            style="cursor: pointer">
                                                            <td>{{ $i + 1 }}</td>
                                                            <td>{{ $sql[$i]->JobCode }}</td>
                                                            <td>{{ $sql[$i]->Title }}</td>
                                                            <td>{{ getDepartment($sql[$i]->DepartmentId) }}</td>
                                                            <td><a href="javascript:void(0);"
                                                                    style="color: #0008ff">View Details</a></td>
                                                        </tr>
                                                        <tr id="detail{{ $sql[$i]->JPId }}"
                                                            class="collapse accordion-collapse">
                                                            <td colspan="6" class="hiddenRow">
                                                                <div>
                                                                    <table
                                                                        class="table table-bordered table-striped table-sm">
                                                                        @php
                                                                            $res = DB::table('jobpost')
                                                                                ->Join('manpowerrequisition', 'manpowerrequisition.MRFId', '=', 'jobpost.MRFId')
                                                                                ->where('jobpost.Status', 'Open')
                                                                                ->where('jobpost.JPId', $sql[$i]->JPId)
                                                                                ->orderBy('JPId', 'desc')
                                                                                ->get();
                                                                        @endphp
                                                                        @foreach ($res as $item)
                                                                            <tr>
                                                                                <td colspan="2">{{ $item->Title }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="width:200px;">Job Code</td>
                                                                                <td>
                                                                                    {{ $item->JobCode }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Job Category</td>
                                                                                <td> {{ getDepartment($item->DepartmentId) }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Job Description</td>
                                                                                <td><?= $item->Description ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Desired Candidate Profile</td>
                                                                                <td>
                                                                                    @php
                                                                                        $data = unserialize($item->KeyPositionCriteria);
                                                                                    @endphp
                                                                                    <ul>
                                                                                        @foreach ($data as $item1)
                                                                                            <li>
                                                                                                {{ $item1 }}
                                                                                            </li>
                                                                                        @endforeach
                                                                                    </ul>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Education Qualification</td>
                                                                                <td>
                                                                                    @php
                                                                                        $data = unserialize($item->EducationId);
                                                                                    @endphp
                                                                                    <ul>
                                                                                        @foreach ($data as $item1)
                                                                                            <li>{{ getEducationById($item1['e']) }}
                                                                                                @if ($item1['s'] != 0)
                                                                                                    {{ ' - ' . getSpecializationbyId($item1['s']) }}
                                                                                                @endif
                                                                                            </li>
                                                                                        @endforeach
                                                                                    </ul>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Work Experience</td>
                                                                                <td><?= $item->WorkExp ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Job Location</td>
                                                                                @php
                                                                                    $loc = unserialize($item->LocationIds);
                                                                                @endphp
                                                                                <td>
                                                                                    @foreach ($loc as $item1)
                                                                                        @if ($item1['city'] != '' || $item1['city'] != 0)
                                                                                            {{ getDistrictName($item1['city']) . ' (' }}
                                                                                        @endif
                                                                                        @if ($item1['state'] != '')
                                                                                            {{ getStateName($item1['state']) }}
                                                                                        @endif
                                                                                        @if ($item1['city'] != '' || $item1['city'] != 0)
                                                                                            {{ ')' }}
                                                                                        @endif

                                                                                    @endforeach
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Salary Package</td>
                                                                                <td>Best as per industry standards</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="2" class="text-center">
                                                                                    <button type="button"
                                                                                        class="btn btn-sm btn-primary"
                                                                                        onclick="jobapply({{ $item->JPId }})">Apply
                                                                                        Now
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </table>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endfor
                                                </tbody>
                                            </table>
                                        </div>

                                        <p style="font-size: 15px;">Thanks for checking out our job openings. if you
                                            don't see any opportunities, please submit your resume & we'll get back to
                                            you if there any suitable openings that match your profile. <a
                                                href="javascript:void(0);" class="text-danger"><b>Submit your
                                                    resume</b></a></p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end row-->
            </div>
        </div>
        <footer class="bg-white shadow-sm border-top p-2 text-center fixed-bottom">
            <p class="mb-0">Copyright © VNR Seeds 2021. All right reserved.</p>
        </footer>
    </div>
    <!--end wrapper-->
    <!-- Bootstrap JS -->
    <script src="{{ URL::to('/') }}/assets/js/bootstrap.bundle.min.js"></script>
    <!--plugins-->
    <script src="{{ URL::to('/') }}/assets/js/jquery.min.js"></script>

</body>

</html>
<script>
    function jobapply(JPId) {
        var JPId = btoa(JPId);
        // window.location.href = "{{ route('job_apply') }}?jpid=" + JPId;
        //comment
        window.open("{{ route('job_apply') }}?jpid=" + JPId, '_blank')
    }

    function btnSip_Click() {
        $("#sip_internship").removeClass('d-none');
        $("#regular_job").addClass('d-none');
    }

    function btnJob_Click() {
        $("#sip_internship").addClass('d-none');
        $("#regular_job").removeClass('d-none');
    }
</script>
