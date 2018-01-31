<?php 
/*
|| --------------------------------------------------------------------------------------------
|| Admin Panel Export Manager
|| --------------------------------------------------------------------------------------------
||
|| @package		Dilaz Panel
|| @subpackage	Export
|| @since		Dilaz Panel 1.0
|| @author		WebDilaz Team, http://webdilaz.com
|| @copyright	Copyright (C) 2017, WebDilaz LTD
|| @link		http://webdilaz.com/panel
|| @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
|| 
*/

/**
 * Export manager
 *
 * @since 1.0
 *
 * @return void
 */
if ( isset($_GET['dilaz-panel-export']) ) {
	
	$absolute_path = __FILE__;
	$path_to_file  = explode('wp-content', $absolute_path);
	$path_to_wp    = $path_to_file[0];

	require_once $path_to_wp .'wp-load.php';
	include_once ABSPATH .'wp-admin/includes/plugin.php';
	
	$option_name = $_GET['dilaz-panel-export'];
	$options     = get_option($option_name);
	
	if ( !empty($options) ) {
		
		$options['dilaz_panel_backup_time'] = date('Y-m-d h:i:s');
		
		$export_content = json_encode((array)$options);
		$filename       = $option_name .'_backup_'. date('Y.m.d_H.i.s') .'.json';
		
		$handle = fopen($filename, 'w');
		fwrite($handle, $export_content);
		fclose($handle);
		
		header('Cache-Control: public');
		header('Content-Description: File Transfer');
		header('Content-Disposition: attachment; filename='. $filename .'');
		header('Content-Type: application/octet-stream'); 
		header('Content-Length: '. filesize($filename) .';');
		
		readfile($filename);		
		unlink($filename);
		
		exit;
	}
}