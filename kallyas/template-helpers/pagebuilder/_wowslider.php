<?php
/*--------------------------------------------------------------------------------------------------
	Wow Slider
--------------------------------------------------------------------------------------------------*/
 
	function _wowslider($options)
	{
	
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

                <div id="wowslider-container" class="drop-shadow <?php echo $options['ww_shadow'];?>"" data-transition="<?php echo $options['ww_transition']; ?>">
                    <div class="ws_images">
                        <ul>
						<?php
						
							if ( isset ( $options['single_wow'] ) && is_array ( $options['single_wow'] ) ) {
								
								$i = 0;
								$thumbs = '';
								
								foreach ( $options['single_wow'] as $slide ) {
								
									$link_start = '';
									$link_end = '';
									$title = '';
									
									if ( isset ( $slide['ww_slide_link']['url'] ) && !empty ( $slide['ww_slide_link']['url'] ) )
									{
										// Set defaults 
										$link_start = '<a class="link" href="'.$slide['ww_slide_link']['url'].'" target="'.$slide['ww_slide_link']['target'].'">';
										$link_end = '</a>';
									
									}
									
									if ( isset ( $slide['ww_slide_title'] ) && !empty ( $slide['ww_slide_title'] ) ) {
										$title = $slide['ww_slide_title'];
									}
									
									echo '<li>';
									echo $link_start;
									
										if ( isset ( $slide['ww_slide_image'] ) && !empty ( $slide['ww_slide_image'] ) ) {
										
											$image = vt_resize( '',$slide['ww_slide_image'] , '1170','', true );
											echo '<img id="wows1_'.$i.'" title="'.$title.'" src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" />';
												
											$image_thumb = vt_resize( '',$slide['ww_slide_image'] , '150','60', true );
											$thumbs .= '<a href="#" title="slide'.$i.'"><img src="'.$image_thumb['url'].'" />'.$i.'</a>';
												
										}
									
									echo $link_end;
									echo '</li>';
									$i++;
								
								}
								
							}
						?>
						
                        </ul>
                    </div><!-- end ws_images -->
                
                    <div class="ws_bullets">
                        <div>
							<?php echo $thumbs; ?>
                        </div>
                    </div><!-- end ws-bullets -->

                </div><!-- end #wow slider -->
                
			</div>
			
			<div class="zn_header_bottom_style"></div><!-- header bottom style -->
			
        </div><!-- end slideshow -->
	<?php

		$zn_wow_slider = array ( 'zn_wow_slider' =>
			"
				(function($) {
					$(window).load(function(){
						transition = jQuery(\"#wowslider-container\").attr('data-transition');
					
						jQuery(\"#wowslider-container\").wowSlider({
							effect:transition,
							duration:900,
							delay:2000,
							width:1170,
							height:465,
							cols:6,
							autoPlay:true,
							stopOnHover:true,
							loop:true,
							bullets:true,
							caption:true,
							controls:true,
							captionEffect:\"slide\",
							logo:\"image/loading_light.gif\",
							images:0
						});
					});
				})(jQuery);
			");
			
			zn_update_array( $zn_wow_slider );

	}
?>