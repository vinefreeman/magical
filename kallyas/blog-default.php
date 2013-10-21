<?php

	global $content_css ,$sidebar_css ,$has_sidebar, $meta_fields , $data;

?>



<div class="row">

	<div class="<?php echo $content_css; ?>">
		 
		 <div class="itemListView clearfix eBlog">

			<div class="itemList">
			
			<?php
			if ( have_posts() ) :
				while( have_posts() ){

					the_post();
					
					$image = '';
					
					// Create the featured image html
					if ( has_post_thumbnail(  ) && ! post_password_required() ) {
						
						$thumb = get_post_thumbnail_id($post->ID);
						$f_image = wp_get_attachment_url($thumb);
						if ( !empty ( $f_image ) ) {
							if ( isset( $data['sb_archive_use_full_image'] ) && $data['sb_archive_use_full_image'] == 'yes' )  {
								$image = '<div class="zn_full_image"><a data-rel="prettyPhoto" href="'.$f_image.'" class="hoverBorder">'.get_the_post_thumbnail($post->ID ,'full-width-image').'</a></div>';
							}
							else {
								$image = '<div class="zn_post_image"><a href="'.get_permalink().'" class="hoverBorder pull-left">'.get_the_post_thumbnail().'</a></div>';
							}
						}

					}
					elseif ( $data['zn_use_first_image'] == 'yes' && ! post_password_required()) {
						
						$f_image =  echo_first_image();
						if ( !empty ( $f_image ) ) {

							if ( isset( $data['sb_archive_use_full_image'] ) && $data['sb_archive_use_full_image'] == 'yes' )  {
								$feature_image = wp_get_attachment_url( $thumb );

								$size = zn_get_size( 'sixteen' ,$has_sidebar , 30 );

								
								$image = vt_resize( '', $f_image  , $size['width'] ,'' , true );
								$image = '<div class="zn_full_image"><a data-rel="prettyPhoto" href="'.$feature_image.'" class="hoverBorder"><img class="shadow" src="'.$image['url'].'" alt=""/></a></div>';
							
							}
							else {

								$image = vt_resize( '', $f_image  , 280,187 , true );
								$image = '<a href="'.get_permalink().'" class="hoverBorder pull-left" style="margin-right: 20px;margin-bottom:4px;"><img class="shadow" src="'.$image['url'].'" alt=""/></a>';
							}
						}
					}

					?>
					
					<div class="itemContainer post-<?php the_ID(); ?>"> 
				
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
							<?php
								if ( preg_match('/<!--more(.*?)?-->/', $post->post_content) ) {
									echo $image;
									the_content('');
								}
								else {
									echo $image;
									the_excerpt();
								}
							?>
							
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
				<div class="clear"></div>
				
			<?php 
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
						if ( !dynamic_sidebar($data['archive_sidebar']) ) : endif;
					echo '</div>';
				echo '</div>';
			}
		}
		// WE CHECK IF WE HAVE A SIDEBAR SET IN PAGE OPTIONS
		elseif ( ( ( $meta_fields['page_layout'] == 'left_sidebar' || $meta_fields['page_layout'] == 'right_sidebar' ) && $meta_fields['sidebar_select'] != 'default' ) || (  $meta_fields['page_layout'] == 'default' && $data['archive_sidebar_position'] != 'no_sidebar' && $meta_fields['sidebar_select'] != 'default' ) ) 
		{ 
				
					echo '<div class="span3">';
						echo '<div id="sidebar" class="sidebar '. $sidebar_css.'">';
							if ( !dynamic_sidebar( $meta_fields['sidebar_select'] ) ) : endif;
						echo '</div>';
					echo '</div>';
		}
		// WE CHECK IF WE HAVE A SIDEBAR SET FROM THEME'S OPTIONS
		elseif ( $meta_fields['page_layout'] == 'default' && $data['archive_sidebar_position'] != 'no_sidebar' && $meta_fields['sidebar_select'] == 'default' || ( ( $meta_fields['page_layout'] == 'left_sidebar' || $meta_fields['page_layout'] == 'right_sidebar' ) && $meta_fields['sidebar_select'] == 'default' ) ) {
			echo '<div class="span3">';
				echo '<div id="sidebar" class="sidebar '.$sidebar_css.'">';
					if ( !dynamic_sidebar($data['archive_sidebar']) ) : endif;
				echo '</div>';
			echo '</div>';
		}
	?>					
</div><!-- end row -->