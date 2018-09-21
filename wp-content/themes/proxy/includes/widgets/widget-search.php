<?php
add_action('widgets_init', create_function('', 'return register_widget("stag_section_search");'));

class stag_section_search extends WP_Widget{
  function stag_section_search(){
    $widget_ops = array('classname' => 'section-block', 'description' => __('Displays the search box with tags and categories.', 'stag'));
    $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'stag_section_search');
    $this->WP_Widget('stag_section_search', __('Homepage: Search Section', 'stag'), $widget_ops, $control_ops);
  }

  function widget($args, $instance){
    extract($args);

    // VARS FROM WIDGET SETTINGS
    $title = apply_filters('widget_title', $instance['title'] );
    $subtitle = $instance['subtitle'];

    echo $before_widget;
    ?>

    <!-- BEGIN #search.section-block -->
    <section id="search" class="section-block">
      <div class="inner-section">
        <?php
        if($subtitle != '') echo '<p class="sub-title">'.__($subtitle, 'stag').'</p>';
        echo $before_title.$title.$after_title;
        $s = get_option( 'sticky_posts' );
        $d_c= '';
        ?>
        <div class="grids">
        <!-- B�squeda //-->
        <div class="grid-12 featured-post">
	 <form class="quick_search" method="post" id="dfx_search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
<p>
<input type="text" name="s" id="s" value="<?php _e('Search for:'); ?>" onfocus="if(!this._haschanged){this.value=''};this._haschanged=true;" />   <input type="submit" value="<?php  _e('Search') ; ?>">
</p>
</form>
        </div>
        <!-- Etiquetas //-->
        <div class="grid-12 featured-post frame-tags">
          <h5><?php _e('Tags') ; ?></h5><?php wp_tag_cloud('smallest=12&largest=12'); ?>
        </div>  
		<br/><br/>
        <!-- Categorias //-->
        <div class="grid-12 featured-post category-list frame-categories">
          <h5><?php _e('Categories'); ?></h5>
		  <?php 
			$category_links = array();
			$categories = get_terms( 'category' );
			if( !is_wp_error( $categories ) ) {
			foreach( $categories as $order => $category ) {
			?>
			
			<?php 
				$url = esc_url( get_category_link( $category->term_id ) );
				$title = esc_attr( $category->name );
				$text = esc_html( $category->name );
				$category_links[] = "\n" . '<a href="' . $url . '" title="' . $title . '" >' . $text . '</a> ';
				?> <?php
			}
			}
			$category_links_count = count( $category_links );
			if( $category_links_count > 1 )
			print implode( ' ', $category_links );
			else if( $category_links_count === 1 )
			print $category_links_count[0];
		  ?>   
        </div>

        </div>
        <!-- END .inner-section -->
      </div>

      <!-- END #search.section-block -->
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