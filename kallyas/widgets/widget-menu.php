<?php
/**
 * Navigation Menu widget class
 *
 * @since 3.0.0
 */
 class ZN_Nav_Menu_Widget extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'description' => __('Use this widget to add one of your custom menus as a widget.This widget will dysplay two menu items on a row.',THEMENAME) );
		parent::__construct( 'sbs_nav_menu', __('['.THEMENAME.'] Side by side Menu',THEMENAME), $widget_ops );
	}

	function widget($args, $instance) {
		// Get menu
		$nav_menu = ! empty( $instance['sbs_nav_menu'] ) ? $instance['sbs_nav_menu'] : false;



		if ( !$nav_menu )
			return;

		$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		echo $args['before_widget'];

		if ( !empty($instance['title']) )
			echo $args['before_title'] . $instance['title'] . $args['after_title'];
			
		echo '<div class="zn_sbs">';
		
		//wp_nav_menu( array( 'fallback_cb' => '', 'menu' => $nav_menu ) );

		cache_wp_nav_menu( $nav_menu,array( 
								'menu' => $nav_menu,
								'fallback_cb' => '',
								'echo' => true)
							);

		echo '</div>';
		
		echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
		$instance['title'] = strip_tags( stripslashes($new_instance['title']) );
		$instance['sbs_nav_menu'] = (int) $new_instance['sbs_nav_menu'];
		return $instance;
	}

	function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$nav_menu = isset( $instance['sbs_nav_menu'] ) ? $instance['sbs_nav_menu'] : '';

		// Get menus
		$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );

		// If no menus exists, direct the user to go and create some.
		if ( !$menus ) {
			echo '<p>'. sprintf( __('No menus have been created yet. <a href="%s">Create some</a>.',THEMENAME), admin_url('nav-menus.php') ) .'</p>';
			return;
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:',THEMENAME) ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('sbs_nav_menu'); ?>"><?php _e('Select Menu:',THEMENAME); ?></label>
			<select id="<?php echo $this->get_field_id('sbs_nav_menu'); ?>" name="<?php echo $this->get_field_name('sbs_nav_menu'); ?>">
		<?php
			foreach ( $menus as $menu ) {
				$selected = $nav_menu == $menu->term_id ? ' selected="selected"' : '';
				echo '<option'. $selected .' value="'. $menu->term_id .'">'. $menu->name .'</option>';
			}
		?>
			</select>
		</p>
		<?php
	}
}


add_action( 'widgets_init', create_function( '', 'register_widget( "ZN_Nav_Menu_Widget" );' ) );

?>