<?php
/*--------------------------------------------------------------------------------------------------
	CIRCULAR CONTENT STYLE 1
--------------------------------------------------------------------------------------------------*/
 
	function _circ2($options)
	{
	
		global $data;

		$responsive_check = 'zn_responsive';
		if ( $data['zn_responsive'] == 'no' ) {
			$responsive_check = 'zn_not_responsive';
		}

		if ( isset ( $options['ww_header_style'] ) && !empty ( $options['ww_header_style'] ) ) { 
			$style = 'uh_'.$options['ww_header_style'];
		} else { 
			$style = '';
		}
	
	?>
        <div id="slideshow"  class="<?php echo $style; ?>">
		
			<div class="bgback"></div>
			<div data-images="<?php echo IMAGES_URL; ?>/" id="sparkles"></div>
		
			<div class="container zn_slideshow <?php echo $responsive_check; ?>">

				<div id="ca-container" class="ca-container">
                    <div class="ca-wrapper">
                    <?php
						
						if ( isset ( $options['single_circ2'] ) && is_array ( $options['single_circ2'] ) ) {
								
							$i = 1;
							$thumbs = '';
							
							foreach ( $options['single_circ2'] as $slide ) {					

								echo '<div class="ca-item ca-item-'.$i.'">';
							
									echo '<div class="ca-item-main">';
									
										if ( isset ( $slide['ww_slide_image'] ) && !empty ( $slide['ww_slide_image'] ) ) {
										
											echo '<div class="ca-icon">';
												$image = vt_resize( '',$slide['ww_slide_image'] , '376','440', true );
												$bg = 'style="background-image:url('.$image['url'].');"';
												
											echo '</div>';	
										}
									
										echo '<div class="background" '.$bg.'></div><!-- background color -->';
									

									
										// TITle
										if ( isset ( $slide['ww_slide_title'] ) && !empty ( $slide['ww_slide_title'] ) ) {
										
											if ( isset ( $slide['ww_slide_title_left'] ) && !empty ( $slide['ww_slide_title_left'] ) ) {
												$title_pos_l = 'left:'.$slide['ww_slide_title_left'].'px;';
											}
											
											if ( isset ( $slide['ww_slide_title_top'] ) && !empty ( $slide['ww_slide_title_top'] ) ) {
												$title_pos_t = 'top:'.$slide['ww_slide_title_top'].'px;';
											}
										
											echo '<div class="title_circle" style="'.$title_pos_t.' '.$title_pos_l.'" data-size="'.$slide['ww_slide_title_size'].'">';
												echo '<span>'.$slide['ww_slide_title'].'</span>';
											echo '</div>';
										}
									
										// DESC
										if ( isset ( $slide['ww_slide_desc'] ) && !empty ( $slide['ww_slide_desc'] ) ) {
											echo '<h4>'. $slide['ww_slide_desc'].'</h4>';
										}
										
										// DESC
										if ( isset ( $slide['ww_slide_read_text'] ) && !empty ( $slide['ww_slide_read_text'] ) ) {
											echo '<a href="#" class="ca-more">'.$slide['ww_slide_read_text'].' <span class="icon-chevron-right icon-white"></span></a>';
										}
							
										// Bottom Title
										if ( isset ( $slide['ww_slide_bottom_title'] ) && !empty ( $slide['ww_slide_bottom_title'] ) ) {
											echo '<span class="ca-starting">'. $slide['ww_slide_bottom_title'].'</span>';
										}
									
									echo '</div>';
									
									echo '<div class="ca-content-wrapper">';
										echo '<div class="ca-content">';
									
											// Content Title
											if ( isset ( $slide['ww_slide_content_title'] ) && !empty ( $slide['ww_slide_content_title'] ) ) {
												echo '<h6>'.$slide['ww_slide_content_title'].'</h6>';
											}
											
											echo '<a href="#" class="ca-close"><span class="icon-remove"></span></a>';
									
											// Content description
											if ( isset ( $slide['ww_slide_desc_full'] ) && !empty ( $slide['ww_slide_desc_full'] ) ) {
												echo '<div class="ca-content-text">';
												
													echo $slide['ww_slide_desc_full'];
												
												echo '</div>';
											}
									
											// Link
											if ( isset ( $slide['ww_slide_read_text_content'] ) && !empty ( $slide['ww_slide_read_text_content'] ) && isset ( $slide['ww_slide_link']['url'] ) && !empty ( $slide['ww_slide_link']['url'] ) ) {
												echo '<a href="'.$slide['ww_slide_link']['url'].'" target="'.$slide['ww_slide_link']['target'].'">'.$slide['ww_slide_read_text_content'].'</a>';
											}
									
										echo '</div>';
									echo '</div>';
									

							
								echo '</div><!-- end ca-item -->';
							
								$i++;
							
							}
						}
					?>

                    </div><!-- end ca-wrapper -->
                </div><!-- end circular content carousel -->

			</div>
			
			<div class="zn_header_bottom_style"></div><!-- header bottom style -->
			
        </div><!-- end slideshow -->
	<?php

		$contentcarousel = array ( 'zn_contentcarousel' =>
				"	
				jQuery('#ca-container').contentcarousel();
				
				setTimeout(function() {
					jQuery('#ca-container .ca-icon').css('backgroundImage', 'none');
				}, 1000);
				;");
				
		zn_update_array( $contentcarousel );
	
	}
?>