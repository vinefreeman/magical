<?php
/*--------------------------------------------------------------------------------------------------
	CSS3 Panels
--------------------------------------------------------------------------------------------------*/

	function _css_pannel($options)
	{
	?>
        <div id="slideshow" class="">
			
			<div id="css3panels" style="height:<?php echo $options['css_height'];?>px">
				<div id="loading"></div>
								
				<?php
					//print_r($options);
					if ( isset ( $options['single_css_panel'] ) && is_array ( $options['single_css_panel'] ) ) {
						
						$i = 1;
						$all = count ( $options['single_css_panel'] );
						
						
						
						foreach ( $options['single_css_panel'] as $panel ) {
							
							$width = 100/$all;
							
							$panel_position ='';
							$style = '';
							
							if ( $i == 1 ) {
								$first = 'first';
								$width = $width+3;
								
							} else { $first =''; }
							
							if ( $i == $all ) {
								$last = 'last';
								$width = $width+4;
								
							} else { $last =''; }
							
							echo '<div class="panel panel'.$i.' '.$first.' '.$last.'" style="'.$style.'width:'.$width.'%;">';
								echo '<div class="inner-panel">';
									
									// Panel Image
									if ( isset ( $panel['panel_image'] ) && !empty ( $panel['panel_image'] ) ) {
										echo '<img src="'.$panel['panel_image'].'" alt="" class="main_image">';
									}
									
									// Panel Position
									if ( isset ( $panel['panel_title_position'] ) && !empty ( $panel['panel_title_position'] ) ) {
										$panel_position = $panel['panel_title_position'];
									}
									
									// Panel Title
									if ( isset ( $panel['panel_title'] ) && !empty ( $panel['panel_title'] ) ){
										echo '<div class="caption '.$panel_position.'">';
											echo '<h3 class="title">'.$panel['panel_title'].'</h3>';
										echo '</div>';
									}
									
								echo '</div>';
							echo '</div>';
							
							$i++;
						}
						
					}
					
				?>

			</div><!-- end panels -->
			<div class="clear"></div>
			
        </div><!-- end slideshow -->
	<?php
	}

	// Load JS and CSS
	wp_enqueue_style('css3_panels');
	wp_enqueue_script('css3_panels');

?>