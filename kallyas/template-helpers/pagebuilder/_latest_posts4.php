<?php
/*--------------------------------------------------------------------------------------------------
	Latest Posts 4
--------------------------------------------------------------------------------------------------*/
 
	function _latest_posts4 ( $options )
	{
	
		
		$element_size = zn_get_size( $options['_sizer'] );
	
	?>
	
							
		<div class="<?php echo $element_size['sizer'];?>">
			<div class="latest_posts default-style">
			
				<div class="row-fluid zn_content_no_margin">
					<div class="<?php echo $element_size['sizer'];?>">
						<h3 class="m_title">
							<?php echo $options['lp_title'];?>
						</h3>
					</div>
				</div>
				<div class="row-fluid zn_content_no_margin">
				<?php
				
					
					global $post;
					//print_r($options['lp_blog_categories']) ;
					// Check what categories were selected..if any 
					if ( !empty ( $options['lp_blog_categories'] ) ) {
						$blog_category = implode(',',$options['lp_blog_categories']);
					}
					else {
						$blog_category = '0';
					}
					
					// HOW MANY POSTS
					if ( isset ( $options['lp_num_posts'] ) ) {
						$num_posts = $options['lp_num_posts'];
					}
					else {
						$num_posts = '3';
					}
					
					// Start the query
					query_posts( array ( 'posts_per_page' => $num_posts , 'cat' => $blog_category ) );
					
					// GET THE NUMBER OF TOTAL POSTS RETURNED
					global $wp_query;
					
					// Start the loop
					while( have_posts() ) {

						the_post(); 
						
						echo '<div class="span4 post">';	

							$image = '';
							// Create the featured image html
							if ( has_post_thumbnail( $post->ID ) ) {
							
								$thumb = get_post_thumbnail_id($post->ID) ;
								$f_image = wp_get_attachment_url($thumb) ;
								if ( !empty ( $f_image ) ) {
								
									$feature_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
									$image = vt_resize( '', $f_image  , 370,200 , true );
									$image = '<a href="'.get_permalink().'" class="hoverBorder plus"><img src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" alt=""/><h6>'.__("Read more",THEMENAME).' +</h6></a>';
									
								}
							

							}

							echo $image;
						
							echo '<em>';
								the_time('d F Y');
								echo ' '.__("By",THEMENAME);
								echo ' '.get_the_author();
								echo ' '.__("in",THEMENAME).' ';
								the_category(", ");
							echo '</em>';

							echo '<h3 class="m_title"><a href="'.get_permalink().'">'.get_the_title().'</a></h3>';
							
							
						echo '</div>';				
					}
					wp_reset_query();
					
				?>
				</div>
			</div><!-- end // latest posts style 2 -->
		</div>

	<?php
	}
?>