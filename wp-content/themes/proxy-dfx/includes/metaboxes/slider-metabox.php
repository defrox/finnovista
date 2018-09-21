<?php

add_action('add_meta_boxes', 'stag_metabox_slider');

function stag_metabox_slider(){
  $meta_box = array(
    'id' => 'stag_metabox_slider',
    'title' => __('Slider Settings', 'stag'),
    'description' => __('Customize the slider settings.', 'stag'),
    'page' => 'post',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
      array(
        'name' => __('Sub Title', 'stag'),
        'desc' => __('Enter the sub title for slider (optional).', 'stag'),
        'id' => '_stag_slide_subtitle',
        'type' => 'text',
        'std' => ''
        ),
      array(
        'name' => __('Slide URL', 'stag'),
        'desc' => __('Enter the URL for slide (optional).', 'stag'),
        'id' => '_stag_slide_url',
        'type' => 'text',
        'std' => ''
        ),
      array(
        'name' => __('Slide Image', 'stag'),
        'desc' => __('Upload the slider image', 'stag'),
        'id' => '_stag_slide_image',
        'type' => 'file',
        'std' => ''
        ),
      )
    );
    $meta_box['page'] = 'slides';
    stag_add_meta_box($meta_box);
}


function stag_slider_template($count = 5){
    $args = array(
        'post_type' => 'slides',
        'posts_per_pages' => $count,
    );

    $the_query = new WP_Query($args);

    if($the_query->have_posts()){
        ?>

        <div id="slideshow" class="clearfix">
            <div id="main-slider" class="flexslider">
                <ul class="slides">
                    <?php while($the_query->have_posts()): $the_query->the_post(); ?>
                    <li>
                        <div class="slider-content">
                            <div class="slider-content-inner">
<!--
                                <?php if(get_the_title() != ''): ?>
                                    <h2><?php echo get_the_title(); ?></h2>
                                 <?php endif; ?>
--> 
                                <div class="clear"></div>
                                <?php
                                /*
                                if(get_post_meta(get_the_ID(), '_stag_slide_url', true) == ""){
                                    echo '<h3>' . get_post_meta(get_the_ID(), '_stag_slide_subtitle', true) . '</h3>';
                                }elseif(get_post_meta(get_the_ID(), '_stag_slide_subtitle', true) != '' && get_post_meta(get_the_ID(), '_stag_slide_url', true) != ''){
                                    echo '<h3><a href="'.get_post_meta(get_the_ID(), '_stag_slide_url', true).'">'. get_post_meta(get_the_ID(), '_stag_slide_subtitle', true) .'</a></h3>';
                                }elseif(get_post_meta(get_the_ID(), '_stag_slide_subtitle', true) != ''){
                                    echo '<h3><a href="'.get_post_meta(get_the_ID(), '_stag_slide_url', true).'">'. get_post_meta(get_the_ID(), '_stag_slide_subtitle', true) .'</a></h3>';
                                }*/
                               ?>
                            </div>
                        </div>

                        <?php
                        if(get_post_meta(get_the_ID(), '_stag_slide_image', true) != ''){
                            echo '<img src="'. get_post_meta(get_the_ID(), '_stag_slide_image', true) .'" alt="">';
                        }
                         ?>
                    </li>
                    <?php endwhile; ?>
                </ul>
            </div>
        </div>

        <?php
        wp_reset_postdata();
    }
}

function stag_slider_shortcode(){
    ob_start();
    stag_slider_template();
    $slider = ob_get_clean();
    return $slider;
}
add_shortcode( 'stag_slider', 'stag_slider_shortcode' );
