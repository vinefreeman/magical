<?php
/*--------------------------------------------------------------------------------------------------
	Info Box
--------------------------------------------------------------------------------------------------*/
 
	function _infobox( $options )
	{
	
		
		$element_size = zn_get_size( $options['_sizer'] );
		
		
		// LINK
		$link = '';
		if ( !empty ( $options['ib_button_text'] ) && !empty ( $options['ib_button_link']['url'] ) ) {
			$link = '<a href="'.$options['ib_button_link']['url'].'" target="'.$options['ib_button_link']['target'].'" class="btn btn-large btn-inverse">'.$options['ib_button_text'].'</a>';
		}
		
		
		echo '<div class="'.$element_size['sizer'].'">';
			
			echo '<div class="'.$options['ib_style'].'">';
				
				if ( $options['ib_style'] == 'infobox2' ) { echo $link; }
				
				// TITLE
				if ( !empty ( $options['ib_title'] ) ) {
					echo '<h3 class="m_title">'.$options['ib_title'].'</h3>';
				}
				
				// SUBTITLE
				if ( !empty ( $options['ib_subtitle'] ) ) {
					if (preg_match('%(<p[^>]*>.*?</p>)%i', $options['ib_subtitle'], $regs)) {
						echo $options['ib_subtitle'];
					} else {
						echo '<p>'.$options['ib_subtitle'].'</p>';
					}
				}
				
				if ( $options['ib_style'] == 'infobox1' ) { echo $link; }

			echo '</div>';
			
		echo '</div>';

	}
?>