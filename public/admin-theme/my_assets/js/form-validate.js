$(document).ready(function () {
    "use strict";
    /* multiselect */
    $(".multiselect").select2();

    jQuery.validator.setDefaults({
        ignore: ":hidden, [contenteditable='true']:not([name])",
    });
    /* add/edit advertise validation */
    $(document)
        .find("#banner-form")
        .validate({
            rules: {
                link: {
                    required: true,
                },
                title: {
                    required: true,
                },
            },
            messages: {
                link: {
                    required: "Banner Link is required.",
                },
                title: {
                    required: "Banner Title is required.",
                },
            },
            submitHandler: function (form) {
                var postData = new FormData(form);
                add_update_details_with_img("banner-form", postData);
            },
        });

    /* add/edit discount coupon validation */
    $(document)
        .find("#coupon-discount")
        .validate({
            rules: {
                coupon_name: {
                    required: true,
                },
                coupon_code: {
                    required: true,
                },
                coupon_amount: {
                    required: true,
                },
                coupon_type: {
                    required: true,
                },
            },
            messages: {
                coupon_name: {
                    required: "Coupon name is required.",
                },
                coupon_code: {
                    required: "Coupon code is required.",
                },
                coupon_amount: {
                    required: "Coupon amount is required.",
                },
                coupon_type: {
                    required: "Coupon Type is required.",
                },
            },
            submitHandler: function (form) {
                var postData = $("#coupon-discount").serializeArray();
                add_update_details("coupon-discount", postData);
            },
        });

    /* add/edit discount coupon validation */

    /* add/edit home content validation */
    $(document)
        .find("#why-choose-us-form")
        .validate({
            rules: {
                image:{
                    required: isIdExist,
                },
                heading: {
                    required: true,
                },
                sub_heading: {
                    required: true,
                },
                type: {
                    required: true,
                },
            },
            messages: {
                image: {
                    required: "Image is required.",
                },
                heading: {
                    required: "Heading is required.",
                },
                sub_heading: {
                    required: "Sub Heading is required.",
                },
                type: {
                    required: "Please Select Type.",
                },
            },
            submitHandler: function (form) {
                var postData = new FormData(form);
                add_update_details_with_img("why-choose-us-form", postData);
            },
        });

    $(".lang-tab").click(function () {
        $(".lang-tab-tar").hide();
        var target = $(this).data("target");
        $("#" + target).show();
    });
   

    /* add/edit pages validation */
    $(document)
        .find("#pages-post-form")
        .validate({
            rules: {
                heading: {
                    required: true,
                },
                slug: {
                    required: true,
                },
                sub_heading: {
                    required: true,
                },
                description: {
                    required: true,
                },
                meta_title: {
                    required: true,
                    maxlength: 55,
                    notEqualTo: '[name="heading"]',
                },
                meta_keywords: {
                    required: true,
                },
                meta_desc: {
                    required: true,
                },
            },
            messages: {
                slug: {
                    required: "Slug is required.",
                },
                topic_id: {
                    required: "Topic Id is required.",
                },
                heading: {
                    required: "Heading is required.",
                },
                sub_heading: {
                    required: "Sub heading is required.",
                },
                short_desc: {
                    required: "Short description is required.",
                },
                description: {
                    required: "Description is required.",
                },
                meta_title: {
                    required: "Meta title is required.",
                },
                meta_keywords: {
                    required: "Meta keywords is required.",
                },
                meta_desc: {
                    required: "Meta description is required.",
                },
            },
            submitHandler: function (form) {
                editorTextarea.updateSourceElement();
                var postData = $("#pages-post-form").serializeArray();
                add_update_details("pages-post-form", postData);
            },
        });

    /* add/edit category validation */
    $(document)
        .find("#product-category-form")
        .validate({
            rules: {
                name: {
                    required: true,
                },
                slug: {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: "Category name is required.",
                },
                slug: {
                    required: "Category slug is required.",
                },
            },
            submitHandler: function (form) {
                var postData = $("#product-category-form").serializeArray();
                console.log(postData);
                add_update_details("product-category-form", postData);
            },
        });

    /* add/edit sub category validation */
    $(document)
        .find("#product-sub-category-form")
        .validate({
            rules: {
                name: {
                    required: true,
                },
                slug: {
                    required: true,
                },
                category_id: {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: "Sub Category name is required.",
                },
                slug: {
                    required: "Sub Category slug is required.",
                },
                category_id: {
                    required: "Please Select Category.",
                }
            },
            submitHandler: function (form) {
                var postData = $("#product-sub-category-form").serializeArray();
                add_update_details("product-sub-category-form", postData);
            },
        });

    /* add/edit testimonal validation */
    $(document)
        .find("#client-testimonal")
        .validate({
            rules: {
                image: {
                    required: isIdExist,
                 },
                name: {
                    required: true,
                },
                designation: {
                    required: true,
                },
                message: {
                    required: true,
                },
                rating: {
                    required: true,
                    range: [0.5, 5],
                },
            },
            messages: {
                image: {
                    required: "Please Select Image.",
                },
                name: {
                    required: "Name is required.",
                },
                designation: {
                    required: "Designation is required.",
                },
                message: {
                    required: "Message is required.",
                },
                rating: {
                    required: "Rating is required.",
                },
            },
            submitHandler: function (form) {
                var postData = new FormData(form);
                add_update_details_with_img("client-testimonal", postData);
            },
        });

   
    /* add/edit vendor terms and conditions validation */
    $(document)
        .find("#vendor-form")
        .validate({
            rules: {
                vendor_tnctext: {
                    required: true,
                },
            },
            messages: {
                vendor_tnctext: {
                    required: "Vendor Terms and condition is required.",
                },
            },
            submitHandler: function (form) {
                editorTextarea.updateSourceElement();
                var postData = $("#vendor-form").serializeArray();
                add_update_details("vendor-form", postData);
            },
        });
   
 /* add/edit user validation */
    $(document)
    .find("#user-form")
    .validate({
        rules: {
            role: {
                required: true,
            },
            full_name: {
                required: true,
            },
            email: {
                required: true,
                minlength: 4,
                maxlength: 100,
                email: true,
            },
            password: {
                required: isIdExist,
                minlength: 6,
                validpass: true,
                maxlength: 50,
            },
        },
        messages: {
            role: {
                required: "Please select user role.",
            },
            full_name: {
                required: "Full Name is required.",
            },
            email: {
                required: "Email is required.",
            },
            password: {
                required: "Password is required.",
            },
        },
        submitHandler: function (form) {
            var postData = new FormData(form);
            add_update_details_with_img("user-form", postData);
        },
    });

    /* admin update profile validation */   
    $(document).find('#my-profile').validate({
        rules: {
            full_name: {
                required: true,
            }
        },
        messages: {
            full_name: {
                required: 'Full Name is required.',
            }
        },
        submitHandler: function(form) {
            var postData = new FormData(form);
            add_update_details_with_img('my-profile', postData);
        }
    });

    /* admin add update connect email list validation */   
    $(document).find('#connect-email-list-form').validate({
        submitHandler: function(form) {
            var postData = $("#connect-email-list-form").serializeArray();
            add_update_details('connect-email-list-form', postData);
        }
    });

     /* admin update profile validation */   
     $(document).find('#my-account-details-form').validate({
        rules: {
            bank_name: {
                required: true,
            },
            account_holder_name: {
                required: true,
            },
            bank_account_number: {
                required: true,
            },
            ifsc_code: {
                required: true,
            }
        },
        messages: {
            bank_name: {
                required: 'Bank Name is required.',
            },
            account_holder_name: {
                required: 'Account Holder Name is required.',
            },
            bank_account_number: {
                required: 'Bank Account Number is required.',
            },
            ifsc_code: {
                required: 'IFSC Code is required.',
            }
        },
        submitHandler: function(form) {
            var postData = $("#my-account-details-form").serializeArray();
            add_update_details("my-account-details-form", postData);
        }
    });

     /* update withdraw request  validation */
     $(document)
     .find("#update-request-form")
     .validate({
         submitHandler: function (form) {
             var postData = $("#update-request-form").serializeArray();
             add_update_details("update-request-form", postData);
         },
     });

      /* Update Order Status */
      $(document)
      .find("#order-status-update-form")
      .validate({
          submitHandler: function (form) {
              var postData = $("#order-status-update-form").serializeArray();
              add_update_details("order-status-update-form", postData);
          },
      });

      $(document)
      .find("#update-product-status-form")
      .validate({
          submitHandler: function (form) {
              var postData = $("#update-product-status-form").serializeArray();
              add_update_details("update-product-status-form", postData, 1);
          },
      });

});

 /* add/edit user validation */
 jQuery.validator.addMethod(
    "validpass",
    function (value) {
        $req = $("#password").attr("required");
        if (value.length > 0) {
            var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/;
            return regex.test(value);
        }
        return true;
    },
    "Password should contains at least 6 characters, 1 number, 1 lowercase ,1 uppercase letter and one special character"
);

