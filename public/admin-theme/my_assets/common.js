"use strict";
/**
* Error Message toaster
*/
function error_message(msg, url = "") {
    iziToast.error({
        title: 'Error',
        message: msg,
        position: 'topRight',
        onOpening: function () { },
        onOpened: function () {
            if (url != "") {
                window.location.href = url;
            }
        },
        onClosing: function () { },
        onClosed: function () { }
    });
}

/**
* success Message toaster
*/
function success_message(msg = "", url = "", refresh_status = 1) {
    if (msg) {
        iziToast.success({
            title: 'Success',
            message: msg,
            position: 'topRight', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter, center
            zindex: 99999999999999999999,
            onOpening: function () {
            },
            onOpened: function () {
                if (refresh_status == 1) {
                    if (url) {
                        window.location.href = url;
                    } else {
                        window.location.reload();
                    }
                }
            },
            onClosing: function () {
            },
            onClosed: function () {
            }
        });
    }
    else {
        if (url) {
            window.location.href = url;
        }
    }
}

/**
* common add/update ajax function
*/
function add_update_details(form_id, postData = "",refresh_status = 1) {
    var url = $('#'+form_id).attr('action');
    var form_btn_id = form_id + '-btn';

    $(document).find('#' + form_btn_id).buttonLoader('start');
    $(document).find('#' + form_btn_id).prop('disabled', true);

    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'JSON',
        data: postData,
        cache: false,
        success: function (response) {
            $('#' + form_btn_id).prop('disabled', false);
            $('#' + form_btn_id).buttonLoader('stop');
            var responseJSON = response;
            if (responseJSON.status == true) {
                success_message(responseJSON.msg, responseJSON.url ?? '', refresh_status);
            }
            else {
                error_message(responseJSON.msg);
            }

        },
        error: function (response) {
            $('#' + form_btn_id).prop('disabled', false);
            $('#' + form_btn_id).buttonLoader('stop');
            var responseJSON = response.responseJSON;
            if (responseJSON.status == true) {
                success_message(responseJSON.msg);
            }
            else {
                error_message(responseJSON.msg);
            }
        }
    });
}

/**
* common status update ajax function
*/
function update_single_status(url, status, btn_id, confirm_message="") {
    if (confirm_message == "") {
        var text = (status == 1) ? 'Deactived' : 'activated';
        confirm_message = 'Are you sure you want to '+text+' this item?';
    }
    iziToast.question({
        timeout: 20000,
        close: false,
        overlay: true,
        displayMode: 'once',
        id: 'question',
        zindex: 9999,
        title: 'Hey',
        message: confirm_message,
        position: 'center',
        buttons: [
            ['<button><b>YES</b></button>', function (instance, toast) {
                $.ajax({
                    url: url,
                    type: 'PATCH',
                    dataType: 'JSON',
                    success: function (data) {
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        if (data.status == false) {
                            error_message(data.msg);
                        }
                        if (data.status == true) {
                            success_message(data.msg, "", status);
                        }
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    },
                    error: function (response) {
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        var responseJSON = response.responseJSON;
                        if (responseJSON.status == true) {
                            success_message(responseJSON.msg);
                        }
                        else {
                            error_message(responseJSON.msg);
                        }
                    }
                });
            }, true],
            ['<button>NO</button>', function (instance, toast) {
                if(btn_id)
                $(document).find('#'+btn_id).trigger('click'); 
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
            }],
        ],

    });
}

/**
* common delete ajax function
*/
function delete_single_details(url, id, refresh_status = 2, confirm_message ="") {
   
    if (confirm_message == "") {
        confirm_message = 'Are you sure to perform this action?';
    }
    iziToast.question({
        timeout: 2000,
        close: false,
        overlay: true,
        displayMode: 'once',
        id: 'question',
        zindex: 999,
        title: 'Hey',
        message: confirm_message,
        position: 'center',
        buttons: [
            ['<button><b>YES</b></button>', function (instance, toast) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    dataType: 'JSON',
                    success: function (response) {
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        if (response.status == false) {
                            error_message(response.msg);
                        }
                        if (response.status == true) {
                            $('#table_row_' + id).hide();
                            $('#table_row_' + id).empty();
                            success_message(response.msg, "", refresh_status);
                        }

                    },
                    error: function (response) {
                        var responseJSON = response.responseJSON;
                        if (responseJSON.status == true) {
                            success_message(responseJSON.msg);
                        }
                        else {
                            error_message(responseJSON.msg);
                        }
                    }
                });
            }, true],
            ['<button>NO</button>', function (instance, toast) {
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
            }],
        ],

    });
}

