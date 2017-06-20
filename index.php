<?php
/*
|| --------------------------------------------------------------------------------------------
|| Admin Options
|| --------------------------------------------------------------------------------------------
||
|| @package		Dilaz Panel
|| @subpackage	Panel
|| @version		1.1
|| @since		Dilaz Panel 1.0
|| @author		WebDilaz Team, http://webdilaz.com
|| @copyright	Copyright (C) 2017, WebDilaz LTD
|| @link		http://webdilaz.com/panel
|| @License		GPL-2.0+
|| @License URI	http://www.gnu.org/licenses/gpl-2.0.txt
|| 
*/

defined('ABSPATH') || exit;

/**
 * Options parameters
 *
 * @since 1.0
 *
 * @return array
 */
if (!function_exists('dilaz_options_parameters')) {
	function dilaz_options_parameters() {
		
		$panel_default_parameters = apply_filters('dilaz_panel_default_params', []);
		
		$use_type_parameters = [];
		
		if (isset($panel_default_parameters['use_type']) && $panel_default_parameters['use_type'] == 'theme') {
			
			# check if its plugin when in theme use type
			if (strpos(dirname(__FILE__), 'plugins')) {

				add_action( 'admin_notices', 'dilaz_panel_plugin_notice' );
				
				function dilaz_panel_plugin_notice() {
					echo '<div id="message" class="error"><p><strong>'. __( 'Options panel is being used in a plugin. Please set "<em>use_type</em>" parameter to "<em>plugin</em>".', 'dilaz-panel' ) .'</strong></p></div>';
				}
				
				# set use type error
				$panel_default_parameters['use_type_error'] = true;
				
			} else {
			
				$theme_object  = wp_get_theme();
				$theme_name    = is_child_theme() ? $theme_object['Template'] : $theme_object['Name'];
				$theme_version = $theme_object['Version'];
				
				$use_type_parameters = array(
					'item_name'    => $theme_name,
					'item_version' => $theme_version,
				);
			}
			
		} else if (isset($panel_default_parameters['use_type']) && $panel_default_parameters['use_type'] == 'plugin') {
			
			# check if its theme when in plugin use type
			if (strpos(dirname(__FILE__), 'themes')) {

				add_action( 'admin_notices', 'dilaz_panel_theme_notice' );
				
				function dilaz_panel_theme_notice() {
					echo '<div id="message" class="error"><p><strong>'. __( 'Options panel is being used in a theme. Please set "<em>use_type</em>" parameter to "<em>theme</em>".', 'dilaz-panel' ) .'</strong></p></div>';
				}
				
				# set use type error
				$panel_default_parameters['use_type_error'] = true;
				
			} else {
			
				if (!function_exists('get_plugin_data')) {
					require_once(ABSPATH . 'wp-admin/includes/plugin.php');
				}
				
				$plugin_object = [];
				
				$plugins_dir     = ABSPATH . 'wp-content/plugins/'; 
				$plugin_basename = plugin_basename(__FILE__);
				$plugin_folder   = strtok($plugin_basename, '/');
				
				# use global to check plugin data from all PHP files within plugin main folder
				foreach (glob(trailingslashit($plugins_dir . $plugin_folder) . '*.php') as $file) {
					$plugin_object = get_plugin_data($file);
				}
				
				$plugin_name    = $plugin_object['Name'];
				$plugin_version = $plugin_object['Version'];
				
				$use_type_parameters = array(
					'item_name'    => $plugin_name,
					'item_version' => $plugin_version,
				);
			}
		}
		
		$panel_parameters = wp_parse_args($use_type_parameters, $panel_default_parameters);
		
		return apply_filters('dilaz_panel_params', $panel_parameters);
	}
}


/**
 * Config
 *
 * @since	1.1
 */
require_once file_exists(dirname(__FILE__) .'/includes/config.php') ? dirname(__FILE__) .'/includes/config.php' : dirname(__FILE__) .'/includes/config-sample.php';


/**
 * Globalize parameters
 */
$GLOBALS['dilaz_panel_params'] = dilaz_options_parameters();


/**
 * Get URL from file
 *
 * @since 1.0
 *
 * @param string	$file
 *
 * @return string|url
 */
if (!function_exists('dilaz_panel_get_url')) {
	function dilaz_panel_get_url($file) {
		
		global $dilaz_panel_params; 
		
		$parentTheme = wp_normalize_path(trailingslashit(get_template_directory()));
		$childTheme  = wp_normalize_path(trailingslashit(get_stylesheet_directory()));
		$file        = (isset($dilaz_panel_params['use_type']) && $dilaz_panel_params['use_type'] == 'plugin') ? wp_normalize_path(trailingslashit($file)) : wp_normalize_path(trailingslashit(dirname($file)));
		
		# if in a parent theme
		if (false !== stripos($file, $parentTheme)) {
			$dir = trailingslashit(str_replace($parentTheme, '', $file));
			$dir = $dir == './' ? '' : $dir;
			return trailingslashit(get_template_directory_uri()) . $dir;
		}
		
		# if in a child theme
		if (false !== stripos($file, $childTheme)) {
			$dir = trailingslashit(str_replace($childTheme, '', $file));
			$dir = $dir == './' ? '' : $dir;
			return trailingslashit(get_stylesheet_directory_uri()) . $dir;
		}
		
		# if in plugin
		return plugin_dir_url($file);
	}
}


