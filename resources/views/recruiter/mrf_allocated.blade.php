@extends('layouts.master')
@section('title', 'Education')
@section('PageContent')
    @php
    $company_list = DB::table('master_company')
        ->where('Status', 'A')
        ->orderBy('CompanyCode', 'desc')
        ->pluck('CompanyCode', 'CompanyId');
    @endphp
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
                        <button type="button" class="btn btn-primary btn-sm">Open MRF <span
                                class="badge bg-warning text-dark" style="font-size: 10px;">4</span>
                        </button>
                        <button class="btn btn-secondary btn-sm pull-right">Closed MRF <span
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
                        </select>
                    </div>
                    <div class="col-2">
                        <select name="Month" id="Month" class="form-select form-select-sm" onchange="GetAllocatedMrf();">
                            <option value="">Select Month</option>
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
                        <thead>
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
            ajax: {
                url: "{{ route('getAllAllocatedMRF') }}",
                data: function(d) {
                    d.status = $('#status').val(),
                        d.search = $('input[type="search"]').val()
                }
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'status',
                    name: 'status'
                },
            ]

        });

        function GetAllocatedMrf() {
            $('#MRFTable').DataTable().draw(true);
        }

        function GetDepartment() {

        }
    </script>
@endsection
