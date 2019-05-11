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
                /*$zoho_form = $_GET['lang'] == 'en' ? "<script src='https://crm.zoho.com/crm/WebFormServeServlet?rid=0d6379c70c887ee0371a71992e27b8d9bf643a59de7886f4fe34e760840de053gid5bbd0d7ac19fe8aecff112a37dc69b45ad0f1c849d4db1e9882702c8980a17a0&script=$sYG'></script>" : "<script src='https://crm.zoho.com/crm/WebFormServeServlet?rid=0d6379c70c887ee0371a71992e27b8d9bce724854d525dfc88aa62a8afad1193gid5bbd0d7ac19fe8aecff112a37dc69b45ad0f1c849d4db1e9882702c8980a17a0&script=$sYG'></script>";
                echo $zoho_form;*/
                require_once ('newsletter-form.php');
                ?> 
                <?php if (stag_get_option('social_url_twitter') != ''): ;?>
                <a href="<?php echo stag_get_option('social_url_twitter'); ?>" class="primary" target="_blank" title="<?php echo stag_get_option('social_user_twitter'); ?>"><i class="fa fa-twitter"></i></a>
                <?php endif; ?>
                <?php if (stag_get_option('social_url_facebook') != ''): ;?>
                <a href="<?php echo stag_get_option('social_url_facebook');?>" class="primary" target="_blank"><i class="fa fa-facebook-official"></i></a>
                <?php endif; ?>
                <?php if (stag_get_option('social_url_linkedin') != ''): ;?>
                <a href="<?php echo stag_get_option('social_url_linkedin');?>" class="primary" target="_blank"><i class="fa fa-linkedin-square"></i></a>
                <?php endif; ?>
                <?php if (stag_get_option('social_url_feed') != ''): ;?>
                <a href="<?php echo stag_get_option('social_url_feed');?>" class="primary" target="_blank"><i class="fa fa-rss"></i></a>
                <?php endif; ?>
              </div>
            </section>
          </div>
        </div>
        <div class="bottom-section">
            <div class="grids">
                <div class="grid-6 via-twitter">
                    <strong><?php echo __('Latest news'); ?></strong>
                    <hr>
                    <a class="twitter-timeline" href="https://twitter.com/Finnovista" data-widget-id="604364474393456640">Tweets by @Finnovista</a>
                    <script>!function (d, s, id) {var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https'; if (!d.getElementById(id)) {js = d.createElement(s); js.id = id; js.src = p + "://platform.twitter.com/widgets.js"; fjs.parentNode.insertBefore(js, fjs); } }(document, "script", "twitter-wjs");</script>
                </div>
                <div class="grid-6 via-feed">
                    <strong><?php echo __('Featured news'); ?></strong>
                    <hr>
                    <div class="feed-widget">
                        <div class="feed-widget-header">
                            <?php echo __('Feeds'); ?>
                            <a class="follow-button profile" href="<?php echo stag_get_option('social_url_feed'); ?>" role="button" data-scribe="component:followbutton" title="<?php echo __('Follow'); ?>"><i class="fa fa-rss"></i> <?php echo __('Follow'); ?></a>
                        </div>
                        <div class="feed-widget-stream"><?php echo dfx_rss_content(); ?></div>
                        <div class="feed-widget-footer">
                            <a href="<?php echo stag_get_option('social_url_feed'); ?>" target="_blank"><?php echo __('read more at'); ?> finnovista</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grids">
                <div class="grid-6 footer-left">
                    <?php dynamic_sidebar( 'sidebar-footer-left' ); ?>
                </div>
                <div class="grid-6 footer-right">
                    <?php dynamic_sidebar( 'sidebar-footer-right' ); ?>
                </div>
            </div>
          <p class="footer_copyright"> &copy; finnovista 2015 | Powered by <a href='http://www.defrox.com' target='_blank'>defrox</a></p>
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
    <script type="text/javascript">
      jQuery(document).ready(function(){
        twitterCheck = setInterval(function() {
            var twitterFrame = jQuery("#twitter-widget-0");
            var twitterTimeline = twitterFrame.contents().find(".timeline");
            if(twitterFrame.length && twitterTimeline.length) {
                twitterTimeline.attr("style",twitterTimeline.attr("style") + "; max-width:100% !important;");
                twitterFrame.attr("style",twitterFrame.attr("style") + "; max-width:100% !important; width: 100% !important;");
                clearInterval(twitterCheck);
            }
        }, 10);
/*
        jQuery('widget_wysija input').each(function(i, el) {
          var elem = jQuery( el );
          console.log(elem.attr('id'));
          if (elem.attr('id') == 8636) 
            jQuery('this').attr('placeholder','<?php echo __('Email');?>');
        });
*/
      });
    </script>  
    <?php stag_footer_after(); ?>
  <?php wp_footer(); ?>
  <?php stag_body_end(); ?>
  </body>
</html>