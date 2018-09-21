<?php

add_action('add_meta_boxes', 'stag_metabox_team');

function stag_metabox_team()
{
    $city_taxonomies = array(
        'event_city',
    );

    $city_terms = get_terms($city_taxonomies, 'hide_empty=0');
    //$city_options = array('' => __('None', 'stag'));
    foreach ($city_terms as $key => $value) {
        $city_options[$value->slug] = $value->name;
    }

    $pdcity_taxonomies = array(
        'event_pdcity',
    );

    $pdcity_terms = get_terms($pdcity_taxonomies, 'hide_empty=0');
    //$pdcity_options = array('' => __('None', 'stag'));
    foreach ($pdcity_terms as $key => $value) {
        $pdcity_options[$value->slug] = $value->name;
    }

    $visacity_taxonomies = array(
        'event_visacity',
    );

    $visacity_terms = get_terms($visacity_taxonomies, 'hide_empty=0');
    //$visacity_options = array('' => __('None', 'stag'));
    foreach ($visacity_terms as $key => $value) {
        $visacity_options[$value->slug] = $value->name;
    }

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
                'name' => __('Order', 'stag'),
                'desc' => __('Enter the member\'s order weight.', 'stag'),
                'id' => '_stag_team_order',
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
            /*array(
            'name' => __('Category', 'stag'),
            'desc' => __('Enter member category.', 'stag'),
            'id' => '_stag_team_category',
            'type' => 'select',
            'options' => array( 'Team'=>'Team',
                                'Speaker'=>'Speaker',
                                'Judges and Mentors' => 'Judges and Mentors',
                                'Collaborator' => 'Collaborator',
                                'Sponsor' => 'Sponsor',
                                ),
            'std' => ''
            ),
            array(
            'name' => __('Area', 'stag'),
            'desc' => __('Enter area.', 'stag'),
            'id' => '_stag_team_area_type',
            'type' => 'select',
            'options' => array( ''=>__('None', 'stag'),
                                'US & RoW'=>'US & RoW',
                                'LATAM'=>'LATAM',
                                'EU' => 'EU',
                                ),
            'std' => ''
            ),*/
            array(
                'name' => __('FINNOSUMMIT City', 'stag'),
                'desc' => __('Enter a FINNOSUMMIT City.', 'stag'),
                'id' => '_stag_team_fscity',
                'type' => 'multicheck',
                'options' => $city_options,
                'std' => ''
            ),
            array(
                'name' => __('Pitch Days City', 'stag'),
                'desc' => __('Enter a Pitch Days City.', 'stag'),
                'id' => '_stag_team_pitch_days',
                'type' => 'multicheck',
                'options' => $pdcity_options,
                'std' => ''
            ),
            array(
                'name' => __('Visa Everywhere City', 'stag'),
                'desc' => __('Enter a Visa Everywhere City.', 'stag'),
                'id' => '_stag_team_visacity',
                'type' => 'multicheck',
                'options' => $visacity_options,
                'std' => ''
            ),
        )
    );
    $meta_box['page'] = 'team';
    stag_add_meta_box($meta_box);
}
