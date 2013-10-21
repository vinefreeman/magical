<?php
/*--------------------------------------------------------------------------------------------------
	STATIC CONTENT - Boxes
--------------------------------------------------------------------------------------------------*/
 
	function _static2($options)
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
		
			<div class="zn_slideshow">
                <div class="container">
                	<div class="static-content boxes-style">
                    <?php
						// TITLE
						if ( isset ( $options['ww_slide_title'] ) && !empty ( $options['ww_slide_title'] ) ) {
							echo '<h3 class="centered">'.do_shortcode($options['ww_slide_title']).'</h3>';
						}
						
						echo '<div class="boxes row">';
						
						if ( !empty ( $options['ww_box1_title'] ) || !empty ( $options['ww_box1_image'] ) || !empty ( $options['ww_box1_desc'] ) ) {
						
							echo '<div class="span4">';
								echo '<div class="info_pop">';
								
									if ( !empty ( $options['ww_box1_title'] ) || !empty ( $options['ww_box1_image'] ) ) {
										echo '<h4 class="title">';
										
										if ( !empty ( $options['ww_box1_image'] ) ) {
											echo '<img src="'.$options['ww_box1_image'].'" alt="'.$options['ww_box1_title'].'"/>';
										}
										if ( !empty ( $options['ww_box1_title'] ) ) {
											echo $options['ww_box1_title'];
										}

										echo '</h4>';
									}
									
									if ( !empty ( $options['ww_box1_desc'] ) ) {
										echo '<p>'.$options['ww_box1_desc'].'</p>';
									}
								
								echo '</div>';
							echo '</div>';
							
						}
						
						if ( !empty ( $options['ww_box2_title'] ) || !empty ( $options['ww_box2_image'] ) || !empty ( $options['ww_box2_desc'] ) ) {
						
							echo '<div class="span4">';
								echo '<div class="info_pop">';
								
									if ( !empty ( $options['ww_box2_title'] ) || !empty ( $options['ww_box2_image'] ) ) {
										echo '<h4 class="title">';
										
										if ( !empty ( $options['ww_box2_image'] ) ) {
											echo '<img src="'.$options['ww_box2_image'].'" alt="'.$options['ww_box2_title'].'"/>';
										}
										if ( !empty ( $options['ww_box2_title'] ) ) {
											echo $options['ww_box2_title'];
										}

										echo '</h4>';
									}
									
									if ( !empty ( $options['ww_box2_desc'] ) ) {
										echo '<p>'.$options['ww_box2_desc'].'</p>';
									}
								
								echo '</div>';
							echo '</div>';
							
						}
						
						if ( !empty ( $options['ww_box3_title'] ) || !empty ( $options['ww_box3_image'] ) || !empty ( $options['ww_box3_desc'] ) ) {
						
							echo '<div class="span4">';
								echo '<div class="info_pop">';
								
									if ( !empty ( $options['ww_box3_title'] ) || !empty ( $options['ww_box3_image'] ) ) {
										echo '<h4 class="title">';
										
										if ( !empty ( $options['ww_box3_image'] ) ) {
											echo '<img src="'.$options['ww_box3_image'].'" alt="'.$options['ww_box3_title'].'"/>';
										}
										if ( !empty ( $options['ww_box3_title'] ) ) {
											echo $options['ww_box3_title'];
										}

										echo '</h4>';
									}
									
									if ( !empty ( $options['ww_box3_desc'] ) ) {
										echo '<p>'.$options['ww_box3_desc'].'</p>';
									}
								
								echo '</div>';
							echo '</div>';
							
						}
						
						echo '</div>';
						
					?>

                        <script type="text/javascript">
						(function($){
                        	var boxes = $('.static-content .boxes');
							boxes.children().hover(function () {
								var _t = $(this);
								_t.animate({'margin-top':-10}, {duration:500, queue:false, easing:'easeOutExpo'});
								_t.siblings().animate({opacity:0.4}, {duration:500, queue:false, easing:'easeOutExpo'});
							},
							function () {
								var _t = $(this);
								_t.animate({'margin-top':0}, {duration:400, queue:false, easing:'easeOutExpo'});
								_t.siblings().animate({opacity:1}, {duration:400, queue:false, easing:'easeOutExpo'});
							});
						})(jQuery);
                        </script>
                    </div>
                </div>
			</div>
			
			<div class="zn_header_bottom_style"></div><!-- header bottom style -->
			
        </div><!-- end slideshow -->
	<?php
	}
?>