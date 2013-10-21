<?php
/**
 * The template for displaying product category thumbnails within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product_cat.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Increase loop count
$woocommerce_loop['loop']++;
?>
<div class="span3 product zn_product_subcategory">
	<div class="product-list-item ">
		<span class="hover"></span>
		<?php do_action( 'woocommerce_before_subcategory', $category ); ?>

		<a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>">

			<?php
				/**
				 * woocommerce_before_subcategory_title hook
				 *
				 * @hooked woocommerce_subcategory_thumbnail - 10
				 */
				do_action( 'woocommerce_before_subcategory_title', $category );
			?>
			<div class="details fixclear">
				<h3>
					<?php echo $category->name; ?>
					<?php if ( $category->count > 0 ) : ?>
						<span class="count">(<?php echo $category->count; ?>)</span>
					<?php endif; ?>
				</h3>
			</div>
			<?php
				/**
				 * woocommerce_after_subcategory_title hook
				 */
				do_action( 'woocommerce_after_subcategory_title', $category );
			?>

		</a>

		<?php do_action( 'woocommerce_after_subcategory', $category ); ?>
	</div>
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