<?php
/*
 * Plugin Name:	Dilaz Panel
 * Plugin URI:	http://webdilaz.com/plugins/dilaz-panel/
 * Description:	Simple options panel for WordPress themes and plugins.
 * Author:		WebDilaz Team
 * Version:		2.0
 * Author URI:	http://webdilaz.com/
 * License:		GPL-2.0+
 * License URI:	http://www.gnu.org/licenses/gpl-2.0.txt
*/

defined('ABSPATH') || exit;

/*
|| --------------------------------------------------------------------------------------------
|| Admin Options Panel
|| --------------------------------------------------------------------------------------------
||
|| @package		Dilaz Panel
|| @subpackage	Panel
|| @version		2.0
|| @since		Dilaz Panel 1.0
|| @author		WebDilaz Team, http://webdilaz.com
|| @copyright	Copyright (C) 2017, WebDilaz LTD
|| @link		http://webdilaz.com/panel
|| @License		GPL-2.0+
|| @License URI	http://www.gnu.org/licenses/gpl-2.0.txt
|| 
*/


/**
 * Dilaz Panel main class
 */
final class DilazPanel {
	
	
	/**
	 * Panel option name
	 *
	 * @var string
	 * @since 2.0
	 */
	protected $option_name;
	
	
	/**
	 * Panel parameters
	 *
	 * @var array
	 */
	protected $params;
	
	
	/**
	 * Panel options
	 *
	 * @var array
	 */
	protected $options;
	
	
	/**
	 * The single instance of the class
	 *
	 * @var string
	 * @since 2.0
	 */
	protected static $_instance = null;
	
	
	/**
	 * Main DilazPanel instance
	 *
	 * Make sure only only one instance can be loaded
	 *
	 * @since 2.0
	 * @static
	 * @see DilazPanel()
	 * @return DilazPanel object - Main instance.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	
	/**
	 * Cloning is forbidden
	 *
	 * @since 2.0
	 * @return void 
	 */
	public function __clone() {
		_doing_it_wrong(__FUNCTION__, __( 'Cheatin&#8217; huh?', 'dilaz-panel' ), '2.0');
	}
	
	
	/**
	 * Unserializing instances of this class is forbidden
	 *
	 * @since 2.0
	 * @return void
	 */
	public function __wakeup() {
		_doing_it_wrong(__FUNCTION__, __( 'Cheatin&#8217; huh?', 'dilaz-panel' ), '2.0');
	}
	
	
	/**
	 * Contructor method
	 *
	 * @param string $option_name unique option name
	 * @param array  $parameters  panel parameters
	 * @param array  $options     panel options
	 *
	 * @since 1.0
	 */
	function __construct( $parameters = array(), array $options = array() ) {

		do_action( 'dilaz_panel_before_load' );
		
		$this->option_name = isset($parameters['option_name']) ? $parameters['option_name'] : '';
		$this->params      = $parameters;
		$this->options     = apply_filters('dilaz_panel_options_filter', $options);
		
		# Load constants
		$this->constants();
		
		# Addons
		add_action('init', array($this, 'parameters'));
		add_action('admin_init', array($this, 'init'));
		add_action('admin_menu', array($this, 'register_menu'));
		add_action('wp_before_admin_bar_render', array($this, 'admin_bar'));
		add_action('wp_ajax_dilaz_panel_save_options', array($this, 'save_options'));
		add_action('wp_ajax_dilaz_panel_reset_options', array($this, 'reset_options'));
		add_action('wp_ajax_dilaz_panel_export_options', array($this, 'export_options'));
		add_action('wp_ajax_dilaz_panel_import_options', array($this, 'import_options'));

		do_action( 'dilaz_panel_after_load' );
		
	}
	
	
	/**
	 * Options parameters
	 *
	 * @since 1.0
	 *
	 * @return array
	 */
	public function parameters() {
		
		return $this->params;
		
	}
	
	
	/**
	 * Constants
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	function constants() {
		
		@define('DILAZ_PANEL_URL', plugin_dir_url(__FILE__));
		@define('DILAZ_PANEL_DIR', trailingslashit(plugin_dir_path(__FILE__)));
		@define('DILAZ_PANEL_IMAGES', DILAZ_PANEL_URL .'assets/images/' );
		@define('DILAZ_PANEL_PREFIX', (isset($this->params['prefix']) && $this->params['prefix'] != '') ? $this->params['prefix'] .'_' : 'dilaz_panel_');
		
	}
	
	
	/**
	 * Includes
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	function includes() {
		
		require_once DILAZ_PANEL_DIR .'includes/functions.php';
		require_once DILAZ_PANEL_DIR .'includes/fields.php';
		require_once DILAZ_PANEL_DIR .'includes/defaults.php';
		
	}
	
	
	/**
	 * Initialize Admin Panel
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	function init() {

		do_action( 'dilaz_panel_before_init' );
		
		# include required files 
		$this->includes();			
		
		# otpion name
		$option_name = $this->option_name;
		// $option_name = (isset($option_name) && !empty($option_name)) ? $option_name : 'dilaz_options';
		
		# set default options if not saved yet
		if (!get_option($option_name)) {
			$this->set_defaults($option_name);
		}
		
		# reset
		if (isset($_POST['reset']) && $_POST['reset']) {
			$this->set_defaults($option_name);
		}
		
		# export
		if (isset($_POST['export']) && $_POST['export']) {
			$this->export_options();
		}

		do_action( 'dilaz_panel_after_init' );
	}
	
	
	/**
	 * Add Admin Menu
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	function register_menu() {
		
		$params = $this->params;

		# bail if parameters are not set
		if (!isset($params)) return;
		
		# bail if page and menu parameters are not set
		if (
			!isset($params['page_title']) || 
			!isset($params['menu_title']) || 
			!isset($params['options_cap']) || 
			!isset($params['page_slug']) || 
			!isset($params['menu_icon'])
		) return;
		
		# Menu page
		$panel_page = add_menu_page(
			$params['page_title'], 
			$params['menu_title'], 
			$params['options_cap'], 
			$params['page_slug'], 
			array($this, 'page'), 
			$params['menu_icon']
		);
		
		# Enqueue scripts and styles
		add_action('admin_print_styles-'. $panel_page, array($this, 'enqueue_styles'));
		add_action('admin_print_scripts-'. $panel_page, array($this, 'enqueue_scripts'));
		
	}
	
	
	/**
	 * Load Admin Styles
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	public function enqueue_styles() {
		
		wp_enqueue_style('wp-color-picker');
		wp_enqueue_style('fontawesome', DILAZ_PANEL_URL .'assets/css/font-awesome.min.css', false, '4.5.0');
		wp_enqueue_style('select2', DILAZ_PANEL_URL .'assets/css/select2.min.css', false, '4.0.3');
		wp_enqueue_style('dilaz-panel-css', DILAZ_PANEL_URL .'assets/css/admin.css', false, '1.0');
		
	}
	
	
	/**
	 * Load Admin Scripts
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		
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
	
	
	/**
	 * Add Admin Bar Menu
	 *
	 * @since 1.0
	 *
	 * @global string $wp_admin_bar
	 *
	 * @return void
	 */
	function admin_bar() {
		
		$params = $this->params;
		
		# bail if parameters are not set
		if (!isset($params)) return;
		
		# bail if page and menu parameters are not set
		if ( !isset($params['menu_title']) || !isset($params['page_slug']) ) return;
		
		global $wp_admin_bar;
		
		$wp_admin_bar->add_node(array(
			'id'    => 'dilaz_panel_node',
			'title' => '<span class="ab-icon dashicons-admin-generic" style="padding-top:6px;"></span><span class="ab-label">'. $params['menu_title'] .'</span>',
			'href'  => admin_url('admin.php?page='. $params['page_slug'])
		));
		
	}
	
	
	/**
	 * Admin panel page
	 *
	 * @since 1.0
	 *
	 * @return mixed
	 */
	public function page() {
		
		$params = $this->params;
		
		if ($params['use_type_error'] == false) {
			
			?>
			
			<div id="dilaz-panel-wrap" class="wrap">
				
				<?php
				if (isset($_GET['updated'])) {
					if ($_GET['updated']) echo '<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible"><p><strong>'. esc_html($params['item_name']) .' '. esc_html__('settings updated.', 'dilaz-panel') .'</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">'. esc_html__('Dismiss this notice.', 'dilaz-panel') .'</span></button></div>';
				}
				
				if (isset($_GET['reset'])) {
					if ($_GET['reset']) echo '<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible"><p><strong>'. esc_html($params['item_name']) .' '. esc_html__('settings reset.', 'dilaz-panel') .'</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">'. esc_html__('Dismiss this notice.', 'dilaz-panel') .'</span></button></div>';
				}
				?>
				<div id="dilaz-panel">
				
					<div id="dilaz-panel-header" class="clearfix">
						<div class="dilaz-panel-item-details">
							<span class="name"><?php echo $params['item_name']; ?></span>
							<span class="version">Version: <?php echo $params['item_version']; ?></span>
						</div>
					</div>
					
					<div id="dilaz-panel-content" class="clearfix">
						<form id="dilaz-panel-form" enctype="multipart/form-data" action="options.php" method="post" data-option-name="<?php echo $this->option_name; ?>" data-option-page="<?php echo $_GET['page']; ?>">
							<div class="dilaz-panel-top clearfix">
								<div style="float:left">
									<ul class="subsubsub">
										<?php if (!empty($params['log_url'])) { ?>
										<li><a href="<?php echo $params['log_url']; ?>"><?php echo $params['log_title']; ?></a> <span>&#124;</span></li>
										<?php } ?>
										<?php if (!empty($params['doc_url'])) { ?>
										<li><a href="<?php echo $params['doc_url']; ?>"><?php echo $params['doc_title']; ?></a> <span>&#124;</span></li>
										<?php } ?>
										<?php if (!empty($params['support_url'])) { ?>
										<li><a href="<?php echo $params['support_url']; ?>"><?php echo $params['support_title']; ?></a> <span>&#124;</span></li>
										<?php } ?>
									</ul>
								</div>
								<div class="dilaz-ajax-save" style="float:right">
									<span class="spinner"></span>
									<span class="progress"><?php _e('Saving options... Please wait...', 'dilaz-panel'); ?></span>
									<span class="finished"></span>
									<input type="submit" class="update button button-primary" name="update" value="<?php _e('Save Options', 'dilaz-panel'); ?>" />
								</div>
							</div>
							<div class="dilaz-panel-menu">
								<?php echo $this->menu(); ?>
							</div>
							<div class="dilaz-panel-fields">
								<?php echo $this->fields(); ?>
							</div>
							<div class="clear"></div>
							<div class="dilaz-panel-bottom clearfix">
								<div class="dilaz-ajax-save" style="float:left">
									<input type="submit" class="reset button" name="reset" value="<?php esc_attr_e( 'Reset Options', 'dilaz-panel'); ?>" onclick="return confirm('<?php print esc_js(__('Click OK to reset. All settings will be lost and replaced with default settings!', 'dilaz-panel')); ?>');" />
									<span class="spinner"></span>
									<span class="progress"><?php _e('Resetting options... Please wait...', 'dilaz-panel'); ?></span>
									<span class="finished"></span>
								</div>
								<div class="dilaz-ajax-save" style="float:right">
									<input type="hidden" name="option_name" value="<?php echo $this->option_name; ?>" />
									<input type="hidden" name="security" value="<?php echo wp_create_nonce(basename(__FILE__)); ?>" />
									<span class="spinner"></span>
									<span class="progress"><?php _e('Saving options... Please wait.', 'dilaz-panel'); ?></span>
									<span class="finished"></span>
									<input type="submit" class="update button button-primary" name="update" value="<?php _e('Save Options', 'dilaz-panel'); ?>" />
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
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	public function menu() {
		
		$options = $this->options;
		
		$menu       = '';
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
			
			$menu .= '<ul>';
				
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
	
	
	/**
	 * Panel options' fields
	 *
	 * @since 1.0
	 *
	 * @global array $allowed_tags
	 *
	 * @return array
	 */
	public function fields() {
		
		global $allowedtags;
		
		$option_name   = $this->option_name;
		$option_name   = isset($option_name) && !empty($option_name) ? $option_name : 'dilaz_options';
		$option_data   = get_option($option_name);
		$option_fields = $this->options;
		
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
					
					$section_id    = 'dilaz-panel-section-'. sanitize_key($field['id']);
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
				
					case 'heading'     : $output .= DilazPanelFields::_heading($field); break;
					case 'subheading'  : $output .= DilazPanelFields::_subheading($field); break;
					case 'info'        : $output .= DilazPanelFields::_info($field); break;
					case 'text'        : $output .= DilazPanelFields::_text($field); break;
					case 'email'       : $output .= DilazPanelFields::_email($field); break;
					case 'textarea'    : $output .= DilazPanelFields::_textarea($field); break;
					case 'select'      : $output .= DilazPanelFields::_select($field); break;
					case 'multiselect' : $output .= DilazPanelFields::_multiselect($field); break;
					case 'queryselect' : $output .= DilazPanelFields::_queryselect($field); break;
					case 'radio'       : $output .= DilazPanelFields::_radio($field); break;
					case 'radioimage'  : $output .= DilazPanelFields::_radioimage($field); break;
					case 'buttonset'   : $output .= DilazPanelFields::_buttonset($field); break;
					case 'switch'      : $output .= DilazPanelFields::_switch($field); break;
					case 'checkbox'    : $output .= DilazPanelFields::_checkbox($field); break;
					case 'multicheck'  : $output .= DilazPanelFields::_multicheck($field); break;
					case 'slider'      : $output .= DilazPanelFields::_slider($field); break;
					case 'range'       : $output .= DilazPanelFields::_range($field); break;
					case 'color'       : $output .= DilazPanelFields::_color($field); break;
					case 'multicolor'  : $output .= DilazPanelFields::_multicolor($field); break;
					case 'font'        : $output .= DilazPanelFields::_font($field); break;
					case 'upload'      : $output .= DilazPanelFields::_upload($field); break;
					case 'background'  : $output .= DilazPanelFields::_background($field); break;
					case 'editor'      : $output .= DilazPanelFields::_editor($field); break;
					case 'export'      : $output .= DilazPanelFields::_export($field); break;
					case 'import'      : $output .= DilazPanelFields::_import($field); break;
					
					# add custom field types via this hook - 'dilaz_panel_FIELD_TYPE_action'
					case $field['type'] : do_action('dilaz_panel_field_'. $field['type'] .'_hook', $field); break;
					
				endswitch; 
				
				if ($field['type'] != 'heading' && $field['type'] != 'subheading' && $field['type'] != 'info') {
					$output .= '</div><!-- .option -->'; # .option
					$output .= '</div><!-- .section_class -->'; # .$section_class
				}
			}
			
			$output .= '</div><!-- tab -->';
		}
		
		return $output;
	}
	
	
	/**
	 * Add default options
	 *
	 * @since 1.0
	 *
	 * @param  string $option_name
	 *
	 * @return void
	 */
	function set_defaults($option_name) {
		
		$values = $this->dafault_values();
		
		if (isset($values)) {
			update_option($option_name, $values);
		}
		
		$is_reset = isset($_POST['reset']) ? '&reset=true' : '';
		
		header('Location: admin.php?page='. $this->params['page_slug'] . $is_reset .'');
	}
	
	
	/**
	 * Set option
	 *
	 * @since 1.2
	 *
	 * @param string $option_name  option name as used in wp_options table
	 * @param string $option_id    option key
	 * @param string $option_value option value(s)
	 * @param string $option_type  option type
	 *
	 * @return void|bool
	 */
	function set_option($option_name, $option_id, $option_value = false, $option_type = false) {
		
		if (!isset($option_name)) return false;
		if (!isset($option_id)) return false;
		
		# sanitize option id
		$option_id = sanitize_key($option_id);
		
		# get all options
		$options = $this->get_options($option_name);
		
		# bail if $options are not set
		if (!isset($options) || !is_array($options) || !$options) return false;
		
		# delete the option if its already set
		if (isset($options[$option_id])) unset($options[$option_id]);
		
		# create sanitized options array
		$sanitized_options = [];
		
		# Get sanitiszed options
		$sanitized_options[$option_id] = $this->sanitize_option($option_type, $option_value, '', true);
		
		# Get sanitiszed options
		$merged_options = array_merge($options, $sanitized_options);
		
		update_option($option_name, $merged_options);
	}
	
	
	/**
	 * Remove option
	 *
	 * @since 1.2
	 *
	 * @param string $option_name  option name as used in wp_options table
	 * @param string $option_id    option key
	 *
	 * @return void|bool
	 */
	function delete_option($option_name, $option_id) {
		
		if (!isset($option_name)) return false;
		if (!isset($option_id)) return false;
		
		# sanitize option id
		$option_id = sanitize_key($option_id);
		
		# get all options
		$options = $this->get_options($option_name);
		
		# bail if $options are not set
		if (!isset($options) || !is_array($options) || !$options) return false;
		
		# delete the option if its already set
		if (isset($options[$option_id])) unset($options[$option_id]);
		
		update_option($option_name, $options);
	}
	
	
	/**
	 * Get single saved option
	 *
	 * @since 1.0
	 *
	 * @param string $option_name option name as used in wp_options table
	 * @param string $option_id   option key or unique identifier
	 *
	 * @return mixed|string|array|bool false if option is not set
	 */
	function get_option($option_name, $option_id = false) {
		
		if (!isset($option_name)) return false;
		
		$options = get_option($option_name);
		
		if (isset($options) && isset($options[$option_id]) && !empty($option_id)) {
			return $options[$option_id];
		} else {
			return false;
		}
	}
	
	
	/**
	 * Get all saved options
	 *
	 * @since 1.0
	 *
	 * @param string $option_name option name as used in wp_options table
	 *
	 * @return array|bool false if option is not set
	 */
	function get_options($option_name) {
		
		if (!isset($option_name)) return false;
		
		$options = get_option($option_name);
		
		if (isset($options)) {
			return $options;
		} else {
			return false;
		}
	}
	
	
	/**
	 * Get default values
	 *
	 * @since 1.0
	 *
	 * @return array all default values
	 */
	function dafault_values() {
		
		$output  = [];
		$options = $this->options;
		
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
			
			$output[$id] = isset($_POST[$id]) ? $this->sanitize_option($option['type'], $option_std, $option) : $this->sanitize_option($option['type'], $option_std, $option);
			
		}
		
		return $output;
	}
		
	
	