/**
* common add/update with image ajax function
*/
function add_update_details_with_img(form_id, postData = "",refresh_status = 1) {
    var url = $('#'+form_id).attr('action');
    var form_btn_id = form_id + '-btn';
    $(document).find('#' + form_btn_id).buttonLoader('start');
    $(document).find('#' + form_btn_id).prop('disabled', true);

    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'JSON',
        data: postData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {
            $('#' + form_btn_id).prop('disabled', false);
            $('#' + form_btn_id).buttonLoader('stop');
            var responseJSON = response;
            if (responseJSON.status == true) {
                success_message(responseJSON.msg, responseJSON.url ?? '', refresh_status);
            }
            else {
                error_message(responseJSON.msg);
            }

        },
        error: function (response) {
            $('#' + form_btn_id).prop('disabled', false);
            $('#' + form_btn_id).buttonLoader('stop');
            var responseJSON = response.responseJSON;
            if (responseJSON.status == true) {
                success_message(responseJSON.msg);
            }
            else {
                error_message(responseJSON.msg);
            }
        }
    });
}


/**
* common status update ajax function
*/
function update_single_status2(url, status, confirm_message="") {

    iziToast.question({
        timeout: 20000,
        close: false,
        overlay: true,
        displayMode: 'once',
        id: 'question',
        zindex: 9999,
        title: 'Hey',
        message: confirm_message,
        position: 'center',
        buttons: [
            ['<button><b>YES</b></button>', function (instance, toast) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data:{'status': status},
                    dataType: 'JSON',
                    success: function (data) {
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        if (data.status == false) {
                            error_message(data.msg);
                        }
                        if (data.status == true) {
                            success_message(data.msg, "", status);
                        }
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    },
                    error: function (response) {
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        var responseJSON = response.responseJSON;
                        if (responseJSON.status == true) {
                            success_message(responseJSON.msg);
                        }
                        else {
                            error_message(responseJSON.msg);
                        }
                    }
                });
            }, true],
            ['<button>NO</button>', function (instance, toast) {
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
            }],
        ],

    });
}

$(document).on('keyup paste', '.generate-slug', function() {
    var str = $(this).val();
    str = $.trim(str);
    str = str.replace(/[^a-z-]/gi, '-');
    str = str.replace(/ /g, '-').replace(/[-]+/g, '-').replace(/[_]+/g, "").replace(/[^\w-]+/g, "");
    $('.append-slug').val(str.toLowerCase());
});

// =============================
    // Colopicker Script
// =============================
$(document).ready(function(){
     
    if ($('.colorpicker-fields').length > 0) {
        $(".pickerinput").spectrum({
            type: "color",
            showInput: true,
            allowEmpty:true,
            showAlpha: true,
            showPalette: true,
            showButtons: true,
            preferredFormat: "hex",
            showInitial: false,
            move: function(color){
                $('.active_options').css(
                    'color', color.toRgbString());
            }
        });
    }
  })
// =============================
    // Colopicker End
// =============================



function uploadImage(file_id) {
    var image = document.getElementById(file_id);
    var file = image.files[0];
    var fileType = file["type"];

    var validImageTypes = ["image/gif", "image/jpeg", "image/jpg", "image/png"];
    if ($.inArray(fileType, validImageTypes) < 0) {
        error_message("Allow jpeg,jpg,png and gif");
    } else {
        var formData = new FormData();
        formData.append("image", file);

        $.ajax({
            url: BASE_URL + "/author/update-image",
            type: "POST",
            contentType: false,
            cache: false,
            processData: false,
            data: formData,
            success: function (response) {
                var responseJSON = response;
                if (responseJSON.status == true) {
                    success_message(responseJSON.msg, "", 1);
                } else {
                    error_message(responseJSON.msg);
                }
            },
            error: function (response) {
                var responseJSON = response.responseJSON;
                error_message(responseJSON.msg);
            },
        });
    }
}