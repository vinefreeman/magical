<?php
/*--------------------------------------------------------------------------------------------------
	Document Header
--------------------------------------------------------------------------------------------------*/
	function _zn_doc_header($options)
	{

		if ( !empty ( $options['hm_header_style'] ) ) { 
			$style = 'uh_'.$options['hm_header_style'];
		} else { 
			$style = '';
		}

		?>
			<div id="page_header" class="<?php echo $style; ?> zn_documentation_page" >
				<div class="bgback"></div>
				
				<div data-images="<?php echo IMAGES_URL; ?>/" id="sparkles"></div>
				<div class="container">
					<div class="row">
						<div class="span12">
							<div class="zn_doc_search">
								<form method="get" id="" action="<?php echo home_url(); ?>">
									<label class="screen-reader-text" for="s"><?php _e("Search for:",THEMENAME); ?></label>
									<input type="text" value="" name="s" id="s" placeholder="<?php _e("Search the Documentation",THEMENAME); ?>">
									<input type="submit" id="searchsubmit" class="btn" value="Search">
									<input type="hidden" name="post_type" value="documentation">
								</form>
							</div>
						</div>
					</div><!-- end row -->
				</div>
				
				<div class="zn_header_bottom_style"></div>
			</div><!-- end page_header -->
		<?php	
	}
?>