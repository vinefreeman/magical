<?php

/*--------------------------------------------------------------------------------------------------
	Limited Offers
--------------------------------------------------------------------------------------------------*/
	function _video_box( $options )
	{
		$element_size = zn_get_size( $options['_sizer'] );
	?>
		<div class="<?php echo $element_size['sizer']; ?>">
		
		<?php
			
			if ( !empty ( $options['vb_video_image'] ) && !empty ( $options['vb_video_url'] ) ) {
				
				echo '<div class="adbox video">';
					$image = vt_resize( '', $options['vb_video_image'] , $element_size['width'],'' , true );
					echo '<img src="'.$image['url'].'" alt="">';
						echo '<div class="video_trigger_container">';
							echo '<a class="playVideo" data-rel="prettyPhoto" href="'.$options['vb_video_url'].'?width=80%&amp;height=80%"></a>';
							echo $options['vb_video_title'];
						echo '</div>';
				echo '</div>';
				
			}
			else {
				
				if ( !empty ( $options['vb_video_url'] ) ) {

					if ( !empty( $options['vb_video_title'] ) ){
						echo '<h4 class="m_title">'.$options['vb_video_title'].'</h4>';
					}

					echo get_video_from_link($options['vb_video_url'], '',$element_size['width'],$element_size['height']);
				}
				
			}
		
		?>

		</div>
	<?php
	}

?>