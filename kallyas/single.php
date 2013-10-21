<?php get_header(); ?>
	
	<?php
	
	// SIDEBAR CHECK
	$has_sidebar = true;
		
	// GET GLOBALS
	global $content_and_sidebar;

	// GET THE METAFIELDS
	$meta_fields = get_post_meta($post->ID, 'zn_meta_elements', true);
	$meta_fields = maybe_unserialize( $meta_fields );

if ( post_password_required() ) {
	$meta_fields['content_main_area'] = '';
	$meta_fields['content_bottom_area'] = '';
	$meta_fields['content_grey_area'] = '';
}

/*--------------------------------------------------------------------------------------------------
	ACTION BOX AREA
--------------------------------------------------------------------------------------------------*/
	zn_get_template_from_area ('action_box_area',$post->ID,$meta_fields);

	?>
	
	
	<section id="content">
		<?php if ( $content_and_sidebar ) { ?>
		<div class="container">
			
			<div id="mainbody">
				
				<div class="row-fluid">
				<?php while(have_posts()) : the_post(); 

					// GET POST OPTIONS 
					$post_meta_fields = get_post_meta($post->ID, 'zn_meta_elements', true);
					$post_meta_fields = maybe_unserialize( $post_meta_fields );

					
					// Here will check if sidebar is enabled
					$content_css = 'span12'; 
					$sidebar_css = ''; 
					$has_sidebar = false;
					$mainbody_css = '';
					$row_style = ' row ';
					
					if ( isset( $meta_fields['page_builder_layout'] ) && $meta_fields['page_builder_layout'] == 'style1' ) {
						$row_style = ' row-fluid zn_def_margin zn_has_sidebar';
					}

					// WE CHECK IF THIS IS NOT A PAGE FROM OUR THEME	
					if ( empty ( $post_meta_fields['page_layout'] ) || empty ( $post_meta_fields['sidebar_select'] ) ) {
						if ( $data['default_sidebar_position'] == 'left_sidebar' ) {
							$content_css = 'span9 zn_float_right zn_content zn_has_sidebar';
							$sidebar_css = 'sidebar-left';
							$has_sidebar = true;
							$mainbody_css = 'zn_has_sidebar';
						}
						elseif ( $data['default_sidebar_position'] == 'right_sidebar' ) {
							$content_css = 'span9 zn_content zn_has_sidebar';
							$sidebar_css = 'sidebar-right';
							$has_sidebar = true;
							$mainbody_css = 'zn_has_sidebar';
						}
					}	
					// WE CHECK IF WE HAVE LEFT SIDEBAR
					elseif ( $post_meta_fields['page_layout'] == 'left_sidebar' || ( $post_meta_fields['page_layout'] == 'default' && !empty ( $data['default_sidebar_position'] ) && $data['default_sidebar_position'] == 'left_sidebar' )   )
					{
						$content_css = 'span9 zn_float_right zn_content zn_has_sidebar';
						$sidebar_css = 'sidebar-left';
						$has_sidebar = true;
						$mainbody_css = 'zn_has_sidebar';
					}
					// WE CHECK IF WE HAVE RIGHT SIDEBAR
					elseif ( $post_meta_fields['page_layout'] == 'right_sidebar' || ( $post_meta_fields['page_layout'] == 'default' && !empty ( $data['default_sidebar_position'] ) && $data['default_sidebar_position'] == 'right_sidebar' )  )
					{
						$content_css = 'span9 zn_content zn_has_sidebar';
						$sidebar_css = 'sidebar-right ';
						$has_sidebar = true;
						$mainbody_css = 'zn_has_sidebar';
					}	
				
					$image = '';
					
					// Create the featured image html
					if ( has_post_thumbnail() && ! post_password_required() ) {

						$thumb = get_post_thumbnail_id($post->ID) ;
						$f_image = wp_get_attachment_url($thumb) ;

						if ( isset( $data['sb_use_full_image'] ) && $data['sb_use_full_image'] == 'yes' )  {

							$image = '<div class="zn_full_image"><a data-rel="prettyPhoto" href="'.$f_image.'" class="hoverBorder">'.get_the_post_thumbnail($post->ID ,'full-width-image').'</a></div>';
				
						}
						else {
							$image = '<div class="zn_post_image"><a data-rel="prettyPhoto" href="'.$f_image.'" class="hoverBorder pull-left">'.get_the_post_thumbnail().'</a></div>';
						}
					}
					


				?>
				
					<div class="<?php echo $content_css; echo $row_style; ?> post-<?php the_ID(); ?>">
				
						<h1 class="page-title"><?php the_title();?></h1>

						<div class="itemView clearfix eBlog">

							<div class="itemHeader">
								<div class="post_details">
									<span class="itemAuthor"><?php echo __("by ", THEMENAME);?><?php the_author_posts_link(); ?></span>
									<span class="infSep"> / </span>
									<span class="itemDateCreated"><span class="icon-calendar"></span> <?php the_time('l, d F Y');?></span>
									<span class="infSep"> / </span>
									<span class="itemCommentsBlock"></span>
									<span class="itemCategory"><span class="icon-folder-close"></span> <?php echo __( 'Published in ', THEMENAME );?></span><?php the_category(", ");  ?>
								</div>
							</div><!-- end itemheader -->

							<div class="itemBody">
								<!-- Blog Image -->
								<?php echo $image; ?>
								
								<!-- Blog Content -->
								<?php the_content(); ?>
								
							</div><!-- end item body -->
							<div class="clear"></div>

						<?php
						
						wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', THEMENAME ) . '</span>', 'after' => '</div>' ) );
						
/*--------------------------------------------------------------------------------------------------
	START CONTENT AREA 
--------------------------------------------------------------------------------------------------*/
						if ( isset ( $meta_fields['content_main_area'] ) && is_array ( $meta_fields['content_main_area'] ) && ( isset( $meta_fields['page_builder_layout'] ) && $meta_fields['page_builder_layout'] == 'style1' ) ) {
							zn_get_template_from_area ('content_main_area',$post->ID,$meta_fields,true);
						}

							if ( !empty($post_meta_fields['show_social']) && $post_meta_fields['show_social'] == 'show' || ( !empty($post_meta_fields['show_social']) &&  $post_meta_fields['show_social'] == 'default' && $data['show_social'] == 'show' ) ) {
							
							
						?>
							
							
							
								<!-- Social sharing -->
								<div class="itemSocialSharing clearfix">

									<!-- Twitter Button -->
									<div class="itemTwitterButton">
										<a href="https://twitter.com/share" class="twitter-share-button" data-count="horizontal">Tweet</a>
										<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
									</div>

									<!-- Facebook Button -->
									<div class="itemFacebookButton">
										<div id="fb-root"></div>
										<div class="fb-like" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false"></div>
									</div>

									<!-- Google +1 Button -->
									<div class="itemGooglePlusOneButton">	
										<script type="text/javascript">
										(function() {
										var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
										po.src = 'https://apis.google.com/js/plusone.js';
										var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
										})();
										</script>
										<div class="g-plusone" data-size="medium"></div>
									</div>

									<div class="clear"></div>
								</div><!-- end social sharing -->
							<?php
							}
						?>

							<?php	
								if (has_tag()) { 
								?>
									<!-- TAGS -->
									<div class="itemTagsBlock">
										<span><?php echo __( 'Tagged under:', THEMENAME );?></span>
										<?php the_tags('');?>
										<div class="clear"></div>
									</div><!-- end tags blocks -->
							<?php	
								}	
								?>	
														
							<div class="clear"></div>
								
						<!-- DISQUS comments block -->
						<div class="disqusForm">
							<?php comments_template(); ?>
						</div>
						<div class="clear"></div>
						<!-- end DISQUS comments block -->

						</div>
						<!-- End Item Layout -->
						
						
						
					</div>
					
					<?php 
					endwhile;
					
					// START SIDEBAR OPTIONS
					// WE CHECK IF THIS IS NOT A PAGE FROM THE THEME
					if ( empty ( $post_meta_fields['page_layout'] ) || empty ( $post_meta_fields['sidebar_select'] ) ) {
						if ( $data['default_sidebar_position'] == 'left_sidebar' || $data['default_sidebar_position'] == 'right_sidebar' ) {
							echo '<div class="span3">';
								echo '<div id="sidebar" class="sidebar '.$sidebar_css.'">';
									if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($data['single_sidebar']) ) : endif;
								echo '</div>';
							echo '</div>';
						}
					}
					// WE CHECK IF WE HAVE A SIDEBAR SET IN PAGE OPTIONS
					elseif ( ( ( $post_meta_fields['page_layout'] == 'left_sidebar' || $post_meta_fields['page_layout'] == 'right_sidebar' ) && $post_meta_fields['sidebar_select'] != 'default' ) || (  $post_meta_fields['page_layout'] == 'default' && $data['default_sidebar_position'] != 'no_sidebar' && $post_meta_fields['sidebar_select'] != 'default' ) ) 
					{ 
							
								echo '<div class="span3">';
									echo '<div id="sidebar" class="sidebar '. $sidebar_css.'">';
										if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar( $post_meta_fields['sidebar_select'] ) ) : endif;
									echo '</div>';
								echo '</div>';
					}
					// WE CHECK IF WE HAVE A SIDEBAR SET FROM THEME'S OPTIONS
					elseif ( $post_meta_fields['page_layout'] == 'default' && $data['default_sidebar_position'] != 'no_sidebar' && $post_meta_fields['sidebar_select'] == 'default' || ( ( $post_meta_fields['page_layout'] == 'left_sidebar' || $post_meta_fields['page_layout'] == 'right_sidebar' ) && $post_meta_fields['sidebar_select'] == 'default' ) ) {
						echo '<div class="span3">';
							echo '<div id="sidebar" class="sidebar '.$sidebar_css.'">';
								if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($data['single_sidebar']) ) : endif;
							echo '</div>';
						echo '</div>';
					}
					
					?>
				</div><!-- end row -->
				
			</div><!-- end mainbody -->
			
		</div><!-- end container -->

		<?php } ?>

