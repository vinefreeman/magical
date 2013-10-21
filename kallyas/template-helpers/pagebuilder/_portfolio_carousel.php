<?php
/*--------------------------------------------------------------------------------------------------
	Portfolio Carousel Layout
--------------------------------------------------------------------------------------------------*/
 
	function _portfolio_carousel( $options )
	{
	
		
		$element_size = zn_get_size( $options['_sizer'] );
	
		
		global $post;

		
		$posts_per_page = isset($options['ports_per_page']) ? $options['ports_per_page'] : '4'; // how many posts

		$query = array(
			'post_type' => 'portfolio',
			'paged' => (get_query_var('paged')) ? get_query_var('paged') : 1,
			'posts_per_page' =>  $posts_per_page,
			'tax_query' => array(
				array(
					'taxonomy' => 'project_category',
					'field' => 'id',
					'terms' =>  $options['portfolio_categories']
				)
			),
			'showposts' => $options['ports_per_page_visible']
		);




		// Start the query
		query_posts( $query );
		$i = 1;

		?>
						<div class="span12">
							

							<?php if ( have_posts() ): while ( have_posts() ): the_post(); 
								// Get post meta information
								$post_meta_fields = get_post_meta($post->ID, 'zn_meta_elements', true);
								$post_meta_fields = maybe_unserialize( $post_meta_fields );
							?>
							<div class="row-fluid hg-portfolio-carousel">
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
									if ( $i % $options['ports_per_page_visible'] != 0 ) {

										echo '<div class="span12"><hr class="bs-docs-separator"></div>';

									}

									$i++;
								?>
								</div><!-- end portfolio layout -->

							<?php endwhile; ?>
							<?php endif;   ?>
								
							
							
							<?php
								echo '<div class="clear"></div>';
								echo '<div class="span12" >';
									zn_pagination(); 
									wp_reset_query();
								echo '</div>';

								

							?>
						</div>
		<?php
		$zn_pcarousel = array ( 'zn_pcarousel' =>
			"
				(function($) {
					$(window).load(function(){
						// ** Portfolio Carousel
						var carousels =	jQuery('.ptcarousel1');
						carousels.each(function(index, element) {
							$(this).carouFredSel({
								responsive: true,
								items: { width: 570 },
								prev	: {	button : $(this).parent().find('a.prev'), key : \"left\" },
								next	: { button : $(this).parent().find('a.next'), key : \"right\" },
								auto: {timeoutDuration: 5000},
								scroll: { fx: \"crossfade\", duration: \"1500\" }
							});	
						});
						// *** end Portfolio Carousel
					});
				})(jQuery);
			");
			
			zn_update_array( $zn_pcarousel );
	}
?>