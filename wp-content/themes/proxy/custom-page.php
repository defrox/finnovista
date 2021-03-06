<?php
/*
Template Name: Custom Page
*/
$custom_logo = get_post_meta(get_the_ID(), '_stag_custom_page_logo', true);
?>
<?php get_header(); ?>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        jQuery('#logo img').each(function () {
            jQuery(this).attr("src", "<?php echo $custom_logo; ?>");
            //jQuery(this).css("margin-top", "10px");
            jQuery(this).parent().parent().find(".subtitle-text").css("display", "none");
        });
        jQuery('#logo a').each(function () {
            jQuery(this).attr("href", "<?php echo site_url() . ($_GET['lang'] != '' ? '?lang=' . $_GET['lang'] : ''); ?>");
        });
    });
</script>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class='hfeed'>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <p class="pubdate"></p>

            <h2 class="entry-title" style="display:none;"><?php the_title(); ?></h2>

            <div class="entry-content clearfix">
                <?php the_content(); ?>
            </div>
        </article>
    </div>
<?php endwhile; ?>
<?php endif; ?>
<?php get_footer(); ?>