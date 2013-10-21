
<?php 

if ($data['zn_width'] == '1170' &&  $data['zn_responsive'] == 'no') {

	echo 'body{min-width:1200px;}';

}
elseif ($data['zn_width'] == '960' &&  $data['zn_responsive'] == 'no'){
		echo 'body{min-width:1000px;}';
}



/* SEARCH BUTTON */
if ( !empty($data['head_show_search']) && $data['head_show_search'] == 'no')  {

	echo 'nav#main_menu {clear: right;}';

}

/* SEARCH BUTTON */
if ( !empty($data['zn_slider_header']) && $data['zn_slider_header'] == 'yes')  {

	echo 'header#header {position: relative;}';
	echo '#slideshow .sliderContainer { padding: 50px 0; }';
	echo '#slideshow .container {padding: 30px 0 45px;}';
	echo '#page_header .container {padding: 0 0 30px;}';

}


/*----------------------  Logo --------------------------*/
if(isset($data['logo_upload']) && !empty($data['logo_upload'])) {

	if($data['logo_size'] == 'yes'){
		$logo_size = getimagesize($data['logo_upload']);
		
		if (isset($logo_size[0]) && isset($logo_size[1])) {
			$logo_width = 'width:auto;';
			$logo_height = 'height:auto;';
		}
		else {
			$logo_width = '';
			$logo_height = '';
		}
	}
	if($data['logo_size'] == 'no'){
		if ( isset( $data['logo_manual_size']['width'] ) && !empty( $data['logo_manual_size']['width'] ) ) {
			$logo_width = 'width:'.$data['logo_manual_size']['width'].'px;';
		}
		else {
			$logo_width = '';
		}
		
		if(isset($data['logo_manual_size']['height']) && !empty($data['logo_manual_size']['height'])) {
			$logo_height = 'height:'.$data['logo_manual_size']['height'].'px;';
		}
		else {
			$logo_height = '';
		}
	}
	elseif ( $data['logo_size'] == 'contain' ) {
		$logo_width = 'width:auto;';
		$logo_height = 'height:100%;';
		
		?>
		body header#header #logo a ,header#header.style2 #logo a , header#header.style3 #logo a{
		min-height: 95px;
			padding: 0 25px;
			line-height: 95px;
			text-align: center;
			height:95px;
			}
		#logo a img { max-height:90px;padding:10px; }
		<?php

	}
?>
#logo a img{
	max-width:none;
	<?php echo $logo_width; ?>
	<?php echo $logo_height; ?>
	-webkit-box-sizing: border-box; /* Safari/Chrome, other WebKit */
	-moz-box-sizing: border-box;    /* Firefox, other Gecko */
	box-sizing: border-box;         /* Opera/IE 8+ */
}

<?php } 
else { ?>
#logo ,#logo a  {
	<?php if ( isset ( $data['fonts']['logo_font'] ) && !empty ( $data['fonts']['logo_font'] ) ) { echo 'font-family:'.$data['fonts']['logo_font'].';'; } ?>
	<?php if ( isset ( $data['logo_font']['size'] ) && !empty ( $data['logo_font']['size'] ) ) { echo 'font-size:'.$data['logo_font']['size'].';'; } ?>
	<?php if ( isset ( $data['logo_font']['height'] ) && !empty ( $data['logo_font']['height'] ) ) { echo 'line-height:'.$data['logo_font']['height'].';'; } ?>
	<?php if ( isset ( $data['logo_font']['color'] ) && !empty ( $data['logo_font']['color'] ) ) { echo 'color:'.$data['logo_font']['color'].';'; } ?>
	text-decoration:none;
	<?php
		if( isset ( $data['logo_font']['style'] ) ){
			switch ($data['logo_font']['style']) {
				case 'normal':
					echo 'font-style:normal;';
				break;
				case 'italic':
					echo 'font-style:italic;';
				break;
				case 'bold':
					echo 'font-weight:bold;';
				break;
				case 'bold italic':
					echo  'font-weight:bold;';
					echo  'font-style:italic;';
				break;
			}
		}
	?>

}

#logo a:hover , #logo a:hover{
	<?php if ( isset ( $data['logo_hover']['color'] ) && !empty ( $data['logo_hover']['color'] ) ) { echo 'color:'.$data['logo_hover']['color'].';'; } ?>
}

<?php } ?>

/*----------------------  Header --------------------------*/


#page_header.zn_def_header_style , #slideshow.zn_def_header_style , #page_header.uh_zn_def_header_style , #slideshow.uh_zn_def_header_style{
<?php if ( isset ( $data['def_header_color'] ) && !empty ( $data['def_header_color'] ) ) { echo 'background-color:'.$data['def_header_color'].';'; } ?>
}

#page_header.zn_def_header_style #sparkles, #slideshow.zn_def_header_style #sparkles , #page_header.uh_zn_def_header_style #sparkles, #slideshow.uh_zn_def_header_style #sparkles {
<?php if ($data['def_header_animate'] == '1' ) { echo 'display:block;'; } ?>
}

#page_header.zn_def_header_style .bgback , #slideshow.zn_def_header_style .bgback , #page_header.uh_zn_def_header_style .bgback , #slideshow.uh_zn_def_header_style .bgback{
<?php if ( isset ( $data['def_header_background'] ) && !empty ( $data['def_header_background'] ) ) { echo 'background-image:url("'.$data['def_header_background'].'");'; } ?>
}

