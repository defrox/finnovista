<?php
/**
 * Template Name: Home Page
 */

get_header(); ?>
<div class="clearfix">
  <div class="grid_12">
  	<div id="before-area">
	  <div class="inner">
	    <?php if ( ! dynamic_sidebar( 'Before Content Area' ) ) : ?>
      <!--Widgetized 'Before Content Area' for the home page-->
    <?php endif; ?>
	  </div>
	</div>
  </div>
</div>
<div id="middle-area" class="clearfix">
    <?php if ( ! dynamic_sidebar( 'Middle Content Area' ) ) : ?>
      <!--Widgetized 'Middle Content Area' for the home page-->
    <?php endif; ?>
</div>
<div class="clearfix">
  <div class="grid_12">
    <div id="bottom-area">
	<div class="inner">
	  <?php if ( ! dynamic_sidebar( 'Bottom Content Area' ) ) : ?>
	<!--Widgetized 'Bottom Content Area' for the home page-->
      <?php endif; ?>
	</div>
      </div>
  </div>	
</div>
<?php get_footer(); ?>