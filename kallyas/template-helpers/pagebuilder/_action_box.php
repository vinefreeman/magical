<?php
/*--------------------------------------------------------------------------------------------------
	Action BOX
--------------------------------------------------------------------------------------------------*/
 
	function _action_box($options)
	{
		?>
			<div id="action_box" data-arrowpos="center">
				<div class="container">
					<div class="row">
						
						<?php 
							// Title
							if ( !empty ( $options['page_ac_title'] ) ) 
							{ 
								echo '<div class="span8">';
								echo '<h4 class="text">'.do_shortcode($options['page_ac_title']).'</h4>';
								echo '</div>';
							}
							
							// LINK
							if ( isset ( $options['page_ac_b_link']['url'] ) && !empty ( $options['page_ac_b_link']['url'] ) && !empty ( $options['page_ac_b_text'] ) )
							{
								echo '<div class="span4 align-center">';
								echo '<a class="btn" href="'.$options['page_ac_b_link']['url'].'" target="'.$options['page_ac_b_link']['target'].'">'.$options['page_ac_b_text'].'</a>';
								echo '</div>';
							}
							
						?>

					</div>
				</div>
			</div><!-- end action box -->
		<?php
	}
?>