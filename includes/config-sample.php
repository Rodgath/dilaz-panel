<?php 
/*
|| --------------------------------------------------------------------------------------------
|| Admin Panel Configuration
|| --------------------------------------------------------------------------------------------
||
|| @package		Dilaz Panel
|| @subpackage	Config
|| @since		Dilaz Panel 1.1
|| @author		WebDilaz Team, http://webdilaz.com
|| @copyright	Copyright (C) 2017, WebDilaz LTD
|| @link		http://webdilaz.com/panel
|| @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
|| 
*/

defined('ABSPATH') || exit;


add_filter('dilaz_panel_default_params', 'dilaz_panel_config_parameters');
function dilaz_panel_config_parameters() {
	
	$config_parameters = array(
		'prefix'          => 'dilaz_panel', # should be unique. Not used to save settings
		'option_name'     => 'dilaz_options', # must be unique. Any time its changed, saved settings are no longer used. New settings will be saved. Set this once.
		'use_type'        => 'theme', # 'theme' if used within a theme OR 'plugin' if used within a plugin
		'use_type_error'  => false, # error when wrong "use_type" is declared, default is false
		'default_options' => true, # whether to load default options
		'custom_options'  => true, # whether to load custom options
		'page_slug'       => 'dilaz_panel', # should be unique
		'page_title'      => __('Dilaz Panel', 'dilaz-panel'),
		'menu_title'      => __('Dilaz Panel', 'dilaz-panel'),
		'options_cap'     => 'manage_options', # The capability required for this menu to be displayed to the user.
		'menu_icon'       => '', # dashicon menu icon
		'import_export'   => true, # 'true' to enable import/export field
		'log_title'       => __('Changelog', 'dilaz-panel'),
		'log_url'         => '#', # leave empty to disable
		'doc_title'       => __('Documentation', 'dilaz-panel'),
		'doc_url'         => '#', # leave empty to disable
		'support_title'   => __('Support', 'dilaz-panel'),
		'support_url'     => '#', # leave empty to disable
	);
	
	return $config_parameters;
}