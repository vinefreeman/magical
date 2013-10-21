<?php
/*--------------------------------------------------------------------------------------------------
	VERTICAL TABS
--------------------------------------------------------------------------------------------------*/
 
	function _vertical_tabs( $options )
	{
	
		
		$element_size = zn_get_size( $options['_sizer'] );
		
		echo '<div class="'.$element_size['sizer'].'">';
		
			echo '<div class="vertical_tabs">';
			
				echo '<div class="tabbable">';
					
					if ( !empty ( $options['single_vertical_tab'] ) && is_array( $options['single_vertical_tab'] ) ) {
					
						echo '<ul class="nav fixclear">';
					
						$i = 1;
						$content = '';
						
						foreach ( $options['single_vertical_tab'] as $tab ) {
							
							$cls = '';
							$icon = '';
							
							if ( $i == 1 ) {
								$cls = 'active';
							}
							
							$uniq_name = $i . uniqid();

							// ICON CHECK
							if ( !empty ( $tab['vts_tab_icon'] ) ) {
								$icon = '<span><span class="'.$tab['vts_tab_icon'].' icon-white"></span></span>';
							}
						
							// Tab Handle
							echo '<li class="'.$cls.'">';
								echo '<a href="#tabs_v2-pane'.$uniq_name.'" data-toggle="tab">';
									echo $icon;
									echo $tab['vts_tab_title'];
								echo '</a>';
								
							echo '</li>';
							
							// TAB CONTENT
							$content .= '<div class="tab-pane '.$cls.'" id="tabs_v2-pane'.$uniq_name.'">';
							
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
		
		echo '</div>';
		
	}
?>