<?php
global $data;
/*--------------------------------------------------------------------------------------------------
	REMOVE UNWANTED ACTIONS
--------------------------------------------------------------------------------------------------*/
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
remove_action( 'woocommerce_pagination', 'woocommerce_catalog_ordering', 20);
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);


/* add*/
//add_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 10);


/*--------------------------------------------------------------------------------------------------
	SINGLE PRODUCT PAGE - Reorder metas
--------------------------------------------------------------------------------------------------*/


// ITEM META
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 10);

// ITEM PRICE
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 30);

// ITEM PRICE
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 40);

if ( !empty( $data['woo_catalog_mode'] ) && $data['woo_catalog_mode'] == 'yes' ) {
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' ); 
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart' , 40 );
}

/* PRODUCT THUMBNAIL IN LOOP */
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
 
/*--------------------------------------------------------------------------------------------------
	PRODUCTS PAGE - FILTER IMAGE
--------------------------------------------------------------------------------------------------*/
 
if ( ! function_exists( 'woocommerce_template_loop_product_thumbnail' ) ) {

	function woocommerce_template_loop_product_thumbnail() {
		echo woocommerce_get_product_thumbnail();
	} 
}
 

if ( ! function_exists( 'woocommerce_get_product_thumbnail' ) ) {

	function woocommerce_get_product_thumbnail( $size = 'shop_catalog', $placeholder_width = 0, $placeholder_height = 0  ) {
		global $post, $woocommerce,$data;

		if ( ! $placeholder_width )
			$placeholder_width = $woocommerce->get_image_size( 'shop_catalog_image_width' );
		if ( ! $placeholder_height )
			$placeholder_height = $woocommerce->get_image_size( 'shop_catalog_image_height' );
			
			$output = '<div class="image">';

			if ( has_post_thumbnail() ) {

				$width = '150';
				$height = '130';
				if ( !empty($data['woo_cat_image_size'] ) ) {
					$width = $data['woo_cat_image_size']['width'];
					$height = $data['woo_cat_image_size']['height'];
				}

				$image = vt_resize( get_post_thumbnail_id($post->ID), ''  , $width,$height , true );
				$output .= '<a href="'. get_permalink().'"><img src="'.$image['url'].'" alt=""></a>';
				
			} else {
			
				$output .= '<img src="'. woocommerce_placeholder_img_src() .'" alt="Placeholder" width="' . $placeholder_width . '" height="' . $placeholder_height . '" />';
			
			}
			
			$output .= '</div>';
			
			return $output;
	}
}
 
/*--------------------------------------------------------------------------------------------------
	FILTER PRODUCT DESCRIPTION
--------------------------------------------------------------------------------------------------*/
function woo_short_desc_filter($content){   


    $content = str_replace ('<p>','<p class="desc">',$content);
    return $content;
}

add_filter('woocommerce_short_description', 'woo_short_desc_filter');

/*--------------------------------------------------------------------------------------------------
	FILTER PRODUCT PRICE
--------------------------------------------------------------------------------------------------*/
function zn_woocommerce_price_html($content){   

	$content = str_replace ('<del><span class="amount">','<small>',$content);
	$content = str_replace ('</span></del>','</small>[zn_break]',$content);
	$content = str_replace ('<ins><span class="amount">','<span>',$content);
	$content = str_replace ('</span></ins>','</span>',$content);

	$content = explode( '[zn_break]', $content );
	
	$price = '';
	if ( !empty ( $content[1] ) ) $price .= $content[1];
	if ( !empty ( $content[0] ) ) $price .= $content[0];


    return $price;
}

add_filter('woocommerce_get_price_html', 'zn_woocommerce_price_html');

function zn_woocommerce_free_price_html($content){   

	$content = '<span>'.$content.'</span>';
	
    return $content;
}

add_filter('woocommerce_free_price_html', 'zn_woocommerce_free_price_html');










?>