<?php

$sample_image_id = '';

/*--------------------------------------------------------------------------------------------------
	Main function for importing dummy data
--------------------------------------------------------------------------------------------------*/
if ( ! function_exists( 'installDummy' ) ) {
	function installDummy(){	

		if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);
			require_once ABSPATH . 'wp-admin/includes/import.php';
			$importer_error = false;

		if ( !class_exists( 'WP_Importer' ) ) {
			$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
			if ( file_exists( $class_wp_importer ) )
			{
				require_once($class_wp_importer);
			}
			else
			{
				$importer_error = true;
			}
		}

		if ( !class_exists( 'WP_Import' ) ) {
			$class_wp_import = get_template_directory() . '/admin/dummy_content/wordpress-importer/wordpress-importer.php';
			if ( file_exists( $class_wp_import ) )
			{

				require_once($class_wp_import);
				
			}
			else
			{
				$importer_error = true;
			}	  
		}

		if($importer_error)
		{
			die("Import error! Please unninstall Wordpress importer plugin and try again");
		}
		else
		{
			if(!is_file(get_template_directory()."/admin/dummy_content/dummy.xml"))
			{
				echo "The XML file containing the dummy content is not available or could not be read in <pre>".get_template_directory()."/admin/dummy_content/dummy.xml</pre>";
			}
			else
			{

				$wp_import = new wp_import();
				$wp_import->fetch_attachments = false;
				$wp_import->import(get_template_directory()."/admin/dummy_content/dummy.xml");
				setMenus();
				zn_set_options();
				//setWidgets();

				update_option(THEMENAME.'_dummy',1);
			}
		}

	}
}

/*--------------------------------------------------------------------------------------------------
	ZN Set menus
--------------------------------------------------------------------------------------------------*/
if ( ! function_exists( 'setMenus' ) ) {
	function setMenus() {
		
		global $wpdb;
		$table_db_name = $wpdb->prefix . "terms";
		$rows = $wpdb->get_results("SELECT * FROM $table_db_name where  name='Main Menu'",ARRAY_A);
		$menu_ids = array();
		foreach($rows as $row) {
			$menu_ids[$row["name"]] = $row["term_id"] ;
		}
		
		if ( has_nav_menu( 'main_navigation' ) ) {
			 //Do something
		}
		else {
			set_theme_mod( 'nav_menu_locations', array_map( 'absint', array(   'main_navigation' =>$menu_ids['Main Menu'] ) ) );
		}
		
		
	}
}