/**
 * Definitions
 */
@define('DILAZ_PANEL_URL', dilaz_panel_get_url(__FILE__));
@define('DILAZ_PANEL_DIR', trailingslashit(plugin_dir_path(__FILE__)));
@define('DILAZ_OPTIONS_NAME', $GLOBALS['dilaz_panel_params']['option_name']);
@define('DILAZ_PANEL_IMAGES', DILAZ_PANEL_URL .'assets/images/' );
@define('DILAZ_PANEL_PREFIX', (isset($GLOBALS['dilaz_panel_params']['prefix']) && $GLOBALS['dilaz_panel_params']['prefix'] != '') ? $GLOBALS['dilaz_panel_params']['prefix'] .'_' : 'dilaz_panel_');


/**
 * Initialize Admin Panel
 */
add_action('admin_init', 'dilaz_panel_admin_init'); 
if (!function_exists('dilaz_panel_admin_init')) {
	function dilaz_panel_admin_init() {
		
		# load options config 
		require_once DILAZ_PANEL_DIR .'options/options.php';
		
		# include required function file 
		require_once DILAZ_PANEL_DIR .'includes/functions.php';
		require_once DILAZ_PANEL_DIR .'includes/fields.php';
		
		# otpion name
		$option_name = $GLOBALS['dilaz_panel_params']['option_name'];
		$option_name = (isset($option_name) && !empty($option_name)) ? $option_name : 'dilaz_options';
		
		# set default options if not saved yet
		if (!get_option($option_name)) {
			dilaz_panel_set_defaults($option_name);
		}
		
		# update
		if (isset($_POST['update']) && $_POST['update']) {
			dilaz_panel_save_options();
		}
		
		# reset
		if (isset($_POST['reset']) && $_POST['reset']) {
			dilaz_panel_set_defaults($option_name);
		}
		
		# export
		if (isset($_POST['export']) && $_POST['export']) {
			dilaz_panel_export_options();
		}
	}
}


/**
 * Add Admin Menu
 */
add_action('admin_menu', 'dilaz_panel_register_menu');
if (!function_exists('dilaz_panel_register_menu')) {
	function dilaz_panel_register_menu() {
		
		global $dilaz_panel_params;
		
		# Menu page
		$panel_page = add_menu_page(
			$dilaz_panel_params['page_title'], 
			$dilaz_panel_params['menu_title'], 
			$dilaz_panel_params['options_cap'], 
			$dilaz_panel_params['page_slug'], 
			'dilaz_panel_page', 
			$dilaz_panel_params['menu_icon']
		);

		# Enqueue scripts and styles
		add_action('admin_print_styles-'. $panel_page, 'dilaz_panel_enqueue_styles' );
		add_action('admin_print_scripts-'. $panel_page, 'dilaz_panel_enqueue_scripts');
	}
}


/**
 * Load Admin Styles
 */
if (!function_exists('dilaz_panel_enqueue_styles')) {
	function dilaz_panel_enqueue_styles() {

		wp_enqueue_style('wp-color-picker');
		wp_enqueue_style('fontawesome', DILAZ_PANEL_URL .'assets/css/font-awesome.min.css', false, '4.5.0');
		wp_enqueue_style('select2', DILAZ_PANEL_URL .'assets/css/select2.min.css', false, '4.0.3');
		wp_enqueue_style('dilaz-panel-css', DILAZ_PANEL_URL .'assets/css/admin.css', false, '1.0');

	}
}


/**
 * Load Admin Scripts
 */
if (!function_exists('dilaz_panel_enqueue_scripts')) {
	function dilaz_panel_enqueue_scripts() {
		
		if (function_exists('wp_enqueue_media')) {
			wp_enqueue_media();
		} else {
			wp_enqueue_style('thickbox');
			wp_enqueue_script('thickbox');
			wp_enqueue_script('media-upload');
		}
		
		wp_enqueue_script('wp-color-picker');
		wp_enqueue_script('select2', DILAZ_PANEL_URL .'assets/js/select2.min.js', false, '4.0.3', true);
		wp_enqueue_script('dilaz-dowhen-script', DILAZ_PANEL_URL .'assets/js/jquery.dowhen.js');
		wp_enqueue_script('dilaz-panel-js', DILAZ_PANEL_URL .'assets/js/admin.js', array('jquery', 'jquery-ui-core', 'jquery-ui-slider'), '1.0', true);

		# Localization
		wp_localize_script(
			'dilaz-panel-js', 
			'dilaz_panel_lang', 
			array(
				'dilaz_panel_images' => DILAZ_PANEL_IMAGES,
				'dilaz_panel_prefix' => DILAZ_PANEL_PREFIX,
				'upload'             => __('Upload', 'dilaz-panel'),
				'remove'             => __('Remove', 'dilaz-panel'),
				'upload_title'       => __('Select Image', 'dilaz-panel'),
				'upload_alert'       => __('Only image is allowed, please try again!', 'dilaz-panel'),
				'confirm_delete'     => __('Are you sure?', 'dilaz-panel')
			)
		);
	}
}


/**
 * Add Admin Bar Menu
 */
