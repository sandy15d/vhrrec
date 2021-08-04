@extends('layouts.master')
@section('title', 'MRF Details')
@section('PageContent')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">MRF Details</div>
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

@endsection
