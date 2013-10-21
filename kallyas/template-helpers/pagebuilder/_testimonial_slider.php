<?php

/*--------------------------------------------------------------------------------------------------

	TESTIMONIALS FADER Box

--------------------------------------------------------------------------------------------------*/

 

	function _testimonial_slider($options)

	{

		

		$element_size = zn_get_size( $options['_sizer'] );

		

		$new_size = $element_size['sizer'];

		

		if ( !empty ( $options['tf_title'] ) || !empty ( $options['tf_desc'] ) ) {

			preg_match('|\d+|', $element_size['sizer'] , $new_size);

			$new_size = $new_size[0]-3;

			$new_size = 'span'.$new_size;

			

			echo '<div class="span3 testimonials_fader">';

			

				if ( !empty ( $options['tf_title'] ) ) {

					echo '<h3 class="m_title">'.$options['tf_title'].'</h3>';

				}

				

				if ( !empty ( $options['tf_desc'] ) ) {

					echo '<p>'.$options['tf_desc'].'</p>';

				}

			

			echo '</div>';



		}

		

		echo '<div class="'.$new_size.' testimonials_fader">';

			echo '<ul id="testimonials_fader" class="fixclear">';

				foreach ( $options['testimonials_single'] as $test ) {

					echo '<li>';

					

						echo '<blockquote>'.$test['tf_single_test'].'</blockquote>';

						echo '<h6>'.$test['tf_single_author'].'</h6>';

					

					echo '</li>';

				}

		

		echo '</ul>';

		echo '</div>';

		$speed = 'auto: {timeoutDuration: 5000},';

		if ( !empty($options['tf_speed']) ) { $speed = 'auto:{timeoutDuration:'.$options['tf_speed'].'},'; }





		$testimonial_slider = array ( 'zn_testimonial_slider' =>

				"	

					// ** Testimonials fader

					jQuery('#testimonials_fader').carouFredSel({

						responsive:true,

						".$speed."

						scroll: { fx: \"fade\", duration: \"1500\" }

					});

					// *** end testimonials fader

				;");

				

		zn_update_array( $testimonial_slider );



	}

?>