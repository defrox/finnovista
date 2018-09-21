<?php
/*
Template Name: Bootstrap Agenda FS
*/

$event_id = get_post_meta(get_the_ID(), '_stag_linked_event', true);
$event_register = get_post_meta($event_id, '_stag_event_register_enabled', true);
$bgcolor = get_post_meta($event_id, '_stag_event_color', true);
$fontcolor = get_post_meta($event_id, '_stag_event_font_color', true) ?: '#ffffff';
$event_date = get_post_meta($event_id, '_stag_event_date', false);
$event_date_text = get_post_meta($event_id, '_stag_event_date_text', false);
@$event_date = $event_date[0] && $event_date[0] != '' ? date('d M Y', strtotime($event_date[0])) : '';
@$event_date_text = $event_date_text[0] && $event_date_text[0] != '' ? $event_date_text[0] : $event_date;

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

$query2 = new WP_Query( $args2 );

if ( $query2->have_posts() ) {
    // The 2nd Loop
    $agenda_items = array();
    $agenda_terms = array();
    while ( $query2->have_posts() ) {
        $query2->the_post();
        $agenda_item = array();
        $agenda_item['id'] = $query2->post->ID;
        $agenda_item['title'] = get_the_title( $query2->post->ID );
        $agenda_item['content'] = get_the_content( $query2->post->ID );
        $agenda_item['category'] = get_the_terms($query2->post->ID, 'event_agenda_category');
        $agenda_item['date'] = get_post_meta($query2->post->ID, '_stag_event_agenda_date', true);
        $agenda_item['start'] = get_post_meta($query2->post->ID, '_stag_event_agenda_start', true);
        $agenda_item['end'] = get_post_meta($query2->post->ID, '_stag_event_agenda_end', true);
        $agenda_item['speakers'] = get_post_meta($query2->post->ID, '_stag_event_agenda_speakers', true);
        $agenda_item['avatar'] = get_post_meta($query2->post->ID, '_stag_event_agenda_avatar', true);
        $agenda_item['event_id'] = get_post_meta($query2->post->ID, '_stag_linked_event', true);
        $agenda_item['meta'] = get_post_meta($query2->post->ID);
        $agenda_items[$agenda_item['date']][(int)preg_replace('/:/', '', $agenda_item['start'] )] = $agenda_item;
        if (is_array($agenda_item['category'])) {
            foreach ($agenda_item['category'] as $term) {
                if (!array_key_exists($term->term_id, $agenda_terms)) {
                    $term_meta = get_term_meta($term->term_id);
                    $agenda_terms[$term->term_id] = array(  'name'  => $term->name,
                                                            'id'    => $term->term_id,
                                                            'slug'  => $term->slug,
                                                            'icon'  => $term_meta['category_icon'][0],
                                                            'color'  => $term_meta['category_color'][0]);
                }
            }
        }
    }
    // Restore original Post Data
    wp_reset_postdata();
}

?>
<?php get_header(); ?>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        jQuery('#logo img').each(function () {
            jQuery(this).attr("src", "/wp-content/uploads/2015/05/finnosummit-logo.png");
            //jQuery(this).css("margin-top", "10px");
            jQuery(this).parent().parent().find(".subtitle-text").css("display", "none");
        });
        jQuery('#logo a').each(function () {
            jQuery(this).attr("href", "/finnosummit");
        });
    });
</script>
<header id="subheader" class="clearfix">
    <style type="text/css"> .single-event #subheader .subheader-inner .event_menu a {
            color: <?= $fontcolor;?> !important;
        }
        #subheader .finnosummit-menu, #subheader .finnosummit-menu .sub-menu li a:hover, .finnosummit-menu li.sfHover > a, .finnosummit-menu li.current-menu-item > a, #mobile-finnosummit-menu ul, #mobile-finnosummit-nav-wrap {
            background-color: <?= $bgcolor;?> !important;
            color: <?= $fontcolor;?> !important;
        }
        .btn-primary.disabled, .btn-tag {
            background-color: <?= $bgcolor;?> !important;
            border-color: <?= $bgcolor;?> !important;
            color: <?= $fontcolor;?> !important;
        }
        .page-template-page-bootstrap-agenda-fs .event_title {
            color: <?= $fontcolor;?> !important;
        }
        #container .hfeed a {color: <?= $bgcolor;?> !important;}
        #agenda_resumen .box a{color: #8D8F92 !important;}
        #agenda_resumen .box.clarita a{color: #fff !important;}</style>
    <div class="subheader-inner">
        <div class="finnosummit-logo"><a href="finnosummit"><img width="270" src="/wp-content/uploads/2015/05/finnosummit-logo.png"/></a>
        </div>
    </div>
    <div class="event_title"><?php echo get_the_title( $event_id ); ?> / <?= $event_date_text; ?></div>
    <a id="finnosummit-mobile-nav" href="#mobile-finnosummit-menu"></a>
    <div class="finnosummit-menu clearfix"
         id="finnosummit-nav"><?php
        $dfx_menu = $event_id != '' ? 'event-menu' : 'finnosummit-menu';
        wp_nav_menu(array('theme_location' => $dfx_menu)); ?></div>
    <div id="mobile-finnosummit-nav-wrap">
        <div id="mobile-finnosummit-menu" class="finnosummit-menu clearfix"><?php wp_nav_menu(array('theme_location' => $dfx_menu, 'menu_class' => 'clearfix menu')); ?>
            <br clear="all"/></div>
    </div>