<?php


	echo '#page_header.zn_def_header_style , #slideshow.zn_def_header_style {';
				// GRADIENT OVER COLOR
				if ( isset ( $data['def_grad_bg'] ) && !empty ( $data['def_grad_bg'] ) ) {

					echo 'background-image: -moz-linear-gradient(top,  rgba(0,0,0,0) 0%, rgba(0,0,0,0.5) 100%); /* FF3.6+ */ ';
					echo 'background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(0,0,0,0)), color-stop(100%,rgba(0,0,0,0.5))); /* Chrome,Safari4+ */';
					echo 'background-image: -webkit-linear-gradient(top,  rgba(0,0,0,0) 0%,rgba(0,0,0,0.5) 100%); /* Chrome10+,Safari5.1+ */';
					echo 'background-image: -o-linear-gradient(top,  rgba(0,0,0,0) 0%,rgba(0,0,0,0.5) 100%); /* Opera 11.10+ */';
					echo 'background-image: -ms-linear-gradient(top,  rgba(0,0,0,0) 0%,rgba(0,0,0,0.5) 100%); /* IE10+ */';
					echo 'background-image: linear-gradient(to bottom,  rgba(0,0,0,0) 0%,rgba(0,0,0,0.5) 100%); /* W3C */';
					echo "filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00000000', endColorstr='#80000000',GradientType=0 ); /* IE6-9 */";
				}
	echo '}';

	// GLARE EFFECT
	if ( isset ( $data['def_glare'] ) && !empty ( $data['def_glare'] ) ) {
	
		echo '#page_header.zn_def_header_style .bgback:after , #slideshow.zn_def_header_style .bgback:after {';
			echo 'content:""; position:absolute; top:0; left:0; width:100%; height:100%; z-index:-1;background-image: url('.get_template_directory_uri().'/images/glare-effect.png); background-repeat: no-repeat; background-position: center top;';
		echo '}';
	
	}

	// Default SHADOW
	if ( isset ( $data['def_bottom_style'] ) && $data['def_bottom_style'] == 'shadow' ) {
	
		echo '#page_header.zn_def_header_style .zn_header_bottom_style , #slideshow.zn_def_header_style .zn_header_bottom_style {';
			echo 'position:absolute; bottom:0; left:0; width:100%; height:20px; background:url('.get_template_directory_uri().'/images/shadow-up.png) no-repeat center bottom; z-index: 2;';
		echo '}';
		
		echo '#page_header.zn_def_header_style .zn_header_bottom_style:after , #slideshow.zn_def_header_style .zn_header_bottom_style:after {';
			echo 'content:\'\'; position:absolute; bottom:-18px; left:50%; border:6px solid transparent; border-top-color:#fff; margin-left:-6px;';
		echo '}';
		
		echo '#page_header.zn_def_header_style, #slideshow.zn_def_header_style {';
			echo 'border-bottom:6px solid #FFFFFF';
		echo '}';
		
	}
	
	
	// SHADOW UP AND DOWN
	if ( isset ( $data['def_bottom_style'] ) && $data['def_bottom_style'] == 'shadow_ud' ) {
	
		echo '#page_header.zn_def_header_style .zn_header_bottom_style , #slideshow.zn_def_header_style .zn_header_bottom_style {';
			echo 'position:absolute; bottom:0; left:0; width:100%; height:20px; background:url('.get_template_directory_uri().'/images/shadow-up.png) no-repeat center bottom; z-index: 2;';
		echo '}';
		
		echo '#page_header.zn_def_header_style .zn_header_bottom_style:after , #slideshow.zn_def_header_style .zn_header_bottom_style:after {';
			echo 'content:\'\'; position:absolute; bottom:-18px; left:50%; border:6px solid transparent; border-top-color:#fff; margin-left:-6px;';
		echo '}';
		
		echo '#page_header.zn_def_header_style, #slideshow.zn_def_header_style {';
			echo 'border-bottom:6px solid #FFFFFF';
		echo '}';
		
		echo '#page_header.zn_def_header_style .zn_header_bottom_style:before , #slideshow.zn_def_header_style .zn_header_bottom_style:before {';
			echo 'content:\'\'; position:absolute; bottom:-26px; left:0; width:100%; height:20px; background:url('.get_template_directory_uri().'/images/shadow-down.png) no-repeat center top; opacity:.6; filter:alpha(opacity=60);';
		echo '}';
		
	}
	
	// MASK 1
	if ( isset ( $data['def_bottom_style'] ) && $data['def_bottom_style'] == 'mask1' && $data['zn_main_style'] == 'light' ) {
	
		echo '#page_header.zn_def_header_style .zn_header_bottom_style , #slideshow.zn_def_header_style .zn_header_bottom_style {';
			echo 'position:absolute; bottom:0; left:0; width:100%; height:27px; z-index:99; background:url('.get_template_directory_uri().'/images/bottom_mask.png) no-repeat center top;';
		echo '}';
							
	}
	elseif ( isset ( $data['def_bottom_style'] ) && $data['def_bottom_style'] == 'mask1' && $data['zn_main_style'] == 'dark' )  {
		echo '#page_header.zn_def_header_style .zn_header_bottom_style , #slideshow.zn_def_header_style .zn_header_bottom_style {';
			echo 'position:absolute; bottom:0; left:0; width:100%; height:27px; z-index:99; background:url('.get_template_directory_uri().'/images/bottom_mask_dark.png) no-repeat center top;';
		echo '}';
	}
	
	// MASK 2
	if ( isset ( $data['def_bottom_style'] ) && $data['def_bottom_style'] == 'mask2' && $data['zn_main_style'] == 'light' ) {
	
		echo '#page_header.zn_def_header_style .zn_header_bottom_style , #slideshow.zn_def_header_style .zn_header_bottom_style {';
			echo 'position:absolute; bottom:0; left:0; width:100%; z-index:99; ';
			echo 'height:33px; background:url('.get_template_directory_uri().'/images/bottom_mask2.png) no-repeat center top;';
		echo '}';
							
	}
	elseif ( isset ( $data['def_bottom_style'] ) && $data['def_bottom_style'] == 'mask2' && $data['zn_main_style'] == 'dark' ) {
		echo '#page_header.zn_def_header_style .zn_header_bottom_style , #slideshow.zn_def_header_style .zn_header_bottom_style {';
			echo 'position:absolute; bottom:0; left:0; width:100%;  z-index:99; ';
			echo 'height:33px; background:url('.get_template_directory_uri().'/images/bottom_mask2_dark.png) no-repeat center top;';
		echo '}';
	}