add_action('wp_before_admin_bar_render', 'dilaz_panel_admin_bar');
if (!function_exists('dilaz_panel_admin_bar')) {
	function dilaz_panel_admin_bar() {

		global $wp_admin_bar, $dilaz_panel_params;
		
		$wp_admin_bar->add_node(array(
			'id'    => 'dilaz_panel_node',
			'title' => '<span class="ab-icon dashicons-admin-generic" style="padding-top:6px;"></span><span class="ab-label">'. $dilaz_panel_params['menu_title'] .'</span>',
			'href'  => admin_url('admin.php?page='. $dilaz_panel_params['page_slug'])
		));

	}
}


/**
 * Admin panel options
 */
if (!function_exists('dilaz_panel_options')) {
	function dilaz_panel_options() {
		$options = array();
		return apply_filters('dilaz_panel_options_filter', $options);
	}
}


/**
 * Admin panel page
 */
if (!function_exists('dilaz_panel_page')) {
	function dilaz_panel_page() {
		
		global $dilaz_panel_params;
		
		if ($dilaz_panel_params['use_type_error'] == false) {
			
			?>
			
			<div id="dilaz-panel-wrap" class="wrap">
				
				<?php
				if (isset($_GET['updated'])) {
					if ($_GET['updated']) echo '<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible"><p><strong>'. esc_html($dilaz_panel_params['item_name']) .' '. esc_html__('settings updated.', 'dilaz-panel') .'</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">'. esc_html__('Dismiss this notice.', 'dilaz-panel') .'</span></button></div>';
				}
				
				if (isset($_GET['reset'])) {
					if ($_GET['reset']) echo '<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible"><p><strong>'. esc_html($dilaz_panel_params['item_name']) .' '. esc_html__('settings reset.', 'dilaz-panel') .'</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">'. esc_html__('Dismiss this notice.', 'dilaz-panel') .'</span></button></div>';
				}
				?>
				<div id="dilaz-panel">
				
					<div id="dilaz-panel-header" class="clearfix">
						<div class="dilaz-panel-item-details">
							<span class="name"><?php echo $dilaz_panel_params['item_name']; ?></span>
							<span class="version">Version: <?php echo $dilaz_panel_params['item_version']; ?></span>
						</div>
					</div>
					
					<div id="dilaz-panel-content" class="clearfix">
						<form enctype="multipart/form-data" action="options.php" method="post">
							<div class="dilaz-panel-top clearfix">
								<div style="float:left">
									<ul class="subsubsub">
										<?php if (!empty($dilaz_panel_params['log_url'])) { ?>
										<li><a href="<?php echo $dilaz_panel_params['log_url']; ?>"><?php echo $dilaz_panel_params['log_title']; ?></a> <span>&#124;</span></li>
										<?php } ?>
										<?php if (!empty($dilaz_panel_params['doc_url'])) { ?>
										<li><a href="<?php echo $dilaz_panel_params['doc_url']; ?>"><?php echo $dilaz_panel_params['doc_title']; ?></a> <span>&#124;</span></li>
										<?php } ?>
										<?php if (!empty($dilaz_panel_params['support_url'])) { ?>
										<li><a href="<?php echo $dilaz_panel_params['support_url']; ?>"><?php echo $dilaz_panel_params['support_title']; ?></a> <span>&#124;</span></li>
										<?php } ?>
									</ul>
								</div>
								<div style="float:right">
									<input type="submit" class="button button-primary" name="update" value="<?php _e('Save Options', 'dilaz-panel'); ?>" />
								</div>
							</div>
							<div class="dilaz-panel-menu">
								<?php echo dilaz_panel_menu(); ?>
							</div>
							<div class="dilaz-panel-fields">
								<?php echo dilaz_panel_fields(); ?>
							</div>
							<div class="clear"></div>
							<div class="dilaz-panel-bottom clearfix">
								<div style="float:left">
									<input type="submit" class="button" name="reset" value="<?php esc_attr_e( 'Reset Options', 'dilaz-panel'); ?>" onclick="return confirm('<?php print esc_js(__('Click OK to reset. All settings will be lost and replaced with default settings!', 'dilaz-panel')); ?>');" />
								</div>
								<div style="float:right">
									<input type="submit" class="button button-primary" name="update" value="<?php _e('Save Options', 'dilaz-panel'); ?>" />
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			
			<?php
		}
	}
}


/**
 * Panel menu
 */
if (!function_exists('dilaz_panel_menu')) {
	function dilaz_panel_menu() {
		
		$options = dilaz_panel_options();
		
		$parent     = 0;
		$menu_items = array();
		$headings   = array();
		
		foreach ($options as $key => $val) {
			if ($val['type'] == 'heading' || $val['type'] == 'subheading') {
				$headings[] = $val;
			}
		}
		
		if (!empty($headings)) {
			foreach($headings as $key => $val) {
				
				$target = sanitize_key($val['name']);
				$val['target'] = $target;
				
				if ($val['type'] == 'heading') {
					$menu_items[$target] = $val;
					$parent = $target;
				}
				
				if ($val['type'] == 'subheading') {
					$menu_items[$parent]['children'][] = $val;
				}
			}
		}
		
		if (!empty($menu_items) && sizeof($menu_items) > 0) {
			
			$menu = '<ul>';
				
				foreach ($menu_items as $key => $val) {
					
					$class = (isset($val['children']) && $val['children'] != '') ? 'has_children' : '';
					$target = (isset($val['target']) && $val['target'] != '') ? $val['target'] : '';
					
					$menu .= '<li id="'. $target .'" class="top_level '. $class .'">';
					
						if (isset($val['icon']) && ($val['icon'] != '')) {
							$menu .= '<i class="fa '. $val['icon'] .'"></i>';
						}
						
						$menu .= '<a class="trigger" href="#'. $val['target'] .'">'. esc_html($val['name']) .'</a>';
						
						if (isset($val['children']) && sizeof($val['children']) > 0) {
							$menu .= '<ul class="submenu">';
								foreach ($val['children'] as $child) {
									$target = $child['target'];
									$menu .= '<li id="'. $target .'" class="child"><a class="trigger" href="#'. $child['target'] .'">'. esc_html($child['name']) .'</a></li>';
								}
							$menu .= '</ul>';
						}
					
					$menu .= '</li>';
				}
			
			$menu .= '</ul>';
		}

		return $menu;
	}
}


