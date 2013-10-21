<?php
/*--------------------------------------------------------------------------------------------------
	Fancy Slider
--------------------------------------------------------------------------------------------------*/
 
	function _fancyslider($options)
	{	
	?>
	
        <div id="slideshow" class="">
			
			<div class="container">
			
				<div class="flexslider zn_fancy_slider">
					<ul class="slides">
					<?php
							if ( isset ( $options['single_fancy'] ) && is_array ( $options['single_fancy'] ) ) {
								
								foreach ( $options['single_fancy'] as $slide ) {
								
									$link_start = '';
									$link_end = '';

									
									if ( isset ( $slide['ww_slide_link']['url'] ) && !empty ( $slide['ww_slide_link']['url'] ) )
									{
										// Set defaults 
										$link_start = '<a class="link" href="'.$slide['ww_slide_link']['url'].'" target="'.$slide['ww_slide_link']['target'].'">';
										$link_end = '</a>';
									
									}
								
									echo '<li data-color="'.$slide['ww_slide_color'].'">';
									
										echo $link_start;
										
											if ( isset ( $slide['ww_slide_image'] ) && !empty ( $slide['ww_slide_image'] ) ) {
											
												$image = vt_resize( '',$slide['ww_slide_image'] , '940','', true );
												echo '<img src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" />';
													
											}
										
										echo $link_end;
									
									echo '</li>';
								
								}
								
							}
					?>
					
					
						
					</ul>
				</div><!-- end #flexslider -->
				
			</div>	
			<div class="shadowUP"></div>
			<div class="shadowUP"></div>
        </div><!-- end slideshow -->	
	
	<?php

	// LOAD CSS AND JS
	wp_enqueue_style('flex_slider_fancy');
	wp_enqueue_script('flex_slider');
	wp_enqueue_script('flex_slider_colors');

		$zn_fancy_slider = array ( 'zn_fancy_slider' =>
			"
				(function($) {
					$(window).load(function(){
						function slideCompleteFancy(args) {
							//console.log(args);
							var _arg = $(args),
								slideshow =  _arg.closest('#slideshow'),
								color = $(args.slides).eq(args.animatingTo).attr('data-color');
								console.log(color)
							if( _arg.css('background-image') != 'none')  _arg.css('background-image', 'none');
							
							slideshow.animate({backgroundColor: color}, 400);
							//slideshow.css({'background-color': color});
						}
						
						$(\".flexslider.zn_fancy_slider\").flexslider({
							animation: \"slide\",				//String: Select your animation type, \"fade\" or \"slide\"
							direction: \"vertical\",			//String: Select the sliding direction, \"horizontal\" or \"vertical\"
							slideshow: true,				//Boolean: Animate slider automatically
							slideshowSpeed: 7000,			//Integer: Set the speed of the slideshow cycling, in milliseconds
							animationDuration: 600,			//Integer: Set the speed of animations, in milliseconds
							directionNav: true,				//Boolean: Create navigation for previous/next navigation? (true/false)
							controlNav: true,				//Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
							keyboardNav: true,				//Boolean: Allow slider navigating via keyboard left/right keys
							mousewheel: false,				//{UPDATED} Boolean: Requires jquery.mousewheel.js (https://github.com/brandonaaron/jquery-mousewheel) - Allows slider navigating via mousewheel
							smoothHeight: true,
							randomize: false,				//Boolean: Randomize slide order
							slideToStart: 0,				//Integer: The slide that the slider should start on. Array notation (0 = first slide)
							animationLoop: true,			//Boolean: Should the animation loop? If false, directionNav will received \"disable\" classes at either end
							pauseOnAction: true,			//Boolean: Pause the slideshow when interacting with control elements, highly recommended.
							pauseOnHover: false,			//Boolean: Pause the slideshow when hovering over slider, then resume when no longer hovering
							start: slideCompleteFancy,
							before: slideCompleteFancy
						});
					});
				})(jQuery);
			");
			
			zn_update_array( $zn_fancy_slider );
	
	}
?>