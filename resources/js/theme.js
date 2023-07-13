$(document)
    .ready(function () {
        const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        const GOOGLE_RECAPTCHA_SITE_KEY = $('meta[name="google-recaptcha-site-key"]').attr('content');

        const $window = $(window);
        const $body = $('body');
        const $loading = $('#loading');

        AOS.init({
            duration: 800,
            disable: 'mobile',
        });

        $window.on('scroll', () => {
            if ($window.scrollTop() > 100) {
                $body.addClass('is-scrolled');
            } else {
                $body.removeClass('is-scrolled');
            }
        });

        $('.stonehenge').stonehenge();

        $('.file.upload').each(function () {
            let $file = $(this),
                uploadPath = $file.data('upload-path'),
                $fileInput = $file.find('.file-input'),
                fileInputName = $fileInput.attr('name'),
                $fileName = $file.find('.file-name');

            $fileInput.removeAttr('name');

            $fileInput.on('change', function (e) {
                let formData = new FormData(),
                    fileInput = $fileInput[0],
                    files = fileInput.files;

                if (files.length > 0) {
                    for (let i = 0; i < files.length; i++) {
                        formData.append('files[]', files[i]);
                    }

                    $loading.addClass('is-active');

                    $.ajax({
                        type: 'POST',
                        url: uploadPath,
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': CSRF_TOKEN,
                        },
                        contentType: false,
                        //processData: false,
                    }).done(function (response) {
                        if (response.length > 0) {
                            response.forEach((file) => {
                                if (file.name && file.url) {
                                    let $tag = $(`<a class="tag is-info" href="${file.url}" target="_blank">${file.name}</a>`);
                                    $tag.append(`<input type="hidden" name="${fileInputName}" value="${file.url}" />`);
                                    $tag.append(`<button class="delete is-small"></button>`);
                                    $fileName.append($tag);
                                }
                            });
                        } else {
                            window.alert("Une erreur est survenue / An error occurred");
                        }

                        $fileInput.val('');
                    }).fail(function () {
                        window.alert("Une erreur est survenue / An error occurred");
                    }).always(function () {
                        $loading.removeClass('is-active');
                    });
                }
            });
        });

        $(document)
            .on('click', '.tag .delete', function (e) {
                e.preventDefault();
                $(this).parents('.tag').remove();
            })
            .on('submit', 'form.recaptcha', function (e) {
                let $form = $(this),
                    token = $form.data('google-recaptcha-token');

                if (! token) {
                    if (GOOGLE_RECAPTCHA_SITE_KEY) {
                        e.preventDefault();

                        $loading.addClass('is-active');

                        grecaptcha.enterprise.ready(async () => {
                            token = await grecaptcha.enterprise.execute(GOOGLE_RECAPTCHA_SITE_KEY, {action: 'LOGIN'});

                            $loading.removeClass('is-active');

                            $form
                                .data('google-recaptcha-token', token)
                                .append(`<input type="hidden" name="google_recaptcha_token" value="${token}" />`)
                                .submit();
                        });
                    }
                }
            });
    });
