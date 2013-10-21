<?php

	global $content_css ,$sidebar_css , $meta_fields , $data , $has_sidebar, $wp_query;

	$columns_size = 12/$data['blog_style_layout'];

?>



<div class="row">

	<div class="<?php echo $content_css; ?>">
		 
		 <div class="itemListView clearfix eBlog">

			<div class="itemList">
			
			<?php

			$i = 1;

			if ( have_posts() ) :
				while( have_posts() ){

					the_post();
					
					if ( $i % $data['blog_style_layout'] == 1 ) {
						echo '<div class="row-fluid">';
					}

					$image = '';
					
					$image_size = zn_get_size( 'span'.$columns_size );

					// Create the featured image html
					if ( has_post_thumbnail( $post->ID ) ) {
					
						$thumb = get_post_thumbnail_id($post->ID) ;
						$f_image = wp_get_attachment_url($thumb) ;
						if ( !empty ( $f_image ) ) {
						
							$feature_image = wp_get_attachment_url( $thumb );
							$image = vt_resize( '', $f_image  , $image_size['width'],$image_size['height'] , true );
							$image = '<a href="'.get_permalink().'" class="hoverBorder pull-left" style="margin-right: 20px;margin-bottom:4px;"><img class="shadow" src="'.$image['url'].'" alt=""/></a>';
							
						}

					}
					elseif ( $data['zn_use_first_image'] == 'yes') {
						
						$f_image =  echo_first_image();
						if ( !empty ( $f_image ) ) {
							$image = vt_resize( '', $f_image , $image_size['width'],$image_size['height'] , true );
							$image = '<a href="'.get_permalink().'" class="hoverBorder pull-left" style="margin-right: 20px;margin-bottom:4px;"><img class="shadow" src="'.$image['url'].'" alt=""/></a>';
						}
					}

					?>
					
					<div class="itemContainer zn_columns zn_columns<?php echo $data['blog_style_layout'];?> post-<?php the_ID(); ?> span<?php echo $columns_size;?>"> 
						<?php echo $image; ?>
						<div class="itemHeader">
							<h3 class="itemTitle">
								<a href="<?php the_permalink(); ?>"><?php the_title();?></a>
							</h3>
							<div class="post_details">
								<span class="catItemDateCreated"><span class="icon-calendar"></span> <?php the_time('l, d F Y');?></span>
								<span class="catItemAuthor"><?php echo __( 'by', THEMENAME );?> <?php the_author_posts_link(); ?></span>
							</div><!-- end post details -->
						</div><!-- end itemHeader -->
				
						<div class="itemBody">
							<div class="itemIntroText">
							<?php the_excerpt();	?>
							
							</div><!-- end Item Intro Text -->
							<div class="clear"></div>
							<div class="itemReadMore">
								<a class="readMore" href="<?php the_permalink(); ?>"><?php echo __( 'Read more...', THEMENAME );?></a>
							</div><!-- end read more -->
							<div class="clear"></div>
						</div><!-- end Item BODY -->
				
						<ul class="itemLinks clearfix">
							<li class="itemCategory">
								<span class="icon-folder-close"></span> 
								<span><?php echo __( 'Published in', THEMENAME );?></span>
								<?php the_category(", ");  ?>
							</li>
						</ul><!-- item links -->
						<div class="clear"></div>
					<?php	if (has_tag()) { ?>
							<div class="itemTagsBlock">
								<span class="icon-tags"></span>
								<span><?php echo __( 'Tagged under:', THEMENAME );?></span>
								<?php the_tags('');?>
								<div class="clear"></div>
							</div><!-- end tags blocks -->
					<?php	}	?>	
						

					
				</div><!-- end Blog Item -->
				
			<?php 

					if ( $i % $data['blog_style_layout'] == 0 || get_option('posts_per_page') == $i || $wp_query->post_count == $i ) {
						
						echo '</div>';
						
					}

					$i++;

				} 
			else: ?>
				<div class="itemContainer noPosts"> 
					<p><?php echo __('Sorry, no posts matched your criteria.', THEMENAME ); ?></p>
				</div><!-- end Blog Item -->
				<div class="clear"></div>
			<?php endif; ?>
			
			</div><!-- end .itemList -->
		
			<!-- Pagination -->
			<?php zn_pagination(); ?>
		
		</div><!-- end blog items list (.itemListView) -->

	</div>
	
	<?php
		// START SIDEBAR OPTIONS
		// WE CHECK IF THIS IS NOT A PAGE FROM THE THEME
		if ( empty ( $meta_fields['page_layout'] ) || empty ( $meta_fields['sidebar_select'] ) ) {
			if ( $data['archive_sidebar_position'] == 'left_sidebar' || $data['archive_sidebar_position'] == 'right_sidebar' ) {
				echo '<div class="span3">';
					echo '<div id="sidebar" class="sidebar '.$sidebar_css.'">';
						if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($data['archive_sidebar']) ) : endif;
					echo '</div>';
				echo '</div>';
			}
		}
		// WE CHECK IF WE HAVE A SIDEBAR SET IN PAGE OPTIONS
		elseif ( ( ( $meta_fields['page_layout'] == 'left_sidebar' || $meta_fields['page_layout'] == 'right_sidebar' ) && $meta_fields['sidebar_select'] != 'default' ) || (  $meta_fields['page_layout'] == 'default' && $data['archive_sidebar_position'] != 'no_sidebar' && $meta_fields['sidebar_select'] != 'default' ) ) 
		{ 
				
					echo '<div class="span3">';
						echo '<div id="sidebar" class="sidebar '. $sidebar_css.'">';
							if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar( $meta_fields['sidebar_select'] ) ) : endif;
						echo '</div>';
					echo '</div>';
		}
		// WE CHECK IF WE HAVE A SIDEBAR SET FROM THEME'S OPTIONS
		elseif ( $meta_fields['page_layout'] == 'default' && $data['archive_sidebar_position'] != 'no_sidebar' && $meta_fields['sidebar_select'] == 'default' || ( ( $meta_fields['page_layout'] == 'left_sidebar' || $meta_fields['page_layout'] == 'right_sidebar' ) && $meta_fields['sidebar_select'] == 'default' ) ) {
			echo '<div class="span3">';
				echo '<div id="sidebar" class="sidebar '.$sidebar_css.'">';
					if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($data['archive_sidebar']) ) : endif;
				echo '</div>';
			echo '</div>';
		}
	?>					
</div><!-- end row -->