<?php 

// var_dump(get_option('dilaz_options')); exit;

if (!function_exists('dilaz_panel_get_url')) {
	function dilaz_options_parameters() {
		
		$theme_object  = wp_get_theme();
		$theme_name    = is_child_theme() ? $theme_object['Template'] : $theme_object['Name'];
		$theme_version = $theme_object['Version'];
		
		$panel_parameters = array(
			'prefix'        => 'dilaz_panel', # should be unique. Not used to save settingsplugin
			'option_name'   => 'dilaz_options', # must be unique. Any time its changed, saved settings are no longer used. New settings will be saved. Set this once.
			'usecase'       => 'theme', # 'theme' if used within a theme or 'plugin' if used within a 
			'theme_name'    => $theme_name,
			'theme_version' => $theme_version,
			'page_slug'     => 'dilaz_panel', # should be unique
			'page_title'    => __('Dilaz Panel', 'dilaz-options'),
			'menu_title'    => __('Dilaz Panel', 'dilaz-options'),
			'options_cap'   => 'manage_options', # The capability required for this menu to be displayed to the user.
			'menu_icon'     => '', # dashicon menu icon
			'import_export' => true, # 'true' to enable import/export field
			'log_title'     => __('Changelog', 'dilaz-options'),
			'log_url'       => '#', # leave empty to disable
			'doc_title'     => __('Documentation', 'dilaz-options'),
			'doc_url'       => '#', # leave empty to disable
			'support_title' => __('Support', 'dilaz-options'),
			'support_url'   => '#', # leave empty to disable
		);
		
		return apply_filters('dilaz_panel_params', $panel_parameters);
	}
}

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
		
		$parentTheme = wp_normalize_path(trailingslashit(get_template_directory()));
		$childTheme  = wp_normalize_path(trailingslashit(get_stylesheet_directory()));
		$file        = wp_normalize_path(trailingslashit(dirname($file)));
		
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
		return plugin_dir_url('', $file);
	}
}


/**
 * Definitions
 */
