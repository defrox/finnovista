<?php
/*
Template Name: Challenges Page
*/
$logo = get_post_meta(get_the_ID(), '_stag_challenges_logo', true);
$bgcolor = get_post_meta(get_the_ID(), '_stag_challenges_background_color', true);
$fontcolor = get_post_meta(get_the_ID(), '_stag_challenges_font_color', true) ?: '#ffffff';
$banner_link = get_post_meta(get_the_ID(), '_stag_challenges_banner_link', true);
$ticket = get_post_meta(get_the_ID(), '_stag_challenges_ticket', true);
?>
<?php get_header(); ?>
<?php if ($logo): ?>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            jQuery('#logo img').each(function () {
                jQuery(this).attr("src", "<?php print $logo; ?>");
                //jQuery(this).css("margin-top", "10px");
                jQuery(this).parent().parent().find(".subtitle-text").css("display", "none");
            });
            //jQuery('#logo a').each(function () {
            //    jQuery(this).attr("href", "/<?//= $event_type ?>//");
            //});
        });
    </script>
<?php endif; ?>
<header id="subheader" class="clearfix">
    <style type="text/css"> .single-event #subheader .subheader-inner .event_menu a {
            color: <?= $fontcolor;?>;
        }
        #subheader .finnosummit-menu, #subheader .finnosummit-menu .sub-menu li a:hover, .finnosummit-menu li.sfHover > a, .finnosummit-menu li.current-menu-item > a, #mobile-finnosummit-menu ul, #mobile-finnosummit-nav-wrap {
            background-color: <?= $bgcolor;?>;
            color: <?= $fontcolor;?>;
        }
        #container .hfeed a {color: <?= $bgcolor;?> !important;}
        #agenda_resumen .box a{color: #8D8F92 !important;}
        #agenda_resumen .box.clarita a{color: #fff !important;}</style>
    <div class="subheader-inner">
        <div class="finnosummit-logo"><a href="finnosummit"><img width="270" src="/wp-content/uploads/2015/05/finnosummit-logo.png"/></a>
        </div>
    </div>
    <div class="event_title"><?php /*echo get_the_title( $event_id ); ?> / <?= $event_date_text;*/ ?></div>
    <a id="finnosummit-mobile-nav" href="#mobile-finnosummit-menu"></a>
    <div class="finnosummit-menu clearfix" id="finnosummit-nav"><?php
        $dfx_menu = 'challenges-menu';
        wp_nav_menu(array('theme_location' => $dfx_menu)); ?></div>
    <div id="mobile-finnosummit-nav-wrap">
        <div id="mobile-finnosummit-menu" class="finnosummit-menu clearfix"><?php wp_nav_menu(array('theme_location' => $dfx_menu, 'menu_class' => 'clearfix menu')); ?>
            <br clear="all"/></div>
    </div>
</header>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <div id="slideshow">
            <?php if ($banner_link != '') : ?>
                <a href="<?php print $banner_link; ?>">
            <?php endif;?>
            <?php if (has_post_thumbnail()) { // check if the post has a Post Thumbnail assigned to it.
                the_post_thumbnail(array(1350, 500), array('class' => 'slide'));
            }
            ?>
            <?php if ($banner_link != '') : ?>
                </a>
            <?php endif;?>            
        </div>
    <div class='hfeed'>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <p class="pubdate"></p>

            <h2 class="entry-title" style="display:none;"><?php the_title(); ?></h2>

            <div class="entry-content clearfix">
                <?php the_content();?>
            </div>
        </article>
    </div>
<?php endwhile; ?>
<?php endif; ?>
<?php get_footer('finnosummit'); ?>