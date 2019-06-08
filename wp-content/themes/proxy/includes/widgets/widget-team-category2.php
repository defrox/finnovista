<?php
add_action('widgets_init', create_function('', 'return register_widget("stag_section_team_category2");'));

class stag_section_team_category2 extends WP_Widget
{
    function stag_section_team_category2()
    {
        $widget_ops = array('classname' => 'section-block', 'description' => __('Displays your team members by category and their extended info.', 'stag'));
        $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'stag_section_team_category2');
        $this->WP_Widget('stag_section_team_category2', __('Homepage: Team by Category Section V2', 'stag'), $widget_ops, $control_ops);
    }

    function widget($args, $instance)
    {
        extract($args);

        // VARS FROM WIDGET SETTINGS
        $title = apply_filters('widget_title', $instance['title']);
        $subtitle = __($instance['subtitle'], 'stag');
        $category = $instance['category'];
        $area = $instance['area'];
        $fscity = $instance['fscity'];
        $pdcity = $instance['pdcity'];
        $visacity = $instance['visacity'];
        $more_link = $instance['more_link'] ? 'true' : 'false';
        $number_posts = $instance['number_posts'] > 0 || $instance['number_posts'] != '' ? $instance['number_posts'] : 15;
        $id = $instance['id'];
        $translate = $instance['translate'];
        $view_all = __('View all %s', 'stag');
        $ordering = $instance['ordering'];

        echo $before_widget;

        if ( $translate != 'on'){
            global $sitepress;
            //changes to the default language
            $sitepress->switch_lang( $sitepress->get_default_language() );
        }

        ?>

        <!-- BEGIN #team-category2.section-block -->
        <section id="<?php echo stag_to_slug($id); ?>" class="section-block team-widget team-category2-widget version2">
            <div class="inner-section">
                <!-- members  -->
                <?php
                echo '<h2 class="main-title">' . $title . '</h2>';
                if ($subtitle != '') echo '<p class="sub-title">' . $subtitle . '</p>';

                $cat_args = array(
                    'taxonomy' => '_stag_team_category',
                    'terms' => $category,
                    'field' => 'term_id',
                );
                $area_args = array(
                    'taxonomy' => '_stag_team_area_type',
                    'terms' => $area,
                    'field' => 'term_id',
                );
                $fscity_args = array(
                    'key' => '_stag_team_fscity',
                    'value' => preg_replace('/-/', ' ', $fscity),
                    'compare' => 'LIKE'
                );
                $pdcity_args = array(
                    'key' => '_stag_team_pitch_days',
                    'value' => preg_replace('/-/', ' ', $pdcity),
                    'compare' => 'LIKE'
                );
                $visacity_args = array(
                    'key' => '_stag_team_visacity',
                    'value' => preg_replace('/-/', ' ', $visacity),
                    'compare' => 'LIKE'
                );

                if ($category == '') $cat_args = '';
                if ($area == '') $area_args = '';
                if ($fscity == '') $fscity_args = '';
                if ($pdcity == '') $pdcity_args = '';
                if ($visacity == '') $visacity_args = '';

                if ($ordering != '') {
                    $metakey_args = '_stag_team_order';
                    $metaquery1_args = array(
                        'relation' => 'AND',
                        array(
                            'key'     => '_stag_team_order',
                            'compare' => '>',
                            'value'   => 0
                        ),
                        array (
                            'relation' => 'AND',
                            $fscity_args,
                            $pdcity_args,
                            $visacity_args
                        )
                    );

                    $metaquery2_args = array(
                        'relation' => 'AND',
                        $fscity_args,
                        $pdcity_args,
                        $visacity_args,
                        array(
                            'relation' => 'OR',
                            array(
                                'key'     => '_stag_team_order',
                                'compare' => 'EXISTS',
                                'value'   => ''
                            ),
                            array(
                                'key'     => '_stag_team_order',
                                'compare' => 'NOT EXISTS',
                                'value'   => ''
                            ),
                        )
                    );

                    $args1 = array(
                        'post_type' => 'team',
                        'meta_query' => $metaquery1_args,
                        'tax_query' => array(
                            'relation' => 'AND',
                            $cat_args,
                            $area_args,
                        ),
                        'meta_key' => $metakey_args,
                        'posts_per_page' => $number_posts,
                        'orderby' => 'meta_value_num',
                        'order' => $ordering
                    );

                    $args2 = array(
                        'post_type' => 'team',
                        'meta_query' => $metaquery2_args,
                        'tax_query' => array(
                            'relation' => 'AND',
                            $cat_args,
                            $area_args,
                        ),
                        'posts_per_page' => $number_posts,
                        'orderby' => 'title',
                        'order' => 'ASC'
                    );

                    if (!$number_posts) $args1 = $args2 = false;
                    $the_query1 = new WP_Query($args1);
                    $the_query2 = new WP_Query($args2);
                    $the_query = new WP_Query();
                    $the_query->posts = array_merge( $the_query1->posts, $the_query2->posts );
                    $the_query->post_count = $the_query1->post_count + $the_query2->post_count;
                } else {
                    $metaquery_args = array(
                        'relation' => 'AND',
                        $fscity_args,
                        $pdcity_args,
                        $visacity_args
                    );
                    $qargs = array(
                        'post_type' => 'team',
                        'meta_query' => $metaquery_args,
                        'tax_query' => array(
                            'relation' => 'AND',
                            $cat_args,
                            $area_args,
                        ),
                        'posts_per_page' => $number_posts,
                        'orderby' => 'post_date',
                        'order' => 'DESC'
                    );

                    if (!$number_posts) $qargs = false;
                    $the_query = new WP_Query($qargs);
                }
                ?>
                <div class="team-members">
                    <?php
                    if ($the_query->have_posts()) {
                        $posts_counter = $i= 0;
                        while ($the_query->have_posts()): $the_query->the_post();
                            $posts_counter ++;
                            if ($posts_counter > $number_posts) break;
                            ?>
                            <div id="<?php print get_the_ID() ?>"><p></p></div>
                            <section class="member-section <?php echo $i % 2 == 0 ? "even" : "odd" ?>">
                                <?php
                                $area_tags = wp_get_post_terms(get_the_ID(), '_stag_team_area_type');
                                $area_tag = $area_tags[0]->name;
                                if ($area_tag == 'Ninguno' || $area_tag == '' || is_null($area_tag)) $area_tag = '&nbsp;';
                                ?>
                                <div class="member">
                                    <?php if ($area_tag != ''): ?>
                                        <div
                                            class="area-tag <?php echo seoUrl($area_tag); ?>"><?php echo $area_tag; ?></div>
                                    <?php endif ?>
                                    <?php if (has_post_thumbnail()): ?>
                                        <div class="member-pic">
                                            <?php the_post_thumbnail('team-avatar'); ?>

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
                                                href="/listado-colaboradores/?<?php print ($category != '' ? '&cat=' . urlencode($category) : '') . ($area != '' ? '&area=' . urlencode($area) : '') . ($fscity != '' ? '&fscity=' . urlencode($fscity) : '') . ($pdcity != '' ? '&pdcity=' . urlencode($pdcity) : '') . ($visacity != '' ? '&visacity=' . urlencode($visacity) : '') . ($_GET['lang'] != '' && $translate == 'on' ? '&lang=' . $_GET['lang'] : '') . '#' . get_the_ID(); ?>"><?php the_title(); ?></a>
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
                    $no_posts = $the_query->post_count;
                    wp_reset_postdata();
                    ?>
                </div>
                <!-- end members -->
            </div>
            <?php
            if ($no_posts >= intval($number_posts) && $more_link == 'true'): ?>
                <div class="clearfix"></div>
                <div <?php post_class($d_c); ?> >
                    <a class="bottom-link"
                       href="/team/?<?php print ($category != '' ? '&cat=' . urlencode($category) : '') . ($area != '' ? '&area=' . urlencode($area) : '') . ($fscity != '' ? '&fscity=' . urlencode($fscity) : '') . ($pdcity != '' ? '&pdcity=' . urlencode($pdcity) : '') . ($_GET['lang'] != '' && $translate == 'on' ? '&lang=' . $_GET['lang'] : ''); ?>"><?php echo sprintf($view_all, $title); ?> &raquo;</a>
                </div>
            <?php
            endif;
            ?>
            <!-- END #team-category2.section-block -->
        </section>
        <script>
            jQuery(document).ready(function () {
                jQuery('.member-description').equalHeights();
            });
        </script>

        <?php
        if ( $translate != 'on'){
            //changes to the current language
            $sitepress->switch_lang( ICL_LANGUAGE_CODE );
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
        $instance['area'] = strip_tags($new_instance['area']);
        $instance['fscity'] = strip_tags($new_instance['fscity']);
        $instance['pdcity'] = strip_tags($new_instance['pdcity']);
        $instance['visacity'] = strip_tags($new_instance['visacity']);
        $instance['more_link'] = strip_tags($new_instance['more_link']);
        $instance['number_posts'] = strip_tags($new_instance['number_posts']);
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

        $options_start = new stdClass();
        $options_start->name = __('All', 'stag');
        $options_start->slug = '';

        $category_taxonomies = array('_stag_team_category');
        $category_options = get_terms($category_taxonomies, 'hide_empty=0');
        $category_options = array_merge(array('' => $options_start), $category_options);

        $area_taxonomies = array('_stag_team_area_type');
        $area_options = get_terms($area_taxonomies, 'hide_empty=0');
        $area_options = array_merge(array('' => $options_start), $area_options);

        $city_taxonomies = array('event_city');
        $city_options = get_terms($city_taxonomies, 'hide_empty=0');
        $city_options = array_merge(array('' => $options_start), $city_options);

        $pdcity_taxonomies = array('event_pdcity');
        $pdcity_options = get_terms($pdcity_taxonomies, 'hide_empty=0');
        $pdcity_options = array_merge(array('' => $options_start), $pdcity_options);

        $visacity_taxonomies = array('event_visacity');
        $visacity_options = get_terms($visacity_taxonomies, 'hide_empty=0');
        $visacity_options = array_merge(array('' => $options_start), $visacity_options);
        $ordering_options = array('' => __('Default Ordering', 'stag'),
            'ASC' => __('Ascending', 'stag'),
            'DESC' => __('Descending', 'stag'),
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
                foreach ($category_options as $key => $value) {
                    # code...
                    if (@$instance['category'] == $value->term_id)
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
            <label for="<?php echo $this->get_field_id('area'); ?>"><?php _e('Area Type:', 'stag'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('area'); ?>"
                    name="<?php echo $this->get_field_name('area'); ?>">
                <?php
                foreach ($area_options as $key => $value) {
                    # code...
                    if (@$instance['area'] == $value->term_id)
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
                    if (@$instance['fscity'] == $value->name)
                        $selected = 'selected="selected"';
                    else
                        $selected = '';
                    ?>
                    <option value="<?= $value->slug; ?>" <?= $selected; ?>><?= $value->name; ?></option>
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
                    if (@$instance['pdcity'] == $value->name)
                        $selected = 'selected="selected"';
                    else
                        $selected = '';
                    ?>
                    <option value="<?= $value->slug; ?>" <?= $selected; ?>><?= $value->name; ?></option>
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
                    if (@$instance['visacity'] == $value->name)
                        $selected = 'selected="selected"';
                    else
                        $selected = '';
                    ?>
                    <option value="<?= $value->slug; ?>" <?= $selected; ?>><?= $value->name; ?></option>
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
                for="<?php echo $this->get_field_id('more_link'); ?>"><?php _e('Show more items link:', 'stag'); ?></label>
            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('more_link'); ?>"
                   name="<?php echo $this->get_field_name('more_link'); ?>" <?php checked(@$instance['more_link'], 'on'); ?> />
            <label for="<?php echo $this->get_field_id('translate'); ?>"><?php _e('Translate:', 'stag'); ?></label>
            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('translate'); ?>"
                   name="<?php echo $this->get_field_name('translate'); ?>" <?php checked(@$instance['translate'], 'on'); ?> />
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