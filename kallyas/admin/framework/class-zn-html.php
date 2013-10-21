<?php
class zn_html {

var $data,$new_fonts,$all_fonts,$menu; 



/***************************************************
* Constructor
*
* The constructor sets up the data for the options
***************************************************/

	function zn_show_options($options,$menu = null) 
	{
	
		// Add Google Fonts
		$fonts = file_get_contents('fonts/fonts.txt' , FILE_USE_INCLUDE_PATH);
		$this->all_fonts = json_decode($fonts,true);
	
		$fonts_new = file_get_contents('fonts/fonts_new.txt' , FILE_USE_INCLUDE_PATH);
		$this->new_fonts = json_decode($fonts_new,true);
		$this->menu = $menu;

		$output = '';
		
		$this->data = get_option(OPTIONS);
		
		$output .= $this->zn_page_start();
				
		foreach ( $options as $option ) 
		{
			if( !isset ( $option['std'] ) ) { $option['std'] = '';}
			if( !isset ( $option['id'] ) ) { $option['id'] = '';}
			/* Sets the default value */
			/*
			if ( $option['type'] == 'zn_dynamic_list' ) {
					foreach ( $option['options'] as $area_id => $area )
					{
						if ( isset ( $this->data[$area_id] ) ) {
						
								$option['std'] = $this->data[$area_id];
							
						}
					}
			}
			else*/if($option['std'] != 'group') 
			{
				if(isset($this->data[$option['id']])) {  
					$option['std'] = $this->data[$option['id']];
				}
			}
			
			$output .= $this->zn_render_element($option);
		}
	
		$output .= $this->zn_page_end();
	
	return $output;
	
	}
		
	
	function zn_show_menu($menu_items){
		
		
		$output  = '';
		$output .= '<ul>';
		
		foreach($menu_items as $menu)
		{
			if( !isset ( $menu['class'] ) ) { $menu['class'] = '';}
			if(isset($menu['submenus'])) {
			
				$output .= '<li class="parent"><a href="#" rel="">'.$menu['name'].'</a>'.$this->zn_show_menu($menu['submenus']).'</li>';
			
			}
			else
			{
				$output .= '<li><a class="normal '.$menu['class'].'" href="#zn_page_'.$menu['id'].'" rel="">'.$menu['name'].'</a></li>';
			}
				
		}
		
		$output .= '</ul>';
		
		return $output;
	}
	
	function zn_page_start() {
		
		global $zn_has_error;
		
		$output  = '';
		
		if ( is_array ( $zn_has_error ) && !empty ( $zn_has_error[0] ) ) {
			$output .= '<div id="zn_error_container">';
				//$output .= '<h3>Error :</h3>';
				foreach ($zn_has_error as $error ){
					$output .= $error.'<br/>';
				}
			$output .= '</div>';
		}
		
		$output  .= '<div id="zn_options_container">';

		
		// Start Form
		$output .= '<form id="zn_form" method="post" action="'. esc_attr( $_SERVER['REQUEST_URI'] ) .'" enctype="multipart/form-data" >';
		

		

		
		// Start Main
		$output .= '<div id="main">';
		
		// Start sidebar
		$output .= '<div id="zn_sidebar">';
		
		// Start the logo
		$output .= '<div class="zn-logo"><img src="'.ADMIN_MASTER_ADMIN_DIR.'images/logo.png" /></div>';
		
		// Start Menu
		$output .= '<div id="zn-nav">';
		$output .= $this->zn_show_menu($this->menu);
		$output .= '</div>';
		
		// End sidebar
		$output .= '</div>';
		
		
		//Start Content 
		$output .= '<div id="content">';

		
		// Header
		$output .= '<div id="header"> <div id="js-warning">Warning- This options panel will not work properly without javascript!</div>';
		
		// Save popups
		$output .= '<div class="zn-save-popup" id="zn-popup-save"><div class="zn-save-save">Options successfully updated</div></div>';
		$output .= '<div class="zn-reset-popup" id="zn-popup-reset"><div class="zn-save-reset">Options Reset</div></div>';
		$output .= '<div class="zn-fail-popup" id="zn-popup-fail"><div class="zn-save-fail">Error!</div></div>';
		
		$output .= '<div class="zn-icon-option">';
		$output .= '<img src="'.ADMIN_MASTER_ADMIN_DIR.'images/wait.png" class="ajax-loading-img ajax-loading-img-bottom" alt="Working..." />';
		
		//$output .= '<button type="button" class="zn_save button-primary">Save All Changes</button>';
		$output .= '<button type="button" class="zn_save zn_save_button"></button>';
		
		$output .= '</div>';
		
		// Info links 
		$my_theme = wp_get_theme();

		$output .= '<div class="h_info"><a href="#">Version '.THEME_VERSION.'</a></div>';		

		$output .= '<div class="h_info"><a target="_blank" href="http://support.hogash.com/">Get Support</a></div>';

		$output .= '<div class="h_info"><a target="_blank" href="http://support.hogash.com/documentation_category/kallyas-wordpress-theme/">Online Documentation</a></div>';

		
		$output .= '<div class="clear"></div>';
		$output .= '</div>';
		$output .= '<div id="inner-content">';
		
		return $output;
	}
	
	function zn_page_end() {
		
		$output   = '';

		$output  .= '</div>'; // End container
		
		$output .= '<div id="zn_footer"> <div id="js-warning">Warning- This options panel will not work properly without javascript!</div>';
		
		// Save popups
		$output .= '<div class="zn-save-popup" id="zn-popup-save"><div class="zn-save-save">Options successfully updated</div></div>';
		$output .= '<div class="zn-reset-popup" id="zn-popup-reset"><div class="zn-save-reset">Options Reset</div></div>';
		$output .= '<div class="zn-fail-popup" id="zn-popup-fail"><div class="zn-save-fail">Error!</div></div>';
		

		
		$output .= '<div class="zn-icon-option">';
		$output .= '<img src="'.ADMIN_MASTER_ADMIN_DIR.'images/wait.png" class="ajax-loading-img ajax-loading-img-bottom" alt="Working..." />';
		
		//$output .= '<button type="button" class="zn_save button-primary">Save All Changes</button>';
		$output .= '<button type="button" class="zn_save zn_save_button"></button>';
		$output  .= '<input type="hidden" id="security" name="security" value="'.wp_create_nonce('zn_ajax_nonce').'" />';
		$output  .= '<input type="hidden" name="zn_reset" value="reset" />';
		$output .= '</div>';

		
		// Info links 
		$my_theme = wp_get_theme();
		$output .= '<div class="h_info"><a href="#">Version '.THEME_VERSION.'</a></div>';
		
		$output .= '<div class="clear"></div>';
		$output .= '</div>'; // End footer
		

		
		$output  .= '</div>'; // End container
		$output  .= '<div class="clear"></div>'; 
		$output  .= '</div>'; // End main

		$output  .= '</form>'; // End Form
		$output  .= '</div>'; // End ZN_CONTAINER
		$output  .= '';
		
		return $output;
	}
	
/***************************************************
* Renderer 
* Renders a single elemenet ( $option )
* Is called by the zn_show_options() and group()
***************************************************/

