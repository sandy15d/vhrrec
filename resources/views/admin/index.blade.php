@php
$NewMRFSQL = DB::table('manpowerrequisition')
    ->where('Status', 'New')
    ->get();
$NewMRF = $NewMRFSQL->count();

$ActiveSQL = DB::table('manpowerrequisition')
    ->where('MRFId', '!=', 0)
    ->where('Status', '!=', 'Close')
    ->where('Status', 'Approved')
    ->get();
$ActiveMRF = $ActiveSQL->count();

$CloseActive = DB::table('manpowerrequisition')
    ->where('MRFId', '!=', 0)
    ->where('Status', 'Close')
    ->get();
$CloseMRF = $CloseActive->count();
@endphp
@extends('layouts.master')
@section('title', 'Dashboard')
@section('PageContent')
<div class="page-content">

    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
        <div class="col">
            <a href="/admin/mrf">
                <div class="card radius-10 border-start border-0 border-3 border-success">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">New MRF's</p>
                                <h4 class="my-1 text-success">{{ $NewMRF }}</h4>

                            </div>
                            <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto"><i
                                    class='bx bxs-comment-add'></i>
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
                            <p class="mb-0 text-secondary">Closed MRF's</p>
                            <h4 class="my-1 text-danger">{{ $CloseMRF }}</h4>

                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-gradient-bloody text-white ms-auto"><i
                                class='bx bxs-comment-minus'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 border-start border-0 border-3 border-info">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Active MRF's</p>
                            <h4 class="my-1 text-info">{{ $ActiveMRF }}</h4>

                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto"><i
                                class='bx bxs-bar-chart-alt-2'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 border-start border-0 border-3 border-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total Candidates</p>
                            <h4 class="my-1 text-warning">837</h4>

                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-gradient-blooker text-white ms-auto"><i
                                class='bx bxs-group'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end row-->

    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Resume Pending for Tech. Screening</p>

                        </div>
                        <div class="ms-auto">
                            <h4 class="my-1 text-primary">23</h4>
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
                            <p class="mb-0 text-secondary">Upcoming Interviews</p>

                        </div>
                        <div class="ms-auto">
                            <h4 class="my-1 text-info">23</h4>
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
                            <p class="mb-0 text-secondary">Offer Letter Status Pending</p>

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
                            <p class="mb-0 text-secondary">Upcoming Joining's</p>

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

    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-condensed" id="recruitertable"
                            style="width: 100%">
                            <thead>
                                <tr>
                                    <th class="th-sm">S.No</th>
                                    <th>Recruiter</th>
                                    <th>Active MRF's</th>
                                    <th>View</th>
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
</div>
@endsection
