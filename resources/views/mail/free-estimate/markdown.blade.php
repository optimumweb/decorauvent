<x-mail::message>
<h1>Demande d'estimé sans frais</h1>

<table width="100%">
@foreach ($fields as $key => $field)
<tr>
<td width="30%">
{{ $field['label'] ?? $key }}
</td>
<td>
@isset($field['value'])
{!! nl2br(is_array($field['value']) ? implode(PHP_EOL, $field['value']) : $field['value']) !!}
@endisset
</td>
</tr>
@endforeach
</table>
</x-mail::message>