	function zn_render_element($option){

		if( !isset ( $option['id'] ) ) { $option['id'] = '';}
		if( !isset ( $option['type'] ) ) { $option['type'] = '';}
		if( !isset ( $option['name'] ) ) { $option['name'] = '';}
		if( !isset ( $option['class'] ) ) { $option['class'] = '';}
		if( !isset ( $option['description'] ) ) { $option['description'] = '';}
		if( !isset ( $option['mod'] ) ) { $option['mod'] = array();}
		if( !isset ( $option['dynamic'] ) ) { $option['dynamic'] = '';}
		if( !isset ( $option['hidden'] ) ) { $option['hidden'] = '';}
		if( !isset ( $option['remove_text'] ) ) { $option['remove_text'] = '';}
		if( !isset ( $option['add_text'] ) ) { $option['add_text'] = '';}

		
		// ???????????????????????????????????????????????????????????????????????????
		if( !isset ( $option['link_to'] ) ) { $option['link_to'] = '';}
		// ???????????????????????????????????????????????????????????????????????????
		
		if( !isset ( $option['sizes'] ) ) { $option['sizes'] = '';}
		if( !isset ( $option['class'] ) ) { $option['class'] = '';}
		if( !isset ( $option['group_title'] ) ) { $option['group_title'] = '';}
		if( !isset ( $option['group_sortable'] ) ) { $option['group_sortable'] = true;}
	
		//print_r($option);
	
		$output = ''; 
			
		if($option['type'] == 'option_page_start')
		{
			$output = '<div class="zn_page" id="zn_page_'.$option['id'].'">';
		}
		
		if($option['type'] == 'option_page_end')
		{
			$output = '</div>';
		}
		
		if($option['type'] == 'zn_accordion_start')
		{
			
			$class = $option['class'];
			
			$output .= '<div class="zn_single_toggle zn_slide_header '.$class.'"><strong>'.$option['name'].'</strong><div class="zn_slide_buttons"><a class="zn_slide_edit_button" href="#">a</a></div></div><div class="zn_slide_body '.$class.'" >'."\n";
			
			
		}
		
		if($option['type'] == 'zn_accordion_end')
		{

			$output .= '</div>'."\n";

		}
			
			

			
			
		if(method_exists( $this, $option['type'] ) ) 
		{
			//check if we should only render the element itself or description as well
			if ( $option['type'] == 'group' && $option['dynamic'] )
			{
				$output .= $this->$option['type']( $option ) ;
			}
			elseif( $option['type'] == 'group' && $option['hidden'] ) 
			{
				$output .= '';
			}
			elseif($option['type'] == 'group')
			{
				// Check for the sortable option
				$not_sortable = 'zn_sortable';
				if ( !$option['group_sortable'] ) {
					$not_sortable = '';
				}
				
				$output .= '<div class="zn_accordion  '.$option['class'].'">';
				$output .= '<h4 class="heading">'.$option['name'].'</h4>';
				$output .= '<ul id="'.$option['id'].'"  class="'.$not_sortable.' zn_normal_group">';
				
				$output .= $this->$option['type']( $option ) ;
				
				$output .= '</ul>';
				$output .= '<div class="clear"></div>';
				$output .= '<a class="zn_slide_add_button zn-blue" href="#">Add a new '.$option['add_text'].'</a>';
				$output .= '<span class="zn_add_type">'.$option['id'].'</span>';
				$output .= '<div class="clear"></div>';
				$output .= '</div>';
			}

			else
			{

				$output .= $this->zn_section_start( $option );
				
				$output .= $this->$option['type']( $option );
			
					
				$output .= $this->zn_section_end( $option );

				
			}
			
		}
	
		return $output;
	}

/***************************************************
* Options
*
* Begin the options
***************************************************/



/***************************************************
*				Group Option
***************************************************/
	function group ($element) {
	
		global $data;
		$output = "";
	
		$number_of_elements = 1;
		
		$group_id = $element['id'];
		$real_id = $element['id'];
		/*
		echo '<pre>';
		print_r($element);
		echo '</pre>';
		*/
		
		if ( isset ( $element['pb_area'] ) )
		{
			$group_id = $element['pb_area'];
		}
		
		if ( isset ( $element['std'] ) && is_array ( $element['std'] ) )
		{
			$number_of_elements = count($element['std']);
		}
		
		$size = '';


		for ($i = 0; $i < $number_of_elements; $i++) {

			if (  isset ( $element['is_dynamic'] ) && $element['is_dynamic'] ) 
			{
				// Set the li size and add a default size		
				if(is_array($element['std']) && isset($element['std'][$i]['_sizer'])){
					$size = $element['std'][$i]['_sizer'];
				}
				elseif(isset($element['sizes']))
				{
					$available_sizes = explode(",", $element['sizes']);
					$size = $available_sizes[0];
				}
				else
				{
					$size = 'zn-one-four';
				}
			}
			
			$handle = '';
			if (  isset ( $element['is_dynamic'] ) && $element['is_dynamic'] ) 
			{
				$handle = 'zn_dynamic_handle';
				$element['add_text'] = $element['name'];
			}
			
			$output .= '<li class="zn_slide '.$size.'">';
			$output .= '<div class="zn_slide_header '.$handle.'">';

			// Add the name of the desired field if it set
			if ( $element['group_title'] && isset($this->data['unlimited_colors'][$i][$element['group_title']]) ) {
				
					$output .= '<strong>'.$this->data['unlimited_colors'][$i][$element['group_title']].'</strong>';
			
			}
			elseif( !empty($element['use_name']) && !empty( $element['std'][$i][$element['use_name']] )){
				$output .= '<strong>'.$element['std'][$i][$element['use_name']].'</strong>';
			}
			else {
				$output .= '<strong>'.$element['add_text'].'</strong>';
			}

			
			// Slide buttons
			$output .= '<div class="zn_slide_buttons">';
			
	

			
			if (  isset ( $element['is_dynamic'] ) && $element['is_dynamic'] ) 
			{
			
				$sizes = array (
					"four"=>"1/4",
					"one-third"=>"1/3",
					"eight"=>"1/2",
					"two-thirds"=>"2/3",
					"twelve"=>"3/4",
					"sixteen"=>"1/1",
				);

				// Set the current size for the dynamic element	
				$zn_size = '';
				foreach($sizes as $key=>$value)
				{
					//echo $size;
					if($size == $key)
					{
						$zn_size = $value;
					}


				}
				
				$first_inactive = '';
				$last_inactive = '';
				
				
				// de continuat
				$available_sizes = explode(",", $element['sizes']);
				if( $size == $available_sizes[0] ) {
					$first_inactive = 'zn-size-inactive';
				
				}
				
				if( $size == end($available_sizes) ) {
					$last_inactive = 'zn-size-inactive';
				}
			
				$output .= '<div class="zn_size_container">';
				
				$output .= '<a href="#" class="zn_slide_decrease_button '.$first_inactive.'"> - </a>';
				
				$output .= '<a href="#" class="zn_slide_increase_button '.$last_inactive.'"> + </a>';
				$output .= '</div>';
				// Slide buttons : edit , delete and size
				$output .= '<div href="#" class="zn_slide_size" data-sizes="'.$element['sizes'].'">'.$zn_size.'</div>';
			}
			

			$output .= '<a href="#" class="zn_slide_edit_button">a</a>';
			$output .= '<a href="#" class="zn_slide_delete_button">d</a>';
			$output .= '</div>';
			
			if (  isset ( $element['is_dynamic'] ) && $element['is_dynamic'] ) 
			{
				$output .= '<a href="#" class="zn_slide_close_button" title="Done">Done</a>';
			}
			
			$output .= '</div>';
			
			$output .= '<div class="zn_slide_body">';
						
						
			$output .= '<input name="'.$group_id.'['.$i.'][dynamic_element_type]" type="hidden" value="'.$real_id.'" />';
			
			
			if ( isset ( $element['pb_area'] ) ) {
				// Set the page area if set
				$output .= '<input name="'.$group_id.'['.$i.'][pb_area]" type="hidden" value="'.$element['pb_area'].'" />';
			}

			foreach($element['subelements'] as $key => $value) {
			
			
			
				// Sets the default vallue if exists
				if( isset ( $element['std'] ) && is_array ( $element['std'] ) && isset ( $element['std'][$i][$value['id']] ) ) {
					$value['std'] = $element['std'][$i][$value['id']];
				}
				$sub_element_id = $value['id'];
				// Sets the id of the subelement to include the group id
				$value['id'] = $group_id.'['.$i.']['.$value['id'].']';
				
				// Pass the translate text to the actual field if necessary :
				if ( isset ($element['translate'] ) && is_array ( $element['translate'] ) )
				{
					foreach ( $element['translate'] as $translate_id => $translate_text )
					{
						if ( $translate_id == $sub_element_id )
						{
							$value['translate_name'] = $translate_text.' '.($i+1);
							$output .= $value['translate_name'] ;
						}
					}
					
				}
				
				$output .=  $this->zn_render_element($value);
				

			}
			
			$output .= '<div class="clear"></div>';
			$output .= '</div>';
			$output .= '</li>';
			
		}
		
		return $output;
		
	}

/***************************************************
*				Dynamic list Option
***************************************************/
	function zn_dynamic_list($element) {
	
		$output = "";
	
		$number_of_elements = 1;
		
		$group_id = $element['id'];
		
		if ( isset ( $element['std'] ) && is_array ( $element['std'] ) )
		{
			$number_of_elements = count($element['std']);
		}
	/*	
		echo '<pre>';
		print_r($element['std']);
		echo '</pre>';
	*/	
		$output .= '<div class="zn_dynamic_accordion">';

		
		// Start area options
		
		foreach ( $element['options'] as $area_id => $area ){
		
		$output .= '<div class="zn_page_area">';
			$output .=  '<div class="zn_pb_area_name"><h4>'.$area['area_name'].'</h4>';
		
			if( !isset ( $area['limit'] ) ) { $area['limit'] = '';}
		
			$output .= '<a href="#" data-pbarea="'.$area_id.'" data-limit="'.$area['limit'].'" class="zn_slide_add_button zn-blue zn_inactive zn-gray">Add Element</a>';
			$output .= '<div class="select_wrapper">';
				$output .= '<select class="select zn_select_dynamic zn-input" >';
				$output .= '<option />Select an element</option>';
				
				asort($area['area_options']);
				
				foreach ($area['area_options'] as $select_ID => $option) {			
					$output .= '<option id="' . $select_ID . '" value="'.$select_ID.'"  />'.$option.'</option>';	 
				} 
				
				$output .= '</select>';
			$output .= '</div>';
		
			$output .= '<span class="zn_hider zn_add_type"></span>';

			$output .= '<div class="clear"></div>';
			
			$output .= '</div>';
		
			$output .= '<ul id="'.$area_id.'"  class="zn_dynamic_list_container">';
			
				if ( !is_array($element['std'] ) ) 
				{
					$element['std'] = array();
				}
			
				foreach($element['std'] as $key=>$value) 
				{
									
					if ( isset ( $element['std'][$key]['pb_area'] ) && $element['std'][$key]['pb_area'] == $area_id ) {
						$new_element = $element['std'][$key]['dynamic_element_type'];
						
						$option = zn_get_element_from_id($new_element);
						
						
						
						$option['std'] = array();
						$option['std'][] = $element['std'][$key];
						
						$option['is_dynamic'] = true;
						$option['pb_area'] = $area_id;
				/*		
					echo '<pre>';
					print_r($option);
					echo '</pre>';
				*/		
						$output .=  $this->zn_render_element($option);
					}
				}
			
			$output .= '</ul>';
			
		$output .= '</div>';
		}
		

			
			
			
			$output .= '<div class="clear"></div>';
			$output .= '</div>';
				
		return $output;
		
	}


	
	
/***************************************************
*				Text Option
***************************************************/


