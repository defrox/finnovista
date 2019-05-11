<?php
add_filter('deprecated_constructor_trigger_error', '__return_false');

/* Autoptimize Cache Size */
add_filter('autoptimize_filter_cachecheck_maxsize','adjust_cachesize');
function adjust_cachesize() {
  return 2*1024*1024*1024;
}

add_filter('excerpt_more', 'dfx_excerpt_more');
#add_filter('the_excerpt', 'dfx_the_excerpt2');
add_filter('the_excerpt_rss', 'dfx_the_excerpt');
#add_filter('get_footer', 'dfx_get_footer');

function dfx_get_footer($footer)
{
    return get_footer('old');
}

function dfx_excerpt_more($more)
{
    return ' <a data-through="no-gateway" data-postid="' . get_the_ID() . '" href="' . get_permalink() . '" title="' . get_the_title() . '">[+]</a>';
}

function dfx_the_excerpt($length = 55)
{
    if ($post->post_excerpt && $post->post_excerpt != 'NULL') {
        $excerpt = get_the_excerpt();
    } else {
        $content = get_the_content();
        $excerpt = wp_trim_words($content, 55);
    }
    echo $excerpt;
}

function dfx_the_excerpt2($length = 55)
{
    if (get_the_excerpt() != '') {
        $excerpt = '<a>' . get_the_excerpt() . '</a>';
    } else {
        $content = get_the_content();
        $excerpt = wp_trim_words($content, 55);
    }
    echo $excerpt;
}

function dfx_the_title($before = '', $after = '', $echo = true)
{
    if (get_post_meta(get_the_ID(), 'titulo_corto', true) != '') {
        $title = get_post_meta(get_the_ID(), 'titulo_corto', true);
    } else {
        $title = get_the_title();
    }
    $title = $before . $title . $after;
    if ($echo)
        echo $title;
    else
        return $title;
}

function dfx_the_permalink( $post = 0 )
{
    if ( !is_object( $post ) ) {
        $post = get_post($post);
    }
    if (get_post_meta($post->ID, 'alternative_link', true) != '') {
        $permalink = get_post_meta($post->ID, 'alternative_link', true);
        echo esc_url( $permalink );
    } else {
        the_permalink($post);
    }
}

function dfx_exclude_private($query) {
    if ( $query->is_feed && is_main_query() ) {
        $query->query_vars["has_password"] = false;
    }
    return $query;
}
add_filter('pre_get_posts', 'dfx_exclude_private');

/* Set Max Content Width */
if (!isset($content_width)) $content_width = 1170;

global $is_retina;
(isset($_COOKIE['retina'])) ? $is_retina = true : $is_retina = false;

/* Theme Setup */
if (!function_exists('stag_theme_setup')) {
    function stag_theme_setup()
    {
        load_theme_textdomain('stag', get_template_directory() . '/languages');

        $locale = get_locale();
        $locale_file = get_template_directory() . "/languages/$locale.php";
        if (is_readable($locale_file)) {
            require_once($locale_file);
        }

        add_editor_style('framework/css/editor-style.css');

        if (function_exists('add_theme_support')) {
            add_theme_support('post-thumbnails');
            set_post_thumbnail_size(170, 160); // Normal post thumbnails
        }

        if (function_exists('add_image_size')) {
            add_image_size('portfolio-thumb', 600, 400, true); // Recent Posts thumbnail (homepage)
            add_image_size('team-thumb', 270, 390, true); // Team Members thumbnail (homepage)
            add_image_size('team-avatar', 200, 200, true); // Team Members Avatar (homepage)
            add_image_size('videos-thumb', 300, 264, true); // Videos thumbnail (homepage)
            add_image_size('medium', 300, 300, true); // Blog thumbnail (homepage)
            add_image_size('logo', 430, 150, true); // Blog thumbnail (homepage)
            add_image_size('poster', 193, 265, false); // Blog thumbnail (homepage)
        }
    }
}
add_action('after_setup_theme', 'stag_theme_setup');

add_theme_support('automatic-feed-links');

