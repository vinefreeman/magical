<?php


	// Set the Options Array
	$data = get_option(OPTIONS);
	global $all_icon_sets,$bootstrap_icons,$wpdb;
	include_once(locate_template(array('admin/options/helper-icons.php'), false));
	
	$extra_options = array();
	$zn_meta_elements = array();

/*--------------------------------------------------------------------------------------------------
	SET-UP META TYPES
--------------------------------------------------------------------------------------------------*/
	$zn_meta_types = array( 
		array( 	'title' =>  'Page Options', 'id'=>'page_options', 'page'=>array('page'), 'context'=>'normal', 'priority'=>'high' ),
		array( 	'title' =>  'Post Options', 'id'=>'post_options', 'page'=>array('post'), 'context'=>'normal', 'priority'=>'high' ),
		array( 	'title' =>  'Portfolio Options', 'id'=>'portfolio_options', 'page'=>array('portfolio','showcase'), 'context'=>'normal', 'priority'=>'high' ),
		array( 	'title' =>  'General Options', 'id'=>'portfolio_g_options', 'page'=>array('portfolio'), 'context'=>'normal', 'priority'=>'high' ),
		array( 	'title' =>  'Page Builder', 'id'=>'page_builder', 'page'=>array('post','page','portfolio','product'), 'context'=>'normal', 'priority'=>'high' ),
		array( 	'title' =>  'Image Gallery', 'id'=>'woo_image_gallery', 'page'=>array('product'), 'context'=>'normal', 'priority'=>'high' ),
	);
		

/*--------------------------------------------------------------------------------------------------
	Get all dynamic sidebars
--------------------------------------------------------------------------------------------------*/
	$sidebar_option = array( 'defaultsidebar' => 'Default Sidebar');
	if ( isset ( $data['sidebar_generator'] ) && is_array ($data['sidebar_generator']) ) {
		//$sidebars = $data['sidebar_generator'];
		foreach ($data['sidebar_generator'] as $sidebar) {
			if ( $sidebar['sidebar_name'] ) {
				$sidebar_option[$sidebar['sidebar_name']] = $sidebar['sidebar_name'];
			}
		}
	}



/*--------------------------------------------------------------------------------------------------
	Get CUTE SLIDER SLIDES
--------------------------------------------------------------------------------------------------*/
	$revslider_options = array();
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
 	if (is_plugin_active('revslider/revslider.php')) {

	// Table name
	$table_name = $wpdb->prefix . "revslider_sliders";

	// Get sliders
	$rev_sliders = $wpdb->get_results( "SELECT title,alias FROM $table_name" );

	// Iterate over the sliders
	foreach($rev_sliders as $key => $item) {
		$revslider_options[$item->alias] = $item->title;
	}
   }




/*--------------------------------------------------------------------------------------------------
	Get REVOLUTION SLIDER SLIDES
--------------------------------------------------------------------------------------------------*/
	$cuteslider_options = array();
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if (is_plugin_active('CuteSlider/cuteslider.php')) {
		$cuteslider_options = array();
		// Table name
		$table_name = $wpdb->prefix . "cuteslider";
	 
		// Get sliders
		$cute_sliders = $wpdb->get_results( "SELECT * FROM $table_name
											WHERE flag_hidden = '0' AND flag_deleted = '0'
											ORDER BY date_c ASC LIMIT 100" );
		
		// Iterate over the sliders
		foreach($cute_sliders as $key => $item) {
			$cuteslider_options[$item->id] = $item->name;
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
	WOO IMAGE GALLERY
--------------------------------------------------------------------------------------------------*/

						
$zn_meta_elements[] = array ( 
						"link_to" => "woo_image_gallery",
						"name" => "Image Gallery",
						"description" => "Please select more images for this product. Please note that prior to this you will need to select a featured image that will be used as the main image for this product",
						"id" => "woo_image_gallery",
						"std" => '',
						"type" => "group",
						"add_text" => "Image",
						"remove_text" => "Image",			
						"subelements" => array 
										(
											array( 
												"name" => "Image",
												"description" => "Please select an image.",
												"id" => "woo_single_image",
												"std" => "",
												"type" => "media"
											),

										)
					);		
						
/*--------------------------------------------------------------------------------------------------
	Get Blog Categories
--------------------------------------------------------------------------------------------------*/
	$args = array(
		'type'                     => 'post',
		'child_of'                 => 0,
		'parent'                   => '',
		'orderby'                  => 'id',
		'order'                    => 'ASC',
		'hide_empty'               => 1,
		'hierarchical'             => 1,
		'taxonomy'                 => 'category',
		'pad_counts'               => false );	
	$blog_categories = get_categories( $args );

	$option_blog_cat = array();
	foreach ($blog_categories as $category) {
		$option_blog_cat[$category->cat_ID] = $category->cat_name;
	}
	
/*--------------------------------------------------------------------------------------------------
	Get Portfolio categories
--------------------------------------------------------------------------------------------------*/
$args = array(
	'type'                     => 'portfolio',
	'child_of'                 => 0,
	'parent'                   => '',
	'orderby'                  => 'id',
	'order'                    => 'ASC',
	'hide_empty'               => 1,
	'hierarchical'             => 1,
	'taxonomy'                 => 'project_category',
	'pad_counts'               => false );	
		
	$port_categories = get_categories( $args );

	$option_port_cat = array();
	foreach ($port_categories as $category) {
		$option_port_cat[$category->cat_ID] = $category->cat_name;
	}

/*--------------------------------------------------------------------------------------------------
	Get Shop categories
--------------------------------------------------------------------------------------------------*/
 	If (is_plugin_active('woocommerce/woocommerce.php')) {
		$args = array(
			'type'                     => 'shop',
			'child_of'                 => 0,
			'parent'                   => '',
			'orderby'                  => 'id',
			'order'                    => 'ASC',
			'hide_empty'               => 1,
			'hierarchical'             => 1,
			'taxonomy'                 => 'product_cat',
			'pad_counts'               => false );	
				
			$shop_categories = get_categories( $args );

			$option_shop_cat = array();
			foreach ($shop_categories as $category) {
				$option_shop_cat[$category->cat_ID] = $category->cat_name;
			}
}
else {

	$option_shop_cat = array();
}

/*--------------------------------------------------------------------------------------------------
//
//
//	Portfolio Area options
//	
//	
--------------------------------------------------------------------------------------------------*/
	
/*--------------------------------------------------------------------------------------------------
	STATIC CONTENT - Event Countdown
--------------------------------------------------------------------------------------------------*/

$zn_meta_elements[] = array ( 
						"link_to" => "portfolio_options",
						"name" => "Project Link",
						"description" => "Please choose the url for this project",
						"id" => "sp_link",
						"std" => "",
						"type" => "link",
						"options" => array ( '_blank' => "New window" , '_self' => "Same window" )
						);
						
$zn_meta_elements[] = array ( 
						"link_to" => "portfolio_options",
						"name" => "Colaborators",
						"description" => "Please enter the collaborators for this project",
						"id" => "sp_col",
						"std" => "",
						"type" => "text"
						);
						
$zn_meta_elements[] = array ( 
						"link_to" => "portfolio_options",
						"name" => "Show social icons ?",
						"description" => "Select yes if you want to show the social share icons or no if you want to hide them.",
						"id" => "sp_show_social",
						"std" => "yes",
						"options" => array ( "yes" => "Yes", "no"=>"No" ),
						"type" => "zn_radio"
						);

$zn_meta_elements[] = array ( 
						"link_to" => "portfolio_options",
						"name" => "Portfolio Item Media",
						"description" => "Portfolio Item Media",
						"id" => "port_media",
						"std" => '',
						"type" => "group",
						"use_name" => "port_med_name",
						"add_text" => "Item",
						"remove_text" => "Item",			
						"subelements" => array 
										(
											array( 
												"name" => "Media Name",
												"description" => "Here you can enter a name for this image/video. It will only appear in the edit page.",
												"id" => "port_med_name",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Select image",
												"description" => "Select the desired image that you want to use.",
												"id" => "port_media_image_comb",
												"std" => "",
												"type" => "media",
												"alt" => true,
												"class" => "zn_hide_me port_media_type-combined"
											),
											array( 
												"name" => "Video URL",
												"description" => "Please enter the Youtube or Vimeo URL for your video.",
												"id" => "port_media_video_comb",
												"std" => "",
												"type" => "text",
												"class" => "zn_hide_me port_media_type-combined"
											)
										)
					);		
					


	

/*--------------------------------------------------------------------------------------------------
//
//
//	Header area options
//	
//	
--------------------------------------------------------------------------------------------------*/


/*--------------------------------------------------------------------------------------------------
	Header Area Modules
--------------------------------------------------------------------------------------------------*/		
$zn_meta_elements[] = array( 
						"link_to" => "page_builder",
						"name" => "Header Area Options",
						"description" => "",
						"id" => "page_builder",
						"std" => "",
						"type" => "zn_dynamic_list",
						"add_text" => "",
						"remove_text" => "",
						"options" => array
										( 
											"header_area" => array 
											(
												"area_name" => "Header Area",
												"limit" => 1,
												"area_options" => array (
																'_header_module'=>'Custom Header Layout' ,
																'_iosSlider'=>'iOS Slider' ,
																'_flexslider'=>'Flex Slider' ,
																'_nivoslider'=>'Nivo Slider' ,
																'_wowslider'=>'Wow Slider' ,
																'_fancyslider'=>'Fancy Slider' ,
																'_circ1'=>'Circular Content Style 1' ,
																'_circ2'=>'Circular Content Style 2' ,
																'_static1'=>'STATIC CONTENT - Default' ,
																'_static2'=>'STATIC CONTENT - Boxes' ,
																'_static3'=>'STATIC CONTENT - Video' ,
																'_static4'=>'STATIC CONTENT - Maps' ,
																'_static4_multiple'=>'STATIC CONTENT - Maps multiple locations' ,
																'_static5'=>'STATIC CONTENT - Text Pop' ,
																'_static6'=>'STATIC CONTENT - Product Loupe' ,
																'_static7'=>'STATIC CONTENT - Event Countdown' ,
																'_static8'=>'STATIC CONTENT - Video Background' ,
																'_static9'=>'STATIC CONTENT - Simple Text' ,
																'_static10'=>'STATIC CONTENT - Text and Register' ,
																'_static11'=>'STATIC CONTENT - Text and Video' ,
																'_css_pannel'=>'CSS3 Panels' ,
																'_icarousel'=>'iCarousel' ,
																'_lslider'=>'Laptop Slider' ,
																'_pslider'=>'Portfolio Slider' ,
																'_cute_slider'=>'3d Cute Slider' ,
																'_rev_slider'=>'Revolution Slider' ,
																'_zn_doc_header'=>'Documentation Header' ,
																)
											),
											"action_box_area" => array 
											(
												"area_name" => "Action Box Area",
												"limit" => 1,
												"area_options" => array (
																'_action_box'=>'Action Box' ,
																'_action_box_text'=>'Action Box Text' ,
																)
											),
											"content_main_area" => array 
											(
												"area_name" => "Content Main Area",
												"limit" => 999,
												"area_options" => array (
																'_image_box'=>'Image Box' ,
																'_image_box2'=>'Images Box' ,
																'_service_box'=>'Service Box' ,
																'_service_box2'=>'Services Element' ,
																'_recent_work'=>'Recent Work' ,
																'_recent_work2'=>'Recent Work 2' ,
																'_call_banner'=>'Call Out Banner' ,
																'_features_element'=>'Features Element' ,
																'_features_element2'=>'Features Element 2' ,
																'_latest_posts'=>'Latest Posts' ,
																'_latest_posts2'=>'Latest Posts 2' ,
																'_latest_posts3'=>'Latest Posts 3' ,
																'_latest_posts4'=>'Latest Posts 4' ,
																'_accordion'=>'Accordion' ,
																'_testimonial_box'=>'Testimonial Box' ,
																'_testimonial_slider'=>'Testimonials Fader' ,
																'_testimonial_slider2'=>'Testimonials Slider' ,
																'_step_box'=>'Steps Box' ,
																'_step_box2'=>'Steps Box 2' ,
																'_step_box3'=>'Steps Box 3' ,
																'_partners_logos'=>'Partners Logos' ,
																'_keyword'=>'Keywords Element' ,
																'_infobox'=>'Info Box' ,
																'_infobox2'=>'Info Box 2' ,
																'_flickrfeed'=>'Flickr Feed' ,
																'_circle_title_box'=>'Circle Title Text Box' ,
																'_text_box'=>'Text Box' ,
																'_screenshoot_box'=>'Screenshoots Box' ,
																'_hover_box'=>'Hover Box' ,
																'_vertical_tabs'=>'Vertical Tabs' ,
																'_tabs'=>'Horizontal Tabs' ,
																'_stats_box'=>'Stats Box' ,
																'_stats_box'=>'Stats Box' ,
																'_c_form' => 'Contact Form',
																'_historic' => 'Historic Element',
																'_team_box' => 'Team Box',
																'_image_gallery' => 'Image Gallery',
																'_woo_products' => 'Shop Products Presentation',
																'_woo_limited' => 'Shop Limited Offers',
																'_shop_features' => 'Shop Features',
																'_video_box' => 'Video Box',
																'_portfolio_category' => 'Portfolio Category',
																'_portfolio_sortable' => 'Portfolio Sortable',
																'_portfolio_carousel' => 'Portfolio Carousel Layout',
																'_photo_gallery' => 'Photo Gallery',
																'_content_sidebar' => 'Content and Sidebar',
																'_zn_documentation' => 'Documentation',
																'_zn_sidebar' => 'Sidebar',
																)
											),
											"content_grey_area" => array 
											(
												"area_name" => "Content Grey Area",
												"limit" => 999,
												"area_options" => array (
																'_image_box'=>'Image Box' ,
																'_image_box2'=>'Images Box' ,
																'_service_box'=>'Service Box' ,
																'_service_box2'=>'Services Element' ,
																'_recent_work'=>'Recent Work' ,
																'_recent_work2'=>'Recent Work 2' ,
																'_call_banner'=>'Call Out Banner' ,
																'_features_element'=>'Features Element' ,
																'_features_element2'=>'Features Element 2' ,
																'_latest_posts'=>'Latest Posts' ,
																'_latest_posts2'=>'Latest Posts 2' ,
																'_latest_posts3'=>'Latest Posts 3' ,
																'_latest_posts4'=>'Latest Posts 4' ,
																'_accordion'=>'Accordion' ,
																'_testimonial_box'=>'Testimonial Box' ,
																'_testimonial_slider'=>'Testimonials Fader' ,
																'_testimonial_slider2'=>'Testimonials Slider' ,
																'_step_box'=>'Steps Box' ,
																'_step_box2'=>'Steps Box 2' ,
																'_step_box3'=>'Steps Box 3' ,
																'_partners_logos'=>'Partners Logos' ,
																'_keyword'=>'Keywords Element' ,
																'_infobox'=>'Info Box' ,
																'_infobox2'=>'Info Box 2' ,
																'_flickrfeed'=>'Flickr Feed' ,
																'_circle_title_box'=>'Circle Title Text Box' ,
																'_text_box'=>'Text Box' ,
																'_screenshoot_box'=>'Screenshoots Box' ,
																'_hover_box'=>'Hover Box' ,
																'_vertical_tabs'=>'Vertical Tabs' ,
																'_tabs'=>'Horizontal Tabs' ,
																'_stats_box'=>'Stats Box' ,
																'_c_form' => 'Contact Form',
																'_historic' => 'Historic Element',
																'_team_box' => 'Team Box',
																'_image_gallery' => 'Image Gallery',
																'_woo_products' => 'Shop Products Presentation',
																'_woo_limited' => 'Shop Limited Offers',
																'_shop_features' => 'Shop Features',
																'_video_box' => 'Video Box',
																'_portfolio_category' => 'Portfolio Category',
																'_portfolio_sortable' => 'Portfolio Sortable',
																'_portfolio_carousel' => 'Portfolio Carousel Layout',
																'_photo_gallery' => 'Photo Gallery',
																'_content_sidebar' => 'Content and Sidebar',
																'_zn_documentation' => 'Documentation',
																'_zn_sidebar' => 'Sidebar',
																)
											),
											"content_bottom_area" => array 
											(
												"area_name" => "Content Bottom Area",
												"limit" => 999,
												"area_options" => array (
																'_image_box'=>'Image Box' ,
																'_image_box2'=>'Images Box' ,
																'_service_box'=>'Service Box' ,
																'_service_box2'=>'Services Element' ,
																'_recent_work'=>'Recent Work' ,
																'_recent_work2'=>'Recent Work 2' ,
																'_call_banner'=>'Call Out Banner' ,
																'_features_element'=>'Features Element' ,
																'_features_element2'=>'Features Element 2' ,
																'_latest_posts'=>'Latest Posts' ,
																'_latest_posts2'=>'Latest Posts 2' ,
																'_latest_posts3'=>'Latest Posts 3' ,
																'_latest_posts4'=>'Latest Posts 4' ,
																'_accordion'=>'Accordion' ,
																'_testimonial_box'=>'Testimonial Box' ,
																'_testimonial_slider'=>'Testimonials Fader' ,
																'_testimonial_slider2'=>'Testimonials Slider' ,
																'_step_box'=>'Steps Box' ,
																'_step_box2'=>'Steps Box 2' ,
																'_step_box3'=>'Steps Box 3' ,
																'_partners_logos'=>'Partners Logos' ,
																'_keyword'=>'Keywords Element' ,
																'_infobox'=>'Info Box' ,
																'_infobox2'=>'Info Box 2' ,
																'_flickrfeed'=>'Flickr Feed' ,
																'_circle_title_box'=>'Circle Title Text Box' ,
																'_text_box'=>'Text Box' ,
																'_screenshoot_box'=>'Screenshoots Box' ,
																'_hover_box'=>'Hover Box' ,
																'_vertical_tabs'=>'Vertical Tabs' ,
																'_tabs'=>'Horizontal Tabs' ,
																'_stats_box'=>'Stats Box' ,
																'_c_form' => 'Contact Form',
																'_historic' => 'Historic Element',
																'_team_box' => 'Team Box',
																'_image_gallery' => 'Image Gallery',
																'_woo_products' => 'Shop Products Presentation',
																'_woo_limited' => 'Shop Limited Offers',
																'_shop_features' => 'Shop Features',
																'_video_box' => 'Video Box',
																'_portfolio_category' => 'Portfolio Category',
																'_portfolio_sortable' => 'Portfolio Sortable',
																'_portfolio_carousel' => 'Portfolio Carousel Layout',
																'_photo_gallery' => 'Photo Gallery',
																'_content_sidebar' => 'Content and Sidebar',
																'_zn_documentation' => 'Documentation',
																'_zn_sidebar' => 'Sidebar',
																)
											)
										)
					);	



/*--------------------------------------------------------------------------------------------------
	Content and Sidebar
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array ( 
						"name" => "Content and Sidebar",
						"description" => "Content and Sidebar",
						"id" => "_content_sidebar",
						"std" => '',
						"type" => "group",
						"add_text" => "Content",
						"remove_text" => "Content",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "sixteen",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This element has no options. Using this element, the editor content along with the page selected sidebar will be placed in this location rather than on top of the page builder elements.",
												"id" => "_sizer",
												"std" => "sixteen",
												"type" => "description"
											)										
										)
					);	

/*--------------------------------------------------------------------------------------------------
	Sidebar
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array ( 
						"name" => "Sidebar",
						"description" => "Sidebar",
						"id" => "_zn_sidebar",
						"std" => '',
						"type" => "group",
						"add_text" => "Sidebar",
						"remove_text" => "Sidebar",
						"hidden" => true,
						"sizes" => "four,one-third,eight,two-thirds,twelve,sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "four",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),	
											array( 
												"name" => "Select sidebar",
												"description" => "Select your desired sidebar to be used on this post",
												"id" => "sidebar_select",
												"std" => "",
												"type" => "select",
												"options" => $sidebar_option
											),
											array( 
												"name" => "Show background ?",
												"description" => "Select yes if you want to show the default sidebar background or no to use a transparent background.",
												"id" => "sidebar_bg",
												"std" => "yes",
												"type" => "select",
												"options" => array( 'yes' => 'Yes' , 'no' => 'No' )
											)
										)
					);	

/*--------------------------------------------------------------------------------------------------
	Photo Gallery
--------------------------------------------------------------------------------------------------*/
// Single Photo Gallery
$extra_options['single_photo_gallery'] = array( "name" => "Images",
						"description" => "Here you can add your desired images.",
						"id" => "single_photo_gallery",
						"std" => "",
						"type" => "group",
						"add_text" => "Image",
						"remove_text" => "Image",
						"group_title" => "",
						"group_sortable" => true,
						"subelements" => array 
											(
												array
												( 
													"name" => "Title",
													"description" => "Please enter a title for this image.",
													"id" => "spg_title",
													"std" => "",
													"type" => "text"
												),
												array
												( 
													"name" => "Image",
													"description" => "Please select an image.",
													"id" => "spg_image",
													"std" => "",
													"type" => "media"
												),
												array
												( 
													"name" => "Video URL",
													"description" => "Please enter the URL for your video.",
													"id" => "spg_video",
													"std" => "",
													"type" => "text"
												),	

											)
						);						
$zn_meta_elements[] = array ( 
						"name" => "Photo Gallery",
						"description" => "Photo Gallery",
						"id" => "_photo_gallery",
						"std" => '',
						"type" => "group",
						"add_text" => "Image",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(

											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "sixteen",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array( 
												"name" => "Number of columns",
												"description" => "Select the desired number of columns for the images.",
												"id" => "pg_num_cols",
												"std" => "6",
												"type" => "select",
												"options" => array( '1' => '1', '2'=>'2' ,  '3'=>'3' , '4'=>'4' , '6'=>'6')
											),
											array
											( 
												"name" => "Images Height",
												"description" => "Select the desired image height in pixels.",
												"id" => "pg_img_height",
												"std" => "",
												"type" => "text",
											),
											$extra_options['single_photo_gallery']
										)
					);	


/*--------------------------------------------------------------------------------------------------
	3D Cute Slider
--------------------------------------------------------------------------------------------------*/			
		
$zn_meta_elements[] = array ( 
						"name" => "3D Cute Slider",
						"description" => "3D Cute Slider",
						"id" => "_cute_slider",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array( 
												"name" => "Background Style",
												"description" => "Select the background style you want to use.Please note that the styles can be created from the unlimited headers options in the theme admin's page.",
												"id" => "ww_header_style",
												"std" => "",
												"type" => "select",
												"options" => $header_option,
												"class" => ""
											),
											array( 
												"name" => "Select slider",
												"description" => "Select the desired slider you want to use. Please note that the slider can be created from inside the Cute Slider option.",
												"id" => "cuteslider_id",
												"std" => "",
												"type" => "select",
												"options" => $cuteslider_options
											)
										)
					);

/*--------------------------------------------------------------------------------------------------
	REVOLUTION Slider
--------------------------------------------------------------------------------------------------*/			
		
$zn_meta_elements[] = array ( 
						"name" => "Revolution Slider",
						"description" => "Revolution Slider",
						"id" => "_rev_slider",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array( 
												"name" => "Background Style",
												"description" => "Select the background style you want to use.Please note that the styles can be created from the unlimited headers options in the theme admin's page.",
												"id" => "ww_header_style",
												"std" => "",
												"type" => "select",
												"options" => $header_option,
												"class" => ""
											),
											array( 
												"name" => "Select slider",
												"description" => "Select the desired slider you want to use. Please note that the slider can be created from inside the Revolution Slider options page.",
												"id" => "revslider_id",
												"std" => "",
												"type" => "select",
												"options" => $revslider_options
											),
											array( 
												"name" => "Use Paralax effect",
												"description" => "Select yes if you have used the paralax classes when you created your slider.",
												"id" => "revslider_paralax",
												"std" => "0",
												"type" => "select",
												"options" => array( 0 => 'No', 1=>'Yes')
											)
										)
					);

/*--------------------------------------------------------------------------------------------------
	Video Box
--------------------------------------------------------------------------------------------------*/			
		
$zn_meta_elements[] = array ( 
						"name" => "Video Box",
						"description" => "Video Box",
						"id" => "_video_box",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "four,one-third,eight,two-thirds,twelve,sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "four",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array
											( 
												"name" => "Video URL",
												"description" => "Please enter a link to your desired video ( Youtube and Vimeo ).",
												"id" => "vb_video_url",
												"std" => "",
												"type" => "text"
											),
											array
											( 
												"name" => "Image",
												"description" => "Please select an image that you want to display.If no image is selected, the video will be shown directly.",
												"id" => "vb_video_image",
												"std" => "",
												"type" => "media"
											),
											array
											( 
												"name" => "Video title",
												"description" => "Please enter a title that will appear over the play icon. This will only be shown if you select an image.",
												"id" => "vb_video_title",
												"std" => "",
												"type" => "text"
											)
										)
					);
		
