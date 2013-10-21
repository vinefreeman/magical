/*--------------------------------------------------------------------------------------------------

	File: znscript.js

	Description: This is the main javascript file for this theme
	Plesae be carefull when editing this file

--------------------------------------------------------------------------------------------------*/


;(function($){

	$(document).ready(function(e) {
	
		/* sliding panel toggle (support panel) */
		var sliding_panel = $('#sliding_panel');
		var slider_height = $('#sliding_panel .container').height();
		$('#open_sliding_panel').toggle(function(e){
			e.preventDefault();
			sliding_panel.animate({  height:slider_height }, {duration:100, queue:false, easing:'easeOutQuint'});
			$(this).addClass('active');
		}, function(){
			sliding_panel.animate({  height:0 }, {duration:100, queue:false, easing:'easeOutQuint'});
			$(this).removeClass('active');
		});
		// --- end sliding panel
	
		// activate tooltips				
		$('*[data-rel="tooltip"]').tooltip(); 
		// LOGIN FORM
		jQuery(document).on('submit','.zn_form_login',function(event){
			event.preventDefault();
		
			var form = $(this),
				warning = false,
				button = $('.zn_sub_button',this),
				values = form.serialize();
			
			$('input',form).each(function(){
				if ( !$(this).val() ) {
					warning = true;
				}
			}); 
			
			if( warning ) {
				button.removeClass('zn_blocked');
				return false;
			}
			
			if( button.hasClass('zn_blocked')) {
				return;
			}
			
			button.addClass('zn_blocked');
	
			jQuery.post(zn_do_login.ajaxurl, values, function(resp) {
				//alert('Got this from the server: ' + resp);


				var data = $(document.createElement('div')).html(resp);

				if ( $('#login_error', data).length ) {

					data.find('a').attr('onClick','ppOpen(\'#forgot_panel\', \'350\');return false;');
					$('div.links', form).html(data);
					button.removeClass('zn_blocked');

				}
				else {
					if ( $('.zn_login_redirect', form).length > 0 ) {
						jQuery.prettyPhoto.close();
						redirect = $('.zn_login_redirect', form);
						href = redirect.val();
						window.location = href;
					}

				}

				button.removeClass('zn_blocked');


			});
			 
			 
		});

		// LOST PASSWORD
		jQuery(document).on('submit','.zn_form_lost_pass',function(event){
			event.preventDefault();
		
			var form = $(this),
				warning = false,
				button = $('.zn_sub_button',this),
				values = form.serialize()+'&ajax_login=true';
			
			$('input',form).each(function(){
				if ( !$(this).val() ) {
					warning = true;
				}
			}); 
			
			if( warning ) {
				button.removeClass('zn_blocked');
				return false;
			}
			
			if( button.hasClass('zn_blocked')) {
				return;
			}
			
			button.addClass('zn_blocked');
	
			$.ajax({
				url: form.attr('action'),
				data: values,
				type: 'POST',
				cache: false,
				success: function (resp) {
					var data = $(document.createElement('div')).html(resp);
					
					$('div.links', form).html('');
					
					if ( $('#login_error', data).length ) {
					
						// We have an error
						var error = $('#login_error', data);
						error.find('a').attr('onClick','ppOpen(\'#forgot_panel\', \'350\');return false;');
						$('div.links', form).html(error);

					}
					else if ( $('.message', data).length ) {
						var message = $('.message', data);
						$('div.links', form).html(message);
					}
					else {
					
						jQuery.prettyPhoto.close();
						redirect = $('.zn_login_redirect', form);
						href = redirect.val();
						window.location = href;
					}
					
					button.removeClass('zn_blocked');
					//alert(resp);
				},
				error: function (jqXHR , textStatus, errorThrown ) {
					$('div.links', form).html(errorThrown);

				}
			});
			 
			 
		});
		
		//hoverlink
		$("a.hoverLink").each(function(index, element) {
            var $t = $(this),
				dtype = $t.data('type'),
				img = $t.find('img'),
				sp = 'fast',
				app = '<span class="icon_wrap"><span class="icon '+dtype+'"></span></span>';
			$t.append(app);
			
			$t.hover(function(){
				img.animate({'opacity': 0.5}, sp);
				$t.find('.icon_wrap').animate({'opacity': 1}, sp);
			}, function(){
				img.animate({'opacity': 1}, sp);
				$t.find('.icon_wrap').animate({'opacity': 0}, sp);
			});
        });
		
		// activate placeholders for older browsers
        //$('input, textarea').placeholder();
		
		//activate collapsible accordions
		$(".collapse").collapse();
		
		

    $('.zn_menu_trigger').unbind('click')
                    .bind('click', function(event){
        event.preventDefault();
        $('nav#main_menu .sf-menu').animate({ height:'toggle' });
    });
		
		// --- search panel
		var searchBtn = $('#search').children('.searchBtn'),
			searchPanel = searchBtn.next(),
			searchP = searchBtn.parent();
		searchBtn.click(function(e){
			e.preventDefault();
			var _t = $(this);
			if(!_t.hasClass('active')) {
				_t.addClass('active')
				.find('span')
				.removeClass('icon-search icon-white')
				.addClass('icon-remove');
				searchPanel.show();
			} else {
				_t.removeClass('active')
				.find('span')
				.addClass('icon-search icon-white')
				.removeClass('icon-remove');
				searchPanel.hide();
			}
		}); // searchBtn.click //
		$(document).click(function(){
			searchBtn.removeClass('active')
				.find('span')
				.addClass('icon-search icon-white')
				.removeClass('icon-remove');
			searchPanel.hide(0);
		});
		searchP.click(function(event){
			event.stopPropagation();
		});
		// --- end search panel
		
		/* scroll to top */
        function totop_button(a) {
            var b = $("#totop");
            b.removeClass("off on");
            if (a == "on") { b.addClass("on") } else { b.addClass("off") }
        }
        window.setInterval(function () {
            var b = $(this).scrollTop();
            var c = $(this).height();
            if (b > 0) { var d = b + c / 2 } else { var d = 1 }
            if (d < 1e3) { totop_button("off") } else { totop_button("on") }
        }, 300);
		
        $("#totop").click(function (e) {
            e.preventDefault();
            $('body,html').animate({scrollTop:0},800, 'easeOutExpo');
        });
		// --- end scroll to top


		
	});	// doc.ready end //

/*	
		// Javascript to enable link to tab
			var gotoHashTab = function (customHash) {
				var hash = customHash || location.hash;
				if (hash) {
					var hashPieces = hash.split('?'),
					activeTab = $('[href=' + hashPieces[0] + ']');
					activeTab && activeTab.tab('show');
				} 

			}

			// onready go to the tab requested in the page hash
			gotoHashTab();

			// when the nav item is selected update the page hash
			$('.nav a').on('shown', function (e) {
				window.location.hash = e.target.hash.replace("#", "#" + prefix);
			})

			// when a link within a tab is clicked, go to the tab requested
			$('.tab-pane a').click(function (event) {
				if (event.target.hash) {
					//gotoHashTab(event.target.hash);
				}
			});
*/
	$(window).load(function(){

	
	/*--------------------------------------------------------------------------------------------------
		Fixed position
	--------------------------------------------------------------------------------------------------*/
		if($('#slideshow').hasClass('slider_fixedd')) {
			
			css = 0;
		
			if ( $('#wpadminbar').length >0 ) {
				css = $('#wpadminbar').height();
			}
		
			$('#slideshow').addClass('slider_fixed')
			//$('.slider_fixed #slideshow'). //
			$('.zn_fixed_slider_fill').css({'height':parseInt($('#slideshow').css('height'))-css+'px', 'background-color': $('body').css('background-color')});
						//$('.inner-page').css({'top':(parseInt($('.slider_fixed #slideshow .item').first().css('height'))-10)+'px', 'background-color': $('body').css('background-color')}); //
			$('#content').css({'background-color': $('body').css('background-color'), 'margin-top':'0px', 'padding-top':'50px'});
		}


		$('.hoverBorder').each(function(index, element) {
			$(this).find('img').wrap('<span class="hoverBorderWrapper"/>').after('<span class="theHoverBorder"></span>');
		});
		
		
		/* RESPONSIVE VIDEOS */
		function adjustIframes()
		{
		  $('iframe').each(function(){
			var
			$this       = $(this),
			proportion  = $this.attr( 'data-proportion' ),
			w           = $this.attr('width'),
			actual_w    = $this.width();
			
			if ( ! proportion )
			{
				proportion = $this.attr('height') / w;
				$this.attr( 'data-proportion', proportion );
			}
		  
			$this.css( 'height', actual_w * proportion + 'px' );

		  });
		}
		$(window).on('resize load',adjustIframes);
		
	}); // window.ready end //


	
})(jQuery);

