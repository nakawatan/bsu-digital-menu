(function ($) {

    "use strict";

    var cfg = {
        scrollDuration: 800, // smoothscroll duration
    },

    $WIN = $(window);

    // Add the User Agent to the <html>
    // will be used for IE10 detection (Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0))
    var doc = document.documentElement;
    doc.setAttribute('data-useragent', navigator.userAgent);

    /* Preloader
    * -------------------------------------------------- */
    var zappPreloader = function () {

        $("html").addClass('cl-preload');

        $WIN.on('load', function () {

            //force page scroll position to top at page refresh
            // $('html, body').animate({ scrollTop: 0 }, 'normal');

            // will first fade out the loading animation 
            $("#loader").fadeOut("slow", function () {
                // will fade out the whole DIV that covers the website.
                $("#preloader").delay(300).fadeOut("slow");
            });

            // for hero content animations 
            $("html").removeClass('cl-preload');
            $("html").addClass('cl-loaded');

        });
    };

    /* Menu on Scrolldown
    * -------------------------------------------------- */
    var zappMenuOnScrolldown = function () {

        var menuTrigger = $('.header-menu-toggle');
        var barTrigger = $('.header-menu-bar');
        var homeTrigger = $('.header-home');

        $WIN.on('scroll', function () {

            if ($WIN.scrollTop() > 150) {
                menuTrigger.addClass('opaque');
                barTrigger.addClass('opaque');
                homeTrigger.addClass('opaque');
            }
            else {
                menuTrigger.removeClass('opaque');
                barTrigger.removeClass('opaque');
                homeTrigger.removeClass('opaque');
            }

        });
    };

    /* Smooth Scrolling
    * ------------------------------------------------------ */
    var zappSmoothScroll = function() {
        
        $('.smoothscroll').on('click', function (e) {
            var target = this.hash,
            $target    = $(target);
            
                e.preventDefault();
                e.stopPropagation();

            $('html, body').stop().animate({
                'scrollTop': $target.offset().top
            }, cfg.scrollDuration, 'swing').promise().done(function () {

                // check if menu is open
                if ($('body').hasClass('menu-is-open')) {
                    $('.header-menu-toggle').trigger('click');
                }

                window.location.hash = target;
            });
        });

    };

    /* Placeholder Plugin Settings
    * ------------------------------------------------------ */
    var zappPlaceholder = function () {
        $('input, textarea, select').placeholder();
    };

    /* Alert Boxes
     * ------------------------------------------------------ */
    var zappAlertBoxes = function () {

        $('.alert-box').on('click', '.alert-box__close', function () {
            $(this).parent().fadeOut(500);
        });

    };

    /* Slick Slider
    * ------------------------------------------------------ */
    var zappSlick = function() {

        $('.onboarding-slide--wrapper').slick({
            arrows: false,
            dots: true,
            infinite: false,
            draggable: false,
            swipe: false,
            slidesToShow: 1,
            slidesToScroll: 1
        });

        $('.featured-promo--slide').slick({
            arrows: false,
            dots: false,
            infinite: false,
            draggable: true,
            swipe: true,
            variableWidth: true,
            // adaptiveHeight: true,
            
        });
        
        $('.categories--slide').slick({
            arrows: false,
            dots: false,
            infinite: false,
            draggable: true,
            swipe: true,
            variableWidth: true,
            adaptiveHeight: true,
        });
        
        $('.modifier-group--items').slick({
            arrows: false,
            dots: false,
            infinite: false,
            draggable: true,
            swipe: true,
            variableWidth: true,
        });
    
    };

    var zappPreviousButton = function() {
        $('.previousButton').click(function(){
            window.history.go(-1); return false;
        });
    };


    (function zappInit() {
        zappPreloader();
        zappMenuOnScrolldown();
        zappSmoothScroll();
        zappPlaceholder();
        zappAlertBoxes();
        zappSlick();
        zappPreviousButton();
    })();

})(jQuery);