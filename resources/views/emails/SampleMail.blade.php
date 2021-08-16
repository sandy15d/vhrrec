@component('mail::message')
# VNR Seeds Pvt. Ltd.

<h2>{{$details['title']}}</h2>
<p>{{$details['body']}}</p>


@component('mail::panel')
This is the panel content.
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
