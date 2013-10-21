<?php
/*--------------------------------------------------------------------------------------------------
	File: shortcodes.php
	Description: This is the file that contains all the shortcodes logic
	Plesae be carefull when editing this file
--------------------------------------------------------------------------------------------------*/
add_filter('widget_text', 'do_shortcode');
/*--------------------------------------------------------------------------------------------------	
Subtitle
--------------------------------------------------------------------------------------------------*/
function zn_shortcode_subtitle( $atts, $content = null ) {
	// [subtitle] Content [/subtitle]
	
	return '<h2 class="subtitle">' . do_shortcode($content) . '</h2>';
	
}
add_shortcode('subtitle', 'zn_shortcode_subtitle');
/*--------------------------------------------------------------------------------------------------
	SITEMAP
--------------------------------------------------------------------------------------------------*/
function zn_shortcode_sitemap( $atts ) {
	// [sitemap menu="Main Menu"]
	
	extract(shortcode_atts(array( 'menu' => null, ), $atts));
	
	$return = '<div class="sitemap">';
	$return .=  wp_nav_menu( array( 'menu' => $menu, 'echo' => false ) );
	$return .= '</div>';
	
	return $return;
}
add_shortcode('sitemap', 'zn_shortcode_sitemap');
/*--------------------------------------------------------------------------------------------------
	Skills
--------------------------------------------------------------------------------------------------*/
function zn_shortcode_skills( $atts, $content = null ) {
	// [skills main_text="skills" main_color="#193340" text_color="#ffffff"] Content [/skills]
	
	extract(shortcode_atts(array(
		"main_text" => 'skills',
		"main_color" => '#193340',
		"text_color" => '#ffffff'
	), $atts));
	
	$return = '<div id="skills_diagram">';
	
		$return .= '<div class="legend">';
		
			$return .= '<h4>'.__("Legend:",THEMENAME).'</h4>';
			$return .= '<ul class="skills">';
			
				$return .= do_shortcode( strip_tags( $content ) );
			
			$return .= '</ul><!-- end the skills -->';
		
		$return .= '</div>';
		$return .= '<div id="thediagram" data-width="600" data-height="600" data-maincolor="'.$main_color.'" data-maintext="'.$main_text.'" data-fontsize="20px Arial" data-textcolor="'.$text_color.'"></div>';
		$return .= '<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>';
		$return .= '<script type="text/javascript" src="'.MASTER_THEME_DIR.'/addons/raphael_diagram/init.js"></script>';
	
	$return .= '</div><!-- end skills diagram -->';
	
	return $return;
	
}
function zn_shortcode_skill( $atts, $content = null ) {
	// [skill main_color="#97BE0D" percentage="95"] Content [/skill]
	extract(shortcode_atts(array(
		"main_color" => '#97BE0D',
		"percentage" => '95'
	), $atts));
	
	$return = '<li data-percent="'.$percentage.'" style="background-color:'.$main_color.';">'.$content.'</li>';
	
	return $return;
}
add_shortcode('skills', 'zn_shortcode_skills');
add_shortcode('skill', 'zn_shortcode_skill');
/*--------------------------------------------------------------------------------------------------
	H1 Alternative
--------------------------------------------------------------------------------------------------*/
function zn_shortcode_h1a( $atts, $content = null ) {
	// [h1a] Content [/h1a]
	
	return '<h1 class="m_title">' . do_shortcode($content) . '</h1>';
	
}
add_shortcode('h1a', 'zn_shortcode_h1a');
/*--------------------------------------------------------------------------------------------------
	H2 Alternative
--------------------------------------------------------------------------------------------------*/
function zn_shortcode_h2a( $atts, $content = null ) {
	// [h2a] Content [/h2a]
	
	return '<h2 class="m_title">' . do_shortcode($content) . '</h2>';
	
}
add_shortcode('h2a', 'zn_shortcode_h2a');
/*--------------------------------------------------------------------------------------------------
	H3 Alternative
--------------------------------------------------------------------------------------------------*/
function zn_shortcode_h3a( $atts, $content = null ) {
	// [h3a] Content [/h3a]
	
	return '<h3 class="m_title">' . do_shortcode($content) . '</h3>';
	
}
add_shortcode('h3a', 'zn_shortcode_h3a');
/*--------------------------------------------------------------------------------------------------
	H4 Alternative
--------------------------------------------------------------------------------------------------*/
function zn_shortcode_h4a( $atts, $content = null ) {
	// [h4a] Content [/h4a]
	
	return '<h4 class="m_title">' . do_shortcode($content) . '</h4>';
	
}
add_shortcode('h4a', 'zn_shortcode_h4a');
/*--------------------------------------------------------------------------------------------------
	H5 Alternative
--------------------------------------------------------------------------------------------------*/
function zn_shortcode_h5a( $atts, $content = null ) {
	// [h5a] Content [/h5a]
	
	return '<h5 class="m_title">' . do_shortcode($content) . '</h5>';
	
}
add_shortcode('h5a', 'zn_shortcode_h5a');
/*--------------------------------------------------------------------------------------------------
	H6 Alternative
--------------------------------------------------------------------------------------------------*/
function zn_shortcode_h6a( $atts, $content = null ) {
	// [h6a] Content [/h6a]
	
	return '<h6 class="m_title">' . do_shortcode($content) . '</h6>';
	
}
add_shortcode('h6a', 'zn_shortcode_h6a');
/*--------------------------------------------------------------------------------------------------
	List styles
--------------------------------------------------------------------------------------------------*/
function zn_shortcode_list( $atts, $content = null ) {
	// TYPE : list-style1 , list-style2 
	
	// [list type="list-style1"] Content [/list]
	
	extract(shortcode_atts(array(
		"type" => 'list-style1'
	), $atts));
	
	return str_replace ( '<ul' ,'<ul class="'.$type.'"', do_shortcode($content) );
	
}
add_shortcode('list', 'zn_shortcode_list');
/*--------------------------------------------------------------------------------------------------
	Blockquote
--------------------------------------------------------------------------------------------------*/
function zn_shortcode_blockquote( $atts, $content = null ) {
	// [blockquote author="" align="left"] Content [/blockquote]
	
	extract(shortcode_atts(array(
		"author" => '',
		"align" => ''
	), $atts));
	
	if ( $align == 'right' ) {
		$align = 'pull-right';
	}
	
	$quote = '<blockquote class="'.$align.'"><p>'.strip_tags( $content ).'</p>';
	
	if ( !empty ( $author ) ) {
		$quote .= '<small>'.strip_tags( $author ).'</small>';
	}
	
	$quote .= '</blockquote>';
	
	return str_replace("\r\n", '', $quote);
}
add_shortcode('blockquote', 'zn_shortcode_blockquote');
/*--------------------------------------------------------------------------------------------------
	QR CODE
--------------------------------------------------------------------------------------------------*/
function zn_shortcode_qr( $atts, $content = null ) {
	// [qr align="right" size="140"] data [/qr]
	
	extract(shortcode_atts(array(
		"align" => 'right',
		"size" => '140',
	), $atts));
	
	$data = urlencode ( trim ( $content ) );
	$return = '<div class="qrCode align'.$align.'" >';
	$return .= '<h6>'.__('Scan me!',THEMENAME).'</h6>';
	$return .= '<img src="http://api.qrserver.com/v1/create-qr-code/?data='.$data.'&amp;size='.$size.'x'.$size.'" alt="'.__("Scan this QR Code!",THEMENAME).'" class="img-polaroid" />';
	$return .= '</div><!-- end QR Code -->';
	
	return $return;
	
}
add_shortcode('qr', 'zn_shortcode_qr');

