<?php
/*--------------------------------------------------------------------------------------------------
	Partners Logos Element
--------------------------------------------------------------------------------------------------*/
 
	function _partners_logos( $options )
	{
	
		
		$element_size = zn_get_size( $options['_sizer'] );
	
		preg_match('|\d+|', $element_size['sizer'] , $new_size);
		$new_size = $new_size[0]-2;
	?>
		<div class="span2 partners_carousel">
		<?php
			if ( !empty ( $options['pl_title'] ) && $options['pl_title_style'] == 'style1' ) {
				echo '<h5 class="title"><span>'.$options['pl_title'].'</span></h5>';
			}
			elseif ( !empty ( $options['pl_title'] ) && $options['pl_title_style'] == 'style2' ) {
				echo '<h4 class="m_title"><span>'.$options['pl_title'].'</span></h4>';
			}
		?>
			<div class="controls">
				<a href="#" class="prev"><span class="icon-chevron-left"></span></a>
				<a href="#" class="next"><span class="icon-chevron-right"></span></a>
			</div>
		</div>
		<div class="span<?php echo $new_size;?> partners_carousel">
			<ul id="partners_carousel" class="fixclear partners_carousel_trigger">
			
				<?php
					if ( !empty ( $options['partners_single'] ) && is_array ( $options['partners_single'] ) ) {
					
						foreach ( $options['partners_single'] as $partner ) {
						
							$link_start = '<a href="#">';
							$link_end = '</a>';
							
							
							
						
							if ( $slide_image = $partner['lp_single_logo'] ) {
							
								
							
								if ( !empty ( $partner['lp_link']['url'] ) ) {
									$link_start = '<a href="'.$partner['lp_link']['url'].'" target="'.$partner['lp_link']['target'].'">';
									$link_end = '</a>';
								}
								
									$saved_alt = '';
									$saved_title = '';

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

											echo '<li>';
												echo $link_start;
													echo '<img src="'.$saved_image.'" '.$saved_alt.' '.$saved_title.'/>';
												echo $link_end;
											echo '</li>';
										}

									}
									else {
										$saved_image = $slide_image;
										echo '<li>';
											echo $link_start;
												echo '<img src="'.$saved_image.'" '.$saved_alt.' '.$saved_title.'/>';
											echo $link_end;
										echo '</li>';
									}

							}

						}

					}
				?>
			
			</ul>
		</div>
	<?php

	$partners_logos = array ( 'zn_partners_logo' =>
			"jQuery(window).load(function(){
			// ** partners carousel
			jQuery('.partners_carousel_trigger').carouFredSel({
				responsive: true,
				scroll: 1,
				auto: false,
				items: {
					width: 250,
					visible: {
						min: 3,
						max: 10
					}
				},
				prev	: {	
					button	: function(){return jQuery(this).closest('.row,.row-fluid').find('.prev');},
					key		: \"left\"
				},
				next	: { 
					button	: function(){return jQuery(this).closest('.row,.row-fluid').find('.next');},
					key		: \"right\"
				}
			});
			// *** end partners carousel
			});");
			
			zn_update_array( $partners_logos );
	
	}
?>