/**
 * Panel options' fields
 */
if (!function_exists('dilaz_panel_fields')) {
	function dilaz_panel_fields() {
		
		global $allowedtags;
		
		$option_name   = $GLOBALS['dilaz_panel_params']['option_name'];
		$option_name   = isset($option_name) && !empty($option_name) ? $option_name : 'dilaz_options';
		$option_data   = get_option($option_name);
		$option_fields = dilaz_panel_options();
		
		$counter = 0;
		$output = '';
		
		if (is_array($option_fields)) {
			
			foreach ($option_fields as $field) {
				
				$counter++;

				# setup field types defaults
				if ( !isset( $field['id'] ) ) $field['id'] = '';
				if ( !isset( $field['type'] ) ) $field['type'] = '';
				if ( !isset( $field['name'] ) ) $field['name'] = '';
				if ( !isset( $field['desc'] ) ) $field['desc'] = '';
				if ( !isset( $field['std'] ) ) $field['std'] = '';
				if ( !isset( $field['class'] ) ) $field['class'] = '';
				if ( !isset( $field['file_format'] ) ) $field['file_format'] = '';
				if ( !isset( $field['file_mime'] ) ) $field['file_mime'] = '';
				if ( !isset( $field['req_id'] ) ) $field['req_id'] = '';
				if ( !isset( $field['req_value'] ) ) $field['req_value'] = '';
				if ( !isset( $field['req_args'] ) ) $field['req_args'] = '';
				if ( !isset( $field['req_cond'] ) ) $field['req_cond'] = '';
				if ( !isset( $field['req_action'] ) ) $field['req_action'] = '';
				
				# use standard if value is empty
				$value = $field['std'];
				
				# setup conditional fields
				$cond_fields = '';
				if ( !isset( $field['req_args'] ) || $field['req_args'] != '' ) {
					if ( !isset( $field['req_cond'] ) || $field['req_cond'] == '' ) {
						
						$cond_fields .= ' data-do-when=\'{';
							$do_when_ = '';
							foreach ( $field['req_args'] as $req_id => $req_value ) {
								if (is_array($req_value)) {
									foreach ($req_value as $key => $val) {
										$do_when_ .= ' "'. $req_id .'" : ["'. $val .'"]';
									}
								} else {
									$do_when_ .= ' "'. $req_id .'" : ["'. $req_value .'"]';
								}
							}
							$cond_fields .= $do_when_;
						$cond_fields .= ' }\' data-do-action="'. $field['req_action'] .'"';
						
					} else if ( $field['req_cond'] == 'AND' ) {
						
						$cond_fields .= ' data-do-when=\'{';
							$do_when_AND = '';
							foreach ( $field['req_args'] as $req_id => $req_value ) {
								if (is_array($req_value)) {
									foreach ($req_value as $key => $val) {
										$do_when_AND .= ' "'. $req_id .'" : ["'. $val .'"],';
									}
								} else {
									$do_when_AND .= ' "'. $req_id .'" : ["'. $req_value .'"],';
								}
							}
							$cond_fields .= rtrim( $do_when_AND, ',' ); # remove last comma
						$cond_fields .= ' }\' data-do-action="'. $field['req_action'] .'"';
						
					} else if ( $field['req_cond'] == 'OR' ) {
						
						$cond_fields .= ' data-do-when=\'';
							$do_when_OR = '';
							foreach ( $field['req_args'] as $req_id => $req_value ) {
								if (is_array($req_value)) {
									foreach ($req_value as $key => $val) {
										$do_when_OR .= '{ "'. $req_id .'" : ["'. $val .'"] } || ';
									}
								} else {
									$do_when_OR .= '{ "'. $req_id .'" : ["'. $req_value .'"] } || ';
								}
							}
							$cond_fields .= rtrim( $do_when_OR, '|| ' ); # remove dangling "OR" sign
						$cond_fields .= ' \' data-do-action="'. $field['req_action'] .'"';
						
					}
				}
				
				if ($field['type'] != 'heading' && $field['type'] != 'subheading' && $field['type'] != 'info') {
					if (isset($option_data[($field['id'])])) {
						$value = $option_data[($field['id'])];
						
						if (!is_array($value)) {
							$value = stripslashes($value);
						}
					}
				}
				
				# setup file options
				$file_library = '';
				if (!isset($field['file_format']) || $field['file_format'] != '') {
					
					$file_library .= ' data-file-library=\'[';
						$file_fields = '';
						foreach ($field['file_format'] as $i => $file_format) {
							$file_fields .= ' "'. $file_format .'/'. $field['file_mime'][$i] .'",';
						}
						$file_library .= rtrim($file_fields, ','); # remove last comma
					$file_library .= ' ]\'';
				
				}
				
				# integrate variables into $field array			
				$field['value']        = $value;
				$field['counter']      = $counter;
				$field['option_data']  = $option_data;
				$field['file_library'] = $file_library;

				# Panel content
				if ($field['type'] != 'heading' && $field['type'] != 'subheading' && $field['type'] != 'info') {
					$section_id = 'dilaz-panel-section-'. sanitize_key($field['id']);
					$section_class = 'dilaz-panel-section dilaz-panel-section-'. $field['type'] .' '. sanitize_html_class($field['class']);

					$output .= '<div id="'. esc_attr($section_id) .'" class="'. esc_attr($section_class) .' clearfix"'. $cond_fields .'>' . "\n";
					
					if ($field['name']) { 
						$output .= '<h4 class="dilaz-panel-section-heading">'. esc_html($field['name']) .'</h4>'."\n";
					}

					if ($field['type'] != 'checkbox' && $field['type'] != 'info' && $field['desc'] != '') {
						$output .= '<div class="description">'. wp_kses($field['desc'], $allowedtags) .'</div>';
					}
					
					$output .= '<div class="option clearfix">' ."\n";

				}
				
				# Field types
				switch ($field['type']):
				
					case 'heading'     : $output .= dilaz_panel_field_heading($field); break;
					case 'subheading'  : $output .= dilaz_panel_field_subheading($field); break;
					case 'info'        : $output .= dilaz_panel_field_info($field); break;
					case 'text'        : $output .= dilaz_panel_field_text($field); break;
					case 'email'       : $output .= dilaz_panel_field_email($field); break;
					case 'textarea'    : $output .= dilaz_panel_field_textarea($field); break;
					case 'select'      : $output .= dilaz_panel_field_select($field); break;
					case 'multiselect' : $output .= dilaz_panel_field_multiselect($field); break;
					case 'queryselect' : $output .= dilaz_panel_field_queryselect($field); break;
					case 'radio'       : $output .= dilaz_panel_field_radio($field); break;
					case 'radioimage'  : $output .= dilaz_panel_field_radioimage($field); break;
					case 'buttonset'   : $output .= dilaz_panel_field_buttonset($field); break;
					case 'switch'      : $output .= dilaz_panel_field_switch($field); break;
					case 'checkbox'    : $output .= dilaz_panel_field_checkbox($field); break;
					case 'multicheck'  : $output .= dilaz_panel_field_multicheck($field); break;
					case 'slider'      : $output .= dilaz_panel_field_slider($field); break;
					case 'range'       : $output .= dilaz_panel_field_range($field); break;
					case 'color'       : $output .= dilaz_panel_field_color($field); break;
					case 'multicolor'  : $output .= dilaz_panel_field_multicolor($field); break;
					case 'font'        : $output .= dilaz_panel_field_font($field); break;
					case 'upload'      : $output .= dilaz_panel_field_upload($field); break;
					case 'background'  : $output .= dilaz_panel_field_background($field); break;
					case 'editor'      : $output .= dilaz_panel_field_editor($field); break;
					case 'export'      : $output .= dilaz_panel_field_export($field); break;
					case 'import'      : $output .= dilaz_panel_field_import($field); break;
					
					# add custom field types via this hook - 'dilaz_panel_FIELD_TYPE_action'
					case $field['type'] : do_action('dilaz_panel_field_'. $field['type'] .'_hook', $field); break; 
		
				endswitch; 
				
				if ($field['type'] != 'heading' && $field['type'] != 'subheading' && $field['type'] != 'info') {
					$output .= '</div><!-- .option -->'; # .option
					$output .= '</div><!-- section_class -->'; # .$section_class
				}
			}

			$output .= '</div><!-- tab -->';
		}
		
		return $output;
	}
}


