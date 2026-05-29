@php

$country_list = DB::table('master_country')->pluck('CountryName', 'CountryId');
@endphp
@extends('layouts.master')
@section('title', 'Job Applications')
@section('PageContent')
    <style>
        .table>:not(caption)>*>* {
            padding: 2px 1px;
        }

        .frminp {
            padding: 4 px !important;
            height: 25 px;
            border-radius: 4 px;
            font-size: 11px;
            font-weight: 550;
        }

        #applications {
            height: 1000px;
            overflow-y: scroll;
        }

        #applications::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for IE, Edge and Firefox */
        #applications {
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
        }

    </style>

    <div class="page-content">
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
            <div class="col">
                <div class="card radius-10 ">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0">Total Applications:</p>
                            </div>
                            <div class="ms-auto font-20">{{ $total_candidate }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <hp class="mb-0">MRF Pending :</hp>
                            </div>
                            <div class="ms-auto font-20">{{ $total_pending_mrf ?? 0 }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
        </div>
       
        <div class="row">
            <div class="col-9">
                <div class="card border-top border-0 border-4 border-primary mb-1">
                    <div class="card-body d-flex justify-content-start g-2 gap-2" style="padding: 5px;">
                        
                           <tr>
                                <td class="p-1"><span style="color:red;">Requisition Form Link</span></td>
                                <td colspan="3"><input type="text" id="link" value="{{ url('candidate-requisition-form') }}">
                                <button onclick="copylink()" class="btn btn-xs btn-primary"> Copy</button>
                                </td>
                            </tr>
                        
                        
                    </div>
                </div>
                <div id="applications">
                    @foreach ($candidate_list as $row)
                        @php
                            $bg_color = '#dbffdacc';
                            $jobapply = null;
                            if($row->JCId)
                            {
                                $jobapply = DB::table('jobapply')->where('JcId',$row->JCId)->latest('JAId')->first();
                            }
                            
                        @endphp
                        <div class="card mb-3" style="background-color:<?= $bg_color ?>">
                            <div class="card-body" style="padding: 5px;">
                                <div class="row  p-2 py-2">
                                    <div style="width: 80%;float: left;">
                                        <table class="jatbl table borderless" style="margin-bottom: 0px !important;">
                                            <tbody>
                                                <tr>
                                                    <td colspan="3">
                                                        <label>
                                                            {{-- @if (isset($jobapply) && $jobapply->Status == 'Selected' && $row->FwdTechScr == 'No' && $row->BlackList == 0)
                                                                <input type="checkbox" name="selectCand"
                                                                    class="japchks" onclick="checkAllorNot()"
                                                                    value="{{ $row->JAId }}">
                                                            @endif --}}
                                                            <span
                                                                style="color: #275A72;font-weight: bold;padding-bottom: 10px;">
                                                                {{ $row->FName }} {{ $row->MName }} {{ $row->LName }}
                                                                (Ref.No {{ $row->ReferenceNo ?? ''}} ) </span> <span>
                                                                @php
                                                                    
                                                                    $dup = CheckDuplicate($row->FName, $row->Phone, $row->Email, $row->DOB, $row->FatherName);
                                                                    
                                                                @endphp

                                                                @if ($dup > 1)
                                                                    <span class="badge badge-danger"><a
                                                                            href="{{ route('get_duplicate_record') }}?Fname={{ $row->FName }}&Phone={{ $row->Phone }}&Email={{ $row->Email }}&DOB={{ $row->DOB }}&FatherName={{ $row->FatherName }}"
                                                                            class="text-white"
                                                                            target="_blank">Duplicate</a></span>
                                                                @endif
                                                            </span>
                                                        </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: left">Applied For<span
                                                            class="text-right fw-bold">:</span></td>
                                                    <td colspan="3" style="text-align: left" class="text-primary">
                                                        @if(isset($jobapply) && $jobapply->JPId != null)
                                                          @php 
                                                            $post = DB::table('jobpost')->where('JPID', $jobapply->JPId)->first();
                                                          @endphp
                                                          {{ $post->Title  ?? ''}}
                                                        @else
                                                           <i class='fa fa-pencil-square-o text-primary' aria-hidden='true' style='cursor: pointer;' id='AddToJobPost' data-id="{{ $row->JCId }}"></i>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr class="">
                                                    <td>Experience<span class="pull-right" style="width: 25%">:</span>
                                                    </td>
                                                    <td style="text-align: left">
                                                        @php
                                                            if ($row->Professional == 'F') {
                                                                echo 'Fresher';
                                                            } else {
                                                                if ($row->JobStartDate != null) {
                                                                    $fdate = $row->JobStartDate;
                                                                    if ($row->JobEndDate == null) {
                                                                        $tdate = Carbon\Carbon::now();
                                                                    } else {
                                                                        $tdate = $row->JobEndDate;
                                                                    }
                                                            
                                                                    echo Carbon\Carbon::createFromDate($fdate)
                                                                        ->diff($tdate)
                                                                        ->format('%y Years %m Months');
                                                                } else {
                                                                    echo 'Experienced';
                                                                }
                                                            }
                                                        @endphp
                                                    </td>
                                                    <td style="text-align: left;">Contact No:</td>
                                                    <td style="text-align:left"> {{ $row->Phone }}@if ($row->Verified == 'Y')
                                                            <i class="fadeIn animated bx bx-badge-check text-success"></i>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr class="">
                                                    <td>Cur. Company<span class="pull-right">:</span></td>
                                                    <td style="text-align: left">
                                                        <?= $row->PresentCompany == null ? '' : $row->PresentCompany ?></td>
                                                    <td style="text-align: left">Email ID<span
                                                            class="pull-right">:</span>
                                                    </td>
                                                    <td style="text-align: left">{{ $row->Email }} @if ($row->Verified == 'Y')
                                                            <i class="fadeIn animated bx bx-badge-check text-success"></i>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr class="">
                                                    <td>Cur. Designation<span class="pull-right">:</span></td>
                                                    <td style="text-align: left">
                                                        <?= $row->Designation == null ? '' : $row->Designation ?></td>
                                                    <td style="text-align: left">Education<span
                                                            class="pull-right">:</span>
                                                    </td>
                                                    <td style="text-align: left">
                                                        <?= $row->Education == null ? '' : getEducationCodeById($row->Education) ?>
                                                        <?= $row->Specialization == null ? '' : '-' . getSpecializationbyId($row->Specialization) ?>
                                                    </td>
                                                </tr>
                                                <tr class="">
                                                    <td>Cur. Location<span class="pull-right">:</span></td>
                                                    <td style="text-align: left">{{ $row->City }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Apply Date:</td>
                                                    <td style="text-align: left">
                                                        {{ date('d-m-Y', strtotime($row->CreatedTime)) }}</td>
                                                    <td style="text-align: left">HR Screening:</td>
                                                    <td style="text-align: left">
                                                            Selected
                                                    </td>
                                                </tr>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="" style=" width: 20%;float: left;">
                                        <center>
                                            @if ($row->CandidateImage == null)
                                                <img src="{{ URL::to('/') }}/assets/images/user1.png"
                                                    style="width: 100px; height: 100px;" class="img-fluid rounded" />
                                            @else
                                                <a href="#" class="pop">
                                                    <img src="{{ Storage::disk('s3')->url('VVNR_Recruitment/Picture/' . $row->CandidateImage) ?? ''}}"
                                                        style="width: 100px; height: 100px;" class="img-fluid rounded" />
                                                </a>
                                            @endif
                                        </center>
                                        <center>
                                            <small>
                                                <span class="text-primary m-1 " style="cursor: pointer; font-size:14px;">
                                                    
                                                        @if(isset($jobapply) && $jobapply != null)
                                                    
                                                            <?php $sendingId = base64_encode($jobapply->JAId); ?>

                                                            <a href="{{ route('candidate_detail') }}?jaid={{ $sendingId }}"
                                                        target="_blank">View Details</a>
                                                        @else
                                                            <?php 
                                                            $sendingId = base64_encode($row->JCId);
                                                            ?>
                                                            <a href="{{ route('requisition_candidate_detail') }}?jcid={{ $sendingId }}"
                                                        target="_blank">View Details</a>
                                                        @endif
                                                    
                                                    
                                                </span>
                                            </small>
                                        </center>

                                        
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

                {{ $candidate_list->appends([])->links('vendor.pagination.custom') }}
            </div>

            <div class="col-3">
                <div class="card border-top border-0 border-4 border-danger">
                    <div class="card-body">
                        <div class="col-12 mb-2 d-flex justify-content-between">
                            <span class="d-inline fw-bold">Filter</span>
                            <span class="text-danger fw-bold" style="font-size: 14px; cursor: pointer;" id="reset"><i
                                    class="bx bx-refresh"></i>Reset</span>
                        </div>
                        <div class="col-12 mb-2">
                            <select name="mrf_mapped" id="mrf_mapped" class="form-select form-select-sm" onchange="GetApplications();">
                                <option value="">MRF Mapped</option>
                                    <option value="yes">YES</option>
                                    <option value="no">No</option>

                            </select>
                            @if (isset($_REQUEST['mrf_mapped']) && $_REQUEST['mrf_mapped'] != '')
                                <script>
                                    $('#mrf_mapped').val('<?= $_REQUEST['mrf_mapped'] ?>');
                                </script>
                            @endif
                        </div>

                        <div class="col-12 mb-2">
                            <select name="Fill_Company" id="Fill_Company" class="form-select form-select-sm">
                                <option value="">Select Company</option>
                                @foreach ($company_list as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            @if (isset($_REQUEST['Company']) && $_REQUEST['Company'] != '')
                                <script>
                                    $('#Fill_Company').val('<?= $_REQUEST['Company'] ?>');
                                </script>
                            @endif
                        </div>
                        <div class="col-12 mb-2">

                            <select name="Fill_Department" id="Fill_Department" class="form-select form-select-sm"
                                onchange="GetApplications();">
                                <option value="">Select Department</option>
                            </select>

                        </div>
                       
                        <div class="col-12 mb-2">
                            <select name="Year" id="Year" class="form-select form-select-sm" onchange="GetApplications();">
                                <option value="">Select Year</option>
                                @for ($i = 2021; $i <= date('Y'); $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            @if (isset($_REQUEST['Year']) && $_REQUEST['Year'] != '')
                                <script>
                                    $('#Year').val('<?= $_REQUEST['Year'] ?>');
                                </script>
                            @endif
                        </div>
                        <div class="col-12 mb-2">
                            <select name="Month" id="Month" class="form-select form-select-sm"
                                onchange="GetApplications();">
                                <option value="">Select Month</option>
                                @foreach ($months as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            @if (isset($_REQUEST['Month']) && $_REQUEST['Month'] != '')
                                <script>
                                    $('#Month').val('<?= $_REQUEST['Month'] ?>');
                                </script>
                            @endif
                        </div>
                        
                        <div class="col-12 mb-2">
                            <select name="Fill_Gender" id="Fill_Gender" class="form-select form-select-sm"
                                onchange="GetApplications();">
                                <option value="">Select Gender</option>
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                                <option value="O">Others</option>
                            </select>
                            @if (isset($_REQUEST['Gender']) && $_REQUEST['Gender'] != '')
                                <script>
                                    $('#Fill_Gender').val('<?= $_REQUEST['Gender'] ?>');
                                </script>
                            @endif
                        </div>
                        <div class="col-12 mb-2">
                            <select name="Education" id="Education" class="form-select form-select-sm"
                                onchange="GetApplications();">
                                <option value="">Select Education</option>
                                @foreach ($education_list as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            @if (isset($_REQUEST['Education']) && $_REQUEST['Education'] != '')
                                <script>
                                    $('#Education').val('<?= $_REQUEST['Education'] ?>');
                                </script>
                            @endif
                        </div>
                        <div class="col-12 mb-2">
                            <input type="text" name="Name" id="Name" class="form-control form-control-sm"
                                placeholder="Search by Name" onkeyup="GetApplications();">
                        </div>
                        @if (isset($_REQUEST['Name']) && $_REQUEST['Name'] != '')
                            <script>
                                $('#Name').val('<?= $_REQUEST['Name'] ?>');
                            </script>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>



    <div class="modal fade" id="AddJobPostModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog">
            <form action="{{ route('MapRequisitionCandidateToJob') }}" method="POST" id="MapCandidateForm">
                <div class="modal-content">
                    <div class="modal-body">
                        <input type="hidden" name="AddJobPost_JCId" id="AddJobPost_JCId">
                        <label for="Status">Map Candidate to Job</label>
                        <select name="JPId" id="JPId" class="form-select form-select-sm">
                            <option value="">Select</option>
                            @foreach ($jobpost_list as $item)
                                <option value="{{ $item->JPId }}">{{ $item->JobCode }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

   
@endsection

@section('scriptsection')
    <script>
        $(document).ready(function() {
            $('.pop').on('click', function() {
                $('.imagepreview').attr('src', $(this).find('img').attr('src'));
                $('#imagemodal').modal('show');
            });
            GetDepartment();

            function copylink() {
            var copyText = document.getElementById("link");
            copyText.select();
            copyText.setSelectionRange(0, 99999)
            document.execCommand("copy");
            alert("Copied Link: " + copyText.value);
        }

            function GetDepartment() {
                var CompanyId = $('#Fill_Company').val();
                $.ajax({
                    type: "GET",
                    url: "{{ route('getDepartment') }}?CompanyId=" + CompanyId,
                    success: function(res) {
                        if (res) {
                            $("#Fill_Department").empty();
                            $("#Fill_Department").append(
                                '<option value="">Select Department</option>');
                            $.each(res, function(key, value) {
                                $("#Fill_Department").append('<option value="' + value + '">' +
                                    key +
                                    '</option>');
                            });
                            $('#Fill_Department').val('<?= $_REQUEST['Department'] ?? '' ?>');
                        } else {
                            $("#Fill_Department").empty();
                        }
                    }
                });
            }

            function GetApplications() {
                var Company = $('#Fill_Company').val() || '';
                var Department = $('#Fill_Department').val() || '';
                var mrf_mapped = $('#mrf_mapped').val() || '';
                var Year = $('#Year').val() || '';
                var Month = $('#Month').val() || '';
                var Source = $('#Source').val() || '';
                var Gender = $('#Fill_Gender').val() || '';
                var Education = $('#Education').val() || '';
                var Name = $('#Name').val() || '';
                window.location.href = "{{ route('requisition.candidate.application') }}?Company=" + Company + "&Department=" +
                    Department + "&mrf_mapped=" + mrf_mapped + "&Year=" + Year + "&Month=" + Month + "&Source=" + Source + "&Gender=" + Gender +
                    "&Education=" + Education + "&Name=" + Name;
            }

            $(document).on('change', '#MoveCompany', function() {
                var CompanyId = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "{{ route('getDepartment') }}?CompanyId=" + CompanyId,
                    success: function(res) {
                        if (res) {
                            $("#MoveDepartment").empty();
                            $("#MoveDepartment").append(
                                '<option value="">Select Department</option>');
                            $.each(res, function(key, value) {
                                $("#MoveDepartment").append('<option value="' + value +
                                    '">' +
                                    key +
                                    '</option>');
                            });
                            $('#MoveDepartment').val('<?= $_REQUEST['Department'] ?? '' ?>');
                        } else {
                            $("#MoveDepartment").empty();
                        }
                    }
                });
            });

            $(document).on('change', '#TechScrCompany', function() {
                var CompanyId = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "{{ route('getDepartment') }}?CompanyId=" + CompanyId,
                    success: function(res) {
                        if (res) {
                            $("#TechScrDepartment").empty();
                            $("#TechScrDepartment").append(
                                '<option value="">Select Department</option>');
                            $.each(res, function(key, value) {
                                $("#TechScrDepartment").append('<option value="' +
                                    value +
                                    '">' +
                                    key +
                                    '</option>');
                            });
                            $('#TechScrDepartment').val('<?= $_REQUEST['Department'] ?? '' ?>');
                        } else {
                            $("#TechScrDepartment").empty();
                        }
                    }
                });
            });

           

            $(document).on('change', '#Fill_Company', function() {
                GetApplications();
            });
            $(document).on('change', '#Fill_Department', function() {
                GetApplications();
            });
            $(document).on('change','#mrf_mapped',function(){
               GetApplications();
            });
            $(document).on('change', '#Year', function() {
                GetApplications();
            });
            $(document).on('change', '#Month', function() {
                GetApplications();
            });
            $(document).on('change', '#Source', function() {
                GetApplications();
            });
            $(document).on('change', '#Fill_Gender', function() {
                GetApplications();
            });
            $(document).on('change', '#Education', function() {
                GetApplications();
            });
            $(document).on('blur', '#Name', function() {
                GetApplications();
            });

            $(document).on('click', '#reset', function() {
                window.location.href = "{{ route('requisition.candidate.application') }}";
            });

           

            $(document).on('click', '#AddToJobPost', function() {
                var JCId = $(this).data('id');
                $('#AddJobPost_JCId').val(JCId);
                $('#AddJobPostModal').modal('show');
            });

           
            

            $('#MapCandidateForm').on('submit', function(e) {
                e.preventDefault();
                var form = this;
                $.ajax({
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    data: new FormData(form),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    success: function(data) {
                        if (data.status == 400) {
                            toastr.error(data.msg);
                        } else {
                            toastr.success(data.msg);
                            window.location.reload();
                        }
                    }
                });
            });

           
            $(document).on('change', '#CandidateImage', function(e) {
                const [file] = e.target.files;
                if (file) {
                    img1.src = URL.createObjectURL(file);
                }
            });

           
        });


       

        function checkAllorNot() {
            var allchk = 1;
            $('.japchks').each(function() {
                if ($(this).prop("checked") == false) {
                    allchk = 0;
                }
            });
            if (allchk == 0) {
                $('#checkall').prop("checked", false);
            } else if (allchk == 1) {
                $('#checkall').prop("checked", true);
            }
        }

        //======================================================//
        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;

            return true;
        }

        function convertCase(evt) {
            var text = $(evt).val();
            $(evt).val(camelCase(text));
        }

        function camelCase(str) {
            return str.replace(/(?:^|\s)\w/g, function(match) {

                return match.toUpperCase();
            });
        }

        function checkRequired() {
            var res = 0;
            $('.reqinp').each(function() {
                if ($(this).val() == '' || $(this).val() == null) {
                    $(this).addClass('errorfield');
                    res = 1;
                } else {
                    $(this).removeClass('errorfield');
                }
            });
            return res;
        }

        function checkResumeSource(id) {

            if (id == 5 || id == 6 || id == 8) {
                $('#othersource_tr').removeClass('d-none');
            } else {
                $('#othersource_tr').addClass('d-none');
            }

        }

        

        
       
    </script>
@endsection
