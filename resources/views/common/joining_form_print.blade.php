@php
use Illuminate\Support\Carbon;
use function App\Helpers\getDistrictName;
use function App\Helpers\getStateName;
use function App\Helpers\getEducationCodeById;
use function App\Helpers\getSpecializationbyId;
use function App\Helpers\getCollegeById;
$sendingId = request()->query('jaid');
$JAId = base64_decode($sendingId);
$Rec = DB::table('jobapply')
    ->join('jobcandidates', 'jobapply.JCId', '=', 'jobcandidates.JCId')
    ->leftJoin('jobpost', 'jobapply.JPId', '=', 'jobpost.JPId')
    ->leftJoin('jf_contact_det', 'jobcandidates.JCId', '=', 'jf_contact_det.JCId')
    ->leftJoin('jf_pf_esic', 'jobcandidates.JCId', '=', 'jf_pf_esic.JCId')
    ->where('JAId', $JAId)
    ->select('jobapply.*', 'jobcandidates.*', 'jobpost.Title as JobTitle', 'jobpost.JobCode', 'jf_contact_det.pre_address', 'jf_contact_det.pre_city', 'jf_contact_det.pre_state', 'jf_contact_det.pre_pin', 'jf_contact_det.pre_dist', 'jf_contact_det.perm_address', 'jf_contact_det.perm_city', 'jf_contact_det.perm_state', 'jf_contact_det.perm_pin', 'jf_contact_det.perm_dist', 'jf_contact_det.cont_one_name', 'jf_contact_det.cont_one_relation', 'jf_contact_det.cont_one_number', 'jf_contact_det.cont_two_name', 'jf_contact_det.cont_two_relation', 'jf_contact_det.cont_two_number', 'jf_pf_esic.UAN', 'jf_pf_esic.PFNumber', 'jf_pf_esic.ESICNumber', 'jf_pf_esic.BankName', 'jf_pf_esic.BranchName', 'jf_pf_esic.IFSCCode', 'jf_pf_esic.AccountNumber', 'jf_pf_esic.PAN', 'jf_pf_esic.Passport')
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

$VnrBusinessRef = DB::table('vnr_business_ref')
    ->where('JCId', $JCId)
    ->get();

