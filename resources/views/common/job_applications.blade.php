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

        .frminp {
            padding: 4 px !important;
            height: 25 px;
            border-radius: 4 px;
            font-size: 11px;
            font-weight: 550;
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
                            <label class="text-primary " style=" cursor: pointer;" onclick="SendForScreening()"><i
                                    class="fas fa-share text-primary"></i> Fwd. for Technical
                                Screening
                            </label>
                        </span>
                       {{--  <span class="d-inline">
                            <label class="text-primary" style=" cursor: pointer;" onclick="MoveCandidate()"><i
                                    class="fas fa-shekel-sign text-primary"></i> Move to Other Co.
                            </label>
                        </span> --}}
                    </div>
                </div>
                @foreach ($candidate_list as $row)
                    @php
                        $bg_color = '';
                        if ($row->Status == 'Rejected') {
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
                                                        @if ($row->Status == 'Selected' && $row->FwdTechScr == 'No')
                                                            <input type="checkbox" name="selectCand" class="japchks"
                                                                onclick="checkAllorNot()" value="{{ $row->JAId }}">
                                                        @endif
                                                        <span
                                                            style="color: #275A72;font-weight: bold;padding-bottom: 10px;">
                                                            {{ $row->FName }} {{ $row->MName }} {{ $row->LName }} (Ref.No {{ $row->ReferenceNo }} ) </span>
                                                    </label>
                                                </td>
                                               
                                            </tr>
                                            <tr>
                                                <td style="text-align: left">Applied For:</td>
                                                <td  colspan="3"><?= $row->DesigId != null ? getDesignation($row->DesigId) : "<i class='fa fa-pencil-square-o text-primary' aria-hidden='true' style='cursor: pointer;' onclick='AddToJobPost($row->JAId)'></i>" ?></td>
                                            </tr>
                                            <tr class="">
                                                <td>Experience<span class="pull-right">:</span></td>
                                                <td style="text-align: right">
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
                                                                $datetime1 = new DateTime($fdate);
                                                                $datetime2 = new DateTime($tdate);
                                                                $interval = $datetime1->diff($datetime2);
                                                                $days = $interval->format('%a');
                                                                $years_remaining = intval($days / 365); //divide by 365 and throw away the remainder
                                                                $days_remaining = $days % 365;
                                                                $month_remaining = $days_remaining % 12;
                                                                echo $years_remaining . ' Year ' . $month_remaining . ' Months';
                                                            } else {
                                                                echo 'Experienced';
                                                            }
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
                                                    <?= $row->Status != null ? '<b>' . $row->Status . '</b>' : "<i class='fa fa-pencil-square-o text-primary' aria-hidden='true' style='font-size:14px;cursor: pointer;' id='HrScreening' data-id='$row->JAId'></i>" ?>
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
                                            <img src="{{ URL::to('/') }}/assets/images/user1.png"
                                                style="width: 130px; height: 130px;" class="img-fluid rounded" />
                                        @else
                                            <img src="{{ URL::to('/') }}/uploads/Picture/{{ $row->CandidateImage }}"
                                                style="width: 130px; height: 130px;" class="img-fluid rounded" />
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

    <div class="modal fade" id="HrScreeningModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <form action="{{ route('update_hrscreening') }}" method="POST" id="ScreeningForm">
                <div class="modal-content">
                    <div class="modal-body">
                        <input type="hidden" name="JAId" id="JAId">
                        <label for="Status">HR Screening Status</label>
                        <select name="Status" id="Status" class="form-select form-select-sm">
                            <option value="" disabled selected></option>
                            <option value="Selected">Selected</option>
                            <option value="Rejected">Rejected</option>
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
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <form action="{{ route('SendForTechScreening') }}" method="POST" id="ScreeningForm">
                <div class="modal-content">
                    <div class="modal-body">
                        <label for="Status">HR Screening Status</label>
                        <select name="Status" id="Status" class="form-select form-select-sm">
                            <option value="" disabled selected></option>
                            <option value="Selected">Selected</option>
                            <option value="Rejected">Rejected</option>
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

            $(document).on('click', '#HrScreening', function() {
                var JAId = $(this).data('id');
                $('#JAId').val(JAId);
                $('#HrScreeningModal').modal('show');
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

        function SendForScreening() {
            var JAId = [];
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

        }
    </script>
@endsection
