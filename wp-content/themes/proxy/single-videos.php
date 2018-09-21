<?php get_header(); ?>  
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>    
<div class='single-video'>    
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <h2 class="entry-title"><?php the_title(); ?></h2>
        <div class="featured-image-content clearfix">
		</div>
        <div class="entry-content clearfix">
            <?php the_content(); ?>
            <p><?php the_excerpt(); ?></p>
        </div>
    </article>
  </div>
<?php endwhile; ?>  
<span style="float:left;margin:-25px 0 50px 70px;"><?php previous_post('&laquo; %', '', 'yes'); ?></span>
<span style="float:right;margin: -25px 70px 50px 0;"><?php next_post('% &raquo; ', '', 'yes'); ?></span>
<?php //comments_template('', true); ?>

<?php
	function disqus_embed($disqus_shortname) {
		global $post;
		wp_enqueue_script('disqus_embed','http://'.$disqus_shortname.'.disqus.com/embed.js');
		echo '<div id="disqus_thread"></div>
		<script type="text/javascript">
		    var disqus_shortname = "'.$disqus_shortname.'";
		    var disqus_title = "'.$post->post_title.'";
		    var disqus_url = "'.get_permalink($post->ID).'";
		    var disqus_identifier = "'.$disqus_shortname.'-'.$post->ID.'";
		</script>';
	}
	
	disqus_embed('finnovar'); 
?>


<?php endif; ?>
<div class="clearfix"></div>        
<?php get_footer() ?>     
