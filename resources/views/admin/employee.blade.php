@extends('layouts.master')
@section('title', 'Employee Master')
@section('PageContent')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Employee Master</div>
            <div class="ms-auto">
                <button class="btn btn-sm btn--red" id="syncEmployee">Sync</button>
            </div>
        </div>
        <!--end breadcrumb-->
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-condensed" id="employeetable" style="width: 100%">
                        <thead>
                            <tr>
                                <th class="th-sm">S.No</th>
                                <th>Employee Name</th>
                                <th>EmpCode</th>
                                <th>Company</th>
                                <th>Department</th>
                                <th>Designation</th>
                                <th>Grade</th>
                                <th>CTC</th>
                                <th>Reporting To</th>
                                <th>Status</th>
                                <th>DOJ</th>
                                <th>Date of Sepration</th>
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
        $('#employeetable').DataTable({
            processing: true,
            info: true,
            ajax: "{{ route('getAllEmployeeData') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'fullname',
                    name: 'fullname'
                },
                {
                    data: 'EmpCode',
                    name: 'EmpCode'
                },
                {
                    data: 'CompanyId',
                    name: 'CompanyId'
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
                    data: 'GradeId',
                    name: 'GradeId'
                },
                {
                    data: 'CTC',
                    name: 'CTC'
                },
                {
                    data: 'RepEmployeeID',
                    name: 'RepEmployeeID'
                },
                {
                    data: 'EmpStatus',
                    name: 'EmpStatus'
                },
                {
                    data: 'DOJ',
                    name: 'DOJ'
                },
                {
                    data: 'DateOfSepration',
                    name: 'DateOfSepration'
                }

            ],

        });

        //===================== Synchonize Company Data from ESS===================
        $(document).on('click', '#syncEmployee', function() {
            var url = '<?= route('syncEmployee') ?>';
            swal.fire({
                title: 'Are you sure?',
                html: 'Synchronize Employee Data from ESS',
                showCancelButton: true,
                showCloseButton: true,
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Yes, Synchronize',
                cancelButtonColor: '#d33',
                confirmButtonColor: '#556ee6',
                width: 400,
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                },

            }).then(function(result) {
                if (result.value) {
                    $.post(url, function(data) {
                        if (data.code == 1) {
                            $('#employeetable').DataTable().ajax.reload(null, false);
                            toastr.success(data.msg);

                        } else {
                            toastr.error(data.msg);
                        }
                    }, 'json');
                }
            });
        });
    </script>
@endsection
