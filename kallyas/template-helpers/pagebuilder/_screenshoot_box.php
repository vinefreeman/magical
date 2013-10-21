<?php
/*--------------------------------------------------------------------------------------------------
	Screenshoots Box
--------------------------------------------------------------------------------------------------*/
 
	function _screenshoot_box( $options )
	{

		?>
		<div class="span12">
			<div class="screenshot-box fixclear">
				<div class="thescreenshot">
					<div class="controls"><a href="#" class="prev"></a><a href="#" class="next"></a></div>
					<ul id="screenshot-carousel" class="fixclear zn_screenshot-carousel">
					<?php
						if ( !empty ( $options['ssb_imag_single'] ) && is_array ( $options['ssb_imag_single'] ) ) {
							foreach ( $options['ssb_imag_single'] as $image ) {
								
								$image = vt_resize( '',$image['ssb_single_screenshoot'] ,'580','328', true );
								echo '<li><img src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" alt=""></li>';
								
							}
						}
					?>

					</ul>
				</div>
				<div class="left-side">
		
					<h3 class="title"><?php echo $options['ssb_title'];?></h3>
					
					<?php
						if ( !empty ( $options['ssb_feat_single'] ) && is_array ( $options['ssb_feat_single'] ) ) {
							
							echo '<ul class="features">';
							
								foreach ( $options['ssb_feat_single'] as $feat ) {
									echo '<li>';
										// FEATURE TITLE
										if ( !empty ( $feat['ssb_single_title'] ) ) {
											echo '<h4>'.$feat['ssb_single_title'].'</h4>';
										}
										// FEATURE DESC
										if ( !empty ( $feat['ssb_single_desc'] ) ) {
											echo '<span>'.$feat['ssb_single_desc'].'</span>';
										}
									
									echo '</li>';
								}
							
							echo '</ul>';
							
						}
						
						// BUTTON LINK
						if ( !empty ( $options['ssb_link_text'] ) && !empty ( $options['ssb_button_link']['url'] ) ) {
							echo '<a href="'.$options['ssb_button_link']['url'].'" target="'.$options['ssb_button_link']['target'].'" class="btn btn-large btn-flat redbtn">'.$options['ssb_link_text'].'</a>';
						}
						
					?>

					
					
					
				</div>
				
			</div><!-- end screenshot-box -->
		</div>
		<?php

		$screenshoot_box = array ( 'zn_screenshoot_box' =>
				"jQuery(window).load(function() {
						// ** Screenshots carousel
						jQuery('.zn_screenshot-carousel').carouFredSel({
							responsive: true,
							scroll: { fx: \"crossfade\", duration: \"1500\" },
							items: {
								width: 580
							},
							auto: true,
							prev	: {	
								button	: function(){return jQuery(this).closest('.thescreenshot').find('.prev');},
								key		: \"left\"
							},
							next	: { 
								button	: function(){return jQuery(this).closest('.thescreenshot').find('.next');},
								key		: \"right\"
							}
						});
						// *** end Screenshots carousel
					
				});");
				
		zn_update_array( $screenshoot_box );
		
	}
?>