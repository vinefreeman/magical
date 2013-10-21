<?php
/**
 * Related Products
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $product, $woocommerce_loop, $has_sidebar;

$related = $product->get_related();

if ( sizeof($related) == 0 ) return;

$content_css = 'span12';
if ( $has_sidebar ) {
	$content_css = 'span9';
}



$args = apply_filters('woocommerce_related_products_args', array(
	'post_type'				=> 'product',
	'ignore_sticky_posts'	=> 1,
	'no_found_rows' 		=> 1,
	'posts_per_page' 		=> $posts_per_page,
	'orderby' 				=> $orderby,
	'post__in' 				=> $related
) );

$products = new WP_Query( $args );

$woocommerce_loop['columns'] 	= $columns;

if ( $products->have_posts() ) : ?>
<div class="<?php echo $content_css;?>">
	<div class="related products">

		<h3><?php _e('Related Products', THEMENAME); ?></h3>

		<div class="row">

			<?php while ( $products->have_posts() ) : $products->the_post(); ?>

				<?php woocommerce_get_template_part( 'content', 'product' ); ?>

			<?php endwhile; // end of the loop. ?>

		</div>

	</div>
</div>

<?php endif;

wp_reset_postdata();