</header>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class="hfeed" style="padding-top: 30px;">
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <p class="pubdate"></p>
            <h2 class="entry-title"><?php the_title(); ?></h2>
            <div class="entry-content clearfix">
                <div class="container"><?php the_content();?></div>
                <?php if (is_array($agenda_items) && count($agenda_items) > 0):
                    $day_col = 12;
                    if (count($agenda_items) > 1 && count($agenda_items) < 3)
                        $day_col = 6;
                    else if (count($agenda_items) >= 3)
                        $day_col = 4;
                    asort($agenda_items, SORT_STRING | SORT_ASC);
                    ?>
                <div class="container agenda-event">
                    <?php if (is_array($agenda_terms) && count($agenda_terms) > 0): ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <p><? _e('Filter by','stag');?>:
                                <button type="button" class="btn btn-default btn-xs btn-tag mb-2"><?= __('All'); ?></button>
                                <?php foreach($agenda_terms as $term_id => $term):
                                    $cat_color = "";
                                    if ($term['name'] != '') {
                                        $cat_color = 'style="background-color: ' . $term['color'] .' !important; border-color: ' . $term['color'] .' !important;"';
                                    }
                                    ?>
                                <button type="button" class="btn btn-info btn-xs btn-tag mb-2" <?= $cat_color; ?>><?= $term['name']; ?></button>
                                <?php endforeach; ?>
                            </p>
                        </div>
                    </div>
                    <?php endif;?>
                    <div class="row">
                        <?php foreach($agenda_items as $day => $hour): ?>
                        <div class="col-sm-<?= $day_col;?>" id="accordion<?= $day;?>">
                            <div class="btn btn-primary btn-lg btn-block disabled mb-4" role="button" aria-disabled="true">
                                <i class="far fa-calendar"></i> <?= date_i18n("j M Y", strtotime($day));?>
                            </div>
                            <?php ksort($hour);
                            foreach($hour as $hitem): ?>
                            <div class="card card-default agenda-item mb-2" data-toggle="collapse" href="#collapse<?= $hitem['id'];?>" id="agendaitem<?= $hitem['id'];?>">
                                <?php if (is_array($hitem['category']) && count($hitem['category']) > 0): ?>
                                    <div style="display: none;">
                                        <span class="label label-primary tag hidden"><?= __('All'); ?></span>
                                        <?php
                                        $category = "";
                                        foreach($hitem['category'] as $catitem):
                                            $category .= " <i class=\"fas fa-" . $agenda_terms[$catitem->term_id]['icon'] . "\"></i> " . $catitem->name;
                                        ?>
                                            <span class="label label-default tag"><?= $catitem->name;?></span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                                <div class="card-header title">
                                    <div class="d-flex mb-1"><span class="timer"><?= $hitem['start']; ?> - <?= $hitem['end']; ?></span> &nbsp; <span class="card-title"><?= $hitem['title'];?></span></div>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex"><span class="category"><?= $category;?></span></div>
                                    <?php if ($hitem['avatar'] != ''):?><div class="d-flex pull-left mr-3"><span class="avatar"><img src="<?= $hitem['avatar']; ?>" /></span></div><?php endif; ?>
                                    <div class="d-flex"><span class="speakers"><?= html_entity_decode($hitem['speakers']); ?></span></div>
                                </div>
                                <div id="collapse<?= $hitem['id']; ?>" class="collapse" data-parent="#accordion<?= $day;?>">
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
                <?php else:?>
                <div class="container"><?= __('To be disclosed.'); ?></div>
                <?php endif;?>
            </div>
        </article>
    </div>
<?php endwhile; ?>
<?php endif; ?>
<script>
    jQuery(document).ready(function () {
        <?php if ($event_register != 'on') : ?>
        jQuery( "a[href='http://dfxlink/#register']" ).each(function(){
            jQuery(this).attr('href', function(i, val) {   return jQuery(this).attr('href').replace('register',
                'contact'); });
        });
        <?php endif; ?>

        jQuery( "a[href*='http://dfxlink/']" ).each(function(){
            jQuery(this).attr('href', function(i, val) {   return jQuery(this).attr('href').replace('http://dfxlink/', '<?php echo post_permalink( $event_id ); ?>'); });
        });

    });
</script>
<?php get_footer('finnosummit') ?>