/*--------------------------------------------------------------------------------------------------
	Service Box
--------------------------------------------------------------------------------------------------*/
// Single Service
$extra_options['single_service_elem'] = array( "name" => "Services",
						"description" => "Here you can add your desired service boxes.",
						"id" => "single_service_elem",
						"std" => "",
						"type" => "group",
						"add_text" => "Box",
						"remove_text" => "Box",
						"group_title" => "",
						"group_sortable" => true,
						"subelements" => array 
											(
												array
												( 
													"name" => "Service title",
													"description" => "Please enter a title for this service box.",
													"id" => "sbe_title",
													"std" => "",
													"type" => "text"
												),	
												array
												( 
													"name" => "Service Content",
													"description" => "Please enter a content for this service box.",
													"id" => "sbe_content",
													"std" => "",
													"type" => "textarea"
												),
												array
												( 
													"name" => "Sub Services",
													"description" => "Please enter your secondary servives one on a line. These will appear when someon hovers over the service box.",
													"id" => "sbe_services",
													"std" => "",
													"type" => "textarea"
												),
												array
												( 
													"name" => "Title Icon",
													"description" => "Please select an icon that will appear on the left of the title.",
													"id" => "sbe_image",
													"std" => "",
													"type" => "media"
												)
											)
						);						
$zn_meta_elements[] = array ( 
						"name" => "Services Element",
						"description" => "Services Element",
						"id" => "_service_box2",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "sixteen",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											$extra_options['single_service_elem']
										)
					);	
					

/*--------------------------------------------------------------------------------------------------
	Image Gallery
--------------------------------------------------------------------------------------------------*/	
// Single image gallery group
$extra_options['single_image_gallery'] = array( "name" => "Images",
						"description" => "Here you can add your desired images.",
						"id" => "single_ig",
						"std" => "",
						"type" => "group",
						"add_text" => "Image",
						"remove_text" => "Image",
						"group_title" => "",
						"group_sortable" => true,
						"subelements" => array 
											(
												array
												( 
													"name" => "Image",
													"description" => "Please select an image.",
													"id" => "sig_image",
													"std" => "",
													"type" => "media"
												)
											)
						);	
						
$zn_meta_elements[] = array ( 
						"name" => "Image Gallery",
						"description" => "Image Gallery",
						"id" => "_image_gallery",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "sixteen",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array
											( 
												"name" => "Name",
												"description" => "Please enter a name for this team member",
												"id" => "ig_title",
												"std" => "",
												"type" => "text",
											),
											$extra_options['single_image_gallery']
										)
					);
					
/*--------------------------------------------------------------------------------------------------
	Team Box
--------------------------------------------------------------------------------------------------*/	
// team group
$extra_options['teb_single_social'] = array( "name" => "Social Icons",
						"description" => "Here you can add your desired social icons.",
						"id" => "single_team_social",
						"std" => "",
						"type" => "group",
						"add_text" => "Icon",
						"remove_text" => "Icon",
						"group_title" => "",
						"group_sortable" => true,
						"subelements" => array 
											(
												array
												( 
													"name" => "Icon title",
													"description" => "Here you can enter a title for this social icon.Please note that this is just for your information as this text will not be visible on the site.",
													"id" => "teb_social_title",
													"std" => "",
													"type" => "text"
												),
												array
												( 
													"name" => "Social icon link",
													"description" => "Please enter your desired link for the social icon. If this field is left blank, the icon will not be linked.",
													"id" => "teb_social_link",
													"std" => "",
													"type" => "link",
													"options" => array ( '_blank' => "New window" , '_self' => "Same window" )
												),
												array
												( 
													"name" => "Social icon",
													"description" => "Select your desired social icon.",
													"id" => "teb_social_icon",
													"std" => "",
													"options" => $all_icon_sets,
													"type" => "zn_icon_font"
												)
											)
						);	
						
$zn_meta_elements[] = array ( 
						"name" => "Team Box",
						"description" => "Team Box",
						"id" => "_team_box",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "four",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "four",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array
											( 
												"name" => "Name",
												"description" => "Please enter a name for this team member",
												"id" => "teb_name",
												"std" => "",
												"type" => "text",
											),
											array
											( 
												"name" => "Position",
												"description" => "Please enter a position for this team member",
												"id" => "teb_position",
												"std" => "",
												"type" => "text",
											),
											array
											( 
												"name" => "Description",
												"description" => "Please enter a description for this team member",
												"id" => "teb_desc",
												"std" => "",
												"type" => "textarea",
											),
											array
											( 
												"name" => "Member image",
												"description" => "Please select an image for this team member",
												"id" => "teb_image",
												"std" => "",
												"type" => "media",
												"alt" => true
											),
											array( 
												"name" => "Image link",
												"description" => "Please choose the link you want to use for the image.",
												"id" => "teb_link",
												"std" => "",
												"type" => "link",
												"options" => array ( '_blank' => "New window" , '_self' => "Same window" )
											),
											$extra_options['teb_single_social']
										)
					);					
					
/*--------------------------------------------------------------------------------------------------
	Historic
--------------------------------------------------------------------------------------------------*/	
// Tabs group
$extra_options['historic_single'] = array( "name" => "Events",
						"description" => "Here you can add your desired events.",
						"id" => "historic_single",
						"std" => "",
						"type" => "group",
						"add_text" => "Event",
						"remove_text" => "Event",
						"group_title" => "",
						"group_sortable" => true,
						"subelements" => array 
											(
												array( 
													"name" => "Event title",
													"description" => "Please enter a title for this event",
													"id" => "she_event_name",
													"std" => "",
													"type" => "text"
												),
												array
												( 
													"name" => "Event date",
													"description" => "Please enter the date for this event",
													"id" => "she_event_date",
													"std" => "",
													"type" => "text",
												),
												array( 
													"name" => "Event description",
													"description" => "Please enter a description for this event",
													"id" => "she_event_desc",
													"std" => "",
													"type" => "textarea"
												),
											)
						);			
$zn_meta_elements[] = array ( 
						"name" => "Historic Element",
						"description" => "Historic Element",
						"id" => "_historic",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "sixteen",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array
											( 
												"name" => "Start text",
												"description" => "Please enter a text that will appear as a start",
												"id" => "he_start",
												"std" => "",
												"type" => "text",
											),
											$extra_options['historic_single']
										)
					);					
					
/*--------------------------------------------------------------------------------------------------
	Contact form element
--------------------------------------------------------------------------------------------------*/
// Tabs group
$extra_options['c_form'] = array( "name" => "Fields",
						"description" => "Here you can add your accordions.",
						"id" => "zn_cf_fields",
						"std" => "",
						"type" => "group",
						"add_text" => "Field",
						"remove_text" => "Field",
						"group_title" => "",
						"group_sortable" => true,
						"subelements" => array 
											(
												array( 
													"name" => "Field Type",
													"description" => "Here you can select what type of field will be displayed.",
													"id" => "zn_cf_type",
													"std" => "",
													"type" => "select",
													"options" => array ( 'text' => 'Text' , 'textarea' => 'Textarea' , 'captcha' => 'Captcha' )
												),		
												array( 
													"name" => "Field name",
													"description" => "Here you can enter the desired name for the this field",
													"id" => "zn_cf_name",
													"std" => "",
													"type" => "text"
												),
												array( 
													"name" => "Field Required ?",
													"description" => "Select if you want your field to be required.",
													"id" => "zn_cf_required",
													"std" => "",
													"type" => "select",
													"options" => array ( true => 'Yes' , false => 'No' )
												),
												array( 
													"name" => "Email Field ?",
													"description" => "Select yes if this is the email field.Will be used as the reply to option when receiving a submission email.",
													"id" => "zn_cf_f_email",
													"std" => "false",
													"type" => "select",
													"options" => array ( false => 'No' , true => 'Yes' )
												),
												array( 
													"name" => "Name Field ?",
													"description" => "Select yes if this will be the visitor's name field.Will be used as the reply to option when receiving a submission email.",
													"id" => "zn_cf_f_name",
													"std" => "false",
													"type" => "select",
													"options" => array ( false => 'No' , true => 'Yes' )
												)
											)
						);
		
$zn_meta_elements[] = array ( 
						"link_to" => "content_area",
						"name" => "Contact Form",
						"description" => "Contact Form element",
						"id" => "_c_form",
						"std" => '',
						"type" => "group",
						"add_text" => "Field",
						"remove_text" => "Field",
						"hidden" => true,
						"sizes" => "four,one-third,eight,two-thirds,twelve,sixteen",
						"link" => "content_area",						
						"subelements" => array 
										(
											array( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "four",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array( 
												"name" => "Email Address",
												"description" => "Please enter the email adress where you want the contact form submissions to be sent",
												"id" => "zn_cf_email_address",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Description",
												"description" => "Here you can enter a description that will appear above the form.",
												"id" => "zn_cf_desc",
												"std" => "",
												"type" => "textarea"
											),	
											array( 
												"name" => "Submit Button Text",
												"description" => "Here you can enter the desired text that will appear on the submit button",
												"id" => "zn_cf_button_value",
												"std" => "Send Message",
												"type" => "text"
											),
											array( 
												"name" => "Email Subject Text",
												"description" => "Here you can enter the desired subject text that will appear when receiving a mail from this form",
												"id" => "zn_cf_button_subject",
												"std" => "New Contact Form submission",
												"type" => "text"
											),
											$extra_options['c_form']
											
										)
					);			
					
/*--------------------------------------------------------------------------------------------------
	Stats Box
--------------------------------------------------------------------------------------------------*/
// STATS SINGLE
$extra_options['stats_single'] = array( "name" => "Stats Boxes",
						"description" => "Here you can add your desired stats boxes.",
						"id" => "single_stats",
						"std" => "",
						"type" => "group",
						"add_text" => "Stat Box",
						"remove_text" => "Stat Box",
						"group_sortable" => true,
						"subelements" => array 
											(
												array( 
													"name" => "Title",
													"description" => "Please enter the desired title that will appear on the right of the icon.",
													"id" => "sb_title",
													"std" => "",
													"type" => "text"
												),
												array( 
													"name" => "Content",
													"description" => "Please enter the desired title that will appear bellow the icon/Title.",
													"id" => "sb_content",
													"std" => "",
													"type" => "text"
												),
												array( 
													"name" => "Icon",
													"description" => "Please select an icon that will appear on the left side of the title.",
													"id" => "sb_icon",
													"std" => "",
													"type" => "media"
												)
											)
						);					
$zn_meta_elements[] = array ( 
						"name" => "Stats Box",
						"description" => "Stats Box",
						"id" => "_stats_box",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "four,eight,twelve,sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "four",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array
											( 
												"name" => "Title",
												"description" => "Please enter the title for this box",
												"id" => "stb_title",
												"std" => "",
												"type" => "text",
											),
											array( 
												"name" => "Tab icon",
												"description" => "Select your desired icon that will appear on the left side of the title.",
												"id" => "vts_tab_icon",
												"std" => "",
												"options" => $bootstrap_icons,
												"type" => "zn_icon_font",
												""
											),
											$extra_options['stats_single']
										)
					);			
					
/*--------------------------------------------------------------------------------------------------
	Text Box
--------------------------------------------------------------------------------------------------*/	
				
$zn_meta_elements[] = array ( 
						"name" => "Text Box",
						"description" => "Text Box",
						"id" => "_text_box",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "four,one-third,eight,two-thirds,twelve,sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "four",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array
											( 
												"name" => "Title",
												"description" => "Please enter the title for this box",
												"id" => "stb_title",
												"std" => "",
												"type" => "text",
											),
											array
											( 
												"name" => "Content",
												"description" => "Please enter the box content",
												"id" => "stb_content",
												"std" => "",
												"type" => "textarea",
											),
											array( 
												"name" => "Title style",
												"description" => "Select the desired style for the title of this box",
												"id" => "stb_style",
												"type" => "select",
												"std" => "style1",
												"options" => array ( 'style1' => 'Style 1', 'style2' => 'Style 2'  ),
											)
										)
					);	
					
/*--------------------------------------------------------------------------------------------------
	HORIZONTAL TABS
--------------------------------------------------------------------------------------------------*/	
// HORIZONTAL TABS SINGLE
$extra_options['hts_single'] = array( "name" => "Tabs",
						"description" => "Here you can add your desired tabs.",
						"id" => "single_horizontal_tab",
						"std" => "",
						"type" => "group",
						"add_text" => "Tab",
						"remove_text" => "Tab",
						"group_sortable" => true,
						"subelements" => array 
											(
												array( 
													"name" => "Tab Title",
													"description" => "Please enter the desired title that will appear as tab.",
													"id" => "vts_tab_title",
													"std" => "",
													"type" => "text"
												),
												array( 
													"name" => "Tab Content Title",
													"description" => "Please enter the desired title that will appear inside the tab.",
													"id" => "vts_tab_c_title",
													"std" => "",
													"type" => "text"
												),
												array( 
													"name" => "Content",
													"description" => "Please enter the desired content for this tab.",
													"id" => "vts_tab_c_content",
													"std" => "",
													"type" => "textarea"
												)
											)
						);	
						
