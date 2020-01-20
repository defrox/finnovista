<?php get_header(); ?>
<section id="blog" class="section-block">
<?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array( 'post_type' => 'post', 'posts_per_page' => 10, 'paged' => $paged );

function dfx_excerpt_more( $more ) {
	return ' <a data-through="no-gateway" data-postid="' . get_the_ID() . '" href="' . get_permalink() . '" title="' . get_the_title() . '">[+]</a>';
}
add_filter('excerpt_more', 'dfx_excerpt_more');

$wp_query = new WP_Query($args); ?>
<?php //$posts=query_posts($query_string . '&posts_per_page=-1'); ?>
<?php $posts=query_posts($query_string); ?>
    <div class="inner-section">
<h1 class="main-title"><?php _e('Search Results');?></h1>           
    
<?php if (have_posts()) : ?>

<?php
$postCount = 0;
while ( have_posts() ) : the_post(); $postCount++; ?>
            <div <?php post_class($d_c); ?>>
              <p class="pubdate"><?php the_time('F d Y'); ?> | <?php the_author_link(); ?></p>
              <h2><a data-through="no-gateway" data-postid="<?php the_ID(); ?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
              <div class="entry-content">
                <?php if(has_post_thumbnail()): ?>
                <a data-through="no-gateway" data-postid="<?php the_ID(); ?>" href="<?php the_permalink(); ?>">
                  <?php the_post_thumbnail(); ?>
                </a>
                <?php endif; ?>
                <?php the_excerpt(); ?>
				<div class="clear"></div>
                <div class="frame-tags"><?php the_tags( '<h5>' . __('Tags') . ':</h5> ', ' ', '' ); ?></div>
                <?php //wp_list_categories( 'style=none&title_li=<h5>'.__('Categories') . ':</h5> '); ?> 
                <div class="frame-categories"><h5><?php _e('Categories'); ?>: </h5> <?php wp_get_post_categories( get_the_ID() );
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
				<?php if ($postCount != sizeof($posts)): ?>
				<!-- NO LAST POST IN LOOP -->
				<div class="clear"></div>
                        <hr />     
<?php endif; ?>
<?php endwhile; ?>
<?php else: ?>
<div class="inner-section"><p><?php _e('No results found.'); ?></p></div>
<?php the_widget('stag_section_search'); ?> 
<?php endif; ?>

<!-- then the pagination links -->
<?php next_posts_link( '&laquo; ' . __('Older Posts') ); ?>
<?php previous_posts_link( __('Recent Posts') . ' &raquo;' ); ?>
</div></div> 

</section> 
<?php get_footer(); ?>
<script type="text/javascript">
      jQuery(document).ready(function($){
        $('#navigation a').each(function(){
          var re = /^#/g,
              that = $(this),
              url = 'index.php',
              attr = $(this).attr('href');
          that.click(function($){
          location.href = attr.replace('#','index.php#section=');
          });
        });
      });
    </script>