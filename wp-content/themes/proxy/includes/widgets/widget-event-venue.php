<?php
add_action('widgets_init', create_function('', 'return register_widget("stag_event_venue");'));

class stag_event_venue extends WP_Widget{
  function stag_event_venue(){
    $widget_ops = array('classname' => 'section-block', 'description' => __('Event venue widget that shows an image, a map and the address.', 'stag'));
    $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'stag_event_venue');
    $this->WP_Widget('stag_event_venue', __('Homepage: Event Venue Widget', 'stag'), $widget_ops, $control_ops);
  }

  function widget($args, $instance){
    extract($args);

    // VARS FROM WIDGET SETTINGS
    $title = apply_filters('widget_title', $instance['title'] );
    $subtitle = $instance['subtitle'];
    if (function_exists('icl_object_id'))
        $post_id = icl_object_id($instance['post_id'], 'page', true, ICL_LANGUAGE_CODE);
    else
        $post_id = $instance['post_id'];
    $id = $instance['id'];

    echo $before_widget;

    ?>

    <!-- BEGIN #event-venue.section-block -->
    <section id="<?php echo stag_to_slug($id); ?>" class="section-block content-section event-venue">
      <div class="inner-section">
        <?php
        $the_event = get_post($post_id);

        if($subtitle != '') echo '<p class="sub-title">'.__($subtitle, 'stag').'</p>';

        if($title == ''){
          echo '<h2 class="widgettitle">'.$before_title.$the_event->post_title.$after_title.'</h2>';
        }else{
          echo '<h2 class="widgettitle">'.$before_title.$title.$after_title.'</h2>';
        }
        ?>
        <div class="entry-content">
          <p class="r">
            <img class="aligncenter size-full wp-image-3473" src="<?php echo get_post_meta(get_the_ID(), '_stag_event_venue_image', false)[0];?>" alt="<?php echo $the_event->post_title;?> Venue" height="183" width="860">
          </p>
          <p class="r"></p>
          <p class="r">
            <?php echo html_entity_decode(@get_post_meta($the_event->ID, '_stag_event_venue_iframe', false)[0]);?>
            <?php echo html_entity_decode(@get_post_meta($the_event->ID, '_stag_event_venue_text', false)[0]);?>
          <div class="clearfix"></div>
        </div>      
      </div>
      <!-- END #event-venue.section-block -->
    </section>

    <?php
    echo $after_widget;
  }

  function update($new_instance, $old_instance){
    $instance = $old_instance;

    // STRIP TAGS TO REMOVE HTML
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['subtitle'] = $new_instance['subtitle'];
    $instance['post_id'] = strip_tags($new_instance['post_id']);
    $instance['id'] = strip_tags($new_instance['id']);

    return $instance;
  }

  function form($instance){

    $defaults = array(
      /* Deafult options goes here */
      'page' => 0,
      'id' => 'venue'
    );

    $instance = wp_parse_args((array) $instance, $defaults);

    $options = array();
    $args = array(
      'post_type' => 'event',
      'post_status' => 'publish',
      'orderby' => 'title',
      'posts_per_page' => -1,
      'order' => 'ASC'
    );
    $the_query = new WP_Query($args);
    if($the_query->have_posts()){
      while($the_query->have_posts()): $the_query->the_post();
        $options[get_the_ID()] = get_the_title();
      endwhile;
    }
    /* HERE GOES THE FORM */
    ?>

    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo @$instance['title']; ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('Subtitle:', 'stag'); ?></label>
      <textarea rows="6" class="widefat" id="<?php echo $this->get_field_id( 'subtitle' ); ?>" name="<?php echo $this->get_field_name( 'subtitle' ); ?>"><?php echo @$instance['subtitle']; ?></textarea>
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('post_id'); ?>"><?php _e('Event:', 'stag'); ?></label>
      <select class="widefat" id="<?php echo $this->get_field_id( 'post_id' ); ?>" name="<?php echo $this->get_field_name( 'post_id' ); ?>">
        <?php
        foreach ($options as $key => $value) {
          # code...
          if (@$instance['post_id'] == $key)
            $selected = 'selected="selected"';
          else
            $selected = '';
          ?>
          <option value="<?= $key;?>" <?= $selected;?>><?= $value;?></option>
          <?php
        }
        ?>
      </select>
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('id'); ?>"><?php _e('Section ID:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'id' ); ?>" name="<?php echo $this->get_field_name( 'id' ); ?>" value="<?php echo @$instance['id']; ?>" />
      <span class="description">Section ID is required if you want to use this section as a navigation. e.g. about, and add a custom link under Menus with link #about.</span>
    </p>

    <?php
  }
}
?>