<?php
/*--------------------------------------------------------------------------------------------------
	Service Box
--------------------------------------------------------------------------------------------------*/
 
	function _service_box($options)
	{
		
		$element_size = zn_get_size( $options['_sizer'] );
	?>
		<div class="<?php echo $element_size['sizer'];?> services_box">
			<div class="box fixclear">
			
				<?php
				
					// Image
					if ( !empty ( $options['service_box_image'] ) ) 
					{ 
					
						echo  '<div class="icon"><img src="'.$options['service_box_image'].'" alt=""></div>';

					}
				
					// Title
					if ( !empty ( $options['service_box_title'] ) ) 
					{ 
						echo '<h4 class="title">'.$options['service_box_title'].'</h4>';
					}
					
					// FEATURES LIST
					if ( !empty ( $options['service_box_features'] ) ) {
					
						echo '<ul class="list-style1">';
					
							$textAr = explode("\n", $options['service_box_features']);
							foreach ($textAr as $index=>$line) {
								echo '<li>'.$line.'</li>';
							} 
					
						echo '</ul>';
					}
					
				?>

			</div><!-- end box -->
		</div>
	<?php
	
	
	}
?>