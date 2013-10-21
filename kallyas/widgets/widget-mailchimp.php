<?php
/**
 * Navigation Menu widget class
 *
 * @since 3.0.0
 */
 class ZN_Mailchimp_Widget extends WP_Widget {
	var $data = '';
 
	function __construct() {
		$widget_ops = array( 'description' => __('Use this widget to add a mailchimp newsletter to your site.',THEMENAME) );
		parent::__construct( 'zn_mailchimp', __('['.THEMENAME.'] Mailchimp Newsletter',THEMENAME), $widget_ops );
		global $data;
		$this->data = $data;
	}
	
	function widget($args, $instance) {
		
		$data = $this->data;
		$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		if ( isset ( $_POST['zn_mc_email']) ) {
			
			
			if ( isset ( $data['mailchimp_api'] ) && !empty ( $data['mailchimp_api'] ) ) {
			
				if ( !class_exists( 'MCAPI' ) ) {
					include_once (TEMPLATEPATH . '/widgets/mailchimp/MCAPI.class.php');
				}
				
				$api_key = $data['mailchimp_api'];
				
				$mcapi = new MCAPI($api_key);
				
				$merge_vars = Array( 
					'EMAIL' => $_POST['zn_mc_email']
				);
				
				$list_id = $instance['zn_mailchimp_list'];
				
				if($mcapi->listSubscribe($list_id, $_POST['zn_mc_email'], $merge_vars ) ) {
					// It worked!   
					$msg = '<span style="color:green;">'.__('Success!&nbsp; Check your inbox or spam folder for a message containing a confirmation link.',THEMENAME).'</span>';
				}else{
					// An error ocurred, return error message   
					$msg = '<span style="color:red;"><b>'.__('Error:',THEMENAME).'</b>&nbsp; ' . $mcapi->errorMessage.'</span>';
					
				}
				
			}

		}
		
		if (empty($data['mailchimp_api'])){

			echo	'<div class="newsletter-signup">';
			echo '<p>No mailchimp list selected. Please set your mailchimp API key in the theme admin panel and then configure the widget from the widget options.</p>';
			echo	'	</div><!-- end newsletter-signup -->';

			return;
		}
		
		echo $args['before_widget'];

		echo	'<div class="newsletter-signup">';
		
		if ( !empty($instance['title']) )
			echo $args['before_title'] . $instance['title'] . $args['after_title'];

		// GET INTRO TEXT
		if ( ! empty( $instance['zn_mailchimp_intro'] ) ) {
			echo	'<p>'.$instance['zn_mailchimp_intro'].'</p>';
		}

		echo	'		<form method="post" class="newsletter_subscribe newsletter-signup" data-url="'.trailingslashit(home_url()).'" name="newsletter_form">';
		echo	'			<input type="text" name="zn_mc_email" class="nl-email" value="" placeholder="'.__("your.address@email.com",THEMENAME).'" />';
		echo	'			<input type="hidden" name="zn_list_class" class="nl-lid" value="'.$instance['zn_mailchimp_list'].'" />';
		echo	'			<input type="submit" name="submit" class="nl-submit" value="'.__("JOIN US",THEMENAME).'" />';
		echo	'		</form>';
		
		if ( isset ( $msg ) ) {
			echo '<span class="zn_mailchimp_result">'.$msg.'</span>';
		}
		else {
			echo	'		<span class="zn_mailchimp_result"></span>';
		}

		// GET INTRO TEXT
		if ( ! empty( $instance['zn_mailchimp_outro'] ) )	{
			echo	'<p>'.$instance['zn_mailchimp_outro'].'</p>';
		}
			
		echo	'	</div><!-- end newsletter-signup -->';
		echo $args['after_widget'];
		
		//global $data;
		//print_r($data);
	}

	function update( $new_instance, $old_instance ) {
		$instance['title'] = strip_tags( stripslashes($new_instance['title']) );
		$instance['zn_mailchimp_intro'] =  stripslashes($new_instance['zn_mailchimp_intro']) ;
		$instance['zn_mailchimp_outro'] =  stripslashes($new_instance['zn_mailchimp_outro']) ;
		$instance['zn_mailchimp_list'] = $new_instance['zn_mailchimp_list'];
		return $instance;
	}

	function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$zn_mailchimp_intro = isset( $instance['zn_mailchimp_intro'] ) ? $instance['zn_mailchimp_intro'] : '';
		$zn_mailchimp_outro = isset( $instance['zn_mailchimp_outro'] ) ? $instance['zn_mailchimp_outro'] : '';
		$zn_mailchimp_list = isset( $instance['zn_mailchimp_list'] ) ? $instance['zn_mailchimp_list'] : '';
		$data = $this->data;

		if ( !function_exists('curl_init') ) {
			echo __('Curl is not enabled on your hosting environment. Please contact your hosting company and ask them to enable CURL for your account.',THEMENAME);
			return;
		}
		
		if ( !isset ( $data['mailchimp_api'] ) && empty ( $data['mailchimp_api'] ) ) {
			echo __('Please enter your MailChimp API KEY in the theme options pannel prior of using this widget.',THEMENAME);
			return;
		}
		
		
		if ( isset ( $data['mailchimp_api'] ) && !empty ( $data['mailchimp_api'] ) ) {
				if ( !class_exists( 'MCAPI' ) ) {
					include_once (TEMPLATEPATH . '/widgets/mailchimp/MCAPI.class.php');
				}
			$api_key = $data['mailchimp_api'];
			
			$mcapi = new MCAPI($api_key);
			
			$lists = $mcapi->lists();
		}
			
		//print_r($lists);
		
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:',THEMENAME) ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('zn_mailchimp_list'); ?>"><?php _e('Select List:',THEMENAME); ?></label>
			<select id="<?php echo $this->get_field_id('zn_mailchimp_list'); ?>" name="<?php echo $this->get_field_name('zn_mailchimp_list'); ?>">
			
			<?php	
			if ( isset($lists['data']) && is_array($lists['data'])) {
				foreach ($lists['data'] as $key => $value) {
					$selected = (isset($zn_mailchimp_list) && $zn_mailchimp_list == $value['id']) ? ' selected="selected" ' : '';
					?>	
						<option <?php echo $selected; ?>value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
					<?php
				}
			}
			?>
			
			</select>
		</p>
		
		<p>
			<div><label for="<?php echo $this->get_field_id('zn_mailchimp_intro'); ?>"><?php echo __('Intro Text :',THEMENAME); ?></label></div>
			<div><textarea id="<?php echo $this->get_field_id('zn_mailchimp_intro'); ?>" name="<?php echo $this->get_field_name('zn_mailchimp_intro'); ?>" cols="35" rows="5"><?php echo $zn_mailchimp_intro; ?></textarea></div>
		</p>
		<p>
			<div><label for="<?php echo $this->get_field_id('zn_mailchimp_outro'); ?>"><?php echo __('After Form Text :',THEMENAME); ?></label></div>
			<div><textarea id="<?php echo $this->get_field_id('zn_mailchimp_outro'); ?>" name="<?php echo $this->get_field_name('zn_mailchimp_outro'); ?>" cols="35" rows="5"><?php echo $zn_mailchimp_outro; ?></textarea></div>
		</p>

		<?php
	}
}


