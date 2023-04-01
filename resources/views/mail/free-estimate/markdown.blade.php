<x-mail::message>
<h1>Demande d'estimé sans frais</h1>

<table width="100%">
@foreach ($fields as $field)
<tr>
<td width="30%">{{ $field['label'] ?? '' }}</td>
<td>{!! nl2br($field['value'] ?? '') !!}</td>
</tr>
@endforeach
</table>
</x-mail::message>