<?php

/*--------------------------------------------------------------------------------------------------
	START CONTENT AREA 
--------------------------------------------------------------------------------------------------*/
	if ( isset ( $meta_fields['content_main_area'] ) && is_array ( $meta_fields['content_main_area'] ) && ( !isset( $meta_fields['page_builder_layout'] ) || $meta_fields['page_builder_layout'] == 'default' ) ) {
		echo '<div class="container">';
			zn_get_template_from_area ('content_main_area',$post->ID,$meta_fields);
		echo '</div>';
	}

/*--------------------------------------------------------------------------------------------------
	START GRAY AREA
--------------------------------------------------------------------------------------------------*/
				
	$cls = '';
	if ( !isset ( $meta_fields['content_bottom_area'] ) || !is_array ( $meta_fields['content_bottom_area'] ) ) {
		$cls = 'noMargin';
	}

	if ( isset ( $meta_fields['content_grey_area'] ) && is_array ( $meta_fields['content_grey_area'] ) ) {
	echo '<div class="gray-area '.$cls.'">';
		echo '<div class="container">';
		
			zn_get_template_from_area ('content_grey_area',$post->ID,$meta_fields);
		
		echo '</div>';
	echo '</div>';
	}
				

		
		
/*--------------------------------------------------------------------------------------------------
	START BOTTOM AREA
--------------------------------------------------------------------------------------------------*/
		

	if ( isset ( $meta_fields['content_bottom_area'] ) && is_array ( $meta_fields['content_bottom_area'] ) ) {
		echo '<div class="container">';
			zn_get_template_from_area ('content_bottom_area',$post->ID,$meta_fields);
		echo '</div>';
	}
?>



	</section><!-- end #content -->
	

























	

	
	

<?php get_footer(); ?>