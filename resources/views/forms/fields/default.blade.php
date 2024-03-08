<div
    id="form-field-{{ $field->id }}"
    class="form-field field {{ $field->class }}"
>
    @include('forms.fields.partials.label')

    <div class="control">
        @include('forms.fields.partials.input', ['type' => $field->type])
    </div>
</div>
