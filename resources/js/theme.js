$(document).ready(function () {
    AOS.init({
        duration: 800
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
