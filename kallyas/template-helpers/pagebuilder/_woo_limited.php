<?php
/*--------------------------------------------------------------------------------------------------
	Limited Offers
--------------------------------------------------------------------------------------------------*/
	function _woo_limited( $options )
	{
		
		global $woocommerce;

		if ( empty($woocommerce) ) { return; }

		$element_size = zn_get_size( $options['_sizer'] );

	?>
		<div class="<?php echo $element_size['sizer'];?>">
		
		<?php
			if ( !empty ( $options['woo_lo_title'] ) ) {
				echo '<h3 class="m_title">'.$options['woo_lo_title'].'</h3>';
			}
		?>
		
			
			<div class="limited-offers-carousel fixclear">
				<ul id="limited_offers" class="zn_limited_offers">
				
					<?php
					
					// Get products on sale
					if ( false === ( $product_ids_on_sale = get_transient( 'wc_products_onsale' ) ) ) {

						$meta_query = array();

						$meta_query[] = array(
							'key' => '_sale_price',
							'value' 	=> 0,
							'compare' 	=> '>',
							'type'		=> 'NUMERIC'
						);

						$on_sale = get_posts(array(
							'post_type' 		=> array('product', 'product_variation'),
							'posts_per_page' 	=> -1,
							'post_status' 		=> 'publish',
							'meta_query' 		=> $meta_query,
							'fields' 			=> 'id=>parent'
						));

						$product_ids 	= array_keys( $on_sale );
						$parent_ids		= array_values( $on_sale );

						// Check for scheduled sales which have not started
						foreach ( $product_ids as $key => $id )
							if ( get_post_meta( $id, '_sale_price_dates_from', true ) > current_time('timestamp') )
								unset( $product_ids[ $key ] );

						$product_ids_on_sale = array_unique( array_merge( $product_ids, $parent_ids ) );

						set_transient( 'wc_products_onsale', $product_ids_on_sale );

					}
					
					
					$product_ids_on_sale[] = 0;

					$meta_query = array();
					$meta_query[] = $woocommerce->query->visibility_meta_query();
					$meta_query[] = $woocommerce->query->stock_status_meta_query();
				
					if ( empty ( $options['woo_categories'] ) ) { $options['woo_categories'] = ''; }
				
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
						'post_type' => 'product',
						'orderby' 		=> 'date',
						'order' 		=> 'ASC',
						'meta_query' 	=> $meta_query,
						'post__in'		=> $product_ids_on_sale
					);	

					
					$r = new WP_Query($query_args);
					

					if ($r->have_posts()) {
					
						while ($r->have_posts()) {
							$r->the_post();
							global $product, $data; 
							//echo $product->product_type;
							if ( $product->product_type == 'variable' ) {

								$old_price = $product->min_variation_regular_price;
								$new_price = $product->min_variation_price;
							} else {
								
								$old_price = $product->regular_price;
								$new_price = $product->sale_price;
							}

							
							$reduced = 0;
							if ( $old_price != 0 ) {
								$reduced = round(100-($new_price*100)/$old_price,0);
							}
							
							echo '<li class="product-list-item" data-discount="'.$reduced.'%">';
							//echo $product->product_type;
								do_action( 'woocommerce_before_shop_loop_item_title' );
								echo '<h5><a href="'.get_permalink().'">'.get_the_title().'</a></h5>';
								echo '<h6 class="price">'.$product->get_price_html().'</h6>';
							echo '</li>';
							
						}
					}
					wp_reset_query();
					?>

				</ul>
				<div class="controls">
					<a href="#" class="prev"><span class="icon-chevron-left"></span></a>
					<a href="#" class="next"><span class="icon-chevron-right"></span></a>
				</div>
			</div>
			<!-- end limited offers carousel -->
		</div>
	<?php

	// Load JS
	$woo_offers = array ( 'woo_offers' =>
			"	
			(function($){
				$(window).load(function() {
					// latest & bestsellers carousels
					jQuery('.zn_limited_offers').carouFredSel({
						responsive: true,
						width: '92%',
						scroll: 1,
						/*auto: true,*/
						items: {width:190, visible: { min: 2, max: 4 } },
						prev	: {	
							button	: function(){return jQuery(this).closest('.limited-offers-carousel').find('.prev');},
							key		: \"left\"
						},
						next	: { 
							button	: function(){return jQuery(this).closest('.limited-offers-carousel').find('.next');},
							key		: \"right\"
						}
					});
				});
			})(jQuery);
			");
			
	zn_update_array( $woo_offers );

	}
?>