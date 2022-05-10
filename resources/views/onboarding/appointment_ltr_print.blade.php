<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="{{ URL::to('/') }}/assets/js/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">

    <title>Appointment Letter</title>
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
            margin-bottom: 10px;
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
$JAId = $_REQUEST['jaid'];
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
        <div id="appointment_ltr">
            <div class="page">
                <div class="subpage ml-3">

                    <p style="margin-bottom:100px;"></p>
                    <p class="text-center "><b><u> APPOINTMENT LETTER</u></b></p>
                    <p style="font-size:16px;"><b>Ref:
                            {{-- {{ getCompanyCode($sql->Company) .'_AL/' .getDepartmentCode($sql->Department) .'/' .date('M-Y', strtotime($sql->JoinOnDt)) .'/' .$JAId }} --}}
                            {{ $sql->AppLetterNo }}
                        </b>
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

                    <p style="text-align: justify">We are pleased to appoint you on the post of
                        <b>{{ getDesignation($sql->Designation) }}</b> at
                        <b>Grade-{{ getGradeValue($sql->Grade) }}</b> in {{ getDepartment($sql->Department) }}
                        w.e.f. {{ date('d-m-Y', strtotime($sql->JoinOnDt)) }} with place of posting being
                        <strong>{{ getHq($sql->F_LocationHq) }}({{ getHqStateCode($sql->F_StateHq) }})</strong>
                    </p>


                    <p style="text-align:justify">Your compensation as CTC will be Rs. {{ $sql->CTC }} per annum.
                        Please note that the salaries, allowances, facilities and other sums payable under this
                        appointment are subject to the application of Income Tax and you shall be liable for the same.
                    </p>

                    <p style="text-align: justify">Please note that the Management views the compensation offered to you
                        as an extremely confidential matter and any leakage of the same shall be viewed as a serious
                        breach of this confidence and conditions of employment at your level.</p>
                    <p style="text-align: justify">Please sign and return a copy of this letter as a token of your
                        acceptance of the “Terms and Conditions of Employment” and return it to HR. </p>
                    <p style="text-align: justify">We wish you a long and successful association with VNR Seeds Private
                        Limited.
                    </p>
                    <p>Yours Faithfully,</p>

                    <b>
                        <p>For, VNR Seeds Pvt. Ltd.</p>
                    </b>

                    <br><br><br><br>
                    <p style="margin-bottom:2px;">----------------------------<span
                            style="float: right">----------------------------</span></p>
                    <p style="margin-bottom: 0px;"><b>Authorized Signatory,</b><span
                            style="float: right">{{ $sql->Title }} {{ $sql->FName }} {{ $sql->MName }}
                            {{ $sql->LName }}</span>
                    </p>
                    <p><b> {{ $sql->SigningAuth }}</b>
                    </p>


                    <br>
                    <br>
                    <p><b>Enclosed: Terms & conditions of Employement</b></p>

                </div>
            </div>

            <div class="page">
                <div class="subpage ml-3">
                    <p style="font-size:16px;"><b>Ref:
                            {{-- {{ getCompanyCode($sql->Company) .'_AL/' .getDepartmentCode($sql->Department) .'/' .date('M-Y', strtotime($sql->JoinOnDt)) .'/' .$JAId }} --}}
                            {{ $sql->AppLetterNo }}
                        </b>
                        <span style="float:right"><b>Date:{{ date('d-m-Y', strtotime($sql->A_Date)) }}</span></b>
                    </p>

                    <br>
                    <center><b>
                            <p><u>TERMS AND CONDITIONS OF EMPLOYMENT</u></p>
                        </b></center>

                    <ol>
                        <li>You shall be on {{ $sql->ServiceCondition }} for a period of
                            {{ $sql->ServiceCondition == 'Probation' ? '6 months' : '1 year' }} from the date of your
                            joining. The above Probation period may be extended for another 3 months at the discretion
                            of the Management.</li>
                        <li>While on {{ $sql->ServiceCondition }} you will be entitled to a salary and entitlements
                            as
                            explained
                            in Annexure A & B as provided with your offer letter.
                        </li>
                        <li>On expiry of the above said {{ $sql->ServiceCondition }} period or extension thereof
                            unless
                            you are
                            confirmed in writing, you will be deemed to be as such.</li>
                        <li>While on {{ $sql->ServiceCondition }} you will perform your duties assigned to you,
                            including any
                            other work assigned by the superiors. Your performance will be under review and assessment
                            by the management, and if management is not satisfied with your ability or performance, your
                            service is liable to be terminated without notice and without assigning any reason.
                            In case of discontinuation of service during the period of {{ $sql->ServiceCondition }}
                            at
                            your end,
                            you shall give
                            @if ($sql->Department == 1002)
                                3-months’ notice or shall pay 3 month’s
                            @else
                                15 days’ notice or shall pay 15 days’
                            @endif


                            wages in lieu of notice. However, the
                            management may terminate your service during the {{ $sql->ServiceCondition }} period
                            immediately
                            without any notice at any point of time without assigning any reason. After Confirmation,
                            the employment can end through a
                            @if ($sql->Department == 1002)
                                3 month notice or payment of 3 month
                            @else
                                1 month notice or payment of 1 month
                            @endif

                            wage in lieu thereof
                            from either side.
                        </li>
                        @if ($sql->ServiceBond == 'Yes')
                            <li>You shall sign and submit a service bond (Annexure B) for continuation of your service
                                at
                                your own free will, discretion and judgement and agrees to serve the company
                                continuously
                                for a minimum period of Two years from the date of your appointment with the company and
                                shall not leave the services of the company before successful completion of the said
                                period.
                                If you leave the employment of the company or brings about any situation as compelling
                                the
                                company to terminate your service during the validity of service period, you
                                unconditionally
                                agree to pay on demand, to the company a sum of 50% of the annual CTC as per the
                                prevailing
                                CTC rate (as on date of leaving).

                                <p> The Service Bond shall be furnished by you with in the same day & date of your
                                    appointment.
                                    In case of failure to do, so your appointment under this agreement shall come to an
                                    end on
                                    the 7th Day from the date of your appointment.</p>
                            </li>
                        @endif

                    </ol>
                    <ol start="{{ $sql->ServiceBond == 'Yes' ? '6' : '5' }}">
                        <li>As per the business requirements at the discretion of management, you may be transferred to
                            any other section or department in the same establishment or you may be transferred to any
                            other establishment either in existence or would come into existence under any management
                            anywhere in the country without any additional benefits. While in service at the transferred
                            place you will be governed by the rules applicable at the transferred place.</li>
                        <li>On satisfactory completion of your {{ $sql->ServiceCondition }} you may be placed in the
                            proper grade/ designation and may be confirmed in writing, if found suitable.
                            You may also be sent on deputation to any other organization under the same management or
                            under different management anywhere in the country.

                        </li>
                        <li>The terms & conditions of the employment & agreement shall be applicable to you. You will
                            also be governed by the service rules/standing order/companies rules/regulations & policies
                            applicable to you during the period of service.</li>
                        <li>On cessation of your employment for any reason whatsoever, you will hand over each property
                            or article or document entrusted to you by the company during the course of employment.
                        </li>

                        <li>"Superannuation/Retirement: You will be superannuated / retire from the services of the
                            company on attaining the age of 60 years as determined by the company policy, unless and
                            otherwise extended by the company."
                        </li>


                    </ol>
                    <b>
                        <p>For, VNR Seeds Pvt. Ltd.</p>
                    </b>
                    <br>
                    <p style="margin-bottom:2px;">----------------------------<span
                            style="float: right">----------------------------</span></p>
                    <p style="margin-bottom: 0px;"><b>Authorized Signatory,</b><span
                            style="float: right">{{ $sql->Title }} {{ $sql->FName }} {{ $sql->MName }}
                            {{ $sql->LName }}</span>
                    </p>
                    <p><b> {{ $sql->SigningAuth }}</b>
                    </p>



                    <p style="text-align: justify">I, <b>{{ $sql->Title }} {{ $sql->FName }} {{ $sql->MName }}
                            {{ $sql->LName }}</b>, {{ $sql->Gender == 'M' ? 'S/o' : 'D/o' }}
                        <b>{{ $sql->FatherTitle }}
                            {{ $sql->FatherName }}</b> have read and understood the terms and conditions of
                        employment
                        and I accept them fully.
                    </p>
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


                </div>
            </div>
        </div>

    </div>


    <script>
        $(document).ready(function() {
            window.print();
        });
    </script>
</body>

</html>
