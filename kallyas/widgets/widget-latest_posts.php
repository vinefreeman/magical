<?php

/*--------------------------------------------------------------------------------------------------

	File: widget-latest_posts.php

	Description: This is the file that contains the Latest Posts widget

--------------------------------------------------------------------------------------------------*/

class Zn_Widget_Recent_Posts extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_recent_entries', 'description' => __( "The most recent posts on your site",THEMENAME) );
		parent::__construct('recent-posts', __('Recent Posts',THEMENAME), $widget_ops);
		$this->alt_option_name = 'widget_recent_entries';

		add_action( 'save_post', array(&$this, 'flush_widget_cache') );
		add_action( 'deleted_post', array(&$this, 'flush_widget_cache') );
		add_action( 'switch_theme', array(&$this, 'flush_widget_cache') );
	}

	function widget($args, $instance) {
		$cache = wp_cache_get('widget_recent_posts', 'widget');

		if ( !is_array($cache) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();
		extract($args);

		$title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Posts',THEMENAME) : $instance['title'], $instance, $this->id_base);
		if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
 			$number = 10;

		$r = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) ) );
		if ($r->have_posts()) :
?>
		<?php echo $before_widget; ?>
		<?php echo '<div class=" latest_posts style3">'; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>
		<ul class="posts">
		<?php  while ($r->have_posts()) : $r->the_post(); 
			$excerpt = get_the_excerpt();
			$excerpt = strip_shortcodes($excerpt);
			$excerpt = strip_tags($excerpt);
			$the_str = mb_substr ($excerpt, 0, 47);
			
			$image = '';
			// Create the featured image html
			if ( has_post_thumbnail( get_the_ID() ) ) {
			
				$thumb = get_post_thumbnail_id(get_the_ID()) ;
				$f_image = wp_get_attachment_url($thumb) ;
				if ( !empty ( $f_image ) ) {

					$image = vt_resize( '', $f_image  , 54,54 , true );
					$image = '<a href="'.get_permalink().'" class="hoverBorder pull-left"><img class="shadow" src="'.$image['url'].'" alt=""/></a>';
					
				}

			}

			
		?>
		<li class="post"><?php echo $image;?><h4 class="title"><a href="<?php the_permalink() ?>" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?></a></h4><div class="text"><?php echo $the_str.'...';?></div></li>
		<?php endwhile; ?>
		</ul>
		<?php echo '</div>'; ?>
		<?php echo $after_widget; ?>
<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('widget_recent_posts', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_recent_entries']) )
			delete_option('widget_recent_entries');

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete('widget_recent_posts', 'widget');
	}

	function form( $instance ) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$number = isset($instance['number']) ? absint($instance['number']) : 5;
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:',THEMENAME); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:',THEMENAME); ?></label>
		<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
<?php
	}
}


add_action( 'widgets_init', create_function( '', 'register_widget( "Zn_Widget_Recent_Posts" );' ) );


?>