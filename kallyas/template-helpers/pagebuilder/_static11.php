<?php
/*--------------------------------------------------------------------------------------------------
	STATIC CONTENT - TEXT AND VIDEO
--------------------------------------------------------------------------------------------------*/
 
	function _static11($options)
	{
	
		if ( isset ( $options['ww_header_style'] ) && !empty ( $options['ww_header_style'] ) ) { 
			$style = 'uh_'.$options['ww_header_style'];
		} else { 
			$style = '';
		}
	
	?>
        <div id="slideshow" class="<?php echo $style; ?>">
        
			<div class="bgback"></div>
			<div data-images="<?php echo IMAGES_URL; ?>/" id="sparkles"></div>
		
                <div class="container zn_slideshow">
                	<div class="static-content default-style with-login">
                    	
						<div class="row">
							<div class="span7">
								<?php
									if (!empty($options['ww_slide_title'])) {
										echo '<h2>'.do_shortcode( $options['ww_slide_title'] ).'</h2>';
									}

									if (!empty( $options['ww_slide_subtitle'] )) {
										echo '<h3>'.do_shortcode( $options['ww_slide_subtitle'] ).'</h3>';
									}

									if ( !empty( $options['ww_slide_m_button'] ) && !empty ( $options['ww_slide_l_text'] ) && !empty($options['ww_slide_link']['url']) ) {

										echo '<div class="info_pop animated fadeBoxIn left" data-arrow="top">';
										echo '<a href="'.$options['ww_slide_link']['url'].'" target="'.$options['ww_slide_link']['url'].'" class="buyit">'.$options['ww_slide_l_text'].'</a>';
										echo '<h5 class="text">'.$options['ww_slide_m_button'].'</h5>';
										echo '<div class="clear"></div>';
										echo '</div>';

									}

								?>

							</div>
							<div class="span5">
								<?php
									// Text
									if ( isset ( $options['sc_ec_vid_desc'] ) && !empty ( $options['sc_ec_vid_desc'] ) ) {
										echo '<h5 style="text-align:right;">'.$options['sc_ec_vid_desc'].'</h5>';
									}
									
								
								
									// VIDEO
									if ( isset ( $options['sc_ec_vime'] ) && !empty ( $options['sc_ec_vime'] ) ) {
										echo get_video_from_link ( $options['sc_ec_vime'] ,'black_border full_width' ,'520px','270px');
									}
								?>
							</div>
						</div><!-- end row -->
                        
                    </div><!-- end static content -->
                </div>
			
			<div class="zn_header_bottom_style"></div><!-- header bottom style -->
			
        </div><!-- end slideshow -->
	<?php
	}
?>