$zn_meta_elements[] = array ( 
						"name" => "Horizontal Tabs",
						"description" => "Horizontal Tabs",
						"id" => "_tabs",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "four,one-third,eight,two-thirds,twelve,sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "four",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											$extra_options['hts_single']
											
										)
					);	

		
/*--------------------------------------------------------------------------------------------------
	VERTICAL TABS
--------------------------------------------------------------------------------------------------*/	
// VERTICAL TABS SINGLE
$extra_options['vts_single'] = array( "name" => "Tabs",
						"description" => "Here you can add your desired tabs.",
						"id" => "single_vertical_tab",
						"std" => "",
						"type" => "group",
						"add_text" => "Tab",
						"remove_text" => "Tab",
						"group_sortable" => true,
						"subelements" => array 
											(
												array( 
													"name" => "Tab Title",
													"description" => "Please enter the desired title that will appear as tab.",
													"id" => "vts_tab_title",
													"std" => "",
													"type" => "text"
												),
												array( 
													"name" => "Tab icon",
													"description" => "Select your desired icon that will appear on the left side of the tab title.",
													"id" => "vts_tab_icon",
													"std" => "",
													"options" => $bootstrap_icons,
													"type" => "zn_icon_font",
													""
												),
												array( 
													"name" => "Tab Content Title",
													"description" => "Please enter the desired title that will appear inside the tab.",
													"id" => "vts_tab_c_title",
													"std" => "",
													"type" => "text"
												),
												array( 
													"name" => "Content",
													"description" => "Please enter the desired content for this tab.",
													"id" => "vts_tab_c_content",
													"std" => "",
													"type" => "textarea"
												)
											)
						);					
$zn_meta_elements[] = array ( 
						"name" => "Vertical Tabs",
						"description" => "Vertical Tabs",
						"id" => "_vertical_tabs",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "eight,two-thirds,twelve,sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "eight",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											$extra_options['vts_single']
											
										)
					);				
					
/*--------------------------------------------------------------------------------------------------
	Hover Box
--------------------------------------------------------------------------------------------------*/					
$zn_meta_elements[] = array ( 
						"name" => "Hover Box",
						"description" => "Hover Box",
						"id" => "_hover_box",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "four,one-third,eight,two-thirds,twelve,sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "four",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array
											( 
												"name" => "Title",
												"description" => "Please enter a title for this box.",
												"id" => "hb_title",
												"std" => "",
												"type" => "text",
											),
											array
											( 
												"name" => "Subitle",
												"description" => "Please enter a subtitle for this box.",
												"id" => "hb_subtitle",
												"std" => "",
												"type" => "text",
											),
											array
											( 
												"name" => "Description",
												"description" => "Please enter a description for this box.",
												"id" => "hb_desc",
												"std" => "",
												"type" => "textarea",
											),
											array( 
												"name" => "Content Style",
												"description" => "Select the desired aligment for the content",
												"id" => "hb_align",
												"type" => "select",
												"std" => "style1",
												"options" => array ( 'zn_fill_class' => 'Normal', 'centered' => 'Centered'  ),
											),
											array
											( 
												"name" => "Icon",
												"description" => "Please select an icon for this box.",
												"id" => "hb_icon",
												"std" => "",
												"type" => "media",
											),
											array( 
												"name" => "Box Link",
												"description" => "Please choose the link you want to use.",
												"id" => "hb_link",
												"std" => "",
												"type" => "link",
												"options" => array ( '_blank' => "New window" , '_self' => "Same window" )
											),
										)
					);					
					
/*--------------------------------------------------------------------------------------------------
	Screenshoots Box
--------------------------------------------------------------------------------------------------*/
// FEATURES SINGLE
$extra_options['ssb_feat_single'] = array( "name" => "Features",
						"description" => "Here you can add your desired features.",
						"id" => "ssb_feat_single",
						"std" => "",
						"type" => "group",
						"add_text" => "Feature",
						"remove_text" => "Feature",
						"group_sortable" => true,
						"subelements" => array 
											(
												array( 
													"name" => "Title",
													"description" => "Please enter the desired title for this feature.",
													"id" => "ssb_single_title",
													"std" => "",
													"type" => "text"
												),
												array( 
													"name" => "Description",
													"description" => "Please enter the desired description for this feature.",
													"id" => "ssb_single_desc",
													"std" => "",
													"type" => "textarea"
												)
											)
						);	

// IMAGES SINGLE
$extra_options['ssb_imag_single'] = array( "name" => "Images",
						"description" => "Here you can add your screenshoots images.",
						"id" => "ssb_imag_single",
						"std" => "",
						"type" => "group",
						"add_text" => "Image",
						"remove_text" => "Image",
						"group_sortable" => true,
						"subelements" => array 
											(
												array( 
													"name" => "Image",
													"description" => "Please choose your desired screenshoot.",
													"id" => "ssb_single_screenshoot",
													"std" => "",
													"type" => "media"
												)
											)
						);	
					
$zn_meta_elements[] = array ( 
						"name" => "Screenshoots Box",
						"description" => "Screenshoots Box",
						"id" => "_screenshoot_box",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "sixteen",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array
											( 
												"name" => "Title",
												"description" => "Please enter title for this box.",
												"id" => "ssb_title",
												"std" => "",
												"type" => "text",
											),
											array
											( 
												"name" => "Link Text",
												"description" => "Please enter a text that will appear as a button link.",
												"id" => "ssb_link_text",
												"std" => "",
												"type" => "text",
											),
											array( 
												"name" => "Button Link",
												"description" => "Please choose the link you want to use.",
												"id" => "ssb_button_link",
												"std" => "",
												"type" => "link",
												"options" => array ( '_blank' => "New window" , '_self' => "Same window" )
											),
											$extra_options['ssb_feat_single'],
											$extra_options['ssb_imag_single']
										)
					);			
					
/*--------------------------------------------------------------------------------------------------
	Circle Title Text Box
--------------------------------------------------------------------------------------------------*/					
$zn_meta_elements[] = array ( 
						"name" => "Circle Title Text Box",
						"description" => "Circle Title Text Box",
						"id" => "_circle_title_box",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "four,one-third,eight,two-thirds,twelve,sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "four",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array
											( 
												"name" => "Circle Text Title",
												"description" => "Please enter a small word that will appear on the left circle beside the main title.",
												"id" => "ctb_circle_title",
												"std" => "",
												"type" => "text",
											),
											array
											( 
												"name" => "Main Title",
												"description" => "Please enter a main title for this box.",
												"id" => "ctb_main_title",
												"std" => "",
												"type" => "text",
											),
											array
											( 
												"name" => "Conent",
												"description" => "Please enter a content for this box.",
												"id" => "ctb_content",
												"std" => "",
												"type" => "textarea",
											),
										)
					);					
					
/*--------------------------------------------------------------------------------------------------
	Flickr FEED
--------------------------------------------------------------------------------------------------*/					
$zn_meta_elements[] = array ( 
						"name" => "Flickr Feed",
						"description" => "Flickr Feed",
						"id" => "_flickrfeed",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "four,one-third,eight,two-thirds,twelve,sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "four",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array
											( 
												"name" => "Title",
												"description" => "Please enter a title for this element",
												"id" => "ff_title",
												"std" => "",
												"type" => "text",
											),
											array
											( 
												"name" => "Flickr ID",
												"description" => "Please enter your flickrID",
												"id" => "ff_id",
												"std" => "",
												"type" => "text",
											),
											array( 
												"name" => "Image Size",
												"description" => "Select the desired image size for the flickr images",
												"id" => "ff_image_size",
												"type" => "select",
												"std" => "small",
												"options" => array ( 'normal' => 'Normal', 'small' => 'Small'  ),
											),
											array
											( 
												"name" => "Images to load",
												"description" => "Please enter the number of images that you want to display",
												"id" => "ff_images",
												"std" => "6",
												"type" => "text",
											),
										)
					);				
	
/*--------------------------------------------------------------------------------------------------
	Testimonial Slider
--------------------------------------------------------------------------------------------------*/	
// TESTIMONIALS SINGLE
$extra_options['tfs_single'] = array( "name" => "Testimonials",
						"description" => "Here you can add your testimonials.",
						"id" => "testimonials_slider_single",
						"std" => "",
						"type" => "group",
						"add_text" => "Testimonial",
						"remove_text" => "Testimonial",
						"group_sortable" => true,
						"subelements" => array 
											(
												array( 
													"name" => "Testimonial",
													"description" => "Please enter the desired testimonial.",
													"id" => "tf_single_test",
													"std" => "",
													"type" => "textarea"
												),
												array( 
													"name" => "Testimonial author",
													"description" => "Please enter the desired author for this testimonial.",
													"id" => "tf_single_author",
													"std" => "",
													"type" => "text"
												)
											)
						);				
$zn_meta_elements[] = array ( 
						"name" => "Testimonial Slider",
						"description" => "Testimonial Slider",
						"id" => "_testimonial_slider2",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "four,one-third,eight,two-thirds,twelve,sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "four",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array
											( 
												"name" => "Title",
												"description" => "Please enter the Testimonials Fader title",
												"id" => "tf_title",
												"std" => "",
												"type" => "text",
											),
											array
											( 
												"name" => "Transition Speed",
												"description" => "Please enter a numeric value for the transition speed.Default is 2500",
												"id" => "tf_speed",
												"std" => "2500",
												"type" => "text",
											),
											$extra_options['tfs_single']
										)
					);	
	
/*--------------------------------------------------------------------------------------------------
	Testimonial Fader
--------------------------------------------------------------------------------------------------*/	
// TESTIMONIALS SINGLE
$extra_options['tf_single'] = array( "name" => "Testimonials",
						"description" => "Here you can add your testimonials.",
						"id" => "testimonials_single",
						"std" => "",
						"type" => "group",
						"add_text" => "Testimonial",
						"remove_text" => "Testimonial",
						"group_sortable" => true,
						"subelements" => array 
											(
												array( 
													"name" => "Testimonial",
													"description" => "Please enter the desired testimonial.",
													"id" => "tf_single_test",
													"std" => "",
													"type" => "textarea"
												),
												array( 
													"name" => "Testimonial author",
													"description" => "Please enter the desired author for this testimonial.",
													"id" => "tf_single_author",
													"std" => "",
													"type" => "text"
												)
											)
						);				
$zn_meta_elements[] = array ( 
						"name" => "Testimonial Fader",
						"description" => "Testimonial Fader",
						"id" => "_testimonial_slider",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "sixteen",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array
											( 
												"name" => "Title",
												"description" => "Please enter the Testimonials Fader title",
												"id" => "tf_title",
												"std" => "",
												"type" => "text",
											),
											array
											( 
												"name" => "Description",
												"description" => "Please enter a description for this element",
												"id" => "tf_desc",
												"std" => "",
												"type" => "textarea",
											),
											array
											( 
												"name" => "Transition Speed",
												"description" => "Please enter a numeric value for the transition speed. Default is 5000",
												"id" => "tf_speed",
												"std" => "5000",
												"type" => "text",
											),
											$extra_options['tf_single']
										)
					);				
	
/*--------------------------------------------------------------------------------------------------
	Info Box 2
--------------------------------------------------------------------------------------------------*/				
			
$zn_meta_elements[] = array ( 
						"name" => "Info Box 2",
						"description" => "Info Box 2",
						"id" => "_infobox2",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "four,one-third,eight,two-thirds,twelve,sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "four",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array
											( 
												"name" => "Content",
												"description" => "Please enter the content for this box",
												"id" => "ib2_title",
												"std" => "",
												"type" => "textarea",
											)
										)
					);
	
/*--------------------------------------------------------------------------------------------------
	Info Box
--------------------------------------------------------------------------------------------------*/				
			
$zn_meta_elements[] = array ( 
						"name" => "Info Box",
						"description" => "Info Box",
						"id" => "_infobox",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "four,one-third,eight,two-thirds,twelve,sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "four",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array
											( 
												"name" => "Title",
												"description" => "Please enter the Info Box title",
												"id" => "ib_title",
												"std" => "",
												"type" => "text",
											),
											array
											( 
												"name" => "Subitle",
												"description" => "Please enter the Info Box subtitle",
												"id" => "ib_subtitle",
												"std" => "",
												"type" => "text",
											),
											array( 
												"name" => "Select Style",
												"description" => "Select the desired style for this element",
												"id" => "ib_style",
												"type" => "select",
												"std" => "style1",
												"options" => array ( 'infobox1' => 'Style 1', 'infobox2' => 'Style 2'  ),
											),
											array
											( 
												"name" => "Button Text",
												"description" => "Please enter a text that will appear as button",
												"id" => "ib_button_text",
												"std" => "",
												"type" => "text",
											),
											array( 
												"name" => "Button Link",
												"description" => "Please choose the link you want to use.",
												"id" => "ib_button_link",
												"std" => "",
												"type" => "link",
												"options" => array ( '_blank' => "New window" , '_self' => "Same window" )
											)
										)
					);		

/*--------------------------------------------------------------------------------------------------
	Keywords Element
--------------------------------------------------------------------------------------------------*/					
$zn_meta_elements[] = array ( 
						"name" => "Keywords Element",
						"description" => "Keywords Element",
						"id" => "_keyword",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "four,one-third,eight,two-thirds,twelve,sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "four",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array
											( 
												"name" => "Content",
												"description" => "Please enter the Keywords content",
												"id" => "kw_content",
												"std" => "",
												"type" => "textarea",
											)
										)
					);				
					
					
/*--------------------------------------------------------------------------------------------------
	Partners Logos
--------------------------------------------------------------------------------------------------*/
// STEPS SINGLE
$extra_options['pl_single'] = array( "name" => "Logos",
						"description" => "Here you can add your parners logos.",
						"id" => "partners_single",
						"std" => "",
						"type" => "group",
						"add_text" => "Logo",
						"remove_text" => "Logo",
						"group_sortable" => true,
						"subelements" => array 
											(
												array( 
													"name" => "Logo",
													"description" => "Please enter the logo for this partner.",
													"id" => "lp_single_logo",
													"std" => "",
													"type" => "media",
													"alt" => true
												),
												array( 
													"name" => "Logo Link",
													"description" => "Please choose the link you want to use.",
													"id" => "lp_link",
													"std" => "",
													"type" => "link",
													"options" => array ( '_blank' => "New window" , '_self' => "Same window" )
												),
											)
						);	
						
$zn_meta_elements[] = array ( 
						"name" => "Partners Logos",
						"description" => "Partners Logos",
						"id" => "_partners_logos",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "eight,two-thirds,twelve,sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "eight",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array
											( 
												"name" => "Title",
												"description" => "Please enter the title for this element.",
												"id" => "pl_title",
												"std" => "",
												"type" => "text",
											),
											array( 
												"name" => "Title Style",
												"description" => "Please select the style you want to use for this title.",
												"id" => "pl_title_style",
												"std" => "style1",
												"options" => array ( "style1" => "Style 1", "style2" => "Style 2" ),
												"type" => "select"
											),
											$extra_options['pl_single']
										)
					);		

/*--------------------------------------------------------------------------------------------------
	Steps Box 3
--------------------------------------------------------------------------------------------------*/			
// STEPS SINGLE
$extra_options['stp_single3'] = array( "name" => "Steps",
						"description" => "Here you can create your desired steps.",
						"id" => "steps_single3",
						"std" => "",
						"type" => "group",
						"add_text" => "Step",
						"remove_text" => "Step",
						"group_sortable" => true,
						"subelements" => array 
											(
												array( 
													"name" => "Step content",
													"description" => "Please enter a content for this step.",
													"id" => "stp_single_desc",
													"std" => "",
													"type" => "textarea"
												)
											)
						);	
		
$zn_meta_elements[] = array ( 
						"name" => "Steps Box 3",
						"description" => "Steps Box 3",
						"id" => "_step_box3",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "sixteen",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array
											( 
												"name" => "Title",
												"description" => "Please enter a title that will appear on over the boxes",
												"id" => "stp_title",
												"std" => "",
												"type" => "text",
											),
											$extra_options['stp_single3']
										)
					);	
					
/*--------------------------------------------------------------------------------------------------
	Steps Box
--------------------------------------------------------------------------------------------------*/			
// STEPS SINGLE
$extra_options['stp_single2'] = array( "name" => "Steps",
						"description" => "Here you can create your desired steps.",
						"id" => "steps_single2",
						"std" => "",
						"type" => "group",
						"add_text" => "Step",
						"remove_text" => "Step",
						"group_sortable" => true,
						"subelements" => array 
											(
												array( 
													"name" => "Step Title",
													"description" => "Please enter a title for this step.",
													"id" => "stp_single_title",
													"std" => "",
													"type" => "text"
												),
												array( 
													"name" => "Step content",
													"description" => "Please enter a content for this step.",
													"id" => "stp_single_desc",
													"std" => "",
													"type" => "textarea"
												),
												array( 
													"name" => "Box Link",
													"description" => "Please choose the link you want to use for this box.",
													"id" => "stp_single_link",
													"std" => "",
													"type" => "link",
													"options" => array ( '_blank' => "New window" , '_self' => "Same window" )
												),
												array( 
													"name" => "Use alternative style?",
													"description" => "Select yes if you want your box to use a different background color and display an OK icon on the left",
													"id" => "stp_single_ok",
													"type" => "select",
													"std" => "no",
													"options" => array ( 'yes' => 'Yes', 'no' => 'No' ),
												)
											)
						);	
		
$zn_meta_elements[] = array ( 
						"name" => "Steps Box 2",
						"description" => "Steps Box 2",
						"id" => "_step_box2",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "sixteen",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array
											( 
												"name" => "Title",
												"description" => "Please enter a title that will appear on over the boxes",
												"id" => "stp_title",
												"std" => "",
												"type" => "text",
											),
											$extra_options['stp_single2']
										)
					);	
			
/*--------------------------------------------------------------------------------------------------
	Steps Box
--------------------------------------------------------------------------------------------------*/			
// STEPS SINGLE
$extra_options['stp_single'] = array( "name" => "Steps",
						"description" => "Here you can create your desired Steps.",
						"id" => "steps_single",
						"std" => "",
						"type" => "group",
						"add_text" => "Step",
						"remove_text" => "Step",
						"group_sortable" => true,
						"subelements" => array 
											(
												array( 
													"name" => "Step Title",
													"description" => "Please enter a title for this step.",
													"id" => "stp_single_title",
													"std" => "",
													"type" => "text"
												),
												array( 
													"name" => "Step content",
													"description" => "Please enter a content for this step.",
													"id" => "stp_single_desc",
													"std" => "",
													"type" => "textarea"
												),
												array( 
													"name" => "Step icon",
													"description" => "Please enter an icon for this step.",
													"id" => "stp_single_icon",
													"std" => "",
													"type" => "media"
												),
												array( 
													"name" => "Step Icon Animation",
													"description" => "Select the desired animation for this step",
													"id" => "stp_single_anim",
													"type" => "select",
													"std" => "tada",
													"options" => array ( 'tada' => 'Tada', 'pulse' => 'Pulse' , 'fadeOutRightBig' => 'Fade Out Right Big'   ),
												)
											)
						);	
		
