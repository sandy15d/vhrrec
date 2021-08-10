@extends('layouts.master')
@section('title', 'MRF Details')
@section('PageContent')
<style>
    .table>:not(caption)>*>* {
        padding: 2px 1px;
    }

</style>
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">MRF Details</div>
    </div>
    <!--end breadcrumb-->
    <hr />
    <div class="card">
        <div class="card-body">
            <div class="row mb-1">
                <div class="col-2"></div>
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
                <div class="col-2">
                    <button type="reset" class="btn btn-danger btn-sm" id="reset"><i class="bx bx-refresh"></i></button>
                </div>
            </div>
            <hr />
            <div class="table-responsive">
                <table class="table  table-hover table-condensed table-bordered" id="MRFTable" style="width: 100%">
                    <thead>
                        <tr>
                            <td class="th-sm">S.No</td>
                            <td>Type</td>
                            <td>JobCode</td>
                            <td>Department</td>
                            <td>Designation</td>
                            <td>Position</td>
                            <td>Location</td>
                            <td>MRF Date</td>
                            <td>Created By</td>
                            <td>Status</td>
                            <td style="width: 200px;">Allocated Task to</td>
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

<div class="modal fade" id="editMRFModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info bg-gradient">
                <h5 class="modal-title text-white">View/Update MRF</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('editMRFAdmin') }}" method="POST" id="editMRFAdminForm">
                @csrf
                <div class="modal-body">
                    <table class="table borderless">
                        <tbody>
                            <tr>
                                <input type="hidden" name="MRFId" id="MRFId">
                                <th style="width:250px;">Reason for Creating New Position<font class="text-danger">*
                                    </font>
                                </th>
                                <td>
                                    <textarea class="form-control" rows="1" name="editReason" id="editReason"
                                        tabindex="1" autofocus></textarea>
                                    <span class="text-danger error-text editReason_error"></span>

                                </td>
                            </tr>
                            <tr>
                                <th>Company<font class="text-danger">*</font>
                                </th>
                                <td><select id="editCompany" name="editCompany"
                                        class="form-control form-select form-select-sm">
                                        <option value="" selected disabled>Select Company</option>
                                        @foreach ($company_list as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error-text editCompany_error"></span>
                                </td>
                            </tr>
                            <tr>
                                <th>Deartment<font class="text-danger">*</font>
                                </th>
                                <td>
                                    <div class="spinner-border text-primary d-none" role="status" id="DeptLoader"> <span
                                            class="visually-hidden">Loading...</span>
                                    </div>
                                    <select id="editDepartment" name="editDepartment" id="editDepartment"
                                        class="form-control form-select form-select-sm">
                                        <option value="" selected disabled>Select Department</option>
                                        @foreach ($department_list as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error-text editDepartment_error"></span>
                                </td>
                            </tr>
                            <tr>
                                <th>Designation<font class="text-danger">*</font>
                                </th>
                                <td>
                                    <div class="spinner-border text-primary d-none" role="status" id="DesigLoader">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <select id="editDesignation" name="editDesignation"
                                        class="form-control form-select form-select-sm">
                                        <option value="" selected disabled>Select Designation</option>
                                        @foreach ($designation_list as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error-text editDesignation_error"></span>
                                </td>
                            </tr>
                            <tr>
                                <th>Reporting Manager<font class="text-danger">*</font>
                                </th>
                                <td>
                                    <div class="spinner-border text-primary d-none" role="status" id="RepLoader"> <span
                                            class="visually-hidden">Loading...</span>
                                    </div>
                                    <select id="editReportingManager" name="editReportingManager"
                                        class="form-control form-select form-select-sm">
                                        <option value="" selected disabled>Select Reporting Manager</option>
                                        @foreach ($employee_list as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error-text editReportingManager_error"></span>
                                </td>
                            </tr>
                            <tr>
                                <th>Location & Man Power <font class="text-danger">*</font>
                                </th>
                                <td>
                                    <table class="table borderless" style="margin-bottom: 0px;">
                                        <tbody id="MulLocation">
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <th>Expected CTC (in Lacs) <font class="text-danger">*</font>
                                </th>
                                <td>
                                    <table class="table borderless" style="margin-bottom: 0px;">
                                        <tr>
                                            <td><input type="text" name="MinCTC" id="MinCTC"
                                                    class="form-control form-control-sm" placeholder="Min"></td>
                                            <td><input type="text" name="MaxCTC" id="MaxCTC"
                                                    class="form-control form-control-sm" placeholder="Max"> </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <th>Work Experience <font class="text-danger">*</font>
                                </th>
                                <td>
                                    <input type="text" name="WorkExp" id="WorkExp" class="form-control form-control-sm">
                                </td>
                            </tr>
                            <tr>
                                <th>Any Other Job-related information</th>
                                <td>
                                    <textarea name="JobInfo" id="JobInfo" class="form-control"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th>Desired Eductaion
                                </th>
                                <td>
                                    <table class="table borderless" style="margin-bottom: 0px;">
                                        <tbody id="MulEducation">
                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <th>Desired University/College</th>
                                <td>
                                    <select name="University[]" id="University"
                                        class="form-control form-select form-select-sm multiple-select"
                                        multiple="multiple">

                                        @foreach ($institute_list as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Key Position Criteria</th>
                                <td>

                                    <table class="table borderless" style="margin-bottom: 0px;">
                                        <tbody id="MulKP">
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <th>Remarks for HR</th>
                                <td>
                                    <textarea name="Remark" id="Remark" class="form-control"></textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="UpdateMRF">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scriptsection')
<script>
    CKEDITOR.replace('JobInfo', {
        height: 100
    });
    $(document).ready(function() {

        $('#MRFTable').DataTable({
            processing: true,
            info: true,
            ajax: "{{ route('getAllMRF') }}",
            columns: [{
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
                    data: 'DepartmentId',
                    name: 'DepartmentId'
                },
                {
                    data: 'DesigId',
                    name: 'DesigId'
                },
                {
                    data: 'Positions',
                    name: 'Positions'
                },
                {
                    data: 'LocationIds',
                    name: 'LocationIds'
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
                    data: 'Status',
                    name: 'Status'
                },
                {
                    data: 'Allocated',
                    name: 'Allocated'
                },
                {
                    data: 'Details',
                    name: 'Details'
                }

            ],

        });
    });

    function editmstst(MRFId, th) {
        $('#mrfstatus' + MRFId).prop('disabled', false);
    }

    function editmrf(id) {
        $('#allocate' + id).prop("disabled", false);
    }

    function chngmrfsts(MRFId, va) {
        var url = '<?= route('updateMRFStatus') ?>';
        if (va == 'Hold' || va == 'Rejected') {
            var RemarkHr = prompt("Please Enter Remark");
            if (RemarkHr != null) {
                $.post(url, {
                    MRFId: MRFId,
                    va: va,
                    RemarkHr: RemarkHr
                }, function(data) {
                    if (data.status == 200) {
                        $('#MRFTable').DataTable().ajax.reload(null, false);
                        toastr.success(data.msg);
                    } else {
                        toastr.error(data.msg);
                    }
                }, 'json');
            }
        } else {
            var RemarkHr = '';
            $.post(url, {
                MRFId: MRFId,
                va: va,
                RemarkHr: RemarkHr
            }, function(data) {
                if (data.status == 200) {
                    $('#MRFTable').DataTable().ajax.reload(null, false);
                    toastr.success(data.msg);
                } else {
                    toastr.error(data.msg);
                }
            }, 'json');

        }

    }

    function allocatemrf(MRFId, va) {
        var url = '<?= route('allocateMRF') ?>';
        $.post(url, {
            MRFId: MRFId,
            va: va,
        }, function(data) {
            if (data.status == 200) {
                $('#MRFTable').DataTable().ajax.reload(null, false);
                toastr.success(data.msg);
            } else {
                toastr.error(data.msg);
            }
        }, 'json');
    }

    $(document).on('click', '#reset', function() {
        location.reload();
    });
    $(document).on('click', '#viewMRF', function() {
        var MRFId = $(this).data('id');
        $.post('<?= route('getMRFDetails') ?>', {
            MRFId: MRFId
        }, function(data) {
            $('#editMRFModal').find('input[name="MRFId"]').val(data.MRFDetails.MRFId);
            $('#editReason').val(data.MRFDetails.Reason);
            $('#editCompany').val(data.MRFDetails.CompanyId);
            $('#editDepartment').val(data.MRFDetails.DepartmentId);
            $('#editDesignation').val(data.MRFDetails.DesigId);
            $('#editReportingManager').val(data.MRFDetails.Reporting);
            $('#MinCTC').val(data.MRFDetails.MinCTC);
            $('#MaxCTC').val(data.MRFDetails.MaxCTC);
            $('#WorkExp').val(data.MRFDetails.WorkExp);
          //  $('#JobInfo').val(data.MRFDetails.Info);
            CKEDITOR.instances['JobInfo'].setData(data.MRFDetails.Info);
            $('#editMRFModal').modal('show');
        }, 'json');
    });




    //==================================Get Department List on Change Company========================//
    $('#editCompany').change(function() {
        var CompanyId = $(this).val();
        if (CompanyId) {
            $.ajax({
                type: "GET",
                url: "{{ route('getDepartmentMRFAdmin') }}?CompanyId=" + CompanyId,
                beforeSend: function() {
                    $('#DeptLoader').removeClass('d-none');
                    $('#editDepartment').addClass('d-none');
                },
                success: function(res) {

                    if (res) {
                        $('#DeptLoader').addClass('d-none');
                        $('#editDepartment').removeClass('d-none');
                        $("#editDepartment").empty();
                        $("#editDesignation").empty();
                        $("#editReportingManager").empty();
                        $("#editDepartment").append(
                            '<option value="" selected disabled >Select Department</option>');
                        $("#editDesignation").append(
                            '<option value="" selected disabled >Select Designation</option>');
                        $("#editReportingManager").append(
                            '<option value="" selected disabled >Select Reporting Manager</option>'
                        );
                        $.each(res, function(key, value) {
                            $("#editDepartment").append('<option value="' + value + '">' +
                                key +
                                '</option>');
                        });

                    } else {
                        $("#editDepartment").empty();
                    }
                }
            });
        } else {
            $("#editDepartment").empty();

        }
    });

    //===============================Ge Designation on Change of Department====================//
    $('#editDepartment').change(function() {
        var DepartmentId = $(this).val();
        if (DepartmentId) {
            $.ajax({
                type: "GET",
                url: "{{ route('getDesignationMRFAdmin') }}?DepartmentId=" + DepartmentId,
                beforeSend: function() {
                    $('#DesigLoader').removeClass('d-none');
                    $('#editDesignation').addClass('d-none');
                },
                success: function(res) {

                    if (res) {
                        $('#DesigLoader').addClass('d-none');
                        $('#editDesignation').removeClass('d-none');
                        $("#editDesignation").empty();
                        $("#editReportingManager").empty();
                        $("#editDesignation").append(
                            '<option value="" selected disabled >Select Designation</option>');
                        $("#editReportingManager").append(
                            '<option value="" selected disabled >Select Reporting Manager</option>'
                        );
                        $.each(res, function(key, value) {
                            $("#editDesignation").append('<option value="' + value + '">' +
                                key +
                                '</option>');
                        });

                    } else {
                        $("#editDesignation").empty();
                    }
                }
            });
        } else {
            $("#editDesignation").empty();

        }
    });

    //===============================Ge Reporting Manager on Change of Department====================//
    $('#editDepartment').change(function() {
        var DepartmentId = $(this).val();
        if (DepartmentId) {
            $.ajax({
                type: "GET",
                url: "{{ route('getRepMgrMRFAdmin') }}?DepartmentId=" + DepartmentId,
                beforeSend: function() {
                    $('#RepLoader').removeClass('d-none');
                    $('#editReportingManager').addClass('d-none');
                },
                success: function(res) {

                    if (res) {
                        $('#RepLoader').addClass('d-none');
                        $('#editReportingManager').removeClass('d-none');
                        $("#editReportingManager").empty();
                        $("#editReportingManager").append(
                            '<option value="" selected disabled >Select Reporting Manager</option>'
                        );
                        $.each(res, function(key, value) {
                            $("#editReportingManager").append('<option value="' + value +
                                '">' +
                                key +
                                '</option>');
                        });

                    } else {
                        $("#editReportingManager").empty();
                    }
                }
            });
        } else {
            $("#editReportingManager").empty();

        }
    });
</script>

@endsection
