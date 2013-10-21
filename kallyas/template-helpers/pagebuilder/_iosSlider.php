<?php

/*--------------------------------------------------------------------------------------------------
	iOS Slider
--------------------------------------------------------------------------------------------------*/
 
	function _iosSlider($options)
	{
	
		if ( isset ( $options['io_header_style'] ) && !empty ( $options['io_header_style'] ) ) { 
			$style = 'uh_'.$options['io_header_style'];
		} else { 
			$style = '';
		}
	
		if ( isset ( $options['io_s_fade'] ) && !empty ( $options['io_s_fade'] ) ) { 
			$faded = 'faded';
		} else { 
			$faded = '';
		}
		
		if ( isset ( $options['io_s_scroll'] ) && !empty ( $options['io_s_scroll'] ) ) { 
			$scroll = 'slider_fixedd';
		} else { 
			$scroll = '';
		}
		
		if ( !empty ( $options['io_s_width'] ) ) { 
			$padded = 'notPadded';
			$fluid_start = '<div class="fluidHeight"><div class="sliderContainer ">';
			$fluid_end = '</div></div>';
			$wid_fixed = 'fixed';
		} else { 
			$padded = '';
			$fluid_start = '';
			$fluid_end = '';
			$wid_fixed = '';
		}
	
		if ( !empty ( $options['io_s_s_height'] ) && empty ( $options['io_s_width'] ) ) {

			$s_height = 'style="padding:0 0 '.$options['io_s_s_height'].'% 0;overflow:hidden;"';

		}
		else {
			$s_height = '';
		}

	?>
		<div id="slideshow" class="<?php echo $style; ?> <?php echo $faded; ?> <?php echo $padded; ?> <?php echo $scroll; ?> " <?php echo $s_height; ?>>
        	
			<div class="bgback"></div>
			<div data-images="<?php echo IMAGES_URL; ?>/" id="sparkles"></div>
			
			<?php echo $fluid_start; ?>
			
			<div class = "iosSlider <?php echo $faded; ?> <?php echo $wid_fixed; ?> zn_slideshow">
			
				<div class="slider">
					
				<?php
					if ( isset ( $options['single_iosslider'] ) && is_array ( $options['single_iosslider'] ) ) {
					
						$thumbs = '';
						$i = 0;
						$bullets = '';
						
						foreach ( $options['single_iosslider'] as $slide ) {
							
							if ( $i == 0 ) { $slide_num = 'first selected'; } else { $slide_num = ''; }
							
							$c_style = 'style1';
							$c_pos = '';
							
							
							$bullets .= '<div class="item '.$slide_num.'"></div>';
							
							echo '<div class = "item">';
							
								$img_link_start = '';
								$img_link_end = '';

								if ( !empty ( $slide['io_slide_link']['url'] ) && !empty($slide['io_slide_link_image']) && $slide['io_slide_link_image'] == 'yes' ) {
									$img_link_start = '<a class="zn_slide_image_link" href="'.$slide['io_slide_link']['url'].'" target="'.$slide['io_slide_link']['target'].'">';
									$img_link_end = '</a>';
								}

								// Slide Image
								if ( $slide_image = $slide['io_slide_image'] ) {

									if ( is_array($slide_image) ){
										$saved_image = $slide_image['image'];
										if ( !empty( $slide_image['alt'] ) ){
											$saved_alt = 'alt="'.$slide_image['alt'].'"';
										}
										else {
											$saved_alt = '';
										}
										if ( !empty( $slide_image['title'] ) ){
											$saved_title = 'title="'.$slide_image['title'].'"';
										}
										else {
											$saved_title = '';
										}
									}
									else {
										$saved_image = $slide_image;
										$saved_alt = '';
										$saved_title = '';
									}

									if ( $options['io_s_width'] ) {
									
										$image = vt_resize( '',$saved_image , '1170','', true );
										echo $img_link_start.'<img src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'"  '.$saved_title.' '.$saved_alt.' />'.$img_link_end;
										
									}else {
										echo $img_link_start.'<img src="'.$saved_image.'" '.$saved_title.' '.$saved_alt.'/>'.$img_link_end;
									}
									
									
									if ( isset ( $options['io_s_navigation'] ) && $options['io_s_navigation'] == 'thumbs' ) {
										
										$image = vt_resize( '',$saved_image , '150','60', true );
										$thumbs .= '<div class="item '.$slide_num.'"><img src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" '.$saved_title.' '.$saved_alt.' /></div>';
									}
									
								}
								
								// Slide Caption Style
								if ( isset ( $slide['io_slide_caption_style'] ) && !empty ( $slide['io_slide_caption_style'] ) ) {
									$c_style = $slide['io_slide_caption_style'];
								}
								
								// Slide Caption Position
								if ( isset ( $slide['io_slide_caption_pos'] ) && !empty ( $slide['io_slide_caption_pos'] ) ) {
									$c_pos = $slide['io_slide_caption_pos'];
								}
								
								echo '<div class="caption '.$c_style.' '.$c_pos.'">';
									
									

									// Slide Main TITLE
									if ( isset ( $slide['io_slide_m_title'] ) && !empty ( $slide['io_slide_m_title'] ) ) {
										echo '<h2 class="main_title">'.$slide['io_slide_m_title'].'</h2>';
									}
									
									// Slide BIG TITLE
									if ( isset ( $slide['io_slide_b_title'] ) && !empty ( $slide['io_slide_b_title'] ) ) {
										echo '<h3 class="title_big">'.$slide['io_slide_b_title'].'</h3>';
									}
									
									if ( !empty ( $slide['io_slide_link']['url'] ) && $slide['io_slide_caption_style'] != 'style3' )
									{
										echo '<a class="more" href="'.$slide['io_slide_link']['url'].'" target="'.$slide['io_slide_link']['target'].'"><img width="10" height="16" src="'.MASTER_THEME_DIR.'/sliders/iosslider/arr01.png" alt=""></a>';
									}
									
									// Slide SMALL TITLE
									if ( isset ( $slide['io_slide_s_title'] ) && !empty ( $slide['io_slide_s_title'] ) ) {
										echo '<h4 class="title_small">'.$slide['io_slide_s_title'].'</h4>';
									}
								echo $img_link_start .  $img_link_end;
								
								echo '</div>';
							
							echo '</div><!-- end item -->';
							
							$i++;
													
						}
					
					}
					

					echo '</div>';


					$infinite_slide = 'false';

					if ( count($options['single_iosslider']) > 1 ) {
						
						// This will fix the Ios Slider when using only one slide
						$infinite_slide = 'true';

						echo '<div class="prev"><div class="btn-label">'.__('PREV',THEMENAME).'</div></div>';
						echo '<div class="next"><div class="btn-label">'.__('NEXT',THEMENAME).'</div></div>';

						if ( !$options['io_s_width'] && $options['io_s_navigation'] == 'thumbs' ) {
							
								?>
									<div class="selectorsBlock thumbs">
										<a href="#" class="thumbTrayButton"><span class="icon-minus icon-white"></span></a>
										<div class="selectors">
											<?php echo $thumbs;?>
										</div>
									</div>
								<?php
							
						}

						echo '</div><!-- end iosSlider -->';

						if ( $options['io_s_width'] || $options['io_s_navigation'] != 'thumbs' ) {
								?>
									<div class="selectorsBlock bullets">
										<div class="selectors">
											<?php echo $bullets;?>
										</div>
									</div>
								<?php
						}

					}
					else {
						echo '</div><!-- end iosSlider -->';
					}

				?>

            <div class="scrollbarContainer"></div>
			
			<div class="zn_header_bottom_style"></div><!-- header bottom style -->
			
			<?php echo $fluid_end; ?>
			
        </div><!-- end slideshow -->
		
		<div class="zn_fixed_slider_fill"></div>

	<?php
	// Load CSS and JS
	wp_enqueue_style('ios_slider');
	wp_enqueue_script('ios_slider_min');
	wp_enqueue_script('ios_slider_kalypso');

	$trans = '5000';
	if ( !empty($options['io_s_trans']) ) { $trans = $options['io_s_trans']; } 

	$ios_slider = array ( 'zn_ios_slider' =>
			"	
				jQuery('.iosSlider').each(function(){

					jQuery(this).iosSlider({
						snapToChildren: true,
						desktopClickDrag: true,
						keyboardControls: true,
						autoSlideTimer: ".$trans.",
						navNextSelector: jQuery(this).closest('.iosSlider').find('.next'),
						navPrevSelector: jQuery(this).closest('.iosSlider').find('.prev'),
						navSlideSelector: jQuery('.selectors .item'),
						scrollbar: true,
						scrollbarContainer: '#slideshow .scrollbarContainer',
						scrollbarMargin: '0',
						scrollbarBorderRadius: '4px',
						onSlideComplete: slideComplete,
						onSliderLoaded: function(args){
							var otherSettings = {
								hideControls : true, // Bool, if true, the NAVIGATION ARROWS will be hidden and shown only on mouseover the slider
								hideCaptions : false  // Bool, if true, the CAPTIONS will be hidden and shown only on mouseover the slider
							}
							sliderLoaded(args, otherSettings);
						},
						onSlideChange: slideChange,
						keyboardControls: true,
						infiniteSlider: ".$infinite_slide.",
						autoSlide: true
					});

				})

			;");
			
	zn_update_array( $ios_slider );

	}

