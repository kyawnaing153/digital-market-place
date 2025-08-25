document.addEventListener("DOMContentLoaded", function () {
    Dropzone.autoDiscover = false;
    var uploadedDocumentMap = {}
    if ($('#previewDropzone').length) {
        var myDropzoneOne = new Dropzone('#previewDropzone', {
            url: BASE_URL + '/upload_preview_image',
            maxFilesize: prev_max_file_upload_size, // MB
            acceptedFiles: prev_allowed_file_extensions,
            addRemoveLinks: true,
            maxFiles: prev_max_files,
            dictMaxFilesExceeded: `Only ${prev_max_files} files are allowed`,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            
            success: function(file, response) {
                $('form').append('<input type="hidden" name="preview_imgs[]" value="' + response.name + '">')
                uploadedDocumentMap[file.name] = response.name
            },
            removedfile: function(file) {
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedDocumentMap[file.name]
                }
                $('form').find('input[name="preview_imgs[]"][value="' + name + '"]').remove()
            },
             init: function() {
                this.on("maxfilesexceeded", function(file) {
                    this.removeAllFiles();
                    this.addFile(file);
                });
            }

        });
    }
});



