<?php
/*
 * Template Name: Videos Page
 * Description: A Page Template with a darker design.
 */
 ?>
<?php get_header(); ?>

<section id="videos" class="section-block videos">
	<div class="inner-section">
		<h2 class="main-title"><?php _e('Videos');?></h2>
	</div>
      <div class="inner-section"><div class="grid-12">
        <?php
          $args = array(
              'post_type' => 'videos',
              'posts_per_page' => -1,
          );
          $the_query = new WP_Query($args);
        ?>     
        <div class="video-item">
          <?php
            if($the_query->have_posts()){
              $i = 0;
              while($the_query->have_posts()): $the_query->the_post();
              ?>
              <div id="<?php print get_the_ID() ?>"><p></p></div>
              <div class="entry-content">
                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                <?php the_post_thumbnail( 'medium' ); ?>
                <h3><?php the_title(); ?></h3>
                <div class="overlay"><?php the_excerpt(); ?></div>
                </a>
                               
              </div> 
               <a class="comments_number_disqus" href="<?php the_permalink();?>#disqus_thread"></a>  
                        
              
              <?php
              $i++;
              endwhile;
            }
            wp_reset_postdata();
          ?>
        </div> 
        
                
      </div> </div>
<div class="clearfix"></div>
</section>
<?php get_footer() ?>   
