@extends('layouts.master')
@section('title', 'CTC Calculator')
@section('PageContent')

<div class="page-content">
    <div class="row">
        <div class="col-xl-12 mx-auto">
            <h6 class="mb-0 text-uppercase">CTC Calculator</h6>
            <hr />

            <div class="row">
                <!-- Form Section - 4 Columns -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Input Parameters</h6>
                        </div>
                        <div class="card-body">
                            <form id="ctcCalculatorForm">
                                @csrf
                                <div class="mb-3">
                                    <label for="Company" class="form-label">Company <span class="text-danger">*</span></label>
                                    <select name="Company" id="Company" class="form-select" required>
                                      
                                        @foreach($company_list as $id => $code)
                                            <option value="{{ $id }}">{{ $code }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="MW" class="form-label">Minimum Wage Category <span class="text-danger">*</span></label>
                                    <select name="MW" id="MW" class="form-select" required>
                                        <option value="">Select Category</option>
                                        <option value="Highly Skilled">Highly Skilled</option>
                                        <option value="Skilled">Skilled</option>
                                        <option value="Semi Skilled">Semi Skilled</option>
                                        <option value="Unskilled">Unskilled</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="target_fixed_ctc" class="form-label">Target Fixed CTC <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="target_fixed_ctc" name="target_fixed_ctc" placeholder="Enter Target Fixed CTC" required>
                                </div>

                                <div class="mb-3">
                                    <label for="Communication_Allowance" class="form-label">Communication Allowance</label>
                                    <select name="Communication_Allowance" id="Communication_Allowance" class="form-select">
                                        <option value="N">No</option>
                                        <option value="Y">Yes</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="Vehicle_Allowance" class="form-label">Vehicle Allowance</label>
                                    <select name="Vehicle_Allowance" id="Vehicle_Allowance" class="form-select">
                                        <option value="N">No</option>
                                        <option value="Y">Yes</option>
                                    </select>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">Calculate CTC</button>
                                    <button type="reset" class="btn btn-secondary" id="resetBtn">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Results Section - 8 Columns -->
                <div class="col-md-8">
                    <div class="card" id="resultsCard">
                <div class="card-header">
                    <h5 class="mb-0">CTC Calculation Results</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-info mb-3" id="calculation_status_container">
                                <strong>Calculation Status:</strong>
                                <span id="calculation_status">Enter parameters and click "Calculate CTC" to see results</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="ctc-breakdown-table">
                                    <tbody>
                                        <!-- Monthly Components Section -->
                                        <tr class="table-secondary">
                                            <td colspan="2"><strong>Monthly Components</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Basic Salary</td>
                                            <td class="text-end" id="result_basic">-</td>
                                        </tr>
                                        <tr>
                                            <td>HRA</td>
                                            <td class="text-end" id="result_hra">-</td>
                                        </tr>
                                        <tr>
                                            <td>Bonus</td>
                                            <td class="text-end" id="result_bonus">-</td>
                                        </tr>
                                        <tr>
                                            <td>Special Allowance</td>
                                            <td class="text-end" id="result_special_alw">-</td>
                                        </tr>
                                        <tr style="background-color: #add8e6;">
                                            <td><strong>Gross Monthly Salary</strong></td>
                                            <td class="text-end" id="result_grsM_salary"><strong>-</strong></td>
                                        </tr>
                                        <tr style="background-color: #add8e6;">
                                            <td><strong>Gross Monthly Salary (Post Annual Components)</strong></td>
                                            <td class="text-end" id="result_grsM_salary_post"><strong>-</strong></td>
                                        </tr>

                                        <!-- Deductions Section -->
                                        <tr class="table-secondary">
                                            <td colspan="2"><strong>Deductions</strong></td>
                                        </tr>
                                        <tr>
                                            <td>PF</td>
                                            <td class="text-end" id="result_emplyPF">-</td>
                                        </tr>
                                        <tr>
                                            <td>ESIC</td>
                                            <td class="text-end" id="result_emplyESIC">-</td>
                                        </tr>
                                        <tr>
                                            <td>NPS</td>
                                            <td class="text-end" id="result_nps">0</td>
                                        </tr>
                                        <tr style="background-color: #90ee90;">
                                            <td><strong>Net Monthly</strong></td>
                                            <td class="text-end" id="result_netMonth"><strong>-</strong></td>
                                        </tr>

                                        <!-- Annual Components Section -->
                                        <tr class="table-secondary">
                                            <td colspan="2"><strong>Annual Components</strong></td>
                                        </tr>
                                        <tr>
                                            <td>LTA</td>
                                            <td class="text-end" id="result_lta">0</td>
                                        </tr>
                                        <tr>
                                            <td>Child Edu. Allow.</td>
                                            <td class="text-end" id="result_child_edu">0</td>
                                        </tr>
                                        <tr style="background-color: #add8e6;">
                                            <td><strong>Annual Gross</strong></td>
                                            <td class="text-end" id="result_anualgrs"><strong>-</strong></td>
                                        </tr>

                                        <!-- Statutory Section -->
                                        <tr class="table-secondary">
                                            <td colspan="2"><strong>Statutory</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Gratuity</td>
                                            <td class="text-end" id="result_gratuity">-</td>
                                        </tr>
                                        <tr>
                                            <td>Employer PF</td>
                                            <td class="text-end" id="result_emplyerPF">-</td>
                                        </tr>
                                        <tr>
                                            <td>Employer ESIC</td>
                                            <td class="text-end" id="result_emplyerESIC">-</td>
                                        </tr>
                                        <tr>
                                            <td>Medical Insurance</td>
                                            <td class="text-end" id="result_medical">-</td>
                                        </tr>

                                        <!-- CTC Summary Section -->
                                        <tr class="table-secondary">
                                            <td colspan="2"><strong>CTC Summary</strong></td>
                                        </tr>
                                        <tr style="background-color: #ffe4b5;">
                                            <td><strong>Fixed CTC</strong></td>
                                            <td class="text-end" id="result_fixed_ctc"><strong>-</strong></td>
                                        </tr>
                                        <tr style="background-color: #add8e6;">
                                            <td>Performance Pay</td>
                                            <td class="text-end" id="result_performance_pay">-</td>
                                        </tr>
                                        <tr style="background-color: #add8e6;">
                                            <td><strong>Total CTC</strong></td>
                                            <td class="text-end" id="result_total_ctc"><strong>-</strong></td>
                                        </tr>

                                        <!-- Additional Allowances Section -->
                                        <tr class="table-secondary">
                                            <td colspan="2"><strong>Additional Allowances</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Communication Allowance</td>
                                            <td class="text-end" id="result_communication_allowance">-</td>
                                        </tr>
                                        <tr>
                                            <td>Vehicle Allowance</td>
                                            <td class="text-end" id="result_vehicle_allowance">-</td>
                                        </tr>
                                        <tr style="background-color: #d3d3d3;">
                                            <td><strong>Total Gross CTC</strong></td>
                                            <td class="text-end" id="result_total_gross_ctc"><strong>-</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scriptsection')
<script>
$(document).ready(function() {
    $('#ctcCalculatorForm').on('submit', function(e) {
        e.preventDefault();

        // Show loading
        Swal.fire({
            title: 'Calculating...',
            html: 'Please wait while we calculate the CTC',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: "{{ route('calculate_ctc') }}",
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                Swal.close();

                if(response.status == 200) {
                    // Populate results
                    $('#result_basic').text(response.data.basic.toLocaleString('en-IN'));
                    $('#result_hra').text(response.data.hra.toLocaleString('en-IN'));
                    $('#result_bonus').text(response.data.bonus.toLocaleString('en-IN'));
                    $('#result_special_alw').text(response.data.special_alw.toLocaleString('en-IN'));
                    $('#result_grsM_salary').text(response.data.grsM_salary.toLocaleString('en-IN'));
                    $('#result_grsM_salary_post').text(response.data.grsM_salary.toLocaleString('en-IN'));

                    $('#result_emplyPF').text(response.data.emplyPF.toLocaleString('en-IN'));
                    $('#result_emplyESIC').text(response.data.emplyESIC.toLocaleString('en-IN'));
                    $('#result_netMonth').text(response.data.netMonth.toLocaleString('en-IN'));

                    $('#result_anualgrs').text(response.data.anualgrs.toLocaleString('en-IN'));
                    $('#result_gratuity').text(response.data.gratuity.toLocaleString('en-IN'));
                    $('#result_emplyerPF').text(response.data.emplyerPF.toLocaleString('en-IN'));
                    $('#result_emplyerESIC').text(response.data.emplyerESIC.toLocaleString('en-IN'));
                    $('#result_medical').text(response.data.medical.toLocaleString('en-IN'));

                    $('#result_fixed_ctc').text(response.data.fixed_ctc.toLocaleString('en-IN'));
                    $('#result_performance_pay').text(response.data.performance_pay.toLocaleString('en-IN'));
                    $('#result_total_ctc').text(response.data.total_ctc.toLocaleString('en-IN'));

                    $('#result_communication_allowance').text(response.data.communication_allowance_amount.toLocaleString('en-IN'));
                    $('#result_vehicle_allowance').text(response.data.vehicle_allowance_amount.toLocaleString('en-IN'));
                    $('#result_total_gross_ctc').text(response.data.total_gross_ctc.toLocaleString('en-IN'));

                    // Show status
                    var statusText = 'Converged in ' + response.iterations + ' iterations. ';
                    statusText += 'Difference from target: ₹' + Math.abs(response.difference).toLocaleString('en-IN');

                    if(Math.abs(response.difference) <= 10) {
                        statusText += ' ✓ (Within tolerance)';
                        $('#calculation_status').html('<span class="text-success">' + statusText + '</span>');
                    } else {
                        statusText += ' (Best match found)';
                        $('#calculation_status').html('<span class="text-warning">' + statusText + '</span>');
                    }

                    // Results are always visible in the 8-column layout
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to calculate CTC. Please try again.'
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred: ' + error
                });
            }
        });
    });

    $('#resetBtn').on('click', function() {
        // Reset all result fields to default
        $('#result_basic, #result_hra, #result_bonus, #result_special_alw, #result_grsM_salary, #result_grsM_salary_post, #result_emplyPF, #result_emplyESIC, #result_netMonth, #result_anualgrs, #result_gratuity, #result_emplyerPF, #result_emplyerESIC, #result_medical, #result_fixed_ctc, #result_performance_pay, #result_total_ctc, #result_communication_allowance, #result_vehicle_allowance, #result_total_gross_ctc').text('-');
        $('#calculation_status').html('Enter parameters and click "Calculate CTC" to see results');
    });
});
</script>
@endsection
