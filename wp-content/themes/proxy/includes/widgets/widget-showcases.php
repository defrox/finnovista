<?php
add_action('widgets_init', create_function('', 'return register_widget("stag_section_showcases");'));

class stag_section_showcases extends WP_Widget{
  function stag_section_showcases(){
    $widget_ops = array('classname' => 'section-block showcases', 'description' => __('Displays a slogan and 4 showcases.', 'stag'));
    $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'stag_section_showcases');
    $this->WP_Widget('stag_section_showcases', __('Homepage: Showcases Section', 'stag'), $widget_ops, $control_ops);
  }

  function widget($args, $instance){
    extract($args);

    // VARS FROM WIDGET SETTINGS
    $title = apply_filters('widget_title', $instance['title'] );
    $subtitle = $instance['subtitle'];
    $slogan = $instance['slogan'];
    $image1 = $instance['image1'];
    $showcase1 = $instance['showcase1'];
    $text1 = $instance['text1'];
    $image2 = $instance['image2'];
    $showcase2 = $instance['showcase2'];
    $text2 = $instance['text2'];
    $image3 = $instance['image3'];
    $showcase3 = $instance['showcase3'];
    $text3 = $instance['text3'];
    $image4 = $instance['image4'];
    $showcase4 = $instance['showcase4'];
    $text4 = $instance['text4'];
    $id = $instance['id'];

    echo $before_widget;

    ?>
    <!-- BEGIN #showcases.section-block -->
    <!-- widget showcases  -->
    <section id="<?php echo stag_to_slug($id); ?>" class="section-block showcases-widget homeconferences clearfix">
      <div class="row">
        <div class="intro">
        <?php
			    if($slogan != '') echo '<h2>' . __($slogan, 'stag') . '</h2>';
          if($subtitle != '') echo __($subtitle, 'stag');
        ?>
        </div>
      </div>
      <div class="row confhighlights row-centered">
        <div class="minirow">
          <div class="col-centered col-fixed-conf col-fixed-285 first">
            <div class="confhightlightcontainer">
              <img src="<?php echo $image1;?>" />
              <div class="description">
                <h3><?php echo __($showcase1, 'stag');?></h3>
                <p><?php echo __($text1, 'stag');?></p>
              </div>
            </div>
          </div>
          <div class="col-centered col-fixed-conf col-fixed-285">
            <div class="confhightlightcontainer">
              <img src="<?php echo $image2;?>" />
              <div class="description">
                  <h3><?php echo __($showcase2, 'stag');?></h3>
                  <p><?php echo __($text2, 'stag');?></p>
              </div>
            </div>
          </div>
          <div class="col-centered col-fixed-conf col-fixed-285">
            <div class="confhightlightcontainer">
              <img src="<?php echo $image3;?>" />
              <div class="description">
                  <h3><?php echo __($showcase3, 'stag');?></h3>
                  <p><?php echo __($text3, 'stag');?></p>
              </div>
            </div>
          </div>
          <div class="col-centered col-fixed-conf col-fixed-285">
            <div class="confhightlightcontainer">
              <img src="<?php echo $image4;?>" />
              <div class="description">
                  <h3><?php echo __($showcase4, 'stag');?></h3>
                  <p><?php echo __($text4, 'stag');?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- END #showcases.section-block -->
    <?php
    echo $after_widget;
  }

  function update($new_instance, $old_instance){
    $instance = $old_instance;

    // STRIP TAGS TO REMOVE HTML
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['subtitle'] = strip_tags($new_instance['subtitle']);
    $instance['slogan'] = strip_tags($new_instance['slogan']);
    $instance['image1'] = strip_tags($new_instance['image1']);
    $instance['showcase1'] = strip_tags($new_instance['showcase1']);
    $instance['text1'] = strip_tags($new_instance['text1']);
    $instance['image2'] = strip_tags($new_instance['image2']);
    $instance['showcase2'] = strip_tags($new_instance['showcase2']);
    $instance['text2'] = strip_tags($new_instance['text2']);
    $instance['image3'] = strip_tags($new_instance['image3']);
    $instance['showcase3'] = strip_tags($new_instance['showcase3']);
    $instance['text3'] = strip_tags($new_instance['text3']);
    $instance['image4'] = strip_tags($new_instance['image4']);
    $instance['showcase4'] = strip_tags($new_instance['showcase4']);
    $instance['text4'] = strip_tags($new_instance['text4']);
    $instance['id'] = strip_tags($new_instance['id']);

    return $instance;
  }

  function form($instance){
    $defaults = array(
      /* Deafult options goes here */
      'page' => 0
    );

    $instance = wp_parse_args((array) $instance, $defaults);
    wp_enqueue_media();
    /* HERE GOES THE FORM */
    ?>

    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo @$instance['title']; ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('slogan'); ?>"><?php _e('Slogan:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'slogan' ); ?>" name="<?php echo $this->get_field_name( 'slogan' ); ?>" value="<?php echo @$instance['slogan']; ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('Sub Title:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'subtitle' ); ?>" name="<?php echo $this->get_field_name( 'subtitle' ); ?>" value="<?php echo @$instance['subtitle']; ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('image1'); ?>"><?php _e('Image 1:', 'stag'); ?></label>
      <div class="uploader">
        <input type="text" class="" id="<?php echo $this->get_field_id( 'image1' ); ?>" name="<?php echo $this->get_field_name( 'image1' ); ?>" value="<?php echo @$instance['image1']; ?>" />
        <input class="button" name="<?php echo $this->get_field_id( 'image1' ); ?>_button" id="<?php echo $this->get_field_id( 'image1' ); ?>_button" value="<?php _e('Upload', 'stag'); ?>" />
        <span class="description">Size: 139 x 176 px.</span>
      </div>
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('showcase1'); ?>"><?php _e('Showcase 1:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'showcase1' ); ?>" name="<?php echo $this->get_field_name( 'showcase1' ); ?>" value="<?php echo @$instance['showcase1']; ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('text1'); ?>"><?php _e('Text 1:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'text1' ); ?>" name="<?php echo $this->get_field_name( 'text1' ); ?>" value="<?php echo @$instance['text1']; ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('image2'); ?>"><?php _e('Image 2:', 'stag'); ?></label>
      <div class="uploader">
        <input type="text" class="" id="<?php echo $this->get_field_id( 'image2' ); ?>" name="<?php echo $this->get_field_name( 'image2' ); ?>" value="<?php echo @$instance['image2']; ?>" />
        <input class="button" name="<?php echo $this->get_field_id( 'image2' ); ?>_button" id="<?php echo $this->get_field_id( 'image2' ); ?>_button" value="<?php _e('Upload', 'stag'); ?>" />
        <span class="description">Size: 139 x 176 px.</span>
      </div>
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('showcase2'); ?>"><?php _e('Showcase 2:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'showcase2' ); ?>" name="<?php echo $this->get_field_name( 'showcase2' ); ?>" value="<?php echo @$instance['showcase2']; ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('text2'); ?>"><?php _e('Text 2:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'text2' ); ?>" name="<?php echo $this->get_field_name( 'text2' ); ?>" value="<?php echo @$instance['text2']; ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('image3'); ?>"><?php _e('Image 3:', 'stag'); ?></label>
      <div class="uploader">
        <input type="text" class="" id="<?php echo $this->get_field_id( 'image3' ); ?>" name="<?php echo $this->get_field_name( 'image3' ); ?>" value="<?php echo @$instance['image3']; ?>" />
        <input class="button" name="<?php echo $this->get_field_id( 'image3' ); ?>_button" id="<?php echo $this->get_field_id( 'image3' ); ?>_button" value="<?php _e('Upload', 'stag'); ?>" />
        <span class="description">Size: 139 x 176 px.</span>
      </div>
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('showcase3'); ?>"><?php _e('Showcase 3:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'showcase3' ); ?>" name="<?php echo $this->get_field_name( 'showcase3' ); ?>" value="<?php echo @$instance['showcase3']; ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('text3'); ?>"><?php _e('Text 3:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'text3' ); ?>" name="<?php echo $this->get_field_name( 'text3' ); ?>" value="<?php echo @$instance['text3']; ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('image4'); ?>"><?php _e('Image 4:', 'stag'); ?></label>
      <div class="uploader">
        <input type="text" class="" id="<?php echo $this->get_field_id( 'image4' ); ?>" name="<?php echo $this->get_field_name( 'image4' ); ?>" value="<?php echo @$instance['image4']; ?>" />
        <input class="button" name="<?php echo $this->get_field_id( 'image4' ); ?>_button" id="<?php echo $this->get_field_id( 'image4' ); ?>_button" value="<?php _e('Upload', 'stag'); ?>" />
        <span class="description">Size: 139 x 176 px.</span>
      </div>
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('showcase4'); ?>"><?php _e('Showcase 4:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'showcase4' ); ?>" name="<?php echo $this->get_field_name( 'showcase4' ); ?>" value="<?php echo @$instance['showcase4']; ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('text4'); ?>"><?php _e('Text 4:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'text4' ); ?>" name="<?php echo $this->get_field_name( 'text4' ); ?>" value="<?php echo @$instance['text4']; ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('id'); ?>"><?php _e('Section ID:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'id' ); ?>" name="<?php echo $this->get_field_name( 'id' ); ?>" value="<?php echo @$instance['id']; ?>" />
      <span class="description">Section ID is required if you want to use this section as a navigation. e.g. about, and add a custom link under Menus with link #about.</span>
    </p>
    <script>
jQuery(document).ready(function($)
{
    var _custom_media = true,
        _orig_send_attachment = wp.media.editor.send.attachment;

    // ADJUST THIS to match the correct button
    $('.uploader .button').click(function(e) 
    {
        var send_attachment_bkp = wp.media.editor.send.attachment;
        var button = $(this);
        var id = button.attr('id').replace('_button', '');
        _custom_media = true;
        wp.media.editor.send.attachment = function(props, attachment)
        {
            if ( _custom_media ) 
            {
                $("#"+id).val(attachment.url);
            } else {
                return _orig_send_attachment.apply( this, [props, attachment] );
            };
        }

        wp.media.editor.open(button);
        return false;
    });

    $('.add_media').on('click', function()
    {
        _custom_media = false;
    });
});    
    </script>
    <?php
  }
}

?>