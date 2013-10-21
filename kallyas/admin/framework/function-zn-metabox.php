<?php

class zn_metabox {

// Contains the meta types/pages/options
 var $meta_types ;
 var $meta_elements;
 var $html;
 var $post_meta;
 
 var $meta_fields;

	function zn_metabox (){
	
		global $zn_meta_types,$zn_meta_elements;

		include_once(locate_template(array('admin/options/zn-meta-boxes.php'), false));
	
		$this->meta_types = $zn_meta_types;
		$this->meta_elements = $zn_meta_elements;
		$this->html = new zn_html();
		
		add_action('add_meta_boxes', array(&$this, 'zn_init_options'));
		add_action('save_post', array(&$this, 'zn_save_options'));
		
	}


	function zn_init_options ()
	{

		foreach($this->meta_types as $key=>$type) 
		{
			foreach ($type['page'] as $page ) 
			{
				
				add_meta_box( 
					$type['id'],
					$type['title'],
					array($this,'zn_render_meta_box'),
					$page,
					$type['context'],
					$type['priority'],	
					array('what_box'=>$type)
				);
			}
		}

	}
	
	
	/*****************************************************************
	* 
	*	Render Function
	*
	*****************************************************************/
	function zn_render_meta_box ( $post , $metabox ) 
	{
		// Get the current metabox
		$zn_metabox = $metabox['args']['what_box'];
		// Get saved values in meta
		$meta_fields = get_post_meta($post->ID, 'zn_meta_elements', true);
		$meta_fields = maybe_unserialize( $meta_fields );
		

	
		$output = '';
		$output .= '<input type="hidden" id="security" name="security" value="'.wp_create_nonce('zn_ajax_nonce').'" />';
		
		
		
		foreach($this->meta_elements as $element) 
		{
				

		if( !isset ( $element['link_to'] ) ) { $element['link_to'] = '';}
		
			if( $element['link_to'] == $zn_metabox['id']) 
			{
			
					// Print the HTML if function exists 
					// Added isset ... Needs to be fully checked
					if ( method_exists( $this->html, $element['type'] ) && !isset($element['subelements']) )
					{	
						
						//replace default values
						if ( $element['type'] == 'zn_dynamic_list' ) {
						
						
						
							$values = array();
								foreach ( $element['options'] as $area_id => $area )
								{
								
									if ( isset ( $meta_fields[$area_id] ) ) {
									
											$values = array_merge ( $meta_fields[$area_id] , $values);
										
									}
								}
								
								$element['std'] = $values;
								
							$output .= '<div class="zn_meta_box zn_meta_box'.$element['type'].' meta_box_'.$zn_metabox['context'].'">';
							

								$output .= $this->html->zn_render_element($element);
							
							$output .= '</div>';
								
								
						}
						elseif(isset($meta_fields[$element['id']]))
						{
							$element['std'] = $meta_fields[$element['id']];
							
							$output .= '<div class="zn_meta_box zn_meta_box_'.$element['type'].' meta_box_'.$zn_metabox['context'].'">';
							

								$output .= $this->html->zn_render_element($element);
							
							$output .= '</div>';
							
						}
						else {
							$output .= '<div class="zn_meta_box zn_meta_box_'.$element['type'].' meta_box_'.$zn_metabox['context'].'">';
							

								$output .= $this->html->zn_render_element($element);
							
							$output .= '</div>';
						}
											


					}elseif ( method_exists( $this->html, $element['type'] ) && isset($element['subelements']) ) {
						if(isset($meta_fields[$element['id']]))
						{
							$element['std'] = $meta_fields[$element['id']];
							$output .= '<div class="zn_meta_box zn_meta_box_'.$element['type'].' meta_box_'.$zn_metabox['context'].'">';
							

								$output .= $this->html->zn_render_element($element);
							
							$output .= '</div>';
						}
						else {
							$output .= '<div class="zn_meta_box zn_meta_box_'.$element['type'].' meta_box_'.$zn_metabox['context'].'">';
							

								$output .= $this->html->zn_render_element($element);
							
							$output .= '</div>';
						}
					}
			}
		}
	
	
		echo $output;

	}
	
	/*****************************************************************
	* 
	*	Save Function
	*
	*****************************************************************/
	function zn_save_options( $post_id ) {
		
		if(isset($_POST['post_ID'])) 
		{
			// verify if this is an auto save routine. 
			// If it is our form has not been submitted, so we dont want to do anything
			if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;  
			
			// Verify Nonce key + Don't Break other post types
			if ( isset ( $_POST['security'] ) ) {
				$nonce=$_POST['security'];
				if (! wp_verify_nonce($nonce, 'zn_ajax_nonce') ) return; 
			}
			else {
				return;
			}
			// Check permissions
			if ( 'page' == $_POST['post_type'] ) 
			{
			if ( !current_user_can( 'edit_page', $post_id ) )
				return;
			}
			else
			{
			if ( !current_user_can( 'edit_post', $post_id ) )
				return;
			}
			
			// Create array of values to save
			$values_to_save = array();
			
			
			// Loop to check what elements needs to be saved on this page
			foreach($this->meta_elements as $element) 
			{
				
				if ( $element['type'] == 'zn_dynamic_list' ) {
					foreach ( $element['options'] as $area_id => $area )
					{
						if ( isset ( $_POST[$area_id] ) ) {
						
								$values_to_save[$area_id] = $_POST[$area_id];
							
						}
					}
				}elseif ( isset ( $_POST[$element['id']] ) ) {
				
						$values_to_save[$element['id']] = $_POST[$element['id']];
					
				}
				
				/*
				foreach($_POST as $key=>$value)
				{
				
					if(strpos($key, $element['id']) !== false)
					{
						$values_to_save[$key] = $value;
					}

					
					
				}*/
				
				
				
			}
			//$values_to_save = serialize($values_to_save);
			
/*
				echo '<pre>';
				print_r($values_to_save);
				echo '<pre>';
				//break;
		*/
			
			
			// Save them already :)
			update_post_meta($post_id, 'zn_meta_elements', $values_to_save);

		}	
		
	}

}

?>