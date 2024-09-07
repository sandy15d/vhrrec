<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Letter</title>
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
        <p style="text-align: center;font-weight: bold;"><b><u> APPOINTMENT LETTER</u></b></p>
        <div style="font-size: 14px; font-weight: bold;">
            <div style="float: left; width: 60%; text-align: left;">Ref:
                {{ getCompanyCode($sql->Company) . '_AL/' . getDepartmentCode($sql->Department) . '/' . date('M-Y', strtotime($sql->JoinOnDt)) . '/' . $JAId }}
            </div>
            <div style="float: left; width: 40%; text-align: right;">Date:{{ date('d-m-Y', strtotime($sql->A_Date)) }}</div>
        </div>

        <p><b>To,</b>
            <br>
            <b style="margin-bottom: 0px;"> {{ $sql->Title }} {{ $sql->FName }} {{ $sql->MName }}
                {{ $sql->LName }}<br>{{ $sql->perm_address }}, {{ $sql->perm_city }},
                <br>Dist-{{ getDistrictName($sql->perm_dist) }},{{ getStateName($sql->perm_state) }},
                {{ $sql->perm_pin }}</b>
        </p>



        <p style="text-align:justify">We take pleasure in appointing you as
            <b>{{ getDesignation($sql->Designation) }}</b> at
            <b>Grade-{{ getGradeValue($sql->Grade) }}</b> at {{ getCompanyName($sql->Company) }}
            (<strong>"Company"</strong>). The said appointment shall be governed by the terms and
            conditions, specified
            hereinbelow, apart from other service rules and conditions that are applicable or may become
            applicable from time to time, at the sole discretion of the Company.
        </p>

        <ol>
            <li>
                <strong>Commencement of Service:</strong> The date of your appointment will be
                {{ date('d-m-Y', strtotime($sql->JoinOnDt)) }} ("<strong>Appointment Date</strong>").
            </li>

            <li>

                @if ($sql->ServiceCondition == 'Training' && $sql->OrientationPeriod != null && $sql->Stipend != null)
                    <p style="margin-bottom: 0px;"><strong>Place of Posting:</strong> You shall report
                        at
                        <strong>{{ getHq($sql->F_LocationHq) }}({{ getHqStateCode($sql->F_StateHq) }})</strong>,
                        for an orientation program of {{ $sql->OrientationPeriod }} months.
                    </p>
                    <p style="margin-bottom: 0px;">After completion of the orientation period, you shall
                        be
                        on a Training period of 12
                        months and during the period of training, you may be allocated various
                        assignments
                        at different locations. </p>
                    <p>However, you may be required to (i) relocate to other locations in India; and/or
                        (ii)
                        undertake such travel in India, (iii) overseas locations, from time to time, as
                        may
                        be necessary in the interests of the Company's business.</p>
                @elseif($sql->TempS == 1 && $sql->FixedS == 1)
                    <p style="margin-bottom: 0px;"><strong>Place of Posting:</strong> For initial
                        {{ $sql->TempM }} months, your
                        temporary headquarter will be
                        <strong>{{ getHq($sql->T_LocationHq) }}({{ getHqStateCode($sql->T_StateHq) }})</strong>


                        @if ($sql->T_StateHq1 != null)
                            or
                            <strong>{{ getHq($sql->T_LocationHq1) }}
                                ({{ getHqStateCode($sql->T_StateHq1) }}) </strong> and
                        @endif
                        then
                        your principal place of employment shall be at
                        <strong>{{ getHq($sql->F_LocationHq) }}({{ getHqStateCode($sql->F_StateHq) }})</strong>.
                        However, you may be
                        required to (i) relocate to other locations in India; and/or (ii) undertake such
                        travel in India, (iii) overseas locations, from time to time, as may be
                        necessary in
                        the interests of the Company's business.
                    </p>
                @elseif($sql->TempS == 1 && $sql->FixedS == 0)
                    <p style="margin-bottom: 0px;">For initial {{ $months_word[$sql->TempM] }}
                        months,
                        your temporary headquarter
                        will be
                        <strong>{{ getHq($sql->T_LocationHq) }}({{ getHqStateCode($sql->T_StateHq) }})</strong>


                        @if ($sql->T_StateHq1 != null)
                            or
                            <strong>{{ getHq($sql->T_LocationHq1) }}
                                ({{ getHqStateCode($sql->T_StateHq1) }}) </strong>
                        @endif
                        However, you may be required to (i) relocate to other locations in India; and/or
                        (ii) undertake such travel in India, (iii) overseas locations, from time to
                        time,
                        as
                        may be necessary in the interests of the Company's business.
                    </p>
                @else
                    <p style="margin-bottom: 0px;"><strong>Place of Posting:</strong> Your principal
                        place
                        of employment shall be at
                        <strong>{{ getHq($sql->F_LocationHq) }}({{ getHqStateCode($sql->F_StateHq) }})</strong>.
                        However, you may be required
                        to (i) relocate to other locations in India; and/or (ii) undertake such travel
                        in
                        India, (iii) or overseas, from time to time, as may be necessary in the
                        interests of
                        the Company's business.
                    </p>
                @endif
            </li>
            <li>
                <strong>Relevant documents:</strong> Your appointment and continuance in service with
                the
                Company is subject to submission of documents as mentioned in the offer letter, by your
                Appointment Date.
            </li>

            <li>
                <strong>Reporting / Duties and responsibilities:</strong>
                <ol type="a">
                    <li>Currently, you will report to
                        @if ($sql->repchk == 'RepWithoutEmp')
                            <strong>{{ getDesignation($sql->reporting_only_desig) }}</strong>
                        @else
                            <strong>{{ getFullName($sql->A_ReportingManager) }},{{ getEmployeeDesignation($sql->A_ReportingManager) }}</strong>
                        @endif
                        (<strong>“Manager”</strong>) or such
                        other person as may be suggested by the Company, from time to time.
                    </li>
                    <li>You will perform all the duties & responsibilities assigned to you from time to
                        time based on business requirement of the Company or any other incidental work,
                        if
                        required by your Manger or other superiors at the Company. It may be subject to
                        changes at the sole discretion of the Company.</li>
                </ol>
            </li>
            @if ($sql->ServiceBond == 'Yes')
                <li>
                    <strong>Service Bond:</strong> You shall sign and submit a service bond for
                    continuation
                    of
                    your service at your own free will, discretion and judgement and agree to serve the
                    Company
                    continuously for a minimum period of<b>{{ $sql->ServiceBondYears }} </b> years
                    from
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
                            from the Appointment Date (<strong>“{{ $sql->ServiceCondition }} Date”</strong>) which
                            maybe
                            either
                            extended or may
                            be
                            dispensed, at the sole discretion of the Company. Unless confirmed in
                            writing,
                            you
                            will be deemed as a
                            {{ $sql->ServiceCondition == 'Probation' ? 'probationer' : 'trainee' }}
                            after
                            expiry of the initial or
                            extended
                            {{ $sql->ServiceCondition }} Period.
                        </li>
                        <li>
                            Upon satisfactory completion of the {{ $sql->ServiceCondition }} Period
                            and a
                            subsequent
                            performance
                            evaluation, your position may be confirmed or extended at the sole
                            discretion of
                            the
                            Company.
                        </li>
                        <li>
                            Based on your performance during the {{ $sql->ServiceCondition }} Period,
                            the
                            Company reserves the
                            right to reduce/dispense with or extend the {{ $sql->ServiceCondition }}
                            Period at its sole
                            discretion
                            or terminate your services with immediate effect, without giving any notice
                            or
                            assigning any reasons thereof.
                        </li>
                    </ol>
                </li>
                <li>
                    <strong>Remuneration:</strong>
                    <ol type="a">
                        @if ($sql->ServiceCondition == 'Training' && $sql->OrientationPeriod != null && $sql->Stipend != null)
                            <li>During the period of Orientation, you shall receive a consolidated
                                stipend
                                of
                                Rs. {{ $sql->Stipend }}/- per month.
                                After completion of your Orientation period, your annual cost to company
                                (CTC)
                                and entitlements details shall be as mentioned in the Annexures A and B
                                attached
                                hereto and effective from the Appointment Date, until further revisions
                                are
                                made
                                by Company at its sole discretion.
                            </li>
                        @else
                            <li>Your annual cost to company (CTC) and other benefits will be as set out
                                in
                                Annexure A and Annexure B hereto and effective from the Appointment
                                Date,
                                until
                                further revisions are made by Company at its sole discretion.</li>
                        @endif
                        <li>You will be always governed by the policies, procedures and rules of the
                            Company
                            related to the salary, allowances, benefits, and perquisites which are
                            specified
                            in
                            the Annexure A of this appointment letter. Further, the Company may modify
                            or
                            change
                            such allowances, benefits, and perquisites from time to time in accordance
                            with
                            its
                            policies.</li>
                        <li>You shall be entitled for statutory benefits like Provident Fund, ESIC,
                            Bonus
                            and
                            Gratuity as per the relevant statutory acts and the relevant rules framed
                            there
                            under.</li>
                        <li>The payment of salary and benefits payable under this appointment shall be
                            subject to deduction of income tax as per the prevailing income tax rates
                            and other statutory deductions, as may be required in accordance with the
                            applicable
                            legislations, in force from time to time.</li>
                        <li>The Company views the compensation offered to you as an extremely
                            confidential matter and any leakage of the same shall be viewed as a serious
                            breach of
                            the confidence and conditions of employment at your level.</li>

                    </ol>
                </li>
            @endif




            <li>
                <b>Transfer & Deputation: </b>As per the business requirements and at the sole
                discretion of Company, you may be transferred or sent on deputation to any other
                section, department or location in the same establishment or you may be transferred to
                any other
                establishment (existing or which may be set up in future) under the control of the
                Company, anywhere in the country with or without any additional benefits.
            </li>
            <li>
                <strong>Termination of services: </strong>
                <ol type="a">
                    <li>In case of discontinuation of service, for more than 10 days, this contract may
                        be
                        terminated by the Company with immediate
                        effect and without any compensation thereof.</li>

                    @php
                        if ($sql->Department == 1040 || $sql->Department == 1002) {
                            $noticePeriod = '3 (three)';
                        } else {
                            $noticePeriod = '1 (one)';
                        }
                    @endphp

                    <li>Upon your confirmation, your employment with the Company can be terminated by
                        either
                        party giving to other a notice period of

                        {{ $noticePeriod }}
                        months’ notice in
                        writing or {{ $noticePeriod }} months’ wages in lieu
                        of
                        such notice.
                        However, in the event of your resignation, the Company at its sole discretion
                        will
                        have an option to accept the same and relieve you prior to completion of the
                        stipulated notice period of {{ $noticePeriod }} months’, without any pay in
                        lieu
                        of
                        the notice period.
                    </li>
                    <li>Your performance will be under review and assessment by the Company from time to
                        time, and if Company is not satisfied with your ability or performance, the
                        Company
                        has the right to terminate your employment, with or without notice or wages in
                        lieu
                        thereof and without assigning of any reason. </li>
                    <li>However, in the event of any gross misconduct or commission of a serious breach
                        by you, either during the period of probation or after confirmation, the company
                        reserves its rights to terminate your employment without giving any notice or
                        wages
                        in lieu thereof and/or assigning of any reasons.</li>
                </ol>
            </li>
            <li>
                <strong>Retirement: </strong>You will retire from the services of the Company on
                attaining
                the age of 60 (Sixty) years, unless and otherwise extended by the company in writing.
                Date of birth entered in your service record and as verified by you will be considered
                for
                the purpose of determining your date of retirement.
            </li>
            <li>
                <strong>Medical Fitness:</strong> This appointment and its continuance are subject to
                your
                being sound and remaining medically (physically and mentally) fit. In case of any
                fitness/health related issues you hold or develop at a later stage that affects your
                performance as expected by the Company, the Company has the right to get you medically
                examined by any certified medical practitioner during the period of your service in case
                you
                don’t regain your fitness within the said period of 30 days, your services shall be
                liable
                to be terminated at the sole discretion of the Company.
            </li>
            <li>
                <strong>General Conditions: </strong>
                <ol type="a">
                    <li>You will intimate in writing to the Company any change of address within a week
                        from such change, failing which any communication sent to you on your last
                        recorded address shall be deemed to have served on you.</li>
                </ol>
            <li>You may be selected and sponsored by the Company to visit other countries to
                undergo specialized technical training/Attend Conference or Seminar/Business
                tour or
                Study tour for meeting the business requirements of the Company and in such
                case,
                you shall be governed by the Overseas Travel Policy of the Company.</li>
            <li>This appointment is offered on the basis of the information’s furnished by you.
                If at any time it is found the employment has been obtained by furnishing
                /misleading insufficient information or withheld material information, the
                Company
                will have the right to terminate your services at any time without giving any
                notice
                or any compensation in lieu thereof.</li>
            <li>On cessation of your employment for any reason whatsoever, you will hand over
                every property or article or document entrusted to you by the company during
                your
                period of employment.</li>

            <li>Your appointment is valid subject to your acceptance of the terms and conditions
                of
                this letter of appointment and submission of signed duplicate copy of this
                letter
                and Service Agreement @if ($sql->ServiceBond == 'Yes')
                    ,Service Bond
                @endif
                attached as Annexure C
                @if ($sql->ServiceBond == 'Yes')
                    and Annexure D respectively
                @endif
                by you to the Company within same day from the date of issue of this
                letter.<br>
                In case of failure to submit the signed copy of the above-mentioned documents to
                the
                Company, your services as per this Appointment Letter shall come to an end
                automatically on the 7th (Seventh) Day from the date of issue of this letter and
                the
                Company shall not be liable to pay any compensation to the you for such period.
            </li>
            </li>



            <li>This agreement shall be governed by laws of India. All matters related to this agreement
                shall be subject to the exclusive jurisdiction of the courts at Raipur, Chhattisgarh.
            </li>
        </ol>




        <br>
        <p>We wish you a long and successful association with the Company.</p>
        <br>
        <p><strong>Declaration</strong></p>
      

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
            understood the terms and conditions of this appointment letter and hereby signify my
            acceptance
            of the same during my entire tenure of service.</p>
            <br>
            <div style="margin-bottom:5px; font-weight:bold;">
                <div style="float: left; width: 33%; text-align: left;">_______________</div>
                <div style="float: left; width: 33%; text-align: center;">_______________</div>
                <div style="float: left; width: 33%; text-align: right;">________________</div>
            </div>
            <div style="font-weight:bold;">
                <div style="float: left; width: 33%; text-align: left;">Location</div>
                <div style="float: left; width: 33%; text-align: center;">Date</div>
                <div style="float: left; width: 33%; text-align: right;">{{ $sql->Title }} {{ $sql->FName }}
                    {{ $sql->MName }} {{ $sql->LName }}</div>
            </div>
       
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
        <pagebreak />
        <br>

        <div style="text-align: center;margin-left:50px;">
            <p class="text-center"><b>ANNEXURE A – COMPENSATION STRUCTURE</b></p>
            <br>
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

            </table>
        </div>

        <p><b>Notes:</b></p>
        <ol type="1">
            <li>Bonus shall be paid as per The Code of Wages Act, 2019</li>
            <li>The Gratuity to be paid as per The Code on Social Security, 2020.</li>
            @if ($sql->Company == 1)
                <li>Performance Pay</li>
            @endif
        </ol>
        @if ($sql->Company == 1)
            <ul type="none">
                <li>
                    <ol type="a">
                        <li>Performance Pay is an annually paid variable component of CTC, paid in July
                            salary.</li>
                        <li>This amount is indicative of the target variable pay, actual pay-out will
                            vary
                            based on the performance of Company and Individual.</li>
                        <li>It is linked with Company performance (as per fiscal year) and Individual
                            Performance (as per appraisal period for minimum 6 months working, pro-rata
                            basis if <1 year working).</li>
                        <li>The calculation shall be based on the pre-defined performance measures at
                            both,
                            Company & Individual level.</li>
                    </ol>
                </li>
            </ul>
            <p>For more details refer to the Company’s Performance Pay policy.</p>
        @endif

        <pagebreak />
        <br>


        <div style="text-align: center;margin-left:50px;">
            <p class="text-center"><b>ANNEXURE B – ENTITLEMENTS</b></p>
            <table class="table" style="width: 90%">
                @php
                    $rowCount = 0;
                @endphp
                <tr>
                    <th class="text-center" style="width:60px;">SN</th>
                    <th colspan="2" class="text-center">Entitlements</th>
                </tr>
                <tr>
                    <td class="text-center"><?= ++$rowCount ?></td>
                    <td style="width:502px;"><b>Lodging </b> (Actual with upper limits per day)
                    </td>
                    <td class="text-center" style="width: 200px;">Rs. {{ $elg->LoadCityA }}</td>
                </tr>

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
                        <td colspan="2"><b>Travel Eligibility (For Official Purpose Only)</b></b>
                        </td>

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
                    <td colspan="2"><b>Mode of Travel outside HQ</b></b></td>

                </tr>

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
                        <td><b>Mobile Expense Reimbursement</b></b></td>
                        <td class="text-center">Rs. {{ $elg->MExpense }} / {{ $elg->MTerm }}</td>
                    </tr>
                @endif

                @if ($elg->Laptop != '')
                    <tr>
                        <td class="text-center"><?= ++$rowCount ?></td>
                        <td><b>Laptop Purchase Eligibility (if applicable)</b></b></td>
                        <td class="text-center">Rs. {{ $elg->Laptop }} </td>
                    </tr>
                @endif

                <tr>
                    <td class="text-center"><?= ++$rowCount ?></td>
                    <td><b>Group Term Insurance</b></b></td>
                    <td class="text-center">
                        5 Lakh
                    </td>
                </tr>


            </table>
        </div>

        @if ($elg->TwoWheelLine == 1)
            <p style="padding-left: 20px;margin-bottom:5px;"> *2 Wheeler vehicle eligibility as per
                company
                vehicle policy.</p>
        @endif

        @if ($elg->FourWheelLine == 1)
            <p style="padding-left: 20px;margin-bottom:5px;">*4 Wheeler vehicle eligibility as per
                company
                vehicle policy.
            </p>
        @endif

        @if ($elg->TravelLine == 1)
            <p style="padding-left: 20px;margin-bottom:5px; text-align:justify">
                @if (($sql->Department == 6 || $sql->Department == 3) && $sql->Grade == 65)
                    * Four wheeler entitlements are applicable for personal vehicle or equivalent
                    allowed
                    amount (Rs. 22000/month) can be claimed for hired vehicle. Overall travel by four
                    wheeler & two wheeler should not exceed by more than 3000 km/month.
                @elseif(($sql->Department == 6 || $sql->Department == 3) && $sql->Grade == 66)
                    * Four wheeler entitlements are applicable for personal vehicle or equivalent
                    allowed
                    amount (Rs. 27500/month) can be claimed for hired vehicle. Overall travel by four
                    wheeler & two wheeler should not exceed by more than 3000 km/month.
                @endif
            </p>
        @endif






</body>

</html>
