@component('mail::message')
<strong>Thank you,</strong> {{ $details['candidate_name'] }}, Reference No :<strong> {{ $details['reference_no'] }}</strong>, for accepting the job offer letter.

<p>To ease your onboarding process, we have provided the documentation process online.</p>

<p>To view and fill the joining form, kindly click on the link below,</p>

@component('mail::buttons', [
    'buttons' => [
        [
            'url' => $details['link'],
            'slot' => 'On Boarding Documentation',
            'color' => 'green' // This is the default
        ]
    ]
])
@endcomponent

<p style="margin-bottom: 2px;">In case of any further query kindly contact,</p>
<p style="margin-bottom: 2px;">HR-Recruitment Team,</p>
<p>Contact No: 0771-435005</p>
<br>

<p>* Please do not reply to this email - This is an automated message and responses cannot be received by our system.</p>


Thanks,<br>
VNR Recruitment
@endcomponent