/*--------------------------------------------------------------------------------------------------
	ZN Set THEME OPTIONS
--------------------------------------------------------------------------------------------------*/
if ( ! function_exists( 'zn_set_options' ) ) {
	function zn_set_options() {
		
		// THIS IS THE EXPORTED THEME OPTIONS
		$import_code = 'YTo3MDp7czoxMToibWVudV9mb2xsb3ciO3M6MzoieWVzIjtzOjE0OiJwYWdlX3ByZWxvYWRlciI7czoyOiJubyI7czoxNToiaGVhZF9zaG93X2xvZ2luIjtzOjE6IjEiO3M6MTE6ImxvZ29fdXBsb2FkIjtzOjY5OiJodHRwOi8vaG9nYXNoLWRlbW8uY29tL2thbGx5YXNfd3Avd3AtY29udGVudC91cGxvYWRzLzIwMTMvMDEvbG9nby5wbmciO3M6OToibG9nb19zaXplIjtzOjM6InllcyI7czoxNjoibG9nb19tYW51YWxfc2l6ZSI7YToyOntzOjU6IndpZHRoIjtzOjM6IjEyNiI7czo2OiJoZWlnaHQiO3M6MjoiNDIiO31zOjk6ImxvZ29fZm9udCI7YTo0OntzOjQ6InNpemUiO3M6NDoiMzZweCI7czo2OiJoZWlnaHQiO3M6NDoiNDBweCI7czo1OiJzdHlsZSI7czo2OiJub3JtYWwiO3M6NToiY29sb3IiO3M6NDoiIzAwMCI7fXM6NToiZm9udHMiO2E6Nzp7czo5OiJsb2dvX2ZvbnQiO3M6OToiTm92YSBNb25vIjtzOjc6ImgxX3R5cG8iO3M6OToiT3BlbiBTYW5zIjtzOjc6ImgyX3R5cG8iO3M6OToiT3BlbiBTYW5zIjtzOjc6ImgzX3R5cG8iO3M6OToiT3BlbiBTYW5zIjtzOjc6Img0X3R5cG8iO3M6OToiT3BlbiBTYW5zIjtzOjc6Img1X3R5cG8iO3M6OToiT3BlbiBTYW5zIjtzOjc6Img2X3R5cG8iO3M6OToiT3BlbiBTYW5zIjt9czoxMDoibG9nb19ob3ZlciI7YToxOntzOjU6ImNvbG9yIjtzOjc6IiNDRDIxMjIiO31zOjE0OiJjdXN0b21fZmF2aWNvbiI7czo3MjoiaHR0cDovL2hvZ2FzaC1kZW1vLmNvbS9rYWxseWFzX3dwL3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDEzLzAxL2Zhdmljb24ucG5nIjtzOjc6ImgxX3R5cG8iO2E6Mzp7czo0OiJzaXplIjtzOjQ6IjM2cHgiO3M6NjoiaGVpZ2h0IjtzOjQ6IjQwcHgiO3M6NToic3R5bGUiO3M6Njoibm9ybWFsIjt9czo3OiJoMl90eXBvIjthOjM6e3M6NDoic2l6ZSI7czo0OiIzMHB4IjtzOjY6ImhlaWdodCI7czo0OiI0MHB4IjtzOjU6InN0eWxlIjtzOjY6Im5vcm1hbCI7fXM6NzoiaDNfdHlwbyI7YTozOntzOjQ6InNpemUiO3M6NDoiMjRweCI7czo2OiJoZWlnaHQiO3M6NDoiNDBweCI7czo1OiJzdHlsZSI7czo2OiJub3JtYWwiO31zOjc6Img0X3R5cG8iO2E6Mzp7czo0OiJzaXplIjtzOjQ6IjE4cHgiO3M6NjoiaGVpZ2h0IjtzOjQ6IjIwcHgiO3M6NToic3R5bGUiO3M6Njoibm9ybWFsIjt9czo3OiJoNV90eXBvIjthOjM6e3M6NDoic2l6ZSI7czo0OiIxNHB4IjtzOjY6ImhlaWdodCI7czo0OiIyMHB4IjtzOjU6InN0eWxlIjtzOjY6Im5vcm1hbCI7fXM6NzoiaDZfdHlwbyI7YTozOntzOjQ6InNpemUiO3M6NDoiMTJweCI7czo2OiJoZWlnaHQiO3M6NDoiMjBweCI7czo1OiJzdHlsZSI7czo2OiJub3JtYWwiO31zOjE1OiJoZWFkX3Nob3dfZmxhZ3MiO3M6MToiMSI7czoxNDoiY29weXJpZ2h0X3RleHQiO3M6MTMxOiLCqSAyMDEyIEtBTExZQVMgVGVtcGxhdGUuIEFsbCBSaWdodHMgUmVzZXJ2ZWQuIDxhIGhyZWY9XCJcIj5DbGljayBoZXJlIHRvIGJ1eSBpdDwvYT4uPGJyLz4NCkRlc2lnbmVkIGJ5IEhPR0FTSCAmIERldmVsb3BlZCBieSBaYXVhbiI7czoyODoiZm9vdGVyX3JvdzFfd2lkZ2V0X3Bvc2l0aW9ucyI7czoyOToie1wiM1wiOltbXCI1XCIsXCI0XCIsXCIzXCJdXX0iO3M6Mjg6ImZvb3Rlcl9yb3cyX3dpZGdldF9wb3NpdGlvbnMiO3M6MjM6IntcIjJcIjpbW1wiNlwiLFwiNlwiXV19IjtzOjExOiJmb290ZXJfbG9nbyI7czo3MDoiaHR0cDovL2hvZ2FzaC1kZW1vLmNvbS9rYWxseWFzX3dwL3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDEzLzAxL2xvZ28yLnBuZyI7czoxOToiZm9vdGVyX3NvY2lhbF9pY29ucyI7YTo0OntpOjA7YTo0OntzOjIwOiJkeW5hbWljX2VsZW1lbnRfdHlwZSI7czoxOToiZm9vdGVyX3NvY2lhbF9pY29ucyI7czoxOToiZm9vdGVyX3NvY2lhbF90aXRsZSI7czo4OiJGYWNlYm9vayI7czoxODoiZm9vdGVyX3NvY2lhbF9saW5rIjthOjI6e3M6MzoidXJsIjtzOjE6IiMiO3M6NjoidGFyZ2V0IjtzOjY6Il9ibGFuayI7fXM6MTg6ImZvb3Rlcl9zb2NpYWxfaWNvbiI7czoxNToic29jaWFsLWZhY2Vib29rIjt9aToxO2E6NDp7czoyMDoiZHluYW1pY19lbGVtZW50X3R5cGUiO3M6MTk6ImZvb3Rlcl9zb2NpYWxfaWNvbnMiO3M6MTk6ImZvb3Rlcl9zb2NpYWxfdGl0bGUiO3M6NzoiVHdpdHRlciI7czoxODoiZm9vdGVyX3NvY2lhbF9saW5rIjthOjI6e3M6MzoidXJsIjtzOjE6IiMiO3M6NjoidGFyZ2V0IjtzOjY6Il9ibGFuayI7fXM6MTg6ImZvb3Rlcl9zb2NpYWxfaWNvbiI7czoxNDoic29jaWFsLXR3aXR0ZXIiO31pOjI7YTo0OntzOjIwOiJkeW5hbWljX2VsZW1lbnRfdHlwZSI7czoxOToiZm9vdGVyX3NvY2lhbF9pY29ucyI7czoxOToiZm9vdGVyX3NvY2lhbF90aXRsZSI7czo3OiJEcmliYmxlIjtzOjE4OiJmb290ZXJfc29jaWFsX2xpbmsiO2E6Mjp7czozOiJ1cmwiO3M6MToiIyI7czo2OiJ0YXJnZXQiO3M6NjoiX2JsYW5rIjt9czoxODoiZm9vdGVyX3NvY2lhbF9pY29uIjtzOjE1OiJzb2NpYWwtZHJpYmJibGUiO31pOjM7YTo0OntzOjIwOiJkeW5hbWljX2VsZW1lbnRfdHlwZSI7czoxOToiZm9vdGVyX3NvY2lhbF9pY29ucyI7czoxOToiZm9vdGVyX3NvY2lhbF90aXRsZSI7czo2OiJFbnZhdG8iO3M6MTg6ImZvb3Rlcl9zb2NpYWxfbGluayI7YToyOntzOjM6InVybCI7czoxOiIjIjtzOjY6InRhcmdldCI7czo2OiJfYmxhbmsiO31zOjE4OiJmb290ZXJfc29jaWFsX2ljb24iO3M6MTM6InNvY2lhbC1lbnZhdG8iO319czoyMjoiZm9vdGVyX3doaWNoX2ljb25zX3NldCI7czo2OiJub3JtYWwiO3M6MjE6ImRlZl9oZWFkZXJfYmFja2dyb3VuZCI7czowOiIiO3M6MTY6ImRlZl9oZWFkZXJfY29sb3IiO3M6NzoiI0FBQUFBQSI7czoxODoiZGVmX2hlYWRlcl9hbmltYXRlIjtzOjE6IjAiO3M6MTY6ImRlZl9oZWFkZXJfYnJlYWQiO3M6MToiMSI7czoxNToiZGVmX2hlYWRlcl9kYXRlIjtzOjE6IjEiO3M6MTY6ImRlZl9oZWFkZXJfdGl0bGUiO3M6MToiMSI7czoxOToiZGVmX2hlYWRlcl9zdWJ0aXRsZSI7czoxOiIxIjtzOjE2OiJnb29nbGVfYW5hbHl0aWNzIjtzOjA6IiI7czoxMzoibWFpbGNoaW1wX2FwaSI7czozNjoiY2VlYmIzOWI4MTk1NTY1ZWM2YmEzMWI0NmFjZDRiYWMtdXM2IjtzOjE4OiJhcmNoaXZlX3BhZ2VfdGl0bGUiO3M6MTM6IkJMT0cgJiBHb3NzaXAiO3M6MjE6ImFyY2hpdmVfcGFnZV9zdWJ0aXRsZSI7czozNjoiVGhpcyB3b3VsZCBiZSB0aGUgYmxvZyBjYXRlZ29yeSBwYWdlIjtzOjI0OiJhcmNoaXZlX3NpZGViYXJfcG9zaXRpb24iO3M6MTM6InJpZ2h0X3NpZGViYXIiO3M6MTU6ImFyY2hpdmVfc2lkZWJhciI7czoxMjoiQmxvZyBTaWRlYmFyIjtzOjI0OiJkZWZhdWx0X3NpZGViYXJfcG9zaXRpb24iO3M6MTM6InJpZ2h0X3NpZGViYXIiO3M6MTQ6InNpbmdsZV9zaWRlYmFyIjtzOjEyOiJCbG9nIFNpZGViYXIiO3M6MTE6InNob3dfc29jaWFsIjtzOjQ6InNob3ciO3M6MjE6InBhZ2Vfc2lkZWJhcl9wb3NpdGlvbiI7czoxMDoibm9fc2lkZWJhciI7czoxMjoicGFnZV9zaWRlYmFyIjtzOjEyOiJCbG9nIFNpZGViYXIiO3M6MTU6InBvcnRmb2xpb19zdHlsZSI7czoxODoicG9ydGZvbGlvX2NhdGVnb3J5IjtzOjE4OiJwb3J0Zm9saW9fcGVyX3BhZ2UiO3M6MjoiLTEiO3M6MjM6InBvcnRmb2xpb19wZXJfcGFnZV9zaG93IjtzOjE6IjQiO3M6MTc6InBvcnRzX251bV9jb2x1bW5zIjtzOjE6IjQiO3M6MTM6InpuX3Jlc3BvbnNpdmUiO3M6MzoieWVzIjtzOjg6InpuX3dpZHRoIjtzOjQ6IjExNzAiO3M6MTY6InpuX2hlYWRlcl9sYXlvdXQiO3M6Njoic3R5bGUyIjtzOjEzOiJ6bl9tYWluX2NvbG9yIjtzOjc6IiNDRDIxMjIiO3M6MTM6InpuX21haW5fc3R5bGUiO3M6NToibGlnaHQiO3M6MTY6ImhlYWRlcl9nZW5lcmF0b3IiO2E6MTQ6e2k6MDthOjg6e3M6MjA6ImR5bmFtaWNfZWxlbWVudF90eXBlIjtzOjE2OiJoZWFkZXJfZ2VuZXJhdG9yIjtzOjEzOiJ1aF9zdHlsZV9uYW1lIjtzOjI0OiJCbHVlIFN0eWxlIHdpdGggZ3JhZGllbnQiO3M6MTk6InVoX2JhY2tncm91bmRfaW1hZ2UiO3M6MDoiIjtzOjE1OiJ1aF9oZWFkZXJfY29sb3IiO3M6NzoiIzM0NTM3MCI7czoxMDoidWhfZ3JhZF9iZyI7czoxOiIxIjtzOjEwOiJ1aF9hbmltX2JnIjtzOjE6IjAiO3M6ODoidWhfZ2xhcmUiO3M6MToiMCI7czoxNToidWhfYm90dG9tX3N0eWxlIjtzOjQ6Im5vbmUiO31pOjE7YTo4OntzOjIwOiJkeW5hbWljX2VsZW1lbnRfdHlwZSI7czoxNjoiaGVhZGVyX2dlbmVyYXRvciI7czoxMzoidWhfc3R5bGVfbmFtZSI7czoxNjoiQ2hyaXN0bWFzIGhlYWRlciI7czoxOToidWhfYmFja2dyb3VuZF9pbWFnZSI7czo3NDoiaHR0cDovL2hvZ2FzaC1kZW1vLmNvbS9rYWxseWFzX3dwL3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDEzLzAxL2NocmlzdG1hcy5qcGciO3M6MTU6InVoX2hlYWRlcl9jb2xvciI7czo3OiIjQUFBQUFBIjtzOjEwOiJ1aF9ncmFkX2JnIjtzOjE6IjAiO3M6MTA6InVoX2FuaW1fYmciO3M6MToiMSI7czo4OiJ1aF9nbGFyZSI7czoxOiIwIjtzOjE1OiJ1aF9ib3R0b21fc3R5bGUiO3M6OToic2hhZG93X3VkIjt9aToyO2E6ODp7czoyMDoiZHluYW1pY19lbGVtZW50X3R5cGUiO3M6MTY6ImhlYWRlcl9nZW5lcmF0b3IiO3M6MTM6InVoX3N0eWxlX25hbWUiO3M6MTM6IkVhc3RlciBoZWFkZXIiO3M6MTk6InVoX2JhY2tncm91bmRfaW1hZ2UiO3M6NzE6Imh0dHA6Ly9ob2dhc2gtZGVtby5jb20va2FsbHlhc193cC93cC1jb250ZW50L3VwbG9hZHMvMjAxMy8wMS9lYXN0ZXIuanBnIjtzOjE1OiJ1aF9oZWFkZXJfY29sb3IiO3M6NzoiI0FBQUFBQSI7czoxMDoidWhfZ3JhZF9iZyI7czoxOiIwIjtzOjEwOiJ1aF9hbmltX2JnIjtzOjE6IjAiO3M6ODoidWhfZ2xhcmUiO3M6MToiMCI7czoxNToidWhfYm90dG9tX3N0eWxlIjtzOjk6InNoYWRvd191ZCI7fWk6MzthOjg6e3M6MjA6ImR5bmFtaWNfZWxlbWVudF90eXBlIjtzOjE2OiJoZWFkZXJfZ2VuZXJhdG9yIjtzOjEzOiJ1aF9zdHlsZV9uYW1lIjtzOjg6IkFib3V0IFVzIjtzOjE5OiJ1aF9iYWNrZ3JvdW5kX2ltYWdlIjtzOjY4OiJodHRwOi8vaG9nYXNoLWRlbW8uY29tL2thbGx5YXNfd3Avd3AtY29udGVudC91cGxvYWRzLzIwMTMvMDIvYmcxLmpwZyI7czoxNToidWhfaGVhZGVyX2NvbG9yIjtzOjc6IiNBQUFBQUEiO3M6MTA6InVoX2dyYWRfYmciO3M6MToiMSI7czoxMDoidWhfYW5pbV9iZyI7czoxOiIwIjtzOjg6InVoX2dsYXJlIjtzOjE6IjEiO3M6MTU6InVoX2JvdHRvbV9zdHlsZSI7czo5OiJzaGFkb3dfdWQiO31pOjQ7YTo4OntzOjIwOiJkeW5hbWljX2VsZW1lbnRfdHlwZSI7czoxNjoiaGVhZGVyX2dlbmVyYXRvciI7czoxMzoidWhfc3R5bGVfbmFtZSI7czoxNDoiU3RhdGljIENvbnRlbnQiO3M6MTk6InVoX2JhY2tncm91bmRfaW1hZ2UiO3M6Njk6Imh0dHA6Ly9ob2dhc2gtZGVtby5jb20va2FsbHlhc193cC93cC1jb250ZW50L3VwbG9hZHMvMjAxMy8wMi9iZzExLmpwZyI7czoxNToidWhfaGVhZGVyX2NvbG9yIjtzOjc6IiNBQUFBQUEiO3M6MTA6InVoX2dyYWRfYmciO3M6MToiMCI7czoxMDoidWhfYW5pbV9iZyI7czoxOiIwIjtzOjg6InVoX2dsYXJlIjtzOjE6IjAiO3M6MTU6InVoX2JvdHRvbV9zdHlsZSI7czo0OiJub25lIjt9aTo1O2E6ODp7czoyMDoiZHluYW1pY19lbGVtZW50X3R5cGUiO3M6MTY6ImhlYWRlcl9nZW5lcmF0b3IiO3M6MTM6InVoX3N0eWxlX25hbWUiO3M6MjY6IlN0YXRpYyBDb250ZW50IHdpdGggc2hhZG93IjtzOjE5OiJ1aF9iYWNrZ3JvdW5kX2ltYWdlIjtzOjY5OiJodHRwOi8vaG9nYXNoLWRlbW8uY29tL2thbGx5YXNfd3Avd3AtY29udGVudC91cGxvYWRzLzIwMTMvMDIvYmcxMS5qcGciO3M6MTU6InVoX2hlYWRlcl9jb2xvciI7czo3OiIjZjVmNWY1IjtzOjEwOiJ1aF9ncmFkX2JnIjtzOjE6IjAiO3M6MTA6InVoX2FuaW1fYmciO3M6MToiMCI7czo4OiJ1aF9nbGFyZSI7czoxOiIwIjtzOjE1OiJ1aF9ib3R0b21fc3R5bGUiO3M6Njoic2hhZG93Ijt9aTo2O2E6ODp7czoyMDoiZHluYW1pY19lbGVtZW50X3R5cGUiO3M6MTY6ImhlYWRlcl9nZW5lcmF0b3IiO3M6MTM6InVoX3N0eWxlX25hbWUiO3M6MTU6IkJsdWUgd2l0aCBnbGFyZSI7czoxOToidWhfYmFja2dyb3VuZF9pbWFnZSI7czowOiIiO3M6MTU6InVoX2hlYWRlcl9jb2xvciI7czo3OiIjMzQ1MzcwIjtzOjEwOiJ1aF9ncmFkX2JnIjtzOjE6IjEiO3M6MTA6InVoX2FuaW1fYmciO3M6MToiMCI7czo4OiJ1aF9nbGFyZSI7czoxOiIxIjtzOjE1OiJ1aF9ib3R0b21fc3R5bGUiO3M6NDoibm9uZSI7fWk6NzthOjg6e3M6MjA6ImR5bmFtaWNfZWxlbWVudF90eXBlIjtzOjE2OiJoZWFkZXJfZ2VuZXJhdG9yIjtzOjEzOiJ1aF9zdHlsZV9uYW1lIjtzOjE1OiJHcmV5IHdpdGggZ2xhcmUiO3M6MTk6InVoX2JhY2tncm91bmRfaW1hZ2UiO3M6MDoiIjtzOjE1OiJ1aF9oZWFkZXJfY29sb3IiO3M6NzoiIzMzMzMzMyI7czoxMDoidWhfZ3JhZF9iZyI7czoxOiIxIjtzOjEwOiJ1aF9hbmltX2JnIjtzOjE6IjAiO3M6ODoidWhfZ2xhcmUiO3M6MToiMSI7czoxNToidWhfYm90dG9tX3N0eWxlIjtzOjQ6Im5vbmUiO31pOjg7YTo4OntzOjIwOiJkeW5hbWljX2VsZW1lbnRfdHlwZSI7czoxNjoiaGVhZGVyX2dlbmVyYXRvciI7czoxMzoidWhfc3R5bGVfbmFtZSI7czoyOToiUmF5IG9mIEZsaWdodCBDb3VudGRvd24gRXZlbnQiO3M6MTk6InVoX2JhY2tncm91bmRfaW1hZ2UiO3M6NzU6Imh0dHA6Ly9ob2dhc2gtZGVtby5jb20va2FsbHlhc193cC93cC1jb250ZW50L3VwbG9hZHMvMjAxMy8wMi9yYXlvZmxpZ2h0LnBuZyI7czoxNToidWhfaGVhZGVyX2NvbG9yIjtzOjc6IiMzMzUzNzAiO3M6MTA6InVoX2dyYWRfYmciO3M6MToiMCI7czoxMDoidWhfYW5pbV9iZyI7czoxOiIxIjtzOjg6InVoX2dsYXJlIjtzOjE6IjAiO3M6MTU6InVoX2JvdHRvbV9zdHlsZSI7czo5OiJzaGFkb3dfdWQiO31pOjk7YTo4OntzOjIwOiJkeW5hbWljX2VsZW1lbnRfdHlwZSI7czoxNjoiaGVhZGVyX2dlbmVyYXRvciI7czoxMzoidWhfc3R5bGVfbmFtZSI7czoyNjoiUGFnZXMgLSBiYWNrZ3JvdW5kIDMgc3R5bGUiO3M6MTk6InVoX2JhY2tncm91bmRfaW1hZ2UiO3M6Njk6Imh0dHA6Ly9ob2dhc2gtZGVtby5jb20va2FsbHlhc193cC93cC1jb250ZW50L3VwbG9hZHMvMjAxMy8wMi94YmczLmpwZyI7czoxNToidWhfaGVhZGVyX2NvbG9yIjtzOjc6IiNBQUFBQUEiO3M6MTA6InVoX2dyYWRfYmciO3M6MToiMSI7czoxMDoidWhfYW5pbV9iZyI7czoxOiIwIjtzOjg6InVoX2dsYXJlIjtzOjE6IjAiO3M6MTU6InVoX2JvdHRvbV9zdHlsZSI7czo5OiJzaGFkb3dfdWQiO31pOjEwO2E6ODp7czoyMDoiZHluYW1pY19lbGVtZW50X3R5cGUiO3M6MTY6ImhlYWRlcl9nZW5lcmF0b3IiO3M6MTM6InVoX3N0eWxlX25hbWUiO3M6MjY6IlBhZ2VzIC0gYmFja2dyb3VuZCAyIHN0eWxlIjtzOjE5OiJ1aF9iYWNrZ3JvdW5kX2ltYWdlIjtzOjY5OiJodHRwOi8vaG9nYXNoLWRlbW8uY29tL2thbGx5YXNfd3Avd3AtY29udGVudC91cGxvYWRzLzIwMTMvMDIveGJnMi5qcGciO3M6MTU6InVoX2hlYWRlcl9jb2xvciI7czo3OiIjQUFBQUFBIjtzOjEwOiJ1aF9ncmFkX2JnIjtzOjE6IjEiO3M6MTA6InVoX2FuaW1fYmciO3M6MToiMCI7czo4OiJ1aF9nbGFyZSI7czoxOiIwIjtzOjE1OiJ1aF9ib3R0b21fc3R5bGUiO3M6OToic2hhZG93X3VkIjt9aToxMTthOjg6e3M6MjA6ImR5bmFtaWNfZWxlbWVudF90eXBlIjtzOjE2OiJoZWFkZXJfZ2VuZXJhdG9yIjtzOjEzOiJ1aF9zdHlsZV9uYW1lIjtzOjg6Ik1hcCBNYXNrIjtzOjE5OiJ1aF9iYWNrZ3JvdW5kX2ltYWdlIjtzOjA6IiI7czoxNToidWhfaGVhZGVyX2NvbG9yIjtzOjc6IiNBQUFBQUEiO3M6MTA6InVoX2dyYWRfYmciO3M6MToiMCI7czoxMDoidWhfYW5pbV9iZyI7czoxOiIwIjtzOjg6InVoX2dsYXJlIjtzOjE6IjAiO3M6MTU6InVoX2JvdHRvbV9zdHlsZSI7czo1OiJtYXNrMiI7fWk6MTI7YTo4OntzOjIwOiJkeW5hbWljX2VsZW1lbnRfdHlwZSI7czoxNjoiaGVhZGVyX2dlbmVyYXRvciI7czoxMzoidWhfc3R5bGVfbmFtZSI7czoxMToiY3V0ZSBzbGlkZXIiO3M6MTk6InVoX2JhY2tncm91bmRfaW1hZ2UiO3M6MDoiIjtzOjE1OiJ1aF9oZWFkZXJfY29sb3IiO3M6NzoiI2Y1ZjVmNSI7czoxMDoidWhfZ3JhZF9iZyI7czoxOiIxIjtzOjEwOiJ1aF9hbmltX2JnIjtzOjE6IjAiO3M6ODoidWhfZ2xhcmUiO3M6MToiMCI7czoxNToidWhfYm90dG9tX3N0eWxlIjtzOjQ6Im5vbmUiO31pOjEzO2E6ODp7czoyMDoiZHluYW1pY19lbGVtZW50X3R5cGUiO3M6MTY6ImhlYWRlcl9nZW5lcmF0b3IiO3M6MTM6InVoX3N0eWxlX25hbWUiO3M6MzY6IkFuaW1hdGVkIEhlYWRlciAtIGJhY2tncm91bmQgc3R5bGUgMiI7czoxOToidWhfYmFja2dyb3VuZF9pbWFnZSI7czo2OToiaHR0cDovL2hvZ2FzaC1kZW1vLmNvbS9rYWxseWFzX3dwL3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDEzLzAyL3hiZzIuanBnIjtzOjE1OiJ1aF9oZWFkZXJfY29sb3IiO3M6NzoiI0FBQUFBQSI7czoxMDoidWhfZ3JhZF9iZyI7czoxOiIxIjtzOjEwOiJ1aF9hbmltX2JnIjtzOjE6IjEiO3M6ODoidWhfZ2xhcmUiO3M6MToiMCI7czoxNToidWhfYm90dG9tX3N0eWxlIjtzOjQ6Im5vbmUiO319czoxNzoic2lkZWJhcl9nZW5lcmF0b3IiO2E6Mjp7aTowO2E6Mjp7czoyMDoiZHluYW1pY19lbGVtZW50X3R5cGUiO3M6MTc6InNpZGViYXJfZ2VuZXJhdG9yIjtzOjEyOiJzaWRlYmFyX25hbWUiO3M6MTI6IkJsb2cgU2lkZWJhciI7fWk6MTthOjI6e3M6MjA6ImR5bmFtaWNfZWxlbWVudF90eXBlIjtzOjE3OiJzaWRlYmFyX2dlbmVyYXRvciI7czoxMjoic2lkZWJhcl9uYW1lIjtzOjE1OiJDYXJlZXJzIFNpZGViYXIiO319czo5OiJjc19lbmFibGUiO3M6MzoieWVzIjtzOjc6ImNzX2Rlc2MiO3M6MTQxOiJXZSBhcmUgY3VycmVudGx5IHdvcmtpbmcgb24gYSBuZXcgd2Vic2l0ZSBhbmQgd29uXCd0IHRha2UgbG9uZy4gUGxlYXNlIGRvblwndCBmb3JnZXQgdG8gY2hlY2sgb3V0IG91ciB0d2VldHMgYW5kIHRvIHN1YnNjcmliZSB0byBiZSBub3RpZmllZCEiO3M6NzoiY3NfZGF0ZSI7YToyOntzOjQ6ImRhdGUiO3M6MTY6IkZlYnJ1YXJ5LzIxLzIwMTMiO3M6NDoidGltZSI7czo1OiIwMjozMCI7fXM6MTA6ImNzX2xzaXRfaWQiO3M6MTA6IjY5Yzc1YzhhOTAiO3M6MTU6ImNzX3NvY2lhbF9pY29ucyI7YToxOntpOjA7YTo0OntzOjIwOiJkeW5hbWljX2VsZW1lbnRfdHlwZSI7czoxNToiY3Nfc29jaWFsX2ljb25zIjtzOjE1OiJjc19zb2NpYWxfdGl0bGUiO3M6MDoiIjtzOjE0OiJjc19zb2NpYWxfbGluayI7YToyOntzOjM6InVybCI7czowOiIiO3M6NjoidGFyZ2V0IjtzOjY6Il9ibGFuayI7fXM6MTQ6ImNzX3NvY2lhbF9pY29uIjtzOjA6IiI7fX1zOjE2OiI0MDRfaGVhZGVyX3N0eWxlIjtzOjI2OiJwYWdlc18tX2JhY2tncm91bmRfM19zdHlsZSI7czoxMzoid29vX3Nob3dfY2FydCI7czoxOiIxIjtzOjEzOiJ3b29fbmV3X2JhZGdlIjtzOjE6IjEiO3M6MTg6Indvb19uZXdfYmFkZ2VfZGF5cyI7czoxOiIzIjtzOjE5OiJ3b29fYXJjaF9wYWdlX3RpdGxlIjtzOjEyOiJPVVIgUFJPRFVDVFMiO3M6MjI6Indvb19hcmNoX3BhZ2Vfc3VidGl0bGUiO3M6MzY6IlNob3AgY2F0ZWdvcnkgaGVyZSB3aXRoIHByb2R1Y3QgbGlzdCI7czoyNToid29vX2FyY2hfc2lkZWJhcl9wb3NpdGlvbiI7czoxMzoicmlnaHRfc2lkZWJhciI7czoxNjoid29vX2FyY2hfc2lkZWJhciI7czoxNDoiZGVmYXVsdHNpZGViYXIiO3M6Mjc6Indvb19zaW5nbGVfc2lkZWJhcl9wb3NpdGlvbiI7czoxMzoicmlnaHRfc2lkZWJhciI7czoxODoid29vX3NpbmdsZV9zaWRlYmFyIjtzOjE0OiJkZWZhdWx0c2lkZWJhciI7czo3OiJmYWNlX29nIjtzOjE6IjEiO3M6MTA6ImZhY2VfQVBfSUQiO3M6MTU6IjQyNjM5MTAyNDEwNzE4MiI7czo4OiJ6bl9yZXNldCI7czo1OiJyZXNldCI7fQ==';

		$import_code = base64_decode($import_code);
		$import_code = unserialize($import_code);

		// Remove some values
		$import_code['mailchimp_api'] = '';
		$import_code['face_AP_ID'] = '';
		
		$import_code = array_map( 'stripslashes_deep', $import_code );
		
		// FIX IMAGES URL'S AND UPLOAD LOCAL IMAGES
		$import_code = zn_replace_image_links_with_local( $import_code );
		
		update_option('zn_kallyas_options',$import_code);
		
		generate_options_css($import_code); //generate static css file
		generate_options_js($import_code); //generate static js file
		
	}
}

