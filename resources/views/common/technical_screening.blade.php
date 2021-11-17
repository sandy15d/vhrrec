@extends('layouts.master')
@section('title', 'Screening Tracker')
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

        table,
        th,
        td {
            border: 0.25px solid white;
            vertical-align: middle;
        }

        td.details-control {
            background: url("{{ asset('assets/images/details_open.png') }}") no-repeat center center;
            cursor: pointer;
        }

        tr.shown td.details-control {
            background: url("{{ asset('assets/images/details_close.png') }}") no-repeat center center;
        }

        .details-control {
            width: 40px;
        }

    </style>
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb  align-items-center mb-3">
            <div class="row mb-1">
                <div class="col-3 breadcrumb-title ">
                    Screening Tracker
                </div>
                <div class="col-2">
                    <select name="Fill_Company" id="Fill_Company" class="form-select form-select-sm"
                        onchange="GetCandidates(); GetDepartment();">
                        <option value="">Select Company</option>
                        @foreach ($company_list as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-2">

                    <select name="Fill_Department" id="Fill_Department" class="form-select form-select-sm"
                        onchange="GetCandidates(); GetMRF();">
                        <option value="">Select Department</option>

                    </select>
                </div>
                <div class="col-4">

                    <select name="Fill_JobCode" id="Fill_JobCode" class="form-select form-select-sm"
                        onchange="GetCandidates();">
                        <option value="">Select MRF</option>

                    </select>
                </div>
                <div class="col-1">
                    <button type="reset" class="btn btn-danger btn-sm" id="reset"><i class="bx bx-refresh"></i></button>
                </div>
            </div>

        </div>
        <!--end breadcrumb-->
        <div class="card border-top border-0 border-4 border-primary mb-2">
            <div class="card-body table-responsive">

            </div>
        </div>

        <div class="card border-top border-0 border-4 border-primary">
            <div class="card-body table-responsive">
                <table class="table table-striped table-condensed text-center" id="candidate_table"
                    style="width: 100%; margin-right:20px; ">
                    <thead class="text-center bg-primary bg-gradient text-light">
                        <tr class="text-center">
                            <th style="width:30px;"></th>
                            <td>#</td>
                            <td>S.No</td>
                            <td>Ref. No</td>
                            <td>Candidate Name</td>
                            <td>Department</td>
                            <td>MRF</td>
                            <td>Screening Status</td>
                            <td>Interview Attend</td>
                            <td>Interview Mail</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="TechnicalScreenModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog">
            <form action="{{ route('MapCandidateToJob') }}" method="POST" id="MapCandidateForm">
                <div class="modal-content">
                    <div class="modal-header bg-primary bg-gradient">
                        <h5 class="modal-title text-light" id="CandidateName"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

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
                            '<option value="" selected>Select Department</option>');
                        $.each(res, function(key, value) {
                            $("#Fill_Department").append('<option value="' + value + '">' +
                                key +
                                '</option>');
                        });
                    } else {
                        $("#Fill_Department").empty();
                    }
                }
            });
        }

        function GetMRF() {
            var DepartmentId = $('#Fill_Department').val();
            $.ajax({
                type: "GET",
                url: "{{ route('getMRFByDepartment') }}?DepartmentId=" + DepartmentId,
                beforeSend: function() {

                },
                success: function(res) {

                    if (res) {
                        $("#Fill_JobCode").empty();
                        $("#Fill_JobCode").append(
                            '<option value="" selected>Select MRF</option>');
                        $.each(res, function(key, value) {
                            $("#Fill_JobCode").append('<option value="' + value + '">' +
                                key +
                                '</option>');
                        });
                    } else {
                        $("#Fill_JobCode").empty();
                    }
                }
            });
        }

        function GetCandidates() {
            $('#candidate_table').DataTable().draw(true);

        }

        $(document).on('click', '#reset', function() {
            location.reload();
        });

        function getCandidateName(JAId) {
            $.ajax({
                type: "POST",
                url: "{{ route('getCandidateName') }}?JAId=" + JAId,
                success: function(res) {
                    if (res) {
                        $("#CandidateName").html(res);
                    }
                }
            });
        }

        function EditTracker(JAId) {
            getCandidateName(JAId);
            $('#TechnicalScreenModal').modal('show');
        }

        $(document).ready(function() {

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
        });

        table = $('#candidate_table').DataTable({
            processing: true,
            serverSide: true,
            ordering: false,
            searching: false,
            lengthChange: false,
            info: true,
            destroy: true,
            ajax: {
                url: "{{ route('getTechnicalSceeningCandidate') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: function(d) {
                    d.Company = $('#Fill_Company').val();
                    d.Department = $('#Fill_Department').val();
                    d.JPId = $('#Fill_JobCode').val();


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
                    data: 'Department',
                    name: 'Department'
                },
                {
                    data: 'JobCode',
                    name: 'JobCode'
                },


                {
                    data: 'ScreenStatus',
                    name: 'ScreenStatus'
                },
                {
                    data: 'InterAtt',
                    name: 'InterAtt'
                },
                {
                    data: 'InterviewMail',
                    name: 'InterviewMail'
                },
                {
                    data: 'Action',
                    name: 'Action'
                }

            ],
        });

        $('#checkall').click(function() {
            if ($(this).prop("checked") == true) {
                $('.japchks').prop("checked", true);
            } else if ($(this).prop("checked") == false) {
                $('.japchks').prop("checked", false);
            }
        });
    </script>
@endsection
