<?php
/*
Template Name: Thank You Page
*/
$custom_logo = get_post_meta(get_the_ID(), '_stag_custom_page_logo', true);
$file = $_REQUEST['file'];
$campaign = $_REQUEST['utm_campaign'] ? $_REQUEST['utm_campaign'] : rawurldecode($file);
?>
<?php get_header(); ?>
<script type="text/javascript">
    /*
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
    */

    function analyticsEvent(event, campaign) {
        ga('send', {
            hitType: 'event',
            eventCategory: 'Download File',
            eventAction: 'download',
            eventLabel: campaign
        });
        gax('send', {
            hitType: 'event',
            eventCategory: 'Download File',
            eventAction: 'download',
            eventLabel: campaign
        });
    }
</script>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class='hfeed'>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <p class="pubdate"></p>

            <h2 class="entry-title" style="display:block; padding-left: 0 !important;"><?php the_title(); ?></h2>

            <div class="entry-content clearfix" style="margin-top: 50px;">
                <span style="font-size: 28px; font-weight: bold;"><?php _e('Download your file'); ?> <a href="<?= rawurldecode($file);?>" onClick="analyticsEvent(event, '<?= $campaign; ?>');" download><?php _e('here'); ?></a></span>
                <br />
                <?php the_content(); ?>
            </div>
        </article>
    </div>
<?php endwhile; ?>
<?php endif; ?>
<?php get_footer(); ?>