	function text ( $value ){
	
		$t_value = '';
		$t_value = esc_html(stripslashes($value['std']));

		$disabled = '';
		$mini ='';
		if(!isset($value['mod'])) $value['mod'] = '';
		if($value['mod'] == 'mini') { $mini = 'mini';}
		
		if ( isset ( $value['mod'] ) && $value['mod'] == 'disabled' ) {
			if ( isset ( $t_value ) && !empty ( $t_value ) ) {
				$disabled = ' readonly';
			}
		}
		
		if ( function_exists('icl_register_string') )
		{	
			if ( isset ( $value['translate_name'] ) )
			{
				icl_register_string(THEMENAME, $value['translate_name'], $t_value);
			}
		}
		
		
		
		$output = '<input class="zn-input '.$mini.'" name="'.$value['id'].'" id="'. $value['id'] .'" type="'. $value['type'] .'" value="'. $t_value .'" '.$disabled.' />';
		
		return $output;
	}

/***************************************************
*				Backup - Restore
***************************************************/


	function zn_backup_restore ( $value ){
	
		$output = '';


		$output .= '<div class="zn_backup"><input name="zn_backup_options" type="submit" value="Backup theme options" class="zn_backup_options zn-blue "></div>';
		$output .= '<div class="zn_backup_sep"></div>';

			global $wpdb;
			$theme_backups = $wpdb->get_results("SELECT * FROM $wpdb->options WHERE option_name LIKE ('".THEMENAME."_backup_from_%')");
			
			// echo '<pre>';
			// print_R($theme_backups);
			// echo '</pre>';

			if ( count( $theme_backups ) > 0 ){

				$output .= '<span class="zn_grey_text">Backup list :</span></br>';
				$output .= '<ul class="zn_backup_list">';
				foreach ($theme_backups as $key => $value) {
					$option_name = $value->option_name;
					$output .= '<li><a class="zn_question zn_restore_option" data-backup="'.$option_name.'" original-title="Restore this backup ?" href="#">'. $option_name.'</a><span data-backup="'.$option_name.'" class="zn_question zn_delete_backup zn_delete" original-title="Delete this backup ?">x</span><li>';
				}
				$output .= '</ul>';
				$output .= '<span class="zn_grey_text no_backups_text" style="display:none;">No backups created so far. Press the "<b>Backup theme options</b>" button from above to perform a backup.</span>';
			}
			else {
				$output .= '<ul class="zn_backup_list">';
				$output .= '</ul>';
				$output .= '<span class="zn_grey_text no_backups_text">No backups created so far. Press the "<b>Backup theme options</b>" button from above to perform a backup.</span>';
			}

		return $output;
	}


/***************************************************
*				Description 
***************************************************/


	function description ( $value ){

		$output = '<div class="">'.$value['desc'].'</div>';
		
		return $output;
	}

	
/***************************************************
*				ONE CLICK INSTALL
***************************************************/


