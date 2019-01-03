<?php

function create_post_type_event_agenda()
{
    $labels = array(
        'name' => __('Event Agenda Items', 'stag'),
        'singular_name' => __('Event Agenda Item', 'stag'),
        'add_new' => _x('Add New', 'stag', 'stag'),
        'add_new_item' => __('Add New Event Agenda item', 'stag'),
        'edit_item' => __('Edit Event Agenda item', 'stag'),
        'new_item' => __('New Event Agenda item', 'stag'),
        'view_item' => __('View Event Agenda item', 'stag'),
        'search_items' => __('Search Event Agenda items', 'stag'),
        'not_found' => __('No event agenda items found', 'stag'),
        'not_found_in_trash' => __('No event agenda items found in Trash', 'stag'),
        'parent_item_colon' => ''
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'exclude_from_search' => true,
        'publicly_queryable' => true,
        'rewrite' => array('slug' => __('event_agenda', 'stag')),
        'show_ui' => true,
        'query_var' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields', 'excerpt')
        //'menu_icon' => get_template_directory_uri()."/assets/img/icon-snippets.png"
    );

    register_post_type(__('event_agenda', 'stag'), $args);
}

function event_agenda_build_taxonomies()
{
    register_taxonomy(__("event_agenda_category", 'stag'), array(__("event_agenda", 'stag')), array("hierarchical" => true, "label" => __("Event Agenda Categories", 'stag'), "singular_label" => __("Event Agenda Category", 'stag'), "rewrite" => array('slug' => 'event_agenda_category', 'hierarchical' => true)));
    register_taxonomy(__("event_agenda_topic", 'stag'), array(__("event_agenda", 'stag')), array("hierarchical" => true, "label" => __("Event Agenda Topics", 'stag'), "singular_label" => __("Event Agenda Topic", 'stag'), "rewrite" => array('slug' => 'event_agenda_topic', 'hierarchical' => true)));
}

function event_agenda_create_categories(){

    // see if we already have populated any terms
    $categories = get_terms( 'event_agenda_category', array( 'hide_empty' => false ) );

    // if no terms then lets add our terms
    if( empty( $categories ) ){
        $categories = event_agenda_get_categories();
        foreach( $categories as $category ){
            if( !term_exists( $category['name'], 'event_agenda_category' ) ){
                $new_term = wp_insert_term( $category['name'], 'event_agenda_category', array( 'slug' => $category['slug'] ) );
                if (is_array($new_term)) {
                    add_term_meta($new_term['term_id'], 'category_icon', $category['category_icon']);
                }
            }
        }
    }
}

function event_agenda_get_categories(){
    $categories = array(
        '0' => array( 'name' => __('Registration & Coffee'), 'slug' => 'registration-and-coffee', 'category_icon' => 'edit' ),
        '1' => array( 'name' => __('Welcome & introduction'), 'slug' => 'welcome-and-introduction', 'category_icon' => 'info-circle' ),
        '2' => array( 'name' => __('Inauguration'), 'slug' => 'inauguration', 'category_icon' => 'coffee' ),
        '3' => array( 'name' => __('Opening Keynote'), 'slug' => 'opening-keynote', 'category_icon' => 'coffee' ),
        '4' => array( 'name' => __('Fireside Chat'), 'slug' => 'fireside-chat', 'category_icon' => 'coffee' ),
        '5' => array( 'name' => __('Keynote'), 'slug' => 'keynote', 'category_icon' => 'microphone' ),
        '6' => array( 'name' => __('Conversation'), 'slug' => 'conversation', 'category_icon' => 'comments' ),
        '7' => array( 'name' => __('Coffee Break'), 'slug' => 'coffee-break', 'category_icon' => 'coffee' ),
        '8' => array( 'name' => __('Pitches/Demo'), 'slug' => 'pitches-demo', 'category_icon' => 'chalkboard-teacher' ),
        '9' => array( 'name' => __('Lunch Break'), 'slug' => 'lunch-break', 'category_icon' => 'utensils' ),
    );

    return $categories;
}

