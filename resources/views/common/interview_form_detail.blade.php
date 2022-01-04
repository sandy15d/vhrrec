@php
use Illuminate\Support\Carbon;
use function App\Helpers\getDistrictName;
use function App\Helpers\getStateName;
use function App\Helpers\getEducationById;
use function App\Helpers\getSpecializationbyId;
use function App\Helpers\getCollegeById;
$sendingId = request()->query('jaid');
$JAId = base64_decode($sendingId);
$Rec = DB::table('jobapply')
    ->join('jobcandidates', 'jobapply.JCId', '=', 'jobcandidates.JCId')
    ->leftJoin('jobpost', 'jobapply.JPId', '=', 'jobpost.JPId')
    ->leftJoin('jf_contact_det', 'jobcandidates.JCId', '=', 'jf_contact_det.JCId')
    ->leftJoin('jf_pf_esic', 'jobcandidates.JCId', '=', 'jf_pf_esic.JCId')
    ->leftJoin('jf_strength', 'jobcandidates.JCId', '=', 'jf_strength.JCId')
    ->where('JAId', $JAId)
    ->select('jobapply.*', 'jobcandidates.*', 'jobpost.Title as JobTitle', 'jobpost.JobCode', 'jf_contact_det.pre_address', 'jf_contact_det.pre_city', 'jf_contact_det.pre_state', 'jf_contact_det.pre_pin', 'jf_contact_det.pre_dist', 'jf_contact_det.perm_address', 'jf_contact_det.perm_city', 'jf_contact_det.perm_state', 'jf_contact_det.perm_pin', 'jf_contact_det.perm_dist', 'jf_contact_det.cont_one_name', 'jf_contact_det.cont_one_relation', 'jf_contact_det.cont_one_number', 'jf_contact_det.cont_two_name', 'jf_contact_det.cont_two_relation', 'jf_contact_det.cont_two_number', 'jf_pf_esic.UAN', 'jf_pf_esic.PFNumber', 'jf_pf_esic.ESICNumber', 'jf_pf_esic.BankName', 'jf_pf_esic.BranchName', 'jf_pf_esic.IFSCCode', 'jf_pf_esic.AccountNumber', 'jf_pf_esic.PAN', 'jf_strength.Strength1', 'jf_strength.Strength2', 'jf_strength.Improvement1', 'jf_strength.Improvement2')
    ->first();

$JCId = $Rec->JCId;

$FamilyInfo = DB::table('jf_family_det')
    ->where('JCId', $JCId)
    ->get();
$Education = DB::table('candidateeducation')
    ->where('JCId', $JCId)
    ->get();
$Experience = DB::table('jf_work_exp')
    ->where('JCId', $JCId)
    ->get();

$Training = DB::table('jf_tranprac')
    ->where('JCId', $JCId)
    ->get();

$PreRef = DB::table('jf_reference')
    ->where('JCId', $JCId)
    ->where('from', 'Previous Organization')
    ->get();

$VnrRef = DB::table('jf_reference')
    ->where('JCId', $JCId)
    ->where('from', 'VNR')
    ->get();

$AboutAns = DB::table('about_answer')
    ->where('JCId', $JCId)
    ->first();

$lang = DB::table('jf_language')
    ->where('JCId', $JCId)
    ->get();

$OtherDetail = DB::table('pre_job_details')
    ->where('JCId', $JCId)
    ->first();
