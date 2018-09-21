<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <title><?php wp_title(''); ?></title>

  <meta name="viewport" content="width=device-width" />
  <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

  <?php /* ?><link rel="dns-prefetch" href="//fonts.googleapis.com">
  <link rel="dns-prefetch" href="//cdnjs.cloudflare.com"><?php */ ?>

  <?php stag_meta_head(); ?>

  <?php wp_head(); ?>

  <?php stag_head(); ?>

  <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/agenda_resumen.css" type="text/css">
	<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" />
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
            <a href="<?php echo site_url(); ?>" title="<?php bloginfo( 'name' ); ?>"><?php bloginfo( 'name' ); ?></a>
          <?php } elseif( stag_get_option('general_custom_logo') ) { ?>
            <a id="customlogo" href="<?php echo site_url(); ?>" title="<?php bloginfo( 'name' ); ?>"><img src="<?php echo stag_get_option('general_custom_logo'); ?>" border="0" alt="<?php bloginfo( 'name' ); ?>"></a>
          <?php } else{ ?>
            <a href="<?php echo site_url(); ?>" title="<?php bloginfo( 'name' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" border="0" alt="<?php bloginfo( 'name' ); ?>"></a>
          <?php } ?>
          <p class="subtitle-text"><?php bloginfo( 'description' ); ?></p>
          <!-- END #logo -->
        </div>
        <!--<div id="entrada_menu">
          <a href="/?p=444"><img src="/wp-content/uploads/2014/05/NB-Bogota.png" width="200" border="0"></a>
        </div>-->
        <div id="icono_menu"></div>

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