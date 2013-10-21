<?php get_header(); ?>

<section id="content">
	<div class="container">
		<div id="mainbody">
					
<?php 
	$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

	global $data;

	// We have SORTABLE PORTFOLIO :)
	if( $data['portfolio_style'] == 'portfolio_sortable' ) {
?>

			<div class="row hg-portfolio ">
				
				<?php include(locate_template( 'template-helpers/loop-portfolio_sortable.php')); ?>

			</div><!-- end row -->

<?php } 
		elseif ( $data['portfolio_style'] == 'portfolio_carousel' ) {
			?>
				<div class="row">
						<div class="span12">
							<div class="row hg-portfolio-carousel">

							<?php 
								$i = 1;
								if ( have_posts() ): while ( have_posts() ): the_post(); 
								// Get post meta information
								$post_meta_fields = get_post_meta($post->ID, 'zn_meta_elements', true);
								$post_meta_fields = maybe_unserialize( $post_meta_fields );
							?>
								<div class="span6">
									<div class="ptcontent">
										<h3 class="title">
											<a href="<?php the_permalink(); ?>"><span class="name"><?php the_title(); ?></span></a>
										</h3>
										<div class="pt-cat-desc">
											<?php
												if ( preg_match('/<!--more(.*?)?-->/', $post->post_content) ) {
													
													the_content('');
												}
												else {
													
													the_excerpt();
												}
											?>
										</div><!-- end item desc -->
										<div class="itemLinks">
											<?php
												if ( !empty ( $post_meta_fields['sp_link']['url'] ) ) {
													echo '<span><a href="'.$post_meta_fields['sp_link']['url'].'" target="'.$post_meta_fields['sp_link']['target'].'" >'.__("Live Preview: ",THEMENAME).'<strong>'.$post_meta_fields['sp_link']['url'].'</strong></a></span>';
												}
											?>
											<span class="seemore">
												<a href="<?php the_permalink(); ?>" ><?php _e('See more &rarr;',THEMENAME);?></a>
											</span>
										</div><!-- end item links -->
									</div><!-- end item content -->
								</div>
								<div class="span6">
									<div class="ptcarousel">
										<div class="controls">
											<a href="#" class="prev"><span class="icon-chevron-left icon-white"></span></a>
											<a href="#" class="next"><span class="icon-chevron-right icon-white"></span></a>
										</div>
										<ul class="ptcarousel1">
										<?php

											if ( !empty ( $post_meta_fields['port_media'] ) && is_array( $post_meta_fields['port_media'] ) ) {
											
										
											
												foreach ( $post_meta_fields['port_media'] as $media ) {
													$size = zn_get_size( 'eight' );
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
															$image = vt_resize( '', $saved_image , $size['width'],'' , true );
														}
														
													}

													// Check to see if we have video
													if ( $portfolio_media = $media['port_media_video_comb'] ) {
														$portfolio_media = str_replace('', '&amp;', $portfolio_media);
													}

													// Display the media
													if ( !empty( $saved_image ) && $portfolio_media ) {
														echo '<li>';
															echo '<a href="'.$portfolio_media.'" data-type="video" rel="prettyPhoto" class="hoverLink">';
															echo '<img src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" '.$saved_alt.' '.$saved_title.' />';
															echo '</a>';
														echo '</li>';
													}
													elseif( !empty($saved_image) ){
														echo '<li>';
															echo '<a href="'.$saved_image.'" data-type="image" rel="prettyPhoto" class="hoverLink">';
															echo '<img src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" '.$saved_alt.' '.$saved_title.' />';
															echo '</a>';
														echo '</li>';
													}
													elseif( $portfolio_media ) {
														echo '<li>';
															echo get_video_from_link( $portfolio_media , '' , $size['width'] , $size['height'] );
														echo '</li>';
													}


					
												}
					
												}

											


										?>
										</ul>
									</div><!-- end ptcarousel -->
								</div>


								<?php
									if ( $i % $data['portfolio_per_page_show'] != 0 ) {

										echo '<div class="span12"><hr class="bs-docs-separator"></div>';

									}

									$i++;
								?>


							<?php endwhile; ?>
							<?php endif; ?>
								
							
							</div><!-- end portfolio layout -->
							<?php
								echo '<div class="clear"></div>';
								echo '<div class="span12" >';
									zn_pagination(); 
									wp_reset_query();
								echo '</div>';

								

							?>
						</div>
						</div>
	<?php 
	} 
	elseif ( $data['portfolio_style'] == 'portfolio_category' ) {

			if ( $data['ports_num_columns'] == '1' ) {
				echo '<div class="span12">';

				// Start the loop
				while( have_posts() ){
					
					the_post(); 
					
					// Get post meta information
					$post_meta_fields = get_post_meta($post->ID, 'zn_meta_elements', true);
					$post_meta_fields = maybe_unserialize( $post_meta_fields );
					



					echo '<div class="row">';
					echo '<div class="span6">';
					echo '<div class="img-intro">';
					
						if ( !empty ( $post_meta_fields['port_media'] ) && is_array( $post_meta_fields['port_media'] ) ) {
							
							$size = zn_get_size( 'eight' );
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
								echo '<a href="'.$portfolio_media.'" data-type="video" rel="prettyPhoto" class="hoverLink">';
								echo '<img src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" '.$saved_alt.' '.$saved_title.' />';
								echo '</a>';
							}
							elseif( !empty($saved_image) ){
								echo '<a href="'.$saved_image.'" data-type="image" rel="prettyPhoto" class="hoverLink">';
								echo '<img src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" '.$saved_alt.' '.$saved_title.' />';
								echo '</a>';
							}
							elseif( $portfolio_media ) {
								echo get_video_from_link( $portfolio_media , '' , $size['width'] , $size['height'] );
							}	
						}

					echo '</div><!-- img intro -->';
					echo '</div>';
						

					echo '<div class="span6">';
					echo '<h3 class="title">';
					echo '<a href="'.get_permalink().'" >'.get_the_title().'</a>';
					echo '</h3>';
					echo '<div class="pt-cat-desc">';

						the_content();

					echo '</div><!-- pt cat desc -->';
					echo '</div>';
					echo '</div><!-- end row -->';
					
					
				}

				echo '<div class="row zn_content_no_margin">';
				echo '<div class="span12">';
					zn_pagination(); 
					wp_reset_query();
				echo '</div>';
				echo '</div>';
				echo '</div>';
			}
			else {

				$proper_size = 12/$data['ports_num_columns'];
				$i = 1;
				echo '<div class="span12">';
				echo '<div class="row zn_content_no_margin">';

				// Start the loop
				while( have_posts() ){
					
					the_post(); 
					
					// Get post meta information
					$post_meta_fields = get_post_meta($post->ID, 'zn_meta_elements', true);
					$post_meta_fields = maybe_unserialize( $post_meta_fields );
					
					echo '<div class="span'.$proper_size.'">';
					echo '<div class="img-intro">';
					

						if ( !empty ( $post_meta_fields['port_media'] ) && is_array( $post_meta_fields['port_media'] ) ) {
							
							$size = zn_get_size( 'span'.$proper_size );
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
								echo '<a href="'.$portfolio_media.'" data-type="video" rel="prettyPhoto" class="hoverLink">';
								echo '<img src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" '.$saved_alt.' '.$saved_title.' />';
								echo '</a>';
							}
							elseif( !empty($saved_image) ){
								echo '<a href="'.$saved_image.'" data-type="image" rel="prettyPhoto" class="hoverLink">';
								echo '<img src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" '.$saved_alt.' '.$saved_title.' />';
								echo '</a>';
							}
							elseif( $portfolio_media ) {
								echo get_video_from_link( $portfolio_media , '' , $size['width'] , $size['height'] );
							}	
						}

						
					echo '</div><!-- img intro -->';
					
						

					
					echo '<h3 class="title">';
					echo '<a href="'.get_permalink().'" >'.get_the_title().'</a>';
					echo '</h3>';
					echo '<div class="pt-cat-desc">';

						if ( preg_match('/<!--more(.*?)?-->/', $post->post_content) ) {
							
							the_content('');
						}
						else {
							
							the_excerpt();
						}

					echo '</div><!-- pt cat desc -->';
					echo '</div>';

					if ( $i % $data['ports_num_columns'] == 0 && $i % $data['portfolio_per_page_show'] != 0 ) {

						echo '<div class="row"><div class="span12"><hr class="bs-docs-separator"></div></div>';

					}

					$i++;
					
				}

				echo '<div class="clear"></div>';

				echo '<div class="row"></div>';
				echo '<div class="span12" >';
					zn_pagination(); 
					wp_reset_query();
				echo '</div>';

				echo '</div><!-- end row -->';
				echo '</div>';
			}
	}

	?>






					
				</div><!-- end mainbody -->
				
			</div><!-- end container -->
		</section><!-- end #content -->

<?php get_footer(); ?>