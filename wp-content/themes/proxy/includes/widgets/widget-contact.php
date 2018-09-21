<?php
add_action('widgets_init', create_function('', 'return register_widget("stag_section_contact");'));

class stag_section_contact extends WP_Widget
{
    function stag_section_contact()
    {
        $widget_ops = array('classname' => 'section-block', 'description' => __('Displayed contact form including map and contact details.', 'stag'));
        $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'stag_section_contact');
        $this->WP_Widget('stag_section_contact', __('Homepage: Contact Section', 'stag'), $widget_ops, $control_ops);
    }

    function widget($args, $instance)
    {
        extract($args);

        // VARS FROM WIDGET SETTINGS
        $title = apply_filters('widget_title', $instance['title']);
        $subtitle = $instance['subtitle'];
        $map_url = $instance['map_url'];
        $map_iframe = $instance['map_iframe'];
        $sub_heading = $instance['sub_heading'];
        $address = $instance['address'];
        $email = $instance['email'];
        $subject = $instance['subject'];
        $description = $instance['description'];

        echo $before_widget;

        ?>

        <!-- BEGIN #contact.section-block -->
        <section id="contact" class="section-block">

            <div class="inner-section">
                <?php
                if ($subtitle != '') echo '<p class="sub-title">' . __($subtitle, 'stag') . '</p>';
                echo $before_title . $title . $after_title;
                ?>
            </div>


            <div class="inner-section">
                <div class="grids">
                    <div class="grid-6">
                        <br>
                        <?php if ($sub_heading != '') echo '<h3 class="sub-heading">' . __($sub_heading, 'stag') . '</h3>'; ?>
                        <address>
                            <?php

                            //if($address != '') echo "<p class='address'><i class='icon'></i>$address</p>";


                            //echo "<p class='address'><i class='icon'></i><b>Parque E:</b><br>Calle 65 Nro 55-46 Parque E Medellín.</p>";

                            //echo "<p class='address'><i class='icon'></i><b>Opinno USA:</b><br>Steuart Tower,1 Market St. STE 500, San Francisco, CA 94105</p>";
                            //echo '<iframe width="400" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.es/maps?f=q&amp;source=s_q&amp;hl=es&amp;geocode=&amp;q=Steuart+Tower,+San+Francisco,+CA+94105&amp;aq=&amp;sll=37.794059,-122.393532&amp;sspn=0.003022,0.005681&amp;ie=UTF8&amp;hq=&amp;hnear=One+Market+Plaza,+1+Market+St+%23345,+San+Francisco,+California+94105-1097,+Estados+Unidos&amp;t=m&amp;ll=37.794053,-122.395075&amp;spn=0.003022,0.005681&amp;z=14&amp;output=embed"></iframe>';

                            //echo "<p class='address'><i class='icon'></i><b>Fundación Coomeva:<b><br>Calle 13 # 57 - 50 Cali Colombia - Sede Nacional Coomeva</p>";

                            if ($email != '') echo "<p class='email'><a href=\"mailto:$email\"><i class='icon'></i>$email</a></p>";


                            ?>
                            <!--<p><a href="https://www.facebook.com/groups/acelerax2/"><img src="/wp-content/uploads/fb.jpg" width="35" align="left"></a>&nbsp;&nbsp;&nbsp;¡Siguenos en Facebook!</p>-->
                        </address>


                    </div>

                    <div class="grid-6">
                        <?php if ($description != '') echo "<div class='description'>__($description, 'stag')</div>"; ?>
                        <form action="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>#contact" method="post">
                            <input type='text' name='dfx_gotcha' id='dfx_gotcha' class='dfx_gotcha' value=''/>
                            <?php

                            $nameError = '';
                            $emailError = '';
                            $commentError = '';
                            do_action('google_invre_render_widget_action');

                            $is_valid = apply_filters('google_invre_is_valid_request_filter', true);
                            if (!$is_valid) {
                                $hasError = true;
                            }

                            if (isset($_POST['dfx_gotcha']) && trim($_POST['dfx_gotcha']) != '') {
                                $hasError = true;
                            }

                            if (isset($_POST['contact_submit'])) {

                                if (trim($_POST['contact_name']) === '') {
                                    $nameError = __('Please enter your name.', 'stag');
                                    $hasError = true;
                                } else {
                                    $name = trim($_POST['contact_name']);
                                }

                                if (trim($_POST['contact_email']) === '') {
                                    $emailError = __('Please enter your email address.', 'stag');
                                    $hasError = true;
                                } else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['contact_email']))) {
                                    $emailError = __('You entered an invalid email address.', 'stag');
                                    $hasError = true;
                                } else {
                                    $email = trim($_POST['contact_email']);
                                }

                                if (trim($_POST['contact_message']) === '') {
                                    $commentError = __('Please enter a message.', 'stag');
                                    $hasError = true;
                                } else {
                                    if (function_exists('stripslashes')) {
                                        $comments = stripslashes(trim($_POST['contact_message']));
                                    } else {
                                        $comments = trim($_POST['contact_message']);
                                    }

                                    if (!isset($hasError)) {
                                        $emailTo = stag_get_option('general_contact_email');
                                        if (!isset($emailTo) || ($emailTo == '')) {
                                            $emailTo = get_option('admin_email');
                                        }
                                        #if($email != '') $emailTo = $email;
                                        $subject = $subject == '' ? '[Contact Form] From ' . $name : $subject;
                                        $body = "Name: $name \n\nEmail: $email \n\nComments: $comments";
                                        $headers = 'From: ' . $name . ' <' . $emailTo . '>' . "\r\n" . 'Reply-To: ' . $email;

                                        mail($emailTo, $subject, $body, $headers);
                                        $emailSent = true;
                                    }
                                }
                            }
                            ?>
                            <br/>
                            <?php if (isset($emailSent) && $emailSent == true): ?>
                                <div class="thanks">
                                    <p><?php _e('Thanks, your email was sent successfully.', 'stag') ?></p>
                                </div>
                            <?php else: ; ?>
                                <div class="row">
                                    <input type="text" name="contact_name" placeholder="<?php _e('Name', 'stag'); ?>" value="<?php if (isset($_POST['contact_name'])) echo $_POST['contact_name'] ?>"
                                           required>
                                    <?php if ($nameError != '') { ?>
                                        <span class="error"><?php echo $nameError; ?></span>
                                    <?php } ?>
                                </div>

                                <div class="row">
                                    <input type="email" name="contact_email" placeholder="<?php _e('Email', 'stag'); ?>"
                                           value="<?php if (isset($_POST['contact_email'])) echo $_POST['contact_email'] ?>" required>
                                    <?php if ($emailError != '') { ?>
                                        <span class="error"><?php echo $emailError; ?></span>
                                    <?php } ?>
                                </div>

                                <div class="row">
                                    <textarea name="contact_message" placeholder="<?php _e('Message', 'stag'); ?>"
                                              required><?php if (isset($_POST['contact_message'])) echo $_POST['contact_message']; ?></textarea>
                                    <?php if ($commentError != '') { ?>
                                        <span class="error"><?php echo $commentError; ?></span>
                                    <?php } ?>
                                </div>

                                <div class="row">
                                    <button name="contact_submit" type="submit"><?php _e('Send', 'stag'); ?></button>
                                </div>
                            <?php endif; ?>
                        </form>

                    </div>
                </div>
            </div>
            <!-- END #contact.section-block -->
        </section>
        <?php
        if ($map_url != '') echo '<div class="map_iframe"><iframe width="100%" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.google.com/maps/embed?' . $map_url . '&amp;output=embed"></iframe></div>';
        elseif ($map_iframe != '') echo '<div class="map_iframe">' . $map_iframe . '</div>';
        ?>
        <script>jQuery(document).ready(function () {
                jQuery(".map_iframe iframe").width(jQuery(window).width());
            });</script>
        <?php
        echo $after_widget;
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;

        // STRIP TAGS TO REMOVE HTML
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['subtitle'] = strip_tags($new_instance['subtitle']);
        $instance['map_url'] = strip_tags($new_instance['map_url']);
        $instance['map_iframe'] = stripslashes($new_instance['map_iframe']);
        $instance['sub_heading'] = strip_tags($new_instance['sub_heading']);
        $instance['address'] = strip_tags($new_instance['address']);
        $instance['email'] = strip_tags($new_instance['email']);
        $instance['subject'] = strip_tags($new_instance['subject']);
        $instance['description'] = $new_instance['description'];

        return $instance;
    }

    function form($instance)
    {
        $defaults = array(
            /* Deafult options goes here */
            'title' => 'This is a title',
            'sub_heading' => 'Send a Direct Message or Visit us',
        );

        $instance = wp_parse_args((array)$instance, $defaults);

        /* HERE GOES THE FORM */
        ?>

        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'stag'); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo @$instance['title']; ?>"/>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('Sub Title:', 'stag'); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('subtitle'); ?>" name="<?php echo $this->get_field_name('subtitle'); ?>"
                   value="<?php echo @$instance['subtitle']; ?>"/>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('map_url'); ?>"><?php _e('Map URL:', 'stag'); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('map_url'); ?>" name="<?php echo $this->get_field_name('map_url'); ?>" value="<?php echo @$instance['map_url']; ?>"/>
            <span class="description">Enter the Google Map URL (optional)</span>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('map_iframe'); ?>"><?php _e('Map Iframe:', 'stag'); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('map_iframe'); ?>" name="<?php echo $this->get_field_name('map_iframe'); ?>"><?php echo @$instance['map_iframe']; ?></textarea>
            <span class="description">Enter the Google Map Iframe (optional)</span>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('sub_heading'); ?>"><?php _e('Sub Heading:', 'stag'); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('sub_heading'); ?>" name="<?php echo $this->get_field_name('sub_heading'); ?>"
                   value="<?php echo @$instance['sub_heading']; ?>"/>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('address'); ?>"><?php _e('Address:', 'stag'); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('address'); ?>" name="<?php echo $this->get_field_name('address'); ?>" value="<?php echo @$instance['address']; ?>"/>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('email'); ?>"><?php _e('Email:', 'stag'); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" value="<?php echo @$instance['email']; ?>"/>
            <span class="description"><strong>Note:</strong> The email you enter here will be displayed publicly.</span>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('subject'); ?>"><?php _e('Email Subject:', 'stag'); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('subject'); ?>" name="<?php echo $this->get_field_name('subject'); ?>" value="<?php echo @$instance['subject']; ?>"/>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('description'); ?>"><?php _e('Description:', 'stag'); ?></label>
            <textarea rows="8" class="widefat" id="<?php echo $this->get_field_id('description'); ?>"
                      name="<?php echo $this->get_field_name('description'); ?>"><?php echo @$instance['description']; ?></textarea>
        </p>

        <?php
    }
}

?>