add_action( 'widgets_init', create_function( '', 'register_widget( "ZN_Mailchimp_Widget" );' ) );


/*--------------------------------------------------------------------------------------------------
	Mailchimp ajax helper
--------------------------------------------------------------------------------------------------*/
		
	function zn_do_action(){
		if ( isset ( $_POST['zn_ajax'] ) ) {
			if (!headers_sent()){ //just in case...
				header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT', true, 200);
			}
			
				if ( isset ( $_POST['zn_mc_email']) ) {
					
					global $data;
										
					if ( isset ( $data['mailchimp_api'] ) && !empty ( $data['mailchimp_api'] ) ) {
					
						include_once (TEMPLATEPATH . '/widgets/mailchimp/MCAPI.class.php');
						$api_key = $data['mailchimp_api'];
						
						$mcapi = new MCAPI($api_key);
						
						$merge_vars = Array( 
							'EMAIL' => $_POST['zn_mc_email']
						);
						
						$list_id = $_POST['zn_mailchimp_list'];
						
						if($mcapi->listSubscribe($list_id, $_POST['zn_mc_email'], $merge_vars ) ) {
							// It worked!   
							$msg = '<span style="color:green;">'.__('Success!&nbsp; Check your inbox or spam folder for a message containing a confirmation link.',THEMENAME).'</span>';
						}else{
							// An error ocurred, return error message   
							$msg = '<span style="color:red;"><b>'.__('Error:',THEMENAME).'</b>&nbsp; ' . $mcapi->errorMessage.'</span>';
							
						}
						
						
					}

				}
			
			echo $msg; // Don't esc_html this, b/c we've already escaped it
			exit;
		}
	}
	
	add_action('init', 'zn_do_action');

?>