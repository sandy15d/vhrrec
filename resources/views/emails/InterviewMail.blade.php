@component('mail::message')
<strong>Congratulations,</strong> {{ $details['name']}},Reference No : {{ $details['reference_no']}}, Your application for the post of {{ $details['title']}} has been shortlisted.
<p>We are sending you this interview call letter to attend an interview for the above mentioned post.</p>
<p>The interview schedule details are mentioned below,</p>
<p style="margin-bottom: 2px;">Date : {{ $details['interview_date'] }}</p>
<p style="margin-bottom: 2px;">Time : {{ $details['interview_time'] }}</p>
<p style="margin-bottom: 2px;">Venue : {{ $details['interview_venue'] }}</p>
<p style="margin-bottom: 2px;">Contact Person: {{$details['contact_person'] }}</p>
<p>Bring copy of all original certificates in support of you Salary (3 month's Payslip & Offer,Appointmnet letter,incentives -if any), if any, Travel Policy, experience,educational qualification,etc.</p>
<p>Kindly fill the job application form and FIRO B Test online by clicking the bellow link, this will save your time and efforts on the interview date.</p>
@component('mail::buttons', [
    'buttons' => [
        [
            'url' => '',
            'slot' => 'Interview Application Form',
            'color' => 'green' // This is the default
        ],[
            'url' => '',
            'slot' => 'FIRO - B',
            'color' => 'blue'
        ]
    ]
])
@endcomponent
<p>Kindly reach the interview venue 30 min. before the scheduled time.</p>
<p><i>#Please note that traveling allowances, to & fro, (travel class) railway fare or but fare, is payable for this purpose on submission of actual bills only.</i></p>
<small>*Please do not reply to this email- This is an automated message and responses cannot be received by our system.</small>




Thanks,<br>
VNR Recruitment
@endcomponent 