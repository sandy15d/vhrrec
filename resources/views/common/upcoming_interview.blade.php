@php
DB::enableQueryLog();
$query = DB::table('screening')
    ->Join('jobapply', 'screening.JAId', '=', 'jobapply.JAId')
    ->Join('jobpost', 'jobapply.JPId', '=', 'jobpost.JPId')
    ->Join('jobcandidates', 'jobapply.JCId', '=', 'jobcandidates.JCId')
    ->where('jobpost.Status', 'Open')
    ->where('screening.ScreenStatus', 'Shortlist')
    ->whereNull('screening.IntervStatus')
    ->orderBy('screening.IntervDt', 'asc')
    ->select('jobcandidates.ReferenceNo', 'jobcandidates.FName', 'jobcandidates.MName', 'jobcandidates.LName', 'jobpost.Title', 'screening.IntervDt', 'screening.IntervTime', 'screening.IntervPanel', 'screening.ScrDpt', 'screening.IntervLoc')
    ->get();
 $sql = DB::getQueryLog();

@endphp
@extends('layouts.master')
@section('title', 'Upcoming Interviews')
@section('PageContent')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Upcoming Interviews</div>
        </div>
        <!--end breadcrumb-->

        <div class="card  border-top border-0 border-4 border-primary">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-condensed table-bordered" style="width: 100%">
                        <thead class="bg-primary text-light text-center">
                            <tr>
                                <td class="td-sm">S.No</td>
                                <td>Reference No</td>
                                <td>Candidate Name</td>
                                <td>Department</td>
                                <td>Interview for Post</td>
                                <td>Date of Interview</td>
                                <td>Interview Location</td>
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
                                    <td>{{ $value->ReferenceNo }}</td>
                                    <td>{{ $value->FName }} {{ $value->MName }} {{ $value->LName }}</td>
                                    <td>{{ getDepartmentCode($value->ScrDpt) }}</td>
                                    <td>{{ $value->Title }}</td>
                                    <td class="text-center">{{ date('d-m-Y', strtotime($value->IntervDt)) }}
                                        {{ date('h:i:s a', strtotime($value->IntervTime)) }}</td>
                                    <td class="text-center">{{ $value->IntervLoc }}</td>
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
