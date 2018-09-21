    <?php $post_meta = of_get_option('post_meta'); ?>
		<?php if ($post_meta=='true' || $post_meta=='') { ?>
			<div class="post-meta">
				<div class="fleft"><?php _e('Posted on', 'theme1830'); ?> <time datetime="<?php the_time('Y-m-d\TH:i'); ?>"><?php the_time('F j, Y'); ?></time> <?php _e('by', 'theme1830'); ?> <?php the_author_posts_link() ?>
				
				<?php if (get_post_type()=='post') { ?>	
					<?php _e('in', 'theme1830'); ?> <?php the_category(', ') ?>
				<?php } elseif (get_post_type()=='portfolio') { ?>
					<?php _e('in', 'theme1830'); ?> <?php the_terms($post->ID, 'portfolio_category','',', ') ?>
				<?php } ?>
				
				</div>
			</div><!--.post-meta-->
		<?php } ?>	