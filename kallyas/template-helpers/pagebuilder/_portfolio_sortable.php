<?php
/*--------------------------------------------------------------------------------------------------
	Portfolio Sortable
--------------------------------------------------------------------------------------------------*/
 
	function _portfolio_sortable( $options )
	{
	
		
		$element_size = zn_get_size( $options['_sizer'] );
	
		
		global $post,$data;

		
		$posts_per_page = isset($options['ports_per_page']) ? $options['ports_per_page'] : '4'; // how many posts

		$query = array(
			'post_type' => 'portfolio',
			'tax_query' => array(
				array(
					'taxonomy' => 'project_category',
					'field' => 'id',
					'terms' =>  $options['portfolio_categories']
				)
			),
			'posts_per_page' =>  $posts_per_page,
		);

		// Start the query
		query_posts( $query );
		
			include(locate_template( 'template-helpers/loop-portfolio_sortable.php'));
				
		$zn_isotope = array ( 'zn_isotope' =>
				"
				(function($){ 
					$(window).load(function(){
						
						// settings
						var sortBy = '', 			// SORTING: date / name
							sortAscending = true, 		// SORTING ORDER: true = Ascending / false = Descending
							theFilter = '';	// DEFAULT FILTERING CATEGORY 
							
						$('#sortBy li a').each(function(index, element) {
							var t = $(this);
							if(t.attr('data-option-value') == sortBy)
								t.addClass('selected');
						});
						$('#sort-direction li a').each(function(index, element) {
							var t = $(this);
							if(t.attr('data-option-value') == sortAscending.toString())
								t.addClass('selected');
						});
						$('#portfolio-nav li a').each(function(index, element) {
							var t = $(this),
								tpar = t.parent();
							if(t.attr('data-filter') == theFilter) {
								$('#portfolio-nav li a').parent().removeClass('current');
								tpar.addClass('current');
							}
						});
								
						// don't edit below unless you know what you're doing
						if ($(\"ul#thumbs\").length > 0){
							var container = $(\"ul#thumbs\");
							container.isotope({
							  itemSelector : \".item\",
							  animationEngine : \"jquery\",
							  animationOptions: {
								  duration: 250,
								  easing: \"easeOutExpo\",
								  queue: false
							  },
							  filter: theFilter,
							  sortAscending : sortAscending,
							  getSortData : {
								  name : function ( elem ) {
									  return elem.find(\"span.name\").text();
								  },
								  date : function ( elem ) {
									  return elem.attr(\"data-date\");
								  }
							  },
							  sortBy: sortBy
							});
							
						}
					});
				})(jQuery);
				");
				
				zn_update_array( $zn_isotope );
	}	
?>