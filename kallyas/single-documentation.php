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
						
						
							<?php while(have_posts()) : the_post(); 
							
									
							?>
<div class="span12 post-<?php the_ID(); ?>">

							<div class="zn_doc_breadcrumb fixclear">
							<?php _e("YOU ARE HERE:",THEMENAME); ?>
							
							<?php 
								echo '<span><a href="'.get_site_url().'">'.__("HOME",THEMENAME).'</a></span>';
								if ( is_tax('documentation_category') ) {

									$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

									$parents = array();
									$parent = $term->parent;
									while ( $parent ) {
										$parents[] = $parent;
										$new_parent = get_term_by( 'id', $parent, get_query_var( 'taxonomy' ) );
										$parent = $new_parent->parent;
									}

									if ( ! empty( $parents ) ) {
										$parents = array_reverse( $parents );
										foreach ( $parents as $parent ) {
											$item = get_term_by( 'id', $parent, get_query_var( 'taxonomy' ));
											echo '<span><a href="' . get_term_link( $item->slug, 'documentation_category' ) . '">' . $item->name . '</a></span>';
										}
									}

									$queried_object = $wp_query->get_queried_object();
									echo '<span>'. $queried_object->name . '</span>';

								}
								elseif ( is_search() ) {
									echo '<span>'. __("Search results for ",THEMENAME).'"' . get_search_query() . '"</span>';
					 
								} 
								elseif ( is_single() ) {
									
									// Show category name
									$cats = get_the_term_list($post->ID, 'documentation_category', '', '|zn_preg|', '|zn_preg|');
									$cats = explode ( '|zn_preg|',$cats );
									
									if ( !empty ( $cats['0'] ) ) {
										
											echo '<span>'.$cats['0'].'</span>';
									}
									
									// Show post name
									echo '<span>'. get_the_title() .'</span>';

								}

							?>
						</div>
						<div class="clear"></div>
						
						<h1 class="page-title"><?php the_title();?></h1>

						<div class="itemView clearfix eBlog">

							<div class="itemBody">

								<!-- Blog Content -->
								<?php the_content(); ?>
								
							</div><!-- end item body -->

														
							<div class="clear"></div>
								
						</div>
						<!-- End Item Layout -->
						
						</div>
							
							<?php endwhile; wp_reset_query(); ?>
							
						
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