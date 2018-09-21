<?php

add_action('add_meta_boxes', 'stag_metabox_team');

function stag_metabox_team(){
  $meta_box = array(
    'id' => 'stag_metabox_team',
    'title' => __('Team Member Details', 'stag'),
    'description' => __('Enter the details of team member.', 'stag'),
    'page' => 'post',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
      array(
        'name' => __('Member\'s Position', 'stag'),
        'desc' => __('Enter the current position of team member.', 'stag'),
        'id' => '_stag_team_position',
        'type' => 'text',
        'std' => ''
        ),
      array(
        'name' => __('Member\'s twitter Profile URL', 'stag'),
        'desc' => __('Enter the twitter Profile url of team member.', 'stag'),
        'id' => '_stag_team_url_twitter',
        'type' => 'text',
        'std' => ''
        ),
      array(
        'name' => __('Member\'s linkedin Profile URL', 'stag'),
        'desc' => __('Enter the linkedin Profile url of team member.', 'stag'),
        'id' => '_stag_team_url_linkedin',
        'type' => 'text',
        'std' => ''
        ),
        array(
        'name' => __('Bio', 'stag'),
        'desc' => __('Enter the bio team member.', 'stag'),
        'id' => '_stag_team_bio',
        'type' => 'text',
        'std' => ''
        ),
        array(
        'name' => __('Category', 'stag'),
        'desc' => __('Enter equipo, mentor o gestor.', 'stag'),
        'id' => '_stag_team_cat',
        'type' => 'select',
        'options' => array('speaker'=>'speaker'),
        'std' => ''
        ),
      )
    );
    $meta_box['page'] = 'team';
    stag_add_meta_box($meta_box);
}
