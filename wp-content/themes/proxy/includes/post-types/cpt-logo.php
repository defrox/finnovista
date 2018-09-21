<?php

function create_post_type_logo(){
  $labels = array(
    'name' => __( 'Logos', 'stag'),
    'singular_name' => __( 'Logo' , 'stag'),
    'add_new' => _x('Add New', 'stag', 'stag'),
    'add_new_item' => __('Add New Logo', 'stag'),
    'edit_item' => __('Edit Logo', 'stag'),
    'new_item' => __('New Logo', 'stag'),
    'view_item' => __('View Logo', 'stag'),
    'search_items' => __('Search Logos', 'stag'),
    'not_found' =>  __('No logos found', 'stag'),
    'not_found_in_trash' => __('No logos found in Trash', 'stag'),
    'parent_item_colon' => ''
    );

    $args = array(
    'labels' => $labels,
    'public' => true,
    'exclude_from_search' => true,
    'publicly_queryable' => true,
    'rewrite' => array('slug' => __( 'logos', 'stag' )),
    'show_ui' => true,
    'query_var' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
    'menu_position' => null,
    'has_archive' => false,
    'supports' => array('title'),
    'hierarchical' => false,
    );

    register_post_type(__( 'logos', 'stag' ),$args);
}

function logo_build_taxonomies(){
  register_taxonomy(__( "logo_type", 'stag' ), array(__( "logos", 'stag' )), array("hierarchical" => true, "label" => __( "Logo Types", 'stag' ), "singular_label" => __( "Logo Type", 'stag' ), "rewrite" => array('slug' => 'logo_type', 'hierarchical' => true)));
}

function logo_edit_columns($columns){

        $columns = array(
            "cb" => "<input type=\"checkbox\" />",
            "title" => __( 'Logo Title', 'stag' ),
            "type" => __( 'Logo Type', 'stag' ),
            "date" => __('Date', 'stag')
        );

        return $columns;
}

function logo_custom_columns($column){
    global $post;
    switch ($column){
        case __( 'type', 'stag' ):
        echo get_the_term_list($post->ID, __( 'logo_type', 'stag' ), '', ', ','');
        break;
   }
}

add_action('init', 'create_post_type_logo');
add_action('init', 'logo_build_taxonomies', 0);
add_filter("manage_edit-logo_columns", "logo_edit_columns");
add_action("manage_posts_custom_column",  "logo_custom_columns");