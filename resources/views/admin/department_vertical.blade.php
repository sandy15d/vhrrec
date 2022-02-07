@extends('layouts.master')
@section('title', 'Vertical Master')
@section('PageContent')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Vertical Master</div>
            <div class="ms-auto">
                <button class="btn btn-sm btn--red" id="syncVertical">Sync</button>
            </div>
        </div>
        <!--end breadcrumb-->
        <hr />
        <div class="card  col-lg-8">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-condensed text-center" id="verticaltable" style="width: 100%">
                        <thead class="bg-primary text-light ">
                            <tr>
                                <td class="td-sm">S.No</td>
                                <td>Company</td>
                                <td>Department</td>
                                <td>Vertical Name</td>
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
        $('#verticaltable').DataTable({
            processing: true,
            info: true,
            ajax: "{{ route('getAllVertical') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
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
                    data: 'VerticalName',
                    name: 'VerticalName'
                }
            ],

        });

        //===================== Synchonize Company Data from ESS===================
        $(document).on('click', '#syncVertical', function() {
            var url = '<?= route('syncVertical') ?>';
            swal.fire({
                title: 'Are you sure?',
                html: 'Synchronize Department Vertical Data from ESS',
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
                        if (data.status==200) {
                            $('#verticaltable').DataTable().ajax.reload(null, false);
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
