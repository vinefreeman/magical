<?php
/*--------------------------------------------------------------------------------------------------
	3D CUTE SLIDER
--------------------------------------------------------------------------------------------------*/
	function _cute_slider($options)
	{
		global $meta_fields;
	
		if ( isset ( $options['ww_header_style'] ) && !empty ( $options['ww_header_style'] ) ) { 
			$style = 'uh_'.$options['ww_header_style'];
		} else { 
			$style = '';
		}

	?>
		<div id="slideshow" class="<?php echo $style; ?>">
			<div class="bgback"></div>
			
			<div data-images="<?php echo IMAGES_URL; ?>/" id="sparkles"></div>
				<div class="container zn_slideshow">
					<?php echo do_shortcode('[cuteslider id="'.$options['cuteslider_id'].'"]'); ?>
				</div>
			<div class="zn_header_bottom_style"></div>
		</div><!-- end page_header -->
	<?php	
	}
?>