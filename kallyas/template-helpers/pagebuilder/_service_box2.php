<?php
/*--------------------------------------------------------------------------------------------------
	Services Element
--------------------------------------------------------------------------------------------------*/

	function _service_box2( $options )
	{ 
	
		echo '<div class="span12">';
		echo '<div class="row-fluid no-space services_box style2">';
		
			if ( !empty ( $options['single_service_elem'] ) && is_array ( $options['single_service_elem'] ) ) {
				
				foreach ( $options['single_service_elem'] as $sb ) {
					
					echo '<div class="span4">';
					echo '<div class="box fixclear">';
					
						// TITLE ICON
						if ( !empty ( $sb['sbe_image'] ) ) {
							echo '<div class="icon"><img src="'.$sb['sbe_image'].'" alt=""></div>';
						}
						
						// TITLE 
						if ( !empty ( $sb['sbe_title'] ) ) {
							echo '<h4 class="title">'.$sb['sbe_title'].'</h4>';
						}
						
						// Services list 
						if ( !empty ( $sb['sbe_services'] ) ) {
						
							echo '<ul class="list">';
						
							$textAr = explode("\n", $sb['sbe_services'] );
							foreach ($textAr as $index=>$line) {
								echo '<li>'.$line.'</li>';
							} 
							
							echo '</ul>';
						}

						// Content 
						if ( !empty ( $sb['sbe_content'] ) ) {
							echo '<div class="text">'.$sb['sbe_content'].'</div>';
						}
					
					
					echo '</div><!-- end box -->';
					echo '</div>';
					
				}
				
			}
		
		echo '</div><!-- end row // services_box -->';
		echo '</div>';
	
	
	?>

			<script type="text/javascript">
				(function($){
					$(".services_box.style2 .box").hover(function() {
						var _t = $(this),
							lis = _t.find('li');
						_t.find('.text').stop().hide();
						lis.stop().css({ opacity: 0, marginTop:10});
						_t.find('.list').stop().show();
						lis.each(function(i) {
							duration = i * 50 + 250;
							delay = i * 250;
							$(this).delay(delay).stop().animate({opacity: 1, marginTop:0}, {queue: false, duration:duration, easing:"easeOutExpo"});
						});
					},function() {
						var _t = $(this);
						_t.find('.text').stop().show();
						_t.find('.list').stop().hide();
					});	
				})(jQuery);
			</script>
		
	
	<?php
	}
?>