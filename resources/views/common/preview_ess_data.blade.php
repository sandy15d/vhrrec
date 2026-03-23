@extends('layouts.master')
@section('title', 'Preview Data Transfer to ESS')

@section('PageContent')
<style>
    body {
        background: #f5f7fa;
    }
    .preview-wrapper {
        background: #f8f9fa;
        padding: 20px;
        max-width: 100%;
        margin: 0 auto;
    }
    .preview-header {
        background: #fff;
        padding: 15px 25px;
        border-radius: 6px;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        border-left: 4px solid #2c5aa0;
    }
    .preview-header h4 {
        margin: 0;
        font-size: 16px;
        color: #2c3e50;
        font-weight: 600;
    }
    .preview-header small {
        color: #7f8c8d;
        font-size: 13px;
    }
    .action-buttons {
        display: flex;
        gap: 10px;
    }
    .masonry-grid {
        column-count: 2;
        column-gap: 18px;
    }
    .content-card {
        background: #fff;
        border-radius: 6px;
        padding: 20px;
        margin-bottom: 15px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        break-inside: avoid;
        display: inline-block;
        width: 100%;
    }
    .content-card.full-width {
        column-span: all;
        break-inside: auto;
    }
    @media (max-width: 1200px) {
        .masonry-grid {
            column-count: 1;
        }
    }
    .section-title {
        padding: 0 0 8px 0;
        margin: 0 0 15px 0;
        font-weight: 600;
        font-size: 13px;
        border-bottom: 2px solid #e9ecef;
        color: #2c5aa0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .data-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px 20px;
        margin-bottom: 5px;
    }
    .data-item {
        display: flex;
        flex-direction: column;
    }
    .data-label {
        font-weight: 500;
        font-size: 10px;
        color: #95a5a6;
        text-transform: uppercase;
        margin-bottom: 4px;
        letter-spacing: 0.3px;
    }
    .data-value {
        color: #2c3e50;
        font-size: 13px;
        font-weight: 400;
    }
    .list-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 5px;
        font-size: 12px;
    }
    .list-table th {
        background: #f8f9fa;
        padding: 8px 10px;
        text-align: left;
        border: 1px solid #e9ecef;
        font-weight: 600;
        font-size: 11px;
        color: #5a6c7d;
        text-transform: uppercase;
    }
    .list-table td {
        padding: 8px 10px;
        border: 1px solid #e9ecef;
        color: #2c3e50;
    }
    .list-table tbody tr:hover {
        background: #f8f9fa;
    }
    .btn-submit {
        background: #27ae60;
        color: #fff;
        padding: 9px 24px;
        border: none;
        cursor: pointer;
        font-size: 13px;
        border-radius: 5px;
        font-weight: 500;
        transition: all 0.2s;
    }
    .btn-submit:hover {
        background: #229954;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(39, 174, 96, 0.3);
    }
    .btn-back {
        background: #fff;
        color: #5a6c7d;
        border: 1px solid #dce1e6;
        padding: 9px 24px;
        cursor: pointer;
        font-size: 13px;
        text-decoration: none;
        display: inline-block;
        border-radius: 5px;
        font-weight: 500;
        transition: all 0.2s;
    }
    .btn-back:hover {
        background: #f8f9fa;
        color: #2c3e50;
        border-color: #bdc3c7;
    }
    .candidate-photo {
        width: 110px;
        height: 130px;
        object-fit: cover;
        border: 3px solid #e9ecef;
        border-radius: 6px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    .photo-section {
        text-align: center;
    }
    .address-box {
        background: #f8f9fa;
        padding: 12px 15px;
        border-radius: 5px;
        border-left: 3px solid #3498db;
    }
    .address-title {
        font-weight: 600;
        font-size: 11px;
        color: #3498db;
        text-transform: uppercase;
        margin-bottom: 6px;
        letter-spacing: 0.3px;
    }
    .address-content {
        font-size: 12px;
        color: #2c3e50;
        line-height: 1.6;
    }
    @media print {
        .action-buttons, .btn-submit, .btn-back {
            display: none;
        }
    }
</style>

<div class="preview-wrapper">
    <!-- Action Buttons at Top -->
    <input type="hidden" id="JAId" value="{{ $JAId }}">
    <div class="preview-header">
        <div>
            <h4>Preview Employee Data - Transfer to HRIMS</h4>
            <small>Employee Code: {{ $EmpCode ?? 'Pending' }}</small>
        </div>
        <div class="action-buttons">
            <a href="{{ url()->previous() }}" class="btn-back">Cancel</a>
            <button type="button" class="btn-submit" id="confirmTransfer">
                ✓ Confirm & Transfer to Peepal
            </button>
        </div>
    </div>

    <!-- Masonry Grid Container -->
    <div class="masonry-grid">
        <!-- Personal Information -->
        <div class="content-card">
            <div class="section-title">Personal Information</div>
            <div class="row">
                <div class="col-md-9">
                    <div class="data-grid" style="grid-template-columns: repeat(2, 1fr);">
                        <div class="data-item">
                            <div class="data-label">Full Name</div>
                            <div class="data-value">{{ $jobcandidate->Title ?? '' }} {{ $jobcandidate->FName ?? '' }} {{ $jobcandidate->MName ?? '' }} {{ $jobcandidate->LName ?? '' }}</div>
                        </div>
                        <div class="data-item">
                            <div class="data-label">Date of Birth</div>
                            <div class="data-value">
                                {{ !empty($jobcandidate->DOB) ? \Carbon\Carbon::parse($jobcandidate->DOB)->format('d-m-Y') : 'N/A' }}
                            </div>
                        </div>
                        <div class="data-item">
                            <div class="data-label">Gender</div>
                            <div class="data-value">
                                @if($jobcandidate->Gender == 'M') Male
                                @elseif($jobcandidate->Gender == 'F') Female
                                @elseif($jobcandidate->Gender == 'O') Other
                                @else N/A
                                @endif
                            </div>
                        </div>
                        <div class="data-item">
                            <div class="data-label">Blood Group</div>
                            <div class="data-value">{{ $jobcandidate->bloodgroup ?? 'N/A' }}</div>
                        </div>
                        <div class="data-item">
                            <div class="data-label">Nationality</div>
                            <div class="data-value">{{ $jobcandidate->nationality_name ?? 'Indian' }}</div>
                        </div>
                        <div class="data-item">
                            <div class="data-label">Religion</div>
                            <div class="data-value">{{ $jobcandidate->Religion ?? 'N/A' }}</div>
                        </div>
                        <div class="data-item">
                            <div class="data-label">Caste</div>
                            <div class="data-value">{{ $jobcandidate->Caste ?? 'N/A' }}</div>
                        </div>
                        <div class="data-item">
                            <div class="data-label">Marital Status</div>
                            <div class="data-value">{{ $jobcandidate->MaritalStatus ?? 'N/A' }}</div>
                        </div>
                        @if($jobcandidate->MaritalStatus == 'Married')
                        <div class="data-item">
                            <div class="data-label">Spouse Name</div>
                            <div class="data-value">{{ $jobcandidate->SpouseName ?? 'N/A' }}</div>
                        </div>
                        <div class="data-item">
                            <div class="data-label">Marriage Date</div>
                            <div class="data-value">
                                {{ !empty($jobcandidate->MarriageDate) ? \Carbon\Carbon::parse($jobcandidate->MarriageDate)->format('d-m-Y') : 'N/A' }}
                            </div>
                        </div>
                        @endif
                        <div class="data-item">
                            <div class="data-label">Aadhar Number</div>
                            <div class="data-value">{{ $jobcandidate->Aadhaar ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="photo-section">
                        @if(!empty($jobcandidate->CandidateImage))
                            <img src="{{ url('file-view/Picture/' . $jobcandidate->CandidateImage) }}"
                                 alt="Candidate Photo" class="candidate-photo">
                        @else
                            <img src="{{ URL::to('/') }}/assets/images/user.png"
                                 alt="No Photo" class="candidate-photo">
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="content-card">
            <div class="section-title">Contact Information</div>
            <div class="data-grid">
                <div class="data-item">
                    <div class="data-label">Email (Primary)</div>
                    <div class="data-value">{{ $jobcandidate->Email ?? 'N/A' }}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">Phone (Primary)</div>
                    <div class="data-value">{{ $jobcandidate->Phone ?? 'N/A' }}</div>
                </div>
                @if(!empty($jobcandidate->Email2))
                <div class="data-item">
                    <div class="data-label">Email (Secondary)</div>
                    <div class="data-value">{{ $jobcandidate->Email2 }}</div>
                </div>
                @endif
                @if(!empty($jobcandidate->Phone2))
                <div class="data-item">
                    <div class="data-label">Phone (Secondary)</div>
                    <div class="data-value">{{ $jobcandidate->Phone2 }}</div>
                </div>
                @endif
            </div>
        </div>

        <!-- Employment Details -->
        <div class="content-card">
            <div class="section-title">Employment Details</div>
            <div class="data-grid">
                <div class="data-item">
                    <div class="data-label">Department</div>
                    <div class="data-value">{{ $jobcandidate->department_name ?? 'N/A' }}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">Sub Department</div>
                    <div class="data-value">{{ $jobcandidate->sub_department_name ?? 'N/A' }}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">Vertical</div>
                    <div class="data-value">{{ $jobcandidate->vertical_name ?? 'N/A' }}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">Grade</div>
                    <div class="data-value">{{ $jobcandidate->grade_name ?? 'N/A' }}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">Designation</div>
                    <div class="data-value">{{ $jobcandidate->designation_name ?? 'N/A' }}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">Join Date</div>
                    <div class="data-value">
                        {{ !empty($jobcandidate->JoinOnDt) ? \Carbon\Carbon::parse($jobcandidate->JoinOnDt)->format('d-m-Y') : 'N/A' }}
                    </div>
                </div>
            </div>
        </div>

       

        <!-- PF & Bank Information -->
        @if($pf_esic_data)
        <div class="content-card">
            <div class="section-title">PF, ESIC & Bank Details</div>
            <div class="data-grid">
                <div class="data-item">
                    <div class="data-label">UAN</div>
                    <div class="data-value">{{ $pf_esic_data->UAN ?? 'N/A' }}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">PF Account No</div>
                    <div class="data-value">{{ $pf_esic_data->PFNumber ?? 'N/A' }}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">ESIC Number</div>
                    <div class="data-value">{{ $pf_esic_data->ESICNumber ?? 'N/A' }}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">PAN</div>
                    <div class="data-value">{{ $pf_esic_data->PAN ?? 'N/A' }}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">Bank Name</div>
                    <div class="data-value">{{ $pf_esic_data->BankName ?? 'N/A' }}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">Account Number</div>
                    <div class="data-value">{{ $pf_esic_data->AccountNumber ?? 'N/A' }}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">IFSC Code</div>
                    <div class="data-value">{{ $pf_esic_data->IFSCCode ?? 'N/A' }}</div>
                </div>
            </div>
        </div>
        @endif

        <!-- Address Information -->
        @if($address_data)
        <div class="content-card">
            <div class="section-title">Address Details</div>
            <div class="mb-2">
                <div class="address-box mb-2">
                    <div class="address-title">Present Address</div>
                    <div class="address-content">
                        {{ $address_data->pre_address ?? 'N/A' }}<br>
                        {{ $address_data->pre_city ?? '' }}{{ $address_data->pre_dist ? ', ' . $address_data->pre_dist : '' }}{{ $address_data->pre_state ? ', ' . $address_data->pre_state : '' }}{{ $address_data->pre_pin ? ' - ' . $address_data->pre_pin : '' }}
                    </div>
                </div>
                <div class="address-box" style="border-left-color: #9b59b6;">
                    <div class="address-title" style="color: #9b59b6;">Permanent Address</div>
                    <div class="address-content">
                        {{ $address_data->perm_address ?? 'N/A' }}<br>
                        {{ $address_data->perm_city ?? '' }}{{ $address_data->perm_dist ? ', ' . $address_data->perm_dist : '' }}{{ $address_data->perm_state ? ', ' . $address_data->perm_state : '' }}{{ $address_data->perm_pin ? ' - ' . $address_data->perm_pin : '' }}
                    </div>
                </div>
            </div>
            @if($address_data->cont_one_name || $address_data->cont_two_name)
            <div class="data-grid">
                @if($address_data->cont_one_name)
                <div class="data-item">
                    <div class="data-label">Emergency Contact 1</div>
                    <div class="data-value">{{ $address_data->cont_one_name }} ({{ $address_data->cont_one_relation ?? '' }}) - {{ $address_data->cont_one_number ?? '' }}</div>
                </div>
                @endif
                @if($address_data->cont_two_name)
                <div class="data-item">
                    <div class="data-label">Emergency Contact 2</div>
                    <div class="data-value">{{ $address_data->cont_two_name }} ({{ $address_data->cont_two_relation ?? '' }}) - {{ $address_data->cont_two_number ?? '' }}</div>
                </div>
                @endif
            </div>
            @endif
        </div>
        @endif

        <!-- Language Proficiency -->
        @if($lang_data && $lang_data->count() > 0)
        <div class="content-card">
            <div class="section-title">Language Proficiency</div>
            <table class="list-table">
                <thead>
                    <tr>
                        <th>Language</th>
                        <th>Read</th>
                        <th>Write</th>
                        <th>Speak</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lang_data as $lang)
                    <tr>
                        <td>{{ $lang->language ?? '' }}</td>
                        <td>{{ $lang->read == 1 ? 'Yes' : 'No' }}</td>
                        <td>{{ $lang->write == 1 ? 'Yes' : 'No' }}</td>
                        <td>{{ $lang->speak == 1 ? 'Yes' : 'No' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif



         <!-- CTC Information (Annexure A Format) -->
         @if($ctc_data)
         <div class="content-card">
             <div class="section-title">CTC Details - Compensation Structure</div>
             <table class="list-table">
                 <thead>
                     <tr>
                         <th colspan="2" style="background: #e7f1ff; text-align: center;">(A) Monthly Components</th>
                     </tr>
                     <tr>
                         <th style="width: 60%;">Emolument Head</th>
                         <th style="width: 40%; text-align: center;">Amount (₹)</th>
                     </tr>
                 </thead>
                 <tbody>
                     <tr>
                         <td>Basic</td>
                         <td style="text-align: center;">{{ $ctc_data->basic ?? 0 }}</td>
                     </tr>
                     @if($ctc_data->hra > 0)
                     <tr>
                         <td>HRA</td>
                         <td style="text-align: center;">{{ $ctc_data->hra ?? 0 }}</td>
                     </tr>
                     @endif
                     @if($ctc_data->bonus > 0)
                     <tr>
                         <td>Bonus</td>
                         <td style="text-align: center;">{{ $ctc_data->bonus ?? 0 }}</td>
                     </tr>
                     @endif
                     @if($ctc_data->special_alw > 0)
                     <tr>
                         <td>Special Allowance</td>
                         <td style="text-align: center;">{{ $ctc_data->special_alw ?? 0 }}</td>
                     </tr>
                     @endif
                     <tr style="background: #f8f9fa; font-weight: 600;">
                         <td><strong>Gross Monthly Salary</strong></td>
                         <td style="text-align: center;"><strong>{{ $ctc_data->grsM_salary ?? 0 }}</strong></td>
                     </tr>
                     <tr>
                         <td>Employee's PF Contribution</td>
                         <td style="text-align: center;">{{ $ctc_data->emplyPF ?? 0 }}</td>
                     </tr>
                     @if($ctc_data->grsM_salary <= 21000)
                     <tr>
                         <td>Employee's ESIC Contribution</td>
                         <td style="text-align: center;">{{ $ctc_data->emplyESIC ?? 0 }}</td>
                     </tr>
                     @endif
                     <tr style="background: #f8f9fa; font-weight: 600;">
                         <td><strong>Net Monthly Salary</strong></td>
                         <td style="text-align: center;"><strong>{{ $ctc_data->netMonth ?? 0 }}</strong></td>
                     </tr>
                 </tbody>
                 <thead>
                     <tr>
                         <th colspan="2" style="background: #e7f1ff; text-align: center;">(B) Annual Components</th>
                     </tr>
                 </thead>
                 <tbody>
                     <tr>
                         <td>Leave Travel Allowance (LTA)</td>
                         <td style="text-align: center;">{{ $ctc_data->lta ?? 0 }}</td>
                     </tr>
                     <tr>
                         <td>Child Education Allowance</td>
                         <td style="text-align: center;">{{ $ctc_data->childedu ?? 0 }}</td>
                     </tr>
                     <tr style="background: #f8f9fa; font-weight: 600;">
                         <td><strong>Annual Gross Salary</strong></td>
                         <td style="text-align: center;"><strong>{{ $ctc_data->anualgrs ?? 0 }}</strong></td>
                     </tr>
                 </tbody>
                 <thead>
                     <tr>
                         <th colspan="2" style="background: #e7f1ff; text-align: center;">(C) Other Annual Components (Statutory)</th>
                     </tr>
                 </thead>
                 <tbody>
                     <tr>
                         <td>Estimated Gratuity</td>
                         <td style="text-align: center;">{{ $ctc_data->gratuity ?? 0 }}</td>
                     </tr>
                     <tr>
                         <td>Employer's PF Contribution</td>
                         <td style="text-align: center;">{{ $ctc_data->emplyerPF ?? 0 }}</td>
                     </tr>
                     @if($ctc_data->grsM_salary <= 21000)
                     <tr>
                         <td>Employer's ESIC Contribution</td>
                         <td style="text-align: center;">{{ $ctc_data->emplyerESIC ?? 0 }}</td>
                     </tr>
                     @endif
                     @if(($ctc_data->medical ?? 0) > 0)
                     <tr>
                         <td>Insurance Policy Premium</td>
                         <td style="text-align: center;">{{ $ctc_data->medical ?? 0 }}</td>
                     </tr>
                     @endif
                     <tr style="background: #f8f9fa; font-weight: 600;">
                         <td><strong>Fixed CTC</strong></td>
                         <td style="text-align: center;"><strong>{{ $ctc_data->fixed_ctc ?? 0 }}</strong></td>
                     </tr>
                     @if(($ctc_data->performance_pay ?? 0) > 0)
                     <tr>
                         <td>Performance Pay</td>
                         <td style="text-align: center;">{{ $ctc_data->performance_pay ?? 0 }}</td>
                     </tr>
                     @endif
                     <tr style="background: #e7f3ff; font-weight: 700;">
                         <td><strong style="color: #2c5aa0;">TOTAL CTC (ANNUAL)</strong></td>
                         <td style="text-align: center;"><strong style="color: #27ae60; font-size: 14px;">{{ $ctc_data->total_ctc ?? 0 }}</strong></td>
                     </tr>
                     @if(($ctc_data->car_allowance_amount ?? 0) > 0 || ($ctc_data->communication_allowance_amount ?? 0) > 0 || ($ctc_data->vehicle_allowance_amount ?? 0) > 0)
                     <tr>
                         <th colspan="2" style="background: #e7f1ff; text-align: center;">(D) Perks</th>
                     </tr>
                     @if(($ctc_data->car_allowance_amount ?? 0) > 0)
                     <tr>
                         <td>Car Allowance</td>
                         <td style="text-align: center;">{{ $ctc_data->car_allowance_amount ?? 0 }}</td>
                     </tr>
                     @endif
                     @if(($ctc_data->communication_allowance_amount ?? 0) > 0)
                     <tr>
                         <td>Communication Allowance</td>
                         <td style="text-align: center;">{{ $ctc_data->communication_allowance_amount ?? 0 }}</td>
                     </tr>
                     @endif
                     @if(($ctc_data->vehicle_allowance_amount ?? 0) > 0)
                     <tr>
                         <td>Vehicle Allowance</td>
                         <td style="text-align: center;">{{ $ctc_data->vehicle_allowance_amount ?? 0 }}</td>
                     </tr>
                     @endif
                     <tr style="background: #e7f3ff; font-weight: 700;">
                         <td><strong style="color: #2c5aa0;">TOTAL GROSS CTC</strong></td>
                         <td style="text-align: center;"><strong style="color: #27ae60; font-size: 14px;">{{ $ctc_data->total_gross_ctc ?? 0 }}</strong></td>
                     </tr>
                     @endif
                 </tbody>
             </table>
         </div>
         @endif
 
         <!-- Entitlement Details (Annexure B Format) -->
         @if($elg_data)
         <div class="content-card">
             <div class="section-title">Entitlement Details</div>
 
             <!-- Lodging Entitlements -->
             <div style="margin-bottom: 15px;">
                 <div style="font-weight: 600; font-size: 12px; color: #2c5aa0; margin-bottom: 8px;">Lodging Entitlements (Actual with upper limits per day)</div>
                 <table class="list-table">
                     <thead>
                         <tr>
                             <th>City Category</th>
                             <th style="text-align: center;">A</th>
                             <th style="text-align: center;">B</th>
                             <th style="text-align: center;">C</th>
                         </tr>
                     </thead>
                     <tbody>
                         <tr>
                             <td><strong>Amount (₹)</strong></td>
                             <td style="text-align: center;">{{ $elg_data->LoadCityA ?? 'N/A' }}</td>
                             <td style="text-align: center;">{{ $elg_data->LoadCityB ?? 'N/A' }}</td>
                             <td style="text-align: center;">{{ $elg_data->LoadCityC ?? 'N/A' }}</td>
                         </tr>
                     </tbody>
                 </table>
             </div>
 
             <!-- Daily Allowances -->
             @if(!empty($elg_data->DAHq) || !empty($elg_data->DAOut))
             <div style="margin-bottom: 15px;">
                 <div style="font-weight: 600; font-size: 12px; color: #2c5aa0; margin-bottom: 8px;">Daily Allowances</div>
                 <table class="list-table">
                     <tbody>
                         @if(!empty($elg_data->DAHq))
                         <tr>
                             <td style="width: 60%;">DA@HQ {{ !empty($elg_data->DAHq_Rmk) ? '(' . $elg_data->DAHq_Rmk . ')' : '' }}</td>
                             <td style="text-align: center;">₹{{ $elg_data->DAHq }}</td>
                         </tr>
                         @endif
                         @if(!empty($elg_data->DAOut))
                         <tr>
                             <td style="width: 60%;">DA Outside HQ {{ !empty($elg_data->DAOutRmk) ? '(' . $elg_data->DAOutRmk . ')' : '' }}</td>
                             <td style="text-align: center;">₹{{ $elg_data->DAOut }}</td>
                         </tr>
                         @endif
                     </tbody>
                 </table>
             </div>
             @endif
 
             <!-- Travel Eligibility -->
             @if((!empty($offer_basic->two_wheel_rc) && $offer_basic->two_wheel_rc == 'Y' && !empty($elg_data->TwoWheel)) ||
                 (!empty($offer_basic->two_wheel_rc) && $offer_basic->two_wheel_rc == 'N' && !empty($offer_basic->two_wheel_flat_rate)) ||
                 (!empty($elg_data->FourWheel)) ||
                 ($elg_data->Train == 'Y' || $elg_data->Flight == 'Y'))
             <div style="margin-bottom: 15px;">
                 <div style="font-weight: 600; font-size: 12px; color: #2c5aa0; margin-bottom: 8px;">Travel Eligibility (For Official Purpose Only)</div>
                 <table class="list-table">
                     <tbody>
                         @if(!empty($offer_basic->two_wheel_rc) && $offer_basic->two_wheel_rc == 'Y' && !empty($elg_data->TwoWheel))
                         <tr>
                             <td style="width: 60%;">2 Wheeler {{ !empty($elg_data->TwoWheel_Rmk) ? '(' . $elg_data->TwoWheel_Rmk . ')' : '' }}</td>
                             <td style="text-align: center;">₹{{ $elg_data->TwoWheel }} /Km</td>
                         </tr>
                         @elseif(!empty($offer_basic->two_wheel_rc) && $offer_basic->two_wheel_rc == 'N' && !empty($offer_basic->two_wheel_flat_rate))
                         <tr>
                             <td style="width: 60%;">2 Wheeler (Flat Rate)</td>
                             <td style="text-align: center;">₹{{ $offer_basic->two_wheel_flat_rate }} /Km</td>
                         </tr>
                         @endif
 
                         @if(!empty($elg_data->FourWheel))
                         <tr>
                             <td style="width: 60%;">4 Wheeler {{ !empty($elg_data->FourWheel_Rmk) ? '(' . $elg_data->FourWheel_Rmk . ')' : '' }}</td>
                             <td style="text-align: center;">₹{{ $elg_data->FourWheel }} /Km</td>
                         </tr>
                         @endif
 
                         @if($elg_data->Train == 'Y' || $elg_data->Flight == 'Y')
                         <tr>
                             <td colspan="2" style="padding: 10px;">
                                 <strong>Mode/Class of Travel Outside HQ:</strong><br>
                                 @if($elg_data->Flight == 'Y')
                                     <span style="display: block; margin-top: 5px;">• <strong>Flight:</strong> {{ $elg_data->Flight_Class ?? '' }} {{ $elg_data->Flight_Remark ?? '' }}</span>
                                 @endif
                                 @if($elg_data->Train == 'Y')
                                     <span style="display: block; margin-top: 5px;">• <strong>Train/Bus:</strong> {{ $elg_data->Train_Class ?? '' }} {{ $elg_data->Train_Remark ?? '' }}</span>
                                 @endif
                             </td>
                         </tr>
                         @endif
                     </tbody>
                 </table>
             </div>
             @endif
 
           {{--   <!-- Mobile Eligibility -->
             @if(($elg_data->Mobile_Allow == 'Y' && !empty($elg_data->Mobile)) || !empty($elg_data->MExpense))
             <div style="margin-bottom: 15px;">
                 <div style="font-weight: 600; font-size: 12px; color: #2c5aa0; margin-bottom: 8px;">Mobile Eligibility</div>
                 <table class="list-table">
                     <tbody>
                         @if(!empty($elg_data->MExpense))
                         <tr>
                             <td style="width: 60%;">Mobile Expenses Reimbursement</td>
                             <td style="text-align: center;">₹{{ $elg_data->MExpense }}/{{ $elg_data->MTerm ?? 'Month' }}</td>
                         </tr>
                         @endif
                         @if($elg_data->Mobile_Allow == 'Y' && !empty($elg_data->Mobile))
                         <tr>
                             <td style="width: 60%;">Mobile Handset Eligibility</td>
                             <td style="text-align: center;">
                                 ₹{{ $elg_data->Mobile }}
                                 @if($elg_data->GPRS == '1')
                                     (Once in 2 yrs)
                                 @else
                                     (Once in 3 yrs)
                                 @endif
                                 <br><small>Subject to submission of bills</small>
                             </td>
                         </tr>
                         @endif
                     </tbody>
                 </table>
             </div>
             @endif --}}
 
             <!-- Laptop Eligibility -->
             @if(!empty($elg_data->Laptop) && $elg_data->Laptop > 0)
             <div style="margin-bottom: 15px;">
                 <div style="font-weight: 600; font-size: 12px; color: #2c5aa0; margin-bottom: 8px;">Laptop Eligibility</div>
                 <table class="list-table">
                     <tbody>
                         <tr>
                             <td style="width: 60%;">Laptop Eligibility</td>
                             <td style="text-align: center;">
                                 ₹{{ $elg_data->Laptop }} (Once in 3 yrs)<br>
                                 <small>Subject to submission of bills</small>
                             </td>
                         </tr>
                     </tbody>
                 </table>
             </div>
             @endif
 
             <!-- Insurance -->
             <div style="margin-bottom: 15px;">
                 <div style="font-weight: 600; font-size: 12px; color: #2c5aa0; margin-bottom: 8px;">Insurance Benefits</div>
                 <table class="list-table">
                     <tbody>
                         @if($ctc_data && $ctc_data->grsM_salary > 21000 && !empty($elg_data->HealthIns))
                         <tr>
                             <td style="width: 60%;">Health Insurance (Sum Insured)</td>
                             <td style="text-align: center;">₹{{ $elg_data->HealthIns }}</td>
                         </tr>
                         @endif
                         @if(!empty($elg_data->Term_Insurance))
                         <tr>
                             <td style="width: 60%;">Group Term Life Insurance (Sum Insured)</td>
                             <td style="text-align: center;">₹{{ $elg_data->Term_Insurance }}</td>
                         </tr>
                         @endif
                         @if(!empty($elg_data->Helth_CheckUp))
                         <tr>
                             <td style="width: 60%;">Executive Health Check-up <small>(Min. Age > 40 Yrs, once in 2 yrs)</small></td>
                             <td style="text-align: center;">₹{{ $elg_data->Helth_CheckUp }}</td>
                         </tr>
                         @endif
                     </tbody>
                 </table>
             </div>
 
             <!-- Notes -->
             <div style="font-size: 11px; color: #5a6c7d; background: #f8f9fa; padding: 12px; border-radius: 5px; border-left: 3px solid #f39c12;">
                 <strong style="display: block; margin-bottom: 6px; color: #2c3e50;">Important Notes:</strong>
                 <ul style="margin: 0; padding-left: 20px;">
                     <li>The 2 Wheeler & 4 Wheeler travel eligibility is subject to submission of vehicle details belonging in the name of employee only.</li>
                     <li>The vehicle must be under the name of employee only in all cases.</li>
                 </ul>
             </div>
         </div>
         @endif
    </div>

    <!-- Full Width Tables -->
    @if($education_data && $education_data->count() > 0)
    <div class="content-card full-width">
        <div class="section-title">Education Details</div>
        <table class="list-table">
            <thead>
                <tr>
                    <th>Qualification</th>
                    <th>Course</th>
                    <th>Specialization</th>
                    <th>Institute</th>
                    <th>Year</th>
                    <th>CGPA</th>
                </tr>
            </thead>
            <tbody>
                @foreach($education_data as $edu)
                <tr>
                    <td>{{ $edu->Qualification ?? 'N/A' }}</td>
                    <td>{{ $edu->course_name ?? 'N/A' }}</td>
                    <td>{{ $edu->specialization_name ?? 'N/A' }}</td>
                    <td>{{ $edu->Institute == 637 ? ($edu->OtherInstitute ?? 'N/A') : ($edu->institute_name ?? 'N/A') }}</td>
                    <td>{{ $edu->YearOfPassing ?? 'N/A' }}</td>
                    <td>{{ $edu->CGPA ?? 'N/A' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    @if($family_data && $family_data->count() > 0)
    <div class="content-card full-width">
        <div class="section-title">Family Details</div>
        <table class="list-table">
            <thead>
                <tr>
                    <th>Relation</th>
                    <th>Name</th>
                    <th>Date of Birth</th>
                    <th>Qualification</th>
                    <th>Occupation</th>
                </tr>
            </thead>
            <tbody>
                @foreach($family_data as $family)
                <tr>
                    <td>{{ $family->relation ?? '' }}</td>
                    <td>{{ $family->name ?? '' }}</td>
                    <td>{{ $family->dob ?? '' }}</td>
                    <td>{{ $family->qualification ?? '' }}</td>
                    <td>{{ $family->occupation ?? '' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    @if(($jobcandidate->Professional == 'P' && $jobcandidate->PresentCompany) || ($workexp_data && $workexp_data->count() > 0))
    <div class="content-card full-width">
        <div class="section-title">Work Experience</div>
        <table class="list-table">
            <thead>
                <tr>
                    <th>Company</th>
                    <th>Designation</th>
                    <th>Period</th>
                    <th>Gross Salary</th>
                    <th>CTC</th>
                </tr>
            </thead>
            <tbody>
                @if($jobcandidate->Professional == 'P' && $jobcandidate->PresentCompany)
                <tr>
                    <td>{{ $jobcandidate->PresentCompany }}</td>
                    <td>{{ $jobcandidate->PresentDesignation ?? '' }}</td>
                    <td>{{ $jobcandidate->JobStartDate ?? '' }} to {{ $jobcandidate->JobEndDate ?? '' }}</td>
                    <td>₹{{ $jobcandidate->GrossSalary ?? '' }}</td>
                    <td>₹{{ $jobcandidate->CTC ?? '' }}</td>
                </tr>
                @endif
                @foreach($workexp_data as $work)
                <tr>
                    <td>{{ $work->company ?? '' }}</td>
                    <td>{{ $work->desgination ?? '' }}</td>
                    <td>{{ $work->job_start ?? '' }} to {{ $work->job_end ?? '' }}</td>
                    <td>₹{{ $work->gross_mon_sal ?? '' }}</td>
                    <td>₹{{ $work->annual_ctc ?? '' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

<!-- Simple Loader -->
<div id="loaderOverlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
    <div style="background:#fff; padding:30px; border-radius:5px; text-align:center;">
        <div style="border:3px solid #f3f3f3; border-top:3px solid #0d6efd; border-radius:50%; width:40px; height:40px; animation:spin 1s linear infinite; margin:0 auto 15px;"></div>
        <p class="text-primary mb-0"><strong>Processing...</strong></p>
    </div>
</div>

<style>
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

@endsection

@section('scriptsection')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    $('#confirmTransfer').on('click', function() {
        Swal.fire({
            title: 'Confirm Transfer',
            text: 'Are you sure you want to transfer this data to HRIMS?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#0d6efd',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Transfer',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#loaderOverlay').css('display', 'flex');

                var JAId = $('#JAId').val();
                $.ajax({
                    url: '{{ route('transferToHrims') }}',
                    method: 'POST',
                    data: {
                        JAId: JAId,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#loaderOverlay').hide();

                        if (data.status == 400) {
                            Swal.fire('Error!', data.msg, 'error');
                        } else {
                            Swal.fire({
                                title: 'Success!',
                                text: data.message || 'Data transferred successfully',
                                icon: 'success',
                                timer: 2000
                            }).then(() => {
                                window.location.href = '{{ url()->previous() }}';
                            });
                        }
                    },
                    error: function() {
                        $('#loaderOverlay').hide();
                        Swal.fire('Error!', 'An error occurred. Please try again.', 'error');
                    }
                });
            }
        });
    });
});
</script>
@endsection
