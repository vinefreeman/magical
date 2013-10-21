<?php
/*--------------------------------------------------------------------------------------------------
	HISTORIC EVENTS
--------------------------------------------------------------------------------------------------*/
 
	function _historic( $options )
	{
	
		echo '<div class="span12 timeline_bar">';
		echo '<div class="row">';
		
			echo '<div class="span12 end_timeline"><span>'.$options['he_start'].'</span></div>';
		
			if ( !empty ( $options['historic_single'] ) && is_array ( $options['historic_single'] ) ) {
			
				$i=1;
			
				foreach ( $options['historic_single'] as $event ) {
				
					$pos = '<div class="span6">';
					
					if ( $i % 2 != 0 ) {
						$pos = '<div class="span6 offset6" data-align="right">';
					}
				
					echo $pos;
						echo '<div class="timeline_box">';
						
							echo '<div class="date">'.$event['she_event_date'].'</div>';
							echo '<h4 class="htitle">'.$event['she_event_name'].'</h4>';
							
							if (preg_match('%(<p[^>]*>.*?</p>)%i', $event['she_event_desc'], $regs)) {
								echo do_shortcode ( $event['she_event_desc'] );
							} else {
								echo '<p>'.do_shortcode ( $event['she_event_desc'] ).'</p>';
							}
						
						echo '</div><!-- end timeline box -->';
					echo '</div>';
					
					$i++;
				}
				
			}
			
		echo '<div class="span12 end_timeline">';
			echo '<span>'.__("PRESENT",THEMENAME).'</span>';
		echo '</div>';
		
		echo '</div><!-- end timeline bar -->';
		echo '</div>';

	}
?>