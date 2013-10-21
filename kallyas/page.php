<?php get_header(); ?>

<?php

	// GET GLOBALS
	global $content_and_sidebar;
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

	if ( isset ( $meta_fields['action_box_area'] ) && is_array ( $meta_fields['action_box_area'] ) ) {
		zn_get_template_from_area ('action_box_area',$post->ID,$meta_fields);
	}

/*--------------------------------------------------------------------------------------------------
	CONTENT AREA
--------------------------------------------------------------------------------------------------*/
	
	// Here will check if sidebar is enabled
	$content_css = 'span12'; 
	$sidebar_css = ''; 
	$has_sidebar = false;
	$mainbody_css = '';
		
	// WE CHECK IF THIS IS NOT A PAGE FROM OUR THEME	
	if ( empty ( $meta_fields['page_layout'] ) || empty ( $meta_fields['sidebar_select'] ) ) {
		if ( $data['page_sidebar_position'] == 'left_sidebar' ) {
			$content_css = 'span9 zn_float_right zn_content';
			$sidebar_css = 'sidebar-left';
			$has_sidebar = true;
			$mainbody_css = 'zn_has_sidebar';
		}
		elseif ( $data['page_sidebar_position'] == 'right_sidebar' ) {
			$content_css = 'span9 zn_content';
			$sidebar_css = 'sidebar-right';
			$has_sidebar = true;
			$mainbody_css = 'zn_has_sidebar';
		}
	}	
	// WE CHECK IF WE HAVE LEFT SIDEBAR
	elseif ( $meta_fields['page_layout'] == 'left_sidebar' || ( $meta_fields['page_layout'] == 'default' && !empty ( $data['page_sidebar_position'] ) && $data['page_sidebar_position'] == 'left_sidebar' )   )
	{
		$content_css = 'span9 zn_float_right zn_content';
		$sidebar_css = 'sidebar-left';
		$has_sidebar = true;
		$mainbody_css = 'zn_has_sidebar';
	}
	// WE CHECK IF WE HAVE RIGHT SIDEBAR
	elseif ( $meta_fields['page_layout'] == 'right_sidebar' || ( $meta_fields['page_layout'] == 'default' && !empty ( $data['page_sidebar_position'] ) && $data['page_sidebar_position'] == 'right_sidebar' )  )
	{
		$content_css = 'span9 zn_content';
		$sidebar_css = 'sidebar-right ';
		$has_sidebar = true;
		$mainbody_css = 'zn_has_sidebar';
	}
	
	echo '<section id="content">';

	if ( $content_and_sidebar ) { 

		while (have_posts()) : the_post();
		
		ob_start();
		the_content();
		$content = ob_get_clean();

	//	$content = get_the_content();
		//$content_check = apply_filters('the_content', get_the_content());
		if ( !empty($content) || ( isset ( $meta_fields['page_title_show'] ) && $meta_fields['page_title_show'] == 'yes' ) || ( isset ( $meta_fields['content_main_area'] ) && is_array ( $meta_fields['content_main_area'] ) && ( isset( $meta_fields['page_builder_layout'] ) && $meta_fields['page_builder_layout'] == 'style1' ) ) ) {

			$row_margin = 'zn_content_no_margin';
			$row_style = 'row';

			if ( $content || $has_sidebar ) {
				$row_margin = '';
			}

			if ( isset( $meta_fields['page_builder_layout'] ) && $meta_fields['page_builder_layout'] == 'style1' ) {
				$row_style = 'row-fluid zn_def_margin zn_has_sidebar';
			}
		
			echo '<div class="container">';
			
			echo '<div class="mainbody '.$mainbody_css.'">';
			
					echo '<div class="'.$row_style.' '.$row_margin.'">';
					
						echo '<div class="'.$content_css.'">';
					
							// TITLE CHECK
							if ( isset ( $meta_fields['page_title_show'] ) && $meta_fields['page_title_show'] == 'yes' ) {
								echo '<h1 class="page-title">'.get_the_title().'</h1>';
							}
							
							// PAGE CONTENT
							echo $content;

							if ( !empty($data['zn_enable_page_comments']) && $data['zn_enable_page_comments'] == 'yes'  ) {
								?>
								<!-- DISQUS comments block -->
								<div class="disqusForm">
									<?php comments_template(); ?>
								</div>
								<div class="clear"></div>
								<!-- end DISQUS comments block -->
								<?php
							}

/*--------------------------------------------------------------------------------------------------
	START CONTENT AREA 
--------------------------------------------------------------------------------------------------*/
						if ( isset ( $meta_fields['content_main_area'] ) && is_array ( $meta_fields['content_main_area'] ) && ( isset( $meta_fields['page_builder_layout'] ) && $meta_fields['page_builder_layout'] == 'style1' ) ) {
							zn_get_template_from_area ('content_main_area',$post->ID,$meta_fields,true);
						}


						echo '</div>';

						
						// START SIDEBAR OPTIONS
						// WE CHECK IF THIS IS NOT A PAGE FROM THE THEME
						if ( empty ( $meta_fields['page_layout'] ) || empty ( $meta_fields['sidebar_select'] ) ) {
							if ( $data['page_sidebar_position'] == 'left_sidebar' || $data['page_sidebar_position'] == 'right_sidebar' ) {
								echo '<div class="span3">';
									echo '<div id="sidebar" class="sidebar '.$sidebar_css.'">';
										if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($data['page_sidebar']) ) : endif;
									echo '</div>';
								echo '</div>';
							}
						}
						// WE CHECK IF WE HAVE A SIDEBAR SET IN PAGE OPTIONS
						elseif ( ( ( $meta_fields['page_layout'] == 'left_sidebar' || $meta_fields['page_layout'] == 'right_sidebar' ) && $meta_fields['sidebar_select'] != 'default' ) || (  $meta_fields['page_layout'] == 'default' && $data['page_sidebar_position'] != 'no_sidebar' && $meta_fields['sidebar_select'] != 'default' ) ) 
						{ 
								
									echo '<div class="span3">';
										echo '<div id="sidebar" class="sidebar '. $sidebar_css.'">';
											if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar( $meta_fields['sidebar_select'] ) ) : endif;
										echo '</div>';
									echo '</div>';
						}
						// WE CHECK IF WE HAVE A SIDEBAR SET FROM THEME'S OPTIONS
						elseif ( $meta_fields['page_layout'] == 'default' && $data['page_sidebar_position'] != 'no_sidebar' && $meta_fields['sidebar_select'] == 'default' || ( ( $meta_fields['page_layout'] == 'left_sidebar' || $meta_fields['page_layout'] == 'right_sidebar' ) && $meta_fields['sidebar_select'] == 'default' ) ) {
							echo '<div class="span3">';
								echo '<div id="sidebar" class="sidebar '.$sidebar_css.'">';
									if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($data['page_sidebar']) ) : endif;
								echo '</div>';
							echo '</div>';
						}
		
					
					echo '</div>';
			
				echo '</div>';
				
			echo '</div>';
			}
		endwhile;
	}
	
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
			
		
		
	echo '</section><!-- end #content -->';
	
	
?>
				
<?php get_footer(); ?>