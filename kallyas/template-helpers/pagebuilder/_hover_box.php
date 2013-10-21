<?php
/*--------------------------------------------------------------------------------------------------
	Hover Box
--------------------------------------------------------------------------------------------------*/
 
	function _hover_box ( $options )
	{
	
		
		$element_size = zn_get_size( $options['_sizer'] );
		$content = '';
		
		$cls = 'margin-top:10px;';
		

		echo '<div class="'.$element_size['sizer'].'">';
		echo '<a href="'.$options['hb_link']['url'].'" target="'.$options['hb_link']['target'].'" class="hover-box '.$options['hb_align'].' fixclear">';
		
		if ( !empty ( $options['hb_icon'] ) ) {
			echo '<img src="'.$options['hb_icon'].'" alt="">';
		}
		
		if ( !empty ( $options['hb_desc'] ) ) {
			$content = '<p>'.$options['hb_desc'].'</p>';
			$cls = '';
		}		
		echo '<h3 style="'.$cls.'">'.$options['hb_title'].'</h3>';
		echo '<h4>'.$options['hb_subtitle'].'</h4>';
		
		echo $content;
		
		echo '</a>';
		echo '</div>';

	}
?>