/**
 * Add default options
 */
if (!function_exists('dilaz_panel_set_defaults')) {
	function dilaz_panel_set_defaults($option_name) {
		
		$values = dilaz_panel_dafault_values();
		
		if (isset($values)) {
			update_option($option_name, $values);
		}
		
		$is_reset = isset($_POST['reset']) ? '&reset=true' : '';
		
		header('Location: admin.php?page='. $GLOBALS['dilaz_panel_params']['page_slug'] . $is_reset .'');
	}
}


/**
 * Get default values
 */
if (!function_exists('dilaz_panel_dafault_values')) {
	function dilaz_panel_dafault_values() {

		$output  = [];
		$options = dilaz_panel_options();
		
		foreach ( (array) $options as $option ) {
			
			if (!isset($option['id']) || !isset($option['type'])) continue;
			if ($option['type'] == 'heading' || $option['type'] == 'subheading') continue;
			if ($option['type'] == 'export' || $option['type'] == 'import') continue;
			
			$id = sanitize_key($option['id']);
			
			# Standard option
			$option_std = isset($option['std']) ? $option['std'] : '';
			
			# Set checkbox to standard value
			if ('checkbox' == $option['type'] && !isset($_POST[$id])) {
				$option_std = $option_std;
			}

			# Set all checbox fields to standard value
			if ('multicheck' == $option['type'] && !isset($_POST[$id])) {
				
				# current standard option
				$standard = $option_std;
				
				# create an array
				$option_std = [];
				
				foreach ($option['options'] as $key => $value) {
					$option_std[$key] = is_array($standard) && in_array($key, $standard) ? true : false;
				}
			}
			
			$output[$id] = isset($_POST[$id]) ? dilaz_panel_sanitize_option($option['type'], $option_std, $option) : dilaz_panel_sanitize_option($option['type'], $option_std, $option);
			
		}
		
		return $output;
	}
}


