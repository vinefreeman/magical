<?php
/**
 * Description tab
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $post;

if ( $post->post_content ) : ?>
	<li class="active"><a href="#tab-description" data-toggle="tab"><?php _e('Description', THEMENAME); ?></a></li>
<?php endif; ?>