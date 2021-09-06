@php
use function App\Helpers\getDepartment;
$sql = DB::table('jobpost')
    ->Join('manpowerrequisition', 'manpowerrequisition.MRFId', '=', 'jobpost.MRFId')
    ->where('manpowerrequisition.CompanyId', 1)
    ->orWhere('jobpost.Status', 'Open')
    ->orWhere('jobpost.PostingView', 'Show')
    ->orderBy('JPId', 'desc')
    ->get();

@endphp
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="assets/css/app.css" rel="stylesheet">
    <title>Jobs at VNR</title>
</head>

<body>
    <!--wrapper-->
    <div class="wrapper">
        <header class="login-header shadow">
            <nav class="navbar navbar-expand-lg rounded fixed-top rounded-0 shadow-sm"
                style=" background-color: #f09a3e;">
                <div class="container-fluid">
                    <a class="navbar-brand" href="javascript:void(0);" style="height: 30px;">
                    </a>
                </div>
            </nav>
        </header>
        <div class="d-flex align-items-center justify-content-center my-5">
            <div class="container">
                <div class="row ">
                    <div class="col mx-auto">
                        <div class="card mt-3">
                            <div class="card-body">
                                <div class="border p-4 rounded">
                                    <div class="text-center">
                                        <h3 class="___class_+?13___"><img
                                                src="https://www.vnrseeds.com/wp-content/uploads/2018/12/vnr-logo-69x90.png">
                                        </h3>
                                        <h4 class="font-weight-bold" style="color: #f09a3e">Engage, Train & Retain</h4>
                                    </div>
                                    <div class="login-separater text-center mb-4"> <span style="font-size: 14px;">At
                                            VNR, our most valuable assets are its people</span>
                                        <hr style="margin-top: -10px" />
                                    </div>
                                    <div class="form-body">
                                        <h5 style="font-size: 24px; color: #008000; font-weight: 700;letter-spacing: 0px;"
                                            class="font-weight-bold">Current Openings at VNR</h5>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" style="width: 100%" id="myTable">
                                                <thead>
                                                    <th>#</th>
                                                    <th>Job Code</th>
                                                    <th>Job Title</th>
                                                    <th>Department</th>
                                                    <th>Apply</th>
                                                </thead>
                                                <tbody>
                                                    @for ($i = 0; $i < count($sql); $i++)
                                                        <tr data-bs-toggle="collapse" data-bs-target="#detail{{ $sql[$i]->JPId }}" data-parent="#myTable" class="accordion-toggle" style="cursor: pointer">
                                                            <td>{{ $i + 1 }}</td>
                                                            <td>{{ $sql[$i]->JobCode }}</td>
                                                            <td>{{ $sql[$i]->Title }}</td>
                                                            <td>{{ getDepartment($sql[$i]->DepartmentId) }}</td>
                                                            <td><a href="javascript:void(0);">View Details</a></td>
                                                        </tr>
                                                        <tr id="detail{{$sql[$i]->JPId}}" class="collapse accordion-collapse">
                                                            <td colspan="6" class="hiddenRow">
                                                                <div>
                                                                    <table class="table table-bordered table-striped table-sm">
                                                                       <tr>
                                                                           <td>aa</td>
                                                                           <td>aa</td>
                                                                           <td>aa</td>
                                                                           <td>aa</td>
                                                                           <td>aa</td>
                                                                           <td>aa</td>
                                                                       </tr>
                                                                      
                                                                    </table>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endfor
                                                </tbody>
                                            </table>
                                        </div>

                                        <p style="font-size: 18px;">Thanks for checking out our job openings. if you
                                            don't see any opportunities, please submit your resume & we'll get back to
                                            you if there any suitable openings that match your profile. <a
                                                href="javascript:void(0);" class="text-danger"><b>Submit your
                                                    resume</b></a></p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end row-->
            </div>
        </div>
        <footer class="bg-white shadow-sm border-top p-2 text-center fixed-bottom">
            <p class="mb-0">Copyright © VNR Seeds 2021. All right reserved.</p>
        </footer>
    </div>
    <!--end wrapper-->
    <!-- Bootstrap JS -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <!--plugins-->
    <script src="assets/js/jquery.min.js"></script>

</body>

</html>
