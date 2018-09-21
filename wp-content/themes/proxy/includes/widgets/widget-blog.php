<?php
add_action('widgets_init', create_function('', 'return register_widget("stag_section_blog");'));

class stag_section_blog extends WP_Widget
{
    function stag_section_blog()
    {
        $widget_ops = array('classname' => 'section-block', 'description' => __('Displays your recent blog post.', 'stag'));
        $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'stag_section_blog');
        $this->WP_Widget('stag_section_blog', __('Homepage: Blog Section', 'stag'), $widget_ops, $control_ops);
    }

    function widget($args, $instance)
    {
        extract($args);

        // VARS FROM WIDGET SETTINGS
        $title = apply_filters('widget_title', $instance['title']);
        $subtitle = $instance['subtitle'];
        $translate = $instance['translate'];
        $view_all = __('View all %s', 'stag');

        echo $before_widget;

        if ( $translate == 'on'){
            global $sitepress;
            //changes to the default language
            $sitepress->switch_lang( $sitepress->get_default_language() );
        }
        $title = apply_filters('widget_title', $instance['title']);

        ?>

        <!-- BEGIN #blog.section-block -->
        <section id="blog" class="section-block">
            <div class="inner-section">
                <?php
                if ($subtitle != '') echo '<p class="sub-title">' . __($subtitle, 'stag') . '</p>';
                echo $before_title . '<a href="/blog/#blog">' . $title . '</a>' . $after_title;
                $s = get_option('sticky_posts');
                $d_c = '';
                ?>
                <div class="grids">
                    <div class="grid-12 featured-post">
                        <?php

                        if (count($s) != 0) {
                            $d_c = 'sticky';
                            $posts = query_posts(array(
                                'p' => array_pop($s),
                                'posts_per_page' => 5,
                                'orderby' => 'date'
                            ));
                        } else {
                            $posts = query_posts(array(
                                'posts_per_page' => 5,
                                'orderby' => 'date'
                            ));
                        }
                        if (have_posts()) {
                            $postCount = 0;
                            while (have_posts()): the_post();
                                $postCount++;
                                ?>
                                <div <?php post_class($d_c); ?>>
                                    <p class="pubdate"><?php the_time('F d Y'); ?> | <?php the_author_link(); ?></p>

                                    <h3><a data-through="no-gateway" data-postid="<?php the_ID(); ?>"
                                           href="<?php the_permalink(); ?>"
                                           title="<?php the_title(); ?>"><?php dfx_the_title(); ?></a></h3>

                                    <div class="entry-content">
                                        <div class="entry-content-left">
                                            <?php if (has_post_thumbnail()): ?>
                                                <a data-through="no-gateway" data-postid="<?php the_ID(); ?>"
                                                   href="<?php the_permalink(); ?>">
                                                    <?php the_post_thumbnail(); ?>
                                                </a>
                                            <?php endif; ?>
                                            <a class="comments_number_disqus"
                                               href="<?php the_permalink(); ?>#disqus_thread"></a>
                                        </div>
                                        <?php dfx_the_excerpt2(); ?>

                                    </div>
                                </div>
                                <?php if ($postCount != sizeof($posts)): ?>
                                    <!-- NO LAST POST IN LOOP -->
                                    <div class="clear"></div>
                                    <hr/>
                                <?php endif; ?>
                            <?php
                            endwhile;
                        }
                        wp_reset_postdata();
                        ?>
                    </div>
                    <?php $no_posts = wp_count_posts();
                    if ($no_posts->publish > 5): ?>
                        <div <?php post_class($d_c); ?>>
                            <a href="<?php echo site_url(); ?>/blog">&laquo; <?php echo __('Older Posts', 'stag'); ?></a>
                        </div>
                    <?php
                    endif; ?>
                    <div class="grid-6 all-posts" style="display: none;">
                        <div id="blog-post-slider" class="flexslider">
                            <ul class="slides">
                                <?php
                                $start = 4;
                                $finish = 1;
                                query_posts(array(
                                    'offset' => 1,
                                    'posts_per_page' => 1000,
                                ));
                                if (have_posts()): while (have_posts()): the_post();
                                    ?>

                                    <?php if (is_multiple($start, 4)): ?>
                                        <li>
                                    <?php endif; ?>
                                    <div class="row">
                                        <p class="pubdate"><?php the_time('F d Y'); ?></p>

                                        <h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"
                                               data-through="no-gateway"
                                               data-postid="<?php the_ID(); ?>"><?php the_title(); ?></a></h3>
                                    </div>
                                    <?php if (is_multiple($finish, 4)): ?>
                                        </li>
                                    <?php endif; ?>

                                    <?php
                                    $start++;
                                    $finish++;
                                endwhile;
                                endif;
                                ?>
                            </ul>
                        </div>
                    </div>


                </div>
                <!-- END .inner-section -->
            </div>

            <!-- END #blog.section-block -->
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
        $instance['subtitle'] = strip_tags($new_instance['subtitle']);
        $instance['translate'] = strip_tags($new_instance['translate']);

        return $instance;
    }

    function form($instance)
    {
        $defaults = array(/* Deafult options goes here */
        );

        $instance = wp_parse_args((array)$instance, $defaults);

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
            <label for="<?php echo $this->get_field_id('translate'); ?>"><?php _e('Translate:', 'stag'); ?></label>
            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('translate'); ?>"
                   name="<?php echo $this->get_field_name('translate'); ?>" <?php checked(@$instance['translate'], 'on'); ?> />
        </p>

        <script type="text/javascript">
            /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
            var disqus_shortname = 'finnovar'; // required: replace example with your forum shortname

            /* * * DON'T EDIT BELOW THIS LINE * * */
            (function () {
                var s = document.createElement('script');
                s.async = true;
                s.type = 'text/javascript';
                s.src = '//' + disqus_shortname + '.disqus.com/count.js';
                (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
            }());

        </script>

    <?php
    }
}

?>