function event_agenda_edit_columns($columns)
{

    $columns = array(
        "cb" => "<input type=\"checkbox\" />",
        "title" => __('Title', 'stag'),
        "topic" => __('Topic', 'stag'),
        "category" => __('Category', 'stag'),
        "start" => __('Start', 'stag'),
        "end" => __('End', 'stag'),
        "event_agenda_date" => __('Event Agenda Date', 'stag'),
        "date" => __('Date', 'stag')
    );

    return $columns;
}


function event_agenda_custom_columns($column)
{
    global $post;
    switch ($column) {
        case __('topic', 'stag'):
            echo get_the_term_list($post->ID, __('event_agenda_topic', 'stag'), '', ', ', '');
            break;
        case __('category', 'stag'):
            echo get_the_term_list($post->ID, __('event_agenda_category', 'stag'), '', ', ', '');
            break;
        case __('start', 'stag'):
            echo get_post_meta(get_the_ID(), '_stag_event_agenda_start', true);
            break;
        case __('end', 'stag'):
            echo get_post_meta(get_the_ID(), '_stag_event_agenda_end', true);
            break;
        case __('event_agenda_date', 'stag'):
            echo get_post_meta(get_the_ID(), '_stag_event_agenda_date', true);
            break;
    }
}

function event_agenda_category_taxonomy_custom_fields($tag) {
    $term_meta = get_term_meta( $tag->term_id );
    $falink = '<a target="_blank" href="https://fontawesome.com/icons?d=gallery&m=free">' . __('fontawesome icons','stag') . '</a>';
    ?>

    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="category_icon"><?php _e('Event Agenda Category Icon'); ?></label>
        </th>
        <td>
            <input type="text" name="term_meta[category_icon]" id="term_meta[category_icon]" size="25" style="width:60%;" value="<?php echo $term_meta['category_icon'][0] ? $term_meta['category_icon'][0] : ''; ?>"><br />
            <span class="description"><?= sprintf(__('Enter the event icon. Choose from %s, just fill in the name.'), $falink);?></span>
        </td>
    </tr>

    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="category_icon"><?php _e('Event Agenda Category Color'); ?></label>
        </th>
        <td>
            <input type="text" name="term_meta[category_color]" id="term_meta[category_color]" class="colorpicker dfx-colorpicker" size="25" value="<?php echo $term_meta['category_color'][0] ? $term_meta['category_color'][0] : ''; ?>"><br />
            <span class="description"><?= __('Enter the event color in HEX, e.g. #AABBCC.');?></span>
        </td>
    </tr>

    <?php
}

function save_taxonomy_custom_fields( $term_id ) {
    if ( isset( $_POST['term_meta'] ) ) {
        $term_meta = get_term_meta( $term_id );
        $cat_keys = array_keys( $_POST['term_meta'] );
        foreach ( $cat_keys as $key ){
            if ( isset( $_POST['term_meta'][$key] ) ){
                $term_meta[$key] = $_POST['term_meta'][$key];
            }
            if (is_array($term_meta)) {
                update_term_meta( $term_id, $key, $_POST['term_meta'][$key] );
            } else {
                add_term_meta( $term_id, $key, $_POST['term_meta'][$key] );
            }
        }
    }
}

add_action('init', 'create_post_type_event_agenda');
add_action('init', 'event_agenda_build_taxonomies', 0);
add_action('init', 'event_agenda_create_categories', 0);
add_filter("manage_edit-event_agenda_columns", "event_agenda_edit_columns");
add_action("manage_posts_custom_column", "event_agenda_custom_columns");
add_action('event_agenda_category_edit_form_fields', 'event_agenda_category_taxonomy_custom_fields', 10, 2 );
add_action('edited_event_agenda_category', 'save_taxonomy_custom_fields', 10, 2 );
add_action('create_event_agenda_category', 'save_taxonomy_custom_fields', 10, 2 );