<x-mail::message>
<h1>{{ site()->trans('mail.freeEstimateRequest.title') }}</h1>

<table width="100%">
@foreach ($fields as $field)
@isset($field['label'])
<tr>
<td width="30%">
{{ $field['label'] }}
</td>
<td>
{!! collect($field['value'] ?? '')->join(PHP_EOL) !!}
</td>
</tr>
@endisset
@endforeach
</table>
</x-mail::message>
