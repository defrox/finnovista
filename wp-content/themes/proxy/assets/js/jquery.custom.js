jQuery(document).ready(function($){
    /*------------------------------------------------------------------------------*/
    /* Set cookie for retina displays; refresh if not set
    /*------------------------------------------------------------------------------*/

    (function(){
        "use strict";
        if( document.cookie.indexOf('retina') === -1 && 'devicePixelRatio' in window && window.devicePixelRatio === 2 ){
            document.cookie = 'retina=' + window.devicePixelRatio + ';';
            window.location.reload();
        }
    })();

    /*------------------------------------------------------------------------------*/
    /* Mobile Navigation Setup
    /*------------------------------------------------------------------------------*/
    var mobileNav = $('#primary-nav').clone().attr('id', 'mobile-primary-nav');
    var mobileNav1 = $('#finnosummit-nav').clone().attr('id', 'mobile-finnosummit-menu');
    var mobileNav2 = $('#visa-everywhere-nav').clone().attr('id', 'mobile-visa-everywhere-menu');

    $('#primary-nav ul, #finnosummit-nav > div ul, #visa-everywhere-nav > div ul').supersubs({
        minWidth: 10,
        maxWidth: 27,
        extraWidth: 1
    }).superfish({
        delay: 100,
        animation: {opacity:'show', height:'show'},
        speed: 'fast',
        autoArrows: false,
        dropShadows: false
    });

    function stag_mobilemenu(){
        "use strict";
        var windowWidth = $(window).width();
        if( windowWidth <= 992 ) {
            if( !$('#mobile-nav').length ) {
                $('<a id="mobile-nav" href="#mobile-primary-nav" />').prependTo('#navigation');
                mobileNav.insertAfter('#mobile-nav').wrap('<div id="mobile-primary-nav-wrap" />');
                mobile_responder();
            }
            if( !$('#finnosummit-mobile-nav').length && $('#finnosummit-nav').length ) {
                $('<a id="finnosummit-mobile-nav" href="#mobile-finnosummit-menu" />').prependTo('#navigation');
                mobileNav.insertAfter('#finnosummit-mobile-nav').wrap('<div id="mobile-finnosummit-nav-wrap" />');
                mobile_responder();
            }
            if( !$('#visa-everywhere-mobile-nav').length && $('#visa-everywhere-nav').length ) {
                $('<a id="visa-everywhere-mobile-nav" href="#mobile-visa-everywhere-menu" />').prependTo('#navigation');
                mobileNav.insertAfter('#visa-everywhere-mobile-nav').wrap('<div id="mobile-visa-everywhere-nav-wrap" />');
                mobile_responder();
            }
        }else{
            mobileNav.css('display', 'none');
            mobileNav1.css('display', 'none');
            mobileNav2.css('display', 'none');
        }
    }
    stag_mobilemenu();

    function mobile_responder(){
        $('#mobile-nav').click(function(e) {
            if( $('body').hasClass('ie8') ) {
                var mobileMenu = $('#mobile-primary-nav');
                if( mobileMenu.css('display') === 'block' ) {
                    mobileMenu.css({
                        'display' : 'none'
                    });
                } else {
                    mobileMenu.css({
                        'display' : 'block',
                        'height' : 'auto',
                        'z-index' : 999,
                        'position' : 'absolute'
                    });
                }
            } else {
                $('#mobile-primary-nav').stop().slideToggle(500);
            }
            e.preventDefault();
        });
        $('#finnosummit-mobile-nav').click(function(e) {
            if( $('body').hasClass('ie8') ) {
                var mobileMenu2 = $('#mobile-finnosummit-menu');
                if( mobileMenu2.css('display') === 'block' ) {
                    mobileMenu2.css({
                        'display' : 'none'
                    });
                } else {
                    mobileMenu2.css({
                        'display' : 'block',
                        'height' : 'auto',
                        'z-index' : 999,
                        'position' : 'absolute'
                    });
                }
            } else {
                $('#mobile-finnosummit-menu').stop().slideToggle(500);
            }
            e.preventDefault();
        });
        $('#visa-everywhere-mobile-nav').click(function(e) {
            if( $('body').hasClass('ie8') ) {
                var mobileMenu3 = $('#mobile-visa-everywhere-menu');
                if( mobileMenu3.css('display') === 'block' ) {
                    mobileMenu3.css({
                        'display' : 'none'
                    });
                } else {
                    mobileMenu3.css({
                        'display' : 'block',
                        'height' : 'auto',
                        'z-index' : 999,
                        'position' : 'absolute'
                    });
                }
            } else {
                $('#mobile-visa-everywhere-menu').stop().slideToggle(500);
            }
            e.preventDefault();
        });
    }

    $(window).resize(function() {
        stag_mobilemenu();
        imageScreeResizer();
    });

    /*------------------------------------------------------------------------------*/
    /* Better fallback for input[placeholder]
    /*------------------------------------------------------------------------------*/
    if (! ("placeholder" in document.createElement("input"))) {
        $('*[placeholder]').each(function() {
            var that = $(this);
            var placeholder = $(this).attr('placeholder');
            if ($(this).val() === '') {
                that.val(placeholder);
            }
            that.bind('focus',
            function() {
                if ($(this).val() === placeholder) {
                    this.plchldr = placeholder;
                    $(this).val('');
                }
            });
            that.bind('blur',
            function() {
                if ($(this).val() === '' && $(this).val() !== this.plchldr) {
                    $(this).val(this.plchldr);
                }
            });
        });
        $('form').bind('submit',
        function() {
            $(this).find('*[placeholder]').each(function() {
                if ($(this).val() === $(this).attr('placeholder')) {
                    $(this).val('');
                }
            });
        });
    }


    /*------------------------------------------------------------------------------*/
    /* Animated back to top navigation
    /*------------------------------------------------------------------------------*/

    $("#backToTop").click(function(e){
        $('body,html').animate({ scrollTop: "0" });
        e.preventDefault();
    });

    $("#navigation a").on('click', function(e){
        var re=/^#/g;
        if(re.test($(this).attr('href')) === true){
            e.preventDefault();
            var h = $(this).attr('href').replace('#', '');
            window.location.hash = "section="+h;
        }

    });

    var goToSection = function(location) {
        var destination = $(location).offset().top;
        if(window.innerWidth > 1024){
            $("html:not(:animated),body:not(:animated)").animate({ scrollTop: destination - $("#header").outerHeight() }, 1200 );
        }else{
            $("html:not(:animated),body:not(:animated)").animate({ scrollTop: destination }, 1200 );
        }
        return false;
    };

    $(window).bind('hashchange', function(){
        if(location.hash.search(/section/i) === 1){
            var h = location.hash.split("=").pop();
            goToSection("#"+h);
        }

        if(location.hash.search(/post/i) === 1){
            var hash = location.hash.split("=").pop();
            $("body").addClass('gateway-open');
            $("#gateway").load(url, {
                id: hash
            }, function(){
                closeGateway();
                nextPrevNav();
                wp_comment();
            });
            gatewayWrap.show();
        }
        return false;
    });

    /*------------------------------------------------------------------------------*/
    /* Screen Width Image Resizer
     /*------------------------------------------------------------------------------*/

    function imageScreeResizer() {
        var screenWidth = $(window).width();
        $('img.screen-width').each(function () {
            var imgHeight = $(this).height();
            var imgWidth = $(this).width();
            var newHeight = (screenWidth * imgHeight) / imgWidth;
            $(this).width(screenWidth).height(newHeight).css('max-width','none').css('margin-left','-70px').css('margin-bottom','-30px');
        });
    }
    imageScreeResizer();

    /*------------------------------------------------------------------------------*/
    /* Change menu active when scroll through sections
    /*------------------------------------------------------------------------------*/

    var $navi = $("#header"), $subnavi = $("#subheader"), scrollTop = 0;
    $(window).scroll(function () {

        var $inview = $('.homepage-sections > section:in-viewport:first').attr('id');
        var $menu_item = $('#navigation li a');
        if ($inview != 'undefined') {
            var $link = $menu_item.filter('[href$=#' + $inview + ']');
            //console.log($link.attr('href'));
            if ($link.length && !$link.is('.active')) {
                $menu_item.parent().removeClass('active');
                $link.parent().addClass('active');
            }
        }

        var $inview2 = $('.widgets_on_page > section:in-viewport:first').attr('id');
        var $menu_item2 = $('#finnosummit-nav li a');
        if ($inview2 != 'undefined') {
            var $link2 = $menu_item2.filter('[href$=#' + $inview2 + ']');
            //console.log($link2.attr('href'));
            if ($link2.length && !$link2.is('.sfHover')) {
                $menu_item2.parent().removeClass('sfHover');
                $link2.parent().addClass('sfHover');
            }
        }

        var $inview3 = $('.widgets_on_page > section:in-viewport:first').attr('id');
        var $menu_item3 = $('#visa-everywhere-nav li a');
        if ($inview3 != 'undefined') {
            var $link3 = $menu_item3.filter('[href$=#' + $inview3 + ']');
            //console.log($link3.attr('href'));
            if ($link3.length && !$link2.is('.sfHover')) {
                $menu_item3.parent().removeClass('sfHover');
                $link3.parent().addClass('sfHover');
            }
        }

        if ( $( window ).width() > 992) {
            var offset = $navi.offset(), top = offset.top, bottom = $(window).height() - top - $navi.outerHeight();
            var y = $(this).scrollTop(), speed = 0.05, pos = y * speed, maxPos = 100, subpos = $navi.height(), maxSPpos = 100;
            if (y > scrollTop) {
                pos = maxPos;
            } else {
                pos = 0;
            }
            if (y > scrollTop) {
                subpos = 0;
                if (y <= maxSPpos) {
                    $subnavi.css({"top":"0", "position": "fixed"});
                }
            } else {
                subpos = maxSPpos;
            }
            scrollTop = y;
            $navi.css({
                "-webkit-transform": "translateY(-" + pos + "%)",
                "-moz-transform": "translateY(-" + pos + "%)",
                "-o-transform": "translateY(-" + pos + "%)",
                "transform": "translateY(-" + pos + "%)"
            });
            $subnavi.css({
                "-webkit-transform": "translateY(" + subpos + "px)",
                "-moz-transform": "translateY(" + subpos + "px)",
                "-o-transform": "translateY(" + subpos + "px)",
                "transform": "translateY(" + subpos + "px)"
            });
        }
    });

    $subnavi.fixTo('body', {
        //className : 'my-class-name',
        zIndex: 10,
        //mind: '#header',
        top: 0,
        useNativeSticky: false,
        //mindBottomPadding: true
    });



    /*------------------------------------------------------------------------------*/
    /* Modal (Gateway) boxes setup
    /*------------------------------------------------------------------------------*/

    var gateway = $("#gateway"),
        gatewayWrap = $("#gateway-wrapper"),
        url = gateway.data('gateway-path');

    gatewayWrap.hide();

    if(location.hash.search(/post/i) === 1){
        var hash = location.hash.split("=").pop();
        $("body").addClass('gateway-open');
        $("#gateway").html('<h1 class="incoming-gateway">Loading...</h1>');
        $("#gateway").load(url, {
            id: hash
        }, function(){
            closeGateway();
            nextPrevNav();
            wp_comment();
        });
        gatewayWrap.show();
    }


    /* OPEN GATEWAY */
    $("a[data-through=gateway]").click(function(e){
        e.preventDefault();
        var thus = $(this);
        $("body").addClass('gateway-open');
        var postid = $(this).data('postid');

        $("#gateway").load(url, {
            id: postid
        }, function(){
            closeGateway();
            nextPrevNav();
            wp_comment();
        });
        $(".stag-tabs").hide();
        location.hash = "post="+thus.data('postid');
        gatewayWrap.fadeIn(200);
    });

    function nextPrevNav(){
        $("#gateway .next, #gateway .prev").on('click', function(e){
            e.preventDefault();
            var pid = $(this).data('postid');
            location.hash= '#post='+$(this).data('postid');
            $("#gateway").html('<h1 class="incoming-gateway">Loading...</h1>');
            $("#gateway .hfeed").fadeOut(200);
            $("#gateway").fadeIn(200).load(url, {
                id: pid
            }, function(){
                closeGateway();
                nextPrevNav();
                wp_comment();
            });
        });

        // To prevent any linked post from keeping the old scroll position.
        goToSection("#gateway-wrapper");

        /* Include Shortcode stuffs here... */
        $(".stag-tabs").tabs();
        $(".stag-toggle").each( function () {
          if($(this).attr('data-id') === 'closed') {
            $(this).accordion({ header: '.stag-toggle-title', collapsible: true, active: false  });
          } else {
            $(this).accordion({ header: '.stag-toggle-title', collapsible: true});
          }
        });

        prettyPrint();

        $("#gateway-wrapper").fitVids();

        // Portfolio Single Page Slider
        jQuery('#portfolio-single-slider').flexslider({
            directionNav: false,
            controlNav: true,
            multipleKeyboard: true
        });
    }

    function closeGateway(){
        $(".close-gateway").on('click', function(e){
            e.preventDefault();
            $("body").removeClass("gateway-open");
            location.hash = '';
            // Remove content to avoid conflicts
            gateway.html('');
            gatewayWrap.fadeOut(200);
        });
    }


    /*------------------------------------------------------------------------------*/
    /* Modal (Gateway) boxes comment setup
    /*------------------------------------------------------------------------------*/
    function wp_comment(){
        var commentform=$('#commentform'); // find the comment form
        commentform.prepend('<div id="comment-status" ></div>'); // add info panel before the form to provide feedback or errors
        var statusdiv=$('#comment-status'); // define the infopanel

        commentform.submit(function(){
        //serialize and store form data in a variable
        var formdata=commentform.serialize();
        //Add a status message
        statusdiv.html('<p>Processing...</p>');
        //Extract action URL from commentform
        var formurl=commentform.attr('action');
        //Post Form with data
        $.ajax({
            type: 'post',
            url: formurl,
            data: formdata,
            error: function(){
            statusdiv.html('<p class="wdpajax-error" >You might have left one of the fields blank, or be posting too quickly</p>');
            },
            success: function(data){
                if(data==="success"){
                    statusdiv.html('<p class="ajax-success" >Thanks for your comment. We appreciate your response.</p>');
                    window.location.reload();
                }else{
                    statusdiv.html('<p class="ajax-error" >Please wait a while before posting your next comment</p>');
                    commentform.find('textarea[name=comment]').val('');
                }
            }
        });
        return false;
        });

        // Do it, so it doesn't mess with other stuffs.
        $("a[href='#']").on('click', function(e){
            e.preventDefault();
        });

        var rofst = $("#respond").offset().top;
        $("a[href='#respond']").on('click', function(e){
            e.preventDefault();
            $("#gateway-wrapper").animate({scrollTop: rofst});
        });


        var commentText;
        var commentList;
        var respondBox;

        $('.comment-reply-link').removeAttr("onclick");

        $('.comment-reply-link').each(function(){
            var href = $(this).attr('href');
            href = href.split("?").pop().replace('#respond', '')+location.hash;
            href = location.pathname+"?"+href;
            $(this).attr('href', href);
        });


        $('.comment-reply-link').click(function() {

            commentText     = $(this).next().next().next('.comment-text');
            commentList     = $(this).closest('.commentlist');
            respondBox      = commentList.parent().parent().next();

            commentText.after( respondBox );

            var comment_href = $(this).attr('href');
            var comment_parent_id = getURLParameter(comment_href, "replytocom").split("#")[0];

            $('#comment_parent').val( comment_parent_id );

            return false;
        });

        function getURLParameter(url, name) {
            return decodeURIComponent(
                (url.match(RegExp("[?&]"+name+"=([^&]*)"))||[null])[1]
            );
        }

    };

    function setupScroll() {
        $(document).scroll(function() {
            var b = $(this).scrollTop();
            b > 50 ? $("#subheader").addClass("scrolled") : $("#subheader").removeClass("scrolled");
            b > 50 ? $('#backToTop').css('opacity', '0.3') : $('#backToTop').css('opacity', '0');
            $('.admin-bar #subheader .subheader-inner').css('margin-top', '32px');
        })

        //console.log($(document).scrollTop());
    }

    $(window).scroll(function(){
        setupScroll();
    })
    $(document).scrollTop() > 50 && $("#subheader").addClass("scrolled");
    $(document).scrollTop() > 50 && $('.admin-bar #subheader .subheader-inner').css('margin-top', '32px');
    $(document).scrollTop() < 50 && $('#backToTop').css('opacity', '0');
    setupScroll();

    $(".post-18328 .logo .logos_description").equalHeights();
    $(".post-18294 .logo .logos_description").equalHeights();
    $(window).resize(function() {
	    $(".post-18328 .logo .logos_description").equalHeights();
	    $(".post-18294 .logo .logos_description").equalHeights();
	});

    /* Filters by tag */
    $(".btn-tag").click(function(eventObject) {
        var tag = $(this).text().trim();
        eventObject.preventDefault();
        if (tag == "All" ) {
            $(".agenda-item").fadeIn();
        } else {
            $(".agenda-item").each(function (index) {
                var flaggy = false;
                $(this).find(".tag").each(function (indx) {
                    if ($(this).text().trim() == tag) {
                        flaggy = true;
                    }
                });
                if (flaggy) {
                    $(this).closest(".agenda-item").hide();
                    $(this).closest(".agenda-item").fadeIn();
                } else {
                    $(this).closest(".agenda-item").hide();
                }
            });
        }
    });
});


