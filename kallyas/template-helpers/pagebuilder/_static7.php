<?php
/*--------------------------------------------------------------------------------------------------
	STATIC CONTENT - Event Countdown
--------------------------------------------------------------------------------------------------*/
 
	function _static7($options)
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
                	<div class="static-content event-style">
                        <div class="row">
                        	<div class="span7">
							<?php 
								// TITLE
								if ( isset ( $options['sc_ec_title'] ) && !empty ( $options['sc_ec_title'] ) ) {
									echo '<h3>'.do_shortcode($options['sc_ec_title']).'</h3>';
								}
							?>

								
								<div class="ud_counter">
                                    <ul id="Counter">
                                        <li>0<span>day</span></li>
                                        <li>00<span>hours</span></li>
                                        <li>00<span>min</span></li>
                                        <li>00<span>sec</span></li>
                                    </ul>
									<?php echo '<span class="till_lauch"><img src="'.MASTER_THEME_DIR.'/images/rocket.png"></span>'; ?>
                                </div><!-- end counter -->

								
								
								<?php
								
								if ( !empty ( $options['sc_ec_mlid'] ) ) {
								
									echo '<div class="mail_when_ready">';
									echo	'		<form method="post" class="newsletter_subscribe newsletter-signup" data-url="'.trailingslashit(home_url()).'" name="newsletter_form">';
									echo	'			<input type="text" name="zn_mc_email" class="nl-email" value="" placeholder="'.__("your.address@email.com",THEMENAME).'" />';
									echo	'			<input type="hidden" name="zn_list_class" class="nl-lid" value="'.$options['sc_ec_mlid'].'" />';
									echo	'			<input type="submit" name="submit" class="nl-submit" value="'.__("JOIN US",THEMENAME).'" />';
									echo	'		</form>';
									echo 	'<span class="zn_mailchimp_result"></span>';
									echo 	'</div>';
									
								}
									
								if ( !empty ( $options['sc_ec_mlid'] ) && isset( $options['single_ec_social'] ) && is_array( $options['single_ec_social'] ) ) {
									echo 	'<span class="or">'.__("-or stay connected: ",THEMENAME).'</span>';
								}
									
								if ( isset( $options['single_ec_social'] ) && is_array( $options['single_ec_social'] ) ) {
								
									$icon_class = '';
									
									
									if( $options['sc_ec_social_color'] == 'colored' ) { 
										$icon_class = 'colored';
									}
									
									echo '<ul class="social-icons '.$icon_class.' fixclear">';
										
										foreach ( $options['single_ec_social'] as $key=>$icon ){
										
											$link = '';
											$target = '';
										
											if ( isset ( $icon['sc_ec_social_link'] ) && is_array ( $icon['sc_ec_social_link'] )) {
												$link = $icon['sc_ec_social_link']['url'];
												$target = 'target="'.$icon['sc_ec_social_link']['target'].'"';
											}
											
										
											echo '<li class="'.$icon['sc_ec_social_icon'].'"><a href="'.$link.'" '.$target.'>'.$icon['sc_ec_social_title'].'</a></li>';
										}
										
									echo '</ul>';
									
								}
									
								?>

                                <div class="clear"></div>
                                
                            </div>
							
							<?php
							
								echo '<div class="span5">';
							
								// Text
								if ( isset ( $options['sc_ec_vid_desc'] ) && !empty ( $options['sc_ec_vid_desc'] ) ) {
									echo '<h5 style="text-align:right;">'.$options['sc_ec_vid_desc'].'</h5>';
								}
								
							
							
								// VIDEO
								if ( isset ( $options['sc_ec_vime'] ) && !empty ( $options['sc_ec_vime'] ) ) {
									echo get_video_from_link ( $options['sc_ec_vime'] ,'black_border full_width' ,'520px','270px');
								}
								
								echo '</div>';
							?>
							
                            
                            	
				
                            
                        </div>
                    </div><!-- end static content / event style -->
                </div>
			</div>
			
			<div class="zn_header_bottom_style"></div><!-- header bottom style -->
			
        </div><!-- end slideshow -->
	<?php

		$zn_event_countdown = array ( 'zn_event_countdown' =>
			"
				var counter = {
					init: function (d)
					{
						jQuery('#Counter').countdown({
							until: new Date(d),
							layout: counter.layout(),
							labels: ['".__('years',THEMENAME)."', '".__('months',THEMENAME)."', '".__('weeks',THEMENAME)."', '".__('days',THEMENAME)."', '".__('hours',THEMENAME)."', '".__('min',THEMENAME)."', '".__('sec',THEMENAME)."'],
							labels1: ['".__('year',THEMENAME)."', '".__('month',THEMENAME)."', '".__('week',THEMENAME)."', '".__('day',THEMENAME)."', '".__('hour',THEMENAME)."', '".__('min',THEMENAME)."', '".__('sec',THEMENAME)."']
						});
					},
					layout: function ()
					{
						return '<li>{dn}<span>{dl}</span></li>' + 
									'<li>{hnn}<span>{hl}</span></li>' + 
									'<li>{mnn}<span>{ml}</span></li>' + 
									'<li>{snn}<span>{sl}</span></li>';
					}
				}

				// initialize the counter
				counter.init(\"".$options['sc_ec_date']['date']." ".$options['sc_ec_date']['time']."\");
			");
				
				zn_update_array( $zn_event_countdown );

					$zn_mailchimp = array ( 'zn_mailchimp' =>
						"// PREPARE THE NEWSLETTER AND SEND DATA TO MAILCHIMP
						jQuery('.nl-submit').click(function() {

							ajax_url = jQuery(this).parent().attr('data-url');
							result_placeholder = jQuery(this).parent().next('span.zn_mailchimp_result');


							jQuery.ajax({
								url: ajax_url,
								type: 'POST',
								data: {
									zn_mc_email: jQuery(this).prevAll('.nl-email').val(),
									zn_mailchimp_list: jQuery(this).prev('.nl-lid').val(),
									zn_ajax: '' // Change here with something different
								},
								success: function(data){
									result_placeholder.html(data);
									
								},
								error: function() {
									result_placeholder.html('ERROR.').css('color', 'red');
								}
							});
							return false;
						});
					");
					
					zn_update_array( $zn_mailchimp );

	}
?>