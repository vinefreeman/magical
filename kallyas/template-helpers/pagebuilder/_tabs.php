<?php
/*--------------------------------------------------------------------------------------------------
	HORIZONTAL TABS
--------------------------------------------------------------------------------------------------*/
 
	function _tabs( $options )
	{
	
		
		$element_size = zn_get_size( $options['_sizer'] );
		
		echo '<div class="'.$element_size['sizer'].'">';
		

			
				echo '<div class="tabbable tabs_style1">';
					
					if ( !empty ( $options['single_horizontal_tab'] ) && is_array( $options['single_horizontal_tab'] ) ) {
					
						echo '<ul class="nav fixclear">';
					
						$i = 1;
						$content = '';
						
						foreach ( $options['single_horizontal_tab'] as $tab ) {
							
							$cls = '';

							if ( $i == 1 ) {
								$cls = 'active';
							}

							$uniq_name = $i . uniqid();

							// Tab Handle
							echo '<li class="'.$cls.'">';
								echo '<a href="#tabs_i2-pane'.$uniq_name.'" data-toggle="tab">';

									echo $tab['vts_tab_title'];
								echo '</a>';
								
							echo '</li>';
							
							// TAB CONTENT
							$content .= '<div class="tab-pane '.$cls.'" id="tabs_i2-pane'.$uniq_name.'">';
							
								$content .= '<h4>'.$tab['vts_tab_c_title'].'</h4>';
							
								if (preg_match('%(<p[^>]*>.*?</p>)%i', $tab['vts_tab_c_content'], $regs)) {
									$content .= $tab['vts_tab_c_content'];
								} else {
									$content .= '<p>'.$tab['vts_tab_c_content'].'</p>';
								}
							
							$content .= '</div>';
					
							$i++;
						}
						
						echo '</ul>';
						
						echo '<div class="tab-content">';
						
							echo do_shortcode($content);
						
						echo '</div>';
					}
					

					
				echo '</div>';
				
		
		echo '</div>';
		
	}
?>