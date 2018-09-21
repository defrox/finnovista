<?php
add_action('widgets_init', create_function('', 'return register_widget("stag_section_team");'));

class stag_section_team extends WP_Widget{
  function stag_section_team(){
    $widget_ops = array('classname' => 'section-block', 'description' => __('Displays your team members and their info.', 'stag'));
    $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'stag_section_team');
    $this->WP_Widget('stag_section_team', __('Homepage: Team Section', 'stag'), $widget_ops, $control_ops);
  }

  function widget($args, $instance){
    extract($args);

    // VARS FROM WIDGET SETTINGS
    $title = apply_filters('widget_title', $instance['title'] );
    $subtitle = $instance['subtitle'];

    echo $before_widget;

    ?>

    <!-- BEGIN #team.section-block -->
    <section id="team" class="section-block">
      <div class="inner-section">

		<!-- mentor  -->
        <?php
          //if($subtitle != '') echo '<p class="sub-title">'.$subtitle.'</p>';
          //echo '<br/>'.$before_title . 'Mentores' . $after_title;
			echo '<h2 class="main-title">Speakers</h2>';

          $args = array(
              'post_type' => 'team',
               'posts_per_page' => -1,
          );
          //$the_query = new WP_Query($args);
          $the_query = new WP_Query(array( 'post_type' => 'team','meta_value' => 'speaker','posts_per_page' => -1 ));
        ?>

        <div class="team-members">
          <?php
            if($the_query->have_posts()){
              while($the_query->have_posts()): $the_query->the_post();
              ?>
              <div class="member">
                  <?php if(has_post_thumbnail()): ?>
                  <div class="member-pic">
                    <?php the_post_thumbnail('full'); ?>

                    <div class="member-links">

                      <?php if(get_post_meta(get_the_ID(), '_stag_team_url_twitter', true) != ''): ?>
                        <a href="<?php echo get_post_meta(get_the_ID(), '_stag_team_url_twitter', true); ?>" class="twitter"></a>
                      <?php endif ?>
	
                      <?php if(get_post_meta(get_the_ID(), '_stag_team_url_linkedin', true) != ''): ?>
                        <a href="<?php echo get_post_meta(get_the_ID(), '_stag_team_url_linkedin', true); ?>" class="linkedin"></a>
                      <?php endif ?>
                    </div>
                  </div>
                  <?php endif; ?>
                  <div class="member-description">
                    <p class="member-title"><a href="/listado-speakers/#<?php print get_the_ID(); ?>"><?php the_title(); ?></a></p>
                    <?php if(get_post_meta(get_the_ID(), '_stag_team_position', true) != '') echo '<p class="member-position">'.get_post_meta(get_the_ID(), '_stag_team_position', true).'</p>'; ?>
                  </div>
                </div>
              <?php
              endwhile;
            }
            wp_reset_postdata();
          ?>
        </div>
	 <div class="team-text">
		<strong>Pr&oacute;ximamente tendremos m&aacute;s informaci&oacute;n. Si est&aacute;s interesado en participar como ponente, por favor cont&aacute;ctanos en <a href="mailto:hola@nextbankbogota.com">hola@nextbankbogota.com</a>.</strong>
        </div> 
        <!-- end mentor -->
 
		
      </div>

      <!-- END #team.section-block -->
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
