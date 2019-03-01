<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php
    $skills = $event_type_terms = get_the_terms(get_the_ID(), 'event_type');
    if ($skills) {
        $skill = $event_type = '';
        foreach ($skills as $ski) {
            $skill[] .= $ski->name;
            $event_type_obj = $ski;
        }
        $skills = implode(', ', $skill);
    }
    $finnosummit = $visaeil = false;
    $categories = get_the_terms(get_the_ID(), 'event_type');
    $event_type = 'finnovista';
    $event_type_name = 'Finnovista';
    $dfx_menu = 'event-menu';

    foreach ((array)$categories as $key => $value) {
        if (intval($categories[$key]->term_id) == 96 || intval($categories[$key]->term_id) == 180) { // Finnosummit event
            $event_type = 'finnosummit';
            $event_type_name = 'Finnosummit';
            $dfx_menu = 'finnosummit-event-menu';
        }
        if (intval($categories[$key]->term_id) == 580 || intval($categories[$key]->term_id) == 579) { // Visa Everywhere event
            $event_type = 'visa-everywhere';
            $event_type_name = 'Visa Everywhere';
            $dfx_menu = 'visa-event-menu';
        }
    }

    $bgcolor = get_post_meta(get_the_ID(), '_stag_event_color', true);
    $logo = get_post_meta(get_the_ID(), '_stag_event_logo', true);
    $logo = '/wp-content/uploads/2015/05/' . $event_type . '-logo.png';
    $fontcolor = get_post_meta(get_the_ID(), '_stag_event_font_color', true);
    $event_date = get_post_meta(get_the_ID(), '_stag_event_date', true);
    $event_register = get_post_meta(get_the_ID(), '_stag_event_register_enabled', true);
    $event_date = $event_date ? date('d M Y', strtotime($event_date)) : '';
    $event_date_text = get_post_meta(get_the_ID(), '_stag_event_date_text', false);
    @$event_date_text = $event_date_text[0] && $event_date_text[0] != '' ? $event_date_text[0] : $event_date;
    if ($logo): ?>
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                jQuery('#logo img').each(function () {
                    jQuery(this).attr("src", "<?php print $logo; ?>");
                    //jQuery(this).css("margin-top", "10px");
                    jQuery(this).parent().parent().find(".subtitle-text").css("display", "none");
                });
                jQuery('#logo a').each(function () {
                    jQuery(this).attr("href", "/<?= $event_type ?>");
                });
            });
        </script>
    <?php endif; ?>
    <header id="subheader">
        <style type="text/css"> .single-event #subheader .subheader-inner .event_menu a {
                color: <?= $fontcolor;?>;
            }
            #subheader .finnosummit-menu, #subheader .finnosummit-menu .sub-menu li a:hover, .finnosummit-menu li.sfHover > a, .finnosummit-menu li.current-menu-item > a, #mobile-finnosummit-menu ul, #mobile-finnosummit-nav-wrap {
                background-color: <?= $bgcolor;?>;
                color: <?= $fontcolor;?>;
            }
            .bootstrap-agenda .btn-primary.disabled, .bootstrap-agenda .btn-tag,
            .daily-agenda .btn-primary.disabled, .daily-agenda .btn-tag {
                background-color: <?= $bgcolor;?> !important;
                border-color: <?= $bgcolor;?> !important;
                color: <?= $fontcolor;?> !important;
            }
            #container .hfeed a {color: <?= $bgcolor;?> !important;}
            #agenda_resumen .box a{color: #8D8F92 !important;}
            #agenda_resumen .box.clarita a{color: #fff !important;}</style>
        <div class="subheader-inner">
            <div class="finnosummit-logo"><a href="<?= $event_type ?>"><img width="250" alt="<?= $event_type_name ?>" src="/wp-content/uploads/2015/05/<?= $event_type ?>-logo.png"/></a>
            </div>
            <!--<div class="event_title">--><!--<?= $skills; ?> / -->
            <!--<?php the_title(); ?> / <?= $event_date; ?></div>--></div>
        <div class="event_title"><!--<?= $skills; ?> / --><?php the_title(); ?> <?= trim($event_date_text) != '' ? '/' : ''; ?> <?= $event_date_text; ?></div>
        <a id="finnosummit-mobile-nav" href="#mobile-finnosummit-menu"></a>

        <div id="mobile-finnosummit-nav-wrap">
            <div id="mobile-finnosummit-menu" class="finnosummit-menu">
                <?php wp_nav_menu(array('theme_location' => $dfx_menu, 'menu_class' => 'clearfix menu')); ?>
            </div>
        </div>
        <div class="finnosummit-menu" id="finnosummit-nav">
            <?php wp_nav_menu(array('theme_location' => $dfx_menu)); ?>
        </div>
    </header>
    <div class='hfeed'>
        <div id="event-single-slider" class="flexslider">
            <ul class="slides">
                <?php
                $sl1 = get_post_meta(get_the_ID(), '_stag_event_image_1', true);
                $sl2 = get_post_meta(get_the_ID(), '_stag_event_image_2', true);
                $sl3 = get_post_meta(get_the_ID(), '_stag_event_image_3', true);
                $sl4 = get_post_meta(get_the_ID(), '_stag_event_image_4', true);
                $sl5 = get_post_meta(get_the_ID(), '_stag_event_image_5', true);
                $images = array($sl1, $sl2, $sl3, $sl4, $sl5);

                foreach ($images as $img) {
                    if ($img != '') {
                        echo '<li><img src="' . $img . '" alt=""></li>';
                    }
                }
                ?>
            </ul>
        </div>
        <a id="que-es"></a>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="entry-content clearfix">
                <?php the_content(); ?>
            </div>
        </article>
    </div>
<?php endwhile; ?>
<?php endif; ?>
    <script>
        jQuery(document).ready(function () {
            <?php if ($event_register != 'on') : ?>
            jQuery( "a[href='http://dfxlink/#register']" ).each(function(){
                jQuery(this).attr('href', function(i, val) {   return jQuery(this).attr('href').replace('register',
                    'contact'); });
            });
            <?php endif; ?>

            jQuery( "a[href*='http://dfxlink/']" ).each(function(){
                jQuery(this).attr('href', function(i, val) {   return jQuery(this).attr('href').replace('http://dfxlink/', '<?php the_permalink() ?>'); });
            });

        });
    </script>
<?php get_footer($event_type); ?>