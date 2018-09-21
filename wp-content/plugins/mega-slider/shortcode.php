<?php
add_shortcode( "test", "test_shortcode" );
function test_shortcode() {
  return "Something";
}
add_shortcode( "mega-slider", "add_md_slider_shortcode" );
function add_md_slider_shortcode( $atts ) {

	extract( shortcode_atts( array(
		'id' => ''
	), $atts ) );
  
	$settings = get_post_meta( $id, 'md-slider-settings', true ); 
  
	$sliders  = json_decode( get_post_meta( $id, 'md-slider-data', true ), true );
  
  if ( ! $settings || ! $sliders ) 
    return "";

	$script = "<script>";
	$html = "";
	$html .= sprintf( '<div class="md-slide-items md-slider" id="md-slider-%s" data-thumb-width="%s" data-thumb-height="%s" style="height: %spx;">', $id, $settings['widthThumb'], $settings['heightThumb'], $settings['height']);
  $class = '';
	foreach ( $sliders as $k => $slider ) { 
    backward_transition_compatibility($slider, $settings);
		$is = $slider['itemsetting'];
    $transition = isset($is['transitions']) ? implode(",", $is['transitions']) : "";
		if ( isset( $is['thumb'] ) && $is['thumb'] !== '' ) {
			$html .= sprintf( '<div class="md-slide-item slide-%s" data-timeout="%s" data-thumb="%s" data-transition="%s">',
        $k, 
        $is['timelinewidth']*100, 
        megaSlider_get_image( wp_get_attachment_url($is['thumb']), $settings['widthThumb'], $settings['heightThumb'], true ),
        $transition
      );
		} else {
      $html .= sprintf( '<div class="md-slide-item slide-%s" data-timeout="%s" data-thumb="%s" data-transition="%s">',
        $k, 
        $is['timelinewidth']*100, 
        megaSlider_get_image( wp_get_attachment_url($is['fid']), $settings['widthThumb'], $settings['heightThumb'], true ),
        $transition
      );
    }
		if ( isset( $is['fid'] ) && $is['fid'] !== '' ) {
      if ( ! $settings['fullwidth'] && $settings['imgslide'] ) {
        $html .= sprintf( '<div class="md-mainimg"><img src="%s" alt="%s"></div>', megaSlider_get_image( wp_get_attachment_url($is['fid']), $settings['width'], $settings['height'], true ), get_the_title($id) );
      } else {
        $html .= sprintf( '<div class="md-mainimg"><img src="%s" alt="%s"></div>', wp_get_attachment_url($is['fid']), get_the_title($id) );
      } 
		} else {
      $html .= sprintf( '<div class="md-mainimg"></div>' );  
    }
		
		$html .= '<div class="md-objects">';
		
		foreach ( $slider['boxitems'] as $tab_id => $tab ) {    
			$data = "";
			$style = "";
      $style = 'style="';
      $style .= process_layer_style( ( object ) $tab );
      $style .= '"';
      
      if ( isset( $tab['left'] ) )
        $data .= sprintf( 'data-x="%s" ', $tab['left'] );
      if ( isset( $tab['top'] ) )
        $data .= sprintf( 'data-y="%s" ', $tab['top'] );
      if ( isset( $tab['width'] ) )
        $data .= sprintf( 'data-width="%s" ', $tab['width'] );
      if ( isset( $tab['height'] ) )
        $data .= sprintf( 'data-height="%s" ', $tab['height'] );
      if ( isset( $tab['paddingtop'] ) )
        $data .= sprintf( 'data-padding-top="%s" ', $tab['paddingtop'] );
      if ( isset( $tab['paddingbottom'] ) )
        $data .= sprintf( 'data-padding-bottom="%s" ', $tab['paddingbottom'] );
      if ( isset( $tab['paddingleft'] ) )
        $data .= sprintf( 'data-padding-left="%s" ', $tab['paddingleft'] );
      if ( isset( $tab['paddingright'] ) )
        $data .= sprintf( 'data-padding-right="%s" ', $tab['paddingright'] );
      if ( isset( $tab['starttime'] ) )
        $data .= sprintf( 'data-start="%s" ', $tab['starttime'] );
      if ( isset( $tab['stoptime'] ) )
        $data .= sprintf( 'data-stop="%s" ', $tab['stoptime'] );
      if ( isset( $tab['startani'] ) )
        $data .= sprintf( 'data-easein="%s" ', $tab['startani'] );
      if ( isset( $tab['stopani'] ) )
        $data .= sprintf( 'data-easeout="%s"', $tab['stopani'] );
      if ( isset( $tab['style'] ) )
        $style_class = $tab['style'];
      else
        $style_class = '';
      if ( isset( $tab['link'] ) && is_array( $tab['link'] ) ) { 
        $link = $tab['link']; 
        $className = 'mega-slider-link-object-' . $tab_id;
        $class .= 'a.mega-slider-link-object-' . $tab_id . ':hover { ';
        if ( $link['color'] !== '' ) 
          $class .= 'color: #' . $link['color'] . '!important; ';
        if ( $link['background'] !== '' )
          $class .= 'background: #' . $link['background'] . '!important; ';
        if ( $link['transparent'] !== '' )
          $class .= 'opacity: ' . $link['transparent'] . '!important; '; 
        if ( $link['border'] )
          $class .= 'border-color: #' . $link['border'] . '!important; ';
        $class .= '} ';
      }
      
			if ( 'text' === $tab['type'] ) {
        if ( isset( $link ) && is_array( $link ) && $link['value'] !== '' ) { 
          $inner = sprintf( '<a href="%s" title="%s" class="%s" %s>%s</a>',
            $link['value'],
            $link['title'],
            $className,
            $style,
            $tab['title']
          );
          $html .= sprintf( '<div class="md-object %s" %s>%s</div>', $style_class, $data, $inner );  
        } else { 
          $inner = sprintf( '<div>%s</div>', $tab['title'] );
          $html .= sprintf( '<div class="md-object %s" %s %s>%s</div>', $style_class, $data, $style, $inner );
        }
			} 
			elseif ( 'video' === $tab['type'] ) {
		    $videohref = generate_video_embeded_url($tab['fileid']);
        $html .= sprintf( '<div class="md-object %s" %s %s><a title="%s" class="md-video" href="%s"><div class="play_button"></div><img src="%s" alt="%s"/></a></div>',
          $style_class,
          $data,
          $style,
          $tab['title'],
          $videohref,
          $tab['thumb'],
          $tab['title']
        );
			} 
			elseif ( 'image' === $tab['type'] ) {
        if ( isset( $link ) && $link['value'] !== '' ) {
          $inner = sprintf( '<a href="%s" title="%s" class="%s" %s><img src="%s" alt="%s"/></a>',
            $link['value'],
            $link['title'],
            $className,
            $style,
            wp_get_attachment_url( $tab['fileid'] ), 
            $link['title']
          );
          $html .= sprintf( '<div class="md-object %s" %s>%s</div>', 
            $style_class,
            $data,  
            $inner
          );
        } else {
          $inner = sprintf( '<img src="%s" alt=""/>', wp_get_attachment_url( $tab['fileid']) );
          $html .= sprintf( '<div class="md-object %s" %s %s>%s</div>', 
            $style_class,
            $data, 
            $style, 
            $inner
          );
        }
			}
      // Unset $link
      if ( isset( $link ) )
        unset($link);
		}
		
		
		$html .= '</div>';
		$html .= '</div>';
	}
	
	$html .= '</div>';
  
  if ( isset( $class ) ) {
    $class = '<style>' . $class . '</style>';
    $html .= $class;
  }

  if ($settings['googlefonts'] != '') {
    $html .= '<style type="text/css" media="all">@import url("' . trim($settings['googlefonts']) . '");</style>';
  }

  $mdSliderOptions = array(
    'fullwidth: %s',
    'transitionsSpeed: %s',
    'width: %s',
    'height: %s',
    'responsive: %s',
    'loop: %s',
    'styleBorder: %s',
    'styleShadow: %s',
    'slideShowDelay: %s',
    'slideShow: %s',
    'showLoading: %s',
    'loadingPosition: "%s"',
    'showArrow: %s',
    'touchArrow: %s',
    'playButton: %s',
    'showBullet: %s',
    'posBullet: %s',
    'showThumb: %s',
    'posThumb: %s',
    'enableDrag: %s'
  );
  
  $mdSliderScripts = '$("#md-slider-%s").mdSlider({' . implode(',', $mdSliderOptions) . '});';

  
  $script_pt = 'jQuery(document).ready(function ($) {';
  
  $script_pt .= $mdSliderScripts . '});';
	$script .= sprintf(
		$script_pt,
		$id,
		$settings['fullwidth'],
		$settings['transitionsSpeed'],
		$settings['width'],
		$settings['height'],
		$settings['responsive'],
    $settings['loop'],
		$settings['styleBorder'],
		$settings['styleShadow'],
		$settings['slideShowDelay'],
		$settings['autoPlay'],
		$settings['showLoading'],
		$settings['loadingPosition'],
		$settings['showArrow'],
    $settings['showArrowTouch'],
		$settings['playButton'],
		$settings['showBullet'],
		$settings['posBullet'],
		$settings['showThumb'],
		$settings['posThumb'],
		$settings['enableDrag']
	);
	$script .= '</script>';

	return  $script . $html;
}

