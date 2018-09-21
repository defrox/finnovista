<?php
function dfx_widget($atts) {

    global $wp_widget_factory;

    extract(shortcode_atts(array(
        'widget_name' => FALSE,
        'instance' => ''
    ), $atts));

    $widget_name = esc_html($widget_name);
    $instance = str_ireplace("&amp;", '&' ,$instance);

    if (!is_a($wp_widget_factory->widgets[$widget_name], 'WP_Widget')):
        $wp_class = 'WP_Widget_'.ucwords(strtolower($class));

        if (!is_a($wp_widget_factory->widgets[$wp_class], 'WP_Widget')):
            return '<p>'.sprintf(__("%s: Widget class not found. Make sure this widget exists and the class name is correct"),'<strong>'.$class.'</strong>').'</p>';
        else:
            $class = $wp_class;
        endif;
    endif;

    ob_start();
    the_widget($widget_name, $instance, array('widget_id'=>'arbitrary-instance-'.$id,
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => ''
    ));
    $output = ob_get_contents();
    ob_end_clean();
    return $output;

}
add_shortcode('dfx_widget','dfx_widget');

// Usage [dfx_widget widget_name="stag_section_logo_category" instance="title=Pages&subtitle=asdf&category=1&area=2&fscity=3&pdcity=4&more_link=on&subtext=hello&describe=off&number_posts=10&id=hare"]

?>