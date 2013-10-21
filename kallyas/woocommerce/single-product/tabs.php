<?php
/**
 * Single Product tabs
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

// Get tabs
global $has_sidebar;

$content_css = 'span12';
if ( $has_sidebar ) {
	$content_css = 'span9';
}

ob_start();

do_action('woocommerce_product_tabs');

$tabs = trim( ob_get_clean() );

if ( ! empty( $tabs ) ) : ?>
	<div class="<?php echo $content_css;?>" style="margin-bottom:35px;">
		<div class="tabbable tabs_style4">
			<ul class="nav fixclear">
				<?php echo $tabs; ?>
			</ul>
			<div class="tab-content">
				<?php do_action('woocommerce_product_tab_panels'); ?>
			</div>
		</div>
	</div>
<?php endif; ?>