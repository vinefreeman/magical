<?php
/*--------------------------------------------------------------------------------------------------
	Latest Posts 2
--------------------------------------------------------------------------------------------------*/
 
	function _latest_posts2 ( $options )
	{
	
		
		$element_size = zn_get_size( $options['_sizer'] );
	
	?>
	
							
		<div class="<?php echo $element_size['sizer'];?>">
			<div class=" latest_posts style3">
				<h3 class="m_title"><?php echo $options['lp_title'];?></h3>
				<?php
					if ( !empty( $options['lp_blog_page'] ) ) {
						echo '<a href="'.$options['lp_blog_page'].'" class="viewall">'. __("VIEW ALL",THEMENAME).' -</a>';
					}
				?>
				<ul class="posts">
				<?php
				
					global $post;
				
					// Check what categories were selected..if any 
					if ( isset ( $options['lp_blog_categories'] ) ) {
						$blog_category = implode(',',$options['lp_blog_categories']);
					}
					else {
						$blog_category = '';
					}
					
					// HOW MANY POSTS
					if ( isset ( $options['lp_num_posts'] ) ) {
						$num_posts = $options['lp_num_posts'];
					}
					else {
						$num_posts = '2';
					}
					
					// Start the query
					query_posts( array ( 'posts_per_page' => $num_posts , 'cat' => $blog_category ) );
					
					// GET THE NUMBER OF TOTAL POSTS RETURNED
					global $wp_query;
					
					// Start the loop
					while( have_posts() ){

						the_post(); 
						
						echo '<li class="post">';	

							$image = '';
							// Create the featured image html
							if ( has_post_thumbnail( $post->ID ) ) {
							
								$thumb = get_post_thumbnail_id($post->ID) ;
								$f_image = wp_get_attachment_url($thumb) ;
								if ( !empty ( $f_image ) ) {
									$feature_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
									$image = vt_resize( '', $f_image , 54,54 , true );
									$image = '<a href="'.get_permalink().'" class="hoverBorder pull-left"><img src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" alt=""/></a>';
									
								}
							

							}
							
							// IMAGE
							echo $image;
							
							// TITLE
							echo '<h4 class="title"><a href="'.get_permalink().'">'.get_the_title().'</a></h4>';	
							
							// TEXT
							echo '<div class="text">';
								$excerpt = get_the_excerpt();
								$excerpt = strip_shortcodes($excerpt);
								$excerpt = strip_tags($excerpt);
								$the_str = mb_substr($excerpt, 0, 95);
								echo $the_str.'...';
								
							echo '</div>';
							
						echo '</li>';				
					}
					wp_reset_query();
					
				?>

				</ul>
			</div><!-- end // latest posts style 2 -->
		</div>

	<?php
	}
?>