<?php
/*--------------------------------------------------------------------------------------------------
	Limited Offers
--------------------------------------------------------------------------------------------------*/
	function _photo_gallery( $options )
	{
		$element_size = zn_get_size( $options['_sizer'] );
	?>

		<div class="<?php echo $element_size['sizer']; ?>">
			<div class="row-fluid zn_image_gallery">
			
				<?php

					if ( !empty ( $options['single_photo_gallery'] ) && is_array($options['single_photo_gallery']) ) {
						$i = 0;
						$id = uniqid('pp_');
						$count = count($options['single_photo_gallery']);

						if ( !empty ($options['pg_num_cols']) ) {
							$num_cols = $options['pg_num_cols'];
						}
						else {
							$num_cols = 6;
						}

						$new_size = 12/$num_cols;	
						$size = zn_get_size( 'span'.$new_size );

						$height = $image_resized['height'];

						if ( isset($options['pg_img_height']) && !empty($options['pg_img_height'])) {
							$height = $options['pg_img_height'];
						}

						foreach ($options['single_photo_gallery'] as $image) {

							if ( $i%$num_cols == 0 ){
								echo '<div class="row-fluid">';
							}

							//preg_match('|\d+|', 'span12' , $new_size);
							

							echo '<div class="span'.$new_size.'">';


								if ( !empty ( $image['spg_image'] ) && !empty( $image['spg_video'] ) ) {

									
									$image_resized = vt_resize( '', $image['spg_image'] , $size['width'],$height , true );

									echo '<a rel="prettyPhoto['.$id.']" href="'.$image['spg_video'].'" title="'.$image['spg_title'].'" class="hoverBorder">';
										echo '<img alt="" src="'.$image_resized['url'].'" width="'.$image_resized['width'].'" height="'.$image_resized['height'].'">';
									echo '</a>';

								}
								elseif ( !empty ( $image['spg_image'] ) ){
									$image_resized = vt_resize( '', $image['spg_image'] , $size['width'],$height , true );
									echo '<a rel="prettyPhoto['.$id.']" href="'.$image['spg_image'].'" title="'.$image['spg_title'].'" class="hoverBorder">';
										echo '<img alt="" src="'.$image_resized['url'].'" width="'.$image_resized['width'].'" height="'.$image_resized['height'].'">';
									echo '</a>';

								}

								$i++;

								if ( $i%$num_cols == 0 || $count == $i ){
									echo '</div>';
								}

							echo '</div>';
						}

					}

				?>
			

			</div>
		</div>

	<?php
	}
?>