?>



/*----------------------  Unlimited Headers --------------------------*/

<?php 
	if ( isset ( $data['header_generator'] ) && is_array ( $data['header_generator'] ) ) {
		foreach ( $data['header_generator'] as $header ) {
		
			if ( isset ( $header['uh_style_name'] ) && !empty ( $header['uh_style_name'] ) ) {
			
				//$header_name_striped = explode ( '|', $header['uh_style_name']);
			
				$header_name = strtolower ( str_replace(' ','_',$header['uh_style_name'] ) );
				
				// Page header + BGBACK
				echo '#page_header.uh_'.$header_name.' .bgback , #slideshow.uh_'.$header_name.' .bgback {';
				
				if ( isset ( $header['uh_background_image'] ) && !empty ( $header['uh_background_image'] ) ) {
					echo 'background-image:url("'.$header['uh_background_image'].'");';
				}
				
				echo '}';
				
				// Animate - Page header + SPARKLES
				if ( isset ( $header['uh_anim_bg'] ) && !empty ( $header['uh_anim_bg'] ) ) {
					echo '#page_header.uh_'.$header_name.' #sparkles , #slideshow.uh_'.$header_name.' #sparkles {display:block}';
				}
				else {
					echo '#page_header.uh_'.$header_name.' #sparkles , #slideshow.uh_'.$header_name.' #sparkles{display:none}';
				}
				
				// COLOR - Page header 
				echo '#page_header.uh_'.$header_name.' , #slideshow.uh_'.$header_name.' {';
				
				if ( isset ( $header['uh_header_color'] ) && !empty ( $header['uh_header_color'] ) ) {
					echo 'background-color:'.$header['uh_header_color'].';';
				}
				
				// GRADIENT OVER COLOR
				if ( isset ( $header['uh_grad_bg'] ) && !empty ( $header['uh_grad_bg'] ) ) {

					echo 'background-image: -moz-linear-gradient(top,  rgba(0,0,0,0) 0%, rgba(0,0,0,0.5) 100%); /* FF3.6+ */ ';
					echo 'background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(0,0,0,0)), color-stop(100%,rgba(0,0,0,0.5))); /* Chrome,Safari4+ */';
					echo 'background-image: -webkit-linear-gradient(top,  rgba(0,0,0,0) 0%,rgba(0,0,0,0.5) 100%); /* Chrome10+,Safari5.1+ */';
					echo 'background-image: -o-linear-gradient(top,  rgba(0,0,0,0) 0%,rgba(0,0,0,0.5) 100%); /* Opera 11.10+ */';
					echo 'background-image: -ms-linear-gradient(top,  rgba(0,0,0,0) 0%,rgba(0,0,0,0.5) 100%); /* IE10+ */';
					echo 'background-image: linear-gradient(to bottom,  rgba(0,0,0,0) 0%,rgba(0,0,0,0.5) 100%); /* W3C */';
					echo "filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00000000', endColorstr='#80000000',GradientType=0 ); /* IE6-9 */";
				}
				
				echo '}';
				
				// GLARE EFFECT
				if ( isset ( $header['uh_glare'] ) && !empty ( $header['uh_glare'] ) ) {
				
					echo '#page_header.uh_'.$header_name.' .bgback:after , #slideshow.uh_'.$header_name.' .bgback:after {';
						echo 'content:""; position:absolute; top:0; left:0; width:100%; height:100%; z-index:-1;background-image: url('.get_template_directory_uri().'/images/glare-effect.png); background-repeat: no-repeat; background-position: center top;';
					echo '}';
				
				}
				
				// Default SHADOW
				if ( isset ( $header['uh_bottom_style'] ) && $header['uh_bottom_style'] == 'shadow' ) {
				
					echo '#page_header.uh_'.$header_name.' .zn_header_bottom_style , #slideshow.uh_'.$header_name.' .zn_header_bottom_style {';
						echo 'position:absolute; bottom:0; left:0; width:100%; height:20px; background:url('.get_template_directory_uri().'/images/shadow-up.png) no-repeat center bottom; z-index: 2;';
					echo '}';
					
					echo '#page_header.uh_'.$header_name.' .zn_header_bottom_style:after , #slideshow.uh_'.$header_name.' .zn_header_bottom_style:after {';
						echo 'content:\'\'; position:absolute; bottom:-18px; left:50%; border:6px solid transparent; border-top-color:#fff; margin-left:-6px;';
					echo '}';
					
					echo '#page_header.uh_'.$header_name.', #slideshow.uh_'.$header_name.' {';
						echo 'border-bottom:6px solid #FFFFFF';
					echo '}';
					
				}
				
				
				// SHADOW UP AND DOWN
				if ( isset ( $header['uh_bottom_style'] ) && $header['uh_bottom_style'] == 'shadow_ud' ) {
				
					echo '#page_header.uh_'.$header_name.' .zn_header_bottom_style , #slideshow.uh_'.$header_name.' .zn_header_bottom_style {';
						echo 'position:absolute; bottom:0; left:0; width:100%; height:20px; background:url('.get_template_directory_uri().'/images/shadow-up.png) no-repeat center bottom; z-index: 2;';
					echo '}';
					
					echo '#page_header.uh_'.$header_name.' .zn_header_bottom_style:after , #slideshow.uh_'.$header_name.' .zn_header_bottom_style:after {';
						echo 'content:\'\'; position:absolute; bottom:-18px; left:50%; border:6px solid transparent; border-top-color:#fff; margin-left:-6px;';
					echo '}';
					
					echo '#page_header.uh_'.$header_name.', #slideshow.uh_'.$header_name.' {';
						echo 'border-bottom:6px solid #FFFFFF';
					echo '}';
					
					echo '#page_header.uh_'.$header_name.' .zn_header_bottom_style:before , #slideshow.uh_'.$header_name.' .zn_header_bottom_style:before {';
						echo 'content:\'\'; position:absolute; bottom:-26px; left:0; width:100%; height:20px; background:url('.get_template_directory_uri().'/images/shadow-down.png) no-repeat center top; opacity:.6; filter:alpha(opacity=60);';
					echo '}';
					
				}
				
				// MASK 1
				if ( isset ( $header['uh_bottom_style'] ) && $header['uh_bottom_style'] == 'mask1' && $data['zn_main_style'] == 'light' ) {
				
					echo '#page_header.uh_'.$header_name.' .zn_header_bottom_style , #slideshow.uh_'.$header_name.' .zn_header_bottom_style {';
						echo 'position:absolute; bottom:0; left:0; width:100%; height:27px; z-index:99; background:url('.get_template_directory_uri().'/images/bottom_mask.png) no-repeat center top;';
					echo '}';
										
				}
				elseif ( isset ( $header['uh_bottom_style'] ) && $header['uh_bottom_style'] == 'mask1' && $data['zn_main_style'] == 'dark' )  {
					echo '#page_header.uh_'.$header_name.' .zn_header_bottom_style , #slideshow.uh_'.$header_name.' .zn_header_bottom_style {';
						echo 'position:absolute; bottom:0; left:0; width:100%; height:27px; z-index:99; background:url('.get_template_directory_uri().'/images/bottom_mask_dark.png) no-repeat center top;';
					echo '}';
				}
				
				// MASK 2
				if ( isset ( $header['uh_bottom_style'] ) && $header['uh_bottom_style'] == 'mask2' && $data['zn_main_style'] == 'light' ) {
				
					echo '#page_header.uh_'.$header_name.' .zn_header_bottom_style , #slideshow.uh_'.$header_name.' .zn_header_bottom_style {';
						echo 'position:absolute; bottom:0; left:0; width:100%; z-index:99; ';
						echo 'height:33px; background:url('.get_template_directory_uri().'/images/bottom_mask2.png) no-repeat center top;';
					echo '}';
										
				}
				elseif ( isset ( $header['uh_bottom_style'] ) && $header['uh_bottom_style'] == 'mask2' && $data['zn_main_style'] == 'dark' ) {
					echo '#page_header.uh_'.$header_name.' .zn_header_bottom_style , #slideshow.uh_'.$header_name.' .zn_header_bottom_style {';
						echo 'position:absolute; bottom:0; left:0; width:100%;  z-index:99; ';
						echo 'height:33px; background:url('.get_template_directory_uri().'/images/bottom_mask2_dark.png) no-repeat center top;';
					echo '}';
				}
				
			}

		}
	}
