<?php
/*
Template Name: Pitch Days
*/
?>
<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div class="pitch-days" id="slideshow">
	<?php if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
		the_post_thumbnail(array(1350, 500));
	} 
	?>
	<?php /* ?>
	<img src="http://www.finnovista.com/wp-content/uploads/2015/04/pitch-days-ALT.jpg" alt="Pitch Days" />
	<?php */ ?>
    <?php //echo do_shortcode( '[mega-slider id="2635"/]' ) ?>
</div>
<div class='hfeed'>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <p class="pubdate"></p>

        <h2 class="entry-title" style="display:none;"><?php the_title(); ?></h2>

        <div class="entry-content clearfix">
            
            <?php the_content();?>
        </div>
    </article>
</div>
<?php endwhile; ?>

<?php endif; ?>

<?php get_footer() ?>