	function one_click_install ( $value ){

			$css = '';
			$disabled = '';
			
			$output = '<p>Please be aware that this button should only be pressed on a clean wordpress installation. If you already have posts and pages you can lose them. The demo data is only for helping you to get started working with this theme and does not contain the demo images.</p>';
			
			if ( get_option(THEMENAME.'_dummy') == 1 ) {
				$output .= '<p style="color:red;">The Demo data was already been imported so the button is disabled so that you cannot import the data again and possible mess up the entire site.If you however want to reinstall the demo data please read the documentation file to see how you can re-enable this button.</p>';
				$disabled = 'disabled';
				$css = 'zn_inactive zn-gray';
			}
			
			$output .= '<input name="zn_install_dummy_data" type="submit" value="Install dummy data " class="zn_install_dummy zn-blue '.$css.'" '.$disabled.'/> ';
			$output .= '<input type="hidden" id="security" name="security" value="'.wp_create_nonce('zn_ajax_nonce').'" />';
			$output .= '<br><br><img class="install_dummy_loading" style="display:none;" src="images/wpspin_light.gif" alt="Loading" /><p class="install_dummy_result"></p>';

		$output .= '<div class="zn_response"></div>';

	
		return $output;
	}
	
	
/***************************************************
*				DatePicker
***************************************************/


	function date_picker ( $value ){
			
		// Check for url
		if ( isset($value['std']['date']) ) 
		{
			$date_val = stripslashes($value['std']['date']);
		}
		else {
			$date_val = '';
		}
		
		// Check for url text
		if ( isset($value['std']['time']) ) 
		{
			$time_val = stripslashes($value['std']['time']);
		}
		else {
			$time_val = '';
		}
			
		$output = '<label for="'. $value['id'].'[date]">Date:</label><input class="zn-input zn_date_picker" name="'.$value['id'].'[date]" id="'. $value['id'].'[date]" value="'. $date_val .'" type="text" /><label for="'. $value['id'].'[time]">Time :</label><input id="'. $value['id'].'[time]" name="'. $value['id'].'[time]" value="'. $time_val .'" type="text" class="zn_time_picker" />';

		return $output;
	}
	
/***************************************************
*				Link Option
***************************************************/


	function link ( $value ){
	
	$output = '';
	
	// Check for url
	if ( isset($value['std']['url']) ) 
	{
		$t_value = stripslashes($value['std']['url']);
	}
	else {
		$t_value = '';
	}
	
	// Check for url text
	if ( isset($value['std']['text']) ) 
	{
		$text_value = stripslashes($value['std']['text']);
	}
	else {
		$text_value = '';
	}
	
	// Check for target
	if ( isset($value['std']['target']) ) 
	{
		$target = stripslashes($value['std']['target']);
	}
	else {
		$target = '';
	}
		
		if ( isset ( $value['mod'] ) && in_array('title',$value['mod']) )
		{
			$output .= '<label>Link text</label><div class="clear"></div>';
			$output .= '<input class="zn-input" name="'.$value['id'].'[text]" id="'. $value['id'] .'_text" type="text" value="'. htmlentities($text_value) .'" /><br />';
		}	
		$output .= '<label>Link URL :</label>';
		$output .= '<input class="zn-input" name="'.$value['id'].'[url]" id="'. $value['id'] .'_url" type="text" value="'. htmlentities($t_value) .'" />';
		
		$output .= '<div class="clear"></div>';
		$output .= '<label>Link target :</label><div class="clear"></div>';
		$output .= '<div class="select_wrapper ">';
		$output .= '<select class="select  zn-input" name="'.$value['id'].'[target]" id="'. $value['id'] .'_target">';
		foreach ($value['options'] as $select_ID => $option) {			
			$output .= '<option id="' . $select_ID . '" value="'.$select_ID.'" ' . selected($target, $select_ID, false) . ' >'.$option.'</option>';	 
		} 
		$output .= '</select></div>';
		
		return $output;
	}
	
/***************************************************
*				Media Upload Option
***************************************************/


	function media ( $value ){
		$output =	'';
	
	// echo '<pre>';
	// print_r($value['std']);
	// echo '</pre>';

		if ( isset($value['alt']) ) {

			if (  is_array( $value['std'] ) ) {
				$saved_image = $value['std']['image'];
				$saved_alt = $value['std']['alt'];
				$saved_title = $value['std']['title'];

				$image_field = $value['id'].'[image]';
			}
			else {
				$saved_alt = '';
				$saved_title = '';
				$saved_image = $value['std'];
				$image_field = $value['id'].'[image]';
			}


		}
		else {
			$saved_alt = '';
			$saved_title = '';
			$saved_image = $value['std'];
			$image_field = $value['id'];

		}

		$output .= '<input class="logo_upload_input" id="'.$value['id'].'" type="text" size="36" name="'.$image_field.'" value="'.$saved_image.'" />';
		$output .= '<input class="zn_upload_image_button" type="button" value="Upload Image" />';

		if( isset ( $value['std'] ) && !empty( $value['std'] ) )
		{
			$output .= '<div class="zn-image-holder"><a class="zn-remove-image" href="#">remove</a><img alt="" src="'.$saved_image.'"></div>';
		}
		else
		{
			$output .= '<div class="zn-image-holder">Nothing selected...</div>';
		}

		if ( isset($value['alt'] ) ) {
			$output .= '<input class="zn_img_alt" id="'.$value['id'].'_alt" type="hidden" name="'.$value['id'].'[alt]" value="'.$saved_alt.'" />';
			$output .= '<input class="zn_img_title" id="'.$value['id'].'_title" type="hidden" name="'.$value['id'].'[title]" value="'.$saved_title.'" />';
		}

		return $output;
	}	
	
/***************************************************
*				Background Options
***************************************************/


