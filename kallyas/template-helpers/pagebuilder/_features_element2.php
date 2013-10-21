<?php
/*--------------------------------------------------------------------------------------------------
	Features Element 2
--------------------------------------------------------------------------------------------------*/
 
	function _features_element2( $options )
	{
	
		if ( !empty ( $options['fb_title'] ) ) {
			echo '<div class="span12 feature_box style3">';
			echo '<h4 class="smallm_title centered bigger"><span>'.$options['fb_title'].'</span></h4>';
			echo '</div>';
		}
	
		if ( !empty ( $options['features_single2'] ) && is_array( $options['features_single2'] ) ) {
			
			foreach ( $options['features_single2'] as $feat ) {
				
				echo '<div class="span3 feature_box style3">';
				
					echo '<div class="box">';
					
						echo '<h4 class="title">'.$feat['fb_single_title'].'</h4>';
						echo '<span class="icon '.$feat['fb_single_icon'].'"></span>';
						echo '<p>'.$feat['fb_single_desc'].'</p>';
					
					echo '</div><!-- end box -->';
				
				echo '</div>';
				
			}
			
		}

	}
?>