?>
/* GENERAL COLOR */

	 a:hover, 
	.cart_details .checkout, 
	.info_pop .buyit, 
	.m_title, 
	.smallm_title, 
	.circle_title, 
	.feature_box .title, 
	.services_box .title, 
	.latest_posts.default-style .hoverBorder:hover h6, 
	.latest_posts.style2 ul.posts .title, 
	.latest_posts.style3 ul.posts .title, 
	.recentwork_carousel li .details h4, 
	.acc-group.default-style > button, 
	.acc-group.style3 > button:after, 
	.screenshot-box .left-side h3.title, 
	.vertical_tabs .tabbable .nav>li>a:hover, 
	.vertical_tabs .tabbable .nav>li.active>a, 
	.services_box.style2 .box .list li, 
	.shop-latest .tabbable .nav li.active a, 
	.product-list-item:hover .details h3, 
	.latest_posts.style3 ul.posts .title a,
	.statbox h4 , #bbpress-forums .bbp-topics li.bbp-body .bbp-topic-title > a
	{color:<?php echo $data['zn_main_color']; ?>;}
	
	.acc-group.style3 > button:hover, 
	.acc-group.style3 > button:hover:after 
	{ color:<?php echo $data['zn_main_color'];?> ;}

	.tabs_style1 > ul.nav > li.active > a, 
	header.style1, 
	header.style2 #logo a, 
	header.style3 #logo a 
	{border-top: 3px solid <?php echo $data['zn_main_color'];?>;}

