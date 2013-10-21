<?php
/*--------------------------------------------------------------------------------------------------
	Stats Box
--------------------------------------------------------------------------------------------------*/
 
	function _stats_box ( $options )
	{
	
		
		$element_size = zn_get_size( $options['_sizer'] );
		
		echo '<div class="'.$element_size['sizer'].' zn_stats_box">';
		
			echo '<div class="row-fluid zn_content_no_margin">';
				echo '<div class="'.$element_size['sizer'].' zn_stats_box">';
				
					echo '<h3 class="mb_title"><span class="'.$options['vts_tab_icon'].' icon-dark"></span> '.$options['stb_title'].'</h3>';
				
				echo '</div>';
			echo '</div>';
		
			if ( !empty ( $options['single_stats'] ) && is_array ( $options['single_stats'] ) ) {
				echo '<div class="row-fluid zn_content_no_margin">';
				foreach ( $options['single_stats'] as $stat ) {
					echo '<div class="span3">';
					
						echo '<div class="statbox">';
						
							if ( !empty ( $stat['sb_icon'] ) ) {
								echo '<img src="'.$stat['sb_icon'].'" alt="">';
							}
							
							echo '<h4>'.$stat['sb_title'].'</h4>';
							
							echo '<h6>'.$stat['sb_content'].'</h6>';
						
						echo '</div>';
					
					echo '</div>';
					
				}
				echo '</div>';
			}
		
		echo '</div>';

	}
?>