<?php
/*
 * Template Name: Post without author and date
 * Template Post Type: post
 */
?>
<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post();
              $terms = get_the_terms( get_the_ID(), 'category' );
              $setted = false;
              if ($terms && sizeof($terms) > 0){
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
              }

if ($cover_image = get_post_meta( $post->ID, '_stag_cover_image', true ) ) {
    $title = get_post_meta( $post->ID, 'titulo_corto', true );
}
?>
<div class='hfeed'>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php if($pd_tag != ''): ?>
        <div class="entry-content pdentry"><span class="pd-tag <?php echo $pd_css; ?>" style="background-color: #<?php echo $pd_color; ?>;"><?php echo $pd_tag; ?></div></span>
        <?php endif ?>

        <h2 class="entry-title"><?php the_title(); ?></h2>
        <div class="featured-image-content clearfix">
			<?php the_post_thumbnail( 'single-post-thumbnail' ); ?>
		</div>
        <div class="entry-content clearfix">
            <?php the_content(); ?>
        </div>
        <div class="frame-tags"><?php the_tags( '<h5>' . __('Tags') . ':</h5> ', ' ', '' ); ?></div><br/>
        <?php //wp_list_categories( 'style=none&title_li=<h5>'.__('Categories') . ':</h5> '); ?>
        <div class="frame-categories"><h5><?php _e('Categories'); ?>: </h5>
            <?php
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
    </article>
  </div>
<?php endwhile; ?>

<span style="float:left;margin:-25px 0 50px 70px;"><?php previous_post_link('&laquo; %link'); ?></span>
<span style="float:right;margin: -25px 70px 50px 0;"><?php next_post_link('%link &raquo; '); ?></span>

<?php comments_template('', true); ?>

<?php endif; ?>

<?php get_footer() ?>
