<?php
/*--------------------------------------------------------------------------------------------------
	Latest Posts Element
--------------------------------------------------------------------------------------------------*/
 
	function _latest_posts( $options )
	{
	?>
	
					<div class="span12">
						<div class="latest_posts acc-style">
							<h3 class="m_title"><?php echo $options['lp_title'];?></h3>
						<?php
							if ( !empty( $options['lp_blog_page'] ) ) {
								echo '<a href="'.$options['lp_blog_page'].'" class="viewall">'. __("VIEW ALL",THEMENAME).' -</a>';
							}
						?>
							
							
							<div class="css3accordion">
								<ul>
								
								<?php

									global $post;
									
									// Check what categories were selected..if any 
									if ( isset ( $options['lp_blog_categories'] ) ) {
										$blog_category = implode(',',$options['lp_blog_categories']);
									}
									else {
										$blog_category = '';
									}
									
									// Start the query
									query_posts( array ( 'posts_per_page' => 3 , 'cat' => $blog_category ) );
									
									// GET THE NUMBER OF TOTAL POSTS RETURNED
									global $wp_query;
									$num_posts = $wp_query->post_count;
									
									$i = 0;
									$cls = '';
									
									// Start the loop
									while( have_posts() ){
									
										$i++;
										
										the_post(); 
										
										if  ( $i == $num_posts ) {
											$cls = 'class="last"';
										}
										
										echo '<li '.$cls.'>';
										
											echo '<div class="inner-acc">';
											
												$image = '';
												// Create the featured image html
												if ( has_post_thumbnail( $post->ID ) ) {
													
													$thumb = get_post_thumbnail_id($post->ID) ;
													$f_image = wp_get_attachment_url($thumb) ;
													if ( !empty ( $f_image ) ) {
													
														$feature_image = wp_get_attachment_url( $thumb );
														$image = vt_resize( '', $f_image  , 370,200 , true );
														$image = '<a href="'.get_permalink().'" class="thumb hoverBorder plus"><img class="shadow" src="'.$image['url'].'" alt=""/></a>';
														
													}
													

												}
												echo $image;
												
												echo '<div class="content">';
												
													echo '<em>'.get_the_time('d F Y').' '.__("by",THEMENAME).' '.get_the_author().', '.__("in",THEMENAME).' ';
														
														$all_cats = count(get_the_category());
														$z = 1;
														foreach((get_the_category()) as $category) {
															echo $category->cat_name;
															if ( $all_cats != $z ) { echo ','; }
															$z++;
														}
													echo '</em>';
													
													echo '<h5 class="m_title"><a href="'.get_permalink().'">'.get_the_title().'</a></h5>';
													
													// TEXT
													echo '<div class="text">';
														$excerpt = get_the_excerpt();
														$excerpt = strip_shortcodes($excerpt);
														$excerpt = strip_tags($excerpt);
														$the_str = mb_substr($excerpt, 0, 80);
														echo $the_str.'...';
														
													echo '</div>';
													
													echo '<a href="'.get_permalink().'">'.__("READ MORE",THEMENAME).' +</a>';
													
												echo '</div>';
												
											echo '</div>';
										
										echo '</li>';
										
									}
									wp_reset_query();
								?>

								</ul>
							</div><!-- end CSS3 Accordion -->
						</div><!-- end acc-style -->
					</div>
	
	<?php
	}
?>