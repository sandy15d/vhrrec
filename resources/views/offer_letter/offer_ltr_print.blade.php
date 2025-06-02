@php

    $JAId = $_REQUEST['jaid'];
    $sql = DB::table('offerletterbasic')
        ->leftJoin('jobapply', 'offerletterbasic.JAId', '=', 'jobapply.JAId')
        ->leftJoin('jobcandidates', 'jobapply.JCId', '=', 'jobcandidates.JCId')
        ->leftJoin('jf_contact_det', 'jobcandidates.JCId', '=', 'jf_contact_det.JCId')
        ->leftJoin('jf_family_det', 'jobcandidates.JCId', '=', 'jf_family_det.JCId')
        ->select('offerletterbasic.*', 'jobcandidates.Title', 'jobcandidates.FName', 'jobcandidates.MName', 'jobcandidates.LName', 'jobcandidates.FatherTitle', 'jobcandidates.FatherName', 'jobcandidates.Gender', 'jobapply.ApplyDate', 'jf_contact_det.perm_address', 'jf_contact_det.perm_city', 'jf_contact_det.perm_dist', 'jf_contact_det.perm_state', 'jf_contact_det.perm_pin')
        ->where('jobapply.JAId', $JAId)
        ->first();

    $ctc = DB::table('candidate_ctc')
        ->select('*')
        ->where('JAId', $JAId)
        ->first();

    $elg = DB::table('candidate_entitlement')
        ->select('*')
        ->where('JAId', $JAId)
        ->first();
    $months_word = ['One' => '1 (One)', 'Two' => '2 (Two)', 'Three' => '3 (Three)', 'Four' => '4 (Four)', 'Five' => '5 (Five)', 'Six' => '6 (Six)', 'Seven' => '7 (Seven)', 'Eight' => '8 (Eight)', 'Nine' => '9 (Nine)', 'Ten' => '10 (Ten)', 'Eleven' => '11 (Eleven)', 'Twelve' => '12 (Twelve)'];
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offer Letter</title>
    <style>
        table {
            border-spacing: 0px;
            border: 1px solid black;
        }

        table tr td,
        tr th {
            border: 1px solid black;

        }
    </style>
</head>