/*--------------------------------------------------------------------------------------------------
	Two Columns
--------------------------------------------------------------------------------------------------*/
function zn_shortcode_two_columns( $atts, $content = null ) {
	// [one_half_column] Content [/one_half_column]
	  
	return '<div class="span6">' . do_shortcode($content) . '</div>';
	
}
add_shortcode('one_half_column', 'zn_shortcode_two_columns');
/*--------------------------------------------------------------------------------------------------
	1/3 Columns
--------------------------------------------------------------------------------------------------*/
function zn_shortcode_three_columns( $atts, $content = null ) {
	// [one_third_column] Content [/one_third_column]
		  
	return '<div class="span4">' . do_shortcode($content) . '</div>';
	
}
add_shortcode('one_third_column', 'zn_shortcode_three_columns');

/*--------------------------------------------------------------------------------------------------
	1/4 Columns
--------------------------------------------------------------------------------------------------*/
function zn_shortcode_one_fourth_columns( $atts, $content = null ) {
	// [one_fourth_column] Content [/one_fourth_column]
		  
	return '<div class="span3">' . do_shortcode($content) . '</div>';
	
}
add_shortcode('one_fourth_column', 'zn_shortcode_one_fourth_columns');
/*--------------------------------------------------------------------------------------------------
	2/3 Columns
--------------------------------------------------------------------------------------------------*/
function zn_shortcode_two_third_columns( $atts, $content = null ) {
	// [two_third_column] Content [/two_third_column]
		  
	return '<div class="span8">' . do_shortcode($content) . '</div>';
	
}
add_shortcode('two_third_column', 'zn_shortcode_two_third_columns');
/*--------------------------------------------------------------------------------------------------
	3/4 Columns
--------------------------------------------------------------------------------------------------*/
function zn_shortcode_three_fourth_columns( $atts, $content = null ) {
	// [three_fourth_column] Content [/three_fourth_column]
	  
	return '<div class="span9">' . do_shortcode($content) . '</div>';
	
}
add_shortcode('three_fourth_column', 'zn_shortcode_three_fourth_columns');
/*--------------------------------------------------------------------------------------------------
	ROW
--------------------------------------------------------------------------------------------------*/
function zn_shortcode_row( $atts, $content="" ) {
	// [row no_margin] Content [/row]
	$class = '';
	
	if (isset($atts[0]) && trim($atts[0])){
		$class=trim($atts[0]);
	}
	
	return '<div class="row-fluid '.$class.'">' . do_shortcode($content) . '</div>';
	
}
add_shortcode('row', 'zn_shortcode_row');/*--------------------------------------------------------------------------------------------------
	Accordion
--------------------------------------------------------------------------------------------------*/
function zn_accordion( $atts, $content = null ) {
	// [accordion title="" style=""] Content [/accordion]
	
	extract(shortcode_atts(array(
		"title" => '',
		"style" => 'default-style',
		"size" => '140',
	), $atts));


	$link = '';
	if ( $style == 'style2' ) {

		$link = 'btn-link';

	}
	  
	$uid = uniqid();
	
		$return = '<div class="acc-group '.$style.' tweaked">';
		$return .= '<button data-toggle="collapse" data-target="#acc'.$uid.'" class="collapsed '.$link.'">'.$title.'</button>';
		$return .= '<div id="acc'.$uid.'" class="collapse in">';
		$return .= '<div class="content">';
		$return .= do_shortcode($content);					
		$return .=	'</div><!-- end content -->';
		$return .=	'</div>';
		$return .=' </div><!-- end acc group -->';
	  
	return $return;
	
}
add_shortcode('accordion', 'zn_accordion');