$zn_meta_elements[] = array ( 
						"name" => "Steps Box",
						"description" => "Steps Box",
						"id" => "_step_box",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "sixteen",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array
											( 
												"name" => "Title",
												"description" => "Please enter a title that will appear on the first box",
												"id" => "stp_title",
												"std" => "",
												"type" => "text",
											),
											array
											( 
												"name" => "Subtitle",
												"description" => "Please enter a subttitle that will appear on the first box",
												"id" => "stp_subtitle",
												"std" => "",
												"type" => "text",
											),
											array
											( 
												"name" => "Description",
												"description" => "Please enter a description that will appear on the first box",
												"id" => "stp_desc",
												"std" => "",
												"type" => "textarea",
											),
											array
											( 
												"name" => "Link Text",
												"description" => "Please enter a text that will appear as link in the first box under the description.",
												"id" => "stp_text_link",
												"std" => "",
												"type" => "text",
											),
											array( 
												"name" => "Bottom Link",
												"description" => "Please choose the link you want to use.",
												"id" => "stp_link",
												"std" => "",
												"type" => "link",
												"options" => array ( '_blank' => "New window" , '_self' => "Same window" )
											),
											$extra_options['stp_single']
										)
					);					
					
/*--------------------------------------------------------------------------------------------------
	Testimonial Box
--------------------------------------------------------------------------------------------------*/					
$zn_meta_elements[] = array ( 
						"name" => "Testimonial Box",
						"description" => "Testimonial Box",
						"id" => "_testimonial_box",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "four,one-third,eight,two-thirds,twelve,sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "four",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array
											( 
												"name" => "Author",
												"description" => "Please enter the quote author name",
												"id" => "tb_author",
												"std" => "",
												"type" => "text",
											),
											array
											( 
												"name" => "Author Company",
												"description" => "Please enter the quote author company/function",
												"id" => "tb_author_com",
												"std" => "",
												"type" => "text",
											),
											array
											( 
												"name" => "Author Quote",
												"description" => "Please enter the quote for this author",
												"id" => "tb_author_quote",
												"std" => "",
												"type" => "textarea",
											),
											array
											( 
												"name" => "Author logo",
												"description" => "Please select a logo for this author.",
												"id" => "tb_author_logo",
												"std" => "",
												"type" => "media",
											),
											array( 
												"name" => "Testimonial style",
												"description" => "Select the desired style for this testimonial element",
												"id" => "tb_style",
												"type" => "select",
												"std" => "style1",
												"options" => array ( 'style1' => 'Style 1', 'style2' => 'Style 2'  ),
											)
										)
					);	
	
/*--------------------------------------------------------------------------------------------------
	Accordion
--------------------------------------------------------------------------------------------------*/
// Accordion SINGLE
$extra_options['acc_single'] = array( "name" => "Accordions",
						"description" => "Here you can create your desired accordions.",
						"id" => "accordion_single",
						"std" => "",
						"type" => "group",
						"add_text" => "Accordion",
						"remove_text" => "Accordion",
						"group_sortable" => true,
						"subelements" => array 
											(
												array( 
													"name" => "Title",
													"description" => "Please enter a title for this accordion.",
													"id" => "acc_single_title",
													"std" => "",
													"type" => "text"
												),
												array( 
													"name" => "Accordion content",
													"description" => "Please enter a content for this accordion.",
													"id" => "acc_single_desc",
													"std" => "",
													"type" => "textarea"
												),
												array( 
													"name" => "Auto Colapsed",
													"description" => "Select yes if you want this accordion to be visible on page load.",
													"id" => "acc_colapsed",
													"std" => "no",
													"options" => array ( 'yes' => 'Yes', 'no' => 'No' ),
													"type" => "select"
												)
											)
						);					
$zn_meta_elements[] = array ( 
						"name" => "Accordion",
						"description" => "Accordion",
						"id" => "_accordion",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "four,one-third,eight,two-thirds,twelve,sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "four",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array
											( 
												"name" => "Title",
												"description" => "Enter a title for your Accordion element",
												"id" => "acc_title",
												"std" => "",
												"type" => "text",
											),
											array( 
												"name" => "Accordion Style",
												"description" => "Please select the style you want to use.",
												"id" => "acc_style",
												"std" => "style1",
												"options" => array ( 'default-style' => 'Style 1', 'style2' => 'Style 2', 'style3' => 'Style 3'  ),
												"type" => "select",
											),
											$extra_options['acc_single']
										)
					);	

/*--------------------------------------------------------------------------------------------------
	Latest Posts 4
--------------------------------------------------------------------------------------------------*/					
$zn_meta_elements[] = array ( 
						"name" => "Latest Posts 4",
						"description" => "Latest Posts 4",
						"id" => "_latest_posts4",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "one-third,two-thirds,sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "one-third",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array
											( 
												"name" => "Title",
												"description" => "Enter a title for your Latest Posts element",
												"id" => "lp_title",
												"std" => "",
												"type" => "text",
											),
											array
											( 
												"name" => "Number of posts",
												"description" => "Enter the number of posts that you want to show",
												"id" => "lp_num_posts",
												"std" => "3",
												"type" => "text",
											),
											array( 
												"name" => "Blog Category",
												"description" => "Select the blog category to show items",
												"id" => "lp_blog_categories",
												"mod" => "multi",
												"std" => "0",
												"type" => "select",
												"options" => $option_blog_cat
											)
										)
					);				
					
/*--------------------------------------------------------------------------------------------------
	Latest Posts 3
--------------------------------------------------------------------------------------------------*/					
$zn_meta_elements[] = array ( 
						"name" => "Latest Posts 3",
						"description" => "Latest Posts 3",
						"id" => "_latest_posts3",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "four,one-third,eight,two-thirds,twelve,sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "four",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array
											( 
												"name" => "Title",
												"description" => "Enter a title for your Latest Posts element",
												"id" => "lp_title",
												"std" => "",
												"type" => "text",
											),
											array
											( 
												"name" => "Blog page Link",
												"description" => "Enter the link to your blog page",
												"id" => "lp_blog_page",
												"std" => "",
												"type" => "text",
											),
											array
											( 
												"name" => "Number of posts",
												"description" => "Enter the number of posts that you want to show",
												"id" => "lp_num_posts",
												"std" => "2",
												"type" => "text",
											),
											array( 
												"name" => "Blog Category",
												"description" => "Select the blog category to show items",
												"id" => "lp_blog_categories",
												"mod" => "multi",
												"std" => "0",
												"type" => "select",
												"options" => $option_blog_cat
											)
										)
					);					
					
/*--------------------------------------------------------------------------------------------------
	Latest Posts 2
--------------------------------------------------------------------------------------------------*/					
$zn_meta_elements[] = array ( 
						"name" => "Latest Posts 2",
						"description" => "Latest Posts 2",
						"id" => "_latest_posts2",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "four,one-third,eight,two-thirds,twelve,sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "four",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array
											( 
												"name" => "Title",
												"description" => "Enter a title for your Latest Posts element",
												"id" => "lp_title",
												"std" => "",
												"type" => "text",
											),
											array
											( 
												"name" => "Blog page Link",
												"description" => "Enter the link to your blog page",
												"id" => "lp_blog_page",
												"std" => "",
												"type" => "text",
											),
											array
											( 
												"name" => "Number of posts",
												"description" => "Enter the number of posts that you want to show",
												"id" => "lp_num_posts",
												"std" => "2",
												"type" => "text",
											),
											array( 
												"name" => "Blog Category",
												"description" => "Select the blog category to show items",
												"id" => "lp_blog_categories",
												"mod" => "multi",
												"std" => "0",
												"type" => "select",
												"options" => $option_blog_cat
											),
										)
					);	
					
/*--------------------------------------------------------------------------------------------------
	Latest Posts Element
--------------------------------------------------------------------------------------------------*/					
$zn_meta_elements[] = array ( 
						"name" => "Latest Posts",
						"description" => "Latest Posts",
						"id" => "_latest_posts",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "sixteen",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array
											( 
												"name" => "Title",
												"description" => "Enter a title for your Latest Posts element",
												"id" => "lp_title",
												"std" => "",
												"type" => "text",
											),
											array
											( 
												"name" => "Blog page Link",
												"description" => "Enter the link to your blog page",
												"id" => "lp_blog_page",
												"std" => "",
												"type" => "text",
											),
											array( 
												"name" => "Blog Category",
												"description" => "Select the blog category to show items",
												"id" => "lp_blog_categories",
												"mod" => "multi",
												"std" => "0",
												"type" => "select",
												"options" => $option_blog_cat
											),
										)
					);		

/*--------------------------------------------------------------------------------------------------
	Features Element 2
--------------------------------------------------------------------------------------------------*/				
// FEATURES SINGLE
$extra_options['features_single2'] = array( "name" => "Features Boxes",
						"description" => "Here you can create your desired features boxes.",
						"id" => "features_single2",
						"std" => "",
						"type" => "group",
						"add_text" => "Feature box",
						"remove_text" => "Feature box",
						"group_sortable" => true,
						"subelements" => array 
											(
												array( 
													"name" => "Feature title",
													"description" => "Please enter a title for this feature box.",
													"id" => "fb_single_title",
													"std" => "",
													"type" => "text"
												),
												array( 
													"name" => "Feature description",
													"description" => "Please enter a description for this feature box.",
													"id" => "fb_single_desc",
													"std" => "",
													"type" => "textarea"
												),
												array( 
													"name" => "Feature icon",
													"description" => "Please select the desired icon to use.",
													"id" => "fb_single_icon",
													"std" => "ico1",
													"options" => array ( 'ico1' => 'Chat', 'ico2' => 'Document' , 'ico3' => 'Paint' , 'ico4' => 'Code'   ),
													"type" => "select",
												),
											)
						);
$zn_meta_elements[] = array ( 
						"name" => "Features Element 2",
						"description" => "Features Element 2",
						"id" => "_features_element2",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "sixteen",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array
											( 
												"name" => "Title",
												"description" => "Enter a title for your Features element",
												"id" => "fb_title",
												"std" => "",
												"type" => "text",
											),
											$extra_options['features_single2']
										)
					);			
					
/*--------------------------------------------------------------------------------------------------
	Features Element
--------------------------------------------------------------------------------------------------*/				
// FEATURES SINGLE
$extra_options['features_single'] = array( "name" => "Features Boxes",
						"description" => "Here you can create your desired features boxes.",
						"id" => "features_single",
						"std" => "",
						"type" => "group",
						"add_text" => "Feature box",
						"remove_text" => "Feature box",
						"group_sortable" => true,
						"subelements" => array 
											(
												array( 
													"name" => "Feature title",
													"description" => "Please enter a title for this feature box.",
													"id" => "fb_single_title",
													"std" => "",
													"type" => "text"
												),
												array( 
													"name" => "Feature description",
													"description" => "Please enter a description for this feature box.",
													"id" => "fb_single_desc",
													"std" => "",
													"type" => "textarea"
												),
												array( 
													"name" => "Feature icon",
													"description" => "Please choose an icon for this feature box. Please note that for best design , your icon should be 20x20 in size.",
													"id" => "fb_single_icon",
													"std" => "",
													"type" => "media"
												)
											)
						);
						
$zn_meta_elements[] = array ( 
						"name" => "Features Element",
						"description" => "Features Element",
						"id" => "_features_element",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "four,eight,twelve,sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "four",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array
											( 
												"name" => "Title",
												"description" => "Enter a title for your Features element",
												"id" => "fb_title",
												"std" => "",
												"type" => "text",
											),
											array
											( 
												"name" => "Secondary title",
												"description" => "Enter a secondary tytle for your Features Elemet. Please note that this description will only appear if you choose to use the style 2.",
												"id" => "fb_stitle",
												"std" => "",
												"type" => "text",
											),
											array
											( 
												"name" => "Description ",
												"description" => "Enter a description for your Features Elemet. Please note that this description will only appear if you choose to use the style 2.",
												"id" => "fb_desc",
												"std" => "",
												"type" => "textarea",
											),
											array( 
												"name" => "Features Box Style",
												"description" => "Please select the style you want to use.",
												"id" => "fb_style",
												"std" => "style1",
												"options" => array ( 'style1' => 'Style 1', 'style2' => 'Style 2', 'style3' => 'Style 3'  ),
												"type" => "select",
											),
											$extra_options['features_single']
										)
					);	
					
/*--------------------------------------------------------------------------------------------------
	Call Out Banner
--------------------------------------------------------------------------------------------------*/				
	
$zn_meta_elements[] = array ( 
						"name" => "Call Out Banner",
						"description" => "Call Out Banner",
						"id" => "_call_banner",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "sixteen",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array
											( 
												"name" => "Main Title",
												"description" => "Enter a title for your Call Out Banner element",
												"id" => "cab_main_title",
												"std" => "",
												"type" => "text",
											),
											array
											( 
												"name" => "Secondary Title",
												"description" => "Enter a secondary title for your Call Out Banner element",
												"id" => "cab_sec_title",
												"std" => "",
												"type" => "text",
											),
											array( 
												"name" => "Button Text",
												"description" => "Please enter a text that will appear on the right button.",
												"id" => "cab_button_text",
												"std" => "",
												"type" => "text",
											),
											array( 
												"name" => "Button Hover Image",
												"description" => "Please select an image that will appear when hovering the mouse over the button. If no image is choosen , the default OK image will be used",
												"id" => "cab_button_image",
												"std" => "",
												"type" => "media",
											),
											array( 
												"name" => "Button link",
												"description" => "Please choose the link you want to use for your button.",
												"id" => "cab_button_link",
												"std" => "",
												"type" => "link",
												"options" => array ( '_blank' => "New window" , '_self' => "Same window" )
											)
										)
					);	

/*--------------------------------------------------------------------------------------------------
	Portfolio Category
--------------------------------------------------------------------------------------------------*/				
	
$zn_meta_elements[] = array ( 
						"name" => "Portfolio Category",
						"description" => "Portfolio Category",
						"id" => "_portfolio_category",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "sixteen",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array( 
												"name" => "Portfolio Category",
												"description" => "Select the portfolio category to show items",
												"id" => "portfolio_categories",
												"mod" => "multi",
												"std" => "0",
												"type" => "select",
												"options" => $option_port_cat
											),
											array( 
												"name" => "Number of portfolio Items",
												"description" => "Please enter how many portfolio items you want to load.",
												"id" => "ports_per_page",
												"std" => "6",
												"type" => "text"
											),
											array( 
												"name" => "Number of portfolio Items Per Page",
												"description" => "Please enter how many portfolio items you want to load on a page.",
												"id" => "ports_per_page_visible",
												"std" => "4",
												"type" => "text"
											),
											array( 
												"name" => "Number of columns",
												"description" => "Please enter how many portfolio items you want to load on a page.",
												"id" => "ports_num_columns",
												"std" => "4",
												"options" => array ( '1' => '1' , '2' => '2' , '3' => '3' , '4' => '4' , ),
												"type" => "select"
											)
										)
					);

/*--------------------------------------------------------------------------------------------------
	Portfolio Sortable
--------------------------------------------------------------------------------------------------*/				
	
$zn_meta_elements[] = array ( 
						"name" => "Portfolio Sortable",
						"description" => "Portfolio Sortable",
						"id" => "_portfolio_sortable",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "sixteen",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array( 
												"name" => "Portfolio Category",
												"description" => "Select the portfolio category to show items",
												"id" => "portfolio_categories",
												"mod" => "multi",
												"std" => "0",
												"type" => "select",
												"options" => $option_port_cat
											),
											array( 
												"name" => "Number of portfolio Items",
												"description" => "Please enter how many portfolio items you want to load.",
												"id" => "ports_per_page",
												"std" => "6",
												"type" => "text"
											),
										)
					);

/*--------------------------------------------------------------------------------------------------
	Portfolio Carousel Layout
--------------------------------------------------------------------------------------------------*/				
	
$zn_meta_elements[] = array ( 
						"name" => "Portfolio Carousel Layout",
						"description" => "Portfolio Carousel Layout",
						"id" => "_portfolio_carousel",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "sixteen",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array( 
												"name" => "Portfolio Category",
												"description" => "Select the portfolio category to show items",
												"id" => "portfolio_categories",
												"mod" => "multi",
												"std" => "0",
												"type" => "select",
												"options" => $option_port_cat
											),
											array( 
												"name" => "Number of portfolio Items",
												"description" => "Please enter how many portfolio items you want to load.",
												"id" => "ports_per_page",
												"std" => "6",
												"type" => "text"
											),
											array( 
												"name" => "Number of portfolio Items Per Page",
												"description" => "Please enter how many portfolio items you want to load on a page.",
												"id" => "ports_per_page_visible",
												"std" => "4",
												"type" => "text"
											)
										)
					);


/*--------------------------------------------------------------------------------------------------
	Recent Work 2
--------------------------------------------------------------------------------------------------*/				
	
$zn_meta_elements[] = array ( 
						"name" => "Recent Work 2",
						"description" => "Recent Work 2",
						"id" => "_recent_work2",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "sixteen",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array
											( 
												"name" => "Recent Works Title",
												"description" => "Enter a title for your Recent Works element",
												"id" => "rw_title",
												"std" => "",
												"type" => "text",
											),
											array( 
												"name" => "Portfolio page link",
												"description" => "Please enter the link to your portfolio page.",
												"id" => "rw_port_link",
												"std" => "",
												"type" => "text",
											),
											array( 
												"name" => "Portfolio Category",
												"description" => "Select the portfolio category to show items",
												"id" => "portfolio_categories",
												"mod" => "multi",
												"std" => "0",
												"type" => "select",
												"options" => $option_port_cat
											),
											array( 
												"name" => "Number of portfolio Items",
												"description" => "Please enter how many portfolio items you want to load.",
												"id" => "ports_per_page",
												"std" => "6",
												"type" => "text"
											)
										)
					);			
			
/*--------------------------------------------------------------------------------------------------
	Recent Work 1
--------------------------------------------------------------------------------------------------*/				
	
