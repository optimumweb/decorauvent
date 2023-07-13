<x-mail::message>
<h1>Demande d'estimé sans frais</h1>

<table width="100%">
@foreach ($fields as $field)
@isset($field['label'])
<tr>
<td width="30%">
{{ $field['label'] }}
</td>
<td>
{!! $field['value'] ?? '' !!}
</td>
</tr>
@endisset
@endforeach
</table>
</x-mail::message>
