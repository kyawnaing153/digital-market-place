(function ($) {
    "use strict";
    var MarktifyAppX = {
        initialised: false,
        version: 1.0,
        mobile: false,
        init: function () {
            if (!this.initialised) {
                this.initialised = true;
            } else {
                return;
            }
            /*-------------- MarktifyAppX Design Functions Calling ---------------------------------------------------
		------------------------------------------------------------------------------------------------*/

            this.menu_toggle();
            this.bottom_top();
            this.loader();
            this.Choose_slider();
            this.Testimonial();
            this.Productcart_slider();
            this.Isotop_gallery();
            this.Magnific_popup();
            this.Nice_select();
            this.ListGridView();
        },

        /*-------------- MarktifyAppX Design Functions Calling ---------------------------------------------------
		--------------------------------------------------------------------------------------------------*/

        ListGridView: function () {
            $(".tp_view_list > ul > li > a").on("click", function () {
                $(".tp_view_list > ul > li > a").removeClass("active");
                $(this).addClass("active");
            });
            $(".list_view").on("click", function () {
                $(".tp_single_grid").addClass("product_list_view");
            });
            $(".grid_view").on("click", function () {
                $(".tp_single_grid").removeClass("product_list_view");
            });
        },

        // Nice select
        Nice_select: function () {
            $(".tp_nice_select").niceSelect();
        },
        // Nice select

        // loader
        loader: function () {
            jQuery(window).on("load", function () {
                $(".loader").fadeOut();
                $(".spinner").delay(500).fadeOut("slow");
            });
        },
        // loader

        // Navbar js
        menu_toggle: function () {
            $(".tp_toggle").click(function (e) {
                e.stopPropagation();
                $(".tp_header_menu").toggleClass("menu_open");
                $("body").toggleClass("toggle_open");
            });

            $(".tp_header_menu").click(function (e) {
                e.stopPropagation();
            });

            $("body,html").click(function (e) {
                $(".tp_header_menu").removeClass("menu_open");
                $("body").removeClass("toggle_open");
            });
        },
        // Navbar js

        // Bottom To Top
        bottom_top: function () {
            if ($("#button").length > 0) {
                var btn = $("#button");
                $(window).scroll(function () {
                    if ($(window).scrollTop() > 300) {
                        btn.addClass("show");
                    } else {
                        btn.removeClass("show");
                    }
                });
                btn.on("click", function (e) {
                    e.preventDefault();
                    $("html, body").animate({ scrollTop: 0 }, "300");
                });
            }
        },
        // Bottom To Top
        // Martiky slider
        Choose_slider: function () {
            var swiper = new Swiper(
                ".tp_uikit_section.tp_feture_product .swiper-container",
                {
                    slidesPerView: 3,
                    spaceBetween: 30,
                    loop: true,
                    speed: 1000,
                    autoplay: {
                        delay: 2500,
                        disableOnInteraction: false,
                    },
                    navigation: {
                        nextEl: ".tp_uikit_section.tp_feture_product .swiper-button-next",
                        prevEl: ".tp_uikit_section.tp_feture_product .swiper-button-prev",
                    },
                    breakpoints: {
                        1199: {
                            slidesPerView: 3,
                            spaceBetween: 30,
                        },
                        992: {
                            slidesPerView: 3,
                            spaceBetween: 30,
                        },
                        768: {
                            slidesPerView: 2,
                            spaceBetween: 30,
                        },
                        575: {
                            slidesPerView: 2,
                            spaceBetween: 15,
                        },
                        0: {
                            slidesPerView: 1,
                            spaceBetween: 15,
                        },
                    },
                }
            );
        },
        // martiky slider

        // Testimonial slider
        Testimonial: function () {
            var swiper = new Swiper(
                ".tp_uikit_section.tp_Testimonial_section .swiper-container",
                {
                    effect: "coverflow",
                    initialSlide: 1,
                    grabCursor: true,
                    loop: true,
                    centeredSlides: true,
                    slidesPerView: "auto",
                    coverflowEffect: {
                        rotate: 0,
                        stretch: 200,
                        depth: 800,
                        modifier: 1,
                        slideShadows: false,
                    },
                    navigation: {
                        nextEl: ".tp_uikit_section.tp_Testimonial_section .swiper-button-next",
                        prevEl: ".tp_uikit_section.tp_Testimonial_section .swiper-button-prev",
                    },
                }
            );
        },
        // Testimonial slider
        Productcart_slider: function () {
            var swiper = new Swiper(
                ".tp_uikit_section.tp_uikit_product .swiper-container",
                {
                    slidesPerView: 3,
                    spaceBetween: 30,
                    loop: true,
                    speed: 1000,
                    autoplay: {
                        delay: 2500,
                        disableOnInteraction: false,
                    },
                    navigation: {
                        nextEl: ".tp_uikit_section.tp_uikit_product .swiper-button-next",
                        prevEl: ".tp_uikit_section.tp_uikit_product .swiper-button-prev",
                    },
                    breakpoints: {
                        1199: {
                            slidesPerView: 3,
                            spaceBetween: 30,
                        },
                        992: {
                            slidesPerView: 3,
                            spaceBetween: 30,
                        },
                        768: {
                            slidesPerView: 2,
                            spaceBetween: 30,
                        },
                        575: {
                            slidesPerView: 2,
                            spaceBetween: 15,
                        },
                        0: {
                            slidesPerView: 1,
                            spaceBetween: 15,
                        },
                    },
                }
            );
        },

        // Star isotop gallery js

        Isotop_gallery: function () {
            $(window).on("load", function () {
                $(".gallery_grid").isotope({
                    itemSelector: ".grid-item",
                    filter: "*",
                });
                $(".int_project_gallery > .gallery_nav > ul > li").on(
                    "click",
                    "a",
                    function () {
                        // filter button click
                        var filterValue = $(this).attr("data-filter");
                        $(".gallery_grid").isotope({ filter: filterValue });

                        //active class added
                        $("a").removeClass("gallery_active");
                        $(this).addClass("gallery_active");
                    }
                );
            });

            $("#loadMore").on("click", function () {
                $(".int_view_gallery").addClass("int_view_gallery_view");
                $(".gallery_grid").isotope({
                    itemSelector: ".grid-item",
                    filter: "*",
                });
            });
        },

        // Star isotop gallery js

        // magnifiv popup for project gallery
        Magnific_popup: function () {
            if ($(".view").length > 0) {
                $(".view").magnificPopup({
                    type: "image",

                    gallery: {
                        // options for gallery
                        enabled: true,
                    },

                    // other options
                });
            }
        },
        // magnifiv popup for project gallery
    };
    MarktifyAppX.init();
})(jQuery);