$zn_meta_elements[] = array ( 
						"name" => "Recent Work",
						"description" => "Recent Work",
						"id" => "_recent_work",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "sixteen",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array
											( 
												"name" => "Recent Works Title",
												"description" => "Enter a title for your Recent Works element",
												"id" => "rw_title",
												"std" => "",
												"type" => "text",
											),
											array( 
												"name" => "Recent Works Description",
												"description" => "Please enter a description that will appear bellow the title.",
												"id" => "rw_desc",
												"std" => "",
												"type" => "textarea",
											),
											array( 
												"name" => "Portfolio page link",
												"description" => "Please enter the link to your portfolio page.",
												"id" => "rw_port_link",
												"std" => "",
												"type" => "text",
											),
											array( 
												"name" => "Portfolio Category",
												"description" => "Select the portfolio category to show items",
												"id" => "portfolio_categories",
												"mod" => "multi",
												"std" => "0",
												"type" => "select",
												"options" => $option_port_cat
											),
											array( 
												"name" => "Number of portfolio Items",
												"description" => "Please enter how many portfolio items you want to load.",
												"id" => "ports_per_page",
												"std" => "4",
												"type" => "text"
											)
										)
					);	
	
/*--------------------------------------------------------------------------------------------------
	Service Box
--------------------------------------------------------------------------------------------------*/

$zn_meta_elements[] = array ( 
						"name" => "Service Box",
						"description" => "Service Box",
						"id" => "_service_box",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "four,one-third,eight,two-thirds,twelve,sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "four",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array
											( 
												"name" => "Service Box Title",
												"description" => "Enter a title for your Service box",
												"id" => "service_box_title",
												"std" => "",
												"type" => "text",
											),
											array( 
												"name" => "Service Box Features",
												"description" => "Please enter your features one on a line.This will create your features list with an arrow on the right.",
												"id" => "service_box_features",
												"std" => "",
												"type" => "textarea",
											),
											array( 
												"name" => "Image",
												"description" => "Please select an image that will appear on the left side of the title.",
												"id" => "service_box_image",
												"std" => "",
												"type" => "media"
											)
										)
					);	

/*--------------------------------------------------------------------------------------------------
	Images Box 2
--------------------------------------------------------------------------------------------------*/
$extra_options['ib2_single'] = array( "name" => "Images",
						"description" => "Here you can add your images.",
						"id" => "ib2_single",
						"std" => "",
						"type" => "group",
						"add_text" => "Image",
						"remove_text" => "Image",
						"group_sortable" => true,
						"subelements" => array 
											(
												array( 
													"name" => "Image",
													"description" => "Please select an image.",
													"id" => "ib2_image",
													"std" => "",
													"type" => "media",
													"alt" => true
												),
												array( 
													"name" => "Image Link",
													"description" => "Please choose the link you want to use.",
													"id" => "ib2_link",
													"std" => "",
													"type" => "link",
													"options" => array ( '_blank' => "New window" , '_self' => "Same window" )
												),
												array( 
													"name" => "Image Width",
													"description" => "Please select the desired width for this image.The number 3 means the image will take a quarter of the space and 12 means it will take the full width of the page. Depending on the image sizes, you can stack images one under the other.",
													"id" => "ib2_width",
													"std" => "span4",
													"options" => array ( 'span3' => '3', 'span4' => '4' , 'span5' => '5' , 'span6' => '6', 'span7' => '7', 'span8' => '8', 'span9' => '9', 'span10' => '10', 'span11' => '11', 'span12' => '12' ),
													"type" => "select"
												)
											)
						);	

$zn_meta_elements[] = array ( 
						"name" => "Images Box",
						"description" => "Images Box",
						"id" => "_image_box2",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "sixteen",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array
											( 
												"name" => "Image Box Title",
												"description" => "Enter a title for your Image box",
												"id" => "image_box_title",
												"std" => "",
												"type" => "text",
											),
											$extra_options['ib2_single']
										)
					);	
					
/*--------------------------------------------------------------------------------------------------
	Image Box
--------------------------------------------------------------------------------------------------*/

$zn_meta_elements[] = array ( 
						"name" => "Image Box",
						"description" => "Image Box",
						"id" => "_image_box",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "four,one-third,eight,two-thirds,twelve,sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "four",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array
											( 
												"name" => "Image Box Title",
												"description" => "Enter a title for your Image box",
												"id" => "image_box_title",
												"std" => "",
												"type" => "text",
											),
											array( 
												"name" => "Image Box Text",
												"description" => "Please enter a text that will appear inside your action Image button.",
												"id" => "image_box_text",
												"std" => "",
												"type" => "textarea",
											),
											array( 
												"name" => "Image",
												"description" => "Please select an image that will appear above the title.",
												"id" => "image_box_image",
												"std" => "",
												"type" => "media",
												"alt" => true
											),
											array( 
												"name" => "Image Box Style",
												"description" => "Please select the style you want to use.",
												"id" => "image_box_style",
												"std" => "imgboxes_style1",
												"options" => array ( 'imgboxes_style1' => 'Style 1', 'style2' => 'Style 2' , 'style3' => 'Style 3' ),
												"type" => "select",
											),
											array
											( 
												"name" => "Link text",
												"description" => "Enter a that will appear as link ove the image.",
												"id" => "image_box_link_text",
												"std" => "",
												"type" => "text",
											),
											array( 
												"name" => "Image Box link",
												"description" => "Please choose the link you want to use for your Image box button.",
												"id" => "image_box_link",
												"std" => "",
												"type" => "link",
												"options" => array ( '_blank' => "New window" , '_self' => "Same window" )
											)
										)
					);	
/*--------------------------------------------------------------------------------------------------
	Partners Logos
--------------------------------------------------------------------------------------------------*/
// STEPS SINGLE
$extra_options['sf_single'] = array( "name" => "Features",
						"description" => "Here you can add your shop features.",
						"id" => "sf_single",
						"std" => "",
						"type" => "group",
						"add_text" => "Feature",
						"remove_text" => "Feature",
						"group_sortable" => true,
						"subelements" => array 
											(
												array( 
													"name" => "Icon",
													"description" => "Please select an icon.",
													"id" => "lp_single_logo",
													"std" => "",
													"type" => "media"
												),
												array( 
													"name" => "Line 1 text",
													"description" => "Please enter a text that will appear on the first line.",
													"id" => "lp_single_line1",
													"std" => "",
													"type" => "text"
												),
												array( 
													"name" => "Line 2 text",
													"description" => "Please enter a text that will appear on the second line.",
													"id" => "lp_single_line2",
													"std" => "",
													"type" => "text"
												),
												array( 
													"name" => "Feature Link",
													"description" => "Please choose the link you want to use.",
													"id" => "lp_link",
													"std" => "",
													"type" => "link",
													"options" => array ( '_blank' => "New window" , '_self' => "Same window" )
												),
											)
						);	
						
$zn_meta_elements[] = array ( 
						"name" => "Shop Features",
						"description" => "Shop Features",
						"id" => "_shop_features",
						"std" => '',
						"type" => "group",
						"add_text" => "Feature",
						"remove_text" => "Feature",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "sixteen",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array
											( 
												"name" => "Title",
												"description" => "Please enter the title for this element.",
												"id" => "sf_title",
												"std" => "",
												"type" => "text",
											),
											$extra_options['sf_single']
										)
					);		
/*--------------------------------------------------------------------------------------------------
	WooCommerce Limited Offers
--------------------------------------------------------------------------------------------------*/

$zn_meta_elements[] = array ( 
						"name" => "Shop Limited Offers",
						"description" => "Shop Products Presentation",
						"id" => "_woo_limited",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "four,one-third,eight,two-thirds,twelve,sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "four",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array
											( 
												"name" => "Element Title",
												"description" => "Enter a title for this element",
												"id" => "woo_lo_title",
												"std" => "",
												"type" => "text",
											),
											array( 
												"name" => "Shop Category",
												"description" => "Select the shop category to show items",
												"id" => "woo_categories",
												"mod" => "multi",
												"std" => "0",
												"type" => "select",
												"options" => $option_shop_cat
											),
											array( 
												"name" => "Number of products",
												"description" => "Please enter how many products you want to load.",
												"id" => "prods_per_page",
												"std" => "6",
												"type" => "text"
											)
										)
					);
					
/*--------------------------------------------------------------------------------------------------
	WooCommerce Items
--------------------------------------------------------------------------------------------------*/

$zn_meta_elements[] = array ( 
						"name" => "Shop Products Presentation",
						"description" => "Shop Products Presentation",
						"id" => "_woo_products",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "four,eight,twelve,sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "four",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array( 
												"name" => "Show Latest Products",
												"description" => "Select yes if you want to show the latest products.",
												"id" => "woo_lp_prod",
												"std" => 1,
												"options" => array ( '1' => 'Yes', '0' => 'No' ),
												"type" => "select",
											),
											array( 
												"name" => "Latest Products Title",
												"description" => "Please enter a title for the latest products. If no title is set , the default title will be shown ( LATEST PRODUCTS )",
												"id" => "woo_lp_title",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Show Best Selling Products",
												"description" => "Select yes if you want to show the best selling products.",
												"id" => "woo_bs_prod",
												"std" => 1,
												"options" => array ( '1' => 'Yes', '0' => 'No' ),
												"type" => "select",
											),
											array( 
												"name" => "Best Selling Title",
												"description" => "Please enter a title for the best selling products. If no title is set , the default title will be shown ( BEST SELLING PRODUCTS )",
												"id" => "woo_bsp_title",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Shop Category",
												"description" => "Select the shop category to show items",
												"id" => "woo_categories",
												"mod" => "multi",
												"std" => "0",
												"type" => "select",
												"options" => $option_shop_cat
											),
											array( 
												"name" => "Number of products",
												"description" => "Please enter how many products you want to load.",
												"id" => "prods_per_page",
												"std" => "6",
												"type" => "text"
											)
										)
					);
			
/*--------------------------------------------------------------------------------------------------
	Alternative page title
--------------------------------------------------------------------------------------------------*/

$zn_meta_elements[] = array( 
						"link_to" => "page_options",
						"name" => "Show Page Title ?",
						"description" => "Choose yes if you want to show the page title above the content.",
						"id" => "page_title_show",
						"std" => "yes",
						"options" => array ( "yes" => "Yes", "no"=>"No" ),
						"type" => "zn_radio",
					);

$zn_meta_elements[] = array( 
						"link_to" => "page_options",
						"name" => "Alternative Page Title",
						"description" => "Enter your desired title for this page. Please note that this title will appear on the top-right of your header if you choose to use a page header.If this field is not completed, the normal page title will appear in both top-right part of the header aswell as the normal location of page title.",
						"id" => "page_title",
						"std" => "",
						"type" => "text"
					);	

$zn_meta_elements[] = array( 
						"link_to" => "page_options",
						"name" => "Page Subtitle",
						"description" => "Enter your desired subtitle for this page.Please note that the appeareance of this subtitle is subject of default or custom options of the header part.",
						"id" => "page_subtitle",
						"std" => "",
						"type" => "text"
					);		

$zn_meta_elements[] = array(
			"link_to" => "page_options",
			"name" => "Hide page subheader?",
			"description" => "Chose yes if you want to hide the page subheader ( including sliders ). Please note that this option will overwrite the option set in the admin panel",
			"id" => "zn_disable_subheader",
			"std" => 'no',
			"options" => array ( 'yes'=>"Yes" , 'no'=> "No"),
			"type" => "select"
		);

/*--------------------------------------------------------------------------------------------------
	ACTION BOX
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array ( 
						"name" => "Action Box",
						"description" => "Action Box",
						"id" => "_action_box",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Action Box Title",
												"description" => "Enter a title for your action box",
												"id" => "page_ac_title",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Action Box Button Text",
												"description" => "Please enter a text that will appear inside your action box button.",
												"id" => "page_ac_b_text",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Action Box link",
												"description" => "Please choose the link you want to use for your action box button.",
												"id" => "page_ac_b_link",
												"std" => "",
												"type" => "link",
												"options" => array ( '_blank' => "New window" , '_self' => "Same window" )
											)
										)
					);		

/*--------------------------------------------------------------------------------------------------
	ACTION BOX TEXT
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array ( 
						"name" => "Action Box Text",
						"description" => "Action Box Text",
						"id" => "_action_box_text",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array
											( 
												"name" => "Action Box Text",
												"description" => "Enter a description text for your action box",
												"id" => "page_ac_title",
												"std" => "",
												"type" => "textarea"
											)
										)
					);		


	
/*--------------------------------------------------------------------------------------------------
	STATIC CONTENT - Video Background
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array ( 
						"name" => "STATIC CONTENT - Video Background",
						"description" => "STATIC CONTENT - Video Background",
						"id" => "_static8",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array( 
												"name" => "Line 1 Title",
												"description" => "Please enter a title that will appear on the first line.",
												"id" => "sc_vb_line1",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Line 2 Title",
												"description" => "Please enter a title that will appear on the second line.",
												"id" => "sc_vb_line2",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Video Type",
												"description" => "Select what type of video background you want to use.",
												"id" => "sc_vb_video_type",
												"std" => "self",
												"options" => array ( "self" => "Self hosted", "iframe"=>"Video Iframe" ),
												"type" => "zn_radio",
												"rel_id" => "sc_vb_video_type",
												"class" => "zn_hide"
											),
											array( 
												"name" => "Video link",
												"description" => "Please enter the video link as seen in the browser address bar for the desired video.",
												"id" => "sc_vb_embed",
												"std" => "",
												"type" => "text",
												"class" => "sc_vb_video_type-iframe"
											),
											array( 
												"name" => "Video file",
												"description" => "Please choose the video file you want to use.",
												"id" => "sc_vb_sh_video1",
												"std" => "",
												"type" => "media",
												"class" => "sc_vb_video_type-self"
											),
											array( 
												"name" => "OGG Video file",
												"description" => "Please enter an ogg video file (.ogv).",
												"id" => "sc_vb_sh_video2",
												"std" => "",
												"type" => "media",
												"class" => "sc_vb_video_type-self"
											),
											array( 
												"name" => "Video image Cover",
												"description" => "Please add an image cover for your video.",
												"id" => "sc_vb_sh_video_cover",
												"std" => "",
												"type" => "media",
												"class" => "sc_vb_video_type-self"
											),
										)
					);						
					
/*--------------------------------------------------------------------------------------------------
	STATIC CONTENT - Simple Text
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array ( 
						"name" => "STATIC CONTENT - Simple Text",
						"description" => "STATIC CONTENT - Simple Text",
						"id" => "_static9",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array( 
												"name" => "Text",
												"description" => "Please enter your desired text.",
												"id" => "sc_sc",
												"std" => "",
												"type" => "textarea"
											),
											array( 
												"name" => "Button Text",
												"description" => "Please enter a text that will appear as a button bellow your text.",
												"id" => "sc_button_text",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Button link",
												"description" => "Please choose the link you want to use for your button.",
												"id" => "sc_button_link",
												"std" => "",
												"type" => "link",
												"options" => array ( '_blank' => "New window" , '_self' => "Same window" )
											)
										)

					);

/*--------------------------------------------------------------------------------------------------
	STATIC CONTENT - Text and Register
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array ( 
						"name" => "STATIC CONTENT - Text and Register",
						"description" => "STATIC CONTENT - Text and Register",
						"id" => "_static10",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array( 
												"name" => "Background Style",
												"description" => "Select the background style you want to use.Please note that the styles can be created from the unlimited headers options in the theme admin's page.",
												"id" => "ww_header_style",
												"std" => "",
												"type" => "select",
												"options" => $header_option,
												"class" => ""
											),
											array( 
												"name" => "Main title",
												"description" => "Please enter a main title.",
												"id" => "ww_slide_title",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Subtitle",
												"description" => "Please enter a subtitle",
												"id" => "ww_slide_subtitle",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Button Main Text",
												"description" => "Please enter a main text for this button",
												"id" => "ww_slide_m_button",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Button Link Text",
												"description" => "Please enter a text that will appear on the right side of the button",
												"id" => "ww_slide_l_text",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Button link",
												"description" => "Please enter a link that will appear on the right side of the button",
												"id" => "ww_slide_link",
												"std" => "",
												"type" => "link",
												"options" => array ( '_self' => "Same window" , '_blank' => "New window"  )
											)
										)

					);

/*--------------------------------------------------------------------------------------------------
	STATIC CONTENT - Text and Video
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array ( 
						"name" => "STATIC CONTENT - Text and Video",
						"description" => "STATIC CONTENT - Text and Video",
						"id" => "_static11",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array( 
												"name" => "Background Style",
												"description" => "Select the background style you want to use.Please note that the styles can be created from the unlimited headers options in the theme admin's page.",
												"id" => "ww_header_style",
												"std" => "",
												"type" => "select",
												"options" => $header_option,
												"class" => ""
											),
											array( 
												"name" => "Main title",
												"description" => "Please enter a main title.",
												"id" => "ww_slide_title",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Subtitle",
												"description" => "Please enter a subtitle",
												"id" => "ww_slide_subtitle",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Button Main Text",
												"description" => "Please enter a main text for this button",
												"id" => "ww_slide_m_button",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Button Link Text",
												"description" => "Please enter a text that will appear on the right side of the button",
												"id" => "ww_slide_l_text",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Button link",
												"description" => "Please enter a link that will appear on the right side of the button",
												"id" => "ww_slide_link",
												"std" => "",
												"type" => "link",
												"options" => array ( '_self' => "Same window" , '_blank' => "New window"  )
											),
											array( 
												"name" => "Video",
												"description" => "Please enter the link for your desired video ( youtube or vimeo ).",
												"id" => "sc_ec_vime",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Video Description",
												"description" => "Please enter a description for this video that will appear above the video.",
												"id" => "sc_ec_vid_desc",
												"std" => "",
												"type" => "text"
											),
										)

					);

/*--------------------------------------------------------------------------------------------------
	STATIC CONTENT - Event Countdown
--------------------------------------------------------------------------------------------------*/
// EVENT COUNTDOWN SINGLE
$extra_options['event_social'] = array( "name" => "Social Icons",
						"description" => "Here you can add your desired social icons.",
						"id" => "single_ec_social",
						"std" => "",
						"type" => "group",
						"add_text" => "Social Icon",
						"remove_text" => "Social Icon",
						"group_sortable" => true,
						"subelements" => array 
											(
												array( 
													"name" => "Icon title",
													"description" => "Here you can enter a title for this social icon.Please note that this is just for your information as this text will not be visible on the site.",
													"id" => "sc_ec_social_title",
													"std" => "",
													"type" => "text"
												),
												array( 
													"name" => "Social icon link",
													"description" => "Please enter your desired link for the social icon. If this field is left blank, the icon will not be linked.",
													"id" => "sc_ec_social_link",
													"std" => "",
													"type" => "link",
													"options" => array ( '_blank' => "New window" , '_self' => "Same window" )
												),
												array( 
													"name" => "Social icon",
													"description" => "Select your desired social icon.",
													"id" => "sc_ec_social_icon",
													"std" => "",
													"options" => $all_icon_sets,
													"type" => "zn_icon_font"
												)
											)
						);
						
