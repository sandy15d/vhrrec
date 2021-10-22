<!doctype html>
<html lang="en" class="{{ session('ThemeStyle') }} {{ session('SidebarColor') }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--favicon-->
    <link rel="icon" href="{{ URL::to('/') }}/assets/images/favicon-32x32.png" type="image/png" />
    <!--plugins-->
    <link href="{{ URL::to('/') }}/assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="{{ URL::to('/') }}/assets/plugins/select2/css/select2.min.css" rel="stylesheet" />
    <link href="{{ URL::to('/') }}/assets/plugins/select2/css/select2-bootstrap4.css" rel="stylesheet" />
    <link href="{{ URL::to('/') }}/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="{{ URL::to('/') }}/assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <!-- loader-->
    <link href="{{ URL::to('/') }}/assets/css/pace.min.css" rel="stylesheet" />
    <script src="{{ URL::to('/') }}/assets/js/pace.min.js"></script>
    <!-- Bootstrap CSS -->

    <link href="{{ URL::to('/') }}/assets/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
    <link href="{{ URL::to('/') }}/assets/css/app.css" rel="stylesheet">
    <link href="{{ URL::to('/') }}/assets/css/icons.css" rel="stylesheet">
    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/css/dark-theme.css" />
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/css/semi-dark.css" />
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/css/header-colors.css" />
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/css/sweetalert2.min.css" />
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/css/toastr.min.css" />
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"
        rel="stylesheet">
    <link href="{{ URL::to('/') }}/assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="{{ URL::to('/') }}/assets/plugins/datatable/css/dataTablesButtons.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/b0b5b1cf9f.js" crossorigin="anonymous"></script>
    <script src="{{ URL::to('/') }}/assets/ckeditor/ckeditor.js"></script>
    <title>HR Recruitment | View MRF</title>
    <style>
        #editUDiv {
            display: none;
            background-color: #fff;
            width: 400px;
            z-index: 9999;
            border: 1px solid #E3E3E3;
        }

        .estable thead th,
        .estable tbody th,
        .estable tbody td {
            font-size: 12px !important;
            padding: 2px 2px !important;
            text-align: center;
            font-weight: 500;
            border: 1px solid #CCE7F4;
            margin: 0px;
        }

        .estable thead th {
            background-color: #275A72;
            color: #fff;
            font-size: 13px;
            font-weight: bold;
            padding: 7px 3px !important;
        }

        .estable tbody td {
            background-color: #fff !important;
            vertical-align: middle;
        }

        .cstable thead th,
        .estable tbody th {
            font-size: 12px !important;
            padding: 1px 2px !important;
            font-weight: 500;
            border: 2px solid #ccc;
            margin: 0px;
        }

        .cstable thead th {
            background-color: #275A72;
            color: #fff;
            font-size: 15px;
            font-weight: bold;
            padding: 7px 3px !important;
            vertical-align: top;

        }

        .cstable thead td {
            background-color: #fff !important;
            width: 250px !important;
            font-size: 12px;
            padding: 4px;
            vertical-align: middle;
        }

    </style>
</head>

<body>
    <form action="{{ route('editMRFAdmin') }}" method="POST" id="editMRFAdminForm">
        @csrf
        <table class=" fstable table table-bordered">
            <tbody>
                <tr>
                    <td>
                        <div style="background-color: #275A72; padding: 5px 5px; height:40px;" class="bg-gradient">
                            <div style="float:left;line-height:40px;">
                                <h5 style="color:white">Edit MRF</h5>
                            </div>
                            <button type="button" class="btn btn-danger btn-sm" style="float: right;"
                                onclick="window.parent.closemrf('<?= $_REQUEST['id'] ?>');"><i
                                    class="fa fa-close"></i></button>
                            <button type="submit" class="btn btn-primary btn-sm"
                                style="float: right; margin-right: 10px;"><i class="fa fa-save"></i></button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="table borderless">
                            <tbody>
                                <tr>
                                    <input type="hidden" name="MRFId" id="MRFId">
                                    <th style="width:250px;">Reason for Creating New Position<font
                                            class="text-danger">*
                                        </font>
                                    </th>
                                    <td>
                                        <textarea class="form-control" rows="1" name="editReason" id="editReason"
                                            tabindex="1" autofocus>{{ $MRFDetails->Reason }}</textarea>
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
                                        <div class="spinner-border text-primary d-none" role="status" id="DeptLoader">
                                            <span class="visually-hidden">Loading...</span>
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
                                        <input type="text" name="WorkExp" id="WorkExp"
                                            class="form-control form-control-sm">
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
                                        <button type="button" name="add" id="addKP"
                                            class="btn btn-warning btn-xs mb-2 mt-2"><i
                                                class="bx bx-plus"></i></button>
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
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</body>
@section('scriptsection')
    <script>
        var KPCount;
        CKEDITOR.replace('JobInfo', {
                height: 100
            });
        $(document).ready(function() {

          
            var UniversityValue = UniversityDetail;
            var selectedOptions = UniversityValue.toString().split(",");

            $('#University').select2({
                multiple: true,
            });
            $('#University').val(selectedOptions).trigger('change');

            KPCount = (KPDetail).length;
            var KPValue = KPDetail.toString().split(",");
            for (i = 1; i <= KPCount; i++) {
                mulKP(i);
                $('#KeyPosition' + i).val(KPValue[i - 1]);
            }


            LocCount = (LocationDetail).length;
            for (j = 1; j <= LocCount; j++) {
                mulLocation(j);
                $('#State' + j).val(LocationDetail[j - 1].state);
                $('#City' + j).val(LocationDetail[j - 1].city);
                $('#ManPower' + j).val(LocationDetail[j - 1].nop);

            }

            EduCount = (EducationDetail).length;

            for (a = 1; a <= EduCount; a++) {
                mulEducation(a);
                $('#Education' + a).val(EducationDetail[a - 1].e);
                $("#Specialization" + a).val(EducationDetail[a - 1].s);
            }
        });
        //==================================Get Department List on Change Company========================//
        $('#editCompany').change(function() {
            var CompanyId = $(this).val();
            if (CompanyId) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('getDepartment') }}?CompanyId=" + CompanyId,
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
                    url: "{{ route('getDesignation') }}?DepartmentId=" + DepartmentId,
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
                    url: "{{ route('getReportingManager') }}?DepartmentId=" + DepartmentId,
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


        $(document).on('click', '.select_all', function() {
            if ($(this).prop("checked") == true) {
                $(this).closest("tr").addClass("bg-secondary bg-gradient");
            } else {
                $(this).closest("tr").removeClass("bg-secondary bg-gradient");
            }
        });
    </script>

@endsection
