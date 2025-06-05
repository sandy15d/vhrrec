<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ URL::to('/') }}/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/css/sweetalert2.min.css" />
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/css/toastr.min.css" />
    <script src="{{ URL::to('/') }}/assets/js/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/b0b5b1cf9f.js" crossorigin="anonymous"></script>
    <title>Offer Letter Generation</title>
    <style>
        body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            font: 12pt "Tahoma";
        }

        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 10mm;
            margin: 10mm auto;
            border: 1px black solid;
            border-radius: 5px;
            background: white;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .subpage {
            padding: 0.5cm;

            /*    height: 297mm; */

        }

        p {
            font-family: "Cambria", serif;
            font-size: 17px;
        }

        ol,
        li {
            text-align: justify;
            font-family: "Cambria", serif;
            font-size: 17px;
            margin-bottom: 5px;
        }

        @page {
            size: A4;
            margin: 0;
        }

        @media print {

            html,
            body {
                width: 210mm;
                height: 297mm;
            }

            .page {
                margin: 0;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
            }

            .noprint {
                display: none !important;
            }
        }

        table,
        th,
        tr,
        td {
            border: 2px solid black;
        }

        .table td,
        .table th {
            padding: .25rem;
            vertical-align: top;
            border-top: 1px solid #060606;
            font-family: "Cambria", serif;
        }

        mark {
            background-color: yellow;
            color: black;
        }

        .generate {
            width: 210mm;
            min-height: 20mm;
            padding: 10mm;
            margin: 10mm auto;

            border: 1px black solid;
            border-radius: 5px;
            background: white;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
@php

    $JAId = base64_decode($_REQUEST['jaid']);

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

<body>
    <div class="container">
        <input type="hidden" name="jaid" id="jaid" value="{{ $JAId }}">
        <div id="offer_letter">
            <div class="page">
                <div class="subpage">
                    <p style="font-size: 16px;"><b>Ref:</b> {{ $sql->LtrNo }}
                        <span style="float:right"><b>Date:</b>
                            @if ($sql->LtrDate == null)
                                {{ date('d-m-Y') }}
                            @else
                                {{ date('d-m-Y', strtotime($sql->LtrDate)) }}
                            @endif
                        </span>
                    </p>
                    <br>
                    <p><b>To,</b></p>
                    <p style="margin-bottom: 0px;"><b>{{ $sql->Title }} {{ $sql->FName }} {{ $sql->MName }}
                            {{ $sql->LName }}</b>
                    </p>
                    <b>
                        <p style="margin-bottom: 0px;">{{ $sql->perm_address }}</p>
                        <p style="margin-bottom: 0px;">{{ $sql->perm_city }},
                            Dist-{{ getDistrictName($sql->perm_dist) }},{{ getStateName($sql->perm_state) }},
                            {{ $sql->perm_pin }}
                        </p>
                    </b><br />
                    <p class="text-center"><b><u>Subject: Offer for Employment</u></b></p>
                    <b>
                        <p>Dear {{ $sql->Title }} {{ $sql->FName }} {{ $sql->MName }} {{ $sql->LName }},</p>
                    </b>
                    <p>We are pleased to offer you the position of <b>{{ getDesignation($sql->Designation) }}</b> at
                        <b>Grade - {{ getGradeValue($sql->Grade) }}</b> in
                        <b>{{ getDepartment($sql->Department) }}</b>
                        Department of {{ getcompany_name($sql->Company) }} (<strong>"Company"</strong>)
                    </p>
                    <p>This offer is subject to following terms and conditions:</p>
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
                                <strong>{{ getHq($sql->T_LocationHq) }}({{ getHqStateCode($sql->T_StateHq) }})</strong>
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
                                <strong>{{ getHq($sql->T_LocationHq) }}({{ getHqStateCode($sql->T_StateHq) }})</strong>
                                However, you may be required to (i) relocate to other locations in India; and/or (ii)
                                undertake such travel in India, iii) overseas locations, from time to time, as may be
                                necessary in the interests of the Company's business.
                            </li>
                        @else
                            <li>Your principal place of employment shall be at
                                <strong>{{ getHq($sql->F_LocationHq) }}({{ getHqStateCode($sql->F_StateHq) }})</strong>.
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




                        @if ($sql->Department == 2 ||$sql->Department == 3 )
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
                        association with us. </p>
                    <p>Yours Sincerely,</p><br><br>
                    <p style="margin-bottom: 0px;"><b>Authorized Signatory,</b></p>
                    <p><b>{{ $sql->SigningAuth }} </b>
                    </p>
                    <hr style="height:1px;border-width:0;color:black;background-color:black;">
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
                    <p style="margin-bottom: 0px;">----------------------
                        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;---------------------&emsp;&emsp;&emsp;&emsp;&emsp;-------------------------
                    </p>
                    <p>Place
                        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Date&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                        {{ $sql->FName }} {{ $sql->MName }} {{ $sql->LName }}
                    </p>
                </div>
            </div>
        </div>

        <div id="ctc">
            <div class="page">
                <div class="subpage">
                    <p style="font-size:16px;"><b>Ref:</b> {{ $sql->LtrNo }}
                        <span style="float: right"><b>Date: </b>
                            @if ($sql->LtrDate == null)
                                {{ date('d-m-Y') }}
                            @else
                                {{ date('d-m-Y', strtotime($sql->LtrDate)) }}
                            @endif
                        </span>
                    </p><br>
                    <p class="text-center"><b>ANNEXURE A – COMPENSATION STRUCTURE</b></p>
                    <br>

                    <table class="table" style="">
                        <form id="ctcform">
                            @csrf
                            <tr>
                                <th class="text-center">Emolument Head</th>
                                <th class="text-center">Amount (in Rs.)</th>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-center">(A) Monthly Components</td>
                            </tr>
                            <tr>
                                <td>Basic + D.A.</td>
                                <td><input type="text" class="form-control text-center" id="basic"
                                        style="height: 21px;border: 0px none;" value="{{ $ctc->basic ?? '' }}"
                                        onchange="calculate()">
                                </td>
                            </tr>
                            <tr>
                                <td>HRA</td>
                                <td><input type="text" class="form-control text-center" id="hra"
                                        style="height: 21px;border: 0px none;" value="{{ $ctc->hra ?? '' }}"
                                        onchange="calculate()">
                                </td>
                            </tr>
                            <tr>
                                <td>*Bonus</td>
                                <td><input type="text" class="form-control text-center" id="bonus"
                                        style="height: 21px;border: 0px none;" value="{{ $ctc->bonus ?? '' }}"
                                        onchange="calculate()">
                                </td>
                            </tr>
                            <tr>
                                <td>Special Allowance</td>
                                <td><input type="text" class="form-control text-center" id="special_alw"
                                        style="height: 21px;border: 0px none;" value="{{ $ctc->special_alw ?? '' }}"
                                        onchange="calculate()">
                                </td>
                            </tr>
                            <tr>
                                <th>Gross Monthly Salary</th>
                                <td><input type="text" class="form-control text-center font-weight-bold"
                                        id="grsM_salary" style="height: 21px;border: 0px none;"
                                        value="{{ $ctc->grsM_salary ?? '' }}" disabled readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>Employee's PF Contribution</td>
                                <td><input type="text" class="form-control text-center" id="emplyPF"
                                        style="height: 21px;border: 0px none;" value="{{ $ctc->emplyPF ?? '' }}"
                                        readonly>
                                </td>
                            </tr>

                            <tr id="esic_tr" class="{{ $ctc->grsM_salary > 21000 ? 'd-none' : '' }}">
                                <td>Employee’s ESIC Contribution </td>
                                <td><input type=" text" class="form-control text-center" id="emplyESIC"
                                        style="height: 21px;border: 0px none;" value="{{ $ctc->emplyESIC ?? '' }}"
                                        readonly>
                                </td>
                            </tr>
                            <tr>
                                <th>Net Monthly Salary</th>
                                <td><input type="text" class="form-control text-center font-weight-bold"
                                        id="netMonth" style="height: 21px;border: 0px none;"
                                        value="{{ $ctc->netMonth ?? '' }}" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center" colspan="2">(B) Annual Components (Tax saving components
                                    which shall
                                    be
                                    reimbursed on production of documents at the end of financial year)</td>
                            </tr>
                            <tr class="d-none">
                                <td>Leave Travel Allowance</td>
                                <td><input type="text" class="form-control text-center" id="lta"
                                        style="height: 21px;border: 0px none;"
                                        value="
                                        <?php if ($ctc->lta == null || $ctc->lta == '') {
                                            echo '0';
                                        } else {
                                            echo $ctc->lta;
                                        } ?>"
                                        onchange="calculate()">
                                </td>
                            </tr>
                            <tr class="d-none">
                                <td>Child Education Allowance</td>
                                <td><input type="text" class="form-control text-center" id="childedu"
                                        style="height: 21px;border: 0px none;"
                                        value="
                                        <?php if ($ctc->childedu == null || $ctc->childedu == '') {
                                            echo '0';
                                        } else {
                                            echo $ctc->childedu;
                                        } ?>"
                                        onchange="calculate()">
                                </td>
                            </tr>
                            <tr>
                                <th>Annual Gross Salary</th>
                                <td><input type="text" class="form-control text-center font-weight-bold"
                                        id="anualgrs" style="height: 21px;border: 0px none;"
                                        value="{{ $ctc->anualgrs ?? '' }}" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-center">(C) Other Annual Components ( Statutory
                                    Components)</td>
                            </tr>
                            <tr>
                                <td>**Estimated Gratuity</td>
                                <td><input type="text" class="form-control text-center" id="gratuity"
                                        style="height: 21px;border: 0px none;" value="{{ $ctc->gratuity ?? '' }}"
                                        readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>Employer’s PF contribution</td>
                                <td><input type="text" class="form-control text-center" id="emplyerPF"
                                        style="height: 21px;border: 0px none;" value="{{ $ctc->emplyerPF ?? '' }}"
                                        readonly>
                                </td>
                            </tr>
                            <tr id="empesic_tr" class="{{ $ctc->grsM_salary > 21000 ? 'd-none' : '' }}">
                                <td>Employer’s ESIC contribution</td>
                                <td><input type="text" class="form-control text-center" id="emplyerESIC"
                                        style="height: 21px;border: 0px none;" value="{{ $ctc->emplyerESIC ?? '' }}"
                                        readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>Insurance Policy Premium </td>
                                <td><input type="text" class="form-control text-center" id="medical"
                                        style="height: 21px;border: 0px none;" value="{{ $ctc->medical ?? '' }}">
                                </td>
                            </tr>
                            <tr>
                                <th>Total CTC</th>
                                <td><input type="text" class="form-control text-center font-weight-bold"
                                        id="total_ctc" style="height: 21px;border: 0px none;"
                                        value="{{ $ctc->total_ctc ?? '' }}" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>Communication Allowance</td>
                                <td><input type="text" class="form-control text-center" id="communication_allowance_amount"
                                        style="height: 21px;border: 0px none;" value="{{ $ctc->communication_allowance_amount ?? '' }}">
                                </td>
                            </tr>
                              <tr>
                                <th>Gross CTC</th>
                                <td><input type="text" class="form-control text-center font-weight-bold"
                                        id="total_gross_ctc" style="height: 21px;border: 0px none;"
                                        value="{{ $ctc->total_gross_ctc ?? '' }}" readonly>
                                </td>
                            </tr>
                        </form>
                    </table>

                    <p style="margin-bottom:0px;">&emsp;&emsp;*Bonus shall be paid as per The Code of Wages Act, 2019
                    </p>
                    <p>&emsp;&emsp;**The Gratuity to be paid as per The Code on Social Security, 2020.</p>
                    <br><br><br><br>
                    <p style="margin-bottom:2px;">----------------------------<span
                            style="float: right">----------------------------</span></p>
                    <p style="margin-bottom: 0px;"><b>Authorized Signatory,</b><span style="float: right">
                            {{ $sql->FName }} {{ $sql->MName }}
                            {{ $sql->LName }}</span>
                    </p>
                    <p><b>{{ $sql->SigningAuth }} </b>
                    </p>
                </div>
                <div class="col text-center">
                    <button type="button" class="btn btn-primary btn-sm text-center d-none" id="save_ctc">Save
                        CTC</button>
                    <button type="button" id="edit_ctc" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i>
                        Edit</button>
                </div>
            </div>
        </div>

        <div id="entitlement">
            <div class="page">
                <div class="subpage">
                    <p style="font-size:16px;"><b>Ref:</b> {{ $sql->LtrNo }}
                        <span style="float: right"><b>Date:</b>
                            @if ($sql->LtrDate == null)
                                {{ date('d-m-Y') }}
                            @else
                                {{ date('d-m-Y', strtotime($sql->LtrDate)) }}
                            @endif
                        </span>
                    </p><br>
                    <p class="text-center"><b>ANNEXURE B – ENTITLEMENTS</b></p>
                    <br>
                    <form id="entform">
                        <table class="table" style="">
                            <tr>
                                <th class="text-center" style="width:60px;">SN</th>
                                <th colspan="2" class="text-center">Entitlements</th>
                            </tr>
                            @php
                                $rowCount = 0;
                            @endphp
                            @if($sql->Grade == '82')
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
                              <td><input type="text" class="form-control text-center" id="LoadCityA"
                                         style="height:20px;border: 0px none;" value="{{ $elg->LoadCityA ?? '' }}">
                              </td>
                             
                          </tr>
                            <tr>
                              <td></td>
                              <td>Lodging for City in Category B</td>
                              <td><input type="text" class="form-control text-center" id="LoadCityB"
                                         style=" height:20px;border: 0px none;" value="{{ $elg->LoadCityB ?? '' }}">
                              </td>
                             
                          </tr>
                            <tr>
                              <td></td>
                              <td>Lodging for City in Category C</td>
                              <td><input type="text" class="form-control text-center" id="LoadCityC"
                                         style=" height:20px;border: 0px none;" value="{{ $elg->LoadCityC ?? '' }}">
                              </td>
                             
                          </tr>
                            @else
                            <tr>
                                <td class="text-center"><?= ++$rowCount ?></td>
                                <td style="width:402px;"><b>Lodging </b> (Actual with upper limits per day)
                                </td>
                                <td><input type="text" class="form-control text-center" id="LoadCityA"
                                        style="height:20px;border: 0px none;" value="{{ $elg->LoadCityA ?? '' }}">
                                </td>
                            </tr>
                            @endif

                            <tr>
                                <td class="text-center"><?= ++$rowCount ?></td>
                                <td><b>D.A Outside H.Q</b> (To be claimed only on night halt)</td>
                                <td><input type="text" class="form-control text-center" id="DAOut"
                                        style=" height:20px;border: 0px none;" value="{{ $elg->DAOut ?? '' }}">
                                </td>
                            </tr>
                             @if ($sql->Department == 13 || $sql->Department == 11 || $sql->Department == 14)
                                <tr>
                                    <td class="text-center"><?= ++$rowCount ?></td>
                                    <td>
                                        @if ($sql->Department == 13)
                                            <b>D.A @ H.Q</b>(Applicable only during *season)
                                        @else
                                            <b>D.A @ H.Q</b>(In case of touring more than 6 hours travel per day )
                                        @endif
                                    </td>
                                    <td><input type="text" class="form-control text-center" id="DAHq"
                                            style=" height:20px;border: 0px none;" value="{{ $elg->DAHq ?? '' }}">
                                    </td>
                                </tr>
                            @endif

                            <tr>
                                <td class="text-center"><?= ++$rowCount ?></td>
                                <td colspan="2"><b>Travel Eligibility (For Official Purpose Only)</b></b></td>

                            </tr>
                            <tr>
                                <td></td>
                                <td style="width:400px;">Two Wheeler
                                     @if ($sql->Department == 14)
                                        ( Max 1500km/month)
                                    @elseif($sql->Department == 15)
                                        ( Max 75Kms/day and 1800km/month)
                                    @endif
                                </td>
                                <td><input type="text" class="form-control text-center" id="TwoWheel"
                                        style=" height:20px;border: 0px none;" value="{{ $elg->TwoWheel ?? '' }}">
                                </td>
                            </tr>
                            <tr class="d-none">
                                <td></td>
                                <td style="width:400px;">Four Wheeler </td>
                                <td><input type="text" class="form-control text-center" id="FourWheel"
                                        style=" height:20px;border: 0px none;" value="{{ $elg->FourWheel ?? '' }}">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center"><?= ++$rowCount ?></td>
                                <td colspan="2"><b>Mode of Travel outside HQ</b></b></td>

                            </tr>

                            <tr>
                                <td></td>
                                <td>Bus/Train</td>
                                <td>
                                    <select id="Train" name="Train" class="frminp"
                                        style=" height:20px;border: 0px none;">
                                        <option disabled selected>Select Travel Mode</option>
                                        <option value="Y">Yes</option>
                                        <option value="N">No</option>
                                    </select>
                                    <script>
                                        $('#Train').val('{{ $elg->Train ?? '' }}');
                                    </script>
                                </td>
                            </tr>
                            <!--<tr class="d-none">-->
                            <!--    <td></td>-->
                            <!--    <td>Flight</td>-->
                            <!--    <td>-->
                            <!--        <select id="Flight" name="Flight" class="frminp"-->
                            <!--            style=" height:20px;border: 0px none;">-->
                            <!--            <option disabled selected>Select Travel Mode</option>-->
                            <!--            <option value="Y">Yes</option>-->
                            <!--            <option value="N">No</option>-->
                            <!--        </select>-->
                            <!--        <script>
                                -- >
                                <
                                !--$('#Flight').val('{{ $elg->Flight ?? '' }}');
                                -- >
                                <
                                !--
                            </script>-->
                            <!--    </td>-->
                            <!--</tr>-->
                            <tr>
                                <td class="text-center"><?= ++$rowCount ?></td>
                                <td colspan="2"><b>Travel Class</b></b></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Bus/Train</td>
                                <td>
                                    <select id="Train_Class" name="Train_Class" class="frminp"
                                        style=" height:20px;border: 0px none;">
                                        <option disabled selected>Select Travel Class</option>
                                        <option value="Sleeper">Sleeper</option>
                                        <option value="AC-I">AC-I</option>
                                        <option value="AC-II">AC-II</option>
                                        <option value="AC-III">AC-III</option>
                                    </select>
                                    <script>
                                        $('#Train_Class').val('{{ $elg->Train_Class ?? '' }}');
                                    </script>
                                </td>
                            </tr>

                            <tr id="flight_class_tr" class="{{ $elg->Flight == 'Y' ? '' : 'd-none' }}">
                                <td></td>
                                <td>Flight</td>
                                <td>
                                    <select id="Flight_Class" name="Flight_Class" class="frminp"
                                        style=" height:20px;border: 0px none;">
                                        <option disabled selected>Select Travel Class</option>
                                        <option value="Economy">Economy</option>
                                        <option value="Business">Business</option>
                                    </select>
                                    <script>
                                        $('#Flight_Class').val('{{ $elg->Flight_Class ?? '' }}');
                                    </script>
                                    <br><br> <input type="text" name="Flight_Remark" id="Flight_Remark"
                                        value="{{ $elg->Flight_Remark ?? '' }}"
                                        style=" height:20px;border: 0px none;" class="form-control text-left">

                                </td>
                            </tr>


                            <!--<tr class="d-none">-->
                            <!--   <td class="text-center"></td>-->
                            <!--    <td><b>Mobile Handset Eligibility</b></b></td>-->
                            <!--    <td><input type="text" class="form-control text-center d-inline" id="Mobile"-->
                            <!--            style=" height:20px;border: 0px none; width:90px;"-->
                            <!--            value="{{ $elg->Mobile ?? '' }}"> <input type="checkbox" id="GPRS"-->
                            <!--            name="GPRS" @if ($elg->GPRS == '1')
