<?php
/*
Plugin Name: WP Clone Menu
Description: Clone WordPress menu very easily
Author: Afzal Multani
Version: 1.0.1
*/

define( 'CLONE_MENU_DIR', plugin_dir_path( __FILE__ ) );
define( 'CLONE_MENU_URL', plugin_dir_url( __FILE__ ) );

/*
*  Add settings link on plugins page.
*/
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'clone_menu_admin_link' );

function clone_menu_admin_link( $links ) {
	$settings_page_link = array(
		'<a href="' . admin_url( 'admin.php?page=clone-menu' ) . '" title="Clone Menu Settings">Settings</a>',
	);

	return array_merge( $settings_page_link, $links );
}

/*
* Registers page in wordpress backend.
*/
function clone_menu_sett_page() {
	global $clone_menu_page;
	$clone_menu_page = add_menu_page( 'Clone Menu', 'Clone Menu', 'manage_options', 'clone-menu', 'clone_menu_output_page' );
}

add_action( 'admin_menu', 'clone_menu_sett_page' );

/*
* settings  output page form .
*/
function clone_menu_output_page() { ?>
    <div class="wrap main-wrap">
        <div id="options-general" class="icon32"><br/></div>
        <h2><?php _e( 'Clone WordPress Menus' ); ?></h2>
		<?php
		$all_menu_items = wp_get_nav_menus();

		if ( empty( $all_menu_items ) ) : ?>
            <p><?php _e( "No Menus found yet." ); ?></p>
		<?php else:
			echo '<div class="main-clone">';
			echo '<span >Select Existing Menu</span>';
			echo '<select name="menu_exist" id="all_menu_items">';
			echo '<option value="">Select Menu</option>';

			foreach ( $all_menu_items as $menu ) {
				echo '<option value="' . $menu->term_id . '">' . $menu->name . '</option>';
			}
			echo '</select>';
			echo '</div>';
			echo '<div class="main-clone">';
			echo '<span>New Menu Name</span>';
			echo '<input type="text" name="clone_menu_name" id="clone_menu_name" placeholder="New Menu Name">';
			echo '<input id="make_clone_btn" type="button" class="button-primary" value="Make Clone">';
			echo '</div>';
			echo '<div id="response"></div>';

		endif;
		?>
    </div>
	<?php
}

/*
* Enqueue ajax & field validation script.
*/
function clone_menu_script_style() {

	$screen = get_current_screen();
	global $clone_menu_page;
	if ( $screen->id == $clone_menu_page ) {
		wp_enqueue_style( 'clone-menu-css', CLONE_MENU_URL . 'css/clone-menu.css', '1.0', true );
		wp_enqueue_script( 'clone-menu-js', CLONE_MENU_URL . 'js/clone-menu.js', array( 'jquery' ), '1.0', true );
		wp_localize_script( 'clone-menu-js', 'clone_main_obj', array( 'plugin_url' => CLONE_MENU_URL ) );
	}
}

add_action( 'admin_enqueue_scripts', 'clone_menu_script_style' );

/*
* Ajax Callback to Clone Menu
*/
function clone_menu_cb() {

	if ( isset( $_POST ) ) {

		$new_name = sanitize_text_field( $_POST['new_name'] );
		$menu_id  = intval( $_POST['menu_id'] );

		$old_menu       = wp_get_nav_menu_object( $menu_id );
		$old_menu_items = wp_get_nav_menu_items( $menu_id );

		$new_menu_id = wp_create_nav_menu( $new_name );

		if ( ! $new_menu_id ) {
			echo "0";
		} else {

			// key is the original db ID, val is the new
			$rel = array();

			$i = 1;
			foreach ( $old_menu_items as $menu_item ) {
				$args = array(
					'menu-item-db-id'       => $menu_item->db_id,
					'menu-item-object-id'   => $menu_item->object_id,
					'menu-item-object'      => $menu_item->object,
					'menu-item-position'    => $i,
					'menu-item-type'        => $menu_item->type,
					'menu-item-title'       => $menu_item->title,
					'menu-item-url'         => $menu_item->url,
					'menu-item-description' => $menu_item->description,
					'menu-item-attr-title'  => $menu_item->attr_title,
					'menu-item-target'      => $menu_item->target,
					'menu-item-classes'     => implode( ' ', $menu_item->classes ),
					'menu-item-xfn'         => $menu_item->xfn,
					'menu-item-status'      => $menu_item->post_status
				);

				$parent_id = wp_update_nav_menu_item( $new_menu_id, 0, $args );

				$rel[ $menu_item->db_id ] = $parent_id;

				if ( $menu_item->menu_item_parent ) {
					$args['menu-item-parent-id'] = $rel[ $menu_item->menu_item_parent ];
					$parent_id                   = wp_update_nav_menu_item( $new_menu_id, $parent_id, $args );
				}

				$i ++;
			}

			echo $new_menu_id;

		}
	}
	die;
}

add_action( 'wp_ajax_make_clone', 'clone_menu_cb' );