/**
 * Save options
 */
if (!function_exists('dilaz_panel_save_options')) {
	function dilaz_panel_save_options() {
		
		global $dilaz_panel_params;
		
		$sanitized_options = array();
		$options = dilaz_panel_options();
		
		foreach ($options as $option) {
			
			if (!isset($option['id']) || !isset($option['type'])) continue;
			if ($option['type'] == 'heading' || $option['type'] == 'subheading') continue;
			if ($option['type'] == 'export' || $option['type'] == 'import') continue;
			
			$id = sanitize_key($option['id']);

			# Set checkbox to false if not set
			if ('checkbox' == $option['type'] && !isset($_POST[$id])) {
				$_POST[$id] = false;
			}

			# Set all checbox fields to false if not set
			if ('multicheck' == $option['type'] && !isset($_POST[$id])) {
				foreach ($option['options'] as $key => $value) {
					$_POST[$id][$key] = false;
				}
			}
			
			# Get sanitiszed options
			$sanitized_options[$id] = isset($_POST[$id]) ? dilaz_panel_sanitize_option($option['type'], $_POST[$id], $option) : dilaz_panel_sanitize_option($option['type'], '', $option);
			
		}
		
		update_option($dilaz_panel_params['option_name'], $sanitized_options);	
		
		header('Location: admin.php?page='. $dilaz_panel_params['page_slug'] .'&updated=true');
		
		exit();
	}
}


/**
 * Sanitize options
 */
if (!function_exists('dilaz_panel_sanitize_option')) {
	function dilaz_panel_sanitize_option($type, $input, $option = '') {
		
		switch ($type) {
		
			case 'text':
			case 'switch':
				return sanitize_text_field($input);
				break;
		
			case 'email':
				return sanitize_email($input);
				break;
		
			case 'textarea':
				return sanitize_textarea_field($input);
				break;
		
			case 'number':
			case 'integer':
			case 'slider':
				return absint($input);
				break;
		
			case 'select':
			case 'radio':
			case 'radioimage':
			case 'buttonset':
				$output = '';
				$options = isset($option['options']) ? $option['options'] : '';
				if (isset($options[$input])) {
					$output = sanitize_text_field($input);
				}
				return $output;
				break;
				
			case 'queryselect':
			case 'range':
				$output = '';
				foreach ((array)$input as $k => $v) {
					$output[$k] = absint($v);
				}
				return $output;
				break;
		
			case 'multiselect':
				$output = '';
				foreach ((array)$input as $k => $v) {
					if (isset($option['options'][$v])) {
						$output[] = $v;
					}
				}
				return $output;
				break;
		
			case 'checkbox':
				return ($input == '') ? false : (bool)$input;
				break;
		
			case 'multicheck':
				$output = array();
				foreach ((array)$input as $k => $v) {
					if (isset($option['options'][$k]) && $v == true) {
						$output[$k] = true;
					} else {
						$output[$k] = false;
					}
				}
				return $output;
				break;
		
			case 'color':
				return sanitize_hex_color($input);
				break;
		
			case 'multicolor':
				$output = '';
				foreach ((array)$input as $k => $v) {
					if (isset($option['options'][$k])) {
						$output[$k] = sanitize_hex_color($v);
					}
				}
				return $output;
				break;
		
			case 'font':
				$output = array();
				foreach ((array)$input as $k => $v) {
					if (isset($option['options'][$k]) && ($k == 'size' || $k == 'height')) {
						$output[$k] = absint($v);
					} else if (isset($option['options'][$k]) && $k == 'color') {
						$output[$k] = sanitize_hex_color($v);
					} else {
						$output[$k] = sanitize_text_field($v);
					} 
				}
				return $output;
				break;
		
			case 'background':
				$output = array();
				foreach ((array)$input as $k => $v) {
					if (isset($option['options'][$k]) && $k == 'image') {
						$output[$k] = absint($v);
					} else if (isset($option['options'][$k]) && $k == 'color') {
						$output[$k] = sanitize_hex_color($v);
					} else if (isset($option['options'][$k]) && ($k == 'repeat' || $k == 'size' || $k == 'position' || $k == 'attachment' || $k == 'origin')) {
						$output[$k] = sanitize_text_field($v);
					} else {
						$output[$k] = sanitize_text_field($v);
					} 
				}
				return $output;
				break;
		
			case 'upload':
				$output = '';
				foreach ((array)$input as $k => $v) {
					$output[] = absint($v);
				}
				return is_array($output) ? array_unique($output) : $output;
				break;
				
			# sanitize custom option types via this filter hook
			case $type: 
				$output = apply_filters('dilaz_panel_sanitize_option_'. $type .'_hook', $input, $option); 
				return $output;
				break;
		}
	}
}


/**
 * Get option
 */
if (!function_exists('dilaz_get_option')) {
	function dilaz_get_option($option_name) {
		
		$options = $GLOBALS['dilaz_panel_params']['option_name'] == $option_name ? get_option($option_name) : '';
		
		return isset($options) ? $options : false;
	}
}


/**
 * Export options
 */