/*--------------------------------------------------------------------------------------------------
	Sparckles
--------------------------------------------------------------------------------------------------*/	
	if ( jQuery("#sparkles[data-images]:visible").length >0  )  {
		var sP = jQuery.noConflict(),
			sparkles_container = sP(document.getElementById("sparkles"));
			images_location = sparkles_container.attr("data-images");
		var Spark=function(){var a=this;this.b=images_location + "sparkles/";this.s=["spark.png","spark2.png","spark3.png","spark4.png","spark5.png","spark6.png"];this.i=this.s[this.random(this.s.length)];this.f=this.b+this.i;this.n=document.createElement("img");this.newSpeed().newPoint().display().newPoint().fly()};Spark.prototype.display=function(){sP(this.n).attr("src",this.f).css("position","absolute").css("z-index",this.random(-3)).css("top",this.pointY).css("left",this.pointX);sparkles_container.append(this.n);return this};Spark.prototype.fly=function(){var a=this;sP(this.n).animate({top:this.pointY,left:this.pointX},this.speed,"linear",function(){a.newSpeed().newPoint().fly()})};Spark.prototype.newSpeed=function(){this.speed=(this.random(10)+5)*1100;return this};Spark.prototype.newPoint=function(){this.pointX=this.random(sparkles_container.width());this.pointY=this.random(sparkles_container.height());return this};Spark.prototype.random=function(a){return Math.ceil(Math.random()*a)-1};sP(function(){if(sP.browser.msie&&sP.browser.version<9){return}var a=40;var b=[];for(i=0;i<a;i++){b[i]=new Spark()}});
	}