function isIdExist() {
    if ($("#resource_id").val())
    return false;
    else 
    return true;
}

 /* add/edit language files validation */
 function languagefileformValidate(form_id) {
    $(document)
        .find("#" + form_id)
        .validate({
            submitHandler: function (form) {
                var postData = $("#" + form_id).serializeArray();
                add_update_details(form_id, postData, 0);
            },
        });
}

 /* add/edit language validation */
 function languageformValidate(form_id) {
    $(document)
        .find("#" + form_id)
        .validate({
            rules: {
                name: {
                    required: true,
                },
                short_name: {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: "Name is required.",
                },
                short_name: {
                    required: "Short Name required.",
                },
            },
            submitHandler: function (form) {
                // form.submit();
                var postData = $("#" + form_id).serializeArray();
                add_update_details(form_id, postData, 1);
            },
        });
}


 /* Email connent disconnect */
$('.email-integration').click(function() {
    $('.email-integration-tar').hide();
    var target = $(this).data('target');
    $('#' + target).show();

});

function openEmailIntePopup(emAppId, name) {
    var id = emAppId.replace("_", "-");
    $('.common_form').addClass('hide')
    $('#' + id + '-form').removeClass('hide');
    $('#myModalLabel').text('Connect to ' + name);
    $('#connectemails').modal('show');
}

