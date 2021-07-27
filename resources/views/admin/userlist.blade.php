@extends('layouts.master')
@section('title', 'User Master')
@section('PageContent')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">User Master</div>
            <div class="ms-auto">
                <button class="btn btn--new btn-sm" id="addUser" data-bs-toggle="modal" data-bs-target="#addUserModal">Add
                    New</button>
            </div>
        </div>
        <!--end breadcrumb-->
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-condensed" id="UserTable" style="width: 100%">
                        <thead>
                            <tr>
                                <th class="th-sm">S.No</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>User Type</th>
                                <th>Contact</th>
                                <th>Email</th>
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


    <div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('addUser') }}" method="POST" id="addUserForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="Company">Company</label>
                                    <select id="Company" name="Company" class="form-select">
                                        <option value="" selected disabled>Select Company</option>
                                        @foreach ($company_list as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error-text Company_error"></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="Employee">Name</label>
                                    <select name="Employee" id="Employee" class="form-control form-select">
                                        <option value="" selected disabled>Select Employee</option>

                                    </select>
                                    <span class="text-danger error-text Employee_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="Username">Username</label>
                                    <input type="text" class="form-control" id="Username" name="Username">
                                    <span class="text-danger error-text Username_error"></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="Password">Password</label>
                                    <input type="text" class="form-control" id="Password" name="Password">
                                    <span class="text-danger error-text Password_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="UserType">User Type</label>
                                    <select name="UserType" class="form-control form-select">
                                        <option value="" disabled selected>Select</option>
                                        <option value="H">Employee</option>
                                        <option value="R">Recruiter</option>
                                    </select>
                                    <span class="text-danger error-text UserType_error"></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="Contact">Contact</label>
                                    <input type="text" class="form-control" id="Contact" name="Contact" readonly>
                                    <span class="text-danger error-text Contact_error"></span>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="Email">Email</label>
                                    <input type="text" class="form-control" id="Email" name="Email" readonly>
                                    <span class="text-danger error-text Email_error"></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="Status">Status</label>
                                    <select name="Status" class="form-control form-select">
                                        <option value="A">Active</option>
                                        <option value="D">Deactive</option>
                                    </select>
                                    <span class="text-danger error-text Status_error"></span>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="SaveState">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

@section('scriptsection')
    <script>
        $('#Company').change(function() {
            var CompanyId = $(this).val();
            if (CompanyId) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('getEmployee') }}?CompanyId=" + CompanyId,

                    success: function(res) {
                        console.log(res);
                        if (res) {
                            $("#Employee").empty();
                            $("#Employee").append('<option>Select Employee</option>');
                            $.each(res, function(key, value) {
                                $("#Employee").append('<option value="' + key + '">' + value +
                                    '</option>');
                            });

                        } else {
                            $("#Employee").empty();
                        }
                    }
                });
            } else {
                $("#Employee").empty();

            }
        });


        //=================================//
        $(document).on('change', '#Employee', function() {
            var EmployeeID = $(this).val();
            $.get('<?= route('getEmployeeDetail') ?>', {
                EmployeeID: EmployeeID
            }, function(data) {
                $('#Contact').val(data.EmployeeDetail.Contact);
                $('#Email').val(data.EmployeeDetail.Email);
            }, 'json');
        });

        $('#addUserForm').on('submit', function(e) {
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
                    if (data.status == 400) {
                        $.each(data.error, function(prefix, val) {
                            $(form).find('span.' + prefix + '_error').text(val[0]);
                        });
                    } else {
                        $(form)[0].reset();
                        $('#addUserModal').modal('hide');
                        $('#UserTable').DataTable().ajax.reload(null, false);
                        toastr.success(data.msg);
                    }
                }
            });
        });

        $('#UserTable').DataTable({
            processing: true,
            info: true,
            ajax: "{{ route('getAllUser') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'Username',
                    name: 'Username'
                },
                {
                    data: 'UserType',
                    name: 'UserType',

                },
                {
                    data: 'Contact',
                    name: 'Contact',

                },
                {
                    data: 'email',
                    name: 'email',

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

        //===============Update State Details================================
        $('#editUserForm').on('submit', function(e) {
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
                    if (data.status == 400) {
                        $.each(data.error, function(prefix, val) {
                            $(form).find('span.' + prefix + '_error').text(val[0]);
                        });
                    } else {
                        $('#editUserModal').modal('hide');
                        // $('#editUserForm').find(form)[0].reset();
                        $('#UserTable').DataTable().ajax.reload(null, false);
                        toastr.success(data.msg);
                    }
                }
            });
        });
        // ?==============Delete State======================//
        $(document).on('click', '#deleteBtn', function() {
            var UserId = $(this).data('id');
            var url = '<?= route('deleteUser') ?>';
            swal.fire({
                title: 'Are you sure?',
                html: 'You want to <b>Delete</b> this User',
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
                        UserId: UserId
                    }, function(data) {
                        if (data.status == 200) {
                            $('#UserTable').DataTable().ajax.reload(null, false);
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