/*--------------------------------------------------------------------------------------------------
	ToolTip
--------------------------------------------------------------------------------------------------*/
function zn_shortcode_tooltip( $atts, $content=null ) {
	// [tooltip placement="" border="yes" title=""] Content [/tooltip]
	extract(shortcode_atts(array(
		"placement" => 'top',
		"title" => '',
		"border" => 'yes'
	), $atts));	



	if ( empty ($placement) ) {
		
		$placement = 'top';
	}

	if ( $border == 'yes' ) {
		
		$border = 'class="stronger"';
	}
	else {

		$border = '';
	}

	$tooltipt = '<span '.$border.' data-rel="tooltip" data-placement="'.$placement.'" title="'.$title.'" data-animation="true">'.$content.'</span>';
	return $tooltipt;
	
 
}
add_shortcode('tooltip', 'zn_shortcode_tooltip');

/*--------------------------------------------------------------------------------------------------
	Icons
--------------------------------------------------------------------------------------------------*/
function zn_shortcode_icons( $atts, $content=null ) {
	// [icon white="false" ] ICON_NAME [/icon]
	extract(shortcode_atts(array(
		"white" => false
	), $atts));	

	if ( $white != 'false' ) {
		$css_white = 'icon-white';
	}
	else {
		$css_white = '';
	}

	$icon = '<i class="'.preg_replace('/\s+/','',$content).' '.$css_white.'"></i>';
	return $icon;
	
 
}

