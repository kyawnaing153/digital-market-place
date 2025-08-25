/*
Copyright Â© 2023 Marktify
------------------------------------------------------------------
[Admin Javascript]

Project:	Marktify

-------------------------------------------------------------------*/

(function ($) {
    "use strict";
	var marktify = {
		initialised: false,
		version: 1.0,
		mobile: false,
		init: function () {

			if(!this.initialised) {
				this.initialised = true;
			} else {
				return;
			}

			/*-------------- marktify Functions Calling ---------------------------------------------------
			------------------------------------------------------------------------------------------------*/
			this.Initialize();
            this.loader();
            this.Sidebar();
            this.menu_toggle();
            this.select_toggle();
		},

		/*-------------- marktify Functions definition ---------------------------------------------------
		---------------------------------------------------------------------------------------------------*/

		Initialize: function() {
        
		  // Custom Tab JS
		    $(document).on('click', '.tp_tab_wrappo ul li', function() {
				$('.tp_tab_wrappo ul li').removeClass('active');
				$(this).addClass('active');
				$('.tp_tab_section').addClass('tp_tab_hide');
				$('.tp_tab_content [data-section="'+$(this).data('target')+'"]').removeClass("tp_tab_hide");			
			});
		
	    // Sidebar Submenu JS
		   $(document).on('click', 'ul.tp_mainmenu>li>a', function() {
			   if(!$(this).parent().hasClass('active')){
					$(this).parent().children('ul').slideToggle();
					$('ul.tp_mainmenu>li>a').not($(this)).parent().children('ul').slideUp();
					$('ul.tp_mainmenu>li').removeClass('active');
					$(this).parent().toggleClass('active',300);
			   }
			
		  });
          //select 2 js
          $("select").select2()
            .on("change", function (e) {
                $(this).valid(); //jquery validation script validate on change
                }).on("select2:open", function() { //correct validation classes (has=*)
                if ($(this).parents("[class*='has-']").length) { //copies the classes
                    var classNames = $(this).parents("[class*='has-']")[0].className.split(/\s+/);
            
                    for (var i = 0; i < classNames.length; ++i) {
                        if (classNames[i].match("has-")) {
                            $("body > .select2-container").addClass(classNames[i]);
                        }
                    }
                } else { //removes any existing classes
                    $("body > .select2-container").removeClass (function (index, css) {
                        return (css.match (/(^|\s)has-\S+/g) || []).join(' ');
                    });            
                }
            });
		},
        // loader			
			loader: function () {
				jQuery(window).on('load', function() {
					$(".loader").fadeOut();
					$(".spinner").delay(500).fadeOut("slow");
				});
			},
		// loader
        Sidebar: function(){
            $('.tp_sidebar_manu ul li').has('.tp_submenu').addClass('has-sub-menu');
                $.sidebarMenu = function(menu) {
                    var animationSpeed = 300,
                        subMenuSelector = '.tp_submenu';
                    $(menu).on('click', 'li a', function(e) {
                        var $this = $(this);
                        var checkElement = $this.next();
                        if (checkElement.is(subMenuSelector) && checkElement.is(':visible')) {
                            checkElement.slideUp(animationSpeed, function() {
                                checkElement.removeClass('menu-show');
                            });
                            checkElement.parent("li").removeClass("active");
                        } else if ((checkElement.is(subMenuSelector)) && (!checkElement.is(':visible'))) {
                            var parent = $this.parents('ul').first();
                            var ul = parent.find('ul:visible').slideUp(animationSpeed);
                            ul.removeClass('menu-show');
                            var parent_li = $this.parent("li");
                            checkElement.slideDown(animationSpeed, function() {
                                checkElement.addClass('menu-show');
                                parent.find('li.active').removeClass('active');
                                parent_li.addClass('active');
                            });
                        }
                        if (checkElement.is(subMenuSelector)) {
                            e.preventDefault();
                        }
                    });
    
                }
                $.sidebarMenu($('.tp_mainmenu'));
                $(function() {
                    for (var a = window.location, counting = $(".tp_mainmenu a").filter(function() {
                            return this.href == a;
                        }).addClass("active").parent().addClass("active");;) {
                        if (!counting.is("li")) break;
                        counting = counting.parent().addClass("in").parent().addClass("active");
                    }
                });
        },

        menu_toggle: function() {
            $(document).on("click", function(event){
              var $trigger = $(".menu_toggle");
                if($trigger !== event.target && !$trigger.has(event.target).length){
                    $(".tp_menu").removeClass('open_menu');
                    $("body").removeClass('slide_wrapper');
                }            
            });
            $(".menu_toggle").click(function(){
                $(".tp_menu").toggleClass('open_menu');
                $("body").toggleClass('slide_wrapper');
            });
          },

          select_toggle:function(){
            $(document).on("click", function(event){
                var $trigger = $('.tp_custom_select');
                  if($trigger !== event.target && !$trigger.has(event.target).length){
                      $("body").removeClass('cs-select-dropdown');
                  }            
              });
              $(document).find(".tp_custom_select").click(function(){
                  $("body").addClass('cs-select-dropdown');
              });
          }
	};
marktify.init();
})(jQuery);

// toggle js
$('.tp_toggle').click(function(e){
    e.stopPropagation();
    $('.tp_sidebar').toggleClass('menu_open');
});

$('.tp_sidebar').click(function(e){
    e.stopPropagation();
});

$('body,html').click(function(e){
    $('.tp_sidebar').removeClass('menu_open');
});

