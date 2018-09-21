      <?php stag_content_end(); ?>
      <!-- END #container -->
    </div>

<?php
$username = "nextbanklatam";
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
$doc->load('http://www.finnovar.com/feed/');
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
            <h3 class="title">De lo que hablamos</h3>
            <div class="social-links">
              <a href="https://twitter.com/NextBankBogota" class="twitter" target="_blank"></a>
              <a href="http://www.finnovar.com/feed" class="feed" target="_blank"></a>
            </div>
          </div>
            <div class="grids">
              <div class="grid-6 via-twitter">
         		<strong>Via <a target="_blank" href="https://twitter.com/nextbankbogota">Twitter</a>:</strong>
              <hr>

				<?php echo do_shortcode('[twitter-feed username="nextbankbogota" id="501638963526762496" mode="feed"]'); ?>

              </div>
              <div class="grid-6 via-blog">
                <strong>Via <a href = "http://www.finnovar.com" target="_blank">Blog</a>:</strong>
               <hr>
               <?php
               $str = "";
               for ($i=0; $i<3;$i++){
               	$str .= '<p style="text-align:left;"><strong>'.$arrFeeds[$i]['title'].'</strong><br /><div>'.$arrFeeds[$i]['desc'].'</div></p>';
               }
               print $str;
               // Output
				//print_r($arrFeeds);
               ?>
              </div>
            </div>

        </div>

        <?php stag_footer_end(); ?>

        <p class="footer_copyright">
          &copy; finnovista 2013 | Powered by <a href='http://opinno.com' target='_blank'>Opinno</a></p>
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
  <?php




if (!is_page ( array (444, 'compra-tu-entrada', 'isd', 'innotribe-startup-disrupt', 1025, 384, 401) )){
  ?>

  <div id='entrada'><a href="/compra-tu-entrada/"><img src="/wp-content/uploads/2014/05/NB-Bogota.png" width="200" border="0" /></a></div>
  <script type="text/javascript">
    jQuery(document).ready(function(){
      jQuery("#entrada").on("mouseenter", function(i,el){
        jQuery(this).stop().animate({right:0}, 500);
      });
      jQuery("#entrada").on("mouseleave", function(i,el){
        jQuery(this).stop().animate({right:"-125px"}, 500);
      });
    });
  </script>

  <?php
  } else if (is_page( array( 'isd', 'innotribe-startup-disrupt', 1025, 384, 401) )){
  ?>
  <div id='registro'><a href="http://www.f6s.com/innotribestartupdisruptlatam2013/info"><input type="button" value="Inscribete YA!" class="wpcf7-form-control wpcf7-submit button" target="_blank" href="http://www.f6s.com/innotribestartupdisruptlatam2013/info"></a></div>
  <script type="text/javascript">
    jQuery(document).ready(function(){
      jQuery("#registro").on("mouseenter", function(i,el){
        jQuery(this).stop().animate({right:10}, 500);
      });
      jQuery("#registro").on("mouseleave", function(i,el){
        jQuery(this).stop().animate({right:"-175px"}, 500);
      });
    });
  </script>
  <?php
  }
  ?>
  </body>
</html>