/* Register Sidebar */
if (!function_exists('stag_sidebar_init')) {
    function stag_sidebar_init()
    {

        register_sidebar(array(
            'name' => __('Other Widgets', 'stag'),
            'id' => 'sidebar-other',
            'before_widget' => '<div id="%1$s" class="widget grid-4 %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
            'description' => __('All widgets excluding Homepage and Services widgets should be included in this sidebar.', 'stag')
        ));

        register_sidebar(array(
            'name' => __('Homepage Widgets', 'stag'),
            'id' => 'sidebar-homepage',
            'before_widget' => '',
            'after_widget' => '',
            'before_title' => '<h2 class="main-title">',
            'after_title' => '</h2>',
        ));

        register_sidebar(array(
            'name' => __('Services Widgets', 'stag'),
            'id' => 'sidebar-services',
            'before_widget' => '',
            'after_widget' => '',
            'before_title' => '<h3 class="service-title">',
            'after_title' => '</h3>',
        ));

        register_sidebar(array(
            'name' => __('Footer Left', 'stag'),
            'id' => 'sidebar-footer-left',
            'before_widget' => '',
            'after_widget' => '',
            'before_title' => '',
            'after_title' => '',
        ));

        register_sidebar(array(
            'name' => __('Footer Right', 'stag'),
            'id' => 'sidebar-footer-right',
            'before_widget' => '',
            'after_widget' => '',
            'before_title' => '',
            'after_title' => '',
        ));

    }
}
add_action('widgets_init', 'stag_sidebar_init');

/* WordPress Title Filter */
if (!function_exists('stag_wp_title')) {
    function stag_wp_title($title)
    {
        if (!stag_check_third_party_seo()) {
            if (is_front_page()) {
                if (get_bloginfo('description') == '') {
                    return get_bloginfo('name');
                } else {
                    return get_bloginfo('name') . ' | ' . get_bloginfo('description');
                }
            } else {
                return trim($title) . ' | ' . get_bloginfo('name');
            }
        }
        return $title;
    }
}
add_filter('wp_title', 'stag_wp_title');

/* Download File button */
function add_download_file_button()
{
    echo '<a href="#" id="insert-download-file-button" class="thickbox button" title="Download File Link Generator" style="outline: medium none !important; cursor: pointer;"><span style="margin-top: 3px;margin-right: 5px;" class="dashicons dashicons-download"></span>' . __('Add Download File', 'stag') . '</a>';
}

add_action('media_buttons', 'add_download_file_button', 30);

function include_download_file_button_js_file()
{
    wp_enqueue_script('media_button', get_template_directory_uri() . '/assets/js/download-file-button.js', array('jquery'), '1.0', true);
}

add_action('wp_enqueue_media', 'include_download_file_button_js_file');

/**
 * Add download and thank you page URL fields to media uploader
 *
 * @param $form_fields array, fields to include in attachment form
 * @param $post object, attachment record in database
 * @return $form_fields, modified form fields
 */
 
function download_file_button_fields_edit( $form_fields, $post ) {
    $langs = icl_get_languages('skip_missing=N&orderby=KEY&order=DIR&link_empty_to=str');
    $languages_select = '<select id="language_select" name="language_select"><option' . (!$curr_language || $curr_language == '' ? ' selected="selected" ' : '') . '>' . __('Choose a language') . '</option>';
    $curr_language = get_post_meta( $post->ID, 'language', true );
    foreach ($langs as $key => $value) {
        $languages_select .= '<option value="' . $value['code'] . '"' . ( $curr_language === $value['code'] ? ' selected="selected" ' : '') . '>' . $value['translated_name'] . '</option>';
        $languages_array[$value['code']] = $value['translated_name'];
    }
    $languages_select .= '</select><script type="text/javascript">$("select[id=language_select]").change(function(){$("input[id=attachments-'.$post->ID.'-language").val($(this).val());});</script><style>.compat-field-language{display:none !important;}</style>';

    $form_fields['download-url'] = array(
        'label' => __('Download slug'),
        'input' => 'text',
        'value' => get_post_meta( $post->ID, 'download_url', true ),
        'helps' => __('Add download page slug'),
    );

    $form_fields['thankyou-url'] = array(
        'label' => __('Thank you slug'),
        'input' => 'text',
        'value' => get_post_meta( $post->ID, 'thankyou_url', true ),
        'helps' => __('Add thank you page slug'),
    );
    $form_fields['campaign'] = array(
        'label' => __('Campaign'),
        'input' => 'text',
        'value' => get_post_meta( $post->ID, 'campaign', true ),
        'helps' => __('Add the campaign tracking name'),
    );
    $form_fields['language'] = array(
        'label' => 'Language',
        'input' => 'html',
        'value' => get_post_meta( $post->ID, 'language', true ),
        'helps' => 'Add the language',
    );
    $form_fields['language_select'] = array(
        'label' => __('Language'),
        'input' => 'html',
        'html' => $languages_select,
        'value' => get_post_meta( $post->ID, 'language', true ),
        'helps' => __('Add the language'),
    );

    return $form_fields;
}

