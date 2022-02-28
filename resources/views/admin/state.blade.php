@extends('layouts.master')
@section('title', 'State Master')
@section('PageContent')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">State Master(HQ)</div>
            <div class="ms-auto">
                <button class="btn btn--new btn-sm" id="addState" data-bs-toggle="modal" data-bs-target="#addStateModal">Add
                    New</button>
                <button class="btn btn-sm btn--red" id="syncState">Sync</button>
            </div>
        </div>
        <!--end breadcrumb-->

        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-condensed" id="Statetable" style="width: 100%">
                        <thead class="bg-primary text-light text-center">
                            <tr>
                                <td class="td-sm">S.No</td>
                                <td>State Name</td>
                                <td>State Code</td>
                                <td>Country</td>
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


    <div class="modal fade" id="addStateModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New State</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('addState') }}" method="POST" id="addStateForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="StateName">State Name</label>
                            <input type="text" class="form-control" name="StateName" placeholder="Enter State Name">
                            <span class="text-danger error-text StateName_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="StateCode">State Code</label>
                            <input type="text" class="form-control" name="StateCode" placeholder="Enter State Code">
                            <span class="text-danger error-text StateCode_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="Country">Country</label>
                            <select name="Country" class="form-control form-select">
                                <option value="" selected disabled>Select Country</option>
                                @foreach ($country_list as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text Country_error"></span>
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
                        <button type="submit" class="btn btn-primary" id="SaveState">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editStateModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update State Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('editState') }}" method="POST" id="editStateForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="stid" />
                            <label for="editStateName">State Name</label>
                            <input type="text" class="form-control" name="editStateName" placeholder="Enter State Name">
                            <span class="text-danger error-text editStateName_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="editStateCode">State Code</label>
                            <input type="text" class="form-control" name="editStateCode" placeholder="Enter State Code">
                            <span class="text-danger error-text editStateCode_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="editCountry">Country</label>
                            <select name="editCountry" id="editCountry" class="form-control form-select">
                                @foreach ($country_list as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text editCountry_error"></span>
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
                        <button type="submit" class="btn btn-primary" id="UpdateState">Update changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scriptsection')
    <script>
        $('#addStateForm').on('submit', function(e) {
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
                        $('#addStateModal').modal('hide');
                        $('#Statetable').DataTable().ajax.reload(null, false);
                        toastr.success(data.msg);
                    }
                }
            });
        });
        $('#Statetable').DataTable({
            processing: true,
            info: true,
            ajax: "{{ route('getAllStateData') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'StateName',
                    name: 'StateName'
                },
                {
                    data: 'StateCode',
                    name: 'StateCode'
                },
                {
                    data: 'CountryName',
                    name: 'CountryName',

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
        //===============Get State Record for Updation=================
        $(document).on('click', '#editBtn', function() {
            var StateId = $(this).data('id');
            $.post('<?= route('getStateDetails') ?>', {
                StateId: StateId
            }, function(data) {
                $('#editStateModal').find('input[name="stid"]').val(data.StateDetails.StateId);
                $('#editStateModal').find('input[name="editStateName"]').val(data.StateDetails
                    .StateName);
                $('#editStateModal').find('input[name="editStateCode"]').val(data.StateDetails
                    .StateCode);
                $('#editCountry').val(data.StateDetails.Country);
                $('#editStatus').val(data.StateDetails.Status);
                $('#editStateModal').modal('show');
            }, 'json');
        });
        //===============Update State Details================================
        $('#editStateForm').on('submit', function(e) {
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
                        $('#editStateModal').modal('hide');
                        // $('#editStateForm').find(form)[0].reset();
                        $('#Statetable').DataTable().ajax.reload(null, false);
                        toastr.success(data.msg);
                    }
                }
            });
        });
        // ?==============Delete State======================//
        $(document).on('click', '#deleteBtn', function() {
            var StateId = $(this).data('id');
            var url = '<?= route('deleteState') ?>';
            swal.fire({
                title: 'Are you sure?',
                html: 'You want to <b>Delete</b> this State',
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
                        StateId: StateId
                    }, function(data) {
                        if (data.status == 200) {
                            $('#Statetable').DataTable().ajax.reload(null, false);
                            toastr.success(data.msg);
                        } else {
                            toastr.error(data.msg);
                        }
                    }, 'json');
                }
            });
        });
        //===================== Synchonize State Data from ESS===================
        $(document).on('click', '#syncState', function() {
            var url = '<?= route('syncState') ?>';
            $('#syncState').html('<i class="fa fa-spinner fa-spin"></i> Loading...');
            swal.fire({
                title: 'Are you sure?',
                html: 'Synchronize State Data from ESS',
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
                        if (data.status == 200) {
                            $('#syncState').html('Sync');
                            $('#Statetable').DataTable().ajax.reload(null, false);
                            toastr.success(data.msg);
                        } else {
                            toastr.error(data.msg);
                            $('#syncState').html('Sync');
                        }
                    }, 'json');
                }
            });
        });
    </script>
@endsection
