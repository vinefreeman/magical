<?php
/*--------------------------------------------------------------------------------------------------
	Testimonial ELEMENT
--------------------------------------------------------------------------------------------------*/
 
	function _testimonial_box($options)
	{

		
		$element_size = zn_get_size( $options['_sizer'] );
		
		$style = 'light';
		$align = "left";
		if ( $options['tb_style'] == 'style2' ){
			$style = 'dark';
			$align = "top";
		}
		
		?>
			<div class="<?php echo $element_size['sizer'];?>" >
				<div class="testimonial_box" data-align="<?php echo $align; ?>" data-theme="<?php echo $style; ?>">
				<div class="details">
				<?php
					
					if ( !empty ( $options['tb_author_logo'] ) ) {
						$image = vt_resize( '',$options['tb_author_logo'] ,'60','60', true );
						echo '<img src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" alt="">';
					
					}
					
					if ( !empty ( $options['tb_author'] ) || !empty ( $options['tb_author_com'] ) ) {
						echo '<h6>';
						
						if ( !empty ( $options['tb_author'] ) ) { echo '<strong>'.$options['tb_author'].'</strong>'; }
						if ( !empty ( $options['tb_author_com'] ) ) { echo $options['tb_author_com']; }
						
						echo '</h6>';
					}
					
				?>
				</div>
				<?php
					if ( !empty ( $options['tb_author_quote'] ) ) { echo '<blockquote>'. $options['tb_author_quote'] .'</blockquote>'; }
				?>
				
			</div>
			</div>
		<?php
	}
?>