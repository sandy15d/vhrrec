@extends('layouts.master')
@section('title', 'FIRO B Report')
@section('PageContent')

    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb  align-items-center mb-3">
            <div class="row mb-1">
                <div class="col-2 breadcrumb-title ">
                    FIRO B Reports
                </div>
            </div>
            <!--end breadcrumb-->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card border-top border-0 border-4 border-primary">
                        <div class="card-body">
                            <table class="table table-bordered d text-center">
                                <thead class="text-center ">
                                    <th>S.No</th>
                                    <th>Reference No</th>
                                    <th>Candidate Name</th>
                                    <th>Exam Date</th>
                                    <th>Result</th>
                                </thead>
                                <tbody>
                                    @php
                                        $i=0;
                                    @endphp
                                    @foreach ($report_list as $item=>$value)
                                        <tr>
                                            <td>{{++$i}}</td>
                                            <td>{{$value->ReferenceNo}}</td>
                                            <td>{{$value->FName}} {{$value->LName}}</td>
                                            <td>{{date('d-m-Y',strtotime($value->SubDate))}}</td>
                                            <td>  <span style="margin-left: 20px;"><a href="javascript:void(0);"
                                                onclick='window.open("{{ route('firob_result') }}?jcid={{ $value->JCId }}", "", "width=750,height=900");'>Result
                                                1</a> </span> | <span style="margin-left: 20px;"><a
                                                href="javascript:void(0);"
                                                onclick='window.open("{{ route('firob_result_summery') }}?jcid={{ $value->JCId }}", "", "width=750,height=900");'>Result
                                                2</a> </span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endsection

    @section('scriptsection')
        <script></script>
    @endsection