$(document).ready(function() {
    "use strict";

    jQuery.validator.setDefaults({
        ignore: ":hidden, [contenteditable='true']:not([name])"
    });

    jQuery.validator.addMethod("ck_editor", function() {
        var content_length = editorTextarea.getData().trim().length;
        return content_length > 0;
    }, "Please insert content for the page.");

    $(document).find('#product-first-step-form').validate({
        rules: {
            product_type: {
                required: true,
            },
            name: {
                required: true,
            },
            slug: {
                required: true,
            },
            category_id: {
                required: true,
            },
            sub_category_id: {
                required: true,
            },
            short_desc: {
                required: true,
            },
            tags: {
                required: true,
            },
            description: {
                ck_editor: true,
            },
            preview_link: {
                required: true,
            },
            meta_title: {
                required: true,
                maxlength: 55,
                notEqualTo: '[name="name"]'
            },
            meta_keywords: {
                required: true,
            },
            meta_desc: {
                required: true,
            },
        },
        messages: {
            product_type: {
                required: 'Please Select Product Type.',
            },
            name: {
                required: 'Product name is required.',
            },
            slug: {
                required: 'Product Url name is required.',
            },
            category_id: {
                required: 'Please Select Category.',
            },
            sub_category_id: {
                required: 'Please Select Sub Category.',
            },
            short_desc: {
                required: 'Short Description required.',
            },
            tags: {
                required: 'Product Tags required.',
            },
            description: {
                ck_editor: 'Description is required.',
            },
            quantity: {
                required: 'Quantity  is required.',
            },
            preview_link: {
                required: 'Product Url name is required.',
            },
            meta_desc: {
                required: 'Meta Description is required.',
            },
            meta_title: {
                required: 'Meta title is required.',
            },
            meta_keywords: {
                required: 'Meta keywords is required.',
            },

        },
        submitHandler: function(form) {
            editorTextarea.updateSourceElement();
            var postData = $('#product-first-step-form').serializeArray();
            add_update_details('product-first-step-form', postData);
        }
    });


    $(document).on('click', '#add_more_product_detail', function() {
        var html = $('#p-field').clone().find("input").val("").end();
        html.find('.field-button').html(`<button type="button"
                                            class="btn-sm btn-danger float-end mt-4 remove-p-d"><i
                                                class="fa fa-trash"></i>
                                        </button>`);
        $('#p-d-body').append(html);
    });

    $(document).on('click', '.remove-p-d', function() {
        $(this).closest('.child-items').remove();
    });
})