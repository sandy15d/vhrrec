@extends('layouts.master')
@section('title', 'MRF Allocated')
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
                    Campus Scr. Tracker
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
            <div class="card-body table-responsive">
                <table class="table  table-condensed align-middle text-center table-bordered table-striped"
                    id="CampusApplication" style="width: 100%; margin-right:20px;">
                    <thead class="text-center bg-primary bg-gradient text-light">
                        <tr>
                            <td>#</td>
                            <td>S.no</td>
                            <td>Reference No</td>
                            <td>Department</td>
                            <td>Designation</td>
                            <td>University</td>
                            <td>Student Name</td>
                            <td>GD Result</td>
                            <td>Test Score</td>
                            <td>Technical Screening <br>Status</td>
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
                    url: "{{ route('getCampusScreeningCandidates') }}",
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
                        data: 'ReferenceNo',
                        name: 'ReferenceNo'
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
                        data: 'University',
                        name: 'University'
                    },
                    {
                        data: 'StudentName',
                        name: 'StudentName'
                    },
                    {
                        data: 'GDResult',
                        name: 'GDResult'
                    },
                    {
                        data: 'TestScore',
                        name: 'TestScore'
                    },
                    {
                        data: 'ScreenStatus',
                        name: 'ScreenStatus'
                    },




                ],
                /* createdRow: (row, data, dataIndex, cells) => {
                    if (data['IntervStatus'] != '2nd Round Interview') {
                        $(cells[3]).css('background-color', 'gray')
                    }
                } */
            });
        });



        $(document).on('click', '.select_all', function() {
            if ($(this).prop("checked") == true) {
                $(this).closest("tr").addClass("bg-secondary bg-gradient text-light");
            } else {
                $(this).closest("tr").removeClass("bg-secondary bg-gradient text-light");
            }
        });

        function editGDRes(id) {
            $('#GDResult' + id).prop("disabled", false);
        }

        function ChngGDResult(JAId, va) {

            $.ajax({
                url: "{{ route('ChngGDResult') }}",
                type: 'POST',
                data: {
                    JAId: JAId,
                    va: va
                },
                dataType: 'json',
                beforeSend: function() {
                    $("#loader").modal('show');
                },
                success: function(data) {
                    if (data.status == 200) {
                        $("#loader").modal('hide');
                        $('#CampusApplication').DataTable().ajax.reload(null, false);
                        toastr.success(data.msg);
                    } else {
                        toastr.error(data.msg);
                    }
                }
            });
        }

        function editTestScore(id) {
            $('#TestScore' + id).prop("disabled", false);
            $('#TestScoreEdit' + id).addClass('d-none');
            $('#SaveScore' + id).removeClass('d-none');
        }

        function SaveTestScore(JAId) {
            var Score = $('#TestScore' + JAId).val();
            $.ajax({
                url: "{{ route('SaveTestScore') }}",
                type: 'POST',
                data: {
                    JAId: JAId,
                    Score: Score
                },
                dataType: 'json',
                
                success: function(data) {
                    if (data.status == 200) {
                     
                        $('#CampusApplication').DataTable().ajax.reload(null, false);
                        toastr.success(data.msg);
                    } else {
                        toastr.error(data.msg);
                    }
                }
            });
        }
        function editScreenStatus(id) {
            $('#ScreenStatus' + id).prop("disabled", false);
        }

        function ChngScreenStatus(JAId, va) {

            $.ajax({
                url: "{{ route('ChngScreenStatus') }}",
                type: 'POST',
                data: {
                    JAId: JAId,
                    va: va
                },
                dataType: 'json',
                beforeSend: function() {
                    $("#loader").modal('show');
                },
                success: function(data) {
                    if (data.status == 200) {
                        $("#loader").modal('hide');
                        $('#CampusApplication').DataTable().ajax.reload(null, false);
                        toastr.success(data.msg);
                    } else {
                        toastr.error(data.msg);
                    }
                }
            });
        }
    </script>
@endsection
