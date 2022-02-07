<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ URL::to('/') }}/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/css/sweetalert2.min.css" />
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/css/toastr.min.css" />
    <script src="{{ URL::to('/') }}/assets/js/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/b0b5b1cf9f.js" crossorigin="anonymous"></script>
    <title>Appointment Letter Generation</title>
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
use function App\Helpers\getCompanyName;
use function App\Helpers\getFullName;
use function App\Helpers\getGradeValue;
use function App\Helpers\getStateName;
use function App\Helpers\getDistrictName;

$JAId = base64_decode($_REQUEST['jaid']);

$sql = DB::table('jobapply')
    ->leftJoin('appointing', 'appointing.JAId', '=', 'jobapply.JAId')
    ->leftJoin('offerletterbasic', 'offerletterbasic.JAId', '=', 'jobapply.JAId')
    ->leftJoin('jobcandidates', 'jobapply.JCId', '=', 'jobcandidates.JCId')
    ->leftJoin('candjoining', 'jobapply.JAId', '=', 'candjoining.JAId')
    ->leftJoin('jf_contact_det', 'jobcandidates.JCId', '=', 'jf_contact_det.JCId')
    ->leftJoin('jf_family_det', 'jobcandidates.JCId', '=', 'jf_family_det.JCId')
    ->select('appointing.*', 'offerletterbasic.*', 'candjoining.JoinOnDt', 'jobcandidates.Title', 'jobcandidates.FName', 'jobcandidates.MName', 'jobcandidates.LName', 'jobcandidates.FatherTitle', 'jobcandidates.FatherName', 'jobcandidates.Gender', 'jf_contact_det.perm_address', 'jf_contact_det.perm_city', 'jf_contact_det.perm_dist', 'jf_contact_det.perm_state', 'jf_contact_det.perm_pin')
    ->where('jobapply.JAId', $JAId)
    ->first();

@endphp

