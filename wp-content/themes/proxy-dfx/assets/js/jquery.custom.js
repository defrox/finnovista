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

    $('#primary-nav ul').supersubs({
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
        }else{
            mobileNav.css('display', 'none');
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
    }

    $(window).resize(function() {
        stag_mobilemenu();
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
    /* Change menu active when scroll through sections
    /*------------------------------------------------------------------------------*/

    $(window).scroll(function () {
        var $inview = $('.homepage-sections > section:in-viewport:first').attr('id');
        var $menu_item = $('#navigation li a');
        var $link = $menu_item.filter('[href=#' + $inview + ']');

        if ($link.length && !$link.is('.active')) {
            $menu_item.parent().removeClass('active');
            $link.parent().addClass('active');
        }
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

    }

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

});
