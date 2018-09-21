<?php
add_action('widgets_init', create_function('', 'return register_widget("stag_section_events");'));

class stag_section_events extends WP_Widget
{
    function stag_section_events()
    {
        $widget_ops = array('classname' => 'section-block', 'description' => __('Displays your events.', 'stag'));
        $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'stag_section_events');
        $this->WP_Widget('stag_section_events', __('Homepage: Events Section', 'stag'), $widget_ops, $control_ops);
    }

    function widget($args, $instance)
    {
        extract($args);
        // VARS FROM WIDGET SETTINGS
        $title = apply_filters('widget_title', $instance['title']);
        $subtitle = $instance['subtitle'];
        $after_title = $instance['after_title'];
        $type = $instance['type'];
        $fscity = $instance['fscity'];
        $pdcity = $instance['pdcity'];
        $visacity = $instance['visacity'];
        $filter = $instance['filter'];
        $id = $instance['id'];
        $more_link = $instance['more_link'] ? 'true' : 'false';
        $number_posts = $instance['number_posts'] > 0 || $instance['number_posts'] != '' ? $instance['number_posts'] : 15;
        $category = $type ? ($type == 96 ? 'finnosummits?type=' . $type . '&fscity=' . $fscity . '&filter=' . $filter : 'pitch-days?type=' . $type . '&pdcity=' . $pdcity . '&visacity=' . $visacity . '&filter=' . $filter ): false;
        echo $before_widget;
        ?>
        <!-- BEGIN #blog.section-block -->
        <section id="<?php echo stag_to_slug($id); ?>" class="events videos section-block">
            <div class="inner-section">
                <?php
                echo '<h2 class="main-title">' . $title . '</h2>';
                if ($subtitle != '') echo '<p class="sub-title">' . __($subtitle, 'stag') . '</p>';
                ?>
                <div class="grid-12">
                    <div class="video-item">
                        <?php
                        $type_args = array(
                            'taxonomy' => 'event_type',
                            'terms' => $type,
                            'field' => 'term_id',
                        );
                        $fscity_args = array(
                            'taxonomy' => 'event_city',
                            'terms' => $fscity,
                            'field' => 'term_id',
                        );
                        $pdcity_args = array(
                            'taxonomy' => 'event_pdcity',
                            'terms' => $pdcity,
                            'field' => 'term_id',
                        );
                        $visacity_args = array(
                            'taxonomy' => 'event_visacity',
                            'terms' => $visacity,
                            'field' => 'term_id',
                        );
                        $date_args = array(
                            'key' => '_stag_event_date',
                            'value' => date('Y-m-d'),
                            'type' => 'DATE',
                            'compare' => $filter,
                        );

                        if ($type == '') $type_args = '';
                        if ($fscity == '') $fscity_args = '';
                        if ($pdcity == '') $pdcity_args = '';
                        if ($visacity == '') $visacity_args = '';
                        if ($filter == '') $date_args = '';

                        $args = array(
                            'post_type' => 'event',
                            'meta_query' => array(
                                $date_args,
                            ),
                            'tax_query' => array(
                                'relation' => 'AND',
                                $type_args,
                                $fscity_args,
                                $pdcity_args,
                                $visacity_args,
                            ),
                            'posts_per_page' => $number_posts,
                            'orderby' => '_stag_event_date',
                            'order' => 'ASC'
                        );
                        if (!$number_posts) $args = false;
                        $the_query = new WP_Query($args);
                        $posts = query_posts($args);
                        if (have_posts()) {
                            $postCount = 0;
                            while (have_posts()): the_post();
                                $postCount++;
                                $taxonomy = $type == 96 ? 'event_city' : 'event_pdcity';
                                $terms = get_the_terms(get_the_ID(), $taxonomy);
                                if (sizeof($terms) > 0) {
                                    foreach ((array)$terms as $term) {
                                        $pd_tag = $term->name;
                                        $pd_css = $term->slug;
                                        $pd_color = $term->description;
                                    }
                                }

                                $event_date = get_post_meta(get_the_ID(), '_stag_event_date', false) ? get_post_meta(get_the_ID(), '_stag_event_date', false)[0] : false;
                                $event_date = $event_date ? date('d, M Y', strtotime($event_date)) : false;
                                ?>
                                <div class="item">
                                    <div id="<?php print get_the_ID() ?>"><p></p></div>
                                    <div class="entry-content pdentry">
                                        <?php if ($pd_tag != ''): ?>
                                            <span><div class="pd-tag <?php echo $pd_css; ?>"
                                                       style="background-color: #<?php echo $pd_color; ?>;"><?php echo $pd_tag . ' ' . $event_date; ?></div></span>
                                        <?php endif ?>
                                        <a href="<?php the_permalink(); ?>"
                                           title="<?php the_title_attribute(); ?>" <?php if ($pd_tag != '') echo 'style="padding-left: 0 !important; padding-right: 0 !important;"' ?>>
                                            <?php the_post_thumbnail('medium'); ?>
                                            <h3><?php dfx_the_title(); ?></h3>

                                            <div class="overlay"><?php dfx_the_excerpt2(); ?></div>
                                        </a>

                                        <div class="boxed disqus" style="display: none;"><a
                                                href="<?php the_permalink(); ?>#disqus_thread"><i
                                                    class="fa fa-comments fa-stack-2x fa-inverse"></i><s>0</s></a></div>
                                    </div>
                                </div>
                            <?php
                            endwhile;
                        }
                        wp_reset_postdata();
                        wp_reset_query();
                        ?>
                    </div>
                    <div class="clearfix"></div>
                    <?php if ($after_title != '') echo '<div class="after_title">' . __($after_title, 'stag') . '</div>'; ?>
                    <?php $no_posts = wp_count_posts();
                    if ($no_posts->publish > $number_posts && $more_link == 'true' && $category): ?>
                        <div <?php post_class($d_c); ?> >
                            <a class="bottom-link"
                               href="<?php echo $category; ?>"><?php echo __('View', 'stag') . ' ' . $title; ?> &raquo;</a>
                        </div>
                    <?php
                    endif;; ?>
                </div>
                <!-- END .inner-section -->
            </div>
            <!-- END #blog.section-block -->
            <div class="clearfix"></div>
        </section>
        <?php
        echo $after_widget;
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;

        // STRIP TAGS TO REMOVE HTML
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['subtitle'] = strip_tags($new_instance['subtitle']);
        $instance['after_title'] = $new_instance['after_title'];
        $instance['type'] = strip_tags($new_instance['type']);
        $instance['fscity'] = strip_tags($new_instance['fscity']);
        $instance['pdcity'] = strip_tags($new_instance['pdcity']);
        $instance['filter'] = $new_instance['filter'];
        $instance['more_link'] = strip_tags($new_instance['more_link']);
        $instance['number_posts'] = strip_tags($new_instance['number_posts']);
        $instance['id'] = strip_tags($new_instance['id']);

        return $instance;
    }

    function form($instance)
    {
        $defaults = array(/* Deafult options goes here */
        );

        $instance = wp_parse_args((array)$instance, $defaults);

        $options_start = new stdClass();
        $options_start->name = __('All', 'stag');
        $options_start->slug = '';

        $type_taxonomies = array('event_type');
        $type_options = get_terms($type_taxonomies, 'hide_empty=0');
        $type_options = array_merge(array('' => $options_start), $type_options);

        $city_taxonomies = array('event_city');
        $city_options = get_terms($city_taxonomies, 'hide_empty=0');
        $city_options = array_merge(array('' => $options_start), $city_options);

        $pdcity_taxonomies = array('event_pdcity');
        $pdcity_options = get_terms($pdcity_taxonomies, 'hide_empty=0');
        $pdcity_options = array_merge(array('' => $options_start), $pdcity_options);

        $visacity_taxonomies = array('event_visacity');
        $visacity_options = get_terms($visacity_taxonomies, 'hide_empty=0');
        $visacity_options = array_merge(array('' => $options_start), $visacity_options);

        $date_options = array('' => __('All', 'stag'), '<=' => __('Past events', 'stag'), '>=' => __('Future events', 'stag'));

        /* HERE GOES THE FORM */
        ?>

        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'stag'); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo @$instance['title']; ?>"/>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('Sub Title:', 'stag'); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('subtitle'); ?>"
                      name="<?php echo $this->get_field_name('subtitle'); ?>"><?php echo @$instance['subtitle']; ?></textarea>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('after_title'); ?>"><?php _e('After Text:', 'stag'); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('after_title'); ?>"
                      name="<?php echo $this->get_field_name('after_title'); ?>"><?php echo @$instance['after_title']; ?></textarea>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('type'); ?>"><?php _e('Type of Event:', 'stag'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('type'); ?>"
                    name="<?php echo $this->get_field_name('type'); ?>">
                <?php
                foreach ($type_options as $key => $value) {
                    # code...
                    if (@$instance['type'] == $value->term_id)
                        $selected = 'selected="selected"';
                    else
                        $selected = '';
                    ?>
                    <option value="<?= $value->term_id; ?>" <?= $selected; ?>><?= $value->name; ?></option>
                <?php
                }
                ?>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('fscity'); ?>"><?php _e('FS City:', 'stag'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('fscity'); ?>"
                    name="<?php echo $this->get_field_name('fscity'); ?>">
                <?php
                foreach ($city_options as $key => $value) {
                    # code...
                    if (@$instance['fscity'] == $value->term_id)
                        $selected = 'selected="selected"';
                    else
                        $selected = '';
                    ?>
                    <option value="<?= $value->term_id; ?>" <?= $selected; ?>><?= $value->name; ?></option>
                <?php
                }
                ?>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('pdcity'); ?>"><?php _e('PD City:', 'stag'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('pdcity'); ?>"
                    name="<?php echo $this->get_field_name('pdcity'); ?>">
                <?php
                foreach ($pdcity_options as $key => $value) {
                    # code...
                    if (@$instance['pdcity'] == $value->term_id)
                        $selected = 'selected="selected"';
                    else
                        $selected = '';
                    ?>
                    <option value="<?= $value->term_id; ?>" <?= $selected; ?>><?= $value->name; ?></option>
                <?php
                }
                ?>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('visacity'); ?>"><?php _e('Visa Everywhere City:', 'stag'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('visacity'); ?>"
                    name="<?php echo $this->get_field_name('visacity'); ?>">
                <?php
                foreach ($visacity_options as $key => $value) {
                    # code...
                    if (@$instance['visacity'] == $value->term_id)
                        $selected = 'selected="selected"';
                    else
                        $selected = '';
                    ?>
                    <option value="<?= $value->term_id; ?>" <?= $selected; ?>><?= $value->name; ?></option>
                    <?php
                }
                ?>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('filter'); ?>"><?php _e('Date filtering:', 'stag'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('filter'); ?>"
                    name="<?php echo $this->get_field_name('filter'); ?>">
                <?php
                foreach ($date_options as $key => $value) {
                    # code...
                    if (@$instance['filter'] == $key)
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
                for="<?php echo $this->get_field_id('more_link'); ?>"><?php _e('Show more items link:', 'stag'); ?></label>
            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('more_link'); ?>"
                   name="<?php echo $this->get_field_name('more_link'); ?>" <?php checked(@$instance['more_link'], 'on'); ?> />
        </p>
        <p>
            <label
                for="<?php echo $this->get_field_id('number_posts'); ?>"><?php _e('Number of posts:', 'stag'); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('number_posts'); ?>"
                   name="<?php echo $this->get_field_name('number_posts'); ?>"
                   value="<?php echo @$instance['number_posts']; ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('id'); ?>"><?php _e('Section ID:', 'stag'); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('id'); ?>"
                   name="<?php echo $this->get_field_name('id'); ?>" value="<?php echo @$instance['id']; ?>"/>
            <span class="description">Section ID is required if you want to use this section as a navigation. e.g. about, and add a custom link under Menus with link #about.</span>
        </p>

    <?php
    }
}

?>
