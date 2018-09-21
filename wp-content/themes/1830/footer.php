  </div><!--.container-->
  <?php if (is_front_page()) : ?>
  <div class="container_12 clearfix">
	<div id="widget-footer" class="clearfix">
      	<?php if ( ! dynamic_sidebar( 'Footer' ) ) : ?>
          <!--Widgetized Footer-->
        <?php endif; ?>
      </div>
  </div>
  <?php endif; ?>
</div>
	<footer id="footer">
  	<div id="back-top-wrapper">
    	<p id="back-top">
        <a href="#top"><span><?php _e('Top', 'theme1830'); ?></span></a>
      </p>
    </div>
	<div id="copyright" class="clearfix">
		<div class="container_12 clearfix">
				<div class="grid_9">
					<div id="footer-text">
						<?php $myfooter_text = of_get_option('footer_text'); ?>
						
						<?php if($myfooter_text){?>
							<?php echo of_get_option('footer_text'); ?>
						<?php } else { ?>
							<a href="<?php bloginfo('url'); ?>/" title="<?php bloginfo('description'); ?>" class="site-name"><?php bloginfo('name'); ?></a> &copy; <?php echo date('Y'); ?> &nbsp;|&nbsp; <a href="<?php bloginfo('url'); ?>/privacy-policy/" title="Privacy Policy"><?php _e('Privacy Policy', 'theme1830'); ?></a>
						<?php } ?>
						<br />
						<?php if( is_front_page() ) { ?>
						More <a rel="nofollow" href="http://www.templatemonster.com/category/bank-wordpress-themes/" target="_blank">Bank WordPress Themes at TemplateMonster.com</a>
						<?php } ?>
					</div>
					
				</div>
				<div class="grid_3">
					<?php if ( ! dynamic_sidebar( 'Social' ) ) : ?>
						<!--Widgetized Footer-->
					      <?php endif; ?>			
				</div>
			</div>
		</div><!--.container-->
	</footer>
    </div>
</div><!--#main-->
<?php wp_footer(); ?> <!-- this is used by many Wordpress features and for plugins to work properly -->
<?php if(of_get_option('ga_code')) { ?>
	<script type="text/javascript">
		<?php echo stripslashes(of_get_option('ga_code')); ?>
	</script>
  <!-- Show Google Analytics -->	
<?php } ?>
</body>
</html>