<?php
add_action('widgets_init', create_function('', 'return register_widget("stag_section_team_pitchdays2");'));

class stag_section_team_pitchdays2 extends WP_Widget
{
    function stag_section_team_pitchdays2()
    {
        $widget_ops = array('classname' => 'section-block', 'description' => __('Displays your team members by category and their extended info.', 'stag'));
        $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'stag_section_team_pitchdays2');
        $this->WP_Widget('stag_section_team_pitchdays2', __('Homepage: Team by Category Section V2', 'stag'), $widget_ops, $control_ops);
    }

    function widget($args, $instance)
    {
        extract($args);

        // VARS FROM WIDGET SETTINGS
        $title = apply_filters('widget_title', $instance['title']);
        $subtitle = $instance['subtitle'];
        $category = $instance['category'];
        $pitchdays = $instance['pitchdays'];
        $id = $instance['id'];
        $translate = $instance['translate'];
        $ordering = $instance['ordering'];

        echo $before_widget;
        if ($translate != 'on') {
            global $sitepress;
            //changes to the default language
            $sitepress->switch_lang($sitepress->get_default_language());
        }
        $title = apply_filters('widget_title', $instance['title']);

        ?>

        <!-- BEGIN #team.section-block -->
        <section id="<?php echo stag_to_slug($id); ?>" class="section-block team-widget version2">
            <div class="inner-section">
                <!-- mentor  -->
                <?php
                //if($subtitle != '') echo '<p class="sub-title">'.$subtitle.'</p>';
                //echo '<br/>'.$before_title . 'Mentores' . $after_title;
                echo '<h2 class="main-title">' . $title . '</h2>';

                $args = array(
                    'post_type' => 'team',
                    'meta_key' => '_stag_team_pitchdays',
                    'meta_value' => $pitchdays,
                    'meta_key' => '_stag_team_category',
                    'meta_value' => $category,
                    //'meta_compare' => 'IN',
                    'posts_per_page' => -1,
                );

                if ($ordering != '') {
                    $args['meta_key'] = '_stag_team_order';
                    $args['orderby'] = 'meta_value_num';
                    $args['order'] = $ordering;
                }

                $the_query = new WP_Query($args);
                ?>
                <div class="team-members">
                    <?php
                    if ($the_query->have_posts()) {
                        $i = 0;
                        while ($the_query->have_posts()): $the_query->the_post();
                            ?>
                            <div id="<?php print get_the_ID() ?>"><p></p></div>
                            <section class="member-section <?php echo $i % 2 == 0 ? "even" : "odd" ?>">
                                <?php
                                $area_tag = get_post_meta(get_the_ID(), '_stag_team_area_type', true);
                                if ($area_tag == 'Ninguno' || $area_tag == '') $area_tag = '&nbsp;';
                                ?>
                                <div class="member">
                                    <?php if ($area_tag != ''): ?>
                                        <div
                                                class="area-tag <?php echo seoUrl($area_tag); ?>"><?php echo $area_tag; ?></div>
                                    <?php endif ?>
                                    <?php if (has_post_thumbnail()): ?>
                                        <div class="member-pic">
                                            <?php the_post_thumbnail('full'); ?>

                                            <div class="member-links">

                                                <?php if (get_post_meta(get_the_ID(), '_stag_team_url_twitter', true) != ''): ?>
                                                    <a href="<?php echo get_post_meta(get_the_ID(), '_stag_team_url_twitter', true); ?>"
                                                       class="twitter"></a>
                                                <?php endif ?>

                                                <?php if (get_post_meta(get_the_ID(), '_stag_team_url_linkedin', true) != ''): ?>
                                                    <a href="<?php echo get_post_meta(get_the_ID(), '_stag_team_url_linkedin', true); ?>"
                                                       class="linkedin"></a>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="member-description">
                                        <p class="member-title"><a
                                                    href="/listado-colaboradores/?cat=<?php print urlencode($category) . ($_GET['lang'] != '' && $translate == 'on' ? '&lang=' . $_GET['lang'] : '') . '#' . get_the_ID(); ?>"><?php the_title(); ?></a>
                                        </p>
                                        <?php if (get_post_meta(get_the_ID(), '_stag_team_position', true) != '') echo '<p class="member-position">' . get_post_meta(get_the_ID(), '_stag_team_position', true) . '</p>'; ?>
                                    </div>
                                </div>
                                <div class="member-bio">
                                    <?php if (get_post_meta(get_the_ID(), '_stag_team_bio', true) != '') echo '<p >' . get_post_meta(get_the_ID(), '_stag_team_bio', true) . '</p>'; ?>
                                </div>
                                <div class="clearfix"></div>
                            </section>
                            <?php
                            $i++;
                        endwhile;
                    }
                    wp_reset_postdata();
                    ?>
                </div>
                <!-- end member -->
            </div>
            <!-- END #team.section-block -->
        </section>
        <script>
            jQuery(document).ready(function () {

                jQuery('.member-description').equalHeights();

            });
            /**
             * Equal Heights Plugin
             * Equalize the heights of elements. Great for columns or any elements
             * that need to be the same size (floats, etc).
             *
             * Version 1.0
             * Updated 12/10/2008
             *
             * Copyright (c) 2008 Rob Glazebrook (cssnewbie.com)
             *
             * Usage: $(object).equalHeights([minHeight], [maxHeight]);
             *
             * Example 1: $(".cols").equalHeights(); Sets all columns to the same height.
             * Example 2: $(".cols").equalHeights(400); Sets all cols to at least 400px tall.
             * Example 3: $(".cols").equalHeights(100,300); Cols are at least 100 but no more
             * than 300 pixels tall. Elements with too much content will gain a scrollbar.
             *
             */

            (function ($) {
                $.fn.equalHeights = function (minHeight, maxHeight) {
                    tallest = (minHeight) ? minHeight : 0;
                    this.each(function () {
                        if ($(this).height() > tallest) {
                            tallest = $(this).height();
                        }
                    });
                    if ((maxHeight) && tallest > maxHeight) tallest = maxHeight;
                    return this.each(function () {
                        $(this).height(tallest).css("overflow", "hidden");
                    });
                }
            })(jQuery);
        </script>

        <?php
        if ($translate != 'on') {
            //changes to the current language
            $sitepress->switch_lang(ICL_LANGUAGE_CODE);
        }
        echo $after_widget;
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;

        // STRIP TAGS TO REMOVE HTML
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['subtitle'] = strip_tags($new_instance['subtitle']);
        $instance['category'] = strip_tags($new_instance['category']);
        $instance['pitchdays'] = strip_tags($new_instance['pitchdays']);
        $instance['id'] = strip_tags($new_instance['id']);
        $instance['translate'] = strip_tags($new_instance['translate']);
        $instance['ordering'] = strip_tags($new_instance['ordering']);

        return $instance;
    }

    function form($instance)
    {
        $defaults = array(
            /* Deafult options goes here */
            'page' => 0
        );

        $instance = wp_parse_args((array)$instance, $defaults);
        $ordering_options = array('' => __('Default Ordering', 'stag'),
            'ASC' => __('Ascending', 'stag'),
            'DESC' => __('Descending', 'stag'),
        );

        $options = array('Team' => 'Team',
            'Speaker' => 'Speaker',
            'Judges and Mentors' => 'Judges and Mentors',
            'Collaborator' => 'Collaborator',
            'Sponsor' => 'Sponsor',
        );
        /* HERE GOES THE FORM */
        ?>

        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'stag'); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo @$instance['title']; ?>"/>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('Sub Title:', 'stag'); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('subtitle'); ?>"
                   name="<?php echo $this->get_field_name('subtitle'); ?>"
                   value="<?php echo @$instance['subtitle']; ?>"/>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Category:', 'stag'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('category'); ?>"
                    name="<?php echo $this->get_field_name('category'); ?>">
                <?php
                foreach ($options as $key => $value) {
                    # code...
                    if (@$instance['category'] == $value)
                        $selected = 'selected="selected"';
                    else
                        $selected = '';
                    ?>
                    <option value="<?= $key; ?>" <?= $selected; ?>><?= $value; ?></option>
                    <?php
                }
                ?>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('ordering'); ?>"><?php _e('Order by weight:', 'stag'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('ordering'); ?>"
                    name="<?php echo $this->get_field_name('ordering'); ?>">
                <?php
                foreach ($ordering_options as $key => $value) {
                    # code...
                    if (@$instance['ordering'] == $key)
                        $selected = 'selected="selected"';
                    else
                        $selected = '';
                    ?>
                    <option value="<?= $key; ?>" <?= $selected; ?>><?= $value; ?></option>
                    <?php
                }
                ?>
            </select>
        </p>
        <p>
            <label
                    for="<?php echo $this->get_field_id('pitchdays'); ?>"><?php _e('Pitch Days Event:', 'stag'); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('pitchdays'); ?>"
                   name="<?php echo $this->get_field_name('pitchdays'); ?>"
                   value="<?php echo @$instance['pitchdays']; ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('id'); ?>"><?php _e('Section ID:', 'stag'); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('id'); ?>"
                   name="<?php echo $this->get_field_name('id'); ?>" value="<?php echo @$instance['id']; ?>"/>
            <span class="description">Section ID is required if you want to use this section as a navigation. e.g. about, and add a custom link under Menus with link #about.</span>
            <label for="<?php echo $this->get_field_id('translate'); ?>"><?php _e('Translate:', 'stag'); ?></label>
            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('translate'); ?>"
                   name="<?php echo $this->get_field_name('translate'); ?>" <?php checked(@$instance['translate'], 'on'); ?> />
        </p>

        <?php
    }
}

?>