@extends('layouts.master')
@section('title', 'Application Source Report')
@section('PageContent')
    <div class="page-content">
        @include('reports._reports_nav')
        <div class="card mb-1">
            <div class="card-body">
                <div class="row mb-1">
                    <h6 class=" text-success">Job Application Source</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="myTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Source</th>
                                <th>No. of Candidates</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sql = 'SELECT master_resumesource.ResumeSource,COUNT(JAId) as total FROM `jobapply` JOIN master_resumesource ON master_resumesource.ResumeSouId = jobapply.ResumeSource GROUP BY ResumeSource';
                                $result = DB::select($sql);
                                $i = 1;
                            @endphp
                            @foreach ($result as $row)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $row->ResumeSource }}</td>
                                    <td>{{ $row->total }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card mb-1">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="myTable1">
                        <thead>
                            <tr>
                                <th>Department</th>
                                <th>Company Careers Site</th>
                                <th>Naukri.Com</th>
                                <th>Linkedin</th>
                                <th>Walk-in</th>
                                <th>Reference for <br> VNR Employee</th>
                                <th>Placement Agencies</th>
                                <th>Campus</th>
                                <th>Others</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sql = "SELECT d.department_name,c.company_code,
                                            COUNT(CASE WHEN ResumeSource = '1' THEN '' END) as 'Company_Site',
                                            COUNT(CASE WHEN ResumeSource = '2' THEN '' END) as 'Naukri',
                                            COUNT(CASE WHEN ResumeSource = '3' THEN '' END) as 'LinkedIn',
                                            COUNT(CASE WHEN ResumeSource = '4' THEN '' END) as 'Walkin' ,
                                            COUNT(CASE WHEN ResumeSource = '5' THEN '' END) as 'Reference',
                                            COUNT(CASE WHEN ResumeSource = '6' THEN '' END) as 'Placement_Agencies',
                                            COUNT(CASE WHEN ResumeSource = '7' THEN '' END) as 'Campus',
                                            COUNT(CASE WHEN ResumeSource = '8' THEN '' END) as 'Others'
                                            FROM jobapply ja  LEFT JOIN core_department d ON d.id = ja.Department LEFT JOIN core_company c ON c.id = ja.Company GROUP BY ja.Department";
                                $result = DB::select($sql);
                                
                            @endphp
                            @foreach ($result as $row)
                                <tr class="text-center">
                                    <td style="text-align: left">{{$row->department_name}}</td>
                                    <td>{{$row->Company_Site}}</td>
                                    <td>{{$row->Naukri}}</td>
                                    <td>{{$row->LinkedIn}}</td>
                                    <td>{{$row->Walkin}}</td>
                                    <td>{{$row->Reference}}</td>
                                    <td>{{$row->Placement_Agencies}}</td>
                                    <td>{{$row->Campus}}</td>
                                    <td>{{$row->Others}}</td>
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
            $('#myTable').DataTable({

                ordering: false,
                searching: false,
                lengthChange: false,
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                info: false,
                paging: false,
                dom: 'Blfrtip',
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o"></i> Export',
                    titleAttr: 'Excel',
                    title: $('.download_label').html(),
                }, ],

            });
            $('#myTable1').DataTable({

                ordering: false,
                searching: false,
                lengthChange: false,
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                info: false,
                paging: false,
                dom: 'Blfrtip',
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o"></i> Export',
                    titleAttr: 'Excel',
                    title: $('.download_label').html(),
                }, ],

            });
           
        });


        function GetApplicationSource() {
            $('#myTable1').DataTable().draw(true);
        }
        //==================================Get Department List on Change Company========================//
        function GetDepartment() {
            var CompanyId = $('#Fill_Company').val();
            $.ajax({
                type: "GET",
                url: "{{ route('getDepartment') }}?CompanyId=" + CompanyId,
                beforeSend: function() {

                },
                success: function(res) {

                    if (res) {
                        $("#Fill_Department").empty();
                        $("#Fill_Department").append(
                            '<option value="" selected disabled >Select Department</option>');
                        $.each(res, function(key, value) {
                            $("#Fill_Department").append('<option value="' + value + '">' + key +
                                '</option>');
                        });
                    } else {
                        $("#Fill_Department").empty();
                    }
                }
            });
        }
        $(document).on('click', '#reset', function() {
            $('#Fill_Company').val('');
            $('#Fill_Department').val('');
            $('#myTable1').DataTable().draw(true);
        });
    </script>
@endsection