nav#main_menu > ul > li.active > a, 
nav#main_menu > ul > li > a:hover, 
nav#main_menu > ul > li:hover > a, 
.social-icons li a:hover, 
#action_box, 
body .circlehover,
body .flex-direction-nav li a:hover,
body .iosSlider .item .caption.style1 .more:before,
body .iosSlider .item .caption.style1 .more:after,
body .iosSlider .item .caption.style2 .more,
body .nivo-directionNav a:hover,
body #wowslider-container a.ws_next:hover,
body #wowslider-container a.ws_prev:hover,
.br-next:hover, .br-previous:hover,
body .ca-more,
body .title_circle,
body .title_circle:before,
body ul.links li a,
.hg-portfolio-sortable #portfolio-nav li a:hover, .hg-portfolio-sortable #portfolio-nav li.current a,
.iosSlider .item .caption.style1 .more:before, .iosSlider .item .caption.style1 .more:after,
.btn-flat ,
body.woocommerce a.button:hover, 
body.woocommerce button.button:hover, 
body.woocommerce input.button:hover, 
body.woocommerce #respond input#submit:hover, 
body.woocommerce #content input.button:hover, 
body.woocommerce-page a.button:hover, 
body.woocommerce-page button.button:hover, 
body.woocommerce-page input.button:hover, 
body.woocommerce-page #respond input#submit:hover, 
body.woocommerce-page #content input.button:hover,
body.woocommerce a.button, 
body.woocommerce button.button, 
body.woocommerce input.button, 
body.woocommerce #respond input#submit, 
body.woocommerce #content input.button, 
body.woocommerce-page a.button, 
body.woocommerce-page button.button, 
body.woocommerce-page input.button, 
body.woocommerce-page #respond input#submit, 
body.woocommerce-page #content input.button,
body.woocommerce a.button.alt, 
body.woocommerce button.button.alt, 
body.woocommerce input.button.alt, 
body.woocommerce #respond input#submit.alt, 
body.woocommerce #content input.button.alt, 
body.woocommerce-page a.button.alt, 
body.woocommerce-page button.button.alt, 
body.woocommerce-page input.button.alt, 
body.woocommerce-page #respond input#submit.alt, 
body.woocommerce-page #content input.button.alt,
body .woocommerce a.button, 
body .woocommerce button.button, 
body .woocommerce input.button, 
body .woocommerce #respond input#submit, 
body .woocommerce #content input.button, 
body .woocommerce-page a.button, 
body .woocommerce-page button.button, 
body .woocommerce-page input.button, 
body .woocommerce-page #respond input#submit, 
body .woocommerce-page #content input.button ,
span.zonsale,
.sidebar .widget ul.menu li.active > a,
.sidebar .widget ul.product-categories li.active > a, 
.sidebar .widget ul.pagenav li.active a, 
.sidebar .widget ul.menu li.current-cat > a, 
.sidebar .widget ul.product-categories li.current-cat > a, 
.sidebar .widget ul.pagenav li.current-cat > a, 
.sidebar .widget ul.menu li > a:hover, 
.sidebar .widget ul.product-categories li > a:hover, 
.sidebar .widget ul.pagenav li a:hover,
#limited_offers li:after,
.login-panel .create_account, 
.login-panel input[type=submit], 
.register-panel input[type=submit], 
.forgot-panel input[type=submit], 
.login-panel .login_facebook ,
#bbpress-forums div.bbp-search-form input[type=submit], #bbpress-forums .bbp-submit-wrapper button, #bbpress-forums #bbp-your-profile fieldset.submit button {background-color:<?php echo $data['zn_main_color'];?>;}

.breadcrumbs li:after {
	border-left-color: <?php echo $data['zn_main_color'];?>;
}

span.zonsale:before ,#limited_offers li:before{border-color:<?php echo $data['zn_main_color'];?>  transparent transparent;}

	.how_to_shop .number, .newsletter-signup input[type=submit], .vertical_tabs .tabbable .nav>li.active>a>span, .vertical_tabs .tabbable .nav>li>a:hover>span, #map_controls, .hg-portfolio-sortable #portfolio-nav li.current a, .ptcarousel .controls > a:hover, .itemLinks span a:hover, .product-list-item .details .actions a, .shop-features .shop-feature:hover, .btn-flat, .redbtn, #sidebar ul.menu li a:hover, .imgboxes_style1 .hoverBorder h6, .feature_box.style3 .box:hover, .services_box .box:hover .icon, .latest_posts.default-style .hoverBorder h6, .process_steps .step.intro, .recentwork_carousel.style2 li a .details .plus, .gobox.ok, .hover-box:hover, .recentwork_carousel li .details > .bg, .circlehover:before,.iosSlider .item .caption.style1 .more:before, .iosSlider .item .caption.style1 .more:after ,.iosSlider .item .caption.style2 .more {background-color:<?php echo $data['zn_main_color'];?>;}
	#action_box:before ,#action_box:after, header#header.style1{border-top-color:<?php echo $data['zn_main_color'];?>;}

	/* BORDER LEFT */
	.process_steps .step.intro:after,
	body .nivo-caption,
	body .flex-caption,
	body #wowslider-container .ws-title
	{border-left-color:<?php echo $data['zn_main_color'];?>; }

	.theHoverBorder:hover {box-shadow:0 0 0 5px <?php echo $data['zn_main_color'];?> inset;}

	.offline-page .containerbox {border-bottom:5px solid <?php echo $data['zn_main_color'];?>; }

	.offline-page .containerbox:after {border-top: 20px solid <?php echo $data['zn_main_color'];?>;}

	header#header.style2 #logo a {border-top: 3px solid <?php echo $data['zn_main_color'];?>;}

	body .iosSlider .item .caption.style2 .title_big, body .iosSlider .item .caption.style2 .title_small {border-left: 5px solid <?php echo $data['zn_main_color'];?>; }
	body .iosSlider .item .caption.style2.fromright .title_big, body .iosSlider .item .caption.style2.fromright .title_small {border-right: 5px solid <?php echo $data['zn_main_color'];?> ; }

