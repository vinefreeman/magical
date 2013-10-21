<?php
/*--------------------------------------------------------------------------------------------------
	Laptop Slider
--------------------------------------------------------------------------------------------------*/

	function _lslider($options)
	{	
	
		if ( isset ( $options['ls_header_style'] ) && !empty ( $options['ls_header_style'] ) && $options['ls_header_style'] != 'zn_def_header_style' ) { 
			$style = 'uh_'.$options['ls_header_style'];
		} else { 
			$style = 'zn_def_header_style';
		}
		
		if ( isset ( $options['ls_slider_desc'] ) && !empty ( $options['ls_slider_desc'] ) ) { 
			$slider_desc = '<h3 class="centered">'.do_shortcode($options['ls_slider_desc']).'</h3>';
		} else { 
			$slider_desc = '';
		}
	
	?>
        <div id="slideshow" class="gradient noGlare <?php echo $style; ?>">
			<div class="bgback"></div>
			<div class="laptop-slider-wrapper">
				<div class="container">
				
					<?php echo $slider_desc;?>
					
					<div class="laptop-mask">
						<div class="flexslider zn_laptop_slider">
							<ul class="slides">
							
								<?php
									if ( isset ( $options['single_lslides'] ) && is_array ( $options['single_lslides'] ) ) {	
										foreach ( $options['single_lslides'] as $slide ) {
										
											$link_start = '';
											$link_end = '';
											$caption = '';
											$alt = '';

											
											if ( isset ( $slide['ls_slide_link']['url'] ) && !empty ( $slide['ls_slide_link']['url'] ) )
											{
											
												// Link
												$link_start = '<a class="link" href="'.$slide['ls_slide_link']['url'].'" target="'.$slide['ls_slide_link']['target'].'">';
												$link_end = '</a>';
												
											}
											
											if ( isset ( $slide['ls_slide_title'] ) && !empty ( $slide['ls_slide_title'] ) )
											{
											
												// Caption
												$caption = '<h2 class="flex-caption">'.$slide['ls_slide_title'].'</h2>';
												$alt = $slide['ls_slide_title'];
												
											}
											
											echo '<li>';
											
												echo $link_start;
												
													if ( isset ( $slide['ls_slide_image'] ) && !empty ( $slide['ls_slide_image'] ) ) {
													
														$image = vt_resize( '',$slide['ls_slide_image'] , '607','380', true );
														echo '<img src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" alt="'.$alt.'" />';
														
													}

													echo $caption;
												
												echo $link_end;
											
											echo '</li>';
											
										
										}
										
									}
								?>

							</ul>
                    </div><!-- end #flexslider -->
					</div><!-- laptop mask -->
					
				</div>	
            </div>
        </div><!-- end slideshow -->
	<?php

	// LOAD CSS AND JS
	wp_enqueue_style('lslider');
	wp_enqueue_script('flex_slider');


	$zn_laptop_slider = array ( 'zn_laptop_slider' =>
			"
			(function($){ 
				$(window).load(function(){
					
					function slideCompletezn_laptop_slider(args) {
						var caption = $(args.container).find('.flex-caption').attr('style', ''),
							thisCaption = $('.flexslider.zn_laptop_slider .slides > li.flex-active-slide').find('.flex-caption');
						thisCaption.animate({left:20, opacity:1}, 500, 'easeOutQuint');
					}
						
					$(\".flexslider.zn_laptop_slider\").flexslider({
						animation: \"fade\",				//String: Select your animation type, \"fade\" or \"slide\"
						slideDirection: \"horizontal\",	//String: Select the sliding direction, \"horizontal\" or \"vertical\"
						slideshow: true,				//Boolean: Animate slider automatically
						slideshowSpeed: 7000,			//Integer: Set the speed of the slideshow cycling, in milliseconds
						animationDuration: 9600,			//Integer: Set the speed of animations, in milliseconds
						directionNav: true,				//Boolean: Create navigation for previous/next navigation? (true/false)
						controlNav: false,				//Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
						keyboardNav: true,				//Boolean: Allow slider navigating via keyboard left/right keys
						mousewheel: false,				//{UPDATED} Boolean: Requires jquery.mousewheel.js (https://github.com/brandonaaron/jquery-mousewheel) - Allows slider navigating via mousewheel
						smoothHeight: false,
						randomize: false,				//Boolean: Randomize slide order
						slideToStart: 0,				//Integer: The slide that the slider should start on. Array notation (0 = first slide)
						animationLoop: true,			//Boolean: Should the animation loop? If false, directionNav will received \"disable\" classes at either end
						pauseOnAction: true,			//Boolean: Pause the slideshow when interacting with control elements, highly recommended.
						pauseOnHover: false,			//Boolean: Pause the slideshow when hovering over slider, then resume when no longer hovering
						start: slideCompletezn_laptop_slider,
						after: slideCompletezn_laptop_slider
					});
				});
			})(jQuery);
			");
			
			zn_update_array( $zn_laptop_slider );
	
	}
?>