<?php get_header(); ?>

	<section id="content">
		<div class="container">
			
			<div id="mainbody">
				
				<div class="row">

					<div class="span12">

						<div class="zn_doc_breadcrumb fixclear">
							<span><?php _e("YOU ARE HERE:",THEMENAME); ?></span>
							<span><a href="<?php echo get_site_url(); ?>"><?php _e("HOME",THEMENAME); ?></a> > </span>
							<?php 
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

							?>
						</div>
						<div class="clear"></div>
						<div class="itemListView clearfix eBlog">

							<div class="itemList">
							
							<?php
							if ( have_posts() ) :
								while( have_posts() ){

									the_post();
									
									?>
									
									<div class="itemContainer post-<?php the_ID(); ?>"> 
								
										<div class="itemHeader">
											<h3 class="itemTitle">
												<a href="<?php the_permalink(); ?>"><?php the_title();?></a>
											</h3>
										</div><!-- end itemHeader -->
								
										<div class="itemBody">
											<div class="itemIntroText">
											<?php
												the_excerpt();
											?>
											
											</div><!-- end Item Intro Text -->
											<div class="clear"></div>
											<div class="itemReadMore">
												<a class="readMore" href="<?php the_permalink(); ?>"><?php echo __( 'Read more...', THEMENAME );?></a>
											</div><!-- end read more -->
											<div class="clear"></div>
										</div><!-- end Item BODY -->
								
										<div class="clear"></div>

								</div><!-- end Blog Item -->
								<div class="clear"></div>
								
							<?php 
								} 
							else: ?>
								<div class="itemContainer noPosts"> 
									<p><?php echo __('Sorry, no posts matched your criteria.', THEMENAME ); ?></p>
								</div><!-- end Blog Item -->
								<div class="clear"></div>
							<?php endif; ?>
							
							</div><!-- end .itemList -->
						
							<!-- Pagination -->
							<?php zn_pagination(); ?>
						
						</div><!-- end blog items list (.itemListView) -->
					</div>

				</div>

			</div><!-- end mainbody -->
			
		</div><!-- end container -->

	</section><!-- end content -->

<?php get_footer(); ?>