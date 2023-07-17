$(document)
    .ready(function () {
        const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        const GRECAPTCHA_SITE_KEY = $('meta[name="grecaptcha-site-key"]').attr('content');

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

        $('.file.base64').each(function () {
            let $file = $(this),
                $fileInput = $file.find('.file-input'),
                fileInputName = $fileInput.attr('name'),
                $fileName = $file.find('.file-name');

            $fileInput.removeAttr('name');

            $fileInput.on('change', async function (e) {
                let fileInput = $fileInput[0],
                    files = fileInput.files;

                if (files.length > 0) {
                    $loading.addClass('is-active');

                    for (let i = 0; i < files.length; i++) {
                        let file = files[i],
                            content = await base64Encode(file),
                            digest = await hash(content);

                        let $tag = $(`<span class="tag is-info">${file.name}</span>`);
                        $tag.append(`<input type="hidden" name="${fileInputName}[${digest}][name]" value="${file.name}" />`);
                        $tag.append(`<input type="hidden" name="${fileInputName}[${digest}][content]" value="${content}" />`);
                        $tag.append(`<button class="delete is-small"></button>`);
                        $fileName.append($tag);
                    }

                    $loading.removeClass('is-active');
                }
            });
        });

        $(document)
            .on('click', '.tag .delete', function (e) {
                e.preventDefault();
                $(this).parents('.tag').remove();
            })
            .on('submit', 'form.grecaptcha', function (e) {
                let $form = $(this),
                    token = $form.data('grecaptcha-token');

                if (! token) {
                    if (GRECAPTCHA_SITE_KEY) {
                        e.preventDefault();

                        $loading.addClass('is-active');

                        grecaptcha.ready(function() {
                            grecaptcha.execute(GRECAPTCHA_SITE_KEY, {action: 'submit'}).then(function(token) {
                                $form
                                    .data('grecaptcha-token', token)
                                    .append(`<input type="hidden" name="grecaptcha_token" value="${token}" />`)
                                    .submit();
                            });
                        });
                    } else {
                        console.log("GRECAPTCHA_SITE_KEY not defined!");
                    }
                }
            });
    });

window.base64Encode = file => new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => resolve(reader.result);
    reader.onerror = reject;
});

window.hash = string => {
    const utf8 = new TextEncoder().encode(string);
    return crypto.subtle.digest('SHA-256', utf8).then((hashBuffer) => {
        return Array.from(new Uint8Array(hashBuffer))
            .map(bytes => bytes.toString(16).padStart(2, '0'))
            .join('');
    });
};
