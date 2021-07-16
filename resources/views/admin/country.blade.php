@extends('layouts.master')
@section('title', 'Country Master')
@section('PageContent')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Country Master</div>

            <div class="ms-auto">
                <button class="btn btn--new btn-sm" id="addCountry" data-bs-toggle="modal"
                    data-bs-target="#addCountryModal">Add New</button>
                <button class="btn btn-sm btn--red" id="syncCountry">Sync</button>
            </div>
        </div>
        <!--end breadcrumb-->

        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-condensed" id="Countrytable" style="width: 100%">
                        <thead>
                            <tr>
                                <th class="th-sm">S.No</th>
                                <th>Country Name</th>
                                <th>Country Code</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="addCountryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Country</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('addCountry') }}" method="POST" id="addCountryForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="CountryName">Country Name</label>
                            <input type="text" class="form-control" name="CountryName" placeholder="Enter Country Name">
                            <span class="text-danger error-text CountryName_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="CountryCode">Country Code</label>
                            <input type="text" class="form-control" name="CountryCode" placeholder="Enter Country Code">
                            <span class="text-danger error-text CountryCode_error"></span>
                        </div>
                  
                        <div class="form-group">
                            <label for="Status">Status</label>
                            <select name="Status" class="form-control form-select">
                                <option value="A">Active</option>
                                <option value="D">Deactive</option>
                            </select>
                            <span class="text-danger error-text Status_error"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="SaveCountry">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editCountryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Country Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('editCountry') }}" method="POST" id="editCountryForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="cid" />
                            <label for="editCountryName">Country Name</label>
                            <input type="text" class="form-control" name="editCountryName" placeholder="Enter Country Name">
                            <span class="text-danger error-text editCountryName_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="editCountryCode">Country Code</label>
                            <input type="text" class="form-control" name="editCountryCode" placeholder="Enter Country Code">
                            <span class="text-danger error-text editCountryCode_error"></span>
                        </div>
                  
                        <div class="form-group">
                            <label for="editStatus">Status</label>
                            <select name="editStatus" id="editStatus" class="form-control form-select">
                                <option value="A">Active</option>
                                <option value="D">Deactive</option>
                            </select>
                            <span class="text-danger error-text editStatus_error"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="UpdateCountry">Update changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scriptsection')
    <script>
        $('#addCountryForm').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {
                    $(form).find('span.error-text').text('');
                },
                success: function(data) {
                    if (data.code == 0) {
                        $.each(data.error, function(prefix, val) {
                            $(form).find('span.' + prefix + '_error').text(val[0]);
                        });
                    } else {
                        $(form)[0].reset();
                        $('#addCountryModal').modal('hide');
                        $('#Countrytable').DataTable().ajax.reload(null, false);
                        toastr.success(data.msg);
                    }
                }
            });


        });

        $('#Countrytable').DataTable({
            processing: true,
            info: true,
            ajax: "{{ route('getAllCountryData') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'CountryName',
                    name: 'CountryName'
                },
                {
                    data: 'CountryCode',
                    name: 'CountryCode'
                },
                {
                    data: 'Status',
                    name: 'Status'
                },
                {
                    data: 'actions',
                    name: 'actions'
                },
            ],
            
        });

        //===============Get Country Record for Updation=================
        $(document).on('click', '#editBtn', function() {
            var CountryId = $(this).data('id');
            $.post('<?= route('getCountryDetails') ?>', {
                CountryId: CountryId
            }, function(data) {
                $('#editCountryModal').find('input[name="cid"]').val(data.CountryDetails.CountryId);
                $('#editCountryModal').find('input[name="editCountryName"]').val(data.CountryDetails
                    .CountryName);
                $('#editCountryModal').find('input[name="editCountryCode"]').val(data.CountryDetails
                    .CountryCode);
                $('#editStatus').val(data.CountryDetails.Status);
                $('#editCountryModal').modal('show');
            }, 'json');
        });

        //===============Update Country Details================================
        $('#editCountryForm').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {
                    $(form).find('span.error-text').text('');
                },
                success: function(data) {
                    if (data.code == 0) {
                        $.each(data.error, function(prefix, val) {
                            $(form).find('span.' + prefix + '_error').text(val[0]);
                        });
                    } else {
                        $('#editCountryModal').modal('hide');
                        // $('#editCountryForm').find(form)[0].reset();
                        $('#Countrytable').DataTable().ajax.reload(null, false);
                        toastr.success(data.msg);
                    }
                }
            });
        });

        // ?==============Delete Country======================//
        $(document).on('click', '#deleteBtn', function() {
            var CountryId = $(this).data('id');
            var url = '<?= route('deleteCountry') ?>';
            swal.fire({
                title: 'Are you sure?',
                html: 'You want to <b>Delete</b> this Country',
                showCancelButton: true,
                showCloseButton: true,
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Yes, Delete',
                cancelButtonColor: '#d33',
                confirmButtonColor: '#556ee6',
                width: 400,
                allowOutsideClick: false

            }).then(function(result) {
                if (result.value) {
                    $.post(url, {
                        CountryId: CountryId
                    }, function(data) {
                        if (data.code == 1) {
                            $('#Countrytable').DataTable().ajax.reload(null, false);
                            toastr.success(data.msg);

                        } else {
                            toastr.error(data.msg);
                        }
                    }, 'json');
                }
            });
        });

        //===================== Synchonize Country Data from ESS===================
        $(document).on('click','#syncCountry',function(){
            var url = '<?= route('syncCountry') ?>';
            swal.fire({
                title: 'Are you sure?',
                html: 'Synchronize Country Data from ESS',
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
                            $('#Countrytable').DataTable().ajax.reload(null, false);
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
