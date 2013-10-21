<?php

global $data;

?>	
<?php
	if ( empty( $data['footer_show'] ) || (!empty( $data['footer_show'] ) && $data['footer_show'] == 'yes') ) { ?>
	<footer id="footer">
		<div class="container">

			<?php	
				if ( !empty ( $data['footer_row1_widget_positions'] ) ) {
				
					if ( (!empty ( $data['footer_row1_show'] ) && $data['footer_row1_show'] == 'yes' ) || empty ( $data['footer_row1_show'] ) ) {

						echo '<div class="row">';
					
						$number_of_columns = 	key( json_decode ( stripslashes ( $data['footer_row1_widget_positions'] ) ) );
						$columns_array = 		json_decode ( stripslashes ( $data['footer_row1_widget_positions'] ),true );
					
						for ($i = 1; $i <= $number_of_columns; $i++) {
							echo '<div class="span'.$columns_array[$number_of_columns][0][$i-1].'">';
								if ( !dynamic_sidebar('Footer row 1 - widget '.$i.'') ) : endif; 
							echo '</div>';
						}
						
						echo '</div><!-- end row -->';

					}
					
				}

				if ( !empty ( $data['footer_row2_widget_positions'] ) ) {
				
					if ( (!empty ( $data['footer_row2_show'] ) && $data['footer_row2_show'] == 'yes' ) || empty ( $data['footer_row2_show'] ) ) {

						echo '<div class="row">';
					
						$number_of_columns = 	key( json_decode ( stripslashes ( $data['footer_row2_widget_positions'] ) ) );
						$columns_array = 		json_decode ( stripslashes ( $data['footer_row2_widget_positions'] ),true );
					
						for ($i = 1; $i <= $number_of_columns; $i++) {
							echo '<div class="span'.$columns_array[$number_of_columns][0][$i-1].'">';
								if ( !dynamic_sidebar('Footer row 2 - widget '.$i.'') ) : endif; 
							echo '</div>';
						}
						
						echo '</div><!-- end row -->';

					}
					
				}
			?>	
			
			<div class="row">
				<div class="span12">
					<div class="bottom fixclear">
					
					<?php
						if ( isset( $data['footer_social_icons'] ) && is_array( $data['footer_social_icons'] ) && !empty ( $data['footer_social_icons'][0]['footer_social_icon'] ) ) {
						
							$icon_class = '';
							
							
							if( $data['footer_which_icons_set'] == 'colored' ) { 
								$icon_class = 'colored';
							}
							
							echo '<ul class="social-icons '.$icon_class.' fixclear">';
								
								echo '<li class="title">'.__('GET SOCIAL', THEMENAME ).'</li>'; // Translate
								
								foreach ( $data['footer_social_icons'] as $key=>$icon ){
								
									$link = '';
									$target = '';
								
									if ( isset ( $icon['footer_social_link'] ) && is_array ( $icon['footer_social_link'] )) {
										$link = $icon['footer_social_link']['url'];
										$target = 'target="'.$icon['footer_social_link']['target'].'"';
									}
									
								
									echo '<li class="'.$icon['footer_social_icon'].'"><a href="'.$link.'" '.$target.'>'.$icon['footer_social_title'].'</a></li>';
								}
								
							echo '</ul>';
							
						}
					?>
					
					<?php if( $data['copyright_text'] || $data['footer_logo']  ) { ?>
						
						<div class="copyright">
							
							
							<?php 
								if( $data['footer_logo'] ) {
									echo '<a href="'.home_url().'"><img src="'.$data['footer_logo'].'" alt="" /></a>';
								
								} 
							
								if( $data['copyright_text'] ) {
									echo '<p>'.stripslashes($data['copyright_text']).'</p>';
								
								} 
							?>
							
							
						</div><!-- end copyright -->
							
					<?php } ?>
						

					</div><!-- end bottom -->
				</div>
			</div><!-- end row -->
			
		</div>
	</footer>
	<?php } ?>
    </div><!-- end page_wrapper -->
	
    <a href="#" id="totop"><?php echo __('TOP', THEMENAME ); ?></a> <?php // Translate ?>

<?php wp_footer(); ?>
</body>
</html>