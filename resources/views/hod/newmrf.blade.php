@extends('layouts.master')
@section('title', 'New MRF')
@section('PageContent')

    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">New MRF</div>
            <div class="ms-auto">
                <button class="btn btn--new btn-sm" id="addNewMRF" data-bs-toggle="modal"
                    data-bs-target="#addNewMRFModal">Add New</button>

            </div>
        </div>
        <!--end breadcrumb-->
        <hr />
        <div class="card border-top border-0 border-4 border-primary">
            <div class="card-body">
                <div class="border p-4 rounded">
                    <div class="card-title d-flex align-items-center">
                        <div><i class="bx bx-info-square me-1 font-20 text-primary"></i>
                        </div>
                        <h6 class="mb-0 text-primary">MRF Summary</h6>
                    </div>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover display compact" id="mrfsummarytable" style="width: 100%">
                            <thead>
                                <tr>
                                    <th class="th-sm">S.No</th>
                                    <th class="th-sm">Type</th>
                                    <th>Job Code</th>
                                    <th>Designation</th>
                                    <th>Status</th>
                                    <th>MRF Date</th>
                                    <th>Details</th>
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

    <div class="modal fade" id="addNewMRFModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">New Manpower Requisition Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('addNewMrf') }}" method="POST" id="addNewMrfForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="Reason">Reason For Creating New Position<font class="text-danger">*</font></label>
                            <textarea class="form-control" rows="1" name="Reason" tabindex="1" autofocus></textarea>
                            <span class="text-danger error-text Reason_error"></span>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="Company">Company<font class="text-danger">*</font></label>
                                    <select id="Company" name="Company" class="form-control form-select form-select-sm">
                                        <option value="" selected disabled>Select Company</option>
                                        @foreach ($company_list as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error-text Company_error"></span>
                                </div>
                            </div>
                            <div class="col-3">

                                <div class="form-group">
                                    <label for="Department">Department<font class="text-danger">*</font></label>
                                    <div class="spinner-border text-primary d-none" role="status" id="DeptLoader"> <span
                                            class="visually-hidden">Loading...</span>
                                    </div>
                                    <select id="Department" name="Department"
                                        class="form-control form-select form-select-sm">
                                        <option value="" selected disabled >Select Department</option>
                                    </select>
                                    <span class="text-danger error-text Department_error"></span>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <div class="spinner-border text-primary d-none" role="status" id="DesigLoader"> <span
                                            class="visually-hidden">Loading...</span>
                                    </div>
                                    <label for="Designation">Designation<font class="text-danger">*</font></label>
                                    <select id="Designation" name="Designation"
                                        class="form-control form-select form-select-sm">
                                        <option value="" selected disabled >Select Designation</option>
                                    </select>
                                    <span class="text-danger error-text Designation_error"></span>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <div class="spinner-border text-primary d-none" role="status" id="RepLoader"> <span
                                        class="visually-hidden">Loading...</span>
                                </div>
                                    <label for="ReportingManager">Reporting Manager<font class="text-danger">*</font>
                                    </label>
                                    <select id="ReportingManager" name="ReportingManager"
                                        class="form-control form-select form-select-sm">
                                        <option value="" selected disabled >Select Reporting Manager</option>
                                    </select>
                                    <span class="text-danger error-text ReportingManager_error"></span>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="SaveNewMrf">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scriptsection')
    <script>
        //==================================Get Department List on Change Company========================//
        $('#Company').change(function() {
            var CompanyId = $(this).val();
            if (CompanyId) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('getDepartment') }}?CompanyId=" + CompanyId,
                    beforeSend: function() {
                        $('#DeptLoader').removeClass('d-none');
                        $('#Department').addClass('d-none');
                    },
                    success: function(res) {
                        console.log(res);
                        if (res) {
                            $('#DeptLoader').addClass('d-none');
                            $('#Department').removeClass('d-none');
                            $("#Department").empty();
                            $("#Designation").empty();
                            $("#ReportingManager").empty();
                            $("#Department").append(
                                '<option value="" selected disabled >Select Department</option>');
                            $("#Designation").append(
                                '<option value="" selected disabled >Select Designation</option>');
                            $("#ReportingManager").append(
                                '<option value="" selected disabled >Select Reporting Manager</option>'
                                );
                            $.each(res, function(key, value) {
                                $("#Department").append('<option value="' + value + '">' + key +
                                    '</option>');
                            });

                        } else {
                            $("#Department").empty();
                        }
                    }
                });
            } else {
                $("#Department").empty();

            }
        });

        //===============================Ge Designation on Change of Department====================//
        $('#Department').change(function() {
            var DepartmentId = $(this).val();
            if (DepartmentId) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('getDesignation') }}?DepartmentId=" + DepartmentId,
                    beforeSend: function() {
                        $('#DesigLoader').removeClass('d-none');
                        $('#Designation').addClass('d-none');
                    },
                    success: function(res) {
                        console.log(res);
                        if (res) {
                            $('#DesigLoader').addClass('d-none');
                            $('#Designation').removeClass('d-none');
                            $("#Designation").empty();
                            $("#ReportingManager").empty();
                            $("#Designation").append(
                                '<option value="" selected disabled >Select Designation</option>');
                            $("#ReportingManager").append(
                                '<option value="" selected disabled >Select Reporting Manager</option>'
                                );
                            $.each(res, function(key, value) {
                                $("#Designation").append('<option value="' + value + '">' +
                                    key +
                                    '</option>');
                            });

                        } else {
                            $("#Designation").empty();
                        }
                    }
                });
            } else {
                $("#Designation").empty();

            }
        });

        //===============================Ge Reporting Manager on Change of Department====================//
        $('#Department').change(function() {
            var DepartmentId = $(this).val();
            if (DepartmentId) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('getReportingManager') }}?DepartmentId=" + DepartmentId,
                    beforeSend: function() {
                        $('#RepLoader').removeClass('d-none');
                        $('#ReportingManager').addClass('d-none');
                    },
                    success: function(res) {
                        console.log(res);
                        if (res) {
                            $('#RepLoader').addClass('d-none');
                            $('#ReportingManager').removeClass('d-none');
                            $("#ReportingManager").empty();
                            $("#ReportingManager").append(
                                '<option value="" selected disabled >Select Reporting Manager</option>'
                                );
                            $.each(res, function(key, value) {
                                $("#ReportingManager").append('<option value="' + value + '">' +
                                    key +
                                    '</option>');
                            });

                        } else {
                            $("#ReportingManager").empty();
                        }
                    }
                });
            } else {
                $("#ReportingManager").empty();

            }
        });

        //====================================== Add New MRF to the Database==========================//
        $('#addNewMrfForm').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {
                    $(form).find('span.error-text').text('');
                },
                success: function(data) {
                    if (data.status == 400) {
                        $.each(data.error, function(prefix, val) {
                            $(form).find('span.' + prefix + '_error').text(val[0]);
                        });
                    } else {
                        $(form)[0].reset();
                        $('#addNewMrfModal').modal('hide');
                        $('#mrfsummarytable').DataTable().ajax.reload(null, false);
                        toastr.success(data.msg);
                    }
                }
            });
        });
    </script>
@endsection
