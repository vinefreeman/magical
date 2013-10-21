<?php
/*--------------------------------------------------------------------------------------------------
	Flex Slider
--------------------------------------------------------------------------------------------------*/
 
	function _flexslider($options)
	{
	
		if ( isset ( $options['fs_header_style'] ) && !empty ( $options['fs_header_style'] ) ) { 
			$style = 'uh_'.$options['fs_header_style'];
		} else { 
			$style = '';
		}
		
		if ( $options['fs_show_thumbs'] ) { 
			$thumbs = 'zn_has_thumbs';
		} 
		else {
			$thumbs = '';
		}
	
	?>
        <div id="slideshow" class="notPadded <?php echo $style; ?>">
			<div class="bgback"></div>
			<div data-images="<?php echo IMAGES_URL; ?>/" id="sparkles"></div>
			<div class="container zn_slideshow">

                    <div data-transition="<?php echo $options['fs_transition'];?>" class="flexslider showOnMouseover zn_normal_flex <?php echo $thumbs; ?> drop-shadow <?php echo $options['fs_shadow'];?>">
                        <ul class="slides">
						<?php
							if ( isset ( $options['single_flex'] ) && is_array ( $options['single_flex'] ) ) {
								
								foreach ( $options['single_flex'] as $slide ) {
								
									$thumb = '';
									$link_start = '';
									$link_end = '';
								
									if ( isset ( $slide['fs_slide_link']['url'] ) && !empty ( $slide['fs_slide_link']['url'] ) )
									{
										// Set defaults 
										$link_start = '<a class="slide" href="'.$slide['fs_slide_link']['url'].'" target="'.$slide['fs_slide_link']['target'].'">';
										$link_end = '</a>';
									
									}
										
									if ( isset ( $slide['fs_slide_image'] ) && !empty ( $slide['fs_slide_image'] ) ) {
									
										$image = vt_resize( '',$slide['fs_slide_image'] , '1170','', true );
										$full_image = '<img src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" />';
										
										
										if ( $options['fs_show_thumbs'] ) { 
											$small_thumb = vt_resize( '',$slide['fs_slide_image'] , '150','60', true );
											$thumb = 'data-thumb="'.$small_thumb['url'].'"';
										} 
										
									}
										


								
									echo '<li '.$thumb.'>';
										echo $link_start;
										

											echo $full_image;
								
										echo $link_end;
										
										if ( isset ( $slide['fs_slide_title'] ) && !empty ( $slide['fs_slide_title'] ) ) {
											echo '<h2 class="flex-caption">'.$slide['fs_slide_title'].'</h2>';
										}
										
									echo '</li>';
								}
								
							}
						?>

                        </ul>
                    </div><!-- end #flexslider -->

			</div>
			
			<div class="zn_header_bottom_style"></div><!-- header bottom style -->
			
        </div><!-- end slideshow -->
	<?php

	// LOAD CSS AND JS
	wp_enqueue_style('flex_slider');
	wp_enqueue_style('zn_shadows');
	wp_enqueue_script('flex_slider');

					$zn_normal_flex = array ( 'zn_normal_flex' =>
						"
							(function($) {
								$(window).load(function(){
								
									function slideCompletezn_normal_flex(args) {
										var caption = $(args.container).find('.flex-caption').attr('style', ''),
											thisCaption = $('.flexslider.zn_normal_flex .slides > li.flex-active-slide').find('.flex-caption');
										thisCaption.animate({left:20, opacity:1}, 500, 'easeOutQuint');
									}
								
									if ( jQuery('.flexslider.zn_normal_flex').hasClass('zn_has_thumbs') ) {
										thumbs = 'thumbnails';
									}
									else {
										thumbs = true;
									}
									
									transition = jQuery(\".flexslider.zn_normal_flex\").attr('data-transition');
									
									$(\".flexslider.zn_normal_flex\").flexslider({
										animation: transition,				//String: Select your animation type, \"fade\" or \"slide\"
										slideDirection: \"horizontal\",	//String: Select the sliding direction, \"horizontal\" or \"vertical\"
										slideshow: true,				//Boolean: Animate slider automatically
										slideshowSpeed: 7000,			//Integer: Set the speed of the slideshow cycling, in milliseconds
										animationDuration: 600,			//Integer: Set the speed of animations, in milliseconds
										directionNav: true,				//Boolean: Create navigation for previous/next navigation? (true/false)
										controlNav: thumbs,				//Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
										keyboardNav: true,				//Boolean: Allow slider navigating via keyboard left/right keys
										mousewheel: false,				//{UPDATED} Boolean: Requires jquery.mousewheel.js (https://github.com/brandonaaron/jquery-mousewheel) - Allows slider navigating via mousewheel
										smoothHeight: true,
										randomize: false,				//Boolean: Randomize slide order
										slideToStart: 0,				//Integer: The slide that the slider should start on. Array notation (0 = first slide)
										animationLoop: true,			//Boolean: Should the animation loop? If false, directionNav will received \"disable\" classes at either end
										pauseOnAction: true,			//Boolean: Pause the slideshow when interacting with control elements, highly recommended.
										pauseOnHover: false,			//Boolean: Pause the slideshow when hovering over slider, then resume when no longer hovering
										start: slideCompletezn_normal_flex,
										after: slideCompletezn_normal_flex
									});
								});
							})(jQuery);
						");
						
						zn_update_array( $zn_normal_flex );
	
	}
?>