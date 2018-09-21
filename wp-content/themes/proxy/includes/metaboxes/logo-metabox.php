<?php

add_action('add_meta_boxes', 'stag_metabox_logos');

function stag_metabox_logos()
{
    $city_taxonomies = array(
        'event_city',
    );

    $city_terms = get_terms($city_taxonomies, 'hide_empty=0');
    //$city_options = array('' => __('None', 'stag'));
    foreach ($city_terms as $key => $value) {
        $city_options[$value->slug] = $value->name;
    }

    $pdcity_taxonomies = array(
        'event_pdcity',
    );

    $pdcity_terms = get_terms($pdcity_taxonomies, 'hide_empty=0');
    //$pdcity_options = array('' => __('None', 'stag'));
    foreach ($pdcity_terms as $key => $value) {
        $pdcity_options[$value->slug] = $value->name;
    }

    $visacity_taxonomies = array(
        'event_visacity',
    );

    $visacity_terms = get_terms($visacity_taxonomies, 'hide_empty=0');
    //$visacity_options = array('' => __('None', 'stag'));
    foreach ($visacity_terms as $key => $value) {
        $visacity_options[$value->slug] = $value->name;
    }

    $meta_box = array(
        'id' => 'stag_metabox_logos',
        'title' => __('Logos Settings', 'stag'),
        'description' => __('Customize the logos settings.', 'stag'),
        'page' => 'post',
        'context' => 'normal',
        'priority' => 'high',
        'fields' => array(
            array(
                'name' => __('Logo Image', 'stag'),
                'desc' => __('Upload the logos image', 'stag'),
                'id' => '_stag_logo_image',
                'type' => 'file',
                'std' => ''
            ),
            array(
                'name' => __('Logo URL', 'stag'),
                'desc' => __('Enter the URL for logo (optional).', 'stag'),
                'id' => '_stag_logo_url',
                'type' => 'text',
                'std' => ''
            ),
            array(
                'name' => __('Alternative Text', 'stag'),
                'desc' => __('Enter the alt tag for logo (optional).', 'stag'),
                'id' => '_stag_logo_subtitle',
                'type' => 'text',
                'std' => ''
            ),
            array(
                'name' => __('Description', 'stag'),
                'desc' => __('Enter the description for logo (optional).', 'stag'),
                'id' => '_stag_logo_description',
                'type' => 'textarea',
                'std' => ''
            ),
            array(
                'name' => __('Origin', 'stag'),
                'desc' => __('Enter the origin for logo (optional).', 'stag'),
                'id' => '_stag_logo_origin',
                'type' => 'text',
                'std' => ''
            ),
            array(
                'name' => __('FINNOSUMMIT City', 'stag'),
                'desc' => __('Enter a FINNOSUMMIT City.', 'stag'),
                'id' => '_stag_logo_fscity',
                'type' => 'multicheck',
                'options' => $city_options,
                'std' => ''
            ),
            array(
                'name' => __('Pitch Days City', 'stag'),
                'desc' => __('Enter a Pitch Days City.', 'stag'),
                'id' => '_stag_logo_pitch_days',
                'type' => 'multicheck',
                'options' => $pdcity_options,
                'std' => ''
            ),
            array(
                'name' => __('Visa Everywhere City', 'stag'),
                'desc' => __('Enter a Visa Everywhere City.', 'stag'),
                'id' => '_stag_logo_visacity',
                'type' => 'multicheck',
                'options' => $visacity_options,
                'std' => ''
            ),
        )
    );
    $meta_box['page'] = 'logos';
    stag_add_meta_box($meta_box);
}


function stag_logos_template($count = 5)
{
    $args = array(
        'post_type' => 'logos',
        'posts_per_pages' => $count,
    );

    $the_query = new WP_Query($args);

    if ($the_query->have_posts()) {
        ?>

        <div id="patrocinadores_inner" class="clearfix">
            <?php while ($the_query->have_posts()): $the_query->the_post(); ?>
                <div class="patrocinador">
                    <?php
                    if (get_post_meta(get_the_ID(), '_stag_logo_image', true) != '') {
                        echo '<img src="' . get_post_meta(get_the_ID(), '_stag_logo_image', true) . '" alt="">';
                    }
                    ?>
                </div>
            <?php endwhile; ?>
        </div>
        <?php
        wp_reset_postdata();
    }
}

function stag_logos_shortcode()
{
    ob_start();
    stag_logos_template();
    $logos = ob_get_clean();
    return $logos;
}

add_shortcode('stag_logos', 'stag_logos_shortcode');
