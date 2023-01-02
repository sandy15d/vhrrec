@extends('layouts.master')
@section('title', 'Trainee Applications')
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

    </style>
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb  align-items-center mb-3">
            <div class="row mb-1">
                <div class="col-3 breadcrumb-title ">
                    SIP/Trainee Applications
                </div>
                <div class="col-2">
                    <select name="Fill_Company" id="Fill_Company" class="form-select form-select-sm"
                        onchange="GetCampusRecords(); GetDepartment();">
                        <option value="">Select Company</option>
                        @foreach ($company_list as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-2">

                    <select name="Fill_Department" id="Fill_Department" class="form-select form-select-sm"
                        onchange="GetCampusRecords();">
                        <option value="">Select Department</option>

                    </select>
                </div>
                <div class="col-2">
                    <select name="Year" id="Year" class="form-select form-select-sm" onchange="GetCampusRecords();">
                        <option value="">Select Year</option>
                        @for ($i = 2021; $i <= date('Y'); $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-2">
                    <select name="Month" id="Month" class="form-select form-select-sm" onchange="GetCampusRecords();">
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
                    id="CampusApplication" style="width: 100%">
                    <thead class="text-center bg-primary text-light">
                        <tr class="text-center">
                            <td>#</td>
                            <td class="th-sm">S.No</td>
                            <td>JobCode</td>
                            <td>Department</td>
                        
                            <td>Student Applied</td>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card d-none border-top border-0 border-4 border-primary" id="CandidateDiv">
            <div class="card-body">
                <h5 class=" text-primary" id="PostTitle"></h5>
                <div class=" bg-white  shadow-sm rounded stickThis " style="font-size: 14px;">
                    &nbsp;<span style="font-weight: bold;">↱</span>&nbsp;
                    <label class="text-primary"><input id="checkall" type="checkbox" name="">&nbsp;Check all</label>
                    <i class="text-muted" style="font-size: 13px;">With selected:</i> 
                    <span class="d-inline">
                        <label class="text-primary" style="font-size: 13px; cursor: pointer;"
                        data-bs-toggle="modal"
                        data-bs-target="#TechScreeningModal"  ><i class="fas fa-long-arrow-alt-right"></i> Fwd. to Screening
                            Stage</label> &nbsp;
                    </span>

                </div>
                <table class="table table-hover table-striped table-condensed align-middle text-center table-bordered"
                    id="CandidateRecords" style="width: 100%">
                    <thead class="text-center bg-primary text-light">
                        <tr class="text-center">
                            <td>#</td>
                            <td class="th-sm">S.No</td>
                            <td>ReferenceNo</td>
                            <td>Candidate Name</td>
                            <td>Qualification</td>
                            <td>CGPA</td>
                            <td>Mobile</td>
                            <td>Email</td>
                         
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
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

        function GetCampusRecords() {
            $('#CampusApplication').DataTable().draw(true);

        }

        $(document).on('click', '#reset', function() {
            location.reload();
        });

        $(document).ready(function() {
            $('#CampusApplication').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                searching: false,
                lengthChange: false,
                info: true,
                ajax: {
                    url: "{{ route('getTraineeSummary') }}",
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
                        data: 'TraineeApplied',
                        name: 'TraineeApplied'
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
                        $("#PostTitle").html('Candidate Applied For: ' + res);
                    }
                }
            });
        }

        function getCandidate(JPId) {

            $('#CandidateDiv').removeClass('d-none');
            var JPId = JPId;
            getPostTitle(JPId);
            $('#CandidateRecords').DataTable({
                processing: true,
                serverSide: true,
                info: true,
                searching: false,
                ordering: false,
                //  dom: 'Bfrtip', //enable 
                lengthChange: false,
                destroy: true,
                buttons: [

                    {
                        extend: 'copyHtml5',
                        text: '<i class="fa fa-files-o"></i>',
                        titleAttr: 'Copy',
                        title: $('.download_label').html(),
                        exportOptions: {
                            columns: ':visible'
                        }
                    },

                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel-o"></i>',
                        titleAttr: 'Excel',
                        title: $('.download_label').html(),
                        exportOptions: {
                            columns: ':visible'

                        }
                    },

                    {
                        extend: 'csvHtml5',
                        text: '<i class="fa fa-file-text-o"></i>',
                        titleAttr: 'CSV',
                        title: $('.download_label').html(),
                        exportOptions: {
                            columns: ':visible'
                        }
                    },

                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fa fa-file-pdf-o"></i>',
                        titleAttr: 'PDF',
                        orientation: 'landscape',
                        title: $('.download_label').html(),
                        exportOptions: {
                            columns: ':visible',


                        }
                    },

                    {
                        extend: 'print',
                        text: '<i class="fa fa-print"></i>',
                        titleAttr: 'Print',
                        title: $('.download_label').html(),
                        customize: function(win) {
                            $(win.document.body)
                                .css('font-size', '10pt');

                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        },
                        exportOptions: {
                            columns: ':visible'
                        }
                    },

                    {
                        extend: 'colvis',
                        text: '<i class="fa fa-columns"></i>',
                        titleAttr: 'Columns',
                        title: $('.download_label').html(),
                        postfixButtons: ['colvisRestore']
                    },
                ],

                ajax: {
                    url: "{{ route('getTraieeCandidates') }}?JPId=" + JPId,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
                        data: 'ReferenceNo',
                        name: 'ReferenceNo'
                    },
                  
                    {
                        data: 'CandidateName',
                        name: 'CandidateName'
                    },
                    {
                        data: 'Qualification',
                        name: 'Qualification'
                    },
                    {
                        data: 'CGPA',
                        name: 'CGPA'
                    },
                    {
                        data: 'Phone',
                        name: 'Phone'
                    },

                    {
                        data: 'Email',
                        name: 'Email'
                    }
                  


                ]
            });
        }

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

        $(document).on('click', '#SendForTechSceenBtn', function() {
            var TId = [];
            var ScreeningBy = $('#ScreeningBy').val();
            $("input[name='selectCand']").each(function() {
                if ($(this).prop("checked") == true) {
                    var value = $(this).val();
                    TId.push(value);
                }
            });
            if (TId.length > 0) {
                if (confirm('Are you sure to Send Selected Candidates to Screening Stage?')) {
                    $.ajax({
                        url: '{{ url('SendTraineeForScreening') }}',
                        method: 'POST',
                        data: {
                            TId: TId,
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
    </script>
@endsection
