<?php
add_action('widgets_init', create_function('', 'return register_widget("stag_section_contact");'));

class stag_section_contact extends WP_Widget{
  function stag_section_contact(){
    $widget_ops = array('classname' => 'section-block', 'description' => __('Displayed contact form including map and contact details.', 'stag'));
    $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'stag_section_contact');
    $this->WP_Widget('stag_section_contact', __('Homepage: Contact Section', 'stag'), $widget_ops, $control_ops);
  }

  function widget($args, $instance){
    extract($args);

    // VARS FROM WIDGET SETTINGS
    $title = apply_filters('widget_title', $instance['title'] );
    $subtitle = $instance['subtitle'];
    $map_url = $instance['map_url'];
    $sub_heading = $instance['sub_heading'];
    $address = $instance['address'];
    $email = $instance['email'];
    $description = $instance['description'];

    echo $before_widget;

    ?>

    <!-- BEGIN #contact.section-block -->
    <section id="contact" class="section-block">

      <div class="inner-section">
        <?php
          if($subtitle != '') echo '<p class="sub-title">'.$subtitle.'</p>';
          echo $before_title.$title.$after_title;
        ?>
      </div>



      <div class="inner-section">
        <div class="grids">
          <div class="grid-6">
          <br>
            <?php if($sub_heading != '') echo '<h3 class="sub-heading">'.$sub_heading.'</h3>'; ?>
            <address>
              <?php

              //if($address != '') echo "<p class='address'><i class='icon'></i>$address</p>";
            	
              if($map_url != '')
				//echo '<iframe width="400" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'.$map_url.'&amp;output=embed"></iframe>';
				
				echo "<p class='address'><i class='icon'></i><b>Parque E:</b><br>Calle 65 Nro 55-46 Parque E Medellín.</p>";
				
				echo "<p class='address'><i class='icon'></i><b>Opinno USA:</b><br>Steuart Tower,1 Market St. STE 500, San Francisco, CA 94105</p>";
				//echo '<iframe width="400" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.es/maps?f=q&amp;source=s_q&amp;hl=es&amp;geocode=&amp;q=Steuart+Tower,+San+Francisco,+CA+94105&amp;aq=&amp;sll=37.794059,-122.393532&amp;sspn=0.003022,0.005681&amp;ie=UTF8&amp;hq=&amp;hnear=One+Market+Plaza,+1+Market+St+%23345,+San+Francisco,+California+94105-1097,+Estados+Unidos&amp;t=m&amp;ll=37.794053,-122.395075&amp;spn=0.003022,0.005681&amp;z=14&amp;output=embed"></iframe>';

				echo "<p class='address'><i class='icon'></i><b>Fundación Coomeva:<b><br>Calle 13 # 57 - 50 Cali Colombia - Sede Nacional Coomeva</p>";				

              if($email != '') echo "<p class='email'><i class='icon'></i>$email</p>";
                     

              ?>
              <p><a href="https://www.facebook.com/groups/acelerax2/"><img src="/wp-content/uploads/fb.jpg" width="35" align="left"></a>&nbsp;&nbsp;&nbsp;¡Siguenos en Facebook!</p>
            </address>

            
          </div>

          <div class="grid-6">
			<?php if($description != '') echo "<div class='description'>$description</div>"; ?>
            <form action="#contact" method="post">
              <?php

              $nameError = '';
              $emailError = '';
              $commentError = '';

              if(isset($_POST['contact_submit'])){

                if(trim($_POST['contact_name']) === '') {
                  $nameError = 'Please enter your name.';
                  $hasError = true;
                } else {
                  $name = trim($_POST['contact_name']);
                }

                if(trim($_POST['contact_email']) === '')  {
                  $emailError = 'Please enter your email address.';
                  $hasError = true;
                } else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['contact_email']))) {
                  $emailError = 'You entered an invalid email address.';
                  $hasError = true;
                } else {
                  $email = trim($_POST['contact_email']);
                }

                if(trim($_POST['contact_message']) === '') {
                  $commentError = 'Please enter a message.';
                  $hasError = true;
                } else {
                  if(function_exists('stripslashes')) {
                    $comments = stripslashes(trim($_POST['contact_message']));
                  } else {
                    $comments = trim($_POST['contact_message']);
                  }

                  if(!isset($hasError)) {
                    $emailTo = stag_get_option('general_contact_email');
                    if (!isset($emailTo) || ($emailTo == '') ){
                      $emailTo = get_option('admin_email');
                    }
                    $subject = '[Contact Form] From '.$name;
                    $body = "Name: $name \n\nEmail: $email \n\nComments: $comments";
                    $headers = 'From: '.$name.' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;

                    mail($emailTo, $subject, $body, $headers);
                    $emailSent = true;
                  }
                }

              }



              ?>


              <?php if(isset($emailSent) && $emailSent == true): ?>
              <div class="thanks">
                <p><?php _e('Thanks, your email was sent successfully.', 'stag') ?></p>
              </div>
              <?php endif; ?>


              <div class="row">
                <input type="text" name="contact_name" placeholder="Name" value="<?php if(isset($_POST['contact_name'])) echo $_POST['contact_name'] ?>" required>
                <?php if($nameError != '') { ?>
                    <span class="error"><?php echo $nameError; ?></span>
                <?php } ?>
              </div>

              <div class="row">
                <input type="email" name="contact_email" placeholder="Email" value="<?php if(isset($_POST['contact_email'])) echo $_POST['contact_email'] ?>" required>
                <?php if($emailError != '') { ?>
                    <span class="error"><?php echo $emailError; ?></span>
                <?php } ?>
              </div>

              <div class="row">
                <textarea name="contact_message" placeholder="Message" required><?php if(isset($_POST['contact_message'])) echo $_POST['contact_message']; ?></textarea>
                <?php if($commentError != '') { ?>
                    <span class="error"><?php echo $commentError; ?></span>
                <?php } ?>
              </div>

              <div class="row">
                <button name="contact_submit" type="submit">Send</button>
              </div>

            </form>

          </div>
        </div>
      </div>

      <!-- END #contact.section-block -->
    </section>

    <?php
    echo $after_widget;
  }

  function update($new_instance, $old_instance){
    $instance = $old_instance;

    // STRIP TAGS TO REMOVE HTML
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['subtitle'] = strip_tags($new_instance['subtitle']);
    $instance['map_url'] = strip_tags($new_instance['map_url']);
    $instance['sub_heading'] = strip_tags($new_instance['sub_heading']);
    $instance['address'] = strip_tags($new_instance['address']);
    $instance['email'] = strip_tags($new_instance['email']);
    $instance['description'] = $new_instance['description'];

    return $instance;
  }

  function form($instance){
    $defaults = array(
      /* Deafult options goes here */
      'title' => 'This is a title',
      'sub_heading' => 'Send a Direct Message or Visit us',
    );

    $instance = wp_parse_args((array) $instance, $defaults);

    /* HERE GOES THE FORM */
    ?>

    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo @$instance['title']; ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('Sub Title:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'subtitle' ); ?>" name="<?php echo $this->get_field_name( 'subtitle' ); ?>" value="<?php echo @$instance['subtitle']; ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('map_url'); ?>"><?php _e('Map URL:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'map_url' ); ?>" name="<?php echo $this->get_field_name( 'map_url' ); ?>" value="<?php echo @$instance['map_url']; ?>" />
      <span class="description">Enter the Google Map URL (optional)</span>
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('sub_heading'); ?>"><?php _e('Sub Heading:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'sub_heading' ); ?>" name="<?php echo $this->get_field_name( 'sub_heading' ); ?>" value="<?php echo @$instance['sub_heading']; ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('address'); ?>"><?php _e('Address:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'address' ); ?>" name="<?php echo $this->get_field_name( 'address' ); ?>" value="<?php echo @$instance['address']; ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('email'); ?>"><?php _e('Email:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>" value="<?php echo @$instance['email']; ?>" />
      <span class="description"><strong>Note:</strong> The email you enter here will be displayed publicly.</span>
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('description'); ?>"><?php _e('Description:', 'stag'); ?></label>
      <textarea rows="8" class="widefat" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>"><?php echo @$instance['description']; ?></textarea>
    </p>

    <?php
  }
}

?>
