<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="{{ URL::to('/') }}/assets/images/favicon-32x32.png" type="image/png" />
    <!--plugins-->
    <link href="{{ URL::to('/') }}/assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
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
    <title>Campus Placement Apply</title>
    <style>
        .borderless td,
        .borderless th {
            border: none;
        }
        .table>:not(caption)>*>* {
            padding: 2px 1px;
        }

    </style>
</head>
@php
use function App\Helpers\getDepartment;
use function App\Helpers\getEducationById;
use function App\Helpers\getSpecializationbyId;
use function App\Helpers\getDistrictName;
use function App\Helpers\getStateName;
$jpid = $_REQUEST['jpid'];
$jpid = base64_decode($jpid);
$query = DB::table('jobpost')
    ->Where('JPId', $jpid)
    ->get();

@endphp

<body class="bg-login">
    <!--wrapper-->
    <div class="wrapper">
        <div>
            <div class="container-fluid">
                <div class="col-lg-8  mx-auto">
                    <div class="col mx-auto">
                        <div class="card">
                            <div class="card-body">
                                <div class="border p-4 rounded">
                                    <div class="text-center">
                                        <h5 class="">Application for : {{ $query[0]->Title }}</h5>
                                    </div>
                                    <hr style="margin: 10px 0px 10px 0px;">
                                    <p class="text-danger" style="font-size: 14px; margin-bottom:0px;">Note: * All
                                        field are mandatory</p>
                                    <p style="font-size: 14px; margin-bottom:0px;">Mention your name as per yor Aadhaar
                                        card only.</p>
                                    <hr style="margin: 10px 0px 10px 0px;">
                                    <form action="{{ route('campus_apply') }}" id="jobApplyForm" name="jobApplyForm"
                                        method="POST">
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-lg-9 col-sm-12">
                                                    <table class=" table borderless d-inline-block">
                                                        <tr>
                                                            <td valign="middle" style="width: 150px !important">Title
                                                                <font color="#FF0000">*
                                                                </font>
                                                            </td>
                                                            <td style="width:800px !important">
                                                                <label><input type="radio" name="Title" value="Mr."
                                                                        class="reqinp"> Mr.</label>&emsp;
                                                                <label><input type="radio" name="Title" value="Ms.">
                                                                    Ms.</label>&emsp;
                                                                <label><input type="radio" name="Title" value="Mrs.">
                                                                    Mrs.</label>&emsp;
                                                                <label><input type="radio" name="Title" value="Dr.">
                                                                    Dr.</label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td valign="middle" style="width: 300px;">First Name<font
                                                                    color="#FF0000">*</font>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    name="FName" value="">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td valign="middle">Middle Name</td>
                                                            <td>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    name="MName" value="">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td valign="middle">Last Name<font color="#FF0000">*</font>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    name="LName" value="">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td valign="middle">Date Of Birth<font color="#FF0000">*
                                                                </font>
                                                            </td>
                                                            <td>
                                                                <input type="date" class="form-control form-control-sm"
                                                                    name="DOB" value="" id="DOB">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td valign="middle">Gender<font color="#FF0000">*
                                                                </font>
                                                            </td>
                                                            <td>
                                                                <select name="Gender" id="Gender"
                                                                    class="form-select form-select-sm">
                                                                    <option value="">Select</option>
                                                                    <option value="M">Male</option>
                                                                    <option value="F">Female</option>
                                                                    <option value="O">Other</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td valign="middle">Father's Name<font color="#FF0000">*
                                                                </font>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    name="FatherName" value="" id="FatherName">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td valign="middle">Email ID<font color="#FF0000">*
                                                                </font>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    name="Email" value="" id="Email">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td valign="middle">Phone No.<font color="#FF0000">*
                                                                </font>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    name="Phone" value="" id="Phone">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td valign="middle">Address<font color="#FF0000">*
                                                                </font>
                                                            </td>
                                                            <td>
                                                                <table style="width: 100%">
                                                                    <tr>
                                                                        <td colspan="3">
                                                                            <input type="text" name="AddLine1"
                                                                                id="AddLine1"
                                                                                class="form-control form-control-sm"
                                                                                placeholder="Line 1">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="3">
                                                                            <input type="text" name="AddLine2"
                                                                                id="AddLine2"
                                                                                class="form-control form-control-sm"
                                                                                placeholder="Line 2">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="3">
                                                                            <input type="text" name="AddLine3"
                                                                                id="AddLine3"
                                                                                class="form-control form-control-sm"
                                                                                placeholder="Line 3">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <select name="State" id="State"
                                                                                class="form-select form-select-sm">
                                                                                <option value="">Select State</option>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <select name="District" id="District"
                                                                                class="form-select form-select-sm">
                                                                                <option value="">Select District
                                                                                </option>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="Village"
                                                                                id="Village"
                                                                                class="form-control form-control-sm">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>

                                                                        <td colspan="3">
                                                                            <input type="text" name="PinCode"
                                                                                id="PinCode"
                                                                                class="form-control form-control-sm"
                                                                                placeholder="Pin Code">
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td valign="middle">Aadhaar No.</td>
                                                            <td>
                                                                <input type="text" name="Aadhaar" id="Aadhaar"
                                                                    class="form-control form-control-sm">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td valign="middle">Highest Qualification</td>
                                                            <td>
                                                                <table style="width: 100%">
                                                                    <tr>
                                                                        <td>
                                                                            <select name="Education" id="Education"
                                                                                class="form-select form-select-sm">
                                                                                <option value="">Select Education</option>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <select name="Specialization" id="Specialization"
                                                                                class="form-select form-select-sm">
                                                                                <option value="">Select Specialization</option>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td valign="middle">Year of Passing</td>
                                                            <td>
                                                                <select name="PassingYear" id="PassingYear" class="form-select form-select-sm">
                                                                    <option value="">Select</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td valign="middle">University/College</td>
                                                            <td>
                                                                <select name="College" id="College" class="form-select form-select-sm">
                                                                    <option value="">Select</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    </table>

                                                </div>
                                                <div class="col-lg-3 col-sm-12">
                                                    <div style="border: 1px solid #195999;vertical-align:top"
                                                        class=" mt-3 d-inline-block" style="width: 150; height: 150;">
                                                        <span id="preview">
                                                            <center>
                                                                <img src="{{ URL::to('/') }}/assets/images/user.png"
                                                                    style="width: 150px; height: 150px;" id="img1" />
                                                            </center>
                                                        </span>
                                                        <center>
                                                            <label>
                                                                <input type="file" name="candphoto" id="candphoto"
                                                                    class="btn btn-sm mb-1 "
                                                                    style="width: 100px;display: none;"
                                                                    accept="image/png, image/gif, image/jpeg"><span
                                                                    class="btn btn-sm btn-light shadow-sm text-primary">Upload
                                                                    photo</span>
                                                            </label>
                                                        </center>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                <button type="reset" class="btn btn-danger">Cancle</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end row-->
            </div>
        </div>
    </div>

    <script src="{{ URL::to('/') }}/assets/js/bootstrap.bundle.min.js"></script>
    <!--plugins-->
    <script src="{{ URL::to('/') }}/assets/js/jquery.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
    <!--Password show & hide js -->
    <!--app JS-->
    <script src="{{ URL::to('/') }}/assets/js/app.js"></script>

    <script>
        $(document).ready(function() {
            $(document).on('change', '#candphoto', function(e) {
                const [file] = e.target.files;
                if (file) {
                    img1.src = URL.createObjectURL(file);
                }
            });
            $(function() {
                var dtToday = new Date();
                var month = dtToday.getMonth() + 1; // jan=0; feb=1 .......
                var day = dtToday.getDate();
                var year = dtToday.getFullYear() - 18;
                if (month < 10)
                    month = '0' + month.toString();
                if (day < 10)
                    day = '0' + day.toString();
                var minDate = year + '-' + month + '-' + day;
                var maxDate = year + '-' + month + '-' + day;
                $('#DOB').attr('max', maxDate);
            });
        });
    </script>
</body>

</html>
