<?php

function create_post_type_video(){
  $labels = array(
    'name' => __( 'Videos', 'stag'),
    'singular_name' => __( 'Video' , 'stag'),
    'add_new' => _x('Add New', 'stag', 'stag'),
    'add_new_item' => __('Add New Video', 'stag'),
    'edit_item' => __('Edit Video', 'stag'),
    'new_item' => __('New Video', 'stag'),
    'view_item' => __('View Video', 'stag'),
    'search_items' => __('Search Videos', 'stag'),
    'not_found' =>  __('No videos found', 'stag'),
    'not_found_in_trash' => __('No videos found in Trash', 'stag'),
    'parent_item_colon' => ''
    );

    $args = array(
    'labels' => $labels,
    'public' => true,
    'exclude_from_search' => true,
    'publicly_queryable' => true,
    'rewrite' => array('slug' => __( 'videos', 'stag' )),
    'show_ui' => true,
    'query_var' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
    'menu_position' => null,
    'has_archive' => false,
    'supports' => array('title', 'thumbnail', 'editor', 'excerpt'),
    'hierarchical' => false,
    );

    register_post_type(__( 'videos', 'stag' ),$args);
}

function video_edit_columns($columns){

        $columns = array(
            "cb" => "<input type=\"checkbox\" />",
            "title" => __( 'Video Title', 'stag' ),
            "date" => __('Date', 'stag')
        );

        return $columns;
}

add_action('init', 'create_post_type_video');
add_filter("manage_edit-video_columns", "video_edit_columns");
