@php

$query = DB::table('screening')
    ->Join('jobapply', 'screening.JAId', '=', 'jobapply.JAId')
    ->Join('jobpost', 'jobapply.JPId', '=', 'jobpost.JPId')
    ->Join('manpowerrequisition', 'jobpost.MRFId', '=', 'manpowerrequisition.MRFId')
    ->Join('jobcandidates', 'jobapply.JCId', '=', 'jobcandidates.JCId')
    ->where('jobpost.Status', 'Open')
    ->whereNull('screening.IntervStatus')
    ->where(function ($query) {
        $query->where('manpowerrequisition.CreatedBy', Auth::user()->id)->orWhere('manpowerrequisition.OnBehalf', Auth::user()->id);
    })

    ->orderBy('screening.IntervDt', 'asc')
    ->select('jobcandidates.FName', 'jobcandidates.MName', 'jobcandidates.LName', 'jobpost.Title', 'screening.IntervDt', 'screening.IntervTime', 'screening.IntervPanel')
    ->get();

@endphp
@extends('layouts.master')
@section('title', 'Interview Schedule')
@section('PageContent')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Interview Schedule</div>
        </div>
        <!--end breadcrumb-->

        <div class="card  border-top border-0 border-4 border-primary">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-condensed table-bordered" style="width: 100%">
                        <thead class="bg-primary text-light text-center">
                            <tr>
                                <td class="td-sm">S.No</td>
                                <td>Candidate Name</td>
                                <td>Interview for Post</td>
                                <td>Date of Interview</td>
                                <td>Timings</td>
                                <td>Panel Member</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($query as $item => $value)
                                <tr>
                                    <td class="text-center">{{ $i }}</td>
                                    <td>{{ $value->FName }} {{ $value->MName }} {{ $value->LName }}</td>
                                    <td>{{ $value->Title }}</td>
                                    <td class="text-center">{{ date('d-m-Y', strtotime($value->IntervDt)) }}</td>
                                    <td class="text-center">{{ date('h:i:s a', strtotime($value->IntervTime)) }}</td>
                                    <td>{{ $value->IntervPanel }}</td>
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
@endsection

@section('scriptsection')

@endsection