add_shortcode('icon', 'zn_shortcode_icons');


/*--------------------------------------------------------------------------------------------------
	TABLES styles
--------------------------------------------------------------------------------------------------*/
function zn_shortcode_table( $atts, $content = null ) {
	// TYPE : table , table-striped , table-bordered , table-hover , table-condensed
	
	// [table type="table-striped"] Content [/table]
	
	extract(shortcode_atts(array(
		"type" => 'table-striped'
	), $atts));
	
	return do_shortcode( str_replace ( '<table' ,'<table class="table '.$type.'"', $content ) );
	
}
add_shortcode('table', 'zn_shortcode_table');

/*--------------------------------------------------------------------------------------------------
	Buttons
--------------------------------------------------------------------------------------------------*/
function zn_shortcode_buttons( $atts, $content=null ) {
	// [button style="btn-primary" url="" size="" block="false" target="_self"] BUTTON TEXT [/button]
	extract(shortcode_atts(array(
		"style" => '',
		"size" => '',
		"block" => '',
		"url" => '',
		"target" => ''
	), $atts));	

	

	$button = ' <a href="'.$url.'" class="btn '.$size.' '.$style.' '.$block.'" target="'.$target.'" type="button">'.$content.'</a>';
	return $button;
	
 
}

add_shortcode('button', 'zn_shortcode_buttons');

/*--------------------------------------------------------------------------------------------------
	Pricing table
--------------------------------------------------------------------------------------------------*/
$columns = '';
$color = '';
function zn_shortcode_pricing_table( $atts, $content=null ) {
	// Colors : red , blue , green , turquoise , orange , purple , yellow , green_lemon , dark , light 
	// Space : no-space
	// [pricing_table color="red" columns="4" space="no" rounded="no"] PRICING COLUMNS [/pricing_table]
	global $columns,$color;
	extract(shortcode_atts(array(
		"columns" => '4',
		"color" => 'red',
		"rounded" => 'no',
		"space" => false
	), $atts));	

	if ( $space == 'no' ) {

		$space = 'no-space';

	}
	else {

		$space = '';

	}

	if ( $rounded == 'yes') {

		$rounded = 'rounded-corners';

	}
	else {

		$rounded = '';

	}

	$pricing = '<div class="row-fluid pricing_table '.$space.' '.$rounded.'">';
		$pricing .= do_shortcode($content);
	$pricing .= '</div>';

	return $pricing;
	
 
}

add_shortcode('pricing_table', 'zn_shortcode_pricing_table');


function zn_shortcode_pricing_column( $atts, $content=null ) {
	// [pricing_column name="" highlight="no" price="" price_value="" button_link="" button_text=""] PRICING COLUMNS [/pricing_column]
	extract(shortcode_atts(array(
		"name" => '',
		"highlight" => false,
		"price" => '',
		"price_value" => '',
		"button_link" => '',
		"button_text" => '',
	), $atts));	

	global $columns,$color;

	$span = 12/$columns;

	if ( $highlight == 'no' ){

		$is_highlight = '';

	}
	else {

		$is_highlight = 'highlight';

	}

	$pricing = '';
	$pricing .= '<div class="span'.$span.'">';
		$pricing .= '<div class="pr_table_col '.$is_highlight.'" data-color="'.$color.'">';
			$pricing .= '<div class="tb_header">';
				$pricing .= '<h4 class="ttitle">'.$name.'</h4>';
				$pricing .= '<div class="price"><p>'.$price.'<span>'.$price_value.'</span></p></div>';
			$pricing .= '</div>';

			$pricing .= do_shortcode(str_replace ( '<ul' ,'<ul class="tb_content"', $content ));

			$pricing .= '<div class="signin"><a class="btn" href="'.$button_link.'">'.$button_text.'</a></div>';
		$pricing .= '</div><!-- end pricing table column -->';
	$pricing .= '</div>';
	

	return $pricing;
	
 
}

