<?php

add_action('add_meta_boxes', 'stag_metabox_cover_image');

function stag_metabox_cover_image()
{
    $meta_box = array(
        'id' => 'stag_metabox_cover_image',
        'title' => __('Cover Image Settings', 'stag'),
        'description' => __('Set a cover image for the post.', 'stag'),
        'page' => 'post',
        'context' => 'normal',
        'priority' => 'high',
        'fields' => array(
            array(
                'name' => __('Select Cover Image', 'stag'),
                'desc' => __('Ideal size 1400px x unlimited.', 'stag'),
                'id' => '_stag_cover_image',
                'type' => 'file',
                'std' => '',
            ),
            array(
                'name' => __('Short title to show on hover', 'stag'),
                'desc' => __('Titulo corto (custom field).', 'stag'),
                'id' => 'titulo_corto',
                'type' => 'text',
                'std' => '',
            ),
            array(
                'name' => __('Alternative Link', 'stag'),
                'desc' => __('Alternative Link (custom field).', 'stag'),
                'id' => 'alternative_link',
                'type' => 'text',
                'std' => '',
            ),
            array(
                'name' => __('Event Date', 'stag'),
                'desc' => __('Enter the event date in format YYYY-MM-DD e.g. 2015-06-22', 'stag'),
                'id' => '_stag_event_date',
                'type' => 'text',
                'std' => ''
            ),
        )
    );
    stag_add_meta_box($meta_box);
}

function stag_metabox_finnosummit_page(){
    global $post;
    // Get the page template post meta
    $page_template = get_post_meta( $post->ID, '_wp_page_template', true );
    // If the current page uses our specific
    // template, then output our custom metabox

    if ( 'finnosummit-page.php' == $page_template ) {
        $events = query_posts(array('post_type' => 'event'));
        $event_options = array('' => __('None', 'stag'));
        foreach ($events as $key => $value) {
            $event_options[(string)$value->ID] = $value->post_title;
        }
        //die(var_dump($event_options));
        $meta_box2 = array(
            'id' => 'stag_metabox_event_id',
            'title' => __('Linked Event', 'stag'),
            'description' => __('Set a linked event for the page.', 'stag'),
            'page' => 'page',
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'name' => __('Select Event', 'stag'),
                    'desc' => __('Select the event you wish to link with this page, so the menu and the ticket will be shown here.', 'stag'),
                    'id' => '_stag_linked_event',
                    'type' => 'select2',
                    'options' => $event_options,
                    'std' => ''
                ),
            )
        );
        stag_add_meta_box($meta_box2);
    };
}

add_action( 'add_meta_boxes', 'stag_metabox_finnosummit_page' );

function stag_metabox_custom_page(){
    global $post;
    // Get the page template post meta
    $page_template = get_post_meta( $post->ID, '_wp_page_template', true );
    // If the current page uses our specific
    // template, then output our custom metabox

    if ( 'custom-page.php' == $page_template ) {
        $meta_box2 = array(
            'id' => 'stag_metabox_custom_logo',
            'title' => __('Custom Logo', 'stag'),
            'page' => 'page',
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'name' => __('Custom Logo', 'stag'),
                    'desc' => __('Choose an image, ideal size 300px x 150px.', 'stag'),
                    'id' => '_stag_custom_page_logo',
                    'type' => 'file',
                    'std' => ''
                ),
            )
        );
        stag_add_meta_box($meta_box2);
    };
}

add_action( 'add_meta_boxes', 'stag_metabox_custom_page' );

function stag_metabox_challenges_page(){
    global $post;
    // Get the page template post meta
    $page_template = get_post_meta( $post->ID, '_wp_page_template', true );
    // If the current page uses our specific
    // template, then output our custom metabox

    if ( 'challenges-page.php' == $page_template ) {
        $menus = get_terms('nav_menu');;
        $menu_options = array('' => __('None', 'stag'));
        foreach ($menus as $key => $value) {
            $menu_options[(string)$value->slug] = $value->name;
        }
        //var_dump($menus);
        $meta_box2 = array(
            'id' => 'stag_metabox_challenges_page',
            'title' => __('Template Options', 'stag'),
            'page' => 'page',
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'name' => __('Custom Logo', 'stag'),
                    'desc' => __('Choose an image, ideal size 300px x 150px.', 'stag'),
                    'id' => '_stag_challenges_logo',
                    'type' => 'file',
                    'std' => ''
                ),
                array(
                    'name' => __('Ticket', 'stag'),
                    'desc' => __('Choose an image, ideal size 500px x 345px.', 'stag'),
                    'id' => '_stag_challenges_ticket',
                    'type' => 'file',
                    'std' => ''
                ),
                array(
                    'name' => __('Select Background Color', 'stag'),
                    'desc' => __('Select the background colour for the menu.', 'stag'),
                    'id' => '_stag_challenges_background_color',
                    'type' => 'text',
                    'std' => ''
                ),
                array(
                    'name' => __('Select Font Color', 'stag'),
                    'desc' => __('Select the font colour for the menu.', 'stag'),
                    'id' => '_stag_challenges_font_color',
                    'type' => 'text',
                    'std' => ''
                ),
                array(
                    'name' => __('Banner Link', 'stag'),
                    'desc' => __('Select the url for the banner link.', 'stag'),
                    'id' => '_stag_challenges_banner_link',
                    'type' => 'text',
                    'std' => ''
                ),
            )
        );
        stag_add_meta_box($meta_box2);
    };
}

add_action( 'add_meta_boxes', 'stag_metabox_challenges_page' );

function stag_metabox_bootstrap_agenda_page(){
    global $post;
    // Get the page template post meta
    $page_template = get_post_meta( $post->ID, '_wp_page_template', true );
    // If the current page uses our specific
    // template, then output our custom metabox

    if ('page-bootstrap-agenda-fs.php' == $page_template ||
        'page-bootstrap-agenda-visa.php' == $page_template ||
        'page-daily-agenda-fs.php' == $page_template ||
        'page-daily-agenda-visa.php' == $page_template ) {
        $events = query_posts(array('post_type' => 'event'));
        $event_options = array('' => __('None', 'stag'));
        foreach ($events as $key => $value) {
            $event_options[(string)$value->ID] = $value->post_title;
        }
        //die(var_dump($event_options));
        $meta_box2 = array(
            'id' => 'stag_metabox_event_id',
            'title' => __('Linked Event', 'stag'),
            'description' => __('Set a linked event for the agenda.', 'stag'),
            'page' => 'page',
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'name' => __('Select Event', 'stag'),
                    'desc' => __('Select the event you wish to link with this agenda.', 'stag'),
                    'id' => '_stag_linked_event',
                    'type' => 'select2',
                    'options' => $event_options,
                    'std' => ''
                ),
            )
        );
        stag_add_meta_box($meta_box2);
    };
}

add_action( 'add_meta_boxes', 'stag_metabox_bootstrap_agenda_page' );
