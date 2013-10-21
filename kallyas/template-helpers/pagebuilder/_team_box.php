<?php
/*--------------------------------------------------------------------------------------------------
	Team Box
--------------------------------------------------------------------------------------------------*/
 
	function _team_box( $options )
	{
	
		
		$element_size = zn_get_size( $options['_sizer'] );
		$c_title = '';
	
		echo '<div class="'.$element_size['sizer'].'">';
		
			echo '<div class="team_member">';
			
				$link_start = '<a href="#" >';
				$link_end = '</a>';
				$image = '';
					
				if ( !empty ( $options['teb_link']['url'] ) ) {
					$link_start = '<a href="'.$options['teb_link']['url'].'" target="'.$options['teb_link']['target'].'" class="grayHover">';
					$link_end = '</a>';
				}
				


				// Check to see if we have an image
				if ( $slide_image = $options['teb_image'] ) {

					$saved_alt = 'alt="'.strip_tags($options['teb_name']).'"';
					$saved_title = 'title="'.strip_tags($options['teb_name']).'"';

					if ( is_array($slide_image) ) {

						if ( $saved_image = $slide_image['image'] ) {
							
							// Image alt
							if ( !empty( $slide_image['alt'] ) ){
								$saved_alt = 'alt="'.$slide_image['alt'].'"';
							}

							// Image title
							if ( !empty( $slide_image['title'] ) ){
								$saved_title = 'title="'.$slide_image['title'].'"';
							}

							$image = vt_resize( '', $saved_image  , 270,270 , true );
							$image = '<img src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" '.$saved_alt.' '.$saved_title.'/>';
						}

					}
					else {
						$saved_image = $slide_image;
						$image = vt_resize( '', $saved_image  , 270,270 , true );
						$image = '<img src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" '.$saved_alt.' '.$saved_title.'/>';

					}
				}
				
				// IMAGE
				echo $link_start;
					echo $image;
				echo $link_end;
				
				// NAME AND POSITION
				echo '<h4>'.$options['teb_name'].'</h4>';
				echo '<h6>'.$options['teb_position'].'</h6>';
			
				echo '<div class="details">';
	
				// DESCRIPTION
				if ( !empty ( $options['teb_desc'] ) ) {
					echo '<div class="desc">';
					
						if (preg_match('%(<p[^>]*>.*?</p>)%i', $options['teb_desc'], $regs)) {
							echo $options['teb_desc'];
						} else {
							echo '<p>'.$options['teb_desc'].'</p>';
						}
					
					echo '</div>';
				}
					
				// SOCIAL ICONS
				if ( !empty ( $options['single_team_social'] ) && is_array ( $options['single_team_social'] ) && !empty( $options['single_team_social'][0]['teb_social_icon'] ) ) {
				
					echo '<ul class="social-icons colored fixclear">';
					
					foreach ( $options['single_team_social'] as $icon ) {
						
						
						echo '<li class="'.$icon['teb_social_icon'].'"><a href="'.$icon['teb_social_link']['url'].'" target="'.$icon['teb_social_link']['target'].'">'.$icon['teb_social_title'].'</a></li>';
						
					}
					
					echo '</ul>';
					
				}
					
					
				echo '</div><!-- end details -->';
			
			echo '</div><!-- end team_member -->';
								
		echo '</div>';							
	}
?>