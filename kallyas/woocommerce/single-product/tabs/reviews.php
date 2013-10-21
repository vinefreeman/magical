<?php
/**
 * Reviews tab
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $woocommerce, $post;

if ( comments_open() ) : ?>
	<div class="tab-pane" id="tab-reviews">
		<?php comments_template(); ?>
	</div>
<?php endif; ?>