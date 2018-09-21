<?php
/*
Template Name: Visa Everywhere Home
*/
$bgcolor = get_post_meta(get_the_ID(), 'visa_background_color', true);
$fontcolor = get_post_meta(get_the_ID(), 'visa_font_color', true);
?>
<?php get_header(); ?>
<script type="text/javascript">
/*    jQuery(document).ready(function ($) {
        jQuery('#logo img').each(function () {
            jQuery(this).attr("src", "/wp-content/uploads/2015/05/visa-everywhere-logo.png");
            //jQuery(this).css("margin-top", "10px");
            jQuery(this).parent().parent().find(".subtitle-text").css("display", "none");
        });
        jQuery('#logo a').each(function () {
            jQuery(this).attr("href", "/visa-everywhere");
        });
    });*/
</script>
<header id="subheader" class="clearfix">
    <style type="text/css"> .single-event #subheader .subheader-inner .event_menu a {
            color: <?= $fontcolor;?>;
        }

        #subheader .finnosummit-menu, #subheader .finnosummit-menu .sub-menu li a:hover, .finnosummit-menu li.sfHover > a, .finnosummit-menu li.current-menu-item > a, #mobile-finnosummit-menu ul, #mobile-finnosummit-nav-wrap {
            background-color: <?= $bgcolor;?>;
            color: <?= $fontcolor;?>;
        }

        #container .hfeed a {
            color: <?= $bgcolor;?> !important;
        }
    </style>
    <div class="subheader-inner">
        <div class="visa-everywhere-logo"><a href="visa-everywhere"><img width="270" src="/wp-content/uploads/2015/05/visa-everywhere-logo.png"/></a>
        </div>
    </div>
    <a id="finnosummit-mobile-nav" href="#mobile-finnosummit-menu"></a>

    <div class="finnosummit-menu clearfix"
         id="finnosummit-nav"><?php wp_nav_menu(array('theme_location' => 'visa-everywhere-menu')); ?></div>
    <div id="mobile-finnosummit-nav-wrap">
        <div id="mobile-finnosummit-menu"
             class="finnosummit-menu clearfix"><?php wp_nav_menu(array('theme_location' => 'visa-everywhere-menu', 'menu_class' => 'clearfix menu')); ?>
            <br clear="all"/></div>
    </div>
</header>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div id="visa-everywhere-banner">
        <div class="contenedor">
            <div class="textos" style="display: none;"><img width="400" src="/wp-content/uploads/2015/05/visa-everywhere-logo.png" class="banner-logo"/>Visa <br>Everywhere <br>Initiative <br>Latam
            </div>
            <div class="botones" style="display: none;">
                <?php
                $args = array(
                    'post_type' => 'event',
                    'meta_query' => array(
                        'relation' => 'OR',
                        array(
                            'key' => '_stag_event_date',
                            'value' => date('Y-m-d'),
                            'type' => 'DATE',
                            'compare' => '>=',
                        ),
                        array(
                            'key' => '_stag_show_past_event',
                            'value' => 'on',
                            'compare' => '=',
                        ),
                        /*array(
                            'key' => '_stag_event_date_text',
                            'compare' => 'EXISTS',
                        ),*/
                        array(
                            'key' => '_stag_event_date_text',
                            'compare' => '!=',
                            'value' => '',
                        ),
                    ),
                    'tax_query' => array(
                        'relation' => 'AND',
                        array(
                            'taxonomy' => 'event_type',
                            'terms' => '579',
                            'field' => 'term_id',
                        )
                    ),
                    'posts_per_page' => -1,
                    'orderby' => array( '_stag_event_date_text' => 'DESC', '_stag_event_date' => 'ASC' )
                );
                $the_query = new WP_Query($args);
                if ($the_query->have_posts()) {
                    while ($the_query->have_posts()): $the_query->the_post();
                        if(get_post_meta(get_the_ID(), '_stag_show_past_event', false)[0] == 'on') {
                            $boton = 'wp-content/uploads/2015/05/label-pastevent.png';
                            $boton_texto = __('Past Event', 'stag');
                        } elseif (get_post_meta(get_the_ID(), '_stag_event_register_enabled', false)[0] == 'on') {
                            $boton = 'wp-content/uploads/2015/05/label-register.png';
                            $boton_texto = __('Register', 'stag');
                        } else {
                            $boton = 'wp-content/uploads/2015/05/label-coming-soon.png';
                            $boton_texto = __('Coming Soon', 'stag');
                        }
                        ?>
                        <div class="boton">
                            <a href="<?php the_permalink(); ?>" data-postid="<?php the_ID(); ?>">
                                <?php 
                                    if(@get_post_meta(get_the_ID(), '_stag_event_poster', true)[0] != '')
                                        get_meta_image(get_post_meta(get_the_ID(), '_stag_event_poster',
                                    false)[0], 'poster', 'Visa Everywhere Initiative Latam ' . get_the_title(), '', '', true);
                                ?>
                                <div class="botoncito">
                                    <img src="<?php echo $boton; ?>" alt="<?php echo $boton_texto; ?>"/>
                                </div>
                            </a>
                        </div>
                    <?php
                    endwhile;
                }
                wp_reset_postdata();
                ?>
            </div>
        </div>
        <div id="slideshow">
            <?php if (has_post_thumbnail()) { // check if the post has a Post Thumbnail assigned to it.
                the_post_thumbnail(array(1350, 500), array('class' => 'slide'));
            }
            ?></div>
        <?php /* ?>
    <img src="http://www.finnovista.com/wp-content/uploads/2015/04/pitch-days-ALT.jpg" alt="Pitch Days" />
    <?php */ ?>
        <?php //echo do_shortcode( '[mega-slider id="2635"/]' ) ?>
    </div>
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
<?php get_footer('visa-everywhere') ?>
