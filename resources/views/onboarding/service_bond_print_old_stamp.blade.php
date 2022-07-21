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


    <script src="https://kit.fontawesome.com/b0b5b1cf9f.js" crossorigin="anonymous"></script>
    <title>Service Bond</title>
    <style>
        body {
            width: 230mm;
            height: 100%;
            margin: 0 auto;
            padding: 0;
            font-size: 12pt;
            background: rgb(204, 204, 204);
        }

        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            margin: 10mm auto;
            background: white;
            box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
        }

        .subpage {
            padding: 1cm;
            height: 297mm;
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
        }

        .abc {
            margin-left: 42.55pt;
            text-align: justify;
            text-justify: inter-ideograph;
            text-indent: -28.35pt
        }

        .bde {
            margin-left: 62.55pt;
            text-align: justify;
            text-justify: inter-ideograph;
            text-indent: -38.35pt
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
use function App\Helpers\getStateCode;
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
    $months_word = ['One' => '1 (One)', 'Two' => '2 (Two)', 'Three' => '3 (Three)', 'Four' => '4 (Four)', 'Five' => '5 (Five)', 'Six' => '6 (Six)', 'Seven' => '7 (Seven)', 'Eight' => '8 (Eight)', 'Nine' => '9 (Nine)', 'Ten' => '10 (Ten)', 'Eleven' => '11 (Eleven)', 'Twelve' => '12 (Twelve)'];
@endphp

<body>
    <div class="container">
        <input type="hidden" name="jaid" id="jaid" value="{{ $JAId }}">
        <input type="hidden" name="ltrno" id="ltrno"
            value="{{ getCompanyCode($sql->Company) .'_AL-SB/' .getDepartmentCode($sql->Department) .'/' .date('M-Y', strtotime($sql->JoinOnDt)) .'/' .$JAId }}">

        <div id="ServiceBond_ltr">

            <div class="page">
                <div class="subpage ml-3">
                    <div style="height:550px;"></div>
                    <p style="font-size:16px;"><b>Ref:
                            {{-- {{ getCompanyCode($sql->Company) .'_AL-SB/' .getDepartmentCode($sql->Department) .'/' .date('M-Y', strtotime($sql->JoinOnDt)) .'/' .$JAId }} --}}</b>
                        <span class="float float-right"><b>Date:
                               {{--  @if ($sql->B_Date == null)
                                    {{ date('d-M-Y') }}

                                @else
                                    {{ date('d-m-Y', strtotime($sql->B_Date)) }}
                                @endif --}} &emsp;&emsp;&emsp;
                            </b>
                        </span>
                    </p>
                    <b>
                        <p class="text-center">Service Bond (Annexure)</p>
                    </b>
                    <p style="text-align: justify">This agreement is executed at RAIPUR, CHHATTISGARH, on this
                        {{--  @if ($sql->B_Date != '')
                             {{ date('d/m/Y', strtotime($sql->B_Date)) }}
                         @else
                             {{ date('d/m/Y') }}
                         @endif --}} &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                         (and effective from date {{-- date('d/m/Y', strtotime($sql->JoinOnDt)) --}}&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;)
                     </p>
 

                    <p><b>BETWEEN</b></p>

                    <p style="text-align: justify"><b>{{ getCompanyName($sql->Company) }}</b> a Company incorporated
                        under the provisions of the Companies Act, 1956 and having its registered office situated at
                        Corporate Centre, Canal Road Crossing, Ring Road No.1, Raipur, Chhattisgarh- 492006,
                        (hereinafter referred to as the <b>“Company”</b>) which expression shall unless repugnant to the
                        subject or context shall mean and include its successors and assignees of the <b>FIRST PART</b>.
                    </p>
                    <p><b>AND</b></p>

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
                    <p style="text-align: justify">{{ $sql->Title }} {{ $sql->FName }}
                        {{ $sql->MName }}
                        {{ $sql->LName }}, {{ $x }} permanently residing at {{ $sql->perm_address }},
                        {{ $sql->perm_city }},
                        Dist-{{ getDistrictName($sql->perm_dist) }} ({{ getStateCode($sql->perm_state) }})
                        -
                        {{ $sql->perm_pin }} (hereinafter referred to as the <b>“Employee”</b>) of the <b>SECOND
                            PART</b>.</p>

                    <p style="text-align: justify"><b>WHEREAS</b> the Company has offered and the Employee has accepted
                        the employment of the Company on the terms and conditions mentioned under the appointment letter
                        dated {{-- date('d-m-Y', strtotime($sql->A_Date)) --}} &emsp;&emsp;&emsp;&emsp; and the Employee has agreed to abide with
                        the
                        terms and conditions of his/her employment.</p>
                    <p style="text-align: justify"><b>AND WHEREAS</b>, in terms of the said letter of appointment, the
                        Employee is required to provide an independent undertaking, as herein appearing to back up the
                        obligations and liabilities of the Employee as condition of his/her employment.</p>
                    <br><br>
                    <p style="margin-bottom: 0px;">on behalf of <b>{{ getCompanyName($sql->Company) }}</b>
                        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span
                            style="text-align: right">_______________________</span></p>
                    <p>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Employee
                        Signature</p>

                    <p style="margin-bottom: 0px;">__________________________</p>
                    <p>Authorized Signatory </p>
                </div>
            </div>



            <div class="page">
                <div class="subpage ml-3">
                    <p style="margin-bottom: 50px;"></p>
                    <p style="font-size:16px;"><b>Ref:
                        {{-- {{ getCompanyCode($sql->Company) .'_AL-SB/' .getDepartmentCode($sql->Department) .'/' .date('M-Y', strtotime($sql->JoinOnDt)) .'/' .$JAId }} --}}</b>
                    <span class="float float-right"><b>Date:
                           {{--  @if ($sql->B_Date == null)
                                {{ date('d-M-Y') }}

                            @else
                                {{ date('d-m-Y', strtotime($sql->B_Date)) }}
                            @endif --}} &emsp;&emsp;&emsp;
                        </b>
                    </span>
                </p>

                    <br>
                    <p style="text-align: justify">NOW, THEREFORE, THIS AGREEMENT WITNESSETH AND THE PARTIES HERETO
                        AGREE AS UNDER:</p>
                    <ol type="1">
                        <li>The Employee understands and acknowledges that the Company shall be incurring expenses on
                            Employee’s skill enhancement directly through training programs or other means which shall
                            be beneficial for the Employee and the Company either immediately or on future date as per
                            the job requirements.</li>
                        <li>The Employee by his/her own free will, discretion and judgement, agrees and undertakes to
                            serve the Company continuously for a minimum period of <b>{{ $months_word[$sql->ServiceBondYears] }} years </b> from
                            the date of his/her appointment with the Company (“Service Period”) and shall not leave the
                            services of the Company before completion of the Service Period. During the said Service
                            Period, the Employee shall not seek employment, or enter employment of any other employer or
                            directly or indirectly engage in any business including as that of the Company.</li>
                        <li>If the Employee leaves the service of the Company before completion of the said Service
                            Period, then he/she shall be liable to refund the Company, the cost incurred by the Company
                            in getting the vacancy published and all other ancillary expenses incurred by the Company in
                            the process of selection of the Employee.</li>
                        <li>During the Service Period, the Employee shall be under an obligation to work with utmost
                            professional competency and dedication to serve the Company.</li>
                        <li>If the Employee, at any time during his/her employment with the Company is found guilty of
                        </li>
                        <ol type="a">
                            <li>any misconduct including as defined under the employee service regulations, or</li>
                            <li>any willful breach or continuous neglect of the terms of this Agreement, or</li>
                            <li>Negligence of his/her duties, the Company may, without any notice, determine his/her
                                employment with the Company.</li>
                        </ol>
                        <p>the Employee shall be deemed to have brought about such a situation that the Company is
                            compelled to put an end to his/her employment and he/she shall, therefore, continue to be
                            liable for all losses /damages in respect thereof and pay compensation to the Company in
                            terms of this Agreement. </p>
                        <li>If the Employee leaves the employment of the Company before expiry of the Service Period,
                            then the Employee unconditionally agrees to pay, on demand, to the Company a sum of 50%
                            (Fifty percent) of his annual salary as per the prevailing CTC rate (on date of leaving) as
                            pre estimated liquidated damages as compensation for the breach of the terms of this
                            Agreement.</li>
                            <li>The Employee agrees to make good the Company all losses or damages suffered by the Company,
                                through any breach of him of the terms and conditions of this Agreement or arising out of
                                his employment with the Company.</li>
                            <li>The company may contact the employee’s subsequent employer for informing about the pending
                                recovery of dues if the employee does not pay the service bond or notice period dues as a
                                part of the separation policy. </li>
                            <li>In addition to the payment of the amount specified in the preceding clause, the Employee
                                agrees and undertakes to indemnify the Company against all expenses incurred in initiating
                                the legal process against the employee for the breach of the terms of this Agreement, if
                                required.</li>
                    </ol>

                    <br><br>
                    <p style="margin-bottom: 0px;">on behalf of <b>{{ getCompanyName($sql->Company) }}</b>
                        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span
                            style="text-align: right">_______________________</span></p>
                    <p>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Employee
                        Signature</p>

                    <p style="margin-bottom: 0px;">__________________________</p>
                    <p>Authorized Signatory </p>
                </div>
            </div>

            <div class="page">
                <div class="subpage ml-3">
                    <p style="margin-bottom: 50px;"></p>
                    <p style="font-size:16px;"><b>Ref:
                        {{-- {{ getCompanyCode($sql->Company) .'_AL-SB/' .getDepartmentCode($sql->Department) .'/' .date('M-Y', strtotime($sql->JoinOnDt)) .'/' .$JAId }} --}}</b>
                    <span class="float float-right"><b>Date:
                           {{--  @if ($sql->B_Date == null)
                                {{ date('d-M-Y') }}

                            @else
                                {{ date('d-m-Y', strtotime($sql->B_Date)) }}
                            @endif --}} &emsp;&emsp;&emsp;
                        </b>
                    </span>
                </p>

                    <br>
                    <ol type="1" start="7">
                        
                    </ol>
                    <br><br>
                    <p>IN WITNESS WHEREOF the parties, to this Agreement have signed on the date, month and year first
                        mentioned hereinabove. </p>
                    <br><br>
                    <p style="margin-bottom: 0px;">on behalf of <b>{{ getCompanyName($sql->Company) }}</b>
                        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span
                            style="text-align: right">_______________________</span></p>
                    <p>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Employee
                        Signature</p>

                    <p style="margin-bottom: 0px;">__________________________</p>
                    <p>Authorized Signatory </p>

                    <br><br>
                    <table class="table table-borderless">
                        <tr>
                            <td>
                                <p><b>Witness 1:</b></p>
                            </td>
                            <td>
                                <p><b>Witness 2:</b></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Name: ________________________________</p>
                            </td>
                            <td>
                                <p>Name: ________________________________</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Address: ______________________________</p>
                            </td>
                            <td>
                                <p>Address: ______________________________</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>_________________________________________</p>
                            </td>
                            <td>
                                <p>_________________________________________</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>_________________________________________</p>
                            </td>
                            <td>
                                <p>_________________________________________</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Contact No: __________________________</p>
                            </td>
                            <td>
                                <p>Contact No: __________________________</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Aadhaar No.: ________________________</p>
                            </td>
                            <td>
                                <p>Aadhaar No.: ________________________</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Signature: ____________________________</p>
                            </td>
                            <td>
                                <p>Signature: ____________________________</p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>



        </div>
    </div>

    <script src="{{ URL::to('/') }}/assets/js/bootstrap.bundle.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/js/sweetalert2.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/js/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            window.print();
        });
    </script>
</body>

</html>
