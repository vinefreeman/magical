<?php
/*--------------------------------------------------------------------------------------------------
	STATIC CONTENT - Text Pop
--------------------------------------------------------------------------------------------------*/
 
	function _static5($options)
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
                	<div class="static-content textpop-style">
					<?php
					
						echo '<div class="texts">';
						// Line 1
						if ( !empty ( $options['sc_pop_line1'] ) ) {
							echo '<span class="line1">'.$options['sc_pop_line1'].'</span>';
						}
						
						// Line 2
						if ( !empty ( $options['sc_pop_line2'] ) ) {
							echo '<span class="line2">'.$options['sc_pop_line2'].'</span>';
						}
						
						// Line 3
						if ( !empty ( $options['sc_pop_line3'] ) ) {
							echo '<span class="line3">'.$options['sc_pop_line3'].'</span>';
						}
						
						// Line 4
						if ( !empty ( $options['sc_pop_line4'] ) ) {
							echo '<span class="line4">'.$options['sc_pop_line4'].'</span>';
						}
						
						echo '</div>';

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
                    </div><!-- end static-content -->
                </div>
			</div>
			
			<div class="zn_header_bottom_style"></div><!-- header bottom style -->
			
        </div><!-- end slideshow -->
	<?php
	}
?>