	/**
	 * Reset options
	 *
	 * @since 1.0
	 *
	 * @param  string $option_name
	 *
	 * @return void
	 */
	function reset_options() {
		
		$response = array();
		
		# verify nonce and proceed
		if (isset($_POST['security']) || wp_verify_nonce($_POST['security'], basename(__FILE__))) {
			
			$option_name = isset($_POST['dilaz_option_name']) ? sanitize_text_field($_POST['dilaz_option_name']) : '';
			$option_page = isset($_POST['dilaz_option_page']) ? sanitize_text_field($_POST['dilaz_option_page']) : '';
			
			# get default values
			$values = $this->dafault_values();
			
			if (isset($values)) {
				update_option($option_name, $values);
			}
			
			$response['success']  = 1;
			$response['message']  = esc_html__('Options reset successfully.', 'dilaz-panel');
			$response['redirect'] = admin_url('admin.php?page='. $option_page .'&reset=true');
			
		} else {
			
			$response['success'] = 0;
			$response['message'] = esc_html__('Error! Options reset failed. Please refresh the page and try again.', 'dilaz-panel');
			
		}
		
		echo json_encode($response);
		
		exit;
		
	}
	
	/**
	 * Save all options
	 *
	 * @since 1.0
	 *
	 * @param string $option_name option name as used in wp_options table
	 *
	 * @return json
	 */
	function save_options() {
		
		$response = array();
		
		# parse form data query string into array
		parse_str($_POST['form_data'], $form_data);
		
		# verify nonce and proceed
		if (isset($form_data['security']) || wp_verify_nonce($form_data['security'], basename(__FILE__))) {
			
			# set option name
			$option_name = isset($form_data['option_name']) ? sanitize_text_field($form_data['option_name']) : '';
			
			# remove options that should not be saved
			// if (isset($form_data['option_name'])) unset($form_data['option_name']);
			if (isset($form_data['security'])) unset($form_data['security']);
			
			$sanitized_options = array();
			$defined_options   = $this->options;
			$saved_options     = $this->get_options($option_name);
			
			foreach ($defined_options as $option) {
				
				if (!isset($option['id']) || !isset($option['type'])) continue;
				if ($option['type'] == 'heading' || $option['type'] == 'subheading') continue;
				if ($option['type'] == 'export' || $option['type'] == 'import') continue;
				
				$id = sanitize_key($option['id']);
				
				# Set checkbox to false if not set
				if ('checkbox' == $option['type'] && !isset($form_data[$id])) {
					$form_data[$id] = false;
				}
				
				# Set all checbox fields to false if not set
				if ('multicheck' == $option['type'] && !isset($form_data[$id])) {
					foreach ($option['options'] as $key => $value) {
						$form_data[$id][$key] = false;
					}
				}
				
				# Get sanitiszed options
				$sanitized_options[$id] = isset($form_data[$id]) ? $this->sanitize_option($option['type'], $form_data[$id], $option) : $this->sanitize_option($option['type'], '', $option);
				
			}
			
			$merged_options = array_merge($saved_options, $sanitized_options);
			
			update_option($option_name, $merged_options);
			
			$response['success'] = 1;
			$response['message'] = esc_html__('Options saved successfully.', 'dilaz-panel');
			
		} else {
			
			$response['success'] = 0;
			$response['message'] = esc_html__('Error! Options not saved. Please refresh the page and try again.', 'dilaz-panel');
			
		}
		
		echo json_encode($response);
		
		exit;
	}
	
	
	/**
  
	 * Save all options
	 *
	 * @since 1.0
	 *
	 * @param string $option_name option name as used in wp_options table
	 *
	 * @return void|bool false if option is not saved
	 */
	function save_options($option_name) {
		
		if (!isset($option_name)) return false;
		
		$sanitized_options = array();
		$defined_options   = $this->options;
		$saved_options     = $this->get_options($option_name);
		
		foreach ($defined_options as $option) {
			
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
			$sanitized_options[$id] = isset($_POST[$id]) ? $this->sanitize_option($option['type'], $_POST[$id], $option) : $this->sanitize_option($option['type'], '', $option);
			
		}
		
		$merged_options = array_merge($saved_options, $sanitized_options);
		
		update_option($this->option_name, $merged_options);	
		
		header('Location: admin.php?page='. $this->params['page_slug'] .'&updated=true');
		
		exit();
	}
	
	
	/**
  
	 * Save single option
	 *
	 * @since 1.2
	 *
	 * @param string $option_name  option name as used in wp_options table
	 * @param string $option_id    option key 
	 * @param string $option_value option value(s)
	 * @param string $option_type  option type
	 *
	 * @return void|bool false if option is not saved
	 */
	function save_option($option_name, $option_id, $option_value = false, $option_type = false) {
		
		if (!isset($option_name)) return false;
		if (!isset($option_id)) return false;
		
		# sanitize option id
		$option_id = sanitize_key($option_id);
		
		# get all options
		$options = $this->get_options($option_name);
		
		# bail if $options are not set
		if (!isset($options) || !is_array($options) || !$options) return false;
		
		# delete the option if its already set
		if (isset($options[$option_id])) unset($options[$option_id]);
		
		# create sanitized options array
		$sanitized_options = [];
		
		# Get sanitiszed options
		$sanitized_options[$option_id] = $this->sanitize_option($option_type, $option_value, '', true);
		
		# Get sanitiszed options
		$merged_options = array_merge($options, $sanitized_options);
		
		update_option($option_name, $merged_options);
		
	}
	
	
	/**
	 * Sanitize options
	 *
	 * @since 1.0
	 *
	 * @param string $type       field type
	 * @param string $input      set/selected/inserted option
	 * @param string $option     option array
	 * @param bool   $set_option whether the option is being set. Default is false
	 *
	 * @return string|mixed|bool sanitized values
	 */
	function sanitize_option($type, $input, $option = '', $set_option = false) {
		
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
				if (isset($options[$input]) || $set_option) {
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
					if (isset($option['options'][$v]) || $set_option) {
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
					if ( ( isset($option['options'][$k]) && $v == true ) || $set_option ) {
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
					if (isset($option['options'][$k]) || $set_option) {
						$output[$k] = sanitize_hex_color($v);
					}
				}
				return $output;
				break;
				
			case 'font':
				$output = array();
				foreach ((array)$input as $k => $v) {
					if ( ( isset($option['options'][$k]) && ($k == 'size' || $k == 'height') ) || $set_option ) {
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
					if ( ( isset($option['options'][$k]) && $k == 'image' ) || $set_option ) {
						$output[$k] = absint($v);
					} else if ( ( isset($option['options'][$k]) && $k == 'color' ) || $set_option ) {
						$output[$k] = sanitize_hex_color($v);
					} else if ( ( isset($option['options'][$k]) && ($k == 'repeat' || $k == 'size' || $k == 'position' || $k == 'attachment' || $k == 'origin') ) || $set_option ) {
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
	
	
	/**
	 * Export options
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	function export_options() {
		
		$response = array();
		
		if (isset($_POST['dilaz_export_nonce']) || wp_verify_nonce($_POST['dilaz_export_nonce'], basename(__FILE__))) {
			
			$option_name = isset($_POST['dilaz_option_name']) ? sanitize_text_field($_POST['dilaz_option_name']) : '';
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
	
	
	/**
	 * Import options
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	function import_options() {
		
		$response = array();
		
		if (isset($_POST['dilaz_import_nonce']) || wp_verify_nonce($_POST['dilaz_import_nonce'], basename(__FILE__))) {
			
			$import_file   = isset($_POST['dilaz_import_file']) ? sanitize_text_field($_POST['dilaz_import_file']) : '';
			$option_page   = isset($_POST['dilaz_option_page']) ? sanitize_text_field($_POST['dilaz_option_page']) : '';
			$option_name   = isset($_POST['dilaz_option_name']) ? sanitize_text_field($_POST['dilaz_option_name']) : '';
			$valid_formats = array('json'); 
			
			# file upload handler
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				
				$file = isset($_FILES[$import_file]) ? $_FILES[$import_file]['tmp_name'] : null;
				
				if ($file != null) {
					
					$data = $this->initialize_file_system($file);
					$data = json_decode($data, true);
					
					if (isset($data['dilaz_panel_backup_time'])) {
						
						unset($data['dilaz_panel_backup_time']);
						
						update_option($option_name, $data);
						
						$response['d']  = $data;
						$response['success']  = 1;
						$response['message']  = esc_html__('Import Successful.', 'dilaz-panel');
						$response['redirect'] = admin_url('admin.php?page='. $option_page);
						
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
	
	
	/**
	 * Initialize Filesystem object and read file
	 *
	 * @see http://www.webdesignerdepot.com/2012/08/wordpress-filesystem-api-the-right-way-to-operate-with-local-files/
	 * @see http://codex.wordpress.org/Filesystem_API
	 * 
	 * @param  str                $file - file to be read
	 * @global WP_Filesystem_Base $wp_filesystem Subclass
	 * @return string|bool        file content, false on failure
	 */
	function initialize_file_system($file) {
		
		$url = wp_nonce_url('admin.php?page='. $this->params['page_slug']);
		
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