$Year = Carbon::now()->year;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interview Application Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script>
    <link href="https://fonts.cdnfonts.com/css/roboto" rel="stylesheet">
    <script src="{{ URL::to('/') }}/assets/js/jquery.min.js"></script>
    <style>
        body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            font: 14px "roboto";
        }

        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 20mm;
            margin: 10mm auto;
            border: 1px #D3D3D3 solid;
            border-radius: 5px;
            background: white;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .subpage {
            padding: 0.5cm;
            height: 257mm;
            outline: 2cm #ffffff solid;
        }


        hr {
            display: block;
            height: 2px;
            background: transparent;
            width: 100%;
            border: none;
            border-top: solid 1px #000000;
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

        .table tr,
        .table td,
        .table th {
            padding: .25rem;
            vertical-align: top;
            font-family: "Cambria", serif;
            border: 1px black solid;
            height: 30px;
        }

    </style>
</head>

<body>
    <div class="book">

        <div class="page">
            <div class="subpage">
                <center>
                    <img src="https://www.vnrseeds.com/wp-content/uploads/2018/12/vnr-logo-69x90.png" width="30px">
                </center>
                <div class="row">
                    <div class="col text-left"><b>Version 1.5</b></div>
                    <div class="col text-center"><b>Application Form</b></div>
                    <div class="col ">&emsp;&nbsp;<b>VNR Seeds Pvt. Ltd.</b></div>
                </div>
                <hr style="margin-top: 0px; height:2px; color:red">
                <div class="row">
                    <p style="margin-bottom: 0px;">Post Applied for (किस पद के लिए आवेदन): <b>
                            {{ $Rec->JobTitle }}</b></p>
                </div>
                <div class="row">
                    <div class="col-9">

                        <div class="row">
                            <div class="col-12">
                                <table class="table">
                                    <tr>
                                        <td>Name (नाम):</td>
                                        <td><b>{{ $Rec->Title }} {{ $Rec->FName }} {{ $Rec->MName }}
                                                {{ $Rec->LName }}
                                            </b></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Date of Birth(जन्म तिथि):
                                        </td>
                                        <td>
                                            <b>
                                                {{ date('d-M-Y', strtotime($Rec->DOB)) }}
                                            </b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Age(आयु):
                                        </td>
                                        <td>
                                            <b>
                                                {{ \Carbon\Carbon::parse($Rec->DOB)->diff(\Carbon\Carbon::now())->format('%y years, %m months and %d days') }}
                                            </b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Gender(लिंग):
                                        </td>
                                        <td>
                                            <b>
                                                @if ($Rec->Gender == 'M')
                                                    Male
                                                @elseif($Rec->Gender=='F')
                                                    Female

                                                @else
                                                    Other
                                                @endif
                                            </b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Nationality(राष्ट्रीयता):
                                        </td>
                                        <td>
                                            <b>
                                                {{ $Rec->MaritalStatus }}
                                            </b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Religion (धर्म):</td>
                                        <td><b>

                                                @if ($Rec->Religion == 'Others')
                                                    {{ $Rec->OtherReligion }}
                                                @else
                                                    {{ $Rec->Religion }}
                                                @endif

                                            </b></td>
                                    </tr>
                                    <tr>
                                        <td>*Category(वर्ग)</td>
                                        <td>
                                            <b>&check;
                                                @if ($Rec->Caste == 'Other')
                                                    {{ $Rec->OtherCaste }}
                                                @else
                                                    {{ $Rec->Caste }}
                                                @endif

                                            </b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Marital Status(वैवाहिक स्थिति):
                                        </td>
                                        <td>
                                            <b>
                                                {{ $Rec->MaritalStatus }}
                                            </b>
                                        </td>
                                    </tr>

                                    @if ($Rec->MaritalStatus == 'Married')
                                        <tr>
                                            <td>
                                                Spouse Name(पति/पत्नी का नाम):
                                            </td>
                                            <td>
                                                <b>
                                                    {{ $Rec->SpouseName }}
                                                </b>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                Marriage Anniversary <br> (विवाह की तिथि):
                                            </td>
                                            <td>
                                                <b>
                                                    {{ date('d-M-Y', strtotime($Rec->MarriageDate)) }}
                                                </b>
                                            </td>
                                        </tr>

                                    @endif


                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        @if ($Rec->CandidateImage == null)
                            <img src="{{ URL::to('/') }}/assets/images/user1.png" width="100" height="140" />
                        @else
                            <img src="{{ URL::to('/') }}/uploads/Picture/{{ $Rec->CandidateImage }}" width="100"
                                height="140" />
                        @endif
                    </div>
                </div>

                <p>*Information collected here is for Govt. Statistical data use only. यहां एकत्रित की गई जानकारी केवल
                    सरकारी सांख्यिकीय डेटा के उपयोग हेतु है।</p>

                <p class="fw-bold">Contact Details (संपर्क विवरण) :</p>
                <div class="row">
                    <div class="col-12">
                        <table class="table table-borderless">

                            <tr>
                                <td colspan="2"><span class="font-weight-bold">E-mail ID (ई- मेल) : </span>
                                    <b>
                                        {{ $Rec->Email }} @if ($Rec->Email2 != null)
                                            , {{ $Rec->Email2 }}

                                        @endif
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><span class="font-weight-bold">Mobile /Phone No(मोबाइल / दूरभाष संख्या)
                                        :
                                    </span><b>
                                        {{ $Rec->Phone }} @if ($Rec->Phone2 != null)
                                            , {{ $Rec->Phone2 }}
                                        @endif
                                    </b>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>


                <div class="row">
                    <div class="col-12">
                        <table class="table table-borderless">
                            <tr>
                                <td class="text-center fw-bold">Present Address <br> पत्र व्यव्हार का पता</td>
                                <td class="text-center fw-bold">Permanent Address <br>स्थायी पता</td>
                            </tr>
                            <tr>
                                <td>
                                    {{ $Rec->pre_address }}, {{ $Rec->pre_city }},
                                    {{ getDistrictName($Rec->pre_dist) }}, {{ getStateName($Rec->pre_state) }},
                                    {{ $Rec->pre_pin ?? '-' }}
                                </td>
                                <td>
                                    {{ $Rec->perm_address }}, {{ $Rec->perm_city }},
                                    {{ getDistrictName($Rec->perm_dist) }}, {{ getStateName($Rec->perm_state) }},
                                    {{ $Rec->perm_pin }}
                                </td>
                            </tr>


                        </table>
                    </div>
                </div>


                <div class="row">
                    <p style="margin-bottom: 0px;"><b>Total Experience: &emsp;&emsp; {{ $Rec->TotalYear }}
                            Years {{ $Rec->TotalMonth }} Months

                        </b> </p>
                    <p>कुल कार्य अनुभव : &emsp;&emsp; &emsp;&emsp;
                        {{ $Rec->TotalYear }} साल {{ $Rec->TotalMonth }} महीना
                    </p>
                </div>


                <div class="row">
                    <div class="col-12">
                        <p style="margin-bottom: 0px;"><b>Please mention the source through which you came to know
                                about this job opening:</b></p>
                        <p style="marign-bottom:0px;">कृपया उस स्त्रोत का नाम बताये जहाँ से आपको इस नौकरी के विषय में
                            पता चला:</p>
                        <div class="row">
                            <div class="col-4">
                                <input type="checkbox" @if ($Rec->ResumeSource == 1)
                                checked
                                @endif> Company Career Site
                            </div>
                            <div class="col">
                                <input type="checkbox" @if ($Rec->ResumeSource == 2)
                                checked
                                @endif> Naukari.com
                            </div>
                            <div class="col">
                                <input type="checkbox" @if ($Rec->ResumeSource == 3)
                                checked
                                @endif> LinkedIn
                            </div>
                            <div class="col">
                                <input type="checkbox" @if ($Rec->ResumeSource == 4)
                                checked
                                @endif> Walk-in
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <input type="checkbox" @if ($Rec->ResumeSource == 5)
                                checked
                                @endif> Ref. from VNR Employee
                            </div>
                            <div class="col-4">
                                <input type="checkbox" @if ($Rec->ResumeSource == 6)
                                checked
                                @endif> Placement Agencies
                            </div>
                            <div class="col-4" @if ($Rec->ResumeSource == 8)
                                checked
                                @endif>
                                <input type="checkbox"> Any other
                            </div>
                        </div>
                        <p>* Please provide Name & Contact nos. of person, if came through any referral or Consultancy:
                        </p>
                    </div>
                </div>


                <div class="row">
                    <div class="col-12">
                        <hr style="margin-bottom: 2px;">
                        <center>
                            <p class="row" style="margin-top: 0px;">
                                Date of Release: 09 September 2019
                                &emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;Released by
                                HRD
                                &emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;&emsp;Page 1
                            </p>
                        </center>
                    </div>
                </div>
            </div>
        </div>

        <div class="page">
            <div class="subpage">
                <center>
                    <img src="https://www.vnrseeds.com/wp-content/uploads/2018/12/vnr-logo-69x90.png" width="30px">
                </center>
                <div class="row">
                    <div class="col text-left"><b>Version 1.5</b></div>
                    <div class="col text-center"><b>Application Form</b></div>
                    <div class="col ">&emsp;&nbsp;<b>VNR Seeds Pvt. Ltd.</b></div>
                </div>
                <hr style="margin-top: 0px;">

                <div class="row">
                    <p><b>Details of Current Employment (वर्तमान नौकरी का विवरण)</b></p>
                    <div class="col-12">
                        <table class="table table-borderless">
                            <tr>
                                <td style="width: 70%"><span class="font-weight-bold">Name of Company (नियोक्ता / कंपनी
                                        का नाम
                                        ): </span>

                                </td>
                                <td> <b>
                                        {{ $Rec->PresentCompany }}
                                    </b></td>
                            </tr>
                            <tr>
                                <td><span class="font-weight-bold">Date of Joining (कार्यग्रहण तिथि ):
                                    </span>

                                </td>
                                <td> <b>
                                        {{ date('d-m-Y', strtotime($Rec->JobStartDate)) }}
                                    </b></td>
                            </tr>
                            <tr>
                                <td><span class="font-weight-bold">Designation (पद ): </span>

                                </td>
                                <td> <b>
                                        {{ $Rec->Designation }}
                                    </b></td>
                            </tr>

                            <tr>
                                <td><span class="font-weight-bold">Annual Package(CTC) (वेतन सालाना):
                                </td>
                                <td>
                                    <b>
                                        {{ $Rec->CTC ?? '' }}
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="font-weight-bold">Salary (Per Month)(वेतन मासिक):


                                </td>
                                <td>
                                    <b>
                                        {{ $Rec->GrossSalary ?? '' }}
                                    </b>
                                </td>
                            </tr>

                            <tr>
                                <td><span class="font-weight-bold">Notice Period in Current Organization <br> (वर्तमान
                                        कंपनी में कार्य छोड़ने का समय):
                                    </span>
                                </td>
                                <td>
                                    <b>
                                        {{ $Rec->NoticePeriod ?? '' }}
                                    </b>

                                </td>
                            </tr>
                            <tr>
                                <td><span class="font-weight-bold">State the reason for which you are seeking for the
                                        job
                                        change (उन कारणों का विवरण दे जिनके कारन आप नए नौकरियों के अवसर तलाश रहे हैं):
                                    </span>

                                </td>
                                <td> <b>
                                        {{ $Rec->ResignReason }}
                                    </b></td>
                            </tr>
                            <tr>
                                <td><span class="font-weight-bold">Expected Annual Package(CTC) (अपेक्षित सालाना वेतन):
                                    </span>

                                </td>
                                <td> <b>
                                        {{ $Rec->ExpectedCTC }}
                                    </b></td>
                            </tr>

                        </table>
                    </div>
                </div>

                <div class="row mb-1">
                    <p style="margin-bottom:5px;"><b>Present job responsibilities, in brief(वर्तमान कार्य का
                            संक्षिप्त वर्णन):</b></p>
                    <div class="col-12">
                        <u> {{ $Rec->JobResponsibility }}</u>

                    </div>
                </div>

                <div class="row">
                    <p style="margin-bottom: 0px;"><b>Other allowances details (to be filled accurately)*</b></p>
                    <p>अन्य भत्तों का वर्णन (कृपया सही विवरण दे)*</p>
                    <div class="col-md-12 ">
                        <table class="table tabler-borderless">

                            <tr>
                                <td>DA@ headquarter</td>
                                <td>DA Outside headquarter</td>
                                <td>Petrol Allowances</td>

                                <td>Hotel Eligibility</td>
                            </tr>
                            <tr style="height:30px;">
                                <td>
                                    {{ $Rec->DAHq }}
                                </td>
                                <td>
                                    {{ $Rec->DAOutHq }}
                                </td>
                                <td>
                                    {{ $Rec->PetrolAlw }}
                                </td>

                                <td>
                                    {{ $Rec->HotelElg }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <p style="margin-bottom: 0px;"><b>Previous Employment Records:</b> अन्य अन्य कार्योनुभव के विवरण
                        (वर्तमान को छोड़कर )
                    </p>
                    <div class="col-md-12">

                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>Name of the Employer</th>
                                    <th>Designation</th>
                                    <th>Job Start Date</th>
                                    <th>Job End Date</th>
                                    <th>Gross Monthly Salary</th>
                                    <th>Annual CTC</th>
                                    <th>Reason for Leave</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Experience as $item)
                                    <tr>
                                        <td>{{ $item->company }}</td>
                                        <td>{{ $item->desgination }}</td>
                                        <td>{{ $item->job_start }}</td>
                                        <td>{{ $item->job_end }}</td>
                                        <td>{{ $item->gross_mon_sal }}</td>
                                        <td>{{ $item->annual_ctc }}</td>
                                        <td>{{ $item->reason_fr_leaving }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <hr style="margin-bottom: 2px;">
                <center>
                    <p class="row" style="margin-top: 0px;">
                        Date of Release: 09 September 2019 &emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;Released by
                        HRD
                        &emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;&emsp;Page 2
                    </p>
                </center>
            </div>

        </div>

        <div class="page">
            <div class="subpage">
                <center>
                    <img src="https://www.vnrseeds.com/wp-content/uploads/2018/12/vnr-logo-69x90.png" width="30px">
                </center>
                <div class="row">
                    <div class="col text-left"><b>Version 1.5</b></div>
                    <div class="col text-center"><b>Application Form</b></div>
                    <div class="col ">&emsp;&nbsp;<b>VNR Seeds Pvt. Ltd.</b></div>
                </div>
                <hr style="margin-top: 0px;">

                <div class="row">
                    <div class="col-12">
                        <p class="fw-bold"> Educational Details (शैक्षाणिक योग्यताये)</p>
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th>Qualification</th>
                                    <th>Year of Passing</th>
                                    <th>Percentage</th>
                                    <th>University / College</th>
                                    <th>Course</th>
                                    <th>Specialization</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Education as $item)
                                    <tr>
                                        <td>{{ $item->Qualification }}</td>

                                        <td>{{ $item->YearOfPassing ?? '-' }}</td>
                                        <td>{{ $item->CGPA ?? '-' }}</td>
                                        <td>
                                            @if ($item->Institute != null)
                                                {{ getCollegeById($item->Institute) }}

                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->Course != null)
                                                {{ getEducationById($item->Course) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if (is_null($item->Specialization))
                                                -
                                            @else
                                                {{ getSpecializationbyId($item->Specialization) }}

                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <p class="fw-bold">About Yourself</p>
                <div class="row">
                    <div class="col-lg-12">
                        <p class="mb-0 fw-bold text-justify">a) What is your aim in life?</p>
                        <p class="mb-0" style="margin-left: 20px;">{{ $AboutAns->AboutAim ?? '' }}</p>

                        <p class="mb-0 fw-bold text-justify">b) What are your hobbies and interest?</p>
                        <p class="mb-0" style="margin-left: 20px;">{{ $AboutAns->AboutHobbi ?? '' }}</p>

                        <p class="mb-0 fw-bold text-justify">c) Where do you see yourself 5 Years from now?</p>
                        <p class="mb-0" style="margin-left: 20px;">{{ $AboutAns->About5Year ?? '' }}</p>

                        <p class="mb-0 fw-bold text-justify">d) What are your greatest personal assets (qualities,
                            skills,
                            abilities) which make you successful in the jobs you take up?</p>
                        <p class="mb-0" style="margin-left: 20px;">{{ $AboutAns->AboutAssets ?? '' }}</p>

                        <p class="mb-0 fw-bold">e) What are your Strengths?</p>
                        <p class="mb-0" style="margin-left: 20px;">{{ $AboutAns->AboutStrength ?? '' }}</p>

                        <p class="mb-0 fw-bold">f) What are your areas where you think you need to improve yourself?
                        </p>
                        <p class="mb-0" style="margin-left: 20px;">{{ $AboutAns->AboutImprovement ?? '' }}
                        </p>

                        <p class="mb-0 fw-bold text-justify">g) In the past or at present, have/are you suffered
                            /suffering from,
                            any form of physical disability or any minor or major illness or deficiency?</p>
                        <p class="mb-0" style="margin-left: 20px;">{{ $AboutAns->AboutDeficiency ?? '' }}
                        </p>

                        <p class="mb-0 fw-bold">h) Have You Been criminally prosecuted? </p>
                        <p class=" mb-0" style="margin-left: 20px;"> <input type="checkbox" @if ($AboutAns != null && $AboutAns->CriminalChk == 'Y')
                            checked
                            @endif> Yes &nbsp; &nbsp;&nbsp; <input type="checkbox" @if ($AboutAns != null && $AboutAns->CriminalChk == 'N')
                            checked
                            @endif> No</p>
                        @if ($AboutAns != null && $AboutAns->AboutCriminal == 'Y')
                            <p class="mb-0" style="margin-left: 20px;">{{ $AboutAns->AboutCriminal ?? '' }}
                            </p>

                        @endif


                        <p class="mb-0 fw-bold">i) Do you have a valid driving licence? </p>
                        <p class=" mb-0" style="margin-left: 20px;"> <input type="checkbox" @if ($AboutAns != null && $AboutAns->LicenseChk == 'Y')
                            checked
                            @endif> Yes &nbsp; &nbsp;&nbsp; <input type="checkbox" @if ($AboutAns != null && $AboutAns->LicenseChk == 'N')
                            checked
                            @endif> No</p>
                        @if ($AboutAns != null && $AboutAns->LicenseChk == 'Y')
                            <p class="mb-0" style="margin-left: 20px;"><span class="fw-bold">Drivining
                                    License:</span>
                                {{ $AboutAns->DLNo ?? '' }} <span style="margin-left: 20px;"
                                    class="fw-bold">Validity:
                                    {{ $AboutAns->LValidity ?? '' }}</span></p>
                        @endif

                    </div>
                </div>

                <hr style="margin-bottom: 0px;">
                <center>
                    <p class="row" style="margin-top: 0px;">
                        Date of Release: 09 September 2019 &emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;Released by
                        HRD
                        &emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;&emsp;Page 3
                    </p>
                </center>
            </div>
        </div>

        <div class="page">
            <div class="subpage">
                <center>
                    <img src="https://www.vnrseeds.com/wp-content/uploads/2018/12/vnr-logo-69x90.png" width="30px">
                </center>
                <div class="row">
                    <div class="col text-left"><b>Version 1.5</b></div>
                    <div class="col text-center"><b>Application Form</b></div>
                    <div class="col ">&emsp;&nbsp;<b>VNR Seeds Pvt. Ltd.</b></div>
                </div>
                <hr style="margin-top: 0px; ">

                <div class="row" style="margin-bottom:0px; marign-top:50px;">

                    <div class="row">
                        <div class="col-12">
                            <p class="fw-bold mb-1">Other Info</p>
                            <p style="margin-bottom: 0px;"><b>a) Please give the reference who had worked with you in
                                    the previous organization </b></p>
                            <table class="table table-borderless">
                                <thead>
                                    <tr class="text-center">
                                        <th>Name</th>
                                        <th>Company</th>
                                        <th>Designation</th>
                                        <th>Contact</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($PreRef as $item)
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->company }}</td>
                                            <td>{{ $item->designation }}</td>
                                            <td>{{ $item->contact }}</td>
                                            <td>{{ $item->email }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="col-12">
                            <p style="margin-bottom: 0px;"><b>b) ACQUAINTANCES / RELATIVES: Indicate acquaintances
                                    /relatives associated with the VNR Group Companies</b></p>
                            <p>परिचित / रिस्तेदार : यदि आपका कोई परिचित / रिस्तेदार वी एन आर ग्रुप कंपनी से संबंधित है
                                तो
                                उल्लेख करे :</p>

                            <table class="table table-borderless">
                                <thead>
                                    <tr class="text-center">
                                        <th>Name</th>
                                        <th>Relationship</th>
                                        <th>Designation</th>
                                        <th>Contact</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($VnrRef as $item)
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->rel_with_person }}</td>
                                            <td>{{ $item->designation }}</td>
                                            <td>{{ $item->contact }}</td>
                                            <td>{{ $item->email }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="row">
                        <div class="table-responsive col-lg-12">
                            <p class="fw-bold mb-1">c)Language Proficiency</p>
                            <table class="table">
                                <thead>
                                    <tr class="text-center fw-bold">
                                        <td>Language</td>
                                        <td>Reading</td>
                                        <td>Writing</td>
                                        <td>Speaking</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lang as $item)
                                        <tr class="text-center">
                                            <td>{{ $item->language }}</td>
                                            <td>{{ $item->read == 1 ? 'Yes' : 'No' }}</td>
                                            <td>{{ $item->write == 1 ? 'Yes' : 'No' }}</td>
                                            <td>{{ $item->speak == 1 ? 'Yes' : 'No' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-12">
                            <p style="margin-bottom:0px ;"><b>d)Family Details(परिवार का विवरण )</b></p>
                            <table class="table table-borderless">
                                <thead>
                                    <tr class="text-center">
                                        <th>Relationship</th>
                                        <th>Name</th>
                                        <th>Date of Birth</th>
                                        <th>Qualification</th>
                                        <th>Occupation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($FamilyInfo as $item)
                                        <tr>
                                            <td>{{ $item->relation }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ date('d-M-Y', strtotime($item->dob)) }}</td>
                                            <td>{{ $item->qualification }}</td>
                                            <td>{{ $item->occupation }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>


                </div>



                <hr style="margin-bottom: 0px; margin-top:20px;">
                <center>
                    <p class="row" style="margin-top: 0px;">
                        Date of Release: 09 September 2019 &emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;Released by
                        HRD
                        &emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;&emsp;Page 4
                    </p>
                </center>
            </div>
        </div>

        <div class="page">
            <div class="subpage">
                <center>
                    <img src="https://www.vnrseeds.com/wp-content/uploads/2018/12/vnr-logo-69x90.png" width="30px">
                </center>
                <div class="row">
                    <div class="col text-left"><b>Version 1.5</b></div>
                    <div class="col text-center"><b>Application Form</b></div>
                    <div class="col ">&emsp;&nbsp;<b>VNR Seeds Pvt. Ltd.</b></div>
                </div>
                <hr style="margin-top: 0px; ">


                <center style="margin-top: 50px;">
                    <p style="margin-bottom:0px;"><b>DECLARATION:</b></p>
                    <p><b>घोषणा</b></p>
                </center>
                <div class="row">
                    <div class="col-12">
                        <p style="text-align: justify;">
                            I hereby declare that all the information’s and facts set forth in this application and any
                            supplemental information is true and complete to the best of my knowledge. I understand
                            that, if employed, falsified statements on this application shall be considered sufficient
                            cause for immediate discharge. I hereby authorize investigation of all statements contained
                            herein and employers listed above to give you any and all information concerning my
                            employment, and any pertinent information they may have, and release all parties from all
                            liability for any damage that may result from furnishing same. I understand that neither the
                            completion of this application nor any other part of my consideration for employment
                            establishes any obligation for the company to hire me. I understand that I am required to
                            abide by all rules and regulations of the company
                        </p>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-12">
                        <table class="table table-borderless">
                            <tr style="border: none;">
                                <td style="width: 70%; border: none;">Place (स्थान)</td>
                                <td style="width: 50%; border: none;">______________________________</td>
                            </tr>
                            <tr style="width: 50%; border: none;">
                                <td style="width: 50%; border: none;">
                                    Date(दिनांक):
                                </td>
                                <td style="width: 50%; border: none;">
                                    Signature of the applicant<br>
                                    आवेदक के हस्ताक्षर
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <hr style="margin-bottom: 0px; margin-top:380px;">
                <center>
                    <p class="row" style="margin-top: 0px;">
                        Date of Release: 09 September 2019 &emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;Released by
                        HRD
                        &emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;&emsp;Page 4
                    </p>
                </center>
            </div>
        </div>

        <div class="page">
            <div class="subpage">
                <center>
                    <img src="https://www.vnrseeds.com/wp-content/uploads/2018/12/vnr-logo-69x90.png" width="30px">
                </center>
                <div class="row">
                    <div class="col text-left"><b>Version 1.5</b></div>
                    <div class="col text-center"><b>Application Form</b></div>
                    <div class="col ">&emsp;&nbsp;<b>VNR Seeds Pvt. Ltd.</b></div>
                </div>
                <hr style="margin-top: 0px; ">

                <div class="row" style="margin-bottom:0px; marign-top:50px;">
                    <div class="row">
                        <div class="col-lg-12">
                            <p class="fw-bold mb-0">Reporting Details:</p>
                            <table class="table">
                                <tr>
                                    <td class="fw-bold" style="width: 50%">Reporting Manager Name</td>
                                    <td>{{ $Rec->Reporting ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Reporting Manager's Designation</td>
                                    <td>{{ $Rec->RepDesig ?? '' }}</td>
                                </tr>
                            </table>

                            <table class="table">
                                <tr>
                                    <td rowspan="2" style="width: 50%" class="fw-bold">No of employees <br>
                                        directly reporting to you</td>
                                    <td class="fw-bold">On roll employees</td>
                                    <td class="fw-bold">Third party employees</td>
                                </tr>
                                <tr>

                                    <td class="text-center"> {{ $OtherDetail->OnRollRepToMe ?? '' }}</td>
                                    <td class="text-center"> {{ $OtherDetail->ThirdPartyRepToMe ?? '' }}</td>

                                </tr>

                            </table>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <p class="fw-bold mb-0">Working Territory Details (mention the name of District or Area's
                            Covered)</p>
                        <p>{{ $OtherDetail->TerritoryDetails ?? '' }}</p>
                    </div>

                    <div class="col-lg-12">
                        <p class="fw-bold mb-0">Business Turnover Details:</p>
                        <table class="table text-center">
                            <tr>
                                <th>Business Turnover</th>
                                <th>Current Year <br>(in lakh's)</th>
                                <th>Previous Year <br>(in lakh's)</th>
                            </tr>
                            <tr>
                                <td class="fw-bold">Vegetable Business</td>
                                <td>{{ $OtherDetail->VegCurrTurnOver ?? '' }}</td>
                                <td>{{ $OtherDetail->VegPreTurnOver ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Field Crop Business</td>
                                <td>{{ $OtherDetail->FieldCurrTurnOver ?? '' }}</td>
                                <td>{{ $OtherDetail->FieldPreTurnOver ?? '' }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-lg-12">
                        <p class="fw-bold mb-0">Incentive Plan Details:</p>
                        <table class="table text-center">
                            <tr>
                                <th>Incentive Payment Duration</th>
                                <th>Incentive Amount (in Rs.)</th>
                            </tr>
                            <tr>
                                <td class="fw-bold">Monthly</td>
                                <td>{{ $OtherDetail->MonthlyIncentive ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Quarterly</td>
                                <td>{{ $OtherDetail->QuarterlyIncentive ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Half Yearly</td>
                                <td>{{ $OtherDetail->HalfYearlyIncentive ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Annually</td>
                                <td>{{ $OtherDetail->AnnuallyIncentive ?? '' }}</td>
                            </tr>
                        </table>
                    </div>

                    <p class="fw-bold mb-0">Any other details related to incentive plan:</p>
                    <p>{{ $OtherDetail->AnyOtheIncentive }}</p>

                    <div class="row">
                        <div class="col-lg-12">
                            <p class="fw-bold mb-1">Company Vehicle Policy (select whichever is appliable to you):
                            </p>

                            @if ($OtherDetail->TwoWheelChk != null && $OtherDetail->TwoWheelChk == '1')
                                <input type="checkbox" name="" id="" checked> 2 Wheeler
                                <table class="table">
                                    <tr>
                                        <td>Ownership Type</td>
                                        <td>{{ $OtherDetail->TwoWheelOwnerType == 'W' ? 'Own' : 'Provided by Company' }}
                                            @if ($OtherDetail->TwoWheelOwnerType == 'C')
                                                - Rs. {{ $OtherDetail->TwoWheelAmount ?? '' }}
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Petrol Allowances</td>
                                        <td>
                                            Rs. {{ $OtherDetail->TwoWheelPetrol ?? '' }}
                                            {{ $OtherDetail->TwoWheelPetrolTerm ?? '' }}
                                        </td>
                                    </tr>
                                </table>
                            @endif

                            @if ($OtherDetail->FourWheelChk != null && $OtherDetail->FourWheelChk == '1')
                                <input type="checkbox" name="" id="" checked> 4 Wheeler
                                <table class="table">
                                    <tr>
                                        <td>Ownership Type</td>
                                        <td>{{ $OtherDetail->FourWheelOwnerType == 'W' ? 'Own' : 'Provided by Company' }}
                                            @if ($OtherDetail->FourWheelOwnerType == 'C')
                                                - Rs. {{ $OtherDetail->FourWheelAmount ?? '' }}
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Petrol Allowances</td>
                                        <td>
                                            Rs. {{ $OtherDetail->FourWheelPetrol ?? '' }}
                                            {{ $OtherDetail->FourWheelPetrolTerm ?? '' }}
                                        </td>
                                    </tr>
                                </table>
                            @endif

                        </div>
                    </div>
                </div>


                <hr style="margin-bottom: 0px; margin-top:20px;">
                <center>
                    <p class="row" style="margin-top: 0px;">
                        Date of Release: 09 September 2019 &emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;Released by
                        HRD
                        &emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;&emsp;Page 4
                    </p>
                </center>
            </div>
        </div>

        <div class="page">
            <div class="subpage">
                <center>
                    <img src="https://www.vnrseeds.com/wp-content/uploads/2018/12/vnr-logo-69x90.png" width="30px">
                </center>
                <div class="row">
                    <div class="col text-left"><b>Version 1.5</b></div>
                    <div class="col text-center"><b>Application Form</b></div>
                    <div class="col ">&emsp;&nbsp;<b>VNR Seeds Pvt. Ltd.</b></div>
                </div>
                <hr style="margin-top: 0px; ">

                <div class="row" style="margin-bottom:0px; marign-top:50px;">
                    <div class="row">
                        <div class="col-lg-12">
                            <p class="fw-bold mb-0">Other Benefit details (select whichever is applicable and mention
                                the details):</p>
                            <table class="table text-center">
                                <tr>
                                    <th>Particulars</th>
                                    <th>Amount</th>
                                </tr>
                                <tr>
                                    <td>DA @ Headquarter</td>
                                    <td>Rs. {{ $Rec->DAHq ?? '' }}/- Per Day </td>
                                </tr>
                                <tr>
                                    <td>DA outside Headquarter</td>
                                    <td>Rs. {{ $Rec->DAOutHq ?? '' }}/- Per Day </td>
                                </tr>
                                <tr>
                                    <td>Lodging eligibility</td>
                                    <td>Rs. {{ $Rec->HotelElg ?? '' }}/- Per Day </td>
                                </tr>
                                <tr>
                                    <td>Medical Insurance</td>
                                    <td>Rs. {{ $Rec->Medical ?? '' }} </td>
                                </tr>
                                <tr>
                                    <td>Group Term Insurance</td>
                                    <td>Rs. {{ $Rec->GrpTermIns ?? '' }} </td>
                                </tr>
                                <tr>
                                    <td>Group Personal Accident Insurance</td>
                                    <td>Rs. {{ $Rec->GrpPersonalAccIns ?? '' }} </td>
                                </tr>
                                <tr>
                                    <td>Mobile Handset</td>
                                    <td>Rs. {{ $Rec->MobileHandset ?? '' }} </td>
                                </tr>
                                <tr>
                                    <td>Mobile Bill reimbursement</td>
                                    <td>Rs. {{ $Rec->MobileBill ?? '' }} </td>
                                </tr>
                                <tr>
                                    <td>Travel eligibilities</td>
                                    <td>{{ $Rec->TravelElg ?? '' }} </td>
                                </tr>
                            </table>


                        </div>

                        <div class="col-lg-12">
                            <p class="fw-bold mb-1">Any other benefit:</p>
                            <p>{{$OtherDetail->OtherBenifit ?? ''}}</p>
                        </div>
                    </div>


                </div>


                <hr style="margin-bottom: 0px; margin-top:20px;">
                <center>
                    <p class="row" style="margin-top: 0px;">
                        Date of Release: 09 September 2019 &emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;Released by
                        HRD
                        &emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;&emsp;Page 4
                    </p>
                </center>
            </div>
        </div>

    </div>
</body>
<script>
    $(document).ready(function() {
        window.print();
    });
</script>
