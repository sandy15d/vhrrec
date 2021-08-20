@php
$sql = DB::table('master_employee')
    ->where('RepEmployeeID', Auth::user()->id)
    ->where('Empstatus', 'A')
    ->get();
$ActiveMember = $sql->count();
@endphp
@extends('layouts.master')
@section('title', 'Education')
@section('PageContent')
    <div class="page-content">
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
            <div class="col">
                <a href="/hod/myteam">
                    <div class="card radius-10 border-start border-0 border-3 border-success">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Active Team Member</p>
                                    <h3 class="my-1 text-success">{{ $ActiveMember }}</h3>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto"><i
                                        class="bx bxs-group"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <div class="card radius-10 border-start border-0 border-3 border-danger">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Interview Schedule</p>
                                <h3 class="my-1 text-danger">9</h3>
                            </div>
                            <div class="widgets-icons-2 rounded-circle bg-gradient-bloody text-white ms-auto"><i
                                    class="fadeIn animated bx bx-network-chart"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-center">
                        <div><i class="bx bx-info-square me-1 font-20 text-primary"></i>
                        </div>
                        <h6 class="mb-0 text-primary">MRF Summary</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover display compact" id="mrfsummarytable"
                            style="width: 100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th class="th-sm">S.No</th>
                                    <th class="th-sm">Type</th>
                                    <th>Job Code</th>
                                    <th>Designation</th>
                                    <th>Status</th>
                                    <th>MRF Date</th>
                                    <th>MRF By</th>
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
    </div>
@endsection

@section('scriptsection')
    <script>
        $('#mrfsummarytable').DataTable({
            processing: true,
            info: true,
            ajax: "{{ route('mrfbyme') }}",
            columns: [{
                    data: 'chk',
                    name: 'chk'
                },
                {
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
                    data: 'CreatedBy',
                    name: 'CreatedBy'
                },
                {
                    data: 'actions',
                    name: 'actions'
                }


            ],


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
