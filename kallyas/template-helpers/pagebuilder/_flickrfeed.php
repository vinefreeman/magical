<?php
/*--------------------------------------------------------------------------------------------------
	Flickr Feed
--------------------------------------------------------------------------------------------------*/
 
	function _flickrfeed($options)
	{
		
		$element_size = zn_get_size( $options['_sizer'] );

		if ( !empty ( $options['ff_images'] ) ) {
			$images_tl = $options['ff_images'];
		}
		else {
			$images_tl = 8;
		}
		
		$image_size = '';
		if ( $options['ff_image_size'] == 'small' ) {
			$image_size = 'data-size="small"';
		}
		
		echo '<div class="'.$element_size['sizer'] .'">';
		echo '<div class="flickrfeed">';
		echo '<h3 class="m_title">'.$options['ff_title'].'</h3>';
		echo '<ul class="flickr_feeds fixclear" data-limit="'.$images_tl.'" '.$image_size.'></ul>';
		echo '</div><!-- end // flickrfeed -->';
		echo '</div>';

		if ( !empty ( $options['ff_id'] ) ) {

			$flickr = array ( 'zn_flickr_feed' =>
					"
					(function($){
					jQuery(window).load(function() {
						// load flicker photos
						
						var ff_container = jQuery('.flickr_feeds'),
							ff_limit = (ff_container.attr('data-limit')) ?  ff_container.attr('data-limit') : 6;
							
						ff_container.parent().removeClass('loading');
							// ff_limit = if data-limit attribute is set, the limit is user defined, if not, default is 6 
						
						ff_container.jflickrfeed({
							limit: ff_limit,
							qstrings: {
								id: '".$options['ff_id']."'
							},
							itemTemplate: '<li><a href=\"{{image_b}}\" data-rel=\"prettyPhoto\"><img src=\"{{image_s}}\" alt=\"{{title}}\" /><span class=\"theHoverBorder \"></span></a></li>'
						}, function(data) {
							jQuery(\".flickr_feeds a[data-rel^='prettyPhoto']\").prettyPhoto({theme:'pp_kalypso',social_tools:false, deeplinking:false});
							//jQuery(\".flickr_feeds li:nth-child(3n)\").addClass(\"last\");
						});
						
					});
					})(jQuery);
				");
					
			zn_update_array( $flickr );
			
		}

	}
?>