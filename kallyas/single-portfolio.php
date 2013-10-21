<?php get_header(); 

	// GET GLOBALS
	global $content_and_sidebar;

	// GET THE METAFIELDS
	$meta_fields = get_post_meta($post->ID, 'zn_meta_elements', true);
	$meta_fields = maybe_unserialize( $meta_fields );

/*--------------------------------------------------------------------------------------------------
	ACTION BOX AREA
--------------------------------------------------------------------------------------------------*/
	zn_get_template_from_area ('action_box_area',$post->ID,$meta_fields);



?>
		<section id="content">
			<?php if ( $content_and_sidebar ) { ?>
			<div class="container">
				
				<div id="mainbody">
					
					<div class="row">
						<div class="span12">
						
							<?php while(have_posts()) : the_post(); 
							
								// GET POST OPTIONS 
								$post_meta_fields = get_post_meta($post->ID, 'zn_meta_elements', true);
								$post_meta_fields = maybe_unserialize( $post_meta_fields );
									
								// Sidebar check 
								$has_sidebar = false;
									
								// TITLE CHECK
								if ( isset ( $post_meta_fields['page_title_show'] ) && $post_meta_fields['page_title_show'] == 'yes' ) {
									echo '<h1 class="page-title">'.get_the_title().'</h1>';
								}
									
							?>

							<div class="hg-portfolio-item row">
                                
                                <div class="text span7">
									<?php the_content(''); ?>
                                </div><!-- end text -->
								
                                <div class="img-full span5">
								
								<?php
									if ( !empty ( $post_meta_fields['port_media'] ) && is_array( $post_meta_fields['port_media'] ) ) {

										$all_media = count( $post_meta_fields['port_media'] );
										$size = zn_get_size( 'span5',$has_sidebar );
										$has_image = false;

										// Modified portfolio display
										// Check to see if we have images
										if ( $portfolio_image = $post_meta_fields['port_media']['0']['port_media_image_comb'] ) {

											if ( is_array( $portfolio_image ) ) {

												if ( $saved_image = $portfolio_image['image'] ) {
													if ( !empty( $portfolio_image['alt'] ) ) {
														$saved_alt = 'alt="'.$portfolio_image['alt'].'"';
													}
													else {
														$saved_alt = '';
													}

													if ( !empty( $portfolio_image['title'] ) ){
														$saved_title = 'title="'.$portfolio_image['title'].'"';
													}
													else {
														$saved_title = '';
													}

													$has_image = true;
												}


											}
											else {
												$saved_image = $portfolio_image;
												$has_image = true;
												$saved_alt = '';
												$saved_title = '';
											}

											if ( $has_image ) {
												$image = vt_resize( '', $saved_image , $size['width'],'' , true );
											}
											

										}

										// Check to see if we have video
										if ( $portfolio_media = $post_meta_fields['port_media']['0']['port_media_video_comb'] ) {

										}

										// Display the media
										if ( !empty( $saved_image ) && $portfolio_media ) {
											echo '<a href="'.$portfolio_media.'" rel="prettyPhoto" class="hoverBorder">';
											echo '<img src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" '.$saved_alt.' '.$saved_title.' />';
											echo '</a>';
										}
										elseif( !empty($saved_image) ){
											echo '<a href="'.$saved_image.'" rel="prettyPhoto" class="hoverBorder">';
											echo '<img src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" '.$saved_alt.' '.$saved_title.' />';
											echo '</a>';
										}
										elseif( $portfolio_media ) {
											echo get_video_from_link( $portfolio_media , '' , $size['width'] , $size['height'] );
										}

										unset( $post_meta_fields['port_media']['0'] );
									}
								?>	
                                    <div class="clear"></div>
                                
								<?php
									if ( !empty ( $post_meta_fields['sp_link']['url'] ) || !empty ( $post_meta_fields['sp_col'] ) ) { 
									
										echo '<div class="itemLinks">';
									
											if ( !empty ( $post_meta_fields['sp_link']['url'] ) ) {
												echo '<p><a href="'.$post_meta_fields['sp_link']['url'].'" target="'.$post_meta_fields['sp_link']['target'].'" >'.__("Live Preview: ",THEMENAME).'<strong>'.$post_meta_fields['sp_link']['url'].'</strong></a></p>';
											}
											
											if ( !empty ( $post_meta_fields['sp_col'] ) ) {
												echo '<p>'.__("Our collaborators: ",THEMENAME).'<strong>'.$post_meta_fields['sp_col'].'</strong></p>';
											}
											
											echo '<p>'.__("Category: ",THEMENAME).'<strong>'. get_the_term_list( $post->ID, 'project_category', '', ' , ', '' ) .'</strong></p>';
											
										echo '</div>';
										
									}
								?>
                                
								<?php 
									if ( !empty ( $post_meta_fields['sp_show_social'] ) && $post_meta_fields['sp_show_social'] == 'yes' ) {
								?>
                                    <div class="itemSocialSharing fixclear">
                                        
                                        <!-- Twitter Button -->
                                        <div class="itemTwitterButton">
                                            <a href="https://twitter.com/share" class="twitter-share-button" data-count="horizontal">Tweet</a>
                                            <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
                                        </div>
                                        
                                        <!-- Facebook Button -->
                                        <div class="itemFacebookButton">
                                            <div id="fb-root"></div>
                                            <script type="text/javascript">
                                                (function(d, s, id) {
                                                var js, fjs = d.getElementsByTagName(s)[0];
                                                if (d.getElementById(id)) {return;}
                                                js = d.createElement(s); js.id = id;
                                                js.src = "http://connect.facebook.net/en_US/all.js#appId=177111755694317&xfbml=1";
                                                fjs.parentNode.insertBefore(js, fjs);
                                                }(document, 'script', 'facebook-jssdk'));
                                            </script>
                                            <div class="fb-like" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false"></div>
                                        </div>
                                        
                                        <!-- Google +1 Button -->
                                        <div class="itemGooglePlusOneButton">	
                                            <g:plusone size="medium"></g:plusone>
                                            <script type="text/javascript">
                                                (function() {
                                                window.___gcfg = {lang: 'en'}; // Define button default language here
                                                var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                                                po.src = 'https://apis.google.com/js/plusone.js';
                                                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                                                })();
                                            </script>
                                        </div>
                                        
                                        <div class="clr"></div>
                                    </div><!-- social links -->
                                
								<?php
									}
								?>
								
                                </div><!-- right side -->


                                <div class="clear"></div>

								<?php
									if ( !empty ( $post_meta_fields['port_media'] ) && is_array( $post_meta_fields['port_media'] ) ) {
									
										echo '<div class="zn_other_images">';
									
										$size = zn_get_size( 'four',$has_sidebar );

										foreach ( $post_meta_fields['port_media'] as $media ) {

											$has_image = false;

											// Modified portfolio display
											// Check to see if we have images
											if ( $portfolio_image = $media['port_media_image_comb'] ) {

												if ( is_array( $portfolio_image ) ) {

													if ( $saved_image = $portfolio_image['image'] ) {

														if ( !empty( $portfolio_image['alt'] ) ) {
															$saved_alt = 'alt="'.$portfolio_image['alt'].'"';
														}
														else {
															$saved_alt = '';
														}

														if ( !empty( $portfolio_image['title'] ) ){
															$saved_title = 'title="'.$portfolio_image['title'].'"';
														}
														else {
															$saved_title = '';
														}

															$has_image = true;
													}

												}
												else {
													$saved_image = $portfolio_image;
													$has_image = true;
													$saved_alt = '';
													$saved_title = '';
												}

												if ( $has_image ) {
													$image = vt_resize( '', $saved_image , $size['width'],'202' , true );
												}
												
											} // END PORTFOLIO IMAGE

											// Check to see if we have video
											if ( $portfolio_media = $media['port_media_video_comb'] ) {

											}

											// Display the media
											if ( !empty( $saved_image ) && $portfolio_media ) {
												echo '<div class="span3">';
													echo '<a href="'.$portfolio_media.'" rel="prettyPhoto" class="hoverBorder">';
													echo '<img src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" '.$saved_alt.' '.$saved_title.' />';
													echo '</a>';
												echo '</div>';
											}
											elseif( !empty($saved_image) ){
												echo '<div class="span3">';
													echo '<a href="'.$saved_image.'" rel="prettyPhoto" class="hoverBorder">';
													echo '<img src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" '.$saved_alt.' '.$saved_title.' />';
													echo '</a>';
												echo '</div>';
											}
											elseif( $portfolio_media ) {
												echo '<div class="span3">';
													echo get_video_from_link( $portfolio_media , '' , $size['width'] , '202' );
												echo '</div>';
											}
										}
										
										echo '<div class="clear"></div>';
										echo '</div>';
									}
								?>
								
                            
                            </div><!-- end Portfolio page -->
							
							<?php endwhile; wp_reset_query(); ?>
							
						</div>
					</div><!-- end row -->
					
				</div><!-- end mainbody -->
				
			</div><!-- end container -->
		<?php } ?>
