@php
$jpid = $_REQUEST['jpid'];
$jpid = base64_decode($jpid);
echo $jpid;
@endphp

@php
use function App\Helpers\getDepartment;
use function App\Helpers\getEducationById;
use function App\Helpers\getSpecializationbyId;
use function App\Helpers\getDistrictName;
use function App\Helpers\getStateName;

$sql = DB::table('jobpost')
    ->Join('manpowerrequisition', 'manpowerrequisition.MRFId', '=', 'jobpost.MRFId')
    ->where('jobpost.JPId', $jpid)
    ->first();

@endphp
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="{{ URL::to('/') }}/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="{{ URL::to('/') }}/assets/css/app.css" rel="stylesheet">
    <link href="{{ URL::to('/') }}/assets/css/icons.css" rel="stylesheet">
    <title>Jobs at VNR</title>
	<style>
		.req{
			color: red;
		}
	</style>
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
                <div class="row col-xl-9 mx-auto">
                    <div class="col mx-auto">
                        <div class="card border-top border-0 border-4 border-success">
                            <div class="card-body p-5">
                                <div class="card-title text-center">
                                    <h5 class="mb-0 text-primary">Application for the post of: {{ $sql->Title }}</h5>
                                </div>
                                <hr>
                                <p class="text-danger font-weight-bold">* Enter your name as per Aadhar</p>
                                <form class="row g-3">
									<div class="col-12">
										<label for="Name" style="font-size:14px;">Name</label><small class="req">*</small>
										<div class="row">
											<div class="col-3">
												<select name="Title" id="Title" class="form-control"></select>
											</div>
											<div class="col-4">
												<input type="text" name="" id="" class="form-control" placeholder="First">
											</div>
										</div>
									</div>
                                </form>
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
    <script src="{{ URL::to('/') }}/assets/js/bootstrap.bundle.min.js"></script>
    <!--plugins-->
    <script src="{{ URL::to('/') }}/assets/js/jquery.min.js"></script>

</body>

</html>
