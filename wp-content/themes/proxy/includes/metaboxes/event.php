<?php
add_action('add_meta_boxes', 'stag_metabox_event');

function stag_metabox_event()
{
    $meta_box = array(
        'id' => 'stag_metabox_event',
        'title' => __('Event Details', 'stag'),
        'description' => __('Enter the details of the event.', 'stag'),
        'page' => 'post',
        'context' => 'normal',
        'priority' => 'high',
        'fields' => array(
            array(
                'name' => __('Enable Event Registration', 'stag'),
                'desc' => __('Enable the event registration, else show coming soon.', 'stag'),
                'id' => '_stag_event_register_enabled',
                'type' => 'checkbox',
                'std' => ''
            ),
            array(
                'name' => __('Show Past Event', 'stag'),
                'desc' => __('Shows or hides the event when the date has passed.', 'stag'),
                'id' => '_stag_show_past_event',
                'type' => 'checkbox',
                'std' => ''
            ),
            array(
                'name' => __('Event Date Text', 'stag'),
                'desc' => __('Enter the event date text', 'stag'),
                'id' => '_stag_event_date_text',
                'type' => 'text',
                'std' => ''
            ),
            array(
                'name' => __('Event Date', 'stag'),
                'desc' => __('Enter the event date in format YYYY-MM-DD e.g. 2015-06-22', 'stag'),
                'id' => '_stag_event_date',
                'type' => 'text',
                'std' => ''
            ),
            array(
                'name' => __('Event URL', 'stag'),
                'desc' => __('Enter the event URL.', 'stag'),
                'id' => '_stag_event_url',
                'type' => 'text',
                'std' => ''
            ),
            array(
                'name' => __('Event Color', 'stag'),
                'desc' => __('Enter the event color in HEX, e.g. #AABBCC', 'stag'),
                'id' => '_stag_event_color',
                'type' => 'text',
                'std' => ''
            ),
            array(
                'name' => __('Event Font Color', 'stag'),
                'desc' => __('Enter the event font color in HEX, e.g. #AABBCC', 'stag'),
                'id' => '_stag_event_font_color',
                'type' => 'text',
                'std' => ''
            ),
            array(
                'name' => __('Event Logo', 'stag'),
                'desc' => __('Choose an image, ideal size 300px x 150px.', 'stag'),
                'id' => '_stag_event_logo',
                'type' => 'file',
                'std' => ''
            ),
            array(
                'name' => __('Event Ticket', 'stag'),
                'desc' => __('Choose an image for the side link, ideal size 500px x 345px.', 'stag'),
                'id' => '_stag_event_ticket',
                'type' => 'file',
                'std' => ''
            ),
            array(
                'name' => __('Event Poster', 'stag'),
                'desc' => __('Choose an image for the FINNOSUMMIT home page, ideal size 193px x 265px.', 'stag'),
                'id' => '_stag_event_poster',
                'type' => 'file',
                'std' => ''
            ),
            array(
                'name' => __('Event Venue Image', 'stag'),
                'desc' => __('Choose an image for the FINNOSUMMIT Venue, ideal size 860px x 183px.', 'stag'),
                'id' => '_stag_event_venue_image',
                'type' => 'file',
                'std' => ''
            ),
            array(
                'name' => __('Event Venue Location Iframe', 'stag'),
                'desc' => __('Enter the event venue iframe, set window size 400x300.', 'stag'),
                'id' => '_stag_event_venue_iframe',
                'type' => 'text',
                'std' => ''
            ),
            array(
                'name' => __('Event Venue Location Text', 'stag'),
                'desc' => __('Enter the event venue text.', 'stag'),
                'id' => '_stag_event_venue_text',
                'type' => 'textarea',
                'std' => ''
            ),
            array(
                'name' => __('Event Image 1', 'stag'),
                'desc' => __('Choose an image, ideal size 1400px x unlimited.', 'stag'),
                'id' => '_stag_event_image_1',
                'type' => 'file',
                'std' => ''
            ),
            array(
                'name' => __('Event Image 2', 'stag'),
                'desc' => __('Choose an image, ideal size 1400px x unlimited.', 'stag'),
                'id' => '_stag_event_image_2',
                'type' => 'file',
                'std' => ''
            ),
            array(
                'name' => __('Event Image 3', 'stag'),
                'desc' => __('Choose an image, ideal size 1400px x unlimited.', 'stag'),
                'id' => '_stag_event_image_3',
                'type' => 'file',
                'std' => ''
            ),
            array(
                'name' => __('Event Image 4', 'stag'),
                'desc' => __('Choose an image, ideal size 1400px x unlimited.', 'stag'),
                'id' => '_stag_event_image_4',
                'type' => 'file',
                'std' => ''
            ),
            array(
                'name' => __('Event Image 5', 'stag'),
                'desc' => __('Choose an image, ideal size 1400px x unlimited.', 'stag'),
                'id' => '_stag_event_image_5',
                'type' => 'file',
                'std' => ''
            ),

        )
    );
    $meta_box['page'] = 'event';
    stag_add_meta_box($meta_box);
}