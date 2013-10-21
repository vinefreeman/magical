<?php
/*--------------------------------------------------------------------------------------------------
	iCarousel
--------------------------------------------------------------------------------------------------*/

	function _icarousel($options)
	{
	

		if ( isset ( $options['ic_header_style'] ) && !empty ( $options['ic_header_style'] ) && $options['ic_header_style'] != 'zn_def_header_style' ) { 
			$style = 'uh_'.$options['ic_header_style'];
		} else { 
			$style = 'zn_def_header_style';
		}
	
	?>
        <div id="slideshow" class="<?php echo $style; ?>">
			<div class="bgback"></div>
			<div class="carousel-container">
				<div id="icarousel">
				<?php
					if ( isset ( $options['single_icarousel'] ) && is_array ( $options['single_icarousel'] ) ) {
						

						foreach ( $options['single_icarousel'] as $slide ) {
							
							$link_start = '<a href="#" class="slide">';
							$link_end = '</a>';
							$slide_class = 'class="slide"';
						
							if ( isset ( $slide['ic_slide_link']['url'] ) && !empty ( $slide['ic_slide_link']['url'] ) )
							{
								// Set defaults 
								$link_start = '<a class="slide" href="'.$slide['ic_slide_link']['url'].'" target="'.$slide['ic_slide_link']['target'].'">';
								$link_end = '</a>';
								$slide_class = '';
							}
							
							echo $link_start;
							
								if ( isset ( $slide['ic_slide_image'] ) && !empty ( $slide['ic_slide_image'] ) ) {
								
									$image = vt_resize( '',$slide['ic_slide_image'] , '480','360', true );
									echo '<img '.$slide_class.' src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" />';
									
								}
								
								if ( isset ( $slide['ic_slide_title'] ) && !empty ( $slide['ic_slide_title'] ) ) {
									echo '<h5><span>'.$slide['ic_slide_title'].'</span></h5>';
								}
								
							echo $link_end;
							
							
						}
						
					}
				?>
				
				</div>
			</div>
			
        </div><!-- end slideshow -->
	<?php

	// Load JS and CSS
	wp_enqueue_style('icarousel_demo');
	wp_enqueue_style('icarousel');
	wp_enqueue_script('icarousel');
	wp_enqueue_script('mousewheel');
	wp_enqueue_script('raphael_min');

					$icarousel = array ( 'zn_icarousel_slider' =>
							"	
								jQuery('#icarousel').iCarousel({
									easing: 'easeInOutQuint',
									slides: 7,
									animationSpeed: 700,
									pauseTime: 5000,
									perspective: 75,
									slidesSpace: 300,
									pauseOnHover: true,
									direction: \"ltr\",
									timer: \"Bar\",
									timerOpacity: 0.4,
									timerDiameter: 220,
									keyboardNav: true,
									mouseWheel: true,
									timerPadding: 3,
									timerStroke: 4,
									timerBarStroke: 0,
									timerColor: \"#FFF\",
									timerPosition: \"bottom-center\",
									timerX: 15,
									timerY: 30
								});
							;");
							
					zn_update_array( $icarousel );
	
	}
?>