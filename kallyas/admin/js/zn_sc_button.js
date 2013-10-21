// JavaScript Document
(function() {
    tinymce.create('tinymce.plugins.zn_button', {
        init : function(ed, url) {
            ed.addButton('zn_button', {
                title : 'Shortcodes',
                image : url+'/zn_button.png',
                onclick : function() {
				
					
				
				
				
					modal = jQuery('.zn_sc_dialog').clone().html();

					jQuery('body').prepend('<div class="zn_mask"></div>');

					//Get the screen height and width
					var maskHeight = jQuery(document).height();
					var maskWidth = jQuery(window).width();

					//Set height and width to mask to fill up the whole screen
					jQuery('.zn_mask').css({'width':maskWidth,'height':maskHeight});
					 
					//transition effect    
					jQuery('.zn_mask').fadeTo("slow",0.8);  
							
					jQuery('body').prepend('<div class="zn_modal_container"><div class="zn_modal_header"><span class="zn_close_modal">x</span></div></div>');
					//jQuery('.zn_modal_container').append(modal);
					jQuery(modal).appendTo('.zn_modal_container');

					//Get the window height and width
					var winH = jQuery(window).height();
					var winW = jQuery(window).width();
						   
					//Set the popup window to center
					jQuery('.zn_modal_container').css('top',  winH/2-jQuery('.zn_modal_container').height()/2);
					jQuery('.zn_modal_container').css('left', winW/2-jQuery('.zn_modal_container').width()/2);
		
					jQuery('.zn_sc_title').click( function(){
						
						var sc = jQuery(this).next('.zn_shortcode_text').html();
						//alert(sc);

						
						ed.selection.setContent(sc);
						var sc = '';
						// Close the modal and remove it from DOM
						jQuery('.zn_mask').detach();
						jQuery('.zn_modal_container').detach();
					});
 
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('zn_button', tinymce.plugins.zn_button);
	
	
	
})();