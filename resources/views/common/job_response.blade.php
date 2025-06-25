@extends('layouts.master')
@section('title', 'Jobs & Response')
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

        .frmbtn {
            padding: 2 px 4 px !important;
            font-size: 11px;
            cursor: pointer;
        }

        td.details-control {
            background: url("{{ asset('assets/images/details_open.png') }}") no-repeat center center;
            cursor: pointer;
        }

        tr.shown td.details-control {
            background: url("{{ asset('assets/images/details_close.png') }}") no-repeat center center;
        }
    </style>

    <div class="page-content">
        <!--breadcrumb-->
        <input type="hidden" name="ToDate" id="ToDate" value="{{ date('Y-m-d') }}">
        <div class="page-breadcrumb  align-items-center mb-3">
            <div class="row mb-1">
                <div class="col-3 breadcrumb-title ">
                    jobs & Response
                </div>
                <div class="col-2">
                    <select name="Fill_Company" id="Fill_Company" class="form-select form-select-sm"
                        onchange="GetJobResponse(); GetDepartment();">
                        <option value="">Select Company</option>
                        @foreach ($company_list as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-2">

                    <select name="Fill_Department" id="Fill_Department" class="form-select form-select-sm"
                        onchange="GetJobResponse();">
                        <option value="">Select Department</option>

                    </select>
                </div>
                <div class="col-2">
                    <select name="Year" id="Year" class="form-select form-select-sm" onchange="GetJobResponse();">
                        <option value="">Select Year</option>
                        @for ($i = 2021; $i <= date('Y'); $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-2">
                    <select name="Month" id="Month" class="form-select form-select-sm" onchange="GetJobResponse();">
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

        </div>
        <!--end breadcrumb-->

        <div class="card border-top border-0 border-4 border-primary mb-3">
            <div class="card-body table-responsive">
                <table class="table table-hover table-striped table-condensed align-middle text-center table-bordered"
                    id="JobApplications" style="width: 100%">
                    <thead class="text-center bg-primary text-light">
                        <tr class="text-center">
                            <td>#</td>
                            <td class="th-sm">S.No</td>
                            <td>JobCode</td>
                            <td>Department</td>
                            <td>Designation</td>
                            <td>Responses</td>
                            {{-- <td>Sources</td> --}}
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card border-top d-none border-0 border-4 border-primary mb-2" id="DetailDiv">
            <div class="card-body">
                <div class="row mb-1">
                    <h5 class=" text-primary" id="PostTitle"></h5>
                </div>
                <div class="row">
                    <div class="col-5">
                        <span class="d-inline">
                            <span style="font-weight: bold;">↱</span>
                            <label class="text-primary"><input id="checkall" type="checkbox" name="">&nbsp;Check
                                all</label>
                            <i class="text-muted" style="font-size: 13px;">With selected:</i>
                            <label class="text-primary " style=" cursor: pointer;" data-bs-toggle="modal"
                                data-bs-target="#TechScreeningModal"><i class="fas fa-share text-primary"></i> Fwd. for
                                Technical
                                Screening
                            </label>
                        </span>
                    </div>
                    <div class="col-3">
                        <span class="d-inline">
                            <select name="Source" id="Source" class="form-select form-select-sm">
                                <option value="">Select Source</option>
                                @foreach ($source_list as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </span>
                    </div>
                    <div class="col-2">
                        <span class="d-inline">
                            <select name="Gender" id="Gender" class="form-select form-select-sm">
                                <option value="">Select Gender</option>
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                                <option value="O">Others</option>
                            </select>
                        </span>
                    </div>
                </div>

            </div>
        </div>
        <div id="CandidateDiv"></div>
        <div id="pagination"></div>
        <input type="hidden" id="userrole" value="{{ Auth::user()->role }}">
        <input type="hidden" id="path" value="{{ URL::to('/') }}">
    </div>


    <div class="modal fade" id="HrScreeningModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog">
            <form action="{{ route('update_hrscreening') }}" method="POST" id="ScreeningForm">
                <div class="modal-content">
                    <div class="modal-body">
                        <input type="hidden" name="JAId" id="JAId">
                        <label for="Status">HR Screening Status</label>
                        <select name="Status" id="Status" class="form-select form-select-sm" required>
                            <option value="" disabled selected></option>
                            <option value="Selected">Selected</option>
                            <option value="Rejected">Rejected</option>
                            <option value="Irrelevant">Irrelevant</option>
                        </select>

                        <textarea name="RejectRemark" id="RejectRemark" cols="30" rows="3"
                            class="form-control form-control-sm mt-2 d-none" placeholder="Please Enter Rejection Remark"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="MoveCandidategModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <form action="{{ route('MoveCandidate') }}" method="POST" id="MoveCandidateForm">
                <div class="modal-content">
                    <div class="modal-body">
                        <label for="Status">Move Candidate To:</label>
                        <input type="hidden" name="MoveCandidate_JAId" id="MoveCandidate_JAId">
                        <select name="MoveCompany" id="MoveCompany" class="form-select form-select-sm">
                            <option value="" disabled selected></option>
                            @foreach ($company_list as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>

                        <label for="MoveDepartment">Department</label>
                        <select name="MoveDepartment" id="MoveDepartment" class="form-select form-select-sm">

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

    <div class="modal fade" id="TechScreeningModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tr>
                            <td style="vertical-align: middle;">Resume Sent For Technical Screen</td>
                            <td><input type="date" id="ResumeSent" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: middle;">Technical Screening By</td>
                            <td>
                                <select id="TechScrCompany" class="form-select form-select-sm mb-1">
                                    <option value="">Select Company</option>
                                    @foreach ($company_list as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>

                                <select id="TechScrDepartment" class="form-select form-select-sm mb-1">
                                    <option value="">Select Department</option>
                                </select>
                                <select id="ScreeningBy" class="form-select form-select-sm">
                                    <option value="">Select Employee</option>
                                </select>
                            </td>
                        </tr>
                    </table>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="SendForTechSceenBtn" class="btn btn-primary btn-sm">Save
                            changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scriptsection')
    <script>
        function GetDepartment() {
            var CompanyId = $('#Fill_Company').val();
            $.ajax({
                type: "GET",
                url: "{{ route('getDepartment') }}?CompanyId=" + CompanyId,
                beforeSend: function() {

                },
                success: function(res) {
                    if (res) {
                        $("#Fill_Department").empty();
                        $("#Fill_Department").append(
                            '<option value="" selected disabled >Select Department</option>');
                        $.each(res, function(key, value) {
                            $("#Fill_Department").append('<option value="' + value + '">' + key +
                                '</option>');
                        });
                    } else {
                        $("#Fill_Department").empty();
                    }
                }
            });
        }

        function GetJobResponse() {
            $('#JobApplications').DataTable().draw(true);

        }

        $(document).on('click', '#reset', function() {
            location.reload();
        });

        $(document).ready(function() {
            $('#JobApplications').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                searching: false,
                lengthChange: false,
                info: true,
                ajax: {
                    url: "{{ route('getJobResponseSummary') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function(d) {
                        d.Company = $('#Fill_Company').val();
                        d.Department = $('#Fill_Department').val();
                        d.Year = $('#Year').val();
                        d.Month = $('#Month').val();
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
                        data: 'JobCode',
                        name: 'JobCode'
                    },
                    {
                        data: 'Department',
                        name: 'Department'
                    },
                    {
                        data: 'Designation',
                        name: 'Designation'
                    },

                    {
                        data: 'Response',
                        name: 'Response'
                    },
                    /* {
                        data: 'Source',
                        name: 'Source'
                    }, */

                ],
            });


        });

        $(document).on('click', '.select_all', function() {
            if ($(this).prop("checked") == true) {
                $(this).closest("tr").addClass("bg-secondary bg-gradient text-light");
            } else {
                $(this).closest("tr").removeClass("bg-secondary bg-gradient text-light");
            }
        });

        function getPostTitle(JPId) {
            $.ajax({
                type: "POST",
                url: "{{ route('getPostTitle') }}?JPId=" + JPId,
                success: function(res) {
                    if (res) {
                        $("#PostTitle").html('Candidates Applied For: ' + res);
                    }
                }
            });
        }
        let page_no = 1;
        let JPId = '';
        let Gender = '';
        let Source = '';
        $(document).on('click', '.getCandidate', function() {
            JPId = $(this).data('id');
            getPostTitle(JPId);
            $('#DetailDiv').removeClass('d-none');
            getCandidate(JPId, page_no, Gender, Source);
        });

        $(document).on('change', '#Source', function() {
            Source = $(this).val();
            getCandidate(JPId, page_no, Gender, Source);
        });

        $(document).on('change', '#Gender', function() {
            Gender = $(this).val();
            getCandidate(JPId, page_no, Gender, Source);
        });

        async function getCandidate(JPId, pageNo, gender, source, state, city, hrScreeningStatus) {
            try {
                // Make AJAX request using fetch for better Promise support
                const response = await $.ajax({
                    type: "POST",
                    url: "{{ route('getJobResponseCandidateByJPId') }}",
                    data: {
                        JPId,
                        page: pageNo,
                        gender,
                        source,
                        state,
                        city,
                        hr_screening_status: hrScreeningStatus
                    }
                });

                // Build candidate cards
                const cards = await buildCandidateCards(response);

                // Update DOM
                $('#CandidateDiv').html(cards);
                $('#pagination').html(response.page_link);

            } catch (error) {
                console.error('Error fetching candidates:', error);
                $('#CandidateDiv').html('<div class="alert alert-danger">Error loading candidates</div>');
            }
        }

        async function buildCandidateCards(response) {
            let html = '';
            const startSNo = (response.data.current_page - 1) * response.data.per_page + 1;

            for (const [index, candidate] of response.data.data.entries()) {
                const jaid = btoa(candidate.JAId);

                // Determine background color
                const bgColor = getBackgroundColor(candidate);

                // Build card components
                const checkbox = buildCheckbox(candidate);
                const ribbon = candidate.ProfileViewed === 'Y' ?
                    '<div class="ribbon ribbon-primary"><i class="lni lni-checkmark" style="transform: rotate(308deg) !important;"></i></div>' :
                    '';

                const jobTitle = candidate.DesigId ?
                    candidate.Title :
                    `<i class="fa fa-pencil-square-o text-primary" style="cursor:pointer" id="AddToJobPost" data-id="${candidate.JAId}"></i>`;

                const experience = getExperience(candidate);
                const verifiedIcon = candidate.Verified === 'Y' ?
                    '<i class="fadeIn animated bx bx-badge-check text-success"></i>' :
                    '';

                const imageSrc = candidate.CandidateImage ?
                    "{{ Storage::disk('s3')->url('Recruitment/Picture/') }}" + candidate.CandidateImage :
                    $('#path').val() + '/assets/images/user1.png';

                // Check for duplicates
                const duplicateCount = await CheckDuplicate(candidate.Phone, candidate.Email);

                // Build candidate card
                html += `
            <div class="card mb-3 ribbon-box border ribbon-fill shadow-none right" style="background-color: ${bgColor}">
                ${ribbon}
                <div class="card-body" style="padding: 5px;">
                    <div class="row p-2 py-2">
                        <div style="width: 80%; float: left;">
                            <table class="jatbl table borderless appli-list" style="margin-bottom: 0px !important;">
                                <tbody>
                                    ${buildCandidateInfo(candidate, checkbox, duplicateCount, jobTitle, experience, verifiedIcon)}
                                    ${buildAdditionalInfo(candidate)}
                                </tbody>
                            </table>
                        </div>
                        <div style="width: 20%; float: left;">
                            <center>
                                <img src="${imageSrc}" style="width: 130px; height: 130px;" class="img-fluid rounded" />
                                <small>
                                    <span class="text-primary m-1" style="cursor: pointer; font-size:14px;">
                                        <a href="{{ route('candidate_detail') }}?jaid=${jaid}" target="_blank">View Details</a>
                                    </span>
                                </small>
                            </center>
                        </div>
                    </div>
                </div>
                ${buildManualEntryFooter(candidate)}
            </div>
        `;
            }

            return html;
        }

        function getBackgroundColor(candidate) {
            if (candidate.Status === 'Rejected' || candidate.BlackList === 1) {
                return '#fe36501f';
            }
            if (candidate.FwdTechScr === 'Yes') {
                return '#dbffdacc';
            }
            return '';
        }

        function buildCheckbox(candidate) {
            if (candidate.Status === 'Selected' && candidate.FwdTechScr === 'No' && candidate.BlackList === 0) {
                return `<input type="checkbox" name="selectCand" class="japchks" onclick="checkAllorNot()" value="${candidate.JAId}">`;
            }
            return '';
        }

        function getExperience(candidate) {
            if (candidate.Professional === 'F') {
                return 'Fresher';
            }
            if (candidate.JobStartDate) {
                const endDate = candidate.JobEndDate || $('#ToDate').val();
                return diff_year_month_day(candidate.JobStartDate, endDate);
            }
            return 'Experienced';
        }

        function buildCandidateInfo(candidate, checkbox, duplicateCount, jobTitle, experience, verifiedIcon) {
            let html = `
        <tr>
            <td colspan="3">
                <label>
                    ${checkbox}
                    <span style="color: #275A72; font-weight: bold; padding-bottom: 10px;">
                        ${candidate.FName} ${candidate.MName || ''} ${candidate.LName}
                        (Ref.No ${candidate.ReferenceNo})
                    </span>
                    ${duplicateCount > 1 ? buildDuplicateBadge(candidate) : ''}
                </label>
            </td>
        </tr>
        <tr>
            <td class="fw-bold-500" style="text-align: left"><b>Applied For</b></td>
            <td colspan="3">: ${jobTitle}</td>
        </tr>
        <tr>
            <td class="fw-bold-500">Experience</td>
            <td>: ${experience}</td>
            <td class="fw-bold-500">Contact No.</td>
            <td>: ${candidate.Phone} ${verifiedIcon}</td>
        </tr>
        <tr>
            <td class="fw-bold-500">Current Company</td>
            <td>: ${candidate.PresentCompany || ''}</td>
            <td class="fw-bold-500">Email ID</td>
            <td>: ${candidate.Email} ${verifiedIcon}</td>
        </tr>
        <tr>
            <td class="fw-bold-500">Current Designation</td>
            <td>: ${candidate.Designation || ''}</td>
            <td class="fw-bold-500">Education</td>
            <td>: ${candidate.EducationCode || ''}${candidate.Specialization ? ` - ${candidate.Specialization}` : ''}</td>
        </tr>
        <tr>
            <td class="fw-bold-500">Current Location</td>
            <td>: ${candidate.City}</td>
        </tr>
        <tr>
            <td class="fw-bold-500">Applied on date:</td>
            <td>: ${candidate.ApplyDate}</td>
        </tr>
        <tr>
            <td class="fw-bold-500">Source</td>
            <td>: ${candidate.ResumeSource}</td>
            <td class="text-danger fw-bold" style="text-align: center" colspan="2"></td>
        </tr>
    `;
            return html;
        }

        function buildDuplicateBadge(candidate) {
            const duplicateLink =
                `{{ route('get_duplicate_record') }}?Fname=${candidate.FName}&Phone=${candidate.Phone}&Email=${candidate.Email}&DOB=${candidate.DOB}&FatherName=${candidate.FatherName}`;
            return `<span class="badge badge-danger"><a href="${duplicateLink}" class="text-white" target="_blank">Duplicate</a></span>`;
        }

        function buildAdditionalInfo(candidate) {
            let html = '';
            if (candidate.BlackListRemark) {
                html += `<tr><td colspan="4" class="text-danger fw-bold">${candidate.BlackListRemark}</td></tr>`;
            }
            if (candidate.UnBlockRemark) {
                html += `<tr><td colspan="4" class="text-success fw-bold">${candidate.UnBlockRemark}</td></tr>`;
            }
            if (candidate.hr_screening_status) {
                html += `
            <tr>
                <td class="fw-bold-500">HR Screening Status</td>
                <td class="fw-bold">${candidate.hr_screening_status}</td>
            </tr>
            <tr>
                <td class="fw-bold-500">HR Screening Remark</td>
                <td class="fw-bold">${candidate.hr_screening_remark}</td>
            </tr>
        `;
            }
            return html;
        }

        function buildManualEntryFooter(candidate) {
            if (candidate.manual_entry_by_name) {
                return `
            <div class="card-footer border-0 p-1 bg-light-warning text-dark">
                <div class="row" style="float: right; margin-right: 20px;">
                    Manual Entry By: ${candidate.manual_entry_by_name}
                </div>
            </div>
        `;
            }
            return '';
        }

        let i = 1;
        $(document).on('click', '.page_click', function(e) {
            e.preventDefault();
            var rel = $(this).attr('rel');
            if (rel == 'next') {
                var no = i++;
                getCandidate(JPId, parseInt(no + 1), Gender, Source);
            } else if (rel == 'prev') {
                var no = i--;
                getCandidate(JPId, parseInt(no - 1), Gender, Source);
            } else {
                page_no = $(this).text();
                getCandidate(JPId, page_no, Gender, Source);
                i = page_no;
            }
        });

        function diff_year_month_day(dt1, dt2) {

            var date2 = new Date(dt1.replace('-', ',')); //old date

            var date1 = new Date(dt2.replace('-', ',')); //latest date, current date

            var diff = Math.floor(date1.getTime() - date2.getTime());
            var day = 1000 * 60 * 60 * 24;
            var days = Math.floor(diff / day);

            var months = Math.floor(days / 30);
            var years = Math.floor(months / 12);

            var yd = Math.floor(years * 365);
            var dd = Math.floor(days - yd);

            var months = Math.floor(dd / 30);
            var cc = Math.floor(months * 30);
            var days = Math.floor(dd - cc);
            return years + " Years " + months + " Months ";
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

        $(document).on('change', '#TechScrDepartment', function() {
            var DepartmentId = $(this).val();
            $.ajax({
                type: "GET",
                url: "{{ route('getReportingManager') }}?DepartmentId=" + DepartmentId,
                success: function(res) {
                    if (res) {
                        $("#ScreeningBy").empty();
                        $("#ScreeningBy").append(
                            '<option value="">Select Department</option>');
                        $.each(res, function(key, value) {
                            $("#ScreeningBy").append('<option value="' + value +
                                '">' +
                                key +
                                '</option>');
                        });
                    } else {
                        $("#ScreeningBy").empty();
                    }
                }
            });
        });

        $('#checkall').click(function() {
            if ($(this).prop("checked") == true) {
                $('.japchks').prop("checked", true);
            } else if ($(this).prop("checked") == false) {
                $('.japchks').prop("checked", false);
            }
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

        $(document).on('click', '#MoveCandidate', function() {
            var JAId = $(this).data('id');
            $('#MoveCandidate_JAId').val(JAId);
            $('#MoveCandidategModal').modal('show');
        });

        $('#ScreeningForm').on('submit', function(e) {
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

        $('#MoveCandidateForm').on('submit', function(e) {
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

        $(document).on('change', '#Status', function() {
            var Status = $(this).val();
            if (Status == 'Rejected') {
                $('#RejectRemark').removeClass('d-none');
                $("#RejectRemark").prop('required', true);
            } else {
                $('#RejectRemark').addClass('d-none');
                $("#RejectRemark").prop('required', false);
            }
        });

        $(document).on('click', '#BlackListCandidate', function() {
            var JCId = $(this).data('id');
            var Remark = prompt("Please Enter Remark to BlackList Candidate");
            if (Remark != null) {
                $.ajax({
                    url: "{{ route('BlacklistCandidate') }}",
                    type: 'POST',
                    data: {
                        JCId: JCId,
                        Remark: Remark
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.status == 200) {
                            toastr.success(data.msg);
                            window.location.reload();
                        } else {
                            toastr.error(data.msg);
                        }
                    }
                });
            } else {
                window.location.reload();
            }
        });

        $(document).on('click', '#UnBlockCandidate', function() {
            var JCId = $(this).data('id');
            var Remark = prompt("Please Enter Remark to Unblock Candidate");
            if (Remark != null) {
                $.ajax({
                    url: "{{ route('UnBlockCandidate') }}",
                    type: 'POST',
                    data: {
                        JCId: JCId,
                        Remark: Remark
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.status == 200) {
                            toastr.success(data.msg);
                            window.location.reload();
                        } else {
                            toastr.error(data.msg);
                        }
                    }
                });
            } else {
                window.location.reload();
            }
        });

        $(document).on('click', '#HrScreening', function() {
            var JAId = $(this).data('id');
            $('#JAId').val(JAId);
            $('#HrScreeningModal').modal('show');
        });

        $(document).on('click', '#SendForTechSceenBtn', function() {
            var JAId = [];
            var ScreeningBy = $('#ScreeningBy').val();
            $("input[name='selectCand']").each(function() {
                if ($(this).prop("checked") == true) {
                    var value = $(this).val();
                    JAId.push(value);
                }
            });
            if (JAId.length > 0) {
                if (confirm('Are you sure to Send Selected Candidates to Screening Stage?')) {
                    $.ajax({
                        url: '{{ url('SendForTechScreening') }}',
                        method: 'POST',
                        data: {
                            JAId: JAId,
                            ScreeningBy: ScreeningBy
                        },
                        success: function(data) {
                            if (data.status == 400) {
                                alert('Something went wrong..!!');
                            } else {
                                toastr.success(data.msg);
                                window.location.reload();
                            }
                        }
                    });
                }

            } else {
                alert('No Candidate Selected!\nPlease select atleast one candidate to proceed.');
            }

        });
    </script>
@endsection