checked
@endif>GPRS-->
                            <!--    </td>-->
                            <!--</tr>-->
                            <tr>
                                <td class="text-center"><?= ++$rowCount ?></td>
                                <td><b>Mobile Expense Reimbursement</b></b></td>
                                <td><input type="text" class="form-control text-center d-inline" id="MExpense"
                                        style="height: 20px;border: 0px none;background-color: white;width: 80px;"
                                        value="{{ $elg->MExpense }}"><span>
                                        <select id="MTerm" name="MTerm" class="frminp" style="width:70px;">
                                            <option value="Monthly">Monthly</option>
                                            <option value="Qtr">Per Qtr</option>
                                        </select>
                                        <script>
                                            $('#MTerm').val('{{ $elg->MTerm ?? '' }}');
                                        </script>
                                    </span>
                                </td>
                            </tr>
                            <!--<tr class="d-none">-->
                            <!--   <td class="text-center"></td>-->
                            <!--    <td><b>Laptop Purchase Eligibility (if applicable)</b></b></td>-->
                            <!--    <td><input type="text" class="form-control text-center" id="Laptop"-->
                            <!--            style=" height:20px;border: 0px none;" value="{{ $elg->Laptop ?? '' }}">-->
                            <!--    </td>-->
                            <!--</tr>-->
                            <!--<tr class="d-none">-->
                            <!--    <td class="text-center"></td>-->
                            <!--    <td><b>Health Insurance</b></b></td>-->
                            <!--    <td>-->
                            <!--        <input type="text" class="form-control text-center d-none" id="HealthIns1"-->
                            <!--            style=" height:20px;border: 0px none;" value="">-->
                            <!--        <select id="HealthIns" name="HealthIns" class="frminp" style="width:100px;">-->
                            <!--            <option value="" selected>Select</option>-->
                            <!--            <option value="100000">1</option>-->
                            <!--            <option value="200000">2</option>-->
                            <!--            <option value="300000">3</option>-->
                            <!--            <option value="400000">4</option>-->
                            <!--            <option value="500000">5</option>-->
                            <!--            <option value="600000">6</option>-->
                            <!--            <option value="700000">7</option>-->
                            <!--            <option value="800000">8</option>-->
                            <!--            <option value="900000">9</option>-->
                            <!--            <option value="1000000">10</option>-->
                            <!--        </select> Lakh-->
                            <!--        <script>
                                -- >
                                <
                                !--$('#HealthIns').val('{{ $elg->HealthIns ?? '' }}');
                                -- >
                                <
                                !--
                            </script>-->
                            <!--    </td>-->
                            <!--</tr>-->
                            <!--</tr>-->
                            <tr>
                                <td class="text-center"><?= ++$rowCount ?></td>
                                <td><b>Group Term Insurance</b></b></td>
                                <td class="text-center">
                                    5 Lakh
                                </td>
                            </tr>


                        </table>
                        @if ($sql->Department == 13)
                            <p>*season- a) Rabi (Oct to Jun), b) Kharif (Jul- Sep) (Applicable only for production)</p>
                        @endif

                        {{-- <p style="margin-bottom:0px;"><input type="checkbox" id="two_wheel_line"
                                name="two_wheel_line" @if ($elg->TwoWheelLine == '1') checked @endif>
                            * 2 Wheeler vehicle eligibility.</p>
                        <p style="margin-bottom:0px;"><input type="checkbox" id="four_wheel_line"
                                name="four_wheel_line" @if ($elg->FourWheelLine == '1') checked @endif> * 4 Wheeler
                            vehicle eligibility.</p>

                        <p style="margin-bottom:0px;"><input type="checkbox" id="tline" name="tline"
                                @if ($elg->TravelLine == '1') checked @endif> * Maximum travel
                            km per month
                            allowed for 4 wheeler is 2000
                            km/month and overall travel including both 4 wheeler & 2 wheeler should not exceed more than
                            3000
                            km/month.</p><br><br> --}}
                    </form>
                    <script>
                        $(document).on('change', '#Flight', function() {
                            var Flight = $('#Flight').val();
                            if (Flight == 'Y') {
                                $('#flight_class_tr').removeClass('d-none');

                            } else {
                                $('#flight_class_tr').addClass('d-none');

                            }
                        });

                        $('#tline').click(function() {
                            if ($(this).prop("checked") == true) {
                                $(this).val(1);

                            } else if ($(this).prop("checked") == false) {

                                $(this).val(0);
                            }
                        });

                        $('#GPRS').click(function() {
                            if ($(this).prop("checked") == true) {
                                $(this).val(1);

                            } else if ($(this).prop("checked") == false) {

                                $(this).val(0);
                            }
                        });


                        $('#two_wheel_line').click(function() {
                            if ($(this).prop("checked") == true) {
                                $(this).val(1);

                            } else if ($(this).prop("checked") == false) {

                                $(this).val(0);
                            }
                        });

                        $('#four_wheel_line').click(function() {
                            if ($(this).prop("checked") == true) {
                                $(this).val(1);

                            } else if ($(this).prop("checked") == false) {

                                $(this).val(0);
                            }


                        });



                        $('#tline').val('{{ $elg->TravelLine }}');
                        $('#two_wheel_line').val('{{ $elg->TwoWheelLine }}');
                        $('#four_wheel_line').val('{{ $elg->FourWheelLine }}');
                        $('#GPRS').val('{{ $elg->GPRS }}');
                    </script>

                    {{-- <p class="text-center"><b><u>LIST OF DOCUMENTS REQUIRED DURING APPOINTMENT</u></b></p>
                    <ol>
                        <li style="font-size:14px;">Form 16/Investment Declaration</li>
                        <li style="font-size:14px;">6 colored formal Passport Size Photos with White background</li>
                        <li style="font-size:14px;">Blood Group Test report</li>
                        <li style="font-size:14px;">Copy of educational certificates (10th / 12th / Graduation / Post
                            Graduation, etc.)</li>
                        <li style="font-size:14px;">Previous Employer documents (Service Certificates)</li>
                        <li style="font-size:14px;">Pay slip/ CTC structure of recent previous company</li>
                        <li style="font-size:14px;">Relieving letter from previous company/ Resignation Acceptance
                            Letter
                        </li>
                        <li style="font-size:14px;">Compulsory Documents (Driving license/PAN Card/ Aadhaar Card)</li>
                        <li style="font-size:14px;">Copy of Bank account passbook (Preferred only SBI/BOB) </li>
                    </ol> --}}
                    <br><br><br><br>
                    <p style="margin-bottom:2px;">----------------------------<span
                            style="float: right">----------------------------</span></p>
                    <p style="margin-bottom: 0px;"><b>Authorized Signatory,</b><span
                            style="float: right">{{ $sql->FName }} {{ $sql->MName }}
                            {{ $sql->LName }}</span>
                    </p>
                    <p><b> {{ $sql->SigningAuth }}</b>
                    </p>
                </div>
                <div class="col text-center">
                    <button type="button" class="btn btn-primary btn-sm text-center d-none" id="save_ent">Save
                        entitlement</button>
                    <button type="button" id="edit_ent" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i>
                        Edit</button>
                </div>

            </div>
        </div>

        <div class="generate" id="generate">
            <center>
                @if ($sql->OfferLtrGen == '0')
                    <button type="button" class="btn  btn-md text-center btn-success" id="generateLtr"><i
                            class="fa fa-file"></i> Generate Letter</button>
                @else
                    <button type="button" class="btn  btn-md text-center btn-danger" id="regenltr"><i
                            class="fa fa-file"></i> Re-Generate Letter</button>
                @endif
                <a id="print" class="btn btn-info btn-md text-center text-light"
                    href="{{ route('offer_ltr_print') }}?jaid={{ $JAId }}"><i class="fa fa-print"></i>
                    Print
                </a>
            </center>
        </div>
    </div>

    <script src="{{ URL::to('/') }}/assets/js/bootstrap.bundle.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/js/sweetalert2.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/js/toastr.min.js"></script>
    <script>
        function calculate() {
        debugger;
            var basic = $('#basic').val();
            var hra = $('#hra').val();
            var bonus = $('#bonus').val();
            var special_alw = $('#special_alw').val();
            var emplyPF = 0;
            if (isNaN(basic) || basic.trim() === '') {
                basic = 0;
            }
            if (isNaN(hra) || hra.trim() === '') {
                hra = 0;
            }
            if (isNaN(bonus) || bonus.trim() === '') {
                bonus = 0;
            }
            if (isNaN(special_alw) || special_alw.trim() === '') {
                special_alw = 0;
            }

            var grsM_salary = Math.round(parseFloat(basic) + parseFloat(hra) + parseFloat(bonus) + parseFloat(special_alw));
            $('#grsM_salary').val(grsM_salary);

            if (basic >= 15000) {
                emplyPF = Math.round(parseFloat(basic * 12 / 100));
            } else {
                if ( (parseFloat(basic) + parseFloat(special_alw)) >= 15000) {
                emplyPF = Math.round(parseFloat(15000 * 12 / 100));
                } else {
                    var totalBasicSpecial = parseFloat(basic) + parseFloat(special_alw);
                    emplyPF = Math.round(parseFloat(totalBasicSpecial * 12 / 100));
                }
            }
            


          
            $('#emplyPF').val(emplyPF);
            var emplyESIC = 0;
            if (grsM_salary > 21000) {
                $('#emplyESIC').val(0).attr('disabled', true);
                $("#esic_tr").addClass('d-none');
                $("#empesic_tr").addClass('d-none');
            } else {
                var emplyESIC = Math.round(parseFloat(grsM_salary * 0.75 / 100));
                $('#emplyESIC').val(emplyESIC).attr('disabled', false);
                $("#esic_tr").removeClass('d-none');
                $("#empesic_tr").removeClass('d-none');
            }
            var netMonth = Math.round(parseFloat(grsM_salary - (emplyPF + emplyESIC)));
            $('#netMonth').val(netMonth);
            var lta = $('#lta').val();
            var childedu = $('#childedu').val();
            var anualgrs = Math.round(parseFloat(parseFloat(grsM_salary * 12) + parseFloat(lta) + parseFloat(childedu)));
            $('#anualgrs').val(anualgrs);

            var gratuity = Math.round(parseFloat(basic * 15 / 26));
            $('#gratuity').val(gratuity);

            var emplyerPF = Math.round(parseFloat(emplyPF * 12));
            $('#emplyerPF').val(emplyerPF);

            if (grsM_salary > 21000) {
                $('#medical').val(15000).attr('disabled', true);
                $('#emplyerESIC').val(0).attr('disabled', true);
            } else {

                $('#medical').val(3000).attr('disabled', false);
                $('#emplyerESIC').val(Math.round(parseFloat(anualgrs * 3.25 / 100))).attr('disabled', true);
            }

            var total_ctc = Math.round(parseFloat(anualgrs) + parseFloat(gratuity) + parseFloat(emplyerPF) + parseFloat($(
                    '#emplyerESIC').val()) +
                parseFloat($('#medical').val()));
            $('#total_ctc').val(total_ctc);
            $('#total_gross_ctc').val(total_ctc);
        }
        
        $(document).on("change", "#communication_allowance_amount", function () {
        var total_ctc = parseFloat($("#total_ctc").val()) || 0;
        var comm_alw = parseFloat($(this).val()) || 0;
        var gross_ctc = total_ctc + comm_alw;
    
        $('#total_gross_ctc').val(gross_ctc); // Optional: formats to 2 decimal places
    });


        $(document).on('click', '#generateLtr', function() {
            if (confirm('Are you sure you want to generate letter?')) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var formData = {
                    jaid: $("#jaid").val(),
                };
                $.ajax({
                    type: 'POST',
                    url: "{{ route('offer_ltr_gen') }}",
                    data: formData,
                    dataType: 'json',
                    success: function(data) {
                        if (data.status == 200) {
                            toastr.success(data.msg);
                            window.location.reload();
                            window.opener.location.reload(true);
                        } else {
                            toastr.error(data.msg);
                        }
                    },
                    error: function(data) {}
                });
            } else {
                window.location.reload();
            }

        });


        $(document).on('click', '#regenltr', function() {
            if (confirm('Are you sure you want to generate letter?')) {
                var RemarkHr = prompt("Please Enter Revision Remark");
                if (RemarkHr != null) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var formData = {
                        jaid: $("#jaid").val(),
                        RemarkHr: RemarkHr,
                    };
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('offer_ltr_gen') }}",
                        data: formData,
                        dataType: 'json',
                        success: function(data) {
                            if (data.status == 200) {
                                toastr.success(data.msg);
                                window.location.reload();
                                window.opener.location.reload(true);
                            } else {
                                toastr.error(data.msg);
                            }
                        },
                        error: function(data) {}
                    });
                } else {
                    window.location.reload();
                }
            } else {
                window.location.reload();
            }

        });

        $(document).ready(function() {
            //================Disable all input element inside ctcform=========================
            var ctcform = document.getElementById('ctcform');
            var elements = ctcform.elements;
            for (var i = 0, len = elements.length; i < len; ++i) {
                elements[i].disabled = true;
                elements[i].style.backgroundColor = "white";
                elements[i].style.color = "Black";
            }
            //================Disable all input element inside entform=========================
            var entform = document.getElementById('entform');
            var elements = entform.elements;
            for (var i = 0, len = elements.length; i < len; ++i) {
                elements[i].disabled = true;
                elements[i].style.backgroundColor = "white";
                elements[i].style.color = "Black";
            }

            //=========================Enable all input element inside ctc form====================
            $(document).on('click', '#edit_ctc', function() {

                var ctcform = document.getElementById('ctcform');
                var elements = ctcform.elements;
                for (var i = 0, len = elements.length; i < len; ++i) {
                    elements[i].disabled = false;
                }
                $('#edit_ctc').addClass('d-none');
                $('#save_ctc').removeClass('d-none');
            });


            //=========================Enable all input element inside ent form====================
            $(document).on('click', '#edit_ent', function() {
                var entform = document.getElementById('entform');
                var elements = entform.elements;
                for (var i = 0, len = elements.length; i < len; ++i) {
                    elements[i].disabled = false;
                }
                $('#edit_ent').addClass('d-none');
                $('#save_ent').removeClass('d-none');
            });

            //============================Insert/Update CTC=========================
            $('#save_ctc').click(function(e) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var formData = {
                    jaid: $("#jaid").val(),
                    basic: $('#basic').val(),
                    hra: $('#hra').val(),
                    bonus: $('#bonus').val(),
                    special_alw: $('#special_alw').val(),
                    grsM_salary: $('#grsM_salary').val(),
                    emplyPF: $('#emplyPF').val(),
                    emplyESIC: $('#emplyESIC').val(),
                    netMonth: $('#netMonth').val(),
                    lta: $('#lta').val(),
                    childedu: $('#childedu').val(),
                    anualgrs: $('#anualgrs').val(),
                    gratuity: $('#gratuity').val(),
                    emplyerPF: $('#emplyerPF').val(),
                    emplyerESIC: $('#emplyerESIC').val(),
                    medical: $('#medical').val(),
                    total_ctc: $('#total_ctc').val(),
                    communication_allowance:$('#communication_allowance_amount').val(),
                    total_gross_ctc:$('#total_gross_ctc').val()
                };
                $.ajax({
                    type: 'POST',
                    url: "{{ route('insert_ctc') }}",
                    data: formData,
                    dataType: 'json',
                    success: function(data) {
                        if (data.status == 200) {
                            toastr.success(data.msg);
                            $('#save_ctc').addClass("d-none");
                            $('#edit_ctc').removeClass('d-none');
                            var ctcform = document.getElementById('ctcform');
                            var elements = ctcform.elements;
                            for (var i = 0, len = elements.length; i < len; ++i) {
                                elements[i].disabled = true;
                                elements[i].style.backgroundColor = "white";
                                elements[i].style.color = "Black";
                            }
                        } else {
                            toastr.error(data.msg);
                        }
                    },

                    error: function(data) {

                    }
                });
            });

            //============================Insert/Update ENT=========================
            $('#save_ent').click(function(e) {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var formData = {
                    jaid: $("#jaid").val(),
                    LoadCityA: $('#LoadCityA').val(),
                    LoadCityB: $('#LoadCityB').val(),
                    LoadCityC: $('#LoadCityC').val(),
                    DAOut: $('#DAOut').val(),
                    DAHq: $('#DAHq').val(),
                    TwoWheel: $('#TwoWheel').val(),
                    FourWheel: $('#FourWheel').val(),
                    Train: $('#Train').val(),
                    Train_Class: $('#Train_Class').val(),
                    Flight: $('#Flight').val(),
                    Flight_Class: $('#Flight_Class').val(),
                    Flight_Remark: $('#Flight_Remark').val(),
                    Mobile: $('#Mobile').val(),
                    MExpense: $('#MExpense').val(),
                    MTerm: $('#MTerm').val(),
                    Laptop: $('#Laptop').val(),
                    HealthIns: $('#HealthIns').val(),
                    tline: $('#tline').val(),
                    two_wheel_line: $('#two_wheel_line').val(),
                    four_wheel_line: $('#four_wheel_line').val(),
                    GPRS: $('#GPRS').val(),


                };
                $.ajax({
                    type: 'POST',
                    url: "{{ route('insert_ent') }}",
                    data: formData,
                    dataType: 'json',
                    success: function(data) {
                        if (data.status == 200) {
                            toastr.success(data.msg);
                            $('#save_ent').addClass("d-none");
                            $('#edit_ent').removeClass('d-none');
                            var entform = document.getElementById('entform');
                            var elements = entform.elements;
                            for (var i = 0, len = elements.length; i < len; ++i) {
                                elements[i].disabled = true;
                                elements[i].style.backgroundColor = "white";
                                elements[i].style.color = "Black";
                            }
                        } else {
                            toastr.error(data.msg);
                        }
                    },

                    error: function(data) {

                    }
                });
            });
        });
    </script>
</body>

</html>
