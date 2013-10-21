<?php
/*--------------------------------------------------------------------------------------------------
	STATIC CONTENT - TEXT AND REGISTER
--------------------------------------------------------------------------------------------------*/
 
	function _static10($options)
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
                	<div class="static-content default-style with-login">
                    	
						<div class="row">
							<div class="span7">
								<?php
									if (!empty($options['ww_slide_title'])) {
										echo '<h2>'.do_shortcode( $options['ww_slide_title'] ).'</h2>';
									}

									if (!empty( $options['ww_slide_subtitle'] )) {
										echo '<h3>'.do_shortcode( $options['ww_slide_subtitle'] ).'</h3>';
									}

									if ( !empty( $options['ww_slide_m_button'] ) && !empty ( $options['ww_slide_l_text'] ) && !empty($options['ww_slide_link']['url']) ) {

										echo '<div class="info_pop animated fadeBoxIn left" data-arrow="top">';
										echo '<a href="'.$options['ww_slide_link']['url'].'" target="'.$options['ww_slide_link']['url'].'" class="buyit">'.$options['ww_slide_l_text'].'</a>';
										echo '<h5 class="text">'.$options['ww_slide_m_button'].'</h5>';
										echo '<div class="clear"></div>';
										echo '</div>';

									}

								?>

							</div>
							<div class="span5">
								<div class="fancy_register_form">
                                	<h4 style="text-align:center"><?php _e("Create <strong>your account</strong> now",THEMENAME);?></h4>
										<form id="register_form_static" name="login_form" method="post" class="zn_form_login" action="<?php echo site_url('wp-login.php?action=register', 'login_post') ?>">
	                                    	<div>
	                                        	<label for="reg-username"><?php _e("Username",THEMENAME);?></label>
	                                            <input type="text" id="reg-username" name="user_login" class="inputbox" required placeholder="<?php _e("Username",THEMENAME);?>">
	                                        </div>
	                                        <div>
	                                        	<label for="reg-email"><?php _e("Email",THEMENAME);?></label>
	                                            <input type="email" id="reg-email" name="user_email" class="inputbox required" placeholder="<?php _e("Your email",THEMENAME);?>">
	                                        </div>
	                                        <div>
	                                        	<label for="reg-pass"><?php _e("Your password",THEMENAME);?></label>
	                                            <input type="password" id="reg-pass" name="user_password" class="inputbox" required placeholder="<?php _e("Your password",THEMENAME);?>">
	                                        </div>
	                                        <div>
	                                        	<label for="reg-pass2"><?php _e("Verify password",THEMENAME);?></label>
	                                            <input type="password" id="reg-pass2" name="user_password2" class="inputbox" required placeholder="<?php _e("Verify password",THEMENAME);?>">
	                                        </div>
											<div style="margin-bottom:0;">
												<input type="submit" id="signup" name="submit" class="zn_sub_button btn btn-danger"  value="<?php _e("REGISTER",THEMENAME);?>">
											</div>
											<input type="hidden" value="register" class="" name="zn_form_action">
											<input type="hidden" value="zn_do_login" class="" name="action">
											<input type="hidden" value="<?php echo $_SERVER['PHP_SELF'] ?>" class="zn_login_redirect" name="submit">
											<div class="links"></div>
										</form>
                                </div>
							</div>
						</div><!-- end row -->
                        
                    </div><!-- end static content -->
                </div>
			
			<div class="zn_header_bottom_style"></div><!-- header bottom style -->
			
        </div><!-- end slideshow -->
	<?php
	}
?>