$zn_meta_elements[] = array ( 
						"name" => "STATIC CONTENT - Event Countdown",
						"description" => "STATIC CONTENT - Event Countdown",
						"id" => "_static7",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "sixteen",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array( 
												"name" => "Background Style",
												"description" => "Select the background style you want to use.Please note that the styles can be created from the unlimited headers options in the theme admin's page.",
												"id" => "ww_header_style",
												"std" => "",
												"type" => "select",
												"options" => $header_option,
												"class" => ""
											),
											array( 
												"name" => "Title",
												"description" => "Please enter a title.",
												"id" => "sc_ec_title",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Video",
												"description" => "Please enter the link for your desired video ( youtube or vimeo ).",
												"id" => "sc_ec_vime",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Video Description",
												"description" => "Please enter a description for this video that will appear above the video.",
												"id" => "sc_ec_vid_desc",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Date",
												"description" => "Here you can select the date until the countdown finishes.",
												"id" => "sc_ec_date",
												"std" => "",
												"type" => "date_picker"
											),
											array( 
												"name" => "Mailchimp List ID",
												"description" => "Please enter your mailchimp list id. In order to make mailchimp work, you should also add your mailchimp api key in the theme's admin page.",
												"id" => "sc_ec_mlid",
												"std" => "",
												"type" => "text"
											),
											$extra_options['event_social'],
											array( 
												"name" => "Use normal or colored social icons?",
												"description" => "Here you can choose to use the normal social icons or the colored version of each icon.",
												"id" => "sc_ec_social_color",
												"std" => "",
												"type" => "select",
												"options" => array ('normal' => 'Normal Icons', 'colored'=>'Colored icons'),
												"class" => ""
											)
										)
					);		
					
/*--------------------------------------------------------------------------------------------------
	STATIC CONTENT - Product Loupe
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array ( 
						
						"name" => "STATIC CONTENT - Product Loupe",
						"description" => "STATIC CONTENT - Product Loupe",
						"id" => "_static6",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "sixteen",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array( 
												"name" => "Background Style",
												"description" => "Select the background style you want to use.Please note that the styles can be created from the unlimited headers options in the theme admin's page.",
												"id" => "ww_header_style",
												"std" => "",
												"type" => "select",
												"options" => $header_option,
												"class" => ""
											),
											array( 
												"name" => "Title",
												"description" => "Please enter a title.",
												"id" => "sc_title",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Featured image",
												"description" => "Select an image that will appear on the right side of the header",
												"id" => "sc_lp_image",
												"std" => "",
												"type" => "media"
											),
											array( 
												"name" => "Features list",
												"description" => "Please enter a title.",
												"id" => "sc_lp_features",
												"std" => "",
												"type" => "textarea"
											),
											array( 
												"name" => "Button 1 Text",
												"description" => "Please enter a text for the first button.",
												"id" => "sc_lp_button1",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Button 1 link",
												"description" => "Here you can add a link to the first button",
												"id" => "sc_lp_button1_link",
												"std" => "",
												"type" => "link",
												"options" => array ( '_self' => "Same window" , '_blank' => "New window"  )
											),
											array( 
												"name" => "Button 1 icon",
												"description" => "Select your desired icon that will appear on the left side of the button text.",
												"id" => "sc_lp_button1_icon",
												"std" => "",
												"options" => $bootstrap_icons,
												"type" => "zn_icon_font",
												""
											),
											array( 
												"name" => "Button 1 style",
												"description" => "Select the desired style for your button.",
												"id" => "sc_lp_button1_style",
												"std" => false,
												"type" => "select",
												"options" => array( "btn" => "Default" , "btn btn-primary" => "Primary" , "btn btn-info" => "Info" , "btn btn-success" => "Success" , "btn btn-warning" => "Warning" , "btn btn-danger" => "Danger" , "btn btn-inverse" => "Inverse" , "btn btn-link" => "Link" ),
												"class" => ""
											),
											array( 
												"name" => "Button 1 icon style",
												"description" => "Select the desired style for your icon.",
												"id" => "sc_lp_button1_icon_style",
												"std" => false,
												"type" => "select",
												"options" => array( false => "Normal icons" , "icon-white" => "White icons" ),
												"class" => ""
											),
											array( 
												"name" => "Text between buttons",
												"description" => "Here you can add a text that will appear between your buttons",
												"id" => "sc_bt_text",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Button 2 Text",
												"description" => "Please enter a text for the second button.",
												"id" => "sc_2p_button1",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Button 2 link",
												"description" => "Here you can add a link to the second button",
												"id" => "sc_lp_button2_link",
												"std" => "",
												"type" => "link",
												"options" => array ( '_self' => "Same window" , '_blank' => "New window"  )
											),
											array( 
												"name" => "Button 2 icon",
												"description" => "Select your desired icon that will appear on the left side of the button text.",
												"id" => "sc_lp_button2_icon",
												"std" => "",
												"options" => $bootstrap_icons,
												"type" => "zn_icon_font",
												""
											),
											array( 
												"name" => "Button 2 style",
												"description" => "Select the desired style for your button.",
												"id" => "sc_lp_button2_style",
												"std" => false,
												"type" => "select",
												"options" => array( "btn" => "Default" , "btn btn-primary" => "Primary" , "btn btn-info" => "Info" , "btn btn-success" => "Success" , "btn btn-warning" => "Warning" , "btn btn-danger" => "Danger" , "btn btn-inverse" => "Inverse" , "btn btn-link" => "Link" ),
												"class" => ""
											),
											array( 
												"name" => "Button 2 icon style",
												"description" => "Select the desired style for your icon.",
												"id" => "sc_lp_button2_icon_style",
												"std" => false,
												"type" => "select",
												"options" => array( false => "Normal icons" , "icon-white" => "White icons" ),
												"class" => ""
											),
										)
					);		
					
/*--------------------------------------------------------------------------------------------------
	STATIC CONTENT - Text Pop
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array ( 
						
						"name" => "STATIC CONTENT - Text Pop",
						"description" => "STATIC CONTENT - Text Pop",
						"id" => "_static5",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "sixteen",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array( 
												"name" => "Background Style",
												"description" => "Select the background style you want to use.Please note that the styles can be created from the unlimited headers options in the theme admin's page.",
												"id" => "ww_header_style",
												"std" => "",
												"type" => "select",
												"options" => $header_option,
												"class" => ""
											),
											array( 
												"name" => "Line 1 Text",
												"description" => "Please enter a text for the first line.",
												"id" => "sc_pop_line1",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Line 2 Text",
												"description" => "Please enter a text for the second line.",
												"id" => "sc_pop_line2",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Line 3 Text",
												"description" => "Please enter a text for the third line.",
												"id" => "sc_pop_line3",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Line 4 Text",
												"description" => "Please enter a text for the fourth line.",
												"id" => "sc_pop_line4",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Button Main Text",
												"description" => "Please enter a main text for this button",
												"id" => "ww_slide_m_button",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Button Link Text",
												"description" => "Please enter a text that will appear on the right side of the button",
												"id" => "ww_slide_l_text",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Button link",
												"description" => "Please enter a link that will appear on the right side of the button",
												"id" => "ww_slide_link",
												"std" => "",
												"type" => "link",
												"options" => array ( '_self' => "Same window" , '_blank' => "New window"  )
											)
										)
					);		
					
/*--------------------------------------------------------------------------------------------------
	STATIC CONTENT - Maps
--------------------------------------------------------------------------------------------------*/

$zoom = array ();

for ( $i = 0; $i<24; $i++) {
	$zoom[$i] = $i;
}

$zn_meta_elements[] = array ( 
						
						"name" => "STATIC CONTENT - Maps",
						"description" => "STATIC CONTENT - Maps",
						"id" => "_static4",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "sixteen",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array( 
												"name" => "Background Style",
												"description" => "Select the background style you want to use.Please note that the styles can be created from the unlimited headers options in the theme admin's page.",
												"id" => "ww_header_style",
												"std" => "",
												"type" => "select",
												"options" => $header_option,
												"class" => ""
											),
											array( 
												"name" => "Map Height",
												"description" => "Please enter height value in pixels for the map height..",
												"id" => "sc_map_height",
												"std" => "600",
												"type" => "text"
											),
											array( 
												"name" => "Map Latitude",
												"description" => "Please enter the latitude value for your location.",
												"id" => "sc_map_latitude",
												"std" => "40.712785",
												"type" => "text"
											),
											array( 
												"name" => "Map Longitude",
												"description" => "Please enter the longitude value for your location.",
												"id" => "sc_map_longitude",
												"std" => "-73.962708",
												"type" => "text"
											),
											array( 
												"name" => "Zoom level",
												"description" => "Select the zoom level you want to use for this map ( default is 14 )",
												"id" => "sc_map_zoom",
												"std" => "14",
												"type" => "select",
												"options" => $zoom,
												"class" => ""
											),
											array( 
												"name" => "Map Type",
												"description" => "Select the desired map type you want to use.",
												"id" => "sc_map_type",
												"std" => "roadmap",
												"type" => "select",
												"options" => array ( "ROADMAP" => "Roadmap", "SATELLITE" => "Satellite" , "TERRAIN" => "Terrain" , "HYBRID" => "Hybrid" ),
												"class" => ""
											),
											array( 
												"name" => "Allow map dragging ?",
												"description" => "Select yes if you want to use the drag ability over map.",
												"id" => "sc_map_dragg",
												"std" => "false",
												"type" => "select",
												"options" => array ( 'true' => 'Yes' , 'false' => 'No' ),
												"class" => ""
											),
											array( 
												"name" => "Allow Mousewheel ?",
												"description" => "Select yes if you want to use the drag ability over map.",
												"id" => "sc_map_zooming_mousewheel",
												"std" => "false",
												"type" => "select",
												"options" => array ( 'true' => 'Yes' , 'false' => 'No' ),
												"class" => ""
											),
											array( 
												"name" => "Current location icon",
												"description" => "Select an icon that will appear as your current location",
												"id" => "sc_map_icon",
												"std" => "",
												"type" => "media"
											),
											array( 
												"name" => "Button Main Text",
												"description" => "Please enter a main text for this button",
												"id" => "ww_slide_m_button",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Button Link Text",
												"description" => "Please enter a text that will appear on the right side of the button",
												"id" => "ww_slide_l_text",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Button link",
												"description" => "Please enter a link that will appear on the right side of the button",
												"id" => "ww_slide_link",
												"std" => "",
												"type" => "link",
												"options" => array ( '_self' => "Same window" , '_blank' => "New window"  )
											)
										)
					);				
					
/*--------------------------------------------------------------------------------------------------
	STATIC CONTENT - Maps Multiple Locations
--------------------------------------------------------------------------------------------------*/

$zoom = array ();

for ( $i = 0; $i<24; $i++) {
	$zoom[$i] = $i;
}

$extra_options['map_multiple'] = array( "name" => "Locations",
						"description" => "Here you can add your map locations.",
						"id" => "single_multiple_maps",
						"std" => "",
						"type" => "group",
						"add_text" => "Location",
						"remove_text" => "Location",
						"group_sortable" => true,
						"subelements" => array 
											(
												array( 
													"name" => "Map Latitude",
													"description" => "Please enter the latitude value for your location.",
													"id" => "sc_map_latitude",
													"std" => "40.712785",
													"type" => "text"
												),
												array( 
													"name" => "Map Longitude",
													"description" => "Please enter the longitude value for your location.",
													"id" => "sc_map_longitude",
													"std" => "-73.962708",
													"type" => "text"
												),
												array( 
													"name" => "Current location icon",
													"description" => "Select an icon that will appear as your current location",
													"id" => "sc_map_icon",
													"std" => "",
													"type" => "media"
												),
											)
						);

$zn_meta_elements[] = array ( 
						
						"name" => "STATIC CONTENT - Maps multiple locations",
						"description" => "STATIC CONTENT - Maps multiple locations",
						"id" => "_static4_multiple",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "sixteen",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array( 
												"name" => "Background Style",
												"description" => "Select the background style you want to use.Please note that the styles can be created from the unlimited headers options in the theme admin's page.",
												"id" => "ww_header_style",
												"std" => "",
												"type" => "select",
												"options" => $header_option,
												"class" => ""
											),
											array( 
												"name" => "Map Height",
												"description" => "Please enter height value in pixels for the map height..",
												"id" => "sc_map_height",
												"std" => "600",
												"type" => "text"
											),
											array( 
												"name" => "Zoom level",
												"description" => "Select the zoom level you want to use for this map ( default is 14 )",
												"id" => "sc_map_zoom",
												"std" => "14",
												"type" => "select",
												"options" => $zoom,
												"class" => ""
											),
											array( 
												"name" => "Map Type",
												"description" => "Select the desired map type you want to use.",
												"id" => "sc_map_type",
												"std" => "roadmap",
												"type" => "select",
												"options" => array ( "ROADMAP" => "Roadmap", "SATELLITE" => "Satellite" , "TERRAIN" => "Terrain" , "HYBRID" => "Hybrid" ),
												"class" => ""
											),
											array( 
												"name" => "Allow map dragging ?",
												"description" => "Select yes if you want to use the drag ability over map.",
												"id" => "sc_map_dragg",
												"std" => "false",
												"type" => "select",
												"options" => array ( 'true' => 'Yes' , 'false' => 'No' ),
												"class" => ""
											),
											array( 
												"name" => "Allow Mousewheel ?",
												"description" => "Select yes if you want to use the drag ability over map.",
												"id" => "sc_map_zooming_mousewheel",
												"std" => "false",
												"type" => "select",
												"options" => array ( 'true' => 'Yes' , 'false' => 'No' ),
												"class" => ""
											),
											array( 
												"name" => "Button Main Text",
												"description" => "Please enter a main text for this button",
												"id" => "ww_slide_m_button",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Button Link Text",
												"description" => "Please enter a text that will appear on the right side of the button",
												"id" => "ww_slide_l_text",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Button link",
												"description" => "Please enter a link that will appear on the right side of the button",
												"id" => "ww_slide_link",
												"std" => "",
												"type" => "link",
												"options" => array ( '_self' => "Same window" , '_blank' => "New window"  )
											),
											$extra_options['map_multiple']
										)
					);		

/*--------------------------------------------------------------------------------------------------
	STATIC CONTENT - Video
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array ( 
						
						"name" => "STATIC CONTENT - Video",
						"description" => "STATIC CONTENT - Video",
						"id" => "_static3",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "sixteen",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array( 
												"name" => "Background Style",
												"description" => "Select the background style you want to use.Please note that the styles can be created from the unlimited headers options in the theme admin's page.",
												"id" => "ww_header_style",
												"std" => "",
												"type" => "select",
												"options" => $header_option,
												"class" => ""
											),
											array( 
												"name" => "Title",
												"description" => "Please enter a title for your boxes.",
												"id" => "ww_slide_title",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Video Link",
												"description" => "Please enter the link to the video you want to embed ( Vimeo or Youtube ).",
												"id" => "ww_slide_video",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Video Description",
												"description" => "Please enter a text that will appear under the video link.",
												"id" => "ww_slide_video_text",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Element height",
												"description" => "Please enter a height value in pixels.Default is 400.",
												"id" => "ww_height",
												"std" => "300",
												"type" => "text"
											),
										)
					);
					
					
/*--------------------------------------------------------------------------------------------------
	STATIC CONTENT - Boxes
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array ( 
						
						"name" => "STATIC CONTENT - Boxes",
						"description" => "STATIC CONTENT - Boxes",
						"id" => "_static2",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "sixteen",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array( 
												"name" => "Background Style",
												"description" => "Select the background style you want to use.Please note that the styles can be created from the unlimited headers options in the theme admin's page.",
												"id" => "ww_header_style",
												"std" => "",
												"type" => "select",
												"options" => $header_option,
												"class" => ""
											),
											array( 
												"name" => "Title",
												"description" => "Please enter a title for your boxes.",
												"id" => "ww_slide_title",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Box 1 Title",
												"description" => "Please enter a title for your first box.",
												"id" => "ww_box1_title",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Box 1 image",
												"description" => "Select an image for this Box",
												"id" => "ww_box1_image",
												"std" => "",
												"type" => "media"
											),
											array( 
												"name" => "Box 1 Description",
												"description" => "Please enter a description text for your first box.",
												"id" => "ww_box1_desc",
												"std" => "",
												"type" => "textarea"
											),
											array( 
												"name" => "Box 2 Title",
												"description" => "Please enter a title for your first box.",
												"id" => "ww_box2_title",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Box 2 image",
												"description" => "Select an image for this Box",
												"id" => "ww_box2_image",
												"std" => "",
												"type" => "media"
											),
											array( 
												"name" => "Box 2 Description",
												"description" => "Please enter a description text for your first box.",
												"id" => "ww_box2_desc",
												"std" => "",
												"type" => "textarea"
											),
											array( 
												"name" => "Box 3 Title",
												"description" => "Please enter a title for your first box.",
												"id" => "ww_box3_title",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Box 3 image",
												"description" => "Select an image for this Box",
												"id" => "ww_box3_image",
												"std" => "",
												"type" => "media"
											),
											array( 
												"name" => "Box 3 Description",
												"description" => "Please enter a description text for your first box.",
												"id" => "ww_box3_desc",
												"std" => "",
												"type" => "textarea"
											),
										)
					);
					
/*--------------------------------------------------------------------------------------------------
	STATIC CONTENT - Default
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array ( 
						
						"name" => "STATIC CONTENT - Default",
						"description" => "STATIC CONTENT - Default",
						"id" => "_static1",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "sixteen",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array( 
												"name" => "Background Style",
												"description" => "Select the background style you want to use.Please note that the styles can be created from the unlimited headers options in the theme admin's page.",
												"id" => "ww_header_style",
												"std" => "",
												"type" => "select",
												"options" => $header_option,
												"class" => ""
											),
											array( 
												"name" => "Main title",
												"description" => "Please enter a main title.",
												"id" => "ww_slide_title",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Subtitle",
												"description" => "Please enter a subtitle",
												"id" => "ww_slide_subtitle",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Button Main Text",
												"description" => "Please enter a main text for this button",
												"id" => "ww_slide_m_button",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Button Link Text",
												"description" => "Please enter a text that will appear on the right side of the button",
												"id" => "ww_slide_l_text",
												"std" => "",
												"type" => "text"
											),
											array( 
												"name" => "Button link",
												"description" => "Please enter a link that will appear on the right side of the button",
												"id" => "ww_slide_link",
												"std" => "",
												"type" => "link",
												"options" => array ( '_self' => "Same window" , '_blank' => "New window"  )
											)
										)
					);				
					
/*--------------------------------------------------------------------------------------------------
	Circular Content Style 2
--------------------------------------------------------------------------------------------------*/
// CIRCULAR CONTENT 2 SINGLE
$extra_options['circulartwo'] = array( "name" => "Slides",
						"description" => "Here you can create your Circular Content Slides.",
						"id" => "single_circ2",
						"std" => "",
						"type" => "group",
						"add_text" => "Slide",
						"remove_text" => "Slide",
						"group_sortable" => true,
						"subelements" => array 
											(
												array( 
													"name" => "Slide image",
													"description" => "Select an image for this Slide",
													"id" => "ww_slide_image",
													"std" => "",
													"type" => "media"
												),
												array( 
													"name" => "Slide title",
													"description" => "This title will appear over the image",
													"id" => "ww_slide_title",
													"std" => "",
													"type" => "text"
												),
												array( 
													"name" => "Slide title - Left Position",
													"description" => "Please enter a value in pixels for the left position of the title",
													"id" => "ww_slide_title_left",
													"std" => "10",
													"type" => "text"
												),
												array( 
													"name" => "Slide title - Top Position",
													"description" => "Please enter a value in pixels for the top position of the title",
													"id" => "ww_slide_title_top",
													"std" => "200",
													"type" => "text"
												),
												array( 
													"name" => "Slder Title Size",
													"description" => "Here you can select the size of your title.",
													"id" => "ww_slide_title_size",
													"std" => "",
													"type" => "select",
													"options" => array( "small" => "Small" ,"medium" => "Medium" ,"large" => "Large" ),
													"class" => ""
												),
												array( 
													"name" => "Slide bottom title",
													"description" => "This title will appear on the bottom left of the slide",
													"id" => "ww_slide_bottom_title",
													"std" => "",
													"type" => "text"
												),
												array( 
													"name" => "Slide more text",
													"description" => "Please enter a text that you want to use as read more text",
													"id" => "ww_slide_read_text",
													"std" => "",
													"type" => "text"
												),
												array( 
													"name" => "Slide content title",
													"description" => "This title will appear after someone will press the read more text button, above the content.",
													"id" => "ww_slide_content_title",
													"std" => "",
													"type" => "text"
												),
												array( 
													"name" => "Slide content text",
													"description" => "This text will appear after someone will press the read more button. Please note that you can use HTML in this textarea.",
													"id" => "ww_slide_desc_full",
													"std" => "",
													"type" => "textarea"
												),
												array( 
													"name" => "Slide read more text",
													"description" => "Please enter a text that you want to use as read more text that will appear bellow the content",
													"id" => "ww_slide_read_text_content",
													"std" => "",
													"type" => "text"
												),
												array( 
													"name" => "Content read more link",
													"description" => "Here you can add a link bellow the content of your slide",
													"id" => "ww_slide_link",
													"std" => "",
													"type" => "link",
													"options" => array ( '_self' => "Same window" , '_blank' => "New window"  )
												)
											)
						);
						
