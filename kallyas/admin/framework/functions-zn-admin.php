<?php

/**************************************************
*	Get default options
**************************************************/



function zn_get_default_values() 
{
	
	global $zn_options;
	include(locate_template(array('admin/options/theme-options.php'), false));
	
	$defaults = array();
	
	foreach ( $zn_options as $option)
	{
		
		if ( isset( $option['std'] ) )
		{
			// Add default Fonts also
			if ( $option['type'] == 'typography' )
			{
				if ( array_key_exists('face',$option['std'] ) )
				{
					$defaults['fonts'][$option['id']] = $option['std']['face'];
				}
			}
			
			$defaults[$option['id']] = $option['std'];
		}
		
	}
	
	return $defaults;
}




/**************************************************
*	Set default options on theme activation
**************************************************/
function zn_admin_init()
{	
	
	if (!get_option(OPTIONS)){
		
		$defaults = zn_get_default_values();
		
		generate_options_css($defaults); 
		generate_options_js($defaults); 
		update_option(OPTIONS,$defaults);
	}
	
}

global $pagenow;
if (is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" ) {
	//Call action that sets the default options
	add_action('admin_head','zn_admin_init');
}


/**************************************************
*	Use new media gallery
*************************************************/

	function enqueue_media_stuff(){
	
		if ( ! did_action( 'wp_enqueue_media' ) ) {
			wp_enqueue_media();
		}
	}
	add_action('admin_enqueue_scripts', 'enqueue_media_stuff');


/**************************************************
*	Create the shortcodes button
*************************************************/

add_action('init', 'zn_sc_button');


function zn_sc_button() {
 
   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
     return;
   }
 
   if ( get_user_option('rich_editing') == 'true' ) {
     add_filter( 'mce_external_plugins', 'add_plugin' );
     add_filter( 'mce_buttons', 'register_button' );
   }
 
}

function register_button( $buttons ) {
	array_push( $buttons, "|", "zn_button" );
	return $buttons;
}

function add_plugin( $plugin_array ) {
   $plugin_array['zn_button'] = get_template_directory_uri() . '/admin/js/zn_sc_button.js';
   return $plugin_array;
}

