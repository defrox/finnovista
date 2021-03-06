<?php
/*
 * Template Name: My Speakers Page
 * Description: A Page Template with a darker design.
 */
 ?>



<?php get_header(); ?>

<section id="team" class="section-block speakers">
	<div class="inner-section">
		<h2 class="main-title">Speakers</h2>
	</div>

      <div class="inner-section">
        <?php
          $args = array(
              'post_type' => 'team',
               'posts_per_page' => -1,
          );
          $the_query = new WP_Query(array( 'post_type' => 'team','meta_value' => 'speaker','posts_per_page' => -1 ));
        ?>

        <div class="team-members">
          <?php
            if($the_query->have_posts()){
              $i = 0;
              while($the_query->have_posts()): $the_query->the_post();
              ?>
              <div id="<?php print get_the_ID() ?>"><p></p></div>
              <section  class="member-section <?php echo $i%2 == 0 ? "even" : "odd" ?>">
              <div class="member">
                  <?php if(has_post_thumbnail()): ?>
                  <div class="member-pic">
                    <?php the_post_thumbnail('full'); ?>

                    <div class="member-links">

                      <?php if(get_post_meta(get_the_ID(), '_stag_team_url_twitter', true) != ''): ?>
                        <a href="<?php echo get_post_meta(get_the_ID(), '_stag_team_url_twitter', true); ?>" class="twitter"></a>
                      <?php endif ?>

                      <?php if(get_post_meta(get_the_ID(), '_stag_team_url_linkedin', true) != ''): ?>
                        <a href="<?php echo get_post_meta(get_the_ID(), '_stag_team_url_linkedin', true); ?>" class="linkedin"></a>
                      <?php endif ?>
                    </div>
                  </div>
                  <?php endif; ?>
                  <div class="member-description">
                    <p class="member-title"><?php the_title(); ?></p>
                    <?php if(get_post_meta(get_the_ID(), '_stag_team_position', true) != '') echo '<p class="member-position">'.get_post_meta(get_the_ID(), '_stag_team_position', true).'</p>'; ?>
                  </div>                  
                </div>
                <div class="member-bio" >
            			<?php if(get_post_meta(get_the_ID(), '_stag_team_bio', true) != '') echo '<p >'.get_post_meta(get_the_ID(), '_stag_team_bio', true).'</p>'; ?>      
                </div>
                <div class="clearfix"></div>
                </section>
              <?php
              $i++;
              endwhile;
            }
            wp_reset_postdata();
          ?>
        </div>       
      </div>

</section>
<?php get_footer() ?>
