<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{ URL::to('/') }}/assets/images/vnrlogomail.png" class="logo" alt="">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
