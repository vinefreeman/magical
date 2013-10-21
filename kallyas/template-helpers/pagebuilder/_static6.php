<?php
/*--------------------------------------------------------------------------------------------------
	STATIC CONTENT - Product Loupe
--------------------------------------------------------------------------------------------------*/
 
	function _static6($options)
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
                	<div class="static-content productzoom-style">
                        <div class="row">
                            <div class="span5">
							<?php
								// TITLE
								if ( !empty ( $options['sc_title'] ) ) {
									echo '<h3>'.do_shortcode( $options['sc_title'] ).'</h3>';
								}
							
								// FEATURES LIST
								if ( !empty ( $options['sc_lp_features'] ) ) {
								
									echo '<ul class="features">';
								
										$textAr = explode("\n", $options['sc_lp_features']);
										foreach ($textAr as $index=>$line) {
											echo '<li><span class="icon-ok icon-white"></span> '.$line.'</li>';
										} 
								
									echo '</ul>';
								}
							
								// First Button
								if ( !empty ( $options['sc_lp_button1'] ) && isset ( $options['sc_lp_button1_link']['url'] ) && !empty ( $options['sc_lp_button1_link']['url'] )  ) {
									echo '<a target="'.$options['sc_lp_button1_link']['target'].'" href="'.$options['sc_lp_button1_link']['url'].'" class="'.$options['sc_lp_button1_style'].' btn-large"><span class="'.$options['sc_lp_button1_icon'].' '.$options['sc_lp_button1_icon_style'].'"></span> '.$options['sc_lp_button1'].'</a> ';
								}
							
								if ( !empty ( $options['sc_lp_button1'] ) && !empty ( $options['sc_2p_button1'] ) && !empty ( $options['sc_bt_text'] ) ) {
									echo '<span class="or">'.$options['sc_bt_text'].'</span> ';
								}
								
								// Second Button
								if ( !empty ( $options['sc_2p_button1'] ) && isset ( $options['sc_lp_button2_link']['url'] ) && !empty ( $options['sc_lp_button2_link']['url'] )  ) {
									echo '<a target="'.$options['sc_lp_button2_link']['target'].'" href="'.$options['sc_lp_button2_link']['url'].'" class="'.$options['sc_lp_button2_style'].' btn-large"><span class="'.$options['sc_lp_button2_icon'].' '.$options['sc_lp_button2_icon_style'].'"></span> '.$options['sc_2p_button1'].'</a> ';
								}
							
								echo '</div>';
							
								// IMAGE
								if ( isset ( $options['sc_lp_image'] ) && !empty ( $options['sc_lp_image'] ) ) {
								
									echo '<div class="span7">';
										echo '<div id="screenshot">';
											echo '<div class="image">';
												
												$image = vt_resize( '',$options['sc_lp_image'] , '620','390', true );
												echo '<img src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" data-full="'.$options['sc_lp_image'].'" />';
												
												echo '<div class="loupe"></div>';	
											echo '</div>';	
										echo '</div>';	
									echo '</div>';	
								}
							
							
							?>

                        	

                        </div><!-- end row -->
                    </div>
                </div>
				
				<div class="zn_header_bottom_style"></div><!-- header bottom style -->

        </div><!-- end slideshow -->
	<?php
	}
?>