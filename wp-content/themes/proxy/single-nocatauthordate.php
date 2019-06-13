<?php
/*
 * Template Name: Post without author, date, category and next/prev links
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
    </article>

  </div>
<?php endwhile; ?>

<?php comments_template('', true); ?>

<?php endif; ?>

<?php get_footer() ?>