<body>
    <div style="font-size: 14px; font-weight: bold;">
        <div style="float: left; width: 60%; text-align: left;">Ref:
            {{ $sql->LtrNo }}
        </div>
        <div style="float: left; width: 40%; text-align: right;">Date: @if ($sql->LtrDate == null)
                {{ date('d-m-Y') }}
            @else
                {{ date('d-m-Y', strtotime($sql->LtrDate)) }}
            @endif
        </div>
    </div>
    <p><b>To,</b>
        <br>
        <b style="margin-bottom: 0px;"> {{ $sql->Title }} {{ $sql->FName }} {{ $sql->MName }}
            {{ $sql->LName }}<br>{{ $sql->perm_address }}, {{ $sql->perm_city }},
            <br>Dist-{{ getDistrictName($sql->perm_dist) }},{{ getStateName($sql->perm_state) }},
            {{ $sql->perm_pin }}</b>
    </p>
    <p style="text-align: center;font-weight: bold;"><b><u>Subject: Offer for Employment</u></b></p>
    <b>
        <p>Dear {{ $sql->Title }} {{ $sql->FName }} {{ $sql->MName }} {{ $sql->LName }},</p>
    </b>
    <p>We are pleased to offer you the position of <b>{{ getDesignation($sql->Designation) }}</b> at
        <b>Grade - {{ getGradeValue($sql->Grade) }}</b> in
        <b>{{ getDepartment($sql->Department) }}</b>
        Department of {{ getcompany_name($sql->Company) }} (<strong>"Company"</strong>)</p>
        <p> This offer is subject to following terms and conditions:</p>
    <ol>
        
        @if ($sql->ServiceCondition == 'Training' && $sql->OrientationPeriod != null && $sql->Stipend != null)
            <li>You shall report at
                <strong>{{ optional($sql)->F_City ? $sql->F_City . ',' : '' }}{{ getHq($sql->F_LocationHq) }}({{ getHqStateCode($sql->F_StateHq) }})</strong>,
                for an orientation program of {{ $sql->OrientationPeriod }} months.
                After completion of the orientation period, you shall be on a Training period of 12
                months and during the period of training, you may be allocated various assignments at
                different locations.
                However, you may be required to (i) relocate to other locations in India; and/or (ii)
                undertake such travel in India, (iii) overseas locations, from time to time, as may be
                necessary in the interests of the Company's business.
            </li>
        @elseif($sql->TempS == 1 && $sql->FixedS == 1)
            <li>For initial {{ $months_word[$sql->TempM] }} months, your temporary headquarter will
                be
                <strong>{{ optional($sql)->T_City ? $sql->T_City . ',' : '' }}{{ getHq($sql->T_LocationHq) }}({{ getHqStateCode($sql->T_StateHq) }})</strong>
                and then
                your principal place of employment shall be at
                <strong>{{ optional($sql)->F_City ? $sql->F_City . ',' : '' }}{{ getHq($sql->F_LocationHq) }}({{ getHqStateCode($sql->F_StateHq) }})</strong>.
                However, you may be
                required to (i) relocate to other locations in India; and/or (ii) undertake such travel
                in India, (iii) overseas locations, from time to time, as may be necessary in the
                interests of the Company's business.
            </li>
        @elseif($sql->TempS == 1 && $sql->FixedS == 0)
            <li>For initial {{ $months_word[$sql->TempM] }} months, your temporary headquarter will
                be
                <strong>{{ optional($sql)->T_City ? $sql->T_City . ',' : '' }}{{ getHq($sql->T_LocationHq) }}({{ getHqStateCode($sql->T_StateHq) }})</strong>
                However, you may be required to (i) relocate to other locations in India; and/or (ii)
                undertake such travel in India, iii) overseas locations, from time to time, as may be
                necessary in the interests of the Company's business.
            </li>
        @else
            <li>Your principal place of employment shall be at
                <strong>{{ optional($sql)->F_City ? $sql->F_City . ',' : '' }}{{ getHq($sql->F_LocationHq) }}({{ getHqStateCode($sql->F_StateHq) }})</strong>.
                However, you may be
                required to (i) relocate to other locations in India; and/or (ii) undertake such travel
                in India, (iii) overseas locations, from time to time, as may be necessary in the
                interests of the Company's business.
            </li>
        @endif

        @if ($sql->Functional_R != 0 && $sql->Admins_R != 0)
            <li>For administrative purpose you shall be reporting to
                <strong>{{ getFullName($sql->A_ReportingManager) }},
                    {{ getEmployeeDesignation($sql->A_ReportingManager) }}</strong>
                and for technical purpose you shall be reporting to
                <strong>{{ getFullName($sql->F_ReportingManager) }},
                    {{ getEmployeeDesignation($sql->F_ReportingManager) }}</strong>
                and will work under the supervision of such officers as may be decided upon by the
                Management from time to time.
            </li>
        @else
            <li>You will report to
                <strong>{{ getFullName($sql->A_ReportingManager) }},
                    {{ getEmployeeDesignation($sql->A_ReportingManager) }}</strong> and will
                work under the supervision of such officers as may be decided upon by the management of
                the Company, from time to time.
            </li>
        @endif


        @if ($sql->ServiceCondition == 'Training' && $sql->OrientationPeriod != null && $sql->Stipend != null)
            <li>After completion of the Orientation period, You shall be on training for a period of 1
                year from the Appointment Date <strong>(“Training Period”)</strong> and after completion
                of the Training
                Period, you will be confirmed subject to your satisfactory performance.</li>
        @elseif ($sql->ServiceCondition == 'Training' && $sql->AFT_Grade != 0)
            <li>You shall be on training for a period of 1 year from the Appointment Date
                <strong>(“Training Period”)</strong> and after completion of the Training Period, you
                will be confirmed on the post of <b>{{ getDesignation($sql->AFT_Designation) }}</b>
                at Grade
                <b>{{ getGradeValue($sql->AFT_Grade) }}</b> subject to your satisfactory performance.
                .
            </li>
        @elseif ($sql->ServiceCondition == 'Training')
            <li>You shall be on training for a period of 1 (One) year from the Appointment Date
                <strong>(“Training Period”)</strong> and after completion of the Training Period, you
                will be confirmed subject to your satisfactory performance.
            </li>
        @elseif ($sql->ServiceCondition == 'Probation')
            <li>You shall be on probation for a period of 6 (Six) months from the Appointment Date
                <strong>(“Probation Period”)</strong> and after completion of the Probation Period, you
                will be confirmed
                subject to your satisfactory performance.
            </li>
        @endif

        @if ($sql->ServiceBond == 'Yes')
            <li>At the time of your appointment, you shall sign a service bond providing your consent to
                serve the company for a minimum period of
                <b>{{ $months_word[$sql->ServiceBondYears] }} </b>years
                from the Appointment Date. In the event of dishonor of this service bond, you shall be
                liable to pay the company a sum of <b>{{ $sql->ServiceBondRefund }} %</b> of your
                annual
                CTC as per the prevailing CTC rate {as on date of leaving}
            </li>
        @endif

        @if ($sql->Department == 1002 || $sql->Department == 1040)
            <li>During the {{ $sql->ServiceCondition }} Period, either you or the Company may
                terminate
                this
                employment by giving 3 (Three) Months’ notice in writing or salary in lieu of such
                notice period. Pursuant to your confirmation, the aforementioned notice period shall be
                of 3 (Three) Months in writing or the salary in lieu thereof. </li>
        @else
            <li>During the {{ $sql->ServiceCondition }} Period, either you or the Company may
                terminate this
                employment by giving 15 days’ notice in writing or salary in lieu of such notice period.
                Pursuant to your confirmation, the aforementioned notice period shall be of 30 days in
                writing or the salary in lieu thereof. </li>
        @endif



        @if ($sql->ServiceCondition == 'Training' && $sql->OrientationPeriod != null && $sql->Stipend != null)
            <li>During the period of Orientation, you shall receive a consolidated stipend of Rs.
                {{ $sql->Stipend }}/- per month.
                After completion of your Orientation period, your annual CTC and entitlements details
                shall be as mentioned in the Annexures A and B attached hereto.
            </li>
        @else
            <li>Your annual CTC and entitlements details shall be as mentioned in the Annexures A and B
                attached hereto.</li>
        @endif

        <li>You shall look after all the duties & responsibilities assigned to you from time to time,
            based on the business requirement. It may be subject to changes at the sole discretion of
            the Company.</li>
        <li>Your employment with the Company will be governed by the Company’s service rules and
            conditions which will be detailed in your appointment letter, issued pursuant to your
            acceptance of this offer. Your employment with the Company will be bound by all policies and
            procedures of the Company, as may be drafted, revised, amended and/or updated from time to
            time. </li>
        <li>The validity of this offer letter and continuation of your service is subject to your being
            found physically, mentally, and medically fit and remaining so during your service.</li>


    </ol>
    <p>We are glad that very soon you will be part of our team. We look forward to your long and
        meaningful
        association with us. <br>Yours Sincerely,</p>

  <pagebreak>
    <p>I, {{ $sql->Title }} {{ $sql->FName }} {{ $sql->MName }} {{ $sql->LName }},
        @if ($sql->Gender == 'M')
            S/o.
        @else
            D/o.
        @endif
        {{ $sql->FatherTitle }} {{ ucwords(strtolower($sql->FatherName)) }} have read and
        understood the above
        terms
        and
        conditions and
        I agree to abide by them. I will join on Date: ................ failing which I have no lien on
        this
        employment.
    </p>

    <br>
    <div style="margin-bottom:5px; font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif">
        <div style="float: left; width: 33%; text-align: left;">_______________</div>
        <div style="float: left; width: 33%; text-align: center;">_______________</div>
        <div style="float: left; width: 33%; text-align: right;">________________</div>
    </div>
    <div style="font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;font-weight: bold;">
        <div style="float: left; width: 33%; text-align: left;">Place</div>
        <div style="float: left; width: 33%; text-align: center;">Date</div>
        <div style="float: left; width: 33%; text-align: right;">{{ $sql->FName }}
            {{ $sql->MName }} {{ $sql->LName }}</div>
    </div>




    <pagebreak>

        <p style="text-align: center;"><b>ANNEXURE A – COMPENSATION STRUCTURE</b></p>

        <div style="text-align: center;margin-left:50px;">
            <table class="table" style="width: 90%">
                <tr>
                    <th class="text-center">Emolument Head</th>
                    <th class="text-center">Amount (in Rs.)</th>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">(A) Monthly Components</td>
                </tr>
                <tr>
                    <td>Basic + D.A.</td>
                    <td class="text-center">{{ $ctc->basic ?? '' }}</td>
                </tr>
                @if ($ctc->hra != null || $ctc->hra != '' || $ctc->hra != 0)
                    <tr>
                        <td>HRA</td>
                        <td class="text-center">{{ $ctc->hra ?? '' }}</td>
                    </tr>
                @endif
                <tr>
                    <td>*Bonus</td>
                    <td class="text-center">{{ $ctc->bonus ?? '' }} </td>
                </tr>
                @if ($ctc->special_alw != null || $ctc->special_alw != '')
                    <tr>
                        <td>Special Allowance</td>
                        <td class="text-center">{{ $ctc->special_alw ?? '' }}</td>
                    </tr>
                @endif
                <tr>
                    <th>Gross Monthly Salary</th>
                    <td class="text-center">{{ $ctc->grsM_salary ?? '' }}</td>
                </tr>
                <tr>
                    <td>Employee's PF Contribution</td>
                    <td class="text-center">{{ $ctc->emplyPF ?? '' }}</td>
                </tr>
                <tr class="{{ $ctc->grsM_salary > 21000 ? 'd-none' : '' }}">
                    <td>Employee’s ESIC Contribution </td>
                    <td class="text-center">{{ $ctc->emplyESIC ?? '' }}</td>
                </tr>
                <tr>
                    <th>Net Monthly Salary</th>
                    <td class="text-center">{{ $ctc->netMonth ?? '' }} </td>
                </tr>
                <tr>
                    <td class="text-center" colspan="2">(B) Annual Components (Tax saving
                        components
                        which shall
                        be
                        reimbursed on production of documents at the end of financial year)</td>
                </tr>
                <tr class="d-none">
                    <td>Leave Travel Allowance</td>
                    <td class="text-center">{{ $ctc->lta }} </td>
                </tr>
                <tr class="d-none">
                    <td>Child Education Allowance</td>
                    <td class="text-center">{{ $ctc->childedu }}</td>
                </tr>
                <tr>
                    <th>Annual Gross Salary</th>
                    <td class="text-center">{{ $ctc->anualgrs ?? '' }}</td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">(C) Other Annual Components ( Statutory
                        Components)</td>
                </tr>
                <tr>
                    <td>**Estimated Gratuity</td>
                    <td class="text-center">{{ $ctc->gratuity ?? '' }}</td>
                </tr>
                <tr>
                    <td>Employer’s PF contribution</td>
                    <td class="text-center">{{ $ctc->emplyerPF ?? '' }}</td>
                </tr>
                <tr class="{{ $ctc->grsM_salary > 21000 ? 'd-none' : '' }}">
                    <td>Employer’s ESIC contribution</td>
                    <td class="text-center">{{ $ctc->emplyerESIC ?? '' }} </td>
                </tr>
                <tr class="{{ $ctc->medical <= 0 ? 'd-none' : '' }}">
                    <td>Insurance Policy Premium </td>
                    <td class="text-center">{{ $ctc->medical ?? '' }}</td>
                </tr>
                <tr>
                    <th>Total Cost to Company</th>
                    <td class="text-center">{{ $ctc->total_ctc ?? '' }} </td>
                </tr>
                @if ($ctc->communication_allowance_amount != null || $ctc->communication_allowance_amount != '')
                    <tr>
                        <td>Communication Allowance</td>
                        <td class="text-center">{{ $ctc->communication_allowance_amount ?? '' }}</td>
                    </tr>
                    <tr>
                    <th>Total Gross CTC</th>
                    <td class="text-center">{{ $ctc->total_gross_ctc ?? '' }} </td>
                </tr>
                @endif
            </table>
        </div>

        <p><b>Notes:</b></p>
        <ol type="1">
            <li>Bonus shall be paid as per The Code of Wages Act, 2019</li>
            <li>The Gratuity to be paid as per The Code on Social Security, 2020.</li>

        </ol>



        <pagebreak />
        <br>
        <p style="text-align: center"><b>ANNEXURE B – ENTITLEMENTS</b></p>

        <table class="table" style="width: 90%">
            @php
                $rowCount = 0;
            @endphp
            <tr>
                <th class="text-center" style="width:40px;">SN</th>
                <th colspan="2" class="text-center">Entitlements</th>
            </tr>
             @if($sql->Grade == '1011')
                <tr>
                  <td class="text-center"><?= ++$rowCount ?></td>
                  <td><b>Lodging :</b> Actual with upper limits per day as mentioned
                      below
                  </td>
                  <td>Amount(in Rs.)</td>
                 
              </tr>
                <tr>
                  <td></td>
                  <td>Lodging for City in Category A</td>
                  <td>{{ $elg->LoadCityA ?? '' }}
                  </td>
                 
              </tr>
                <tr>
                  <td></td>
                  <td>Lodging for City in Category B</td>
                  <td>{{ $elg->LoadCityB ?? '' }}
                  </td>
                 
              </tr>
                <tr>
                  <td></td>
                  <td>Lodging for City in Category C</td>
                  <td>{{ $elg->LoadCityC ?? '' }}
                  </td>
                 
              </tr>
            @else
            <tr>
                <td class="text-center"><?= ++$rowCount ?></td>
                <td style="width:402px;"><b>Lodging </b> (Actual with upper limits per day)
                </td>
                <td style="width:120px;">{{ $elg->LoadCityA ?? '' }}
                </td>
            </tr>
            @endif

            @if ($elg->DAOut != '')
                <tr>
                    <td class="text-center"><?= ++$rowCount ?></td>
                    <td><b>D.A Outside H.Q</b> (To be claimed only on night halt)</td>
                    <td class="text-center">{{ $elg->DAOut }}</td>
                </tr>
            @endif

            @if ($sql->Department == 1004 || $sql->Department == 1025 || $sql->Department == 1024)
                <tr>
                    <td class="text-center"><?= ++$rowCount ?></td>
                    <td>
                        @if ($sql->Department == 1004)
                            <b>D.A @ H.Q</b>(Applicable only during *season)
                        @else
                            <b>D.A @ H.Q</b>(In case of touring more than 6 hours travel per day )
                        @endif
                    </td>
                    <td class="text-center">{{ $elg->DAHq }}</td>
                </tr>
            @endif
            @if ($elg->TwoWheel != '' || $elg->TwoWheel != null)
                <tr>
                    <td class="text-center"><?= ++$rowCount ?></td>
                    <td colspan="2"><b>Travel Eligibility (For Official Purpose Only)</b></td>

                </tr>

                @if ($elg->TwoWheel != '' || $sql->Department != 1002 || $sql->Department != 1040)
                    <tr>
                        <td></td>
                        <td style="width:502px;">**Two Wheeler
                            @if ($sql->Department == 1003)
                                ( Max 1500km/month)
                            @elseif($sql->Department == 1006)
                                ( Max 75Kms/day and 1800km/month)
                            @endif
                        </td>
                        <td class="text-center">Rs. {{ $elg->TwoWheel }} /KM</td>
                    </tr>
                @endif
                @if ($elg->FourWheel != '')
                    <tr>
                        <td></td>
                        <td style="width:502px;">*Four Wheeler
                        </td>
                        <td class="text-center">{{ $elg->FourWheel }}</td>
                    </tr>
                @endif

            @endif
            @if ($elg->Train_Class != '')
            <tr>
                <td class="text-center"><?= ++$rowCount ?></td>
                <td colspan="2"><b>Mode of Travel outside HQ</b></td>
            </tr>
            @endif
            @if ($elg->Train_Class != '')
            <tr>
                <td></td>
                <td>Bus/Train</td>
                <td class="text-center"> {{ $elg->Train_Class }}</td>

            </tr>
            @endif
            @if ($elg->Flight == 'Y')
                <tr>
                    <td></td>
                    <td>Flight</td>
                    <td class="text-center"> {{ $elg->Flight_Class }}
                        ({{ $elg->Flight_Remark }})
                    </td>
                </tr>
            @endif

            @if ($elg->Mobile != '')
                <tr>
                    <td class="text-center"><?= ++$rowCount ?></td>
                    <td><b>Mobile Handset Eligibility</b>
                        @if ($elg->GPRS == 1)
                            (Once in 2 Years)
                        @else
                            (Once in 3 Years)
                        @endif
                    </td>
                    <td class="text-center">Rs. {{ $elg->Mobile }}</td>
                </tr>

            @endif


            @if ($elg->MExpense != '')
                <tr>
                    <td class="text-center"><?= ++$rowCount ?></td>
                    <td><b>Mobile Expense Reimbursement</b></td>
                    <td class="text-center">Rs. {{ $elg->MExpense }} / {{ $elg->MTerm }}</td>
                </tr>
            @endif

            @if ($elg->Laptop != '')
                <tr>
                    <td class="text-center"><?= ++$rowCount ?></td>
                    <td><b>Laptop Purchase Eligibility (if applicable)</b></td>
                    <td class="text-center">Rs. {{ $elg->Laptop }} </td>
                </tr>
            @endif

            <tr>
                <td class="text-center"><?= ++$rowCount ?></td>
                <td><b>Group Term Insurance</b></td>
                <td class="text-center">
                    5 Lakh
                </td>
            </tr>


        </table>
        @if ($elg->TwoWheelLine == 1)
            <p style="padding-left: 20px;margin-bottom:5px;"> *2 Wheeler vehicle eligibility as per company
                vehicle policy.</p>
        @endif

        @if ($elg->FourWheelLine == 1)
            <p style="padding-left: 20px;margin-bottom:5px;">*4 Wheeler vehicle eligibility as per company
                vehicle policy.
            </p>
        @endif

        @if ($elg->TravelLine == 1)
            <p style="padding-left: 20px;margin-bottom:5px; text-align:justify">*Maximum travel km per
                month
                allowed for 4 wheeler is 2000
                km/month and overall travel including both 4 wheeler & 2 wheeler should not exceed more
                than
                3000
                km/month.</p>
        @endif
        @if ($sql->Department == 1004)
            <p>*season- a) Rabi (Oct to Jun), b) Kharif (Jul- Sep) (Applicable only for production)</p>
        @endif
        <br>
        <p class="text-center"><b><u>LIST OF DOCUMENTS REQUIRED DURING APPOINTMENT</u></b></p>
        <ol>
            <li style="font-size:14px;">Mandatory Documents <b>(E-Aadhaar Card /Driving license/PAN
                    Card)</b></li>
            <li style="font-size:14px;">Copy of Bank account passbook (Preferred only Bank of Baroda) </li>
            <li style="font-size:14px;">Copy of educational certificates (10th / 12th / Graduation / Post
                Graduation, etc.)</li>
            <li style="font-size:14px;">6 colored formal Passport Size Photos with White background</li>
            <li style="font-size:14px;">Blood Group Test report</li>

            <li style="font-size:14px;">Previous Employer documents (Service Certificates)</li>

            <li style="font-size:14px;">COVID-19 Vaccination Certificate</li>
            <li style="font-size:14px;">Certificate of Pradhan Mantri Jeevan Jyoti Bima Yojna (PMJJBY) &
                Pradhan Mantri Suraksha Bima Yojna (PMSBY)</li>
            <li style="font-size:14px;">Aadhaar Card of each Family Members
            </li>
            <li style="font-size:14px;">Group Family Photograph (Postal Card Size-2). </li>
        </ol>


</body>

</html>
