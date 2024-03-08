<div
    id="form-field-{{ $field->id }}"
    class="form-field field {{ $field->class }}"
>
    @include('forms.fields.partials.label')

    <div class="control">
        <div class="file has-name is-fullwidth">
            <label class="file-label">
                <input
                    id="form-field-{{ $field->id }}"
                    class="file-input @error($field->dotname) is-danger @enderror"
                    name="{{ $field->name }}"
                    type="file"
                    accept="{{ $field->accept->join(',') }}"
                    {{ $field->is_multiple ? 'multiple' : '' }}
                    {{ $field->is_required ? 'required' : '' }}
                />

                <span class="file-cta">
                    <span class="file-icon">
                        <i class="fas fa-upload"></i>
                    </span>

                    @isset($field->placeholder)
                        <span class="file-label">
                            {{ $field->placeholder }}
                        </span>
                    @endisset
                </span>

                <span class="file-name">
                    {{ $field->old($field->default_value) }}
                </span>
            </label>
        </div>
    </div>
</div>
