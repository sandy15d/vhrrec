@extends('layouts.master')
@section('title', 'Institute Master')
@section('PageContent')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Institute Master</div>
            <div class="ms-auto">
                <button class="btn btn--new btn-sm" id="addInstitute" data-bs-toggle="modal"
                    data-bs-target="#addInstituteModal">Add New</button>
            </div>
        </div>
        <!--end breadcrumb-->
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-condensed" id="EducationTable" style="width: 100%">
                        <thead class="bg-primary text-light text-center">
                            <tr>
                                <td></td>
                                <td class="td-sm">S.No</td>
                                <td>Education Institute</td>
                                <td>Code</td>
                                <td>Category</td>
                                <td>Type</td>
                                <td>State</td>
                                <td>District</td>
                                <td>Status</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="addInstituteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Education</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('addInstitute') }}" method="POST" id="addInstituteForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-8">
                                <div class="form-group">
                                    <label for="InstituteName">Institute Name</label>
                                    <input type="text" class="form-control" name="InstituteName"
                                        placeholder="Enter Institute Name">
                                    <span class="text-danger error-text InstituteName_error"></span>
                                </div>

                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="InstituteCode">Institute Code</label>
                                    <input type="text" class="form-control" name="InstituteCode"
                                        placeholder="Education Code">
                                    <span class="text-danger error-text InstituteCode_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="State">State</label>
                                    <select name="State" id="State" class="form-control form-select">
                                        <option value="" selected disabled>Select State</option>
                                        @foreach ($state_list as $key => $state)
                                            <option value="{{ $key }}">{{ $state }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error-text State_error"></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="District">District</label>
                                    <select name="District" id="District" class="form-control form-select">

                                    </select>
                                    <span class="text-danger error-text District_error"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="Category">Category</label>
                                    <select name="Category" class="form-control form-select">
                                        <option value="" selected disabled>Select Category</option>
                                        <option value="Central">Central</option>
                                        <option value="State">State</option>
                                        <option value="Deemed">Deemed</option>
                                        <option value="Private">Private</option>

                                    </select>
                                    <span class="text-danger error-text Category_error"></span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="Type">Type</label>
                                    <select name="Type" class="form-control form-select">
                                        <option value="" selected disabled>Select Type</option>
                                        <option value="Agri">Agri</option>
                                        <option value="Non-Agri">Non-Agri</option>
                                    </select>
                                    <span class="text-danger error-text Type_error"></span>
                                </div>
                            </div>
                            <div class="col-4">
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
                        <button type="submit" class="btn btn-primary" id="SaveInstitute">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editInstituteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Institute Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('editInstitute') }}" method="POST" id="editInstituteForm">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="EId" name="EId">
                        <div class="row">
                            <div class="col-8">
                                <div class="form-group">
                                    <label for="editInstituteName">Institute Name</label>
                                    <input type="text" class="form-control" name="editInstituteName"
                                        placeholder="Enter Institute Name">
                                    <span class="text-danger error-text editInstituteName_error"></span>
                                </div>

                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="editInstituteCode">Institute Code</label>
                                    <input type="text" class="form-control" name="editInstituteCode"
                                        placeholder="Education Code">
                                    <span class="text-danger error-text editInstituteCode_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="editState">State</label>
                                    <select name="editState" id="editState" class="form-control form-select">
                                        <option value="" selected disabled>Select State</option>
                                        @foreach ($state_list as $key => $state)
                                            <option value="{{ $key }}">{{ $state }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error-text editState_error"></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="editDistrict">District</label>
                                    <select name="editDistrict" id="editDistrict" class="form-control form-select">
                                        @foreach ($district_list as $key => $state)
                                            <option value="{{ $key }}">{{ $state }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error-text editDistrict_error"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="editCategory">Category</label>
                                    <select name="editCategory" id="editCategory" class="form-control form-select">
                                        <option value="" selected disabled>Select Category</option>
                                        <option value="Central">Central</option>
                                        <option value="State">State</option>
                                        <option value="Deemed">Deemed</option>
                                        <option value="Private">Private</option>

                                    </select>
                                    <span class="text-danger error-text editCategory_error"></span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="editType">Type</label>
                                    <select name="editType" id="editType" class="form-control form-select">
                                        <option value="" selected disabled>Select Type</option>
                                        <option value="Agri">Agri</option>
                                        <option value="Non-Agri">Non-Agri</option>
                                    </select>
                                    <span class="text-danger error-text editType_error"></span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="editStatus">Status</label>
                                    <select name="editStatus" id="editStatus" class="form-control form-select">
                                        <option value="A">Active</option>
                                        <option value="D">Deactive</option>
                                    </select>
                                    <span class="text-danger error-text editStatus_error"></span>
                                </div>
                            </div>
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
        $('#State').change(function() {
            var StateId = $(this).val();
            if (StateId) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('getDistrict') }}?StateId=" + StateId,

                    success: function(res) {
                        console.log(res);
                        if (res) {
                            $("#District").empty();
                            $("#District").append('<option>Select District</option>');
                            $.each(res, function(key, value) {
                                $("#District").append('<option value="' + value + '">' + key +
                                    '</option>');
                            });

                        } else {
                            $("#District").empty();
                        }
                    }
                });
            } else {
                $("#District").empty();

            }
        });


        $('#addInstituteForm').on('submit', function(e) {
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
                        $('#addInstituteModal').modal('hide');
                        $('#EducationTable').DataTable().ajax.reload(null, false);
                        toastr.success(data.msg);
                    }
                }
            });
        });
        $('#EducationTable').DataTable({
            processing: true,
            info: true,
            ajax: "{{ route('getAllInstitute') }}",
            columns: [

                {
                    data: 'chk',
                    name: 'chk'
                },
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'InstituteName',
                    name: 'InstituteName'
                },
                {
                    data: 'InstituteCode',
                    name: 'InstituteCode'
                },
                {
                    data: 'Category',
                    name: 'Category'
                },
                {
                    data: 'Type',
                    name: 'Type'
                },
                {
                    data: 'StateCode',
                    name: 'StateCode'
                },
                {
                    data: 'DistrictName',
                    name: 'DistrictName'
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
        //===============Get Institute Record for Updation=================
        $(document).on('click', '#editBtn', function() {
            var InstituteId = $(this).data('id');
            $.post('<?= route('getInstituteDetails') ?>', {
                InstituteId: InstituteId
            }, function(data) {
                $('#editInstituteModal').find('input[name="EId"]').val(data.IntituteDetails.InstituteId);
                $('#editInstituteModal').find('input[name="editInstituteName"]').val(data.IntituteDetails
                    .InstituteName);
                $('#editInstituteModal').find('input[name="editInstituteCode"]').val(data.IntituteDetails
                    .InstituteCode);
                $('#editState').val(data.IntituteDetails.StateId);
                $('#editDistrict').val(data.IntituteDetails.DistrictId);
                $('#editCategory').val(data.IntituteDetails.Category);
                $('#editType').val(data.IntituteDetails.Type);
                $('#editStatus').val(data.IntituteDetails.Status);
                $('#editInstituteModal').modal('show');
            }, 'json');
        });
        //===============Update Institute Details================================
        $('#editInstituteForm').on('submit', function(e) {
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
                        $('#editInstituteModal').modal('hide');
                        $('#EducationTable').DataTable().ajax.reload(null, false);
                        toastr.success(data.msg);
                    }
                }
            });
        });
        // ?==============Delete Institute======================//
        $(document).on('click', '#deleteBtn', function() {
            var InstituteId = $(this).data('id');
            var url = '<?= route('deleteInstitute') ?>';
            swal.fire({
                title: 'Are you sure?',
                html: 'You want to <b>Delete</b> this Institute',
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
                        InstituteId: InstituteId
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




        $('#editState').change(function() {
            var StateId = $(this).val();
            if (StateId) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('getDistrict') }}?StateId=" + StateId,

                    success: function(res) {
                        console.log(res);
                        if (res) {
                            $("#editDistrict").empty();
                            $("#editDistrict").append('<option>Select District</option>');
                            $.each(res, function(key, value) {
                                $("#editDistrict").append('<option value="' + value + '">' +
                                    key +
                                    '</option>');
                            });

                        } else {
                            $("#editDistrict").empty();
                        }
                    }
                });
            } else {
                $("#editDistrict").empty();

            }
        });

        $(document).on('click', '.select_all', function() {
            if ($(this).prop("checked") == true) {
                $(this).closest("tr").addClass("bg-secondary bg-gradient");
            } else {
                $(this).closest("tr").removeClass("bg-secondary bg-gradient");
            }
        });
    </script>
@endsection
