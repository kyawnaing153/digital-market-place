/*A jQuery plugin which add loading indicators into buttons
* By Minoli Perera
* MIT Licensed.
*/
(function ($) {
    "use strict";
    $('.has-spinner').attr("disabled", false);
    $.fn.buttonLoader = function (action) {
        var self = $(this);
        if (action == 'start') {
            if ($(self).attr("disabled") == "disabled") {
                return false;
            }
            $('.has-spinner').attr("disabled", true);
            $(self).attr('data-btn-text', $(self).text());
            var text = 'Loading';
            if ($(self).attr('data-load-text') != undefined && $(self).attr('data-load-text') != "") {
                var text = $(self).attr('data-load-text');
            }
            $(self).html('<div class="spinner123"><i class="fa fa-spinner fa-spin" title="button-loader"></i></div> ' + text);
            $(self).addClass('active');
        }
        if (action == 'stop') {
            $(self).html($(self).attr('data-btn-text'));
            $(self).removeClass('active');
            $('.has-spinner').attr("disabled", false);
        }
    }
})(jQuery);
