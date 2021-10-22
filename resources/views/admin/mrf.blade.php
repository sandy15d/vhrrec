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
        <div class="page-breadcrumb  align-items-center mb-3">
            <div class="row mb-1">
                <div class="col-2 breadcrumb-title ">
                    MRF Details
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
                    <button type="reset" class="btn btn-danger btn-sm" id="reset"><i
                            class="bx bx-refresh"></i></button>
                </div>
            </div>
 
        </div>
        <!--end breadcrumb-->
      
        <div class="card">
            <div class="card-body">
             
                <div class="table-responsive">
                    <table class="table  table-hover table-condensed table-striped table-bordered text-center" id="MRFTable"
                        style="width: 100%">
                        <thead class="bg-primary text-light">
                            <tr class="text-center">
                                <td></td>
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
                    <h5 class="modal-title text-white">MRF Details</h5>

                    <button type="button" class="btn btn-info" style="margin-left: 510px; opacity:1" id="edit_mrf_btn"><i
                            class="fa fa-pencil"></i>Edit</button>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('updateMRF') }}" method="POST" id="update_mrf_form">
                    @csrf
                    <div class="modal-body">
                        <table class="table borderless">
                            <tbody>
                                <tr>
                                    <input type="hidden" name="MRFId" id="MRFId">
                                    <input type="hidden" name="MRF_Type" id="MRF_Type">
                                    <th style="width:250px;">Reason for Creating New Position<font class="text-danger">*
                                        </font>
                                    </th>
                                    <td>
                                        <textarea class="form-control" rows="1" name="Reason" id="Reason" tabindex="1"
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
                                        <select id="Department" name="Department" id="Department"
                                            class="form-control form-select form-select-sm">
                                            <option value="" selected disabled>Select Department</option>
                                            @foreach ($department_list as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text Department_error"></span>
                                    </td>
                                </tr>
                                <tr id="deisgnation_tr" class="d-none">
                                    <th>Designation<font class="text-danger">*</font>
                                    </th>
                                    <td>
                                        <div class="spinner-border text-primary d-none" role="status" id="DesigLoader">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <select id="Designation" name="Designation"
                                            class="form-control form-select form-select-sm">
                                            <option value="" selected disabled>Select Designation</option>
                                            @foreach ($designation_list as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text Designation_error"></span>
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
                                <tr id="ctc_tr">
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
                                <tr id="stipend_tr">
                                    <th>Desired Stipend (in Rs. Per Month) <font class="text-danger">*</font>
                                    </th>
                                    <td>
                                        <input type="text" name="Stipend" id="Stipend" class="form-control form-control-sm">
                                    </td>
                                </tr>
                                <tr id="other_benifit_tr">
                                    <th>Other Benefits</th>
                                    <td>
                                        <table class="table borderless" style="margin-bottom: 0px;">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input " type="checkbox"
                                                                id="two_wheeler_check">
                                                            <label class="form-check-label" for="two_wheeler_check">2
                                                                Wheeler reimbursement Rs.
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline d-none"
                                                            id="two_wheeler_div">
                                                            <input type="text" name="two_wheeler" id="two_wheeler"
                                                                style="border-radius: .2rem; border:1px solid #ced4da; padding:.25rem">
                                                            per
                                                            km
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="form-check form-check-inline" style="width: 200px;">
                                                            <input class="form-check-input " type="checkbox" id="da_check">
                                                            <label class="form-check-label" for="da_check">DA
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline d-none" id="da_div">
                                                            <input type="text" name="da" id="da"
                                                                style="border-radius: .2rem; border:1px solid #ced4da; padding:.25rem">
                                                            Rs. per
                                                            Day
                                                        </div>
                                                    </td>
                                                </tr>

                                            </tbody>
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
                                <tr id="work_exp_tr">
                                    <th>Work Experience <font class="text-danger">*</font>
                                    </th>
                                    <td>
                                        <input type="text" name="WorkExp" id="WorkExp" class="form-control form-control-sm">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Job Description</th>
                                    <td>
                                        <textarea name="JobInfo" id="JobInfo" class="form-control"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Mandatory Requirement</th>
                                    <td>

                                        <table class="table borderless" style="margin-bottom: 0px;">
                                            <tbody id="MulKP">
                                            </tbody>
                                        </table>
                                        <button type="button" name="add" id="addKP"
                                            class="btn btn-warning btn-sm mb-2 mt-2"><i class="bx bx-plus"></i></button>
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

        var KPCount;

        $(document).ready(function() {
            $('#MRFTable').DataTable({
                processing: true,
                ordering: false,
                searching: false,
                lengthChange: false,
                info: true,
                ajax: "{{ route('getNewMrf') }}",
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
            if (va == 'Hold' || va == 'Rejected') {
                var RemarkHr = prompt("Please Enter Remark");
                if (RemarkHr != null) {
                    $.ajax({
                        url: "{{ route('updateMRFStatus') }}",
                        type: 'POST',
                        data: {
                            MRFId: MRFId,
                            va: va,
                            RemarkHr: RemarkHr
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
                } else {
                    alert('Please Enter Remark');
                }
            } else {
                var RemarkHr = '';
                $.ajax({
                    url: "{{ route('updateMRFStatus') }}",
                    type: 'POST',
                    data: {
                        MRFId: MRFId,
                        va: va,
                        RemarkHr: RemarkHr
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
        }

        function allocatemrf(MRFId, va) {
            $.ajax({
                url: "{{ route('allocateMRF') }}",
                type: 'POST',
                data: {
                    MRFId: MRFId,
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

        $(document).on('click', '#reset', function() {
            location.reload();
        });


        $("#two_wheeler_check").change(function() {
            if (!this.checked) {
                $("#two_wheeler_div").addClass("d-none");
            } else {
                $("#two_wheeler_div").removeClass("d-none");
            }
        });
        $("#da_check").change(function() {
            if (!this.checked) {
                $("#da_div").addClass("d-none");
            } else {
                $("#da_div").removeClass("d-none");
            }
        });



        $(document).on('click', '#edit_mrf_btn', function() {
            var form = document.getElementById("update_mrf_form");
            var elements = form.elements;
            for (var i = 0, len = elements.length; i < len; ++i) {
                elements[i].disabled = false;
            }
            CKEDITOR.instances['JobInfo'].setReadOnly(false);
            $('.modal-footer').removeClass('d-none');
        });

        function editmstst(MRFId, th) {
            $('#mrfstatus' + MRFId).prop('disabled', false);
        }

        function editmrf(id) {
            $('#allocate' + id).prop("disabled", false);
        }



        function chngmrfsts(MRFId, va) {
            if (va == 'Hold' || va == 'Rejected') {
                var RemarkHr = prompt("Please Enter Remark");
                if (RemarkHr != null) {
                    $.ajax({
                        url: "{{ route('updateMRFStatus') }}",
                        type: 'POST',
                        data: {
                            MRFId: MRFId,
                            va: va,
                            RemarkHr: RemarkHr
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
                } else {
                    alert('Please Enter Remark');
                }
            } else {
                var RemarkHr = '';
                $.ajax({
                    url: "{{ route('updateMRFStatus') }}",
                    type: 'POST',
                    data: {
                        MRFId: MRFId,
                        va: va,
                        RemarkHr: RemarkHr
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
        }

        function allocatemrf(MRFId, va) {
            $.ajax({
                url: "{{ route('allocateMRF') }}",
                type: 'POST',
                data: {
                    MRFId: MRFId,
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

        $(document).on('click', '#reset', function() {
            location.reload();
        });

        $(document).on('click', '#viewMRF', function() {
            var MRFId = $(this).data('id');
            $.post('<?= route('getMRFDetails') ?>', {
                MRFId: MRFId
            }, function(data) {
                if(data.MRFDetails.status !='New'){
                    $('#edit_mrf_btn').addClass('d-none');
                }
                $('#editMRFModal').find('input[name="MRFId"]').val(data.MRFDetails.MRFId);
                $('#MRF_Type').val(data.MRFDetails.Type);
                $('#Reason').val(data.MRFDetails.Reason);
                $('#Company').val(data.MRFDetails.CompanyId);
                $('#Department').val(data.MRFDetails.DepartmentId);
                $('#Designation').val(data.MRFDetails.DesigId);
                $('#MinCTC').val(data.MRFDetails.MinCTC);
                $('#MaxCTC').val(data.MRFDetails.MaxCTC);
                $('#MaxCTC').val(data.MRFDetails.MaxCTC);
                $('#Stipend').val(data.MRFDetails.Stipend);
                CKEDITOR.instances['JobInfo'].setData(data.MRFDetails.Info);
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
                    mulKP(i);
                    $('#KeyPosition' + i).val(KPValue[i - 1]);
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

                var form = document.getElementById("update_mrf_form");
                var elements = form.elements;
                for (var i = 0, len = elements.length; i < len; ++i) {
                    elements[i].disabled = true;
                }
                CKEDITOR.instances['JobInfo'].setReadOnly(true);

                if (data.MRFDetails.Type == 'SIP' || data.MRFDetails.Type == 'SIP_Hr_Manual') {
                    $('#deisgnation_tr').addClass('d-none');
                    $('#stipend_tr').removeClass('d-none');
                    $('#ctc_tr').addClass('d-none');
                    $('#other_benifit_tr').removeClass('d-none');
                    if (data.MRFDetails.TwoWheeler != null) {
                        $('#two_wheeler_check').prop('checked', true);
                        $("#two_wheeler_div").removeClass("d-none");
                        $('#two_wheeler').val(data.MRFDetails.TwoWheeler);
                    }
                    if (data.MRFDetails.DA != null) {
                        $('#da_check').prop('checked', true);
                        $("#da_div").removeClass("d-none");
                        $('#da').val(data.MRFDetails.DA);
                    }
                } else {
                    $('#deisgnation_tr').removeClass('d-none');
                    $('#stipend_tr').addClass('d-none');
                    $('#ctc_tr').removeClass('d-none');
                    $('#other_benifit_tr').addClass('d-none');
                }



                $('.modal-footer').addClass('d-none');
                $('#editMRFModal').modal('show');
            }, 'json');
        });
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

                            $.each(res, function(key, value) {
                                $("#Department").append('<option value="' + value + '">' +
                                    key +
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
                    '    <option value="0" selected>Select City</option>'  + CityList +
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
        mulKP();

        function mulKP(n) {
            x = '<tr>';
            x += '<td >' +
                '<input type="text" class="form-control form-control-sm" id="KeyPosition' + n + '" name="KeyPosition[]">' +
                '</td>';
            if (n > 1) {
                x +=
                    '<td><button type="button" name="remove" id="" class="btn btn-danger btn-sm  removeKP"><i class="bx bx-x"></td></tr>';
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


            if (num > 1) {
                x +=
                    '<td><button type="button" name="remove" id="" class="btn btn-danger btn-sm  removeEducation">Remove</td></tr>';
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


        $(document).on('click', '.select_all', function() {
            if ($(this).prop("checked") == true) {
                $(this).closest("tr").addClass("bg-secondary bg-gradient text-light");
            } else {
                $(this).closest("tr").removeClass("bg-secondary bg-gradient text-light");
            }
        });

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
                            '<option value="0" selected>Select City</option>');

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

        $('#update_mrf_form').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
            $('#Company').removeAttr('disabled');
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
                        $("#loader").modal('hide');
                        $.each(data.error, function(prefix, val) {
                            $(form).find('span.' + prefix + '_error').text(val[0]);
                        });
                    } else {
                        $(form)[0].reset();
                        $('#loader').modal('hide');
                        toastr.success(data.msg);
                        window.location.href = "{{ route('mrf') }}";
                    }
                }
            });
        });

        $(document).on('click', '#deleteMrf', function() {
            var MRFId = $(this).data('id');
            var url = '<?= route('deleteMRF') ?>';
            swal.fire({
                title: 'Are you sure?',
                html: 'You want to <b>Delete</b> this MRF',
                showCancelButton: true,
                showCloseButton: true,
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Yes, Delete',
                cancelButtonColor: '#d33',
                confirmButtonColor: '#556ee6',
                width: 400,
                allowOutsideClick: false

            }).then(function(result) {
                if (result.value) {
                    $.post(url, {
                        MRFId: MRFId
                    }, function(data) {
                        if (data.status == 200) {
                            $('#mrfsummarytable').DataTable().ajax.reload(null, false);
                            toastr.success(data.msg);

                        } else {
                            toastr.error(data.msg);
                        }
                    }, 'json');
                }
            });
        });
    </script>

@endsection
