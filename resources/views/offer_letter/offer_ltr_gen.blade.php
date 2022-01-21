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
use function App\Helpers\getDesignation;
use function App\Helpers\getHqStateCode;
use function App\Helpers\getHq;
use function App\Helpers\getDepartmentCode;
use function App\Helpers\getCompanyCode;
use function App\Helpers\getFullName;
use function App\Helpers\getGradeValue;
use function App\Helpers\getStateName;
use function App\Helpers\getDistrictName;
$JAId = base64_decode($_REQUEST['jaid']);

$sql = DB::table('offerletterbasic')
    ->leftJoin('jobapply', 'offerletterbasic.JAId', '=', 'jobapply.JAId')
    ->leftJoin('jobcandidates', 'jobapply.JCId', '=', 'jobcandidates.JCId')
    ->leftJoin('jf_contact_det', 'jobcandidates.JCId', '=', 'jf_contact_det.JCId')
    ->leftJoin('jf_family_det', 'jobcandidates.JCId', '=', 'jf_family_det.JCId')
    ->select('offerletterbasic.*', 'jobcandidates.Title', 'jobcandidates.FName', 'jobcandidates.MName', 'jobcandidates.LName', 'jobcandidates.FatherTitle', 'jobcandidates.FatherName', 'jobcandidates.Gender', 'jobapply.ApplyDate','jf_contact_det.perm_address', 'jf_contact_det.perm_city', 'jf_contact_det.perm_dist', 'jf_contact_det.perm_state', 'jf_contact_det.perm_pin')
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
                    <p style="margin-bottom: 0px;"><b>{{ $sql->FName }} {{ $sql->MName }} {{ $sql->LName }}</b>
                    </p>
                    <b>
                        <p style="margin-bottom: 0px;">{{$sql->perm_address}}</p>
                        <p style="margin-bottom: 0px;">{{$sql->perm_city}},
                            Dist-{{getDistrictName($sql->perm_dist)}},{{getStateName($sql->perm_state)}},
                           {{$sql->perm_pin}}
                        </p>
                    </b><br />
                    <p class="text-center"><b><u>Subject: Offer for Employment</u></b></p>
                    <b>
                        <p>Dear {{ $sql->Title }} {{ $sql->FName }} {{ $sql->MName }} {{ $sql->LName }},</p>
                    </b>
                    <p>We are pleased to offer you the position of <b>{{ getDesignation($sql->Designation) }}</b> at
                        <b>Grade - {{ getGradeValue($sql->Grade) }}</b> in
                        <b>{{ getDepartmentCode($sql->Department) }}</b>
                        Department w.e.f. the date of your joining.
                    </p>
                    <p>This offer is subject to following terms and conditions:</p>
                    <ol>
                        @if ($sql->ServiceCondition == 'Training' && $sql->OrientationPeriod != null && $sql->Stipend != null)
                            <li>You shall join at <strong>{{ getHq($sql->F_LocationHq) }}</strong>
                                <strong>({{ getHqStateCode($sql->F_StateHq) }})</strong>, for an orientation program
                                of
                                {{ $sql->OrientationPeriod }} months. During the
                                period of orientation, you shall receive a consolidated stipend of Rs.
                                {{ $sql->Stipend }}/- per month. After completion of the orientation period, you
                                shall be
                                on a Training period of 12 months and during the period of training, you will be
                                allocated
                                various assignments at different
                                locations.
                            </li>
                        @else
                            @if ($sql->TempS != 1)
                                @if ($sql->Department == 2) {{-- R&D Department --}}
                                    <li>You will be placed at <strong>{{ $sql->F_LocationHq }}</strong>
                                        <strong>({{ getHqStateCode($sql->F_StateHq) }})</strong>, which the Company,
                                        in
                                        its
                                        business interest can change in future.
                                    </li>
                                @else
                                    <li>Your headquarter will be at
                                        <strong>{{ getHq($sql->F_LocationHq) }}</strong>
                                        <strong>({{ getHqStateCode($sql->F_StateHq) }})</strong>, which the Company,
                                        in
                                        its
                                        business interest can change in future.
                                    </li>
                                @endif
                            @else
                                @if ($sql->Department == 2) {{-- R&D Department --}}
                                    @if ($sql->TempS == 1 && $sql->FixedS == 0)
                                        {{-- if temp hq and no permanent --}}
                                        <li>
                                            You shall be placed at <strong>({{ getHq($sql->T_LocationHq) }},
                                                {{ getHqStateCode($sql->T_StateHq) }})</strong> during the initial
                                            training
                                            period. After successful completion of training you will be stationed at any
                                            of
                                            the R&D locations of the company.
                                        </li>
                                    @else
                                        <li>For initial {{ $sql->TempM }} months, your temporary headquarter will be
                                            <strong>{{ getHq($sql->T_LocationHq) }}</strong>
                                            <strong>({{ getHqStateCode($sql->T_StateHq) }})</strong>, and
                                            then you will be placed at
                                            <strong>{{ getHq($sql->F_LocationHq) }}</strong>
                                            <strong>({{ getHqStateCode($sql->F_StateHq) }})</strong>, which the
                                            Company, in
                                            its
                                            business interest can change in future.
                                        </li>
                                    @endif
                                @else
                                    @if ($sql->TempS == 1 && $sql->FixedS == 0)
                                        {{-- if temp hq and no permanent --}}
                                        <li>For initial {{ $sql->TempM }} months, your temporary headquarter will be
                                            <strong>{{ getHq($sql->T_LocationHq) }}</strong>
                                            <strong>({{ getHqStateCode($sql->T_StateHq) }})</strong>, which the
                                            Company, in
                                            its
                                            business interest can change in future.
                                        </li>
                                    @else
                                        <li>For initial {{ $sql->TempM }} months, your temporary headquarter will be
                                            <strong>{{ getHq($sql->T_LocationHq) }}</strong>
                                            <strong>({{ getHqStateCode($sql->T_StateHq) }})</strong>, and
                                            then your permanent headquarter will be
                                            <strong>{{ getHq($sql->F_LocationHq) }}</strong>
                                            <strong>({{ getHqStateCode($sql->F_StateHq) }})</strong>, which the
                                            Company, in
                                            its
                                            business interest can change in future.
                                        </li>
                                    @endif
                                @endif
                            @endif
                        @endif

                        @if ($sql->Functional_R != 0 && $sql->Admins_R != 0)
                            <li>For administrative purpose you shall be reporting to
                                <b>{{ getFullName($sql->A_ReportingManager) }}</b>
                                and for technical purpose you shall be reporting to
                                <b>{{ getFullName($sql->F_ReportingManager) }}</b>
                                and will work under the supervision of such officers as may be decided upon by the
                                Management
                                from time to time.
                            </li>
                        @elseif ($sql->Admins_R ==1 && $sql->Functional_R ==0)
                            <li>You will report to <b>{{ getFullName($sql->A_ReportingManager) }}</b>, and will work
                                under the
                                supervision of such officers as may be decided upon by the management from time to time.
                            </li>
                        @else
                            <li>You will work under the supervision of such officers as may be decided upon by the
                                Management
                                from time to time.</li>
                        @endif


                        @if ($sql->ServiceCondition == 'Training' && $sql->OrientationPeriod != null && $sql->Stipend != null)
                            <li>After completion of the orientation period, you shall be on a Training period of 12
                                months and
                                after completion of the training period you will be confirmed subject to your
                                satisfactory
                                performance during such period.</li>
                        @elseif ($sql->ServiceCondition == 'Training' && $sql->AFT_Grade != 0)
                            <li>You shall be on a Training period of 12 months from the date of your appointment and
                                after
                                completion of the training period and subject to your satisfactory performance you will
                                be
                                confirmed on the post of <b>{{ getDesignation($sql->AFT_Designation) }}</b> at Grade
                                <b>{{ getGradeValue($sql->AFT_Grade) }}</b>.
                            </li>
                        @elseif ($sql->ServiceCondition == 'Training')
                            <li>You shall be on a Training period of 12 months from the date of your appointment and
                                after
                                completion of the training period you will be confirmed subject to your satisfactory
                                performance
                                during such period.</li>

                        @elseif ($sql->ServiceCondition == 'Probation')
                            <li>You shall be on a probationary period of six months from the date of your appointment
                                and after
                                completion of the probationary period you will be confirmed subject to your satisfactory
                                performance during such period.</li>
                        @endif

                        @if ($sql->ServiceBond == 'Yes')
                            <li>At the time of your appointment, you shall sign a service bond providing your consent to
                                serve
                                the company for a minimum period of <b>{{ $sql->ServiceBondYears }} </b>years from
                                your
                                date of appointment. In the event of
                                dishonor of this service bond, you shall be liable to pay the company a sum of
                                <b>{{ $sql->ServiceBondRefund }}</b>% of your
                                annual CTC as per the prevailing CTC rate (as on date of leaving).
                            </li>
                        @endif


                        @if ($sql->Company == 1)
                            {{-- VSPL --}}
                            @if ($sql->Department == 6 || $sql->Department == 3)
                                {{-- PD & Salse Department --}}
                                @if ($sql->ServiceCondition == 'nopnot')
                                    <li>In case of discontinuation of service, you shall serve the notice period of
                                        three months in
                                        advance
                                        or salary in lieu of notice period.</li>
                                @else
                                    <li>In case of discontinuation of service, during the period of
                                        {{ $sql->ServiceCondition }} the
                                        notice period will be
                                        one month and after confirmation of the service the notice period will be of
                                        three months.</li>
                                @endif
                            @elseif ($sql->Department == 2)
                                {{-- R&D Department --}}
                                @if ($sql->ServiceCondition == 'nopnot')
                                    @if ($sql->ctc_date >= '2021-08-06')
                                        <li>In case of discontinuation of service, you shall serve the notice period of
                                            three month in advance or salary in lieu of notice period.</li>
                                    @else
                                        <li>In case of discontinuation of service, you shall serve the notice period of
                                            one month in advance or salary in lieu of notice period.</li>
                                    @endif
                                @else
                                    @if ($sql->ctc_date >= '2021-08-06')
                                        <li>In case of discontinuation of service, during the period of
                                            {{ $sql->ServiceCondition }} and after confirmation, you
                                            shall serve the notice period of three month in advance or salary in lieu of
                                            notice period. </li>
                                    @else
                                        <li>In case of discontinuation of service, during the period of
                                            {{ $sql->ServiceCondition }} and after confirmation, you
                                            shall serve the notice period of one month in advance or salary in lieu of
                                            notice period. </li>
                                    @endif
                                @endif
                            @elseif ($sql->Department == 24)
                                @if ($sql->ServiceCondition == 'nopnot')
                                    @if ($sql->ctc_date >= '2021-08-06')
                                        <li>In case of discontinuation of service, you shall serve the notice period of
                                            three months in advance
                                            or salary in lieu of notice period.</li>
                                    @else
                                        <li>In case of discontinuation of service, you shall serve the notice period of
                                            one month in advance
                                            or salary in lieu of notice period.</li>
                                    @endif
                                @else
                                    @if ($sql->ctc_date >= '2021-08-06')
                                        <li>In case of discontinuation of service, during the period of
                                            {{ $sql->ServiceCondition }} the
                                            notice period will be one month and after confirmation of the service the
                                            notice period will be of
                                            three months. </li>
                                    @else
                                        <li>In case of discontinuation of service, during the period of
                                            {{ $sql->ServiceCondition }} the
                                            notice period will be 15 days and after confirmation of the service the
                                            notice period will be of
                                            one month. </li>
                                    @endif
                                @endif
                            @else
                                @if ($sql->ServiceCondition == 'nopnot')
                                    <!---  All Other Department--->
                                    <li>In case of discontinuation of service, you shall serve the notice period of one
                                        month in advance
                                        or salary in lieu of notice period.</li>
                                @else
                                    <li>In case of discontinuation of service, during the period of
                                        {{ $sql->ServiceCondition }} the
                                        notice period will be 15 days and after confirmation of the service the notice
                                        period will be of
                                        one month. </li>
                                @endif
                            @endif
                        @elseif ($sql->Company==3)
                            {{-- VNPL --}}
                            <li>In case of discontinuation of service, during the period of
                                {{ $sql->ServiceCondition }} the
                                notice period will be one month and after confirmation of the service the notice period
                                will be of
                                two month. </li>
                        @endif

                        @if ($sql->ServiceCondition == 'Training' && $sql->OrientationPeriod != null && $sql->Stipend != null)
                            <li>After completion of your orientation period, your salary (CTC) and entitlements details
                                shall be
                                as mentioned in the Annexures A and B.</li>
                        @else
                            <li>Your salary (CTC) and entitlements details shall be as mentioned in the Annexures A and
                                B.</li>
                        @endif

                        <li>You shall look after all the duties & responsibilities assigned to you from time to time
                            based on business requirement. It may be subject to changes as management deems fit.</li>
                        <li>Your service will be governed by the Company’s service rules and conditions which will be
                            detailed in the appointment letter.</li>
                        <li>The validity of this offer letter and continuation of your service is subject to your being
                            found physically, mentally, and medically fit and remaining so during your service.</li>

                        @if ($sql->PreMedicalCheckUp == 'Yes')

                        @endif
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
                        {{ $sql->FatherTitle }} {{ $sql->FatherName }} have read and understood the above
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
                        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Date&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                        {{ $sql->Title }} {{ $sql->FName }} {{ $sql->MName }} {{ $sql->LName }}
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
                                <td>Basic</td>
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
                            <tr>
                                <td>Employee’s ESIC Contribution </td>
                                <td><input type="text" class="form-control text-center" id="emplyESIC"
                                        style="height: 21px;border: 0px none;" value="{{ $ctc->emplyESIC ?? '' }}"
                                        readonly>
                                </td>
                            </tr>
                            <tr>
                                <th>Net Monthly Salary</th>
                                <td><input type="text" class="form-control text-center font-weight-bold" id="netMonth"
                                        style="height: 21px;border: 0px none;" value="{{ $ctc->netMonth ?? '' }}"
                                        readonly>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center" colspan="2">(B) Annual Components (Tax saving components
                                    which shall
                                    be
                                    reimbursed on production of documents at the end of financial year)</td>
                            </tr>
                            <tr>
                                <td>Leave Travel Allowance</td>
                                <td><input type="text" class="form-control text-center" id="lta"
                                        style="height: 21px;border: 0px none;" value="
                                        <?php if ($ctc->lta == null || $ctc->lta == '') {
                                            echo '0';
                                        } else {
                                            echo $ctc->lta;
                                        } ?>" onchange="calculate()">
                                </td>
                            </tr>
                            <tr>
                                <td>Child Education Allowance</td>
                                <td><input type="text" class="form-control text-center" id="childedu"
                                        style="height: 21px;border: 0px none;" value="
                                        <?php if ($ctc->childedu == null || $ctc->childedu == '') {
                                            echo '0';
                                        } else {
                                            echo $ctc->childedu;
                                        } ?>" onchange="calculate()">
                                </td>
                            </tr>
                            <tr>
                                <th>Annual Gross Salary</th>
                                <td><input type="text" class="form-control text-center font-weight-bold" id="anualgrs"
                                        style="height: 21px;border: 0px none;" value="{{ $ctc->anualgrs ?? '' }}"
                                        readonly>
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
                            <tr>
                                <td>Employer’s ESIC contribution</td>
                                <td><input type="text" class="form-control text-center" id="emplyerESIC"
                                        style="height: 21px;border: 0px none;" value="{{ $ctc->emplyerESIC ?? '' }}"
                                        readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>Insurance Policy Premium </td>
                                <td><input type="text" class="form-control text-center" id="medical"
                                        style="height: 21px;border: 0px none;" value="{{ $ctc->medical ?? '' }}"
                                        readonly>
                                </td>
                            </tr>
                            <tr>
                                <th>Total Cost to Company</th>
                                <td><input type="text" class="form-control text-center font-weight-bold" id="total_ctc"
                                        style="height: 21px;border: 0px none;" value="{{ $ctc->total_ctc ?? '' }}"
                                        readonly>
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
                    <p style="margin-bottom: 0px;"><b>Authorized Signatory,</b><span
                            style="float: right">{{ $sql->Title }} {{ $sql->FName }} {{ $sql->MName }}
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
                            <tr>
                                <td class="text-center">1</td>
                                <td style="width:402px;"><b>Lodging :</b> Actual with upper limits per day as mentioned
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
                            <tr>
                                <td class="text-center">2</td>
                                <td><b>D.A Out Side H.Q</b></td>
                                <td><input type="text" class="form-control text-center" id="DAOut"
                                        style=" height:20px;border: 0px none;" value="{{ $elg->DAOut ?? '' }}">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">3</td>
                                <td><b>D.A @ H.Q</b>

                                </td>
                                <td><input type="text" class="form-control text-center" id="DAHq"
                                        style=" height:20px;border: 0px none;" value="{{ $elg->DAHq ?? '' }}">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">4</td>
                                <td colspan="2"><b>Travel Eligibility (For Official Purpose Only)</b></b></td>

                            </tr>
                            <tr>
                                <td></td>
                                <td style="width:400px;">Two Wheeler </td>
                                <td><input type="text" class="form-control text-center" id="TwoWheel"
                                        style=" height:20px;border: 0px none;" value="{{ $elg->TwoWheel ?? '' }}">
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td style="width:400px;">Four Wheeler </td>
                                <td><input type="text" class="form-control text-center" id="FourWheel"
                                        style=" height:20px;border: 0px none;" value="{{ $elg->FourWheel ?? '' }}">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">5</td>
                                <td><b>Mode of Travel outside HQ</b></b></td>
                                <td>
                                    <select id="TravelMode" name="TravelMode" class="frminp"
                                        style=" height:20px;border: 0px none;">
                                        <option disabled selected>Select Travel Mode</option>
                                        <option value="Bus/Train">Bus/Train</option>
                                        <option value="Flight">Flight</option>
                                    </select>
                                    <script>
                                        $('#TravelMode').val('{{ $elg->TravelMode ?? '' }}');
                                    </script>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">6</td>
                                <td><b>Travel Class</b></b></td>
                                <td>
                                    <select id="TravelClass" name="TravelClass" class="frminp"
                                        style="height:20px;border:0px none;">
                                        <option disabled selected> Select Travel Class</option>

                                        <option value="Sleeper">Sleeper</option>
                                        <option value="3 AC">3 AC</option>
                                        <option value="2 AC">2 AC</option>
                                        <option value="First Class">First Class</option>
                                        <option value="Economy">Economy</option>
                                        <option value="Business">Business</option>
                                    </select>
                                    <script>
                                        $('#TravelClass').val('{{ $elg->TravelClass ?? '' }}');
                                    </script>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center"></td>
                                <td>Flight</td>
                                <td>
                                    <input type="checkbox" id="flight_approval_based" name="flight_approval_based"
                                        class="flight" data-value="flight_approval_based"
                                        @if ($elg->Flight == 'flight_approval_based') checked @endif>Flight Approval Based
                                    <br />
                                    <input type="checkbox" id="flight_need_based" name="flight_need_based"
                                        class="flight" data-value="flight_need_based"
                                        @if ($elg->Flight == 'flight_need_based') checked @endif>Flight Need Based
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">7</td>
                                <td><b>Mobile Handset Eligibility</b></b></td>
                                <td><input type="text" class="form-control text-center d-inline" id="Mobile"
                                        style=" height:20px;border: 0px none; width:90px;"
                                        value="{{ $elg->Mobile ?? '' }}"> <input type="checkbox" id="GPRS"
                                        name="GPRS" @if ($elg->GPRS == '1') checked @endif>GPRS
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">8</td>
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
                            <tr>
                                <td class="text-center">9</td>
                                <td><b>Laptop Purchase Eligibility (if applicable)</b></b></td>
                                <td><input type="text" class="form-control text-center" id="Laptop"
                                        style=" height:20px;border: 0px none;" value="{{ $elg->Laptop ?? '' }}">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">10</td>
                                <td><b>Health Insurance</b></b></td>
                                <td>
                                    <input type="text" class="form-control text-center d-none" id="HealthIns1"
                                        style=" height:20px;border: 0px none;" value="">
                                    <select id="HealthIns" name="HealthIns" class="frminp" style="width:100px;">
                                        <option value="" selected>Select</option>
                                        <?php
                                        for ($i = 1; $i <= 10; $i++) {
                                            echo '<option value=' . $i . '>' . $i . '</option>';
                                        }
                                        ?>
                                    </select> Lakh
                                    <script>
                                        $('#HealthIns').val('{{ $elg->HealthIns ?? '' }}');
                                    </script>
                                </td>
                            </tr>
                            </tr>
                            <tr>
                                <td class="text-center">11</td>
                                <td><b>Group Personal Accident Insurance</b></b></td>
                                <td>
                                    <?php
                                    if ($sql->Grade == 61 || $sql->Grade == 62) {
                                        echo '05 Lakhs';
                                    } elseif ($sql->Grade == 63 || $sql->Grade == 64 || $sql->Grade == 65 || $sql->Grade == 66) {
                                        echo '10 Lakhs';
                                    } elseif ($sql->Grade == 67 || $sql->Grade == 68 || $sql->Grade == 69 || $sql->Grade == 70 || $sql->Grade == 71) {
                                        echo '25 Lakhs';
                                    } elseif ($sql->Grade == 72 || $sql->Grade == 73 || $sql->Grade == 74 || $sql->Grade == 75 || $sql->Grade == 76) {
                                        echo '50 Lakhs';
                                    }
                                    ?>
                                </td>
                            </tr>


                        </table>
                        <p style="margin-bottom:0px;"><input type="checkbox" id="two_wheel_line" name="two_wheel_line"
                                @if ($elg->TwoWheelLine == '1') checked @endif>
                            * 2 Wheeler vehicle eligibility.</p>
                        <p style="margin-bottom:0px;"><input type="checkbox" id="four_wheel_line" name="four_wheel_line"
                                @if ($elg->FourWheelLine == '1') checked @endif> * 4 Wheeler vehicle eligibility.</p>

                        <p style="margin-bottom:0px;"><input type="checkbox" id="tline" name="tline"
                                @if ($elg->TravelLine == '1') checked @endif> * Maximum travel
                            km per month
                            allowed for 4 wheeler is 2000
                            km/month and overall travel including both 4 wheeler & 2 wheeler should not exceed more than
                            3000
                            km/month.</p><br><br>
                    </form>
                    <script>
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

                        $(document).on('click', '.flight', function() {
                            var x = '';
                            var flight = $(this).data('value');
                            if ($(this).prop("checked") == true) {
                                if (flight == 'flight_approval_based') {
                                    x = 'flight_approval_based';
                                } else {
                                    x = 'flight_need_based';
                                }
                            } else {
                                x = '';
                            }

                        });

                        $('#tline').val('{{ $elg->TravelLine }}');
                        $('#two_wheel_line').val('{{ $elg->TwoWheelLine }}');
                        $('#four_wheel_line').val('{{ $elg->FourWheelLine }}');
                        $('#GPRS').val('{{ $elg->GPRS }}');
                    </script>

                    <p class="text-center"><b><u>LIST OF DOCUMENTS REQUIRED DURING APPOINTMENT</u></b></p>
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
                    </ol>
                    <br><br><br><br>
                    <p style="margin-bottom:2px;">----------------------------<span
                            style="float: right">----------------------------</span></p>
                    <p style="margin-bottom: 0px;"><b>Authorized Signatory,</b><span
                            style="float: right">{{ $sql->Title }} {{ $sql->FName }} {{ $sql->MName }}
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
                <button id="print" class="btn btn-info btn-md text-center text-light"
                    onclick="printLtr('{{ route('offer_ltr_print') }}?jaid={{ $JAId }}');"> <i
                        class="fa fa-print"></i> Print</button>
            </center>
        </div>
    </div>

    <script src="{{ URL::to('/') }}/assets/js/bootstrap.bundle.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/js/sweetalert2.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/js/toastr.min.js"></script>
    <script>
        function calculate() {

            var basic = $('#basic').val();
            var hra = $('#hra').val();
            var bonus = $('#bonus').val();
            var special_alw = $('#special_alw').val();

            if (isNaN(basic) || basic == '') {
                basic = 0;
            }
            if (isNaN(hra) || hra == '') {
                hra = 0;
            }
            if (isNaN(bonus) || bonus == '') {
                bonus = 0;
            }
            if (isNaN(special_alw) || special_alw == '') {
                special_alw = 0;
            }

            var grsM_salary = Math.round(parseFloat(basic) + parseFloat(hra) + parseFloat(bonus) + parseFloat(special_alw));
            $('#grsM_salary').val(grsM_salary);

            var emplyPF = Math.round(parseFloat(basic * 12 / 100));
            $('#emplyPF').val(emplyPF);
            var emplyESIC = 0;
            if (grsM_salary > 21000) {
                $('#emplyESIC').val(0).attr('disabled', true);
            } else {
                var emplyESIC = Math.round(parseFloat(grsM_salary * 0.75 / 100));
                $('#emplyESIC').val(emplyESIC).attr('disabled', false);
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
                $('#medical').val(10000).attr('disabled', true);
                $('#emplyerESIC').val(0).attr('disabled', true);
            } else {

                $('#medical').val(0).attr('disabled', false);
                $('#emplyerESIC').val(Math.round(parseFloat(anualgrs * 3.25 / 100))).attr('disabled', true);
            }

            var total_ctc = Math.round(parseFloat(anualgrs) + parseFloat(gratuity) + parseFloat(emplyerPF) + parseFloat($(
                    '#emplyerESIC').val()) +
                parseFloat($('#medical').val()));
            $('#total_ctc').val(total_ctc);
        }

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
                var x = '';
                $('.flight').each(function(k, v) {
                    if ($(this).prop("checked") == true) {
                        x = $(this).data('value');
                    }
                });
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
                    TravelMode: $('#TravelMode').val(),
                    TravelClass: $('#TravelClass').val(),
                    Mobile: $('#Mobile').val(),
                    MExpense: $('#MExpense').val(),
                    MTerm: $('#MTerm').val(),
                    Laptop: $('#Laptop').val(),
                    HealthIns: $('#HealthIns').val(),
                    tline: $('#tline').val(),
                    two_wheel_line: $('#two_wheel_line').val(),
                    four_wheel_line: $('#four_wheel_line').val(),
                    GPRS: $('#GPRS').val(),
                    flight: x,

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

        function printLtr(url) {
            $("<iframe>") // create a new iframe element
                .hide() // make it invisible
                .attr("src", url) // point the iframe to the page you want to print
                .appendTo("body");
        }
    </script>
</body>

</html>
