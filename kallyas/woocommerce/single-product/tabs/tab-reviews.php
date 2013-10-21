<?php
/**
 * Reviews tab
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( comments_open() ) : ?>
	<li class="reviews_tab"><a href="#tab-reviews" data-toggle="tab"><?php _e('Reviews', THEMENAME); ?><?php echo comments_number(' (0)', ' (1)', ' (%)'); ?></a></li>
<?php endif; ?>