/*--------------------------------------------------------------------------------------------------
	ZN SET PROPER MEDIA
--------------------------------------------------------------------------------------------------*/
if ( ! function_exists( 'zn_replace_image_links_with_local' ) ) {
	function zn_replace_image_links_with_local( $zarray ) {
		//$new_array = array ();

		if ( !is_array ( $zarray ) ) {
		
			return $zarray;
		
		}
		else {
			
			foreach ($zarray as $key => $val ) {
			
				$image_folder = '';
				$image_path = '';
			
				if ( !is_array( $val ) ) {
					// FUNCTIA DE SCHIMBAT URL SI UPLOAD POZA IN FOLDERUL WP-CONTENT
					
						if ( isImage ( $val ) ) {
						
							$image_name = basename($val);
							$image_path_on_upload = explode( 'http://hogash-demo.com/kallyas_wp/wp-content/uploads/',$val);
							$wp_upload_dir = wp_upload_dir();
							
							if ( !empty( $image_path_on_upload[1] ) ) {
							
								$image_to_check = $image_path_on_upload[1];
								$image_folder = explode ( $image_name , $image_path_on_upload[1] );
								$image_folder = $image_folder[0];
								
								$image_path = get_template_directory() .'/images/demo_images/'.$image_folder . $image_name;

							}

							
							if ( file_exists ( $image_path ) ) {
								
								if ( !is_dir( $wp_upload_dir['basedir'] . '/' .$image_folder ) ) {
									if ( !mkdir( $wp_upload_dir['basedir'] . '/' .$image_folder ,0777,true ) ){
										echo 'Directory could not be created : '.$image_folder;
									}
								}
								
								// Check if file is not already uploaded
								if ( !file_exists ( $wp_upload_dir['basedir'] . '/' .$image_folder . $image_name ) ) {			
									$wp_filetype = wp_check_filetype(basename($image_name), null );
									
									
									if (!@copy($image_path,$wp_upload_dir['basedir'].'/'. $image_folder . $image_name)) {
										echo 'Could not copy file';
									}
									
									$attachment = array(
										'guid' => $wp_upload_dir['baseurl'] . '/' .$image_folder . basename( $image_name ), 
										'post_mime_type' => $wp_filetype['type'],
										'post_title' => preg_replace('/\.[^.]+$/', '', basename($image_name)),
										'post_content' => '',
										'post_status' => 'inherit'
									);
																		
									$attach_id = wp_insert_attachment( $attachment, $wp_upload_dir['basedir'] . '/' . $image_folder . $image_name );
																		
									// you must first include the image.php file
									// for the function wp_generate_attachment_metadata() to work
									require_once(ABSPATH . 'wp-admin/includes/image.php');
									$attach_data = wp_generate_attachment_metadata( $attach_id, $image_name );
									wp_update_attachment_metadata( $attach_id, $attach_data );
								
									$new_array[$key] = $wp_upload_dir['baseurl'] . '/' . $image_folder . basename( $image_name );
									
									//echo $wp_upload_dir['baseurl'] .'<br/>';
								}
								else {
									$new_array[$key] = $wp_upload_dir['baseurl'] . '/' . $image_folder . basename( $image_name );
								}
								
							}
							else {
							
								$image_path = get_template_directory() .'/images/demo_images/'.$image_folder . 'sample.png';
								
								if ( !is_dir( $wp_upload_dir['basedir'] . '/' .$image_folder ) ) {
									if ( !mkdir( $wp_upload_dir['basedir'] . '/' .$image_folder ,0777,true ) ){
										echo 'Directory could not be created : '.$image_folder;
									}
								}
								
								// Check if file is not already uploaded
								if ( !file_exists ( $wp_upload_dir['basedir'] . '/' .$image_folder . 'sample.png' ) ) {			
									$wp_filetype = wp_check_filetype(basename($image_name), null );
									
									
									if (!@copy($image_path,$wp_upload_dir['basedir'].'/'. $image_folder . 'sample.png' ) ) {
										echo 'Could not copy file';
									}
									
									$attachment = array(
										'guid' => $wp_upload_dir['baseurl'] . '/' .$image_folder . 'sample.png', 
										'post_mime_type' => $wp_filetype['type'],
										'post_title' => preg_replace('/\.[^.]+$/', '', 'sample.png' ),
										'post_content' => '',
										'post_status' => 'inherit'
									);
																		
									$attach_id = wp_insert_attachment( $attachment, $wp_upload_dir['basedir'] . '/' . $image_folder . 'sample.png' );
									
									global $sample_image_id;
									$sample_image_id = $attach_id;
									
									// you must first include the image.php file
									// for the function wp_generate_attachment_metadata() to work
									require_once(ABSPATH . 'wp-admin/includes/image.php');
									$attach_data = wp_generate_attachment_metadata( $attach_id, $image_name );
									wp_update_attachment_metadata( $attach_id, $attach_data );
								
									$new_array[$key] = $wp_upload_dir['baseurl'] . '/' . $image_folder . 'sample.png';
									
									//echo $wp_upload_dir['baseurl'] .'<br/>';
								}
								else {
									$new_array[$key] = $wp_upload_dir['baseurl'] . '/' . $image_folder . 'sample.png';
								}
							
							}
						}
						else {
							$new_array[$key] = $val;
						}
					
					
				}
				else {

					$new_array[$key] = zn_replace_image_links_with_local( $val );
					
				}
			}
		
		}
		
		return $new_array; 
		
	}
}	
	
/*--------------------------------------------------------------------------------------------------
	ZN UPDATE FEATURED IMAGES 
--------------------------------------------------------------------------------------------------*/
if ( ! function_exists( 'zn_update_featured' ) ) {
	function zn_update_featured( $id )
	{
		global $sample_image_id;
		return $sample_image_id;
	}
}
/*--------------------------------------------------------------------------------------------------
	ZN CHECK IF IMAGE
--------------------------------------------------------------------------------------------------*/
if ( ! function_exists( 'isImage' ) ) {
  function isImage( $url )
  {
    $pos = strrpos( $url, ".");
	if ($pos === false)
	  return false;
	$ext = strtolower(trim(substr( $url, $pos)));
	$imgExts = array(".gif", ".jpg", ".jpeg", ".png", ".tiff", ".tif"); // this is far from complete but that's always going to be the case...
	if ( in_array($ext, $imgExts) )
	  return true;
    return false;
  }
}	
	
?>