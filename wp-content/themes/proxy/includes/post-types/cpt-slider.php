<?php

function create_post_type_slider(){
  $labels = array(
    'name' => __( 'Slides', 'stag'),
    'singular_name' => __( 'Slides' , 'stag'),
    'add_new' => _x('Add New', 'stag', 'stag'),
    'add_new_item' => __('Add New Slides', 'stag'),
    'edit_item' => __('Edit Slides', 'stag'),
    'new_item' => __('New Slides', 'stag'),
    'view_item' => __('View Slides', 'stag'),
    'search_items' => __('Search Slides', 'stag'),
    'not_found' =>  __('No slides found', 'stag'),
    'not_found_in_trash' => __('No slides found in Trash', 'stag'),
    'parent_item_colon' => ''
    );

    $args = array(
    'labels' => $labels,
    'public' => true,
    'exclude_from_search' => true,
    'publicly_queryable' => true,
    'rewrite' => array('slug' => __( 'slides', 'stag' )),
    'show_ui' => true,
    'query_var' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
    'menu_position' => null,
    'has_archive' => false,
    'supports' => array('title'),
    'hierarchical' => false,
    );

    register_post_type(__( 'slides', 'stag' ),$args);
}

function slider_edit_columns($columns){

        $columns = array(
            "cb" => "<input type=\"checkbox\" />",
            "title" => __( 'Slider Title', 'stag' ),
            "date" => __('Date', 'stag')
        );

        return $columns;
}

add_action('init', 'create_post_type_slider');
add_filter("manage_edit-slider_columns", "slider_edit_columns");