/* Buddypress styles */
#buddypress form#whats-new-form p.activity-greeting:after {border-top-color: <?php echo $data['zn_main_color'];?>;}

#buddypress input[type=submit],
#buddypress input[type=button],
#buddypress input[type=reset] ,
#buddypress .activity-list li.load-more a {background: <?php echo $data['zn_main_color'];?>;}

#buddypress div.item-list-tabs ul li.selected a,
#buddypress div.item-list-tabs ul li.current a {border-top: 2px solid <?php echo $data['zn_main_color'];?>;}

#buddypress form#whats-new-form p.activity-greeting,
.widget.buddypress ul.item-list li:hover {background-color: <?php echo $data['zn_main_color'];?>;}

.widget.buddypress div.item-options a.selected ,
#buddypress div.item-list-tabs ul li.selected a,
#buddypress div.item-list-tabs ul li.current a ,
#buddypress div.activity-meta a ,
#buddypress div.activity-meta a:hover,
#buddypress .acomment-options a {color:<?php echo $data['zn_main_color'];?>;}



/* HEADINGS */
h1 , .page-title{
	
	<?php if ( isset ( $data['fonts']['h1_typo'] ) && !empty ( $data['fonts']['h1_typo'] ) ) { echo 'font-family:'.$data['fonts']['h1_typo'].';'; } ?>
	<?php if ( isset ( $data['h1_typo']['size'] ) && !empty ( $data['h1_typo']['size'] ) ) { echo 'font-size:'.$data['h1_typo']['size'].';'; } ?>
	<?php if ( isset ( $data['h1_typo']['height'] ) && !empty ( $data['h1_typo']['height'] ) ) { echo 'line-height:'.$data['h1_typo']['height'].';'; } ?>


}

h2 {
	
	<?php if ( isset ( $data['fonts']['h2_typo'] ) && !empty ( $data['fonts']['h2_typo'] ) ) { echo 'font-family:'.$data['fonts']['h2_typo'].';'; } ?>
	<?php if ( isset ( $data['h2_typo']['size'] ) && !empty ( $data['h2_typo']['size'] ) ) { echo 'font-size:'.$data['h2_typo']['size'].';'; } ?>
	<?php if ( isset ( $data['h2_typo']['height'] ) && !empty ( $data['h2_typo']['height'] ) ) { echo 'line-height:'.$data['h2_typo']['height'].';'; } ?>


}

h3 {
	
	<?php if ( isset ( $data['fonts']['h3_typo'] ) && !empty ( $data['fonts']['h3_typo'] ) ) { echo 'font-family:'.$data['fonts']['h3_typo'].';'; } ?>
	<?php if ( isset ( $data['h3_typo']['size'] ) && !empty ( $data['h3_typo']['size'] ) ) { echo 'font-size:'.$data['h3_typo']['size'].';'; } ?>
	<?php if ( isset ( $data['h3_typo']['height'] ) && !empty ( $data['h3_typo']['height'] ) ) { echo 'line-height:'.$data['h3_typo']['height'].';'; } ?>


}

h4 {
	
	<?php if ( isset ( $data['fonts']['h4_typo'] ) && !empty ( $data['fonts']['h4_typo'] ) ) { echo 'font-family:'.$data['fonts']['h4_typo'].';'; } ?>
	<?php if ( isset ( $data['h4_typo']['size'] ) && !empty ( $data['h4_typo']['size'] ) ) { echo 'font-size:'.$data['h4_typo']['size'].';'; } ?>
	<?php if ( isset ( $data['h4_typo']['height'] ) && !empty ( $data['h4_typo']['height'] ) ) { echo 'line-height:'.$data['h4_typo']['height'].';'; } ?>


}

h5 {
	
	<?php if ( isset ( $data['fonts']['h5_typo'] ) && !empty ( $data['fonts']['h5_typo'] ) ) { echo 'font-family:'.$data['fonts']['h5_typo'].';'; } ?>
	<?php if ( isset ( $data['h5_typo']['size'] ) && !empty ( $data['h5_typo']['size'] ) ) { echo 'font-size:'.$data['h5_typo']['size'].';'; } ?>
	<?php if ( isset ( $data['h5_typo']['height'] ) && !empty ( $data['h5_typo']['height'] ) ) { echo 'line-height:'.$data['h5_typo']['height'].';'; } ?>


}

