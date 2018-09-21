<?php
add_action('admin_init', 'stag_homepage_settings');
function stag_homepage_settings(){

  $homepage_settings['description'] = __('Configure your homepage settings.', 'stag');

  $homepage_settings[] = array(
    'title' => 'Portfolio Count',
    'desc' => 'Count of portfolio items to show on homepage work section slider.',
    'type' => 'text',
    'id' => 'homepage_portfolio_count',
    'val' => 5
  );

  $homepage_settings[] = array(
    'title' => 'Footer Copyright Information',
    'desc' => 'Type the text to show in footer copyright information.',
    'type' => 'wysiwyg',
    'id' => 'homepage_footer_info',
    'val' => '<strong>Copyright</strong> &copy;  '. date( 'Y' ) .' <a href="'. home_url() .'">'. get_bloginfo( 'name' ) .'</a>'
  );


  stag_add_framework_page( 'Homepage Settings', $homepage_settings, 14 );
}