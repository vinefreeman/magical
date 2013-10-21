jQuery.noConflict();
	jQuery(document).ready(function($){
	
	//hide hidden section on page load.
	jQuery('#section-body_bg, #section-body_bg_custom, #section-body_bg_properties').hide();
	

	//hides warning if js is enabled			
	$('#js-warning').hide();
	
	/* save everything */
	$(document).on('click','.zn_save',function() {
			
		var nonce = $('#security').val();
					
		$('.ajax-loading-img').fadeIn();
										
		var serializedReturn = $('#zn_form :input[name][name!="security"][name!="of_reset"]').serialize();
										
		//alert(serializedReturn);
						
		var data = {
			type: 'save',
			action: 'zn_ajax_post_action',
			security: nonce,
			data: serializedReturn
		};
					
		$.post(ajaxurl, data, function(response) {
			var success = $('.zn-save-popup');
			var fail = $('.zn-fail-popup');
			var loading = $('.ajax-loading-img');
			loading.fadeOut();  
						
			if (response==1) {
				success.fadeIn();
			} else { 
				fail.fadeIn();
			}
						
			window.setTimeout(function(){
				success.fadeOut(); 
				fail.fadeOut();
			}, 2000);
		});
			
	return false; 
					
	});   

}); //end doc ready