h6 {
	
	<?php if ( isset ( $data['fonts']['h6_typo'] ) && !empty ( $data['fonts']['h6_typo'] ) ) { echo 'font-family:'.$data['fonts']['h6_typo'].';'; } ?>
	<?php if ( isset ( $data['h6_typo']['size'] ) && !empty ( $data['h6_typo']['size'] ) ) { echo 'font-size:'.$data['h6_typo']['size'].';'; } ?>
	<?php if ( isset ( $data['h6_typo']['height'] ) && !empty ( $data['h6_typo']['height'] ) ) { echo 'line-height:'.$data['h6_typo']['height'].';'; } ?>


}

/* Body */
body{
	
	<?php if ( isset ( $data['fonts']['body_font'] ) && !empty ( $data['fonts']['body_font'] ) ) { echo 'font-family:'.$data['fonts']['body_font'].';'; } ?>
	<?php if ( isset ( $data['body_font']['size'] ) && !empty ( $data['body_font']['size'] ) ) { echo 'font-size:'.$data['body_font']['size'].';'; } ?>
	<?php if ( isset ( $data['body_font']['height'] ) && !empty ( $data['body_font']['height'] ) ) { echo 'line-height:'.$data['body_font']['height'].';'; } ?>
	<?php if ( isset ( $data['body_font']['color'] ) && !empty ( $data['body_font']['color'] ) ) { echo 'color:'.$data['body_font']['color'].';'; } ?>

}
/* Grey Area */
body .gray-area {
	
	<?php if ( isset ( $data['fonts']['ga_font'] ) && !empty ( $data['fonts']['ga_font'] ) ) { echo 'font-family:'.$data['fonts']['ga_font'].';'; } ?>
	<?php if ( isset ( $data['ga_font']['size'] ) && !empty ( $data['ga_font']['size'] ) ) { echo 'font-size:'.$data['ga_font']['size'].';'; } ?>
	<?php if ( isset ( $data['ga_font']['height'] ) && !empty ( $data['ga_font']['height'] ) ) { echo 'line-height:'.$data['ga_font']['height'].';'; } ?>
	<?php if ( isset ( $data['ga_font']['color'] ) && !empty ( $data['ga_font']['color'] ) ) { echo 'color:'.$data['ga_font']['color'].';'; } ?>

}
/* Footer Area */
body #footer {
	
	<?php if ( isset ( $data['fonts']['footer_font'] ) && !empty ( $data['fonts']['footer_font'] ) ) { echo 'font-family:'.$data['fonts']['footer_font'].';'; } ?>
	<?php if ( isset ( $data['footer_font']['size'] ) && !empty ( $data['footer_font']['size'] ) ) { echo 'font-size:'.$data['footer_font']['size'].';'; } ?>
	<?php if ( isset ( $data['footer_font']['height'] ) && !empty ( $data['footer_font']['height'] ) ) { echo 'line-height:'.$data['footer_font']['height'].';'; } ?>
	<?php if ( isset ( $data['footer_font']['color'] ) && !empty ( $data['footer_font']['color'] ) ) { echo 'color:'.$data['footer_font']['color'].';'; } ?>

}

body #page_wrapper , body.boxed #page_wrapper {
	<?php if ( !empty ( $data['zn_body_def_color'] ) ) { echo 'background-color:'.$data['zn_body_def_color'].';'; } ?>
	<?php if( !empty($data['body_back_image']['image'])){ echo 'background-image:url("'.$data['body_back_image']['image'].'");'; } ?>
	<?php if( !empty($data['body_back_image']['repeat'])){ echo 'background-repeat:'.$data['body_back_image']['repeat'].';'; } ?>
	<?php if( !empty($data['body_back_image']['position'])){ echo 'background-position:'.$data['body_back_image']['position']['x'].' '.$data['body_back_image']['position']['y'].';'; } ?>
	<?php if( !empty($data['body_back_image']['attachment'])){ echo 'background-attachment:'.$data['body_back_image']['attachment'].';'; } ?>
}

.gray-area {
	<?php if ( !empty ( $data['zn_gr_area_def_color'] ) ) { echo 'background-color:'.$data['zn_gr_area_def_color'].';'; } ?>
	<?php if( !empty($data['gr_arr_back_image']['image'])){ echo 'background-image:url("'.$data['gr_arr_back_image']['image'].'");'; } ?>
	<?php if( !empty($data['gr_arr_back_image']['repeat'])){ echo 'background-repeat:'.$data['gr_arr_back_image']['repeat'].';'; } ?>
	<?php if( !empty($data['gr_arr_back_image']['position'])){ echo 'background-position:'.$data['gr_arr_back_image']['position']['x'].' '.$data['gr_arr_back_image']['position']['y'].';'; } ?>
	<?php if( !empty($data['gr_arr_back_image']['attachment'])){ echo 'background-attachment:'.$data['gr_arr_back_image']['attachment'].';'; } ?>
}