function zn_sc_dialog() {

$headings = array (
	'Page Subtitle' => '[subtitle] Content [/subtitle]',
	'H1 Alternative' => '[h1a] Content [/h1a]',
	'H2 Alternative' => '[h2a] Content [/h2a]',
	'H3 Alternative' => '[h3a] Content [/h3a]',
	'H4 Alternative' => '[h4a] Content [/h4a]',
	'H5 Alternative' => '[h5a] Content [/h5a]',
	'H6 Alternative' => '[h6a] Content [/h6a]'
);

$lists = array (
	'Arrow list' => '[list type="list-style1"] <ul><li> First list item </li> <li> Second list item </li> </ul> [/list]',
	'Check list' => '[list type="list-style2"] <ul><li> First list item </li> <li> Second list item </li> </ul> [/list]'
);

$blockquotes = array (
	'Left aligned' => '[blockquote author=""] Content [/blockquote]',
	'Right aligned' => '[blockquote author="" align=""] Content [/blockquote]'
);

$buttons = array (
	'Button' => '[button style="" url="" size="" block="false" target="_self"] BUTTON TEXT [/button]',
	'Button Primary' => '[button style="btn-primary" url="" size="" block="false" target="_self"] BUTTON TEXT [/button]',
	'Button info' => '[button style="btn-info" url="" size="" block="false" target="_self"] BUTTON TEXT [/button]',
	'Button success' => '[button style="btn-success" url="" size="" block="false" target="_self"] BUTTON TEXT [/button]',
	'Button warning' => '[button style="btn-warning" url="" size="" block="false" target="_self"] BUTTON TEXT [/button]',
	'Button danger' => '[button style="btn-danger" url="" size="" block="false" target="_self"] BUTTON TEXT [/button]',
	'Button inverse' => '[button style="btn-inverse" url="" size="" block="false" target="_self"] BUTTON TEXT [/button]'
);

$accordions = array(
	'Style 1' => '[accordion title="" style="default-style"] Content [/accordion]', 
	'Style 2' => '[accordion title="" style="style2"] Content [/accordion]', 
	'Style 3' => '[accordion title="" style="style3"] Content [/accordion]', 
	);

$misc = array (
	'QR Code' => '[qr align="right" size="140"] MECARD:N:Marius Hogas;ADR:MyStreet 22, Bucuresti;TEL:+ (50) 555 89 89;TEL:+ (50) 555 88 88;TEL:+ (50) 555 87 87;TEL:+ (50) 555 86 86;EMAIL:mhogas@gmail.com;URL:http://www.hogash.com/; [/qr]',
	'Code' => '[code] Content [/code]',	
	'Skills' => '[skills main_text="skills" main_color="#193340" text_color="#ffffff"] <br/>

[skill main_color="#97BE0D" percentage="95"] JavaScript [/skill]<br/>

[skill main_color="#D84F5F" percentage="90"] CSS3[/skill]<br/>

[skill main_color="#88B8E6" percentage="80"] HTML5[/skill]<br/>

[skill main_color="#BEDBE9" percentage="53"] PHP[/skill]<br/>

[skill main_color="#EDEBEE" percentage="45"] MySQL[/skill]<br/>

[/skills]',
	'Tooltip' => '[tooltip placement="top" border="yes" title="Tooltip Title"] Content [/tooltip]',
	'Icon' => '[icon white="false" ] icon-glass [/icon]',
);


$tables = array (
	'Striped' => '[table type="table-striped"] <table>
<thead>
<tr>
<th>#</th>
<th>First Name</th>
</tr>
</thead>
<tbody>
<tr>
<td>1</td>
<td>Mark</td>
</tr>
<tr>
<td>2</td>
<td>Jacob</td>
</tr>
<tr>
<td>3</td>
<td>Larry</td>
</tr>
</tbody>
</table> [/table]',
	'Bordered' => '[table type="table-bordered"] <table>
<thead>
<tr>
<th>#</th>
<th>First Name</th>
</tr>
</thead>
<tbody>
<tr>
<td>1</td>
<td>Mark</td>
</tr>
<tr>
<td>2</td>
<td>Jacob</td>
</tr>
<tr>
<td>3</td>
<td>Larry</td>
</tr>
</tbody>
</table> [/table]',
	'Hover Table' => '[table type="table-hover"] <table>
<thead>
<tr>
<th>#</th>
<th>First Name</th>
</tr>
</thead>
<tbody>
<tr>
<td>1</td>
<td>Mark</td>
</tr>
<tr>
<td>2</td>
<td>Jacob</td>
</tr>
<tr>
<td>3</td>
<td>Larry</td>
</tr>
</tbody>
</table> [/table]',
	'Condensed Table' => '[table type="table-condensed"] <table>
<thead>
<tr>
<th>#</th>
<th>First Name</th>
</tr>
</thead>
<tbody>
<tr>
<td>1</td>
<td>Mark</td>
</tr>
<tr>
<td>2</td>
<td>Jacob</td>
</tr>
<tr>
<td>3</td>
<td>Larry</td>
</tr>
</tbody>
</table> [/table]',
);

$layouts = array (
	'Row' => '[row] Content [/row]',
	'Two Columns' => '[one_half_column] Content [/one_half_column]',
	'1/3 Columns' => '[one_third_column] Content [/one_third_column]',
	'1/4 Columns' => '[one_fourth_column] Content [/one_fourth_column]',
	'2/3 Columns' => '[two_third_column] Content [/two_third_column]',
	'3/4 Columns' => '[three_fourth_column] Content [/three_fourth_column]',
);

$pricing = array (
	'Red' => '[pricing_table color="red" columns="4" space="no" rounded="no"]

[pricing_column name="Starter" highlight="no" price="$6.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Standard" highlight="yes" price="$9.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Professional" highlight="no" price="$13.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Ultra" highlight="no" price="$99.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[/pricing_table]',

	'Blue' => '[pricing_table color="blue" columns="4" space="no" rounded="no"]

[pricing_column name="Starter" highlight="no" price="$6.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Standard" highlight="yes" price="$9.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Professional" highlight="no" price="$13.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Ultra" highlight="no" price="$99.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[/pricing_table]',

	'Green' => '[pricing_table color="green" columns="4" space="no" rounded="no"]

[pricing_column name="Starter" highlight="no" price="$6.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Standard" highlight="yes" price="$9.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Professional" highlight="no" price="$13.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Ultra" highlight="no" price="$99.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[/pricing_table]',

	'Turquoise' => '[pricing_table color="turquoise" columns="4" space="no" rounded="no"]

[pricing_column name="Starter" highlight="no" price="$6.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Standard" highlight="yes" price="$9.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Professional" highlight="no" price="$13.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Ultra" highlight="no" price="$99.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[/pricing_table]',

	'Orange' => '[pricing_table color="orange" columns="4" space="no" rounded="no"]

[pricing_column name="Starter" highlight="no" price="$6.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Standard" highlight="yes" price="$9.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Professional" highlight="no" price="$13.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Ultra" highlight="no" price="$99.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[/pricing_table]',

	'Purple' => '[pricing_table color="purple" columns="4" space="no" rounded="no"]

[pricing_column name="Starter" highlight="no" price="$6.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Standard" highlight="yes" price="$9.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Professional" highlight="no" price="$13.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Ultra" highlight="no" price="$99.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[/pricing_table]',

	'Yellow' => '[pricing_table color="yellow" columns="4" space="no" rounded="no"]

[pricing_column name="Starter" highlight="no" price="$6.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Standard" highlight="yes" price="$9.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Professional" highlight="no" price="$13.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Ultra" highlight="no" price="$99.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[/pricing_table]',

	'Green Lemon' => '[pricing_table color="green_lemon" columns="4" space="no" rounded="no"]

[pricing_column name="Starter" highlight="no" price="$6.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Standard" highlight="yes" price="$9.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Professional" highlight="no" price="$13.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Ultra" highlight="no" price="$99.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[/pricing_table]',

	'Dark' => '[pricing_table color="dark" columns="4" space="no" rounded="no"]

[pricing_column name="Starter" highlight="no" price="$6.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Standard" highlight="yes" price="$9.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Professional" highlight="no" price="$13.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Ultra" highlight="no" price="$99.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[/pricing_table]',

	'Light' => '[pricing_table color="light" columns="4" space="no" rounded="no"]

[pricing_column name="Starter" highlight="no" price="$6.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Standard" highlight="yes" price="$9.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Professional" highlight="no" price="$13.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Ultra" highlight="no" price="$99.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[/pricing_table]',

	'Caption' => '[pricing_table color="red" columns="4" space="no" rounded="no"]
[pricing_caption name="TITLE"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_caption]

[pricing_column name="Standard" highlight="yes" price="$9.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Professional" highlight="no" price="$13.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[pricing_column name="Ultra" highlight="no" price="$99.99" price_value="per month" button_link="#" button_text="ORDER NOW"]
<ul>
	<li>TEXT</li>
	<li>TEXT</li>
</ul>
[/pricing_column]

[/pricing_table]',

);

$tabs = array (
	'Style 1' => '[tabs style="style1"]<br/>
	[tab title="TAB_NAME"] CONTENT [/tab]<br/>
	[tab title="TAB_NAME"] CONTENT [/tab]<br/>
	[tab title="TAB_NAME"] CONTENT [/tab]<br/>
	[/tabs]<br/>',
	'Style 2' => '[tabs style="style2"]<br/>
	[tab title="TAB_NAME"] CONTENT [/tab]<br/>
	[tab title="TAB_NAME"] CONTENT [/tab]<br/>
	[tab title="TAB_NAME"] CONTENT [/tab]<br/>
	[/tabs]<br/>',
	'Style 3' => '[tabs style="style3"]<br/>
	[tab title="TAB_NAME"] CONTENT [/tab]<br/>
	[tab title="TAB_NAME"] CONTENT [/tab]<br/>
	[tab title="TAB_NAME"] CONTENT [/tab]<br/>
	[/tabs]<br/>',
	'Style 4' => '[tabs style="style4"]<br/>
	[tab title="TAB_NAME"] CONTENT [/tab]<br/>
	[tab title="TAB_NAME"] CONTENT [/tab]<br/>
	[tab title="TAB_NAME"] CONTENT [/tab]<br/>
	[/tabs]<br/>'
);

$categories = array (  
						'Headings' => $headings,
						'Lists' => $lists,
						'Tables' => $tables,
						'Blockquotes' => $blockquotes,
						'Misc' => $misc,
						'Layouts' => $layouts,
						'Buttons' => $buttons,
						'PricingTables' => $pricing,
						'Accordions' => $accordions,
						'Tabs' => $tabs
					);




$page = '';
$i = '0';


	echo '<div class="zn_sc_dialog">';
	
	
	?>
	
	<div id="zn_sidebar">
		<div id="zn-nav">
			<ul class="zn_activate_nav">
				<?php
					foreach ( $categories as $name => $shortcodes ) {
						$cls = '';
						if ( $i == '0') { $cls = 'active'; }
						echo '<li><a rel="" href="#zn_page_'.$name.'" class="normal '.$cls.'">'.$name.'</a></li>';
					
						
							$page .= '<div id="zn_page_'.$name.'" class="zn_page">';
								$page .= '<h4 class="heading">'.$name.'</h4>';
								foreach ( $shortcodes as $shortcode_name => $shortcode_value ) {
									$page .= '<div class="zn_sc_container"><div class="zn_sc_title">'.$shortcode_name.'</div><div class="zn_shortcode_text">'.$shortcode_value.'</div></div>';
								}
							$page .= '</div>';
						
						$i++;
					}
				?>
			
			</ul>
		</div>
	</div>
	
	<div id="content">

		<?php echo $page;?>
		
	</div>
	
	<?php
	
	

	
	echo '</div>';
}

/*-----------------------------------------------------------------------------------*/
/* ZN Framework Admin Interface - zn_framework_add_admin */
/*-----------------------------------------------------------------------------------*/

function zn_framework_add_admin() {
	
    $zn_page = add_menu_page(THEMENAME, THEMENAME . ' Options', 'edit_theme_options', THEMENAME,'zn_framework_options_page',ADMIN_IMAGES_DIR.'/favicon.png');
    $zn_woo_options = add_submenu_page( THEMENAME, 'Woocommerce Options', 'Woocommerce Options', 'edit_theme_options', 'zn_woo_page', 'zn_woo_options_page' );


	// Add framework functionaily to the head individually
	add_action("admin_print_scripts-$zn_page", 'of_load_only');
	add_action("admin_print_scripts-$zn_woo_options", 'of_load_only');
	add_action("admin_print_styles-$zn_page",'of_style_only');
	add_action("admin_print_styles-$zn_woo_options",'of_style_only');
	

	if(basename( $_SERVER['PHP_SELF']) == "post-new.php" || basename( $_SERVER['PHP_SELF']) == "post.php" )
	{	
		of_load_only();
		of_style_only();
		add_action('admin_footer', 'zn_sc_dialog');
	}
	
	
} 

add_action('admin_menu', 'zn_framework_add_admin');

/*-----------------------------------------------------------------------------------*/
/* Build the Options Page  */
/*-----------------------------------------------------------------------------------*/

function zn_framework_options_page(){

	$html = new zn_html();

	global $zn_options, $zn_admin_menu;
	include(locate_template(array('admin/options/theme-options.php'), false));
	echo $html->zn_show_options($zn_options ,$zn_admin_menu ); 

}

/*-----------------------------------------------------------------------------------*/
/* Build the WooCommerce Options Page  */
/*-----------------------------------------------------------------------------------*/

function zn_woo_options_page(){
	$html = new zn_html();

	global $zn_options, $zn_admin_menu;
	include(locate_template(array('admin/options/woocommerce-options.php'), false));
	echo $html->zn_show_options($zn_options ,$zn_admin_menu ); 

}


/*-----------------------------------------------------------------------------------*/
/* Load Inline scripts to footer
/*-----------------------------------------------------------------------------------*/
function add_this_script_footer(){ 

	?>
	<script type="text/javascript">
		(function($){
			var doc = {
				ready: function(){
					slider.init();
					
					jQuery('.zn-remove-image').live('click',function(){
						jQuery(this).parents('.controls').children('.zn_upload_image_button').prev().val('');
						jQuery(this).parent().html('Nothing selected...<a class="zn-remove-image" href="#">remove</a>');
						return false; 
						
					})
				}
			},
			
			slider = {
				// the following 2 objects would be our backup containers
				// as we will be replacing the default media handlers
				media_send_attachment: null,
				field : false,
				media_close_window: null,
				init: function(){
					// bind the button's click the browse_clicked handler

						$('.zn_upload_image_button').live("click", 	slider.browse_clicked);

					
				},
				browse_clicked: function(event){
					// cancel the event so we won't be navigated to href="#"
					event.preventDefault();
					
					slider.field = jQuery(this).prev();
					slider.field_alt = jQuery(this).parent().find('.zn_img_alt');
					slider.field_title = jQuery(this).parent().find('.zn_img_title');
					
					// backup editor objects first
					slider.media_send_attachment = wp.media.editor.send.attachment;
					slider.media_close_window = wp.media.editor.remove;

					// override the objects with our own
					wp.media.editor.send.attachment = slider.media_accept;
					wp.media.editor.remove = slider.media_close;

					// open up the media manager window
					wp.media.editor.open();
				},
				media_accept: function(props, attachment){
					// this function is called when the media manager sends in media info
					// when the user clicks the "Insert into Post" button
					// this may be called multiple times (one for each selected file) 
					// you might be interested in the following:
					// alert(attachment.id); // this stands for the id of the media attachment passed
					// alert(attachment.url); // this is the url of the media attachment passed
					// for now let's log it the console
					// not you can do anything Javascript-ly possible here
					
						if (slider.field !=false) {
							console.log(attachment);
							console.log(slider.field_alt);
							console.log(slider.field_title);
							
							if ( attachment.filename.match(/.jpg$|.jpeg$|.ico$|.png$|.gif$/) ) {
								imgurl = attachment.url;
								slider.field.val(imgurl);
								slider.field_alt.val(attachment.alt);
								slider.field_title.val(attachment.title);

									image = '<a href="#" class="zn-remove-image">remove</a><img class="zn_mu_image" src="'+imgurl+'" alt="" />';
								
								slider.field.parent().children('.zn-image-holder').html(image);
								
								
							}
							else {

								imgurl = attachment.url;
								slider.field.val(imgurl);
								
								image = '<div class="attachment-preview type-video subtype-mp4 landscape"><img draggable="false" class="icon" src="<?php echo IMAGES_URL; ?>/video.png"><div class="filename"><div>'+ attachment.filename +'</div></div></div>'
								
								//image = '<a href="#" class="zn-remove-image">remove</a>Media Selected';
								slider.field.parent().children('.zn-image-holder').html(image);
								
							}
							
						}
					
				//	console.log(props);
				//	console.log(attachment);
				},
				media_close: function(id){
					// this function is called when the media manager wants to close
					// (either close button or after sending the selected items)

					// restore editor objects from backup
					wp.media.editor.send.attachment = slider.media_send_attachment;
					wp.media.editor.remove = slider.media_close_window;

					// nullify the backup objects to free up some memory
					slider.media_send_attachment= null;
					slider.media_close_window= null;

					// trigger the actual remove
					wp.media.editor.remove(id);
				}
			};
			$(document).ready(doc.ready);
		})(jQuery);
	</script> 
	<?php

 } 

add_action('admin_footer', 'add_this_script_footer');

/*-----------------------------------------------------------------------------------*/
/* Load required styles for Options Page - of_style_only */
/*-----------------------------------------------------------------------------------*/

function of_style_only(){
	// Needed for image upload

	wp_enqueue_style('zn-admin-style', ADMIN_MASTER_ADMIN_DIR . 'css/zn-admin-style.css');
	
	
	wp_enqueue_style('zn-color-picker', ADMIN_MASTER_ADMIN_DIR . 'css/colorpicker.css');
	wp_enqueue_style('zn-time-picker', ADMIN_MASTER_ADMIN_DIR . 'css/jquery.timepicker.css');
	wp_enqueue_style('zn-jquery-ui', ADMIN_MASTER_ADMIN_DIR . 'css/jquery-ui-1.8.16.custom.css');

}	

/*-----------------------------------------------------------------------------------*/
/* Load required javascripts for Options Page - of_load_only */
/*-----------------------------------------------------------------------------------*/

function of_load_only() {

	
	//wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('jquery-ui-slider');
	wp_enqueue_script('jquery-ui-button');
	
	// Needed for image upload
	wp_enqueue_script('media-upload');

	wp_register_script('jquery-input-mask', ADMIN_MASTER_ADMIN_DIR .'js/jquery.maskedinput-1.2.2.js', array( 'jquery' ));
	wp_enqueue_script('jquery-input-mask');
	wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_script('zn-color-picker', ADMIN_MASTER_ADMIN_DIR .'js/colorpicker.js', array('jquery'));
	wp_enqueue_script('zn-time-picker', ADMIN_MASTER_ADMIN_DIR .'js/jquery.timepicker.min.js', array('jquery'));
	//wp_enqueue_script('ajaxupload', ADMIN_MASTER_ADMIN_DIR .'js/ajaxupload.js', array('jquery'));
	//wp_enqueue_script('cookie', ADMIN_MASTER_ADMIN_DIR . '/js/jquery.cookie.js', 'jquery');
	wp_enqueue_script('tipsy', ADMIN_MASTER_ADMIN_DIR . '/js/jquery.tipsy.js', 'jquery');
	wp_enqueue_script('asmselect', ADMIN_MASTER_ADMIN_DIR . '/js/jquery.asmselect.js', 'jquery');
	wp_enqueue_script('zn-admin-scripts', ADMIN_MASTER_ADMIN_DIR . '/js/zn-admin-scripts.js', 'jquery');
	wp_enqueue_script('zn-ajax-options', ADMIN_MASTER_ADMIN_DIR . '/js/zn-ajax-options.js', 'jquery');
		// Registers custom scripts for the Media Library AJAX uploader.
}



/*-----------------------------------------------------------------------------------*/
/* Get element fields from id
/*-----------------------------------------------------------------------------------*/
function zn_get_element_from_id( $id ) {

	// INCLUDE the options files
	global $zn_meta_elements,$extra_options,$zn_options;
	include(locate_template(array('admin/options/zn-meta-boxes.php'), false));
	include(locate_template(array('admin/options/theme-options.php'), false));
		
	$options = array_merge($zn_options,$zn_meta_elements,$extra_options);	
	
	foreach($options as $option) {
		if(!isset($option['id'])) {$option['id'] = '';}
		if($option['id'] == $id) {
			
			$option['dynamic'] = true;
			return $option;
		}

	}
}

/*-----------------------------------------------------------------------------------*/
/* Re-ENABLE THE DUMMY ISNTALL BUTTON
/*-----------------------------------------------------------------------------------*/
if (is_admin() && isset($_GET['enable_dummy_install'] ) ) {
	//Call action that sets
	update_option(THEMENAME.'_dummy',0);
	header('Location: '.get_admin_url().'?page='.THEMENAME, true, 302);
}



/* For use in themes */
$data = get_option(OPTIONS);

/*-----------------------------------------------------------------------------------*/
/* Create Dynamic Css*/
/*-----------------------------------------------------------------------------------*/
function generate_options_css($newdata) {

	/** Define some vars **/
	$data = $newdata;
	$uploads = wp_upload_dir();
	$css_dir = get_template_directory() . '/css/'; // Shorten code, save 1 call
	
	/** Save on different directory if on multisite **/
	if(is_multisite()) {
		$zn_uploads_dir = trailingslashit($uploads['basedir']);
	} else {
		$zn_uploads_dir = $css_dir;
	}
	
	/** Capture CSS output **/
	ob_start();
	require($css_dir . 'styles.php');
	$css = ob_get_clean();
	
	/** Write to options.css file **/
	file_put_contents($zn_uploads_dir . 'options.css', $css);

}

/*-----------------------------------------------------------------------------------*/
/* Create Dynamic Js*/
/*-----------------------------------------------------------------------------------*/
function generate_options_js($newdata) {

return;

}

/*-----------------------------------------------------------------------------------*/
/* Auto Update the theme
/*-----------------------------------------------------------------------------------*/
	if ( !empty( $data['zn_theme_username'] ) && !empty( $data['zn_theme_api'] ) ) {

		$username = $data['zn_theme_username'];
		$apikey = $data['zn_theme_api'];
		$author = 'Hogash';

		require_once("class-pixelentity-theme-update.php");
		PixelentityThemeUpdate::init($username,$apikey,$author);
			
	}

/*-----------------------------------------------------------------------------------*/
/* CHECK IF REQUIRED FILES ARE WRITEABLE
/*-----------------------------------------------------------------------------------*/

global $zn_has_error;

$zn_has_error = array();

	$css_dir = get_template_directory() . '/css/';
	$uploads = wp_upload_dir();

	if(is_multisite()) {
		$zn_uploads_dir = trailingslashit($uploads['basedir']);
	} else {
		$zn_uploads_dir = $css_dir;
	}

$css_file = $zn_uploads_dir.'options.css';

if ( !is_writable($css_file) ) {
	$zn_has_error[] = '<br/>Please make sure that the bellow files exists and have the proper file permissions ( 644 or 777 ) and belong to the same user group as the rest of the wordpress files. Until you set the proper permissions to those files , you won\'n be able to change any color/bacgrounds <br/>';
	$zn_has_error[] = $css_file.' <b>IS NOT WRITEABLE OR DOESN\'T EXISTS</b>';

	$zn_has_error[] = '<br/><h3>HOW TO RESOLVE THIS :</h3>';
	$zn_has_error[] = '+ If this is the first time you use the theme or you\'ve just updated the theme , save the options and refresh the page<br/>';
	$zn_has_error[] = '+ If the above step didn\'t removed this message, using a FTP client, please check that the above mentioned files are present in the mentioned directories. If the files are not present, please manually create them and then save the options again and refresh the page.';


}

/*--------------------------------------------------------------------------------------------------
	Add options for the portfolio and Documentation
--------------------------------------------------------------------------------------------------*/
function zn_permalink_settings_init() {

	// Add a section to the permalinks page
	add_settings_section( 'zn-portfolio-permalink', 'Portfolio Slugs', '', 'permalink' );
	add_settings_section( 'zn-doc-permalink', 'Documentation Slugs', '', 'permalink' );

	// Add our settings
	add_settings_field(
		'zn_portfolio_item_slug_input',      	// id
		'Portfolio item slug', 	// setting title
		'zn_portfolio_item_slug',  // display callback
		'permalink',                 				// settings page
		'zn-portfolio-permalink'                  				// settings section
	);

	// Add our settings
	add_settings_field(
		'zn_portfolio_taxonomy_slug_input',      	// id
		'Portfolio taxonomy slug', 	// setting title
		'zn_portfolio_taxonomy_slug',  // display callback
		'permalink',                 				// settings page
		'zn-portfolio-permalink'                  				// settings section
	);

	// Add our settings
	add_settings_field(
		'zn_doc_item_slug_input',      	// id
		'Documentation taxonomy slug', 	// setting title
		'zn_doc_item_slug',  // display callback
		'permalink',                 				// settings page
		'zn-doc-permalink'                  				// settings section
	);

	// Add our settings
	add_settings_field(
		'zn_doc_taxonomy_slug_input',      	// id
		'Documentation taxonomy slug', 	// setting title
		'zn_doc_taxonomy_slug',  // display callback
		'permalink',                 				// settings page
		'zn-doc-permalink'                  				// settings section
	);

}

add_action( 'admin_init', 'zn_permalink_settings_init' );

/*--------------------------------------------------------------------------------------------------
	Permalinks actual options
--------------------------------------------------------------------------------------------------*/
function zn_portfolio_item_slug() {
	$permalinks = get_option( 'zn_permalinks' );
	?>
	<input name="zn_portfolio_item_slug_input" type="text" class="regular-text code" value="<?php if ( isset( $permalinks['port_item'] ) ) echo esc_attr( $permalinks['port_item'] ); ?>" placeholder="portfolio" />
	<?php
}

function zn_portfolio_taxonomy_slug() {
	$permalinks = get_option( 'zn_permalinks' );
	?>
	<input name="zn_portfolio_taxonomy_slug_input" type="text" class="regular-text code" value="<?php if ( isset( $permalinks['port_tax'] ) ) echo esc_attr( $permalinks['port_tax'] ); ?>" placeholder="project_category" />
	<?php
}

function zn_doc_item_slug() {
	$permalinks = get_option( 'zn_permalinks' );
	?>
	<input name="zn_doc_item_slug_input" type="text" class="regular-text code" value="<?php if ( isset( $permalinks['doc_item'] ) ) echo esc_attr( $permalinks['doc_item'] ); ?>" placeholder="documentation" />
	<?php
}

function zn_doc_taxonomy_slug() {
	$permalinks = get_option( 'zn_permalinks' );
	?>
	<input name="zn_doc_taxonomy_slug_input" type="text" class="regular-text code" value="<?php if ( isset( $permalinks['doc_tax'] ) ) echo esc_attr( $permalinks['doc_tax'] ); ?>" placeholder="documentation_category" />
	<?php
}


/*--------------------------------------------------------------------------------------------------
	Save the permalinks options
--------------------------------------------------------------------------------------------------*/
function zn_permalink_settings_save() {
	if ( ! is_admin() )
		return;

	// We need to save the options ourselves; settings api does not trigger save for the permalinks page
	if ( isset( $_POST['permalink_structure'] ) || isset( $_POST['zn_portfolio_item_slug_input'] ) ) {
		// Portfolio items slug
		$zn_portfolio_item_slug_input = sanitize_text_field( $_POST['zn_portfolio_item_slug_input'] );
		$zn_portfolio_taxonomy_slug_input = sanitize_text_field( $_POST['zn_portfolio_taxonomy_slug_input'] );

		// Documentatin items slug
		$zn_doc_item_slug_input = sanitize_text_field( $_POST['zn_doc_item_slug_input'] );
		$zn_doc_taxonomy_slug_input = sanitize_text_field( $_POST['zn_doc_taxonomy_slug_input'] );


		$permalinks = get_option( 'zn_permalinks' );
		if ( ! $permalinks )
			$permalinks = array();

		$permalinks['port_item'] 	= untrailingslashit( $zn_portfolio_item_slug_input );
		$permalinks['port_tax'] 	= untrailingslashit( $zn_portfolio_taxonomy_slug_input );
		$permalinks['doc_item'] 	= untrailingslashit( $zn_doc_item_slug_input );
		$permalinks['doc_tax'] 	= untrailingslashit( $zn_doc_taxonomy_slug_input );

		update_option( 'zn_permalinks', $permalinks );
	}
}

add_action( 'admin_init', 'zn_permalink_settings_save' );

/*--------------------------------------------------------------------------------------------------
	AJAX CALLBACK
--------------------------------------------------------------------------------------------------*/
add_action('wp_ajax_zn_ajax_post_action', 'zn_ajax_callback');

function zn_ajax_callback() {

	$nonce=$_POST['security'];
	
	if (! wp_verify_nonce($nonce, 'zn_ajax_nonce') ) die('-1'); 
			
	//get options array from db
	$all = get_option(OPTIONS);
		
	$save_type = $_POST['type'];
	

	if ($save_type == 'save') {
	
		$_POST = array_map( 'stripslashes_deep', $_POST );
		parse_str($_POST['data'], $data);
		unset($data['security']);
		unset($data['of_save']);
   
		$args = wp_parse_args( $data, $all );
   
		update_option(OPTIONS, $args);
		generate_options_css($args); //generate static css file
		generate_options_js($args); //generate static js file
		
		echo '1'; 
		
	} 
	elseif ($save_type == 'zn_restore_options') {

		$saved_backup = get_option($_POST['data']);

		update_option(OPTIONS, $saved_backup);
		generate_options_css($args); //generate static css file
		generate_options_js($args); //generate static js file
		ob_clean();
		echo '1'; 

	} 
	elseif ($save_type == 'zn_delete_backup') {

		$saved_backup = delete_option($_POST['data']);
		ob_clean();
		echo '1'; 

	} 
	elseif ($save_type == 'install_dummy') {

		locate_template(array('admin/dummy_content/zn_importer.php'), true, true);
		installDummy();

	} 
	elseif ($save_type == 'zn_backup_options') {

		$_POST = array_map( 'stripslashes_deep', $_POST );
		parse_str($_POST['data'], $data);
		unset($data['security']);
		unset($data['of_save']);
   
		$args = wp_parse_args( $data, $all );
   
		$date = date('Y m d H i s');

		$option_field = THEMENAME.'_backup_from_' . str_replace(' ', '_', $date);
		$option_field = strtolower($option_field);

		add_option($option_field, $args,'' , 'no');
		ob_clean();
		echo $option_field; 
		
	} 
	elseif ($save_type == 'add_element') {
		
		//$what_element = $_POST['data'];
		
		$html = new zn_html();
		parse_str(($_POST['data']),$data);
		
		
		// Make a check to see if the element is a subelement 
		// All subelements options must be placed in the same array that is passed to zn_get_element_from_id() function in functions-zn-admin.php !!
		$full_id = $data['element_type'];
		
		if( preg_match( '/\[(\d+)\]/', $full_id, $matches ) )
		{
			
			$split_element_type = preg_split('/\[(\d+)\]/', $full_id);
			$number_of_ids = count($split_element_type)-1;
			$string = str_replace('[','',$split_element_type[$number_of_ids]);
			$string = str_replace(']','',$string);
			
			$data['element_type'] = $string;
			
		}
		
		$option = zn_get_element_from_id($data['element_type']);
				
		if ( isset ( $option['link'] ) ) 
		{
			$option['is_dynamic'] = true;
		}
		
		$option['id'] = $full_id;
		if ( isset ( $data['pb_area'] ) && !empty ( $data['pb_area'] ) ) {
			$option['pb_area'] = $data['pb_area'];		
		}
		
		
		echo $html->zn_render_element($option); 
		
		//print_r($option);
		
		unset($data['security']);
		unset($data['of_save']);
				
		die(1); 
		
	} 


  die();

}



?>
