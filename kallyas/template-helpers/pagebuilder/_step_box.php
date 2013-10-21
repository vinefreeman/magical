<?php
/*--------------------------------------------------------------------------------------------------
	STEPS BOX
--------------------------------------------------------------------------------------------------*/
 
	function _step_box($options)
	{
	?>
		<div class="span12">
			<div class="process_steps fixclear">
				<div class="step intro">
				<?php
					if ( !empty ( $options['stp_title'] ) || !empty ( $options['stp_subtitle'] ) ) {
						
						echo '<h3>';
						// TITLE
						if ( !empty ( $options['stp_title'] ) ) {
							echo $options['stp_title'];
						}
						// TITLE
						if ( !empty ( $options['stp_subtitle'] ) ) {
							echo '<strong>'.$options['stp_subtitle'].'</strong>';
						}
						echo '</h3>';

					}
					
					// CONTENT
					if ( !empty ( $options['stp_desc'] ) ) {
						if (preg_match('%(<p[^>]*>.*?</p>)%i', $options['stp_desc'], $regs)) {
							echo $options['stp_desc'];
						} else {
							echo '<p>'.$options['stp_desc'].'</p>';
						}
					}
					
					if ( !empty (  $options['stp_text_link'] ) && !empty ( $options['stp_link']['url'] ) ) {
						echo '<a href="'.$options['stp_link']['url'].'" target="'.$options['stp_link']['target'].'">'.$options['stp_text_link'].' +</a>';
					}
					
				?>
					
					
				</div><!-- end step -->
				
				<?php
					if ( !empty ( $options['steps_single'] ) && is_array ( $options['steps_single'] ) ) {
					
						$i = 1;
					
						foreach ( $options['steps_single'] as $step ) {
						
							echo '<div class="step step'.$i.'">';
								
								$animation = $step['stp_single_anim'];
								
								// ICON AND ANIMATION
								if ( !empty ( $step['stp_single_icon'] ) ) {
									echo '<div class="icon" data-animation="'.$animation.'">';
										echo '<img src="'.$step['stp_single_icon'].'" alt="">';
									echo '</div>';
								}
								
								// STEP TITLE
								if ( !empty ( $step['stp_single_title'] ) ) {
									echo '<h3>'.$step['stp_single_title'].'</h3>';
								}
								
								// STEP CONTENT
								if ( !empty ( $step['stp_single_desc'] ) ) {
									if (preg_match('%(<p[^>]*>.*?</p>)%i', $step['stp_single_desc'], $regs)) {
										echo $step['stp_single_desc'];
									} else {
										echo '<p>'.$step['stp_single_desc'].'</p>';
									}
								}
								
							echo '</div>';

							
							if ( $i == 3 ) { $i = 0;}
							$i++;
							
						}
					}
				?>
				
			</div>

		</div>
	<?php
	}
?>