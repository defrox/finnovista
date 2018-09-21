<?php
add_action('add_meta_boxes', 'stag_metabox_event_agenda');

function stag_metabox_event_agenda()
{
    $events = query_posts(array('post_type' => 'event'));
    $event_options = array('' => __('None', 'stag'));
    foreach ($events as $key => $value) {
        $event_options[(string)$value->ID] = $value->post_title;
    }
    $meta_box = array(
        'id' => 'stag_metabox_event_agenda',
        'title' => __('Event Agenda Details', 'stag'),
        'description' => __('Enter the details of the event agenda item.', 'stag'),
        'page' => 'post',
        'context' => 'normal',
        'priority' => 'high',
        'fields' => array(
            array(
                'name' => __('Select Event', 'stag'),
                'desc' => __('Select the event you wish to link with this agenda item.', 'stag'),
                'id' => '_stag_linked_event_agenda',
                'type' => 'select2',
                'options' => $event_options,
                'std' => ''
            ),
            /*array(
                'name' => __('Event Day Text', 'stag'),
                'desc' => __('Enter the event date text', 'stag'),
                'id' => '_stag_event_date_text',
                'type' => 'text',
                'std' => ''
            ),*/
            array(
                'name' => __('Event Agenda Date', 'stag'),
                'desc' => __('Enter the event date in format YYYY-MM-DD e.g. 2015-06-22', 'stag'),
                'id' => '_stag_event_agenda_date',
                'type' => 'text',
                'std' => ''
            ),
            array(
                'name' => __('Event Agenda Start', 'stag'),
                'desc' => __('Enter the start time in format HH:MM e.g. 16:00', 'stag'),
                'id' => '_stag_event_agenda_start',
                'type' => 'text',
//                'attributes' => array(
//                    'disabled'  => true,
//                    'required'  => true,
//                    'readonly'  => true,
//                    'maxlength' => true,
//                    'pattern'   => true,
//                ),
                'std' => ''
            ),
            array(
                'name' => __('Event Agenda End', 'stag'),
                'desc' => __('Enter the end time in format HH:MM e.g. 16:00', 'stag'),
                'id' => '_stag_event_agenda_end',
                'type' => 'text',
                'std' => ''
            ),
//            array(
//                'name' => __('Event Agenda Icon', 'stag'),
//                'desc' => __('Enter the event icon. Choose from https://fontawesome.com/icons?d=gallery&m=free just fill in the name.', 'stag'),
//                'id' => '_stag_event_agenda_icon',
//                'type' => 'text',
//                'std' => ''
//            ),
            array(
                'name' => __('Event Agenda Speakers', 'stag'),
                'desc' => __('Enter the speakers text.', 'stag'),
                'id' => '_stag_event_agenda_speakers',
                'type' => 'textarea',
                'class' => 'dfx-mce-editor',
                'std' => ''
            ),

            array(
                'name' => __('Event Agenda Avatar', 'stag'),
                'desc' => __('Choose an image, to use as avatar.', 'stag'),
                'id' => '_stag_event_agenda_avatar',
                'type' => 'file',
                'std' => ''
            ),

        )
    );
    $meta_box['page'] = 'event_agenda';
    stag_add_meta_box($meta_box);
}