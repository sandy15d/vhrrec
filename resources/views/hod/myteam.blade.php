@extends('layouts.master')
@section('title', 'My Team')
@section('PageContent')
<style>
    .table>:not(caption)>*>* {
        padding: 2px 1px;
    }

</style>
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">My Team Details</div>
    </div>
    <!--end breadcrumb-->
    <hr />
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover display compact" id="myteamtable" style="width: 100%">
                    <thead>
                        <tr>
                            <th class="th-sm">S.No</th>
                            <th class="th-sm">EmpCode</th>
                            <th>Name</th>
                            <th>Company</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Grade</th>
                            <th>HQ</th>
                            <th>Rep.Manager</th>
                            <th>Status</th>
                            <th>Position</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card d-none" id="teamdiv">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover display compact" id="myteamtable1" style="width: 100%">
                    <thead>
                        <tr>
                            <th class="th-sm">S.No</th>
                            <th class="th-sm">EmpCode</th>
                            <th>Name</th>
                            <th>Company</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Grade</th>
                            <th>HQ</th>
                            <th>Rep.Manager</th>
                            <th>Status</th>
                            <th>Position</th>
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
    $('#myteamtable').DataTable({
        processing: true,
        info: true,
        ajax: "{{ route('getAllMyTeamMember') }}",
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'EmpCode',
                name: 'EmpCode'

            },
            {
                data: 'fullname',
                name: 'fullname'
            },

            {
                data: 'CompanyCode',
                name: 'CompanyCode'
            },
            {
                data: 'DepartmentCode',
                name: 'DepartmentCode'
            },
            {
                data: 'DesigName',
                name: 'DesigName'
            },
            {
                data: 'GradeValue',
                name: 'GradeValue'
            },
            {
                data: 'HqName',
                name: 'HqName'
            },
            {
                data: 'Reporting',
                name: 'Reporting'
            },
            {
                data: 'Status',
                name: 'Status'
            },
            {
                data: 'MStatus',
                name: 'MStatus'
            }

        ],
        "createdRow": function(row, data, name) {
            if (data['Status'] == 'Resigned') {
                $(row).addClass('bg-danger text-light');
            
            }
        }

    });

    $(document).on('click', '.addRepMRF', function() {
        var EmployeeID = $(this).data('id');
        window.location.href ="{{route('repmrf')}}?ei="+EmployeeID;
    });


    $(document).on('click', '.getMyTeam', function() {
        var EmployeeID = $(this).data('id');
        getMyTeam(EmployeeID);
    });

    function getMyTeam(EmployeeID) {
     
        $('#teamdiv').removeClass('d-none');
        $('#myteamtable1').DataTable({
            processing: true,
            info: true,
            searching: false,
            lengthChange: false,
            destroy: true,

            ajax: {
                url: "{{ route('getMyTeam') }}",
                type: "POST",
                data: {
                    EmployeeID: EmployeeID
                },
                dataType: "JSON",

            },
            columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'EmpCode',
                name: 'EmpCode'

            },
            {
                data: 'fullname',
                name: 'fullname'
            },

            {
                data: 'CompanyCode',
                name: 'CompanyCode'
            },
            {
                data: 'DepartmentCode',
                name: 'DepartmentCode'
            },
            {
                data: 'DesigName',
                name: 'DesigName'
            },
            {
                data: 'GradeValue',
                name: 'GradeValue'
            },
            {
                data: 'HqName',
                name: 'HqName'
            },
            {
                data: 'Reporting',
                name: 'Reporting'
            },
            {
                data: 'Status',
                name: 'Status'
            },
            {
                data: 'MStatus',
                name: 'MStatus'
            }
            ],
            "createdRow": function(row, data, name) {
            if (data['Status'] == 'Resigned') {
                $(row).addClass('bg-danger text-light');
            
            }
        }
        });
    }
</script>
@endsection
