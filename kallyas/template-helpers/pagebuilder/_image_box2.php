<?php
/*--------------------------------------------------------------------------------------------------
	Images Box 2
--------------------------------------------------------------------------------------------------*/
	function _image_box2( $options )
	{
	
		if ( !empty ( $options['image_box_title'] ) ) {
		
			echo '<div class="span12 offer-banners">';
			echo '<h3 class="m_title">'.$options['image_box_title'].'</h3>';
			echo '</div>';
		}
	
		if ( !empty ( $options['ib2_single'] ) && is_array( $options['ib2_single'] ) ) {
			
			foreach ( $options['ib2_single'] as $simage ) {
				
				if ( $slide_image = $simage['ib2_image'] ) {
				
					if ( is_array($slide_image) ){

						// Get the saved image
						$saved_image = $slide_image['image'];

						if ( !empty( $slide_image['alt'] ) ){
							$saved_alt = 'alt="'.$slide_image['alt'].'"';
						}
						else {
							$saved_alt = '';
						}
						if ( !empty( $slide_image['title'] ) ){
							$saved_title = 'title="'.$slide_image['title'].'"';
						}
						else {
							$saved_title = '';
						}
					}
					else {
						$saved_image = $slide_image;
						$saved_alt = '';
						$saved_title = '';
					}

					echo '<div class="'.$simage['ib2_width'].' offer-banners">';
					
						$element_size = zn_get_size( $simage['ib2_width'] );
						$image = vt_resize( '', $saved_image  , $element_size['width'],'' , true );
						$link_start = '<a href="#" class="hoverBorder">';
						$link_end = '</a>';
						
						if ( !empty ( $simage['ib2_link']['url'] ) ) {
							$link_start = '<a href="'.$simage['ib2_link']['url'].'" target="'.$simage['ib2_link']['target'].'" class="hoverBorder">';
							$link_end = '</a>';
						}
						
						echo $link_start;
							
							echo '<img src="'.$image['url'].'" height="'.$image['height'].'" width="'.$image['width'].'" '.$saved_alt.'  '.$saved_title.' />';
						
						echo $link_end;
					
					echo '</div>';
					
				}
			
			}
			
		}

	}
?>