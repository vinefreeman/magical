<?php
/*--------------------------------------------------------------------------------------------------
	STATIC CONTENT - Video
--------------------------------------------------------------------------------------------------*/
 
	function _static3($options)
	{
	
		if ( isset ( $options['ww_header_style'] ) && !empty ( $options['ww_header_style'] ) ) { 
			$style = 'uh_'.$options['ww_header_style'];
		} else { 
			$style = '';
		}

		if ( !empty($options['ww_height'])) {
			$height = 'style="height:'.$options['ww_height'].'px;"';
		}
	
	?>
        <div id="slideshow" <?php echo $height;?> class="<?php echo $style; ?>">
        
			<div class="bgback"></div>
			<div data-images="<?php echo IMAGES_URL; ?>/" id="sparkles"></div>
		
			<div class="zn_slideshow">
                <div class="container">
                	<div class="static-content video-style">
					<?php
						// TITLE
						if ( isset ( $options['ww_slide_title'] ) && !empty ( $options['ww_slide_title'] ) ) {
							echo '<h3 class="centered">'.do_shortcode($options['ww_slide_title']).'</h3>';
						}
						
						// VIDEO
						if ( isset ( $options['ww_slide_video'] ) && !empty ( $options['ww_slide_video'] ) ) {
							
							echo '<div class="video_trigger_container">';
								echo '<a class="playVideo" data-rel="prettyPhoto" href="'.$options['ww_slide_video'].'"></a>';
								echo $options['ww_slide_video_text'];
							echo '</div>';
							
							
						}
						
					?>
                    </div><!-- end static-content -->
                </div>
			</div>
			
			<div class="zn_header_bottom_style"></div><!-- header bottom style -->
			
        </div><!-- end slideshow -->
	<?php
	}
?>