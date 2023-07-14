<x-mail::message>
<h1>{{ site()->trans('mail.freeEstimateConfirmation.title') }}</h1>

<p>{{ site()->trans('mail.freeEstimateConfirmation.intro') }}</p>
<p>{{ site()->trans('mail.freeEstimateConfirmation.photos') }}</p>

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
