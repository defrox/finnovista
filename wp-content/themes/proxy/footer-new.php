      <?php stag_content_end(); ?>
      <!-- END #container -->
    </div>
<?php
$username = "finnovista";
$feed = "http://search.twitter.com/search.atom?q=from:" . $username . "&rpp=5";

function recent_tweet($feed) {
	$one = explode('<content type="html">', $feed);
//	die ("<pre>".print_r($one,true)."</pre>");
	$str = "";
	for($i=1; $i<sizeof($one);$i++){
		$two = explode("</content>", $one[$i]);
		$tweet = $two[0];
		$tweet = str_replace("&lt;", "<", $tweet); 	
		$tweet = str_replace("&gt;", ">", $tweet);
		$str .= '<p style="text-align:left;">'.$tweet.'</p>';
	}
	
return $str;
}
@$tweetFeed = file_get_contents($feed);
$tweets = recent_tweet($tweetFeed);

// Create a new DOMDocument object
$doc = new DOMDocument(); 
// Load the RSS file into the object
$doc->load(stag_get_option('social_url_feed'));
// Initialize empty array
$arrFeeds = array();
// Get a list of all the elements with the name 'item'
foreach ($doc->getElementsByTagName('item') as $node) {
	$itemRSS = array (
		'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
		'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
		'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
		'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue
	);
	array_push($arrFeeds, $itemRSS);
}
?>
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
                    'showname'    => false,
                    'emailtxt'    => '',
                    'emailholder'   => 'Email', 
                    'showsubmit'  => true, 
                    'submittxt'   => 'Suscribirse', 
                    'jsthanks'    => true,
                    'thankyou'    => 'Gracias por suscribirse al blog'
                  );
                  echo do_shortcode('[wysija_form id="1"]');
                ?> 
              <?php if (stag_get_option('social_url_twitter') != ''): ;?>
              <a href="<?php echo stag_get_option('social_url_twitter'); ?>" class="twitter" target="_blank" title="<?php echo stag_get_option('social_user_twitter'); ?>"></a>
              <?php endif; ?>
              <?php if (stag_get_option('social_url_feed') != ''): ;?>
              <a href="<?php echo stag_get_option('social_url_feed');?>" class="feed" target="_blank"></a>
              <?php endif; ?>
              </div>
            </section>
          </div>
        </div>
        <div class="inner-section">
          <div class="footer-top clearfix">
            <h3 class="title">De lo que hablamos</h3>
          </div>
            <div class="grids">
              <div class="grid-6 via-twitter">
         		<strong>Via <a target="_blank" href="<?php echo stag_get_option('social_url_twitter'); ?>">Twitter</a>:</strong>
              <hr>
      				<?php echo do_shortcode('[twitter-feed username="' . stag_get_option('social_user_twitter') . '" id="501648182070099968" mode="feed"]'); ?>                
              </div>
              <div class="grid-6">
                <strong>Via <a href="<?php echo stag_get_option('social_url_feed');?>" target="_blank">Blog</a>:</strong>
               <hr>
               <?php
               $str = "";
               $max_array = count($arrFeeds) < 10 ? count($arrFeeds) : 10;
               for ($i=0; $i<$max_array;$i++) {
               	$str .= '<p style="text-align:left;"><strong>'.$arrFeeds[$i]['title'].'</strong><br>'.$arrFeeds[$i]['desc'].'<a href="'.$arrFeeds[$i]['link'].'" target="_blank">[+]</a></p>';
               }
               print $str;
               // Output
				//print_r($arrFeeds);
               ?>
              </div>
            </div>
        </div>
        <?php stag_footer_end(); ?>
          <p class="footer_copyright"> &copy; finnovista 2015 <!--| Powered by <a href='http://www.opinno.com' target='_blank'>Opinno</a>--></p>
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