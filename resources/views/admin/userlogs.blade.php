@php

@endphp
@extends('layouts.master')
@section('title', 'Dashboard')
@section('PageContent')
    <div class="page-content">
         <!--breadcrumb-->
         <div class="page-breadcrumb  d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Logbook</div>

          
        </div>
        <!--end breadcrumb-->

        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                    <table  class="table table-striped table-hover table-condensed" id="logtable">
                        <thead class="bg-primary text-light text-center">
                            
                            <th style="width: 5%">S.No</th>
                            <th style="width: 10%">Type</th>
                            <th>Subject</th>
                            <th>Date</th>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                              
                            @endphp
                            @foreach ($logs as $item)
                                <tr>
                                    <td class="text-center">{{ $i }}</td>
                                    <td class="text-center">{{$item->type}}</td>
                                    <td class="text-left">{{$item->subject}}</td>
                                    <td class="text-center">{{date('d-m-Y',strtotime($item->created_at))}}</td>
                                </tr>
                                @php
                                    $i++;
                                @endphp
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
    <script>
        $(document).ready(function() {
            $('#logtable').DataTable();
        });
    </script>
@endsection
