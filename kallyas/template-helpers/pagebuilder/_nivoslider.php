<?php
/*--------------------------------------------------------------------------------------------------
	Nivo Slider
--------------------------------------------------------------------------------------------------*/
 
	function _nivoslider($options)
	{
	
		if ( isset ( $options['nv_header_style'] ) && !empty ( $options['nv_header_style'] ) ) { 
			$style = 'uh_'.$options['nv_header_style'];
		} else { 
			$style = '';
		}
	
	?>
        <div id="slideshow" class="<?php echo $style; ?>">
		
			<div class="bgback"></div>
			<div data-images="<?php echo IMAGES_URL; ?>/" id="sparkles"></div>
		
			<div class="container zn_slideshow">

                <div id="nivoslider" class="nivoContainer ">
                    <div class="nivoSlider drop-shadow <?php echo $options['nv_shadow'];?>" data-transition="<?php echo $options['nv_transition'];?>">
					<?php
					
						if ( isset ( $options['single_nivo'] ) && is_array ( $options['single_nivo'] ) ) {
							
							foreach ( $options['single_nivo'] as $slide ) {
								
								$link_start = '';
								$link_end = '';
								$title = '';
								
								if ( isset ( $slide['nv_slide_link']['url'] ) && !empty ( $slide['nv_slide_link']['url'] ) )
								{
									// Set defaults 
									$link_start = '<a class="link" href="'.$slide['nv_slide_link']['url'].'" target="'.$slide['nv_slide_link']['target'].'">';
									$link_end = '</a>';
								
								}
								
								if ( isset ( $slide['nv_slide_title'] ) && !empty ( $slide['nv_slide_title'] ) ) {
									$title = $slide['nv_slide_title'];
								}
								
								echo $link_start;
								
									if ( isset ( $slide['nv_slide_image'] ) && !empty ( $slide['nv_slide_image'] ) ) {
									
										$image = vt_resize( '',$slide['nv_slide_image'] , '1170','', true );
										echo '<img title="'.$title.'" src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" />';
																				
									}
								
								echo $link_end;
								
								
							}
							
						}
					
					?>
					
                        
                    </div>
                </div><!-- end #nivoslider -->
                
			</div>
			
			<div class="zn_header_bottom_style"></div><!-- header bottom style -->
			
        </div><!-- end slideshow -->
	<?php

					if ( isset( $options['nv_auto_slide'] ) ){
						$nv_auto_slide = $options['nv_auto_slide'];
					}	
					else {
						$nv_auto_slide = 1;
					}

					if ( isset( $options['nv_pause_time'] ) ){
						$nv_pause_time = $options['nv_pause_time'];
					}	
					else {
						$nv_pause_time = 5000;
					}

					$zn_nivo_slider = array ( 'zn_nivo_slider' =>
						"
							(function($) {
								$(window).load(function(){
									var slider = $('#nivoslider .nivoSlider');
									
									function slideFirst() {
										var caption = slider.find('.nivo-caption');
										setTimeout(function(){
											caption.css('min-width',400).animate({left:20, opacity:1}, 500, 'easeOutQuint');
										}, 1000);
									}
									function slideIn() {
										slider.find('.nivo-caption').css('min-width','').animate({left:20, opacity:1}, 500, 'easeOutQuint');
									}
									function slideOut() {
										slider.find('.nivo-caption').css('min-width','').animate({left:120, opacity:0}, 500, 'easeOutQuint');
									}
									
									transition = slider.attr('data-transition');
									
									
									slider.nivoSlider({
										effect:transition,		// Specify sets like: 'fold,fade,sliceDown'
										boxCols: 8,				// For box animations
										boxRows: 4,				// For box animations
										slices:15,				// For slice animations
										animSpeed:500,			// Slide transition speed
										pauseTime:".$nv_pause_time.",			// How long each slide will show
										startSlide:0,			// Set starting Slide (0 index)
										directionNav:1,			// Next & Prev navigation
										controlNav:1,			// 1,2,3... navigation
										controlNavThumbs:0,		// Use thumbnails for Control Nav
										pauseOnHover:1,			// Stop animation while hovering
										manualAdvance:".$nv_auto_slide.",		// Force manual transitions
										afterLoad: slideFirst,
										beforeChange: slideOut,
										afterChange: slideIn
									});
								});
							})(jQuery);
						");
						
						zn_update_array( $zn_nivo_slider );
	
	}
?>