/*--------------------------------------------------------------------------------------------------
	Pretty Photo
--------------------------------------------------------------------------------------------------*/

	function ppOpen(panel, width){
		jQuery.prettyPhoto.close();
		setTimeout(function() {
			jQuery.fn.prettyPhoto({social_tools: false, deeplinking: false, show_title: false, default_width: width, theme:'pp_kalypso'});
			jQuery.prettyPhoto.open(panel);
		}, 300);

	} // function to open different panel within the panel

	jQuery("a[data-rel^='prettyPhoto'], .prettyphoto_link").prettyPhoto({theme:'pp_kalypso',social_tools:false, deeplinking:false});
	jQuery("a[rel^='prettyPhoto']").prettyPhoto({theme:'pp_kalypso'});
	jQuery("a[data-rel^='prettyPhoto[login_panel]']").prettyPhoto({theme:'pp_kalypso', default_width:800, social_tools:false, deeplinking:false});
	
	jQuery(".prettyPhoto_transparent").click(function(e){
		e.preventDefault();
		jQuery.fn.prettyPhoto({social_tools: false, deeplinking: false, show_title: false, default_width: 980, theme:'pp_kalypso transparent', opacity: 0.95});
		jQuery.prettyPhoto.open($(this).attr('href'),'','');
	});

if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
    var msViewportStyle = document.createElement("style");
    msViewportStyle.appendChild(
        document.createTextNode(
            "@-ms-viewport{width:auto!important}"
        )
    );
    document.getElementsByTagName("head")[0].
        appendChild(msViewportStyle);
}
