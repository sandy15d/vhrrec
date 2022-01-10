@php
use function App\Helpers\ActiveMRFCount;
$NewMRF = DB::table('manpowerrequisition')
    ->where('Status', 'Approved')
    ->whereNull('Allocated')
    ->orWhere('Status', 'New')
    ->count();
$ActiveMRF = DB::table('manpowerrequisition')
    ->where('MRFId', '!=', 0)
    ->where('Allocated', '!=', null)
    ->where('Status', 'Approved')
    ->count();
$CloseMRF = DB::table('manpowerrequisition')
    ->where('MRFId', '!=', 0)
    ->where('Status', 'Close')
    ->count();
$sql = DB::table('users')
    ->where('role', 'R')
    ->where('Status', 'A')
    ->get();
$TotalCandidate = DB::table('jobcandidates')->count();

$upcomming_interview = DB::table('screening')
    ->Join('jobapply', 'screening.JAId', '=', 'jobapply.JAId')
    ->Join('jobpost', 'jobapply.JPId', '=', 'jobpost.JPId')
    ->Join('manpowerrequisition', 'jobpost.MRFId', '=', 'manpowerrequisition.MRFId')
    ->Join('jobcandidates', 'jobapply.JCId', '=', 'jobcandidates.JCId')
    ->where('jobpost.Status', 'Open')
    ->whereNull('screening.IntervStatus')
   ->count();

   $total_available = DB::table('jobapply')
            ->where('Type', '!=', 'Campus')
            ->where('Status', null)
            ->count();
       
@endphp
@extends('layouts.master')
@section('title', 'Dashboard')
@section('PageContent')
    <div class="page-content">
        <style>
            .table>:not(caption)>*>* {
                padding: 2px 1px;
            }

        </style>
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
            <div class="col">
                <a href="/admin/mrf">
                    <div class="card radius-10 border-start border-0 border-3 border-success">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">New MRF's</p>
                                </div>
                                <div class="ms-auto">
                                    <h3 class="my-1 text-success">{{ $NewMRF }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="/admin/closedmrf">
                    <div class="card radius-10 border-start border-0 border-3 border-danger">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Closed MRF's</p>
                                </div>
                                <div class="ms-auto">
                                    <h3 class="my-1 text-danger">{{ $CloseMRF }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="/admin/active_mrf">
                    <div class="card radius-10 border-start border-0 border-3 border-info">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Active MRF's</p>
                                </div>
                                <div class="ms-auto">
                                    <h3 class="my-1 text-info">{{ $ActiveMRF }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="/job_applications">
                    <div class="card radius-10 border-start border-0 border-3 border-warning">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Total Candidates</p>

                                </div>
                                <div class="ms-auto">
                                    <h3 class="my-1 text-warning">{{ $TotalCandidate }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!--end row-->

        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
            <div class="col">
                <a href="/TechnicalScreening">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-primary">Resume Pending for Tech. Screening</p>
                                </div>
                                <div class="ms-auto">
                                    <h4 class="my-1 text-danger">{{$total_available}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="/interview_tracker">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-primary">Upcoming Interviews</p>
                            </div>
                            <div class="ms-auto">
                                <h4 class="my-1 text-success">{{$upcomming_interview}}</h4>
                            </div>

                        </div>
                    </div>
                </div>
                </a>
            </div>
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-primary">Offer Letter Status Pending</p>
                            </div>
                            <div class="ms-auto">
                                <h4 class="my-1 text-danger">23</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-primary">Upcoming Joining's</p>
                            </div>
                            <div class="ms-auto">
                                <h4 class="my-1 text-success">23</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->

        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
            @foreach ($sql as $item)
                <div class="col viewTask " data-id="{{ $item->id }}" style="cursor: pointer">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="my-1 text-primary">{{ $item->name }}</p>
                                    <p class="my-1">Active MRF's</p>
                                </div>
                                <div class="text-primary ms-auto">
                                    <h3 class="my-1 text-primary">{{ ActiveMRFCount($item->id) }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="modal" id="taskmodal" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="border-radius:10px;">
                <div class="modal-header">
                    <h6 class="modal-title text-primary ">Task Allocation List (<i id="RecruiterName"></i>)</h6>
                    <p class="download_label d-none">Task Allocation List</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-condensed table-bordered text-center"
                            id="taskTable" style="width: 100%">
                            <thead class="bg-primary text-light text-center">
                                <tr>
                                    <td class="td-sm">S.No</td>
                                    <td>Job Code</td>
                                    <td>MRF Allocation Date</td>
                                    <td>MRF Status</td>
                                    <td>Days to Close MRF</td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scriptsection')
    <script>
        $(document).on('click', '.viewTask', function() {
            var Uid = $(this).data('id');
            getTaskList(Uid);

        });

        function getTaskList(Uid) {
            getRecruiterName(Uid);
            $('#taskTable').DataTable({
                processing: true,
                info: true,
                searching: false,
                ordering: false,
                lengthChange: false,
                destroy: true,
                dom: 'Bfrtip',
                buttons: [

                    {
                        extend: 'copyHtml5',
                        text: '<i class="fa fa-files-o"></i>',
                        titleAttr: 'Copy',
                        title: $('.download_label').html(),
                        exportOptions: {
                            columns: ':visible'
                        }
                    },

                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel-o"></i>',
                        titleAttr: 'Excel',
                        title: $('.download_label').html(),
                        exportOptions: {
                            columns: ':visible'

                        }
                    },

                    {
                        extend: 'csvHtml5',
                        text: '<i class="fa fa-file-text-o"></i>',
                        titleAttr: 'CSV',
                        title: $('.download_label').html(),
                        exportOptions: {
                            columns: ':visible'
                        }
                    },

                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fa fa-file-pdf-o"></i>',
                        titleAttr: 'PDF',
                        title: $('.download_label').html(),
                        exportOptions: {
                            columns: ':visible'

                        }
                    },

                    {
                        extend: 'print',
                        text: '<i class="fa fa-print"></i>',
                        titleAttr: 'Print',
                        title: $('.download_label').html(),
                        customize: function(win) {
                            $(win.document.body)
                                .css('font-size', '10pt');

                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        },
                        exportOptions: {
                            columns: ':visible'
                        }
                    },

                    {
                        extend: 'colvis',
                        text: '<i class="fa fa-columns"></i>',
                        titleAttr: 'Columns',
                        title: $('.download_label').html(),
                        postfixButtons: ['colvisRestore']
                    },
                ],
                ajax: {
                    url: "{{ route('getTaskList') }}",
                    type: "POST",
                    data: {
                        Uid: Uid
                    },
                    dataType: "JSON",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'JobCode',
                        name: 'JobCode'
                    },
                    {
                        data: 'AllocatedDt',
                        name: 'AllocatedDt'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'days_to_fill',
                        name: 'days_to_fill'
                    }
                ],

            });
            $('#taskmodal').modal('show');
        }

        function getRecruiterName(Uid) {
            var Uid = Uid;
            $.post('<?= route('getRecruiterName') ?>', {
                Uid: Uid
            }, function(data) {
                $('#RecruiterName').html(data.details);

            }, 'json');
        }
    </script>
@endsection
