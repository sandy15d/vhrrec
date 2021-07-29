@extends('layouts.master')
@section('title', 'New MRF')
@section('PageContent')

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">New MRF</div>
        <div class="ms-auto">
            <button class="btn btn--new btn-sm" id="addNewMRF" data-bs-toggle="modal"
                data-bs-target="#addNewMRFModal">Add New</button>
          
        </div>
    </div>
    <!--end breadcrumb-->
    <hr />
    <div class="card border-top border-0 border-4 border-primary">
        <div class="card-body">
            <div class="border p-4 rounded">
                <div class="card-title d-flex align-items-center">
                    <div><i class="bx bx-info-square me-1 font-20 text-primary"></i>
                    </div>
                    <h6 class="mb-0 text-primary">MRF Summary</h6>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table table-striped table-hover display compact" id="myteamtable" style="width: 100%">
                        <thead>
                            <tr>
                                <th class="th-sm">S.No</th>
                                <th class="th-sm">Type</th>
                                <th>Job Code</th>
                                <th>Designation</th>
                                <th>Status</th>
                                <th>MRF Date</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addNewMRFModal" tabindex="-1" aria-hidden="true">
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
@endsection

@section('scriptsection')
    <script>

       
    </script>
@endsection
