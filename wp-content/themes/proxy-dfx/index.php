<?php get_header(); ?>

<div class="homepage-sections">
  <section>
    <div class="inner-section">
      <div id="innotribe" class="entry-content">
        <div id="startup_fintech" style="display:none;">
          <a href="bbvaop/" target="_blank" data-through="no-gateway" data-postid="<?php the_ID(); ?>" > <img src="/wp-content/uploads/2014/04/Banner_Call_to_action1.png"/> </a> </div>
      </div>
    </div>
  </section>
  <?php dynamic_sidebar( 'sidebar-homepage' ); ?>
</div>
<?php get_footer(); ?>
