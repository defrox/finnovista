      <?php stag_content_end(); ?>
      <!-- END #container -->
    </div>
    <?php stag_footer_before(); ?>
    <!-- BEGIN .footer -->
      <footer class="footer" role="contentinfo">
        <?php stag_footer_start(); ?>
        <div class="inner-section">
          <div class="footer-top clearfix">
            <section id="subscribe">
              <div class="social-links">              
          			<?php 
          				$args = array(
          					'showname' 		=> false,
          					'emailtxt' 		=> '',
          					'emailholder' 	=> 'Email', 
          					'showsubmit' 	=> true, 
          					'submittxt' 	=> 'Suscribirse', 
          					'jsthanks' 		=> true,
          					'thankyou' 		=> 'Gracias por suscribirse al blog'
          				);
                  echo do_shortcode('[wysija_form id="1"]');
          			?>              
              <a href="http://twitter.com/finnovista" class="twitter" target="_blank"></a>
              <a href="http://www.finnovista.com/?feed=rss2" class="feed" target="_blank"></a>
              </div>
            </section>
          </div>
        </div>
        <div class="bottom-section">
          <div class="foot_menu">
            <a href="<?php echo get_site_url(); ?>/about_us">ABOUT US</a>
            <a href="<?php echo get_site_url(); ?>/contacta-con-nosotros">CONTACT US</a>
          </div>
          <div class="phones">
            <div>SPAIN<br /><span>+34 617 436 003</span></div>
            <div>USA<br /><span>+1 646 504 6279</span></div>
            <div>MÉXICO<br /><span>+52 55 8421 3125</span></div>
          </div>
          <p class="footer_copyright"> &copy; finnovista 2015 <!--| Powered by <a href='http://www.opinno.com' target='_blank'>Opinno</a>--></p>
        </div>
        <?php stag_footer_end(); ?>
          <a style="display: inline;" href="#" class="scrollup" id="backToTop">Scroll</a>
        <!-- END .footer -->
      </footer>

      <?php if(is_home()): ?>
      <div id="gateway-wrapper">
        <div id="gateway" data-gateway-path="<?php echo get_template_directory_uri(); ?>/includes/gateway.php"></div>
      </div>
    <?php endif; ?>
    <?php stag_footer_after(); ?>
  <?php wp_footer(); ?>
  <?php stag_body_end(); ?>
  </body>
</html>