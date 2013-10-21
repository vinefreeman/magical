<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

get_header('shop'); 

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
	<div class="container">
		<div id="mainbody">
			<div class="row">
			
			<?php
				global $data;
				
				// Here will check if sidebar is enabled
				$content_css = 'span12'; 
				$sidebar_css = ''; 
				$has_sidebar = false;
				
				if ( $data['woo_single_sidebar_position'] == 'left_sidebar'   )
				{
					$content_css = 'span9 zn_float_right';
					$sidebar_css = 'sidebar-left';
					$has_sidebar = true;
				}
				elseif ( $data['woo_single_sidebar_position'] == 'right_sidebar'   )
				{
					$content_css = 'span9';
					$sidebar_css = 'sidebar-right';
					$has_sidebar = true;
				}
			?>
			
				<div class="<?php echo $content_css;?>">
					<?php
						/**
						 * woocommerce_before_main_content hook
						 *
						 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
						 * @hooked woocommerce_breadcrumb - 20
						 */
						do_action('woocommerce_before_main_content');
					?>

						<?php while ( have_posts() ) : the_post(); ?>

							<?php woocommerce_get_template_part( 'content', 'single-product' ); ?>

						<?php endwhile; // end of the loop. ?>
				
					<?php
						/**
						 * woocommerce_after_main_content hook
						 *
						 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
						 */
						do_action('woocommerce_after_main_content');
					?>
				</div>
				
				<?php if ( $data['woo_single_sidebar_position'] != 'no_sidebar' && !empty( $data['woo_single_sidebar'] ) ) { ?>
						
						<div class="span3">
							<div id="sidebar" class="sidebar <?php echo $sidebar_css; ?>">
								<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($data['woo_single_sidebar']) ) : endif; ?>
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