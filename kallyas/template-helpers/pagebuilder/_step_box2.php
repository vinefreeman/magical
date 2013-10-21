<?php
/*--------------------------------------------------------------------------------------------------
	STEPS BOX 2
--------------------------------------------------------------------------------------------------*/
 
	function _step_box2( $options )
	{
	
		if ( !empty ( $options['stp_title'] ) ) {
			echo '<div class="span12">';
			echo '<h3 class="m_title">'.$options['stp_title'].'</h3>';
			echo '</div>';
		}
	
		if ( !empty ( $options['steps_single2'] ) && is_array ( $options['steps_single2'] ) ) {
		
			$i = 1;
			$count = count( $options['steps_single2'] );
		
			foreach ( $options['steps_single2'] as $step ) {
			
				if ( $i % 3 == 1 ){
					echo '<div class="row-fluid zn_photo_gallery">';
				}


				$ok = '';
				$image = '';
			
				if ( $step['stp_single_ok'] == 'yes' ) {
					$ok = 'ok';
					$image = '<img src="'.MASTER_THEME_DIR.'/images/ok.png" alt="">';
				}
			
				echo '<div class="span4">';
					
					echo '<div class="gobox '.$ok.'">';
					
					echo $image;	
						
					if ( !empty ( $step['stp_single_title'] ) ) {
						echo '<h4>'.$step['stp_single_title'].'</h4>';
					}
					
					if ( !empty ( $step['stp_single_link']['url'] ) ) {
						echo '<a class="zn_step_link" href="'.$step['stp_single_link']['url'].'" target="'.$step['stp_single_link']['target'].'"></a>';
					}					

					

					if ( !empty ( $step['stp_single_desc'] ) ) {
						echo '<p>'.$step['stp_single_desc'].'</p>';
					}

					echo '</div>';
					
				echo '</div>';

				if ( $i % 3 == 0 || $i == $count ){
					echo '</div>';
				}

				$i++;
				
				
			}
		}

	}
?>