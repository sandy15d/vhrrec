@extends('layouts.master')
@section('title', 'Company Master')
@section('PageContent')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Company Master</div>

            <div class="ms-auto">
            <button class="btn btn--new btn-sm" id="addCompany" data-bs-toggle="modal" data-bs-target="#addCompanyModal">Add New</button>
            <button class="btn btn-sm btn--red">Sync</button>
            </div>
        </div>
        <!--end breadcrumb-->
       
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                <table class="table table-striped table-hover"  id="companytable">
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
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur.</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scriptsection')
    <script>
        $(document).ready(function() {
            $('#companytable').DataTable(); 
        });

        
    </script>
@endsection
