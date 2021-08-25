@extends('layouts.master')
@section('title', 'Education')
@section('PageContent')
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Allocated MRF Details</div>
    </div>
    <!--end breadcrumb-->
    <hr />
    <div class="card">
        <div class="card-body">
            <div class="row mb-1">
                <div class="col-3">
                    <button type="button" class="btn btn-primary btn-sm">Open MRF <span class="badge bg-warning text-dark" style="font-size: 10px;">4</span>
                    </button>
                    <button class="btn btn-secondary btn-sm pull-right">Closed MRF <span class="badge bg-warning text-dark" style="font-size: 10px;">4</span></button>
                </div>
              
                <div class="col-2">
                    <select name="Company" id="Company" class="form-select form-select-sm">
                        <option value="">Select Company</option>
                    </select>
                </div>
                <div class="col-2">

                    <select name="Department" id="Department" class="form-select form-select-sm">
                        <option value="">Select Department</option>
                    </select>
                </div>
                <div class="col-2">
                    <select name="Year" id="Year" class="form-select form-select-sm">
                        <option value="">Select Year</option>
                    </select>
                </div>
                <div class="col-2">
                    <select name="Month" id="Month" class="form-select form-select-sm">
                        <option value="">Select Month</option>
                    </select>
                </div>
                <div class="col-1">
                    <button type="reset" class="btn btn-danger btn-sm" id="reset"><i class="bx bx-refresh"></i></button>
                </div>
            </div>
            <hr />
            <div class="table-responsive">
                <table class="table  table-hover table-condensed table-bordered text-center" id="MRFTable"
                    style="width: 100%">
                    <thead>
                        <tr class="text-center">
                            <td></td>
                            <td class="th-sm">S.No</td>
                            <td>Type</td>
                            <td>JobCode</td>
                            <td>Department</td>
                            <td>Designation</td>
                            <td>Position</td>
                            <td>Location</td>
                            <td>Job Posting</td>
                            <td>View on Site</td>
                            <td>Details</td>
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
