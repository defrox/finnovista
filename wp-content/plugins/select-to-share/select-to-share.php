<?php
/*
Plugin Name: Select to Share
Description: Display a nice pop-over menu with sharing buttons for Facebook, Twitter, LinkedIN and e-mail over selected text in your post.
Version: 1.0.1
Author: Sibin Grasic
Author URI: http://sgi.io
*/

/**
 * 
 * @package SGI\SSR
 */

/* Prevent Direct access */
if ( !defined( 'DB_NAME' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	die;
}

/*Define plugin main file*/
if ( !defined('SGI_SSR_FILE') )
	define ( 'SGI_SSR_FILE', __FILE__ );

/* Define BaseName */
if ( !defined('SGI_SSR_BASENAME') )
	define ('SGI_SSR_BASENAME',plugin_basename(SGI_SSR_FILE));

/* Define internal path */
if ( !defined( 'SGI_SSR_PATH' ) )
	define( 'SGI_SSR_PATH', plugin_dir_path( SGI_SSR_FILE ) );

/* Define internal version for possible update changes */
define ('SGI_SSR_VERSION', '1.0.1');

/* Load Up the text domain */
function sgi_ssr_load_textdomain()
{
	load_plugin_textdomain('sgissr', false, basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action('wp_loaded','sgi_ssr_load_textdomain');

/* Check if we're running compatible software */
if ( version_compare( PHP_VERSION, '5.2', '<' ) && version_compare(WP_VERSION, '3.8', '<') ) :
	if (is_admin()) :
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		deactivate_plugins( __FILE__ );
		wp_die(__('Select to Share plugin requires WordPress 3.8 and PHP 5.3 or greater. The plugin has now disabled itself','sgidpw'));
	endif;
endif;

/* Let's load up our plugin */

function sgi_ssr_backend_init()
{
	require_once (SGI_SSR_PATH.'lib/ssr-backend.php');
	new SGI_SSR_Backend();
}

function sgi_ssr_frontend_init()
{
	require_once (SGI_SSR_PATH.'lib/ssr-frontend.php');
	new SGI_SSR_Frontend();
}


if (is_admin()) : 
	add_action('plugins_loaded','sgi_ssr_backend_init');
else :
	add_action('init','sgi_ssr_frontend_init',20);
endif;