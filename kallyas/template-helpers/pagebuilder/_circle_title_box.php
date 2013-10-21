<?php
/*--------------------------------------------------------------------------------------------------
	Circle Title Box
--------------------------------------------------------------------------------------------------*/
 
	function _circle_title_box( $options )
	{
	
		
		$element_size = zn_get_size( $options['_sizer'] );
		$c_title = '';
	
		echo '<div class="'.$element_size['sizer'].'">';
		
			// TITLE
			if ( !empty ( $options['ctb_circle_title'] ) ) {
				$c_title = '<span>'.$options['ctb_circle_title'].'</span> ';
			}
		
			// TITLE
			if ( !empty ( $options['ctb_main_title'] ) ) {
				echo '<h4 class="circle_title">'.$c_title.''.$options['ctb_main_title'].'</h4>';
			}

			// CONTENT
			if ( !empty ( $options['ctb_content'] ) ) {
				if (preg_match('%(<p[^>]*>.*?</p>)%i', $options['ctb_content'], $regs)) {
					echo do_shortcode($options['ctb_content']);
				} else {
					echo '<p>'.do_shortcode($options['ctb_content']).'</p>';
				}
			}
			
		echo '</div>';
		
		


	}
?>