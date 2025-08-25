$(document).ready(function () {
    "use strict";
    $(document).on("click", "#add_more_options", function () {
        var html = $(this)
            .closest(".options-op")
            .clone()
            .first()
            .find("input")
            .val("")
            .end();
        html.find(".option-add-btn").html(`<button type="button"
                                    class="btn-sm btn-danger float-end mt-4 remove-p-d"><i
                                        class="fa fa-trash"></i>
                                </button>`);
        $(this).closest(".option-body").append(html);
    });
    var question = $("#total_que").val() ?? 1;
    $(document).on("click", "#add_more_question_ans", function () {
        var html = $(".que-parent").clone().first().find("input").val("").end();

        html.find(".que-add-button").html(`<button type="button"
                                    class="btn-sm btn-danger float-end mt-4 remove-ques"><i
                                        class="fa fa-trash"></i>
                                </button>`);
        question++;
        html.find(".options").attr("name", "options" + question + "[]");
        $("#que-parent").append(html);
    });

    $(document).on("click", ".remove-p-d", function () {
        $(this).closest(".options-op").remove();
    });

    $(document).on("click", ".remove-ques", function () {
        $(this).closest(".que-parent").remove();
    });
});
