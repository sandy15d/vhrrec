@extends('layouts.master')
@section('title', 'Headquarter Master')
@section('PageContent')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Headquarter Master</div>
            <div class="ms-auto">
                <button class="btn btn-sm btn--red" id="syncHeadquarter">Sync</button>
            </div>
        </div>
        <!--end breadcrumb-->
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-condensed" id="headquartertable" style="width: 100%">
                        <thead class="bg-primary text-light text-center">
                            <tr>
                                <td class="td-sm">S.No</td>
                                <td>Headquarter</td>
                                <td>State</td>
                                <td>Company</td>
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
        $('#headquartertable').DataTable({
            processing: true,
            info: true,
            ajax: "{{ route('getAllHeadquarter') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'HqName',
                    name: 'HqName'
                },
                {
                    data: 'StateName',
                    name: 'StateName'
                },
                {
                    data: 'CompanyCode',
                    name: 'CompanyCode'
                }
            ],

        });

        //===================== Synchonize Company Data from ESS===================
        $(document).on('click', '#syncHeadquarter', function() {
            var url = '<?= route('syncHeadquarter') ?>';
            swal.fire({
                title: 'Are you sure?',
                html: 'Synchronize Headquaeter Data from ESS',
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
                            $('#headquartertable').DataTable().ajax.reload(null, false);
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
