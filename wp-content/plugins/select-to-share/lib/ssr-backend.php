<?php

/**
 * 
 * @package SGI\SSR
 */

/**
 * 
 * Main class for WP-Admin hooks
 * 
 * This class loads all of our backend hooks and sets up our admin interfaces
 * 
 * @subpackage Admin Interfaces
 * @author Sibin Grasic
 * @since 1.0
 * @var version - plugin version
 * @var opts - plugin opts
 */
class SGI_SSR_Backend
{

	private $version;
	private $opts;

	/**
	 * Sgi SSR Admin constructor
	 * 
	 * Constructor first checks for the plugin version. If this is the first activation, plugin adds version info to the DB with autoload option set to false.
	 * In that manner we can easily change plugin options and defaults accross versions, and preserve compatibility
	 * @return void
	 */
	public function __construct()
	{

		if ( $ssr_ver = get_option('sgi_ssr_ver') ) :
			$this->version = $ssr_ver;
		else :
			$ssr_ver = SGI_SSR_VERSION;
			add_option('sgi_ssr_ver',$ssr_ver,'','no');
		endif;

		$ssr_opts = get_option('sgi_ssr_opts',
			array(
				'selector' => 'p',
				'active'   => array(
					'post' => true,
					'page' => true,
				)
		));

		$this->opts = $ssr_opts;

		add_action('admin_init', array(&$this,'register_settings'));
		add_filter('plugin_action_links_'.SGI_SSR_BASENAME, array(&$this,'add_settings_link'));
	}

	/**
	 * Function that adds settings link to the plugin page
	 * @param array $links 
	 * @return array - merged array with our links
	 * @author Sibin Grasic
	 * @since 1.0
	 */
	public function add_settings_link($links)
	{
		$admin_url = admin_url();
		$link = array("<a href=\"${admin_url}options-reading.php#sgi-sel-share\">Settings</a>");

		return array_merge($links,$link);
	}

	/**
	 * Function that is hooked into the admin initialisation and registers settings
	 * @return void
	 * @author Sibin Grasic
	 * @since 1.0
	 */
	public function register_settings()
	{
		add_settings_section('sgi_ssr_opts','Select to Share options',array(&$this, 'settings_section_info'), 'reading');

		add_settings_field('sgi_ssr_opts[selector]', __('CSS selector for script','sgissr'), array(&$this,'selector_callback'), 'reading', 'sgi_ssr_opts', $this->opts['selector']);

		register_setting('reading','sgi_ssr_opts',array(&$this,'sanitize_opts'));

	}

	/**
	 * Function that displays the section heading information
	 * @author Sibin Grasic
	 * @since 1.0
	 */
	public function settings_section_info()
	{
		echo '<div id="sgi-sel-share"></div><p>'.__('These are the settings for the Select to Share script','sgissr').'</p>';
	}

	/**
	 * Function that displays the input box for the CSS selestor
	 * @param string $selector 
	 * @return void
	 * @author Sibin Grasic
	 * @since 1.0
	 */
	public function selector_callback($selector)
	{
		echo "<input type=\"text\" name=\"sgi_ssr_opts[selector]\" value=\"${selector}\">".'<br>';
		echo "<small>".__('Default selector is p, if you\'re having compatibility issues, change the CSS selector','sgissr').'</small>';
	}

	/**
	 * Function that "sanitizes options"
	 * 
	 * @param array $opts
	 * @return array options array
	 * @author Sibin Grasic
	 * @since 1.0
	 * 
	 */
	public function sanitize_opts($opts)
	{
		return $opts;
	}
}