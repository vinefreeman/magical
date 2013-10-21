<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
	$woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) {
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
}

// Ensure visibilty
if ( ! $product->is_visible() ) {
	return;
}

?>
				

	<?php do_action( 'woocommerce_before_shop_loop_item' ); 


// Increase loop count
$woocommerce_loop['loop']++;


?>
<div class="span3 product">
<?php

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
		
		if ( $product->product_type != 'external') {
			$zlink = '<a href="'. $link .'" rel="nofollow" data-product_id="'.$product->id.'" class="add_to_cart_button product_type_'.$product->product_type.'">'. $label.'</a>';
		}
		else {
			$zlink = '';
		}
	}
		
/*--------------------------------------------------------------------------------------------------
	New BADGE
--------------------------------------------------------------------------------------------------*/

	global $data;
	$new_badge = '';
	if ( $data['woo_new_badge'] ) {
	
		$now = time();
		$diff = (get_the_time('U') > $now) ? get_the_time('U') - $now : $now - get_the_time('U');
		$val = floor($diff/86400);
		$days = floor(get_the_time('U')/(86400));
		
		if ( $data['woo_new_badge_days'] >= $val ) {
			$new_badge = '<span class="znew">'.__('NEW!', THEMENAME).'</span>';
		}

	} 
		
/*--------------------------------------------------------------------------------------------------
	SALE BADGE
--------------------------------------------------------------------------------------------------*/
	$on_sale = '';
	if ($product->is_on_sale() && $product->is_in_stock()) { 

		$on_sale = '<span class="zonsale">'.__('SALE!', THEMENAME).'</span>'; 

	}
		
		
	?>

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
						/**
						 * woocommerce_after_shop_loop_item_title hook
						 */
						do_action( 'woocommerce_after_shop_loop_item_title' );
					?>
				<!-- WOOCOOMERCE SHORT DESC -->	

				<?php 
					if ( !isset( $data['woo_hide_small_desc'] ) || ( isset( $data['woo_hide_small_desc'] ) && $data['woo_hide_small_desc'] == 'no' )  ) {
						echo apply_filters( 'woocommerce_short_description', $post->post_excerpt );
					}
				?>

				<div class="actions">
					<?php if ( empty( $data['woo_catalog_mode'] ) || ( !empty( $data['woo_catalog_mode'] ) && $data['woo_catalog_mode'] == 'no' ) ) { echo $zlink; } ?><br/>
					<a href="<?php echo get_permalink();?>"><?php _e("MORE INFO",THEMENAME);?></a>
				</div>

				
				<?php if ($price_html = $product->get_price_html()) : ?>
					<div class="price"><?php echo $price_html; ?></div>
				<?php endif; ?>
				

			</div>
		</div><!-- end product-item -->
	




	<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>

</div>

<?php
	global $has_sidebar;
	if ( $has_sidebar ) {
		$num_col = 3;
	}
	else {
		$num_col = 4;
	}
	if ( $woocommerce_loop['loop'] % $num_col == 0 ) {
		echo '<div class="zn_loop_row"></div>';
	}
?>