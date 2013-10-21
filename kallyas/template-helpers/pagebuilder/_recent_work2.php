<?php
/*--------------------------------------------------------------------------------------------------
	Recent Works 2
--------------------------------------------------------------------------------------------------*/
 
	function _recent_work2( $options )
	{
	
		
		$element_size = zn_get_size( $options['_sizer'] );
	
		?>
		
				<div class="recentwork_carousel style2 <?php echo $element_size['sizer'];?>">
					<?php
						// ELEMENT TITLE
						if ( !empty ( $options['rw_title'] ) ) {
							echo '<h3 class="m_title">'.$options['rw_title'].'</h3>';
						}
						
					?>
						<div class="controls">
							<a href="#" class="prev"><span class="icon-chevron-left"></span></a>
						<?php
							// PORTFOLIO PAGE LINK
							if ( !empty ( $options['rw_port_link'] ) ) {
								echo '<a href="'.$options['rw_port_link'].'" class="complete"><span class="icon-th"></span></a>';
							}
						?>
							<a href="#" class="next"><span class="icon-chevron-right"></span></a>
						</div>
						

						<ul id="recent_works2" class="fixclear recent_works2">
						
						<?php
							
							global $post;
							
							$posts_per_page = isset($options['ports_per_page']) ? $options['ports_per_page'] : '4'; // how many posts
							
							// Start the query
							query_posts( 
								array ( 
									'post_type' => 'portfolio' , 
									'posts_per_page' => $posts_per_page , 
									'tax_query' => array(
											array(
												'taxonomy' => 'project_category',
												'field' => 'id',
												'terms' =>  $options['portfolio_categories']
											)
										), 
									) 
								);
									
							// Start the loop
							while( have_posts() ){
								
								the_post(); 
								
								// Get post meta information
								$post_meta_fields = get_post_meta($post->ID, 'zn_meta_elements', true);
								$post_meta_fields = maybe_unserialize( $post_meta_fields );
								
								echo '<li>';
								
									echo '<a href="'.get_permalink().'">';
										
										if ( !empty ( $post_meta_fields['port_media'] ) && is_array( $post_meta_fields['port_media'] ) ) {
											
											$size = zn_get_size( 'four' );
											$has_image = false;

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
													$image = vt_resize( '', $saved_image , $size['width'],'169' , true );
												}
												

											}

											// Check to see if we have video
											if ( $portfolio_media = $post_meta_fields['port_media']['0']['port_media_video_comb'] ) {

											}

											// IMAGE
											if( !empty($saved_image) ){
												echo '<img src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" '.$saved_alt.' '.$saved_title.' />';
											}
											elseif( $portfolio_media ) {
												echo get_video_from_link( $portfolio_media , '' , $size['width'] , '169' );
											}
												
										}
										
										echo '<div class="details">';
										echo '<span class="plus">+</span>';
										
										// GET THE POST TITLE
										echo '<h4>'.get_the_title().'</h4>';								
										
										// GET ALL POST CATEGORIES
										echo '<span>'.strip_tags ( get_the_term_list( $post->ID, 'project_category', '', ' , ', '' ) ).'</span>';
										echo '</div>';
										
									echo '</a>';
								
								echo '</li>';
							}
							wp_reset_query();
						?>

						</ul>
				</div><!-- end row // recentworks_carousel default-style -->
		
		<?php

					$zn_recent_works2 = array ( 'zn_recent_works2' =>
							"
							jQuery(window).load(function(){
								jQuery('.recent_works2').carouFredSel({
									responsive: true,
									scroll: 1,
									auto: false,
									items: {
										width: 400,
										visible: {
											min: 4,
											max: 10
										}
									},
									prev	: {	
										button	: function(){return jQuery(this).closest('.recentwork_carousel').find('.prev');},
										key		: \"left\"
									},
									next	: { 
										button	: function(){return jQuery(this).closest('.recentwork_carousel').find('.next');},
										key		: \"right\"
									}
								});
							});
							// *** end recent works carousel");
							
							zn_update_array( $zn_recent_works2 );
		
	}	
?>