<?php
add_action('widgets_init', create_function('', 'return register_widget("stag_section_work");'));

class stag_section_work extends WP_Widget{
  function stag_section_work(){
    $widget_ops = array('classname' => 'section-block', 'description' => __('Showcase your work from Portfolio section.', 'stag'));
    $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'stag_section_work');
    $this->WP_Widget('stag_section_work', __('Homepage: Work Section', 'stag'), $widget_ops, $control_ops);
  }

  function widget($args, $instance){
    extract($args);

    // VARS FROM WIDGET SETTINGS
    $title = apply_filters('widget_title', $instance['title'] );
    $subtitle = $instance['subtitle'];

    echo $before_widget;

    ?>

    <!-- BEGIN #work.section-block -->
    <section id="work" class="section-block">

      <div class="inner-section">

        <?php
          if($subtitle != '') echo '<p class="sub-title">'.__($subtitle, 'stag').'</p>';
          echo $before_title . $title . $after_title;

          $args = array(
              'post_type' => 'portfolio',
              'posts_per_page' => stag_get_option('homepage_portfolio_count'),
          );
          $the_query = new WP_Query($args);
        ?>

        <!-- BEGIN #portfolio-slider -->
        <div id="portfolio-slider" class="">
          <ul class="grids">
            <?php
              if($the_query->have_posts()){
                while($the_query->have_posts()): $the_query->the_post();
                ?>
                  <li class="grid-6">
                    <a href="<?php the_permalink(); ?>" data-through="gateway" data-postid="<?php the_ID(); ?>">
                      <div class="portfolio-content">
                        <h3><?php the_title(); ?></h3><i class="icon-open"></i>
                      </div>
                    </a>
                    <?php
                      if(has_post_thumbnail()){
                        echo the_post_thumbnail('portfolio-thumb');
                      }

                    ?>
                  </li>
                <?php
                endwhile;
              }
              wp_reset_postdata();
            ?>
          </ul>
        <!-- END #portfolio-slider -->
        </div>
      </div>

      <!-- END #work.section-block -->
    </section>

    <?php
    echo $after_widget;
  }

  function update($new_instance, $old_instance){
    $instance = $old_instance;

    // STRIP TAGS TO REMOVE HTML
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['subtitle'] = strip_tags($new_instance['subtitle']);

    return $instance;
  }

  function form($instance){
    $defaults = array(
      /* Deafult options goes here */
      'page' => 0
    );

    $instance = wp_parse_args((array) $instance, $defaults);

    /* HERE GOES THE FORM */
    ?>

    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo @$instance['title']; ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('Sub Title:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'subtitle' ); ?>" name="<?php echo $this->get_field_name( 'subtitle' ); ?>" value="<?php echo @$instance['subtitle']; ?>" />
    </p>

    <?php
  }
}

?>