	function background ( $value ){
		$output =	'';
		
		if( !isset ( $value['std']['image'] ) || empty( $value['std']['image'] ) )
		{
			$value['std']['image'] = '';
		}
		
		$output .= '<input class="logo_upload_input" id="'.$value['id'].'_image" type="text" size="36" name="'.$value['id'].'[image]" value="'.$value['std']['image'].'" />';
		$output .= '<input class="zn_upload_image_button" type="button" value="Upload Image" />';
		
		if( isset ( $value['std']['image'] ) && !empty( $value['std']['image'] ) )
		{
			$output .= '<div class="zn-image-holder"><a class="zn-remove-image" href="#">remove</a><img alt="" src="'.$value['std']['image'].'"></div>';
		}
		else
		{
			$output .= '<div class="zn-image-holder">Nothing selected...</div>';
		}
		
		if ( isset( $value['options']['repeat'] ) || !empty( $value['std']['repeat'] ) )
		{
			
			if( !isset ( $value['std']['repeat'] ) || empty( $value['std']['repeat'] ) )
			{
				$value['std']['repeat'] = '';
			}
			
			$output .= '<div class="z-2">';
			$output .= '<label>Background repeat</label>';
			$output .= '<div class="select_wrapper ">';
			$output .= '<select class="select  zn-input" name="'.$value['id'].'[repeat]" id="' . $value['id'] . '_repeat'  . '">';
			$repeats = array ('repeat' ,'repeat-x' ,'repeat-y' ,'no-repeat');

			foreach ($repeats as $repeat) {
				$output .= '<option value="' . $repeat . '" ' . selected( $value['std']['repeat'], $repeat, false ) . '>'. $repeat . '</option>';
			}
			$output .= '</select></div>';
			$output .= '<div class="clear"></div>';
			$output .= '</div>';
		}
		
		if ( isset( $value['options']['attachment'] ) )
		{
		
			if( !isset ( $value['std']['attachment'] ) || empty( $value['std']['attachment'] ) )
			{
				$value['std']['attachment'] = '';
			}
		
			$output .= '<div class="z-2">';
			$output .= '<label>Background attachment</label>';
			$output .= '<div class="select_wrapper ">';
			$output .= '<select class="select  zn-input" name="'.$value['id'].'[attachment]" id="' . $value['id'] . '_attachment'  . '">';
			$attachments = array ('scroll' ,'fixed' );

			foreach ($attachments as  $attachment) {
				$output .= '<option value="' . $attachment . '" ' . selected( $value['std']['attachment'], $attachment, false ) . '>'. $attachment . '</option>';
			}
			$output .= '</select></div>';
			$output .= '<div class="clear"></div>';
			$output .= '</div>';
		}
		
		if ( isset( $value['options']['position'] ) )
		{
		
			if( !isset ( $value['std']['position']['x'] ) || empty( $value['std']['position']['x'] ) )
			{
				$value['std']['position']['x'] = '';
			}
			
			if( !isset ( $value['std']['position']['y'] ) || empty( $value['std']['position']['y'] ) )
			{
				$value['std']['position']['y'] = '';
			}
		
			// Position - X
			$output .= '<div class="z-2">';
			$output .= '<label>Background position-x</label>';
			$output .= '<div class="select_wrapper ">';
			$output .= '<select class="select  zn-input" name="'.$value['id'].'[position][x]" id="' . $value['id'] . '_position-x'  . '">';
			$positionxs = array ('left' ,'center' ,'right');

			foreach ($positionxs as  $positionx) {
				$output .= '<option value="' . $positionx . '" ' . selected( $value['std']['position']['x'], $positionx, false ) . '>'. $positionx . '</option>';
			}
			$output .= '</select></div>';
			$output .= '<div class="clear"></div>';
			$output .= '</div>';
		
			// Position - Y
			$output .= '<div class="z-2">';
			$output .= '<label>Background position-y</label>';
			$output .= '<div class="select_wrapper ">';
			$output .= '<select class="select  zn-input" name="'.$value['id'].'[position][y]" id="' . $value['id'] . '_position-y'  . '">';
			$positionys = array ('top' ,'center' ,'bottom');

			foreach ($positionys as  $positiony) {
				$output .= '<option value="' . $positiony . '" ' . selected( $value['std']['position']['y'], $positiony, false ) . '>'. $positiony . '</option>';
			}
			$output .= '</select></div>';
			$output .= '<div class="clear"></div>';
			$output .= '</div>';
		}
		

		
		return $output;
	}	
	
/***************************************************
*				Zn ui slider - Drag select
***************************************************/
	
	function znuislider ( $value )
	{
	
		$output ='<div id="'.$value['id'].'_znslider" rel="'. $value['std'] .'" class="uislider"><div class="min">'. $value['min'] .'</div><div class="max">'. $value['max'] .'</div></div>';
		$output .= '<input class="zn-color ui_slider_input" name="'.$value['id'].'" id="'. $value['id'] .'" type="text" value="'. $value['std'] .'" />';
		
		return $output;
	}
	
/***************************************************
*				Zn Radio - iphone button
***************************************************/
	
	function zn_radio ( $value )
	{
	
		if ( isset ( $value['rel_id'] ) ) {
			$rel = $value['rel_id'];
		}
		else {
			$rel = $value['id'];
		}
	
		$output = '';
		$output .= '<div id="'.$value['id'].'" class="zn_radio">';
		$i = 0;
		 foreach($value['options'] as $option=>$name) {
			$i++;
			
			$label_id = str_replace('[','_',$value['id']);
			$label_id = str_replace(']','_',$label_id);
			
			
			$label = uniqid();
			$output .= '<input rel="'.$rel.'" id="'.$label.''.$i.'" name="'.$value['id'].'" type="radio" value="'.$option.'" ' . checked($value['std'], $option, false) . ' autocomplete="off" />';				
			$output .= '<label for="'.$label.''.$i.'">'.$name.'</label>';				
		}	
		$output .=	'</div>';	
		
		return $output;
	}
	
/***************************************************
*				ZN Hide Select
***************************************************/
	
	function zn_hide_select ( $value )
	{
	
		if ( isset ( $value['rel_id'] ) ) {
			$rel = $value['rel_id'];
		}
		else {
			$rel = $value['id'];
		}
		$output = '';
	$output .= '<div id="'.$value['id'].'" class="zn_hide">';
			
			$output .= '<div class="select_wrapper">';
			$output .= '<select class="select  zn-input" name="'.$value['id'].'" id="'. $value['id'] .'">';
			foreach ($value['options'] as $select_ID => $option) {			
				$output .= '<option id="' . $select_ID . '" value="'.$select_ID.'" ' . selected($value['std'], $select_ID, false) . ' >'.$option.'</option>';	 
			} 
			$output .= '</select></div>';
	
	$output .=	'</div>';	
	

		
		return $output;
	}
	
/***************************************************
*				Zn Image size 
***************************************************/
	function image_size ( $value ) 
	{
		$output = '';
		$image_size = $value['std'];
		
		if  ( empty($image_size['width']) ) {
			$image_size['width'] = '';
		}

		if  ( empty($image_size['height']) ) {
			$image_size['height'] = '';
		}


		$output .= '<div class="zn_image_size">';
		$output .= '<div>';
		$output .= '<label>Width</label>';
		$output .= '<input type="text" value="'. $image_size['width'] .'" id="'. $value['id'] .'_width" name="'.$value['id'].'[width]" class="zn-color">';
		$output .= '</div>';
		$output .= '<div class="separator">X</div>';
		$output .= '<div>';
		$output .= '<label>Height</label>';
		$output .= '<input type="text" value="'. $image_size['height'] .'" id="'. $value['id'] .'_height" name="'.$value['id'].'[height]" class="zn-color">';
		$output .= '</div>';
		$output .= '</div>';

		return $output;
	}
	

	
/***************************************************
*				Tiles inputboxes
***************************************************/
	function tiles ( $value )
	{
		$output = '';
		$i = 0;
		$select_value = '';
		$select_value = $value['std'];
			$output .= '<div class="zn_tiles">';
			$output .= '<div class="tiles_inner">';
		foreach ($value['options'] as $key => $option) 
		{ 
		$i++;

			$checked = '';
			$selected = '';
			if(NULL!=checked($select_value, $option, false)) {
				$checked = checked($select_value, $option, false);
				$selected = 'zn-radio-tile-selected';  
			}

			$output .= '<span>';
			$output .= '<input type="radio" id="zn-radio-tile-' . $value['id'] . $i . '" class="checkbox zn-radio-tile-radio" value="'.$option.'" name="'.$value['id'].'" '.$checked.' />';
			$output .= '<div class="zn-radio-tile-img '. $selected .'" style="background: url('.$option.')" onClick="document.getElementById(\'zn-radio-tile-'. $value['id'] . $i.'\').checked = true;"></div>';
			$output .= '</span>';				
			
		}
			$output .= '</div>';
			$output .= '</div>';
			
		return $output;
	}
	
/***************************************************
*				Textarea Option
***************************************************/
	function textarea ( $value ){

		$cols = '8';
		$ta_value = '';
		
		if(isset($value['options'])){
				$ta_options = $value['options'];
				if(isset($ta_options['cols'])){
				$cols = $ta_options['cols'];
				} 
			}

		//$output = wp_editor( '',  $value['id'], $settings = array('media_buttons'=> false) );


		
		
		$ta_value = esc_html(stripslashes($value['std']));			
		$output = '<textarea class="zn-input testc" name="'.$value['id'].'" id="'. $value['id'] .'" cols="'. $cols .'" rows="8">'.$ta_value.'</textarea>';		

		return $output;
		
	}
	
/***************************************************
*				Hidden Option
***************************************************/
	function hidden ( $value ){
					
		$output = '<input name="'.$value['id'].'" class="'.$value['class'].'" value="'.$value['std'].'" id="'. $value['id'] .'" type="hidden"></input>';		

		return $output;
		
	}

/***************************************************
*				Border Option
***************************************************/
	function border ( $value ){
			
		$output = '';
		
		/* Border Width */
		$border_stored = $value['std'];
		
		$output .= '<div class="z-3">';
		$output .= '<label>Border size</label>';
		$output .= '<div class="select_wrapper border-width">';
		$output .= '<select class="zn-border zn-border-width select" name="'.$value['id'].'[width]" id="'. $value['id'].'_width">';
			for ($i = 0; $i < 21; $i++){ 
				$output .= '<option value="'. $i .'" ' . selected($border_stored['width'], $i, false) . '>'. $i .'</option>';				 
			}
		$output .= '</select></div>';
		$output .= '</div>';
		
		/* Border Style */
		$output .= '<div class="z-3">';
		$output .= '<label>Border style</label>';
		$output .= '<div class="select_wrapper border-style">';
		$output .= '<select class="zn-border zn-border-style select" name="'.$value['id'].'[style]" id="'. $value['id'].'_style">';
		
		$styles = array('none'=>'None',
						'solid'=>'Solid',
						'dashed'=>'Dashed',
						'dotted'=>'Dotted');
						
		foreach ($styles as $i=>$style){
			$output .= '<option value="'. $i .'" ' . selected($border_stored['style'], $i, false) . '>'. $style .'</option>';		
		}
		
		$output .= '</select></div>';
		$output .= '</div>';
		
		/* Border Color */		
		$output .= '<div class="z-3">';
		$output .= '<label>Border color</label>';
		$output .= '<div id="' . $value['id'] . '_color_picker" class="colorSelector"><div style="background-color: '.$border_stored['color'].'"></div></div>';
		$output .= '<input class="zn-color zn-border zn-border-color" name="'.$value['id'].'[color]" id="'. $value['id'] .'_color" type="text" value="'. $border_stored['color'] .'" />';
		$output .= '</div>';
		
		return $output;
		
	}	
	
/***************************************************
*				Space
***************************************************/
	function zn_space ( $value ) 
	{	
		$sizes   = $value['std'];
	
		$output  = '';
		
		$output .= '<div class="z-2">';
		$output .= '<label>Top space</label>';
		$output .= '<div class="select_wrapper mini">';

		$output .= '<select class="select of-input" name="'.$value['id'].'[top]" id="'. $value['id'] .'_top">';
		
		for ($i = 0; $i < 21; $i++){ 
			$output .= '<option value="'. $i .'px" ' . selected($sizes['top'], $i.'px', false) . '>'. $i .'px</option>';				 
		}

		$output .= '</select></div>';
		$output .= '</div>';
		
		$output .= '<div class="z-2">';
		$output .= '<label>Bottom Space</label>';
		$output .= '<div class="select_wrapper mini">';
		$output .= '<select class="select of-input" name="'.$value['id'].'[bottom]" id="'. $value['id'] .'_bottom">';
		
		for ($i = 0; $i < 21; $i++){ 
			$output .= '<option value="'. $i .'px" ' . selected($sizes['bottom'], $i.'px', false) . '>'. $i .'px</option>';				 
		}

		$output .= '</select></div>';
		$output .= '</div>';
		
		return $output;
	}
	
/***************************************************
*				GOOGLE FONTS
***************************************************/

