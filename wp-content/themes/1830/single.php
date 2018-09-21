<?php get_header(); ?>

	<div id="content" class="grid_7 <?php echo of_get_option('blog_sidebar_pos'); if (of_get_option('blog_sidebar_pos')=='right') {echo ' suffix_1';} ?>">
		
		
		<?php 
                
			if (have_posts()) : while (have_posts()) : the_post(); 
			
					// The following determines what the post format is and shows the correct file accordingly
					$format = get_post_format();
					get_template_part( 'includes/post-formats/'.$format );
					
					if($format == '')
					get_template_part( 'includes/post-formats/standard' ); ?>
					
    
		<?php get_template_part( 'includes/post-formats/related-posts' ); ?>
		
		
		
		<?php comments_template('', true); ?>
		
		
		<?php endwhile; endif; ?>
    

	</div><!--#content-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>