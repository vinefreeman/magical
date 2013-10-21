<?php get_header(); ?>
<?php

	if ( is_home() ) {
		$blog_page_id = get_option( 'page_for_posts' );
		global $wp_query;
		$meta_fields = get_post_meta($blog_page_id, 'zn_meta_elements', true);
		$meta_fields = maybe_unserialize($meta_fields);
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
		if ( $data['archive_sidebar_position'] == 'left_sidebar' ) {
			$content_css = 'span9 zn_float_right zn_content';
			$sidebar_css = 'sidebar-left';
			$has_sidebar = true;
			$mainbody_css = 'zn_has_sidebar';
		}
		elseif ( $data['archive_sidebar_position'] == 'right_sidebar' ) {
			$content_css = 'span9 zn_content';
			$sidebar_css = 'sidebar-right';
			$has_sidebar = true;
			$mainbody_css = 'zn_has_sidebar';
		}
	}	
	// WE CHECK IF WE HAVE LEFT SIDEBAR
	elseif ( $meta_fields['page_layout'] == 'left_sidebar' || ( $meta_fields['page_layout'] == 'default' && !empty ( $data['archive_sidebar_position'] ) && $data['archive_sidebar_position'] == 'left_sidebar' )   )
	{
		$content_css = 'span9 zn_float_right zn_content';
		$sidebar_css = 'sidebar-left';
		$has_sidebar = true;
		$mainbody_css = 'zn_has_sidebar';
	}
	// WE CHECK IF WE HAVE RIGHT SIDEBAR
	elseif ( $meta_fields['page_layout'] == 'right_sidebar' || ( $meta_fields['page_layout'] == 'default' && !empty ( $data['archive_sidebar_position'] ) && $data['archive_sidebar_position'] == 'right_sidebar' )  )
	{
		$content_css = 'span9 zn_content';
		$sidebar_css = 'sidebar-right ';
		$has_sidebar = true;
		$mainbody_css = 'zn_has_sidebar';
	}
	
?>

	<section id="content">
		<div class="container">
			
			<div id="mainbody <?php echo $mainbody_css;?>">
				
			<?php	

				$columns = 1;

				if ( !empty( $data['blog_style_layout'] ) ) {

					$columns = $data['blog_style_layout'];

				}

				if ( $columns > 1 ) {
					get_template_part( 'blog', 'columns' );
				}
				else {
					get_template_part( 'blog', 'default' );
				}
			?>
				
			</div><!-- end mainbody -->
			
		</div><!-- end container -->
<?php	
/*--------------------------------------------------------------------------------------------------
	START CONTENT AREA 
--------------------------------------------------------------------------------------------------*/
	if ( isset ( $meta_fields['content_main_area'] ) && is_array ( $meta_fields['content_main_area'] ) ) {
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
	</section><!-- end content -->

<?php get_footer(); ?>