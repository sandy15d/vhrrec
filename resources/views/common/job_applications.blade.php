@php
use function App\Helpers\getDesignation;
use function App\Helpers\getEducationById;
use function App\Helpers\getSpecializationbyId;
use function App\Helpers\getResumeSourceById;
use function App\Helpers\getStateName;
@endphp
@extends('layouts.master')
@section('title', 'Job Applications')
@section('PageContent')
    <style>
        .table>:not(caption)>*>* {
            padding: 2px 1px;
        }

    </style>
    <div class="page-content">
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
            <div class="col">
                <div class="card radius-10 bg-primary bg-gradient">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-white font-20">Total Applications:</p>
                            </div>
                            <div class="text-light ms-auto font-20">{{ $total_candidate }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 bg-info bg-gradient">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-white font-20">Total Scr. by HR:</p>
                            </div>
                            <div class="text-light ms-auto font-20">{{ $total_hr_scr }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 bg-warning bg-gradient">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-light font-20">Fwd. for Tech. Scr.:</p>

                            </div>
                            <div class="text-light ms-auto font-20">{{ $total_candidate }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 bg-success bg-gradient">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-white font-20">Total Available:</p>

                            </div>
                            <div class="text-light ms-auto font-20">{{ $total_available }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-9">
                <div class="card border-top border-0 border-4 border-primary mb-1">
                    <div class="card-body d-flex justify-content-between" style="padding: 5px;">
                        <span class="d-inline">
                            <span style="font-weight: bold;">↱</span>
                            <label class="text-primary"><input id="checkall" type="checkbox" name="">&nbsp;Check
                                all</label>
                            <i class="text-muted" style="font-size: 13px;">With selected:</i> 
                            <label class="text-primary " style=" cursor: pointer;" onclick="SendForScreening()"><i
                                    class="fas fa-share text-primary"></i> Fwd. for Technical
                                Screening
                            </label>
                        </span>
                        <span class="d-inline">
                            <label class="text-primary" style=" cursor: pointer;" onclick="MoveCandidate()"><i
                                    class="fas fa-shekel-sign text-primary"></i> Move to Other Co.
                            </label>
                        </span>
                    </div>
                </div>
                @foreach ($candidate_list as $row)
                    <div class="card mb-1">
                        <div class="card-body" style="padding: 5px;">
                            <div class="row  p-2 py-2">
                                <div style="width: 80%;float: left;">
                                    <table class="jatbl table borderless" style="margin-bottom: 0px !important;">
                                        <tbody>
                                            <tr>
                                                <td colspan="2">
                                                    <label style="margin-bottom: 12px;">
                                                        <input type="checkbox" name="selectCand" class="japchks"
                                                            onclick="checkAllorNot()" value="{{ $row->JCId }}">
                                                        <span
                                                            style="color: #275A72;font-weight: bold;padding-bottom: 10px;">
                                                            {{ $row->FName }} {{ $row->MName }} {{ $row->LName }} (
                                                            Ref.No:{{ $row->ReferenceNo }}) </span>
                                                    </label>
                                                </td>
                                                <td style="text-align: left" colspan="2"><b>Applied
                                                        For:</b>{{ getDesignation($row->DesigId) }}</td>
                                            </tr>

                                            <tr class="">
                                                <td>Experience<span class="pull-right">:</span></td>
                                                <td style="text-align: right">
                                                    <?= $row->Professional == 'F' ? 'Fresher' : 'Experienced' ?>
                                                    @php
                                                        if ($row->JobStartDate != null) {
                                                            $fdate = $row->JobStartDate;
                                                            if ($row->JobEndDate == null) {
                                                                $tdate = Carbon\Carbon::now();
                                                            } else {
                                                                $tdate = $row->JobEndDate;
                                                            }
                                                            $datetime1 = new DateTime($fdate);
                                                            $datetime2 = new DateTime($tdate);
                                                            $interval = $datetime1->diff($datetime2);
                                                            $days = $interval->format('%a');
                                                            echo $days;
                                                        }
                                                    @endphp



                                                </td>
                                                <td style="text-align: right">Contact No<span
                                                        class="pull-right">:</span></td>
                                                <td style="text-align:right"> {{ $row->Phone }}@if ($row->Verified == 'Y')
                                                        <i class="fadeIn animated bx bx-badge-check text-success"></i>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr class="">
                                                <td>Current Company<span class="pull-right">:</span></td>
                                                <td style="text-align: right">
                                                    <?= $row->PresentCompany == null ? '' : $row->PresentCompany ?></td>
                                                <td style="text-align: right">Email ID<span class="pull-right">:</span>
                                                </td>
                                                <td style="text-align: right">{{ $row->Email }} @if ($row->Verified == 'Y')
                                                        <i class="fadeIn animated bx bx-badge-check text-success"></i>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr class="">
                                                <td>Current Designation<span class="pull-right">:</span></td>
                                                <td style="text-align: right">
                                                    <?= $row->Designation == null ? '' : $row->Designation ?></td>
                                                <td style="text-align: right">Education<span class="pull-right">:</span>
                                                </td>
                                                <td style="text-align: right">
                                                    <?= $row->Education == null ? '' : getEducationById($row->Education) ?>
                                                    <?= $row->Specialization == null ? '' : '-' . getSpecializationbyId($row->Specialization) ?>

                                                </td>
                                            </tr>
                                            <tr class="">
                                                <td>Current Location<span class="pull-right">:</span></td>
                                                <td style="text-align: right">{{ $row->City }}</td>

                                            </tr>


                                            <tr>
                                                <td>Applied on date:</td>
                                                <td style="text-align: right">
                                                    {{ date('d-m-Y', strtotime($row->ApplyDate)) }}</td>
                                                <td style="text-align: right">HR Screening Status:</td>
                                                <td style="text-align: right">

                                                </td>

                                            </tr>
                                            <tr>
                                                <td> Source: </td>
                                                <td style="text-align: right">
                                                    {{ getResumeSourceById($row->ResumeSource) }}
                                                </td>
                                                <td class="text-danger" style="text-align: right">Blocklist Candidate
                                                </td>
                                            </tr>


                                        </tbody>
                                    </table>
                                </div>
                                <div class="" style=" width: 20%;float: left;">
                                    <center>
                                        @if ($row->CandidateImage == null)
                                            <img src="{{ URL::to('/') }}/assets/images/user.png"
                                                style="width: 130px; height: 130px;" class="img-fluid rounded-circle" />
                                        @else
                                            <img src="{{ URL::to('/') }}/uploads/Picture/{{ $row->CandidateImage }}"
                                                style="width: 130px; height: 130px;" class="img-fluid rounded-circle" />
                                        @endif


                                    </center>
                                    <center>
                                        <small>
                                            <span class="text-primary m-1 " style="cursor: pointer; font-size:14px;">
                                                View Details
                                            </span>
                                        </small>
                                    </center>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
                {{ $candidate_list->links('vendor.pagination.custom') }}
            </div>

            <div class="col-3">
                <div class="card border-top border-0 border-4 border-danger">
                    <div class="card-body">
                        <div class="col-12 mb-2 d-flex justify-content-between">
                            <span class="d-inline text-dark fw-bold">Filter</span>
                            <span class="text-danger fw-bold" style="font-size: 14px; cursor: pointer;" id="reset"><i
                                    class="bx bx-refresh"></i>Reset</span>
                        </div>
                        <div class="col-12 mb-2">
                            <select name="Fill_Company" id="Fill_Company" class="form-select form-select-sm">
                                <option value="">Select Company</option>
                                @foreach ($company_list as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            @if (isset($_REQUEST['Company']) && $_REQUEST['Company'] != '')
                                <script>
                                    $('#Fill_Company').val('<?= $_REQUEST['Company'] ?>');
                                </script>
                            @endif
                        </div>
                        <div class="col-12 mb-2">

                            <select name="Fill_Department" id="Fill_Department" class="form-select form-select-sm"
                                onchange="GetApplications();">
                                <option value="">Select Department</option>
                            </select>

                        </div>
                        <div class="col-12 mb-2">
                            <select name="Year" id="Year" class="form-select form-select-sm" onchange="GetApplications();">
                                <option value="">Select Year</option>
                                @for ($i = 2021; $i <= date('Y'); $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            @if (isset($_REQUEST['Year']) && $_REQUEST['Year'] != '')
                                <script>
                                    $('#Year').val('<?= $_REQUEST['Year'] ?>');
                                </script>
                            @endif
                        </div>
                        <div class="col-12 mb-2">
                            <select name="Month" id="Month" class="form-select form-select-sm"
                                onchange="GetApplications();">
                                <option value="">Select Month</option>
                                @foreach ($months as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            @if (isset($_REQUEST['Month']) && $_REQUEST['Month'] != '')
                                <script>
                                    $('#Month').val('<?= $_REQUEST['Month'] ?>');
                                </script>
                            @endif
                        </div>
                        <div class="col-12 mb-2">
                            <select name="Source" id="Source" class="form-select form-select-sm"
                                onchange="GetApplications();">
                                <option value="">Select Source</option>
                                @foreach ($source_list as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            @if (isset($_REQUEST['Source']) && $_REQUEST['Source'] != '')
                                <script>
                                    $('#Source').val('<?= $_REQUEST['Source'] ?>');
                                </script>
                            @endif
                        </div>
                        <div class="col-12 mb-2">
                            <select name="Gender" id="Gender" class="form-select form-select-sm"
                                onchange="GetApplications();">
                                <option value="">Select Gender</option>
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                                <option value="O">Others</option>
                            </select>
                            @if (isset($_REQUEST['Gender']) && $_REQUEST['Gender'] != '')
                                <script>
                                    $('#Gender').val('<?= $_REQUEST['Gender'] ?>');
                                </script>
                            @endif
                        </div>
                        <div class="col-12 mb-2">
                            <select name="Education" id="Education" class="form-select form-select-sm"
                                onchange="GetApplications();">
                                <option value="">Select Education</option>
                                @foreach ($education_list as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            @if (isset($_REQUEST['Education']) && $_REQUEST['Education'] != '')
                                <script>
                                    $('#Education').val('<?= $_REQUEST['Education'] ?>');
                                </script>
                            @endif
                        </div>
                        <div class="col-12 mb-2">
                            <input type="text" name="Name" id="Name" class="form-control form-control-sm"
                                placeholder="Search by Name" onkeyup="GetApplications();">
                        </div>
                        @if (isset($_REQUEST['Name']) && $_REQUEST['Name'] != '')
                            <script>
                                $('#Name').val('<?= $_REQUEST['Name'] ?>');
                            </script>
                        @endif
                    </div>
                </div>

            </div>

        </div>

    </div>
@endsection

@section('scriptsection')
    <script>
        $(document).ready(function() {
            GetDepartment();

            function GetDepartment() {
                var CompanyId = $('#Fill_Company').val();
                $.ajax({
                    type: "GET",
                    url: "{{ route('getDepartment') }}?CompanyId=" + CompanyId,
                    success: function(res) {
                        if (res) {
                            $("#Fill_Department").empty();
                            $("#Fill_Department").append(
                                '<option value="">Select Department</option>');
                            $.each(res, function(key, value) {
                                $("#Fill_Department").append('<option value="' + value + '">' +
                                    key +
                                    '</option>');
                            });
                            $('#Fill_Department').val('<?= $_REQUEST['Department'] ?? '' ?>');
                        } else {
                            $("#Fill_Department").empty();
                        }
                    }
                });
            }

            function GetApplications() {
                var Company = $('#Fill_Company').val() || '';
                var Department = $('#Fill_Department').val() || '';
                var Year = $('#Year').val() || '';
                var Month = $('#Month').val() || '';
                var Source = $('#Source').val() || '';
                var Gender = $('#Gender').val() || '';
                var Education = $('#Education').val() || '';
                var Name = $('#Name').val() || '';
                window.location.href = "{{ route('job_applications') }}?Company=" + Company + "&Department=" +
                    Department + "&Year=" + Year + "&Month=" + Month + "&Source=" + Source + "&Gender=" + Gender +
                    "&Education=" + Education + "&Name=" + Name;
            }

            $(document).on('change', '#Fill_Company', function() {
                GetApplications();
            });
            $(document).on('change', '#Fill_Department', function() {
                GetApplications();
            });
            $(document).on('change', '#Year', function() {
                GetApplications();
            });
            $(document).on('change', '#Month', function() {
                GetApplications();
            });
            $(document).on('change', '#Source', function() {
                GetApplications();
            });
            $(document).on('change', '#Gender', function() {
                GetApplications();
            });
            $(document).on('change', '#Education', function() {
                GetApplications();
            });
            $(document).on('blur', '#Name', function() {
                GetApplications();
            });

            $(document).on('click', '#reset', function() {
                window.location.href = "{{ route('job_applications') }}";
            });
        });
    </script>
@endsection
