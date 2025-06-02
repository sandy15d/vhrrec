<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

@php

use Carbon\Carbon;
$NewMRF = DB::table('manpowerrequisition')
    ->where('CountryId', session('Set_Country'))
    ->where('Status', 'New')
    ->orWhere(function ($query) {
        $query->where('Status', 'Approved')->whereNull('Allocated');
    })
    ->count();

$ActiveMRF = DB::table('manpowerrequisition')
    ->where('CountryId', session('Set_Country'))
    ->where('MRFId', '!=', 0)
    ->where('Allocated', '!=', null)
    ->where('Status', 'Approved')
    ->count();

$CloseMRF = DB::table('manpowerrequisition')
    ->where('CountryId', session('Set_Country'))
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
    ->Join('jobcandidates', 'jobapply.JCId', '=', 'jobcandidates.JCId')
    ->where('jobpost.Status', 'Open')
    ->where('jobpost.JobPostType', 'Regular')
    ->where('screening.ScreenStatus', 'Shortlist')
    ->whereDate('IntervDt', '>=',Carbon::today())
    ->whereNull('screening.IntervStatus')
    ->count();

$pending_tech_scr = DB::table('screening')
    ->join('jobapply', 'jobapply.JAId', '=', 'screening.JAId')
    ->join('jobpost', 'jobpost.JPId', '=', 'jobapply.JPId')
    ->where('jobpost.Status', '=', 'Open')
    ->whereNull('screening.ScreenStatus')
    ->count();


$OfferStatusPending = DB::table('candjoining')
    ->whereNull('Answer')
    ->count();
$upcommingJoining = DB::table('candjoining')
    ->where('Answer', 'Accepeted')
    ->where('Joined', 'No')

    ->count();

$resume_source_pie_chart = DB::table('jobapply')
    ->select('master_resumesource.ResumeSource', DB::raw('COUNT(JAId) as total'))
    ->join('master_resumesource', 'master_resumesource.ResumeSouId', '=', 'jobapply.ResumeSource')
    ->groupBy('jobapply.ResumeSource')
    ->get();

$resume_source_pie_chart_data = [];
foreach ($resume_source_pie_chart as $key => $value) {
    $resume_source_pie_chart_data[$key]['name'] = $value->ResumeSource;
    $resume_source_pie_chart_data[$key]['y'] = $value->total;
}

