<?php
/*
Plugin Name: Mega Slider
Plugin URI: http://wpprime.com
Description: Drag and drop to create your custom slider.
Version: 1.7
Author: Mega Drupal
Author URI: http://megadrupal.com
License: 
*/

if (!defined('MS_URL')) {
	define('MS_URL', plugin_dir_url(__FILE__));
}
if (!defined('MS_PATH')) {
	define('MS_PATH', plugin_dir_path(__FILE__));
}
if (!defined('MS_ADMIN_URL')) {
	define('MS_ADMIN_URL', MS_URL . 'admin');
}
if (!defined('MS_FRONT_URL')) {
	define('MS_FRONT_URL', MS_URL . 'front-end');
}
if (!defined('MS_DEBUG')) {
	// Load minify scripts for higher speed loading scripts. Change to 'true' to enable develop mode.
	define('MS_DEBUG', true);
}

// Implicitly prevent the plugin's installation from collision
if (!class_exists('MegaSlider')) {
	class MegaSlider {
		public $slug;
		public $remote_path = "http://update.wpprime.com/index.php";
		public $LicenseName = "mega_slider_license";
		public function __construct() {
			list ($t1, $t2) = explode('/', plugin_basename(__FILE__));
			$this->slug = str_replace('.php', '', $t2);
			// Load languages files(s)
			add_action('init', array($this, 'load_languages'));
			// Register 'slider' post type
			add_action('init', array($this, 'add_slider_type'));
			add_action('admin_menu', array($this, 'license_sub_menu'));

			// Add Slider admin
			add_action('add_meta_boxes', array($this, 'add_mega_admin'));
			// Add help tabs
			add_action('load-post-new.php', array($this, 'add_helper'));
			// Add help tabs
			add_action('load-post.php', array($this, 'add_helper'));
			add_action('admin_head', array($this, 'add_mega_fonts'));
			// Enqueue scripts for Slider admin
			add_action('admin_enqueue_scripts', array($this, 'load_scripts'));
			add_action('edit_form_after_title', array($this, 'publish_panel'));
			add_action('edit_form_after_title', array($this, 'preview_panel'));
			add_action('edit_form_after_title', array($this, 'settings_panel'));
			add_action('save_post', array($this, 'save_data'), 10, 2);

			add_action('init', array($this,'auto_check_update'));
			add_action('wp_enqueue_scripts', array($this, 'load_front_scripts'));
			add_action('wp_ajax_mega_get_bg', array($this, 'get_background_image'));
			add_action('wp_ajax_mega_resize_bg', array($this, 'resize_background_image'));
			add_action('wp_ajax_mega_delete_bg', array($this, 'delete_background_image'));

			add_filter('screen_layout_columns', array($this, 'set_columns'));
			add_filter('get_user_option_screen_layout_mega-slider', array($this, 'force_user_column'));
			add_filter('post_updated_messages', array($this, 'mega_slider_messages'));
			add_filter('widget_text', 'do_shortcode');
			add_filter('the_content', array($this, 'default_slider_content'));

		}

		/*
		 * License
		 *
		 */
		public function license_sub_menu() {
			add_submenu_page('edit.php?post_type=mega-slider', 'License', 'License Settings', 'manage_options', 'mega-slider-license', array($this, 'license_page'));
		}

		public function license_page() {
			include("license.php");
		}

		public function get_license() {

			$default_modern_admin_license = array('license' => '', 'status' => false, 'date' => time(),);
			$modern_admin_license = get_option($this->LicenseName);
			if (!empty($modern_admin_license)) {
				foreach ($modern_admin_license as $key => $option) $default_modern_admin_license[$key] = $option;
			}
			update_option($this->LicenseName, $default_modern_admin_license);
			return $default_modern_admin_license;
		}

		public function admin_notice() {
			?>
			<div class="updated">
				<p><?php _e($this->string_notice, 'mega-slider'); ?></p>
			</div>
		<?php
		}

		public function modern_admin_license_page() {
			include_once('includes/license.php');
		}

		public function auto_check_update() {
			if (is_admin()) {
				require_once('wp_autoupdate.php');
				$license = $this->get_license();
				if (!empty($license['license'])) {
					if (!function_exists('get_plugin_data')) require_once(ABSPATH . 'wp-admin/includes/plugin.php');
					$current_plugin = get_plugin_data(__FILE__, $markup = true, $translate = true);
					$current_version = $current_plugin['Version'];
					$plugin_slug = plugin_basename(__FILE__);
					new mega_slider_auto_update ($license['license'], $current_version, $this->remote_path, $plugin_slug);
				}
			}
		}

		// Load language file(s) (.mo)
		public function load_languages() {
			load_plugin_textdomain('mega-slider', false, dirname(plugin_basename(__FILE__)) . '/languages');
		}

		public function load_scripts( $hook ) {
			$screen = get_current_screen();
			$dot = ( MS_DEBUG ) ? '.' : '.min.';

			if ( is_admin() && $screen->post_type === "mega-slider" && $screen->base === "post" ) { 

				wp_enqueue_style( 'mega-admin', MS_ADMIN_URL . '/css/md-slider-admin' . $dot . 'css' );
				wp_enqueue_style( 'mega-style', MS_ADMIN_URL . '/css/md-slider-style.css' );

				// Replace current color picker by Iris color picker in next update 
				//wp_enqueue_script( 'wp-color-picker' );

				if ( function_exists( 'wp_enqueue_media' ) ) {
					wp_enqueue_media();
				}

				wp_enqueue_script( 'media-upload' ); 
				
				wp_enqueue_script( 'jquery-ui-dialog' );
				wp_enqueue_script( 'color-picker', MS_ADMIN_URL . '/js/colorpicker/js/colorpicker' . $dot . 'js' );
				wp_enqueue_style( 'color-picker', MS_ADMIN_URL . '/js/colorpicker/css/colorpicker' . $dot . 'css' );
				wp_enqueue_script( 'jquery-ui-tabs' );
				wp_enqueue_script( 'jquery-ui-resizable' );

				wp_enqueue_style( 'mega-slider-css', MS_ADMIN_URL . '/preview/css/md-slider.css' );
				wp_enqueue_script( 'mega-slider-min', MS_ADMIN_URL . '/preview/js/md-slider-min.js' );
				wp_enqueue_script( 'mega-slider-lib', MS_ADMIN_URL . '/js/md-slider-lib' . $dot . 'js' );
				wp_enqueue_script( 'mega-slider-panel', MS_ADMIN_URL . '/js/md-slider-panel' . $dot . 'js' );
				wp_enqueue_script( 'mega-slider-timeline', MS_ADMIN_URL . '/js/md-slider-timeline' . $dot . 'js' );
				wp_enqueue_script( 'mega-slider-toolbar', MS_ADMIN_URL . '/js/md-slider-toolbar' . $dot . 'js' );
				wp_enqueue_script( 'mega-slider', MS_ADMIN_URL . '/js/md-slider' . $dot . 'js' );
			}
		}

		public function load_front_scripts() {
			$dot = ( MS_DEBUG ) ? '.' : '.min.';
			wp_enqueue_style( 'mega-animate', MS_FRONT_URL . '/css/animate' . $dot . 'css' );
			wp_enqueue_style( 'mega-style', MS_FRONT_URL . '/css/style' . $dot . 'css' );
			wp_enqueue_style( 'mega-slider-style', MS_ADMIN_URL . '/css/md-slider-style.css' );
			
			wp_enqueue_script( 'jquery-touchwipe', MS_FRONT_URL . '/js/jquery.touchwipe' . $dot . 'js', array( 'jquery' ) );
			wp_enqueue_script( 'jquery-easing', MS_FRONT_URL . '/js/jquery.easing.js', array( 'jquery' ) );
			wp_enqueue_script( 'mega-modernizr', MS_FRONT_URL . '/js/modernizr.custom.js', array( 'jquery' ) );
            wp_enqueue_script('mega-queryloader2', MS_FRONT_URL . '/js/jquery.queryloader2.js', array('jquery'));
			wp_enqueue_script( 'mega-slider', MS_FRONT_URL . '/js/md-slider' . $dot . 'js', array( 'jquery' ) );
		}

		public function set_columns($columns) {
			$columns['mega-slider'] = 1;
			return $columns;
		}

		public function force_user_column($columns) {
			return 1;
		}

		public function mega_slider_messages($messages) {
			global $post, $post_ID;
			$messages['mega-slider'][6] = __('Slider created', 'mega-slider') . sprintf(' <a href="%s">' . __('View Slider', 'mega-slider') . '</a>', esc_url(get_permalink($post_ID)));
			return $messages;
		}

		public function default_slider_content($content) {
			global $post;
			if ($post->post_type === 'mega-slider') return sprintf('[mega-slider id="%s"/]', $post->ID);
			return $content;
		}

		public function add_mega_fonts() {
			global $post;
			if (!$post) return;
			$screen = get_current_screen();
			if ($screen->post_type === 'mega-slider') {
				$settings = get_post_meta($post->ID, 'md-slider-settings', true);
				if (!$settings || !$settings['googlefonts']) return;
				printf('<link rel="stylesheet" href="%s">', esc_attr($settings['googlefonts']));
			}
		}

		public function get_background_image() {
			if (!isset($_POST['id']) || !isset($_POST['width']) || !isset($_POST['height'])) die();

			$id = $_POST['id'];
			$oldId = $_POST['oldId'];
			$width = $_POST['width'];
			$oldWidth = $_POST['oldWidth'];
			$height = $_POST['height'];
			$oldHeight = $_POST['oldHeight'];

			// Delete previously image
			if (($oldId != -1) && file_exists(megaSlider_get_image($oldId, $oldWidth, $oldHeight, true))) megaSlider_delete_image($oldId, $oldWidth, $oldHeight, true);

			if (file_exists(megaSlider_get_image($id, $width, $height, true))) die();
			die(megaSlider_create_image($id, $width, $height, true));
		}

		public function resize_background_image() {
			if (!isset($_POST['fid']) || !isset($_POST['crop']) || !isset($_POST['width']) || !isset($_POST['height']) || !isset($_POST['oldWidth']) || !isset($_POST['oldHeight'])
			) die();

			$fid = $_POST['fid'];
			$crop = $_POST['crop'];
			$width = $_POST['width'];
			$height = $_POST['height'];
			$oldWidth = $_POST['oldWidth'];
			$oldHeight = $_POST['oldHeight'];

			$urls = array();

			foreach ($fid as $id) {
				megaSlider_delete_image($id, $oldWidth, $oldHeight, true);
				$urls[] = megaSlider_create_image($id, $width, $height, true);
			}

			if (count($urls)) {
				die(json_encode($urls));
			}
		}

		public function delete_background_image() {
			if (!isset($_POST['fid']) || !isset($_POST['width']) || !isset($_POST['height'])) die();
			$fid = $_POST['fid'];
			$width = $_POST['width'];
			$height = $_POST['height'];

			$fids = array();
			foreach ($fid as $id) {
				megaSlider_delete_image($id, $width, $height, true);
				$fids[] = wp_get_attachment_url($id);
			}
			die(json_encode($fids));
		}

		public function save_data($post_id) {

			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;


			if (get_post_type($post_id) !== 'mega-slider' || !isset($_POST['publish'])) return;

			if (!isset($_POST['mega-slider']) || !wp_verify_nonce($_POST['mega-slider'], 'mega-save-settings')) wp_die("Something goes wrong!");


			if (!isset($_POST['post_type']) || 'mega-slider' !== $_POST['post_type']) return;

			// Saving sliders's data.
			$sliders = sanitize_text_field($_POST['md-slider-data']);
			update_post_meta($post_id, 'md-slider-data', $sliders);

			// Saving sliders's general settings.

			$defaults = array('fullwidth' => 0, 'imgslide' => 1, 'transitionsSpeed' => 1000, 'width' => 990, 'height' => 420, 'responsive' => 1, 'loop' => 0, 'styleBorder' => 1, 'styleShadow' => 1, 'slideShowDelay' => 8000, 'autoPlay' => 1, 'showLoading' => 1, 'loadingPosition' => 'bottom', 'showArrow' => 1, 'showArrowTouch' => 0, 'playButton' => 1, 'showBullet' => 0, 'posBullet' => 0, 'showThumb' => 1, 'widthThumb' => 100, 'heightThumb' => 80, 'posThumb' => 1, 'enableDrag' => 1, 'googlefonts' => '');

			$settings = $_POST['md-settings'];
			$noncheckbox = array_diff_key($defaults, $settings);
			foreach ($noncheckbox as $i => $v) {
				$noncheckbox[$i] = 0;
			}
			$settings = array_merge($settings, $noncheckbox);

			update_post_meta($post_id, 'md-slider-settings', $settings);

			if (isset($_POST['mega-old'])) {
				$old = $_POST['mega-old'];
				$old = json_decode(str_replace('\\', '', $old), true);

				// Delete previous thumbnail images
				foreach ($old['thumb'] as $id) {
					megaSlider_delete_image($id, $old['widthThumb'], $old['heightThumb'], true);
				}

				// Delete previous background images
				foreach ($old['fid'] as $id) {
					megaSlider_delete_image($id, $old['width'], $old['height'], $old['crop']);
				}
			}
		}

		public function add_slider_type() {
			$labels = array('name' => 'MegaSlider', 'singular_name' => 'MegaSlider', 'add_new' => __('Add New Slider', 'mega-slider'), 'add_new_item' => __('Add New Slider', 'mega-slider'), 'edit_item' => __('Edit Slider', 'mega-slider'), 'new_item' => __('New Slider', 'mega-slider'), 'all_items' => __('All Sliders', 'mega-slider'), 'view_item' => __('View Slider', 'mega-slider'), 'search_items' => __('Search Sliders', 'mega-slider'), 'not_found' => __('No sliders found', 'mega-slider'), 'not_found_in_trash' => __('No sliders found in Trash', 'mega-slider'), 'parent_item_colon' => '', 'menu_name' => 'MegaSlider');

			$args = array('labels' => $labels, 'public' => true, 'publicly_queryable' => true, 'show_ui' => true, 'show_in_menu' => true, 'query_var' => true, 'rewrite' => array('slug' => 'mega-slider'), 'capability_type' => 'post', 'has_archive' => true, 'hierarchical' => false, 'menu_position' => 7, 'supports' => array('title'), 'menu_icon' => MS_ADMIN_URL . '/images/icon.png');

			register_post_type('mega-slider', $args);
		}

		public function add_mega_admin() {
			remove_meta_box('submitdiv', 'mega-slider', 'side');
		}

		public function settings_panel() {
			global $post;
			$screen = get_current_screen();

			if ($screen->post_type !== 'mega-slider') return;

			$step_one = false;
			$settings = get_post_meta($post->ID, 'md-slider-settings', true);

			$defaults = array('fullwidth' => 0, 'imgslide' => 1, 'transitionsSpeed' => 1000, 'width' => 990, 'height' => 420, 'responsive' => 1, 'loop' => 0, 'styleBorder' => 1, 'styleShadow' => 1, 'slideShowDelay' => 8000, 'autoPlay' => 1, 'showLoading' => 1, 'loadingPosition' => 'bottom', 'showArrow' => 1, 'showArrowTouch' => 0, 'playButton' => 1, 'showBullet' => 0, 'posBullet' => 0, 'showThumb' => 1, 'widthThumb' => 100, 'heightThumb' => 80, 'posThumb' => 1, 'enableDrag' => 1, 'googlefonts' => '');

			if (!$settings) {
				$step_one = true;
				$settings = $defaults;
			} else {
				$settings = array_merge($defaults, $settings);
			}
			?>
			<h2><?php _e('General Settings', 'mega-slider'); ?></h2>
			<div id="mega-slider-settings" class="postbox">
				<div class="mega-settings">
					<div class="md-settings-fullwidth">
						<input type="checkbox" <?php checked($settings['fullwidth'], 1); ?>name="md-settings[fullwidth]"
						       id="md-settings-fullwidth" value="1">
						<label for="md-settings-fullwidth"><?php _e('Fullwidth', 'mega-slider'); ?></label>
					</div>

					<div class="md-settings-width">
						<label for="md-settings-width" class="title"><?php _e('Width', 'mega-slider'); ?></label>
						<input type="text" value="<?php echo esc_attr($settings['width']); ?>" name="md-settings[width]"
						       id="md-settings-width"/> px
					</div>

					<div class="md-settings-height">
						<label for="md-settings-height" class="title"><?php _e('Height', 'mega-slider'); ?></label>
						<input type="text" value="<?php echo esc_attr($settings['height']); ?>"
						       name="md-settings[height]" id="md-settings-height"/> px
					</div>

					<div class="md-settings-bgstyle">
						<input type="checkbox" <?php checked($settings['imgslide']); ?> name="md-settings[imgslide]"
						       id="md-settings-bgstyle" value="1"/>
						<label for="md-settings-bgstyle"> <?php _e('Auto crop image', 'mega-slider'); ?></label>
					</div>

					<div class="md-settings-enableDrag">
						<input type="checkbox" <?php checked($settings['enableDrag']); ?> name="md-settings[enableDrag]"
						       id="md-settings-enableDrag" value="1"/>
						<label for="md-settings-enableDrag"><?php _e('Enable touch swipe', 'mega-slider'); ?></label>
						</label>
					</div>

					<div class="md-settings-responsive">
						<input type="checkbox" <?php checked($settings['responsive']); ?> name="md-settings[responsive]"
						       id="md-settings-responsive" value="1"/>
						<label for="md-settings-responsive"> <?php _e('Enable responsive', 'mega-slider'); ?></label>
					</div>

					<div class="md-settings-loop">
						<input type="checkbox" <?php checked($settings['loop']); ?> name="md-settings[loop]"
						       id="md-settings-loop" value="1"/>
						<label for="md-settings-loop"> <?php _e('Loop', 'mega-slider'); ?></label>
					</div>

					<div class="md-settings-showLoading">
						<label class="title"><?php _e('Loading bar', 'mega-slider'); ?></label>
						<input id="md-settings-showLoading_bar"
						       type="radio" <?php checked($settings['showLoading'], 1); ?>
						       name="md-settings[showLoading]" value="1">
						<label for="md-settings-showLoading_bar">Bar</label>
						<input id="md-settings-showLoading_none"
						       type="radio" <?php checked($settings['showLoading'], 0); ?>
						       name="md-settings[showLoading]" value="0">
						<label for="md-settings-showLoading_none">None</label>
					</div>

					<div class="md-settings-loadingPosition md-settings-sub-showLoading"
					     style="display:<?php echo ($settings['showLoading']) ? 'block' : 'none'; ?>">
						<span class="title"><?php _e('Bar position', 'mega-slider'); ?>: </span>
						<select name="md-settings[loadingPosition]" id="md-settings-loadingPosition">
							<option <?php selected($settings['loadingPosition'], 'top'); ?> value="top">Top</option>
							<option <?php selected($settings['loadingPosition'], 'bottom'); ?> value="bottom">Bottom
							</option>
						</select>
					</div>

					<h4><?php _e('Navigation', 'mega-slider'); ?></h4>

					<div class="md-settings-prevnextbtn">
						<input type="checkbox" <?php checked($settings['showArrow'], "1"); ?>
						       name="md-settings[showArrow]" id="md-settings-prevnextbtn" value="1"/>
						<label
							for="md-settings-prevnextbtn"> <?php _e('Show next previous button', 'mega-slider'); ?></label>
					</div>

					<div class="md-settings-prevnextbtntouch">
						<input type="checkbox" <?php checked($settings['showArrowTouch'], "1"); ?>
						       name="md-settings[showArrowTouch]" id="md-settings-prevnextbtntouch" value="1"/>
						<label
							for="md-settings-prevnextbtntouch"> <?php _e('Show next previous button for touch devices', 'mega-slider'); ?></label>
					</div>

					<div class="md-settings-autoPlay">
						<input type="checkbox" <?php checked($settings['autoPlay']); ?> name="md-settings[autoPlay]"
						       id="md-settings-autoPlay" value="1"/>
						<label for="md-settings-autoPlay"><?php _e('Auto play slides', 'mega-slider'); ?></label>
					</div>

					<div class="md-settings-showBullet">
						<input type="checkbox" <?php checked($settings['showBullet']); ?> name="md-settings[showBullet]"
						       id="md-settings-showBullet" value="1"/>
						<label for="md-settings-showBullet"><?php _e('Show bullet', 'mega-slider'); ?></label>
					</div>

					<div class="md-settings-posBullet md-settings-sub-showBullet"
					     style="display: <?php echo ($settings['showBullet']) ? 'block' : 'none'; ?>">
						<label class="title"
						       for="md-settings-posBullet"><?php _e('Bullet position', 'mega-slider'); ?></label>
						<select name="md-settings[posBullet]" id="md-settings-posBullet">
							<option <?php selected($settings['posBullet'], 1); ?> value="1">Bottom left</option>
							<option <?php selected($settings['posBullet'], 2); ?> value="2">Bottom center</option>
							<option <?php selected($settings['posBullet'], 3); ?> value="3">Bottom right</option>
							<option <?php selected($settings['posBullet'], 4); ?> value="4">Top left</option>
							<option <?php selected($settings['posBullet'], 5); ?> value="5">Top center</option>
							<option <?php selected($settings['posBullet'], 6); ?> value="6">Top right</option>
						</select>
					</div>

					<div class="md-settings-showThumb">
						<input type="checkbox" <?php checked($settings['showThumb']); ?> name="md-settings[showThumb]"
						       id="md-settings-showThumb" value="1"/>
						<label for="md-settings-showThumb"><?php _e('Show thumbnail', 'mega-slider'); ?></label>
					</div>

					<div class="md-settings-sub-showThumb md-settings-widthThumb"
					     style="display: <?php echo ($settings['showThumb']) ? 'block' : 'none'; ?>">
						<label for="md-settings-widthThumb"
						       class="title"><?php _e('Thumbnail width', 'mega-slider'); ?></label>
						<input type="text" value="<?php echo esc_attr($settings['widthThumb']); ?>"
						       name="md-settings[widthThumb]" id="md-settings-widthThumb"/><span> px</span>
						<input type="hidden" value="<?php echo esc_attr($settings['widthThumb']); ?>"
						       name="md-settings[widthThumbOld]"/>
					</div>

					<div class="md-settings-sub-showThumb md-settings-heightThumb"
					     style="display: <?php echo ($settings['showThumb']) ? 'block' : 'none'; ?>">
						<label for="md-settings-heightThumb"
						       class="title"><?php _e('Thumbail height', 'mega-slider'); ?></label>
						<input type="text" value="<?php echo esc_attr($settings['heightThumb']); ?>"
						       name="md-settings[heightThumb]" id="md-settings-heightThumb"/><span> px</span>
						<input type="hidden" value="<?php echo esc_attr($settings['heightThumb']); ?>"
						       name="md-settings[heightThumbOld]"/>
					</div>

					<div class="md-settings-sub-showThumb md-settings-posThumb"
					     style="display: <?php echo ($settings['showThumb'] && !$settings['showBullet']) ? 'block' : 'none'; ?>">
						<label class="title"
						       for="md-settings-posThumb"><?php _e('Thumbnail position', 'mega-slider'); ?></label>
						<select name="md-settings[posThumb]" id="md-settings-posThumb">
							<option <?php selected($settings['posThumb'], 1); ?> value="1">Center 1</option>
							<option <?php selected($settings['posThumb'], 2); ?> value="2">Center 2</option>
							<option <?php selected($settings['posThumb'], 3); ?> value="3">Left</option>
							<option <?php selected($settings['posThumb'], 4); ?> value="4">Right</option>
							<option <?php selected($settings['posThumb'], 5); ?> value="5">Full</option>
						</select>
					</div>

					<div class="md-settings-styleBorder">
						<label class="title"
						       for="md-settings-styleBorder"><?php _e('Border style', 'mega-slider'); ?></label>
						<select name="md-settings[styleBorder]" id="md-settings-styleBorder">
							<option <?php selected($settings['styleBorder'], 0); ?> value="0">None</option>
							<option <?php selected($settings['styleBorder'], 1); ?> value="1">Style 1</option>
							<option <?php selected($settings['styleBorder'], 2); ?> value="2">Style 2</option>
							<option <?php selected($settings['styleBorder'], 3); ?> value="3">Style 3</option>
							<option <?php selected($settings['styleBorder'], 4); ?> value="4">Style 4</option>
							<option <?php selected($settings['styleBorder'], 5); ?> value="5">Style 5</option>
							<option <?php selected($settings['styleBorder'], 6); ?> value="6">Style 6</option>
							<option <?php selected($settings['styleBorder'], 7); ?> value="7">Style 7</option>
							<option <?php selected($settings['styleBorder'], 8); ?> value="8">Style 8</option>
							<option <?php selected($settings['styleBorder'], 9); ?> value="9">Style 9</option>
						</select>
					</div>

					<div class="md-settings-slideShowDelay">
						<label for="md-settings-slideShowDelay"
						       class="title"><?php _e('Slide delay', 'mega-slider'); ?></label>
						<input type="text" name="md-settings[slideShowDelay]" id="md-settings-slideShowDelay"
						       value="<?php echo esc_attr($settings['slideShowDelay']); ?>"/><span> milliseconds</span>
					</div>

					<div class="md-settings-transitionsSpeed">
						<label for="md-settings-transitionsSpeed"
						       class="title"><?php _e("Slide's translation time", 'mega-slider'); ?></label>
						<input type="text" name="md-settings[transitionsSpeed]" id="md-settings-transitionsSpeed"
						       value="<?php echo esc_attr($settings['transitionsSpeed']); ?>"/><span> milliseconds</span>
					</div>

					<div class="md-settings-googlefonts">
						<label for="md-settings-googlefonts" class="title">Google Web Fonts</label>
						<textarea name="md-settings[googlefonts]" id="md-settings-googlefonts" class="code" cols="80"
						          rows="5"><?php echo esc_textarea($settings['googlefonts']); ?></textarea>
						<ul class="gg-steps">
							<li>Go to <a href="http://www.google.com/webfonts"
							             target="_blank">www.google.com/webfonts</a>, choose your fonts and add to
								collection
							</li>
							<li>Click &quot;Use&quot; in the bottom bar after choose fonts</li>
							<li>Find &quot;Add this code to your website&quot;, copy from <strong>http://</strong> to
								the nearest <strong>'</strong> and paste it below to activate.
							</li>
						</ul>
					</div>

					<div class="submitbox" id="submitpost">
						<div id="delete-action">
							<a class="button button-primary button-large delete"
							   href="<?php echo get_delete_post_link($post->ID); ?>"><?php _e('Move to Trash', 'mega-slider') ?></a>
						</div>
						<div id="publishing-action">
							<span class="spinner" style="display: none;"></span>
							<input name="original_publish" type="hidden" id="original_publish" value="Publish">
							<input type="submit" name="publish" id="publish" class="button button-primary button-large"
							       value="<?php echo ($step_one) ? __('Initilize Slider', 'mega-slider') : __('Update Settings', 'mega-slider'); ?>"
							       accesskey="p">
						</div>
					</div>
					<?php wp_nonce_field("mega-save-settings", "mega-slider") ?>
					<div class="clear"></div>
				</div>
			</div><!-- #mega-slider-settings -->
		<?php
		}

		public function publish_panel() {
			global $post;
			$screen = get_current_screen();
			if ($screen->post_type !== 'mega-slider') return;

			if (!get_post_meta($post->ID, 'md-slider-settings', true)) return;

			printf('<div class="mega-publish"><p>' . __('You can use the following shortcode for displaying the newly created slider', 'mega-slider') . ':<p>');
			printf('<div>[mega-slider id="%s"/]</div>', $post->ID);
			printf('<p>' . __('Copy and paste it where you wish the slider will display', 'mega-slider') . ', ');
			printf(__('e.g. Post, Page editor, Text widget or even directly in your PHP code by using ', 'mega-slider'));
			printf('<a href="http://codex.wordpress.org/Function_Reference/do_shortcode">do_shortcode</a> ' . __('function', 'mega-slider') . '.</p></div>');
		}

		public function preview_panel() {
			global $post;

			if ($post->post_type !== 'mega-slider') return;

			$settings = get_post_meta($post->ID, 'md-slider-settings', true);

			if (!$settings) return;

			if ($settings['googlefonts']) {
				$link = parse_url($settings['googlefonts']);
				parse_str($link['query']);
				if ($family) {
					$fonts = explode("|", $family);
				}
			}

			$sliders = get_post_meta($post->ID, 'md-slider-data', true);
			$sliders = json_decode($sliders, true);
			$sliders = ($sliders) ? $sliders : array();

			// Hold current thumbnail, background attachment id in JSON
			$old = array('fid' => array(), 'thumb' => array(), 'width' => $settings['width'], 'height' => $settings['height'], 'widthThumb' => $settings['widthThumb'], 'heightThumb' => $settings['heightThumb']);
			foreach ($sliders as $i => $slider) {
				$old['fid'][] = $slider['itemsetting']['fid'];
				$old['thumb'][] = $slider['itemsetting']['thumb'];
				$old['crop'] = $settings['imgslide'];
			}
			$old = json_encode($old);

			foreach ($sliders as $i => $slider) {
				$bg_id = $slider['itemsetting']['fid'];
				$thumb_id = ($slider['itemsetting']['thumb'] !== '') ? $slider['itemsetting']['thumb'] : $bg_id;
				if (file_exists(megaSlider_get_image(get_attached_file($thumb_id), $settings['widthThumb'], $settings['heightThumb'], true))) continue;
				// Force cropping thumbnail
				megaSlider_create_image($thumb_id, $settings['widthThumb'], $settings['heightThumb'], true);

				if ($settings['fullwidth'] || file_exists(megaSlider_get_image(get_attached_file($bg_id), $settings['width'], $settings['height'], $settings['imgslide']))) continue;
				// Create background
				megaSlider_create_image($bg_id, $settings['width'], $settings['height'], $settings['imgslide']);
			}

			$style_options = include(MS_PATH . '/admin/list-styles.php');
			?>
			<div class="md-wrap" data-url="<?php echo MS_ADMIN_URL; ?>">
			<h2><?php _e('Slider Content', 'mega-slider'); ?></h2>
			<input type="hidden" id="mega-old" name="mega-old" value='<?php echo $old; ?>'/>
			<input type="submit" name="secondpublish" id="secondpublish" class="button button-primary button-large"
			       style="float: right" value="Update Settings" accesskey="p">
			<a class="button button-primary button-large" title="<?php _e('Add new tab', 'mega-slider'); ?>"
			   id="add_tab" href="#"><?php _e('ADD', 'mega-slider'); ?></a>

			<div id="md-tabs">
				<ul class="md-tabs-head clearfix">
					<?php for ($i = 1; $i <= count($sliders); $i++) : ?>
						<li class="tab-item <?php echo ($i === 0) ? "first" : ""; ?> clearfix">
							<a class="tab-link" href="#tabs-<?php echo $i; ?>"><span
									class="tab-text"><?php _e('Slide', 'mega-slider'); ?> <?php echo $i; ?></span></a>
							<span class="ui-icon ui-icon-close"><?php _e('Remove Tab', 'mega-slider'); ?></span>
						</li>
					<?php endfor; ?>
				</ul>
				<?php foreach ($sliders as $i => $tabs) :
					backward_transition_compatibility($tabs, $settings);
					$bg_id = (isset($tabs['itemsetting']['fid'])) ? $tabs['itemsetting']['fid'] : '';
					$items = $tabs['boxitems'];
					?>
					<div id="tabs-<?php echo $i + 1; ?>"
					     data-timelinewidth="<?php echo $tabs['itemsetting']['timelinewidth']; ?>"
					     class="md-tabcontent clearfix">
						<div class="settings">
							<a href="#" class="panel-settings-link">[<?php _e('Settings', 'mega-slider'); ?>]</a> &nbsp;
							<a class="panel-clone" href="#">[<?php _e('Clone slide', 'mega-slider'); ?>]</a>
							<input type="hidden" autocomplete="off" class="panelsettings"
							       value='<?php echo json_encode($tabs['itemsetting']); ?>'/>
						</div>
						<div class="md-slidewrap"
						     style="width: <?php echo esc_attr($settings['width']); ?>px;  height: <?php echo esc_attr($settings['height']); ?>px;">
							<div class="md-slide-image"
							     style="width: <?php echo esc_attr($settings['width']); ?>px;  height: <?php echo esc_attr($settings['height']); ?>px;">
								<?php if (!$settings['fullwidth'] && $settings['imgslide']) : ?>
									<img
										src="<?php echo ($bg_id === '') ? MS_ADMIN_URL . "/images/default_bg.jpg" : esc_attr(megaSlider_create_image($bg_id, $settings['width'], $settings['height'], true)); ?>"/>
								<?php else : ?>
									<img
										src="<?php echo ($bg_id === '') ? MS_ADMIN_URL . "/images/default_bg.jpg" : esc_attr(wp_get_attachment_url($bg_id)); ?>"/>
								<?php endif; ?>
							</div>
							<div class="md-objects"
							     style="width: <?php echo esc_attr($settings['width']); ?>px; height: <?php echo esc_attr($settings['height']); ?>px;">
								<?php foreach ($items as $it) :
									$datas = "";
									foreach ($it as $i => $v) {
										if (is_array($v)) $datas .= sprintf('data-%s=\'%s\'', $i, json_encode($v)); else
											$datas .= sprintf('data-%s="%s" ', $i, esc_attr($v));
									}
									?>
									<div class="slider-item ui-widget-content" <?php echo $datas; ?> style="">
										<?php if ($it['type'] == 'text') : ?>
											<div><?php echo esc_attr($it['title']); ?></div>
										<?php elseif ($it['type'] == 'image') : ?>
											<img width="100%" height="100%" alt="<?php echo esc_attr($it['title']); ?>"
											     src="<?php echo esc_attr(wp_get_attachment_url($it['fileid'])); ?>">
										<?php elseif ($it['type'] == 'video') : ?>
											<img width="100%" height="100%" alt="<?php echo esc_attr($it['title']); ?>"
											     src="<?php echo esc_attr($it['thumb']); ?>">
										<?php endif; ?>
										<span class="sl-tl"></span>
										<span class="sl-tr"></span>
										<span class="sl-bl"></span>
										<span class="sl-br"></span>
										<span class="sl-top"></span>
										<span class="sl-right"></span>
										<span class="sl-bottom"></span>
										<span class="sl-left"></span>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="md-toolbar" id="md-toolbar" disabled="true">
			<a title="<?php _e('Add new text', 'mega-slider'); ?>" class="mdt-button mdt-text" href="#"></a>
			<a title="<?php _e('Add new image', 'mega-slider'); ?>" class="mdt-button mdt-image" href="#"></a>
			<a title="<?php _e('Add new video', 'mega-slider'); ?>" class="mdt-button mdt-video" href="#"></a>

			<a title="<?php _e('Align left edge', 'mega-slider'); ?>" class="mdt-button mdt-align-left" href="#"></a>
			<a title="<?php _e('Align horizontal center', 'mega-slider'); ?>" class="mdt-button mdt-align-center"
			   href="#"></a>
			<a title="<?php _e('Align right edge', 'mega-slider'); ?>" class="mdt-button mdt-align-right" href="#"></a>
			<a title="<?php _e('Align top edge', 'mega-slider'); ?>" class="mdt-button mdt-align-top" href="#"></a>
			<a title="<?php _e('Align vertical center', 'mega-slider'); ?>" class="mdt-button mdt-align-vcenter"
			   href="#"></a>
			<a title="<?php _e('Align bottom edge', 'mega-slider'); ?>" class="mdt-button mdt-align-bottom"
			   href="#"></a>

			<a title="<?php _e('Space evenly vertically', 'mega-slider'); ?>" class="mdt-button mdt-spacev"
			   href="#"></a>
			<a title="<?php _e('Space evenly horizontally', 'mega-slider'); ?>" class="mdt-button mdt-spaceh"
			   href="#"></a>
			<input type="text" class="mdt-text mdt-spacei" value="">

			<a title="proportions" class="mdt-proportions mdt-proportions-yes" href="#"></a>
			<input type="text" class="mdt-text mdt-input mdt-width" name="width" value="" disabled="">
			<input type="text" class="mdt-text mdt-input mdt-height" name="height" value="" disabled="">
			<input type="text" class="mdt-text mdt-input mdt-left" name="left" value="" disabled="">
			<input type="text" class="mdt-text mdt-input mdt-top" name="top" value="" disabled="">

			<div class="mdt-item-type mdt-type-text" style="display: none;">
				<div class="mdt-label"><?php _e('Text', 'mega-slider'); ?>:</div>
				<textarea name="text" class="mdt-text mdt-textvalue"></textarea>
				<a href="#" class="mdt-button mdt-addlink" title="<?php _e('Add link', 'mega-slider'); ?>"></a>
				<input type="text" class="mdt-text mdt-input mdt-fontsize" name="font-size" value="12">
				<span class="mdt-fontsizeunit"></span>

				<select name="font-family" class="mdt-select mdt-input mdt-font-family">
					<option value=""></option>
					<optgroup label="System fonts">
						<option value="Arial" data-fontweight="400,700,400italic,700italic" style="font-family: Arial">
							Arial
						</option>
						<option value="Verdana" data-fontweight="400,700,400italic,700italic"
						        style="font-family: Verdana">Verdana
						</option>
						<option value="Trebuchet MS" data-fontweight="400,700,400italic,700italic"
						        style="font-family: 'Trebuchet MS'">Trebuchet MS
						</option>
						<option value="Georgia" data-fontweight="400,700,400italic,700italic"
						        style="font-family: Georgia">Georgia
						</option>
						<option value="Times New Roman" data-fontweight="400,700,400italic,700italic"
						        style="font-family: 'Times New Roman'">Times New Roman
						</option>
						<option value="Tahoma" data-fontweight="400,700,400italic,700italic"
						        style="font-family: Tahoma">Tahoma
						</option>
					</optgroup>
					<?php if (isset($fonts)) : ?>
						<optgroup label="Google Fonts">
							<?php
							foreach ($fonts as $font) {
								$f = explode(":", $font);
								if (!isset($f[1])) $f[1] = "";
								if (isset($f[0])) {
									printf('<option value="%s" data-fontweight="%s" style="font-family: \'%s\'">%s</option>', $f[0], $f[1], $f[0], $f[0]);
								}
							}
							?>
						</optgroup>
					<?php endif; ?>
				</select>
				<select name="font-weight" class="mdt-select mdt-input mdt-font-weight">
					<option value=""></option>
				</select>

				<a href="#" class="mdt-button button-style mdt-font-underline" name="text-decoration" active="underline"
				   normal="none" title="<?php _e('Underline', 'mega-slider'); ?>"></a>
				<a href="#" class="mdt-button button-style mdt-font-allcaps" name="text-transform" active="uppercase"
				   normal="none" title="<?php _e('All caps', 'mega-slider'); ?>"></a>

				<a href="#" class="mdt-button button-align mdt-left-alignment" value="left"
				   title="<?php _e('Left alignment', 'mega-slider'); ?>"></a>
				<a href="#" class="mdt-button button-align mdt-center-alignment" value="center"
				   title="<?php _e('Center alignment', 'mega-slider'); ?>"></a>
				<a href="#" class="mdt-button button-align mdt-right-alignment" value="right"
				   title="<?php _e('Right alignment', 'mega-slider'); ?>"></a>
				<a href="#" class="mdt-button button-align mdt-justified-alignment" value="justify"
				   title="<?php _e('Justified alignment', 'mega-slider'); ?>"></a>

				<a class="mdt-button mdt-text-color" title="<?php _e('Text color', 'mega-slider'); ?>"></a>
				<input type="hidden" name="color" value="" class="mdt-color mdt-input"/>
				<input type="hidden" name="border-color" value="" class="mdt-border-color mdt-input"/>
			</div>

			<div style="display: none;" class="mdt-item-type mdt-type-image">
				<div class="mdti-image">
					<input type="hidden" value="" name="fileid" class="mdt-text mdt-input mdt-image-fileid"/>
					<img class="mdt-imgsrc" src=""/>
				</div>
				<a href="#" class="mdt-button mdt-addlink" title="<?php _e('Add link', 'mega-slider'); ?>"></a>

				<div class="mdt-label"><?php _e('Image', 'mega-slider'); ?>: <a id="change-image"
				                                                                href="#"><?php _e('Change image', 'mega-slider'); ?></a>
				</div>
				<textarea class="mdt-textarea mdt-imgalt" name="imgalt"></textarea>
			</div>
			<div style="display: none;" class="mdt-item-type mdt-type-video">
				<div class="mdti-image">
					<input type="hidden" value="" name="fileid" class="mdt-text mdt-input mdt-video-fileid"/>
					<img class="mdt-videosrc" src=""/><span class="mdt-play"></span>
				</div>
				<div class="mdt-label"><?php _e('Video', 'mega-slider'); ?>: <a id="change-video"
				                                                                href="#"><?php _e('Change', 'mega-slider'); ?></a>
				</div>
				<textarea class="mdt-textarea mdt-videoname" name="videoname"></textarea>
			</div>

			<input type="text" class="mdt-text mdt-starttime" name="starttime" readonly="readonly" value="" disabled="">
			<input type="text" class="mdt-text mdt-stoptime" name="stoptime" readonly="readonly" value="" disabled="">

			<select class="mdt-select mdt-input mdt-startani" name="startani" disabled="">
				<option value="none">none</option>
				<option value="random">random</option>
				<option value="bounceIn">bounceIn</option>
				<option value="bounceInDown">bounceInDown</option>
				<option value="bounceInUp">bounceInUp</option>
				<option value="bounceInLeft">bounceInLeft</option>
				<option value="bounceInRight">bounceInRight</option>
				<option value="fadeIn">fadeIn</option>
				<option value="fadeInUp">fadeInUp</option>
				<option value="fadeInDown">fadeInDown</option>
				<option value="fadeInLeft">fadeInLeft</option>
				<option value="fadeInRight">fadeInRight</option>
				<option value="fadeInRight">fadeInRight</option>
				<option value="fadeInUpBig">fadeInUpBig</option>
				<option value="fadeInDownBig">fadeInDownBig</option>
				<option value="fadeInLeftBig">fadeInLeftBig</option>
				<option value="fadeInRightBig">fadeInRightBig</option>
				<option value="flipInX">flipInX</option>
				<option value="flipInY">flipInY</option>
				<option value="foolishIn">foolishIn</option>
				<option value="lightSpeedIn">lightSpeedIn</option>
				<option value="puffIn">puffIn</option>
				<option value="rollIn">rollIn</option>
				<option value="rotateIn">rotateIn</option>
				<option value="rotateInDownLeft">rotateInDownLeft</option>
				<option value="rotateInDownRight">rotateInDownRight</option>
				<option value="rotateInUpLeft">rotateInUpLeft</option>
				<option value="rotateInUpRight">rotateInUpRight</option>
				<option value="twisterInDown">twisterInDown</option>
				<option value="twisterInUp">twisterInUp</option>
				<option value="swap">swap</option>
				<option value="swashIn">swashIn</option>
				<option value="tinRightIn">tinRightIn</option>
				<option value="tinLeftIn">tinLeftIn</option>
				<option value="tinUpIn">tinUpIn</option>
				<option value="tinDownIn">tinDownIn</option>
				<option value="vanishIn">vanishIn</option>
			</select>
			<select class="mdt-select mdt-input mdt-stopani" name="stopani" disabled="">
				<option value="none">none</option>
				<option value="keep">Keep in slide</option>
				<option value="random">random</option>
				<option value="bombRightOut">bombRightOut</option>
				<option value="bombLeftOut">bombLeftOut</option>
				<option value="bounceOut">bounceOut</option>
				<option value="bounceOutDown">bounceOutDown</option>
				<option value="bounceOutUp">bounceOutUp</option>
				<option value="bounceOutLeft">bounceOutLeft</option>
				<option value="bounceOutRight">bounceOutRight</option>
				<option value="fadeOut">fadeOut</option>
				<option value="fadeOutUp">fadeOutUp</option>
				<option value="fadeOutDown">fadeOutDown</option>
				<option value="fadeOutLeft">fadeOutLeft</option>
				<option value="fadeOutRight">fadeOutRight</option>
				<option value="fadeOutRight">fadeOutRight</option>
				<option value="fadeOutUpBig">fadeOutUpBig</option>
				<option value="fadeOutDownBig">fadeOutDownBig</option>
				<option value="fadeOutLeftBig">fadeOutLeftBig</option>
				<option value="fadeOutRightBig">fadeOutRightBig</option>
				<option value="flipOutX">flipOutX</option>
				<option value="flipOutY">flipOutY</option>
				<option value="foolishOut">foolishOut</option>
				<option value="hinge">hinge</option>
				<option value="holeOut">holeOut</option>
				<option value="lightSpeedOut">lightSpeedOut</option>
				<option value="puffOut">puffOut</option>
				<option value="rollOut">rollOut</option>
				<option value="rotateOut">rotateOut</option>
				<option value="rotateOutDownLeft">rotateOutDownLeft</option>
				<option value="rotateOutDownRight">rotateOutDownRight</option>
				<option value="rotateOutUpLeft">rotateOutUpLeft</option>
				<option value="rotateOutUpRight">rotateOutUpRight</option>
				<option value="rotateDown">rotateDown</option>
				<option value="rotateUp">rotateUp</option>
				<option value="rotateLeft">rotateLeft</option>
				<option value="rotateRight">rotateRight</option>
				<option value="swashOut">swashOut</option>
				<option value="tinRightOut">tinRightOut</option>
				<option value="tinLeftOut">tinLeftOut</option>
				<option value="tinUpOut">tinUpOut</option>
				<option value="tinDownOut">tinDownOut</option>
				<option value="vanishOut">vanishOut</option>
			</select>

			<input type="text" name="opacity" value="100" maxlength="3" class="mdt-text mdt-input mdt-opacity"/>

			<select class="mdt-select mdt-input mdt-style" name="style" disabled="">
				<option value="none">None</option>
				<?php foreach ($style_options as $class => $name) : ?>
					<option value="<?php echo esc_attr($class); ?>"><?php echo esc_attr($name); ?></option>
				<?php endforeach; ?>
			</select>
			<a class="mdt-button mdt-background-color" title="<?php _e('Background color', 'mega-slider'); ?>"></a>
			<input type="hidden" id="background-color" class="mdt-background mdt-input" value=""
			       name="background-color">
			<input type="text" value="" maxlength="3" name="background-transparent"
			       class="mdt-text mdt-input mdt-background-transparent"/>

			<div class="border-position" id="border-position">
				<a href="#" class="bp-all" title="<?php _e('All borders', 'mega-slider'); ?>"><span></span></a>
				<a href="#" class="bp-top" title="<?php _e('Top borders', 'mega-slider'); ?>"><span></span></a>
				<a href="#" class="bp-right" title="<?php _e('Right borders', 'mega-slider'); ?>"><span></span></a>
				<a href="#" class="bp-bottom" title="<?php _e('Bottom borders', 'mega-slider'); ?>"><span></span></a>
				<a href="#" class="bp-left" title="<?php _e('Left borders', 'mega-slider'); ?>"><span></span></a>
			</div>
			<input type="text" value="" maxlength="3" name="border-width" class="mdt-text mdt-input mdt-border-width"/>
			<select name="border-style" class="mdt-select mdt-input mdt-border-style">
				<option value="solid">solid</option>
				<option value="dashed">dashed</option>
				<option value="dotted">dotted</option>
				<option value="double">double</option>
			</select>

			<a class="mdt-button mdt-border-color" title="<?php _e('Border color', 'mega-slider'); ?>"></a>
			<input type="hidden" id="border-color" class="mdt-border mdt-input" value="" name="border-color">

			<input type="text" value="" maxlength="2" name="border-top-left-radius"
			       class="mdt-text mdt-border-radius mdt-br-topleft"/>
			<input type="text" value="" maxlength="2" name="border-top-right-radius"
			       class="mdt-text mdt-border-radius mdt-br-topright"/>
			<input type="text" value="" maxlength="2" name="border-bottom-right-radius"
			       class="mdt-text mdt-border-radius mdt-br-bottomright"/>
			<input type="text" value="" maxlength="2" name="border-bottom-left-radius"
			       class="mdt-text mdt-border-radius mdt-br-bottomleft"/>

			<input type="text" value="" maxlength="2" name="padding-top" class="mdt-text mdt-padding mdt-p-top"/>
			<input type="text" value="" maxlength="2" name="padding-right" class="mdt-text mdt-padding mdt-p-right"/>
			<input type="text" value="" maxlength="2" name="padding-bottom" class="mdt-text mdt-padding mdt-p-bottom"/>
			<input type="text" value="" maxlength="2" name="padding-left" class="mdt-text mdt-padding mdt-p-left"/>

			<div id="mdt-linkexpand" class="mdt-linkexpand mdt-input">
				<a href="#" class="mdt-link-close"></a>
				<input type="text" value="" name="" class="mdt-text mdt-link-value"/>
				<input type="text" value="" name="" class="mdt-text mdt-link-title"/>

				<a class="mdt-link-color mdt-edit-color" title="<?php _e('Hover text color', 'mega-slider'); ?>"></a>
				<input type="hidden" id="link-color" class="link-color" value="" name="link-color">

				<a class="mdt-link-background mdt-edit-color"
				   title="<?php _e('Hover background color', 'mega-slider'); ?>"></a>
				<input type="hidden" id="link-background" class="link-background" value="" name="link-background">
				<input type="text" value="" maxlength="3" name="link-background-transparent"
				       class="mdt-text link-background-transparent"/>

				<a class="mdt-link-border mdt-edit-color" title="<?php _e('Hover border color', 'mega-slider'); ?>"></a>
				<input type="hidden" id="link-border" class="link-border" value="" name="link-border">

				<a href="#" class="mdt-link-remove">Remove</a>
				<a href="#" class="mdt-link-save">Save</a>
			</div>
			</div>
			<!-- /#md-toolbar -->

			<div class="md-timeline">
				<div class="mdtl-layers">
					<div class="mdtl-head">
						<div class="mdtl-head-left"><?php _e('Timeline', 'mega-slider'); ?></div>
						<div class="mdtl-head-right">
							<div class="mdtl-ruler">
								<?php for ($i = 0; $i < 20; $i++): ?>
									<div class="number"><span><?php print $i; ?></span></div>
									<div></div>
									<div></div>
									<div></div>
									<div></div>
									<div></div>
									<div></div>
									<div></div>
									<div></div>
									<div></div>
								<?php endfor; ?>
							</div>
							<div id="slideshow-time">
								<div></div>
							</div>
						</div>
					</div>
					<div class="timeline-wrap">
						<div id="timeline-items">

						</div>
					</div>
				</div>
			</div>
			<!-- /.md-timeline -->
			<!-- dialog -->
			<div id="dlg-video" style="display:none;" title="<?php _e('Item setting', 'mega-slider'); ?>">
				<div class="dlg-inner">
					<form id="form-slider-panelsetting">
						<fieldset class="ui-helper-reset">
							<div class="form-item">
								<label for="videoid"><?php _e('Video URL', 'mega-slider'); ?></label>
								<input type="text" name="txtvideoid" id="txtvideoid" class="form-text"
								       autocomplete="false" value=""/>
								<button class="button button-large"
								        id="btn-search"><?php _e('Search', 'mega-slider'); ?></button>
							</div>
							<div class="form-item">
								<label for="videoid"><?php _e('Video Id', 'mega-slider'); ?></label>
								<input type="text" name="videoid" id="videoid" class="form-text" autocomplete="false"
								       value=""/>
							</div>
							<div class="form-item">
								<label for="videoname"><?php _e('Video Name', 'mega-slider'); ?></label>
								<input type="text" name="videoname" id="videoname" class="form-text"
								       autocomplete="false" value=""/>
							</div>
							<div class="form-item">
								<img src="" id="videothumb" width="100px" height="100px"/>
							</div>
							<button class="button"
							        id="videothumb-pick"><?php _e('Choose another thumbnail', 'mega-slider'); ?></button>
						</fieldset>
					</form>
				</div>
			</div>
			<input id="savedcolor1" type="hidden" name="color_saved" value="ff9900,CC0000"/>

			<div id="dlg-slide-setting" style="display:none;">
				<div class="settings">
					<a href="#" class="panel-settings-link">[<?php _e('Settings', 'mega-slider'); ?>]</a> &nbsp;
					<a class="panel-clone" href="#">[<?php _e('Clone slide', 'mega-slider'); ?>]</a>
					<input class="panelsettings" type="hidden" value='{}' autocomplete="off">
				</div>
				<div class="md-slidewrap"
				     style="width: <?php echo esc_attr($settings['width']); ?>px;  height: <?php echo esc_attr($settings['height']); ?>px;">
					<div class="md-slide-image"><img src="<?php echo MS_ADMIN_URL; ?>/images/default_bg.jpg"/></div>
					<div class="md-objects"
					     style="width: <?php echo esc_attr($settings['width']); ?>px; height: <?php echo esc_attr($settings['height']); ?>px;"></div>
				</div>
			</div>
			<input type="hidden" name="default-timelinewidth"
			       value="<?php echo esc_attr($settings['slideShowDelay'] / 100); ?>">
			<input type="hidden" name="md-slider-data" id="md-slider-data"/>

			<div id='slide-setting-dlg' title="Slide setting" style="display: none">
				<div class="megaslider-popup clearfix">
					<div id="slide-setting-tabs" class="cs-popup-tabs clearfix">
						<div class="slide-setting clearfix">
							<div class="choose-image">
								<a class="slide-choose-image-link" href="#">[Choose image]</a>

								<div><img id="slide-background-preview" src=""/></div>
							</div>
							<input type="hidden" id="slide-backgroundimage">

							<div class="choose-thumbnail">
								<a class="slide-choose-thumbnail-link" href="#">[Choose thumbnail]</a>

								<div><img id="slide-thumbnail-preview" src=""/></div>
							</div>
							<input type="hidden" id="slide-thumbnail">
						</div>
						<!-- / .slide-setting -->
						<div class="transition">
							<h3>Transitions <a href="#" class="random-transition">[Choose random]</a></h3>

							<p>You can select multiple value, slide will take random effect form what you selected.</p>

							<div id="navbar-content-transitions" class="transition-inner">
								<?php $transitions = array('slit-horizontal-left-top' => "Slit horizontal left top", 'slit-horizontal-top-right' => "Slit horizontal top right", 'slit-horizontal-bottom-up' => "Slit horizontal bottom up", 'slit-vertical-down' => "Slit vertical down", 'slit-vertical-up' => "Slit vertical up", 'strip-up-right' => "Strip up right", 'strip-up-left' => "Strip up left", 'strip-down-right' => "Strip down right", 'strip-down-left' => "Strip down left", 'strip-left-up' => "Strip left up", 'strip-left-down' => "Strip left down", 'strip-right-up' => "Strip right up", 'strip-right-down' => "Strip right down", 'strip-right-left-up' => "Strip right left up", 'strip-right-left-down' => "Strip right left down", 'strip-up-down-right' => "Strip up down right", 'strip-up-down-left' => "Strip up down left", 'left-curtain' => "Left curtain", 'right-curtain' => "Right curtain", 'top-curtain' => "Top curtain", 'bottom-curtain' => "Bottom curtain", 'slide-in-right' => "Slide in right", 'slide-in-left' => "Slide in left", 'slide-in-up' => "Slide in up", 'slide-in-down' => "Slide in down", 'fade' => "Fade") ?>
								<div id="navbar-content" class="navbar-content navbar-content-tr">
									<ul class="megaslider-3columns clearfix">
										<?php foreach ($transitions as $key => $transition): ?>
											<li><input type="checkbox" id="transitions_<?php echo $key ?>"
											           value="<?php echo $key ?>"/> <label
													for="transitions_<?php echo $key ?>"><?php echo $transition ?></label>
											</li>
										<?php endforeach; ?>
									</ul>
								</div>
							</div>
							<div id="md-tooltip" class="tooltip" style="display: none;">
								<div class="md-slide-wrap">
									<div class="md-slide-items" id="md-slider">
										<div class="md-slide-item" data-timeout="2000">
											<div class="md-mainimg"><img style="left:0px;top:0px;"
											                             src="<?php echo MS_ADMIN_URL; ?>/preview/img/1.jpg"/>
											</div>
											<div class="md-objects">

											</div>
										</div>
										<div class="md-slide-item" data-timeout="2000" style="display: none;">
											<div class="md-mainimg"><img style="left:0px;top:0px;"
											                             src="<?php echo MS_ADMIN_URL; ?>/preview/img/2.jpg"/>
											</div>
											<div class="md-objects">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- / .transitions -->

					</div>
					<!-- / .cs-popup-tabs -->
				</div>
			</div>
			</div>
		<?php
		}

		public function add_helper() {
			$screen = get_current_screen();

			if ($screen->post_type === 'mega-slider') {
				$screen->add_help_tab(array('id' => 'megaslider-document', 'title' => 'Document', 'content' => 'Not sure about anything? Check <a href="http://wpprime.com/doc/mega-slider">online document here</a>',));

				$screen->add_help_tab(array('id' => 'support-forum', 'title' => 'Support forum', 'content' => '<p>Have problem? <a href="http://wpprime.com/user">Login</a> &amp; post your problem to our forum: <a href="http://wpprime.com/forum">wpprime.com/forum</a></p>',));

				$screen->set_help_sidebar($screen->action);
			}
		}
	}
}

