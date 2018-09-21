<?php
add_action('widgets_init', create_function('', 'return register_widget("stag_section_logo_category");'));

class stag_section_logo_category extends WP_Widget
{
    function stag_section_logo_category()
    {
        $widget_ops = array('classname' => 'section-block', 'description' => __('Displays your logos members by category.', 'stag'));
        $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'stag_section_logo_category');
        $this->WP_Widget('stag_section_logo_category', __('Homepage: Logo by Category Section', 'stag'), $widget_ops, $control_ops);
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
        $columns = $instance['columns'];
        $more_link = $instance['more_link'] == 'on' ? true : false;
        $subtext = __($instance['subtext'], 'stag');
        $describe = $instance['describe'] == 'on' ? true : false;
        $number_posts = $instance['number_posts'] > 0 || $instance['number_posts'] != '' ? $instance['number_posts'] : 15;
        $id = $instance['id'];
        $translate = $instance['translate'];
        $view_all = __('View all %s', 'stag');

        echo $before_widget;
        if ( $translate != 'on'){
            global $sitepress;
            //changes to the default language
            $sitepress->switch_lang( $sitepress->get_default_language() );
        }
        $title = apply_filters('widget_title', $instance['title']);

        ?>
        <!-- BEGIN #logo.section-block -->
        <!-- widget logo category  -->
        <section id="<?php echo stag_to_slug($id); ?>" class="section-block logo-widget">
            <div class="inner-section">
                <!-- logos  -->
                <?php
                echo '<h2 class="main-title">' . $title . '</h2>';
                if ($subtitle != '') echo '<p class="sub-title">' . $subtitle . '</p>';

                $cat_args = array(
                    'taxonomy' => 'logo_type',
                    'terms' => $category,
                    'field' => 'term_id',
                );
                $area_args = array(
                    'taxonomy' => '_stag_logo_area_type',
                    'terms' => $area,
                    'field' => 'term_id',
                );
                $fscity_args = array(
                    'key' => '_stag_logo_fscity',
                    'value' => preg_replace('/-/', ' ', $fscity),
                    'compare' => 'LIKE'
                );
                $pdcity_args = array(
                    'key' => '_stag_logo_pitch_days',
                    'value' => preg_replace('/-/', ' ', $pdcity),
                    'compare' => 'LIKE'
                );
                $visacity_args = array(
                    'key' => '_stag_logo_pitch_days',
                    'value' => preg_replace('/-/', ' ', $visacity),
                    'compare' => 'LIKE'
                );

                if ($category == '') $cat_args = '';
                if ($area == '') $area_args = '';
                if ($fscity == '') $fscity_args = '';
                if ($pdcity == '') $pdcity_args = '';
                if ($visacity == '') $visacity_args = '';

                $args = array(
                    'post_type' => 'logos',
                    'meta_query' => array(
                        'relation' => 'AND',
                        $fscity_args,
                        $pdcity_args,
                        $visacity_args,
                    ),
                    'tax_query' => array(
                        'relation' => 'AND',
                        $cat_args,
                        $area_args,
                    ),
                    'posts_per_page' => $number_posts,
                    'orderby' => 'title',
                    'order' => 'ASC'
                );
                echo '<!--';
                print_r($args, false);
                echo '-->';

                $the_query = new WP_Query($args);
                ?>
                <div class="logos_inner cols<?= $columns; ?> clearfix">
                    <?php
                    if ($the_query->have_posts()) {
                        while ($the_query->have_posts()): $the_query->the_post();
                            ?>
                            <div class="logo">
                                <?php if (get_post_meta(get_the_ID(), '_stag_logo_image', true) != ''): ?>
                                    <a href="<?php echo get_post_meta(get_the_ID(), '_stag_logo_url', true) == '#' || get_post_meta(get_the_ID(), '_stag_logo_url', true) == '' ? 'javascript:return false;' : get_post_meta(get_the_ID(), '_stag_logo_url', true); ?>"
                                       class="mini-logo" title="<?php the_title(); ?>" target="<?php echo get_post_meta(get_the_ID(), '_stag_logo_url', true) == '#' || get_post_meta(get_the_ID(), '_stag_logo_url', true) == '' ? '' : '_blank'; ?>">
                                        <?php get_meta_image(get_post_meta(get_the_ID(), '_stag_logo_image', true), 'logo', get_post_meta(get_the_ID(), '_stag_logo_subtitle', true), 'logo', '', true);?>
                                    </a>
                                    <?php //echo get_post_meta(get_the_ID(), '_stag_logo_category', true); ?>
                                <?php endif; ?>
                                <?php if ($describe): ?>
                                    <div class="logos_description clearfix"><?php echo get_post_meta(get_the_ID(), '_stag_logo_description', true); ?>
                                        <?php if (get_post_meta(get_the_ID(), '_stag_logo_origin', true) != ''): ?>
                                            <div class="origin_meta"><?php echo get_post_meta(get_the_ID(), '_stag_logo_origin', true); ?></div>
                                        <?php endif; ?>            
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php
                        endwhile;
                    }
                    wp_reset_postdata();
                    ?>

