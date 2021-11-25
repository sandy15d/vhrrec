<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ URL::to('/') }}/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/css/sweetalert2.min.css" />
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/css/toastr.min.css" />
    <script src="{{ URL::to('/') }}/assets/js/jquery.min.js"></script>
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
$JAId = base64_decode($_REQUEST['jaid']);

$sql = DB::table('offerletterbasic')
    ->leftJoin('jobapply', 'offerletterbasic.JAId', '=', 'jobapply.JAId')
    ->leftJoin('jobcandidates', 'jobapply.JCId', '=', 'jobcandidates.JCId')
    ->leftJoin('jf_contact_det', 'jobcandidates.JCId', '=', 'jf_contact_det.JCId')
    ->leftJoin('jf_family_det', 'jobcandidates.JCId', '=', 'jf_family_det.JCId')
    ->select('offerletterbasic.*', 'jobcandidates.Title', 'jobcandidates.FName', 'jobcandidates.MName', 'jobcandidates.LName', 'jobcandidates.FatherTitle', 'jobcandidates.FatherName', 'jobcandidates.Gender', 'jobapply.ApplyDate')
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
                        <p style="margin-bottom: 0px;">Ward No 8, Near Old Gram Panchayat Bhawan</p>
                        <p style="margin-bottom: 0px;">Baloda,
                            Dist-Janjgir-Champa,Chhattisgarh,
                            495559
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

        <div class="generate" id="generate">
            <center>
                <button type="button" class="btn btn-success btn-md text-center " id="generateLtr">
                    <span class="fa fa-list-alt"></span>
                    Generate Letter
                </button>
            </center>
        </div>
    </div>



    <script src="{{ URL::to('/') }}/assets/js/bootstrap.bundle.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/js/sweetalert2.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/js/toastr.min.js"></script>
    <script>
        $(document).on('click', '#generateLtr', function() {
            window.opener.location.reload(true);
        });
    </script>
</body>

</html>
