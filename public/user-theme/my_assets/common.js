/**
* set csrf token in header
*/
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {
    "use strict";
    //Remove toaster message
    $(document).on('click', '.tp_close_icon', function () {
        $(document).find('#msg-toast').html("");
    })

    $(document).on('click', '.watchlist_btn', function () {
        if ($(this).find('.fa-heart').hasClass('active'))
            $(this).find('.fa-heart').removeClass('active');
        else
            $(this).find('.fa-heart').addClass('active');
    });

    //Submit newsletter ajax function
    $("#newsletter_form").submit(function(e){
        e.preventDefault();
        var postData = $('#newsletter_form').serializeArray();
        add_update_details('newsletter_form', postData, 0);
    });

    //show hide password
    $(".toggle-password").click(function () {
        var eyeslash = ASSET_URL + 'assets/images/auth/password.svg';
        var eye = ASSET_URL + 'assets/images/auth/eye.svg';
        var input = $(this).siblings('input');
        if (input.attr("type") == "password") {
            input.attr("type", "text");
            $(this).attr('src', eye);
        } else {
            input.attr("type", "password");
            $(this).attr('src', eyeslash);
        }
    });
    
});

//Error Message toster
function error_message(msg) {
    var html = `<div class="tp_error_msg toster_open">
    <div class="tp_close_icon">
        <span>×</span>
    </div>
    <div class="tp_success_flex">
        <div class="tp_happy_img">
            <img src="`+ SAD_STRIKER +`" alt="Sad Striker" />
        </div>
        <div class="tp_yeah">
            <h5>Ooops,</h5>
            <p>`+ msg + `</p>
        </div>
    </div>
</div>`;
    $(document).find('#msg-toast').html(html);

    setTimeout(() => {
        $(document).find('#msg-toast').html("");
    }, 2000);
}

//Success Message toster
function success_message(msg = "", url = "", reload = "") {
    var html = `<div class="tp_success_msg toster_open">
        <div class="tp_close_icon">
            <span>×</span>
        </div>
        <div class="tp_success_flex">
            <div class="tp_happy_img">
                <img src="`+ HAPPY_STRIKER + `" alt="Happy striker" />
            </div>
            <div class="tp_yeah">
                <h5>Great Success!</h5>
                <p>`+ msg + `</p>
            </div>
        </div>
    </div>`;
    $(document).find('#msg-toast').html(html);

    if (url != "") {
        setTimeout(() => {
            window.location.href = url;
        }, 1000);
    }
    else if (reload == 1) {
        setTimeout(() => {
            location.reload();
        }, 1000);
    } else {
        setTimeout(() => {
            $(document).find('#msg-toast').html("");
        }, 2000);
    }

}

//Add to cart common function 
function addToCart(slug = "", buy_now = "") {
    var postData = {};
    if (slug == "") {
        postData = $('#add-to-card-form').serializeArray();
        if (buy_now != "") {
            postData.push({
                'name': 'buy_now',
                'value': 1,
            });
        }
    }
    else
        postData.slug = slug;
    $.ajax({
        url: BASE_URL + "cart",
        type: 'POST',
        dataType: 'JSON',
        data: postData,
        success: function (response) {
            var responseJSON = response;
            if (responseJSON.status == true) {
                success_message(responseJSON.msg, responseJSON.url);
            } else {
                error_message(responseJSON.msg);
            }
        },
        error: function (response) {
            var responseJSON = response.responseJSON;
            error_message(responseJSON.msg);
        }
    });
}

//Common add update function 
function add_update_details(form_id, postData = "", refresh_status = 1) {
    var url = $('#' + form_id).attr('action');
    let form_btn_id = form_id + '_btn';
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
            
            if(refresh_status == 0){
                $('#' + form_id).find("input").val("");
                $('#' + form_id).find("textarea").val("");
            }
            
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
//Coupon Submit 
function couponCodeApply(form_id) {
    $(document).find('#' + form_id).validate({
        rules: {
            coupon_code: {
                required: true,
            },
        },
        messages: {
            coupon_code: {
                required: 'Please Enter Discount Code.',
            },
        },
        submitHandler: function (form) {
            var postData = $('#' + form_id).serializeArray();
            add_update_details(form_id, postData, 1);
        }
    });
}

//validate checkout 
function validatecheckout(form_id) {
    $(document).find('#' + form_id).validate({
        rules: {
            gateway: {
                required: true,
            },
            reference_number:{
                required: true,
                minlength:12
            }
        },
        messages: {
            gateway: {
                required: 'Please select any gateway.',
            },
            reference_number: {
                required: 'Reference Number is required.',
            },
        },
        submitHandler: function (form) {
            $(document).find('#' + form_id + '_btn').buttonLoader('start');
            $(document).find('#' + form_id + '_btn').prop('disabled', true);
            $('#' + form_id + '_btn').attr('disabled', 'disabled');
            form.submit();
        }
    });
}
//validate checkout 
function validatecheckout(form_id) {
    $(document).find('#' + form_id).validate({
        rules: {
            gateway: {
                required: true,
            },
            billing_name: {
               required: true,
            },
            billing_email:{
                required: true,
                email: true,
            },
            reference_number:{
                required: true,
                minlength:12
            }
        },
        messages: {
            gateway: {
                required: 'Please select any gateway.',
            },
            billing_name: {
                required: 'Please enter your name',
            },
            billing_email: {
                required: 'Please enter your email',
            },
            reference_number: {
                required: 'Reference Number is required.',
            },
        },
        submitHandler: function (form) {
            $(document).find('#' + form_id + '_btn').buttonLoader('start');
            $(document).find('#' + form_id + '_btn').prop('disabled', true);
            $('#' + form_id + '_btn').attr('disabled', 'disabled');
            form.submit();
        }
    });
}

$(document).on('click','[name=gateway]',function(){
    if($(this).val() == "manual"){
        $("#manual_transfer_details").removeClass('d-none');
    }else{
        $("#manual_transfer_details").addClass('d-none');
    }

});

/**
* add to wishlist common function
*/
function addtoWishlist(slug) {
    var _url = BASE_URL + "cart/add-to-wishlist";
    $.ajax({
        url: _url,
        type: 'POST',
        dataType: 'JSON',
        data: { 'slug': slug },
        success: function (response) {
            var responseJSON = response;
            if (responseJSON.status == true) {
                success_message(responseJSON.msg, responseJSON.url, 0);

            } else {
                error_message(responseJSON.msg);
            }
        },
        error: function (response) {
            var responseJSON = response.responseJSON;
            error_message(responseJSON.msg);
        }
    });

}

// //header search input placeholder animation
document.addEventListener("DOMContentLoaded", function() {
    let i = 0;
    let placeholder = "";
    function typeAnimation() {

        let searchTextElement = document.getElementById("search_text");
        if (searchTextElement) {
            if (i < autoSearch.length) {
                placeholder += autoSearch.charAt(i);
                searchTextElement.setAttribute("placeholder", placeholder);
                i++;
                setTimeout(typeAnimation, 120);
            } else {
                i = 0;
                placeholder = "";
                setTimeout(typeAnimation, 120);
            }
        }
    }

    typeAnimation();
});



