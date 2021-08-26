@extends('layouts.master')
@section('title', 'Education')
@section('PageContent')
    @php
    $company_list = DB::table('master_company')
        ->where('Status', 'A')
        ->orderBy('CompanyCode', 'desc')
        ->pluck('CompanyCode', 'CompanyId');
    $months = [1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'];

    @endphp
    <style>
        .table>:not(caption)>*>* {
            padding: 2px 1px;
        }

    </style>
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Allocated MRF Details</div>
        </div>
        <!--end breadcrumb-->
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="row mb-1">
                    <div class="col-3">
                        <button type="button" class="btn btn-primary btn-sm" id="openMrf">Open MRF <span
                                class="badge bg-warning text-dark" style="font-size: 10px;">4</span>
                        </button>
                        <button class="btn btn-secondary btn-sm pull-right" id="closedMrf">Closed MRF <span
                                class="badge bg-warning text-dark" style="font-size: 10px;">4</span></button>
                    </div>

                    <div class="col-2">
                        <select name="Company" id="Company" class="form-select form-select-sm"
                            onchange="GetAllocatedMrf(); GetDepartment();">
                            <option value="">Select Company</option>
                            @foreach ($company_list as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-2">

                        <select name="Department" id="Department" class="form-select form-select-sm"
                            onchange="GetAllocatedMrf();">
                            <option value="">Select Department</option>

                        </select>
                    </div>
                    <div class="col-2">
                        <select name="Year" id="Year" class="form-select form-select-sm" onchange="GetAllocatedMrf();">
                            <option value="">Select Year</option>
                            @for ($i = 2021; $i <= date('Y'); $i++)
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-2">
                        <select name="Month" id="Month" class="form-select form-select-sm" onchange="GetAllocatedMrf();">
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
                <hr />
                <div class="table-responsive">
                    <table class="table  table-hover table-condensed table-bordered text-center" id="MRFTable"
                        style="width: 100%">
                        <thead class="text-center">
                            <tr class="text-center">
                                <td></td>
                                <td class="th-sm">S.No</td>
                                <td>Type</td>
                                <td>JobCode</td>
                                <td>Department</td>
                                <td>Designation</td>
                                <td>Position</td>
                                <td>Location</td>
                                <td>Job Posting</td>
                                <td>View on Site</td>
                                <td>Details</td>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scriptsection')
    <script>
        $('#MRFTable').DataTable({
            processing: true,
            serverSide: true,
            info: true,
            searching: false,
            lengthChange: false,
            ajax: {
                url: "{{ route('getAllAllocatedMRF') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: function(d) {
                    d.Company = $('#Company').val(),
                    d.Department = $('#Department').val()
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
                    data: 'Type',
                    name: 'Type'
                },
                {
                    data: 'JobCode',
                    name: 'JobCode'
                },
                {
                    data: 'DepartmentCode',
                    name: 'DepartmentCode'
                },
                {
                    data: 'DesigCode',
                    name: 'DesigCode'
                },
                {
                    data: 'Positions',
                    name: 'Positions'
                },
                {
                    data: 'LocationIds',
                    name: 'LocationIds'
                },

                {
                    data: 'DepartmentCode',
                    name: 'DepartmentCode'
                },
                {
                    data: 'DepartmentCode',
                    name: 'DepartmentCode'
                },

                {
                    data: 'details',
                    name: 'details'
                }
            ],

        });

        function GetAllocatedMrf() {
            $('#MRFTable').DataTable().draw(true);
            //$('#MRFTable').DataTable().ajax.reload(null, false);
        }

        function GetDepartment() {
            var CompanyId = $('#Company').val();
            $.ajax({
                type: "GET",
                url: "{{ route('getDepartmentForRec') }}?CompanyId=" + CompanyId,
                beforeSend: function() {
                   
                },
                success: function(res) {

                    if (res) {
                        $("#Department").empty();
                        $("#Department").append(
                            '<option value="" selected disabled >Select Department</option>');
                        $.each(res, function(key, value) {
                            $("#Department").append('<option value="' + value + '">' + key +
                                '</option>');
                        });
                    } else {
                        $("#Department").empty();
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

        $(document).on('click','#reset',function(){
            window.location.reload();
        });
        $(document).on('click','#closedMrf',function(){
            GetAllocatedMrf();
        });
    </script>
@endsection
