$(document).ready(function () {
    $(".parent-rating").click(function () {
        $(".child-rating").find("input").prop("checked", false);
    });
    $(".child-rating").click(function () {
        $(".parent-rating").find("input").prop("checked", false);
    });
    $(".parent-category").click(function () {
        $(".child-category").find("input").prop("checked", false);
    });
    $(".child-category").click(function () {
        $(".parent-category").find("input").prop("checked", false);
    });

    //laod more
    $("#load_more_button").on("click", function () {
        let page = $(this).attr("data");
        search_product(page);
    });

    //Get search page advertize
    $.get(BASE_URL + "get_advertize?page_name=SearchPage", function (data) {
        $("#advertize-ad").html(data.html);
    });
});

//Product Search filter
function search_product(page = "") {
   
    var url = $("#product-search-form").attr("action");
   
    let searchData = $("#product-search-form").serializeArray();
   
    searchData.push(
        {
            name: "search_text",
            value: $("#search_text").val(),
        },
        {
            name: "page",
            value: page ?? 1,
        },
        {
            name: "p_view",
            value: $(".p-view.active").data('val'),
        }
    );
    $.ajax({
        url: url,
        type: "POST",
        dataType: "JSON",
        data: searchData,
        success: function (response) {
            var responseJSON = response;
            if (responseJSON.status == true) {
                if (page != "")
                    $("#search_box").append(responseJSON.html_response);
                else $("#search_box").html(responseJSON.html_response);

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
search_product();
//End