<body>
    <div class="container">
        <input type="hidden" name="jaid" id="jaid" value="{{ $JAId }}">
        <input type="hidden" name="ltrno" id="ltrno"
            value="{{ getCompanyCode($sql->Company) . '_AL/' . getDepartmentCode($sql->Department) . '/' . date('M-Y', strtotime($sql->JoinOnDt)) . '/' . $JAId }}">

        <div id="appointment_ltr">
            <div class="page">
                <div class="subpage ml-3">

                    <p style="margin-bottom:100px;"></p>
                    <p class="text-center "><b><u> APPOINTMENT LETTER</u></b></p>
                    <p style="font-size:16px;"><b>Ref:
                            {{ getCompanyCode($sql->Company) . '_AL/' . getDepartmentCode($sql->Department) . '/' . date('M-Y', strtotime($sql->JoinOnDt)) . '/' . $JAId }}</b>
                        <span style="float:right"><b>Date:{{ date('d-m-Y', strtotime($sql->A_Date)) }}</span></b>
                    </p>

                    <br>
                    <p><b>To,</b></p>
                    <p style="margin-bottom: 0px;" class="fw-bold">{{ $sql->FName }} {{ $sql->MName }}
                        {{ $sql->LName }}</p>
                    <b>
                        <p style="margin-bottom: 0px;">{{ $sql->perm_address }}, {{ $sql->perm_city }},
                        </p>
                    </b>
                    <b>
                        <p style="margin-bottom: 0px;">
                            Dist-{{ getDistrictName($sql->perm_dist) }},{{ getStateName($sql->perm_state) }},
                            {{ $sql->perm_pin }}
                        </p>
                    </b>
                    <br>

                    <br>
                    <p style="text-align:justify">We are pleased to appoint you on the post of
                        <b>{{ getDesignation($sql->Designation) }}</b> at
                        <b>Grade-{{ getGradeValue($sql->Grade) }}</b> in
                        <b>{{ getDepartmentCode($sql->Department) }}</b> Department w.e.f.
                        <b><?= date('d-M-Y', strtotime($sql->JoinOnDt)) ?></b>.
                        @if ($sql->TempS == 1 && $sql->FixedS == 1)
                            For initial few months, your temporary headquarter will be
                            <strong>{{ getHQ($sql->T_LocationHq) }}</strong>
                            <strong>({{ getHqStateCode($sql->T_StateHq) }})</strong>, and
                            then you will be placed at <strong>{{ getHQ($sql->F_LocationHq) }}</strong>
                            <strong>({{ getHqStateCode($sql->F_StateHq) }})</strong>,
                        @elseif ($sql->TempS == 1)
                            with place of posting being <strong>{{ getHQ($sql->T_LocationHq) }}
                                ({{ getHqStateCode($sql->T_StateHq) }})</strong>.
                        @else
                            with place of posting being <strong>{{ getHQ($sql->F_LocationHq) }}
                                ({{ getHqStateCode($sql->F_StateHq) }})</strong>.
                        @endif

                    </p>
                    <br>
                    <p style="text-align:justify">Your compensation as CTC will be <b>Rs. {{ $sql->CTC }} /- per
                            annum.</b>
                        Please note that the
                        salaries, allowances, facilities and other sums payable under this appointment are subject to
                        the
                        application of Income Tax and you shall be liable for the same.</p>

                    <br>
                    <p style="text-align:justify">Please note that the Management views the compensation offered to you
                        as an
                        extremely confidential matter and any leakage of the same shall be viewed as a serious breach of
                        this confidence and conditions of employment at your level.</p>
                    <br>
                    <p style="text-align:justify">Please sign and return a copy of this letter as a token of your
                        acceptance
                        of
                        the “Terms and Conditions of Employment” and return it to HR.</p>
                    <br>
                    <p style="text-align:justify">We wish you a long and successful association with
                        {{ getCompanyName($sql->Company) }}
                    </p>
                    <br><br>

                    <p>Yours Faithfully,</p>
                    <br>
                    <p style="margin-bottom: 100px;"><b>For, {{ getCompanyName($sql->Company) }}</b></p>

                    <p style="margin-bottom:2px;">----------------------------<span
                            style="float:right">----------------------------</span></p>
                    <p style="margin-bottom: 0px;"><b>Authorized Signatory,</b><span style="float:right">
                            {{ $sql->FName }} {{ $sql->MName }} {{ $sql->LName }}
                        </span></p>
                    <p><b>{{ $sql->SigningAuth }}</b>
                    </p>
                    <br><br><br>
                    <b>Enclosed: Terms & conditions of Employment</b>
                </div>
            </div>
        </div>

        <div id="terms_con">
            <div class="page">

                <div class="subpage">
                    <p style="font-size:16px;"><b>Ref:
                            {{ getCompanyCode($sql->Company) . '_AL/' . getDepartmentCode($sql->Department) . '/' . date('M-Y', strtotime($sql->JoinOnDt)) . '/' . $JAId }}</b>
                        <span style="float: right"><b>Date: {{ date('d-m-Y', strtotime($sql->A_Date)) }} </span></b>
                    </p><br>

                    <b>
                        <p class="text-center"><u>TERMS AND CONDITIONS OF EMPLOYMENT</u></p>
                    </b>
                    <ol>

                        @if ($sql->ServiceCondition == 'Training')
                            <li>You shall be on Training for a period of 12 months from the date of your joining.
                                The above training period may be extended for another 3 months at the discretion of the
                                Management.
                            </li>
                        @elseif ($sql->ServiceCondition == 'Probation')
                            <li>You shall be on Probation for a period of 06 months from the date of your joining.
                                The above probation period may be extended for another 3 months at the discretion of the
                                Management.
                            </li>
                        @endif


                        @if ($sql->ServiceCondition == 'Training' || $sql->ServiceCondition == 'Probation')
                            <li>On expiry of the above {{ $sql->ServiceCondition }} period or extension thereof
                                unless you are confirmed in writing, you will be deemed to be as such.</li>

                            <li>While on {{ $sql->ServiceCondition }} you will be entitled to a salary and
                                entitlements as explained in Annexure A & B as provided with your offer letter.</li>

                        @else
                            <li>You will be entitled to a salary and entitlements as explained in Annexure A & B as
                                provided with your offer letter.</li>

                        @endif


                        @if ($sql->ServiceCondition == 'Training' || $sql->ServiceCondition == 'Probation')
                            <li>While on {{ $sql->ServiceCondition }} you will perform your duties assigned to you,
                                including any other work assigned by the superiors. Your performance will be under
                                review and assessment by the management, and if management is not satisfied with your
                                ability or performance, your service is liable to be terminated without notice and
                                without assigning any reason.<br>
                                @if ($sql->Department == 6 || $sql->Department == 3)
                                    In case of discontinuation of service during the period of
                                    <?= $sql->ServiceCondition ?>
                                    at your end you shall give 1 month notice or shall pay 1 month’s wages in lieu of
                                    notice. However, the management may terminate your service during
                                    <?= $sql->ServiceCondition ?> period immediately without any notice at any point of
                                    time without assigning any reason. After confirmation, the employment can end
                                    through a 3 month notice or payment of 3month wages in lieu thereof from either
                                    side.
                                @elseif ($sql->Department == 2)
                                    @if ($sql->A_Date >= '2021-08-06')
                                        In case of discontinuation of service at your end you shall give 3-month notice
                                        or shall pay 3 month’s wages in lieu of notice. However, the management may
                                        terminate your service during {{ $sql->ServiceCondition }} period immediately
                                        without any notice at any point of time without assigning any reason. After
                                        confirmation, the employment can end through a 3 month notice or payment of 3
                                        month wages in lieu thereof from either side.
                                    @else
                                        In case of discontinuation of service at your end you shall give 1-month notice
                                        or shall pay 1 month’s wages in lieu of notice. However, the management may
                                        terminate your service during <?= $sql->ServiceCondition ?> period immediately
                                        without any notice at any point of time without assigning any reason. After
                                        confirmation, the employment can end through a 1 month notice or payment of 1
                                        month wages in lieu thereof from either side.
                                    @endif

                                @elseif ($sql->Department == 24)

                                    @if ($sql->A_Date >= '2021-08-18')
                                        In case of discontinuation of service during the period of
                                        {{ $sql->ServiceCondition }}
                                        at your end you shall give 15 days’ notice or shall pay 3 month wages in lieu of
                                        notice.
                                        However, the management may terminate your service during
                                        {{ $sql->ServiceCondition }} period
                                        immediately without any notice at any point of time without assigning any
                                        reason. After confirmation,
                                        the employment can end through a 3 month notice or payment of 3 month wages in
                                        lieu thereof from
                                        either side.
                                    @else
                                        In case of discontinuation of service during the period of
                                        {{ $sql->ServiceCondition }} at your end you
                                        shall give 15 days’ notice or shall pay 15 days wages in lieu of notice.
                                        However,
                                        the management may terminate your service during {{ $sql->ServiceCondition }}
                                        period immediately without any
                                        notice at any point of time without assigning any reason. After confirmation,
                                        the employment can end through a 1 month notice or payment of 1 month wages in
                                        lieu thereof from
                                        either side.
                                    @endif

                                @else
                                    In case of discontinuation of service during the period of
                                    <?= $sql->ServiceCondition ?>
                                    at
                                    your end you
                                    shall give 15 days’ notice or shall pay 15 days wages in lieu of notice. However,
                                    the
                                    management
                                    may terminate your service during {{ $sql->ServiceCondition }} period immediately
                                    without any
                                    notice at any point of time without assigning any reason. After confirmation, the
                                    employment
                                    can
                                    end through a 1 month notice or payment of 1 month wages in lieu thereof from either
                                    side.
                                @endif

                            </li>
                        @else

                            <li>You will perform your duties assigned to you,
                                including any other work assigned by the superiors. Your performance will be under
                                review
                                and
                                assessment by the management, and if management is not satisfied with your ability or
                                performance, your service is liable to be terminated without notice and without
                                assigning
                                any
                                reason.<br>
                                In case of discontinuation of service the employment can
                                end through a 1 month notice or payment of 1 month wages in lieu thereof from either
                                side.
                            </li>
                        @endif


                        @if ($sql->ServiceBond == 'Yes')
                            <li>
                                <p>You shall sign and submit a service bond for continuation of your service at you own
                                    free
                                    will,discretion and judgement and agrees to serve the Company continuously for a
                                    minimum
                                    period of {{ $sql->ServiceBondYears }} years from the date of your appointment
                                    with
                                    the
                                    Company
                                    and shall not leave the services of the company before successful completion of the
                                    said
                                    period.</p>

                                <p> If you leave the employement of the Company or brings about any situation as
                                    compelling
                                    the Company to terminate your service during the validity of the Service period, you
                                    unconditionally agree to pay, on demand, to the Company a sum of
                                    {{ $sql->ServiceBondRefund }}% of annual CTC as per the prevailing CTC rate(on
                                    date
                                    of leaving).</p>
                                @if ($sql->A_Date >= '2021-10-18')
                                    <p>The Service Bond shall be furnished by you within the same day & date of your
                                        appointment. In case of failure to do so, your appointment under this agreement
                                        shall
                                        come to an end on the 7th Day from the date of your appointment.</p>
                                @else
                                    <p>The Service Bond shall be furnished by you within 15 days from the date of your
                                        appointment. In case of failure to do so, your appointment under this agreement
                                        shall
                                        come to an end on the 30th Day from the date of your appointment.</p>
                                @endif
                            </li>
                        @endif

                        <li>As per the business requirements at the discretion of management, you may be transferred to
                            any
                            other section or department in the same establishment or you may be transferred to any other
                            establishment either in existence or would come into existence under any management anywhere
                            in
                            the country without any additional benefits. While in service at the transferred place you
                            will
                            be governed by the rules applicable at the transferred place.</li>


                        @if ($sql->ServiceCondition == 'Training' || $sql->ServiceCondition == 'Probation')
                            <li>On satisfactory completion of your <?= $sql->ServiceCondition ?> you may be placed in
                                the
                                proper grade or
                                designation and may be confirmed in writing, if found suitable. <br>
                                You may also be sent on deputation to any other organization under the same management
                                or
                                under
                                different management anywhere in the country.
                            </li>
                        @else
                            <li>You may also be sent on deputation to any other organization under the same management
                                or
                                under
                                different management anywhere in the country.
                            </li>
                        @endif


                        <li>The terms & conditions of the employment & agreement shall be applicable to you. You will
                            also
                            be governed by the service rules/standing order/companies rules/regulations & policies
                            applicable to you during the period of service.</li>
                        <li>On cessation of your employment for any reason whatsoever, you will hand over each property
                            or
                            article or document entrusted to you by the company during the course of employment.</li>
                        <li>"Superannuation/Retirement: You will be superannuated / retire from the services of the
                            company
                            on attaining the age of 60 years as determined by the company policy, unless and otherwise
                            extended by the company."</li>
                    </ol>

                    <p><b>For, {{ getCompanyName($sql->Company) }}</b></p>
                    <br>
                    <p style="margin-bottom:0.5px;">----------------------------<span></p>
                    <p style="margin-bottom: 0px;"><b>Authorized Signatory,</b></p>
                    <p><b><?= $sql->SigningAuth ?> </b>



                    <p class="text-justify">I, <b> {{ $sql->FName }} {{ $sql->MName }} {{ $sql->LName }},
                            S/D/o.
                            <b> {{ $sql->FatherName }}</b> have
                            read and understand the terms and conditions of employment and i accept them fully.</p><br>
                    <div class="row">
                        <div class="col text-center">--------------- <p>Location</p>
                        </div>
                        <div class="col text-center">---------------<p>Date</p>
                        </div>
                        <div class="col text-center">---------------<p>{{ $sql->Title }} {{ $sql->FName }}
                                {{ $sql->MName }} {{ $sql->LName }}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="generate" id="generate">
            <center>
                @if ($sql->AppLtrGen == 'No' || $sql->AppLtrGen == '' || $sql->AppLtrGen == null)
                    <button type="button" class="btn  btn-md text-center btn-success" id="generateLtr"><i
                            class="fa fa-file"></i> Generate Letter</button>
                @endif

                <button id="print" class="btn btn-info btn-md text-center text-light"
                    onclick="printLtr('{{ route('appointment_ltr_print') }}?jaid={{ $JAId }}');"> <i
                        class="fa fa-print"></i> Print</button>
            </center>
        </div>
    </div>

    <script src="{{ URL::to('/') }}/assets/js/bootstrap.bundle.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/js/sweetalert2.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/js/toastr.min.js"></script>
    <script>
        $(document).on('click', '#generateLtr', function() {
            var JAId = $("#jaid").val();
            var ltrno = $("#ltrno").val();
            var url = '<?= route('appointment_letter_generate') ?>';
            swal.fire({
                title: 'Are you sure?',
                html: 'Generate Appointment Letter',
                showCancelButton: true,
                showCloseButton: true,
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Yes',
                cancelButtonColor: '#d33',
                confirmButtonColor: '#556ee6',
                width: 400,
                allowOutsideClick: false

            }).then(function(result) {
                if (result.value) {
                    $.post(url, {
                        "_token": "{{ csrf_token() }}",
                        JAId: JAId,
                        ltrno: ltrno
                    }, function(data) {
                        if (data.status == 200) {

                            toastr.success(data.msg);

                        } else {
                            toastr.error(data.msg);
                        }
                    }, 'json');
                }
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
