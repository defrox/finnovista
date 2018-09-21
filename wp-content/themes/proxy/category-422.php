<?php get_header(); ?>
<section id="blog" class="section-block">
<?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array( 'post_type' => 'post', 'posts_per_page' => 10, 'paged' => $paged );
$cat_name = get_query_var('cat');
$wp_query = new WP_Query($args); ?>
                 <?php $posts=query_posts($query_string . '&posts_per_page=-1&cat='.$cat_name); ?>
<div class="inner-section">
<h1 class="main-title"><?php echo get_cat_name($cat_name); ?></h1>
<div>
Si deseas recibir más información sobre Finnovista o asistir como medio de comunicación o blogger a alguno de nuestros eventos, por favor envíanos un email a communication@finnovista.com será un placer proporcionarte toda la información necesaria.
</div>
<p></p>               
<?php if (have_posts()) : ?>

<?php                                  
$postCount = 0;
while ( have_posts() ) : the_post(); $postCount++;
                                $terms = get_the_terms(get_the_ID(), 'category');
                                $pd_tag = $pd_css = $pd_color = $pd_tag2 = $pd_css2 = $pd_color2 = $setted = $setted2 = false;
                                if (sizeof($terms) > 0 && is_array($terms)) {
                                    foreach ($terms as $term) {
                                        if ($term->parent == 87) {
                                            $pd_tag = $term->name;
                                            $pd_css = $term->slug;
                                            $pd_color = $term->description;
                                            $setted = true;
                                        } elseif ($category == 87 && !$setted) {
                                            $pd_tag = '&nbsp;';
                                            $pd_css = '';
                                            $pd_color = '';
                                        }
                                    }
                                };
                                $terms2 = get_the_terms(get_the_ID(), 'post_tag');
                                global $language_terms;
                                if (sizeof($terms2) > 0 && is_array($terms2)) {
                                    foreach ($terms2 as $term2) {
                                        if (in_array($term2->term_id, $language_terms) && !$setted2) {
                                            $pd_tag2 = $term2->name;
                                            $pd_css2 = $term2->slug;
                                            $pd_color2 = $term2->description;
                                            $setted2 = true;
                                        }
                                    }
                                }
 ?>
            <div <?php post_class($d_c); ?>>
              <h2><a data-through="no-gateway" data-postid="<?php the_ID(); ?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
              <p class="pubdate"><?php the_time('F d Y'); ?><?php if (get_the_author_ID() != 1): ?> | <?php the_author_link(); ?><?php endif; ?></p>
              <div class="entry-content pdentry">
                  <?php if($pd_tag2 != ''): ?>
                    <span class="pd-tag <?php echo $pd_css2; ?>" style="background-color: #<?php echo $pd_color2; ?>;"><?php echo $pd_tag2; ?></span>
                  <?php endif ?>
                  <?php if($pd_tag != ''): ?>
                    <span class="pd-tag <?php echo $pd_css; ?>" style="background-color: #<?php echo $pd_color; ?>;"><?php echo $pd_tag; ?></span>
                  <?php endif ?>

                <?php if(has_post_thumbnail()): ?>
                <a data-through="no-gateway" data-postid="<?php the_ID(); ?>" href="<?php the_permalink(); ?>">
                  <?php the_post_thumbnail(); ?>
                </a>
                <?php endif; ?>
                <?php the_excerpt(); ?>
				<div class="clear"></div>
                <div class="frame-tags"><?php the_tags( '<h5>' . __('Tags') . ':</h5> ', ' ', '' ); ?></div>
                <?php //wp_list_categories( 'style=none&title_li=<h5>'.__('Categories') . ':</h5> '); ?> 
                		 
              </div>
            </div>
				<?php 
                    $pd_tag = false;
                    $pd_css = false;
                    $pd_color = false;
        if ($postCount != sizeof($posts)): ?>
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