add_filter( 'attachment_fields_to_edit', 'download_file_button_fields_edit', 10, 2 );

/**
 * Save values of download and thank you page URL fields in media uploader
 *
 * @param $post array, the post data for database
 * @param $attachment array, attachment fields from $_POST form
 * @return $post array, modified post data
 */

function download_file_button_fields_save( $post, $attachment ) {
    if( isset( $attachment['download-url'] ) )
        update_post_meta( $post['ID'], 'download_url', $attachment['download-url'] );

    if( isset( $attachment['thankyou-url'] ) )
        update_post_meta( $post['ID'], 'thankyou_url', $attachment['thankyou-url'] );

    if( isset( $attachment['campaign'] ) )
        update_post_meta( $post['ID'], 'campaign', $attachment['campaign'] );

    if( isset( $attachment['language'] ) )
        update_post_meta( $post['ID'], 'language', $attachment['language'] );

    return $post;
}

add_filter( 'attachment_fields_to_save', 'download_file_button_fields_save', 10, 2 );

/* Register Menu */
function register_menus()
{
    register_nav_menus(
        array(
            'primary-menu' => __('Primary Menu', 'stag'),
            'finnosummit-menu' => __('Finnosummit Menu', 'stag'),
            'visa-everywhere-menu' => __('Visa Everywhere Menu', 'stag'),
            'visa-event-menu' => __('Visa Event Menu', 'stag'),
            'event-menu' => __('Event Menu', 'stag'),
            'finnosummit-event-menu' => __('Finnosummit Event Menu', 'stag'),
            'challenges-menu' => __('Finnosummit Challenges Menu', 'stag'),
        )
    );

    /* Events Dynamic Menu */
    $menuname = 'Events Dynamic Menu';
    $bpmenulocation = 'event-menu';
// Does the menu exist already?
    $menu_exists = wp_get_nav_menu_object($menuname);

// If it doesn't exist, let's create it.
    if (!$menu_exists) {
        $menu_id = wp_create_nav_menu($menuname);

        // Set up default links and add them to the menu.
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => __('What is?', 'dfx'),
            'menu-item-classes' => 'what-is',
            'menu-item-url' => 'http://dfxlink/#what-is',
            'menu-item-status' => 'publish'));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => __('Speakers', 'dfx'),
            'menu-item-classes' => 'speakers',
            'menu-item-url' => 'http://dfxlink/#speakers',
            'menu-item-status' => 'publish'));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => __('Agenda', 'dfx'),
            'menu-item-classes' => 'agenda',
            'menu-item-url' => 'http://dfxlink/#agenda',
            'menu-item-status' => 'publish'));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => __('Venue', 'dfx'),
            'menu-item-classes' => 'venue',
            'menu-item-url' => 'http://dfxlink/#venue',
            'menu-item-status' => 'publish'));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => __('Sponsors', 'dfx'),
            'menu-item-classes' => 'sponsors',
            'menu-item-url' => 'http://dfxlink/#sponsors',
            'menu-item-status' => 'publish'));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => __('Collaborators', 'dfx'),
            'menu-item-classes' => 'collaborators',
            'menu-item-url' => 'http://dfxlink/#collaborators',
            'menu-item-status' => 'publish'));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => __('Contact', 'dfx'),
            'menu-item-classes' => 'organize',
            'menu-item-url' => 'http://dfxlink/#organize',
            'menu-item-status' => 'publish'));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => __('Register', 'dfx'),
            'menu-item-classes' => 'register',
            'menu-item-url' => 'http://dfxlink/#register',
            'menu-item-status' => 'publish'));

        // Grab the theme locations and assign our newly-created menu
        // to the menu location.
        if (!has_nav_menu($bpmenulocation)) {
            $locations = get_theme_mod('nav_menu_locations');
            $locations[$bpmenulocation] = $menu_id;
            set_theme_mod('nav_menu_locations', $locations);
        };
    };

    /* Finnosummit Events Dynamic Menu */
    $menuname = 'Finnosummit Event Dynamic Menu';
    $bpmenulocation = 'finnosummit-event-menu';