	function zn_g_fonts( $value ) {
		$output = '';

		


		$output .= '<div class="zn_accordion">';
		$output .= '<h4 class="heading">'.$value['name'].'</h4>';
		$output .= '<ul id="'.$value['id'].'"  class=" zn_normal_group">';
		
		$value['fonts'] = array_merge($value['fonts'] , $value['std']);

	    if ( !empty($value['fonts']) ) {
	        foreach ($value['fonts'] as $font) {

			$output .= '<li class="zn_slide ">';
			$output .= '<div class="zn_slide_header">';
			$output .= '<strong>'.$font.'</strong>';
			$output .= '<div class="zn_slide_buttons">';
			$output .= '<a href="#" class="zn_slide_edit_button">a</a>';
			$output .= '</div>';
			$output .= '</div>';

			$output .= '<div class="zn_slide_body">';

			//$output .= $fonts[$font]['variants'];

			if ( empty($this->data['all_g_fonts']) ) { $this->data['all_g_fonts'] = array(); }

			$vals = $this->data['all_g_fonts'];

			if( empty($vals[$font]) ) { $this->data['all_g_fonts'][$font]['variant'] = array(); }



			$multi_stored = $this->data['all_g_fonts'][$font]['variant'];
					


			foreach ($this->new_fonts[$font]['variants'] as $key => $option) {
				if (!isset($multi_stored[$key])) {$multi_stored[$key] = '';}
				$of_key_string = 'all_g_fonts_'.str_replace(' ', '_',$font).'' . $key;
				$output .= '<input type="checkbox" class="checkbox zn-input" name="all_g_fonts['.$font.'][variant]['.$key.']" id="'. $of_key_string .'" value="'.$option.'" '. checked($multi_stored[$key], $option, false) .' /><label for="'. $of_key_string .'">'. $option .'</label><br />';								
			
			}

//print_r( $this->data['all_g_fonts'] );
			

			$output .= '<div class="clear"></div>';
			$output .= '</div>';
			$output .= '</li>';



				//print_r($fonts[$font]);
			}
		}
		
		$output .= '</ul>';
		$output .= '<div class="clear"></div>';
		$output .= '</div>';

/*
		if ( !empty($value['std']) ) {
			foreach ($value['std'] as $font) {

				$output .= '';


				print_r($fonts[$font]);
			}
		}
/*
// GET ALL FONTS NAMES WITH VARIANTS


		foreach ($items as $item) {
			$i++;
			$str[] = $item['family'];
			
			$faces[$item['family']] = array();
			$faces[$item['family']]['variants'] = $item['variants'];
			$faces[$item['family']]['subsets'] = $item['subsets'];
		}

print_r(json_encode($faces));
*/

	return $output;


	}

/***************************************************
*				Typography
***************************************************/

