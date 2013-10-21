<?php
/*--------------------------------------------------------------------------------------------------
	Portfolio Slider
--------------------------------------------------------------------------------------------------*/

	function _pslider($options)
	{	
		
		$title = '';
		$link = '';
	
	
		if ( isset ( $options['ps_header_style'] ) && !empty ( $options['ps_header_style'] ) && $options['ps_header_style'] != 'zn_def_header_style' ) { 
			$style = 'uh_'.$options['ps_header_style'];
		} else { 
			$style = 'zn_def_header_style';
		}
		
		if ( isset ( $options['ps_slider_desc'] ) && !empty ( $options['ps_slider_desc'] ) ) { 
			$slider_desc = '<h3 class="centered">'.do_shortcode($options['ps_slider_desc']).'</h3>';
		} else { 
			$slider_desc = '';
		}
	
		if ($options['ps_sliding_direction'] == 'Horizontal'){
			$hclass='horizontal-mode';
			$container_start = '';
			$container_end = '';
		}
		else{
			$hclass='';
			$container_start = '<div class="container">';
			$container_end = '</div>';
		}


	?>
	
        <div id="slideshow" class="gradient <?php echo $style; ?>">
			<div class="bgback"></div>
			
			<div data-images="<?php echo IMAGES_URL; ?>/" id="sparkles"></div>
			
			<div class="portfolio-slider-frames <?php echo $hclass;?> zn_slideshow">
                <?php echo $container_start;?>
				
					<?php echo $slider_desc;?>
                   
                    <div id="carousel-wrapper">
                        <div id="carousel" class="animating_frames">
						<?php
							if ( isset ( $options['single_pslides'] ) && is_array ( $options['single_pslides'] ) ) {	
								foreach ( $options['single_pslides'] as $slide ) {
								
									echo '<div>';
									
										if ( isset ( $slide['ps_slide_title'] ) && !empty ( $slide['ps_slide_title'] ) ) {
											$title = '<span class="project_title">'.$slide['ps_slide_title'].'</span>';
										}
									
										if ( isset ( $slide['ps_slide_link']['url'] ) && !empty ( $slide['ps_slide_link']['url'] ) )
										{
											$link = '<a class="project_url" href="'.$slide['ps_slide_link']['url'].'" target="'.$slide['ps_slide_link']['target'].'">'.$slide['ps_slide_link']['url'].'</a>';
										}
									
										// Front Image
										if ( isset ( $slide['ps_slide_image1'] ) && !empty ( $slide['ps_slide_image1'] ) ) {
											
											echo '<div class="img-front">';
											
												echo $title;
												echo $link;
												$image = vt_resize( '',$slide['ps_slide_image1'] , '460','320', true );
												echo '<img src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" alt="" />';
												
											echo '</div>';
										}
								
										// Right Image
										if ( isset ( $slide['ps_slide_image3'] ) && !empty ( $slide['ps_slide_image3'] ) ) {

												$image = vt_resize( '',$slide['ps_slide_image3'] , '460','320', true );
												echo '<img class="img-back" src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" alt="" />';

										}
									
										// Left Image
										if ( isset ( $slide['ps_slide_image2'] ) && !empty ( $slide['ps_slide_image2'] ) ) {

												$image = vt_resize( '',$slide['ps_slide_image2'] , '460','320', true );
												echo '<img class="img-back2" src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" alt="" />';

										}
									echo '</div>';
								
								}
							}
						?>
						</div>	
                        <a id="prev" href="#"><span class="icon-chevron-left icon-white"></span></a>
                        <a id="next" href="#"><span class="icon-chevron-right icon-white"></span></a>
                    </div><!-- end Carousel wrapper -->
                    
                <?php echo $container_end;?>
            </div>
            <div class="zn_header_bottom_style"></div>
        </div><!-- end slideshow -->
	
	<?php

					if ( $options['ps_sliding_direction'] == 'Vertical' ) {
						$zn_portfolio_slider = array ( 'zn_portfolio_slider' =>
							"
							(function($){
								var left = {
										imgFront	: 365,
										imgBack		: 365,
										imgBack2	: 365
									},
									current = {
										imgFront	: 0,
										imgBack		: 80,
										imgBack2	: 50
									},
									right = {
										imgFront	: 365,
										imgBack		: 365,
										imgBack2	: 365
									},
									cSpeed = 400,
									cEasing = 'easeOutExpo',
									isScrolling = false;

								$('#carousel').carouFredSel({
									scroll	: {
										duration		: -1,
										timeoutDuration	: 3000
									},
									auto	: false,
									prev	: {
										button		: '#prev',
										conditions	: function() {
											return (!isScrolling);
										},
										onBefore	: function( data ) {
											isScrolling = true;
											$(this).delay(900);
											
											data.items.old.find('.img-front').delay(700).animate({top: right.imgFront}, cSpeed, cEasing);
											data.items.old.find('img.img-back').delay(500).animate({top: right.imgBack}, cSpeed, cEasing);
											data.items.old.find('img.img-back2').delay(300).animate({top: right.imgBack2}, cSpeed, cEasing);
										},
										onAfter: function( data ) {
											
											data.items.old.find('.img-front').css({top: current.imgFront});
											data.items.old.find('img.img-back').css({top: current.imgBack});
											data.items.old.find('img.img-back2').css({top: current.imgBack2});
											data.items.visible.find('.img-front').css({top: left.imgFront}).delay(700).animate({top: current.imgFront}, cSpeed, cEasing, function() {
												isScrolling = false;
											});
											data.items.visible.find('img.img-back').css({top: left.imgBack}).delay(500).animate({top: current.imgBack}, cSpeed, cEasing);
											data.items.visible.find('img.img-back2').css({top: left.imgBack2}).delay(300).animate({top: current.imgBack2}, cSpeed, cEasing);
											
										}
									},
									next	: {
										button		: '#next',
										conditions	: function() {
											return (!isScrolling);
										},
										onBefore	: function( data ) {
											isScrolling = true;
											$(this).delay(900);	//	delay the onafter
											data.items.old.find('.img-front').animate({top: left.imgFront}, cSpeed, cEasing);
											data.items.old.find('img.img-back').delay(300).animate({top: left.imgBack}, cSpeed, cEasing);
											data.items.old.find('img.img-back2').delay(500).animate({top: left.imgBack2}, cSpeed, cEasing);
										},
										onAfter: function( data ) {
											data.items.old.find('.img-front').css({top: current.imgFront});
											data.items.old.find('img.img-back').css({top: current.imgBack});
											data.items.old.find('img.img-back2').css({top: current.imgBack2});
											
											data.items.visible.find('.img-front').css({top: right.imgFront}).animate({top: current.imgFront}, cSpeed, cEasing);
											data.items.visible.find('img.img-back').css({top: right.imgBack}).delay(200).animate({top: current.imgBack}, cSpeed, cEasing);
											data.items.visible.find('img.img-back2').css({top: right.imgBack2}).delay(300).animate({top: current.imgBack2}, cSpeed, cEasing, function() {
												isScrolling = false;
											});
											
											
										}
									}
									
								});
								
								if($('#carousel').hasClass('animating_frames')) {
									var _tf = $('#carousel .img-front'),
										_tb = $('#carousel img.img-back'),
										_tbl = $('#carousel img.img-back2'),
										_spd = 250, 
										_eas = 'easeOutExpo';
										
									_tb.hover(function(){
										$(this).animate({'margin-top':-40}, _spd, _eas);
										_tf.animate({'margin-left':-90}, _spd, _eas);
										_tbl.animate({'margin-left':-30}, _spd, _eas);
									},function(){
										$(this).animate({'margin-top':0}, _spd, _eas);
										_tf.animate({'margin-left':0}, _spd, _eas);
										_tbl.animate({'margin-left':0}, _spd, _eas);
									});
									_tbl.hover(function(){
										$(this).animate({'margin-top':-20}, _spd, _eas);
										_tf.animate({'margin-left':90}, _spd, _eas);
										_tb.animate({'margin-left':20}, _spd, _eas);
									},function(){
										$(this).animate({'margin-top':0}, _spd, _eas);
										_tf.animate({'margin-left':0}, _spd, _eas);
										_tb.animate({'margin-left':0}, _spd, _eas);
									}); 
								}
							})(jQuery);
						");
					}
					else {
						$zn_portfolio_slider = array ( 'zn_portfolio_slider' =>
							"
							(function($){
								var left = {
									imgFront	: -1200,
									imgBack		: -1200,
									imgBack2	: -1200
								}
								var current = {
									imgFront	: 261,
									imgBack		: 470,
									imgBack2	: 60
								}
								var right = {
									imgFront	: 2200,
									imgBack		: 2200,
									imgBack2	: 2200
								}
										
								var isScrolling = false;

								$('#carousel').carouFredSel({
									scroll	: {
										duration		: 0,
										timeoutDuration	: 3000
									},
									auto	: false,
									width: '100%',
									prev	: {
										button		: '#prev',
										conditions	: function() {
											return (!isScrolling);
										},
										onBefore	: function( data ) {
											isScrolling = true;
									
											$(this).delay(900);
									
											data.items.old.find('.img-front').delay(400).animate({left: right.imgFront});
											data.items.old.find('img.img-back').delay(300).animate({left: right.imgBack});
											data.items.old.find('img.img-back2').delay(200).animate({left: right.imgBack2});
										},
										onAfter: function( data ) {
											data.items.old.find('.img-front').css({left: current.imgFront});
											data.items.old.find('img.img-back').css({left: current.imgBack});
											data.items.old.find('img.img-back2').css({left: current.imgBack2});
											data.items.visible.find('.img-front').css({left: left.imgFront}).delay(400).animate({left: current.imgFront}, function() {
													isScrolling = false;
												});
											data.items.visible.find('img.img-back').css({left: left.imgBack}).delay(300).animate({left: current.imgBack});
											data.items.visible.find('img.img-back2').css({left: left.imgBack2}).delay(200).animate({left: current.imgBack2});
									
										}
									},
									next	: {
										button		: '#next',
										conditions	: function() {
											return (!isScrolling);
										},
										onBefore	: function( data ) {
											isScrolling = true;
									
											$(this).delay(900);	//	delay the onafter
											data.items.old.find('.img-front').animate({left: left.imgFront});
											data.items.old.find('img.img-back').delay(100).animate({left: left.imgBack});
											data.items.old.find('img.img-back2').delay(200).animate({left: left.imgBack2});
										},
										onAfter: function( data ) {
											data.items.old.find('.img-front').css({left: current.imgFront});
											data.items.old.find('img.img-back').css({left: current.imgBack});
											data.items.old.find('img.img-back2').css({left: current.imgBack2});
											
											data.items.visible.find('.img-front').css({left: right.imgFront}).animate({left: current.imgFront});
											data.items.visible.find('img.img-back').css({left: right.imgBack}).delay(100).animate({left: current.imgBack});
											data.items.visible.find('img.img-back2').css({left: right.imgBack2}).delay(200).animate({left: current.imgBack2}, function() {
												isScrolling = false;
											}); 
										}
									}
								});


							})(jQuery);
						");

					}
							zn_update_array( $zn_portfolio_slider );
	
	}
?>