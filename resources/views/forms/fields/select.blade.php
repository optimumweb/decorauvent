<div
    id="form-field-{{ $field->id }}"
    class="form-field field {{ $field->class }}"
>
    @include('forms.fields.partials.label')

    <div class="control">
        <div class="select is-fullwidth">
            <select
                id="form-field-{{ $field->id }}"
                class="input @error($field->dotname) is-danger @enderror"
                name="{{ $field->name }}"
                type="text"
                {{ $field->is_required ? 'required' : '' }}
            >
                <option value="">{{ $field->placeholder }}</option>

                @foreach ($field->html_options as $htmlOption)
                    <option value="{{ $htmlOption['value'] }}">{{ $htmlOption['label'] }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
