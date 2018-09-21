<?php
add_action('widgets_init', create_function('', 'return register_widget("stag_slider_widget");'));

class stag_slider_widget extends WP_Widget{
  function stag_slider_widget(){
    $widget_ops = array('classname' => 'stag-slider', 'description' => __('Display your slides from custom post type Slides.', 'stag'));
    $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'stag_slider_widget');
    $this->WP_Widget('stag_slider_widget', __('Homepage: Custom Slides', 'stag'), $widget_ops, $control_ops);
  }

  function widget($args, $instance){
    extract($args);

    echo $before_widget;

    echo do_shortcode('[stag_slider]');

    echo $after_widget;
  }

  function update($new_instance, $old_instance){
    $instance = $old_instance;
    return $instance;
  }

  function form($instance){
    $defaults = array(

      );

    $instance = wp_parse_args((array) $instance, $defaults);

    /* HERE GOES THE FORM */
    ?>

    <p>
      <span class="description">Yay! No options to set!</span>
    </p>

    <?php
  }
}