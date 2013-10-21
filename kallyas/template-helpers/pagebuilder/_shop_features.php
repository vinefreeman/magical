<?php
/*--------------------------------------------------------------------------------------------------
	Limited Offers
--------------------------------------------------------------------------------------------------*/
	function _shop_features( $options )
	{
		
	?>

		<div class="span12">
			<div class="row shop-features">
			
				<?php
					if ( !empty ( $options['sf_title'] ) ) {
						echo '<div class="span3">';
							echo '<h3 class="title">'.$options['sf_title'].'</h3>';
						echo '</div>';
					}
					
					if ( isset ( $options['sf_single'] ) && is_array ( $options['sf_single'] ) ) {
						
						foreach ( $options['sf_single'] as $single ) {
							
							echo '<div class="span3">';
								$link_start = '';
								$link_end = '';
							
							if ( !empty ( $single['lp_link']['url'] ) ) {
								$link_start = '<a href="'.$single['lp_link']['url'].'" target="'.$single['lp_link']['target'].'">';
								$link_end = '</a>';
							}
							
								echo $link_start;
								echo '<div class="shop-feature">';
								
									if ( !empty ( $single['lp_single_logo'] ) ) {
										echo '<img src="'.$single['lp_single_logo'].'" alt="">';
									}
								
									if ( !empty ( $single['lp_single_line1'] ) ) {
										echo '<h4>'.$single['lp_single_line1'].'</h4>';
									}
								
									if ( !empty ( $single['lp_single_line2'] ) ) {
										echo '<h5>'.$single['lp_single_line2'].'</h5>';
									}
								
								echo '</div><!-- end shop feature -->';
								echo $link_end;
								
							echo '</div>';
							
						}
						
					}
					
				?>
			

			</div>
		</div>

	<?php
	}
?>