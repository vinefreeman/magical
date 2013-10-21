<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

get_header('shop'); 

	// GET GLOBALS
	global $content_and_sidebar,$post;

	$shop_page_id = get_option('woocommerce_shop_page_id'); 

	// GET THE METAFIELDS
	$meta_fields = get_post_meta($shop_page_id, 'zn_meta_elements', true);
	$meta_fields = maybe_unserialize( $meta_fields );

/*--------------------------------------------------------------------------------------------------
	ACTION BOX AREA
--------------------------------------------------------------------------------------------------*/
	zn_get_template_from_area ('action_box_area',$post->ID,$meta_fields);


?>
<section id="content">
	<div class="container">
		<div id="mainbody">

			<div class="row">
			
			<?php
				global $data,$has_sidebar;
				
				// Here will check if sidebar is enabled
				$content_css = 'span12'; 
				$sidebar_css = ''; 
				$has_sidebar = false;
				
				if ( $data['woo_arch_sidebar_position'] == 'left_sidebar'   )
				{
					$content_css = 'span9 zn_float_right';
					$sidebar_css = 'sidebar-left';
					$has_sidebar = true;
				}
				elseif ( $data['woo_arch_sidebar_position'] == 'right_sidebar'   )
				{
					$content_css = 'span9';
					$sidebar_css = 'sidebar-right';
					$has_sidebar = true;
				}
				
				
			?>
			
				<div class="<?php echo $content_css;?> zn_woo_cat_page">
				
				<?php
					/**
					 * woocommerce_before_main_content hook
					 *
					 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
					 * 
					 */
					do_action('woocommerce_before_main_content');
				?>
				
				<h1 class="page-title">
					<?php if ( is_search() ) : ?>
						<?php
							printf( __( 'Search Results: &ldquo;%s&rdquo;', THEMENAME ), get_search_query() );
							if ( get_query_var( 'paged' ) )
								printf( __( '&nbsp;&ndash; Page %s', THEMENAME ), get_query_var( 'paged' ) );
						?>
					<?php elseif ( is_tax() ) : ?>
						<?php echo single_term_title( "", false ); ?>
					<?php else : ?>
						<?php
							$shop_page = get_post( woocommerce_get_page_id( 'shop' ) );

							echo apply_filters( 'the_title', ( $shop_page_title = get_option( 'woocommerce_shop_page_title' ) ) ? $shop_page_title : $shop_page->post_title );
						?>
					<?php endif; ?>
				</h1>

				<?php do_action( 'woocommerce_archive_description' ); ?>

				<?php if ( is_tax() ) : ?>
					<?php do_action( 'woocommerce_taxonomy_archive_description' ); ?>
				<?php elseif ( ! empty( $shop_page ) && is_object( $shop_page ) ) : ?>
					<?php do_action( 'woocommerce_product_archive_description', $shop_page ); ?>
				<?php endif; ?>

				<?php if ( have_posts() ) : ?>

					<?php do_action('woocommerce_before_shop_loop'); ?>
					<div class="clear"></div>
					
					<div class="row">

						<?php woocommerce_product_subcategories(); ?>

						<?php while ( have_posts() ) : the_post(); ?>

							<?php woocommerce_get_template_part( 'content', 'product' ); ?>

						<?php endwhile; // end of the loop. ?>

					</div>

					<?php do_action('woocommerce_after_shop_loop'); ?>
					
				<?php else : ?>

					<?php if ( ! woocommerce_product_subcategories( array( 'before' => '<ul class="products">', 'after' => '</ul>' ) ) ) : ?>

						<p><?php _e( 'No products found which match your selection.', THEMENAME ); ?></p>

					<?php endif; ?>

				<?php endif; ?>

				
				
				<div class="clear"></div>
				
				<?php
					/**
					 * woocommerce_after_main_content hook
					 *
					 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
					 */
					do_action('woocommerce_after_main_content');
				?>
				
				<?php
					/**
					 * woocommerce_pagination hook
					 *
					 * @hooked woocommerce_pagination - 10
					 * @hooked woocommerce_catalog_ordering - 20
					 */
					do_action( 'woocommerce_pagination' );
				?>

		


			</div>

			<?php if ( $data['woo_arch_sidebar_position'] != 'no_sidebar' && !empty( $data['woo_arch_sidebar'] ) ) { ?>
					
					<div class="span3">
						<div id="sidebar" class="sidebar <?php echo $sidebar_css; ?>">
							<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($data['woo_arch_sidebar']) ) : endif; ?>
						</div>
					</div>
			<?php } ?>
				
		</div>
		</div>
	</div>

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

</section>


<?php get_footer('shop'); ?>