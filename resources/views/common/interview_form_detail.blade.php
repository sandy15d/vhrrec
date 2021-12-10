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
                    <p style="margin-bottom: 0px;">Post Applied for: &emsp;&emsp;&emsp;&emsp;<b>
                            {{ $Rec->JobTitle }}</b></p>

                    <p>किस पद के लिए आवेदन: </p>
                </div>
                <div class="row">
                    <div class="col-9">

                        <div class="row">
                            <div class="col-12">
                                <table class="table">
                                    <tr>
                                        <td>1. Name (नाम):</td>
                                        <td><b>{{ $Rec->Title }} {{ $Rec->FName }} {{ $Rec->MName }}
                                                {{ $Rec->LName }}
                                            </b></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            2. Date of Birth(जन्म तिथि):
                                        </td>
                                        <td>
                                            <b>
                                                {{ date('d-M-Y', strtotime($Rec->DOB)) }}
                                            </b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            3. Age(आयु):
                                        </td>
                                        <td>
                                            <b>
                                                {{ \Carbon\Carbon::parse($Rec->DOB)->diff(\Carbon\Carbon::now())->format('%y years, %m months and %d days') }})
                                            </b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4. Gender(लिंग):
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
                                            5. Marital Status(वैवाहिक स्थिति):
                                        </td>
                                        <td>
                                            <b>
                                                {{ $Rec->MaritalStatus }}
                                            </b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>6. Religion (धर्म):</td>
                                        <td><b>

                                                @if ($Rec->Religion == 'Others')
                                                    {{ $Rec->OtherReligion }}
                                                @else
                                                    {{ $Rec->Religion }}
                                                @endif

                                            </b></td>
                                    </tr>
                                    <tr>
                                        <td>7. *Category(वर्ग)</td>
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
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        @if ($Rec->CandidateImage == null)
                            <img src="{{ URL::to('/') }}/assets/images/user1.png" width="121" height="157" />
                        @else
                            <img src="{{ URL::to('/') }}/uploads/Picture/{{ $Rec->CandidateImage }}" width="121"
                                height="157" />
                        @endif
                    </div>
                </div>
                <p>*Information collected here is for Govt. Statistical data use only. यहां एकत्रित की गई जानकारी केवल
                    सरकारी सांख्यिकीय डेटा के उपयोग हेतु है।</p>
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
                            <tr>
                                <td colspan="2"><span class="font-weight-bold">E-mail ID (ई- मेल) : </span>
                                    <b>
                                        {{ $Rec->Email }}
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><span class="font-weight-bold">Mobile /Phone No(मोबाइल / दूरभाष संख्या)
                                        :
                                    </span><b>
                                        {{ $Rec->Phone }}
                                    </b>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">Driving License No(ड्राइविंग लाइसेंस):
                                    <b>
                                        {{ $Rec->DrivingLicense }}
                                    </b> <br>Validity (वैद्यता)
                                    <b>
                                        {{ $Rec->LValidity }}
                                    </b>
                                </td>
                            </tr>



                        </table>
                    </div>
                </div>
                <div class="row">

                    <div class="col-12">
                        8.Educational Details (शैक्षाणिक योग्यताये)
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th>Qualification</th>
                                    <th>Year of Passing</th>
                                    <th>Percentage/Grade</th>
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
                    <p><b>9. Details of Current Employment (वर्तमान नौकरी का विवरण)</b></p>
                    <div class="col-12">

                        <table class="table table-borderless">
                            <tr>
                                <td colspan="2"><span class="font-weight-bold">Name of Company (नियोक्ता / कंपनी का नाम
                                        ): </span>
                                    <b>
                                        {{ $Rec->PresentCompany }}
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><span class="font-weight-bold">Date of Joining (कार्यग्रहण तिथि ):
                                    </span>
                                    <b>
                                        {{ date('d-m-Y', strtotime($Rec->JobStartDate)) }}
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><span class="font-weight-bold">Position held (पद ): </span>
                                    <b>
                                        {{ $Rec->Designation }}
                                    </b>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="row">
                        <p style="margin-bottom:5px;"><b>9.1 Present job responsibilities, in brief(वर्तमान कार्य का
                                संक्षिप्त वर्णन):</b></p>
                        <div class="col-12">
                            {{ $Rec->JobResponsibility }}
                            <hr style="margin-bottom:20px;">
                        </div>
                    </div>
                    <div class="row">
                        <p style="margin-bottom: 0px;"><b>9.2 Present Salary details(to be filled accurately)*</b></p>
                        <p>वर्तमान वेतन का वर्णन (कृपया सही विवरण दे)*</p>
                        <div class="col-12">
                            <table class="table table-borderless" style="valign=" middle">
                                <tr>
                                    <td colspan="2"><span class="font-weight-bold">Salary(Per Month) <br>वेतन मासिक
                                        </span>

                                    </td>
                                    <td style="width: 100px;"> <b>
                                            {{ $Rec->GrossSalary }}
                                        </b></td>
                                    <td colspan="2"><span class="font-weight-bold">Annual Package (CTC)
                                            <br>वेतन सालाना
                                        </span>

                                    </td>
                                    <td style="width: 100px;"> <b>
                                            {{ $Rec->CTC }}
                                        </b></td>
                                </tr>

                            </table>
                        </div>
                        <div class="col-md-12 ">
                            <table class="table tabler-borderless">

                                <tr>
                                    <td>DA@ headquarter</td>
                                    <td>DA Outside headquarter</td>
                                    <td>Petrol Allowances</td>
                                    <td>Phone Allowances</td>
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
                                        {{ $Rec->PhoneAlw }}
                                    </td>
                                    <td>
                                        {{ $Rec->HotelElg }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <p style="margin-bottom: 0px;"><b>9.3 Expected Annual Package(CTC):</b> &emsp;&emsp;
                        </p>
                        <p>अपेक्षित सालाना वेतन: {{ $Rec->ExpectedCTC }} </p>

                    </div>
                    <div class="row">
                        <p style="margin-bottom: 0px;"><b>9.4 Notice Period in Current Organization:</b> &emsp;&emsp;

                        </p>
                        <p>वर्तमान कंपनी में कार्य छोड़ने का समय: {{ $Rec->NoticePeriod }} </p>
                    </div>
                    <div class="row">
                        <p style="margin-bottom: 0px;"><b>9.5 Previous Employment Records:</b> &emsp;&emsp;

                        </p>
                        <p>अन्य अन्य कार्योनुभव के विवरण (वर्तमान को छोड़कर )</p>
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
                    <div class="row">
                        <p style="margin-bottom: 0px;"><b>9.6 Total Experience: &emsp;&emsp; {{ $Rec->TotalYear }}
                                Years {{ $Rec->TotalMonth }} Months

                            </b> </p>
                        <p>कुल कार्य अनुभव : &emsp;&emsp; &emsp;&emsp;
                            {{ $Rec->TotalYear }} साल {{ $Rec->TotalMonth }} महीना
                        </p>
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
                <div class="row" style="margin-bottom:0px;">
                    <p style="margin-bottom: 0px;"><b>10. State the reason for which you are seeking for the job
                            change:</b></p>
                    <p style="margin-bottom:0px;">उन कारणों का विवरण दे जिनके कारन आप नए नौकरियों के अवसर तलाश रहे हैं|
                    </p>
                    <div class="col-12">
                        {{ $Rec->ResignReason }}
                        <hr style="margin-bottom:20px;">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <p style="margin-bottom: 0px;"><b>11. What are your strenghts and Areas of Improvement?</b></p>
                        <p>अपने सामर्थ्य एवं उन्नति के क्षेत्रों का उल्लेख करें </p>
                        <table class="table table-bordered ">
                            <tr class="text-center">
                                <td style="width: 50%;"> <b>Strength's (सामर्थ्य)</b></td>
                                <td><b>Areas of Improvements (उन्नति के क्षेत्र)</b></td>
                            </tr>
                            <tr style="height: 25px;" class="text-left">
                                <td>1. {{$Rec->Strength1}}</td>
                                <td>1. {{$Rec->Strength2}}</td>
                            </tr>
                            <tr style="height: 25px;">
                                <td>2. {{$Rec->Improvement1}}</td>
                                <td>2. {{$Rec->Improvement2}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <p style="margin-bottom: 0px;"><b>12. Please mention the source through which you came to know
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
                        <p style="margin-bottom: 0px;"><b>13. ACQUAINTANCES / RELATIVES: Indicate acquaintances
                                /relatives associated with the VNR Group Companies</b></p>
                        <p>परिचित / रिस्तेदार : यदि आपका कोई परिचित / रिस्तेदार वी एन आर ग्रुप कंपनी से संबंधित है तो
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
                    <div class="col-md-12">
                        <center>
                            <p style="margin-bottom:0px ;"><b>Family Details(परिवार का विवरण )</b></p>
                        </center>
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
                    <div class="col-12">
                        <center>
                            <b>Medical Declaration</b>
                        </center>
                        <p style="margin-bottom: 0px;text-align: justify;">In the past or at present, have/are you
                            suffered /suffering from, any form of physical disability or any minor or major illness or
                            deficiency. if yes please mention.</p>
                        <p style="text-align: justify;">अतीत में या वर्तमान में क्या आप किसी भी प्रकार की शारीरिक
                            विकलांगता या किसी भी छोटी या बड़ी बीमारी से पीड़ित रहे हैं या हैं | यदि हाँ , तो कृपया उसका
                            उल्लेख करें | </p>
                        <hr>
                    </div>
                </div>
                <center style="margin-top: 50px;">
                    <p style="margin-bottom:0px;"><b>DECLARATION:</b></p>
                    <p><b>घोषणा</b></p>
                </center>
                <div class="row">
                    <div class="col-12">
                        <p style="text-align: justify;">
                            I hereby declare that all information contained in this application form is true to the best
                            of my knowledge. I understand that if any of the contents/information furnished herein are
                            found to be false or misrepresented, I shal liable to be disqualified for the interview
                            process of the company.
                        </p>
                        <p style="text-align: justify;">
                            मैं एतद द्वारा घोषणा करता हूँ की मेरे द्वारा दी गयी उपरोक्त समस्त जानकारियाँ पूर्ण एवं सत्य
                            है तथा किसी भी स्तर पर असत्य पाए जाने पर इस नौकरी की समस्त प्रक्रियाओं के लिए मेरी साडी
                            पात्रता अयोग्य मानी जाएगी |
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
                <hr style="margin-bottom: 0px; margin-top:290px;">
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
     window.print();
</script>
