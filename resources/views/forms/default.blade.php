<form
    id="form-{{ $form->name }}"
    class="form {{ $form->grecaptcha_enabled ? 'grecaptcha-enabled' : '' }}"
    action="{{ $form->action }}"
    method="{{ $form->method }}"
    enctype="multipart/form-data"
    data-grecaptcha-site-key="{{ $form->grecaptcha_site_key }}"
>
    @csrf

    @if (session()->has('success'))
        <p class="notification is-success">
            {!! session()->get('success') !!}
        </p>
    @endif

    @isset($errors)
        @foreach($errors->all() as $message)
            <p class="notification is-danger">
                {!! $message !!}
            </p>
        @endforeach
    @endisset

    <div class="columns is-multiline">
        @foreach ($form->fields as $field)
            <div class="column is-{{ $field->columns }}">
                {!! $field !!}
            </div>
        @endforeach
    </div>

    <button
        class="button is-success"
        type="submit"
    >
        {{ site()->trans('forms.submit') }}
    </button>
</form>

@if ($form->grecaptcha_enabled && isset($form->grecaptcha_site_key))
    <!-- Google reCAPTCHA v3 -->
    <script src="https://www.google.com/recaptcha/api.js?render={{ $form->grecaptcha_site_key }}"></script>
    <!-- /Google reCAPTCHA v3 -->
@endif