add_action('wp_ajax_dilaz_panel_export_options', 'dilaz_panel_export_options');
if (!function_exists('dilaz_panel_export_options')) {
	function dilaz_panel_export_options() {
		
		$response = array();
		
		if (isset($_POST['dilaz_export_nonce']) || wp_verify_nonce($_POST['dilaz_export_nonce'], basename(__FILE__))) {
			
			$option_name = $GLOBALS['dilaz_panel_params']['option_name'];
			$options     = get_option($option_name);
		
			if (!empty($options)) {		
				$response['success'] = 1;
				$response['message'] = esc_html__('Export Successful', 'dilaz-panel');
				$response['exp']     = DILAZ_PANEL_URL .'includes/export.php?dilaz-panel-export='. $option_name .'';
			} else {
				$response['success'] = 0;
				$response['message'] = esc_html__('Export failed! Options do not exist.', 'dilaz-panel');
			}
			
		} else {
			
			$response['success'] = 0;
			$response['message'] = esc_html__('Export failed.', 'dilaz-panel');
			
		}
		
		echo json_encode($response);
		
		exit;
	}
}


/**
 * Import options
 */
add_action('wp_ajax_dilaz_panel_import_options', 'dilaz_panel_import_options');
if (!function_exists('dilaz_panel_import_options')) {
	function dilaz_panel_import_options() {
		
		global $dilaz_panel_params;
		
		$response = array();
		
		if (isset($_POST['dilaz_import_nonce']) || wp_verify_nonce($_POST['dilaz_import_nonce'], basename(__FILE__))) {
			
			$import_file   = isset($_POST['dilaz_import_file']) ? sanitize_text_field($_POST['dilaz_import_file']) : '';
			$valid_formats = array('json'); 
			
			# file upload handler
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				
				$file = isset($_FILES[$import_file]) ? $_FILES[$import_file]['tmp_name'] : null;
				
				if ($file != null) {
					
					$data = dilaz_panel_initialize_file_system($file);
					$data = json_decode($data, true);
					
					if (isset($data['dilaz_panel_backup_time'])) {
						
						unset($data['dilaz_panel_backup_time']);
						
						$option_name = $dilaz_panel_params['option_name'];
						
						update_option($option_name, $data);
						
						$response['success']  = 1;
						$response['message']  = esc_html__('Import Successful.', 'dilaz-panel');
						$response['redirect'] = admin_url('admin.php?page='. $dilaz_panel_params['page_slug']);
						
					} else {
						
						$response['success'] = 0;
						$response['message'] = esc_html__('Wrong import file. Please try again.', 'dilaz-panel');
						
					}
				}
			}
		}
		
		echo json_encode($response);
		
		exit;
	}
}


/**
 * Initialize Filesystem object and read file
 *
 * @see http://www.webdesignerdepot.com/2012/08/wordpress-filesystem-api-the-right-way-to-operate-with-local-files/
 * @see http://codex.wordpress.org/Filesystem_API
 * 
 * @param str $file - file to be read
 * @return string|bool - file content, false on failure
 */
if (!function_exists('dilaz_panel_initialize_file_system')) {
	function dilaz_panel_initialize_file_system($file) {
		
		$url = wp_nonce_url('admin.php?page='. $GLOBALS['dilaz_panel_params']['page_slug']);
		
		# bail if can't get get credentials
		if (false === ($creds = request_filesystem_credentials($url))) {
			return;
		}
		
		# use acquired credentials
		if (!WP_Filesystem($creds)) {
			request_filesystem_credentials($url, '', true, false, null);
			return;
		}

		global $wp_filesystem;
		return $wp_filesystem->get_contents($file);
	}
}


/**
 * Background defaults
 */
if (!function_exists('dilaz_panel_bg_defaults')) {
	function dilaz_panel_bg_defaults() {
		
		$bg_defaults = array(
			'image'  => '', 
			'repeat' => array(
				''          => '',
				'no-repeat' => __('No Repeat', 'dilaz-panel'),
				'repeat'    => __('Repeat All', 'dilaz-panel'),
				'repeat-x'  => __('Repeat Horizontally', 'dilaz-panel'),
				'repeat-y'  => __('Repeat Vertically', 'dilaz-panel'),
				'inherit'   => __('Inherit', 'dilaz-panel'),
			), 
			'size' => array(
				''        => '',
				'cover'   => __('Cover', 'dilaz-panel'),
				'contain' => __('Contain', 'dilaz-panel'),
				'inherit' => __('Inherit', 'dilaz-panel'),
			), 
			'position' => array(
				''              => '',
				'top left'      => __('Top Left', 'dilaz-panel'),
				'top center'    => __('Top Center', 'dilaz-panel'),
				'top right'     => __('Top Right', 'dilaz-panel'),
				'center left'   => __('Center Left', 'dilaz-panel'),
				'center center' => __('Center Center', 'dilaz-panel'),
				'center right'  => __('Center Right', 'dilaz-panel'),
				'bottom left'   => __('Bottom Left', 'dilaz-panel'),
				'bottom center' => __('Bottom Center', 'dilaz-panel'),
				'bottom right'  => __('Bottom Right', 'dilaz-panel')
			),
			'attachment' => array(
				''        => '',
				'fixed'   => __('Fixed', 'dilaz-panel'),
				'scroll'  => __('Scroll', 'dilaz-panel'),
				'inherit' => __('Inherit', 'dilaz-panel'),
			), 
			'origin' => array(
				''            => '',
				'content-box' => __('Content Box', 'dilaz-panel'),
				'border-box'  => __('Border Box', 'dilaz-panel'),
				'padding-box' => __('Padding Box', 'dilaz-panel'),
			), 
			'color'  => '', 
		);
		
		$bg_defaults = apply_filters('dilaz_panel_bg_defaults', $bg_defaults);
		
		foreach ($bg_defaults as $k => $v) {
			$bg_defaults[$k] = is_array($v) ? array_map('sanitize_text_field', $v) : sanitize_text_field($bg_defaults[$k]);
		}
		
		return $bg_defaults;
	}
}


