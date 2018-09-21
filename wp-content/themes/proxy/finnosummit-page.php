<?php
/*
Template Name: FINNOSUMMIT Page
*/
$event_id = get_post_meta(get_the_ID(), '_stag_linked_event', true);
$event_register = get_post_meta($event_id, '_stag_event_register_enabled', true);
$bgcolor = get_post_meta($event_id, '_stag_event_color', true);
$fontcolor = get_post_meta($event_id, '_stag_event_font_color', true);
$event_date = get_post_meta($event_id, '_stag_event_date', false);
$event_date_text = get_post_meta($event_id, '_stag_event_date_text', false);
@$event_date = $event_date[0] && $event_date[0] != '' ? date('d M Y', strtotime($event_date[0])) : '';
@$event_date_text = $event_date_text[0] && $event_date_text[0] != '' ? $event_date_text[0] : $event_date;
?>
<?php get_header(); ?>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        jQuery('#logo img').each(function () {
            jQuery(this).attr("src", "/wp-content/uploads/2015/05/finnosummit-logo.png");
            //jQuery(this).css("margin-top", "10px");
            jQuery(this).parent().parent().find(".subtitle-text").css("display", "none");
        });
        jQuery('#logo a').each(function () {
            jQuery(this).attr("href", "/finnosummit");
        });
    });
</script>
<header id="subheader" class="clearfix">
    <style type="text/css"> .single-event #subheader .subheader-inner .event_menu a {
            color: <?= $fontcolor;?>;
        }
        #subheader .finnosummit-menu, #subheader .finnosummit-menu .sub-menu li a:hover, .finnosummit-menu li.sfHover > a, .finnosummit-menu li.current-menu-item > a, #mobile-finnosummit-menu ul, #mobile-finnosummit-nav-wrap {
            background-color: <?= $bgcolor;?>;
            color: <?= $fontcolor;?>;
        }
        .bootstrap-agenda .btn-primary.disabled, .bootstrap-agenda .btn-tag {
            background-color: <?= $bgcolor;?> !important;
            border-color: <?= $bgcolor;?> !important;
            color: <?= $fontcolor;?> !important;
        }
        #container .hfeed a {color: <?= $bgcolor;?> !important;}
        #agenda_resumen .box a{color: #8D8F92 !important;}
        #agenda_resumen .box.clarita a{color: #fff !important;}</style>
    <div class="subheader-inner">
        <div class="finnosummit-logo"><a href="finnosummit"><img width="270" src="/wp-content/uploads/2015/05/finnosummit-logo.png"/></a>
        </div>
    </div>
    <div class="event_title"><?php echo get_the_title( $event_id ); ?> / <?= $event_date_text; ?></div>
    <a id="finnosummit-mobile-nav" href="#mobile-finnosummit-menu"></a>
    <div class="finnosummit-menu clearfix"
         id="finnosummit-nav"><?php
        $dfx_menu = $event_id != '' ? 'event-menu' : 'finnosummit-menu';
        wp_nav_menu(array('theme_location' => $dfx_menu)); ?></div>
    <div id="mobile-finnosummit-nav-wrap">
        <div id="mobile-finnosummit-menu" class="finnosummit-menu clearfix"><?php wp_nav_menu(array('theme_location' => $dfx_menu, 'menu_class' => 'clearfix menu')); ?>
            <br clear="all"/></div>
    </div>
</header>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class='hfeed'>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <p class="pubdate"></p>

            <h2 class="entry-title" style="display:none;"><?php the_title(); ?></h2>

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
            jQuery(this).attr('href', function(i, val) {   return jQuery(this).attr('href').replace('http://dfxlink/', '<?php echo post_permalink( $event_id ); ?>'); });
        });

    });
</script>
<?php get_footer('finnosummit') ?>
