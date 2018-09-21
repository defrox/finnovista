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
            "category" => __( 'Team Member Category', 'stag' ),
            "position" => __( 'Team Member Position', 'stag' ),
            "order" => __('Order', 'stag'),
            "date" => __('Date', 'stag'),
        );

        return $columns;
}


function team_custom_columns($column){
    global $post;
    switch ($column){
        case __( 'position', 'stag' ):
        echo get_post_meta(get_the_ID(), '_stag_team_position', true);
        break;
        case __( 'category', 'stag' ):
        echo get_post_meta(get_the_ID(), '_stag_team_category', true);
        break;
        case __( 'order', 'stag' ):
        echo get_post_meta(get_the_ID(), '_stag_team_order', true);
        break;
    }
}

function team_build_taxonomies(){
  register_taxonomy(__( "_stag_team_category", 'stag' ), array(__( "team", 'stag' )), array("hierarchical" => true, "label" => __( "Team Member Categories", 'stag' ), "singular_label" => __( "Team Member Category", 'stag' ), "rewrite" => array('slug' => '_stag_team_category', 'hierarchical' => true)));
  register_taxonomy(__( "_stag_team_area_type", 'stag' ), array(__( "team", 'stag' )), array("hierarchical" => true, "label" => __( "Team Member Areas", 'stag' ), "singular_label" => __( "Team Member Area", 'stag' ), "rewrite" => array('slug' => '_stag_team_area_type', 'hierarchical' => true)));
}

function team_create_categories(){
 
        // see if we already have populated any terms
    $categories = get_terms( '_stag_team_category', array( 'hide_empty' => false ) );
 
    // if no terms then lets add our terms
    if( empty( $categories ) ){
        $categories = team_get_categories();
        foreach( $categories as $category ){
            if( !term_exists( $category['name'], '_stag_team_category' ) ){
                wp_insert_term( $category['name'], '_stag_team_category', array( 'slug' => $category['slug'] ) );
            }
        }
    } 
}

function team_get_categories(){ 
    $categories = array(
        '0' => array( 'name' => 'Judges and Mentors', 'slug' => 'judges-mentors' ),
        '1' => array( 'name' => 'Speaker', 'slug' => 'speaker' ),
        '2' => array( 'name' => 'Team', 'slug' => 'team' ),
        '3' => array( 'name' => 'Sponsor', 'slug' => 'sponsor' ),
        '4' => array( 'name' => 'Collaborator', 'slug' => 'collaborator' ),
    );
 
    return $categories;
}   

function team_create_areas(){
 
        // see if we already have populated any terms
    $areas = get_terms( '_stag_team_area_type', array( 'hide_empty' => false ) );
 
    // if no terms then lets add our terms
    if( empty( $areas ) ){
        $areas = team_get_areas();
        foreach( $areas as $area ){
            if( !term_exists( $area['name'], '_stag_team_area_type' ) ){
                wp_insert_term( $area['name'], '_stag_team_area_type', array( 'slug' => $area['slug'] ) );
            }
        }
    } 
}

function team_get_areas(){ 
    $areas = array(
        '0' => array( 'name' => 'US & RoW', 'slug' => 'us-row' ),
        '1' => array( 'name' => 'LATAM', 'slug' => 'latam' ),
        '2' => array( 'name' => 'EU', 'slug' => 'eu' ),
    );
 
    return $areas;
}   

function update_team_values() {
    global $wpdb;
    $contador = 0;
    $get_query = "SELECT * FROM wp_postmeta WHERE meta_key = '_stag_team_category'";
    $results = $wpdb->get_results( $get_query, OBJECT );
    foreach($results as $result){
        $get_terms = "SELECT * FROM wp_terms WHERE BINARY name = '" . $result->meta_value . "'";
        $terms = $wpdb->get_results( $get_terms, OBJECT );
        foreach ($terms as $term) {
            $get_insert = "SELECT COUNT(*) FROM wp_term_relationships WHERE object_id=" . $result->post_id . " AND term_taxonomy_id=".$term->term_id;
            $insert = $wpdb->get_var( $get_insert );
            if ($insert==0) {
                $wpdb->insert( 
                    'wp_term_relationships', 
                    array( 
                        'object_id' => $result->post_id, 
                        'term_taxonomy_id' => $term->term_id,
                        'term_order' => 0 
                    ), 
                    array( 
                        '%d', 
                        '%d',
                        '%d' 
                    ) 
                );
                $contador++;
            };
        }
    }
    echo $contador;
    #die();
}

function update_area_values() {
    global $wpdb;
    $contador = 0;
    $get_query = "SELECT * FROM wp_postmeta WHERE meta_key = '_stag_team_area_type'";
    $results = $wpdb->get_results( $get_query, OBJECT );
    foreach($results as $result){
        $get_terms = "SELECT * FROM wp_terms WHERE BINARY name = '" . $result->meta_value . "'";
        $terms = $wpdb->get_results( $get_terms, OBJECT );
        foreach ($terms as $term) {
            $get_insert = "SELECT COUNT(*) FROM wp_term_relationships WHERE object_id=" . $result->post_id . " AND term_taxonomy_id=".$term->term_id;
            $insert = $wpdb->get_var( $get_insert );
            if ($insert==0) {
                $wpdb->insert( 
                    'wp_term_relationships', 
                    array( 
                        'object_id' => $result->post_id, 
                        'term_taxonomy_id' => $term->term_id,
                        'term_order' => 0 
                    ), 
                    array( 
                        '%d', 
                        '%d',
                        '%d' 
                    ) 
                );
                $contador++;
            };
        }
    }
    echo $contador;
    #die();
}


add_action('init', 'create_post_type_team');
add_action('init', 'team_build_taxonomies', 0);
add_action('init', 'team_create_categories', 0);
add_action('init', 'team_create_areas', 0);
#add_action('init', 'update_team_values', 0);
#add_action('init', 'update_area_values', 0);
add_filter("manage_edit-team_columns", "team_edit_columns");
add_action("manage_posts_custom_column",  "team_custom_columns");