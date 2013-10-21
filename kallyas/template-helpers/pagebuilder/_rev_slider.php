<?php
/*--------------------------------------------------------------------------------------------------
	REVOLLUTION SLIDER
--------------------------------------------------------------------------------------------------*/
	function _rev_slider($options)
	{
		global $meta_fields;
	
		if ( isset ( $options['ww_header_style'] ) && !empty ( $options['ww_header_style'] ) ) { 
			$style = 'uh_'.$options['ww_header_style'];
		} else { 
			$style = '';
		}

	?>
		<div id="slideshow" class="<?php echo $style; ?> portfolio_devices zn_slideshow">
			<div class="bgback"></div>
			<div data-images="<?php echo IMAGES_URL; ?>/" id="sparkles"></div>

				
					<?php echo do_shortcode('[rev_slider '.$options['revslider_id'].']'); ?>
				

			<div class="zn_header_bottom_style"></div>
		</div><!-- end page_header -->
	<?php

	if(  $options['revslider_paralax'] ){
		$paralax = array ( 'zn_paralax' =>
				"	
					var parallax = new Parallax({
						container: '#slideshow',
						layers: [
							{ selector: '.para1', ratio: .020 },
							{ selector: '.para2', ratio: .010 },
							{ selector: '.para3', ratio: .008 },
							{ selector: '.para4', ratio: .005 },
							{ selector: '.para5', ratio: .005 }
						]
					});

				");
				
		zn_update_array( $paralax );

	}

}

?>