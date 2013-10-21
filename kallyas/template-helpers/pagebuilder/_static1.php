<?php
/*--------------------------------------------------------------------------------------------------
	STATIC CONTENT - Default
--------------------------------------------------------------------------------------------------*/
 
	function _static1($options)
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
		
			<div class="zn_slideshow">
                <div class="container">
                	<div class="static-content default-style">
					<?php
						// TITLE
						if ( isset ( $options['ww_slide_title'] ) && !empty ( $options['ww_slide_title'] ) ) {
							echo '<h2 class="centered">'.do_shortcode($options['ww_slide_title']).'</h2>';
						}
						
						// SUBTITLE
						if ( isset ( $options['ww_slide_subtitle'] ) && !empty ( $options['ww_slide_subtitle'] ) ) {
							echo '<h3 class="centered">'.do_shortcode($options['ww_slide_subtitle']).'</h3>';
						}
						
						// BUTTON
						if ( $options['ww_slide_m_button'] || $options['ww_slide_l_text'] ) {
							echo '<div class="info_pop animated fadeBoxIn" data-arrow="top">';
								
								if ( $options['ww_slide_l_text'] && isset ( $options['ww_slide_link']['url'] ) && !empty ( $options['ww_slide_link']['url'] ) ) {
									echo '<a class="buyit" href="'.$options['ww_slide_link']['url'].'" target="'.$options['ww_slide_link']['target'].'">'.$options['ww_slide_l_text'].'</a>';
								}
							
								// BUTTON LEFT TEXT
								if ( isset ( $options['ww_slide_m_button'] ) && !empty ( $options['ww_slide_m_button'] ) ) {
									echo '<h5 class="text">'.$options['ww_slide_m_button'].'</h5>';
								}
								
								echo '<div class="clear"></div>';
							echo '</div>';
						}
						
					?>
					
                        
                    </div>
                </div>
			</div>
			
			<div class="zn_header_bottom_style"></div><!-- header bottom style -->
			
        </div><!-- end slideshow -->
	<?php
	}
?>