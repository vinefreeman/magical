<?php
/*--------------------------------------------------------------------------------------------------
	CONTACT FORM ELEMENT
--------------------------------------------------------------------------------------------------*/
	function _c_form($options)
	{	 
		require_once(TEMPLATEPATH . '/template-helpers/contact_form.php');

		$contact_form = array ( 'zn_contact_form' =>
				"
				(function($){
					$(document).ready(function() {
						$('#submit-form').click(function(e){
						
							var form = $(this).closest('.zn_form');
							var success = $('#success',form);
							var has_error = false;
							
							e.preventDefault();
							var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
							
							$('input.zn_required_field, textarea.zn_required_field',form).each(function(){
							
								if ( $(this).val().length == 0 ) {
									$(this).closest('.control-group').addClass('error');
									has_error = true;
								}

								else if( $(this).hasClass( 'zn_email_field' ) && reg.test($(this).val()) == false ) {

										$(this).closest('.control-group').addClass('error');
										
									has_error = true;
								}
								else {
									$(this).closest('.control-group').removeClass('error');
								}
								
							});
							
							if (has_error) {
								return false;
							}
							
							$.ajax({
								type: 'POST',
								url: location.href,
								data: $(form).serialize(),
								success: function(msg){
									
									if (msg == 'sent'){
										if (typeof Recaptcha != 'undefined' ) {
											Recaptcha.reload();
										}
										
										success.html('<div class=\"alert alert-success\">".htmlspecialchars(__('Message successfully sent!',THEMENAME),ENT_QUOTES)."</div>')  ;
										$('input:not(#submit-form), textarea',form).val('')
										
									}
									else if ( msg == 'mail_not_sent' ){
										success.html('<div class=\"alert alert-error\">".htmlspecialchars(__('Message not sent! Please Try Again!',THEMENAME),ENT_QUOTES)."</div>');
									}
									else{
										if (typeof Recaptcha != 'undefined' ) {
											Recaptcha.reload();
										}
										success.html('<div class=\"alert alert-error\">'+msg+'</div>');
									}
								}
							});

							
							
						});
					});
				})(jQuery);
");
				
		zn_update_array( $contact_form );
		
	}
?>