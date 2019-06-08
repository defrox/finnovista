<?php
add_action('widgets_init', create_function('', 'return register_widget("stag_section_blog_category");'));

class stag_section_blog_category extends WP_Widget
{
    function stag_section_blog_category()
    {
        $widget_ops = array('classname' => 'section-block', 'description' => __('Displays your recent blog post.', 'stag'));
        $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'stag_section_blog_category');
        $this->WP_Widget('stag_section_blog_category', __('Homepage: Blog Section Category', 'stag'), $widget_ops, $control_ops);
    }

    function widget($args, $instance)
    {
        extract($args);
        // VARS FROM WIDGET SETTINGS
        $title = apply_filters('widget_title', $instance['title']);
        $subtitle = $instance['subtitle'];
        $category = $instance['category'];
        $more_link = $instance['more_link'] ? 'true' : 'false';
        $id = $instance['id'];
        $number_posts = $instance['number_posts'];
        $translate = $instance['translate'];
        $alt_links = $instance['alt_links'];
        $sort_date = $instance['sort_date'];
        $view_all = __('View all %s', 'stag');

        echo $before_widget;
        if ( $translate != 'on'){
            global $sitepress;
            //changes to the default language
            $sitepress->switch_lang( $sitepress->get_default_language() );
        }
        ?>
        <!-- BEGIN #blog.section-block -->
        <section id="<?php echo stag_to_slug($id); ?>" class="videos section-block">
            <div class="inner-section">
                <?php
                if ($subtitle != '') echo '<p class="sub-title">' . __($subtitle, 'stag') . '</p>';
                echo $before_title . '<a href="' . get_category_link($category) . '">' . $title . '</a>' . $after_title;
                ?>
                <div class="grid-12">
                    <div class="video-item">
                        <?php
                        if ( $sort_date == 'on') {
                            $args = [
                                'post_type' => 'post',
                                'tax_query' => [
                                    'relation' => 'OR',
                                    [
                                        'taxonomy' => 'category',
                                        'field' => 'term_id',
                                        'terms' => $category,
                                        'include_children' => true
                                    ],
                                    [
                                        'taxonomy' => 'category',
                                        'field' => 'parent_id',
                                        'terms' => $category,
                                        'include_children' => true
                                    ]
                                ],
                                'meta_query' => array(
                                    'relation' => 'OR',
                                    array(
                                        'key' => '_stag_event_date',
                                        'compare' => 'EXISTS',
                                    ),
                                    array(
                                        'key' => '_stag_event_date',
                                        'compare' => 'NOT EXISTS',
                                    )
                                ),
                                'posts_per_page' => $number_posts,
                                'orderby' => '_stag_event_date',
                                'order' => 'ASC',
                            ];
                            $the_query = new WP_Query($args);
                            $posts = query_posts($args);
                        } else {
                            $posts = query_posts(array(
                                'posts_per_page' => $number_posts,
                                'orderby' => 'date',
                                'cat' => $category,
                            ));
                        }

                        if (have_posts()) {
                            $postCount = 0;
                            while (have_posts()): the_post();
                                $postCount++;
                                $terms = get_the_terms(get_the_ID(), 'category');
                                $color_categories = array(87,483,831,841,613,838,595,845,847,849,850,851,1240,1241);
                                $pd_tag = $pd_css = $pd_color = $pd_tag2 = $pd_css2 = $pd_color2 = $setted = $setted2 = false;
                                // Color categories
                                if (sizeof($terms) > 0 && is_array($terms)) {
                                    foreach ($terms as $term) {
                                        if (in_array($term->parent, $color_categories)) {
                                            $pd_tag = $term->name;
                                            $pd_css = $term->slug;
                                            $pd_color = $term->description;
                                            $setted = true;
                                        } elseif (in_array($term->parent, $color_categories) && !$setted) {
                                            $pd_tag = '&nbsp;';
                                            $pd_css = '';
                                            $pd_color = '';
                                        }
                                    }
                                };
                                $terms2 = get_the_terms(get_the_ID(), 'post_tag');
                                global $language_terms;
                                // Color language tag
                                if (is_array($terms2) && sizeof($terms2) > 0) {
                                    foreach ($terms2 as $term2) {
                                        if (in_array($term2->term_id, $language_terms) && !$setted2) {
                                            $pd_tag2 = $term2->name;
                                            $pd_css2 = $term2->slug;
                                            $pd_color2 = $term2->description;
                                            $setted2 = true;
                                        }
                                    }
                                }

                                ?>
                                <div class="item">
                                    <div id="<?php print get_the_ID() ?>"><p></p></div>
                                    <div class="entry-content pdentry">
                                        <?php if ($pd_tag2 != ''): ?>
                                            <span><div class="pd-tag pd-tag-1 <?php echo $pd_css2; ?>"
                                                       style="background-color: #<?php echo $pd_color2; ?>;"><?php echo $pd_tag2; ?></div></span>
                                        <?php endif ?>
                                        <?php if ($pd_tag != ''): ?>
                                            <span><div class="pd-tag pd-tag-2 <?php echo $pd_css; ?>"
                                                       style="background-color: #<?php echo $pd_color; ?>;"><?php echo $pd_tag; ?></div></span>
                                        <?php endif ?>
                                        <a href="<?php $alt_links != 'on' ? the_permalink() : dfx_the_permalink(); ?>"
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
                    <?php $no_posts = wp_count_posts();
                    if ($no_posts->publish > $number_posts && $more_link != 'true'): ?>
                        <div class="clearfix"></div>
                        <div <?php post_class($d_c); ?> >
                            <a class="bottom-link"
                               href="<?php echo get_category_link($category); ?>"><?php echo sprintf($view_all, $title); ?> &raquo;</a>
                        </div>
                    <?php
                    endif;/*?>
        <div class="grid-6 all-posts" style="display: none;">
          <div id="blog-post-slider" class="flexslider">
            <ul class="slides">
              <?php
              $start = 4;
              $finish = 1;
              query_posts(array(
                'offset' => 1,
                'posts_per_page' => 1000,
                'cat' => $category
              ));
              if(have_posts()): while(have_posts()): the_post();
              ?>
              <?php if(is_multiple($start, 4)): ?>
                <li>
              <?php endif; ?>
              <div class="row">
                <p class="pubdate"><?php the_time('F d Y'); ?></p>
                <h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" data-through="no-gateway" data-postid="<?php the_ID(); ?>"><?php the_title(); ?></a></h3>
              </div>
              <?php if(is_multiple($finish, 4)): ?>
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
        <?php */; ?>
                </div>
                <!-- END .inner-section -->
            </div>
            <!-- END #blog.section-block -->
            <div class="clearfix"></div>
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
        $instance['category'] = strip_tags($new_instance['category']);
        $instance['number_posts'] = strip_tags($new_instance['number_posts']);
        $instance['id'] = strip_tags($new_instance['id']);
        $instance['translate'] = strip_tags($new_instance['translate']);
        $instance['alt_links'] = strip_tags($new_instance['alt_links']);
        $instance['more_link'] = strip_tags($new_instance['more_link']);
        $instance['sort_date'] = strip_tags($new_instance['sort_date']);

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
            <label
                    for="<?php echo $this->get_field_id('more_link'); ?>"><?php _e('Hide view all link:', 'stag'); ?></label>
            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('more_link'); ?>"
                   name="<?php echo $this->get_field_name('more_link'); ?>" <?php checked(@$instance['more_link'], 'on'); ?> />
            <label for="<?php echo $this->get_field_id('translate'); ?>"><?php _e('Translate:', 'stag'); ?></label>
            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('translate'); ?>"
                   name="<?php echo $this->get_field_name('translate'); ?>" <?php checked(@$instance['translate'], 'on'); ?> />
            <label for="<?php echo $this->get_field_id('alt_links'); ?>"><?php _e('Use alternative links:', 'stag'); ?></label>
            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('alt_link'); ?>"
                   name="<?php echo $this->get_field_name('alt_links'); ?>" <?php checked(@$instance['alt_links'], 'on'); ?> />
            <label for="<?php echo $this->get_field_id('sort_date'); ?>"><?php _e('Sort by event date:', 'stag'); ?></label>
            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('sort_date'); ?>"
                   name="<?php echo $this->get_field_name('sort_date'); ?>" <?php checked(@$instance['sort_date'], 'on'); ?> />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Select Category:', 'stag'); ?></label>

            <select id="<?php echo $this->get_field_id('category'); ?>"
                    name="<?php echo $this->get_field_name('category'); ?>" class="widefat">
                <?php

                $args = array(
                    'order' => 'asc',
                    'orderby' => 'name',
                    'taxonomy' => 'category',
                    'hide_empty' => 0
                );
                $categories = get_categories($args);
                foreach ($categories as $category) { ?>
                    <option
                        value="<?php echo $category->cat_ID; ?>" <?php if ($instance['category'] == $category->cat_ID) echo "selected"; ?>><?php echo $category->name; ?></option>
                <?php }

                ?>
            </select>
            <span class="description">This category will be used to display content.</span>
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
        <script type="text/javascript">
            /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
            var disqus_shortname = 'finnovista-test'; // required: replace example with your forum shortname

            /* * * DON'T EDIT BELOW THIS LINE * * */
            /*
             (function () {
             var s = document.createElement('script'); s.async = true;
             s.type = 'text/javascript';
             s.src = '//' + disqus_shortname + '.disqus.com/count.js';
             (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
             }());
             */
        </script>

    <?php
    }
}

?>