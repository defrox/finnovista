<?php

function create_post_type_team(){
  $labels = array(
        'name' => __( 'Team', 'stag'),
        'singular_name' => __( 'Team' , 'stag'),
        'add_new' => _x('Add New', 'stag', 'stag'),
        'add_new_item' => __('Add New Team', 'stag'),
        'edit_item' => __('Edit Team', 'stag'),
        'new_item' => __('New Team', 'stag'),
        'view_item' => __('View Team', 'stag'),
        'search_items' => __('Search Team', 'stag'),
        'not_found' =>  __('No team found', 'stag'),
        'not_found_in_trash' => __('No team found in Trash', 'stag'),
        'parent_item_colon' => ''
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'exclude_from_search' => true,
        'publicly_queryable' => true,
        'rewrite' => array('slug' => __( 'team', 'stag' )),
        'show_ui' => true,
        'query_var' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'has_archive' => false,
        'supports' => array('title', 'thumbnail'),
        'hierarchical' => false,
    );

    register_post_type(__( 'team', 'stag' ),$args);
}

function team_edit_columns($columns){

        $columns = array(
            "cb" => "<input type=\"checkbox\" />",
            "title" => __( 'Team Member Title', 'stag' ),
            "position" => __( 'Team Member Position', 'stag' ),
            "date" => __('Date', 'stag')
        );

        return $columns;
}


function team_custom_columns($column){
    global $post;
    switch ($column){
        case __( 'position', 'stag' ):
        echo get_post_meta(get_the_ID(), '_stag_team_position', true);
        break;
    }
}


add_action('init', 'create_post_type_team');
add_filter("manage_edit-team_columns", "team_edit_columns");
add_action("manage_posts_custom_column",  "team_custom_columns");