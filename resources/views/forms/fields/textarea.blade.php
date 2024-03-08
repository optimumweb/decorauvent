<div
    id="form-field-{{ $field->id }}"
    class="form-field field {{ $field->class }}"
>
    @include('forms.fields.partials.label')

    <div class="control">
        <textarea
            id="form-field-{{ $field->id }}"
            class="textarea @error($field->dotname) is-danger @enderror"
            name="{{ $field->name }}"
            placeholder="{{ $field->placeholder }}"
            {{ $field->is_required ? 'required' : '' }}
        >{!! $field->old($field->default_value) !!}</textarea>
    </div>
</div>
