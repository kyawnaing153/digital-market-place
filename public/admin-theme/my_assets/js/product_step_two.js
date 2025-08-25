
$(document).ready(function () {
    "use strict";

    var priceCount = parseInt($('#price-count').val());  //price count
    var fileCount = parseInt($('#file-count').val()); //file count
  

    $(document).find('#product-sec-step-form').validate({
        rules: {
        },
        messages: {
        },
        submitHandler: function(form) {
            var formData = new FormData(form);
            add_update_details_with_img("product-sec-step-form", formData);
        }
    });

    $('#is_enable_multi_price').click(function() {
        var html = "";
        if ($(this).is(":checked")) {
            $('.price-option').removeClass('d-none');
            $('#single_price_card').addClass('d-none');
            $('#multi_price_card').removeClass('d-none');
            set_product_offer();
            add_price_in_file();
            $('select').select2();
        } else {
            $('.price-option').addClass('d-none');
            $('#single_price_card').removeClass('d-none');
            $('#multi_price_card').addClass('d-none');
            set_product_offer();
        }
    })

    $(document).on('click', '#add_more_price', function() {
        var html = $('#product-fields').clone().find("input").val("").end();
        html.find('input[type=radio]').prop("checked", false);
        html.find('input[type=radio]').removeAttr('checked');
        html.find('input[type=hidden]').val('0');
        html.find('input[type=radio]').val('1');
        $('#price-body').append(html);
        priceCount++;
    });


    
   $(document).on('click', '#add_new_file', function() {
        var html = $('#file-fields').clone().find("input").val("").end();
        html.find('.file-url-fu').text('');
        html.find('.select2').remove();
        html.find('.progress').remove();
        html.find('#tp-progress').append('<div class="progress" style="display: none; margin-top: 10px;">' +
            '<div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>' +
            '</div>');
        $('#file-body').append(html);
        fileCount++;
        $('select').select2();
   });

    let isClicking = false;

    $(document).on('click', '.depones', function (e) {
        if (isClicking) return;
        isClicking = true;  
        e.stopImmediatePropagation(); 
        $(this).find('input[type="file"]').click();
        isClicking = false; 
    });


    $(document).on('change', '.depones input[type="file"]', function (e) {
        let file = e.target.files[0]; 
        var fileName = $(this).val().split('\\').pop();  
        const max_file_size = max_upload_size * 1024 * 1024; 
        if (file.size > max_file_size) {
            error_message(`File size exceeds the maximum allowed limit of ${max_upload_size} MB`);
            this.value = "";
            return;
        }
        //console.log('Selected file:', fileName);
        let container = $(this).closest('.file-container');
        container.find('.file-url-fu').text(fileName);

        if (file) {
            resetProgressBar(container);
            uploadFile(file, container);
        }
    });

    function uploadFile(file, container) {
        
        let formData = new FormData();
        formData.append('file', file);

        // AJAX request
        $.ajax({
            url: BASE_URL + '/upload_preview_image',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            xhr: function () {
                let xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function (evt) {
                    if (evt.lengthComputable) {
                        let percentComplete = Math.round((evt.loaded / evt.total) * 100);
                        let progressBar = container.find('.progress-bar');
                        container.find('.progress').show();
                        updateProgressBar(progressBar, percentComplete);
                    }
                }, false);

                return xhr;
            },
            success: function (response) {
                if (response.status == false) { 
                    error_message('something went wrong please try again later.');
                }
            },
            error: function (response) {
                var responseJSON = response.responseJSON;
                error_message(responseJSON.msg);
            },
        });
    }

    function resetProgressBar(container) {
        let progressBar = container.find('.progress-bar');
        container.find('.progress').hide(); 
        progressBar.css('width', '0%').attr('aria-valuenow', 0); 
        progressBar.text('0%');
    }
    
    function updateProgressBar(progressBar, percentComplete) {
    let currentProgress = parseInt(progressBar.attr('aria-valuenow')) || 0; 
    let interval = 500; 
    let step = 50; 

    function update() {
            if (currentProgress < percentComplete) {
                currentProgress += step;
                if (currentProgress > percentComplete) currentProgress = percentComplete;
                progressBar.css('width', currentProgress + '%').attr('aria-valuenow', currentProgress);
                progressBar.text(currentProgress + '%');
                setTimeout(update, interval);
            }
        }
        update();
    }

    $(document).on('click', '#remove_price', function () {
        if (priceCount == 1)
            $('#product-fields').find("input").val("");
        else {
            $(this).parent().parent().remove();
            add_price_in_file();
            priceCount--;
        }
    });

    $(document).on('click', '#remove_file', function() {
        if (fileCount == 1) {
            $('#file-fields').find("input").val("");
            $('#file-fields').find('.file-url-fu').text('');
        } else {
            $(this).parent().remove();
            fileCount--;
        }
    });

    $(document).on('change', '#file_type', function() {
        if ($(this).val() == 1) {
            $('#bundle-card').removeClass('d-none');
            $('#single-card').addClass('d-none');
        } else {
            $('#bundle-card').addClass('d-none');
            $('#single-card').removeClass('d-none');

        }
    });
    
    $('#product_image').change(function() {
    var file = this.files[0];
    const max_thumb_size = thumb_img_size * 1024 * 1024; 
    
    if (file) {
        var fileType = file.type;
        
        if (!fileType.startsWith('image') && !fileType.startsWith('video') && !fileType.startsWith('audio')  ) {
            error_message('Only image,video and audio files are allowed.');
            return;
        }

        if (file.size > max_thumb_size) {
            error_message(`File size exceeds the maximum allowed limit of ${thumb_img_size} MB`);
            this.value = "";
            return;
        }
        var reader = new FileReader();
        reader.onload = function(event) {
            var html;
            if (fileType.startsWith('video')) {
                html = '<video width="15%" height="100%" controls>' +
                    '<source src="' + event.target.result + '" type="' + fileType + '" class="product-step2img">' +
                    '</video>';
            } else if (fileType.startsWith('image')) {
                html = '<img src ="' + event.target.result + '" alt="product image" class="product-step2img">';
            } else if (fileType.startsWith('audio')) { 
                 
                html = '<audio  width="15%" height="100%" controls>' +
                    '<source src="' + event.target.result + '" type="' + fileType + '" class="product-step2img">' +
                    '</audio>';
            }
            $('#product_image_prev').html(html);
            $('#product_image_prev').removeClass('d-none');
        };
        reader.readAsDataURL(file);
    }
});


$(document).on('click', '.tp_proimg_multisel,fa-times', function() {
    $(this).parent().remove();
});


})


