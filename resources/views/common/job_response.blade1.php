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

        <div class="card border-top border-0 border-4 border-primary">
            <div class="card-body">
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
                            <td>Sources</td>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card d-none border-top border-0 border-4 border-primary" id="CandidateDiv">
            <div class="card-body">
                <div class="row mb-1">
                    <div class="col-7">
                        <h5 class=" text-primary" id="PostTitle"></h5>
                    </div>
                    <div class="col-2">
                        <select name="Source" id="Source" class="form-select form-select-sm" onchange="GetCandidate();">
                            <option value="">Select Source</option>
                            @foreach ($source_list as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-2">

                        <select name="Gender" id="Gender" class="form-select form-select-sm" onchange="GetCandidate();">
                            <option value="">Select Gender</option>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                            <option value="O">Others</option>
                        </select>
                    </div>

                </div>

                <div class=" bg-white rounded stickThis d-flex justify-content-between"
                    style="font-size: 14px; padding-left:35px;">
                    <span class="d-inline">
                        <span style="font-weight: bold;">↱</span>
                        <label class="text-primary"><input id="checkall" type="checkbox" name="">&nbsp;Check all</label>
                        <i class="text-muted" style="font-size: 13px;">With selected:</i> 
                        <label class="text-primary " style=" cursor: pointer;" onclick="SendForScreening()"><i
                                class="fas fa-share text-primary"></i> Fwd. for Technical
                            Screening
                        </label>
                    </span>
                    
                    <span class="d-inline">
                        <label class="text-dark" style=" cursor: pointer;" onclick="MoveCandidate()"><i
                                    class="fas fa-shekel-sign text-dark"></i> Move to Other Co.
                        </label>
                    </span>
                </div>
                <table class="table table-hover table-striped table-condensed align-middle text-center table-bordered"
                    id="candidate_table" style="width: 100%">
                    <thead class="text-center bg-primary text-light">
                        <tr class="text-center">
                            <th style="width:30px;"></th>
                            <td>#</td>
                            <td class="th-sm">S.No</td>
                            <td>Reference No</td>
                            <td>Name</td>
                            <td>Experience</td>
                            <td>Apply Date</td>
                            <td>Sources</td>
                            <td>Screened By</td>
                            <td>View</td>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
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

        function GetCandidate() {
            $('#candidate_table').DataTable().draw(true);

        }

        $(document).on('click', '#reset', function() {
            location.reload();
        });


        function format(d) {
            // `d` is the original data object for the row
            return '<table cellpadding="5" cellspacing="0"  style="padding-left:50px;" class="table text-center bg-secondary text-light">' +
                '<tr>' +
                '<td>Current Company:</td>' +
                '<td>' + d.PresentCompany + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Designation:</td>' +
                '<td>' + d.Designation + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Extra info:</td>' +
                '<td>And any further details here (images etc)...</td>' +
                '</tr>' +
                '</table>';
        }

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
                    {
                        data: 'Source',
                        name: 'Source'
                    },

                ],
            });


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

        function getCandidate(JPId) {
            $('#CandidateDiv').removeClass('d-none');
            var JPId = JPId;
            getPostTitle(JPId);
            table = $('#candidate_table').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                searching: false,
                lengthChange: false,
                info: true,
                destroy: true,
                ajax: {
                    url: "{{ route('getCandidates') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function(d) {
                        d.JPId = JPId;
                        d.Gender = $('#Gender').val();
                        d.Source = $('#Source').val();

                    },
                    type: 'POST',
                    dataType: "JSON",
                },
                columns: [{
                        "className": 'details-control',
                        "orderable": false,
                        "data": null,
                        "defaultContent": ''
                    },

                    {
                        data: 'chk',
                        name: 'chk'
                    },
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },

                    {
                        data: 'ReferenceNo',
                        name: 'ReferenceNo'
                    },
                    {
                        data: 'Name',
                        name: 'Name'
                    },

                    {
                        data: 'Professional',
                        name: 'Professional'
                    },
                    {
                        data: 'ApplyDate',
                        name: 'ApplyDate'
                    },
                    {
                        data: 'Source',
                        name: 'Source'
                    },
                    {
                        data: 'ScreenedBy',
                        name: 'ScreenedBy'
                    },
                    {
                        data: 'Details',
                        name: 'Details'
                    }

                ],
            });

        }

        $('#candidate_table tbody').on('click', 'td.details-control', function() {
            var tr = $(this).closest('tr');
            var row = table.row(tr);

            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                row.child(format(row.data())).show();
                tr.addClass('shown');
            }
        });


        $(document).on('click', '.select_all', function() {
            if ($(this).prop("checked") == true) {
                $(this).closest("tr").addClass("bg-secondary bg-gradient text-light");
            } else {
                $(this).closest("tr").removeClass("bg-secondary bg-gradient text-light");
            }
        });

        function PDateEnbl(JCId, th) {
            $('#PlacementDate' + JCId).prop('readonly', false);
            $(th).hide(500);
            $('#PDateSave' + JCId).show(500);
            $('#PDateCanc' + JCId).show(500);
        }

        function SavePlacementDate(JCId, th) {
            var JCId = JCId;
            var PlacementDate = $('#PlacementDate' + JCId).val();
            $.ajax({
                url: '{{ url('SavePlacementDate') }}',
                method: 'POST',
                data: {
                    JCId: JCId,
                    PlacementDate: PlacementDate
                },
                success: function(data) {
                    if (data.status == 400) {
                        alert('Something went wrong..!!');
                    } else {
                        toastr.success(data.msg);
                        location.reload();
                    }
                }
            });
        }

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
            var sc = [];
            $("input[name='selectCand']").each(function() {
                if ($(this).prop("checked") == true) {
                    var value = $(this).val();
                    sc.push(value);
                }
            });
            if (sc.length > 0) {
                if (confirm('Are you sure to Send Selected Candidates to Screening Stage?')) {
                    $.ajax({
                        url: '{{ url('SendForScreening') }}',
                        method: 'POST',
                        data: {
                            JAId: sc,
                        },
                        success: function(data) {
                            if (data.status == 400) {
                                alert('Something went wrong..!!');
                            } else {
                                toastr.success(data.msg);
                                $('#CandidateRecords').DataTable().ajax.reload(null, false);
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
