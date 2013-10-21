<?php
/*--------------------------------------------------------------------------------------------------
	Action BOX TEXT
--------------------------------------------------------------------------------------------------*/
 
	function _action_box_text($options)
	{
		?>
			<div id="action_box" data-arrowpos="center">
				<div class="container">
					<div class="row">
						
						<?php 
							// Title
							if ( !empty ( $options['page_ac_title'] ) ) 
							{ 
								echo '<div class="span12">';
								echo '<h4 class="text">'.do_shortcode($options['page_ac_title']).'</h4>';
								echo '</div>';
							}
							
						?>

					</div>
				</div>
			</div><!-- end action box -->
		<?php
	}
?>