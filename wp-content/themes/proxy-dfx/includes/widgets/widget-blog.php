<?php
add_action('widgets_init', create_function('', 'return register_widget("stag_section_blog");'));

class stag_section_blog extends WP_Widget{
  function stag_section_blog(){
    $widget_ops = array('classname' => 'section-block', 'description' => __('Displays your recent blog post.', 'stag'));
    $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'stag_section_blog');
    $this->WP_Widget('stag_section_blog', __('Homepage: Blog Section', 'stag'), $widget_ops, $control_ops);
  }

  function widget($args, $instance){
    extract($args);

    // VARS FROM WIDGET SETTINGS
    $title = apply_filters('widget_title', $instance['title'] );
    $subtitle = $instance['subtitle'];

    echo $before_widget;

    ?>

    <!-- BEGIN #blog.section-block -->
    <section id="blog" class="section-block">
      <div class="inner-section">
        <?php
        if($subtitle != '') echo '<p class="sub-title">'.$subtitle.'</p>';
        echo $before_title.$title.$after_title;
        $s = get_option( 'sticky_posts' );
        $d_c= '';
        ?>
        <div class="grids">

        <div class="grid-6 featured-post">
          <?php

          if(count($s) != 0){
            $d_c = 'sticky';
            query_posts(array(
              'p' => array_pop($s),
              'posts_per_page' => 1,
              'orderby' => 'date'
            ));
          }else{
            query_posts(array(
              'posts_per_page' => 1,
              'orderby' => 'date'
            ));
          }

          if(have_posts()){
            while(have_posts()): the_post();
            ?>
            <div <?php post_class($d_c); ?>>
              <p class="pubdate"><?php the_time('F d Y'); ?></p>
              <h2><a data-through="gateway" data-postid="<?php the_ID(); ?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
              <div class="entry-content">
                <?php if(has_post_thumbnail()): ?>
                <a data-through="gateway" data-postid="<?php the_ID(); ?>" href="<?php the_permalink(); ?>">
                  <?php the_post_thumbnail(); ?>
                </a>
                <?php endif; ?>
                <?php the_excerpt(); ?>
              </div>
            </div>
            <?php
            endwhile;
          }
          wp_reset_postdata();
          ?>
        </div>
        <div class="grid-6 all-posts">
          <div id="blog-post-slider" class="flexslider">
            <ul class="slides">
              <?php
              $start = 4;
              $finish = 1;
              query_posts(array(
                'offset' => 1,
                'posts_per_page' => 1000,
              ));
              if(have_posts()): while(have_posts()): the_post();
              ?>

              <?php if(is_multiple($start, 4)): ?>
                <li>
              <?php endif; ?>
              <div class="row">
                <p class="pubdate"><?php the_time('F d Y'); ?></p>
                <h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" data-through="gateway" data-postid="<?php the_ID(); ?>"><?php the_title(); ?></a></h3>
              </div>
              <?php if(is_multiple($finish, 4)): ?>
                </li>
              <?php endif; ?>

              <?php
              $start++;
              $finish++;
              endwhile;
              endif;
              ?>
            </ul>
          </div>
        </div>


        </div>
        <!-- END .inner-section -->
      </div>

      <!-- END #blog.section-block -->
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

    <?php
  }
}

?>