// Does the menu exist already?
    $menu_exists = wp_get_nav_menu_object($menuname);

// If it doesn't exist, let's create it.
    if (!$menu_exists) {
        $menu_id = wp_create_nav_menu($menuname);

        // Set up default links and add them to the menu.
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => __('What is?', 'dfx'),
            'menu-item-classes' => 'what-is',
            'menu-item-url' => 'http://dfxlink/#what-is',
            'menu-item-status' => 'publish'));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => __('Speakers', 'dfx'),
            'menu-item-classes' => 'speakers',
            'menu-item-url' => 'http://dfxlink/#speakers',
            'menu-item-status' => 'publish'));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => __('Agenda', 'dfx'),
            'menu-item-classes' => 'agenda',
            'menu-item-url' => 'http://dfxlink/#agenda',
            'menu-item-status' => 'publish'));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => __('Venue', 'dfx'),
            'menu-item-classes' => 'venue',
            'menu-item-url' => 'http://dfxlink/#venue',
            'menu-item-status' => 'publish'));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => __('Sponsors', 'dfx'),
            'menu-item-classes' => 'sponsors',
            'menu-item-url' => 'http://dfxlink/#sponsors',
            'menu-item-status' => 'publish'));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => __('Collaborators', 'dfx'),
            'menu-item-classes' => 'collaborators',
            'menu-item-url' => 'http://dfxlink/#collaborators',
            'menu-item-status' => 'publish'));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => __('Contact', 'dfx'),
            'menu-item-classes' => 'organize',
            'menu-item-url' => 'http://dfxlink/#organize',
            'menu-item-status' => 'publish'));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => __('Register', 'dfx'),
            'menu-item-classes' => 'register',
            'menu-item-url' => 'http://dfxlink/#register',
            'menu-item-status' => 'publish'));

        // Grab the theme locations and assign our newly-created menu
        // to the menu location.
        if (!has_nav_menu($bpmenulocation)) {
            $locations = get_theme_mod('nav_menu_locations');
            $locations[$bpmenulocation] = $menu_id;
            set_theme_mod('nav_menu_locations', $locations);
        };
    };

    /* Visa Everywhere Menu */
    $menuname = 'Visa Event Dynamic Menu';
    $bpmenulocation = 'visa-event-menu';
// Does the menu exist already?
    $menu_exists = wp_get_nav_menu_object($menuname);