	function typography ( $value ) 
	{		
		$data = get_option(OPTIONS);
	
			$typography_stored = $value['std'];
			//var_dump($data);
			/* Font Size */
			
			$output = '';
			
			if(isset($typography_stored['size'])) {
				
				$output .= '<div class="z-2"><label>Font size</label>';
				$output .= '<div class="select_wrapper typography-size">';
				$output .= '<select class="zn-typography zn-typography-size select" name="'.$value['id'].'[size]" id="'. $value['id'].'_size">';
					for ($i = 9; $i < 50; $i++){ 
						$test = $i.'px';
						$output .= '<option value="'. $i .'px" ' . selected($typography_stored['size'], $test, false) . '>'. $i .'px</option>'; 
						}
		
				$output .= '</select></div><div class="clear"></div></div>';
			
			}
			

				
			/* Font Face */
			if(isset($data['fonts'][$value['id']])) {
				$f = $data['fonts'][$value['id']];
			}
			elseif( isset( $value['std']['face'] ) ) {
				$f = $value['std']['face'];
			}
			else {
				$f = 'Arial';
				}
			
			if ( isset ( $f ) && !empty ( $f ) ) { 
				$output .= '<div class="z-2"><label>Font Family :</label>';
				$output .= '<div class="select_wrapper typography-face">';
				$output .= '<select class="zn-typography zn-typography-face select" name="fonts['.$value['id'].']" id="'. $value['id'].'_face">';
				
				// All normal Fonts	
				$faces = array('arial'=>'Arial',
								'verdana'=>'Verdana, Geneva',
								'trebuchet'=>'Trebuchet',
								'georgia' =>'Georgia',
								'times'=>'Times New Roman',
								'tahoma'=>'Tahoma, Geneva',
								'palatino'=>'Palatino',
								'helvetica'=>'Helvetica',
								'disabled' => 'Google Web Fonts :');



				$items = $this->all_fonts['items'];
				$i = 0;

				foreach ($items as $item) {
					$i++;
					$str[] = $item['family'];
					
					$faces[$item['family']] = $item['family'];
				}
					
				foreach ($faces as $i=>$face) {
					if($i == 'disabled') {
						$output .= '<option disabled="disabled" >'. $face .'</option>';
					}
					else {
						$output .= '<option value="'. $i .'" ' . selected($f, $i, false) . '>'. $face .'</option>';
					}
				}			
								
				$output .= '</select></div><div class="clear"></div></div>';

			}
			
			/* Line Height */
			
			if( isset($typography_stored['height']) ) {
				$output .= '<div class="z-2"><label>Line Height :</label>';
				$output .= '<div class="select_wrapper typography-height">';
				$output .= '<select class="zn-typography zn-typography-height select" name="'.$value['id'].'[height]" id="'. $value['id'].'_height">';
					for ($i = 1; $i < 50; $i++){ 
						$test = $i.'px';
						$output .= '<option value="'. $i .'px" ' . selected($typography_stored['height'], $test, false) . '>'. $i .'px</option>'; 
						}
		
				$output .= '</select></div><div class="clear"></div></div>';
			
			}
			
			/* Font Weight */
			
			if(isset($typography_stored['style'])) {
				$output .= '<div class="z-2"><label>Font Style :</label>';
				$output .= '<div class="select_wrapper typography-style">';
				$output .= '<select class="zn-typography zn-typography-style select" name="'.$value['id'].'[style]" id="'. $value['id'].'_style">';
				$styles = array('normal'=>'Normal',
								'italic'=>'Italic',
								'bold'=>'Bold',
								'bold italic'=>'Bold Italic');
								
				foreach ($styles as $i=>$style){
				
					$output .= '<option value="'. $i .'" ' . selected($typography_stored['style'], $i, false) . '>'. $style .'</option>';		
				}
				$output .= '</select></div><div class="clear"></div></div>';
			
			}
			
			/* Text Decoration */
			
			if(isset($typography_stored['decoration'])) {
				$output .= '<div class="z-2"><label>Text Decoration :</label>';
				$output .= '<div class="select_wrapper typography-style">';
				$output .= '<select class="zn-typography zn-typography-style select" name="'.$value['id'].'[decoration]" id="'. $value['id'].'_style">';
				$styles = array('none'=>'None',
								'underline'=>'Underline',
								'overline'=>'Overline',
								'line-through'=>'Line Trough'
							);
								
				foreach ($styles as $i=>$style){
				
					$output .= '<option value="'. $i .'" ' . selected($typography_stored['decoration'], $i, false) . '>'. $style .'</option>';		
				}
				$output .= '</select></div><div class="clear"></div></div>';
			
			}
			
			/* Font Color */

			if(isset($typography_stored['color'])) {
				$output .= '<div class="z-2"><label>Font Color :</label>';
				$output .= '<div id="' . $value['id'] . '_color_picker" class="colorSelector"><div style="background-color: '.$typography_stored['color'].'"></div></div>';
				$output .= '<input class="zn-color zn-typography zn-typography-color" name="'.$value['id'].'[color]" id="'. $value['id'] .'_color" type="text" value="'. $typography_stored['color'] .'" />';
				$output .= '<div class="clear"></div>';
				$output .= '</div>';
			}
	
		return $output;
	}
	
/***************************************************
*				Select Option
***************************************************/
	function select ( $value ){
	
		$output = '';
		$class='';
		if( isset( $value['class'] )) {
			$class=$value['class'];
		}
		/*
		echo '<pre>';	
		print_r($value['std']);
		echo '</pre>';	
		*/
		if( $value['mod'] == 'multi' ) {
			$output .= '<select class="select zn_multi zn-input" title="Select an option" multiple="multiple" name="'.$value['id'].'[]" id="'. $value['id'] .'">';
			foreach ($value['options'] as $select_ID => $option) {
			
				$checked = '';
				if(is_array($value['std'])) {
					if(in_array($select_ID,$value['std'])) { $checked = 'selected="selected"'; } else { $checked = ''; }
				}
				
				$output .= '<option id="' . $select_ID . '"  value="'.$select_ID.'" '.$checked.' >'.$option.'</option>';	 
			} 
			$output .= '</select>';	
		}
		else {
			$output .= '<div class="select_wrapper '.$class.'">';
			$output .= '<select class="select  zn-input" name="'.$value['id'].'" id="'. $value['id'] .'">';
			foreach ($value['options'] as $select_ID => $option) {			
				$output .= '<option id="' . $select_ID . '" value="'.$select_ID.'" ' . selected($value['std'], $select_ID, false) . ' >'.$option.'</option>';	 
			} 
			$output .= '</select></div>';
		}
		
		return $output;

	}
	
/***************************************************
*				Color Option
***************************************************/
	function color ( $value ) {	
		
		$output  = '<div id="' . $value['id'] . '_picker" class="colorSelector"><div style="background-color: '.$value['std'].'"></div></div>';
		$output .= '<input class="zn-color" name="'.$value['id'].'" id="'. $value['id'] .'" type="text" value="'. $value['std'] .'" />';

		return $output;
	}	
	
/***************************************************
*				Font icon option
***************************************************/
	function zn_icon_font ( $value ) {	
		
		//$output  = '<div id="' . $value['id'] . '_picker" class="colorSelector"><div style="background-color: '.$value['std'].'"></div></div>';
		//$output .= '<input class="zn-color" name="'.$value['id'].'" id="'. $value['id'] .'" type="text" value="'. $value['std'] .'" />';
/*
		echo '<pre>';
		print_r($value['options']);
		echo '</pre>';
*/	
		$output = '<div class="zn_font_icon_container">';
		$output .= '<input class="zn_font_icon_input" value="'. $value['std'] .'" name="'.$value['id'].'" type="hidden"/>';
		$output .= '<input type="button" value="Select Icon" class="zn_select_icon_font">';
		
		if( isset ( $value['std'] ) && !empty( $value['std'] ) )
		{
			$output .= '<div class="zn-image-holder"><a class="zn-remove-image" href="#">remove</a><ul class="'.$value['options'][0]['class'].'"><li class="'.$value['std'].'"><a>'.$value['std'].'</a></li></ul></div>';
		}
		else
		{
			$output .= '<div class="zn-image-holder">Nothing selected...</div>';
		}
		
		$output .= '<div class="icon_modal icon_modal_hidden">';
		
		foreach ( $value['options'] as $icon_number => $icon_set ) {
			
			
			$output .= '<ul class="'.$icon_set['class'].'">';
			
				foreach( $icon_set['icons'] as $icon_option ) {
					$output .= '<li class="'.$icon_option.'"><a>'.$icon_option.'</a></li>';
				}
			
			$output .= '</ul>';
			
		}
		
		
		
		/*
		foreach ( $value['options'] as $icon_name )
		{
			$output .= '<span class="zn_icon_holder '.$icon_name.'">'.$icon_name.'</span>';
		}*/
		
		$output .= '<span class="clear"></span>';
		$output .= '</div>';
		
		$output .= '</div>';
		
		return $output;
	}	
	
	
/***************************************************
*				Radio Option
***************************************************/
	function radio ( $value ) {
	
		$output = '';
		
		if( $value['mod'] == 'toggle' ) {
		
			$output .= '<div class="zn_radio">';
			$i = 0;
			 foreach($value['options'] as $option=>$name) {
				$i++;
				$output .= '<input autocomplete="off" rel="'.$value['id'].'" id="'.$value['id'].''.$i.'" name="'.$value['std'].'" type="radio" value="'.$option.'" ' . checked($value['std'], $option, false) . ' />';				
				$output .= '<label for="'.$value['id'].''.$i.'">'.$name.'</label>';				
			}	
			$output .=	'</div>';
			
		}
		else {
			foreach($value['options'] as $option=>$name) {
				$output .= '<input class="zn-input zn-radio" name="'.$value['id'].'" type="radio" value="'.$option.'" ' . checked($value['std'], $option, false) . ' />'.$name.'<br/>';				
			}	
		}

		return $output;
		
	}
	
/***************************************************
*				Checkbox Option
***************************************************/
	function checkbox ( $value ) {
		
		if( $value['mod'] == 'multi' ) {
		
			$multi_stored = $value['std'];
						
			foreach ($value['options'] as $key => $option) {
				if (!isset($multi_stored[$key])) {$multi_stored[$key] = '';}
				$of_key_string = $value['id'] . '_' . $key;
				$output .= '<input type="checkbox" class="checkbox zn-input" name="'.$value['id'].'['.$key.']'.'" id="'. $of_key_string .'" value="1" '. checked($multi_stored[$key], 1, false) .' /><label for="'. $of_key_string .'">'. $option .'</label><br />';								
			}
			
		}
		else {
			$output .= '<input type="checkbox" class="checkbox zn-input" name="'.$value['id'].'" id="'. $value['id'] .'" value="1" '. checked($value['std'], 1, false) .' />';
		}

		return $output;
		
	}
	

	
/**
* Other html
*
* 
*/
/*
	function zn_section_start( $option ){
	
			$output = '';
			$desc = '';
			$class = '';
			
			if( $option['description'] )
			{
				$desc = 'zn_has_desc';
			}
			
			if( $option['class'] )
			{
				$class = $option['class'];
			}
			
			if( $option['type'] != 'hidden' )
			{
				$output .= '<div class="zn-option '.$class.'">';

				$output .= '<div class="controls '.$desc.'">';
			
			}
				
		return $output;
	}
	
	
	function zn_section_end( $option ){
	
			$output ='';
			
			if( $option['type'] != 'hidden' )
			{
				$output .= '<div class="clear"> </div></div>';
				
				if( $option['description'] )
				{
					$output .= '<div class="zn_title_and_description"><div class="zn_title"><h4 class="heading">'. $option['name'] .'</h4></div><div class="zn-description">'.$option['description'].'</div></div>';
				}
				
				$output .= '<div class="clear"> </div></div>'."\n";
			}
		
		return $output;
	}
	*/
	
