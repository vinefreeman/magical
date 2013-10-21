<?php
/*--------------------------------------------------------------------------------------------------
	STATIC CONTENT - Simple text
--------------------------------------------------------------------------------------------------*/
 
	function _static9($options)
	{
	?>
        <div id="slideshow" class="nobg">

                <div class="container">
                	<div class="static-content simple">
                    	
						<div class="row">
							<div class="span12">
								<?php

									echo do_shortcode($options['sc_sc']);

									if (!empty( $options['sc_button_text'] ) && !empty( $options['sc_button_link']['url'] ) ) {
										

										echo '<a href="'.$options['sc_button_link']['url'].'" target="'.$options['sc_button_link']['target'].'" class="btn btn-large btn-flat">'.$options['sc_button_text'].'</a><span class="line"></span>';

									}

								?>
                               
                                
							</div>
						</div><!-- end row -->
                    </div><!-- end static content -->
                </div>

        </div><!-- end slideshow -->
	<?php
	}
?>