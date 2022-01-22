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
    <title>Service Agreement Generation</title>
    <style>
        body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: "Cambria", serif;
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

            /*   height: 297mm; */

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
            margin-bottom: 20px;
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
                /*  width: 216mm;
                height: 356mm;*/
                /*  display: none; */
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
            min-height: 10mm;
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
use function App\Helpers\getStateCode;
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
            value="{{ getCompanyCode($sql->Company) . '_AL-SA/' . getDepartmentCode($sql->Department) . '/' . date('M-Y', strtotime($sql->JoinOnDt)) . '/' . $JAId }}">

        <div id="ServiceAgreement_ltr">

            <div class="page">
                <div class="subpage">
                    <p class="text-center "><b>Service Agreement</b></p>
                    <p style="font-size:16px;"><b>Ref:
                            {{ getCompanyCode($sql->Company) . '_AL-SA/' . getDepartmentCode($sql->Department) . '/' . date('M-Y', strtotime($sql->JoinOnDt)) . '/' . $JAId }}</b>
                        <span style="float:right"><b>Date:
                                @if ($sql->Agr_Date == null)
                                    {{ date('d-M-Y') }}

                                @else
                                    {{ date('d-m-Y', strtotime($sql->Agr_Date)) }}
                                @endif

                        </span></b>
                    </p>

                    <br>


                    <br>
                    <p class="text-center"> This Agreement is made on this
                        @if ($sql->Agr_Date != '')
                            {{ date('dS', strtotime($sql->Agr_Date)) }}
                        @else
                            {{ date('dS') }}
                        @endif
                        day of
                        @if ($sql->Agr_Date != '')
                            {{ date('M', strtotime($sql->Agr_Date)) }}

                        @else
                            {{ date('M') }}

                        @endif,
                        @if ($sql->Agr_Date != '')

                            {{ date('Y', strtotime($sql->Agr_Date)) }}

                        @else
                            {{ date('Y') }}

                        @endif, (and is effective from date
                        {{ date('d-M-Y', strtotime($sql->JoinOnDt)) }} )
                        By and Between
                    </p>
                    <p class="text-justify"><b> {{ getCompanyName($sql->Company) }}</b>, a private limited company
                        incorporated under
                        the
                        provisions of the
                        Companies Act, 1956 and having its Registered and administrative office situated at Corporate
                        Center, Canal Road Crossing, Ring Road No.1, Raipur 492006, C.G. (here in after reffered to as
                        the
                        "Company"), of the First Part;</p>
                    <p class="text-center">AND</p>

                    <p class="text-justify"><b> {{ $sql->Title }} {{ $sql->FName }} {{ $sql->MName }}
                            {{ $sql->LName }}</b>,
                        @if ($sql->Title == 'Mr.')
                            S/o,
                        @else
                            D/o,
                        @endif
                        <b> {{ $sql->FatherTitle }}
                            {{ $sql->FatherName }}</b>,


                        permanentaly residing at {{ $sql->perm_address }}, {{ $sql->perm_city }},
                        Dist-{{ getDistrictName($sql->perm_dist) }} ({{ getStateCode($sql->perm_state) }}) -
                        {{ $sql->perm_pin }}
                        hereinafter referred to as the "Employee" of the Second Part.
                    </p>

                    <p class="text-justify">WHERE AS the company has selected the Employee on the post of
                        {{ getDesignation($sql->Designation) }} at
                        Grade - {{ getGradeValue($sql->Grade) }}, in the Company as per the term and conditions
                        Stipulated in the letter of appointment dated
                        <?= date('d-M-Y', strtotime($sql->A_Date)) ?> and the employee has agreed to abide
                        with the terms and conditions of his employment.
                    </p>
                    <p class="text-justify">NOW THEREFORE, in consideration of the mutual covenants and subject to the
                        terms
                        and conditions hereinafter set forth, the Company and the Employee, intending to be legally
                        bound,
                        mutually covenant and agree as follows:</p>
                    <br>
                    <p style="margin-bottom: 100px;"><b>For, {{ getCompanyName($sql->Company) }}</b></p>

                    <p style="margin-bottom:2px;">----------------------------<span
                            style="float:right">----------------------------</span></p>
                    <p style="margin-bottom: 0px;"><b>Authorized Signatory,</b><span style="float:right">
                            {{ $sql->Title }} {{ $sql->FName }} {{ $sql->MName }} {{ $sql->LName }}
                        </span></p>

                </div>
            </div>

            <div class="page">
                <div class="subpage">
                    <p style="margin-bottom:50px;"></p>
                    <p class="text-center"><u><B>EMPLOYMENT AGREEMENT</B></u></p>
                    <p style="text-align: justify"><b>I, {{ $sql->Title }} {{ $sql->FName }} {{ $sql->MName }}
                            {{ $sql->LName }},
                            @if ($sql->Title == 'Mr.')
                                S/o,
                            @else
                                D/o,
                            @endif
                            {{ $sql->FatherTitle }}
                            {{ $sql->FatherName }}
                        </b> has been offered
                        employment by M/s.
                        {{ getCompanyName($sql->Company) }} and has accepted the employment as per the terms &
                        conditions
                        communicated to
                        me in relation to the same. In addition to confirming my acceptance of all such terms &
                        conditions, I
                        further acknowledge and agree as follows:</p>
                    <ol>
                        <li>I understand that during my employment with the company I will be coming into close contacts
                            with
                            many confidential matters and information not generally available to the public. Further,
                            during my
                            connections with the company, I may be exposed to, or otherwise learn about, various
                            patents,
                            copyrights, trademarks, inventions, manufacturing process and technology, methods or other
                            technical
                            or specialized information which may provide me with the basis of developing new technology,
                            and it
                            may be part of my connections with the Company to assist in developing new technology. In
                            consideration of the Company’s agreeing to provide me with the said opportunity, I am here
                            by
                            agreeing to the provisions of this agreement, with full knowledge that this agreement
                            imposes
                            various restrictions.</li>
                        <li>(a) I agree that during my employment with the Company and at all times thereafter, I will
                            keep
                            and maintain the Confidential Information (defined below), in the strictest secrecy and
                            confidence, and further agree not to, directly or indirectly, use or disclose any of the
                            Confidential Information for the benefit of myself or otherwise, except as authorized in
                            writing by the Company. This restriction shall continue to apply even after the termination
                            of this agreement without limit in time.<br><br>
                            (b) For purposes of this agreement “Confidential Information” shall include trade Secrets
                            and
                            Information pertaining to the following:
                            <ul type="disc">
                                <li>Research & Development, Species used</li>
                                <li>Plant & Machinery, Engineering of the Plant, Designs & Layouts, Material Handling,
                                    Raw
                                    Material Specifications, Consumption Norms, Rejection Parameters etc.</li>
                                <li>Sales, Service, Cost and other Marketing Information including, without limitations;
                                    Customer List, Mailing Lists, Pricing Policies, marketing Plans & Strategies; and
                                    other
                                    Selling Information</li>
                                <li>General business information pertaining to the Company, including, without
                                    limitation;
                                    Financial Information; Sales Volume, Expenses & Margins; Business Strategies;
                                    Operational
                                    Methods; Consulting Contracts; Supplier Information; Purchasing Information; Product
                                    Development; Strategies; Techniques or Plans; Research and Development; Acquisition
                                    Transaction and Personal Plans.</li>
                                <li>Planning, Engineering and Technical Information, including, without limitation
                                    Formulae;
                                    Product Specifications; Product Formulation; Manufacturing Process; Patterns;
                                    Methods;
                                    Plans; and know-how.</li>
                                <li>Any information, which the Company from time to time maintains as confidential
                                    information
                                    or declares to be confidential information, provided the same is not generally
                                    available in
                                    the public domain.</li>
                                <li>Any other information, which is unique to the Company or which, gives the Company an
                                    advantage over competitors who do not have such information.</li>
                            </ul>
                        </li>


                    </ol>
                    <br>
                    <p><b>For, {{ getCompanyName($sql->Company) }}</b></p>

                    <p style="margin-bottom:2px;">----------------------------<span
                            style="float: right">----------------------------</span></p>
                    <p style="margin-bottom: 0px;"><b>Authorized Signatory,</b><span style="float:right">
                            {{ $sql->Title }} {{ $sql->FName }} {{ $sql->MName }} {{ $sql->LName }}
                        </span></p>
                </div>
            </div>

            <div class="page">
                <div class="subpage">
                    <p style="margin-bottom:50px;"></p>
                    <ol start="3">
                        <li>(a) I acknowledge that at any time upon the Company’s request and in any event, upon the
                            termination of my relations with the Company, I will immediately deliver to the Company all
                            Data,
                            Manual, Specifications, Lists, Notes, Memorandum, Writing, Customer or Product Material
                            Whatsoever,
                            including all copies or duplicates (collectively referred to as “Documents” and individually
                            as a
                            “Document”). Any and all such Documents (including, without limitation, any of my won notes
                            which I
                            prepared or maintained in the course of my relations with the Company) are and will be the
                            Company’s
                            property, and these Documents are maintained by me or entrusted to me, on a temporary basis
                            during
                            the course of my relations with the Company, and solely for the purposes of the Company.<br>
                            (b) I agree that, during my relations with the Company and for a period of two years after
                            the
                            terminations of said relations, I will not, directly or indirectly, solicit, nor transact
                            any
                            business, with any customer of or supplier of the Company, nor, during such two-year time
                            period,
                            will I otherwise divert or attempt to divert any existing business of the Company to myself
                            or to
                            any Company or other entity with which I may be associated.<br>
                            (c) I agree that, during my relations with the Company and for a period of two years after
                            the
                            termination of said relations, I will not, directly or indirectly, solicit, induce, recruit
                            or cause
                            another person, in the employee of the Company, to terminate his or her employment with the
                            Company
                            for the purpose of joining, associating with or being employed by or with any business
                            activity with
                            which I am associated or which is in competition with the Company.</li>
                        <li>I Understand and agree that in the course of my relations with the Company, I may have
                            occasion
                            to conceive, Invent or Develop Ideas, Inventions, Improvements, Technological Advancements
                            or other
                            Developments (collectively referred to as “Developments”, and individually as a
                            “Development”). I
                            may create such developments alone or while working with others, and the developments may be
                            developed during working hours or after hours, and may be reduced to practice during my
                            relations
                            with the Company or thereafter. I acknowledge and agree that all such Developments that are
                            within
                            the scope of the Company’s business operations or that relate to any of the Company’s Work,
                            Projects, Products, Field of Expertise or Businesses, are and shall remain the Company’s
                            exclusive
                            property.

                            I agree to assist the Company, at the Company’s expense, to obtain patents for any
                            patentable ideas,
                            inventions or other Developments, and I agree to execute any and all documents necessary to
                            obtain
                            these patents in the Company’s name and to otherwise give full recognition and effect to the
                            Company’s ownership of any such Development. I further agree to give the Company prompt
                            notice of
                            any Development.
                        </li>
                        <li>I understand that this agreement will apply regardless of any changes in my relations with
                            the
                            Company. This agreement will remain in full force and effect, regardless of whether I
                            voluntarily
                            terminate or whether the Company terminates my relations with the Company, and whether such
                            termination is with or without cause.</li>
                        <li>You will not make any statement or shall not disclose/ publish any information about any of
                            the
                            matters of the company before any person or media unless authorized to do so by the
                            management in
                            writing.</li>
                        <li>(a) I understand that if I violate a provision of this agreement, the Company may suffer
                            serious
                            losses, and that the Company shall have the right to various remedies against me. In
                            addition to
                            whatever other rights and remedies the Company may have against me, the Company shall have
                            the
                            following specific rights.
                            <ul type="disc">
                                <li>The right to specific enforcement and/or injunctive relief, and in that regard, I
                                    acknowledge that my breach of my obligations under this agreement may cause
                                    irreparable
                                    damage to the Company and that monetary compensation may not provide an adequate
                                    remedy.
                                </li>
                                <li>The right to require me to account for the pay over to the Company all compensation,
                                    profits, money, accruals, increments, or other benefits which I may derive or
                                    receive
                                    arising from my breach of my obligations to the Company.</li>
                            </ul>
                        </li>

                    </ol>

                    <p><b>For, {{ getCompanyName($sql->Company) }}</b></p>
                    <p style="margin-bottom:2px;">----------------------------<span
                            style="float: right">----------------------------</span></p>
                    <p style="margin-bottom: 0px;"><b>Authorized Signatory,</b><span style="float:right">
                            {{ $sql->Title }} {{ $sql->FName }} {{ $sql->MName }} {{ $sql->LName }}
                        </span></p>
                </div>
            </div>


            <div class="page">
                <p style="margin-bottom:50px;"></p>
                <div class="subpage">
                    <ol start="7">
                        <li> (b) I further agree to reimburse the Company for all of its expenses and damages that it
                            may incur
                            as a result of my violation of any provision of this agreement. This obligation shall
                            include court
                            costs, litigation expenses and reasonable attorney’s fees and disbursement.</li>
                        <li>If any court shall determine that any provision of this agreement, or any part thereof, is
                            invalid or unenforceable, then the remainder of this agreement shall not thereby be affected
                            and the
                            same shall be given full force and effect, without regard to the invalid portions. Without
                            limiting
                            the foregoing, if any court shall determine that any of the provisions of this agreement, or
                            any
                            part thereof, if unenforceable because of the time duration of such provision, or the
                            geographical
                            area or subject matter covered by such restriction, or for any other reason, then I
                            specifically
                            agree that the court may, and I hereby request that the court shall, limit of reduce the
                            time
                            duration, geographical area, subject matter, level, limit, form and substances, which such
                            court may
                            deem reasonable and enforceable, and the undersigned further agree and request that the
                            court shall
                            then enforce such provision in such reduced and limited form.</li>
                        <li>I confirm that this agreement shall not be waived, changed, modified, abandoned or
                            terminated, in
                            whole or in part. I specifically agree that moral waiver or contrary instruction or
                            statement by the
                            Company or any officer or representative of the Company shall apply or be effective, except
                            in a
                            written form, signed by an officer or the Company.</li>
                        <li>The laws of India shall govern this agreement, I consent to, and hereby confer jurisdiction
                            upon, any court of competent jurisdiction in India in connection with any matter pertaining
                            to this
                            agreement. I further consent to service of process upon me, and agree that the same shall be
                            deemed
                            sufficient, if the same is made by means of certified mail, return receipt requested, mailed
                            to my
                            address set forth below. I shall have the right to change such address for service of
                            process and
                            notice under this agreement, by giving notice thereof to the Company by certified mail,
                            return
                            receipt requested. I confirm that the foregoing is not the exclusive method of service. Any
                            notice
                            given under this agreement must be in writing.</li>
                    </ol>
                    <p><b>IN WITNESS WHEREOF,</b> the Parties have set their hands and seal on the day and year above
                        written.</p>
                    <table class="table table-borderless">
                        <tr>
                            <td>Signed and Delivered <br><b>For, {{ getCompanyName($sql->Company) }}</b></td>
                            <td>Signed and Delivered <br></td>
                        </tr>
                        <tr>
                            <td>
                                ----------------------<br>
                                Authorized Signatory
                            </td>
                            <td>
                                ----------------------<br>
                                {{ $sql->Title }} {{ $sql->FName }} {{ $sql->MName }} {{ $sql->LName }}
                            </td>
                        </tr>
                        <tr>
                            <td><b>Witness 1:</b></td>
                            <td><b>Witness 2:</b></td>
                        </tr>
                        <tr>
                            <td>Name: ..............................................</td>
                            <td>Name: ..............................................</td>

                        </tr>
                        <tr>
                            <td>Address: ........................................</td>
                            <td>Address: ........................................</td>

                        </tr>
                        <tr>
                            <td>.............................................................</td>
                            <td>.............................................................</td>
                        </tr>
                        <tr>
                            <td>.............................................................</td>
                            <td>.............................................................</td>
                        </tr>
                        <tr>
                            <td>Contact: ........................................</td>
                            <td>Contact: ........................................</td>
                        </tr>
                        <tr>
                            <td>Signature: ....................................</td>
                            <td>Signature: ....................................</td>
                        </tr>
                    </table>

                </div>
            </div>

        </div>



        <div class="generate" id="generate">
            <center>
                @if ($sql->AgrLtrGen == 'No')
                    <button type="button" class="btn  btn-md text-center btn-success" id="generateLtr"><i
                            class="fa fa-file"></i> Generate Letter</button>
                @endif

                <button id="print" class="btn btn-info btn-md text-center text-light"
                    onclick="printLtr('{{ route('service_agreement_print') }}?jaid={{ base64_encode($JAId) }}');">
                    <i class="fa fa-print"></i> Print</button>
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
            var url = '<?= route('service_agreement_generate') ?>';
            swal.fire({
                title: 'Are you sure?',
                html: 'Generate Service Agreement',
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
                            setTimeout(function() {
                                window.opener.location.reload();
                                window.close();
                            }, 1000);
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
