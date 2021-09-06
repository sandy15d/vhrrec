@extends('layouts.master')
@section('title', 'MRF Allocated')
@section('PageContent')
    @php
    $company_list = DB::table('master_company')
        ->where('Status', 'A')
        ->orderBy('CompanyCode', 'desc')
        ->pluck('CompanyCode', 'CompanyId');
    $months = [1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'];

    $CloseActive = DB::table('manpowerrequisition')
        ->where('Allocated', Auth::user()->id)
        ->where('Status', 'Close')
        ->get();
    $CloseMRF = $CloseActive->count();

    $OpenMRFSQL = DB::table('manpowerrequisition')
        ->where('Allocated', Auth::user()->id)
        ->where('Status', '!=', 'Close')
        ->get();
    $OpenMRF = $OpenMRFSQL->count();
    @endphp
    <style>
        .table>:not(caption)>*>* {
            padding: 2px 1px;
        }

    </style>
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3 download_label">Allocated MRF Details</div>
        </div>
        <!--end breadcrumb-->
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="row mb-1">
                    <div class="col-3">
                        <button type="button" class="btn btn-primary btn-sm" id="openMrf" data-status='Open'>Open MRF <span
                                class="badge bg-warning text-dark" style="font-size: 10px;">{{ $OpenMRF }}</span>
                        </button>
                        <button class="btn btn-outline-primary btn-sm pull-right" data-status='Close' id="closedMrf">Closed
                            MRF <span class="badge bg-warning text-dark"
                                style="font-size: 10px;">{{ $CloseMRF }}</span></button>
                    </div>

                    <div class="col-2">
                        <select name="Company" id="Company" class="form-select form-select-sm"
                            onchange="GetAllocatedMrf(); GetDepartment();">
                            <option value="">Select Company</option>
                            @foreach ($company_list as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-2">

                        <select name="Department" id="Department" class="form-select form-select-sm"
                            onchange="GetAllocatedMrf();">
                            <option value="">Select Department</option>

                        </select>
                    </div>
                    <div class="col-2">
                        <select name="Year" id="Year" class="form-select form-select-sm" onchange="GetAllocatedMrf();">
                            <option value="">Select Year</option>
                            @for ($i = 2021; $i <= date('Y'); $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-2">
                        <select name="Month" id="Month" class="form-select form-select-sm" onchange="GetAllocatedMrf();">
                            <option value="">Select Month</option>
                            @foreach ($months as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-1">
                        <button type="reset" class="btn btn-danger btn-sm" id="reset"><i
                                class="bx bx-refresh"></i></button>
                    </div>
                </div>
                <hr />
                <div>
                    <table class="table  table-hover table-striped table-condensed align-middle text-center" id="MRFTable"
                        style="width: 100%">
                        <thead class="text-center">
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
    <div class="modal fade" id="createpostmodal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info bg-gradient">
                    <h5 class="modal-title text-white">Create Job Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('createJobPost') }}" method="POST" id="createJobPostForm">
                    @csrf
                    <div class="modal-body">
                        <table class="table borderless">
                            <tbody>
                                <tr>
                                    <th style="width:250px;">Designation<font class="text-danger">*
                                        </font>
                                    </th>
                                    <td>
                                        <input type="hidden" name="MRFId" id="MRFId">
                                        <input type="text" name="Designation" id="Designation"
                                            class="form-control form-control-sm" readonly>
                                        <span class="text-danger error-text Designation_error"></span>

                                    </td>
                                </tr>
                                <tr>
                                    <th>Job Code <font class="text-danger">*</font>
                                    </th>
                                    <td>
                                        <input type="text" name="JobCode" id="JobCode" class="form-control form-control-sm"
                                            readonly>
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
                                        <button type="button" name="add" id="addKP"
                                            class="btn btn-warning btn-xs mb-2 mt-2"><i class="bx bx-plus"></i></button>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="CreateJobPost">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editMRFModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info bg-gradient">
                <h5 class="modal-title text-white">View MRF Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="editMRFAdminForm">
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
                                    <textarea name="JobDescription" id="JobDescription" class="form-control"></textarea>
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
                                        <tbody id="KeyPositionCriteria">
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

            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>
@endsection
@section('scriptsection')
    <script>
        CKEDITOR.replace('JobInfo');
        CKEDITOR.replace('JobDescription');

        var MrfStatus = 'Open';
        $('#MRFTable').DataTable({
            processing: true,
            serverSide: true,
            info: true,
            searching: false,
            dom: 'Bfrtip',
            lengthChange: false,
            buttons: [

                {
                    extend: 'copyHtml5',
                    text: '<i class="fa fa-files-o"></i>',
                    titleAttr: 'Copy',
                    title: $('.download_label').html(),
                    exportOptions: {
                        columns: ':visible'
                    }
                },

                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o"></i>',
                    titleAttr: 'Excel',
                    title: $('.download_label').html(),
                    exportOptions: {
                        columns: ':visible'

                    }
                },

                {
                    extend: 'csvHtml5',
                    text: '<i class="fa fa-file-text-o"></i>',
                    titleAttr: 'CSV',
                    title: $('.download_label').html(),
                    exportOptions: {
                        columns: ':visible'
                    }
                },

                {
                    extend: 'pdfHtml5',
                    text: '<i class="fa fa-file-pdf-o"></i>',
                    titleAttr: 'PDF',
                    title: $('.download_label').html(),
                    exportOptions: {
                        columns: ':visible'

                    }
                },

                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i>',
                    titleAttr: 'Print',
                    title: $('.download_label').html(),
                    customize: function(win) {
                        $(win.document.body)
                            .css('font-size', '10pt');

                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    },
                    exportOptions: {
                        columns: ':visible'
                    }
                },

                {
                    extend: 'colvis',
                    text: '<i class="fa fa-columns"></i>',
                    titleAttr: 'Columns',
                    title: $('.download_label').html(),
                    postfixButtons: ['colvisRestore']
                },
            ],
            ajax: {
                url: "{{ route('getAllAllocatedMRF') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: function(d) {
                    d.Company = $('#Company').val();
                    d.Department = $('#Department').val();
                    d.Year = $('#Year').val();
                    d.Month = $('#Month').val();
                    d.MrfStatus = MrfStatus;
                },
                type: 'POST',
                dataType: "JSON",
            },
            columns: [

                {
                    data: 'chk',
                    name: 'chk'
                },
                {
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
                    data: 'DepartmentCode',
                    name: 'DepartmentCode'
                },
                {
                    data: 'DesigCode',
                    name: 'DesigCode'
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
                    data: 'JobPost',
                    name: 'JobPost'
                },
                {
                    data: 'JobShow',
                    name: 'JobShow'
                },

                {
                    data: 'details',
                    name: 'details'
                }
            ],

        });

        function GetAllocatedMrf() {
            $('#MRFTable').DataTable().draw(true);
            //$('#MRFTable').DataTable().ajax.reload(null, false);
        }


        $(document).on('click', '#openMrf', function() {
            MrfStatus = 'Open';
            $('#openMrf').removeClass('btn-outline-primary');
            $('#closedMrf').removeClass('btn-primary');
            $('#closedMrf').addClass('btn-outline-primary');
            $('#openMrf').addClass('btn-primary');
            GetAllocatedMrf();
        });

        $(document).on('click', '#closedMrf', function() {

            MrfStatus = 'Close';
            $('#closedMrf').removeClass('btn-outline-primary');
            $('#openMrf').removeClass('btn-primary');
            $('#openMrf').addClass('btn-outline-primary');
            $('#closedMrf').addClass('btn-primary');
            GetAllocatedMrf();
        });

        function GetDepartment() {
            var CompanyId = $('#Company').val();
            $.ajax({
                type: "GET",
                url: "{{ route('getDepartment') }}?CompanyId=" + CompanyId,
                beforeSend: function() {

                },
                success: function(res) {

                    if (res) {
                        $("#Department").empty();
                        $("#Department").append(
                            '<option value="" selected disabled >Select Department</option>');
                        $.each(res, function(key, value) {
                            $("#Department").append('<option value="' + value + '">' + key +
                                '</option>');
                        });
                    } else {
                        $("#Department").empty();
                    }
                }
            });
        }


        $(document).on('click', '.select_all', function() {
            if ($(this).prop("checked") == true) {
                $(this).closest("tr").addClass("bg-secondary bg-gradient text-light");
            } else {
                $(this).closest("tr").removeClass("bg-secondary bg-gradient text-light");
            }
        });

        $(document).on('click', '#reset', function() {
            window.location.reload();
        });

        var KPCount = 1;


        mulKP();

        function mulKP(n) {
            x = '<tr>';
            x += '<td >' +
                '<input type="text" class="form-control form-control-sm" id="KeyPosition' + n + '" name="KeyPosition[]">' +
                '</td>';

            if (n > 1) {
                x +=
                    '<td><button type="button" name="remove" id="" class="btn btn-danger btn-xs  removeKP"><i class="bx bx-x"></td></tr>';
                $('#MulKP').append(x);
            } else {
                x +=
                    '';
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

        function getDetailForJobPost(MRFId) {
            var MRFId = MRFId;
            $.post('<?= route('getDetailForJobPost') ?>', {
                MRFId: MRFId
            }, function(data) {

                $('#MRFId').val(data.MRFDetails.MRFId);
                $('#Designation').val(data.Designation);
                $('#JobCode').val(data.MRFDetails.JobCode);

                CKEDITOR.instances['JobInfo'].setData(data.MRFDetails.Info);

                KPCount = (data.KPDetails).length;
                var KPValue = data.KPDetails.toString().split(",");
                for (i = 1; i <= KPCount; i++) {
                    mulKP(i);
                    $('#KeyPosition' + i).val(KPValue[i - 1]);
                }

            }, 'json');
        }

        $('#createJobPostForm').on('submit', function(e) {
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
                    $("#loader").modal('show');
                },

                success: function(data) {
                    if (data.status == 400) {
                        $.each(data.error, function(prefix, val) {
                            $(form).find('span.' + prefix + '_error').text(val[0]);
                        });
                    } else {
                        $(form)[0].reset();
                        $('#loader').modal('hide');
                        $('#createpostmodal').modal('hide');
                        $('#MRFTable').DataTable().ajax.reload(null, false);
                        toastr.success(data.msg);
                    }
                }
            });
        });

        function editmrf(id) {
            $('#postStatus' + id).prop("disabled", false);
        }

        function ChngPostingView(JPId, va) {

            $.ajax({
                url: "{{ route('ChngPostingView') }}",
                type: 'POST',
                data: {
                    JPId: JPId,
                    va: va
                },
                dataType: 'json',
                beforeSend: function() {
                    $("#loader").modal('show');
                },
                success: function(data) {
                    if (data.status == 200) {
                        $("#loader").modal('hide');
                        $('#MRFTable').DataTable().ajax.reload(null, false);
                        toastr.success(data.msg);
                    } else {
                        toastr.error(data.msg);
                    }
                }
            });
        }


        $(document).on('click', '#viewMRF', function() {
            var MRFId = $(this).data('id');
            $.post('<?= route('getMRFDetails') ?>', {
                MRFId: MRFId
            }, function(data) {
                //   console.log(data.EducationDetails);
                $('#editMRFModal').find('input[name="MRFId"]').val(data.MRFDetails.MRFId);
                $('#editReason').val(data.MRFDetails.Reason);
                $('#editCompany').val(data.MRFDetails.CompanyId);
                $('#editDepartment').val(data.MRFDetails.DepartmentId);
                $('#editDesignation').val(data.MRFDetails.DesigId);
                $('#editReportingManager').val(data.MRFDetails.Reporting);
                $('#MinCTC').val(data.MRFDetails.MinCTC);
                $('#MaxCTC').val(data.MRFDetails.MaxCTC);
                $('#WorkExp').val(data.MRFDetails.WorkExp);
                CKEDITOR.instances['JobDescription'].setData(data.MRFDetails.Info);
                $('#Remark').val(data.MRFDetails.Remarks);
                var UniversityValue = data.UniversityDetails;
                var selectedOptions = UniversityValue.toString().split(",");

                $('#University').select2({
                    multiple: true,
                });
                $('#University').val(selectedOptions).trigger('change');

                KPCount = (data.KPDetails).length;
                var KPValue = data.KPDetails.toString().split(",");
                for (i = 1; i <= KPCount; i++) {
                    KeyPosition(i);
                    $('#KP' + i).val(KPValue[i - 1]);
                }


                LocCount = (data.LocationDetails).length;
                for (j = 1; j <= LocCount; j++) {
                    mulLocation(j);
                    $('#State' + j).val(data.LocationDetails[j - 1].state);
                    $('#City' + j).val(data.LocationDetails[j - 1].city);
                    $('#ManPower' + j).val(data.LocationDetails[j - 1].nop);

                }

                EduCount = (data.EducationDetails).length;

                for (a = 1; a <= EduCount; a++) {
                    mulEducation(a);
                    $('#Education' + a).val(data.EducationDetails[a - 1].e);
                    $("#Specialization" + a).val(data.EducationDetails[a - 1].s);
                }
                $("#editMRFAdminForm :input").prop('disabled', true);
                CKEDITOR.instances['JobDescription'].setReadOnly(true);
                $('#editMRFModal').modal('show');
            }, 'json');
        });

        var StateList = '';
        var CityList = '';
        var EducationList = '';
        var SpecializationList = '';
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
        getCity();

        function getCity() {
            $.ajax({
                type: "GET",
                url: "{{ route('getAllDistrict') }}",
                async: false,
                success: function(res) {
                    if (res) {
                        $.each(res, function(key, value) {
                            CityList = CityList + '<option value="' + value + '">' + key +
                                '</option>';
                        });
                    }
                }
            });
        }
        getEducation();
        getAllSP();

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

        function getAllSP() {
            $.ajax({
                type: "GET",
                url: "{{ route('getAllSP') }}",
                async: false,
                success: function(res) {
                    if (res) {
                        $.each(res, function(key, value) {
                            SpecializationList = SpecializationList + '<option value="' + value + '">' +
                                key +
                                '</option>';
                        });
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
                '    <option value="" selected disabled>Select City</option>' + CityList +
                '</select>' +
                '<span class="text-danger error-text City' + number + '_error"></span>' +
                '</td>';
            x += '<td>' +
                '  <input type="text" name="ManPower[]" id="ManPower' + number +
                '" class="form-control form-control-sm" style="width:130px" placeholder="No. of Manpower">' +
                '<span class="text-danger error-text ManPower' + number + '_error"></span>' +
                '</td>';
            
                $('#MulLocation').html(x);
            
        }

        KeyPosition();

        function KeyPosition(n) {
            x = '<tr>';
            x += '<td >' +
                '<input type="text" class="form-control form-control-sm" id="KP' + n + '" name="KP[]">' +
                '</td>';
            if (n > 1) {
                x +=
                    '';
                $('#KeyPositionCriteria').append(x);
            } else {
                x +=
                    '';
                $('#KeyPositionCriteria').html(x);
            }
        }


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

                '    <option value="0" >Other</option>' + SpecializationList +
                '</select>' +
                '<span class="text-danger error-text Specialization' + num + '_error"></span>' +
                '</td>';
                $('#MulEducation').html(x);
            
        }




        $(document).on('click', '.select_all', function() {
            if ($(this).prop("checked") == true) {
                $(this).closest("tr").addClass("bg-secondary bg-gradient");
            } else {
                $(this).closest("tr").removeClass("bg-secondary bg-gradient");
            }
        });
    </script>
@endsection
