<?php
/*--------------------------------------------------------------------------------------------------
	STEPS BOX 3
--------------------------------------------------------------------------------------------------*/
 
	function _step_box3( $options )
	{
	
		if ( !empty ( $options['stp_title'] ) ) {
			echo '<div class="span12">';
			echo '<h3 class="m_title">'.$options['stp_title'].'</h3>';
			echo '</div>';
		}
	
		if ( !empty ( $options['steps_single3'] ) && is_array ( $options['steps_single3'] ) ) {
		
			$i = 1;
			$all = count( $options['steps_single3'] );
			$cls = '';
			
			foreach ( $options['steps_single3'] as $step ) {
			
				if ( $i % 2 != 0 ) {
					$align = 'left';
				}
				else {
					$align = 'right';
				}
				
				if ( $i == $all ) {
					$cls = 'last';
				}
				  
				echo '<div class="process_box span12 '.$cls.'" data-align="'.$align.'">';
			
					echo '<div class="number"><span>';
						
						if ( $i < 10 ) {
							echo '0'.$i;
						}
						else {
							echo $i;
						}
					
					echo '</span></div>';
			
					echo '<div class="content">';
						// STEP CONTENT
						if ( !empty ( $step['stp_single_desc'] ) ) {
							if (preg_match('%(<p[^>]*>.*?</p>)%i', $step['stp_single_desc'], $regs)) {
								echo $step['stp_single_desc'];
							} else {
								echo '<p>'.$step['stp_single_desc'].'</p>';
							}
						}
					echo '</div>';
					echo '<div class="clear"></div>';
				echo '</div>';

				$i++;
				
			}
		}

	}
?>