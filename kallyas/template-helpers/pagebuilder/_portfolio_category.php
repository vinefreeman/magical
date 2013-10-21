<?php
/*--------------------------------------------------------------------------------------------------
	Portfolio Category
--------------------------------------------------------------------------------------------------*/
 
	function _portfolio_category( $options )
	{
	
		
		$element_size = zn_get_size( $options['_sizer'] );
	
		wp_reset_query();
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

			if ( $options['ports_num_columns'] == '1' ) {
				echo '<div class="span12">';

				// Start the loop
				while( have_posts() ){
					
					the_post(); 
					
					// Get post meta information
					$post_meta_fields = get_post_meta($post->ID, 'zn_meta_elements', true);
					$post_meta_fields = maybe_unserialize( $post_meta_fields );
					

					echo '<div class="row-fluid">';
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

				echo '<div class="row-fluid zn_content_no_margin">';
				echo '<div class="span12">';
					zn_pagination(); 
					wp_reset_query();
				echo '</div>';
				echo '</div>';
				echo '</div>';
			}
			else {

				$proper_size = 12/$options['ports_num_columns'];
				$i = 1;
				echo '<div class="span12">';
				

				// Start the loop
				while( have_posts() ){
					
					the_post(); 
					
					if ( $i % $options['ports_num_columns'] == 1 ) {

						echo '<div class="row-fluid">';

					}

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

					if ( $i % $options['ports_num_columns'] == 0 && $i % $options['ports_per_page_visible'] != 0 ) {

						echo '<div class="row-fluid"><div class="span12"><hr class="bs-docs-separator"></div></div></div>';

					}


					$i++;
					
				}

				echo '<div class="clear"></div>';

				echo '<div class="row-fluid"></div>';
				echo '<div class="span12" >';
					zn_pagination(); 
					wp_reset_query();
				echo '</div>';

				echo '</div><!-- end row -->';
				echo '</div>';
			}


	}	
?>