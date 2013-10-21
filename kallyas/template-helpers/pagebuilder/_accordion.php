<?php
/*--------------------------------------------------------------------------------------------------
	Accordion
--------------------------------------------------------------------------------------------------*/
 
	function _accordion($options)
	{

		
		$element_size = zn_get_size( $options['_sizer'] );
		
		?>
			<div class="<?php echo $element_size['sizer'];?>">
			
			<?php
				if ( !empty ( $options['acc_title'] ) && $options['acc_style'] == 'default-style' ) {
					echo '<h3 class="m_title">'.$options['acc_title'].'</h3>';
				}
				elseif ( !empty ( $options['acc_title'] ) && ( $options['acc_style'] == 'style2' || $options['acc_style'] == 'style3' ) ) {
					echo '<h3>'.$options['acc_title'].'</h3>';
				}
				
				$acc_id = 1;
				$uniq = uniqid();
				
				if ( isset ( $options['accordion_single'] ) && is_array( $options['accordion_single'] ) ) {
					foreach ( $options['accordion_single'] as $acc ) {

						$colapsed = 'in';

						if ( isset($acc['acc_colapsed']) && $acc['acc_colapsed'] == 'yes' ) {
							$colapsed = '';
						}

						echo '<div class="acc-group '.$options['acc_style'].'">';
							echo '<button data-toggle="collapse" data-target="#acc'.$uniq.''.$acc_id.'" class="collapsed">'.$acc['acc_single_title'].'</button>';
							echo '<div id="acc'.$uniq.''.$acc_id.'" class="collapse '.$colapsed.'">';
								
								echo '<div class="content">';
								
										if (preg_match('%(<p[^>]*>.*?</p>)%i', $acc['acc_single_desc'], $regs)) {
											echo do_shortcode ( $acc['acc_single_desc'] );
										} else {
											echo '<p>'.do_shortcode ( $acc['acc_single_desc'] ).'</p>';
										}
										
								echo '</div>';	
								
							echo '</div>';
						echo '</div>';
						
						$acc_id++;
					}
				}
				
			?>

				<!-- end // accordion texts  -->
			</div>
		
		<?php
	}
?>