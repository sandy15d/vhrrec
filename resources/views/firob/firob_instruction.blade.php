@php
$JCId = base64_decode(request()->query('jcid'));
$query = DB::table('jobcandidates')
    ->where('JCId', $JCId)
    ->select('FName', 'MName', 'LName', 'ReferenceNo', 'CandidateImage')
    ->first();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="{{ URL::to('/') }}/assets/firob/img/favicon.ico">
    <title>FIRO B</title>
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/firob/css/style.default.css" type="text/css" />
    <link href="{{ URL::to('/') }}/assets/firob/css/font-awesome.min.css" rel="stylesheet" />
    <link href="{{ URL::to('/') }}/assets/firob/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{{ URL::to('/') }}/assets/firob/css/custom.css" rel="stylesheet" />

</head>

<body>
    <div id="all">
        <div class="top-bar">
            <div class="container">
                <div class="col-md-12">
                    <div class="top-links"> </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <header class="main-header">
            <div class="navbar" data-spy="affix" data-offset-top="200">
                <div class="navbar navbar-default yamm" role="navigation" id="navbar">
                    <div class="container">
                        <div class="navbar-header">
                            <h2>FIRO B</h2>

                        </div>
                        <div class="col-md-5 pull-right">
                            <div class="navbar-collapse">
                                <ul class="nav navbar-nav pull-right exam-paper ">
                                    <li class="">
                                        <table>
                                            <tr>
                                                @if ($query->CandidateImage == null)
                                                    <td style="padding: 5px 15px; border: 2px solid #666"><i
                                                            class="fa fa-user fa-4x"></i></td>
                                                @else
                                                <td style="border: 2px solid #f09a3e; "> <img
                                                    src="{{ URL::to('/') }}/uploads/Picture/{{ $query->CandidateImage }}" style="width: 80px;" height="80px;"/></td>
                                                   
                                                @endif


                                                <td>
                                                    <table>
                                                        <tr>
                                                            <td style="padding: 5px 5px;">Candidate Name</td>
                                                            <td> : <span
                                                                    style="color: #f09a3e; font-weight: bold">{{ $query->FName }}
                                                                    {{ $query->MName }} {{ $query->LName }}</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding: 5px 5px;">Reference No</td>
                                                            <td> : <span
                                                                    style="color: #f09a3e; font-weight: bold">{{ $query->ReferenceNo }}</span>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="clear"></div>
        <div>
            <div id="heading-breadcrumbs">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="pull-left">General Instructions</h1>
                            <div class="pull-right" style="padding: 0">
                                <label style="color: #fff;"> Choose Your Language</label>
                                <select class="form-control" onChange="changeIndtruct(this.value)">
                                    <option value="en">English</option>
                                    <option value="hi">Hindi</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="content">
                <div class="container">
                    <section>
                        <div class="row">
                            <div class="col-md-12 exam-confirm">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="col-md-12" id="en">
                                            <h4 class="text-center">Please read the instructions carefully</h4>
                                            <h4><strong><u>General Instructions:</u></strong></h4>
                                            <ol>
                                                <li>Total duration for FIRO B Assessment is 30.
                                                </li>
                                                <li>The clock will be set at the server. The countdown timer in the top
                                                    right corner of screen will display the remaining time available for
                                                    you to complete the examination. When the timer reaches zero, the
                                                    examination will end by itself. You will not be required to end or
                                                    submit your examination.</li>
                                                <li>
                                                    The Questions Palette displayed on the right side of screen will
                                                    show the status of each question using one of the following symbols:
                                                    <ol>
                                                        <li><img
                                                                src="{{ URL::to('/') }}/assets/firob/img/QuizIcons/Logo1.png" />
                                                            You have not visited the question yet.<br /><br /></li>
                                                        <li><img
                                                                src="{{ URL::to('/') }}/assets/firob/img/QuizIcons/Logo2.png" />
                                                            You have not answered the question.<br /><br /></li>
                                                        <li><img
                                                                src="{{ URL::to('/') }}/assets/firob/img/QuizIcons/Logo3.png" />
                                                            You have answered the question.<br /><br /></li>

                                                    </ol>
                                                </li>
                                                <li>You can click on the "&gt;" arrow which apperes to the left of
                                                    question palette to collapse the question palette thereby maximizing
                                                    the question window. To view the question palette again, you can
                                                    click
                                                    on "&lt;" which appears on the right side of question window.</li>
                                              
                                            </ol>
                                            <h4><strong><u>Navigating to a Question:</u></strong></h4>
                                            <ol start="5">
                                                <li>
                                                    To answer a question, do the following:
                                                    <ol type="a">
                                                        <li>Click on the question number in the Question Palette at the
                                                            right of your screen to go to that numbered question
                                                            directly. Note that using this option does NOT save your
                                                            answer to the current question.</li>
                                                        <li>Click on <strong>Save & Next</strong> to save your answer
                                                            for the current question and then go to the next question.
                                                        </li>
                                                     
                                                    </ol>
                                                </li>
                                            </ol>
                                            <h4><strong><u>Answering a Question:</u></strong></h4>
                                            <ol start="6">
                                                <li>
                                                    Procedure for answering a multiple choice type question:
                                                    <ol type="a">
                                                        <li>To select you answer, click on the button of one of the
                                                            options.</li>
                                                        <li>To deselect your chosen answer, click on the button of the
                                                            chosen option again or click on the <strong>Clear
                                                                Response</strong> button</li>
                                                        <li>To change your chosen answer, click on the button of another
                                                            option</li>
                                                        <li>To save your answer, you MUST click on the Save & Next
                                                            button.</li>
                                                        
                                                    </ol>
                                                </li>
                                                <li>To change your answer to a question that has already been answered,
                                                    first select that question for answering and then follow the
                                                    procedure for answering that type of question.</li>
                                            </ol>
                                            
                                            <hr>

                                            <span class="text-danger">Please note all questions will appear in your
                                                default language. This language can be changed for a particular question
                                                later on.</span>
                                            <hr>
                                            <label>
                                                <input type="checkbox" id="en_ch">&nbsp;&nbsp;I have read and understood
                                                the instructions. </label>
                                            <hr>
                                            <div class="col-md-4 col-md-offset-4 text-center">
                                                <a onClick="check_instruction('en')"
                                                    class="btn btn-primary btn-block">Proceed</a>
                                            </div>
                                        </div>

                                        <div class="col-md-12" id="hi" style="display: none">
                                            <h4 class="text-center">कृपया निम्नलिखित निर्देशों को ध्यान से पढ़ें</h4>
                                            <h4><strong><u>सामान्य अनुदेश:</u></strong></h4>
                                            <ol>
                                                <li>सभी प्रश्नों को हल करने की कुल अवधि 30
                                                    मिनट ।</li>
                                                <li>सर्वर पर घड़ी लगाई गई है तथा आपकी स्क्रीन के दाहिने कोने में शीर्ष
                                                    पर काउंटडाउन टाइमर में आपके लिए परीक्षा समाप्त करने के लिए शेष समय
                                                    प्रदर्शित होगा। परीक्षा समय समाप्त होने पर, आपको अपनी परीक्षा बंद या
                                                    जमा करने की जरूरत नहीं है । यह स्वतः बंद या जमा हो जाएगी।</li>
                                                <li>
                                                    स्क्रीन के दाहिने कोने पर प्रश्न पैलेट, प्रत्येक प्रश्न के लिए निम्न
                                                    में से कोई एक स्थिति प्रकट करता है:
                                                    <ol>
                                                        <li><img
                                                                src="{{ URL::to('/') }}/assets/firob/img/QuizIcons/Logo1.png" />
                                                            आप अभी तक प्रश्न पर नहीं गए हैं।<br /><br /></li>
                                                        <li><img
                                                                src="{{ URL::to('/') }}/assets/firob/img/QuizIcons/Logo2.png" />
                                                            आपने प्रश्न का उत्तर नहीं दिया है।<br /><br /></li>
                                                        <li><img
                                                                src="{{ URL::to('/') }}/assets/firob/img/QuizIcons/Logo3.png" />
                                                            आप प्रश्न का उत्तर दे चुके हैं।<br /><br /></li>

                                                    </ol>
                                                
                                                </li>
                                                <li>आप प्रश्न पैलेट को छुपाने के लिए "&gt;" चिन्ह पर क्लिक कर सकते है,
                                                    जो प्रश्न पैलेट के बाईं ओर दिखाई देता है, जिससे प्रश्न विंडो सामने आ
                                                    जाएगा. प्रश्न पैलेट को फिर से देखने के लिए, "&lt;" चिन्ह पर क्लिक
                                                    कीजिए
                                              
                                            </ol>
                                            <h4><strong><u>किसी प्रश्न पर जाना :</u></strong></h4>
                                            <ol start="5">
                                                <li>
                                                    उत्तर देने हेतु कोई प्रश्न चुनने के लिए, आप निम्न में से कोई एक
                                                    कार्य कर सकते हैं:
                                                    <ol type="a">
                                                        <li>स्क्रीन के दायीं ओर प्रश्न पैलेट में प्रश्न पर सीधे जाने के
                                                            लिए प्रश्न संख्या पर क्लिक करें। ध्यान दें कि इस विकल्प का
                                                            प्रयोग करने से मौजूदा प्रश्न के लिए आपका उत्तर सुरक्षित नहीं
                                                            होता है।</li>
                                                        <li>वर्तमान प्रश्न का उत्तर सुरक्षित करने के लिए और क्रम में
                                                            अगले प्रश्न पर जाने के लिए <strong>Save & Next</strong> पर
                                                    
                                                    </ol>
                                                </li>
                                            </ol>
                                            <h4><strong><u>प्रश्नों का उत्तर देना :</u></strong></h4>
                                            <ol start="6">
                                                <li>
                                                    बहुविकल्प प्रकार प्रश्न के लिए
                                                    <ol type="a">
                                                        <li>अपना उत्तर चुनने के लिए, विकल्प के बटनों में से किसी एक पर
                                                            क्लिक करें।</li>
                                                        <li>चयनित उत्तर को अचयनित करने के लिए, चयनित विकल्प पर दुबारा
                                                            क्लिक करें या <strong>Clear Response</strong> बटन पर क्लिक
                                                            करें।</li>
                                                        <li>अपना उत्तर बदलने के लिए, अन्य वांछित विकल्प बटन पर क्लिक
                                                            करें।</li>
                                                        <li>अपना उत्तर सुरक्षित करने के लिए, आपको <strong>Save &
                                                                Next</strong> पर क्लिक करना जरूरी है। </li>
                                                    
                                                    </ol>
                                                </li>
                                                <li>किसी प्रश्न का उत्तर बदलने के लिए, पहले प्रश्न का चयन करें, फिर नए
                                                    उत्तर विकल्प पर क्लिक करने के बाद <strong>Save & Next</strong> बटन
                                                    पर क्लिक करें।</li>
                                            </ol>
                                            
                                            <hr>

                                            <span class="text-danger">कृपया ध्यान दें कि सभी प्रश्न आपकी डिफ़ॉल्ट
                                                भाषा में दिखाई देंगे। इस भाषा को बाद में किसी विशेष प्रश्न के लिए बदला
                                                जा सकता है ।</span>
                                            <hr>
                                            <label>
                                                <input type="checkbox" id="hi_ch">&nbsp;&nbsp;मैंने निर्देशों को पढ़ और
                                                समझ लिया है। </label>
                                            <hr>
                                            <div class="col-md-4 col-md-offset-4 text-center">
                                                <a onClick="check_instruction('hi')"
                                                    class="btn btn-primary btn-block">Proceed</a>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <div id="copyright">
            <div class="container">
                <div class="col-md-12">
                    <p class="text-center">&copy; 2018 National Testing Agency</p>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ URL::to('/') }}/assets/js/jquery.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">
        function changeIndtruct(q) {
            $('#' + q).css("display", "block");
            if (q == 'hi') {
                $('#en').css("display", "none");
            } else {
                $('#hi').css("display", "none");
            }
        }

        function check_instruction(id) {
           
            if ($('#' + id + '_ch').prop("checked") == false) {
                if (id == 'en') {
                    alert('Please accept terms and conditions before proceeding.');
                } else {
                    alert('आगे बढ़ने से पहले नियम और शर्तें स्वीकार करें।');
                }
            } else {

                window.location.href = "{{ route('firob_test') }}?jcid={{ request()->query('jcid') }}";
            }
        }
    </script>
</body>

</html>