// If it doesn't exist, let's create it.
    if (!$menu_exists) {
        $menu_id = wp_create_nav_menu($menuname);

        // Set up default links and add them to the menu.
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => __('What is?', 'dfx'),
            'menu-item-classes' => 'what-is',
            'menu-item-url' => 'http://dfxlink/#what-is',
            'menu-item-status' => 'publish'));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => __('Speakers', 'dfx'),
            'menu-item-classes' => 'speakers',
            'menu-item-url' => 'http://dfxlink/#speakers',
            'menu-item-status' => 'publish'));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => __('Agenda', 'dfx'),
            'menu-item-classes' => 'agenda',
            'menu-item-url' => 'http://dfxlink/#agenda',
            'menu-item-status' => 'publish'));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => __('Venue', 'dfx'),
            'menu-item-classes' => 'venue',
            'menu-item-url' => 'http://dfxlink/#venue',
            'menu-item-status' => 'publish'));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => __('Sponsors', 'dfx'),
            'menu-item-classes' => 'sponsors',
            'menu-item-url' => 'http://dfxlink/#sponsors',
            'menu-item-status' => 'publish'));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => __('Collaborators', 'dfx'),
            'menu-item-classes' => 'collaborators',
            'menu-item-url' => 'http://dfxlink/#collaborators',
            'menu-item-status' => 'publish'));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => __('Contact', 'dfx'),
            'menu-item-classes' => 'organize',
            'menu-item-url' => 'http://dfxlink/#organize',
            'menu-item-status' => 'publish'));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => __('Register', 'dfx'),
            'menu-item-classes' => 'register',
            'menu-item-url' => 'http://dfxlink/#register',
            'menu-item-status' => 'publish'));

        // Grab the theme locations and assign our newly-created menu
        // to the menu location.
        if (!has_nav_menu($bpmenulocation)) {
            $locations = get_theme_mod('nav_menu_locations');
            $locations[$bpmenulocation] = $menu_id;
            set_theme_mod('nav_menu_locations', $locations);
        };
    };
}

add_action('init', 'register_menus');

/* Register and load scripts */
function stag_enqueue_scripts()
{
    if (!is_admin()) {
        global $is_IE, $pagenow, $post;
        //wp_enqueue_script('jquery');
        wp_deregister_script('jquery');
        wp_register_script('jquery', 'https://code.jquery.com/jquery-1.11.3.min.js', false, '1.11.3');
        wp_enqueue_script('jquery');

        wp_enqueue_script('script', get_template_directory_uri() . '/assets/js/jquery.custom.js', array('jquery', 'superfish', 'supersubs', 'flexslider'), '', true);

        // Dropdown for Superfish
        wp_enqueue_script('superfish', get_template_directory_uri() . '/assets/js/superfish.js', array('jquery'), '', true);
        wp_enqueue_script('supersubs', get_template_directory_uri() . '/assets/js/supersubs.js', array('jquery'), '', true);

        // Mixed Scripts
        wp_enqueue_script('viewport', get_template_directory_uri() . '/assets/js/jquery.viewport.js', array('jquery'), '', true);
        wp_enqueue_script('retinajs', get_template_directory_uri() . '/assets/js/retina.js', '', '', true);
        wp_enqueue_script('fitvids', '//cdnjs.cloudflare.com/ajax/libs/fitvids/1.0.1/jquery.fitvids.min.js', array('jquery', 'script'), '1.0.1', true);
        wp_enqueue_script('prettify', '//cdnjs.cloudflare.com/ajax/libs/prettify/r224/prettify.js', array('jquery', 'script'), '', true);
        wp_enqueue_script('fixto', get_template_directory_uri() . '/assets/js/fixto.min.js', array('jquery'), '', true);

        // Bootstrap Agenda files
        if (is_page_template("page-bootstrap-agenda-fs.php") ||
            is_page_template("page-bootstrap-agenda-visa.php") ||
            is_page_template("page-daily-agenda-fs.php") ||
            is_page_template("page-daily-agenda-visa.php") ||
            get_post_type() == 'event') {
            // Bootstrap 4
            wp_enqueue_script('bootstrap', '//stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js', '', '4.1.1', true);
            wp_enqueue_style('bootstrap', '//stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css');
            // Font Awesome 5.1.0
            wp_enqueue_style('fontawesome', '//use.fontawesome.com/releases/v5.1.0/css/all.css');
            // Custom styles
            wp_enqueue_style('agenda-style', get_template_directory_uri() . '/assets/css/agenda-styles.css');
        }

        // Flexslider
        wp_enqueue_script('flexslider', get_template_directory_uri() . '/assets/js/jquery.flexslider-min.js', array('jquery'), '', true);
        wp_enqueue_style('flexslider', get_template_directory_uri() . '/assets/css/flexslider.css');

        wp_enqueue_style('style', get_template_directory_uri() . '/style.css');
        wp_enqueue_style('fonts', get_template_directory_uri() . '/assets/fonts/fonts.css');
        wp_enqueue_style('user-style', get_template_directory_uri() . '/assets/css/user-styles.php');

        if (is_singular()) wp_enqueue_script('comment-reply'); // loads the javascript required for threaded comments

        // IE Scripts
        if ($is_IE) {
            wp_enqueue_script('html5shiv', '//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.1/html5shiv.js');
            wp_enqueue_script('selectivizr', '//cdnjs.cloudflare.com/ajax/libs/selectivizr/1.0.2/selectivizr-min.js');
            wp_enqueue_script('css3-mediaqueries', 'http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js');
        }

        // IE CSS
        if (strpos($_SERVER['HTTP_USER_AGENT'], "MSIE 8")) {
            wp_enqueue_style('ie8', get_template_directory_uri() . '/assets/css/ie.css');
        }
    }

}

