@extends('layouts.master')
@section('title', 'FIRO B Report')

@section('PageContent')
    <style>
        .report-filters {
            background: #f7f9fb;
            border: 1px solid #e2e7ec;
            padding: 12px;
        }

        .report-filters .form-label {
            color: #536170;
            font-size: 11px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        #report td {
            font-size: 12px;
            vertical-align: middle;
        }

        #report th {
            font-size: 11px;
            white-space: nowrap;
        }
    </style>

    <div class="page-content">
        <div class="page-breadcrumb align-items-center mb-3">
            <div class="breadcrumb-title">Employee FIRO B Report</div>
        </div>

        <div class="card border-top border-0 border-4 border-success">
            <div class="card-body">
                <div class="report-filters mb-3">
                    <div class="row g-2">
                        <div class="col-xl-2 col-md-4 col-sm-6">
                            <label for="filter_company" class="form-label">Company</label>
                            <select id="filter_company" class="form-select form-select-sm">
                                <option value="">All Companies</option>
                                @foreach($company_list as $id => $company)
                                    <option value="{{ $id }}">{{ $company }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-xl-2 col-md-4 col-sm-6">
                            <label for="filter_department" class="form-label">Department</label>
                            <select id="filter_department" class="form-select form-select-sm">
                                <option value="">All Departments</option>
                                @foreach($department_list as $id => $department)
                                    <option value="{{ $id }}">{{ $department }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-xl-2 col-md-4 col-sm-6">
                            <label for="filter_sub_department" class="form-label">Sub Department</label>
                            <select id="filter_sub_department" class="form-select form-select-sm" disabled>
                                <option value="">Select Department First</option>
                            </select>
                        </div>


                        <div class="col-xl-2 col-md-4 col-sm-6">
                            <label for="filter_designation" class="form-label">Designation</label>
                            <select id="filter_designation" class="form-select form-select-sm">
                                <option value="">All Designations</option>
                                @foreach($designation_list as $id => $designation)
                                    <option value="{{ $id }}">{{ $designation }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-xl-2 col-md-4 col-sm-6">
                            <label for="filter_firob_status" class="form-label">FIRO B Status</label>
                            <select id="filter_firob_status" class="form-select form-select-sm">
                                <option value="">All Statuses</option>
                                <option value="completed">Completed</option>
                                <option value="incomplete">Incomplete</option>
                                <option value="not_taken">YARMS Result</option>
                            </select>
                        </div>

                        <div class="col-12 d-flex justify-content-end gap-2 mt-3">
                            <button type="button" class="btn btn-light btn-sm" id="reset_filters">
                                <i class="bx bx-reset me-1"></i>Reset
                            </button>
                            <button type="button" class="btn btn-outline-success btn-sm" id="export_report">
                                <i class="fa fa-file-excel-o me-1"></i>Export
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover table-condensed" id="report" style="width: 100%">
                        <thead class="bg-success text-light text-center">
                            <tr>
                                <th>S.No</th>
                                <th>Employee Code</th>
                                <th>Employee Name</th>
                                <th>Company</th>
                                <th>Grade</th>
                                <th>Designation</th>
                                <th>Department</th>
                                <th>Sub Department</th>
                                <th>DOJ</th>
                                <th>FIRO B Date</th>
                                <th>FIRO B Result</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script_section')
    <script>
        $(function () {
            $('.report-filters select').val('');
            $('#filter_sub_department')
                .empty()
                .append('<option value="">Select Department First</option>')
                .prop('disabled', true);

            var reportTable = $('#report').DataTable({
                processing: true,
                serverSide: true,
                ordering: true,
                searching: true,
                pageLength: 25,
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                dom: 'lfrtip',
                ajax: {
                    url: '{{ route('get.emp.firob.reports') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function (data) {
                        data.Company = $('#filter_company').val();
                        data.Department = $('#filter_department').val();
                        data.SubDepartment = $('#filter_sub_department').val();
                        data.Designation = $('#filter_designation').val();
                        data.FirobStatus = $('#filter_firob_status').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'EmpCode', name: 'employee.EmpCode' },
                    { data: 'employee_name', name: 'employee.Fname', orderable: false },
                    { data: 'company_code', name: 'company.company_code', defaultContent: '-' },
                    { data: 'grade_name', name: 'grade.grade_name', defaultContent: '-' },
                    { data: 'designation_name', name: 'designation.designation_name', defaultContent: '-' },
                    { data: 'department_name', name: 'department.department_name', defaultContent: '-' },
                    { data: 'sub_department_name', name: 'sub_department.sub_department_name', defaultContent: '-' },
                    { data: 'DOJ', name: 'employee.DOJ' },
                    { data: 'firob_date', name: 'firob_summary.firob_date' },
                    { data: 'firob_result', name: 'firob_result', orderable: false, searchable: false }
                ],
                order: [[1, 'asc']]
            });

            function loadSubDepartments() {
                var department = $('#filter_department').val();
                var subDepartment = $('#filter_sub_department');

                subDepartment.empty();
                if (!department) {
                    subDepartment.append('<option value="">Select Department First</option>').prop('disabled', true);
                    return $.Deferred().resolve().promise();
                }

                subDepartment.append('<option value="">Loading...</option>').prop('disabled', true);

                return $.ajax({
                    url: '{{ route('get.emp.firob.sub.departments') }}',
                    type: 'GET',
                    data: {
                        Department: department,
                        Company: $('#filter_company').val()
                    },
                    success: function (subDepartments) {
                        subDepartment.empty().append('<option value="">All Sub Departments</option>');
                        $.each(subDepartments, function (index, item) {
                            subDepartment.append(
                                $('<option></option>').val(item.id).text(item.sub_department_name)
                            );
                        });
                        subDepartment.prop('disabled', false);
                    },
                    error: function () {
                        subDepartment.empty().append('<option value="">Unable to load</option>').prop('disabled', true);
                    }
                });
            }

            $('#filter_department').on('change', function () {
                loadSubDepartments().always(function () {
                    reportTable.ajax.reload();
                });
            });

            $('#filter_company').on('change', function () {
                if ($('#filter_department').val()) {
                    loadSubDepartments().always(function () {
                        reportTable.ajax.reload();
                    });
                } else {
                    reportTable.ajax.reload();
                }
            });

            $('#filter_sub_department, #filter_designation, #filter_firob_status').on('change', function () {
                reportTable.ajax.reload();
            });

            $('#reset_filters').on('click', function () {
                $('.report-filters select').val('');
                $('#filter_sub_department')
                    .empty()
                    .append('<option value="">Select Department First</option>')
                    .prop('disabled', true);
                reportTable.search('').ajax.reload();
            });

            $('#export_report').on('click', function () {
                var params = new URLSearchParams({
                    Company: $('#filter_company').val() || '',
                    Department: $('#filter_department').val() || '',
                    SubDepartment: $('#filter_sub_department').val() || '',
                    Designation: $('#filter_designation').val() || '',
                    FirobStatus: $('#filter_firob_status').val() || ''
                });

                window.location.href = '{{ route('export.emp.firob.reports') }}?' + params.toString();
            });
        });
    </script>
@endsection
