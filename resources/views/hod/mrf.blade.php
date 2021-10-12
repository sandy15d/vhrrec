@extends('layouts.master')

@section('title', 'New MRF')
@section('PageContent')
    <style>
        .table>:not(caption)>*>* {
            padding: 1px 1px;
        }

    </style>

    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Manpower Requisition Form</div>

            <div class="ms-auto">
                <a class="btn btn--new btn-sm" href="{{ route('new_mrf') }}"><i class="bx bx-plus"></i> New MRF</a>
                <a class="btn btn--green btn-sm" href="{{ route('sip_mrf') }}"><i class="bx bx-plus"></i> MRF-
                    SIP/Internship</a>
                <a class="btn btn--red btn-sm" href="{{ route('campus_mrf') }}"><i class="bx bx-plus"></i> MRF-Campus
                    Hiring</a>
            </div>
        </div>
        <!--end breadcrumb-->
        <hr />
        <div class="card border-top border-0 border-4 border-primary">
            <div class="card-body">
                <div class="card-title d-flex align-items-center">
                    <div><i class="bx bx-info-square me-1 font-20 text-primary"></i>
                    </div>
                    <h6 class="mb-0 text-primary">MRF Summary</h6>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table table-striped table-hover display compact text-center table-bordered"
                        id="mrfsummarytable" style="width: 100%">
                        <thead>
                            <tr>
                                <th class="th-sm">S.No</th>
                                <th class="th-sm">Type</th>
                                <th>Job Code</th>
                                <th>Designation</th>
                                <th>Status</th>
                                <th>MRF Date</th>
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

@section('scriptsection')

    <script>
        $('#mrfsummarytable').DataTable({
            processing: true,
            info: true,
            ajax: "{{ route('getAllMRFCreatedByMe') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'Type',
                    name: 'Type'

                },
                {
                    data: 'JobCode',
                    name: 'JobCode'
                },

                {
                    data: 'DesigName',
                    name: 'DesigName'
                },


                {
                    data: 'Status',
                    name: 'Status'
                },

                {
                    data: 'MRFDate',
                    name: 'MRFDate'
                },

                {
                    data: 'actions',
                    name: 'actions'
                }


            ],

        });
    </script>
@endsection
