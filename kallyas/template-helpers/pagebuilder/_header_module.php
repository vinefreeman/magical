<?php
/*--------------------------------------------------------------------------------------------------
	Custom Header Layout
--------------------------------------------------------------------------------------------------*/
	function _header_module($options)
	{
		global $meta_fields;			$height='';
	
		if ( !empty ( $options['hm_header_style'] ) && $options['hm_header_style'] != 'zn_def_header_style'  ) { 
			$style = 'uh_'.$options['hm_header_style'];
		} elseif( !empty ( $options['hm_header_style'] ) && $options['hm_header_style'] == 'zn_def_header_style' ){
			$style = 'zn_def_header_style';
		} 
		else { 
			$style = '';
		}
		if ( !empty ( $options['hm_header_height'] ) ) {			$height='style="height:'.$options['hm_header_height'].'px;min-height:'.$options['hm_header_height'].'px""';		}

	?>
		<div id="page_header" class="<?php echo $style; ?> bottom-shadow" <?php echo $height;?>>
			<div class="bgback"></div>
			
			<div data-images="<?php echo IMAGES_URL; ?>/" id="sparkles"></div>
			
			
			
			<div class="container">
				<div class="row">
					<div class="span6">
					
						<?php 
						
							// Breadcrumbs check
							if ( isset ( $options['hm_header_bread'] ) && !empty ( $options['hm_header_bread'] ) ) {
								zn_breadcrumbs();
							}
							
							// Date check
							if ( isset ( $options['hm_header_date'] ) && !empty ( $options['hm_header_date'] ) ) {
								echo '<span id="current-date">'.date_i18n(get_option('date_format') ,strtotime(date("l M d, Y"))).'</span>';
							}
							
						?>
						
					</div>
					<div class="span6">
						<div class="header-titles">
							<?php
							
							// Title check
							if ( isset ( $options['hm_header_title'] ) && !empty ( $options['hm_header_title'] ) ) {
								if ( isset ( $meta_fields['page_title'] ) && !empty ( $meta_fields['page_title'] ) ) {

									echo '<h2>'.do_shortcode( stripslashes( $meta_fields['page_title'] ) ).'</h2>';
							
								}
								else {
									echo '<h2>'.get_the_title($page_id).'</h2>';
								}
							}

							?> 
							<?php
							
							// Subtitle check
							if ( isset ( $options['hm_header_subtitle'] ) && !empty ( $options['hm_header_subtitle'] ) ) {
								if ( isset ( $meta_fields['page_subtitle'] ) && !empty ( $meta_fields['page_subtitle'] ) ) {

									echo '<h4>'.do_shortcode( stripslashes( $meta_fields['page_subtitle'] ) ).'</h4>';
									
								}
							}

							?>

						</div>
					</div>
				</div><!-- end row -->
			</div>
			
			<div class="zn_header_bottom_style"></div>
		</div><!-- end page_header -->
	<?php	
	}
?>