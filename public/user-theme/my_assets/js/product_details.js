$(document).ready(function () {
    "use strict";

    $(document)
        .find("#add-product-comment-form")
        .validate({
            rules: {
                comment: {
                    required: true,
                    minlength: 5,
                },
            },
            messages: {
                comment: {
                    required: "Please enter a comment.",
                },
            },
            submitHandler: function (form) {
                var postData = $("#add-product-comment-form").serializeArray();
                addCommentFunction("add-product-comment-form",postData, 0);
            },
        });

    $("#load_more_cmd_button").on("click", function () {
        let page = $(this).attr("data");
        search_comment(page);
    });

    $(document).on("click", ".reply-form-remove", function () {
        var closest = $(this).closest(".comment_section");
        closest.find(".reply-form").addClass("d-none");
    });

    $(document).on("click", ".reply-btn", function () {
        $(".reply-form").addClass("d-none");
        var closest = $(this).closest(".comment_section");
        closest.find(".reply-form").removeClass("d-none");

        closest.find(".addReply").validate({
            rules: {
                comment: {
                    required: true,
                    minlength: 5,
                    maxlength: 1000,
                },
            },
            messages: {
                comment: {
                    required: "Please Enter comment.",
                },
            },
            submitHandler: function (form) {
                var postData = closest.find(".addReply").serializeArray();
                closest.find(".reply-btn").attr("disabled", "disabled");

                closest.find(".cmd-reply-btn").buttonLoader("start");
                closest.find(".cmd-reply-btn").prop("disabled", true);

                $.ajax({
                    url: BASE_URL + "comment",
                    type: "POST",
                    dataType: "JSON",
                    data: postData,
                    cache: false,
                    success: function (response) {
                        closest.find(".cmd-reply-btn").prop("disabled", false);
                        closest.find(".cmd-reply-btn").buttonLoader("stop");
                        var responseJSON = response;
                        if (responseJSON.status == true) {
                            success_message(
                                responseJSON.msg,
                                responseJSON.url ?? "",
                                0
                            );
                            $(".comment-text-area").val("");
                            search_comment();
                        } else {
                            error_message(responseJSON.msg);
                        }
                    },
                    error: function (response) {
                        closest.find(".cmd-reply-btn").prop("disabled", false);
                        closest.find(".cmd-reply-btn").buttonLoader("stop");
                        var responseJSON = response.responseJSON;
                        if (responseJSON.status == true) {
                            success_message(responseJSON.msg);
                        } else {
                            error_message(responseJSON.msg);
                        }
                    },
                });
            },
        });
    });

    $.get(
        BASE_URL + "get_advertize?page_name=SingleProductPage",
        function (data) {
            $("#advertize-ad").html(data.html);
        }
    );
});

function addCommentFunction(form_id, postData = "", refresh_status = 1) {
    let form_btn_id = form_id + "-btn";
    $(document)
        .find("#" + form_btn_id)
        .buttonLoader("start");
    $(document)
        .find("#" + form_btn_id)
        .prop("disabled", true);

    $.ajax({
        url: BASE_URL + "comment",
        type: "POST",
        dataType: "JSON",
        data: postData,
        cache: false,
        success: function (response) {
            $("#" + form_btn_id).prop("disabled", false);
            $("#" + form_btn_id).buttonLoader("stop");
            var responseJSON = response;
            if (responseJSON.status == true) {
                success_message(
                    responseJSON.msg,
                    responseJSON.url ?? "",
                    refresh_status
                );
                $(".comment-text-area").val("");
                search_comment();
            } else {
                error_message(responseJSON.msg);
            }
        },
        error: function (response) {
            $("#" + form_btn_id).prop("disabled", false);
            $("#" + form_btn_id).buttonLoader("stop");
            var responseJSON = response.responseJSON;
            if (responseJSON.status == true) {
                success_message(responseJSON.msg);
            } else {
                error_message(responseJSON.msg);
            }
        },
    });
}

//Comment Search filter
function search_comment(page = "") {
    var url = BASE_URL + "comment/ajax_search";
    let searchData = {};
    searchData.filter_month = $("#filter_month").val();
    searchData.filter_year = $("#filter_year").val();
    searchData.product_id = $("#product_id").val();
    searchData.page = page ?? 1;
    $.ajax({
        url: url,
        type: "POST",
        dataType: "JSON",
        data: searchData,
        success: function (response) {
            var responseJSON = response;
            if (responseJSON.status == true) {
                if (page != "")
                    $("#cmd_search_box").append(responseJSON.html_response);
                else $("#cmd_search_box").html(responseJSON.html_response);

                if (responseJSON.last_page > responseJSON.current_page) {
                    $("#load_more_cmd_button").removeClass("d-none");
                    $("#load_more_cmd_button").attr(
                        "data",
                        responseJSON.current_page + 1
                    );
                } else {
                    $("#load_more_cmd_button").addClass("d-none");
                }
            } else {
                error_message(responseJSON.msg);
            }
        },
        error: function (response) {
            var responseJSON = response.responseJSON;
            if (responseJSON.status == true) {
                success_message(responseJSON.msg);
            } else {
                error_message(responseJSON.msg);
            }
        },
    });
}

//Rating Search filter
function search_rating(page = "") {
    var url = BASE_URL + "rating/ajax_search";
    let searchData = {};
    searchData.product_id = $("#product_id").val();
    searchData.rating = $("#filter_rating").val();
    $.ajax({
        url: url,
        type: "POST",
        dataType: "JSON",
        data: searchData,
        success: function (response) {
            var responseJSON = response;
            if (responseJSON.status == true) {
                if (page != "")
                    $("#review_search_box").append(responseJSON.html_response);
                else $("#review_search_box").html(responseJSON.html_response);

                if (responseJSON.last_page > responseJSON.current_page) {
                    $("#load_more_button").removeClass("d-none");
                    $("#load_more_button").attr(
                        "data",
                        responseJSON.current_page + 1
                    );
                } else {
                    $("#load_more_button").addClass("d-none");
                }
            } else {
                error_message(responseJSON.msg);
            }
        },
        error: function (response) {
            var responseJSON = response.responseJSON;
            if (responseJSON.status == true) {
                success_message(responseJSON.msg);
            } else {
                error_message(responseJSON.msg);
            }
        },
    });
}

setTimeout(() => {
    search_comment();
    search_rating();
}, 1000);
