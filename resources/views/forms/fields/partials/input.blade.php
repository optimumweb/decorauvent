<input
    id="form-field-{{ $field->id }}"
    class="input @error($field->dotname) is-danger @enderror"
    name="{{ $field->name }}"
    type="{{ $type ?? 'text' }}"
    placeholder="{{ $field->placeholder }}"
    value="{{ $field->old($field->default_value) }}"
    list="{{ isset($field->html_options) ? "form-field-{$field->id}-list" : '' }}"
    {{ $field->is_required ? 'required' : '' }}
/>

@isset($field->html_options)
    <datalist id="form-field-{{ $field->id }}-list">
        @foreach ($field->html_options as $htmlOption)
            <option value="{!! $htmlOption['value'] !!}">{!! $htmlOption['label'] !!}</option>
        @endforeach
    </datalist>
@endisset
