@extends('layouts.master')

@section('title', 'New MRF')
@section('PageContent')
<style>
    .table>:not(caption)>*>* {
        padding: 1px 1px;
    }

</style>

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
            <div class="card-title d-flex align-items-center">
                <div><i class="bx bx-info-square me-1 font-20 text-primary"></i>
                </div>
                <h6 class="mb-0 text-primary">MRF Summary</h6>
            </div>
            <hr>
            <div class="table-responsive">
                <table class="table table-striped table-hover display compact text-center table-bordered"
                    id="mrfsummarytable" style="width: 100%">
                    <thead>
                        <tr>
                            <th class="th-sm">S.No</th>
                            <th class="th-sm">Type</th>
                            <th>Job Code</th>
                            <th>Designation</th>
                            <th>Status</th>
                            <th>MRF Date</th>

                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="addNewMRFModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info bg-gradient">
                <h5 class="modal-title text-white">New Manpower Requisition Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('addNewMrf') }}" method="POST" id="addNewMrfForm">
                @csrf
                <div class="modal-body">
                    <table class="table borderless">
                        <tbody>
                            <tr>
                                <th style="width:250px;">Reason for Creating New Position<font class="text-danger">*
                                    </font>
                                </th>
                                <td>
                                    <textarea class="form-control" rows="1" name="Reason" tabindex="1"
                                        autofocus></textarea>
                                    <span class="text-danger error-text Reason_error"></span>

                                </td>
                            </tr>
                            <tr>
                                <th>Company<font class="text-danger">*</font>
                                </th>
                                <td><select id="Company" name="Company" class="form-control form-select form-select-sm">
                                        <option value="" selected disabled>Select Company</option>
                                        @foreach ($company_list as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error-text Company_error"></span>
                                </td>
                            </tr>
                            <tr>
                                <th>Deartment<font class="text-danger">*</font>
                                </th>
                                <td>
                                    <div class="spinner-border text-primary d-none" role="status" id="DeptLoader"> <span
                                            class="visually-hidden">Loading...</span>
                                    </div>
                                    <select id="Department" name="Department"
                                        class="form-control form-select form-select-sm">
                                        <option value="" selected disabled>Select Department</option>
                                    </select>
                                    <span class="text-danger error-text Department_error"></span>
                                </td>
                            </tr>
                            <tr>
                                <th>Designation<font class="text-danger">*</font>
                                </th>
                                <td>
                                    <div class="spinner-border text-primary d-none" role="status" id="DesigLoader">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <select id="Designation" name="Designation"
                                        class="form-control form-select form-select-sm">
                                        <option value="" selected disabled>Select Designation</option>
                                    </select>
                                    <span class="text-danger error-text Designation_error"></span>
                                </td>
                            </tr>
                            <tr>
                                <th>Reporting Manager<font class="text-danger">*</font>
                                </th>
                                <td>
                                    <div class="spinner-border text-primary d-none" role="status" id="RepLoader"> <span
                                            class="visually-hidden">Loading...</span>
                                    </div>
                                    <select id="ReportingManager" name="ReportingManager"
                                        class="form-control form-select form-select-sm">
                                        <option value="" selected disabled>Select Reporting Manager</option>
                                    </select>
                                    <span class="text-danger error-text ReportingManager_error"></span>
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
                                <th>Desired CTC (in Rs.) <font class="text-danger">*</font>
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
                                <th>Work Experience <font class="text-danger">*</font>
                                </th>
                                <td>
                                    <input type="text" name="WorkExp" id="WorkExp" class="form-control form-control-sm">
                                </td>
                            </tr>
                            <tr>
                                <th>Job Description</th>
                                <td>
                                    <textarea name="JobInfo" id="JobInfo" class="JobInfo"></textarea>
                                </td>
                            </tr>
                          

                         
                            <tr>
                                <th>Mandatory Requirements</th>
                                <td>

                                    <table class="table borderless" style="margin-bottom: 0px;">
                                        <tbody id="MulKP">
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <th>Any Other Remark</th>
                                <td>
                                    <textarea name="Remark" id="Remark" class="form-control"></textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
    var StateList;
    var DistrictList;
    var EducationList;
    getState();

    function getState() {
        $.ajax({
            type: "GET",
            url: "{{ route('getState') }}",
            async: false,
            success: function(res) {

                if (res) {
                    $.each(res, function(key, value) {
                        StateList = StateList + '<option value="' + value + '">' + key +
                            '</option>';
                    });

                }
            }
        });
    }

    getEducation();

    function getEducation() {
        $.ajax({
            type: "GET",
            url: "{{ route('getEducation') }}",
            async: false,
            success: function(res) {

                if (res) {
                    $.each(res, function(key, value) {
                        EducationList = EducationList + '<option value="' + value + '">' + key +
                            '</option>';
                    });

                }
            }
        });
    }

    //=========================Start multiple Location==================
    var LocCount = 1;
    mulLocation(LocCount);

    function mulLocation(number) {
        x = '<tr>';
        x += '<td >' +
            ' <select  name="State[]" id="State' +
            number +
            '" class="form-control form-select form-select-sm" onchange="getLocation(this.value,' + number + ')">' +
            '  <option value="" selected disabled>Select State</option>' + StateList +
            '</select>' +
            ' <span class="text-danger error-text State' + number + '_error"></span>' +
            '</td>';
        x += '<td>' +
            '<div class="spinner-border text-primary d-none" role="status" id="LocLoader' + number +
            '"> <span class="visually-hidden">Loading...</span></div>' +
            '       <select  id="City' + number + '" name="City[]" class="form-control form-select form-select-sm">' +
            '    <option value="" selected disabled>Select City</option>' +
            '</select>' +
            '<span class="text-danger error-text City' + number + '_error"></span>' +
            '</td>';
        x += '<td>' +
            '  <input type="text" name="ManPower[]" id="ManPower' + number +
            '" class="form-control form-control-sm" style="width:130px" placeholder="No. of Manpower">' +
            '<span class="text-danger error-text ManPower' + number + '_error"></span>' +
            '</td>';

        if (number > 1) {
            x +=
                '<td><button type="button" name="remove" id="" class="btn btn-danger btn-xs  removeLocation">Remove</td></tr>';
            $('#MulLocation').append(x);
        } else {
            x +=
                '<td><button type="button" name="add" id="addLocation" class="btn btn-warning btn-sm ">Add</button></td></tr>';
            $('#MulLocation').html(x);
        }
    }

    $(document).on('click', '#addLocation', function() {
        LocCount++;
        mulLocation(LocCount);
    });

    $(document).on('click', '.removeLocation', function() {
        LocCount--;
        $(this).closest("tr").remove();
    });
    //===========================End Multiple Location===========================//

    //-------------------------------Start Multiple Education===========================//

    var EduCount = 1;
    mulEducation(EduCount);

    function mulEducation(num) {
        x = '<tr>';
        x += '<td >' +
            ' <select  name="Education[]" id="Education' +
            num +
            '" class="form-control form-select form-select-sm" onchange="getSpecialization(this.value,' + num + ')">' +
            '  <option value="" selected disabled>Select Education</option>' + EducationList +
            '</select>' +
            ' <span class="text-danger error-text Education' + num + '_error"></span>' +
            '</td>';
        x += '<td>' +
            '<div class="spinner-border text-primary d-none" role="status" id="SpeLoader' + num +
            '"> <span class="visually-hidden">Loading...</span></div>' +
            '       <select  id="Specialization' + num +
            '" name="Specialization[]" class="form-control form-select form-select-sm">' +
            '    <option value="" selected disabled>Select Specialization</option>' +
            '</select>' +
            '<span class="text-danger error-text Specialization' + num + '_error"></span>' +
            '</td>';


        if (num > 1) {
            x +=
                '<td><button type="button" name="remove" id="" class="btn btn-danger btn-xs  removeEducation">Remove</td></tr>';
            $('#MulEducation').append(x);
        } else {
            x +=
                '<td><button type="button" name="add" id="addEducation" class="btn btn-warning btn-sm ">Add</button></td></tr>';
            $('#MulEducation').html(x);
        }
    }

    $(document).on('click', '#addEducation', function() {
        EduCount++;
        mulEducation(EduCount);
    });

    $(document).on('click', '.removeEducation', function() {
        EduCount--;
        $(this).closest("tr").remove();
    });
    //===========================End Multiple Location=====================================//
    //=====================Start KeyPosition Criteria========================//


    var KPCount = 1;


    mulKP();

    function mulKP(n) {
        x = '<tr>';
        x += '<td >' +
            '<input type="text" class="form-control form-control-sm" id="KeyPosition' + n + '" name="KeyPosition[]">' +
            '</td>';

        if (n > 1) {
            x +=
                '<td><button type="button" name="remove" id="" class="btn btn-danger btn-xs  removeKP">Remove</td></tr>';
            $('#MulKP').append(x);
        } else {
            x +=
                '<td><button type="button" name="add" id="addKP" class="btn btn-warning btn-sm ">Add</button></td></tr>';
            $('#MulKP').html(x);
        }
    }
    $(document).on('click', '#addKP', function() {
        KPCount++;
        mulKP(KPCount);
    });

    $(document).on('click', '.removeKP', function() {
        KPCount--;
        $(this).closest("tr").remove();
    });
    //=====================End KP========================
    function getLocation(StateId, No) {
        var StateId = StateId;
        var No = No;
        $.ajax({
            type: "GET",
            url: "{{ route('getDistrict') }}?StateId=" + StateId,
            async: false,
            beforeSend: function() {
                $('#LocLoader' + No).removeClass('d-none');
                $('#City' + No).addClass('d-none');
            },

            success: function(res) {

                if (res) {
                    $('#LocLoader' + No).addClass('d-none');
                    $('#City' + No).removeClass('d-none');
                    $("#City" + No).empty();
                    $("#City" + No).append(
                        '<option value="" selected disabled >Select City</option>');

                    $.each(res, function(key, value) {
                        $("#City" + No).append('<option value="' + value + '">' + key +
                            '</option>');
                    });

                } else {
                    $("#City" + No).empty();
                }
            }
        });
    }


    function getSpecialization(EducationId, No) {
        var EducationId = EducationId;
        var No = No;
        $.ajax({
            type: "GET",
            url: "{{ route('getSpecialization') }}?EducationId=" + EducationId,
            async: false,
            beforeSend: function() {
                $('#SpeLoader' + No).removeClass('d-none');
                $('#Specialization' + No).addClass('d-none');
            },

            success: function(res) {

                if (res) {
                    $('#SpeLoader' + No).addClass('d-none');
                    $('#Specialization' + No).removeClass('d-none');
                    $("#Specialization" + No).empty();
                    $("#Specialization" + No).append(
                        '<option value="" selected disabled >Select Specialization</option>');

                    $.each(res, function(key, value) {
                        $("#Specialization" + No).append('<option value="' + value + '">' + key +
                            '</option>');
                    });
                    $("#Specialization" + No).append('<option value="0">Other</option>');


                } else {
                    $("#Specialization" + No).empty();
                }
            }
        });
    }
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


    $("#addNewMRFModal").on('shown.bs.modal', function() {
        CKEDITOR.replace('JobInfo');
    });
    //====================================== Add New MRF to the Database==========================//
    $('#addNewMrfForm').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
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
                    $('#addNewMRFModal').modal('hide');
                    $('#mrfsummarytable').DataTable().ajax.reload(null, false);
                    toastr.success(data.msg);
                }
            }
        });
    });
    $('#mrfsummarytable').DataTable({
        processing: true,
        info: true,
        ajax: "{{ route('getAllMRFCreatedByMe') }}",
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
                data: 'DesigName',
                name: 'DesigName'
            },


            {
                data: 'Status',
                name: 'Status'
            },

            {
                data: 'MRFDate',
                name: 'MRFDate'
            },

            {
                data: 'actions',
                name: 'actions'
            }


        ],


    });
</script>
@endsection