$zn_meta_elements[] = array ( 
						
						"name" => "Circular Content Style 2",
						"description" => "Circular Content Style 2",
						"id" => "_circ2",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "sixteen",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array( 
												"name" => "Slder Background Style",
												"description" => "Select the background style you want to use for this slider.Please note that the styles can be created from the unlimited headers options in the theme admin's page.",
												"id" => "ww_header_style",
												"std" => "",
												"type" => "select",
												"options" => $header_option,
												"class" => ""
											),
											$extra_options['circulartwo']
											
										)
					);

	
/*--------------------------------------------------------------------------------------------------
	Circular Content Style 1
--------------------------------------------------------------------------------------------------*/
// CIRCULAR CONTENT 1 SINGLE
$extra_options['circularone'] = array( "name" => "Slides",
						"description" => "Here you can create your Circular Content Slides.",
						"id" => "single_circ1",
						"std" => "",
						"type" => "group",
						"add_text" => "Slide",
						"remove_text" => "Slide",
						"group_sortable" => true,
						"subelements" => array 
											(
												array( 
													"name" => "Slide image",
													"description" => "Select an image for this Slide",
													"id" => "ww_slide_image",
													"std" => "",
													"type" => "media"
												),
												array( 
													"name" => "Slide title",
													"description" => "This title will appear over the image",
													"id" => "ww_slide_title",
													"std" => "",
													"type" => "text"
												),
												array( 
													"name" => "Slide description",
													"description" => "This description will appear under the title",
													"id" => "ww_slide_desc",
													"std" => "",
													"type" => "textarea"
												),
												array( 
													"name" => "Slide bottom title",
													"description" => "This title will appear on the bottom left of the slide",
													"id" => "ww_slide_bottom_title",
													"std" => "",
													"type" => "text"
												),
												array( 
													"name" => "Slide more text",
													"description" => "Please enter a text that you want to use as read more text",
													"id" => "ww_slide_read_text",
													"std" => "",
													"type" => "text"
												),
												array( 
													"name" => "Slide content title",
													"description" => "This title will appear after someone will press the read more text button, above the content.",
													"id" => "ww_slide_content_title",
													"std" => "",
													"type" => "text"
												),
												array( 
													"name" => "Slide content text",
													"description" => "This text will appear after someone will press the read more button. Please note that you can use HTML in this textarea.",
													"id" => "ww_slide_desc_full",
													"std" => "",
													"type" => "textarea"
												),
												array( 
													"name" => "Slide read more text",
													"description" => "Please enter a text that you want to use as read more text that will appear bellow the content",
													"id" => "ww_slide_read_text_content",
													"std" => "",
													"type" => "text"
												),
												array( 
													"name" => "Content read more link",
													"description" => "Here you can add a link bellow the content of your slide",
													"id" => "ww_slide_link",
													"std" => "",
													"type" => "link",
													"options" => array ( '_self' => "Same window" , '_blank' => "New window"  )
												)
											)
						);
						
$zn_meta_elements[] = array ( 
						
						"name" => "Circular Content Style 1",
						"description" => "Circular Content Style 1",
						"id" => "_circ1",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "sixteen",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array( 
												"name" => "Slder Background Style",
												"description" => "Select the background style you want to use for this slider.Please note that the styles can be created from the unlimited headers options in the theme admin's page.",
												"id" => "ww_header_style",
												"std" => "",
												"type" => "select",
												"options" => $header_option,
												"class" => ""
											),
											array( 
												"name" => "Slidee height",
												"description" => "Please enter a height number in pixels ( for example : 450 )",
												"id" => "ww_slider_height",
												"std" => "450",
												"type" => "text"
											),
											$extra_options['circularone']
											
										)
					);
				
		
/*--------------------------------------------------------------------------------------------------
	Fancy Slider
--------------------------------------------------------------------------------------------------*/
// FANCY SLIDER SINGLE
$extra_options['fancyslider'] = array( "name" => "Slides",
						"description" => "Here you can create your Fancy Slider Slides.",
						"id" => "single_fancy",
						"std" => "",
						"type" => "group",
						"add_text" => "Slide",
						"remove_text" => "Slide",
						"group_sortable" => true,
						"subelements" => array 
											(
												array( 
													"name" => "Slide image",
													"description" => "Select an image for this Slide",
													"id" => "ww_slide_image",
													"std" => "",
													"type" => "media"
												),
												array( 
													"name" => "Slide link",
													"description" => "Here you can add a link to your slide",
													"id" => "ww_slide_link",
													"std" => "",
													"type" => "link",
													"options" => array ( '_self' => "Same window" , '_blank' => "New window"  )
												),
												array( 
													"name" =>  "Slide Color",
													"description" => "Here you can choose a color for this slide.",
													"id" => "ww_slide_color",
													"std" => '#699100',
													"type" => "color"
												)
											)
						);
						
$zn_meta_elements[] = array ( 
						
						"name" => "Fancy Slider",
						"description" => "Fancy Slider",
						"id" => "_fancyslider",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "sixteen",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											$extra_options['fancyslider']
											
										)
					);

	
/*--------------------------------------------------------------------------------------------------
	WOW Slider
--------------------------------------------------------------------------------------------------*/
// WOW SLIDER SINGLE
$extra_options['wowslider'] = array( "name" => "Slides",
						"description" => "Here you can create your Wow Slider Slides.",
						"id" => "single_wow",
						"std" => "",
						"type" => "group",
						"add_text" => "Slide",
						"remove_text" => "Slide",
						"group_sortable" => true,
						"subelements" => array 
											(
												array( 
													"name" => "Slide image",
													"description" => "Select an image for this Slide",
													"id" => "ww_slide_image",
													"std" => "",
													"type" => "media"
												),
												array( 
													"name" => "Slide title",
													"description" => "This title will appear over the image",
													"id" => "ww_slide_title",
													"std" => "",
													"type" => "text"
												),
												array( 
													"name" => "Slide link",
													"description" => "Here you can add a link to your slide",
													"id" => "ww_slide_link",
													"std" => "",
													"type" => "link",
													"options" => array ( '_self' => "Same window" , '_blank' => "New window"  )
												)
											)
						);
						
$zn_meta_elements[] = array ( 
						
						"name" => "Wow Slider",
						"description" => "Wow Slider",
						"id" => "_wowslider",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "sixteen",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array( 
												"name" => "Slder Background Style",
												"description" => "Select the background style you want to use for this slider.Please note that the styles can be created from the unlimited headers options in the theme admin's page.",
												"id" => "ww_header_style",
												"std" => "",
												"type" => "select",
												"options" => $header_option,
												"class" => ""
											),
											array( 
												"name" => "Shadow style",
												"description" => "Select the desired shadow that you want to use for this slider.",
												"id" => "ww_shadow",
												"std" => "curved curved-hz-1",
												"type" => "select",
												"options" => array ('lifted' => 'Lifted', 'curled'=>'Curled', 'perspective' => 'Perspective', 'raised'=>'Raised' , "curved" => "Curved" , "curved curved-vt-1" => "curved curved-vt-1", "curved curved-vt-2" => "curved curved-vt-2", "curved curved-hz-1" => "curved curved-hz-1", "curved curved-hz-2" => "curved curved-hz-2", "lifted rotated" => "lifted rotated" ),
												"class" => ""
											),
											array( 
												"name" => "Slider Transition",
												"description" => "Select the desired transition that you want to use for this slider.",
												"id" => "ww_transition",
												"std" => "blast",
												"type" => "select",
												"options" => array ( 'blast' => 'Blast' , 'blinds' => 'Blinds' , 'blur' => 'Blur' , 'fly' => 'Fly'   ),
												"class" => ""
											),
											$extra_options['wowslider']
											
										)
					);

	
/*--------------------------------------------------------------------------------------------------
	Nivo Slider
--------------------------------------------------------------------------------------------------*/
// NIVO SLIDER SINGLE
$extra_options['nivoslider'] = array( "name" => "Slides",
						"description" => "Here you can create your Nivo Slider Slides.",
						"id" => "single_nivo",
						"std" => "",
						"type" => "group",
						"add_text" => "Slide",
						"remove_text" => "Slide",
						"group_sortable" => true,
						"subelements" => array 
											(
												array( 
													"name" => "Slide image",
													"description" => "Select an image for this Slide",
													"id" => "nv_slide_image",
													"std" => "",
													"type" => "media"
												),
												array( 
													"name" => "Slide title",
													"description" => "This title will appear over the image",
													"id" => "nv_slide_title",
													"std" => "",
													"type" => "text"
												),
												array( 
													"name" => "Slide link",
													"description" => "Here you can add a link to your slide",
													"id" => "nv_slide_link",
													"std" => "",
													"type" => "link",
													"options" => array ( '_self' => "Same window" , '_blank' => "New window"  )
												)
											)
						);
						
$zn_meta_elements[] = array ( 
						
						"name" => "Nivo Slider",
						"description" => "Nivo Slider",
						"id" => "_nivoslider",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "sixteen",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array( 
												"name" => "Slder Background Style",
												"description" => "Select the background style you want to use for this slider.Please note that the styles can be created from the unlimited headers options in the theme admin's page.",
												"id" => "nv_header_style",
												"std" => "",
												"type" => "select",
												"options" => $header_option,
												"class" => ""
											),
											array( 
												"name" => "Shadow style",
												"description" => "Select the desired shadow that you want to use for this slider.",
												"id" => "nv_shadow",
												"std" => "curved curved-hz-1",
												"type" => "select",
												"options" => array ('lifted' => 'Lifted', 'curled'=>'Curled', 'perspective' => 'Perspective', 'raised'=>'Raised' , "curved" => "Curved" , "curved curved-vt-1" => "curved curved-vt-1", "curved curved-vt-2" => "curved curved-vt-2", "curved curved-hz-1" => "curved curved-hz-1", "curved curved-hz-2" => "curved curved-hz-2", "lifted rotated" => "lifted rotated" ),
												"class" => ""
											),
											array( 
												"name" => "Slider Transition",
												"description" => "Select the desired transition that you want to use for this slider.",
												"id" => "nv_transition",
												"std" => "random",
												"type" => "select",
												"options" => array ( 'random' => 'Random' , 'sliceDown' => 'sliceDown' ,'sliceDownLeft' => 'sliceDownLeft' ,'sliceUp' => 'sliceUp' ,'sliceUpLeft' => 'sliceUpLeft' ,'sliceUpDown' => 'sliceUpDown' ,'sliceUpDownLeft' => 'sliceUpDownLeft' ,'fold' => 'fold' ,'fade' => 'fade' , 'slideInRight' => 'slideInRight', 'slideInLeft' => 'slideInLeft', 'boxRandom' => 'boxRandom', 'boxRain' => 'boxRain', 'boxRainReverse' => 'boxRainReverse', 'boxRainGrow' => 'boxRainGrow', 'boxRainGrowReverse' => 'boxRainGrowReverse' ),
												"class" => ""
											),
											array( 
												"name" => "Automatic Transition",
												"description" => "Select yes if you want the slider to autoadvance to each slide, or no, in order to manually change the slide.",
												"id" => "nv_auto_slide",
												"std" => "1",
												"type" => "select",
												"options" => array ( '1' => 'No' , '0' => 'Yes' ),
												"class" => ""
											),
											array( 
												"name" => "Slider Pause Time",
												"description" => "How long each slide will show ( default is 5000 ).",
												"id" => "nv_pause_time",
												"std" => "5000",
												"type" => "text"
											),
											$extra_options['nivoslider']
											
										)
					);					
		

/*--------------------------------------------------------------------------------------------------
	Documentation Header
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array ( 
						"name" => "Documentation Header",
						"description" => "Documentation Header",
						"id" => "_zn_doc_header",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,
						"subelements" => array 
										(
											array( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "sixteen",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array( 
												"name" => "Header Style",
												"description" => "Select the header style you want to use for this page.Please note that header styles can be created from the theme's admin page.",
												"id" => "hm_header_style",
												"std" => "",
												"type" => "select",
												"options" => $header_option,
												"class" => ""
											)
										)
					);

/*--------------------------------------------------------------------------------------------------
	Documentation
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array ( 
						"name" => "Documentation",
						"description" => "Documentation",
						"id" => "_zn_documentation",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,
						"subelements" => array 
										(
											array( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "sixteen",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array( 
												"name" => "Number of items",
												"description" => "Please enter the desired number of items that you want to be shown under each category.",
												"id" => "doc_num_items",
												"std" => "6",
												"type" => "text"
											),
										)
					);


/*--------------------------------------------------------------------------------------------------
	Custom Header Layout
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array ( 
						"name" => "Custom Header Layout",
						"description" => "Custom Header Layout",
						"id" => "_header_module",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,
						"subelements" => array 
										(
											array( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "sixteen",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array( 
												"name" => "Header Style",
												"description" => "Select the header style you want to use for this page.Please note that header styles can be created from the theme's admin page.",
												"id" => "hm_header_style",
												"std" => "",
												"type" => "select",
												"options" => $header_option,
												"class" => ""
											),
											array( 

												"name" => "Header Height",

												"description" => "Please enter your desired height in pixels for this header.",

												"id" => "hm_header_height",

												"std" => "300",

												"type" => "text"

											),
											array( 
												"name" => "Show Breadcrumbs",
												"description" => "Select if you want to show the breadcrumbs or not.",
												"id" => "hm_header_bread",
												"std" => "",
												"type" => "select",
												"options" => array ('1' => 'Show', '0'=>'Hide'),
												"class" => ""
											),
											array( 
												"name" => "Show Date",
												"description" => "Select if you want to show the current date under breadcrumbs or not.",
												"id" => "hm_header_date",
												"std" => "",
												"type" => "select",
												"options" => array ('1' => 'Show', '0'=>'Hide'),
												"class" => ""
											),
											array( 
												"name" => "Show Page Title",
												"description" => "Select if you want to show the page title or not.",
												"id" => "hm_header_title",
												"std" => "",
												"type" => "select",
												"options" => array ('1' => 'Show', '0'=>'Hide'),
												"class" => ""
											),
											array( 
												"name" => "Show Page Subtitle",
												"description" => "Select if you want to show the page subtitle or not.",
												"id" => "hm_header_subtitle",
												"std" => "",
												"type" => "select",
												"options" => array ('1' => 'Show', '0'=>'Hide'),
												"class" => ""
											)
										)
					);
	
/*--------------------------------------------------------------------------------------------------
	CSS3 Pannels
--------------------------------------------------------------------------------------------------*/

// CSS3 SINGLE PANEL
$extra_options['css_panels'] = array( "name" => "CSS Panels",
						"description" => "Here you can create your CSS3 Panels.",
						"id" => "single_css_panel",
						"std" => "",
						"type" => "group",
						"add_text" => "Panel",
						"remove_text" => "Panel",
						"group_sortable" => true,
						"subelements" => array 
											(
												array( 
													"name" => "Panel image",
													"description" => "Select an image for this Panel",
													"id" => "panel_image",
													"std" => "",
													"type" => "media"
												),
												array( 
													"name" => "Panel title",
													"description" => "Here you can enter a title that will appear on this panel.",
													"id" => "panel_title",
													"std" => "",
													"type" => "text"
												),
												array( 
													"name" => "Panel Title Position",
													"description" => "Here you can choose where the panel title will be shown",
													"id" => "panel_title_position",
													"std" => "",
													"type" => "select",
													"options" => array ( '' => "Normal" , 'upper' => "Upper"  )
												)
											)
						);

$zn_meta_elements[] = array ( 
						
						"name" => "CSS3 Panels",
						"description" => "CSS3 Panels",
						"id" => "_css_pannel",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "sixteen",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array( 
												"name" => "Slider Height",
												"description" => "Please enter a numerical value in pixels for your slider height.",
												"id" => "css_height",
												"std" => "600",
												"type" => "text",
												"class" => ''
											),
											$extra_options['css_panels']
											
										)
					);	
	
/*--------------------------------------------------------------------------------------------------
	Flex Slider
--------------------------------------------------------------------------------------------------*/
// Flex SLIDER SINGLE
$extra_options['flexslider'] = array( "name" => "Slides",
						"description" => "Here you can create your Flex Slider Slides.",
						"id" => "single_flex",
						"std" => "",
						"type" => "group",
						"add_text" => "Slide",
						"remove_text" => "Slide",
						"group_sortable" => true,
						"subelements" => array 
											(
												array( 
													"name" => "Slide image",
													"description" => "Select an image for this Slide",
													"id" => "fs_slide_image",
													"std" => "",
													"type" => "media"
												),
												array( 
													"name" => "Slide title",
													"description" => "This title will appear over the image",
													"id" => "fs_slide_title",
													"std" => "",
													"type" => "text"
												),
												array( 
													"name" => "Slide link",
													"description" => "Here you can add a link to your slide",
													"id" => "fs_slide_link",
													"std" => "",
													"type" => "link",
													"options" => array ( '_self' => "Same window" , '_blank' => "New window"  )
												)
											)
						);
						
