@extends('layouts.master')
@section('title', 'Company Master')
@section('PageContent')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Company Master</div>

            <div class="ms-auto">
                <button class="btn btn--new btn-sm" id="addCompany" data-bs-toggle="modal"
                    data-bs-target="#addCompanyModal">Add New</button>
                <button class="btn btn-sm btn--red" id="syncCompany">Sync</button>
            </div>
        </div>
        <!--end breadcrumb-->

        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-condensed" id="companytable" style="width: 100%">
                        <thead>
                            <tr>
                                <th class="th-sm">S.No</th>
                                <th>Company Name</th>
                                <th>Company Code</th>
                                <th>Address</th>
                                <th>Phone</th>
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


    <div class="modal fade" id="addCompanyModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Company</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('addCompany') }}" method="POST" id="addCompanyForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="CompanyName">Company Name</label>
                            <input type="text" class="form-control" name="CompanyName" placeholder="Enter Company Name">
                            <span class="text-danger error-text CompanyName_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="CompanyCode">Company Code</label>
                            <input type="text" class="form-control" name="CompanyCode" placeholder="Enter Company Code">
                            <span class="text-danger error-text CompanyCode_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="Address">Address</label>
                            <input type="text" class="form-control" name="Address" placeholder="Address">
                            <span class="text-danger error-text Address_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="Phone">Phone</label>
                            <input type="text" class="form-control" name="Phone" placeholder="Enter Phone Number">
                            <span class="text-danger error-text Phone_error"></span>
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
                        <button type="submit" class="btn btn-primary" id="SaveCompany">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editCompanyModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Company Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('editCompany') }}" method="POST" id="editCompanyForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="cid" />
                            <label for="editCompanyName">Company Name</label>
                            <input type="text" class="form-control" name="editCompanyName" placeholder="Enter Company Name">
                            <span class="text-danger error-text editCompanyName_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="editCompanyCode">Company Code</label>
                            <input type="text" class="form-control" name="editCompanyCode" placeholder="Enter Company Code">
                            <span class="text-danger error-text editCompanyCode_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="editAddress">Address</label>
                            <input type="text" class="form-control" name="editAddress" placeholder="Address">
                            <span class="text-danger error-text editAddress_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="editPhone">Phone</label>
                            <input type="text" class="form-control" name="editPhone" placeholder="Enter Phone Number">
                            <span class="text-danger error-text editPhone_error"></span>
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
                        <button type="submit" class="btn btn-primary" id="UpdateCompany">Update changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scriptsection')
    <script>
        $('#addCompanyForm').on('submit', function(e) {
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
                        $('#addCompanyModal').modal('hide');
                        $('#companytable').DataTable().ajax.reload(null, false);
                        toastr.success(data.msg);
                    }
                }
            });


        });

        $('#companytable').DataTable({
            processing: true,
            info: true,
            ajax: "{{ route('getAllCompanyData') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'CompanyName',
                    name: 'CompanyName'
                },
                {
                    data: 'CompanyCode',
                    name: 'CompanyCode'
                },
                {
                    data: 'Address',
                    name: 'Address',
                  
                },
                {
                    data: 'Phone',
                    name: 'Phone'
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

        //===============Get Company Record for Updation=================
        $(document).on('click', '#editBtn', function() {
            var CompanyId = $(this).data('id');
            $.post('<?= route('getCompanyDetails') ?>', {
                CompanyId: CompanyId
            }, function(data) {
                $('#editCompanyModal').find('input[name="cid"]').val(data.CompanyDetails.CompanyId);
                $('#editCompanyModal').find('input[name="editCompanyName"]').val(data.CompanyDetails
                    .CompanyName);
                $('#editCompanyModal').find('input[name="editCompanyCode"]').val(data.CompanyDetails
                    .CompanyCode);
                $('#editCompanyModal').find('input[name="editAddress"]').val(data.CompanyDetails.Address);
                $('#editCompanyModal').find('input[name="editPhone"]').val(data.CompanyDetails.Phone);
                $('#editStatus').val(data.CompanyDetails.Status);
                $('#editCompanyModal').modal('show');
            }, 'json');
        });

        //===============Update Company Details================================
        $('#editCompanyForm').on('submit', function(e) {
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
                        $('#editCompanyModal').modal('hide');
                        // $('#editCompanyForm').find(form)[0].reset();
                        $('#companytable').DataTable().ajax.reload(null, false);
                        toastr.success(data.msg);
                    }
                }
            });
        });

        // ?==============Delete Company======================//
        $(document).on('click', '#deleteBtn', function() {
            var CompanyId = $(this).data('id');
            var url = '<?= route('deleteCompany') ?>';
            swal.fire({
                title: 'Are you sure?',
                html: 'You want to <b>Delete</b> this Company',
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
                        CompanyId: CompanyId
                    }, function(data) {
                        if (data.code == 1) {
                            $('#companytable').DataTable().ajax.reload(null, false);
                            toastr.success(data.msg);

                        } else {
                            toastr.error(data.msg);
                        }
                    }, 'json');
                }
            });
        });

        //===================== Synchonize Company Data from ESS===================
        $(document).on('click','#syncCompany',function(){
            var url = '<?= route('syncCompany') ?>';
            swal.fire({
                title: 'Are you sure?',
                html: 'Synchronize Company Data from ESS',
                showCancelButton: true,
                showCloseButton: true,
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Yes, Synchronize',
                cancelButtonColor: '#d33',
                confirmButtonColor: '#556ee6',
                width: 400,
                allowOutsideClick: false

            }).then(function(result) {
                if (result.value) {
                    $.post(url, function(data) {
                        if (data.code == 1) {
                            $('#companytable').DataTable().ajax.reload(null, false);
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
