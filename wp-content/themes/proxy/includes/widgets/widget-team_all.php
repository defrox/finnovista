<?php
add_action('widgets_init', create_function('', 'return register_widget("stag_section_team");'));

class stag_section_team extends WP_Widget
{
    function stag_section_team()
    {
        $widget_ops = array('classname' => 'section-block', 'description' => __('Displays your team members and their info.', 'stag'));
        $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'stag_section_team');
        $this->WP_Widget('stag_section_team', __('Homepage: Team Section', 'stag'), $widget_ops, $control_ops);
    }

    function widget($args, $instance)
    {
        extract($args);

        // VARS FROM WIDGET SETTINGS
        $title = apply_filters('widget_title', $instance['title']);
        $subtitle = $instance['subtitle'];
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
        <div class="inner-section"
        <div class="entry-content">
            <h1>¿Quiénes somos?</h1>
            <div style="clear:both; margin-top: 40px;">
                <p><img src="/wp-content/uploads/2013/04/innpulsa.jpg" style="float:left; margin:10px">iNNpulsa Colombia es la unidad del Gobierno Nacional creada para promover la innovación
                    empresarial y el emprendimiento dinámico como motores para la competitividad y el desarrollo regional.</p>
            </div>
            <div style="clear:both; margin-top: 70px;">
                <img src="/wp-content/uploads/2013/04/logoCoomeva.gif" style="float:left; margin:10px">XXXX Coomeva
            </div>
            <div style="clear:both; margin-top: 70px;">
                <img src="/wp-content/uploads/2013/04/parque_E.png" style="float:left; margin:10px">El Parque del Emprendimiento es una iniciativa de la Alcaldía de Medellín y la Universidad de
                Antioquia que busca fortalecer la cultura del emprendimiento y acompañar la creación de empresas a partir de las oportunidades de negocio o de los resultados de investigaciones y
                actividades académicas identificadas por los emprendedores.
            </div>
            <div style="clear:both; margin-top: 70px;">
                <img src="/wp-content/uploads/2013/04/opinno.png" style="float:left; margin:10px">Opinno es una red global de centros de innovación que tiene como principal objetivo potenciar la
                innovación y la detección de nuevos talentos en Latinoamérica y Europa para ayudar a generar nuevas empresas de alta tecnología. Opinno construye y cultiva el ecosistema emprendedor en
                todo el mundo a través de múltiples iniciativas como conferencias de tecnología, competiciones de emprendedores e innovadoras y viajes de negocios entre muchas otras.
            </div>
        </div>
        </div>

        <!-- BEGIN #team.section-block -->
        <section id="team" class="section-block">

            <div class="inner-section">
                <!-- equipo  -->
                <?php
                if ($subtitle != '') echo '<p class="sub-title">' . __($subtitle, 'stag') . '</p>';
                echo $before_title . __('Team', 'stag') . $after_title;

                $args = array(
                    'post_type' => 'team',
                    'meta_value' => 'equipo',
                    // 'posts_per_page' => 4,
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
                        while ($the_query->have_posts()): $the_query->the_post();
                            ?>
                            <div class="member">
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
                                    <p class="member-title"><?php the_title(); ?></p>
                                    <?php if (get_post_meta(get_the_ID(), '_stag_team_position', true) != '') echo '<p class="member-position">' . get_post_meta(get_the_ID(), '_stag_team_position', true) . '</p>'; ?>
                                </div>
                            </div>
                        <?php
                        endwhile;
                    }
                    wp_reset_postdata();
                    ?>
                </div>
                <!-- end equipo -->
                <!-- mentor  -->
                <?php
                if ($subtitle != '') echo '<p class="sub-title">' . $subtitle . '</p>';
                echo $before_title . 'Mentores' . $after_title;

                $args = array(
                    'post_type' => 'team',
                    // 'posts_per_page' => 4,
                );
                //$the_query = new WP_Query($args);
                $the_query = new WP_Query(array('post_type' => 'team', 'meta_value' => 'mentor'));
                ?>

                <div class="team-members">
                    <?php
                    if ($the_query->have_posts()) {
                        while ($the_query->have_posts()): $the_query->the_post();
                            ?>
                            <div class="member">
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
                                    <p class="member-title"><?php the_title(); ?></p>
                                    <?php if (get_post_meta(get_the_ID(), '_stag_team_position', true) != '') echo '<p class="member-position">' . get_post_meta(get_the_ID(), '_stag_team_position', true) . '</p>'; ?>
                                </div>
                            </div>
                        <?php
                        endwhile;
                    }
                    wp_reset_postdata();
                    ?>
                </div>
                <!-- end mentor -->
                <!-- startups  -->
                <?php
                if ($subtitle != '') echo '<p class="sub-title">' . $subtitle . '</p>';
                echo $before_title . 'Startups' . $after_title;

                $args = array(
                    'post_type' => 'team',
                    // 'posts_per_page' => 4,
                );
                //$the_query = new WP_Query($args);
                $the_query = new WP_Query(array('post_type' => 'team', 'meta_value' => 'startup'));
                ?>

                <div class="team-members">
                    <?php
                    if ($the_query->have_posts()) {
                        while ($the_query->have_posts()): $the_query->the_post();
                            ?>
                            <div class="member">
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
                                    <p class="member-title"><?php the_title(); ?></p>
                                    <?php if (get_post_meta(get_the_ID(), '_stag_team_position', true) != '') echo '<p class="member-position">' . get_post_meta(get_the_ID(), '_stag_team_position', true) . '</p>'; ?>
                                </div>
                            </div>
                        <?php
                        endwhile;
                    }
                    wp_reset_postdata();
                    ?>
                </div>
                <!-- end startups -->


            </div>

            <!-- END #team.section-block -->
        </section>

        <?php
        echo $after_widget;
        if ($translate != 'on') {
            //changes to the current language
            $sitepress->switch_lang(ICL_LANGUAGE_CODE);
        }
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;

        // STRIP TAGS TO REMOVE HTML
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['subtitle'] = strip_tags($new_instance['subtitle']);
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
            <label for="<?php echo $this->get_field_id('translate'); ?>"><?php _e('Translate:', 'stag'); ?></label>
            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('translate'); ?>"
                   name="<?php echo $this->get_field_name('translate'); ?>" <?php checked(@$instance['translate'], 'on'); ?> />
        </p>

        <?php
    }
}

?>
