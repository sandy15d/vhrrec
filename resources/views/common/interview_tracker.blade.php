@extends('layouts.master')
@section('title', 'Interview Tracker')
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
                    Interview Tracker
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

        <div class="card border-top border-0 border-4 border-primary">
            <div class="card-body table-responsive">
                <table class="table table-condensed text-center" id="candidate_table"
                    style="width: 100%; margin-right:20px; ">
                    <thead class="text-center bg-primary bg-gradient text-light">
                        <tr class="text-center">
                            <th style="width:30px;" rowspan="2"></th>
                            {{-- <td rowspan="2">#</td> --}}
                            <td rowspan="2">S.no</td>
                            <td rowspan="2">Ref.No</td>
                            <td rowspan="2">Candidate</td>
                            <td rowspan="2">Department</td>
                            <td rowspan="2">MRF</td>
                            <td colspan="2" class="text-center" style="padding-right: 0px">Interview</td>
                            <td colspan="2" class="text-center" style="padding-right: 0px">2nd Round<br> Interview</td>
                            <td colspan="3" style="text-align: center;padding-right: 0px">Selected for</td>
                        </tr>
                        <tr class="text-center">

                            <td style="text-align: center">Interview <br>Status</td>
                            <td>Edit</td>
                            <td>Interview<br> Status</td>
                            <td>Edit</td>
                            <td>Company</td>
                            <td>Department</td>
                            <td>Edit</td>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- The Modal -->
    <div class="modal fade" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-info bg-gradient">
                    <h6 class="modal-title text-white" id="candidatename"></h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('first_round_interview') }}" method="POST" id="first_interview_form">
                    @csrf
                    <div class="modal-body">
                        <table>
                            <tr>
                                <td style="width: 50%">Interview Status</td>
                                <td style="width: 50%">
                                    <input type="hidden" name="ScId" id="ScId">
                                    <select name="IntervStatus" id="IntervStatus" class="form-select form-select-sm">
                                        <option value=""></option>
                                        <option value="Selected">Selected</option>
                                        <option value="Rejected">Rejected</option>
                                        <option value="On Hold">On Hold</option>
                                        <option value="2nd Round Interview">2nd Round Interview</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- The 2nd Interview Modal -->
    <div class="modal fade" id="2ndInterviewModal" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-info bg-gradient">
                    <h6 class="modal-title text-white" id="candidatename1"></h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('second_round_interview') }}" method="POST" id="second_interview_form">
                    @csrf
                    <div class="modal-body">
                        <table class="table table-borderless">
                            <tr>
                                <td>Date of Interview</td>
                                <td>
                                    <input type="hidden" name="ScId_2nd" id="ScId_2nd">
                                    <input type="date" name="IntervDt2" id="IntervDt2"
                                        class="form-control form-control-sm frminp">
                                </td>
                            </tr>
                            <tr>
                                <td>Interview Location</td>
                                <td>
                                    <input type="text" name="IntervLoc2" id="IntervLoc2"
                                        class="form-control form-control-sm frminp">
                                </td>
                            </tr>
                            <tr>
                                <td>Interview Panel Members</td>
                                <td>
                                    <textarea name="IntervPanel2" id="IntervPanel2" cols="10" rows="3"
                                        class="form-control form-control-sm"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>Interview Status</td>
                                <td>
                                    <select name="IntervStatus2" id="IntervStatus2" class="form-select form-select-sm">
                                        <option value=""></option>
                                        <option value="Selected">Selected</option>
                                        <option value="Rejected">Rejected</option>
                                        <option value="On Hold">On Hold</option>
                                    </select>
                                </td>
                            </tr>
                        </table>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="companyModal" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-info bg-gradient">
                    <h6 class="modal-title text-white" id="candidatename_company"></h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('select_cmp_dpt_for_candidate') }}" method="POST" id="cmp_dpt_form">
                    @csrf
                    <div class="modal-body">
                        <table class="table table-borderless">
                            <tr>
                                <td>Company</td>
                                <td>
                                    <input type="hidden" name="ScId_cmp" id="ScId_cmp">
                                    <select name="SelectedForC" id="SelectedForC" class="form-select form-select-sm"
                                        onchange="GetDepartment1();">
                                        <option value="">Select Company</option>
                                        @foreach ($company_list as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Department</td>
                                <td>
                                    <select name="SelectedForD" id="SelectedForD"
                                        class="form-select form-select-sm"></select>
                                </td>
                            </tr>

                        </table>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="intervcostmodal" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-info bg-gradient">
                    <h6 class="modal-title text-white">Interview Cost</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('update_interview_cost') }}" method="POST" id="interview_cost_form">
                    @csrf
                    <div class="modal-body">
                        <table class="table table-borderless">
                            <tr>
                                <td>Travel:</td>
                                <td>
                                    <input type="hidden" name="IntervCost_JAId" id="IntervCost_JAId">
                                    <input type="text" name="Travel" id="Travel" class="form-control form-control-sm">
                                </td>
                            </tr>
                            <tr>
                                <td>Lodging</td>
                                <td>
                                    <input type="text" name="Lodging" id="Lodging" class="form-control form-control-sm">
                                </td>
                            </tr>
                            <tr>
                                <td>Relocation</td>
                                <td>
                                    <input type="text" name="Relocation" id="Relocation"
                                        class="form-control form-control-sm">
                                </td>
                            </tr>
                            <tr>
                                <td>Other</td>
                                <td>
                                    <input type="text" name="Other" id="Other" class="form-control form-control-sm">
                                </td>
                            </tr>

                        </table>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
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

        }

        function GetDepartment1() { // for Interview Department Selection
            var CompanyId = $('#SelectedForC').val();
            $.ajax({
                type: "GET",
                url: "{{ route('getDepartment') }}?CompanyId=" + CompanyId,
                beforeSend: function() {

                },
                success: function(res) {

                    if (res) {
                        $("#SelectedForD").empty();
                        $("#SelectedForD").append(
                            '<option value="" selected disabled >Select Department</option>');
                        $.each(res, function(key, value) {
                            $("#SelectedForD").append('<option value="' + value + '">' + key +
                                '</option>');
                        });
                    } else {
                        $("#SelectedForD").empty();
                    }
                }
            });
        }

        function GetCampusRecords() {
            $('#candidate_table').DataTable().draw(true);

        }

        $(document).on('click', '#reset', function() {
            location.reload();
        });

        $(document).ready(function() {


            function format(d) {
                x = '';
                x = x +
                    '<table class="table" style="background-color:">' +
                    '<tr><td colspan="8" class="fw-bold">1st Interview</td></tr>' +
                    '<tr>' +
                    '<td style="text-align:left;">Interview Date:</td>' +
                    '<td style="text-align:left;">' + d.IntervDt.split("-").reverse().join("-") +
                    '</td>' +
                    '<td style="text-align:left;">Location:</td>' +
                    '<td style="text-align:left;">' + d.IntervLoc + '</td>' +
                    '<td style="text-align:left;">Panel Member</td>' +
                    '<td style="text-align:left;" colspan="3">' + d.IntervPanel + '</td>' +
                    '</tr>';

                if (d.IntervStatus == '2nd Round Interview') {
                    x = x + '<tr><td colspan="8" class="fw-bold">2nd Round Interview</td></tr>' +
                        '<tr>' +
                        '<td style="text-align:left;">Interview Date:</td>' +
                        '<td style="text-align:left;">' + d.IntervDt2.split("-").reverse().join("-") +
                        '</td>' +
                        '<td style="text-align:left;">Location:</td>' +
                        '<td style="text-align:left;">' + d.IntervLoc2 + '</td>' +
                        '<td style="text-align:left;">Panel Member</td>' +
                        '<td style="text-align:left;" colspan="3">' + d.IntervPanel2 + '</td>' +
                        '</tr>';
                }

                x = x +
                    '<tr><td colspan="8" class="fw-bold">Interview Cost <i class="fa fa-pencil text-primary" onclick="editIntervCost(' +
                    d.JAId + ')" style="cursor:pointer"></i></td></tr>' +
                    '<tr>' +
                    '<td style="text-align:left;">Travel:</td>' +
                    '<td style="text-align:left;">' + d.Travel +
                    '</td>' +
                    '<td style="text-align:left;">Lodging:</td>' +
                    '<td style="text-align:left;">' + d.Lodging + '</td>' +
                    '<td style="text-align:left;">Relocation</td>' +
                    '<td style="text-align:left;">' + d.Relocation + '</td>' +
                    '<td style="text-align:left;">Other</td>' +
                    '<td style="text-align:left;">' + d.Other + '</td>' +
                    '</tr>';
                x = x + '</table>';
                return x;
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


            table = $('#candidate_table').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                searching: false,
                lengthChange: false,
                info: true,
                ajax: {
                    url: "{{ route('getInterviewTrackerCandidate') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function(d) {
                        d.Company = $('#Fill_Company').val();
                        d.Department = $('#Fill_Department').val();

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
                    /*  {
                         data: 'chk',
                         name: 'chk'
                     }, */
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
                        data: 'IntervStatus',
                        name: 'IntervStatus'
                    },
                    {
                        data: 'IntervEdit',
                        name: 'IntervEdit'
                    },

                    {
                        data: 'IntervStatus2',
                        name: 'IntervStatus2'
                    },
                    {
                        data: 'IntervEdit2',
                        name: 'IntervEdit2'
                    },

                    {
                        data: 'SelectedForC',
                        name: 'SelectedForC'
                    },
                    {
                        data: 'SelectedForD',
                        name: 'SelectedForD'
                    },
                    {
                        data: 'CompanyEdit',
                        name: 'CompanyEdit'
                    },

                ],

                createdRow: (row, data, dataIndex, cells) => {
                    if (data['IntervStatus'] == 'Selected' || data['IntervStatus'] == null) {

                        $(cells[8]).css('background-color', 'rgb(218 209 237)')
                        $(cells[9]).css('background-color', 'rgb(218 209 237)')
                    }
                }

            });
        });

        $(document).on('click', '.select_all', function() {
            if ($(this).prop("checked") == true) {
                $(this).closest("tr").addClass("bg-secondary bg-gradient text-light");
            } else {
                $(this).closest("tr").removeClass("bg-secondary bg-gradient text-light");
            }
        });

        function editInt(JAId, ScId) {
            getCandidateName(JAId);
            $('#ScId').val(ScId);
            $('#myModal').modal('show');
        }

        function editInt_2nd(JAId, ScId) {
            getCandidateName(JAId);
            $('#ScId_2nd').val(ScId);
            $('#2ndInterviewModal').modal('show');
        }

        function editCompany(JAId, ScId) {
            getCandidateName(JAId);
            $('#ScId_cmp').val(ScId);
            $('#companyModal').modal('show');
        }

        function getCandidateName(JAId) {
            $.ajax({
                type: "POST",
                url: "{{ route('getCandidateName') }}?JAId=" + JAId,
                success: function(res) {
                    if (res) {
                        $("#candidatename").html('1st Round Interview Edit (' + res + ' )');
                        $("#candidatename1").html('2nd Round Interview Edit (' + res + ' )');
                        $("#candidatename_company").html('Selection for (' + res + ' )');
                    }
                }
            });
        }

        $('#first_interview_form').on('submit', function(e) {
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

                },
                success: function(data) {
                    if (data.status == 400) {
                        $.each(data.error, function(prefix, val) {
                            $(form).find('span.' + prefix + '_error').text(val[0]);
                        });
                    } else {
                        $(form)[0].reset();
                        $('#myModal').modal('hide');
                        $('#candidate_table').DataTable().ajax.reload(null, false);
                        toastr.success(data.msg);
                    }
                }
            });
        });

        $('#second_interview_form').on('submit', function(e) {
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

                },
                success: function(data) {
                    if (data.status == 400) {
                        $.each(data.error, function(prefix, val) {
                            $(form).find('span.' + prefix + '_error').text(val[0]);
                        });
                    } else {
                        $(form)[0].reset();
                        $('#2ndInterviewModal').modal('hide');
                        $('#candidate_table').DataTable().ajax.reload(null, false);
                        toastr.success(data.msg);
                    }
                }
            });
        });

        $('#cmp_dpt_form').on('submit', function(e) {
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

                },
                success: function(data) {
                    if (data.status == 400) {
                        $.each(data.error, function(prefix, val) {
                            $(form).find('span.' + prefix + '_error').text(val[0]);
                        });
                    } else {
                        $(form)[0].reset();
                        $('#companyModal').modal('hide');
                        $('#candidate_table').DataTable().ajax.reload(null, false);
                        toastr.success(data.msg);
                    }
                }
            });
        });

        function editIntervCost(JAId) {
            var JAId = JAId;
            $("#IntervCost_JAId").val(JAId);
            $.ajax({
                type: "POST",
                url: "{{ route('get_interview_cost') }}?JAId=" + JAId,
                success: function(res) {

                    $("#Travel").val(res.data.Travel);
                    $("#Relocation").val(res.data.Relocation);
                    $("#Lodging").val(res.data.Lodging);
                    $("#Other").val(res.data.Other);

                }
            });
            $('#intervcostmodal').modal('show');

        }

        $('#interview_cost_form').on('submit', function(e) {
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
                        $(form)[0].reset();
                        $('#intervcostmodal').modal('hide');
                        $('#candidate_table').DataTable().ajax.reload(null, false);
                        toastr.success(data.msg);
                    }
                }
            });
        });

        $('#intervcostmodal').on('hidden.bs.modal', function() {
            $('#intervcostmodal form')[0].reset();
        });
    </script>
@endsection
