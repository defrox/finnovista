<?php
// =============================== My Social Networks Widget ====================================== //
class My_SocialNetworksWidget extends WP_Widget {

	function My_SocialNetworksWidget() {
		$widget_ops = array('classname' => 'social_networks_widget', 'description' => __('Link to your social networks.'));
		$this->WP_Widget('social_networks', __('My - Social Networks'), $widget_ops, $control_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		
		$networks['Google+']['link'] = $instance['google+'];
		$networks['Twitter']['link'] = $instance['twitter'];
		$networks['Flickr']['link'] = $instance['flickr'];
		$networks['Feed']['link'] = $instance['feed'];
		$networks['Linkedin']['link'] = $instance['linkedin'];
		
		$networks['Google+']['label'] = $instance['google+_label'];	
		$networks['Twitter']['label'] = $instance['twitter_label'];
		$networks['Flickr']['label'] = $instance['flickr_label'];
		$networks['Feed']['label'] = $instance['feed_label'];
		$networks['Linkedin']['label'] = $instance['linkedin_label'];

		$display = $instance['display'];
		

		echo $before_widget;
		if ( $title )
    		echo $before_title . $title . $after_title;
		?>
		
			<ul class="social-networks">
				
					<?php foreach(array("Google+", "Linkedin", "Feed", "Flickr", "Twitter") as $network) : ?>
			    		<?php if (!empty($networks[$network]['link'])) : ?>
						<li>
							<a rel="external" title="<?php echo strtolower($network); ?>" href="<?php echo $networks[$network]['link']; ?>">
						    		<?php if (($display == "both") or ($display =="icons")) { ?>
									<img src="<?php bloginfo('stylesheet_directory'); ?>/images/icons/<?php echo strtolower($network);?>.png" alt="">
								<?php } if (($display == "labels") or ($display == "both")) { ?> 
									<?php if (($networks[$network]['label'])!=="") { echo $networks[$network]['label']; } else { echo $network; } ?>
								<?php } ?>
							</a>
						</li>
					<?php endif; ?>
					<?php endforeach; ?>
			      
      		</ul>
      
		<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		
		$instance['google+'] = $new_instance['google+'];
		$instance['twitter'] = $new_instance['twitter'];
		$instance['flickr'] = $new_instance['flickr'];
		$instance['feed'] = $new_instance['feed'];
		$instance['linkedin'] = $new_instance['linkedin'];
		
		$instance['google+_label'] = $new_instance['google+_label'];
		$instance['twitter_label'] = $new_instance['twitter_label'];
		$instance['flickr_label'] = $new_instance['flickr_label'];
		$instance['feed_label'] = $new_instance['feed_label'];
		$instance['linkedin_label'] = $new_instance['linkedin_label'];

		$instance['display'] = $new_instance['display'];

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
		$title = strip_tags($instance['title']);
		
		$gplus = $instance['google+'];	
		$twitter = $instance['twitter'];		
		$flickr = $instance['flickr'];		
		$feed = $instance['feed'];
		$linkedin = $instance['linkedin'];	
		
		$gplus_label = $instance['google+_label'];
		$twitter_label = $instance['twitter_label'];
		$flickr_label = $instance['flickr_label'];
		$feed_label = $instance['feed_label'];
		$linkedin_label = $instance['linkedin_label'];

		$display = $instance['display'];		


		$text = format_to_edit($instance['text']);
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
		
	<fieldset style="border:1px solid #dfdfdf; padding:10px 10px 0; margin-bottom:1em;">
			<legend style="padding:0 5px;"><?php _e('Google+'); ?>:</legend>	
		<p><label for="<?php echo $this->get_field_id('google+'); ?>"><?php _e('Google+ URL:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('google+'); ?>" name="<?php echo $this->get_field_name('google+'); ?>" type="text" value="<?php echo esc_attr($gplus); ?>" /></p>
        <p><label for="<?php echo $this->get_field_id('google+_label'); ?>"><?php _e('Google+ label:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('google+_label'); ?>" name="<?php echo $this->get_field_name('google+_label'); ?>" type="text" value="<?php echo esc_attr($gplus_label); ?>" /></p>
        </fieldset>	
    
        <fieldset style="border:1px solid #dfdfdf; padding:10px 10px 0; margin-bottom:1em;">
			<legend style="padding:0 5px;"><?php _e('Twitter'); ?>:</legend>	
		<p><label for="<?php echo $this->get_field_id('twitter'); ?>"><?php _e('Twitter URL:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" type="text" value="<?php echo esc_attr($twitter); ?>" /></p>
        <p><label for="<?php echo $this->get_field_id('twitter_label'); ?>"><?php _e('Twitter label:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('twitter_label'); ?>" name="<?php echo $this->get_field_name('twitter_label'); ?>" type="text" value="<?php echo esc_attr($twitter_label); ?>" /></p>
        </fieldset>	
		
        <fieldset style="border:1px solid #dfdfdf; padding:10px 10px 0; margin-bottom:1em;">
			<legend style="padding:0 5px;"><?php _e('Flickr'); ?>:</legend>
		<p><label for="<?php echo $this->get_field_id('flickr'); ?>"><?php _e('Flickr URL:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('flickr'); ?>" name="<?php echo $this->get_field_name('flickr'); ?>" type="text" value="<?php echo esc_attr($flickr); ?>" /></p>
        <p><label for="<?php echo $this->get_field_id('flickr_label'); ?>"><?php _e('Flickr label:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('flickr_label'); ?>" name="<?php echo $this->get_field_name('flickr_label'); ?>" type="text" value="<?php echo esc_attr($flickr_label); ?>" /></p>
        </fieldset>	
		
        <fieldset style="border:1px solid #dfdfdf; padding:10px 10px 0; margin-bottom:1em;">
			<legend style="padding:0 5px;"><?php _e('RSS feed'); ?>:</legend>
		<p><label for="<?php echo $this->get_field_id('feed'); ?>"><?php _e('RSS feed:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('feed'); ?>" name="<?php echo $this->get_field_name('feed'); ?>" type="text" value="<?php echo esc_attr($feed); ?>" /></p>
        <p><label for="<?php echo $this->get_field_id('feed_label'); ?>"><?php _e('RSS label:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('feed_label'); ?>" name="<?php echo $this->get_field_name('feed_label'); ?>" type="text" value="<?php echo esc_attr($feed_label); ?>" /></p>
        </fieldset>	
    
    <fieldset style="border:1px solid #dfdfdf; padding:10px 10px 0; margin-bottom:1em;">
			<legend style="padding:0 5px;"><?php _e('Linkedin'); ?>:</legend>
    <p><label for="<?php echo $this->get_field_id('linkedin'); ?>"><?php _e('Linkedin URL:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('linkedin'); ?>" name="<?php echo $this->get_field_name('linkedin'); ?>" type="text" value="<?php echo esc_attr($linkedin); ?>" /></p>
        <p><label for="<?php echo $this->get_field_id('linkedin_label'); ?>"><?php _e('Linkedin label:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('linkedin_label'); ?>" name="<?php echo $this->get_field_name('linkedin_label'); ?>" type="text" value="<?php echo esc_attr($linkedin_label); ?>" /></p>
        </fieldset>	

		<p>Display:</p>
		<label for="<?php echo $this->get_field_id('icons'); ?>"><input type="radio" name="<?php echo $this->get_field_name('display'); ?>" value="icons" id="<?php echo $this->get_field_id('icons'); ?>" <?php checked($display, "icons"); ?>></input>  Icons</label>
		<label for="<?php echo $this->get_field_id('labels'); ?>"><input type="radio" name="<?php echo $this->get_field_name('display'); ?>" value="labels" id="<?php echo $this->get_field_id('labels'); ?>" <?php checked($display, "labels"); ?>></input> Labels</label>
		<label for="<?php echo $this->get_field_id('both'); ?>"><input type="radio" name="<?php echo $this->get_field_name('display'); ?>" value="both" id="<?php echo $this->get_field_id('both'); ?>" <?php checked($display, "both"); ?>></input> Both</label>

    
<?php
	}
}

add_action('widgets_init', create_function('', 'return register_widget("My_SocialNetworksWidget");'));


?>