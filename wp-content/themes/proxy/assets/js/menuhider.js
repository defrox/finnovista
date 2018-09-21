jQuery(document).ready(function() {
// Hide Header on on scroll down
    var didScroll;
    var lastScrollTop = 0;
    var delta = 5;
    var navbarHeight = $('headerasdf').outerHeight();

    $(window).scroll(function (event) {
        didScroll = true;
    });

    setInterval(function () {
        if (didScroll) {
            hasScrolled();
            didScroll = false;
        }
    }, 250);

    function hasScrolled() {
        var st = $(this).scrollTop();

        // Make sure they scroll more than delta
        if (Math.abs(lastScrollTop - st) <= delta)
            return;

        // If they scrolled down and are past the navbar, add class .nav-up.
        // This is necessary so you never see what is "behind" the navbar.
        if (st > lastScrollTop && st > navbarHeight) {
            // Scroll Down
            $('header').removeClass('nav-down').addClass('nav-up');
        } else {
            // Scroll Up
            if (st + $(window).height() < $(document).height()) {
                $('header').removeClass('nav-up').addClass('nav-down');
            }
        }

        lastScrollTop = st;
    }
});

jQuery(document).ready(function () {
    var $navi = $("#header"), scrollTop = 0;
    (window).scroll(function () {
        var y = $(this).scrollTop(), speed = 0.05, pos = y * speed, maxPos = 100;
        if (y > scrollTop) {
            pos = maxPos;
        } else {
            pos = 0;
        }
        scrollTop = y;
        $navi.css({
            "-webkit-transform": "translateY(-" + pos + "%)",
            "-moz-transform": "translateY(-" + pos + "%)",
            "-o-transform": "translateY(-" + pos + "%)",
            "transform": "translateY(-" + pos + "%)"
        });
    });
});