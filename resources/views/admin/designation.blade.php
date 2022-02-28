@extends('layouts.master')
@section('title', 'Designation Master')
@section('PageContent')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Designation Master</div>
            <div class="ms-auto">
                <button class="btn btn-sm btn--red" id="syncDesignation">Sync</button>
            </div>
        </div>
        <!--end breadcrumb-->
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-condensed" id="designationtable" style="width: 100%">
                        <thead class="bg-primary text-light text-center">
                            <tr>
                                <td class="td-sm">S.No</td>
                                <td>Designation Name</td>
                                <td>Designation Code</td>
                                <td>Department</td>
                                <td>Company</td>
                                <td>Status</td>
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
        $('#designationtable').DataTable({
            processing: true,
            info: true,
            ajax: "{{ route('getAllDesignation') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'DesigName',
                    name: 'DesigName'
                },
                {
                    data: 'DesigCode',
                    name: 'DesigCode'
                },
                {
                    data: 'DepartmentCode',
                    name: 'DepartmentCode'
                },
                {
                    data: 'CompanyCode',
                    name: 'CompanyCode'
                },
                {
                    data: 'DesigStatus',
                    name: 'DesigStatus'
                }
            ],

        });

        //===================== Synchonize Company Data from ESS===================
        $(document).on('click', '#syncDesignation', function() {
            var url = '<?= route('syncDesignation') ?>';
            $('#syncDesignation').html('<i class="fa fa-spinner fa-spin"></i> Loading...');
            swal.fire({
                title: 'Are you sure?',
                html: 'Synchronize Designation Data from ESS',
                showCancelButton: true,
                showCloseButton: true,
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Yes, Synchronize',
                cancelButtonColor: '#d33',
                confirmButtonColor: '#556ee6',
                width: 400,
                allowOutsideClick: false,

            }).then(function(result) {
                if (result.value) {
                    $.post(url, function(data) {
                        if (data.status == 200) {
                            $('#syncDesignation').html('Sync');
                            $('#designationtable').DataTable().ajax.reload(null, false);
                            toastr.success(data.msg);
                        } else {
                            $('#syncDesignation').html('Sync');
                            toastr.error(data.msg);
                        }
                    }, 'json');
                }
            });
        });
    </script>
@endsection