add_action('wp_enqueue_scripts', 'stag_enqueue_scripts');

function stag_menu_footer_scripts()
{
    if (!is_home()) {
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                $('#navigation a').each(function () {
                    var re = /^#/g,
                        that = $(this),
                        url = '<?php echo home_url(); ?>',
                        attr = $(this).attr('href');
                    if (re.test(attr) === true) {
                        that.attr('href', url + "/" + attr);
                    }
                });
            });
        </script>
        <?php
    }
}

add_action('wp_footer', 'stag_menu_footer_scripts');


function stag_datpicker_scripts()
{
    global $pagenow;
    if (isset($_GET['post']) && $pagenow == "post.php" || $pagenow == "post-new.php") {
        wp_enqueue_script('jquery-ui-datepicker', get_template_directory_uri() . '/assets/js/jquery-ui-datepicker.js', array('jquery'));
//        wp_enqueue_script('jquery-ui-timepicker', '//cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-sliderAccess.js', array('jquery'));
//        wp_enqueue_script('jquery-ui-timepicker', '//cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/i18n/jquery-ui-timepicker-es.js', array('jquery'));
//        wp_enqueue_script('jquery-ui-timepicker', '//cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/i18n/jquery-ui-timepicker-addon-i18n.min.js', array('jquery'));
        wp_enqueue_style('jquery-ui-datepicker', get_template_directory_uri() . '/assets/css/jquery-ui-datepicker.css');
//        wp_enqueue_style('jquery-ui-timepicker', '//cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css');
    }
}

add_action('admin_enqueue_scripts', 'stag_datpicker_scripts');


/* Custom text length */
function stag_trim_text($text, $cut, $suffix = '...')
{
    if ($cut < strlen($text)) {
        return substr($text, '0', $cut) . $suffix;
    } else {
        return substr($text, '0', $cut);
    }
}

/* Pagination */
function pagination()
{
    global $wp_query;
    $total_pages = $wp_query->max_num_pages;
    if ($total_pages > 1) {
        if ($total_pages > 1) {
            $current_page = max(1, get_query_var('paged'));
            $return = paginate_links(array(
                'base' => get_pagenum_link(1) . '%_%',
                'format' => '/page/%#%',
                'current' => $current_page,
                'total' => $total_pages,
                'prev_next' => false
            ));
            echo "<div class='pages'>{$return}</div>";
        }
    } else {
        return false;
    }
}


