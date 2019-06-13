<?php get_header(); ?>  
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>    
	<div class='hfeed'>    
	    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	        <h2 class="entry-title"><?php the_title(); ?></h2>
	        <div class="featured-image-content clearfix">
			</div>                                      
	        <div class="entry-content clearfix">
	            <?php the_content(); ?>
	        </div>
	    </article>
  	</div>
<?php endwhile; ?>  
<span style="float:left;margin:-25px 0 50px 70px;"><?php previous_post_link('&laquo; %link'); ?></span>
<span style="float:right;margin: -25px 70px 50px 0;"><?php next_post_link('%link &raquo; '); ?></span>
<?php comments_template('', true); ?>
<?php endif; ?>        
<?php get_footer() ?>     