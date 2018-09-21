<?php

add_action('add_meta_boxes', 'stag_metabox_cover_image');

function stag_metabox_cover_image(){
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
        'std' => ''
        ),
      )
    );
    stag_add_meta_box($meta_box);
}