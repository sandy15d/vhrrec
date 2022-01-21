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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap"
        rel="stylesheet">
    <link href="{{ URL::to('/') }}/assets/css/app.css" rel="stylesheet">
    <link href="{{ URL::to('/') }}/assets/css/icons.css" rel="stylesheet">
    <title>HR Recruitment V2.0</title>
</head>
@php
    $company_list = DB::table('master_company')
    ->orderBy('CompanyId', 'asc')
    ->pluck('CompanyName', 'CompanyId');
    $country_list = DB::table('master_country')->orderBy('CountryId', 'asc')->pluck('CountryName', 'CountryId');
@endphp
<body class="bg-login">
    <!--wrapper-->
    <div class="wrapper">
        <div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
            <div class="container-fluid">
                <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
                    <div class="col mx-auto">
                        <div class="mb-4 text-center">
                            <img src="{{ URL::to('/') }}/assets/images/logo-img.png" width="250" alt="" />
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="border p-4 rounded">
                                    <div class="text-center">
                                        <h3 class="">Sign in</h3>
                                    </div>
                                    <div class="
                                            form-body">
                                            <form class="row g-3" method="POST" action="{{ route('login') }}">
                                                @if (Session::get('success'))
                                                    <div class="alert alert-success">
                                                        {{ Session::get('success') }}
                                                    </div>
                                                @endif
                                                @if (Session::get('error'))
                                                    <div class="alert alert-danger">
                                                        {{ Session::get('error') }}
                                                    </div>

                                                @endif
                                                @csrf
                                                <div class="col-12">
                                                    <label for="company" class="form-label">Company</label>
                                                    <select name="company" id="company"
                                                        class="form-control form-select @error('company') is-invalid @enderror"
                                                        value="{{ old('company') }}" required autofocus>
                                                        @foreach ($company_list as $key => $value)
                                                        <option value="{{ $key }}">{{ $value }}</option>
                                                    @endforeach
                                                    </select>
                                                    @error('company')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-12">
                                                    <label for="country" class="form-label">Country</label>
                                                    <select name="country" id="country"
                                                        class="form-control form-select @error('country') is-invalid @enderror"
                                                        value="{{ old('country') }}" required autofocus>
                                                        @foreach ($country_list as $key => $value)
                                                        <option value="{{ $key }}">{{ $value }}</option>
                                                    @endforeach
                                                    </select>
                                                    @error('country')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-12">
                                                    <label for="email" class="form-label">Username</label>
                                                    <input id="email" type="text"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        name="email" value="{{ old('email') }}"
                                                        placeholder="Enter Username" required autocomplete="email">
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-12">
                                                    <label for="inputChoosePassword" class="form-label">Enter
                                                        Password</label>
                                                    <div class="input-group" id="show_hide_password">
                                                        <input type="password"
                                                            class="form-control border-end-0 @error('password') is-invalid @enderror"
                                                            id="password" name="password" placeholder="Enter Password"
                                                            required autocomplete="current-password"> <a
                                                            href="javascript:;"
                                                            class="input-group-text bg-transparent"><i
                                                                class='bx bx-hide'></i></a>
                                                        @error('password')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                {{-- <div class="col-md-6">
												<div class="form-check form-switch">
													<input class="form-check-input" type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
													<label class="form-check-label" for="remember"> {{ __('Remember Me') }}</label>
												</div>
											</div> --}}

                                                <div class="col-12">
                                                    <div class="d-grid">
                                                        <button type="submit" class="btn btn-primary"><i
                                                                class="bx bxs-lock-open"></i>Sign in</button>
                                                    </div>
                                                </div>
                                            </form>
                                    </div>
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
{{--     <script src="{{ URL::to('/') }}/assets/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/plugins/metismenu/js/metisMenu.min.js"></script> --}}
{{--     <script src="{{ URL::to('/') }}/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script> --}}
    <!--Password show & hide js -->
    <script>
        $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("bx-hide");
                    $('#show_hide_password i').removeClass("bx-show");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("bx-hide");
                    $('#show_hide_password i').addClass("bx-show");
                }
            });
        });
    </script>
    <!--app JS-->
  {{--   <script src="{{ URL::to('/') }}/assets/js/app.js"></script> --}}
</body>

</html>
