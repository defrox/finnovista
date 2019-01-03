<?php
add_action('widgets_init', create_function('', 'return register_widget("stag_section_bootstrap_agenda");'));

class stag_section_bootstrap_agenda extends WP_Widget
{
    function stag_section_bootstrap_agenda()
    {
        $widget_ops = array('classname' => 'section-block', 'description' => __('Displays the agenda for the event.', 'stag'));
        $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'stag_section_bootstrap_agenda');
        $this->WP_Widget('stag_section_bootstrap_agenda', __('Homepage: Bootstrap Agenda', 'stag'), $widget_ops, $control_ops);
    }

    function widget($args, $instance)
    {
        extract($args);

        // VARS FROM WIDGET SETTINGS
        $title = apply_filters('widget_title', $instance['title']);
        $subtitle = $instance['subtitle'];
//        $translate = $instance['translate'];
        if (function_exists('icl_object_id'))
            $event_id = icl_object_id($instance['event_id'], 'page', true, ICL_LANGUAGE_CODE);
        else
            $event_id = $instance['event_id'];
        $id = $instance['id'];

//        if ($translate == 'on') {
//            global $sitepress;
//            //changes to the default language
//            if ($sitepress) $sitepress->switch_lang($sitepress->get_default_language());
//        }

        $title = apply_filters('widget_title', $instance['title']);

        ?>

        <!-- BEGIN #bootstrap-agenda.section-block -->
        <section id="<?php echo stag_to_slug($id); ?>" class="section-block content-section bootstrap-agenda">
            <div class="inner-section">
                <?php
                echo '<h2 class="main-title">' . $title . '</h2>';
                if ($subtitle != '') echo '<p class="sub-title-no">' . $subtitle . '</p>';

                $event_args = array(
                    'key' => '_stag_linked_event_agenda',
                    'value' => $event_id,
                    'compare' => '='
                );

                if ($event_id == '') $event_args = '';

                $args2 = array(
                    'post_type' => 'event_agenda',
                    'meta_query' => array(
                        'relation' => 'AND',
                        $event_args,
                    ),
                    'posts_per_page' => -1,
                );

                $query2 = new WP_Query($args2);

                if ($query2->have_posts()) {
                    // The 2nd Loop
                    $agenda_items = array();
                    $agenda_terms = array();
                    $agenda_topics = array();
                    while ($query2->have_posts()) {
                        $query2->the_post();
                        $agenda_item = array();
                        $agenda_item['id'] = $query2->post->ID;
                        $agenda_item['title'] = get_the_title($query2->post->ID);
                        $agenda_item['content'] = get_the_content($query2->post->ID);
                        $agenda_item['category'] = get_the_terms($query2->post->ID, 'event_agenda_category');
                        $agenda_item['topic'] = get_the_terms($query2->post->ID, 'event_agenda_topic');
                        $agenda_item['date'] = get_post_meta($query2->post->ID, '_stag_event_agenda_date', true);
                        $agenda_item['start'] = get_post_meta($query2->post->ID, '_stag_event_agenda_start', true);
                        $agenda_item['end'] = get_post_meta($query2->post->ID, '_stag_event_agenda_end', true);
                        $agenda_item['speakers'] = get_post_meta($query2->post->ID, '_stag_event_agenda_speakers', true);
                        $agenda_item['avatar'] = get_post_meta($query2->post->ID, '_stag_event_agenda_avatar', true);
                        $agenda_item['event_id'] = get_post_meta($query2->post->ID, '_stag_linked_event', true);
                        $agenda_item['meta'] = get_post_meta($query2->post->ID);
                        $agenda_items[$agenda_item['date']][(int)preg_replace('/:/', '', $agenda_item['start'])] = $agenda_item;
                        if (is_array($agenda_item['category'])) {
                            foreach ($agenda_item['category'] as $term) {
                                if (!array_key_exists($term->term_id, $agenda_terms)) {
                                    $term_meta = get_term_meta($term->term_id);
                                    $agenda_terms[$term->term_id] = array('name' => $term->name,
                                        'id' => $term->term_id,
                                        'slug' => $term->slug,
                                        'icon' => $term_meta['category_icon'][0],
                                        'color' => $term_meta['category_color'][0]);
                                }
                            }
                        }
                        if (is_array($agenda_item['topic'])) {
                            foreach ($agenda_item['topic'] as $term) {
                                if (!array_key_exists($term->term_id, $agenda_topics)) {
                                    $term_meta = get_term_meta($term->term_id);
                                    $agenda_topics[$term->term_id] = array(
                                        'name'  => $term->name,
                                        'id'    => $term->term_id,
                                        'slug'  => $term->slug
                                    );
                                }
                            }
                        }
                    }
                    // Restore original Post Data
                    wp_reset_postdata();
                }
                ?>
                <div class="bootstrap-agenda">
                    <div class="entry-content clearfix">
                        <?php if (is_array($agenda_items) && count($agenda_items) > 0):
                            $day_col = 12;
                            if (count($agenda_items) > 1 && count($agenda_items) < 3)
                                $day_col = 6;
                            else if (count($agenda_items) >= 3)
                                $day_col = 4;
                            ksort($agenda_items, SORT_STRING | SORT_ASC);
                            ?>
                            <div class="container agenda-event">
                                <?php if (is_array($agenda_topics) && count($agenda_topics) > 0): ?>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <p><? _e('Topics','stag');?>:
                                                <button type="button" class="btn btn-default btn-xs btn-tag mb-2"><?= __('All'); ?></button>
                                                <?php foreach($agenda_topics as $topic_id => $topic): ?>
                                                    <button type="button" class="btn btn-info btn-xs btn-tag mb-2"><?= $topic['name']; ?></button>
                                                <?php endforeach; ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php endif;?>
                                <?php if (is_array($agenda_terms) && count($agenda_terms) > 0): ?>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <p><?= __('Filter by', 'stag'); ?>:
                                                <button type="button" class="btn btn-default btn-xs btn-tag mb-2"><?= __('All'); ?></button>
                                                <?php foreach ($agenda_terms as $term_id => $term):
                                                    $cat_color = "";
                                                    if ($term['name'] != '') {
                                                        $cat_color = 'style="background-color: ' . $term['color'] . ' !important; border-color: ' . $term['color'] . ' !important;"';
                                                    }
                                                    ?>
                                                    <button type="button" class="btn btn-info btn-xs btn-tag mb-2" <?= $cat_color; ?>><?= $term['name']; ?></button>
                                                <?php endforeach; ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="row">
                                    <?php foreach ($agenda_items as $day => $hour): ?>
                                        <div class="col-sm-<?= $day_col; ?>" id="accordion<?= $day; ?>">
                                            <div class="btn btn-primary btn-lg btn-block disabled mb-4" role="button" aria-disabled="true">
                                                <i class="far fa-calendar"></i> <?= date_i18n("j M Y", strtotime($day)); ?>
                                            </div>
                                            <?php ksort($hour);
                                            foreach ($hour as $hitem): ?>
                                                <div class="card card-default agenda-item mb-2" data-toggle="collapse" href="#collapse<?= $hitem['id']; ?>" id="agendaitem<?= $hitem['id']; ?>">
                                                    <?php if (is_array($hitem['category']) && count($hitem['category']) > 0): ?>
                                                        <div style="display: none;">
                                                            <span class="label label-primary tag hidden"><?= __('All'); ?></span>
                                                            <?php
                                                            $category = "";
                                                            foreach ($hitem['category'] as $catitem):
                                                                $category .= " <i class=\"fas fa-" . $agenda_terms[$catitem->term_id]['icon'] . "\"></i> " . $catitem->name;
                                                                ?>
                                                                <span class="label label-default tag"><?= $catitem->name; ?></span>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if (is_array($hitem['topic']) && count($hitem['topic']) > 0): ?>
                                                        <div style="display: none;">
                                                            <span class="label label-primary tag hidden"><?= __('All'); ?></span>
                                                            <?php
                                                            foreach($hitem['topic'] as $topic_item): ?>
                                                                <span class="label label-default tag"><?= $topic_item->name;?></span>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="card-header title">
                                                        <div class="d-flex mb-1"><span class="timer"><?= $hitem['start']; ?> - <?= $hitem['end']; ?></span> &nbsp; <span
                                                                    class="card-title"><?= $hitem['title']; ?></span></div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="d-flex"><span class="category"><?= $category; ?></span></div>
                                                        <?php if ($hitem['avatar'] != ''): ?>
                                                            <div class="d-flex pull-left mr-3"><span class="avatar"><img src="<?= $hitem['avatar']; ?>"/></span></div><?php endif; ?>
                                                        <div class="d-flex"><span class="speakers"><?= html_entity_decode($hitem['speakers']); ?></span></div>
                                                    </div>
                                                    <div id="collapse<?= $hitem['id']; ?>" class="collapse" data-parent="#accordion<?= $day; ?>">
                                                        <div class="card-body">
                                                            <?= $hitem['content']; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="container"><?= __('To be disclosed.'); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- END .inner-section -->
            </div>

            <!-- END #bootstrap-agenda.section-block -->
        </section>

        <?php
//        if ($translate != 'on') {
//            //changes to the current language
//            if ($sitepress) $sitepress->switch_lang(ICL_LANGUAGE_CODE);
//        }
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;

        // STRIP TAGS TO REMOVE HTML
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['subtitle'] = strip_tags($new_instance['subtitle']);
        $instance['event_id'] = strip_tags($new_instance['event_id']);
        $instance['id'] = strip_tags($new_instance['id']);
//        $instance['translate'] = strip_tags($new_instance['translate']);

        return $instance;
    }

    function form($instance)
    {
        $defaults = array(/* Deafult options goes here */
        );

        $instance = wp_parse_args((array)$instance, $defaults);

        $event_options = array();
        $args = array(
            'post_type' => 'event',
            'post_status' => 'publish',
            'orderby' => 'title',
            'posts_per_page' => -1,
            'order' => 'ASC'
        );
        $the_query = new WP_Query($args);
        if ($the_query->have_posts()) {
            while ($the_query->have_posts()): $the_query->the_post();
                $event_options[get_the_ID()] = get_the_title();
            endwhile;
        }

        /* HERE GOES THE FORM */
        ?>

        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'stag'); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo @$instance['title']; ?>"/>
            <span class="description">Leave blank to use default page title.</span>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('Sub Title:', 'stag'); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('subtitle'); ?>"
                   name="<?php echo $this->get_field_name('subtitle'); ?>"
                   value="<?php echo @$instance['subtitle']; ?>"/>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('event_id'); ?>"><?php _e('Event:', 'stag'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('event_id'); ?>" name="<?php echo $this->get_field_name('event_id'); ?>">
                <?php
                foreach ($event_options as $key => $value) {
                    # code...
                    if (@$instance['event_id'] == $key)
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
            <label for="<?php echo $this->get_field_id('id'); ?>"><?php _e('Section ID:', 'stag'); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('id'); ?>" name="<?php echo $this->get_field_name('id'); ?>" value="<?php echo @$instance['id']; ?>"/>
            <span class="description">Section ID is required if you want to use this section as a navigation. e.g. about, and add a custom link under Menus with link #about.</span>
        </p>

        <!--p>
            <label for="<?php echo $this->get_field_id('translate'); ?>"><?php _e('Translate:', 'stag'); ?></label>
            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('translate'); ?>"
                   name="<?php echo $this->get_field_name('translate'); ?>" <?php checked(@$instance['translate'], 'on'); ?> />
        </p-->

        <?php
    }
}

?>
