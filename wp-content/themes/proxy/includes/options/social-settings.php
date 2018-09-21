<?php
add_action('admin_init', 'stag_social_settings');
function stag_social_settings(){

  $social_settings['description'] = __('Configure the social links for your site.', 'stag');

  $social_settings[] = array(
    'title' => 'Facebook URL',
    'desc' => 'Enter your facebook page/profile username',
    'type' => 'text',
    'id' => 'social_url_facebook',
    'val' => ''
  );

  $social_settings[] = array(
    'title' => 'Twitter URL',
    'desc' => 'Enter your twitter url.',
    'type' => 'text',
    'id' => 'social_url_twitter',
    'val' => ''
  );

  $social_settings[] = array(
    'title' => 'Twitter User',
    'desc' => 'Enter your twitter username.',
    'type' => 'text',
    'id' => 'social_user_twitter',
    'val' => ''
  );

  $social_settings[] = array(
    'title' => 'LinkedIn URL',
    'desc' => 'Enter your linkedin group url.',
    'type' => 'text',
    'id' => 'social_url_linkedin',
    'val' => ''
  );

  $social_settings[] = array(
    'title' => 'RSS Feed URL',
    'desc' => 'Enter your blog feed URL',
    'type' => 'text',
    'id' => 'social_url_feed',
    'val' => get_bloginfo('rss_url')
  );

  $social_settings[] = array(
    'title' => 'Facebook URL 2',
    'desc' => 'Enter your facebook page/profile username 2',
    'type' => 'text',
    'id' => 'social_url_facebook2',
    'val' => ''
  );

  $social_settings[] = array(
    'title' => 'Twitter URL 2',
    'desc' => 'Enter your twitter url 2.',
    'type' => 'text',
    'id' => 'social_url_twitter2',
    'val' => ''
  );

  $social_settings[] = array(
    'title' => 'Twitter User 2',
    'desc' => 'Enter your twitter username 2.',
    'type' => 'text',
    'id' => 'social_user_twitter2',
    'val' => ''
  );

  $social_settings[] = array(
    'title' => 'LinkedIn URL 2',
    'desc' => 'Enter your linkedin group url 2.',
    'type' => 'text',
    'id' => 'social_url_linkedin2',
    'val' => ''
  );

  $social_settings[] = array(
    'title' => 'RSS Feed URL 2',
    'desc' => 'Enter your blog feed URL 2',
    'type' => 'text',
    'id' => 'social_url_feed2',
    'val' => get_bloginfo('rss_url')
  );

  $social_settings[] = array(
    'title' => 'Forrst URL',
    'type' => 'text',
    'id' => 'social_url_forrst',
    'desc' => 'Enter your forrst username'
  );

  $social_settings[] = array(
    'title' => 'Dribbble URL',
    'type' => 'text',
    'id' => 'social_url_dribbble',
    'desc' => 'Enter your dribbble username'
  );

  stag_add_framework_page( 'Social Settings', $social_settings, 15 );
}

