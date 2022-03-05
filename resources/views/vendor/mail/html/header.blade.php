<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://www.vnrseeds.com/wp-content/uploads/2018/12/cropped-vnr-logo-512-1-192x192.png" class="logo" alt="">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
