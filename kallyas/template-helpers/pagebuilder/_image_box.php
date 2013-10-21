<?php
/*--------------------------------------------------------------------------------------------------
	Image Box
--------------------------------------------------------------------------------------------------*/
 
	function _image_box($options)
	{
	
		
		$element_size = zn_get_size( $options['_sizer'] );
	
		$link_start = '<span class="zn_image_box_cont">';
		$link_end = '</span>';
		$image = '';
		$title = '';
		$text = '';
		$link_text = '';
	
		// Title
		if ( !empty ( $options['image_box_title'] ) ) 
		{ 
			$title = '<h3 class="m_title">'.$options['image_box_title'].'</h3>';
		}
	
		// TEXT
		if ( !empty ( $options['image_box_text'] ) ) 
		{ 
			$text = $options['image_box_text'];
		}
		
		// READ MORE TEXT
		if ( !empty ( $options['image_box_link_text'] ) ) 
		{ 
			$link_text = '<h6>'.$options['image_box_link_text'].'</h6>';
		}
		
		// Check to see if we have an image
		if ( $slide_image = $options['image_box_image'] ) {

			$saved_alt = 'alt="'.strip_tags($options['image_box_title']).'"';
			$saved_title = 'title="'.strip_tags($options['image_box_title']).'"';

			if ( is_array($slide_image) ) {


				if ( $saved_image = $slide_image['image'] ) {

					// Image alt
					if ( !empty( $slide_image['alt'] ) ){
						$saved_alt = 'alt="'.$slide_image['alt'].'"';
					}

					// Image title
					if ( !empty( $slide_image['title'] ) ){
						$saved_title = 'title="'.$slide_image['title'].'"';
					}
				}

			}
			else {
				$saved_image = $slide_image;

			}
		}
	
		// STYLE 2 - IMAGE IS ON THE RIGHT
		if ( !empty ( $options['image_box_style'] ) && $options['image_box_style'] == 'style2'  ) 
		{ 
			$zn_style = 'imgboxes_style1 zn_ib_style2';
			
			// IMAGE
			if ( !empty ( $saved_image ) ) {
				$image = vt_resize( '',$saved_image , '220','156', true );
				$image = '<img src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" '.$saved_alt.' '.$saved_title.' />';
			}
			

			if ( !empty($options['image_box_link']['url']) ) {
				$link_start = '<a class="hoverBorder alignright" href="'.$options['image_box_link']['url'].'" target="'.$options['image_box_link']['target'].'">';
				$link_end = '</a>';
			}
			else {
				$link_start = '<span class="zn_image_box_cont alignright">';
				$link_end = '</span>';
			}

			
			echo '<div class="'.$element_size['sizer'].' box image-boxes '.$zn_style.'">';
		
				echo $title;

					echo $link_start;
					
						echo $image;
						
					echo $link_end;

				echo $text;

			echo '</div><!-- end span -->';

		}
		// STYLE 3 - CONTENT IS OVER IMAGE
		elseif ( !empty ( $options['image_box_style'] ) && $options['image_box_style'] == 'style3'  ) {
			$zn_style = 'imgboxes_style2';
			// IMAGE
			if ( !empty ( $saved_image ) ) {
				$image = vt_resize( '',$saved_image , $element_size['width'],'', true );
				$image = '<img src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" '.$saved_alt.' '.$saved_title.' />';
			}
			
			if ( !empty($options['image_box_link']['url']) ) {
				$link_start = '<a class="slidingDetails" href="'.$options['image_box_link']['url'].'" target="'.$options['image_box_link']['target'].'">';
				$link_end = '</a>';
			}
			else {
				$link_start = '<a class="slidingDetails" href="javascript:;" target="'.$options['image_box_link']['target'].'">';
				$link_end = '</a>';
			}

			// Title
			if ( !empty ( $options['image_box_title'] ) ) 
			{ 
				$title = '<h4>'.$options['image_box_title'].'</h4>';
			}
			
			echo '<div class="'.$element_size['sizer'].' box image-boxes '.$zn_style.'">';
		
				echo $link_start;
				
					echo $image;
					
					echo '<div class="details">';
					
						echo $title;
						echo $text;
						
					echo '</div>';
					
				echo $link_end;

			echo '</div><!-- end span -->';

			
		}
		// STYLE 1 - IMAGE WITH READ MORE BUTTON OVER IT
		else {
			$zn_style = 'imgboxes_style1';
			$link_start = '<span>';
			$link_end = '</span>';


			// IMAGE
			if ( !empty ( $saved_image ) ) {
				$image = vt_resize( '',$saved_image , $element_size['width'],'', true );
				$image = '<img src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" '.$saved_alt.' '.$saved_title.' />';
			}
			
			if ( !empty($options['image_box_link']['url']) ) {
				$link_start = '<a class="hoverBorder" href="'.$options['image_box_link']['url'].'" target="'.$options['image_box_link']['target'].'">';
				$link_end = $link_text.'</a>';
			}


			echo '<div class="'.$element_size['sizer'].' box image-boxes '.$zn_style.'">';
		
				echo $link_start;
				
					echo $image;
					
				echo $link_end;

				echo $title;
				echo $text;
				
			echo '</div><!-- end span -->';

		}
	

		

	}
?>