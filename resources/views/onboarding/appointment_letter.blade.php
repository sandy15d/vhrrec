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
            width: 230mm;
            height: 100%;
            margin: 0 auto;
            padding: 0;
            font: 12pt "Tahoma";
            background: rgb(204, 204, 204);
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
            padding: 1cm;
            /*  height: 297mm; */
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
use function App\Helpers\getDepartment;
use function App\Helpers\getCompanyCode;
use function App\Helpers\getCompanyName;
use function App\Helpers\getFullName;
use function App\Helpers\getGradeValue;
use function App\Helpers\getStateName;
use function App\Helpers\getDistrictName;
use function App\Helpers\getEmployeeDesignation;

$JAId = base64_decode($_REQUEST['jaid']);

$sql = DB::table('jobapply')
    ->leftJoin('appointing', 'appointing.JAId', '=', 'jobapply.JAId')
    ->leftJoin('offerletterbasic', 'offerletterbasic.JAId', '=', 'jobapply.JAId')
    ->leftJoin('jobcandidates', 'jobapply.JCId', '=', 'jobcandidates.JCId')
    ->leftJoin('candjoining', 'jobapply.JAId', '=', 'candjoining.JAId')
    ->leftJoin('jf_contact_det', 'jobcandidates.JCId', '=', 'jf_contact_det.JCId')
    ->leftJoin('jf_family_det', 'jobcandidates.JCId', '=', 'jf_family_det.JCId')
    ->select('appointing.*', 'offerletterbasic.*', 'candjoining.JoinOnDt', 'jobcandidates.Title', 'jobcandidates.FName', 'jobcandidates.MName', 'jobcandidates.LName', 'jobcandidates.FatherTitle', 'jobcandidates.FatherName', 'jobcandidates.Gender', 'jobcandidates.MaritalStatus', 'jobcandidates.SpouseName', 'jf_contact_det.perm_address', 'jf_contact_det.perm_city', 'jf_contact_det.perm_dist', 'jf_contact_det.perm_state', 'jf_contact_det.perm_pin')
    ->where('jobapply.JAId', $JAId)
    ->first();

@endphp

