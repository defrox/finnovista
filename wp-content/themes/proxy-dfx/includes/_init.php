<?php
/*--------------------------------------------------*/
/* Include Theme Options
/*--------------------------------------------------*/
require_once('options/general-settings.php');
require_once('options/styling-options.php');
require_once('options/social-settings.php');
require_once('options/homepage-settings.php');

/*--------------------------------------------------*/
/* Include Widgets
/*--------------------------------------------------*/
require_once('widgets/widget-about.php');
require_once('widgets/widget-blog.php');
require_once('widgets/widget-contact.php');
require_once('widgets/widget-flickr.php');
require_once('widgets/widget-other.php');
require_once('widgets/widget-services.php');
require_once('widgets/widget-slider.php');
require_once('widgets/widget-service-box.php');
require_once('widgets/widget-team.php');
require_once('widgets/widget-twitter.php');
require_once('widgets/widget-work.php');

/*--------------------------------------------------*/
/* Include Custom Post Types
/*--------------------------------------------------*/
require_once('post-types/cpt-portfolio.php');
require_once('post-types/cpt-slider.php');
require_once('post-types/cpt-team.php');

/*--------------------------------------------------*/
/* Include Meta Boxes
/*--------------------------------------------------*/
require_once('metaboxes/portfolio.php');
require_once('metaboxes/post-metabox.php');
if(stag_get_option('general_disable_seo_settings') == 'off'){
  require_once('metaboxes/seo.php');
}
require_once('metaboxes/slider-metabox.php');
require_once('metaboxes/team-metabox.php');


require_once('theme-shortcodes.php');
