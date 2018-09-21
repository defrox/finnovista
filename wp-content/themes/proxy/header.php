<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <title><?php wp_title(''); ?></title>

  <meta name="viewport" content="width=device-width" />
  <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

  <?php stag_meta_head(); ?>

  <?php wp_head(); ?>

  <?php stag_head(); ?>
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/agenda_resumen.css" type="text/css" />
  <base href="<?php global $wp; $dfx_current_url = home_url(); echo $dfx_current_url; ?>" />
  <?php /* ?><base href="<?php global $wp; $dfx_current_url = home_url(add_query_arg(array(),$wp->request)); echo $dfx_current_url; ?>" /><?php */ ?>
</head>

<!-- BEGIN body -->
<body <?php body_class(); ?>>
  <?php stag_body_start(); ?>


  <?php stag_header_before(); ?>

  <!-- BEGIN #header -->
  <header id="header" role="banner">

    <?php stag_header_start(); ?>

      <!-- BEGIN .header-inner -->
      <div class="header-inner">

        <!-- BEGIN #logo -->
        <div id="logo">
          <?php

          if( stag_get_option('general_text_logo') == 'on' ){ ?>
            <a href="<?php echo site_url() . (isset($_GET['lang']) && $_GET['lang'] != '' ? '?lang=' . $_GET['lang'] : ''); ?>" title="<?php bloginfo( 'name' ); ?>"><?php bloginfo( 'name' ); ?></a>
          <?php } elseif( stag_get_option('general_custom_logo') ) { ?>
            <a id="customlogo" href="<?php echo site_url() . (isset($_GET['lang']) && $_GET['lang'] != '' ? '?lang=' . $_GET['lang'] : ''); ?>" title="<?php bloginfo( 'name' ); ?>"><img src="<?php echo stag_get_option('general_custom_logo'); ?>" border="0" alt="<?php bloginfo( 'name' ); ?>"></a>
          <?php } else{ ?>
            <a href="<?php echo site_url() . (isset($_GET['lang']) && $_GET['lang'] != '' ? '?lang=' . $_GET['lang'] : ''); ?>" title="<?php bloginfo( 'name' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" border="0" alt="<?php bloginfo( 'name' ); ?>"></a>
          <?php } ?>
          <div class="subtitle-text"><?php bloginfo( 'description' ); ?></div>
          <!-- END #logo -->
        </div>
        <div class="mobile-subtitle-text"><?php bloginfo( 'description' ); ?></div>
        <div id="list_language_selector"><?php language_selector_list(); ?></div >
        <div id="icono_menu" class="header">
          <div class="social-links">
            <?php if (stag_get_option('social_url_twitter') != ''): ;?>
            <a href="<?php echo stag_get_option('social_url_twitter'); ?>" class="primary" target="_blank" title="<?php echo stag_get_option('social_user_twitter'); ?>"><i class="fa fa-twitter"></i></a>
            <?php endif; ?>
            <?php if (stag_get_option('social_url_twitter2') != ''): ;?>
            <a href="<?php echo stag_get_option('social_url_twitter2'); ?>" class="secondary" target="_blank" title="<?php echo stag_get_option('social_user_twitter2'); ?>"><i class="fa fa-twitter"></i></a>
            <?php endif; ?>
            <?php if (stag_get_option('social_url_facebook') != ''): ;?>
            <a href="<?php echo stag_get_option('social_url_facebook');?>" class="primary" target="_blank"><i class="fa fa-facebook-official"></i></a>
            <?php endif; ?>
            <?php if (stag_get_option('social_url_facebook2') != ''): ;?>
            <a href="<?php echo stag_get_option('social_url_facebook2');?>" class="secondary" target="_blank"><i class="fa fa-facebook-official"></i></a>
            <?php endif; ?>
            <?php if (stag_get_option('social_url_linkedin') != ''): ;?>
            <a href="<?php echo stag_get_option('social_url_linkedin');?>" class="primary" target="_blank"><i class="fa fa-linkedin-square"></i></a>
            <?php endif; ?>
            <?php if (stag_get_option('social_url_linkedin2') != ''): ;?>
            <a href="<?php echo stag_get_option('social_url_linkedin2');?>" class="secondary" target="_blank"><i class="fa fa-linkedin-square"></i></a>
            <?php endif; ?>
            <?php if (stag_get_option('social_url_feed') != ''): ;?>
            <a href="<?php echo stag_get_option('social_url_feed');?>" class="primary" target="_blank"><i class="fa fa-rss"></i></a>
            <?php endif; ?>
            <?php if (stag_get_option('social_url_feed2') != ''): ;?>
            <a href="<?php echo stag_get_option('social_url_feed2');?>" class="secondary" target="_blank"><i class="fa fa-rss"></i></a>
            <?php endif; ?>
          </div>
        </div>

        <!-- BEGIN #primary-nav -->
        <nav id="navigation" role="navigation">

          <?php
            if(has_nav_menu('primary-menu')){
              wp_nav_menu(array(
                'theme_location' => 'primary-menu',
                'container' => 'div',
                'container_id' => 'primary-nav',
                'container_class' => 'primary-menu',
                ));
            }
          ?>

          <!-- END #primary-nav -->
        </nav>

        <!-- END .header-inner -->
      </div>

    <?php stag_header_end(); ?>

    <!-- END .header -->
  </header>

  <?php stag_header_after(); ?>



  <!-- BEGIN #container -->
  <div id="container">
  <?php stag_content_start(); ?>