/*------------------------------------------------------------------------------*/
/* The Awesome FlexSlider
/*------------------------------------------------------------------------------*/
jQuery(window).load(function(){

    jQuery("#container").css('padding-top', jQuery("#header").outerHeight());

    jQuery('#main-slider').flexslider({
        directionNav: false,
        controlNav: true,
        multipleKeyboard: false,
        animation: "fade"
    });

    jQuery('#blog-post-slider').flexslider({
        directionNav: true,
        controlNav: false,
        multipleKeyboard: false,
        animation: "slide",
        animationLoop: false,
        slideshow: false
    });
        // Event Single Page Slider
        jQuery('#event-single-slider').flexslider({
            directionNav: false,
            controlNav: true,
            multipleKeyboard: true
        });

});

/**
 * Equal Heights Plugin
 * Equalize the heights of elements. Great for columns or any elements
 * that need to be the same size (floats, etc).
 * 
 * Version 1.0
 * Updated 12/10/2008
 *
 * Copyright (c) 2008 Rob Glazebrook (cssnewbie.com) 
 *
 * Usage: $(object).equalHeights([minHeight], [maxHeight]);
 * 
 * Example 1: $(".cols").equalHeights(); Sets all columns to the same height.
 * Example 2: $(".cols").equalHeights(400); Sets all cols to at least 400px tall.
 * Example 3: $(".cols").equalHeights(100,300); Cols are at least 100 but no more
 * than 300 pixels tall. Elements with too much content will gain a scrollbar.
 * 
 */

(function($) {
  $.fn.equalHeights = function(minHeight, maxHeight) {
    tallest = (minHeight) ? minHeight : 0;
    this.each(function() {
      if($(this).height() > tallest) {
        tallest = $(this).height();
      }
    });
    if((maxHeight) && tallest > maxHeight) tallest = maxHeight;
    return this.each(function() {
      $(this).height(tallest).css("overflow","hidden");
    });
  }
})(jQuery);
