@php
use function App\Helpers\getDepartment;
use function App\Helpers\getDesignation;
use function App\Helpers\getDistrictName;
use function App\Helpers\getStateName;
use function App\Helpers\getEducationById;
use function App\Helpers\getSpecializationbyId;
use function App\Helpers\getCollegeById;

@endphp
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

    </style>
</head>

<body>

    <table class=" fstable table table-bordered">
        <tbody>
            <tr>
                <td>
                    <div style="background-color: #275A72; padding: 5px 5px; height:40px;" class="bg-gradient">
                        <div style="float:left;line-height:40px;">
                            <h6 style="color:white">
                                @if ($MRFDetails->Type == 'N' or $MRFDetails->Type == 'N_HrManual')
                                    {{ 'New MRF' }}
                                @elseif($MRFDetails->Type =='SIP' OR $MRFDetails->Type =='SIP_HrManual')
                                    {{ 'SIP/Internship MRF' }}
                                @elseif($MRFDetails->Type =='Campus' OR $MRFDetails->Type =='Campus_HrManual')
                                    {{ 'Campus MRF' }}
                                @else
                                    {{ 'Replacement MRF' }}
                                @endif
                                --
                                <small>{{ $MRFDetails->JobCode }}</small>
                            </h6>
                        </div>

                        <button type="button" class="btn btn-danger btn-sm" style="float: right;"
                            onclick="window.parent.closemrf('<?= $_REQUEST['id'] ?>');"><i
                                class="fa fa-close"></i></button>
                        @if ($MRFDetails->Status == 'New')
                            <button type="button" class="btn btn-primary btn-sm"
                                style="float: right; margin-right: 10px;"><i class="fa fa-pencil"
                                    onclick="window.location.href='{{ route('editMrf') }}?id='+<?= $_REQUEST['id'] ?>"></i></button>
                        @endif


                    </div>
                </td>

            </tr>
            <tr>
                <td>
                    <table class=" cstable table-bordered" style="width: 100%; ">
                        <thead>
                            <tr>
                                <th style="width: 30%">Reason For Creating New Position</th>
                                <td>
                                    {{ $MRFDetails->Reason }}
                                </td>
                            </tr>
                            <tr>
                                <th>Department</th>
                                <td>{{ getDepartment($MRFDetails->DepartmentId) }}</td>
                            </tr>
                            @if ($MRFDetails->Type == 'N' or $MRFDetails->Type == 'N_HrManual' or $MRFDetails->Type == 'Campus' or $MRFDetails->Type == 'Campus_HrManual' or $MRFDetails->Type == 'R' or $MRFDetails->Type == 'R_HrManual')
                                <tr>
                                    <th>Designation</th>


                                    <td>{{ getDesignation($MRFDetails->DesigId) }}</td>

                                </tr>
                            @endif
                            <tr>
                                <th>Number of Position</th>
                                <td>
                                    {{ $MRFDetails->Positions }}
                                </td>
                            </tr>

                            <tr>
                                <th>Location </th>
                                <td>
                                    <ol style="margin-bottom: 0px;">
                                        @foreach ($LocationDetail as $item)

                                            <li>{{ getDistrictName($item['city']) }},{{ getStateName($item['state']) }}
                                                - {{ $item['nop'] }}
                                            </li>

                                        @endforeach
                                    </ol>
                                </td>
                            </tr>
                            @if ($MRFDetails->Type == 'N' or $MRFDetails->Type == 'N_HrManual' or $MRFDetails->Type == 'Campus' or $MRFDetails->Type == 'Campus_HrManual' or $MRFDetails->Type == 'R' or $MRFDetails->Type == 'R_HrManual')

                                <tr>
                                    <th>Expected CTC </th>
                                    <td>
                                        Min: {{ $MRFDetails->MinCTC }} <br>
                                        Max: {{ $MRFDetails->MaxCTC }}
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <th>
                                        Desired Stipend
                                    </th>
                                    <td>
                                        {{ $MRFDetails->Stipend }}
                                    </td>
                                </tr>
                            @endif

                            @if ($MRFDetails->Type == 'N' or $MRFDetails->Type == 'N_HrManual' or $MRFDetails->Type == 'Campus' or $MRFDetails->Type == 'Campus_HrManual' or $MRFDetails->Type == 'R' or $MRFDetails->Type == 'R_HrManual')
                                <tr>
                                    <th>Work Experience</th>
                                    <td>
                                        {{ $MRFDetails->WorkExp }}
                                    </td>
                                </tr>

                            @endif

                            @if ($MRFDetails->Type == 'SIP' or $MRFDetails->Type == 'SIP_HrManual')
                                <tr>
                                    <th>Other Benifits</th>
                                    <td>
                                        @if ($MRFDetails->TwoWheeler != null)
                                            2 Wheeler reimbursement Rs. {{ $MRFDetails->TwoWheeler }} per km <br>
                                        @endif
                                        @if ($MRFDetails->DA != null)
                                            DA Rs. {{ $MRFDetails->DA }} per day
                                        @endif
                                    </td>
                                </tr>

                            @endif

                            <tr>
                                <th>Job Description</th>
                                <td>
                                    {!! $MRFDetails->Info !!}
                                </td>
                            </tr>

                            <tr>
                                <th>Education </th>
                                <td>
                                    <ol style="margin-bottom: 0px;">
                                        @foreach ($EducationDetail as $item)

                                            <li>
                                                @if ($item['e'] != '')
                                                    {{ getEducationById($item['e']) }}
                                                @else
                                                    {{ '' }}
                                                @endif

                                                @if ($item['s'])
                                                    -{{ getSpecializationbyId($item['s']) }}
                                                @else
                                                    {{ '' }}
                                                @endif

                                            </li>

                                        @endforeach
                                    </ol>
                                </td>
                            </tr>
                            <tr>
                                <th>University/College </th>
                                <td>
                                    <ol style="margin-bottom: 0px;">
                                        @foreach ($UniversityDetail as $item)
                                            <li>
                                                @if ($item != '')
                                                    {{ getCollegeById($item) }}
                                                @else
                                                    {{ '' }}
                                                @endif

                                            </li>
                                        @endforeach
                                    </ol>
                                </td>
                            </tr>
                            <tr>
                                <th>Key Position Criteria </th>
                                <td>
                                    <ol style="margin-bottom: 0px;">
                                        @foreach ($KPDetail as $item)

                                            @if ($item != '')
                                                <li> {{ $item }}</li>
                                            @else
                                                {{ '' }}
                                            @endif

                                            </li>
                                        @endforeach
                                    </ol>
                                </td>
                            </tr>
                            <tr>
                                <th>Any Other Remarks</th>
                                <td>
                                    {{ $MRFDetails->Remarks }}
                                </td>
                            </tr>
                            @if ($MRFDetails->RemarkHr != null)
                                <tr>
                                    <th>Remark By HR</th>
                                    <td>
                                        {{ $MRFDetails->RemarkHr }}
                                    </td>
                                </tr>
                            @endif
                        </thead>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>
