@php
use function App\Helpers\getDesignation;
use function App\Helpers\getEducationById;
use function App\Helpers\getSpecializationbyId;
use function App\Helpers\getResumeSourceById;
use function App\Helpers\getStateName;
@endphp
@extends('layouts.master')
@section('title', 'Jobs & Response')
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
            padding: 2 px 4 px !important;
            font-size: 11px;
            cursor: pointer;
        }

        td.details-control {
            background: url("{{ asset('assets/images/details_open.png') }}") no-repeat center center;
            cursor: pointer;
        }

        tr.shown td.details-control {
            background: url("{{ asset('assets/images/details_close.png') }}") no-repeat center center;
        }

    </style>
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb  align-items-center mb-3">
            <div class="row mb-1">
                <div class="col-3 breadcrumb-title ">
                    jobs & Response
                </div>
                <div class="col-2">
                    <select name="Fill_Company" id="Fill_Company" class="form-select form-select-sm"
                        onchange="GetJobResponse(); GetDepartment();">
                        <option value="">Select Company</option>
                        @foreach ($company_list as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-2">

                    <select name="Fill_Department" id="Fill_Department" class="form-select form-select-sm"
                        onchange="GetJobResponse();">
                        <option value="">Select Department</option>

                    </select>
                </div>
                <div class="col-2">
                    <select name="Year" id="Year" class="form-select form-select-sm" onchange="GetJobResponse();">
                        <option value="">Select Year</option>
                        @for ($i = 2021; $i <= date('Y'); $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-2">
                    <select name="Month" id="Month" class="form-select form-select-sm" onchange="GetJobResponse();">
                        <option value="">Select Month</option>
                        @foreach ($months as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-1">
                    <button type="reset" class="btn btn-danger btn-sm" id="reset"><i class="bx bx-refresh"></i></button>
                </div>
            </div>

        </div>
        <!--end breadcrumb-->

        <div class="card border-top border-0 border-4 border-primary mb-3">
            <div class="card-body table-responsive">
                <table class="table table-hover table-striped table-condensed align-middle text-center table-bordered"
                    id="JobApplications" style="width: 100%">
                    <thead class="text-center bg-primary text-light">
                        <tr class="text-center">
                            <td>#</td>
                            <td class="th-sm">S.No</td>
                            <td>JobCode</td>
                            <td>Department</td>
                            <td>Designation</td>
                            <td>Responses</td>
                            {{-- <td>Sources</td> --}}
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card border-top d-none border-0 border-4 border-primary mb-2" id="DetailDiv">
            <div class="card-body">
                <div class="row mb-1">
                    <h5 class=" text-primary" id="PostTitle"></h5>
                </div>
                <div class="row">
                    <div class="col-5">
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
                    </div>
                    <div class="col-3">
                        <span class="d-inline">
                            <select name="Source" id="Source" class="form-select form-select-sm">
                                <option value="">Select Source</option>
                                @foreach ($source_list as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </span>
                    </div>
                    <div class="col-2">
                        <span class="d-inline">
                            <select name="Gender" id="Gender" class="form-select form-select-sm">
                                <option value="">Select Gender</option>
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                                <option value="O">Others</option>
                            </select>
                        </span>
                    </div>
                </div>

            </div>
        </div>
        <div id="CandidateDiv"></div>
        <div id="pagination"></div>
        <input type="hidden" id="userrole" value="{{ Auth::user()->role }}">
        <input type="hidden" id="path" value="{{ URL::to('/') }}">
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
@endsection
@section('scriptsection')
    <script>
        function GetDepartment() {
            var CompanyId = $('#Fill_Company').val();
            $.ajax({
                type: "GET",
                url: "{{ route('getDepartment') }}?CompanyId=" + CompanyId,
                beforeSend: function() {

                },
                success: function(res) {
                    if (res) {
                        $("#Fill_Department").empty();
                        $("#Fill_Department").append(
                            '<option value="" selected disabled >Select Department</option>');
                        $.each(res, function(key, value) {
                            $("#Fill_Department").append('<option value="' + value + '">' + key +
                                '</option>');
                        });
                    } else {
                        $("#Fill_Department").empty();
                    }
                }
            });
        }

        function GetJobResponse() {
            $('#JobApplications').DataTable().draw(true);

        }

        $(document).on('click', '#reset', function() {
            location.reload();
        });

        $(document).ready(function() {
            $('#JobApplications').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                searching: false,
                lengthChange: false,
                info: true,
                ajax: {
                    url: "{{ route('getJobResponseSummary') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function(d) {
                        d.Company = $('#Fill_Company').val();
                        d.Department = $('#Fill_Department').val();
                        d.Year = $('#Year').val();
                        d.Month = $('#Month').val();
                    },
                    type: 'POST',
                    dataType: "JSON",
                },
                columns: [

                    {
                        data: 'chk',
                        name: 'chk'
                    },
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },

                    {
                        data: 'JobCode',
                        name: 'JobCode'
                    },
                    {
                        data: 'Department',
                        name: 'Department'
                    },
                    {
                        data: 'Designation',
                        name: 'Designation'
                    },

                    {
                        data: 'Response',
                        name: 'Response'
                    },
                    /* {
                        data: 'Source',
                        name: 'Source'
                    }, */

                ],
            });


        });

        $(document).on('click', '.select_all', function() {
            if ($(this).prop("checked") == true) {
                $(this).closest("tr").addClass("bg-secondary bg-gradient text-light");
            } else {
                $(this).closest("tr").removeClass("bg-secondary bg-gradient text-light");
            }
        });

        function getPostTitle(JPId) {
            $.ajax({
                type: "POST",
                url: "{{ route('getPostTitle') }}?JPId=" + JPId,
                success: function(res) {
                    if (res) {
                        $("#PostTitle").html('Candidates Applied For: ' + res);
                    }
                }
            });
        }
        let page_no = 1;
        let JPId = '';
        let Gender = '';
        let Source = '';
        $(document).on('click', '.getCandidate', function() {
            JPId = $(this).data('id');
            getPostTitle(JPId);
            $('#DetailDiv').removeClass('d-none');
            getCandidate(JPId, page_no, Gender, Source);
        });

        $(document).on('change', '#Source', function() {
            Source = $(this).val();
            getCandidate(JPId, page_no, Gender, Source);
        });

        $(document).on('change', '#Gender', function() {
            Gender = $(this).val();
            getCandidate(JPId, page_no, Gender, Source);
        });

        function getCandidate(JPId, page_no, Gender, Source) {
            $.ajax({
                type: "POST",
                url: "{{ route('getJobResponseCandidateByJPId') }}",
                async: false,
                data: {
                    JPId: JPId,
                    page: page_no,
                    Gender: Gender,
                    Source: Source
                },
                success: function(response) {
                    var x = '';
                    var s_no = (parseInt(response.data.current_page - 1) * parseInt(response.data
                        .per_page) + 1)
                    $.each(response.data.data, function(key, value) {
                        var jaid = btoa(value.JAId);
                        var bg_color = '';
                        if (value.Status == 'Rejected' || value.BlackList == 1) {
                            bg_color = '#fe36501f';
                        } else {
                            if (value.FwdTechScr == 'Yes') {
                                bg_color = '#dbffdacc';
                            }
                        }
                        x = x + '<div class="card mb-3" style="background-color:' + bg_color + '">' +
                            '<div class="card-body" style="padding: 5px;">' +
                            '<div class="row  p-2 py-2">' +
                            '<div style="width: 80%;float: left;">' +
                            '<table class="jatbl table borderless" style="margin-bottom: 0px !important;">' +
                            ' <tbody>' +
                            '<tr>' +
                            ' <td colspan="3">' +
                            ' <label>';
                        if (value.Status == 'Selected' && value.FwdTechScr == 'No' && value.BlackList ==
                            0) {
                            x = x +
                                '<input type="checkbox" name="selectCand" class="japchks" onclick="checkAllorNot()" value="' +
                                value.JAId + '"> ';
                        }
                        x = x +
                            '<span style="color: #275A72;font-weight: bold;padding-bottom: 10px;">' +
                            value.FName + ' ' + (value.MName == null ? '' : value.MName) + ' ' + value
                            .LName +
                            '(Ref.No ' + value.ReferenceNo + ')</span>' +
                            ' </label>' +
                            '</td>' +
                            ' </tr>' +
                            '<tr>' +
                            '<td style="text-align: left">Applied For:</td>' +
                            '<td colspan="3">' + (value.DesigId != null ? value.Title :
                                '<id class="fa fa-pencil-square-o text-primary" style="cursor:pointer" id="AddToJobPost" data-id="' +
                                value.JAId + '"></id>') + '</td>' +
                            ' </tr>' +
                            '<tr>' +
                            '<td>Experience<span class="pull-right">:</span></td>' +
                            '<td style="text-align:right">';
                        if (value.Professional == 'F') {
                            x = x + 'Fresher';
                        } else {
                            if (value.JobStartDate != null) {
                                var fdate = value.JobStartDate;
                                if (value.JobEndDate == null) {
                                    var tdate = now();
                                } else {
                                    var tdate = value.JobEndDate;
                                }
                                var diff_year_month_day = diff_year_month_day(fdate, tdate)
                                x = x + diff_year_month_day;
                            } else {
                                x = x + 'Experienced';
                            }
                        }
                        x = x + '</td>' +
                            '<td style="text-align: right">Contact No<span class="pull-right">:</span></td>' +
                            '<td style="text-align:right">' + value.Phone;
                        if (value.Verified == 'Y') {
                            x = x + '<i class="fadeIn animated bx bx-badge-check text-success"></i>';
                        }
                        x = x + '<tr>' +
                            '<tr class=""><td>Current Company<span class="pull-right">:</span></td>' +
                            ' <td style="text-align: right">' + (value.PresentCompany == null ? '' :
                                value
                                .PresentCompany) +
                            '<td style="text-align: right">Email ID<span class="pull-right">:</span></td>' +
                            '<td style="text-align: right">' + value.Email;
                        if (value.Verified == 'Y') {
                            x = x + '<i class="fadeIn animated bx bx-badge-check text-success"></i>';
                        }
                        x = x + '</td> </tr>';
                        x = x +
                            '<tr class=""><td>Current Designation<span class="pull-right">:</span></td><td style="text-align: right">' +
                            (value.Designation == null ? '' : value.Designation) +
                            ' </td>' +
                            '<td style="text-align: right">Education<span class="pull-right">:</span></td>' +
                            ' <td style="text-align: right">' +
                            (value.Education == null ? '' : value.EducationCode) +
                            (value.Specialization == null ? '' : ' - ' + value.Specialization) +
                            '</td></tr>' +
                            '<tr class="">' +
                            '<td>Current Location<span class="pull-right">:</span></td>' +
                            '<td style="text-align: right">' + value.City + '</td>' +
                            ' </tr>' +
                            '<tr><td>Applied on date:</td>' +
                            ' <td style="text-align: right">' + value.ApplyDate + '</td>' +
                            ' <td style="text-align: right">HR Screening Status:</td>' +
                            '   <td style="text-align: right">';
                        if (value.JPId != 0) {
                            x = x + (value.Status != null ? '<b>' + value.Status + '<b>' :
                                '<i class="fa fa-pencil-square-o text-primary" aria-hidden="true" style="font-size:14px;cursor: pointer;" id="HrScreening" data-id="' +
                                value.JAId + '">'
                            );
                        }
                        x = x + '</td></tr>' +
                            '<tr><td> Source: </td><td style="text-align: right">' +
                            value.ResumeSource +
                            '</td>' +
                            '<td class="text-danger fw-bold" style="text-align: center" colspan="2">';
                        if (value.BlackList == 0) {
                            x = x +
                                '<label class="text-danger" style=" cursor: pointer;" id="BlackListCandidate" data-id="' +
                                value.JCId +
                                '"><i class="fas fa-ban text-danger"></i>Blacklist Candidate</label>';
                        } else {
                            if ($("#userrole").val() == 'A') {
                                x = x +
                                    '<label class="text-primary" style=" cursor: pointer;" id="UnBlockCandidate" data-id="' +
                                    value.JCId +
                                    '"><i class="fas fa-user text-primary"></i>Unblock Candidate</label>';
                            }
                        }
                        x = x + ' </td>' +
                            '</tr>';
                        if (value.BlackListRemark != null) {
                            x = x + '<tr><td colspan="4" class="text-danger fw-bold">' + value
                                .BlackListRemark + '</td></tr>';
                        }
                        if (value.UnBlockRemark != null) {
                            x = x + '<tr><td colspan="4" class="text-success fw-bold">' + value
                                .UnBlockRemark + '</td></tr>';
                        }
                        x = x + '</tbody>' +
                            '</table>' +
                            '</div>' +
                            ' <div class="" style=" width: 20%;float: left;">' +
                            '<center>';
                        if (value.CandidateImage == null || value.CandidateImage == '') {
                            x = x +
                                '<img src="' + $('#path').val() +
                                '/assets/images/user1.png" style="width: 130px; height: 130px;" class="img-fluid rounded" />';
                        } else {
                            x = x +
                                '<img src="' + $('#path').val() +
                                '/uploads/Picture/' + value.CandidateImage +
                                '" style="width: 130px; height: 130px;" class="img-fluid rounded" />';
                        }
                        x = x + '</center>' +
                            ' <center>' +
                            '<small>' +
                            '<span class="text-primary m-1 " style="cursor: pointer; font-size:14px;">' +
                            '<a href="{{route('candidate_detail')}}?jaid='+jaid+'" target="_blank">View Details</a>' +
                            '</span>' +
                            '</small>' +
                            '</center>' +
                            '<center class="mt-3 fw-bold"><span class="d-inline"><label class="text-success" style=" cursor: pointer;" id="MoveCandidate" data-id="' +
                            value.JAId +
                            '"><i class="fas fa-shekel-sign text-success"></i> Move to Other Co.' +
                            '</label></span></center>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                    });
                    $('#CandidateDiv').html(x);
                    $('#pagination').html(response.page_link);
                }
            });
        }

        let i = 1;
        $(document).on('click', '.page_click', function(e) {
            e.preventDefault();
            var rel = $(this).attr('rel');
            if (rel == 'next') {
                var no = i++;
                getCandidate(JPId, parseInt(no + 1), Gender, Source);
            } else if (rel == 'prev') {
                var no = i--;
                getCandidate(JPId, parseInt(no - 1), Gender, Source);
            } else {
                page_no = $(this).text();
                getCandidate(JPId, page_no, Gender, Source);
                i = page_no;
            }
        });

        function diff_year_month_day(dt1, dt2) {
            var time = (dt2.getTime() - dt1.getTime()) / 1000;
            var year = Math.abs(Math.round((time / (60 * 60 * 24)) / 365.25));
            var month = Math.abs(Math.round(time / (60 * 60 * 24 * 7 * 4)));
            var days = Math.abs(Math.round(time / (3600 * 24)));
            return "Year :- " + year + " Month :- " + month + " Days :-" + days;
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

        $(document).on('click', '#HrScreening', function() {
            var JAId = $(this).data('id');
            $('#JAId').val(JAId);
            $('#HrScreeningModal').modal('show');
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
    </script>
@endsection
