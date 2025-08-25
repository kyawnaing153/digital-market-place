$(document).ready(function () {
    "use strict";

    $("#OpenImgUpload").click(function () {
        $("#imgupload").trigger("click");
    });

    $(document)
        .find("#update_user_details")
        .validate({
            rules: {
                full_name: {
                    required: true,
                },
                username: {
                    required: true,
                },
                email: {
                    required: true,
                },
            },
            messages: {
                full_name: {
                    required: "Full Name is required.",
                },
                username: {
                    required: "User name is required.",
                },
            },
            submitHandler: function (form) {
                var postData = $("#update_user_details").serializeArray();
                add_update_details("update_user_details", postData);
            },
        });

    $(document)
        .find("#change_password_form_id")
        .validate({
            rules: {
                old_password: {
                    required: true,
                },
                password: {
                    required: true,
                    minlength: 6,
                    validpass: true,
                    maxlength: 50,
                },
                confirm_password: {
                    required: true,
                    equalTo: '[name="password"]',
                },
            },
            messages: {
                old_password: {
                    required: "Old Password is required.",
                },
                password: {
                    required: "New Password is required.",
                    minlength:
                        "Password should contains at least 6 characters, 1 number, 1 lowercase ,1 uppercase letter and one special character",
                    notEqual:
                        "Current Password and New Password will not be same.",
                },
                confirm_password: {
                    required: "Confirm Password is required.",
                    equalTo: "New Password & Confirm Password must be same.",
                },
            },
            submitHandler: function (form) {
                var postData = $("#change_password_form_id").serializeArray();
                add_update_details("change_password_form_id", postData);
            },
        });

    $(document)
        .find("#frmContactUs")
        .validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3,
                    maxlength: 25,
                },
                email: {
                    required: true,
                    email: true,
                },
                subject: {
                    required: true,
                },
                message: {
                    required: true,
                }
            },
            messages: {
                name: {
                    required: "Please Enter Full Name",
                },
                email: {
                    required: "Email is required.",
                    email: "Please enter valid email address.",
                },
                message: {
                    required: "Message is required.",
                },
                subject: {
                    required: "Subject is required.",
                }
            },
            submitHandler: function (form) {
                var postData = $("#frmContactUs").serializeArray();
                add_update_details("frmContactUs", postData,0);
            },
        });

    $(document)
        .find("#user_set_review")
        .validate({
            rules: {
                comment: {
                    required: true,
                    minlength: 20,
                    maxlength: 2000,
                },
            },
            messages: {
                comment: {
                    required: "Please write a review.",
                },
            },
            submitHandler: function (form) {
                var postData = $("#user_set_review").serializeArray();
                add_update_details("user_set_review", postData);
            },
        });

        $(document)
        .find("#become_an_author_form_id")
        .validate({
            rules: {
                "answer[0]": {
                    required: true,
                },
                "answer[1]": {
                    required: true,
                },
                "answer[2]": {
                    required: true,
                },
                "answer[3]": {
                    required: true,
                },
                "answer[4]": {
                    required: true,
                },
                author_terms_condition: {
                    required: true,
                },
            },
            messages: {
                "answer[0]": {
                    required: "Please select one of them.",
                },
                "answer[1]": {
                    required: "Please select one of them.",
                },
                "answer[2]": {
                    required: "Please select one of them.",
                },
                "answer[3]": {
                    required: "Please select one of them.",
                },
                "answer[4]": {
                    required: "Please select one of them.",
                },
                author_terms_condition: {
                    required: "Pelase Select Terms and Condition",
                },
            },
            submitHandler: function (form) {

                var postData = $("#become_an_author_form_id").serializeArray();
                add_update_details("become_an_author_form_id", postData);
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


function setReview(img, slug, txid = "", ratid = "", rate = "") {
    $(".rate").prop("checked", false);
    $("#md-review-img").attr("src", img);
    $("#_pid").val(slug);
    $("#_txid").val(txid);
    $("#_rate_id").val(ratid);
    var cmt = $("#r_comment_" + ratid).val();
    $("#rt_comment").val(cmt);
    $("#star" + rate).prop("checked", true);
}

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
            url: BASE_URL + "update-user-image",
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
