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
                <button class="btn btn-sm btn--red">Sync</button>
            </div>
        </div>
        <!--end breadcrumb-->

        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="companytable">
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
                            <select name="Status" class="form-control">
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
@endsection

@section('scriptsection')
    <script>
        $(document).ready(function() {
            $('#companytable').DataTable();
        });

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
                    }else{
                        $(form)[0].reset();
                        $('#addCompanyModal').modal('hide');
                        toastr.success(data.msg);
                    }
                }
            });
     

        });
    </script>
@endsection
