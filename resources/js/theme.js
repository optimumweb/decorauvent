$(document).ready(function () {
    AOS.init({
        duration: 800
    });

    const $window = $(window);
    const $body = $('body');

    $window.on('scroll', () => {
        if ($window.scrollTop() > 100) {
            $body.addClass('is-scrolled');
        } else {
            $body.removeClass('is-scrolled');
        }
    });

    $('.stonehenge').stonehenge();

    $('.file').each(function () {
        let $file = $(this),
            $fileInput = $file.find('.file-input'),
            $fileName = $file.find('.file-name'),
            files,
            fileNames;

        $fileInput.on('change', function (e) {
            files = e.target.files;
            fileNames = [];

            if (files.length > 0) {
                for (let i = 0; i < files.length; i++) {
                    fileNames.push(files[i].name);
                }
            }

            $fileName.text(fileNames.join(', '));
        });
    });
});
