<?php
/*--------------------------------------------------------------------------------------------------
	TEXT BOX
--------------------------------------------------------------------------------------------------*/
 
	function _text_box( $options )
	{
	
		
		$element_size = zn_get_size( $options['_sizer'] );
		
		echo '<div class="'.$element_size['sizer'].'">';
		if ( $options['stb_style'] == 'style2' && !empty($options['stb_title'])) {
			echo '<h3>'.$options['stb_title'].'</h3>';
		}
		elseif($options['stb_style'] == 'style1' && !empty($options['stb_title'])) {
			echo '<h4 class="m_title">'.$options['stb_title'].'</h4>';
		}
		
		if ( !empty ( $options['stb_content'] ) )  {
			if (preg_match('%(<[^>]*>.*?</)%i', $options['stb_content'], $regs)) {
				echo do_shortcode ( $options['stb_content'] );
			} else {
				echo '<p>'.do_shortcode ( $options['stb_content'] ).'</p>';
			}
		}	

			
		echo '</div>';
	}
?>