$OtherSeed = DB::table('relation_other_seed_cmp')
    ->where('JCId', $JCId)
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
    <title>Interview Joining Form</title>
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
                    <div class="col text-left"><b>Version 1.2</b></div>
                    <div class="col text-center"><b>Joining Form</b></div>
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
                                                @elseif($Rec->Gender == 'F')
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
                    <p style="margin-bottom: 0px;"><b>Total Experience: &emsp;&emsp;
                            @if ($Rec->Professional == 'P')
                                {{ $Rec->TotalYear }}
                                Years {{ $Rec->TotalMonth }} Months
                            @else
                                Fresher
                            @endif
                        </b> </p>
                    <p>कुल कार्य अनुभव : &emsp;&emsp; &emsp;&emsp;
                        @if ($Rec->Professional == 'P')
                            {{ $Rec->TotalYear }} साल {{ $Rec->TotalMonth }} महीना
                        @endif
                    </p>
                </div>


                <div class="row">
                    <div class="col-lg-12">
                        <p class="fw-bold">Emergency Contact Details (आपात्कालीन सम्पर्क विवरण):</p>
                        <table class="table table-bordered text-center">
                            <tr>
                                <th>Contact Person</th>
                                <th>Relationship</th>
                                <th>Contact No.</th>
                            </tr>
                            <tbody>
                                <tr>
                                    <td>{{ $Rec->cont_one_name }}</td>
                                    <td>{{ $Rec->cont_one_relation }}</td>
                                    <td>{{ $Rec->cont_one_number }}</td>
                                </tr>
                                @if ($Rec->cont_two_name != null)
                                    <tr>
                                        <td>{{ $Rec->cont_two_name }}</td>
                                        <td>{{ $Rec->cont_two_relation }}</td>
                                        <td>{{ $Rec->cont_two_number }}</td>
                                @endif
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
                    <div class="col text-left"><b>Version 1.2</b></div>
                    <div class="col text-center"><b>Joining Form</b></div>
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
                                        @if ($Rec->Professional == 'P')
                                            {{ $Rec->PresentCompany }}
                                        @else
                                            Fresher
                                        @endif
                                    </b></td>
                            </tr>
                            <tr>
                                <td><span class="font-weight-bold">Date of Joining (कार्यग्रहण तिथि ):
                                    </span>

                                </td>
                                <td> <b>
                                        @if ($Rec->Professional == 'P')
                                            {{ date('d-m-Y', strtotime($Rec->JobStartDate)) }}

                                        @endif

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

                <div class="row">
                    <div class="col-lg-12">
                        <p class="fw-bold">Social benefit details related to previous employment</p>
                        <table class="table table-bordered text-center">
                            <tr>
                                <td>UAN</td>
                                <td>{{ $Rec->UAN ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>EPFO Code No</td>
                                <td>{{ $Rec->PFNumber ?? '' }}</td>
                            </tr>
                            <tr>

                                <td>ESIC</td>
                                <td>{{ $Rec->ESICNumber ?? '' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <p style="margin-bottom: 0px;"><b>Training & Practical Experience (Other than regular jobs):</b>
                        प्रशिक्षण और व्यावहारिक अनुभव (नियमित नौकरियों के अलावा)
                    </p>
                    <div class="col-md-12">

                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>Name of the Training</th>
                                    <th>Training provided by <br>Organization/Institute</th>
                                    <th>From Date</th>
                                    <th>To Date</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Training as $item)
                                    <tr>
                                        <td>{{ $item->training }}</td>
                                        <td>{{ $item->organization }}</td>
                                        <td>{{ $item->from }}</td>
                                        <td>{{ $item->to }}</td>

                                    </tr>
                                @endforeach
                            </tbody>
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
                    <div class="col text-left"><b>Version 1.2</b></div>
                    <div class="col text-center"><b>Joining Form</b></div>
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
                                    <th>%</th>
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
                                                {{ getEducationCodeById($item->Course) }}
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
                    <div class="table-responsive col-lg-12">
                        <p class="fw-bold mb-1">Language Proficiency</p>
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
                        <p style="margin-bottom:0px ;"><b>Family Details(परिवार का विवरण )</b></p>
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
                    <div class="col text-left"><b>Version 1.2</b></div>
                    <div class="col text-center"><b>Joining Form</b></div>
                    <div class="col ">&emsp;&nbsp;<b>VNR Seeds Pvt. Ltd.</b></div>
                </div>
                <hr style="margin-top: 0px; ">

                <div class="row" style="margin-bottom:0px; marign-top:50px;">

                    <div class="row">
                        <p class="fw-bold mb-1">Other Info</p>
                        @if ($Rec->Professional == 'P')
                            <div class="col-12">
                                <p style="margin-bottom: 0px;"><b>Please give the reference who had worked with you in
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
                        @endif

                        <div class="col-12">
                            <p style="margin-bottom: 0px;"><b>Do you have any acquaintances or relatives working with
                                    VNR Group Companies?</b></p>
                            <p class="mb-0">क्या आपका कोई परिचित या रिश्तेदार वीएनआर ग्रुप कंपनियों के साथ
                                काम कर रहा है? :</p>
                            <p class="mb-0" style="margin-left: 20px;"> <input type="checkbox" @if ($Rec != null && $Rec->VNR_Acq == 'Y')
                                checked
                                @endif> Yes &nbsp; &nbsp;&nbsp; <input type="checkbox" @if ($Rec != null && $Rec->VNR_Acq == 'N')
                                checked
                                @endif> No</p>
                            <table class="table table-borderless {{ $Rec->VNR_Acq == 'N' ? 'd-none' : '' }}"
                                style="width:100%">
                                <thead>
                                    <tr class="text-center">
                                        <th>Name</th>
                                        <th>Mobile </th>
                                        <th>Email</th>
                                        <th>VNR Group /<br>Company Name</th>
                                        <th>Designation</th>
                                        <th>Location</th>
                                        <th>Your Relationship <br>with person mentioned</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($VnrRef as $item)
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->contact }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->company }}
                                                {{ $item->company == 'Other' ? '/ ' . $item->other_company : '' }}
                                            </td>
                                            </td>
                                            <td>{{ $item->designation }}</td>
                                            <td>{{ $item->location }}</td>
                                            <td>{{ $item->rel_with_person }}</td>



                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="col-12">
                            <p style="margin-bottom: 0px;"><b>Do you have any acquaintances or relatives associated with
                                    VNR as business associates (like Dealer, Distributor, Retailer, Organizer, Vendor
                                    etc.)?</b></p>
                            <p class="mb-0">क्या आपका कोई परिचित या रिश्तेदार VNR से व्यावसायिक सहयोगी (जैसे
                                डीलर, वितरक, खुदरा विक्रेता, आयोजक, विक्रेता आदि) के रूप में जुड़ा है?:</p>
                            <p class="mb-0" style="margin-left: 20px;"> <input type="checkbox" @if ($Rec != null && $Rec->VNR_Acq_Business == 'Y')
                                checked
                                @endif> Yes &nbsp; &nbsp;&nbsp; <input type="checkbox" @if ($Rec != null && $Rec->VNR_Acq_Business == 'N')
                                checked
                                @endif> No</p>
                            <table
                                class="table table-borderless {{ $Rec->VNR_Acq_Business == 'N' ? 'd-none' : '' }}"
                                style="width:100%">
                                <thead>
                                    <tr class="text-center">
                                        <th>Name</th>
                                        <th>Mobile </th>
                                        <th>Email</th>
                                        <th>Business Relation <br>With VNR</th>
                                        <th>Location of Business /
                                            acquaintances</th>

                                        <th>Your Relationship <br>with person mentioned</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @foreach ($VnrBusinessRef as $item)
                                        <tr>
                                            <td>{{ $item->Name ?? '' }}</td>
                                            <td>{{ $item->Mobile ?? '' }}</td>
                                            <td>{{ $item->Email ?? '' }}</td>
                                            <td>{{ $item->BusinessRelation ?? '' }}</td>
                                            </td>
                                            <td>{{ $item->Location ?? '' }}</td>
                                            <td>{{ $item->PersonRelation ?? '' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="col-12">
                            <p style="margin-bottom: 0px;"><b>Is any of your relatives or acquaintances is/are working
                                    or associated with any other Seed Company?</b></p>
                            <p class="mb-0">क्या आपका कोई रिश्तेदार या परिचित किसी अन्य सीड कंपनी से जुड़ा
                                है/काम कर रहा है?</p>
                            <p class="mb-0" style="margin-left: 20px;"> <input type="checkbox" @if ($Rec != null && $Rec->OtherSeedRelation == 'Y')
                                checked
                                @endif> Yes &nbsp; &nbsp;&nbsp; <input type="checkbox" @if ($Rec != null && $Rec->OtherSeedRelation == 'N')
                                checked
                                @endif> No</p>
                            <table
                                class="table table-borderless {{ $Rec->OtherSeedRelation == 'N' ? 'd-none' : '' }}"
                                style="width:100%">
                                <thead>
                                    <tr class="text-center">
                                        <th>Name</th>
                                        <th>Mobile </th>
                                        <th>Email</th>
                                        <th>Company Name</th>
                                        <th>Designation</th>
                                        <th>Location</th>
                                        <th>Your Relationship <br>with person mentioned</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @foreach ($OtherSeed as $item)
                                        <tr>
                                            <td>{{ $item->Name ?? '' }}</td>
                                            <td>{{ $item->Mobile ?? '' }}</td>
                                            <td>{{ $item->Email ?? '' }}</td>
                                            <td>{{ $item->CompanyName ?? '' }}</td>
                                            <td>{{ $item->Designation ?? '' }}</td>
                                            <td>{{ $item->Location ?? '' }}</td>
                                            <td>{{ $item->Relation ?? '' }}</td>
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
                    <div class="col text-left"><b>Version 1.2</b></div>
                    <div class="col text-center"><b>Joining Form</b></div>
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
                            that, during my employment, any falsified statements on this application shall be considered
                            sufficient cause for my immediate discharge from the employment of the Company. I hereby
                            authorize investigation of all statements contained herein and employers listed above to
                            give you any and all information concerning my employment, and any pertinent information
                            they may have, and release all parties from all liability for any damage that may result
                            from furnishing same. I understand that I am required to abide by all rules and regulations
                            of the company.
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
                    <div class="col text-left"><b>Version 1.2</b></div>
                    <div class="col text-center"><b>Joining Form</b></div>
                    <div class="col ">&emsp;&nbsp;<b>VNR Seeds Pvt. Ltd.</b></div>
                </div>
                <hr style="margin-top: 0px; ">


                <center style="margin-top: 50px;">
                    <p style="margin-bottom:0px;"><b>Dcoument Details:</b></p>

                </center>
                <div class="row">
                    <div class="col-12">
                        <table class="table table-bordered">
                            <tr>
                                <td style="width: 2%">1</td>
                                <td style="width: 20%">Bank Name</td>
                                <td>{{ $Rec->BankName ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Bank Branch</td>
                                <td>{{ $Rec->BranchName ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Account Number</td>
                                <td>{{ $Rec->AccountNumber ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>IFSC Code</td>
                                <td>{{ $Rec->IFSCCode ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>PAN Number</td>
                                <td>{{ $Rec->PAN ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>Aadhaar Card</td>
                                <td>{{ $Rec->Aadhaar ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>Passport</td>
                                <td>{{ $Rec->Passport ?? '' }}</td>
                            </tr>
                           <tr>
                               <td>8</td>
                               <td>Driving License</td>
                                 <td>{{ $AboutAns->DLNo ?? '' }}</td>
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

    </div>
</body>
<script>
    $(document).ready(function() {
        window.print();
    });
</script>
