<?php

/**
 * 
 * @package SGI\SSR
 */

/**
 * 
 * Main plugin class
 * 
 * This class loads plugin options, enqueues scripts and loads up the selection sharer
 * 
 * @subpackage Frontend interfaces
 * @author Sibin Grasic
 * @since 1.0
 * @var opts - plugin options
 */
class SGI_SSR_Frontend
{

	private $opts;

	/**
	 * Class Constructor
	 * 
	 * Loads default options (if none are saved) and enqueues our scripts
	 * @author Sibin Grasic
	 * @since 1.0
	 */
	public function __construct()
	{
		$ssr_opts = get_option('sgi_ssr_opts',
			array(
				'selector' => 'p',
				'active'   => array(
					'post' => true,
					'page' => true,
				)
		));

		$this->opts = $ssr_opts;

		add_action('wp_enqueue_scripts',array(&$this,'load_scripts'),75);
	}

	/**
	 * Load our scripts when needed.
	 * 
	 * Since we only need selection share on single posts, we're checking if we're viewing single post or page
	 *
	 * @author Sibin Grasic
	 * @since 1.0
	 */
	public function load_scripts()
	{
		if (is_single() || is_page() && !is_front_page()) : 

			wp_register_style( 'sgi-select-to-share', plugins_url('assets/css/select-to-share.css',SGI_SSR_BASENAME), null, SGI_SSR_VERSION );
			wp_enqueue_style( 'sgi-select-to-share' );

			wp_register_script( 'sgi-select-to-share', plugins_url( "assets/js/select-to-share.js", SGI_SSR_BASENAME ), false, SGI_SSR_VERSION, true);
			wp_enqueue_script('sgi-select-to-share');

			add_action ('wp_footer',array (&$this,'footer_activation'),90);

		endif;
	}

	/**
	 * Add script activator to footer
	 * 
	 * Adds a small inline script to the bottom of the footer which targets our custom selector set in WP-admin
	 * 
	 * @author Sibin Grasic
	 * @since 1.0
	 */
	public function footer_activation()
	{
		$selector = $this->opts['selector'];

		echo 
		"
		<script type=\"text/javascript\">
		jQuery(window).load(function(){
			jQuery('${selector}').selectionSharer();
		});
		</script>
		";
	}
}