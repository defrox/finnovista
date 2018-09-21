<?php
add_action('widgets_init', create_function('', 'return register_widget("stag_section_about");'));

class stag_section_about extends WP_Widget{
  function stag_section_about(){
    $widget_ops = array('classname' => 'section-block', 'description' => __('Show info about your site from specific page.', 'stag'));
    $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'stag_section_about');
    $this->WP_Widget('stag_section_about', __('Homepage: Content Section', 'stag'), $widget_ops, $control_ops);
  }

  function widget($args, $instance){
    extract($args);

    // VARS FROM WIDGET SETTINGS
    $title = apply_filters('widget_title', $instance['title'] );
    $subtitle = $instance['subtitle'];
    $page = $instance['page'];
    $id = $instance['id'];

    echo $before_widget;

    ?>

    <!-- BEGIN #about.section-block -->
    <section id="<?php echo stag_to_slug($id); ?>" class="section-block content-section">

      <div class="inner-section">

        <?php
        $the_page = get_page($page);

        if($subtitle != '') echo '<p class="sub-title">'.$subtitle.'</p>';

        if($title == ''){
          echo $before_title.$the_page->post_title.$after_title;
        }else{
          echo $before_title.$title.$after_title;
        }

        echo '<div class="entry-content">'.do_shortcode($the_page->post_content).'</div>';
        ?>

      </div>

      <!-- END #about.section-block -->
    </section>

    <?php
    echo $after_widget;
  }

  function update($new_instance, $old_instance){
    $instance = $old_instance;

    // STRIP TAGS TO REMOVE HTML
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['subtitle'] = strip_tags($new_instance['subtitle']);
    $instance['page'] = strip_tags($new_instance['page']);
    $instance['id'] = strip_tags($new_instance['id']);

    return $instance;
  }

  function form($instance){
    $defaults = array(
      /* Deafult options goes here */
      'page' => 0,
      'id' => 'about'
    );

    $instance = wp_parse_args((array) $instance, $defaults);

    /* HERE GOES THE FORM */
    ?>

    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo @$instance['title']; ?>" />
      <span class="description">Leave blank to use default page title.</span>
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('Sub Title:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'subtitle' ); ?>" name="<?php echo $this->get_field_name( 'subtitle' ); ?>" value="<?php echo @$instance['subtitle']; ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('page'); ?>"><?php _e('Select Page:', 'stag'); ?></label>

      <select id="<?php echo $this->get_field_id( 'page' ); ?>" name="<?php echo $this->get_field_name( 'page' ); ?>" class="widefat">
      <?php

        $args = array(
          'sort_order' => 'ASC',
          'sort_column' => 'post_title',
          );
        $pages = get_pages($args);

        foreach($pages as $paged){ ?>
          <option value="<?php echo $paged->ID; ?>" <?php if($instance['page'] == $paged->ID) echo "selected"; ?>><?php echo $paged->post_title; ?></option>
        <?php }

       ?>
     </select>
     <span class="description">This page will be used to display content.</span>
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