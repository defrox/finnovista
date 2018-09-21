<?php
/*
 * Template Name: Events Page
 * Description: A Page Template with a darker design.
 */
?>
<?php get_header();
$dfx_title = '';
$type = $_REQUEST['type'];
$fscity = $_REQUEST['fscity'];
$pdcity = $_REQUEST['pdcity'];
$pdcity = $_REQUEST['visacity'];
$filter = $_REQUEST['filter'];
if (isset($_REQUEST['filter']) && $filter != '') $dfx_title .= $filter == '<=' ? __('Past', 'stag') : __('Upcoming', 'stag') . ' ';
if (isset($_REQUEST['fscity'])) $dfx_title .= get_term($fscity, 'event_city')->name . ' ';
if (isset($_REQUEST['pdcity'])) $dfx_title .= get_term($pdcity, 'event_pdcity')->name . ' ';
if (isset($_REQUEST['visacity'])) $dfx_title .= get_term($pdcity, 'event_visacity')->name . ' ';
if (isset($_REQUEST['type'])) $dfx_title .= get_term($type, 'event_type')->name;
?>

<section id="videos" class="section-block videos">
    <div class="inner-section">
        <h2 class="main-title"><?php if ($dfx_title != '') {
                print $dfx_title;
            } else _e('Events'); ?></h2>
    </div>
    <div class="inner-section">
        <div class="grid-12">
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
                'posts_per_page' => -1,
                'orderby' => '_stag_event_date',
                'order' => 'ASC'
            );
            $the_query = new WP_Query($args);
            ?>
            <div class="video-item">
                <?php
                if ($the_query->have_posts()) {
                    $i = 0;
                    while ($the_query->have_posts()): $the_query->the_post();
                        $taxonomy = $type == 96 ? 'event_city' : 'event_pdcity';
                        $terms = isset($_REQUEST['fscity']) || isset($_REQUEST['pdcity']) ? get_the_terms(get_the_ID(), $taxonomy) : false;
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
                        <div id="<?php print get_the_ID() ?>"><p></p></div>
                        <div class="entry-content pdentry">
                            <?php if ($pd_tag != ''): ?>
                                <span><div class="pd-tag <?php echo $pd_css; ?>"
                                           style="background-color: #<?php echo $pd_color; ?>;"><?php echo $pd_tag . ' ' . $event_date; ?></div></span>
                            <?php endif ?>
                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                <?php the_post_thumbnail('medium'); ?>
                                <h3><?php the_title(); ?></h3>

                                <div class="overlay"><?php the_excerpt(); ?></div>
                            </a>

                        </div>
                        <a class="comments_number_disqus" href="<?php the_permalink(); ?>#disqus_thread"></a>


                        <?php
                        $i++;
                    endwhile;
                }
                wp_reset_postdata();
                ?>
            </div>


        </div>
    </div>
    <div class="clearfix"></div>
</section>
<?php get_footer() ?>   
