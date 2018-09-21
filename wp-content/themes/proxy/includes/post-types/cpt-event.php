<?php

function create_post_type_event()
{
    $labels = array(
        'name' => __('Event', 'stag'),
        'singular_name' => __('Event', 'stag'),
        'add_new' => _x('Add New', 'stag', 'stag'),
        'add_new_item' => __('Add New Event', 'stag'),
        'edit_item' => __('Edit Event', 'stag'),
        'new_item' => __('New Event', 'stag'),
        'view_item' => __('View Event', 'stag'),
        'search_items' => __('Search Event', 'stag'),
        'not_found' => __('No events found', 'stag'),
        'not_found_in_trash' => __('No events found in Trash', 'stag'),
        'parent_item_colon' => ''
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'exclude_from_search' => true,
        'publicly_queryable' => true,
        'rewrite' => array('slug' => __('event', 'stag')),
        'show_ui' => true,
        'query_var' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields', 'excerpt')
        //'menu_icon' => get_template_directory_uri()."/assets/img/icon-snippets.png"
    );

    register_post_type(__('event', 'stag'), $args);
}

function event_build_taxonomies()
{
    register_taxonomy(__("event_type", 'stag'), array(__("event", 'stag')), array("hierarchical" => true, "label" => __("Event Type", 'stag'), "singular_label" => __("Event Type", 'stag'), "rewrite" => array('slug' => 'event_type', 'hierarchical' => true)));
    register_taxonomy(__("event_city", 'stag'), array(__("event", 'stag')), array("hierarchical" => true, "label" => __("FINNOSUMMIT Cities", 'stag'), "singular_label" => __("FINNOSUMMIT City", 'stag'), "rewrite" => array('slug' => 'event_city', 'hierarchical' => false)));
    register_taxonomy(__("event_pdcity", 'stag'), array(__("event", 'stag')), array("hierarchical" => true, "label" => __("Pitch Days Cities", 'stag'), "singular_label" => __("Pitch Days City", 'stag'), "rewrite" => array('slug' => 'event_pdcity', 'hierarchical' => false)));
    register_taxonomy(__("event_visacity", 'stag'), array(__("event", 'stag')), array("hierarchical" => true, "label" => __("Visa Everywhere Cities", 'stag'), "singular_label" => __("Visa Everywhere City", 'stag'), "rewrite" => array('slug' => 'event_visacity', 'hierarchical' => false)));
}

function event_edit_columns($columns)
{

    $columns = array(
        "cb" => "<input type=\"checkbox\" />",
        "title" => __('Event Title', 'stag'),
        "type" => __('Event Type', 'stag'),
        "city" => __('FINNOSUMMIT City', 'stag'),
        "pdcity" => __('Pitch Days City', 'stag'),
        "visacity" => __('Visa Everywhere City', 'stag'),
        "event_date" => __('Event Date', 'stag'),
        "date" => __('Date', 'stag')
    );

    return $columns;
}


function event_custom_columns($column)
{
    global $post;
    switch ($column) {
        case __('type', 'stag'):
            echo get_the_term_list($post->ID, __('event_type', 'stag'), '', ', ', '');
            break;
        case __('city', 'stag'):
            echo get_the_term_list($post->ID, __('event_city', 'stag'), '', ', ', '');
            break;
        case __('pdcity', 'stag'):
            echo get_the_term_list($post->ID, __('event_pdcity', 'stag'), '', ', ', '');
            break;
        case __('visacity', 'stag'):
            echo get_the_term_list($post->ID, __('event_visacity', 'stag'), '', ', ', '');
            break;
        case __('event_date', 'stag'):
            echo get_post_meta(get_the_ID(), '_stag_event_date', true);
            break;
    }
}

add_action('init', 'create_post_type_event');
add_action('init', 'event_build_taxonomies', 0);
add_filter("manage_edit-event_columns", "event_edit_columns");
add_action("manage_posts_custom_column", "event_custom_columns");