/**
 * Multicolor defaults
 */
if (!function_exists('dilaz_panel_multicolor_defaults')) {
	function dilaz_panel_multicolor_defaults() {
		$multicolor_defaults = array();
		$multicolor_defaults = apply_filters('dilaz_panel_multicolor_defaults', $multicolor_defaults);
		$multicolor_defaults = array_map('sanitize_hex_color', $multicolor_defaults);
		return $multicolor_defaults;
	}
}


/**
 * Font defaults
 */
if (!function_exists('dilaz_panel_font_defaults')) {
	function dilaz_panel_font_defaults() {
		$font_defaults = array(
			'family' => 'verdana', 
			'subset' => '', 
			'size'   => '14', 
			'height' => '16', 
			'style'  => '', 
			'case'   => '', 
			'color'  => '#555'
		);
		$font_defaults = apply_filters('dilaz_panel_font_defaults', $font_defaults);
		$font_defaults = array_map('sanitize_text_field', $font_defaults);
		return $font_defaults;
	}
}


/**
 * Font family defaults
 */
if (!function_exists('dilaz_panel_font_family')) {
	function dilaz_panel_font_family() {
		$font_family = array(
			''          => '',
			'arial'     => 'Arial',
			'verdana'   => 'Verdana, Geneva',
			'trebuchet' => 'Trebuchet',
			'georgia'   => 'Georgia',
			'times'     => 'Times New Roman',
			'tahoma'    => 'Tahoma, Geneva',
			'palatino'  => 'Palatino',
			'helvetica' => 'Helvetica',
		);
		$font_family = apply_filters('dilaz_panel_font_family', $font_family);
		$font_family = array_map('sanitize_text_field', $font_family);
		return $font_family;
	}
}


/**
 * Font subset defaults
 */
if (!function_exists('dilaz_panel_font_subset')) {
	function dilaz_panel_font_subset() {
		$font_subset = array(
			''      => '',
			'latin' => 'Latin',
		);
		$font_subset = apply_filters('dilaz_panel_font_subset', $font_subset);
		$font_subset = array_map('sanitize_text_field', $font_subset);
		return $font_subset;
	}
}


/**
 * Font size defaults
 */
if (!function_exists('dilaz_panel_font_sizes')) {
	function dilaz_panel_font_sizes() {
		$font_sizes = range(6, 100);
		$font_sizes = apply_filters('dilaz_panel_font_sizes', $font_sizes);
		$font_sizes = array_map('absint', $font_sizes);
		return $font_sizes;
	}
}


/**
 * Font height defaults
 */
if (!function_exists('dilaz_panel_font_heights')) {
	function dilaz_panel_font_heights() {
		$font_heights = range(10, 70);
		$font_heights = apply_filters('dilaz_panel_font_heights', $font_heights);
		$font_heights = array_map('absint', $font_heights);
		return $font_heights;
	}
}


/**
 * Font weight defaults
 */
if (!function_exists('dilaz_panel_font_weights')) {
	function dilaz_panel_font_weights() {
		$font_weights = array(
			''        => '',
			'100'     => '100',
			'200'     => '200',
			'300'     => '300',
			'400'     => '400',
			'500'     => '500',
			'600'     => '600',
			'700'     => '700',
			'800'     => '800',
			'900'     => '900',
			'normal'  => 'Normal',
			'lighter' => 'Lighter',
			'bold'    => 'Bold',
			'bolder'  => 'Bolder',
			'inherit' => 'Inherit',
			'initial' => 'Initial'
		);
		$font_weights = apply_filters('dilaz_panel_font_weights', $font_weights);
		$font_weights = array_map('sanitize_text_field', $font_weights);
		return $font_weights;
	}
}


/**
 * Font style defaults
 */
if (!function_exists('dilaz_panel_font_styles')) {
	function dilaz_panel_font_styles() {
		$font_styles = array(
			''        => '',
			'normal'  => 'Normal',
			'italic'  => 'Italic',
			'oblique' => 'Oblique',
			'inherit' => 'Inherit',
			'initial' => 'Initial'
		);
		$font_styles = apply_filters('dilaz_panel_font_styles', $font_styles);
		$font_styles = array_map('sanitize_text_field', $font_styles);
		return $font_styles;
	}
}


/**
 * Font case defaults
 */
if (!function_exists('dilaz_panel_font_cases')) {
	function dilaz_panel_font_cases() {
		$font_cases = array(
			''           => '', 
			'none'       => 'None', 
			'uppercase'  => 'Uppercase', 
			'lowercase'  => 'Lowercase', 
			'capitalize' => 'Capitalize'
		);
		$font_cases = apply_filters('dilaz_panel_font_cases', $font_cases);
		$font_cases = array_map('sanitize_text_field', $font_cases);
		return $font_cases;
	}
}