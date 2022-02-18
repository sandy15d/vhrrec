@php
use function App\Helpers\getDesignation;
use function App\Helpers\getEducationCodeById;
use function App\Helpers\getSpecializationbyId;
use function App\Helpers\getResumeSourceById;
use function App\Helpers\getStateName;
$country_list = DB::table('master_country')->pluck('CountryName', 'CountryId');
@endphp
@extends('layouts.master')
@section('title', 'Job Applications')
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

        #applications {
            height: 1000px;
            overflow-y: scroll;
        }

        #applications::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for IE, Edge and Firefox */
        #applications {
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
        }

    </style>
    <div class="page-content">
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
            <div class="col">
                <div class="card radius-10 ">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0">Total Applications:</p>
                            </div>
                            <div class="ms-auto font-20">{{ $total_candidate }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <hp class="mb-0">Total Screening by HR:</hp>
                            </div>
                            <div class="ms-auto font-20">{{ $total_hr_scr }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0">Fwd. for Tech. Screening:</p>

                            </div>
                            <div class="ms-auto font-20">{{ $total_fwd }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0">Total Available:</p>

                            </div>
                            <div class="ms-auto font-20">{{ $total_available }}
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
                            <label class="text-primary " style=" cursor: pointer;" data-bs-toggle="modal"
                                data-bs-target="#TechScreeningModal"><i class="fas fa-share text-primary"></i> Fwd. for
                                Technical
                                Screening
                            </label>
                        </span>
                        <span style="float: right"><button type="button" class="btn btn-primary btn-sm"
                                data-bs-toggle="modal" data-bs-target="#application_form_modal"><i
                                    class="bx bx-user mr-1"></i>New Application</button></span>
                    </div>
                </div>
                <div id="applications">
                    @foreach ($candidate_list as $row)
                        @php
                            $bg_color = '';
                            if ($row->Status == 'Rejected' || $row->BlackList == 1) {
                                $bg_color = '#fe36501f';
                            } else {
                                if ($row->FwdTechScr == 'Yes') {
                                    $bg_color = '#dbffdacc';
                                }
                            }
                        @endphp
                        <div class="card mb-3" style="background-color:<?= $bg_color ?>">
                            <div class="card-body" style="padding: 5px;">
                                <div class="row  p-2 py-2">
                                    <div style="width: 80%;float: left;">
                                        <table class="jatbl table borderless" style="margin-bottom: 0px !important;">
                                            <tbody>
                                                <tr>
                                                    <td colspan="3">
                                                        <label>
                                                            @if ($row->Status == 'Selected' && $row->FwdTechScr == 'No' && $row->BlackList == 0)
                                                                <input type="checkbox" name="selectCand"
                                                                    class="japchks" onclick="checkAllorNot()"
                                                                    value="{{ $row->JAId }}">
                                                            @endif
                                                            <span
                                                                style="color: #275A72;font-weight: bold;padding-bottom: 10px;">
                                                                {{ $row->FName }} {{ $row->MName }} {{ $row->LName }}
                                                                (Ref.No {{ $row->ReferenceNo }} ) </span>
                                                        </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: left">Applied For<span
                                                            class="text-right fw-bold">:</span></td>
                                                    <td colspan="3" style="text-align: left" class="text-primary">
                                                        <?= $row->DesigId != null ? getDesignation($row->DesigId) : "<i class='fa fa-pencil-square-o text-primary' aria-hidden='true' style='cursor: pointer;' id='AddToJobPost' data-id='$row->JAId'></i>" ?>
                                                    </td>
                                                </tr>
                                                <tr class="">
                                                    <td>Experience<span class="pull-right" style="width: 25%">:</span>
                                                    </td>
                                                    <td style="text-align: left">
                                                        @php
                                                            if ($row->Professional == 'F') {
                                                                echo 'Fresher';
                                                            } else {
                                                                if ($row->JobStartDate != null) {
                                                                    $fdate = $row->JobStartDate;
                                                                    if ($row->JobEndDate == null) {
                                                                        $tdate = Carbon\Carbon::now();
                                                                    } else {
                                                                        $tdate = $row->JobEndDate;
                                                                    }
                                                            
                                                                    echo Carbon\Carbon::createFromDate($fdate)
                                                                        ->diff($tdate)
                                                                        ->format('%y Years %m Months');
                                                                } else {
                                                                    echo 'Experienced';
                                                                }
                                                            }
                                                        @endphp
                                                    </td>
                                                    <td style="text-align: left;">Contact No:</td>
                                                    <td style="text-align:left"> {{ $row->Phone }}@if ($row->Verified == 'Y')
                                                            <i class="fadeIn animated bx bx-badge-check text-success"></i>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr class="">
                                                    <td>Cur. Company<span class="pull-right">:</span></td>
                                                    <td style="text-align: left">
                                                        <?= $row->PresentCompany == null ? '' : $row->PresentCompany ?></td>
                                                    <td style="text-align: left">Email ID<span
                                                            class="pull-right">:</span>
                                                    </td>
                                                    <td style="text-align: left">{{ $row->Email }} @if ($row->Verified == 'Y')
                                                            <i class="fadeIn animated bx bx-badge-check text-success"></i>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr class="">
                                                    <td>Cur. Designation<span class="pull-right">:</span></td>
                                                    <td style="text-align: left">
                                                        <?= $row->Designation == null ? '' : $row->Designation ?></td>
                                                    <td style="text-align: left">Education<span
                                                            class="pull-right">:</span>
                                                    </td>
                                                    <td style="text-align: left">
                                                        <?= $row->Education == null ? '' : getEducationCodeById($row->Education) ?>
                                                        <?= $row->Specialization == null ? '' : '-' . getSpecializationbyId($row->Specialization) ?>
                                                    </td>
                                                </tr>
                                                <tr class="">
                                                    <td>Cur. Location<span class="pull-right">:</span></td>
                                                    <td style="text-align: left">{{ $row->City }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Apply Date:</td>
                                                    <td style="text-align: left">
                                                        {{ date('d-m-Y', strtotime($row->ApplyDate)) }}</td>
                                                    <td style="text-align: left">HR Screening:</td>
                                                    <td style="text-align: left">
                                                        @if ($row->JPId != 0)
                                                            <?= $row->Status != null ? '<b>' . $row->Status . '</b>' : "<i class='fa fa-pencil-square-o text-primary' aria-hidden='true' style='font-size:14px;cursor: pointer;' id='HrScreening' data-id='$row->JAId'></i>" ?>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td> Source: </td>
                                                    <td style="text-align: left">
                                                        {{ getResumeSourceById($row->ResumeSource) }}
                                                    </td>

                                                    <td class="text-danger fw-bold" style="text-align: center" colspan="2">
                                                        @if ($row->BlackList == 0)
                                                            <label class="text-danger" style=" cursor: pointer;"
                                                                id="BlackListCandidate" data-id="{{ $row->JCId }}"><i
                                                                    class="fas fa-ban text-danger"></i>
                                                                Blacklist Candidate
                                                            </label>
                                                        @else
                                                            @if (Auth::user()->role == 'A')
                                                                <label class="text-primary" style=" cursor: pointer;"
                                                                    id="UnBlockCandidate" data-id="{{ $row->JCId }}"><i
                                                                        class="fas fa-user text-primary"></i>
                                                                    Unblock Candidate
                                                                </label>
                                                            @endif
                                                        @endif

                                                    </td>
                                                </tr>
                                                @if ($row->BlackListRemark != null)
                                                    <tr>
                                                        <td colspan="4" class="text-danger fw-bold">
                                                            {{ $row->BlackListRemark }}
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($row->UnBlockRemark != null)
                                                    <tr>
                                                        <td colspan="4" class="text-success fw-bold">
                                                            {{ $row->UnBlockRemark }}
                                                        </td>
                                                    </tr>
                                                @endif

                                                @if ($row->Type == 'Manual Entry')
                                                    @php
                                                        $JCId = base64_encode($row->JCId);
                                                    @endphp
                                                    <tr>
                                                        <td>Link</td>
                                                        <td colspan="3"><input type="text" id="link{{ $row->JCId }}"
                                                                value="{{ url('jobportal/jobapply?jcid=' . $JCId . '') }}">
                                                            <button onclick="copylink({{ $row->JCId }})"
                                                                class="btn btn-xs btn-primary"> Copy</button>
                                                        </td>
                                                    </tr>
                                                @endif

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="" style=" width: 20%;float: left;">
                                        <center>
                                            @if ($row->CandidateImage == null)
                                                <img src="{{ URL::to('/') }}/assets/images/user1.png"
                                                    style="width: 100px; height: 100px;" class="img-fluid rounded" />
                                            @else
                                            <a href="#" class="pop">
                                                <img src="{{ URL::to('/') }}/uploads/Picture/{{ $row->CandidateImage }}"
                                                    style="width: 100px; height: 100px;" class="img-fluid rounded" />
                                            </a>
                                            @endif
                                        </center>
                                        <center>
                                            <small>
                                                <span class="text-primary m-1 " style="cursor: pointer; font-size:14px;">
                                                    @php
                                                        $sendingId = base64_encode($row->JAId);
                                                    @endphp
                                                    <a href="{{ route('candidate_detail') }}?jaid={{ $sendingId }}"
                                                        target="_blank">View Details</a>
                                                </span>
                                            </small>
                                        </center>

                                        <center class="mt-3 fw-bold">
                                            <span class="d-inline">
                                                <label class="text-success" style=" cursor: pointer;" id="MoveCandidate"
                                                    data-id="{{ $row->JAId }}"><i
                                                        class="fas fa-shekel-sign text-success"></i>
                                                    Move to Other Co.
                                                </label>
                                            </span>
                                        </center>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

                {{ $candidate_list->appends([])->links('vendor.pagination.custom') }}
            </div>

            <div class="col-3">
                <div class="card border-top border-0 border-4 border-danger">
                    <div class="card-body">
                        <div class="col-12 mb-2 d-flex justify-content-between">
                            <span class="d-inline fw-bold">Filter</span>
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
                            <select name="Fill_Gender" id="Fill_Gender" class="form-select form-select-sm"
                                onchange="GetApplications();">
                                <option value="">Select Gender</option>
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                                <option value="O">Others</option>
                            </select>
                            @if (isset($_REQUEST['Gender']) && $_REQUEST['Gender'] != '')
                                <script>
                                    $('#Fill_Gender').val('<?= $_REQUEST['Gender'] ?>');
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

    <div class="modal fade" id="HrScreeningModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog">
            <form action="{{ route('update_hrscreening') }}" method="POST" id="ScreeningForm">
                <div class="modal-content">
                    <div class="modal-body">
                        <input type="hidden" name="JAId" id="JAId">
                        <label for="Status">HR Screening Status</label>
                        <select name="Status" id="Status" class="form-select form-select-sm" required>
                            <option value="" disabled selected></option>
                            <option value="Selected">Selected</option>
                            <option value="Rejected">Rejected</option>
                        </select>

                        <textarea name="RejectRemark" id="RejectRemark" cols="30" rows="3"
                            class="form-control form-control-sm mt-2 d-none"
                            placeholder="Please Enter Rejection Remark"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="AddJobPostModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog">
            <form action="{{ route('MapCandidateToJob') }}" method="POST" id="MapCandidateForm">
                <div class="modal-content">
                    <div class="modal-body">
                        <input type="hidden" name="AddJobPost_JAId" id="AddJobPost_JAId">
                        <label for="Status">Map Candidate to Job</label>
                        <select name="JPId" id="JPId" class="form-select form-select-sm">
                            <option value="">Select</option>
                            @foreach ($jobpost_list as $item)
                                <option value="{{ $item->JPId }}">{{ $item->JobCode }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="MoveCandidategModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <form action="{{ route('MoveCandidate') }}" method="POST" id="MoveCandidateForm">
                <div class="modal-content">
                    <div class="modal-body">
                        <label for="Status">Move Candidate To:</label>
                        <input type="hidden" name="MoveCandidate_JAId" id="MoveCandidate_JAId">
                        <select name="MoveCompany" id="MoveCompany" class="form-select form-select-sm">
                            <option value="" disabled selected></option>
                            @foreach ($company_list as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>

                        <label for="MoveDepartment">Department</label>
                        <select name="MoveDepartment" id="MoveDepartment" class="form-select form-select-sm">

                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="TechScreeningModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tr>
                            <td style="vertical-align: middle;">Resume Sent For Technical Screen</td>
                            <td><input type="date" id="ResumeSent" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: middle;">Technical Screening By</td>
                            <td>
                                <select id="TechScrCompany" class="form-select form-select-sm mb-1">
                                    <option value="">Select Company</option>
                                    @foreach ($company_list as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>

                                <select id="TechScrDepartment" class="form-select form-select-sm mb-1">
                                    <option value="">Select Department</option>
                                </select>
                                <select id="ScreeningBy" class="form-select form-select-sm">
                                    <option value="">Select Employee</option>
                                </select>
                            </td>
                        </tr>
                    </table>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="SendForTechSceenBtn" class="btn btn-primary btn-sm">Save
                            changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="application_form_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info bg-gradient">
                    <h5 class="modal-title text-white">Job Application Form (Manual Entry)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="job_application_manual" method="POST" id="jobapplicationform">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-9 col-sm-12 table-responsive">
                                <table class=" table borderless d-inline-block">
                                    <tr>
                                        <td valign="middle">Source of Resume<font color="#FF0000">*
                                            </font>
                                        </td>
                                        <td>
                                            <select name="ResumeSource" id="ResumeSource"
                                                class="form-select form-select-sm reqinp"
                                                onchange="checkResumeSource(this.value);">
                                                <option value="">Select</option>
                                                @foreach ($resume_list as $key => $value)
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr id="othersource_tr" class="d-none">
                                        <td></td>
                                        <td>
                                            <textarea name="OtherResumeSource" id="OtherResumeSource" cols="30" rows="3"
                                                class="form-control form-control-sm"
                                                placeholder="Please provide Name & Contact nos. of Person, if came through any referral or Consultancy"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="middle" style="width: 150px !important">Title
                                            <font color="#FF0000">*
                                            </font>
                                        </td>
                                        <td style="width:800px !important">
                                            <label><input type="radio" name="Title" value="Mr." class="reqinp"
                                                    checked>
                                                Mr.</label>&emsp;
                                            <label><input type="radio" name="Title" value="Ms.">
                                                Ms.</label>&emsp;
                                            <label><input type="radio" name="Title" value="Mrs.">
                                                Mrs.</label>&emsp;
                                            <label><input type="radio" name="Title" value="Dr.">
                                                Dr.</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="middle" style="width: 300px;">First Name<font color="#FF0000">*</font>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm reqinp" name="FName"
                                                id="FName" onblur="return convertCase(this)">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="middle">Middle Name</td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm" name="MName"
                                                onblur="return convertCase(this)">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="middle">Last Name<font color="#FF0000">*</font>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm reqinp" name="LName"
                                                onblur="return convertCase(this)">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="middle">Gender<font color="#FF0000">*
                                            </font>
                                        </td>
                                        <td>
                                            <select name="Gender" id="Gender" class="form-select form-select-sm reqinp">
                                                <option value="">Select</option>
                                                <option value="M">Male</option>
                                                <option value="F">Female</option>
                                                <option value="O">Other</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="middle">Father's Name<font color="#FF0000">*
                                            </font>
                                        </td>
                                        <td>
                                            <table style="width: 100%">
                                                <tr>
                                                    <td>
                                                        <select name="FatherTitle" id="FatherTitle"
                                                            class="form-select form-select-sm d-inline"
                                                            style="width: 80%;">
                                                            <option value="Mr.">Mr.</option>
                                                            <option value="Late">Late</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm reqinp"
                                                            name="FatherName" id="FatherName"
                                                            onblur="return convertCase(this)">
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="middle">Email ID<font color="#FF0000">*
                                            </font>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm reqinp" name="Email"
                                                id="Email">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="middle">Phone No.<font color="#FF0000">*
                                            </font>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm reqinp" name="Phone"
                                                id="Phone" onkeypress="return isNumberKey(event)" maxlength="10">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="middle">Nationality <font color="#FF0000">*</font>
                                        </td>
                                        <td>
                                            <select name="Nationality" id="Nationality" class="form-select form-select-sm">
                                                <option value="">Select</option>
                                                @foreach ($country_list as $key => $value)
                                                    <option value="{{ $key }}"
                                                        {{ session('Set_Country') == $key ? 'selected' : '' }}>
                                                        {{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td valign="middle">Aadhaar No. / NID No<font color="#FF0000">*
                                            </font>
                                        </td>
                                        <td>
                                            <input type="text" name="Aadhaar" id="Aadhaar" maxlength="12"
                                                onkeypress="return isNumberKey(event)"
                                                class="form-control form-control-sm reqinp">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Upload Resume</td>
                                        <td><input type="file" name="Resume" id="Resume"
                                                class="form-control form-control-sm reqinp" accept=".pdf,.docx">
                                            <p class="text-primary">Plese upload PDF/Word Document
                                                Only.</p>
                                        </td>
                                    </tr>
                                </table>

                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <div style="border: 1px solid #195999;vertical-align:top" class=" mt-3 d-inline-block"
                                    style="width: 150; height: 150;">
                                    <span id="preview">
                                        <center>
                                            <img src="{{ URL::to('/') }}/assets/images/user.png"
                                                style="width: 150px; height: 150px;" id="img1" />
                                        </center>
                                    </span>
                                    <center>
                                       
                                            <label>
                                                <input type="file" name="CandidateImage" id="CandidateImage"
                                                    class="btn btn-sm mb-1 " style="width: 100px;display: none;"
                                                    accept="image/png, image/gif, image/jpeg"><span
                                                    class="btn btn-sm btn-light shadow-sm text-primary">Upload
                                                    photo</span>
                                            </label>
                                      
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="SaveApplication">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="imagemodal" tabindex="-1"  aria-labelledby="myModalLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                 
                    <img src="" class="imagepreview" style="width: 100%;">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scriptsection')
    <script>
        $(document).ready(function() {
            $('.pop').on('click', function() {
                $('.imagepreview').attr('src', $(this).find('img').attr('src'));
                $('#imagemodal').modal('show');
            });
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
                var Gender = $('#Fill_Gender').val() || '';
                var Education = $('#Education').val() || '';
                var Name = $('#Name').val() || '';
                window.location.href = "{{ route('job_applications') }}?Company=" + Company + "&Department=" +
                    Department + "&Year=" + Year + "&Month=" + Month + "&Source=" + Source + "&Gender=" + Gender +
                    "&Education=" + Education + "&Name=" + Name;
            }

            $(document).on('change', '#MoveCompany', function() {
                var CompanyId = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "{{ route('getDepartment') }}?CompanyId=" + CompanyId,
                    success: function(res) {
                        if (res) {
                            $("#MoveDepartment").empty();
                            $("#MoveDepartment").append(
                                '<option value="">Select Department</option>');
                            $.each(res, function(key, value) {
                                $("#MoveDepartment").append('<option value="' + value +
                                    '">' +
                                    key +
                                    '</option>');
                            });
                            $('#MoveDepartment').val('<?= $_REQUEST['Department'] ?? '' ?>');
                        } else {
                            $("#MoveDepartment").empty();
                        }
                    }
                });
            });

            $(document).on('change', '#TechScrCompany', function() {
                var CompanyId = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "{{ route('getDepartment') }}?CompanyId=" + CompanyId,
                    success: function(res) {
                        if (res) {
                            $("#TechScrDepartment").empty();
                            $("#TechScrDepartment").append(
                                '<option value="">Select Department</option>');
                            $.each(res, function(key, value) {
                                $("#TechScrDepartment").append('<option value="' +
                                    value +
                                    '">' +
                                    key +
                                    '</option>');
                            });
                            $('#TechScrDepartment').val('<?= $_REQUEST['Department'] ?? '' ?>');
                        } else {
                            $("#TechScrDepartment").empty();
                        }
                    }
                });
            });

            $(document).on('change', '#TechScrDepartment', function() {
                var DepartmentId = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "{{ route('getReportingManager') }}?DepartmentId=" + DepartmentId,
                    success: function(res) {
                        if (res) {
                            $("#ScreeningBy").empty();
                            $("#ScreeningBy").append(
                                '<option value="">Select Department</option>');
                            $.each(res, function(key, value) {
                                $("#ScreeningBy").append('<option value="' + value +
                                    '">' +
                                    key +
                                    '</option>');
                            });
                        } else {
                            $("#ScreeningBy").empty();
                        }
                    }
                });
            });

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
            $(document).on('change', '#Fill_Gender', function() {
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

            $(document).on('click', '#HrScreening', function() {
                var JAId = $(this).data('id');
                $('#JAId').val(JAId);
                $('#HrScreeningModal').modal('show');
            });

            $(document).on('click', '#AddToJobPost', function() {
                var JAId = $(this).data('id');
                $('#AddJobPost_JAId').val(JAId);
                $('#AddJobPostModal').modal('show');
            });

            $(document).on('click', '#MoveCandidate', function() {
                var JAId = $(this).data('id');
                $('#MoveCandidate_JAId').val(JAId);
                $('#MoveCandidategModal').modal('show');
            });

            $('#ScreeningForm').on('submit', function(e) {
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
                            toastr.success(data.msg);
                            window.location.reload();
                        }
                    }
                });
            });

            $('#MapCandidateForm').on('submit', function(e) {
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
                            toastr.success(data.msg);
                            window.location.reload();
                        }
                    }
                });
            });

            $('#MoveCandidateForm').on('submit', function(e) {
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
                            toastr.success(data.msg);
                            window.location.reload();
                        }
                    }
                });
            });

            $(document).on('change', '#Status', function() {
                var Status = $(this).val();
                if (Status == 'Rejected') {
                    $('#RejectRemark').removeClass('d-none');
                    $("#RejectRemark").prop('required', true);
                } else {
                    $('#RejectRemark').addClass('d-none');
                    $("#RejectRemark").prop('required', false);
                }
            });

            $(document).on('click', '#BlackListCandidate', function() {
                var JCId = $(this).data('id');
                var Remark = prompt("Please Enter Remark to BlackList Candidate");
                if (Remark != null) {
                    $.ajax({
                        url: "{{ route('BlacklistCandidate') }}",
                        type: 'POST',
                        data: {
                            JCId: JCId,
                            Remark: Remark
                        },
                        dataType: 'json',
                        success: function(data) {
                            if (data.status == 200) {
                                toastr.success(data.msg);
                                window.location.reload();
                            } else {
                                toastr.error(data.msg);
                            }
                        }
                    });
                } else {
                    window.location.reload();
                }
            });

            $(document).on('click', '#UnBlockCandidate', function() {
                var JCId = $(this).data('id');
                var Remark = prompt("Please Enter Remark to Unblock Candidate");
                if (Remark != null) {
                    $.ajax({
                        url: "{{ route('UnBlockCandidate') }}",
                        type: 'POST',
                        data: {
                            JCId: JCId,
                            Remark: Remark
                        },
                        dataType: 'json',
                        success: function(data) {
                            if (data.status == 200) {
                                toastr.success(data.msg);
                                window.location.reload();
                            } else {
                                toastr.error(data.msg);
                            }
                        }
                    });
                } else {
                    window.location.reload();
                }
            });

            $(document).on('change', '#CandidateImage', function(e) {
                const [file] = e.target.files;
                if (file) {
                    img1.src = URL.createObjectURL(file);
                }
            });

            $('#Phone').focusout(function() {
                var count = $(this).val().length;
                if (count != 10) {
                    alert('Phone number should be of 10 digits');
                    $(this).addClass('errorfield');
                } else {
                    $(this).removeClass('errorfield');
                }
            });

            $('#Aadhaar').focusout(function() {
                var count = $(this).val().length;
                if (count != 12) {
                    alert('Aadhaar Number should be of 12 digits');
                    $(this).addClass('errorfield');
                } else {
                    $(this).removeClass('errorfield');
                }
            });
        });


        $(document).on('click', '#SendForTechSceenBtn', function() {
            var JAId = [];
            var ScreeningBy = $('#ScreeningBy').val();
            $("input[name='selectCand']").each(function() {
                if ($(this).prop("checked") == true) {
                    var value = $(this).val();
                    JAId.push(value);
                }
            });
            if (JAId.length > 0) {
                if (confirm('Are you sure to Send Selected Candidates to Screening Stage?')) {
                    $.ajax({
                        url: '{{ url('SendForTechScreening') }}',
                        method: 'POST',
                        data: {
                            JAId: JAId,
                            ScreeningBy: ScreeningBy
                        },
                        success: function(data) {
                            if (data.status == 400) {
                                alert('Something went wrong..!!');
                            } else {
                                toastr.success(data.msg);
                                window.location.reload();
                            }
                        }
                    });
                }

            } else {
                alert('No Candidate Selected!\nPlease select atleast one candidate to proceed.');
            }

        });

        $('#checkall').click(function() {
            if ($(this).prop("checked") == true) {
                $('.japchks').prop("checked", true);
            } else if ($(this).prop("checked") == false) {
                $('.japchks').prop("checked", false);
            }
        });

        function checkAllorNot() {
            var allchk = 1;
            $('.japchks').each(function() {
                if ($(this).prop("checked") == false) {
                    allchk = 0;
                }
            });
            if (allchk == 0) {
                $('#checkall').prop("checked", false);
            } else if (allchk == 1) {
                $('#checkall').prop("checked", true);
            }
        }

        //======================================================//
        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;

            return true;
        }

        function convertCase(evt) {
            var text = $(evt).val();
            $(evt).val(camelCase(text));
        }

        function camelCase(str) {
            return str.replace(/(?:^|\s)\w/g, function(match) {

                return match.toUpperCase();
            });
        }

        function checkRequired() {
            var res = 0;
            $('.reqinp').each(function() {
                if ($(this).val() == '' || $(this).val() == null) {
                    $(this).addClass('errorfield');
                    res = 1;
                } else {
                    $(this).removeClass('errorfield');
                }
            });
            return res;
        }

        function checkResumeSource(id) {

            if (id == 5 || id == 6 || id == 8) {
                $('#othersource_tr').removeClass('d-none');
            } else {
                $('#othersource_tr').addClass('d-none');
            }

        }

        $('#jobapplicationform').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            var reqcond = checkRequired();
            if (reqcond == 1) {
                alert('Please fill required field...!');
            } else {
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
                            toastr.success(data.msg);
                            window.location.reload();
                        }
                    }
                });
            }

        });

        function copylink(id) {
            var copyText = document.getElementById("link" + id);
            copyText.select();
            copyText.setSelectionRange(0, 99999)
            document.execCommand("copy");
            alert("Copied Link: " + copyText.value);
        }

        $('#Phone').focusout(function() {
            var count = $(this).val().length;
            if (count != 10) {
                alert('Phone number should be of 10 digits');
                $(this).addClass('errorfield');
            } else {
                $(this).removeClass('errorfield');
            }
        });

        $('#Aadhaar').focusout(function() {
            var count = $(this).val().length;
            if (count != 12) {
                alert('Aadhaar Number should be of 12 digits');
                $(this).addClass('errorfield');
            } else {
                $(this).removeClass('errorfield');
            }
        });
    </script>
@endsection
