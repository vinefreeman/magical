<?php


	// Set the Options Array
	$data = get_option(OPTIONS);
	global $all_icon_sets,$bootstrap_icons,$zn_options;

		
	include_once(locate_template(array('admin/options/helper-icons.php'), false));
	

		$zn_admin_menu = array();
		$zn_options = array();

		$zn_admin_menu[] = array(
			"name" => "General options",
			"id" => "woo_general_options"
		);
		
		$zn_admin_menu[] = array(
			"name" => "Categories page",
			"id" => "woo_category_options"
		);

		$zn_admin_menu[] = array(
			"name" => "Single item page",
			"id" => "woo_single_options"
		);



		$bg_images_path = get_stylesheet_directory() . '/images/bg/'; // change this to where you store your bg images
		$bg_images_url = get_template_directory_uri() . '/images/bg/'; // change this to where you store your bg images
		$bg_images = array();
		if (is_dir($bg_images_path))
		{
			if ($bg_images_dir = opendir($bg_images_path))
			{
				while (($bg_images_file = readdir($bg_images_dir)) !== false)
				{
					if (stristr($bg_images_file, ".png") !== false || stristr($bg_images_file, ".jpg") !== false)
					{
						$bg_images[] = $bg_images_url . $bg_images_file;
						natsort($bg_images);
					}
				}
			}
		}