function set_product_offer() {
    
    if ($('#is_offer').val() != "") {
        $('#prod-offer-div').removeClass('d-none');
        $('.offer-price-op').removeClass('d-none');
    } else {
        $('.offer-price-op').addClass('d-none');
        $('#prod-offer-div').addClass('d-none');
    }
 

    if ($('#is_offer').val() == 1) {
        if ($('#is_enable_multi_price').is(":checked")) {
            $('.offer-price-op').removeClass('d-none');
            $('.p-of-p').hide();
            $('.s-sale').hide();
        } else {
            $('.s-sale').hide();
            $('.p-of-p').show();
        }
    } else if ($('#is_offer').val() == 2) {
        if ($('#is_enable_multi_price').is(":checked")) {
            $('.offer-price-op').removeClass('d-none');
            $('.s-sale').removeClass('d-none');
            $('.s-sale').show();
            $('.p-of-p').hide();
        } else {
            $('.s-sale').removeClass('d-none');
            $('.s-sale').show();
        }
    }
}

function add_price_in_file() {
    $('.file_price_append').html('');
    $('input[name="option_name[]"]').map(function(idx, ele) {
        if (idx == 0) {
            $('.file_price_append').append(`<option value="ALL">ALL</option>`)
        }
        if ($(ele).val() != "") {
            optionText = $(ele).val();
            optionValue = (idx + 1);
            $('.file_price_append').append(`<option value="${optionValue}">
                    ${optionText}
                </option>`)
        }
    }).get();
}