$zn_meta_elements[] = array ( 
						
						"name" => "Flex Slider",
						"description" => "Flex Slider",
						"id" => "_flexslider",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "sixteen",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array( 
												"name" => "Slder Background Style",
												"description" => "Select the background style you want to use for this slider.Please note that the styles can be created from the unlimited headers options in the theme admin's page.",
												"id" => "fs_header_style",
												"std" => "",
												"type" => "select",
												"options" => $header_option,
												"class" => ""
											),
											array( 
												"name" => "Show Thumbnails ?",
												"description" => "Select if yes if you want to display thumbnails of images on the right side of the slider.",
												"id" => "fs_show_thumbs",
												"std" => "0",
												"type" => "select",
												"options" => array ('1' => 'Yes', '0'=>'No'),
												"class" => ""
											),
											array( 
												"name" => "Shadow style",
												"description" => "Select the desired shadow that you want to use for this slider.",
												"id" => "fs_shadow",
												"std" => "curved curved-hz-1",
												"type" => "select",
												"options" => array ('lifted' => 'Lifted', 'curled'=>'Curled', 'perspective' => 'Perspective', 'raised'=>'Raised' , "curved" => "Curved" , "curved curved-vt-1" => "curved curved-vt-1", "curved curved-vt-2" => "curved curved-vt-2", "curved curved-hz-1" => "curved curved-hz-1", "curved curved-hz-2" => "curved curved-hz-2", "lifted rotated" => "lifted rotated" ),
												"class" => ""
											),
											array( 
												"name" => "Slider Transition",
												"description" => "Select the desired transition that you want to use for this slider.",
												"id" => "fs_transition",
												"std" => "fade",
												"type" => "select",
												"options" => array ('fade' => 'Fade', 'slide'=>'Slide' ),
												"class" => ""
											),
											$extra_options['flexslider']
											
										)
					);	
	
	
/*--------------------------------------------------------------------------------------------------
	ICarousel
--------------------------------------------------------------------------------------------------*/
// ICAROUSEL SINGLE
$extra_options['icarousel'] = array( "name" => "Slides",
						"description" => "Here you can create your iCarousel Slides.",
						"id" => "single_icarousel",
						"std" => "",
						"type" => "group",
						"add_text" => "Slide",
						"remove_text" => "Slide",
						"group_sortable" => true,
						"subelements" => array 
											(
												array( 
													"name" => "Slide image",
													"description" => "Select an image for this Slide",
													"id" => "ic_slide_image",
													"std" => "",
													"type" => "media"
												),
												array( 
													"name" => "Slide title",
													"description" => "This title will appear over the image",
													"id" => "ic_slide_title",
													"std" => "",
													"type" => "text"
												),
												array( 
													"name" => "Slide link",
													"description" => "Here you can add a link to your slide",
													"id" => "ic_slide_link",
													"std" => "",
													"type" => "link",
													"options" => array ( '_self' => "Same window" , '_blank' => "New window"  )
												)
											)
						);
						
$zn_meta_elements[] = array ( 
						
						"name" => "iCarousel",
						"description" => "iCarousel",
						"id" => "_icarousel",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "sixteen",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array( 
												"name" => "Slder Background Style",
												"description" => "Select the background style you want to use for this slider.Please note that the styles can be created from the unlimited headers options in the theme admin's page.",
												"id" => "ic_header_style",
												"std" => "",
												"type" => "select",
												"options" => $header_option,
												"class" => ""
											),
											$extra_options['icarousel']
											
										)
					);	


/*--------------------------------------------------------------------------------------------------
	Laptop Slider
--------------------------------------------------------------------------------------------------*/
// LAPTOP SLIDER SINGLE
$extra_options['lslider'] = array( "name" => "Slides",
						"description" => "Here you can create your Laptop Slider Slides.",
						"id" => "single_lslides",
						"std" => "",
						"type" => "group",
						"add_text" => "Slide",
						"remove_text" => "Slide",
						"group_sortable" => true,
						"subelements" => array 
											(

												array( 
													"name" => "Slide image",
													"description" => "Select an image for this Slide",
													"id" => "ls_slide_image",
													"std" => "",
													"type" => "media"
												),
												array( 
													"name" => "Slide title",
													"description" => "This title will appear over the image",
													"id" => "ls_slide_title",
													"std" => "",
													"type" => "text"
												),
												array( 
													"name" => "Slide link",
													"description" => "Here you can add a link to your slide",
													"id" => "ls_slide_link",
													"std" => "",
													"type" => "link",
													"options" => array ( '_self' => "Same window" , '_blank' => "New window"  )
												)
											)
						);
						
$zn_meta_elements[] = array ( 
						"name" => "Laptop Slider",
						"description" => "Laptop Slider",
						"id" => "_lslider",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => false,
						"link" => true,
						"sizes" => "sixteen",						
						"subelements" => array 
										(
											array( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "sixteen",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array( 
												"name" => "Slider Description",
												"description" => "Here you can enter a description that will appear above the slider.",
												"id" => "ls_slider_desc",
												"std" => "",
												"type" => "textarea",
												"class" => ''
											),
											array( 
												"name" => "Slder Background Style",
												"description" => "Select the background style you want to use for this slider.Please note that the styles can be created from the unlimited headers options in the theme admin's page.",
												"id" => "ls_header_style",
												"std" => "",
												"type" => "select",
												"options" => $header_option,
												"class" => ""
											),
											$extra_options['lslider']
											
										)
					);	



/*--------------------------------------------------------------------------------------------------
	Portfolio Slider
--------------------------------------------------------------------------------------------------*/
// PORTFOLIO SLIDER SINGLE
$extra_options['pslider'] = array( "name" => "Slides",
						"description" => "Here you can create your Portfolio Slider Slides.",
						"id" => "single_pslides",
						"std" => "",
						"type" => "group",
						"add_text" => "Slide",
						"remove_text" => "Slide",
						"group_sortable" => true,
						"subelements" => array 
											(
												array( 
													"name" => "Slide title",
													"description" => "This title will appear as browser title",
													"id" => "ps_slide_title",
													"std" => "",
													"type" => "text"
												),
												array( 
													"name" => "Slide link",
													"description" => "Here you can add a link to your slide",
													"id" => "ps_slide_link",
													"std" => "",
													"type" => "link",
													"options" => array ( '_self' => "Same window" , '_blank' => "New window"  )
												),			
												array( 
													"name" => "Front Image",
													"description" => "Select an image that will appear on front",
													"id" => "ps_slide_image1",
													"std" => "",
													"type" => "media"
												),
												array( 
													"name" => "Left Image",
													"description" => "Select an image that will appear on left",
													"id" => "ps_slide_image2",
													"std" => "",
													"type" => "media"
												),
												array( 
													"name" => "Right Image",
													"description" => "Select an image that will appear on right",
													"id" => "ps_slide_image3",
													"std" => "",
													"type" => "media"
												),
											)
						);
						
$zn_meta_elements[] = array ( 
						
						"name" => "Portfolio Slider",
						"description" => "Portfolio Slider",
						"id" => "_pslider",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "sixteen",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array( 
												"name" => "Slider Description",
												"description" => "Here you can enter a description that will appear above the slider.",
												"id" => "ps_slider_desc",
												"std" => "",
												"type" => "textarea",
												"class" => ''
											),
											array( 
												"name" => "Slder Background Style",
												"description" => "Select the background style you want to use for this slider.Please note that the styles can be created from the unlimited headers options in the theme admin's page.",
												"id" => "ps_header_style",
												"std" => "",
												"type" => "select",
												"options" => $header_option,
												"class" => ""
											),
											array( 
												"name" => "Sliding Direction",
												"description" => "Select the desired sliding direction.",
												"id" => "ps_sliding_direction",
												"std" => "",
												"type" => "select",
												"options" => array( "Horizontal"=>"Horizontal" ,"Vertical"=>"Vertical"  ),
												"class" => ""
											),
											$extra_options['pslider']
											
										)
					);	


/*--------------------------------------------------------------------------------------------------
	iOS Slider
--------------------------------------------------------------------------------------------------*/
// iOS SLIDER SINGLE
$extra_options['iosslider'] = array( "name" => "Slides",
						"description" => "Here you can create your iOS Slider Slides.",
						"id" => "single_iosslider",
						"std" => "",
						"type" => "group",
						"add_text" => "Slide",
						"remove_text" => "Slide",
						"group_sortable" => true,
						"subelements" => array 
											(
												array( 
													"name" => "Slide Image",
													"description" => "Select an image for this slide",
													"id" => "io_slide_image",
													"std" => "",
													"type" => "media",
													"alt" => "yes"
												),
												array( 
													"name" => "Slide main title",
													"description" => "Enter a main title for this slide",
													"id" => "io_slide_m_title",
													"std" => "",
													"type" => "text"
												),
												array( 
													"name" => "Slide big title",
													"description" => "Enter a title for this slide",
													"id" => "io_slide_b_title",
													"std" => "",
													"type" => "text"
												),
												array( 
													"name" => "Slide small title",
													"description" => "Enter a small title for this slide",
													"id" => "io_slide_s_title",
													"std" => "",
													"type" => "text"
												),
												array( 
													"name" => "Slide link",
													"description" => "Here you can add a link to your slide",
													"id" => "io_slide_link",
													"std" => "",
													"type" => "link",
													"options" => array ( '_self' => "Same window" , '_blank' => "New window"  )
												),	
												array( 
													"name" => "Link Image ?",
													"description" => "Select yes if you want to also link the slide image. Please note that by enabling this option, in Internet Explorer 8 the swipe function won't behave properly.",
													"id" => "io_slide_link_image",
													"std" => "no",
													"type" => "select",
													"options" => array( "yes"=>"Yes" ,"no"=>"No" ),
													"class" => ""
												),
												array( 
													"name" => "Slider Caption Style",
													"description" => "Select the desired style for this slide.",
													"id" => "io_slide_caption_style",
													"std" => "",
													"type" => "select",
													"options" => array( "style1"=>"Style 1" ,"style2"=>"Style 2" ,"style3"=>"Style 3" ),
													"class" => ""
												),
												array( 
													"name" => "Slder Caption Animation/Position",
													"description" => "Select the desired Animation/Position for this slide.",
													"id" => "io_slide_caption_pos",
													"std" => "",
													"type" => "select",
													"options" => array( "zn_def_anim_pos"=>"From Left" ,"fromright"=>"From Right" ),
													"class" => ""
												)

											)
						);
						
$zn_meta_elements[] = array ( 
						"name" => "iOS Slider",
						"description" => "iOS Slider",
						"id" => "_iosSlider",
						"std" => '',
						"type" => "group",
						"add_text" => "Item",
						"remove_text" => "Item",
						"hidden" => true,
						"sizes" => "sixteen",
						"link" => true,						
						"subelements" => array 
										(
											array( 
												"name" => "Sizer Hidden Option",
												"desc" => "This option is hidden.",
												"id" => "_sizer",
												"std" => "sixteen",
												"type" => "hidden",
												"class" => 'zn_size_input'
											),
											array( 
												"name" => "Slder Background Style",
												"description" => "Select the background style you want to use for this slider.Please note that the styles can be created from the unlimited headers options in the theme admin's page.",
												"id" => "io_header_style",
												"std" => "",
												"type" => "select",
												"options" => $header_option,
												"class" => ""
											),
											array( 
												"name" => "Slider Navigation",
												"description" => "Choose what type of navigation you want to use for your slide.",
												"id" => "io_s_navigation",
												"std" => "bullets",
												"type" => "select",
												"options" => array( "bullets"=>"Bullets" ,"thumbs"=>"Thumbnails" ),
												"class" => ""
											),
											array( 
												"name" => "Add Fade Effect?",
												"description" => "Choose if you want to add a bottom fade effect to your slider.",
												"id" => "io_s_fade",
												"std" => "0",
												"type" => "select",
												"options" => array( "1"=>"Yes" ,"0"=>"No" ),
												"class" => ""
											),
											array( 
												"name" => "Use fixed width slider ?",
												"description" => "Choose if you want to use a full width slider or a fixed width one.",
												"id" => "io_s_width",
												"std" => "0",
												"type" => "select",
												"options" => array( "0" =>"Full Width" ,"1" =>"Fixed Width" ),
												"class" => ""
											),
											array( 
												"name" => "Use fixed (scroll) slider ?",
												"description" => "Choose if you want your slider to be fixed on the page when you scroll down",
												"id" => "io_s_scroll",
												"std" => "0",
												"type" => "select",
												"options" => array( "1" =>"Yes" ,"0" =>"No" ),
												"class" => ""
											),
											array( 
												"name" => "Transition Speed",
												"description" => "Enter a numeric value for the transition speed (default: 5000)",
												"id" => "io_s_trans",
												"std" => "5000",
												"type" => "text"
											),
											array( 
												"name" => "Slider Height",
												"description" => "Enter a numeric value for the slider height.Please note that the value will be used as percentage. The default value is 39",
												"id" => "io_s_s_height",
												"std" => "",
												"type" => "text"
											),
											$extra_options['iosslider']
											
										)
					);	




/*--------------------------------------------------------------------------------------------------
	CONTENT AREA
--------------------------------------------------------------------------------------------------*/	

$zn_meta_elements[] = array( 
						"link_to" => "page_options",
						"name" => "Page Layout Options",
						"description" => "Select your desired layout",
						"id" => "page_layout",
						"std" => "default",
						"type" => "select",
						"options" => array ( 'left_sidebar' => "Left Sidebar" , 'right_sidebar' => "Right sidebar" , "no_sidebar" => "No sidebar" , "default" => "Default - Set from theme options" )
					);
					
$page_sidebar = array_merge ($sidebar_option,array ('default'=>'Default - Set from theme options'));	
$zn_meta_elements[] = array( 
						"link_to" => "page_options",
						"name" => "Select sidebar",
						"description" => "Select your desired sidebar to be used on this post",
						"id" => "sidebar_select",
						"std" => "default",
						"type" => "select",
						"options" => $page_sidebar
					);	

$zn_meta_elements[] = array( 
						"link_to" => "page_options",
						"name" => "Page Builder Layout",
						"description" => "Select your desired layout for the page builder. You can choose to display all the page builder elements bellow the main page content and sidebar or display the Page builders Content Main Area bellow the main page content ( on the side of the sidebar )",
						"id" => "page_builder_layout",
						"std" => "default",
						"type" => "select",
						"options" => array ( 'default' => "Page builder bellow main content and sidebar" , 'style1' => "Page builder and sidebar on same row"  )
					);


/*--------------------------------------------------------------------------------------------------
	SINGLE POST OPTIONS
--------------------------------------------------------------------------------------------------*/	

$zn_meta_elements[] = array( 
						"link_to" => "post_options",
						"name" => "Post Layout Options",
						"description" => "Select your desired layout",
						"id" => "page_layout",
						"std" => "default",
						"type" => "select",
						"options" => array ( 'left_sidebar' => "Left Sidebar" , 'right_sidebar' => "Right sidebar" , "no_sidebar" => "No sidebar" , "default" => "Default - Set from theme options" )
					);
					
$page_sidebar = array_merge ($sidebar_option,array ('default'=>'Default - Set from theme options'));	
$zn_meta_elements[] = array( 
						"link_to" => "post_options",
						"name" => "Select sidebar",
						"description" => "Select your desired sidebar to be used on this post",
						"id" => "sidebar_select",
						"std" => "default",
						"type" => "select",
						"options" => $page_sidebar
					);	

$zn_meta_elements[] = array( 
						"link_to" => "post_options",
						"name" => "Show Social Share Buttons ?",
						"description" => "Choose if you want to show the social share buttons bellow the post's content.",
						"id" => "show_social",
						"std" => "default",
						"type" => "select",
						"options" => array ( 'show' => 'Show social buttons' , 'hide' => 'Do not show social buttons' , 'default' => 'Default - Set from theme options' )
					);	

$zn_meta_elements[] = array(
			"link_to" => "post_options",
			"name" => "Hide page subheader??",
			"description" => "Chose yes if you want to hide the page subheader ( including sliders ). Please note that this option will overwrite the option set in the admin panel",
			"id" => "zn_disable_subheader",
			"std" => 'no',
			"options" => array ( 'yes'=>"Yes" , 'no'=> "No"),
			"type" => "select"
		);

$zn_meta_elements[] = array( 
						"link_to" => "post_options",
						"name" => "Page Builder Layout",
						"description" => "Select your desired layout for the page builder. You can choose to display all the page builder elements bellow the main page content and sidebar or display the Page builders Content Main Area bellow the main page content ( on the side of the sidebar )",
						"id" => "page_builder_layout",
						"std" => "default",
						"type" => "select",
						"options" => array ( 'default' => "Page builder bellow main content and sidebar" , 'style1' => "Page builder and sidebar on same row"  )
					);


/*--------------------------------------------------------------------------------------------------
	PORTFOLIO POST OPTIONS
--------------------------------------------------------------------------------------------------*/	

					
$zn_meta_elements[] = array( 
						"link_to" => "portfolio_g_options",
						"name" => "Show Title ?",
						"description" => "Choose yes if you want to show the title above the content.",
						"id" => "page_title_show",
						"std" => "yes",
						"options" => array ( "yes" => "Yes", "no"=>"No" ),
						"type" => "zn_radio",
					);

$zn_meta_elements[] = array( 
						"link_to" => "portfolio_g_options",
						"name" => "Alternative Title",
						"description" => "Enter your desired title for this page. Please note that this title will appear on the top-right of your header if you choose to use a page header.If this field is not completed, the normal page title will appear in both top-right part of the header aswell as the normal location of page title.",
						"id" => "page_title",
						"std" => "",
						"type" => "text"
					);	

$zn_meta_elements[] = array( 
						"link_to" => "portfolio_g_options",
						"name" => "Subtitle",
						"description" => "Enter your desired subtitle for this page.Please note that the appeareance of this subtitle is subject of default or custom options of the header part.",
						"id" => "page_subtitle",
						"std" => "",
						"type" => "text"
					);	

$zn_meta_elements[] = array(
			"link_to" => "portfolio_g_options",
			"name" => "Hide page subheader??",
			"description" => "Chose yes if you want to hide the page subheader ( including sliders ). Please note that this option can be overriten from each page/post",
			"id" => "zn_disable_subheader",
			"std" => 'no',
			"options" => array ( 'yes'=>"Yes" , 'no'=> "No"),
			"type" => "select"
		);


?>
