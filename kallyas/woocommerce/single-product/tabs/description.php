<?php
/**
 * Description tab
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $woocommerce, $post;

if ( $post->post_content ) : ?>
	<div class="tab-pane active" id="tab-description">

		<?php the_content(); ?>

	</div>
<?php endif; ?>