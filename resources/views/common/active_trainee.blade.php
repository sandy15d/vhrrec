@extends('layouts.master')
@section('title', 'Active Trainee')
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

        table,
        th,
        td {
            border: 0.25px solid white;
            vertical-align: middle;
        }

    </style>
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb  align-items-center mb-3">
            <div class="row mb-1">
                <div class="col-3 breadcrumb-title ">
                    Active Trainee
                </div>
                <div class="col-2">
                    <select name="Fill_Company" id="Fill_Company" class="form-select form-select-sm"
                        onchange="GetCampusRecords(); GetDepartment();">
                        <option value="">Select Company</option>
                        @foreach ($company_list as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-2">

                    <select name="Fill_Department" id="Fill_Department" class="form-select form-select-sm"
                        onchange="GetCampusRecords();">
                        <option value="">Select Department</option>

                    </select>
                </div>
                <div class="col-2">
                    <select name="Year" id="Year" class="form-select form-select-sm" onchange="GetCampusRecords();">
                        <option value="">Select Year</option>
                        @for ($i = 2021; $i <= date('Y'); $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-2">
                    <select name="Month" id="Month" class="form-select form-select-sm" onchange="GetCampusRecords();">
                        <option value="">Select Month</option>
                        @foreach ($months as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-1">
                    <button type="reset" class="btn btn-danger btn-sm" id="reset"><i class="bx bx-refresh"></i></button>
                </div>
            </div>

        </div>
        <!--end breadcrumb-->

        <div class="card border-top border-0 border-4 border-primary">
            <div class="card-body table-responsive">
                <table class="table table-striped table-condensed" id="CampusApplication"
                    style="width: 100%; margin-right:20px;">
                    <thead class="text-center bg-primary bg-gradient text-light">
                        <tr>
                            <td>#</td>
                            <td>S.No</td>
                            <td>Reference No</td>
                            <td>Name</td>
                            <td>Department</td>
                            <td>DOJ</td>
                            <td>DOC</td>
                            <td>Stipend</td>
                            <td>Other Benifit</td>
                            <td style="width: 15%">Action</td>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="EditModal" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-info bg-gradient">
                    <h6 class="modal-title text-white" id="candidatename"></h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('save_trainee_detail') }}" method="POST" id="trainee_detail_form">
                    @csrf
                    <div class="modal-body">
                        <table class="table table-borderless">
                            <tr>
                                <td>Date of Join</td>
                                <td>
                                    <input type="hidden" name="TId" id="TId">
                                    <input type="date" name="Doj" id="Doj" class="form-control form-control-sm frminp">
                                </td>
                            </tr>

                            <tr>
                                <td>Stipend</td>
                                <td>
                                    <input type="text" name="Stipend" id="Stipend"
                                        class="form-control form-control-sm frminp">
                                </td>
                            </tr>
                            <tr>
                                <td>Other Benefit</td>
                                <td>
                                    <textarea name="OtherBenefit" id="OtherBenefit" cols="10" rows="3" class="form-control form-control-sm"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>Date of Completion</td>
                                <td>
                                    <input type="date" name="Doc" id="Doc" class="form-control form-control-sm">
                                </td>
                            </tr>
                            <tr>
                                <td>Training Complete</td>
                                <td>
                                    <input type="checkbox" name="TrainingComplete" id="TrainingComplete" value="0">
                                </td>
                            </tr>
                        </table>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="UpdateMRF">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add_expense_modal" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-info bg-gradient">
                    <h6 class="modal-title text-white" id="candidatename2"></h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('add_expense') }}" method="POST" id="add_expense_form">
                    @csrf
                    <div class="modal-body">
                        <table class="table table-borderless">
                            <tr>
                                <td>Month</td>
                                <td>
                                    <input type="hidden" name="Add_TId" id="Add_TId">
                                    <input type="month" name="Month" id="Month" class="form-control">
                                </td>
                            </tr>

                            <tr>
                                <td>Stipend</td>
                                <td>
                                    <input type="text" name="Stipend" id="Stipend" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td>Expense</td>
                                <td>
                                    <input type="text" name="Expense" id="Expense" class="form-control">
                                </td>
                            </tr>

                        </table>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="UpdateMRF">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="expense_list_modal" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info bg-gradient">
                    <h6 class="modal-title text-white" id="candidatename1"></h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <table class="table" id="expensetable" style="width: 100%">
                    <thead class="text-center bg-primary bg-gradient text-light">
                        <th>S.No</th>
                        <th>Year</th>
                        <th>Month</th>
                        <th>Stipend</th>
                        <th>Expense</th>
                        <th>Total</th>
                    </thead>
                    <tbody id="expense_list" class="text-center">

                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="fw-bold" style="text-align: right">Grand Total</td>
                            <td id="total" style="text-align: center" class="fw-bold"></td>
                        </tr>
                    </tfoot>
                </table>

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

        function GetCampusRecords() {
            $('#CampusApplication').DataTable().draw(true);

        }

        $(document).on('click', '#reset', function() {
            location.reload();
        });

        $(document).ready(function() {
            CKEDITOR.replace('OtherBenefit');
            $('#CampusApplication').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                searching: false,
                lengthChange: false,
                info: true,
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel-o"></i>',
                        titleAttr: 'Excel',
                        title: $('.download_label').html(),
                        exportOptions: {
                            modifier: {
                                page: 'all'
                            }

                        }
                    },


                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fa fa-file-pdf-o"></i>',
                        titleAttr: 'PDF',
                        title: $('.download_label').html(),
                        exportOptions: {
                            modifier: {
                                page: 'all'
                            }

                        }
                    },

                    {
                        extend: 'print',
                        text: '<i class="fa fa-print"></i>',
                        titleAttr: 'Print',
                        title: $('.download_label').html(),
                        customize: function(win) {
                            $(win.document.body)
                                .css('font-size', '10pt');

                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        },
                        exportOptions: {
                            modifier: {
                                page: 'all'
                            }
                        }
                    },


                ],
                ajax: {
                    url: "{{ route('get_active_trainee') }}",
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
                        data: 'ReferenceNo',
                        name: 'ReferenceNo'
                    },
                    {
                        data: 'CandidateName',
                        name: 'CandidateName'
                    },
                    {
                        data: 'Department',
                        name: 'Department'
                    },


                    {
                        data: 'Doj',
                        name: 'Doj'
                    },
                    {
                        data: 'Doc',
                        name: 'Doc'
                    },
                    {
                        data: 'Stipend',
                        name: 'Stipend'
                    },
                    {
                        data: 'OtherBenefit',
                        name: 'OtherBenefit'
                    },
                    {
                        data: 'Action',
                        name: 'Action'
                    }

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

        function edit_detail(TId) {
            $('#TId').val(TId);
            getTraineeName(TId);
            $.ajax({
                url: "{{ route('getTraineeDetail') }}",
                type: 'POST',
                data: {
                    TId: TId,
                },
                dataType: 'json',

                success: function(data) {

                    $("#Doj").val(data.Doj);
                    $("#Doc").val(data.Doc);
                    $("#Stipend").val(data.Stipend);

                    CKEDITOR.instances['OtherBenefit'].setData(data.OtherBenefit);
                    if (data.TrainingComplete == 1) {
                        $("#TrainingComplete").prop('checked', true);
                    }
                }
            });
            $("#EditModal").modal('show');
        }

        $('#trainee_detail_form').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }

            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {
                    $(form).find('span.error-text').text('');
                },
                success: function(data) {
                    if (data.status == 400) {
                        $.each(data.error, function(prefix, val) {
                            $(form).find('span.' + prefix + '_error').text(val[0]);
                        });
                    } else {
                        window.location.reload();
                    }
                }
            });
        });

        $('#add_expense_form').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }

            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {
                    $(form).find('span.error-text').text('');
                },
                success: function(data) {
                    if (data.status == 400) {
                        $.each(data.error, function(prefix, val) {
                            $(form).find('span.' + prefix + '_error').text(val[0]);
                        });
                    } else {
                        window.location.reload();
                    }
                }
            });
        });

        function addexpense(TId) {
            $('#Add_TId').val(TId);
            getTraineeName(TId);
            $("#add_expense_modal").modal('show');
        }

        function getTraineeName(TId) {
            $.ajax({
                type: "POST",
                url: "{{ route('getTraineeName') }}?TId=" + TId,
                success: function(res) {
                    if (res) {
                        $("#candidatename").html('Edit Detail - (' + res + ' )');
                        $("#candidatename1").html('View Stipend / Expense - (' + res + ' )');
                        $("#candidatename2").html('Add Stipend / Expense - (' + res + ' )');
                    }
                }
            });
        }

        $("#TrainingComplete").click(function() {
            if ($(this).prop("checked") == true) {
                $("#TrainingComplete").val(1);
            } else {
                $("#TrainingComplete").val(0);
            }
        });

        function view_expense(TId) {
            var TId = TId;
            getTraineeName(TId);
            $('#expensetable').DataTable({
                processing: true,
                info: false,
                searching: false,
                ordering: false,
                lengthChange: false,
                destroy: true,
                paginate: false,
                dom: 'Bfrtip',
                buttons: [

                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel-o"></i>',
                        titleAttr: 'Excel',
                        title: $('.download_label').html(),
                        exportOptions: {
                            columns: ':visible'

                        }
                    },



                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fa fa-file-pdf-o"></i>',
                        titleAttr: 'PDF',
                        title: $('.download_label').html(),
                        exportOptions: {
                            columns: ':visible'

                        }
                    },

                    {
                        extend: 'print',
                        text: '<i class="fa fa-print"></i>',
                        titleAttr: 'Print',
                        title: $('.download_label').html(),
                        customize: function(win) {
                            $(win.document.body)
                                .css('font-size', '10pt');

                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        },
                        exportOptions: {
                            columns: ':visible'
                        }
                    },


                ],
                ajax: {
                    url: "{{ route('get_expense_list') }}",
                    type: "POST",
                    data: {
                        TId: TId
                    },
                    dataType: "JSON",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'Year',
                        name: 'Year'
                    },
                    {
                        data: 'Month',
                        name: 'Month'
                    },
                    {
                        data: 'Stipend',
                        name: 'Stipend'
                    },
                    {
                        data: 'Expense',
                        name: 'Expense'
                    },
                    {
                        data: 'Total',
                        name: 'Total'
                    }
                ],

                "footerCallback": function(row, data, start, end, display) {
                    var api = this.api(),
                        data;

                    // Remove the formatting to get integer data for summation
                    var intVal = function(i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                    };

                    // Total over all pages
                    total = api
                        .column(5)
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Total over this page
                    pageTotal = api
                        .column(5, {
                            page: 'current'
                        })
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Update footer
                    $(api.column(5).footer()).html(
                        pageTotal
                    );
                }

            });
            $('#expense_list_modal').modal('show');
        }
    </script>
@endsection
