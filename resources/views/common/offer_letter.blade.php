@php
use function App\Helpers\getDesignation;
use function App\Helpers\getStateName;
use function App\Helpers\getDepartmentCode;
use function App\Helpers\getCompanyCode;
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

        .frmbtn {
            padding: 2px 4px !important;
            font-size: 11px;
            cursor: pointer;
        }

    </style>
    <div class="page-content">
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
            <div class="col">
                <div class="card radius-10 mb-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0">Total Offer Letter Issued:<br>(Cr. year)</p>
                            </div>
                            <div class="ms-auto font-20">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 mb-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <hp class="mb-0">Offer Letter Status:<br>Accepted</hp>
                            </div>
                            <div class="ms-auto font-20">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 mb-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <hp class="mb-0">Offer Letter Status:<br>Pending</hp>

                            </div>
                            <div class="ms-auto font-20">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 mb-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <hp class="mb-0">Offer Letter Status:<br>Rejected</hp>

                            </div>
                            <div class="ms-auto font-20">
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
                                data-bs-target="#TechScreeningModal"><i class="fas fa-share text-primary"></i> Send Offer
                                Letter to Candidate
                            </label>
                        </span>
                    </div>
                </div>
                @foreach ($candidate_list as $row)

                    <div class="card mb-2">
                        <div class="card-body" style="padding: 5px;">
                            <div class="row  p-2 py-2">
                                <div style="width: 80%;float: left;">
                                    <table class=" table borderless" style="margin-bottom: 0px !important;">
                                        <tbody>
                                            <tr>
                                                <td colspan="2">
                                                    <label>
                                                        <input type="checkbox" name="selectCand" class="japchks"
                                                            onclick="checkAllorNot()" value="{{ $row->JAId }}">
                                                        <span class="mb-1 fw-bold" style="font-size: 14px; color:#275A72">
                                                            {{ $row->FName }} {{ $row->MName }} {{ $row->LName }}
                                                            (Ref.No {{ $row->ReferenceNo }}) </span>
                                                    </label>
                                                </td>
                                                <td colspan="2">MRF: {{ $row->JobCode }}</td>
                                            </tr>
                                            <tr>
                                                <td>Selectde for Dept.</td>
                                                <td>{{ getDepartmentCode($row->SelectedForD) }}
                                                    ({{ getCompanyCode($row->SelectedForC) }})
                                                </td>
                                                <td style="text-align: right">Offer Letter Send:</td>
                                                <td style="text-align: right">{{ $row->OfferLetterSent ?? 'No' }}
                                                    @if ($row->OfferLetterSent != null)
                                                        <span style="margin-left: 10px;"><button
                                                                class="frmbtn btn btn-primary">View History</button></span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Acceptance Status:</td>
                                                <td
                                                    class="<?= $row->Answer == 'Accepted' ? 'text-success' : 'text-danger' ?> fw-bold">
                                                    {{ $row->Answer }}</td>
                                                <td style="text-align: right">Date of Joining:</td>
                                                <td style="text-align: right">
                                                    {{ $row->JoinOnDt }}
                                                    <span style="margin-left: 20px; font-size:14px;"
                                                        class="text-primary"><i class="fa fa-pencil"></i></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Joining Form to Candidate Sent:</td>
                                                <td>{{ $row->JoiningFormSent ?? 'No' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-primary">
                                                    <a href="javascript:void(0);" data-bs-toggle="modal"
                                                        data-bs-target="#OfferLtrModal" id="offerltredit"
                                                        data-id="{{ $row->JAId }}">
                                                        Letter Basic Details
                                                        @if ($row->OfferLetter == 1)
                                                            <i class="fa fa-check-circle text-success"></i>
                                                        @endif
                                                    </a>
                                                </td>
                                                <td class="text-primary" colspan="2">

                                                    @if ($row->OfferLetter == 1)
                                                        <a href="javascript:void(0);" id="offerltrgen"
                                                            data-id="{{ $row->JAId }}">Generate & View
                                                            Offer Letter</a>
                                                        @if ($row->OfferLtrGen == 1)
                                                            <i class="fa fa-check-circle text-success"></i>
                                                        @endif
                                                    @else
                                                        <a href="javascript:void(0);"
                                                            title="Offer Letter Basic Detail Not Mentioned"
                                                            id="{{ $row->JAId }}">Generate
                                                            & View
                                                            Offer Letter</a>


                                                    @endif

                                                </td>
                                                <td class="text-primary" style="text-align: right">Send for Review
                                                    @if ($row->SendReview == 1)
                                                        <i class="fa fa-check-circle text-success"></i>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Offer Letter View:</td>
                                                @php
                                                    $jaid = base64_encode($row->JAId);
                                                @endphp
                                                <td colspan="3"><input type="text" name="" id="" class="frminp d-inline"
                                                        value="{{ url('jobportal/aaa?jaid=' . $jaid) }}">
                                                    <button class="frmbtn btn btn-sm btn-secondary">Copy Link</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Joining Form View:</td>
                                                <td colspan="3"><input type="text" name="" id="" class="frminp d-inline">
                                                    <button class="frmbtn btn btn-sm btn-secondary">Copy Link</button>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="" style=" width: 20%;float: left;">
                                    <center>
                                        @if ($row->CandidateImage == null)
                                            <img src="{{ URL::to('/') }}/assets/images/user1.png"
                                                style="width: 130px; height: 130px;" class="img-fluid rounded" />
                                        @else
                                            <img src="{{ URL::to('/') }}/uploads/Picture/{{ $row->CandidateImage }}"
                                                style="width: 130px; height: 130px;" class="img-fluid rounded" />
                                        @endif
                                    </center>
                                    <center>
                                        <small>
                                            <span class="text-primary m-1 " style="cursor: pointer; font-size:14px;"
                                                onclick="aboutCand($row->JAId);">
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
                            <select name="Status" id="Status" class="form-select form-select-sm"
                                onchange="GetApplications();">
                                <option value="">Select Status</option>
                                <option value="Accept">Accept</option>
                                <option value="Reject">Reject</option>
                            </select>
                            @if (isset($_REQUEST['Status']) && $_REQUEST['Status'] != '')
                                <script>
                                    $('#Status').val('<?= $_REQUEST['Status'] ?>');
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

    <div class="modal fade" id="OfferLtrModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('update_offerletter_basic') }}" method="POST" id="offerletterbasicform">
                <input type="hidden" name="JAId" id="JAId">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-light" id="exampleModalLabel">Offer Letter Basic Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered" style="vertical-align: middle;">
                            <tbody>
                                <tr>
                                    <td style="width:150px; ">Candidate's Name</td>
                                    <td><input type="text" name="CandidateName" id="CandidateName" disabled
                                            style="background-color: white;border:aliceblue; width: 160px; color:black">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:150px;">Father's Name</td>
                                    <td><input type="text" name="Father" id="Father" disabled
                                            style="background-color: white;border:aliceblue; width: 160px; color:black">
                                    </td>
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
                                                        <div class="form-check form-check-inline d-none" id="permanent_div">
                                                            <select name="PermState" id="PermState"
                                                                class="form-select form-select-sm d-inline"
                                                                style="width: 130px;">
                                                                <option value="">Select State</option>

                                                            </select>
                                                            <select name="PermHQ" id="PermHQ"
                                                                class="form-select form-select-sm d-inline"
                                                                style="width: 130px;">
                                                                <option value="">Select HQ</option>

                                                            </select>
                                                            <input type="text" name="PermCity" id="PermCity"
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
                                                            <label class="form-check-label" for="functional_chk">Functional
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
                                            <label class="form-check-label" for="nopnot">No Probation / No Training</label>
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
                var Gender = $('#Gender').val() || '';
                var Status = $('#Status').val() || '';
                var Name = $('#Name').val() || '';
                window.location.href = "{{ route('offer_letter') }}?Company=" + Company + "&Department=" +
                    Department + "&Year=" + Year + "&Month=" + Month + "&Gender=" + Gender + "&Name=" + Name +
                    "&Status=" + Status;
            }


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
            $(document).on('change', '#Status', function() {
                GetApplications();
            });

            $(document).on('blur', '#Name', function() {
                GetApplications();
            });

            $(document).on('click', '#reset', function() {
                window.location.href = "{{ route('offer_letter') }}";
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
                $('.scon').css('display', 'inline');
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

                        $('#JAId').val(res.candidate_detail.JAId);
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

                        $("#PermState").empty();
                        $("#PermState").append(
                            '<option value="0">Select State</option>');
                        $.each(res.state_list, function(key, value) {
                            $("#PermState").append('<option value="' + value + '">' + key +
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
                            $('#PermState').val(res.candidate_detail.F_StateHq);
                            $('#PermHQ').val(res.candidate_detail.F_LocationHq);
                            $('#PermCity').val(res.candidate_detail.F_City);
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


        /* $(document).on('change', '#PermState', function() {
                    var StateId = $(this).val();
                    $.ajax({
                        type: "GET",
                        url: "{{ route('getHq') }}?StateId=" + StateId,
                        success: function(res) {
                            if (res) {
                                $("#PermHQ").empty();
                                $("#PermHQ").append(
                                    '<option value="">Select Headquarter</option>');
                                $.each(res, function(key, value) {
                                    $("#PermHQ").append('<option value="' + value + '">' +
                                        key +
                                        '</option>');
                                });
                                $('#PermHQ').val('<?= $_REQUEST['Department'] ?? '' ?>');
                            } else {
                                $("#PermHQ").empty();
                            }
                        }
                    });
                });

                $(document).on('change', '#TempState', function() {
                    var StateId = $(this).val();
                    $.ajax({
                        type: "GET",
                        url: "{{ route('getHq') }}?StateId=" + StateId,
                        success: function(res) {
                            if (res) {
                                $("#TempHQ").empty();
                                $("#TempHQ").append(
                                    '<option value="">Select Headquarter</option>');
                                $.each(res, function(key, value) {
                                    $("#TempHQ").append('<option value="' + value + '">' +
                                        key +
                                        '</option>');
                                });
                                $('#TempHQ').val('<?= $_REQUEST['Department'] ?? '' ?>');
                            } else {
                                $("#TempHQ").empty();
                            }
                        }
                    });
                }); */







        $(document).on('change', '#AdminstrativeDepartment', function() {
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

                    }
                }
            });


        });

        $(document).on('click', '#offerltrgen', function() {
            var JAId = $(this).data('id');
            sendingId = btoa(JAId);
            window.open("{{ route('offer_letter_generate') }}?jaid=" + sendingId, '_blank');

        });


    </script>
@endsection