$data = [];
$months = [1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'];

for ($i = 1; $i <= 12; $i++) {
    $sql1 = "SELECT COUNT(MRFId) as Open,(SELECT COUNT(MRFId) FROM manpowerrequisition WHERE Status='Close' AND (YEAR(CloseDt)=YEAR(CURRENT_DATE)) AND (MONTH(CloseDt)=$i)) as Close  FROM `manpowerrequisition` WHERE (YEAR(AllocatedDt)=YEAR(CURRENT_DATE)) AND (MONTH(AllocatedDt)=$i)";
    $result = DB::select($sql1);
    $data[$i]['Month'] = $months[$i];
    $data[$i]['Open'] = $result[0]->Open;
    $data[$i]['Close'] = $result[0]->Close;
}

$mrf_summary_chart = array_values($data);

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
        <div class="row ">
            <div class="col">
                <a href="/admin/mrf">
                    <div class="card radius-10 border-start border-0 border-3 border-success" style="margin-bottom: 0.5rem">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">MRF Pending for Approval</p>
                                </div>
                                <div class="ms-auto">
                                    <h4 class="my-1 text-success">{{ $NewMRF }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="/admin/closedmrf">
                    <div class="card radius-10 border-start border-0 border-3 border-danger" style="margin-bottom: 0.5rem">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Closed MRF's</p>
                                </div>
                                <div class="ms-auto">
                                    <h4 class="my-1 text-danger">{{ $CloseMRF }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="/admin/active_mrf">
                    <div class="card radius-10 border-start border-0 border-3 border-info" style="margin-bottom: 0.5rem">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Active MRF's</p>
                                </div>
                                <div class="ms-auto">
                                    <h4 class="my-1 text-info">{{ $ActiveMRF }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="/job_applications">
                    <div class="card radius-10 border-start border-0 border-3 border-warning" style="margin-bottom: 0.5rem">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Total Candidates</p>

                                </div>
                                <div class="ms-auto">
                                    <h4 class="my-1 text-warning">{{ $TotalCandidate }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="/TechnicalScreening">
                    <div class="card radius-10 border-start border-0 border-3 border-dark" style="margin-bottom: 0.5rem">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Pending Tech. Scr</p>
                                </div>
                                <div class="ms-auto">
                                    <h4 class="my-1 text-danger">{{ $pending_tech_scr }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="/offer_letter">
                    <div class="card radius-10 border-start border-0 border-3 border-dark" style="margin-bottom: 0.5rem">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Offer Letter Status Pending</p>
                                </div>
                                <div class="ms-auto">
                                    <h4 class="my-1 text-danger">{{ $OfferStatusPending }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <hr style="margin: 3px;">
        <div class="row">
            <div class="col-4">
                <div class="row">
                    <div class="col-6">
                        <a href="/upcoming_interview">
                            <div class="card radius-10 border-start border-0 border-3 border-secondary "
                                style="margin-bottom: 0.5rem">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <p class="mb-0 text-secondary">Upcoming Interviews</p>
                                        </div>
                                        <div class="ms-auto">
                                            <h4 class="my-1 text-success">{{ $upcomming_interview }}</h4>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="/candidate_joining">
                            <div class="card radius-10 border-start border-0 border-3 border-secondary "
                                style="margin-bottom: 0.5rem">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <p class="mb-0 text-secondary">Upcoming Joinings</p>
                                        </div>
                                        <div class="ms-auto">
                                            <h4 class="my-1 text-success">{{ $upcommingJoining }}</h4>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

        </div>
        <hr style="margin: 3px;">
        <p>Recruiter</p>
        <div class="row">
            @foreach ($sql as $item)
            <div class="col viewTask " data-id="{{ $item->id }}" style="cursor: pointer">
                <div class="card radius-10" style="margin-bottom: 0.5rem">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="my-1 text-primary">{{ $item->name }}</p>

                            </div>
                            <div class="text-primary ms-auto">
                                <h4 class="my-1 text-primary">{{ ActiveMRFCount($item->id) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card" style="margin-bottom: 0.5rem">
                    <div class="card-body">
                        <p class="text-center mb-0 fw-bold">Active Pipeline</p>
                        <form action="">
                            <div class="row mb-4">
                                <div class="col-sm-8">
                                    <select name="select_mrf" id="select_mrf" class="form-select form-select-sm"
                                        onchange="getActiveMrfPipeline();">
                                        <option value="">Select MRF</option>
                                        @foreach ($active_mrf as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                        </form>

                        <div id="active_mrf_chart" style="height: 300px;"></div>

                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card" style="margin-bottom: 0.5rem">
                    <div class="card-body">
                        <p class="text-center mb-0 fw-bold">MRF Status-Open Days</p>
                        <form action="">
                            <div class="row mb-4">
                                <div class="col-sm-8">
                                    <select name="select_recruiter" id="select_recruiter" class="form-select form-select-sm"
                                        onchange="getMRFOpenDayChart();">
                                        <option value="">Select Recruiter</option>
                                        @foreach ($recruiter as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                        </form>
                        <div id="columnchart_values" style=" height:300px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-lg-12">
                <div class="card" style="margin-bottom: 0.5rem">
                    <div class="card-body">
                        <p class="text-center mb-0 fw-bold">MRF Summary</p>
                        <div id="columnchart_material" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card" style="margin-bottom: 0.5rem">
                    <div class="card-body">
                        <div id="resumesource_chart" style=" height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>




        <hr>
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

    @php

    @endphp
@endsection
@section('scriptsection')
    <script>
        google.charts.load('current', {
            'packages': ['corechart', 'bar']
        });
        //     google.charts.setOnLoadCallback(draw_resumesource_chart);
        google.charts.setOnLoadCallback(draw_mrf_summary_chart);
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
                lengthChange: true,
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

        /*   function draw_resumesource_chart() {
              var data = google.visualization.arrayToDataTable([
                  ['ResumeSource', 'total'],
                  @php
                      foreach ($resume_source_pie_chart as $d) {
                          echo "['" . $d->ResumeSource . "', " . $d->total . '],';
                      }
                  @endphp
              ]);

              var options = {
                  title: 'Total Candidate: {{ $TotalCandidate }}',

              };

              var chart = new google.visualization.PieChart(document.getElementById('resumesource_chart'));
              chart.draw(data, options);
          } */

        function draw_mrf_summary_chart() {
            var data = google.visualization.arrayToDataTable([
                ['Months', 'Open', 'Closed'],
                @php
                    for ($i = 0; $i < count($mrf_summary_chart); $i++) {
                        echo "['" . $mrf_summary_chart[$i]['Month'] . "', " . $mrf_summary_chart[$i]['Open'] . ', ' . $mrf_summary_chart[$i]['Close'] . '],';
                    }
                @endphp
            ]);

            var options = {
                is3D: true,
                animation: {
                    duration: 5000,
                    easing: 'in',
                    startup: true //This is the new option
                },
                vAxis: {
                    title: 'No. of MRF',
                    titleTextStyle: {
                        color: 'red'
                    },
                    minValue: 0,
                    maxValue: 1000
                },
                chart: {
                    title: 'MRF summary',
                    subtitle: 'Open and Closed MRF in Year {{ date('Y') }}',

                },

            };


            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
            chart.draw(data, google.charts.Bar.convertOptions(options));

        }

        function getActiveMrfPipeline() {
            var MRFId = $("#select_mrf").val();
            $.ajax({
                type: "POST",
                url: "{{ route('getActiveMRFWiesData') }}",
                data: {
                    MRFId: MRFId
                },
                dataType: "JSON",
                success: function(res) {
                    var chart = new CanvasJS.Chart("active_mrf_chart", {
                        animationEnabled: true,
                        theme: "light2", //"light1", "dark1", "dark2"
                        data: [{
                            type: "funnel",
                            indexLabel: "{label} - {y}",
                            toolTipContent: "<b>{label}</b>: {y} ",
                            neckWidth: 20,
                            neckHeight: 0,
                            valueRepresents: "area",
                            dataPoints: res,
                        }]
                    });

                    chart.render();
                }
            });

        }



        function getMRFOpenDayChart() {
            var UserId = $("#select_recruiter").val();

            $.ajax({
                type: "POST",
                url: "{{ route('mrf_status_open_days') }}",
                data: {
                    UserId: UserId
                },
                dataType: "JSON",
                success: function(res) {
                    var chart2 = new CanvasJS.Chart("columnchart_values", {
                        animationEnabled: true,
                        theme: "light2",
                        axisY: {
                            title: "Days"
                        },
                        data: [{
                            type: "column",
                            showInLegend: true,
                            legendMarkerColor: "grey",
                            legendText: "MRF Status-Open Days",
                            dataPoints: res
                        }]
                    });
                    changeColor(chart2);
                    chart2.render();
                }
            });

        }
        window.onload = function() {
            var chart1 = new CanvasJS.Chart("active_mrf_chart", {
                animationEnabled: true,
                theme: "light2", //"light1", "dark1", "dark2"

                data: [{
                    type: "funnel",
                    indexLabel: "{label} - {y}",
                    toolTipContent: "<b>{label}</b>: {y} ",
                  /*   neckWidth: 10,
                    neckHeight: 10, */
                    valueRepresents: "area",
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart1.render();


            var chart2 = new CanvasJS.Chart("columnchart_values", {
                animationEnabled: true,
                theme: "light2",
                axisY: {
                    title: "Days"
                },
                data: [{
                    type: "column",
                    showInLegend: true,
                    legendMarkerColor: "grey",
                    legendText: "MRF Status-Open Days",
                    dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
                }]
            });
            changeColor(chart2);
            chart2.render();

           

            var resume_source_chart = new CanvasJS.Chart("resumesource_chart", {
                theme: "light1",
                exportFileName: "Resume Source Chart",
                exportEnabled: true,
                animationEnabled: true,
                title: {
                    text: "Resume Source"
                },
                legend: {
                    cursor: "pointer",
                    itemclick: explodePie
                },
                data: [{
                    type: "doughnut",
                    innerRadius: 50,
                    showInLegend: true,
                    toolTipContent: "<b>{name}</b>: {y} ",
                    indexLabel: "{name} - {y}",
                    dataPoints: <?php echo json_encode($resume_source_pie_chart_data, JSON_NUMERIC_CHECK); ?>
                }]
            });
            resume_source_chart.render();

            function explodePie(e) {
                if (typeof(e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries
                    .dataPoints[e.dataPointIndex].exploded) {
                    e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
                } else {
                    e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
                }
                e.resume_source_chart.render();
            }
        }
        function changeColor(chart) {
                for (var i = 0; i < chart.options.data.length; i++) {
                    for (var j = 0; j < chart.options.data[i].dataPoints.length; j++) {
                        y = chart.options.data[i].dataPoints[j].y;
                        if (y <= 30)
                            chart.options.data[i].dataPoints[j].color = "green";
                        else
                            chart.options.data[i].dataPoints[j].color = "red";
                    }
                }
            }
    </script>
@endsection
