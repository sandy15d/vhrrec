@extends('layouts.master')
@section('title', 'MRF Details')
@section('PageContent')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">MRF Details</div>
        </div>
        <!--end breadcrumb-->
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="row mb-1">
                    <div class="col-2"></div>
                    <div class="col-2">
                        <select name="Department" id="Department" class="form-select form-select-sm">
                            <option value="">Select Department</option>
                        </select>
                    </div>
                    <div class="col-2">
                        <select name="Year" id="Year" class="form-select form-select-sm">
                            <option value="">Select Year</option>
                        </select>
                    </div>
                    <div class="col-2">
                        <select name="Month" id="Month" class="form-select form-select-sm">
                            <option value="">Select Month</option>
                        </select>
                    </div>
                    <div class="col-2">
                        <button type="reset" class="btn btn-danger btn-sm"><i class="bx bx-refresh"></i></button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover table-condensed " id="MRFTable" style="width: 100%">
                        <thead>
                            <tr>
                                <td class="th-sm">S.No</td>
                                <td>Type</td>
                                <td>JobCode</td>
                                <td>Department</td>
                                <td>Designation</td>
                                <td>Position</td>
                                <td>Location</td>
                                <td>MRF Date</td>
                                <td>Created By</td>
                                <td>Status</td>
                                <td>Allocated Task to</td>
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
        $(document).ready(function() {

            $('#MRFTable').DataTable({
                processing: true,
                info: true,
                ajax: "{{ route('getAllMRF') }}",
                columns: [{
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
                        data: 'DepartmentId',
                        name: 'DepartmentId'
                    },
                    {
                        data: 'DesigId',
                        name: 'DesigId'
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
                        data: 'MRFDate',
                        name: 'MRFDate'
                    },
                    {
                        data: 'CreatedBy',
                        name: 'CreatedBy'
                    },
                    {
                        data: 'Status',
                        name: 'Status'
                    },
                    {
                        data: '',
                        name: ''
                    },
                    {
                        data: '',
                        name: ''
                    }

                ],

            });
        });

        function editmstst(MRFId, th) {

            $('#mrfstatus' + MRFId).prop('disabled', false);

            $(th).hide(500);



        }
    </script>

@endsection
