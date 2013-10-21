<?php
/*--------------------------------------------------------------------------------------------------
	STATIC CONTENT - Video Background
--------------------------------------------------------------------------------------------------*/
 
	function _static8($options)
	{
	?>
        <div id="slideshow" class="gradient">
        		
                <div class="video-container">
				
				<?php
					
					if ( $options['sc_vb_video_type'] == 'self' ) { 
						echo '<video autoplay class="video" loop id="the-video"> ';
							
							if ( !empty ( $options['sc_vb_sh_video1'] ) ) { 
								echo  '<source src="'.$options['sc_vb_sh_video1'].'"/> ';
							} 	
							
							if ( !empty ( $options['sc_vb_sh_video2'] ) ) { 
								echo  '<source src="'.$options['sc_vb_sh_video2'].'" type=\'video/ogg; codecs="theora, vorbis"\'/> ';
							} 
							
							if ( !empty ( $options['sc_vb_sh_video_cover'] ) ) { 
								echo  '<img src="'.$options['sc_vb_sh_video_cover'].'"> ';
							} 
							
						echo '</video>';
					}
					elseif ( $options['sc_vb_video_type'] == 'iframe' && !empty ( $options['sc_vb_embed'] ) ){
						echo  get_video_from_link( $options['sc_vb_embed'] ,'' , '400','600');
					}
					
					echo '<div class="captions">';
					
						if ( !empty ( $options['sc_vb_line1'] ) ) { 
							echo  '<span class="line">'.do_shortcode($options['sc_vb_line1']).'</span>';
						} 
					
						if ( !empty ( $options['sc_vb_line2'] ) ) { 
							echo  '<span class="line">'.do_shortcode($options['sc_vb_line2']).'</span>';
						} 
					
					echo '</div>';
					
					
				?>
				
                </div>
                
        </div><!-- end slideshow -->
	<?php
	}
?>