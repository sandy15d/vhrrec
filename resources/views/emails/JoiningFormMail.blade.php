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
<p>Download the following documents.</p>
<ol>
<li><a href='https://hrrec.vnress.in/assets/documents/pf_form2.pdf' target='_blank'>PF_Nomination Form 2</a></li>
<li><a href='https://hrrec.vnress.in/assets/documents/pf_form11.pdf' target='_blank'>PF_Declaration Form 11</a></li>
<li><a href='https://hrrec.vnress.in/assets/documents/gratutity.pdf' target='_blank'>Gratuity_Nomination Form</a></li>
<li><a href='https://hrrec.vnress.in/assets/documents/esic_declaration.pdf' target='_blank'>ESIC_Declaration Form 1</a></li>
<li><a href='https://hrrec.vnress.in/assets/documents/esic_family.pdf' target='_blank'>Family Declaration Form 1(A)</a></li>
<li><a href='https://hrrec.vnress.in/assets/documents/health_declaration.pdf' target='_blank'>Health Declaration Form</a></li>
<li><a href='https://hrrec.vnress.in/assets/documents/ethical_compliance.pdf' target='_blank'>Declaration for Compliance to Ethical Financial Dealings</a></li>
</ol><br/><br/>
<p style="margin-bottom: 2px;">In case of any further query kindly contact,</p>
<p style="margin-bottom: 2px;">HR-Recruitment Team,</p>
<p>Contact No: 0771-435005</p>
<br>

<p>* Please do not reply to this email - This is an automated message and responses cannot be received by our system.</p>


Thanks,<br>
VNR Recruitment
@endcomponent