/*--------------------------------------------------------------------------------------------------
	Get all dynamic headers
--------------------------------------------------------------------------------------------------*/
		$header_option = array();
		$header_option['zn_def_header_style'] = 'Default style';
		if ( isset ( $data['header_generator'] ) && is_array ($data['header_generator']) ) {
			//$sidebars = $data['sidebar_generator'];
			foreach ($data['header_generator'] as $header) {
				if ( isset ( $header['uh_style_name'] ) && !empty ( $header['uh_style_name'] ) ) {
				
					$header_name = strtolower ( str_replace(' ','_',$header['uh_style_name'] ) );
					$header_option[$header_name] = $header['uh_style_name'];
					
				}
			}
			
		}




		/*--------------------------------------------------------------------------------------------------
		WooCommerce options
		--------------------------------------------------------------------------------------------------*/
		$sidebar_option = array();
		$sidebar_option['defaultsidebar'] = 'Default Sidebar';
		if (isset($data['sidebar_generator']) && is_array($data['sidebar_generator']))
		{
			$sidebars = $data['sidebar_generator'];
			foreach($data['sidebar_generator'] as $sidebar)
			{
				if ($sidebar['sidebar_name'])
				{
					$sidebar_option[$sidebar['sidebar_name']] = $sidebar['sidebar_name'];
				}
			}
		}

		// Add default sidebar

		/*
		*			Start WOO GENERAL OPTIONS
		------------------------------------------------------------*/
		$zn_options[] = array(
			"type" => 'option_page_start',
			"id" => 'woo_general_options'
		);

		// Show CART in header

		$zn_options[] = array(
			"name" => "Enable Catalog Mode ?",
			"description" => "Choose yes if you wanto to turn your shop in a catalog mode shop ( all the purchase buttons will be removed. )",
			"id" => "woo_catalog_mode",
			"std" => "no",
			"type" => "zn_radio",
			"options" => array(
				"yes" => "Yes",
				"no" => "No"
			) ,
			"class" => "zn_hide"
		);

		$zn_options[] = array(
			"name" => "Show MY CART in header",
			"description" => "Choose yes if you want to show a link to MY CART and the total value of the cart in the header",
			"id" => "woo_show_cart",
			"std" => "1",
			"type" => "zn_radio",
			"options" => array(
				"1" => "Show",
				"0" => "Hide"
			) ,
			"class" => "zn_hide"
		);

		// Show new items badge

		$show_new_badge = array(
			"1" => "Show",
			"0" => "Hide"
		);
		$zn_options[] = array(
			"name" => "Show new items badge ?",
			"description" => "Choose yes if you want to show a NEW item badge over the new products",
			"id" => "woo_new_badge",
			"std" => "1",
			"type" => "zn_radio",
			"options" => $show_new_badge,
			"class" => "zn_hide"
		);


		$zn_options[] = array(
			"name" => "Hide small description in catalog view and related products ?",
			"description" => "Choose yes if you want to hide the short description in the catalog mode and related products",
			"id" => "woo_hide_small_desc",
			"std" => "no",
			"type" => "zn_radio",
			"options" => array(
				"yes" => "Yes",
				"no" => "No"
			) 
		);

		// Days to show as new

		$zn_options[] = array(
			"name" => "Days to show badge",
			"description" => "Please insert the number of days after a product is published to display the badge",
			"id" => "woo_new_badge_days",
			"std" => '3',
			"type" => "text",
			"class" => "woo_new_badge-1"
		);
		$zn_options[] = array(
			"type" => 'option_page_end'
		);
		/*
		*			Start WOO CATEGORY OPTIONS
		------------------------------------------------------------*/
		$zn_options[] = array(
			"type" => 'option_page_start',
			"id" => 'woo_category_options'
		);

		$zn_options[] = array(
			"name" => "Shop Archive Page Title",
			"description" => "Enter the desired page title for the shop archive page.",
			"id" => "woo_arch_page_title",
			"std" => "OUR PRODUCTS",
			"type" => "text",
			"translate_name" => "Shop Archive Page Title",
			"class" => ""
		);

		$zn_options[] = array(
			"name" => "Shop Archive Page Subitle",
			"description" => "Enter the desired page subtitle for the Shop archive page.",
			"id" => "woo_arch_page_subtitle",
			"std" => "Shop category here with product list",
			"type" => "text",
			"translate_name" => "Shop Archive Page Subtitle",
			"class" => ""
		);
		$zn_options[] = array(
			"name" => "Shop Archive Sidebar Position",
			"description" => "Select the position of the sidebar on Shop archive pages.",
			"id" => "woo_arch_sidebar_position",
			"std" => "right_sidebar",
			"type" => "select",
			"options" => array(
				'left_sidebar' => "Left Sidebar",
				'right_sidebar' => "Right sidebar",
				"no_sidebar" => "No sidebar"
			) ,
			"class" => ""
		);

		$zn_options[] = array(
			"name" => "Shop Archive Default Sidebar",
			"description" => "Select the default sidebar that will be used on Shop archive pages.",
			"id" => "woo_arch_sidebar",
			"std" => "",
			"type" => "select",
			"options" => $sidebar_option,
			"class" => ""
		);

		$zn_options[] = array(
			"name" => "Image size",
			"description" => "Enter the desired image sizes for the category images. Please note that the single item image sizes can be set from WooCommerce options.",
			"id" => "woo_cat_image_size",
			"std" => "",
			"type" => "image_size",
			"class" => ""
		);

		$zn_options[] = array(
			"type" => 'option_page_end'
		);
		/*
		*			Start WOO SINGLE OPTIONS
		------------------------------------------------------------*/
		$zn_options[] = array(
			"type" => 'option_page_start',
			"id" => 'woo_single_options'
		);
		$zn_options[] = array(
			"name" => "Shop Single Sidebar Position",
			"description" => "Select the position of the sidebar on Shop Single pages.",
			"id" => "woo_single_sidebar_position",
			"std" => "right_sidebar",
			"type" => "select",
			"options" => array(
				'left_sidebar' => "Left Sidebar",
				'right_sidebar' => "Right sidebar",
				"no_sidebar" => "No sidebar"
			) ,
			"class" => ""
		);

		$zn_options[] = array(
			"name" => "Shop Single Default Sidebar",
			"description" => "Select the default sidebar that will be used on Shop Single pages.",
			"id" => "woo_single_sidebar",
			"std" => "",
			"type" => "select",
			"options" => $sidebar_option,
			"class" => ""
		);

		$zn_options[] = array(
			"type" => 'option_page_end'
		);

?>