function emailformValidate(form_id) {
    $(document).find('#' + form_id).validate({
        rules: {
            api_key: {
                required: true,
            },
            api_url: {
                required: true,
            },
            user_name: {
                required: true,
            },
            password: {
                required: true,
            },
            api_token: {
                required: true,
            },
            api_secret: {
                required: true,
            },
        },
        messages: {
            api_key: {
                required: 'API KEY is required.',
            },
            api_url: {
                required: 'API URL is required.',
            },
            user_name: {
                required: 'user email  is required.',
            },
            password: {
                required: 'password is required.',
            },
            api_token: {
                required: 'API Token is required.',
            },
            api_secret: {
                required: 'API Secret is required.',
            },
        },
        submitHandler: function(form) {
            var postData = $('#' + form_id).serializeArray();
            console.log(postData);
            add_update_details(form_id, postData);
        }
    });
}

 /* Email connent disconnect */

  /* Email Template start */
 $(".setting-tab").click(function() {
    $(".setting-tab-tar").hide();
    var target = $(this).data("target");
    $("#" + target).show();
});
$(document).ready(function() {
    $('.setting-form').each(function() {
        $(this).validate({
            submitHandler: function(form) {
                var postData = $(form).serializeArray();
                add_update_details(form.id, postData, 0);
            }
        });
    });
});

function testMail(form_id) {

    $(document).find('#' + form_id).validate({
        rules: {
            email: {
                required: true,
                email: true,
            },
        },
        messages: {
            email: {
                required: 'Email is required.',
            }
        },
        submitHandler: function(form) {
            var postData = $('#' + form_id).serializeArray();
            add_update_details(form_id, postData, 0);
            setTimeout(() => {
                $('#' + form_id).find('#email').val('');
            }, 1500);
        }
    });
}

  /* Email Template End */


   /* admin update profile validation */
function withdrawValidation(form_id,MinWithdraw,MaxWithdraw){
    $(document).find('#'+form_id).validate({
        rules: {
            amount: {
                required: true,
                max:MaxWithdraw,
                min:MinWithdraw
            }
        },
        messages: {
            amount: {
                required: 'Please Enter Amount.',
                min:"amount is greater than and equal to the min withdrawal amount.",
                max:"insufficient balance.",
            }
        },
        submitHandler: function(form) {
            var postData = $("#"+form_id).serializeArray();
            add_update_details(form_id, postData);
        }
    });
}

  /* admin update validation */
function common_add_update_validation(form_id)
{
    $(document)
    .find("#" + form_id)
    .validate({
        submitHandler: function (form) {
            var postData = $("#" + form_id).serializeArray();
            add_update_details(form_id, postData, 0);
        },
    });
}