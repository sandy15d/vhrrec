@extends('layouts.master')
@section('title', 'District Master')
@section('PageContent')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">District Master</div>
            <div class="ms-auto">
                <button class="btn btn--new btn-sm" id="addDistrict" data-bs-toggle="modal"
                    data-bs-target="#addDistrictModal">Add New</button>
            </div>
        </div>
        <!--end breadcrumb-->

        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-condensed" id="DistrictTable" style="width: 100%">
                        <thead>
                            <tr>
                                <th class="th-sm">S.No</th>
                                <th>District Name</th>
                                <th>State</th>
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


    <div class="modal fade" id="addDistrictModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New District</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('addDistrict') }}" method="POST" id="addDistrictForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="DistrictName">State Name</label>
                            <input type="text" class="form-control" name="DistrictName" placeholder="Enter State Name">
                            <span class="text-danger error-text DistrictName_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="State">State</label>
                            <select name="State" class="form-control form-select">
                              <option value="" selected disabled>Select State</option>
                              @foreach ($state_list as $key =>$state)
                                  <option value="{{$key}}">{{$state}}</option>
                              @endforeach
                            </select>
                            <span class="text-danger error-text State_error"></span>
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
                        <button type="submit" class="btn btn-primary" id="SaveDistrict">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editDistrictModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update District Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('editDistrict') }}" method="POST" id="editDistrictForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="districtId" />
                            <label for="editDistrict">District</label>
                            <input type="text" class="form-control" name="editDistrict">
                            <span class="text-danger error-text editDistrict_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="editState">State Code</label>
                            <input type="text" class="form-control" name="editState" placeholder="Enter State Code">
                            <span class="text-danger error-text editState_error"></span>
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
                        <button type="submit" class="btn btn-primary" id="UpdateDistrict">Update changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scriptsection')
    <script>
        $('#addDistrictForm').on('submit', function(e) {
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
                        $('#addDistrictModal').modal('hide');
                        $('#DistrictTable').DataTable().ajax.reload(null, false);
                        toastr.success(data.msg);
                    }
                }
            });
        });
        $('#DistrictTable').DataTable({
            processing: true,
            info: true,
            ajax: "{{ route('getAllDistrict') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'StateName',
                    name: 'StateName'
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
        //===============Get District Record for Updation=================
        $(document).on('click', '#editBtn', function() {
            var StateId = $(this).data('id');
            $.post('<?= route('getDistrictDetails') ?>', {
                StateId: StateId
            }, function(data) {
                $('#editDistrictModal').find('input[name="districtId"]').val(data.DistrictDetails.DistrictId);
                $('#editDistrictModal').find('input[name="editDistrict"]').val(data.DistrictDetails
                    .DistrictName);
                $('#editDistrictModal').find('input[name="editstate"]').val(data.DistrictDetails
                    .StateId);
                $('#editStatus').val(data.DistrictDetails.Status);
                $('#editDistrictModal').modal('show');
            }, 'json');
        });
        //===============Update District Details================================
        $('#editDistrictForm').on('submit', function(e) {
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
                        $('#editDistrictModal').modal('hide');
                        // $('#editDistrictForm').find(form)[0].reset();
                        $('#DistrictTable').DataTable().ajax.reload(null, false);
                        toastr.success(data.msg);
                    }
                }
            });
        });
        // ?==============Delete District======================//
        $(document).on('click', '#deleteBtn', function() {
            var DistrictId = $(this).data('id');
            var url = '<?= route('deleteDistrict') ?>';
            swal.fire({
                title: 'Are you sure?',
                html: 'You want to <b>Delete</b> this District',
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
                        DistrictId: DistrictId
                    }, function(data) {
                        if (data.status == 200) {
                            $('#DistrictTable').DataTable().ajax.reload(null, false);
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
