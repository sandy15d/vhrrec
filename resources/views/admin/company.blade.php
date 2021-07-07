@extends('layouts.master')
@section('title', 'Company Master')
@section('PageContent')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Company Master</div>

            <div class="ms-auto">
            <button>Add New</button>
            <button>Sync</button>
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
                        @foreach ($collection as $item)
                            
                      
                        <tr>
                            <td>{{$item['CompanyId']}}</td>
                            <td>{{$item['CompanyName']}}</td>
                            <td></td>
                            <td>{{$item['address']}}</td>
                            <td>{{$item['Phone']}}</td>
                            <td>{{$item['Status']}}</td>
                            <td><button type="button" class="btn btn-sm btn-primary"><i
                                        class="bx bx-message-square-edit me-0"></i>
                                </button></td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
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
