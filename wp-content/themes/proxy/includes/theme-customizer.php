<?php

function stag_customize_register( $wp_customize ){

    $wp_customize->add_section('accent_control', array(
        'title' => __('Accent Color', 'stag'),
        // 'description' => __('', 'stag'),
        'priority' => 36,
    ));

    $wp_customize->add_setting( 'stag_framework_values[accent_color]' , array(
        'default' => '#1f2329',
        'type' => 'option'
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'stag_framework_values[accent_color]', array(
        'label' => __('Choose accent color', 'stag'),
        'section' => 'accent_control',
        'settings' => 'stag_framework_values[accent_color]',
    )));
}
add_action( 'customize_register', 'stag_customize_register' );

function proxy_customize_css()
{
    ?>
<style type="text/css" media="all">
.content-section .sub-title, 
#about .sub-title, 
#contact .sub-title, 
#team .sub-title, 
a, 
.hentry .pubdate, 
.stag-toggle .ui-state-active, 
.stag-tabs ul.stag-nav .ui-state-active a, 
.hentry .pubdate, 
.pinky_text_bold, 
#blog .entry-content a, 
#team .entry-content a, 
.team-widget .entry-content a, 
#about .entry-content a, 
.tag #blog .entry-content p a, 
.category #blog .entry-content p a, 
.homepage-sections #blog .entry-content p a, 
#team .member-description .member-title,
.team-widget .member-description .member-title,
#agenda_resumen .red_text
{ color: <?php echo stag_get_option('accent_color'); ?>; }

.button, 
button, 
input[type=submit], 
blockquote, 
#slideshow .slider-content h3, 
#primary-nav li.sfHover > a, 
#primary-nav li.current-menu-item > a, 
#primary-nav li.active > a, 
#team .member-pic .member-links a, 
.team-widget .member-pic .member-links a,
#portfolio-slider .portfolio-content .icon-open, 
.frame-categories a, 
.frame-tags a,
.boxed a
{ background-color: <?php echo stag_get_option('accent_color'); ?>; }

.button:hover, 
button:hover, 
input[type=submit]:hover, 
#primary-nav li a:hover, 
#mobile-primary-nav li a:hover, 
.frame-categories a:hover, 
.frame-tags a:hover 
{ background-color: <?php echo stag_get_option('accent_color'); ?>; } 

::selection 
{ background-color: <?php echo stag_get_option('accent_color'); ?>; }

</style>
    <?php
}
add_action( 'wp_head', 'proxy_customize_css');