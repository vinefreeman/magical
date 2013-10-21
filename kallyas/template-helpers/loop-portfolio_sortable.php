<?php

	global $term;

?>

			<div class="span12">

					<?php if ( !empty($term) ) { ?>
						<h1 class="page-title"><?php echo apply_filters( 'the_title', $term->name ); ?></h1>

						<?php if ( !empty( $term->description ) ): ?>
							<div class="archive-description">
								<?php echo esc_html($term->description); ?>
							</div>
						<?php endif; ?>
					<?php }	?>


				<div class="hg-portfolio-sortable">
				
					<div id="sorting" class="fixclear">

						<span class="sortTitle"> <?php _e("Sort By:",THEMENAME);?> </span>
						<ul id="sortBy" class="option-set " data-option-key="sortBy" data-default="">
							<li><a href="#sortBy=name" data-option-value="name"><?php _e("Name",THEMENAME);?></a></li>
							<li><a href="#sortBy=date" data-option-value="date"><?php _e("Date",THEMENAME);?></a></li>
						</ul>
						
						<span class="sortTitle"> <?php _e("Direction:",THEMENAME);?> </span>
						<ul id="sort-direction" class="option-set " data-option-key="sortAscending">
							<li><a href="#sortAscending=true" data-option-value="true"><?php _e("ASC",THEMENAME);?></a></li>
							<li><a href="#sortAscending=false" data-option-value="false"><?php _e("DESC",THEMENAME);?></a></li>
						</ul>
						
					</div><!-- end sorting toolbar -->

					<?php if ( empty($term) ) { ?>
						<ul id="portfolio-nav" class="fixclear">
							<li class="current"><a href="#" data-filter="*"><?php _e("All",THEMENAME);?></a></li>
								<?php

									$args = array();

									if ( isset( $options['portfolio_categories'] ) ){
										$args = array( 
											'include'=> $options['portfolio_categories'],
										);
									}

									$terms = get_terms('project_category',$args);
									//	print_r($terms);
									foreach ( $terms as $term ) {
									  echo '<li><a href="#" data-filter=".'.$term->slug.'_sort">'.$term->name.'</a></li>';
									}
									
								?>

						</ul><!-- end nav toolbar -->
					<?php }	?>


					<div class="clear"></div>
				
					<ul id="thumbs" class="fixclear">
					
						<?php if ( have_posts() ): while ( have_posts() ): the_post(); ?>
						
							<?php
							// GET THE ASSIGNED CATEGORIES
							$css_classes = '';
							$item_categories = get_the_terms( $post->ID, 'project_category');

							if(is_object($item_categories) || is_array($item_categories))
							{
								foreach ($item_categories as $cat)
								{
									$css_classes .= $cat->slug.'_sort ';
								}
							}

							?>

							 <li class="item <?php echo $css_classes; ?> even" data-date="<?php the_time('U'); ?>">
								
								<div class="inner-item">
								
								<?php
								
									// Get post meta information
									$post_meta_fields = get_post_meta($post->ID, 'zn_meta_elements', true);
									$post_meta_fields = maybe_unserialize( $post_meta_fields );
									
										if ( !empty ( $post_meta_fields['port_media'] ) && is_array( $post_meta_fields['port_media'] ) ) {
											
											$size = zn_get_size( 'portfolio_sortable' );
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
												$portfolio_media = str_replace('', '&amp;', $portfolio_media);
											}

											// Display the media
											if ( !empty( $saved_image ) && $portfolio_media ) {
												echo '<a href="'.$portfolio_media.'" data-type="video" rel="prettyPhoto" class="hoverLink">';
												echo '<img src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" '.$saved_alt.' '.$saved_title.' />';
												echo '</a>';
											}
											elseif( !empty($saved_image) ){

												if ( !empty( $data['zn_link_portfolio'] ) && $data['zn_link_portfolio'] ==  'yes' ){
													echo '<a href="'.get_permalink().'" data-type="image" class="hoverLink">';
														echo '<img src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" '.$saved_alt.' '.$saved_title.' />';
													echo '</a>';
												}
												else {
													echo '<a href="'.$saved_image.'" data-type="image" rel="prettyPhoto" class="hoverLink">';
													echo '<img src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" '.$saved_alt.' '.$saved_title.' />';
													echo '</a>';
												}
											}
											elseif( $portfolio_media ) {
												echo get_video_from_link( $portfolio_media , '' , $size['width'] , $size['height'] );
											}		
										}
								?>
								

									<h4 class="title">
										<a href="<?php the_permalink(); ?>"><span class="name"><?php the_title(); ?></span></a>
									</h4>
									<span class="moduleDesc">
										<?php 

											$excerpt = get_the_excerpt();
											$excerpt = strip_shortcodes($excerpt);
											$excerpt = strip_tags($excerpt);
											$the_str = mb_substr($excerpt, 0, 116);
											echo $the_str.'...';

										?>
									</span>
									<div class="clear"></div>
								</div><!-- end ITEM (.inner-item) -->
							</li>
						<?php endwhile; ?>
						<?php endif; wp_reset_query(); ?>
						
						
					</ul><!-- end items list -->
				
				</div><!-- end Portfolio page -->
			</div>