header#header , .oldie #page_wrapper header#header {
	<?php if( !empty($data['header_style']) && $data['header_style'] == 'image_color'){ echo 'background-color:'.$data['header_style_color'].';';  } ?>
	<?php if( !empty($data['header_style']) && $data['header_style'] == 'image_color' && !empty($data['header_style_image']['image'])){ echo 'background-image:url("'.$data['header_style_image']['image'].'");'; } elseif(!empty($data['header_style']) && $data['header_style'] == 'image_color') { echo 'background-image:none;'; } ?>
	<?php if( !empty($data['header_style']) && $data['header_style'] == 'image_color' && isset($data['header_style_image']['repeat']) && !empty($data['header_style_image']['repeat'])){ echo 'background-repeat:'.$data['header_style_image']['repeat'].';'; } ?>
	<?php if( !empty($data['header_style']) && $data['header_style'] == 'image_color' && isset($data['header_style_image']['position']) && !empty($data['header_style_image']['position'])){ echo 'background-position:'.$data['header_style_image']['position']['x'].' '.$data['header_style_image']['position']['y'].';'; } ?>
	<?php if( !empty($data['header_style']) && $data['header_style'] == 'image_color' && isset($data['header_style_image']['attachment']) && !empty($data['header_style_image']['attachment'])){ echo 'background-attachment:'.$data['header_style_image']['attachment'].';'; } ?>

}

footer#footer {
	<?php if( !empty($data['footer_style']) && $data['footer_style'] == 'image_color'){ echo 'background-color:'.$data['footer_style_color'].';';  } ?>
	<?php if( !empty($data['footer_style']) && $data['footer_style'] == 'image_color' && isset($data['footer_style_image']['image']) && !empty($data['footer_style_image']['image'])){ echo 'background-image:url("'.$data['footer_style_image']['image'].'");'; } ?>
	<?php if( !empty($data['footer_style']) && $data['footer_style'] == 'image_color' && isset($data['footer_style_image']['repeat']) && !empty($data['footer_style_image']['repeat'])){ echo 'background-repeat:'.$data['footer_style_image']['repeat'].';'; } ?>
	<?php if( !empty($data['footer_style']) && $data['footer_style'] == 'image_color' && isset($data['footer_style_image']['position']) && !empty($data['footer_style_image']['position'])){ echo 'background-position:'.$data['footer_style_image']['position']['x'].' '.$data['footer_style_image']['position']['y'].';'; } ?>
	<?php if( !empty($data['footer_style']) && $data['footer_style'] == 'image_color' && isset($data['footer_style_image']['attachment']) && !empty($data['footer_style_image']['attachment'])){ echo 'background-attachment:'.$data['footer_style_image']['attachment'].';'; } ?>
}

footer#footer .bottom {	<?php if ( !empty ( $data['footer_border_color'] ) ) { echo 'border-top:5px solid '. $data['footer_border_color'] .';'; } ?> }

nav#main_menu > ul > li > a {
	
	<?php if ( !empty ( $data['fonts']['menu_font'] ) ) { echo 'font-family:"'.$data['fonts']['menu_font'].'" , "Helvetica Neue", Helvetica, Arial, sans-serif;'; } ?>
	<?php if ( !empty ( $data['h4_typo']['size'] ) ) { echo 'font-size:'.$data['menu_font']['size'].';'; } ?>
	<?php if ( !empty ( $data['menu_font']['height'] ) ) { echo 'line-height:'.$data['menu_font']['height'].';'; } ?>
	<?php if ( !empty ( $data['menu_font']['color'] ) ) { echo 'color:'.$data['menu_font']['color'].';'; } ?>
	<?php
		if( isset ( $data['menu_font']['style'] ) ){
			switch ($data['menu_font']['style']) {
				case 'normal':
					echo 'font-style:normal;';
				break;
				case 'italic':
					echo 'font-style:italic;';
				break;
				case 'bold':
					echo 'font-weight:700;';
				break;
				case 'bold italic':
					echo  'font-weight:700;';
					echo  'font-style:italic;';
				break;
			}
		}
	?>

}


<?php 
if ( !empty ( $data['zn_boxed_layout'] ) && $data['zn_boxed_layout'] == 'yes' ) {
	?>
	body {
		<?php if( !empty( $data['boxed_style_color'] ) ){ echo 'background-color:'.$data['boxed_style_color'].';';  } ?>
		<?php if( !empty( $data['boxed_style_image']['image'] ) ){ echo 'background-image:url("'.$data['boxed_style_image']['image'].'");'; } ?>
		<?php if( !empty($data['boxed_style_image']['repeat'])){ echo 'background-repeat:'.$data['boxed_style_image']['repeat'].';'; } ?>
		<?php if( !empty($data['boxed_style_image']['position'])){ echo 'background-position:'.$data['boxed_style_image']['position']['x'].' '.$data['boxed_style_image']['position']['y'].';'; } ?>
		<?php if( !empty($data['boxed_style_image']['attachment'])){ echo 'background-attachment:'.$data['boxed_style_image']['attachment'].';'; } ?>

	}
	<?php
}
?>

<?php

	if ( !empty($data['zn_top_nav_color']) ) {
		echo '.topnav > li > a { color:'.$data['zn_top_nav_color'].' ;}';
	}
	if ( !empty($data['zn_top_nav_h_color']) ) {
		echo '.topnav > li > a:hover { color:'.$data['zn_top_nav_h_color'].' ;}';
	}

/* WOOCOMMERCE CATEGORY IMAGE */
	if ( !empty($data['woo_cat_image_size'] ) ) {
		echo '.product-list-item .image { max-height: '.$data['woo_cat_image_size']['height'].'px;line-height:'.$data['woo_cat_image_size']['height'].'px;}';
	}

	if ( !empty ( $data['zn_custom_css'] ) ) {
		echo  stripslashes ( $data['zn_custom_css'] );
	}
?>