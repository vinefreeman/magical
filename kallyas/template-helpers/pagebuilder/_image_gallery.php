<?php
/*--------------------------------------------------------------------------------------------------
	Image Gallery
--------------------------------------------------------------------------------------------------*/
 
	function _image_gallery( $options )
	{
	
		$element_size = zn_get_size( 'one-third' );
	
		if ( !empty ( $options['ig_title'] ) ) {
			echo '<div class="span12">';
			echo '<h4 class="smallm_title centered bigger"><span>'.$options['ig_title'].'</span></h4>';
			echo '</div>';
		}
	
		if ( !empty ( $options['single_ig'] ) && is_array( $options['single_ig'] ) ) {
			
			$count = count( $options['single_ig'] );
			$i = 1;

			foreach ( $options['single_ig'] as $image_arr ) {
			
				if ( $i % 3 == 1 ){
					echo '<div class="row-fluid zn_photo_gallery">';
				}

				if ( !empty ( $image_arr['sig_image'] ) ) {
			
					$image = vt_resize( '', $image_arr['sig_image']  , $element_size['width'],'' , true );
			
					echo '<div class="span4">';
						echo '<a href="'.$image_arr['sig_image'].'" class="hoverBorder" rel="prettyPhoto"><img src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" alt=""></a>';
					echo '</div>';
					
				}

				
				
				if ( $i % 3 == 0 || $i == $count ){
					echo '</div>';
				}

				$i++;

			}
			
		}
		
		echo '<div class="clear"></div>';
	
	

	}
?>