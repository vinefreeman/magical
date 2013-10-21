<?php
/*--------------------------------------------------------------------------------------------------
	Products Presentation
--------------------------------------------------------------------------------------------------*/
	function _woo_products( $options )
	{
	

		global $woocommerce;
		if ( empty($woocommerce) ) { return; }
		$element_size = zn_get_size( $options['_sizer'] );

	?>
		<div class="<?php echo $element_size['sizer'];?>">
			<div class="shop-latest">
			
				<div class="tabbable">
				
					<ul class="nav fixclear">
					
					<?php
						$css = '';
						if ( $options['woo_lp_prod'] ) {

							if ( !empty( $options['woo_lp_title'] ) ) {
								echo '<li class="active"><a href="#tabpan1" data-toggle="tab">'.$options['woo_lp_title'].'</a></li>';
							}
							else{
								echo '<li class="active"><a href="#tabpan1" data-toggle="tab">'.__("LATEST PRODUCTS",THEMENAME).'</a></li>';
							}
							
							
						}
						else {
							$css = 'active';
						}		

						// Best selling products title				
						if ( $options['woo_bs_prod'] ) {
							if ( !empty( $options['woo_bsp_title'] ) ) {
								echo '<li class="'.$css.'"><a href="#tabpan2" data-toggle="tab">'. $options['woo_bsp_title'].'</a></li>';
							}
							else{
								echo '<li class="'.$css.'"><a href="#tabpan2" data-toggle="tab">'.__("BEST SELLING PRODUCTS",THEMENAME).'</a></li>';
							}
							
						}
					?>
					</ul>
					
				<?php
				if ( $options['woo_lp_prod'] ) {
				?>
					<div class="tab-content">
						<div class="tab-pane active" id="tabpan1">
						
							<div class="shop-latest-carousel">
								<ul id="latest_products">
								<?php
										
									$query_args = array('posts_per_page' => $options['prods_per_page'],
														'tax_query' => array (
																			array (
																				'taxonomy' => 'product_cat',
																				'field' => 'id',
																				'terms' => $options['woo_categories']
																				)
																		),
														'no_found_rows' => 1, 
														'post_status' => 'publish', 
														'post_type' => 'product' 
													);	

									
									$r = new WP_Query($query_args);
									
									if ($r->have_posts()) {
									
										while ($r->have_posts()) {
											$r->the_post();
											global $product, $data; 
											
											/* CHECK STOCK */
											if ( ! $product->is_in_stock() ) { 

												$zlink = '<a href="'. apply_filters( 'out_of_stock_add_to_cart_url', get_permalink( $product->id ) ).'" class="">'. apply_filters( 'out_of_stock_add_to_cart_text', __( 'Read More', THEMENAME ) ).'</a>';
											}	
											else { ?>

											<?php

												switch ( $product->product_type ) {
													case "variable" :
														$link 	= apply_filters( 'variable_add_to_cart_url', get_permalink( $product->id ) );
														$label 	= apply_filters( 'variable_add_to_cart_text', __('Select options', THEMENAME) );
													break;
													case "grouped" :
														$link 	= apply_filters( 'grouped_add_to_cart_url', get_permalink( $product->id ) );
														$label 	= apply_filters( 'grouped_add_to_cart_text', __('View options', THEMENAME) );
													break;
													case "external" :
														$link 	= apply_filters( 'external_add_to_cart_url', get_permalink( $product->id ) );
														$label 	= apply_filters( 'external_add_to_cart_text', __('Read More', THEMENAME) );
													break;
													default :
														$link 	= apply_filters( 'add_to_cart_url', esc_url( $product->add_to_cart_url() ) );
														$label 	= apply_filters( 'add_to_cart_text', __('ADD TO CART', THEMENAME) );
													break;
												}
												
												$zlink = '<a href="'. $link .'" rel="nofollow" data-product_id="'.$product->id.'" class="add_to_cart_button product_type_'.$product->product_type.'">'. $label.'</a>';
											}
											$new_badge = '';
											
											/* CHECK BADGE */
											if ( $data['woo_new_badge'] == 1 ) {
												
												$now = time();
												$diff = (get_the_time('U') > $now) ? get_the_time('U') - $now : $now - get_the_time('U');
												$val = floor($diff/86400);
												$days = floor(get_the_time('U')/(86400));
												
												if ( $data['woo_new_badge_days'] >= $val ) {
													$new_badge = '<span class="znew">'.__('NEW!', THEMENAME).'</span>';
												}

											} 
											/* CHECK ON SALE */
											$on_sale = '';
											if ($product->is_on_sale() && $product->is_in_stock()) : 

												$on_sale = '<span class="zonsale">'.__('SALE!', THEMENAME).'</span>'; 

											endif; 
										?>
											<li>
											
												<div class="product-list-item ">
													<span class="hover"></span>
													<div class="zn_badge_container">
														<?php echo $on_sale;?>
														<?php echo $new_badge;?>
													</div>
													<?php
														/**
														 * woocommerce_before_shop_loop_item_title hook
														 * @hooked woocommerce_template_loop_product_thumbnail - 10
														 */
													do_action( 'woocommerce_before_shop_loop_item_title' );
													?>
													<div class="details fixclear">
														<h3><a href="<?php echo get_permalink();?>"><?php the_title(); ?></a></h3>
														
														<?php 
															if ( !isset( $data['woo_hide_small_desc'] ) || ( isset( $data['woo_hide_small_desc'] ) && $data['woo_hide_small_desc'] == 'no' )  ) {
																echo apply_filters( 'woocommerce_short_description', get_the_excerpt() );
															}
														?>

														<div class="actions">
															<?php if ( empty( $data['woo_catalog_mode'] ) || ( !empty( $data['woo_catalog_mode'] ) && $data['woo_catalog_mode'] == 'no' ) ) {  echo $zlink; } ?>
															<a href="<?php echo get_permalink();?>"><?php _e("MORE INFO",THEMENAME);?></a>
														</div>

														
														<?php if ($price_html = $product->get_price_html()) : ?>
															<div class="price"><?php echo $price_html; ?></div>
														<?php endif; ?>
														

													</div>
												</div><!-- end product-item -->
											
											</li>
										<?php

										}
									
									}
									
									// Reset the global $the_post as this query will have stomped on it
									wp_reset_query();
									
								?>

								</ul><!-- shop product list -->
								<div class="controls">
									<a href="#" class="prev"><span class="icon-chevron-left"></span></a>
									<a href="#" class="next"><span class="icon-chevron-right"></span></a>
								</div>
								<div class="clear"></div>
							</div><!--end shop-latest-carousel -->

						</div><!-- end tab pane -->
					<?php
					}
					?>
					<?php
					if ( $options['woo_bs_prod'] ) {
					?>
						<div class="tab-pane <?php echo $css;?>" id="tabpan2">
						
							<div class="shop-latest-carousel">
								<ul id="bestselling_products">
								<?php
								
									$query_args = array('posts_per_page' => $options['prods_per_page'],
														'tax_query' => array (
																			array (
																				'taxonomy' => 'product_cat',
																				'field' => 'id',
																				'terms' => $options['woo_categories']
																				)
																		),
														'no_found_rows' => 1, 
														'post_status' => 'publish', 
														'post_type' => 'product' , 
														'meta_key' => 'total_sales',
														'orderby' => 'meta_value'
													);
									
									
									$r = new WP_Query($query_args);
									
									if ($r->have_posts()) {
									
										while ($r->have_posts()) {
											$r->the_post();
											global $product, $data; 
											
											/* CHECK STOCK */
											if ( ! $product->is_in_stock() ) { 

												$zlink = '<a href="'. apply_filters( 'out_of_stock_add_to_cart_url', get_permalink( $product->id ) ).'" class="">'. apply_filters( 'out_of_stock_add_to_cart_text', __( 'Read More', THEMENAME ) ).'</a>';
											}	
											else { ?>

											<?php

												switch ( $product->product_type ) {
													case "variable" :
														$link 	= apply_filters( 'variable_add_to_cart_url', get_permalink( $product->id ) );
														$label 	= apply_filters( 'variable_add_to_cart_text', __('Select options', THEMENAME) );
													break;
													case "grouped" :
														$link 	= apply_filters( 'grouped_add_to_cart_url', get_permalink( $product->id ) );
														$label 	= apply_filters( 'grouped_add_to_cart_text', __('View options', THEMENAME) );
													break;
													case "external" :
														$link 	= apply_filters( 'external_add_to_cart_url', get_permalink( $product->id ) );
														$label 	= apply_filters( 'external_add_to_cart_text', __('Read More', THEMENAME) );
													break;
													default :
														$link 	= apply_filters( 'add_to_cart_url', esc_url( $product->add_to_cart_url() ) );
														$label 	= apply_filters( 'add_to_cart_text', __('ADD TO CART', THEMENAME) );
													break;
												}
												
												$zlink = '<a href="'. $link .'" rel="nofollow" data-product_id="'.$product->id.'" class="add_to_cart_button product_type_'.$product->product_type.'">'. $label.'</a>';
											}
											
											/* CHECK BADGE */
											if ( $data['woo_new_badge'] ) {
											
												$now = time();
												$diff = (get_the_time('U') > $now) ? get_the_time('U') - $now : $now - get_the_time('U');
												$val = floor($diff/86400);
												$days = floor(get_the_time('U')/(86400));
												
												if ( $data['woo_new_badge_days'] >= $val ) {
													$new_badge = '<span class="znew">'.__('NEW!', THEMENAME).'</span>';
												}

											} 
											/* CHECK ON SALE */
											$on_sale = '';
											if ($product->is_on_sale()) : 

												$on_sale = '<span class="zonsale">'.__('SALE!', THEMENAME).'</span>'; 

											endif; 
										?>
											<li>
											
												<div class="product-list-item ">
													<span class="hover"></span>
													<div class="zn_badge_container">
														<?php echo $on_sale;?>
														<?php echo $new_badge;?>
													</div>
													<?php
														/**
														 * woocommerce_before_shop_loop_item_title hook
														 * @hooked woocommerce_template_loop_product_thumbnail - 10
														 */
													do_action( 'woocommerce_before_shop_loop_item_title' );
													?>
													<div class="details fixclear">
														<h3><a href="<?php echo get_permalink();?>"><?php the_title(); ?></a></h3>
														<?php echo apply_filters( 'woocommerce_short_description', get_the_excerpt() ) ?>
														<div class="actions">
															<?php if ( empty( $data['woo_catalog_mode'] ) || ( !empty( $data['woo_catalog_mode'] ) && $data['woo_catalog_mode'] == 'no' ) ) {  echo $zlink; } ?>
															<a href="<?php echo get_permalink();?>"><?php _e("MORE INFO",THEMENAME);?></a>
														</div>

														
														<?php if ($price_html = $product->get_price_html()) : ?>
															<div class="price"><?php echo $price_html; ?></div>
														<?php endif; ?>
														

													</div>
												</div><!-- end product-item -->
											
											</li>
										<?php

										}
									
									}
									
									// Reset the global $the_post as this query will have stomped on it
									wp_reset_query();
									
								?>
								</ul><!-- shop product list -->
								<div class="controls">
									<a href="#" class="prev"><span class="icon-chevron-left"></span></a>
									<a href="#" class="next"><span class="icon-chevron-right"></span></a>
								</div>
								<div class="clear"></div>
							</div><!--end shop-latest-carousel -->

						</div><!-- end tab pane -->
					<?php
					}
					?>	

					</div><!-- /.tab-content -->
				</div><!-- /.tabbable -->

			</div><!-- end shop latest -->
		</div>
	<?php

					
	$woo_products = array ( 'woo_products' =>
			"	
			(function($){
				$(window).load(function() {
					// latest & bestsellers carousels
					jQuery('.shop-latest-carousel > ul').each(function(index, element) {
						jQuery(this).carouFredSel({
							responsive: true,
							scroll: 1,
							auto: false,
							items: {width:300, visible: { min: 1, max: 4 } },
							prev	: {	button : jQuery(this).parent().find('a.prev'), key : \"left\" },
							next	: { button : jQuery(this).parent().find('a.next'), key : \"right\" },
						});
					});
				});
			})(jQuery);
			");
			
	zn_update_array( $woo_products );
	
	}
?>