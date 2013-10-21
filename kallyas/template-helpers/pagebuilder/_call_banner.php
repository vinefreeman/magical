<?php
/*--------------------------------------------------------------------------------------------------
	Call Out Banner
--------------------------------------------------------------------------------------------------*/
 
	function _call_banner( $options )
	{

			$button = false;
			$div_size = 'span12';
			
			if ( !empty ( $options['cab_button_text'] ) && !empty ( $options['cab_button_link']['url'] ) ) {
				$button = true;
				$div_size = 'span10';
			}
		
			if ( !empty ( $options['cab_main_title'] ) || !empty ( $options['cab_sec_title'] ) ) {
				
				echo '<div class="'.$div_size.'">';
			
				if ( !empty ( $options['cab_main_title'] ) ) {
					echo '<h3 class="m_title" style="margin-top:25px;">'.$options['cab_main_title'].'</h3>';
				}
				
				if ( !empty ( $options['cab_sec_title'] ) ) {
					echo '<p>'.$options['cab_sec_title'].'</p>';
				}
				
				echo '</div>';
				
			}
			
			if ( $button ) {
				echo '<div class="span2">';
				
					echo '<a href="'.$options['cab_button_link']['url'].'" class="circlehover with-symbol" data-size="" data-position="top-left" data-align="right" target="'.$options['cab_button_link']['target'].'">';
						echo '<span class="text">'.$options['cab_button_text'].'</span>';
						if ( !empty ( $options['cab_button_image'] ) ) {
							echo '<span class="symbol"><img src="'.$options['cab_button_image'].'" alt=""></span>';
						}
						else {
							echo '<span class="symbol"><img src="'.MASTER_THEME_DIR.'/images/ok.png" alt=""></span>';
						}
					echo '</a>';
				echo '</div>';
			}

	}
?>