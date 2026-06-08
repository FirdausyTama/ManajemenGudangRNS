@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<div style="font-size:22px; font-weight:bold; color:#0d3b91; font-family:'Poppins', sans-serif;">PT Rand Nusantara Sejahtera</div>
@else
{!! $slot !!}
@endif
</a>
</td>
</tr>
