<?php

$cminds_plugin_config = array(
	'plugin-is-pro'				 => false,
	'plugin-version'			 => '1.1.10',
	'plugin-abbrev'				 => 'cmodsar',
	'plugin-short-slug'			 => 'search-and-replace',
	'plugin-parent-short-slug'	 => '',
	'plugin-file'				 => CMODSAR_PLUGIN_FILE,
    'plugin-affiliate'               => '',
    'plugin-redirect-after-install'  => admin_url( 'admin.php?page=cmodsar_settings' ),
    'plugin-show-guide'              => TRUE,
    'plugin-guide-text'              => '    <div style="display:block">
        <ol>
         <li>This plugin allows you to setup the search & replace rules for the content of your site.</li>
        <li>You can set a <strong>textual string or HTML</strong> which should be found and the string/HTML that should be placed instead.</li>
        <li> You may also decide only to remove without replacing it (just leave the "To String" empty).</li>
        <li>This plugin and replacment tules <strong>does not change the content on the database</strong>. Instead it changes the content right before it is displayed.</li>
        <li><strong>Example:</strong>Create a rule, in the From String field type: "test" in the To String field: "passed"</li>
        <li>Create a new page, add some title (any), and write the "test" in the content</li>
        <li>Save the page and view it</li>
        <li>You should see the string "passed" in the content</li>
        <li>If there is still "test" displayed - it may mean that your theme is not using "the_content" filter.</li>
        </ol>
    </div>',
    'plugin-guide-video-height'          => 240,
    'plugin-guide-videos'            => array(
        array( 'title' => 'Installation tutorial', 'video_id' => '157541752' ),
    ),
	'plugin-dir-path'			 => plugin_dir_path( CMODSAR_PLUGIN_FILE ),
	'plugin-dir-url'			 => plugin_dir_url( CMODSAR_PLUGIN_FILE ),
	'plugin-basename'			 => plugin_basename( CMODSAR_PLUGIN_FILE ),
	'plugin-icon'				 => '',
	'plugin-name'				 => CMODSAR_NAME,
	'plugin-license-name'		 => CMODSAR_CANONICAL_NAME,
	'plugin-slug'				 => '',
	'plugin-menu-item'			 => CMODSAR_SETTINGS_OPTION,
	'plugin-textdomain'			 => CMODSAR_SLUG_NAME,
	'plugin-userguide-key'		 => '282-cm-search-and-replace',
	'plugin-store-url'			 => 'https://www.cminds.com/wordpress-plugins-library/purchase-cm-on-demand-search-and-replace-plugin-for-wordpress/',
	'plugin-support-url'		 => 'https://wordpress.org/support/plugin/cm-on-demand-search-and-replace',
	'plugin-review-url'			 => 'https://wordpress.org/support/view/plugin-reviews/cm-on-demand-search-and-replace',
	'plugin-changelog-url'		 => CMODSAR_RELEASE_NOTES,
	'plugin-licensing-aliases'	 => array( CMODSAR_LICENSE_NAME ),
	'plugin-compare-table'	 => '
            <div class="suite-package" style="padding-left:10px;"><h2>The premium version of this plugin is included in CreativeMinds All plugins suite:</h2><a href="https://www.cminds.com/wordpress-plugins-library/cm-wordpress-plugins-yearly-membership/" target="_blank"><img src="'.plugin_dir_url( __FILE__ ).'CMWPPluginssuite.png"></a></div>
            <hr style="width:1000px; height:3px;">
            <div class="pricing-table" id="pricing-table"><h2 style="padding-left:10px;">Upgrade The On Demand Search and Replace Plugin:</h2>
                <ul>
                    <li class="heading" style="background-color:black;">Current Edition</li>
                    <li class="price">FREE<br /></li>
                     <li style="text-align:left;"><span class="dashicons dashicons-yes"></span>Define find and replace rules</li>
                    <li style="text-align:left;"><span class="dashicons dashicons-yes"></span>Supports posts and pages</li>
                </ul>

                <ul>
                   <li class="heading">Pro<a href="https://www.cminds.com/wordpress-plugins-library/purchase-cm-on-demand-search-and-replace-plugin-for-wordpress/" style="float:right;font-size:11px;color:white;" target="_blank">More</a></li>
                    <li class="price">$29.00<br /> <span style="font-size:14px;">(For one Year / Site)<br />Additional pricing options available <a href="https://www.cminds.com/wordpress-plugins-library/purchase-cm-on-demand-search-and-replace-plugin-for-wordpress/" target="_blank"> >>> </a></span> <br /></li>
                    <li class="action"><a href="https://www.cminds.com/?edd_action=add_to_cart&download_id=33640&wp_referrer=https://www.cminds.com/checkout/&edd_options[price_id]=1" style="font-size:18px;" target="_blank">Upgrade Now</a></li>
                     <li style="text-align:left;"><span class="dashicons dashicons-yes"></span>All Free Version Features <span class="dashicons dashicons-admin-comments cminds-package-show-tooltip" style="color:green" title="All free features are supported in the pro"></span></li>  
                <li style="text-align:left;"><span class="dashicons dashicons-yes"></span>All WordPress Content Types<span class="dashicons dashicons-admin-comments cminds-package-show-tooltip" style="color:green" title="Define search and replace rules for comments, posts, pages, titles, content and excerpts "></span></li>
                <li style="text-align:left;"><span class="dashicons dashicons-yes"></span>Limit to Specific Post Types<span class="dashicons dashicons-admin-comments cminds-package-show-tooltip" style="color:green" title="Support search and replace only on specific content types or custom posts"></span></li>
                <li style="text-align:left;"><span class="dashicons dashicons-yes"></span>Remove Content<span class="dashicons dashicons-admin-comments cminds-package-show-tooltip" style="color:green" title="Support removing content without replacing it"></span></li>
                <li style="text-align:left;"><span class="dashicons dashicons-yes"></span>Case Sensitive<span class="dashicons dashicons-admin-comments cminds-package-show-tooltip" style="color:green" title="Support case sensitive replacements"></span></li>
                <li style="text-align:left;"><span class="dashicons dashicons-yes"></span>Rules Management<span class="dashicons dashicons-admin-comments cminds-package-show-tooltip" style="color:green" title="Pause certain rules or delete them"></span></li>
                <li style="text-align:left;"><span class="dashicons dashicons-yes"></span>Frontend Widget<span class="dashicons dashicons-admin-comments cminds-package-show-tooltip" style="color:green" title="Front-end control widget to turn search and replace off and on"></span></li>
                <li style="text-align:left;"><span class="dashicons dashicons-yes"></span>Import and Export Rules<span class="dashicons dashicons-admin-comments cminds-package-show-tooltip" style="color:green" title="Import and export rules"></span></li>
                <li style="text-align:left;"><span class="dashicons dashicons-yes"></span>Search Rules<span class="dashicons dashicons-admin-comments cminds-package-show-tooltip" style="color:green" title="Search within rules set - in case you have many rules between sites"></span></li>
                <li style="text-align:left;"><span class="dashicons dashicons-yes"></span>Drag and Drop<span class="dashicons dashicons-admin-comments cminds-package-show-tooltip" style="color:green" title="Easily change order of rules using drag and drop interface"></span></li>
                <li style="text-align:left;"><span class="dashicons dashicons-yes"></span>Time restricted search and replace<span class="dashicons dashicons-admin-comments cminds-package-show-tooltip" style="color:green" title="Supports applying the search and replace rules on specific dates."></span></li>
                <li style="text-align:left;"><span class="dashicons dashicons-yes"></span>Target specific post<span class="dashicons dashicons-admin-comments cminds-package-show-tooltip" style="color:green" title="Target rules to specific post or page."></span></li>
                <li style="text-align:left;"><span class="dashicons dashicons-yes"></span>Regex search and replace<span class="dashicons dashicons-admin-comments cminds-package-show-tooltip" style="color:green" title="Supports regex search and replace statements."></span></li>
                <li style="text-align:left;"><span class="dashicons dashicons-yes"></span>External Plugins Support<span class="dashicons dashicons-admin-comments cminds-package-show-tooltip" style="color:green" title="Special support for ACF, Yoast, Woocommerce and bbPress plugins fields"></span></li>
                   <li class="support" style="background-color:lightgreen; text-align:left; font-size:14px;"><span class="dashicons dashicons-yes"></span> One year of expert support <span class="dashicons dashicons-admin-comments cminds-package-show-tooltip" style="color:grey" title="You receive 365 days of a WordPress expert support. We will answer questions you have and also support any issue related to the plugin. We also provide on site support."></span><br />
                        <span class="dashicons dashicons-yes"></span> Unlimited product updates <span class="dashicons dashicons-admin-comments cminds-package-show-tooltip" style="color:grey" title="During the year, you can update the plugin as many times as needed and receive any new release and security update"></span><br />
                        <span class="dashicons dashicons-yes"></span> Plugin can be used forever <span class="dashicons dashicons-admin-comments cminds-package-show-tooltip" style="color:grey" title="If you choose not to renew the plugin license, you can still continue to use a long as you want."></span><br />
                        <span class="dashicons dashicons-yes"></span> Save 35% once renewing license <span class="dashicons dashicons-admin-comments cminds-package-show-tooltip" style="color:grey" title="If you choose to renew the plugin license you can do this anytime you choose. The renewal cost will be 35% off the product cost."></span></li>
                </ul>




            </div>',
);