add_shortcode('pricing_column', 'zn_shortcode_pricing_column');

function zn_shortcode_pricing_caption( $atts, $content=null ) {
	// [pricing_caption name=""] PRICING COLUMNS [/pricing_caption]
	extract(shortcode_atts(array(
		"name" => ''
	), $atts));	

	global $columns,$color;

	$span = 12/$columns;
	$pricing = '';
	$pricing .= '<div class="span'.$span.'">';
		$pricing .= '<div class="pr_table_col caption_column" data-color="'.$color.'">';
			$pricing .= '<div class="tb_header">';
				$pricing .= $name;
			$pricing .= '</div>';

			$pricing .= do_shortcode(str_replace ( '<ul' ,'<ul class="tb_content"', $content ));

		$pricing .= '</div><!-- end pricing table column -->';
	$pricing .= '</div>';
	

	return $pricing;
	
 
}

add_shortcode('pricing_caption', 'zn_shortcode_pricing_caption');


/*--------------------------------------------------------------------------------------------------
	TABS
--------------------------------------------------------------------------------------------------*/
  function zn_shortcode_tabs($atts, $content = null) {
	// [tabs style=""]  [tab title="TAB_NAME"] CONTENT [/tab]  [tab title="TAB_NAME"] CONTENT [/tab]  [tab title="TAB_NAME"] CONTENT [/tab][/tabs]

      if (isset($GLOBALS['tabs_count'])) $GLOBALS['tabs_count']++;
      else $GLOBALS['tabs_count'] = 0;
      extract(shortcode_atts(array(
          'tabtype' => 'nav-tabs',
          'style' => 'style1',
          'tabdirection' => '', ), $atts));

      preg_match_all('/tab title="([^\"]+)"/i', $content, $matches, PREG_OFFSET_CAPTURE);

      $tab_titles = array();
      if (isset($matches[1])) {
          $tab_titles = $matches[1];
      }

      $output = '';

      if (count($tab_titles)) {
          $output .= '<div class="tabbable tabs_'.$style.' tabs-'.$tabdirection.'"><ul class="nav '.$tabtype.'" id="custom-tabs-'.rand(1, 100).'">';

          $i = 0;
          foreach($tab_titles as $tab) {
              if ($i == 0) $output .= '<li class="active">';
              else $output .= '<li>';

              $output .= '<a href="#custom-tab-'.$GLOBALS['tabs_count'].'-'.sanitize_title($tab[0]).'"  data-toggle="tab">'.$tab[0].'</a></li>';
              $i++;
          }

          $output .= '</ul>';
          $output .= '<div class="tab-content">';
          $output .= do_shortcode($content);
          $output .= '</div></div>';
      } else {
          $output .= do_shortcode($content);
      }

      return $output;
  }

  function zn_shortcode_tab($atts, $content = null) {

      if (!isset($GLOBALS['current_tabs'])) {
          $GLOBALS['current_tabs'] = $GLOBALS['tabs_count'];
          $state = 'active';
      } else {

          if ($GLOBALS['current_tabs'] == $GLOBALS['tabs_count']) {
              $state = '';
          } else {
              $GLOBALS['current_tabs'] = $GLOBALS['tabs_count'];
              $state = 'active';
          }
      }

      $defaults = array('title' => 'Tab');
      extract(shortcode_atts($defaults, $atts));

      return '<div id="custom-tab-'.$GLOBALS['tabs_count'].'-'.sanitize_title($title).'" class="tab-pane '.$state.'">'.do_shortcode($content).'</div>';
  }

  add_shortcode('tabs', 'zn_shortcode_tabs');
  add_shortcode('tab', 'zn_shortcode_tab');


/*--------------------------------------------------------------------------------------------------
	SHOW CODE
--------------------------------------------------------------------------------------------------*/
function zn_shortcode_code( $atts, $content=null ) {
	// [code] BUTTON TEXT [/code]

	$content = str_replace('<br />', '', $content);
	$content = str_replace('<p>', '', $content);
	$content = str_replace('</p>', '', $content);

	$code = '<pre class="prettyprint linenums">'.htmlentities($content).'</pre>';
	return $code;
	
 
}

add_shortcode('code', 'zn_shortcode_code');
?>