function process_layer_style( $layer ) {
  $output = array();
  if ( isset( $layer->backgroundcolor ) ) {
    if ( isset( $layer->backgroundtransparent ) ) {
      $rgb = hex_to_rgb( $layer->backgroundcolor );
      $alpha = $layer->backgroundtransparent / 100;
      $output[] = "background: rgb({$rgb[0]}, {$rgb[1]}, {$rgb[2]});background: rgba({$rgb[0]}, {$rgb[1]}, {$rgb[2]}, {$alpha});";
    } else {
      if ( is_string( $layer->backgroundcolor ) ) {
        $output[] = "background: #{$layer->backgroundcolor};";
      }
      else {
        $output[] = "background: #000;";
      }
    }
  }

  if ( isset( $layer->opacity ) ) {
    $opacity = $layer->opacity / 100;
    $data = "opacity: {$opacity};";
    $data .= '-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=' . $layer->opacity . ')";';
    $data .= "filter: alpha(opacity={$layer->opacity});";
    $output[] = $data;
  }

  # Process style for layer border
  if ( isset( $layer->borderposition ) && isset( $layer->borderwidth ) && $layer->borderposition > 0 && $layer->borderwidth > 0) {
    $color = ( isset( $layer->bordercolor ) ) ? $layer->bordercolor : "000";
    $border_style = ( isset( $layer->borderstyle ) ) ? $layer->borderstyle : "solid";

    # Process border layer position
    $positions = process_layer_border_position( $layer->borderposition );
    if ( count( $positions ) == 4 ) {
      $output[] = "border: {$layer->borderwidth}px {$border_style} #{$color};";
    }
    else {
      foreach ( $positions as $position ) {
        $output[] = "border-{$position}: {$layer->borderwidth}px {$border_style} #{$color};";
      }
    }
  }

  if ( isset( $layer->bordertopleftradius ) && $layer->bordertopleftradius > 0 ) {
    $output[] = "-webkit-border-top-left-radius: {$layer->bordertopleftradius}px; -moz-border-radius-topleft: {$layer->bordertopleftradius}px; border-top-left-radius: {$layer->bordertopleftradius}px;";
  }

  if ( isset( $layer->bordertoprightradius) && $layer->bordertoprightradius > 0 ) {
    $output[] = "-webkit-border-top-right-radius: {$layer->bordertoprightradius}px; -moz-border-radius-topright: {$layer->bordertoprightradius}px; border-top-right-radius: {$layer->bordertoprightradius}px;";
  }

  if ( isset( $layer->borderbottomleftradius) && $layer->borderbottomleftradius > 0 ) {
    $output[] = "-webkit-border-bottom-left-radius: {$layer->borderbottomleftradius}px; -moz-border-radius-bottomleft: {$layer->borderbottomleftradius}px; border-bottom-left-radius: {$layer->borderbottomleftradius}px;";
  }

  if ( isset( $layer->borderbottomrightradius) && $layer->borderbottomrightradius > 0 ) {
    $output[] = "-webkit-border-bottom-right-radius: {$layer->borderbottomrightradius}px; -moz-border-radius-bottomright: {$layer->borderbottomrightradius}px; border-bottom-right-radius: {$layer->borderbottomrightradius}px;";
  }

  # Process styles for text layer
  if ($layer->type == 'text') {
    if ( isset( $layer->color ) && $layer->color !== '' ) {
      $output[] = "color: #{$layer->color};";
    }

    if ( isset( $layer->bordercolor ) && $layer->bordercolor !== '' ) {
      $output[] = "border-color: #{$layer->bordercolor};";
    }

    if ( isset( $layer->textalign ) && $layer->textalign !== '' ) {
      $output[] = "text-align: {$layer->textalign};";
    }

    if ( isset( $layer->fontsize ) && $layer->fontsize !== '' ) {
      $fontsize = $layer->fontsize / 12;
      $output[] = "font-size: {$fontsize}em;";
    }

    if ( isset( $layer->fontweight ) && $layer->fontweight !== '' ) {
      $font_weight = (int)$layer->fontweight;
      $font_style = str_replace( $font_weight, '', $layer->fontweight );
      $output[] = "font-weight: {$font_weight};";
      $output[] = "font-style: {$font_style};";
    }

    if ( isset( $layer->fontfamily ) && $layer->fontfamily !== '' ) {
      $output[] = "font-family: {$layer->fontfamily};";
    }

    /*
    if ( isset( $layer->fontstyle ) && $layer->fontstyle !== '' ) {
      $output[] = "font-style: {$layer->fontstyle};";
    }
    */

    if ( isset( $layer->textdecoration ) && $layer->textdecoration !== '' ) {
      $output[] = "text-decoration: {$layer->textdecoration};";
    }

    if ( isset( $layer->texttransform ) && $layer->texttransform !== '' ) {
      $output[] = "text-transform: {$layer->texttransform};";
    }
  }

  return implode( ' ', $output );
}

function process_layer_border_position( $border_position ) {
  $border_pos = array();

  if ( $border_position & 1 )
    $border_pos[] = "top";

  if ( $border_position & 2 )
    $border_pos[] = "right";

  if ( $border_position & 4 )
    $border_pos[] = "bottom";

  if ( $border_position & 8 )
    $border_pos[] = "left";

  return $border_pos;
}

function hex_to_rgb( $hex ) {
  $hex = str_replace( "#", "", $hex );

  if ( strlen( $hex ) == 3 ) {
    $r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
    $g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
    $b = hexdec( substr( $hex, 2, 1) . substr( $hex, 2, 1 ) );
  } else {
    $r = hexdec( substr( $hex, 0, 2 ) );
    $g = hexdec( substr( $hex, 2, 2 ) );
    $b = hexdec( substr( $hex, 4, 2 ) );
  }
  return array( $r, $g, $b );
}
  
function generate_video_embeded_url($video_id) {
  if (strlen($video_id) == 11) {
    # Youtube video
    return "http://www.youtube.com/embed/{$video_id}";
  }
  else {
    # Vimeo video
    return "http://player.vimeo.com/video/{$video_id}";
  }
}