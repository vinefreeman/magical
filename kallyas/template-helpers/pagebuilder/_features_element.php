<?php
/*--------------------------------------------------------------------------------------------------
	FEATURES BOX
--------------------------------------------------------------------------------------------------*/
 
	function _features_element( $options )
	{
	
		
		$element_size = zn_get_size( $options['_sizer'] );
	
		echo '<div class="'.$element_size['sizer'].'">';	
	
		if ( $options['fb_style'] == 'style2' )  {
		
			echo '<div class="row noMargin">';
				// TITLE
				if ( !empty( $options['fb_title'] ) ) {
					echo '<div class="'.$element_size['sizer'].'">';
						echo '<h4 class="smallm_title"><span>'.$options['fb_title'].'</span></h4>';
					echo '</div>';
				}
				
				// SECONDARY TITLE AND CONTENT
				if ( !empty ( $options['fb_stitle'] ) || !empty ( $options['fb_desc'] )){
					echo '<div class="span3">';
						if ( !empty ( $options['fb_stitle'] ) ) { echo '<p><strong>'.$options['fb_stitle'].'</strong></p>';}
						if ( !empty ( $options['fb_desc'] ) ) { echo '<p><em>'.$options['fb_desc'].'</em></p>';}
						
					echo '</div>';
				}
				
				// FEATURES
				if ( isset ( $options['features_single'] ) && is_array ( $options['features_single'] ) ) {
				
				
				
					foreach ( $options['features_single'] as $feature ) {
					
					$image = '';
					
						echo '<div class="span3 feature_box default_style">';
							echo '<div class="box">';
								if ( !empty ( $feature['fb_single_icon'] ) ) {
									$image = '<img src="'.$feature['fb_single_icon'].'" alt="">';
								}
								
								if ( !empty ( $feature['fb_single_title'] ) ) {
									echo '<h4 class="title">'.$image.''.$feature['fb_single_title'].'</h4>';
								}
								
								if ( !empty ( $feature['fb_single_desc'] ) ) {
									echo '<p>'.$feature['fb_single_desc'].'</p>';
								}
								
							echo '</div>';
						echo '</div>';
					}
				
				}
			
			echo '</div>';
		}
		elseif ( $options['fb_style'] == 'style1' ) {
		
			echo '<div class="row noMargin">';
			
				if ( !empty( $options['fb_title'] ) ) {
					echo '<div class="'.$element_size['sizer'].'">';
						echo '<h4 class="smallm_title centered bigger"><span>'.$options['fb_title'].'</span></h4>';
					echo '</div>';
				}
			
				// SECONDARY TITLE AND CONTENT
				if ( !empty ( $options['fb_stitle'] ) || !empty ( $options['fb_desc'] )){
					echo '<div class="span3">';
						if ( !empty ( $options['fb_stitle'] ) ) { echo '<p><strong>'.$options['fb_stitle'].'</strong></p>';}
						if ( !empty ( $options['fb_desc'] ) ) { echo '<p><em>'.$options['fb_desc'].'</em></p>';}
						
					echo '</div>';
				}
			
				if ( isset ( $options['features_single'] ) && is_array ( $options['features_single'] ) ) {
					foreach ( $options['features_single'] as $feature ) {
						echo '<div class="span3 feature_box style2">';
							echo '<div class="box">';
								if ( !empty ( $feature['fb_single_icon'] ) ) {
									echo '<span class="icon"><img src="'.$feature['fb_single_icon'].'" alt=""></span>';
								}
								
								if ( !empty ( $feature['fb_single_title'] ) ) {
									echo '<h4 class="title">'.$feature['fb_single_title'].'</h4>';
								}
								
								if ( !empty ( $feature['fb_single_desc'] ) ) {
									echo '<p>'.$feature['fb_single_desc'].'</p>';
								}
								
							echo '</div>';
						echo '</div>';
					}
				}
			echo '</div>';
			
		}
		elseif ( $options['fb_style'] == 'style3' ) {
			echo '<div class="row noMargin">';
				// TITLE
				if ( !empty( $options['fb_title'] ) ) {
					echo '<div class="'.$element_size['sizer'].'">';
						echo '<h3 class="m_title">'.$options['fb_title'].'</h3>';
					echo '</div>';
				}
				
				// SECONDARY TITLE AND CONTENT
				if ( !empty ( $options['fb_stitle'] ) || !empty ( $options['fb_desc'] )){
					echo '<div class="span3">';
						if ( !empty ( $options['fb_stitle'] ) ) { echo '<p><strong>'.$options['fb_stitle'].'</strong></p>';}
						if ( !empty ( $options['fb_desc'] ) ) { echo '<p><em>'.$options['fb_desc'].'</em></p>';}
						
					echo '</div>';
				}
				
				// FEATURES
				if ( isset ( $options['features_single'] ) && is_array ( $options['features_single'] ) ) {
				
				
				
					foreach ( $options['features_single'] as $feature ) {
					
					$image = '';
					
						echo '<div class="span3 feature_box default_style">';
							echo '<div class="box">';
								if ( !empty ( $feature['fb_single_icon'] ) ) {
									$image = '<img src="'.$feature['fb_single_icon'].'" alt="">';
								}
								
								if ( !empty ( $feature['fb_single_title'] ) ) {
									echo '<h4 class="title">'.$image.''.$feature['fb_single_title'].'</h4>';
								}
								
								if ( !empty ( $feature['fb_single_desc'] ) ) {
									echo '<p>'.$feature['fb_single_desc'].'</p>';
								}
								
							echo '</div>';
						echo '</div>';
					}
				
				}
			
			echo '</div>';
		}
		echo '</div>';
	}
?>