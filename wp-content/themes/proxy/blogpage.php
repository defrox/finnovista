<?php
/*
 * Template Name: Blogpage
 * Description: A Page Template with a darker design. 
 */
 ?>
<?php get_header(); ?>

<section id="blog" class="section-block">
<div class="inner-section">
<h1 class="main-title"><a href="<?php echo site_url(); ?>/blog/">Blog</a></h1>
<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array( 'post_type' => 'post', 'posts_per_page' => 5, 'paged' => $paged );
$wp_query = new WP_Query($args);

$postCount = 0;
while ( $wp_query->have_posts() ) : $wp_query->the_post(); $postCount++; ?>
            <div <?php post_class($d_c); ?>>
              <p class="pubdate"><?php the_time('F d Y'); ?> | <?php the_author_link(); ?></p>
              <h2><a data-through="no-gateway" data-postid="<?php the_ID(); ?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2> 
              <div class="entry-content">
				  <div class="entry-content-left">
                <?php if(has_post_thumbnail()): ?>
                <a data-through="no-gateway" data-postid="<?php the_ID(); ?>" href="<?php the_permalink(); ?>">
                  <?php the_post_thumbnail(); ?>
                </a>
                <?php endif; ?>
                <a class="comments_number_disqus" href="<?php the_permalink();?>#disqus_thread"></a>
                </div>
                <?php the_excerpt(); ?>                   
				        <div class="clear"></div>
                <div class="frame-tags"><?php the_tags( '<h5>' . __('Tags') . ':</h5> ', ' ', '' ); ?></div>
                <?php //wp_list_categories( 'style=none&title_li=<h5>'.__('Categories') . ':</h5> '); ?> 
                <div class="frame-categories"> <h5><?php _e('Categories'); ?>: </h5> <?php wp_get_post_categories( get_the_ID() );
$post_categories = wp_get_post_categories( get_the_ID() );
$cats = $cats_name = array();
	
foreach($post_categories as $c){
	$cat = get_category( $c );
	$cats[] = array( 'name' => $cat->name, 'slug' => $cat->slug );
	$cats_name[] = '<a href="' . home_url().'/?cat='. $cat->cat_ID . '">' . $cat->name .'</a>';  
}            
echo implode(' ' , $cats_name);    
                 ?> 
				</div>				 
              </div>
            </div> 
			<br/>
            <?php 
			//$posts_per_page = get_option('posts_per_page'); echo $postCount . " " . $wp_query->found_posts . " " . $posts_per_page . " " . $wp_query->post_count;  
				if ($postCount != $wp_query->post_count) { ?>
					<!-- LAST POST IN LOOP -->
					<div class="clear"></div>
                    <hr />
			<?php 
			} ?>       
<?php endwhile; ?>   
<!-- then the pagination links -->
<?php next_posts_link( '&laquo; ' . __('Older Posts') ); ?>
<div style="float: right"><?php previous_posts_link( __('Recent Posts') . ' &raquo;' );  ?></div>
<!-- Resetea la barra de navegacion -->
<?php wp_reset_query(); ?>
</div>
</section>
<?php get_footer(); ?>  