/* Comments */
function stag_comments($comment, $args, $depth) {

    $isByAuthor = false;

    if ($comment->comment_author_email == get_the_author_meta('email')) {
        $isByAuthor = true;
    }

    $GLOBALS['comment'] = $comment; ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
        <div id="comment-<?php comment_ID(); ?>" class="the-comment">

            <div class="comment-body clearfix">
                <?php
                global $is_retina;
                if ($is_retina) {
                    echo get_avatar($comment, $size = '150');
                } else {
                    echo get_avatar($comment, $size = '100');
                }
                ?>

                <div class="inner-body">
                    <?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
                    <h3 class="comment-author"><?php echo get_comment_author_link(); ?></h3>

                    <p class="comment-date"><?php echo get_comment_date("U"); ?></p>
                    <?php if ($comment->comment_approved == '0') : ?>
                        <em class="moderation"><?php _e('Your comment is awaiting moderation.', 'stag') ?></em>
                    <?php endif; ?>
                    <div class="comment-text">
                        <?php comment_text() ?>
                    </div>
                </div>
            </div>

        </div>

        <?php
        }

        function stag_list_pings($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment; ?>
    <li id="comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?>
<?php }


// A little math stuff
function is_multiple($number, $multiple)
{
    return ($number % $multiple) == 0;
}

if (!function_exists('custom_excerpt_length')) {
    function custom_excerpt_length($length)
    {
        return stag_get_option('general_post_excerpt_length');
    }

    add_filter('excerpt_length', 'custom_excerpt_length', 999);
}

if (!function_exists('new_excerpt_more')) {
    function new_excerpt_more($more)
    {
        global $post;
        return ' <a class="read-more" data-through="gateway" data-postid="' . $post->ID . '" href="' . get_permalink($post->ID) . '">' . stag_get_option('general_post_excerpt_text') . '</a>';
    }

    add_filter('excerpt_more', 'new_excerpt_more');
}

function stag_social_class($value)
{
    $class = explode('_', $value);
    return end($class);
}

add_action('comment_post', 'ajaxify_comments', 20, 2);
function ajaxify_comments($comment_ID, $comment_status)
{
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        //If AJAX Request Then
        switch ($comment_status) {
            case '0':

                //notify moderator of unapproved comment
                wp_notify_moderator($comment_ID);
            case '1': //Approved comment
                echo "success";
                $commentdata =& get_comment($comment_ID, ARRAY_A);
                $post =& get_post($commentdata['comment_post_ID']);
                wp_notify_postauthor($comment_ID, $commentdata['comment_type']);
                break;

            default:
                echo "error";
        }
        exit;
    }
}

add_filter('get_comment_date', 'get_the_relative_time');
function get_the_relative_time($time = null)
{
    if (is_null($time)) $time = get_the_time("U");

    $time_diff = date("U") - $time; // difference in second

    $second = 1;
    $minute = 60;
    $hour = 60 * 60;
    $day = 60 * 60 * 24;
    $week = 60 * 60 * 24 * 7;
    $month = 60 * 60 * 24 * 7 * 30;
    $year = 60 * 60 * 24 * 7 * 30 * 365;

    if ($time_diff <= 120) {
        $output = "now";
    } elseif ($time_diff > $second && $time_diff < $minute) {
        $output = round($time_diff / $second) . " second";
    } elseif ($time_diff >= $minute && $time_diff < $hour) {
        $output = round($time_diff / $minute) . " minute";
    } elseif ($time_diff >= $hour && $time_diff < $day) {
        $output = round($time_diff / $hour) . " hour";
    } elseif ($time_diff >= $day && $time_diff < $week) {
        $output = round($time_diff / $day) . " day";
    } elseif ($time_diff >= $week && $time_diff < $month) {
        $output = round($time_diff / $week) . " week";
    } elseif ($time_diff >= $month && $time_diff < $year) {
        $output = round($time_diff / $month) . " month";
    } elseif ($time_diff >= $year && $time_diff < $year * 10) {
        $output = round($time_diff / $year) . " year";
    } else {
        $output = " more than a decade ago";
    }

    if ($output <> "now") {
        $output = (substr($output, 0, 2) <> "1 ") ? $output . "s" : $output;
        $output .= " ago";
    }

    return $output;
}

function seoUrl($string)
{
    //Lower case everything
    $string = strtolower($string);
    //Make alphanumeric (removes all other characters)
    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
    //Clean up multiple dashes or whitespaces
    $string = preg_replace("/[\s-]+/", " ", $string);
    //Convert whitespaces and underscore to dash
    $string = preg_replace("/[\s_]/", "-", $string);
    return $string;
}

