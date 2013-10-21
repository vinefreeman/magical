<?php
/*--------------------------------------------------------------------------------------------------
	Documentation
--------------------------------------------------------------------------------------------------*/
	function _zn_documentation($options)
	{

		 $categories = get_terms( 'documentation_category', array(
								 	'orderby'    => 'name',
								 	'order' => 'ASC',
								 	'hide_empty' => 0,
								 	'show_count ' => 1
								 ) );
		$limit = '6';
		if ( !empty($options['doc_num_items']) ) {
			$limit = $options['doc_num_items'];
		}

		$count = count( $categories );
		$i = 1;

		foreach ($categories as $category) {

			if ( $i % 2 == 1 ){
				echo '<div class="row-fluid zn_photo_gallery">';
			}

			echo '<div class="span6">';
				echo '<h3><a href="'.get_term_link( $category->slug, 'documentation_category' ).'">'.$category->name.' ('.$category->count.')</a></h3>';

				$args = array(
					'post_type'     => 'documentation',
					'post_status'   => 'publish',
					'posts_per_page' => $limit,
					'documentation_category'	=> $category->slug
				);

				$zn_doc = new WP_Query( $args );

				echo '<ol>';

					while( $zn_doc->have_posts() ): $zn_doc->the_post();

					global $post;

						echo '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';

					endwhile; // end loop

				echo "</ol>";

			echo '</div>';

			if ( $i % 2 == 0 || $i == $count ){
				echo '</div>';
			}

			$i++;

		}
	}
?>