                </div>
                <!-- end logos -->
                <div class="subtext clearfix">
                    <?php echo $subtext; ?>
                    <?php if ($more_link): ?>
                    <?php endif; ?>
                </div>
            </div>
            <!-- END #logo.section-block -->
        </section>
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
        $instance['subtitle'] = $new_instance['subtitle'];
        $instance['category'] = strip_tags($new_instance['category']);
        $instance['area'] = strip_tags($new_instance['area']);
        $instance['fscity'] = strip_tags($new_instance['fscity']);
        $instance['pdcity'] = strip_tags($new_instance['pdcity']);
        $instance['columns'] = strip_tags($new_instance['columns']);
        $instance['more_link'] = strip_tags($new_instance['more_link']);
        $instance['subtext'] = $new_instance['subtext'];
        $instance['describe'] = $new_instance['describe'];
        $instance['number_posts'] = strip_tags($new_instance['number_posts']);
        $instance['id'] = strip_tags($new_instance['id']);
        $instance['translate'] = strip_tags($new_instance['translate']);

        return $instance;
    }

    function form($instance)
    {
        $defaults = array(
            /* Deafult options goes here */
            'page' => 0
        );

        $instance = wp_parse_args((array)$instance, $defaults);

        /* HERE GOES THE FORM */

        $options_start = new stdClass();
        $options_start->name = __('All', 'stag');
        $options_start->slug = '';

        $category_taxonomies = array('logo_type');
        $category_options = get_terms($category_taxonomies, 'hide_empty=0');
        $category_options = array_merge(array('' => $options_start), $category_options);

        /*
            $area_taxonomies = array( '_stag_logo_area_type' );
            $area_options = get_terms($area_taxonomies, 'hide_empty=0');
            $area_options = array_merge(array('' => $options_start), $area_options);
        */

        $city_taxonomies = array('event_city');
        $city_options = get_terms($city_taxonomies, 'hide_empty=0');
        $city_options = array_merge(array('' => $options_start), $city_options);

        $pdcity_taxonomies = array('event_pdcity');
        $pdcity_options = get_terms($pdcity_taxonomies, 'hide_empty=0');
        $pdcity_options = array_merge(array('' => $options_start), $pdcity_options);

        $visacity_taxonomies = array('event_visacity');
        $visacity_options = get_terms($visacity_taxonomies, 'hide_empty=0');
        $visacity_options = array_merge(array('' => $options_start), $visacity_options);
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
            <label for="<?php echo $this->get_field_id('subtext'); ?>"><?php _e('After Text:', 'stag'); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('subtext'); ?>"
                      name="<?php echo $this->get_field_name('subtext'); ?>"><?php echo @$instance['subtext']; ?></textarea>
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
        <?php /* ;?><p>
      <label for="<?php echo $this->get_field_id('area'); ?>"><?php _e('Area Type:', 'stag'); ?></label>
      <select class="widefat" id="<?php echo $this->get_field_id( 'area' ); ?>" name="<?php echo $this->get_field_name( 'area' ); ?>">
        <?php
        foreach ($area_options as $key => $value) {
          # code...
          if (@$instance['area'] == $value->term_id)
            $selected = 'selected="selected"';
          else
            $selected = '';
          ?>
          <option value="<?= $value->term_id;?>" <?= $selected;?>><?= $value->name;?></option>
          <?php
        }
        ?>
      </select>
    </p><?php */;?>
        <p>
            <label for="<?php echo $this->get_field_id('fscity'); ?>"><?php _e('FS City:', 'stag'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('fscity'); ?>"
                    name="<?php echo $this->get_field_name('fscity'); ?>">
                <?php
                foreach ($city_options as $key => $value) {
                    # code...
                    if (@$instance['fscity'] == $value->slug)
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
                    if (@$instance['pdcity'] == $value->slug)
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
        <p>
            <label for="<?php echo $this->get_field_id('visacity'); ?>"><?php _e('Visa Everywhere City:', 'stag'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('visacity'); ?>"
                    name="<?php echo $this->get_field_name('visacity'); ?>">
                <?php
                foreach ($visacity_options as $key => $value) {
                    # code...
                    if (@$instance['visacity'] == $value->slug)
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
        <label for="<?php echo $this->get_field_id('columns'); ?>"><?php _e('Columns:', 'stag'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('columns'); ?>"
                    name="<?php echo $this->get_field_name('columns'); ?>">
                <?php
                for ($i = 1; $i < 6; $i++) {
                    # code...
                    if (@$instance['columns'] == $i)
                        $selected = 'selected="selected"';
                    else
                        $selected = '';
                    ?>
                    <option value="<?= $i; ?>" <?= $selected; ?>><?= $i; ?></option>
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
                for="<?php echo $this->get_field_id('describe'); ?>"><?php _e('Show descriptions:', 'stag'); ?></label>
            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('describe'); ?>"
                   name="<?php echo $this->get_field_name('describe'); ?>" <?php checked(@$instance['describe'], 'on'); ?> />
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