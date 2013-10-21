<?php

// Submit form
function submit_form( $options ) {

}


// Text field
function text ( $field ) {

	$required = '';
	$req = '';
	$email_field = '';
	
	if ( $field['zn_cf_required'] ) {
	
		$required = 'zn_required_field';
		
		if (check_field ( $field['zn_cf_name'] ) ) {
			
			$req = 'error';
		}
		
	}
	
	if ( $field['zn_cf_f_email'] ) {
		$email_field = 'zn_email_field';
	}

	$field_name = preg_replace('~[\W\s]~', '_', $field['zn_cf_name']);
	
	 
	echo '<div class="control-group '.$req.'">';
		echo '<label class="control-label" for="'.$field_name.'">'.$field['zn_cf_name'].'</label>';
		echo '<div class="controls">';
			echo '<input id="'.$field_name.'" type="text" name="'.$field_name.'" placeholder="'.$field['zn_cf_name'].'" class="input-xlarge '.$required.' '.$email_field.'" title="'.$field['zn_cf_name'].'" />';
		echo '</div>';
	echo '</div><!-- end control group -->';
}

// Text field
function captcha ( $field ) {

	global $data;

	if( empty( $data['rec_pub_key'] ) || empty( $data['rec_priv_key'] ) ){
		echo __('Please enter the reCaptcha public and private keys inside the admin panel!',THEMENAME);
		return;
	}	

	echo '<div class="control-group">';
		echo '<label class="control-label">'.$field['zn_cf_name'].'</label>';
		echo '<div class="controls">';

			?>

				<script type="text/javascript">
				var RecaptchaOptions = {
				theme : '<?php echo $data['rec_theme']; ?>'
				};
				</script>
			  <script type="text/javascript"
			     src="http://www.google.com/recaptcha/api/challenge?k=<?php echo $data['rec_pub_key']; ?>">
			  </script>
			  <noscript>
			     <iframe src="http://www.google.com/recaptcha/api/noscript?k=<?php echo $data['rec_pub_key']; ?>"
			         height="300" width="500" frameborder="0"></iframe><br>
			     <textarea name="recaptcha_challenge_field" rows="3" cols="40">
			     </textarea>
			     <input type="hidden" name="recaptcha_response_field"
			         value="manual_challenge">
			  </noscript>
			<?php
		echo '</div>';
	echo '</div><!-- end control group -->';

}

// Textarea field
function textarea ( $field ) {


	$required = '';
	$req = '';
	$email_field = '';

	if ( $field['zn_cf_required'] ) {
	
		$required = 'zn_required_field';
		
		if (check_field ( $field['zn_cf_name'] ) ) {
			
			$req = 'error';
		}
		
	}
	
	
	if ( $field['zn_cf_f_email'] == 'yes' ) {
		$email_field = 'zn_email_field';
	}

	$field_name = preg_replace('~[\W\s]~', '_', $field['zn_cf_name']);
	
	echo '<div class="control-group '.$req.'">';
		echo '<label class="control-label" for="'.$field_name.'">'.$field['zn_cf_name'].'</label>';
		echo '<div class="controls">';
			echo '<textarea id="'.$field_name.'" name="'.$field_name.'" placeholder="'.$field['zn_cf_name'].'" class=" textarea zn_cf_textarea '.$required.' '.$email_field.'" title="'.$field['zn_cf_name'].'" ></textarea> ';
		echo '</div>';
	echo '</div><!-- end control group -->';
}

function check_field ( $field ) {

	if ( isset ($_POST['cform_submit']) ) {
		if ( isset ($_POST[$field]) && !empty ( $_POST[$field] ) ) {
			return false;
		}
		else {
			return true;
		}
	}
	
}

$element_size = zn_get_size( $options['_sizer'] );
?>
 

		<div class="<?php echo $element_size['sizer']; ?>">
						
			<?php if ( isset ( $options['zn_cf_desc'] ) && !empty ( $options['zn_cf_desc'] ) ) {
				echo '<p>'.do_shortcode($options['zn_cf_desc']).'</p>';
			}?>
			
			<div id="contact_form" class="rapid_contact ">
			
			<form  method="post" class="cf_validate form-horizontal zn_form">
				<div id="success"></div>
					<?php submit_form($options);?>
					<?php 
						if ( isset ( $options['zn_cf_fields'] ) ) {
							foreach ( $options['zn_cf_fields'] as $field ) {
								if (  function_exists( $field['zn_cf_type'] ) ) {

										$field['zn_cf_type']($field);

								}
							}
						}
					?>
				
					<input type="hidden" name="cform_submit" value="cf_submitted" />
					
						<div class="control-group">
							<div class="controls">
								<input class=" btn " id="submit-form" type="submit" name="submit" value="<?php echo $options['zn_cf_button_value'];?>" />
							</div>
						</div><!-- end control group -->

				</ul>
			</form> 

			</div>
			
		</div>
		
<?php  ?>