<?php

/*--------------------------------------------------------------------------------------------------
	START CONTENT AREA 
--------------------------------------------------------------------------------------------------*/
	if ( isset ( $meta_fields['content_main_area'] ) && is_array ( $meta_fields['content_main_area'] ) ) {
		echo '<div class="container">';
			zn_get_template_from_area ('content_main_area',$post->ID,$meta_fields);
		echo '</div>';
	}

/*--------------------------------------------------------------------------------------------------
	START GRAY AREA
--------------------------------------------------------------------------------------------------*/
				
	$cls = '';
	if ( !isset ( $meta_fields['content_bottom_area'] ) || !is_array ( $meta_fields['content_bottom_area'] ) ) {
		$cls = 'noMargin';
	}

	if ( isset ( $meta_fields['content_grey_area'] ) && is_array ( $meta_fields['content_grey_area'] ) ) {
	echo '<div class="gray-area '.$cls.'">';
		echo '<div class="container">';
		
			zn_get_template_from_area ('content_grey_area',$post->ID,$meta_fields);
		
		echo '</div>';
	echo '</div>';
	}
				

		
		
/*--------------------------------------------------------------------------------------------------
	START BOTTOM AREA
--------------------------------------------------------------------------------------------------*/
		

	if ( isset ( $meta_fields['content_bottom_area'] ) && is_array ( $meta_fields['content_bottom_area'] ) ) {
		echo '<div class="container">';
			zn_get_template_from_area ('content_bottom_area',$post->ID,$meta_fields);
		echo '</div>';
	}
?>

		</section><!-- end #content -->
			

<?php get_footer(); ?>