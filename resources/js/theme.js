$(document)
    .ready(function () {
        AOS.init({
            duration: 800,
            disable: 'mobile',
        });

        const $window = $(window);
        const $body = $('body');
        const $loading = $('#loading');
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

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
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        cache: false,
                        contentType: false,
                        processData: false,
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
                        }

                        $fileInput.val('');
                    }).always(function () {
                        $loading.removeClass('is-active');
                    });
                }
            });
        });
    })
    .on('click', '.tag .delete', function (e) {
        e.preventDefault();
        $(this).parents('.tag').remove();
    });