function pn_get_attachment_id_from_url($attachment_url = '')
{

    global $wpdb;
    $attachment_id = false;

    // If there is no url, return.
    if ('' == $attachment_url)
        return;

    // Get the upload directory paths
    $upload_dir_paths = wp_upload_dir();

    // Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
    if (false !== strpos($attachment_url, $upload_dir_paths['baseurl'])) {

        // If this is the URL of an auto-generated thumbnail, get the URL of the original image
        $attachment_url = preg_replace('/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url);

        // Remove the upload path base directory from the attachment URL
        $attachment_url = str_replace($upload_dir_paths['baseurl'] . '/', '', $attachment_url);

        // Finally, run a custom database query to get the attachment ID from the modified attachment URL
        $attachment_id = $wpdb->get_var($wpdb->prepare("SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url));

    }

    return $attachment_id;
}

function get_meta_image($source = false, $size = 'medium', $alt = '', $class = '', $id = '', $print = false)
{
    if (!$source) return false;
    $source = str_replace('http://', 'https://', $source);
    $attachment_id = pn_get_attachment_id_from_url($source);
    $attr = array('class' => $class, 'alt' => $alt, 'id' => $id);
    $image = wp_get_attachment_image($attachment_id, $size, 0, $attr);
    if ($print) print $image;
    else return $image;
}

function my_mce_external_plugins($plugins)
{

    $plugins['anchor'] = '/wp-includes/js/tinymce/plugins/anchor/plugin.min.js';
    return $plugins;
}

add_filter('mce_external_plugins', 'my_mce_external_plugins');

function language_selector_list()
{
    if (function_exists('icl_get_languages')) {
        $languages = icl_get_languages('skip_missing=0&orderby=code');
        if (!empty($languages)) {
            echo '<ul>';
            foreach ($languages as $l) {
                $language_code = preg_split('/-/', icl_disp_language($l['language_code']));
                echo "<li><span>";
                if (!$l['active']) echo '<a href="' . $l['url'] . '">';
                echo $language_code[0];
                if (!$l['active']) echo '</a>';
                echo "</span></li>";
            }
            echo "</ul>";
        }
    }
}

function admin_add_wysiwyg_custom_field_textarea()
{ ?>
    <script type="text/javascript">/* <![CDATA[ */
        jQuery(document).ready(function() {
            if ( typeof( tinyMCE ) == "object" && jQuery(".dfx-mce-editor").length > 0) {
                var tinyMCEOpts = tinyMCEPreInit.mceInit['content'];
                tinyMCEOpts['selector'] = ".dfx-mce-editor,#content";
                tinyMCE.init(tinyMCEOpts);
            }
        })
        /* ]]> */</script>
<?php }
add_action( 'admin_print_footer_scripts', 'admin_add_wysiwyg_custom_field_textarea', 1 );

/* Include the StagFramework */
$tmpDir = get_template_directory();
require_once($tmpDir . '/framework/_init.php');
require_once($tmpDir . '/includes/_init.php');
require_once($tmpDir . '/includes/theme-customizer.php');

$language_terms = array('197', '198', '199', '200');

// Footer RSS content
function dfx_rss_content() {
    $result = "";
    $query = new WP_Query( 'posts_per_page=10' );
    if ( $query->have_posts() )  {
        while ($query->have_posts()) {
            $query->the_post();

            $title = get_the_title_rss();
            $query->reset_postdata();

            $excerpt = get_the_excerpt();
            $query->reset_postdata();

            $image = get_the_post_thumbnail($query->post->ID, 'archive-thumb');
            $query->reset_postdata();

            $permalink = esc_url( apply_filters( 'the_permalink_rss', get_permalink() ) );
            $query->reset_postdata();

            $result .= '<div class="feed-widget-stream-item"><strong class="item-title">' . $title . '</strong><br><div style="float:left;">' . $image . '</div>' . $excerpt . '<a href="' . $permalink . '" target="_blank"></a></div>';
        }
    }
    wp_reset_postdata();
    return $result;
}
