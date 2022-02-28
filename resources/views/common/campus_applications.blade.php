@extends('layouts.master')
@section('title', 'Campus Applications')
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
                    Campus Applications
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
                            <td>College</td>
                            <td>JobCode</td>
                            <td>Department</td>
                            <td>Designation</td>
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
                            onclick="SendForScreening()"><i class="fas fa-long-arrow-alt-right"></i> Fwd. to Screening
                            Stage</label> &nbsp;
                    </span>

                    <span style="float:right;">↱ <label class="text-primary"><input id="checkall_date" type="checkbox"
                                name="">&nbsp;Check all <label class="text-danger"
                                style="font-size: 13px; cursor: pointer;" onclick="SetAllCampusDate()"><i
                                    class="fas fa-long-arrow-alt-right text-danger"></i> Set Date</label></label>
                    </span>


                </div>
                <table class="table table-hover table-striped table-condensed align-middle text-center table-bordered"
                    id="CandidateRecords" style="width: 100%">
                    <thead class="text-center bg-primary text-light">
                        <tr class="text-center">
                            <td>#</td>
                            <td class="th-sm">S.No</td>
                            <td>ReferenceNo</td>
                            <td class="th-sm">University</td>
                            <td class="th-sm">Roll No</td>
                            <td>Student Name</td>
                            <td>Qualification</td>
                            <td>CGPA</td>
                            <td>Mobile</td>
                           {{--  <td>Email</td> --}}
                            <td>Campus Placement Date</td>
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
                    url: "{{ route('getCampusSummary') }}",
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
                        data: 'College',
                        name: 'College'
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
                        data: 'StudentApplied',
                        name: 'StudentApplied'
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
                        $("#PostTitle").html('Student Applied For: ' + res);
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
                    url: "{{ route('getCampusCandidates') }}?JPId=" + JPId,
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
                        data: 'University',
                        name: 'University'
                    },
                    {
                        data: 'StudentId',
                        name: 'StudentId'
                    },
                    {
                        data: 'StudentName',
                        name: 'StudentName'
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

                    /* {
                        data: 'Email',
                        name: 'Email'
                    }, */
                    {
                        data: 'PlacementDate',
                        name: 'PlacementDate'
                    },


                ],
                "createdRow": function(row, data, name) {
                    if (data['Status'] == 'Selected') {
                        $(row).addClass('bg-success text-light');

                    }
                }
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



        $('#checkall_date').click(function() {
            if ($(this).prop("checked") == true) {
                $('.camcand').prop("checked", true);
            } else if ($(this).prop("checked") == false) {
                $('.camcand').prop("checked", false);
            }
        });

        

        function SetAllCampusDate() {
            var sc = [];
            $("input[name='camcand']").each(function() {
                if ($(this).prop("checked") == true) {
                    var value = $(this).val();
                    sc.push(value);
                }
            });
            if (sc.length > 0) {
                if (confirm('Are you sure to Set Campus Date for Selected Candidates?')) {
                    $.ajax({
                        url: '{{ url('SetAllCampusDate') }}',
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