@define('DILAZ_PANEL_URL', dilaz_panel_get_url(__FILE__) );
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
		
		# Load options config 
		require_once DILAZ_PANEL_DIR .'options/options.php';
		
		# Include required function file 
		require_once DILAZ_PANEL_DIR .'includes/functions.php';
		require_once DILAZ_PANEL_DIR .'includes/fields.php';
		
		
		$option_name = $GLOBALS['dilaz_panel_params']['option_name'];
		$option_name = (isset($option_name) && !empty($option_name)) ? $option_name : 'dilaz_options';
		
		# Set default options if not saved yet
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
		add_action('admin_print_styles-' . $panel_page, 'dilaz_panel_enqueue_styles' );
		add_action('admin_print_scripts-' . $panel_page, 'dilaz_panel_enqueue_scripts');
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
		wp_enqueue_script('dilaz-panel-js', DILAZ_PANEL_URL .'assets/js/admin.js', array('jquery', 'jquery-ui-core', 'jquery-ui-slider'), '1.0', true);

		# Localization
		wp_localize_script(
			'dilaz-panel-js', 
			'dilaz_panel_lang', 
			array(
				'dilaz_panel_images' => DILAZ_PANEL_IMAGES,
				'dilaz_panel_prefix' => DILAZ_PANEL_PREFIX,
				'upload'         => __('Upload', 'dilaz-options'),
				'remove'         => __('Remove', 'dilaz-options'),
				'upload_title'   => __('Select Image', 'dilaz-options'),
				'upload_alert'   => __('Only image is allowed, please try again!', 'dilaz-options'),
				'confirm_delete' => __('Are you sure?', 'dilaz-options')
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
		// dilaz_panel_bg_defaults();
		// var_dump(sanitize_text_field());
		// var_dump(get_option($GLOBALS['dilaz_panel_params']['option_name']));
		// var_dump(dilaz_panel_options());
		// var_dump($_POST['logo']);
		// var_dump(DILAZ_PANEL_DIR);
		// var_dump(dilaz_panel_menu());
		
		?>
		
		<div id="dilaz-panel-wrap" class="wrap">
			
			<?php
			if (isset($_GET['updated'])) {
				if ($_GET['updated']) echo '<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible"><p><strong>'. esc_html($dilaz_panel_params['theme_name']) .' '. esc_html__('settings updated.', 'dilaz-options') .'</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">'. esc_html__('Dismiss this notice.', 'dilaz-options') .'</span></button></div>';
			}
			
			if (isset($_GET['reset'])) {
				if ($_GET['reset']) echo '<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible"><p><strong>'. esc_html($dilaz_panel_params['theme_name']) .' '. esc_html__('settings reset.', 'dilaz-options') .'</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">'. esc_html__('Dismiss this notice.', 'dilaz-options') .'</span></button></div>';
			}
			?>
			<div id="dilaz-panel">
			
				<div id="dilaz-panel-header" class="clearfix">
					<div class="dilaz-panel-item-details">
						<span class="name"><?php echo $dilaz_panel_params['theme_name']; ?></span>
						<span class="version">Version: <?php echo $dilaz_panel_params['theme_version']; ?></span>
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
								<input type="submit" class="button button-primary" name="update" value="<?php _e('Save Options', 'dilaz-options'); ?>" />
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
								<input type="submit" class="button" name="reset" value="<?php esc_attr_e( 'Reset Options', 'dilaz-options'); ?>" onclick="return confirm('<?php print esc_js(__('Click OK to reset. All settings will be lost and replaced with default settings!', 'dilaz-options')); ?>');" />
							</div>
							<div style="float:right">
								<input type="submit" class="button button-primary" name="update" value="<?php _e('Save Options', 'dilaz-options'); ?>" />
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		
		<?php
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
					
					$class = ( isset($val['children']) && $val['children'] != '' ) ? 'has_children' : '';
					$target = ( isset($val['target']) && $val['target'] != '' ) ? $val['target'] : '';
					
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
				
				# use standard if value is empty
				$value = $field['std'];
				
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
				$field['value']         = $value;
				$field['counter']       = $counter;
				$field['option_data']   = $option_data;
				$field['file_library']  = $file_library;

				# Panel content
				if ($field['type'] != 'heading' && $field['type'] != 'subheading' && $field['type'] != 'info') {
					$section_id = 'dilaz-panel-section-' . sanitize_key($field['id']);
					$section_class = 'dilaz-panel-section dilaz-panel-section-'. $field['type'] .' '. sanitize_html_class($field['class']);

					$output .= '<div id="'. esc_attr($section_id) .'" class="'. esc_attr($section_class) .' clearfix">' . "\n";
					if ($field['name']) 
					$output .= '<h4 class="dilaz-panel-section-heading">'. esc_html($field['name']) .'</h4>'."\n";

					if ($field['type'] != 'checkbox' && $field['type'] != 'info' && $field['desc'] != '') {
						$output .= '<div class="description">'. wp_kses($field['desc'], $allowedtags) .'</div>';
					}
					
					$output .= '<div class="option clearfix">' . "\n";

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
					
					# add custom field types via this hook
					case $field['type'] : do_action('dilaz_panel_'. $field['type'] .'_action', $field); break; 
		
				endswitch; 
				
				if ($field['type'] != 'heading' && $field['type'] != 'subheading' && $field['type'] != 'info') {
					$output .= '</div>'; # .option
					$output .= '</div>'; # .$section_class
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
		
		header('Location: admin.php?page='. $GLOBALS['dilaz_panel_params']['page_slug'] .'&reset=true');
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
			
			if (!isset($option['id'])) continue;
			if (!isset($option['type'])) continue;
			if (isset($option['type']) && $option['type'] == 'heading') continue;
			if (isset($option['type']) && $option['type'] == 'subheading') continue;
			
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
				return ($input == '') ? false : (bool) $input;
				break;
		
			case 'multicheck':
				$output = '';
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
					if (isset($option['options'][$k]) && $k == 'color') {
						$output[$k] = sanitize_hex_color($v);
					} else {
						$output[$k] = $v;
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
						$output[$k] = is_array($v) ? array_map('sanitize_text_field', $v) : sanitize_text_field($v);
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
		}
	}
}


/**
 * Get default values
 */
if (!function_exists('dilaz_panel_dafault_values')) {
	function dilaz_panel_dafault_values() {

		$output = array();
		$options = dilaz_panel_options();
		
		foreach ( (array) $options as $option ) {
			
			if (!isset($option['id']) || !isset($option['std']) || !isset($option['type'])) continue;
			
			$id = sanitize_key($option['id']);
			
			$output[$id] = isset($_POST[$id]) ? dilaz_panel_sanitize_option($option['type'], $option['std']) : dilaz_panel_sanitize_option($option['type'], '');
			
		}
		
		return $output;
	}
}


/**
 * Get option
 */
if (!function_exists('dilaz_get_option')) {
	function dilaz_get_option($option_name) {
		
		$options = get_option($GLOBALS['dilaz_panel_params'][$option_name]);
		
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
				$response['message'] = esc_html__('Export Successful', 'dilaz-options');
				$response['exp']     = DILAZ_PANEL_URL .'includes/export.php?dilaz-panel-export='. $option_name .'';
			} else {
				$response['success'] = 0;
				$response['message'] = esc_html__('Export failed! Options do not exist.', 'dilaz-options');
			}
			
		} else {
			
			$response['success'] = 0;
			$response['message'] = esc_html__('Export failed.', 'dilaz-options');
			
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
						$response['message']  = esc_html__('Import Successful.', 'dilaz-options');
						$response['redirect'] = admin_url('admin.php?page='. $dilaz_panel_params['page_slug']);
						
					} else {
						
						$response['success'] = 0;
						$response['message'] = esc_html__('Wrong import file. Please try again.', 'dilaz-options');
						
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
function dilaz_panel_bg_defaults() {
	
	$bg_defaults = array(
		'image'  => '', 
		'repeat' => array(
			''          => '',
			'no-repeat' => __('No Repeat', 'dilaz-options'),
			'repeat'    => __('Repeat All', 'dilaz-options'),
			'repeat-x'  => __('Repeat Horizontally', 'dilaz-options'),
			'repeat-y'  => __('Repeat Vertically', 'dilaz-options'),
			'inherit'   => __('Inherit', 'dilaz-options'),
		), 
		'size' => array(
			''        => '',
			'cover'   => __('Cover', 'dilaz-options'),
			'contain' => __('Contain', 'dilaz-options'),
			'inherit' => __('Inherit', 'dilaz-options'),
		), 
		'position' => array(
			''              => '',
			'top left'      => __('Top Left', 'dilaz-options'),
			'top center'    => __('Top Center', 'dilaz-options'),
			'top right'     => __('Top Right', 'dilaz-options'),
			'center left'   => __('Center Left', 'dilaz-options'),
			'center center' => __('Center Center', 'dilaz-options'),
			'center right'  => __('Center Right', 'dilaz-options'),
			'bottom left'   => __('Bottom Left', 'dilaz-options'),
			'bottom center' => __('Bottom Center', 'dilaz-options'),
			'bottom right'  => __('Bottom Right', 'dilaz-options')
		),
		'attachment' => array(
			''        => '',
			'fixed'   => __('Fixed', 'dilaz-options'),
			'scroll'  => __('Scroll', 'dilaz-options'),
			'inherit' => __('Inherit', 'dilaz-options'),
		), 
		'origin' => array(
			''            => '',
			'content-box' => __('Content Box', 'dilaz-options'),
			'border-box'  => __('Border Box', 'dilaz-options'),
			'padding-box' => __('Padding Box', 'dilaz-options'),
		), 
		'color'  => '', 
	);
	
	$bg_defaults = apply_filters('dilaz_panel_bg_defaults', $bg_defaults);
	
	foreach ($bg_defaults as $k => $v) {
		$bg_defaults[$k] = is_array($v) ? array_map('sanitize_text_field', $v) : sanitize_text_field($bg_defaults[$k]);
	}
	
	return $bg_defaults;
}


/**
 * Multicolor defaults
 */
function dilaz_panel_multicolor_defaults() {
	$multicolor_defaults = array();
	$multicolor_defaults = apply_filters('dilaz_panel_multicolor_defaults', $multicolor_defaults);
	$multicolor_defaults = array_map('sanitize_hex_color', $multicolor_defaults);
	return $multicolor_defaults;
}


/**
 * Font defaults
 */
function dilaz_panel_font_defaults() {
	$font_defaults = array(
		'face'   => '', 
		'size'   => '', 
		'height' => '', 
		'style'  => '', 
		'case'   => '', 
		'color'  => ''
	);
	$font_defaults = apply_filters('dilaz_panel_font_defaults', $font_defaults);
	$font_defaults = array_map('sanitize_text_field', $font_defaults);
	return $font_defaults;
}


/**
 * Font face defaults
 */
function dilaz_panel_font_faces() {
	$font_faces = array(
		'arial'     => 'Arial',
		'verdana'   => 'Verdana, Geneva',
		'trebuchet' => 'Trebuchet',
		'georgia'   => 'Georgia',
		'times'     => 'Times New Roman',
		'tahoma'    => 'Tahoma, Geneva',
		'palatino'  => 'Palatino',
		'helvetica' => 'Helvetica',
	);
	$font_faces = apply_filters('dilaz_panel_font_faces', $font_faces);
	$font_faces = array_map('sanitize_text_field', $font_faces);
	return $font_faces;
}


/**
 * Font size defaults
 */
function dilaz_panel_font_sizes() {
	$font_sizes = range(6, 100);
	$font_sizes = apply_filters('dilaz_panel_font_sizes', $font_sizes);
	$font_sizes = array_map('absint', $font_sizes);
	return $font_sizes;
}


/**
 * Font height defaults
 */
function dilaz_panel_font_heights() {
	$font_heights = range(10, 70);
	$font_heights = apply_filters('dilaz_panel_font_heights', $font_heights);
	$font_heights = array_map('absint', $font_heights);
	return $font_heights;
}


/**
 * Font style defaults
 */
function dilaz_panel_font_styles() {
	$font_styles = array(
		'normal'      => 'Normal',
		'italic'      => 'Italic',
		'bold'        => 'Bold',
		'bold italic' => 'Bold Italic'
	);
	$font_styles = apply_filters('dilaz_panel_font_styles', $font_styles);
	$font_styles = array_map('sanitize_text_field', $font_styles);
	return $font_styles;
}


/**
 * Font case defaults
 */
function dilaz_panel_font_cases() {	
	$font_cases = array(
		'none'       => 'None', 
		'uppercase'  => 'Uppercase', 
		'lowercase'  => 'Lowercase', 
		'capitalize' => 'Capitalize'
	);
	$font_cases = apply_filters('dilaz_panel_font_cases', $font_cases);
	$font_cases = array_map('sanitize_text_field', $font_cases);
	return $font_cases;
}