if (!function_exists('megaSlider_create_image')) {
	function megaSlider_create_image($attachment_id, $w, $h, $crop = false) {
		$file_path = get_attached_file($attachment_id);
		$file_info = pathinfo($file_path);
		$image = wp_get_image_editor($file_path);
		if (!is_wp_error($image)) {
			if ($crop) {
				$newly_name = sprintf('%s/%s-%sx%s-cropped.%s', $file_info['dirname'], $file_info['filename'], $w, $h, $file_info['extension']);
			} else {
				$newly_name = sprintf('%s/%s-%sx%s.%s', $file_info['dirname'], $file_info['filename'], $w, $h, $file_info['extension']);
			}

			$image->resize($w, $h, $crop);
			$image->save($newly_name);
			return megaSlider_get_image(wp_get_attachment_url($attachment_id), $w, $h, $crop);
		}
		return false;
	}
}

if (!function_exists('megaSlider_get_image')) {
	function megaSlider_get_image($url_or_path, $w, $h, $crop = false) {
		$ext_file = substr($url_or_path, strrpos($url_or_path, '.'));
		$size = $w . 'x' . $h;
		if ($crop) return str_replace($ext_file, '-' . $size . '-cropped' . $ext_file, $url_or_path);
		return str_replace($ext_file, '-' . $size . $ext_file, $url_or_path);
	}
}

if (!function_exists('megaSlider_delete_image')) {
	function megaSlider_delete_image($attachment_id, $w, $h, $crop = false) {
		$file = megaSlider_get_image(get_attached_file($attachment_id), $w, $h, $crop);
		if (file_exists($file)) {
			@unlink($file);
		}
	}
}

if (!function_exists('backward_transition_compatibility')) {
	function backward_transition_compatibility(&$tabs, $settings) {
		if (!isset($tabs['itemsetting']['transitions']) && isset($settings['transitions'])) {
			$old_to_new = array('fade' => 'fade', 'scrollLeft' => 'slide-in-left', 'scrollRight' => 'slide-in-right', 'scrollHorz' => 'slide-in-left', 'scrollVert' => 'slide-in-down', 'scrollUp' => 'slide-in-up', 'scrollDown' => 'slide-in-down');
			$tabs['itemsetting']['transitions'] = array($old_to_new[$settings['transitions']]);
		}
	}
}

$mega_slider = new MegaSlider; // Kick-ass

include("shortcode.php"); // Load shortcode
?>