@php
use function App\Helpers\getDesignationCode;
use function App\Helpers\getGradeValue;
use function App\Helpers\getHQ;
$RepEmpId = request()->query('ei');
$res = DB::table('master_employee')
    ->where('EmployeeID', $RepEmpId)
    ->get();
@endphp
@extends('layouts.master')
@section('title', 'Replacement Manpower Requisition Form')
@section('PageContent')
<style>
    .table>:not(caption)>*>* {
        padding: 2px 1px;
    }

</style>
<div class="page-content">

    <div class="col-xl-6 mx-auto">
        <div class="card border-top border-0 border-4 border-primary">
            <div class="card-body p-3">
                <div class="card-title d-flex align-items-center">
                    <div><i class="bx bxs-user me-1 font-22 text-primary"></i>
                    </div>
                    <h5 class="mb-0 text-primary">Replacement Manpower Requisition Form</h5>

                </div>
                <hr>
                <form action="">
                    <table class="table">
                        <tr>
                            <th>Replacement For:</th>
                            <td>
                                <input type="text" class="form-control form-control-sm" id="Replacement"
                                    name="Replacement" value="{{ $res[0]->Fname . ' ' . $res[0]->Lname }}" readonly>
                                <input type="hidden" name="ReplacementFor" id="ReplacementFor"
                                    value="{{ request()->query('ei') }}">
                            </td>
                        </tr>
                        <tr>
                            <th>Designation:</th>
                            <td>
                                <input type="text" class="form-control form-control-sm" id="Designation"
                                    name="Designation" value="{{ getDesignationCode($res[0]->DesigId) }}" readonly>
                            </td>
                        </tr>
                        <tr>
                            <th>Grade:</th>
                            <td>
                                <input type="text" class="form-control form-control-sm" id="Grade"
                                    value="{{ getGradeValue($res[0]->GradeId) }}" readonly>
                            </td>
                        </tr>
                        <tr>
                            <th>Existing Location:</th>
                            <td>
                                <input type="text" class="form-control form-control-sm" id="ExistingLocation"
                                    value="{{ getHQ($res[0]->Location) }}" readonly>
                            </td>
                        </tr>
                        <tr>
                            <th>Existing CTC:</th>
                            <td>
                                <input type="text" class="form-control form-control-sm" id="ExCTC"
                                    value="{{ $res[0]->CTC }}" readonly>
                            </td>
                        </tr>
                        <tr>
                            <th>Desired Location:</th>
                            <td>
                                <div style="width: 50%;display: inline-block;float: left">
                                    <select id="State" name="State" class="form-control form-select form-select-sm">
                                        <option disabled="" selected="">Select State</option>

                                    </select>
                                </div>
                                <div style="width: 50%;display: inline-block;float: left" class="ml-3">
                                    <select id="District" name="District"
                                        class="form-control form-select form-select-sm">
                                        <option disabled="" selected="">Select City</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Desired CTC (in Lacs):</th>
                            <td>
                                <div style="width: 50%;display: inline-block;float: left">
                                    <input type="text" name="MinCTC" id="MinCTC" class="form-control form-control-sm"
                                        placeholder="Min">
                                </div>
                                <div style="width: 50%;display: inline-block;float: left" class="ml-3">
                                    <input type="text" name="MaxCTC" id="MaxCTC" class="form-control form-control-sm"
                                        placeholder="Max">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Desired Education:</th>

                            <td>
                                
                                    <table class="table borderless" style="margin-bottom: 0px;">
                                        <tbody id="MulEducation">
                                        </tbody>
                                    </table>
                                 <button id="addEducation" type="button" class="btn btn-sm btn-warning mb-2 mt-2">Add Education</button>
                            
                            </td>
                        </tr>
                        <tr>
                            <th>Action:</th>
                            <td>
                                <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                <button type="reset" class="btn btn-danger btn-sm">Cancle</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>


    </div>
</div>


@endsection

@section('scriptsection')
<script>
    var EducationList;
    //-------------------------------Start Multiple Education===========================//

    var EduCount = 1;
    mulEducation(EduCount);

    function mulEducation(num) {
        x = '<tr>';
        x += '<td >' +
            ' <select  name="Education[]" id="Education' +
            num +
            '" class="form-control form-select form-select-sm" onchange="getSpecialization(this.value,' + num + ')">' +
            '  <option value="" selected disabled>Select Education</option>' + EducationList +
            '</select>' +
            ' <span class="text-danger error-text Education' + num + '_error"></span>' +
            '</td>';
        x += '<td>' +
            '<div class="spinner-border text-primary d-none" role="status" id="SpeLoader' + num +
            '"> <span class="visually-hidden">Loading...</span></div>' +
            '       <select  id="Specialization' + num +
            '" name="Specialization[]" class="form-control form-select form-select-sm">' +
            '    <option value="" selected disabled>Select Specialization</option>' +
            '</select>' +
            '<span class="text-danger error-text Specialization' + num + '_error"></span>' +
            '</td>';


        if (num > 1) {
            x +=
                '<td><button type="button" name="remove" id="" class="btn btn-danger btn-xs  removeEducation">Remove</td></tr>';
            $('#MulEducation').append(x);
        } else {
            x +=
                '';
            $('#MulEducation').html(x);
        }
    }

    $(document).on('click', '#addEducation', function() {
        EduCount++;
        mulEducation(EduCount);
    });

    $(document).on('click', '.removeEducation', function() {
        EduCount--;
        $(this).closest("tr").remove();
    });
</script>
@endsection
