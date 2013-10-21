<?php
/*--------------------------------------------------------------------------------------------------
	TESTIMONIALS SLIDER
--------------------------------------------------------------------------------------------------*/
 
	function _testimonial_slider2( $options )
	{
		
		$element_size = zn_get_size( $options['_sizer'] );
		
		$new_size = $element_size['sizer'];
		
		echo '<div class="'.$element_size['sizer'].'">';
		
			echo '<div class="testimonials-carousel">';
			
				if ( !empty ( $options['tf_title'] ) ) {
					echo '<h3 class="m_title">'.$options['tf_title'].'</h3>';
				}
			
				echo '<div class="controls">';
					echo '<a href="#" class="prev"><span class="icon-chevron-left"></span></a>';
					echo '<a href="#" class="next"><span class="icon-chevron-right"></span></a>';
				echo '</div>';
			
				if ( !empty ( $options['testimonials_slider_single'] ) && is_array ( $options['testimonials_slider_single'] ) ) {
				
					echo '<ul id="testimonials_carousel" class="zn_testimonials_carousel fixclear">';
				
					foreach ( $options['testimonials_slider_single'] as $test ) {
						if ( !empty ( $test['tf_single_test'] ) ) {
							echo '<li>';
							
								echo '<blockquote>'.do_shortcode($test['tf_single_test']).'</blockquote>';
								echo '<h5>'.$test['tf_single_author'].'</h5>';
							
							echo '</li>';
						}
						
					}
					
					echo '</ul>';
					
				}
			
			echo '</div>';
		
		echo '</div>';

		$speed = 'auto: true,';
		if ( !empty($options['tf_speed']) ) { $speed = 'auto:{timeoutDuration:'.$options['tf_speed'].'},'; }

		$testimonial_slider2 = array ( 'zn_testimonial_slider2' =>
				"
				jQuery(window).load(function() {
				// ** Testimonials carousel
				jQuery('.zn_testimonials_carousel').carouFredSel({
					responsive: true,

					items: {
						width: 300
					},
					".$speed."
					
					prev	: {	
						button	: function(){return jQuery(this).closest('.testimonials-carousel').find('.prev');},
						key		: \"left\"
					},
					next	: { 
						button	: function(){return jQuery(this).closest('.testimonials-carousel').find('.next');},
						key		: \"right\"
					}
				});
				// *** end testimonials carousel
				});
		");
				
		zn_update_array( $testimonial_slider2 );

	}
?>