	function zn_section_start( $option ){
	
			$output = '';
			$desc = '';
			$class = '';
			$title = '';
			
			if( $option['description'] )
			{
				$desc = 'zn_has_desc';
				$title = 'title="'.$option['description'].'"';
			}
			
			if( $option['class'] )
			{
				$class = $option['class'];
			}
			
			if( $option['type'] != 'hidden' )
			{
				$output .= '<div class="zn-option '.$class.'">';

				if( $option['description'] )
				{
					$output .= '<div class="zn_title_and_description"><div class="zn_title"><h4 class="heading">'. $option['name'] .'<span class="zn_question" '.$title.'>?</span></h4></div></div>';
				}
				
				$output .= '<div class="controls '.$desc.'">';
			
			}
				
		return $output;
	}
	
	
	function zn_section_end( $option ){
	
			$output ='';
			
			if( $option['type'] != 'hidden' )
			{
				$output .= '<div class="clear"> </div></div>';
				

				
				$output .= '<div class="clear"> </div></div>'."\n";
			}
		
		return $output;
	}

/***************************************************
*				Test footer columns
***************************************************/


	function widget_positions ( $value ){
	
		$number_of_columns  = $value['number_of_columns'];
		$columns_variations = $value['columns_positions'];

		$saved_widgets_display = stripslashes( $value['std'] );
		$saved_widgets_array = json_decode($saved_widgets_display,true);
	/*	
		echo '<pre>';
		//echo $saved_widgets_display;
		echo '</pre>';
	*/	
		
		$output = '<div class="zn_mp">';
		
		$output .= '<div class="zn_nop">';
			$output .= '<span class="option_title">Columns :</span>';
			$output .= '<ul class="zn_number_list">';
		
				for ( $i=1; $i<$number_of_columns+1; $i++ ) {
					
					$active_class = '';
					if ( $i == key($saved_widgets_array) ) {$active_class = 'active';}
				
					$output .= '<li class="nof_trigger '.$active_class.'">'.$i.'</li>';
				}
	
			$output .= '</ul>';
			$output .= '<div class="clear"></div>';
			
		$output .= '</div>';
		
		$alphabet = array ('a','b','c','d');

		$output .= '<div class="zn_positions">';
		
		$output .= '<div class="zn_positions_display">';
			
			for ( $i=1; $i<$number_of_columns+1; $i++) {
				
				$css = '';
				$saved_variation = '';
				
				if ( $i > key($saved_widgets_array) ) {
					$css = 'hidden';
					
				}else {
					//$saved_variation = $value['columns_positions'][key($saved_widgets_array)][0][$i-1];
					$saved_variation = $saved_widgets_array[key($saved_widgets_array)][0][$i-1];
				}

			
				$output .= '<div class="zn_position zn-grid-'.$saved_variation.' '.$css.'"><span>'.$alphabet[$i-1].'</span></div>';
			}
			$output .= '</div>';
			$output .= '<div class="clear"></div>';
			$output .= '<div class="zn_position_options">';
			
				// All position variations
				$output .= '<div class="zn_position_var_options">';
					
					
					$output .= '<span class="option_title">Styles :</span>';
					$output .= '<ul class="zn_number_list">';
					
					foreach( $columns_variations[key($saved_widgets_array)] as $key => $val ) {
					
						$active_class = '';
						if (  $saved_widgets_array[ key($saved_widgets_array) ][0] == $val ) { $active_class = 'active'; }
					
						$pos_value = $key+1;
					
						$output .= '<li class="'.$active_class.'">'. $pos_value .'</li>';
					}
					
					$output .= '</ul>';
									
				$output .= '</div>';
			
				// All position variations
				$output .= '<div class="zn_all_options hidden">';
					
					$output .= json_encode($columns_variations);
									
				$output .= '</div>';
			
			$output .= '</div>';
			
			
			$output .= '<div class="clear"></div>';
			// Positions input
			$output .= '<input class="zn_widgets_positions hidden" data-columns="'.key($saved_widgets_array).'" name="'.$value['id'].'" id="'.$value['id'].'" type="text" value="'. htmlspecialchars ($saved_widgets_display ) .'" />';
		
			
		$output .= '</div>';
		
		

		
		$output .= '</div>';

		return $output;
	}
	
} // END CLASS







?>