<body>
    <div class="container">
        <input type="hidden" name="jaid" id="jaid" value="{{ $JAId }}">
        <input type="hidden" name="ltrno" id="ltrno"
            value="{{ getCompanyCode($sql->Company) .'_AL/' .getDepartmentCode($sql->Department) .'/' .date('M-Y', strtotime($sql->JoinOnDt)) .'/' .$JAId }}">

        <div id="appointment_ltr">
            <div class="page">
                <div class="subpage ml-3">

                    <p style="margin-bottom:100px;"></p>
                    <p class="text-center "><b><u> APPOINTMENT LETTER</u></b></p>
                    <p style="font-size:16px;"><b>Ref:
                            {{ getCompanyCode($sql->Company) .'_AL/' .getDepartmentCode($sql->Department) .'/' .date('M-Y', strtotime($sql->JoinOnDt)) .'/' .$JAId }}</b>
                        <span style="float:right"><b>Date:{{ date('d-m-Y', strtotime($sql->A_Date)) }}</span></b>
                    </p>

                    <br>
                    <p><b>To,</b></p>
                    <b>
                        <p style="margin-bottom: 0px;"> {{ $sql->Title }} {{ $sql->FName }} {{ $sql->MName }}
                            {{ $sql->LName }}</p>
                    </b>
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



                    <p style="text-align:justify">We take pleasure in appointing you as
                        <b>{{ getDesignation($sql->Designation) }}</b> at
                        <b>Grade-{{ getGradeValue($sql->Grade) }}</b> at {{ getCompanyName($sql->Company) }}
                        (<strong>"Company"</strong>). The said appointment shall be governed by the terms and
                        conditions, specified
                        hereinbelow, apart from other service rules and conditions that are applicable or may become
                        applicable from time to time, at the sole discretion of the Company.
                    </p>

                    <ul style="list-style-type:square">
                        <li>
                            <strong>Commencement of Service:</strong> The date of your appointment will be
                            {{ date('d-m-Y', strtotime($sql->JoinOnDt)) }} ("<strong>Appointment Date</strong>").
                        </li>

                        <li>

                            @if ($sql->ServiceCondition == 'Training' && $sql->OrientationPeriod != null && $sql->Stipend != null)
                                <p><strong>Place of Posting:</strong> You shall report at
                                    <strong>{{ getHq($sql->F_LocationHq) }}({{ getHqStateCode($sql->F_StateHq) }})</strong>,
                                    for an orientation program of {{ $sql->OrientationPeriod }} months.
                                </p>
                                <p>After completion of the orientation period, you shall be on a Training period of 12
                                    months and during the period of training, you may be allocated various assignments
                                    at different locations. </p>
                                <p>However, you may be required to (i) relocate to other locations in India; and/or (ii)
                                    undertake such travel in India, (iii) overseas locations, from time to time, as may
                                    be necessary in the interests of the Company's business.</p>
                            @elseif($sql->TempS == 1 && $sql->FixedS == 1)
                                <p><strong>Place of Posting:</strong> For initial {{ $sql->TempM }} months, your
                                    temporary headquarter will be
                                    <strong>{{ getHq($sql->T_LocationHq) }}({{ getHqStateCode($sql->T_StateHq) }})</strong>
                                    and then
                                    your principal place of employment shall be at
                                    <strong>{{ getHq($sql->F_LocationHq) }}({{ getHqStateCode($sql->F_StateHq) }})</strong>.
                                    However, you may be
                                    required to (i) relocate to other locations in India; and/or (ii) undertake such
                                    travel in India, (iii) overseas locations, from time to time, as may be necessary in
                                    the interests of the Company's business.
                                </p>
                            @else
                                <p><strong>Place of Posting:</strong> Your principal place of employment shall be at
                                    <strong>{{ getHq($sql->F_LocationHq) }}({{ getHqStateCode($sql->F_StateHq) }})</strong>.
                                    However, you may be required
                                    to (i) relocate to other locations in India; and/or (ii) undertake such travel in
                                    India, (iii) or overseas, from time to time, as may be necessary in the interests of
                                    the Company's business.
                                </p>
                            @endif
                        </li>
                        <li>
                            <strong>Relevant documents:</strong> Your appointment and continuance in service with the
                            Company is subject to submission of documents as mentioned in the offer letter, by your
                            Appointment Date.
                        </li>

                        <li>
                            <strong>Reporting / Duties and responsibilities:</strong>
                            <ol type="a">
                                <li>Currently, you will report to
                                    <strong>{{ getEmployeeDesignation($sql->A_ReportingManager) }}</strong>
                                    (<strong>“Manager”</strong>) or such
                                    other person as may be suggested by the Company, from time to time.
                                </li>
                                <li>You will perform all the duties & responsibilities assigned to you from time to
                                    time based on business requirement of the Company or any other incidental work, if
                                    required by your Manger or other superiors at the Company. It may be subject to
                                    changes at the sole discretion of the Company.</li>
                            </ol>
                        </li>
                        @if ($sql->ServiceBond == 'Yes')
                            <li>
                                <strong>Service Bond:</strong> You shall sign and submit a service bond for continuation
                                of
                                your service at your own free will, discretion and judgement and agree to serve the
                                Company
                                continuously for a minimum period of<b>{{ $sql->ServiceBondYears }} </b> years from
                                the Appointment Date (<strong>“Bond
                                    Period”</strong>) and shall not leave the services of the Company prior to the
                                expiry of the Bond
                                Period.
                            </li>
                        @endif
                        @if ($sql->ServiceCondition == 'Probation' || $sql->ServiceCondition == 'Training')
                            <li>
                                <strong>Probation / Training Period: </strong>
                                <ol type="a">
                                    <li>
                                        You will be on {{ $sql->ServiceCondition }} for a period of
                                        {{ $sql->ServiceCondition == 'Probation' ? '6 (Six)' : '12 (Twelve)' }}
                                        months
                                        from the Appointment Date (<strong>“Probation Date”</strong>) which maybe either
                                        extended or may
                                        be
                                        dispensed, at the sole discretion of the Company. Unless confirmed in writing,
                                        you
                                        will be deemed as a
                                        {{ $sql->ServiceCondition == 'Probation' ? 'probationer' : 'trainee' }} after
                                        expiry of the initial or
                                        extended
                                        {{ $sql->ServiceCondition }} Period.
                                    </li>
                                    <li>
                                        Upon satisfactory completion of the {{ $sql->ServiceCondition }} Period and a
                                        subsequent
                                        performance
                                        evaluation, your position may be confirmed or extended at the sole discretion of
                                        the
                                        Company.
                                    </li>
                                    <li>
                                        Based on your performance during the {{ $sql->ServiceCondition }} Period, the
                                        Company reserves the
                                        right to reduce/dispense with or extend the {{ $sql->ServiceCondition }}
                                        Period at its sole
                                        discretion
                                        or terminate your services with immediate effect, without giving any notice or
                                        assigning any reasons thereof.
                                    </li>
                                </ol>
                            </li>
                        @endif
                        <li>
                            <strong>Remuneration:</strong>
                            <ol type="a">
                                @if ($sql->ServiceCondition == 'Training' && $sql->OrientationPeriod != null && $sql->Stipend != null)
                                    <li>During the period of Orientation, you shall receive a consolidated stipend of
                                        Rs. {{ $sql->Stipend }}/- per month.
                                        After completion of your Orientation period, your annual cost to company (CTC)
                                        and entitlements details shall be as mentioned in the Annexures A and B attached
                                        hereto and effective from the Appointment Date, until further revisions are made
                                        by Company at its sole discretion.
                                    </li>
                                @else
                                    <li>Your annual cost to company (CTC) and other benefits will be as set out in
                                        Annexure A and Annexure B hereto and effective from the Appointment Date, until
                                        further revisions are made by Company at its sole discretion.</li>
                                @endif
                                <li>You will be always governed by the policies, procedures and rules of the Company
                                    related to the salary, allowances, benefits, and perquisites which are specified in
                                    the Annexure A of this appointment letter. Further, the Company may modify or change
                                    such allowances, benefits, and perquisites from time to time in accordance with its
                                    policies.</li>
                            </ol>
                        </li>

                    </ul>



                </div>
            </div>

            <div class="page">
                <div class="subpage ml-3">
                    <ul type="none">
                        <li>
                            <ol type="a" start="3">
                                <li>You shall be entitled for statutory benefits like Provident Fund, ESIC, Bonus and
                                    Gratuity as per the relevant statutory acts and the relevant rules framed there
                                    under.</li>
                                <li>The payment of salary and benefits payable under this appointment shall be
                                    subject to deduction of income tax as per the prevailing income tax rates and other
                                    statutory deductions, as may be required in accordance with the applicable
                                    legislations, in force from time to time.</li>
                                <li>The Company views the compensation offered to you as an extremely confidential
                                    matter and any leakage of the same shall be viewed as a serious breach of the
                                    confidence and conditions of employment at your level.</li>
                            </ol>
                        </li>
                    </ul>
                    <ul style="list-style-type:square">

                        <li>
                            <strong>Transfer & Deputation: </strong>As per the business requirements and at the sole
                            discretion of Company, you may be transferred or sent on deputation to any other section,
                            department or location in the same establishment or you may be transferred to any other
                            establishment (existing or which may be set up in future) under the control of the Company,
                            anywhere in the country with or without any additional benefits.
                        </li>
                        <li>
                            <strong>Termination of services: </strong>
                            <ol type="a">
                                <li>In case of discontinuation of service, for more than [insert] days, during the
                                    Probation Period, this contract may be terminated by the Company with immediate
                                    effect and without any compensation thereof.</li>

                                @php
                                    if ($sql->Department == 6 || $sql->Department == 3) {
                                        $noticePeriod = '3 (three)';
                                    } else {
                                        $noticePeriod = '1 (one)';
                                    }
                                @endphp

                                <li>Upon your confirmation, your employment with the Company can be terminated by either
                                    party giving to other a notice period of

                                    {{ $noticePeriod }}
                                    months’ notice in
                                    writing or {{ $noticePeriod }} months’ wages in lieu
                                    of
                                    such notice.
                                    However, in the event of your resignation, the Company at its sole discretion
                                    will
                                    have an option to accept the same and relieve you prior to completion of the
                                    stipulated notice period of {{ $noticePeriod }} months’, without any pay in lieu
                                    of
                                    the notice period.
                                </li>
                                <li>Your performance will be under review and assessment by the Company from time to
                                    time, and if Company is not satisfied with your ability or performance, the Company
                                    has the right to terminate your employment, with or without notice or wages in lieu
                                    thereof and without assigning of any reason. </li>
                                <li>However, in the event of any gross misconduct or commission of a serious breach
                                    by you, either during the period of probation or after confirmation, the company
                                    reserves its rights to terminate your employment without giving any notice or wages
                                    in lieu thereof and/or assigning of any reasons.</li>
                            </ol>
                        </li>
                        <li>
                            <strong>Retirement: </strong>You will retire from the services of the Company on attaining
                            the age of 60 (Sixty) years, unless and otherwise extended by the company in writing.
                            Date of birth entered in your service record and as verified by you will be considered for
                            the purpose of determining your date of retirement.
                        </li>
                        <li>
                            <strong>Medical Fitness:</strong> This appointment and its continuance are subject to your
                            being sound and remaining medically (physically and mentally) fit. In case of any
                            fitness/health related issues you hold or develop at a later stage that affects your
                            performance as expected by the Company, the Company has the right to get you medically
                            examined by any certified medical practitioner during the period of your service in case you
                            don’t regain your fitness within the said period of 30 days, your services shall be liable
                            to be terminated at the sole discretion of the Company.
                        </li>
                        <li>
                            <strong>General Conditions: </strong>
                            <ol type="a">
                                <li>You will intimate in writing to the Company any change of address within a week
                                    from such change, failing which any communication sent to you on your last recorded
                                    address shall be deemed to have served on you.</li>
                                <li>You may be selected and sponsored by the Company to visit other countries to
                                    undergo specialized technical training/Attend Conference or Seminar/Business tour or
                                    Study tour for meeting the business requirements of the Company and in such case,
                                    you shall be governed by the Overseas Travel Policy of the Company.</li>
                                <li>This appointment is offered on the basis of the information’s furnished by you.
                                    If at any time it is found the employment has been obtained by furnishing
                                    /misleading insufficient information or withheld material information, the Company
                                    will have the right to terminate your services at any time without giving any notice
                                    or any compensation in lieu thereof.</li>
                            </ol>
                        </li>
                    </ul>

                    <br><br>


                </div>
            </div>

            <div class="page">
                <div class="subpage ml-3">
                    <ul type="none">
                        <li>
                            <ol type="a" start="4">
                                <li>On cessation of your employment for any reason whatsoever, you will hand over
                                    every property or article or document entrusted to you by the company during your
                                    period of employment.</li>
                                <li>Your appointment is valid subject to your acceptance of the terms and conditions of
                                    this letter of appointment and submission of signed duplicate copy of this letter
                                    and Service Agreement and Service Bond attached as Annexure A and Annexure B
                                    respectively by you to the Company within same day from the date of issue of this
                                    letter.<br>
                                    In case of failure to submit the signed copy of the above-mentioned documents to the
                                    Company, your services as per this Appointment Letter shall come to an end
                                    automatically on the 7th (Seventh) Day from the date of issue of this letter and the
                                    Company shall not be liable to pay any compensation to the you for such period.
                                </li>
                            </ol>
                        </li>
                    </ul>
                    <ul style="list-style-type:square">
                        <li>This agreement shall be governed by laws of India. All matters related to this agreement
                            shall be subject to the exclusive jurisdiction of the courts at Raipur, Chhattisgarh.</li>
                    </ul>
                    <br>
                    <p>We wish you a long and successful association with the Company.</p>
                    <br><br>
                    <p><strong>For, {{ getCompanyName($sql->Company) }}</strong></p>
                    <br>
                    <br>
                    ------------------------------------
                    <p style="margin: 0px;"><strong>Authorized Signatory,</strong></p>
                    <p><strong>{{ $sql->SigningAuth }}</strong></p>

                    --------------------------------------------------------------------------------------------------------------------
                    @php
                        if ($sql->MaritalStatus != '' || $sql->MaritalStatus != null) {
                            if ($sql->MaritalStatus == 'Single') {
                                if ($sql->Gender == 'M') {
                                    $x = 'S/o. ' . $sql->FatherTitle . ' ' . $sql->FatherName;
                                } else {
                                    $x = 'D/o. ' . $sql->FatherTitle . ' ' . $sql->FatherName;
                                }
                            } else {
                                if ($sql->Gender == 'M') {
                                    $x = 'S/o. ' . $sql->FatherTitle . ' ' . $sql->FatherName;
                                } else {
                                    $x = 'W/o. ' . $sql->FatherTitle . ' ' . $sql->SpouseName;
                                }
                            }
                        } else {
                            if ($sql->Gender == 'M') {
                                $x = 'S/o. ' . $sql->FatherTitle . ' ' . $sql->FatherName;
                            } else {
                                $x = 'D/o. ' . $sql->FatherTitle . ' ' . $sql->FatherName;
                            }
                        }
                    @endphp
                    <p style="text-align: justify">I, <strong>{{ $sql->Title }} {{ $sql->FName }}
                            {{ $sql->MName }}
                            {{ $sql->LName }}</strong>, <strong>{{ $x }}</strong> have read and
                        understood the terms and conditions of this appointment letter and hereby signify my acceptance
                        of the same during my entire tenure of service.</p>
                    <br>
                    <div class="d-flex justify-content-between" style="height: 16px;">

                        <p><strong>------</strong></p>


                        <p><strong>-----------</strong></p>


                        <p><strong>---------------</strong></p>

                    </div>
                    <div class="d-flex justify-content-between">

                        <p><strong>Location</strong></p>


                        <p><strong>Date</strong></p>


                        <p><strong>Employee Signature</strong></p>

                    </div>
                    <br><br>
                    <strong>
                        <p>Enclosed:</p>
                    </strong>
                    <ol type="1">
                        <li>Annexure A- CTC</li>
                        <li>Annexure B- Entitlements</li>
                        <li>Annexure C- Service Agreement</li>
                        @if ($sql->ServiceBond == 'Yes')
                            <li>Annexure D- Service Bond </li>
                        @endif
                    </ol>
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
