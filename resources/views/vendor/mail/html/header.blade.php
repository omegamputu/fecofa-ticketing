@props(['url'])
<tr>
<td class="header" style="text-align:center">
<a href="{{ config('app.url') }}" style="display:inline-block;">
    {{-- Logo FECOFA --}}
    <img src="{{ asset('images/Logo FECOFA.svg') }}" alt="FECOFA Helpdesk" height="48">
</a>
<div style="font-weight:700; font-size:20px; margin-top:8px;">
    {{ config('app.name') }}
</div>
</a>
</td>
</tr>
