@extends('layouts.master')
@section('title', 'Education Master')
@section('PageContent')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Education Master</div>
            <div class="ms-auto">
                <button class="btn btn--new btn-sm" id="addEducation" data-bs-toggle="modal"
                    data-bs-target="#addEducationModal">Add New</button>
            </div>
        </div>
        <!--end breadcrumb-->

        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-condensed" id="EducationTable" style="width: 100%">
                        <thead>
                            <tr>
                                <th class="th-sm">S.No</th>
                                <th>Education</th>
                                <th>Code</th>
                                <th>Type</th>
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


    <div class="modal fade" id="addEducationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New District</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('addEducation') }}" method="POST" id="addEducationForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="EducationName">Education Name</label>
                            <input type="text" class="form-control" name="EducationName" placeholder="Enter Education Name">
                            <span class="text-danger error-text EducationName_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="EducationCode">Education Code</label>
                            <input type="text" class="form-control" name="EducationCode" placeholder="Enter Education Code">
                            <span class="text-danger error-text EducationCode_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="EducationType">Education Type</label>
                            <select name="EducationType" class="form-control form-select">
                                <option value="" selected disabled>Select Education Type</option>
                                <option value="10th">10th</option>
                                <option value="12th">12th</option>
                                <option value="Graduation">Graduation</option>
                                <option value="PostGraduation">Post Graduation</option>
                                <option value="PhD">PhD</option>
                                <option value="MPhil">MPhil</option>
                                <option value="Technical">Technical</option>
                            </select>
                            <span class="text-danger error-text EducationType_error"></span>
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
                        <button type="submit" class="btn btn-primary" id="SaveEducation">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editEducationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Education Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('editEducation') }}" method="POST" id="editEducationForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="EId" />
                            <label for="editEducation">Education</label>
                            <input type="text" class="form-control" name="editEducation">
                            <span class="text-danger error-text editEducation_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="editEducationCode">Education Code</label>
                            <input type="text" class="form-control" name="editEducationCode" placeholder="Enter State Code">
                            <span class="text-danger error-text editEducationCode_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="editEducationType">Education Type</label>
                            <select name="editEducationType" id="editEducationType" class="form-control form-select">
                                <option value="10th">10th</option>
                                <option value="12th">12th</option>
                                <option value="Graduation">Graduation</option>
                                <option value="PostGraduation">Post Graduation</option>
                                <option value="PhD">PhD</option>
                                <option value="MPhil">MPhil</option>
                                <option value="Technical">Technical</option>
                            </select>
                            <span class="text-danger error-text editEducationType_error"></span>
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
                        <button type="submit" class="btn btn-primary" id="UpdateEducation">Update changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scriptsection')
    <script>
        $('#addEducationForm').on('submit', function(e) {
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
                    if (data.status==400) {
                        $.each(data.error, function(prefix, val) {
                            $(form).find('span.' + prefix + '_error').text(val[0]);
                        });
                    } else {
                        $(form)[0].reset();
                        $('#addEducationModal').modal('hide');
                        $('#EducationTable').DataTable().ajax.reload(null, false);
                        toastr.success(data.msg);
                    }
                }
            });
        });
        $('#EducationTable').DataTable({
            processing: true,
            info: true,
            ajax: "{{ route('getAllDistrict') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'EducationName',
                    name: 'EducationName'
                },
                {
                    data: 'EducationCode',
                    name: 'EducationCode'
                },
                {
                    data: 'EducationType',
                    name: 'EducationType'
                },
                {
                    data: 'actions',
                    name: 'actions'
                },
            ],
            
        });
        //===============Get District Record for Updation=================
        $(document).on('click', '#editBtn', function() {
            var StateId = $(this).data('id');
            $.post('<?= route('getEducationDetails') ?>', {
                StateId: StateId
            }, function(data) {
                $('#editEducationModal').find('input[name="districtId"]').val(data.EducationDetails.DistrictId);
                $('#editEducationModal').find('input[name="editEducation"]').val(data.EducationDetails
                    .EducationName);
                $('#editEducationType').val(data.EducationDetails
                    .EducationType);
                $('#editStatus').val(data.EducationDetails.Status);
                $('#editEducationModal').modal('show');
            }, 'json');
        });
        //===============Update District Details================================
        $('#editEducationForm').on('submit', function(e) {
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
                        $('#editEducationModal').modal('hide');
                        // $('#editEducationForm').find(form)[0].reset();
                        $('#EducationTable').DataTable().ajax.reload(null, false);
                        toastr.success(data.msg);
                    }
                }
            });
        });
        // ?==============Delete District======================//
        $(document).on('click', '#deleteBtn', function() {
            var EducationId = $(this).data('id');
            var url = '<?= route('deleteEducation') ?>';
            swal.fire({
                title: 'Are you sure?',
                html: 'You want to <b>Delete</b> this Education',
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
                        EducationId: EducationId
                    }, function(data) {
                        if (data.status == 200) {
                            $('#EducationTable').DataTable().ajax.reload(null, false);
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
