/**
Core script to handle the entire theme and core functions
**/
var Layout = function () {

    var layoutImgPath = Metronic.getAssetsPath() + 'admin/layout3/img/';

    var layoutCssPath = Metronic.getAssetsPath() + 'admin/layout3/css/';

    //* BEGIN:CORE HANDLERS *//
    // this function handles responsive layout on screen size resize or mobile device rotate.

    // Handles header
    var handleHeader = function () {        
        // handle search box expand/collapse        
        $('.page-header').on('click', '.search-form', function (e) {
            $(this).addClass("open");
            $(this).find('.form-control').focus();

            $('.page-header .search-form .form-control').on('blur', function (e) {
                $(this).closest('.search-form').removeClass("open");
                $(this).unbind("blur");
            });
        });

        // handle hor menu search form on enter press
        $('.page-header').on('keypress', '.hor-menu .search-form .form-control', function (e) {
            if (e.which == 13) {
                $(this).closest('.search-form').submit();
                return false;
            }
        });

        // handle header search button click
        $('.page-header').on('mousedown', '.search-form.open .submit', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).closest('.search-form').submit();
        });

        $(document).on('click', '.mega-menu-dropdown .dropdown-menu', function (e) {
            e.stopPropagation();
        });
    };

    // Handles main menu
    var handleMainMenu = function () {

        // handle menu toggler icon click
        $(".page-header .menu-toggler").on("click", function(event) {
            if (Metronic.getViewPort().width < 992) {
                var menu = $(".page-header .page-header-menu");
                if (menu.hasClass("page-header-menu-opened")) {
                    menu.slideUp(300);
                    menu.removeClass("page-header-menu-opened");
                } else {
                    menu.slideDown(300);
                    menu.addClass("page-header-menu-opened");
                }
            }
        });

        // handle sub dropdown menu click for mobile devices only
        $(".dropdown-submenu > a").on("click", function(e) {
            if (Metronic.getViewPort().width < 992) {
                if ($(this).next().hasClass('dropdown-menu')) {
                    e.stopPropagation();

                    if ($(this).parent().hasClass("open")) {
                        $(this).parent().removeClass("open");
                        $(this).next().hide();
                    } else {
                        $(this).parent().addClass("open");
                        $(this).next().show();
                    }
                }
            }
        });

        // handle hover dropdown menu for desktop devices only
        if (Metronic.getViewPort().width >= 992) {
            $('[data-hover="megamenu-dropdown"]').not('.hover-initialized').each(function() {   
                $(this).dropdownHover(); 
                $(this).addClass('hover-initialized'); 
            });
        }

        // handle fixed mega menu(minimized) 
        $(window).scroll(function() {                
            var offset = 75;
            if ($('body').hasClass('page-header-menu-fixed')) {
                if ($(window).scrollTop() > offset){
                    $(".page-header-menu").addClass("fixed");
                } else {
                    $(".page-header-menu").removeClass("fixed");  
                }
            }

            if ($('body').hasClass('page-header-top-fixed')) {
                if ($(window).scrollTop() > offset){
                    $(".page-header-top").addClass("fixed");
                } else {
                    $(".page-header-top").removeClass("fixed");  
                }
            }
        });
    };

    // Handles main menu on window resize
    var handleMainMenuOnResize = function() {
        // handle hover dropdown menu for desktop devices only
        if (Metronic.getViewPort().width >= 992) {
            $('.hor-menu [data-hover="megamenu-dropdown"]').not('.hover-initialized').each(function() {   
                $(this).dropdownHover(); 
                $(this).addClass('hover-initialized'); 
            });
            $('.hor-menu .navbar-nav li.open').removeClass('open');
        } else {
            // disable hover bootstrap dropdowns plugin
            $('.hor-menu [data-hover="megamenu-dropdown"].hover-initialized').each(function() {   
                $(this).unbind('hover');
                $(this).parent().unbind('hover').find('.dropdown-submenu').each(function() {
                    $(this).unbind('hover');
                });
                $(this).removeClass('hover-initialized'); 
            });
        }
    };

    var handleContentHeight = function() {
        var height;

        if ($('body').height() < Metronic.getViewPort().height) {            
            height = Metronic.getViewPort().height -
                $('.page-header').outerHeight() - 
                ($('.page-container').outerHeight() - $('.page-content').outerHeight()) -
                $('.page-prefooter').outerHeight() - 
                $('.page-footer').outerHeight();

            $('.page-content').css('min-height', height);
        }
    };

    // Handles the go to top button at the footer
    var handleGoTop = function () {
        var offset = 100;
        var duration = 500;

        if (navigator.userAgent.match(/iPhone|iPad|iPod/i)) {  // ios supported
            $(window).bind("touchend touchcancel touchleave", function(e){
               if ($(this).scrollTop() > offset) {
                    $('.scroll-to-top').fadeIn(duration);
                } else {
                    $('.scroll-to-top').fadeOut(duration);
                }
            });
        } else {  // general 
            $(window).scroll(function() {
                if ($(this).scrollTop() > offset) {
                    $('.scroll-to-top').fadeIn(duration);
                } else {
                    $('.scroll-to-top').fadeOut(duration);
                }
            });
        }
        
        $('.scroll-to-top').click(function(e) {
            e.preventDefault();
            $('html, body').animate({scrollTop: 0}, duration);
            return false;
        });
    };

    //* END:CORE HANDLERS *//

    return {

        //main function to initiate the theme
        init: function () {
            //IMPORTANT!!!: Do not modify the core handlers call order.

            //layout handlers            
            handleContentHeight(); // handles content height
            handleHeader(); // handles horizontal menu
            handleGoTop(); //handles scroll to top functionality in the footer
            handleMainMenu(); // handles menu toggle for mobile

            Metronic.addResizeHandler(handleMainMenuOnResize); // handle main menu on window resize
        },

        getLayoutImgPath: function() {
            return layoutImgPath;
        },

        getLayoutCssPath: function() {
            return layoutCssPath;
        }
    };

}();