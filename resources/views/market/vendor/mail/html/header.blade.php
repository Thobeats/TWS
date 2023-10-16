@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'TWSL')
<img src="{{ asset('/images/logo.png') }}" class="logo" alt="The Wholesale Lounge">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
