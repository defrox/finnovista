<?php
/*
 * Template Name: My Speakers Page
 * Description: A Page Template with a darker design.
 */
?>
<?php get_header();
$dfx_title = '';
$area = $_REQUEST['area'];
$category = $_REQUEST['cat'];
$fscity = $_REQUEST['fscity'];
$pdcity = $_REQUEST['pdcity'];
$visacity = $_REQUEST['visacity'];
if (isset($_REQUEST['area'])) $dfx_title = get_term($area, '_stag_team_area_type')->name . ' ';
if (isset($_REQUEST['fscity'])) $dfx_title .= ucwords(preg_replace('/-/', ' ', $fscity)) . ' ';
if (isset($_REQUEST['pdcity'])) $dfx_title .= ucwords(preg_replace('/-/', ' ', $pdcity)) . ' ';
if (isset($_REQUEST['visacity'])) $dfx_title .= ucwords(preg_replace('/-/', ' ', $visacity)) . ' ';
if (isset($_REQUEST['cat'])) $dfx_title .= get_term($category, '_stag_team_category')->name;
?>
    <section id="team" class="section-block speakers">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <div class="inner-section">
                <h2 class="main-title"><?php if ($dfx_title != '') {
                        print $dfx_title;
                    } else the_title(); ?></h2>
            </div>
            <div class="inner-section"> <?php the_content(); ?></div>
        <?php endwhile; endif; ?>
        <div class="inner-section">
            <?php
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

            $args = array(
                'post_type' => 'team',
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
                'posts_per_page' => -1,
                'orderby' => 'title',
                'order' => 'ASC'
            );
            $the_query = new WP_Query($args);
            ?>
            <div class="team-members">
                <?php
                if ($the_query->have_posts()) {
                    $i = 0;
                    while ($the_query->have_posts()): $the_query->the_post();
                        $area_tags = wp_get_post_terms(get_the_ID(), '_stag_team_area_type');
                        $area_tag = $area_tags[0]->name;
                        if ($area_tag == 'Ninguno' || $area_tag == '' || is_null($area_tag)) $area_tag = '&nbsp;';
                        ?>
                        <div id="<?php print get_the_ID() ?>"><p></p></div>
                        <section class="member-section <?php echo $i % 2 == 0 ? "even" : "odd" ?>">
                            <div class="member">
                                <?php if ($area_tag != ''): ?>
                                    <div class="area-tag <?php echo seoUrl($area_tag); ?>"><?php echo $area_tag; ?></div>
                                <?php endif ?>
                                <?php if (has_post_thumbnail()): ?>
                                    <div class="member-pic">
                                        <?php the_post_thumbnail('team-avatar'); ?>

                                        <div class="member-links">

                                            <?php if (get_post_meta(get_the_ID(), '_stag_team_url_twitter', true) != ''): ?>
                                                <a href="<?php echo get_post_meta(get_the_ID(), '_stag_team_url_twitter', true); ?>" class="twitter"></a>
                                            <?php endif ?>

                                            <?php if (get_post_meta(get_the_ID(), '_stag_team_url_linkedin', true) != ''): ?>
                                                <a href="<?php echo get_post_meta(get_the_ID(), '_stag_team_url_linkedin', true); ?>" class="linkedin"></a>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="member-description">
                                    <p class="member-title"><?php the_title(); ?></p>
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
        </div>
    </section>
<?php get_footer() ?>