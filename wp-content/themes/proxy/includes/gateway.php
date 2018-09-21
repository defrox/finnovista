<?php

if(file_exists('../../../../wp-load.php')) {
    include '../../../../wp-load.php';
} else {
    include '../../../../../wp-load.php';
}

$postId = $_POST['id'];
$p = get_post($postId);

echo $p->post_type;

if($p->post_type === "portfolio"){
    query_posts(array(
            'p' => $postId,
            'post_type' => "portfolio"
        )
    );
    echo '<script>
            jQuery("#gateway-wrapper").removeClass("post-class")
            jQuery("#gateway-wrapper").addClass("portfolio-class");
        </script>';
}else{
    query_posts(array(
            'p' => $postId,
        )
    );
    echo '<script>
            jQuery("#gateway-wrapper").removeClass("portfolio-class");
            jQuery("#gateway-wrapper").addClass("post-class");
         </script>';
}


if (have_posts()) : while (have_posts()) : the_post();
$prev = get_adjacent_post(false,'',false);
$next = get_adjacent_post(false,'',true);
?>
<div id="gateway-navigation">

    <?php if( is_object($prev) && $prev->ID != get_the_ID()): ?>
        <a href="#" data-through="gateway" data-postid="<?php echo $prev->ID; ?>" class="prev"></a>
    <?php endif; ?>

    <?php if( is_object($next) && $next->ID != get_the_ID()): ?>
        <a href="#" data-through="gateway" data-postid="<?php echo $next->ID; ?>" class="next"></a>
    <?php endif; ?>


    <a href="#" class="close-gateway"></a>
</div>

<div class="hfeed">
    <?php if(get_post_meta(get_the_ID(), '_stag_cover_image', true) != ''): ?>
    <figure class="entry-image">
        <img src="<?php echo get_post_meta(get_the_ID(), '_stag_cover_image', true); ?>" alt="<?php the_title(); ?>">
    </figure>
    <?php endif; ?>

    <div id="portfolio-single-slider" class="flexslider">
        <ul class="slides">
            <?php
                $sl1 = get_post_meta(get_the_ID(), '_stag_portfolio_image_1', true);
                $sl2 = get_post_meta(get_the_ID(), '_stag_portfolio_image_2', true);
                $sl3 = get_post_meta(get_the_ID(), '_stag_portfolio_image_3', true);
                $sl4 = get_post_meta(get_the_ID(), '_stag_portfolio_image_4', true);
                $sl5 = get_post_meta(get_the_ID(), '_stag_portfolio_image_5', true);
                $images = array($sl1,$sl2,$sl3,$sl4,$sl5);

                foreach($images as $img){
                    if($img != ''){
                        echo '<li><img src="'.$img.'" alt=""></li>';
                    }
                }
            ?>
        </ul>
    </div>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <p class="pubdate">
        <?php if($p->post_type === 'post'): ?>
            <?php the_time('F d Y'); ?>
        <?php endif; ?>
        </p>

        <h2 class="entry-title"><?php the_title(); ?></h2>

        <div class="entry-content clearfix">

            <?php if($p->post_type == "portfolio"): ?>

            <div class="portfolio-details">

                <?php

                if(get_post_meta(get_the_ID(), '_stag_portfolio_date', true) != ''){
                    echo '<div class="row"><i class="icon-check"></i> Project Date: <span>'.get_post_meta(get_the_ID(), '_stag_portfolio_date', true).'</span></div>';
                }

                $skills = get_the_terms(get_the_ID(), 'skill');
                if($skills){
                    $skill = '';
                    foreach($skills as $ski){
                        $skill[] .= $ski->name;
                    }

                    echo "<div class='row'>";
                    echo "<i class='icon-check'></i> Skills: ";
                    echo "<span>";
                    echo implode($skill, ', ');
                    echo "</span>";
                    echo "</div>";

                }
                 ?>
                <?php if(get_post_meta(get_the_ID(), '_stag_portfolio_url', true) != ''){
                    echo '<div class="row"><a href="'.get_post_meta(get_the_ID(), '_stag_portfolio_url', true).'" class="button">Go to Live Project</a></div>';
                } ?>
            </div>

            <?php endif; ?>

            <?php the_content(); ?>
        </div>

    </article>

    <?php
    endwhile;

    if($p->post_type == 'post'){
        comments_template('', true);
    }

    endif;
    ?>
</div>

<div id="gateway-navigation-2">

    <?php if( is_object($prev) && $prev->ID != get_the_ID()): ?>
        <a href="#" data-through="gateway" data-postid="<?php echo $prev->ID; ?>" class="prev"></a>
    <?php endif; ?>

    <?php if( is_object($next) && $next->ID != get_the_ID()): ?>
        <a href="#" data-through="gateway" data-postid="<?php echo $next->ID; ?>" class="next"></a>
    <?php endif; ?>

    <a href="#" class="close-gateway"></a>
</div>