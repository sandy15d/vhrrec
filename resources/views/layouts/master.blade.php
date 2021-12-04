@php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
$Notification = DB::table('notification')
    ->where('userid', Auth::user()->id)
    ->where('status', 0)
    ->where('notification_read', 0)
    ->orderBy('id', 'DESC')
    ->get();
$NotificationCount = $Notification->count();

$CompanyQry = DB::table('master_company')
    ->where('CompanyId', session('Set_Company'))
    ->get();
@endphp
<!doctype html>
<html lang="en" class="{{ session('ThemeStyle') }} {{ session('SidebarColor') }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/css/mystyle.css" />
    <link rel="icon" href="{{ URL::to('/') }}/assets/images/favicon-32x32.png" type="image/png" />
    <link href="{{ URL::to('/') }}/assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="{{ URL::to('/') }}/assets/plugins/select2/css/select2.min.css" rel="stylesheet" />
    <link href="{{ URL::to('/') }}/assets/plugins/select2/css/select2-bootstrap4.css" rel="stylesheet" />
    <link href="{{ URL::to('/') }}/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="{{ URL::to('/') }}/assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <link href="{{ URL::to('/') }}/assets/css/pace.min.css" rel="stylesheet" />
    <script src="{{ URL::to('/') }}/assets/js/pace.min.js"></script>
    <link href="{{ URL::to('/') }}/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
    <link href="{{ URL::to('/') }}/assets/css/app.css" rel="stylesheet">
    <link href="{{ URL::to('/') }}/assets/css/icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/css/dark-theme.css" />
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/css/semi-dark.css" />
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/css/header-colors.css" />
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/css/sweetalert2.min.css" />
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/css/toastr.min.css" />
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/css/BsMultiSelect.css" />

    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"
        rel="stylesheet">
    <link href="{{ URL::to('/') }}/assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="{{ URL::to('/') }}/assets/plugins/datatable/css/dataTablesButtons.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/b0b5b1cf9f.js" crossorigin="anonymous"></script>
    
    <script src="{{ URL::to('/') }}/assets/ckeditor/ckeditor.js"></script>
    <script src="{{ URL::to('/') }}/assets/js/jquery.min.js"></script>



    <title>HR Recruitment | @yield('title')</title>
    <style>
        .btn--red {
            color: #fff;
            background-color: #e944ff;
            background: linear-gradient(103deg, #ff0036 0%, #ff9116 0%, #fe19fe 100%);
        }

        .btn--new {
            color: #fff;
            background: #2193b0;

            background: -webkit-linear-gradient(to right, #6dd5ed, #2193b0);
            background: linear-gradient(to right, #6dd5ed, #2193b0);
        }

        .btn--edit {
            color: #fff;
            background: #8360c3;
            background: -webkit-linear-gradient(to right, #00416A, #E4E5E6);
            background: linear-gradient(to right, #00416A, #E4E5E6);

        }

        .btn--green {
            color: #fff;
            background: #d7e428;
            background: -webkit-linear-gradient(to right, #56ab2f, #a8e063);
            background: linear-gradient(to right, #56ab2f, #a8e063);

        }



        .btn-xs {
            padding: .25rem .4rem;
            font-size: .875rem;

            border-radius: .2rem;
        }

        .borderless td,
        .borderless th {
            border: none;
        }

        .errorfield {
            border: 2px solid #E8290B;
        }

        div.dt-buttons {
            float: right;
        }

        .btn-outline-secondary {
            position: relative;
            display: inline-block;
            /*   box-sizing: border-box; */
            margin-right: 0.333em;
            padding: 2px 6.2px;
            border-radius: 0px;
            cursor: pointer;
            font-size: 14px;
            white-space: nowrap;
            overflow: hidden;
            /*  background-color: #fff; */
            outline: none;
            border-top: 0;
            border-left: 0;
            border-right: 0;
            border-bottom: 0;
            /*  border-bottom: 1px solid #ddd; */
        }

        .overlay {
            display: none;
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 999;
            background: rgba(255, 255, 255, 0.8) url("loader.gif") center no-repeat;
        }


        body.loading {
            overflow: hidden;
        }

        body.loading .overlay {
            display: block;
        }

    </style>
    @livewireStyles
</head>

<body>
    <div class="wrapper">
        <div class="sidebar-wrapper" data-simplebar="true">
            <div class="sidebar-header">
                <div>
                    <h4 class="logo-text">HR Recruitment</h4>
                </div>
                <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
                </div>
            </div>
            <!--navigation-->
      
            <ul class="metismenu" id="menu">

                @if (Auth::user()->role == 'A')
                    <li class="{{ request()->is('admin/dashboard') ? 'mm-active' : '' }}">
                        <a href="/admin/dashboard">
                            <div class="parent-icon"><i class="fas fa-laptop-house text-primary"></i>
                            </div>
                            <div class="menu-title">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="has-arrow">
                            <div class="parent-icon"><i class="lni lni-react  text-danger"></i>
                            </div>
                            <div class="menu-title">Master</div>
                        </a>
                        <ul>
                            <li> <a href="/admin/company"><i class="bx bx-right-arrow-alt"></i>Company</a></li>
                            <li> <a href="/admin/country"><i class="bx bx-right-arrow-alt"></i>Country</a></li>
                            <li> <a href="/admin/state"><i class="bx bx-right-arrow-alt"></i>State(HQ)</a></li>
                            <li> <a href="/admin/headquarter"><i class="bx bx-right-arrow-alt"></i>Headquarter</a></li>
                            <li> <a href="/admin/department"><i class="bx bx-right-arrow-alt"></i>Department</a></li>
                            <li> <a href="/admin/designation"><i class="bx bx-right-arrow-alt"></i>Designation</a></li>
                            <li> <a href="/admin/grade"><i class="bx bx-right-arrow-alt"></i>Grade</a></li>
                            <li> <a href="/admin/district"><i class="bx bx-right-arrow-alt"></i>District</a></li>
                            <li> <a href="/admin/education"><i class="bx bx-right-arrow-alt"></i>Education</a></li>
                            <li> <a href="/admin/eduspecialization"><i class="bx bx-right-arrow-alt"></i>Education
                                    Specialization</a></li>
                            <li> <a href="/admin/institute"><i class="bx bx-right-arrow-alt"></i>Education
                                    Institute</a>
                            </li>
                            <li> <a href="/admin/resumesource"><i class="bx bx-right-arrow-alt"></i>Resume Source</a>
                            </li>
                            <li> <a href="/admin/employee"><i class="bx bx-right-arrow-alt"></i>Employee</a></li>
                            <li> <a href="/admin/communication_control"><i
                                        class="bx bx-right-arrow-alt"></i>Communication Control</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="has-arrow">
                            <div class="parent-icon"><i class="bx bx-category" style="color: maroon"></i>
                            </div>
                            <div class="menu-title">MRF</div>
                        </a>
                        <ul>
                            <li> <a href="/admin/mrf"><i class="bx bx-right-arrow-alt"></i>New MRF</a></li>
                            <li> <a href="/admin/active_mrf"><i class="bx bx-right-arrow-alt"></i>Active MRF</a></li>
                            <li> <a href="/admin/closedmrf"><i class="bx bx-right-arrow-alt"></i>Closed MRF</a></li>
                            <li> <a href="/recruiter_mrf_entry"><i class="bx bx-right-arrow-alt"></i>Manual Entry</a>
                            </li>

                        </ul>
                    </li>

                @endif


                @if (Auth::user()->role == 'H')
                    <li class="{{ request()->is('hod/dashboard') ? 'mm-active' : '' }}">
                        <a href="/hod/dashboard">
                            <div class="parent-icon"><i class="fas fa-laptop-house text-primary"></i>
                            </div>
                            <div class="menu-title">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <a href="/hod/myteam">
                            <div class="parent-icon"><i class="fas fa-users text-info"></i>
                            </div>
                            <div class="menu-title">My Team Details</div>
                        </a>
                    </li>
                    <li>
                        <a href="/hod/manpowerrequisition">
                            <div class="parent-icon"><i class="fas fa-feather-alt text-success"></i>
                            </div>
                            <div class="menu-title">MRF</div>
                        </a>
                    </li>
                    <li>
                        <a href="/hod/interviewschedule">
                            <div class="parent-icon"><i class="far fa-calendar-alt text-warning"></i>
                            </div>
                            <div class="menu-title">Interview Schedule</div>
                        </a>
                    </li>
                @endif



                @if (Auth::user()->role == 'R')
                    <li class="{{ request()->is('recruiter/dashboard') ? 'mm-active' : '' }}">
                        <a href="/recruiter/dashboard">
                            <div class="parent-icon"><i class="fas fa-laptop-house text-primary"></i>
                            </div>
                            <div class="menu-title">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="has-arrow">
                            <div class="parent-icon"><i class="bx bx-category" style="color: #198754"></i>
                            </div>
                            <div class="menu-title">MRF</div>
                        </a>
                        <ul>
                            <li> <a href="/recruiter/mrf_allocated"><i class="bx bx-right-arrow-alt"></i>MRF
                                    Allocated</a></li>
                            <li> <a href="/recruiter_mrf_entry"><i class="bx bx-right-arrow-alt"></i>Manual
                                    Entry</a></li>
                        </ul>
                    </li>
                @endif

                @if (Auth::user()->role == 'A' || Auth::user()->role == 'R')
                  
                    <li>
                        <a href="javascript:;" class="has-arrow">
                            <div class="parent-icon"><i class="lni lni-write text-warning"></i>
                            </div>
                            <div class="menu-title">Job Application Management</div>
                        </a>
                        <ul>
                            <li> <a href="/job_response"><i class="bx bx-right-arrow-alt"></i>Job & Response</a></li>
                            <li> <a href="/job_applications"><i class="bx bx-right-arrow-alt"></i>Job Application
                                    (Resume Databank)</a>
                            </li>
                            <li> <a href="/job_application_manual_entry_form"><i class="bx bx-right-arrow-alt"></i>Job
                                    Application Form (Manual
                                    Entry)</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="has-arrow">
                            <div class="parent-icon"><i class="lni lni-ux  text-primary"></i>
                            </div>
                            <div class="menu-title">Campus Hirings</div>
                        </a>
                        <ul>
                            <li> <a href="/campus_mrf_allocated"><i class="bx bx-right-arrow-alt"></i>Campus MRF</a>
                            </li>
                            <li> <a href="/campus_applications"><i class="bx bx-right-arrow-alt"></i>Campus
                                    Application</a></li>
                            <li> <a href="/campus_screening_tracker"><i class="bx bx-right-arrow-alt"></i>Screening
                                    Tracker</a></li>
                            <li> <a href="/campus_hiring_tracker"><i class="bx bx-right-arrow-alt"></i>Hiring
                                    Tracker</a></li>
                            <li> <a href="/"><i class="bx bx-right-arrow-alt"></i>Hiring Costing</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="has-arrow">
                            <div class="parent-icon"><i class="lni lni-timer  text-info"></i>
                            </div>
                            <div class="menu-title">Recruitment Tracker</div>
                        </a>
                        <ul>

                            <li> <a href="/TechnicalScreening"><i class="bx bx-right-arrow-alt"></i>Screening Tracker</a></li>
                            <li> <a href="/interview_tracker"><i class="bx bx-right-arrow-alt"></i>Interview Tracker</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="has-arrow">
                            <div class="parent-icon"><i class="fadeIn animated bx bx-walk  text-success"></i>
                            </div>
                            <div class="menu-title">Onboarding</div>
                        </a>
                        <ul>
                            <li> <a href="/offer_letter"><i class="bx bx-right-arrow-alt"></i>Job Offers</a></li>
                            <li> <a href="/"><i class="bx bx-right-arrow-alt"></i>Candidates for Joining</a></li>
                            <li> <a href="/"><i class="bx bx-right-arrow-alt"></i>Appointments</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="has-arrow">
                            <div class="parent-icon"><i class="fadeIn animated bx bx-atom  text-danger"></i>
                            </div>
                            <div class="menu-title">Trainee</div>
                        </a>
                        <ul>
                            <li> <a href="/"><i class="bx bx-right-arrow-alt"></i>Trainee Details</a></li>
                            <li> <a href="/"><i class="bx bx-right-arrow-alt"></i>Trainee Costing</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="/">
                            <div class="parent-icon"><i class="lni lni-target-customer" style="color: #6610f2"></i>
                            </div>
                            <div class="menu-title">Online Test Module</div>
                        </a>
                    </li>


                @endif

                @if (Auth::user()->role == 'A')
                    <li> <a href="/admin/userlist">
                            <div class="parent-icon"><i class='bx bx-user text-info'></i>
                            </div>
                            <div class="menu-title">Users</div>
                        </a></li>


                    <li>
                        <a href="/admin/sentemails" target="_blank">
                            <div class="parent-icon"><i class='fadeIn animated bx bx-mail-send text-primary'></i>
                            </div>
                            <div class="menu-title">Sent Mails</div>
                        </a>
                    </li>

                    <li>
                        <a href="/">
                            <div class="parent-icon"><i class='lni lni-slack' style="color: crimson"></i>
                            </div>
                            <div class="menu-title">Reports</div>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/userlogs">
                            <div class="parent-icon"><i class='bx bx-news text-success'></i>
                            </div>
                            <div class="menu-title">Logs</div>
                        </a>
                    </li>
                @endif
            </ul>

        </div>

        <header>
            <div class="topbar d-flex align-items-center">
                <nav class="navbar navbar-expand">
                    <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>

                    </div>
                    <div class="search-bar flex-grow-1">
                        <div class="position-relative search-bar-box">
                            <h4 class="logo-text">{{ $CompanyQry[0]->CompanyName }}</h4>
                        </div>
                    </div>
                    <div class="top-menu ms-auto">
                        <ul class="navbar-nav align-items-center">

                            <li class="nav-item dropdown-large">
                                <a id="sidebarsetting" class="nav-link dropdown-toggle dropdown-toggle-nocaret"
                                    href="#" role="button"> <i class='bx bx-shape-polygon'></i>
                                </a>
                            </li>
                            <li class="nav-item dropdown dropdown-large">
                                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    @if ($NotificationCount > 0)
                                        <span class="alert-count">
                                            {{ $NotificationCount }}
                                        </span>
                                    @endif
                                    <i class='bx bx-bell'></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="javascript:;">
                                        <div class="msg-header">
                                            <p class="msg-header-title">Notifications</p>
                                            <p class="msg-header-clear ms-auto" onclick="markAllRead()">Marks all as
                                                read</p>
                                        </div>
                                    </a>
                                    <div class="header-notifications-list">

                                        @foreach ($Notification as $item)
                                            <a class="dropdown-item" href="javascript:;"
                                                onclick="readNotification({{ $item->id }})">
                                                <div class="d-flex align-items-center">
                                                    <div class="notify bg-light-primary">
                                                        @if ($item->title == 'MRF Allocated')
                                                            <i class="bx bx-file  text-primary"></i>
                                                        @elseif($item->title =='Offer Letter')
                                                            <i class="bx bx-user text-danger"></i>
                                                        @elseif($item->title =='Job Post Create')
                                                            <i class="bx bx-send text-success"></i>
                                                        @endif

                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="msg-name">{{ $item->title }}
                                                            <span
                                                                class="msg-time float-end">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</span>
                                                        </h6>
                                                        <p class="msg-info">{{ $item->description }}
                                                            <span class="user-online float-end mt-3"></span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>

                                </div>
                            </li>
                            <li class="nav-item dropdown dropdown-large d-none">
                                <div class="dropdown-menu dropdown-menu-end">
                                    <div class="header-message-list">
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="user-box dropdown">
                        <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ URL::to('/') }}/assets/images/avatars/avatar-2.png" class="user-img"
                                alt="user avatar">
                            <div class="user-info ps-3">
                                <p class="user-name mb-0"> {{ Auth::user()->name }}</p>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="javascript:;"><i
                                        class="bx bx-user"></i><span>Profile</span></a> </li>
                            <li>
                                <div class="dropdown-divider mb-0"></div>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                              document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    class="d-none">
                                    @csrf
                                </form>

                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>

        <div class="page-wrapper">
           
            @yield('PageContent')
            <div class="modal" id="loader" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered" style="width:220px;">
                    <div class="modal-content" style="border-radius:10px;">

                        <div class="modal-body">
                            <img alt="" src="{{ URL::to('/') }}/assets/images/loader.gif">
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="overlay toggle-icon"></div>

        <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>

        <footer class="page-footer">
            <p class="mb-0">Developed and Managed By: IT Department,VNR Seeds Pvt. Ltd.</p>
        </footer>
    </div>

    <div class="switcher-wrapper">
        <div class="switcher-body">
            <div class="d-flex align-items-center">
                <h5 class="mb-0 text-uppercase">Theme Customizer</h5>
                <button type="button" class="btn-close ms-auto close-switcher" aria-label="Close"></button>
            </div>
            <hr />
            <h6 class="mb-0">Theme Styles</h6>
            <hr />
            <div class="d-flex align-items-center justify-content-between">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="lightmode"
                        {{ session('ThemeStyle') == 'light-theme' ? 'checked' : '' }}>
                    <label class="form-check-label" for="lightmode">Light</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="darkmode"
                        {{ session('ThemeStyle') == 'dark-theme' ? 'checked' : '' }}>
                    <label class="form-check-label" for="darkmode">Dark</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="semidark"
                        {{ session('ThemeStyle') == 'semi-dark' ? 'checked' : '' }}>
                    <label class="form-check-label" for="semidark">Semi Dark</label>
                </div>
            </div>
            <hr />
            <div class="form-check">
                <input class="form-check-input" type="radio" id="minimaltheme" name="flexRadioDefault"
                    {{ session('ThemeStyle') == 'minimal-theme' ? 'checked' : '' }}>
                <label class="form-check-label" for="minimaltheme">Minimal Theme</label>
            </div>
            <hr />
            <h6 class="mb-0">Sidebar Colors</h6>
            <hr />
            <div class="header-colors-indigators">
                <div class="row row-cols-auto g-3">
                    <div class="col">
                        <div class="indigator sidebarcolor1" id="sidebarcolor1"></div>
                    </div>
                    <div class="col">
                        <div class="indigator sidebarcolor2" id="sidebarcolor2"></div>
                    </div>
                    <div class="col">
                        <div class="indigator sidebarcolor3" id="sidebarcolor3"></div>
                    </div>
                    <div class="col">
                        <div class="indigator sidebarcolor4" id="sidebarcolor4"></div>
                    </div>
                    <div class="col">
                        <div class="indigator sidebarcolor5" id="sidebarcolor5"></div>
                    </div>
                    <div class="col">
                        <div class="indigator sidebarcolor6" id="sidebarcolor6"></div>
                    </div>
                    <div class="col">
                        <div class="indigator sidebarcolor7" id="sidebarcolor7"></div>
                    </div>
                    <div class="col">
                        <div class="indigator sidebarcolor8" id="sidebarcolor8"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!--end switcher-->
    <!-- Bootstrap JS -->
    <script src="{{ URL::to('/') }}/assets/js/bootstrap.bundle.min.js"></script>
    <!--plugins-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="{{ URL::to('/') }}/assets/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
    <script src="{{ URL::to('/') }}/assets/plugins/select2/js/select2.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/js/sweetalert2.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/js/toastr.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/js/BsMultiSelect.min.js"></script>

    <!--app JS-->
    <script src="{{ URL::to('/') }}/assets/js/app.js"></script>
 
    @yield('scriptsection')
   
    <script>
        $(document).ready(function() {

            $('.multiple-select').select2({
                theme: 'bootstrap4',
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                    'style',
                placeholder: $(this).data('placeholder'),

                allowClear: Boolean($(this).data('allow-clear')),
            });


            $(document).on('click', '#sidebarsetting', function() {
                $(".switcher-wrapper").toggleClass("switcher-toggled");
                // $(".wrapper").removeClass("toggled");
            });

            /* $( ".sidebar-wrapper" ).hover(function() {
                $(".wrapper").toggleClass("toggled");
            }); */
            //=====================Set Light Theme=====================
            $(document).on('click', '#lightmode', function() {
                $.ajax({
                    url: "{{ route('setTheme') }}",
                    method: 'POST',
                    data: {
                        ThemeStyle: 'lightmode'
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.status == 200) {

                            location.reload();
                        } else {
                            alert('failed');
                        }
                    }
                });
            });
            //======================Set Dark Theme  ========================

            $(document).on('click', '#darkmode', function() {
                $.ajax({
                    url: "{{ route('setTheme') }}",
                    method: 'POST',
                    data: {
                        ThemeStyle: 'darkmode'
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.status == 200) {

                            location.reload();
                        } else {
                            alert('failed');
                        }
                    }
                });
            });

            //======================Set Semi Dark Theme  ========================

            $(document).on('click', '#semidark', function() {
                $.ajax({
                    url: "{{ route('setTheme') }}",
                    method: 'POST',
                    data: {
                        ThemeStyle: 'semidark'
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.status == 200) {

                            location.reload();
                        } else {
                            alert('failed');
                        }
                    }
                });
            });

            // ======================Set minimaltheme Theme  ========================

            $(document).on('click', '#minimaltheme', function() {
                $.ajax({
                    url: "{{ route('setTheme') }}",
                    method: 'POST',
                    data: {
                        ThemeStyle: 'minimaltheme'
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.status == 200) {

                            location.reload();
                        } else {
                            alert('failed');
                        }
                    }
                });
            });
            // ======================Set Sidebar1 Theme  ========================

            $(document).on('click', '#sidebarcolor1', function() {
                $.ajax({
                    url: "{{ route('setTheme') }}",
                    method: 'POST',
                    data: {
                        ThemeStyle: 'sidebarcolor1'
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.status == 200) {

                            location.reload();
                        } else {
                            alert('failed');
                        }
                    }
                });
            });

            $(document).on('click', '#sidebarcolor2', function() {
                $.ajax({
                    url: "{{ route('setTheme') }}",
                    method: 'POST',
                    data: {
                        ThemeStyle: 'sidebarcolor2'
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.status == 200) {

                            location.reload();
                        } else {
                            alert('failed');
                        }
                    }
                });
            });
            $(document).on('click', '#sidebarcolor3', function() {
                $.ajax({
                    url: "{{ route('setTheme') }}",
                    method: 'POST',
                    data: {
                        ThemeStyle: 'sidebarcolor3'
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.status == 200) {

                            location.reload();
                        } else {
                            alert('failed');
                        }
                    }
                });
            });
            $(document).on('click', '#sidebarcolor4', function() {
                $.ajax({
                    url: "{{ route('setTheme') }}",
                    method: 'POST',
                    data: {
                        ThemeStyle: 'sidebarcolor4'
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.status == 200) {

                            location.reload();
                        } else {
                            alert('failed');
                        }
                    }
                });
            });
            $(document).on('click', '#sidebarcolor5', function() {
                $.ajax({
                    url: "{{ route('setTheme') }}",
                    method: 'POST',
                    data: {
                        ThemeStyle: 'sidebarcolor5'
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.status == 200) {

                            location.reload();
                        } else {
                            alert('failed');
                        }
                    }
                });
            });
            $(document).on('click', '#sidebarcolor6', function() {
                $.ajax({
                    url: "{{ route('setTheme') }}",
                    method: 'POST',
                    data: {
                        ThemeStyle: 'sidebarcolor6'
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.status == 200) {

                            location.reload();
                        } else {
                            alert('failed');
                        }
                    }
                });
            });
            $(document).on('click', '#sidebarcolor7', function() {
                $.ajax({
                    url: "{{ route('setTheme') }}",
                    method: 'POST',
                    data: {
                        ThemeStyle: 'sidebarcolor7'
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.status == 200) {

                            location.reload();
                        } else {
                            alert('failed');
                        }
                    }
                });
            });
            $(document).on('click', '#sidebarcolor8', function() {
                $.ajax({
                    url: "{{ route('setTheme') }}",
                    method: 'POST',
                    data: {
                        ThemeStyle: 'sidebarcolor8'
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.status == 200) {

                            location.reload();
                        } else {
                            alert('failed');
                        }
                    }
                });
            });



        });
        toastr.options.preventDuplicates = true;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function readNotification(id) {
            var id = id;
            $.ajax({
                url: "{{ route('notificationMarkRead') }}?id=" + id,
                method: 'POST',

                dataType: 'json',
                success: function(data) {
                    if (data.status == 200) {
                        location.reload();
                        // console.log($('.alert-count').text());
                    } else {
                        alert('failed');
                    }
                }
            });
        }

        function markAllRead() {
            $.ajax({
                url: "{{ route('markAllRead') }}",
                method: 'POST',
                dataType: 'json',
                success: function(data) {
                    if (data.status == 200) {
                        location.reload();
                    } else {
                        alert('failed');
                    }
                }
            });
        }
    </script>

</body>

</html>
