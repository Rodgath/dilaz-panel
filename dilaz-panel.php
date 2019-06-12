<?php
/*
 * Plugin Name: Dilaz Panel
 * Plugin URI:  https://github.com/Rodgath/Dilaz-Panel-Plugin
 * Description: Simple options panel for WordPress themes and plugins.
 * Author:      Rodgath
 * Text Domain: dilaz-panel
 * Domain Path: /languages
 * Version:     2.7.11
 * Author URI:  https://github.com/Rodgath
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
||
|| --------------------------------------------------------------------------------------------
|| Admin Options Panel
|| --------------------------------------------------------------------------------------------
||
|| @package     Dilaz Panel
|| @subpackage  Panel
|| @version     2.7.11
|| @since       Dilaz Panel 1.0
|| @author      Rodgath, https://github.com/Rodgath
|| @copyright   Copyright (C) 2017, Rodgath LTD
|| @link        https://github.com/Rodgath/Dilaz-Panel-Plugin
|| @License     GPL-2.0+
|| @License URI http://www.gnu.org/licenses/gpl-2.0.txt
|| 
*/

defined('ABSPATH') || exit;

/**
 * Dilaz Panel main class
 */
if (!class_exists('DilazPanel')) {
	class DilazPanel {
		
		
		/**
		 * Panel option name
		 *
		 * @var    string
		 * @since  2.0
		 * @access protected
		 */
		protected $_optionName;
		
		
		/**
		 * Panel parameters
		 *
		 * @var    array
		 * @access protected
		 */
		protected $_params;
		
		
		/**
		 * Panel options
		 *
		 * @var    array
		 * @access protected
		 */
		protected $_options;
		
		
		/**
		 * Panel attributes
		 *
		 * @since  2.1
		 * @var    array
		 * @access protected
		 */
		protected $_panelAtts;
		
		
		/**
		 * Saved Google Fonts
		 *
		 * @since  2.7.12
		 * @var    array
		 * @access protected
		 */
		protected $savedGFonts;
		
		
		/**
		 * The single instance of the class
		 *
		 * @var    string
		 * @since  2.0
		 * @access protected
		 */
		protected static $_instance = NULL;
		
		
		/**
		 * Main DilazPanel instance
		 *
		 * Make sure only only one instance can be loaded
		 *
		 * @since  2.0
		 * @access public
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
		 * @since  2.0
		 * @access public
		 * @return void 
		 */
		public function __clone() {
			_doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?', 'dilaz-panel'), '2.0');
		}
		
		
		/**
		 * Unserializing instances of this class is forbidden
		 *
		 * @since  2.0
		 * @access public
		 * @return void
		 */
		public function __wakeup() {
			_doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?', 'dilaz-panel'), '2.0');
		}
		
		
		/**
		 * Contructor method
		 *
		 * @param array $option_args panel arguments
		 *
		 * @since 1.0
		 */
		function __construct($option_args) {

			do_action('dilaz_panel_before_load');
			
			$this->args        = is_array($option_args) ? $option_args : array();
			$this->_params     = !empty($this->args) ? $this->sanitizeParams($this->args[0]) : array();
			$this->_options    = !empty($this->args) ? $this->args[1] : array();
			$this->_optionName = isset($this->_params['option_name']) ? $this->_params['option_name'] : '';
			$this->_panelAtts  = !empty($this->_options) ? $this->_options[0] : array();
			$saved_options     = $this->getOptions($this->_optionName);
			$this->savedGFonts = isset($saved_options['saved_google_fonts']) ? $saved_options['saved_google_fonts'] : array();
			
			# Load constants
			$this->constants();
			
			# Actions
			add_action('init', array($this, 'init'));
			add_action('admin_init', array($this, 'adminInit'));
			add_action('admin_menu', array($this, 'registerMenu'));
			add_action('wp_before_admin_bar_render', array($this, 'adminBar'));
			add_action('wp_ajax_dilaz_panel_save_options', array($this, 'saveOptions'));
			add_action('wp_ajax_dilaz_panel_reset_options', array($this, 'resetOptions'));
			add_action('wp_ajax_dilaz_panel_export_options', array($this, 'exportOptions'));
			add_action('wp_ajax_dilaz_panel_import_options', array($this, 'importOptions'));

			do_action( 'dilaz_panel_after_load' );
		}
		
		
		/**
		 * Initialize
		 *
		 * @since  2.7.12
		 * @access public
		 * @return array
		 */
		public function init() {
			add_action('wp_head', array($this, 'loadGoogleFonts'));
			
			require_once DILAZ_PANEL_DIR .'includes/functions.php';
			
			# Load parameters
			$this->parameters();
		}
		
		
		/**
		 * Options parameters
		 *
		 * @since  1.0
		 * @access public
		 * @return array
		 */
		public function parameters() {
			return $this->_params;
		}
		
		
		/**
		 * Constants
		 *
		 * @since  1.0
		 * @access public
		 * @return void
		 */
		public function constants() {
			@define('DILAZ_PANEL_URL', plugin_dir_url(__FILE__));
			@define('DILAZ_PANEL_DIR', trailingslashit(plugin_dir_path(__FILE__)));
			@define('DILAZ_PANEL_IMAGES', DILAZ_PANEL_URL .'assets/images/');
			@define('DILAZ_PANEL_PREFIX', (isset($this->_params['prefix']) && $this->_params['prefix'] != '') ? $this->_params['prefix'] .'_' : 'dilaz_panel_');
		}
		
		
		/**
		 * Includes
		 *
		 * @since  1.0
		 * @access public
		 * @return void
		 */
		public function includes() {
			require_once DILAZ_PANEL_DIR .'includes/fields.php';
			require_once DILAZ_PANEL_DIR .'includes/defaults.php';
		}
		
		
		/**
		 * Initialize Admin Panel
		 *
		 * @since  1.0
		 * @access public
		 * @return void
		 */
		public function adminInit() {

			do_action('dilaz_panel_before_init');
			
			# include required files 
			$this->includes();			
			
			# otpion name
			$option_name = $this->_optionName;
			
			# saved options
			$saved_options = get_option($option_name);
			
			# set default options if not saved yet
			if (!$saved_options) {
				$this->setDefaults($option_name);
			} else {
				
				$saved_panel_atts['panel-atts']   = isset($saved_options['panel-atts']) ? $saved_options['panel-atts'] : '';
				$defined_panel_atts['panel-atts'] = $this->panelAttsReduced();
				
				if ($defined_panel_atts != $saved_panel_atts) {
					array_splice($saved_options, 0, 1, $defined_panel_atts); // replace old atts with new atts
				}
			}
			
			# Add WP editor styles
			$this->editorStyles();
			
			do_action('dilaz_panel_after_init');
		}
		
		
		/**
		 * Panel attributes reduced
		 *
		 * @since  2.6.5
		 * @access public
		 * @return void
		 */
		public function panelAttsReduced() {
			
			$panel_atts = $this->_panelAtts;
			
			# remove 'id' and 'type' fields from panel atts
			unset($panel_atts['id']);
			unset($panel_atts['type']);
			
			return $panel_atts;
		}
		
		
		/**
		 * Add Admin Menu
		 *
		 * @since 1.0
		 * @since 2.5   added add_submenu_page method
		 * @since 2.7.8 added multiple capabilities check
		 * 
		 * @access public
		 * @return void
		 */
		public function registerMenu() {
			
			$params = $this->_params;

			# bail if parameters are not set
			if (!isset($params)) return;
			
			# bail if page and menu parameters are not set
			if (
				!isset($params['page_title']) || 
				!isset($params['menu_title']) || 
				!isset($params['options_view_cap']) || 
				!isset($params['page_slug'])
			) return;
			
			# At first, no menu is added
			$menu_added = FALSE;
			
			foreach ($params['options_view_cap'] as $cap_key => $cap) {
				
				# bail if current user doesn't have capability
				if (!current_user_can($cap)) continue;
				
				# Add menu only if there's none
				if (FALSE == $menu_added) {
				
					# Add submenu page if 'parent_slug' is set
					if (isset($params['parent_slug']) && trim($params['parent_slug']) != '') {
						
						# Menu page
						$panel_page = add_submenu_page(
							$params['parent_slug'], 
							$params['page_title'], 
							$params['menu_title'], 
							$cap, 
							$params['page_slug'], 
							array($this, 'page')
						);
					
					# Add a top-level menu page if 'parent_slug' is not set
					} else {
						
						# bail if 'menu_icon' or 'menu_position' parameters are not set
						if (!isset($params['menu_icon']) || !array_key_exists('menu_position', $params)) return;
						
						# Menu page
						$panel_page = add_menu_page(
							$params['page_title'], 
							$params['menu_title'], 
							$cap, 
							$params['page_slug'], 
							array($this, 'page'), 
							$params['menu_icon'],
							$params['menu_position']
						);
						
						# add Dilaz Panel submenu dropdown in admin bar
						# @since Dilaz Panel 2.7.4
						$menu_items = $this->menuArray();
						$count_items = 0;
						if (!empty($menu_items)) {
							foreach ($menu_items as $key => $val) {
								
								$count_items++;
								
								$parent_target = (isset($val['target']) && $val['target'] != '') ? $val['target'] : '';
								
								$sub_menu_page_slug = $count_items > 1 ? $params['page_slug'] .'#'. $parent_target : $params['page_slug'];
								add_submenu_page(
									$params['page_slug'], 
									esc_html($val['name']), 
									esc_html($val['name']), 
									$cap, 
									$sub_menu_page_slug, 
									array($this, 'page')
								);
								
							}
						}
					}
					
					# Enqueue scripts and styles
					add_action('admin_print_styles-'. $panel_page, array($this, 'enqueueStyles'));
					add_action('admin_print_scripts-'. $panel_page, array($this, 'enqueueScripts'));
					
					# If menu is added, then declare it to avoid same menu multiple additions
					$menu_added = ($panel_page) ? TRUE : FALSE;
				}
			}
		}
		
		
		/**
		 * Load Admin Styles
		 *
		 * @since 1.0
		 * @access public
		 * @return void
		 */
		public function enqueueStyles() {
			
			wp_enqueue_style('wp-color-picker');
			
			# Create auto-updating cache version based on the last file update
			$meterial_css_ver    = date('ymd-Gis', filemtime( DILAZ_PANEL_DIR .'assets/css/materialdesignicons.min.css' ));
			$select2_css_ver     = date('ymd-Gis', filemtime( DILAZ_PANEL_DIR .'assets/css/select2.min.css' ));
			$dilaz_panel_css_ver = date('ymd-Gis', filemtime( DILAZ_PANEL_DIR .'assets/css/admin.css' ));
			
			wp_enqueue_style('material-webfont', DILAZ_PANEL_URL .'assets/css/materialdesignicons.min.css', FALSE, $meterial_css_ver);
			wp_enqueue_style('select2', DILAZ_PANEL_URL .'assets/css/select2.min.css', FALSE, $select2_css_ver);
			wp_enqueue_style('dilaz-panel', DILAZ_PANEL_URL .'assets/css/admin.css', FALSE, $dilaz_panel_css_ver);
		}
		
		
		/**
		 * Load Admin Scripts
		 *
		 * @since  1.0
		 * @access public
		 * @return void
		 */
		public function enqueueScripts() {
			
			if (function_exists('wp_enqueue_media')) {
				wp_enqueue_media();
			} else {
				wp_enqueue_style('thickbox');
				wp_enqueue_script('thickbox');
				wp_enqueue_script('media-upload');
			}
			
			# Create auto-updating cache version based on the last file update
			$select2_js_ver     = date('ymd-Gis', filemtime( DILAZ_PANEL_DIR .'assets/js/select2/select2.min.js' ));
			$dilaz_panel_js_ver = date('ymd-Gis', filemtime( DILAZ_PANEL_DIR .'assets/js/admin.js' ));
			
			wp_enqueue_script('wp-color-picker');
			wp_enqueue_script('select2', DILAZ_PANEL_URL .'assets/js/select2/select2.min.js', FALSE, $select2_js_ver, TRUE);
			wp_enqueue_script('dilaz-dowhen-script', DILAZ_PANEL_URL .'assets/js/jquery.dowhen.js');
			wp_enqueue_script('dilaz-panel-js', DILAZ_PANEL_URL .'assets/js/admin.js', array('jquery', 'jquery-ui-core', 'jquery-ui-slider'), $dilaz_panel_js_ver, TRUE);
			
			# Localization
			wp_localize_script(
				'dilaz-panel-js', 
				'dilaz_panel_lang', 
				array(
					'dilaz_panel_url'    => DILAZ_PANEL_URL,
					'dilaz_panel_images' => DILAZ_PANEL_IMAGES,
					'dilaz_panel_prefix' => DILAZ_PANEL_PREFIX,
					'page_slug'          => !empty($this->_params) && isset($this->_params['page_slug']) ? $this->_params['page_slug'] : '',
					'upload'             => __('Upload', 'dilaz-panel'),
					'remove'             => __('Remove', 'dilaz-panel'),
					'upload_title'       => __('Select Image', 'dilaz-panel'),
					'upload_alert'       => __('Only image is allowed, please try again!', 'dilaz-panel'),
					'confirm_delete'     => __('Are you sure?', 'dilaz-panel'),
					'confirm_reset'      => __('Are you sure? All settings will be lost and replaced with default settings!', 'dilaz-panel'),
				)
			);
		}
		
		
		/**
		 * WP Editor custom styles
		 *
		 * @since  2.7.11
		 * 
		 * @access public
		 * @return void
		 */
		public function editorStyles() {
			add_editor_style( DILAZ_PANEL_URL .'assets/css/custom-editor-styles.css' );
		}
		
		
		/**
		 * Sanitize parameters
		 *
		 * @since  2.5
		 * @since  2.7.8 - deprecated 'options_cap'
		 * @since  2.7.8 - sanitize 'options_view_cap' and 'options_save_cap'
		 * 
		 * @access public
		 * @return void
		 */
		public function sanitizeParams($params) {
			
			foreach($params as $key => $val) {
				switch ($key) {
					case 'option_name':
					case 'option_prefix':
					case 'use_type':
					case 'page_slug':
					case 'page_title':
					case 'menu_title':
					case 'options_cap':
					case 'menu_icon':
					case 'parent_slug':
					case 'log_title':
					case 'doc_title':
					case 'support_title':
					case 'item_name':
					case 'item_version':
						$params[$key] = sanitize_text_field($val);
						break;
					
					case 'options_view_cap':
					case 'options_save_cap':
						if (is_array($val)) {
							foreach ($val as $k => $v) {
								$val[$k] = sanitize_text_field($v);
							}
							$params[$key] = $val;
						} else {
							$params[$key] = sanitize_text_field($val);
						}
						break;
						
					case 'default_options':
					case 'custom_options':
					case 'admin_bar_menu':
					case 'import_export':
						$params[$key] = ($val == '') ? FALSE : filter_var($val, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
						break;
						
					case 'menu_position':
						if (trim($val) != '' && $val != NULL) {
							$params[$key] = is_int($val) ? absint($val) : NULL;
						} else {
							$params[$key] = NULL;
						}
						break;
						
					case 'log_url':
					case 'doc_url':
					case 'support_url':
					case 'dir_url':
						$params[$key] = esc_url($val);
						break;
						
					# sanitize custom parameters via this filter hook
					case $key:
						$params[$key] = apply_filters('dilaz_panel_sanitize_param_'. $key .'_hook', $val); 
						break;
				}
			}
			
			return $params;
		}
		
		
		/**
		 * Add Admin Bar Menu
		 *
		 * @since  1.0
		 * @since  2.7.11 added 'options_view_cap' capability check
		 * 
		 * @access public
		 * @global string $wp_admin_bar
		 * @return void
		 */
		public function adminBar() {
			
			$params = $this->_params;
			
			# bail if parameters are not set
			if ( !isset($params) ) return;
			
			# bail if page and menu parameters are not set
			if ( !isset($params['menu_title']) || !isset($params['page_slug']) ) return;
			
			# show if enabled
			if ( isset($params['admin_bar_menu']) && $params['admin_bar_menu'] == TRUE ) {
			
				# At first, no menu is added
				$menu_bar_added = FALSE;
				
				foreach ($params['options_view_cap'] as $cap_key => $cap) {
					
					# bail if current user doesn't have capability
					if (!current_user_can($cap)) continue;
					
					# Add menu only if there's none
					if (FALSE == $menu_bar_added) {
						
						global $wp_admin_bar;
						
						$menu_id = $params['page_slug'] .'_node';
						
						# add Dilaz Panel menu node in admin bar
						$wp_admin_bar->add_node(array(
							'id'    => $menu_id,
							'title' => '<span class="ab-icon dashicons-admin-generic" style="padding-top:6px;"></span><span class="ab-label">'. $params['menu_title'] .'</span>',
							'href'  => admin_url('admin.php?page='. $params['page_slug']),
							'meta'  => array('class' => 'dilaz-panel-admin-bar-menu')
						));
						
						# add Dilaz Panel submenu dropdown in admin bar
						# @since Dilaz Panel 2.7.2
						$menu_items = $this->menuArray();
						
						if ( !empty($menu_items) ) {
							foreach ( $menu_items as $key => $val ) {
								
								$parent_target = ( isset($val['target']) && $val['target'] != '' ) ? $val['target'] : '';
								
								if ( isset($val['icon']) && ($val['icon'] != '') ) {
									$menu_icon = '<span class="mdi '. $val['icon'] .'" style="font-family:Material Design Icons;margin-right:5px"></span>';
								} else {
									$menu_icon = '<span class="mdi mdi-settings" style="font-family:Material Design Icons;margin-right:5px"></span>';
								}
								
								# drop down level 1
								$drop_down_parent_id = $menu_id .'_'. $parent_target;
								$wp_admin_bar->add_node(array(
									'parent' => $menu_id,
									'title'  => $menu_icon . esc_html($val['name']),
									'id'     => $drop_down_parent_id,
									'href'   => admin_url('admin.php?page='. $params['page_slug'] .'#'. $parent_target),
									'meta'   => array('class' => 'dilaz-panel-admin-bar-menu-l1')
								));
								
								# drop down level 2
								if (isset($val['children']) && sizeof($val['children']) > 0) {
									foreach ($val['children'] as $child) {
										$child_target = $child['target'];
										$wp_admin_bar->add_node(array(
											'parent' => $drop_down_parent_id,
											'title'  => esc_html($child['name']),
											'id'     => $menu_id .'_'. $child_target,
											'href'   => admin_url('admin.php?page='. $params['page_slug'] .'#'. $child_target),
											'meta'   => array('class' => 'dilaz-panel-admin-bar-menu-l2')
										));
									}
								}
								
							}
					
							# If menu is added, then declare it to avoid same menu multiple additions
							$menu_bar_added = TRUE;
						}
					}
				}
			}
		}
		
		
		/**
		 * Admin panel page
		 *
		 * @since  1.0
		 * @access public
		 * @return mixed
		 */
		public function page() {
			
			$params = $this->_params;
			
			if ($params['use_type_error'] == FALSE) {
				
				?>
				
				<div id="dilaz-panel-wrap" class="wrap">
					<div id="dilaz-panel">
						<div id="dilaz-panel-header" class="clearfix">
							<div class="dilaz-panel-item-details">
								<span class="name"><?php echo $params['item_name']; ?></span>
								<span class="version">Version: <?php echo $params['item_version']; ?></span>
							</div>
						</div>
						<div id="dilaz-panel-content" class="clearfix">
							<form id="dilaz-panel-form" enctype="multipart/form-data" method="post" data-option-name="<?php echo $this->_optionName; ?>" data-option-page="<?php echo $_GET['page']; ?>">
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
									<?php echo $this->menuHTML(); ?>
								</div>
								<div class="dilaz-panel-fields">
									<div class="dilaz-panel-fields-preloader" style="display:block !important"><span class="mdi mdi-loading mdi-spin"></span></div>
									<?php echo $this->fields(); ?>
								</div>
								<div class="clear"></div>
								<div class="dilaz-panel-bottom clearfix">
									<div class="dilaz-ajax-save" style="float:left">
										<input type="submit" class="reset button" name="reset" value="<?php esc_attr_e( 'Reset Options', 'dilaz-panel'); ?>" />
										<span class="spinner"></span>
										<span class="progress"><?php _e('Resetting options... Please wait...', 'dilaz-panel'); ?></span>
										<span class="finished"></span>
									</div>
									<div class="dilaz-ajax-save" style="float:right">
										<input type="hidden" name="option_name" value="<?php echo $this->_optionName; ?>" />
										<input type="hidden" name="security" value="<?php echo wp_create_nonce(basename(__FILE__)); ?>" />
										<span class="spinner"></span>
										<span class="progress"><?php _e('Saving options... Please wait...', 'dilaz-panel'); ?></span>
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
		 * Panel menu array
		 *
		 * @since  2.7.3
		 * @access public
		 * @return void
		 */
		public function menuArray() {
			
			$options = $this->_options;
			
			$parent     = 0;
			$menu_array = array();
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
						$menu_array[$target] = $val;
						$parent = $target;
					}
					
					if ($val['type'] == 'subheading') {
						$menu_array[$parent]['children'][] = $val;
					}
				}
			}
			
			return $menu_array;
			
		}
		
		
		/**
		 * Panel menu
		 *
		 * @since  1.0
		 * @access public
		 * @return void
		 */
		public function menuHTML() {
			
			$menu_items = $this->menuArray();
			
			$menu = '';
			
			if (!empty($menu_items) && sizeof($menu_items) > 0) {
				
				$menu .= '<ul>';
					
					foreach ($menu_items as $key => $val) {
						
						$class = (isset($val['children']) && $val['children'] != '') ? 'has_children' : '';
						$parent_target = (isset($val['target']) && $val['target'] != '') ? $val['target'] : '';
						
						$menu .= '<li id="'. $parent_target .'" class="top_level '. $class .'">';
						
							if (isset($val['icon']) && ($val['icon'] != '')) {
								$menu .= '<span class="mdi '. $val['icon'] .'"></span>';
							}
							
							$menu .= '<a class="trigger" href="#'. $parent_target .'">'. esc_html($val['name']) .'</a>';
							
							if (isset($val['children']) && sizeof($val['children']) > 0) {
								$menu .= '<ul class="submenu">';
									foreach ($val['children'] as $child) {
										$child_target = $child['target'];
										$menu .= '<li id="'. $child_target .'" class="child"><a class="trigger" href="#'. $child_target .'">'. esc_html($child['name']) .'</a></li>';
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
		 * @since  1.0
		 * @access public
		 * @global array $allowed_tags
		 * @return array
		 */
		public function fields() {
			
			$option_name   = $this->_optionName;
			$option_data   = get_option($option_name);
			$option_fields = $this->_options;
			
			$counter = 0;
			$output = '';
			
			if (is_array($option_fields)) {
				
				foreach ($option_fields as $field) {
					
					# skip panel-atts field type
					if (isset($field['type']) && $field['type'] == 'panel-atts') continue;
					
					$counter++;
					
					# setup field types defaults
					if ( !isset( $field['id'] ) ) $field['id'] = '';
					if ( !isset( $field['type'] ) ) $field['type'] = '';
					if ( !isset( $field['name'] ) ) $field['name'] = '';
					if ( !isset( $field['desc'] ) ) $field['desc'] = '';
					if ( !isset( $field['desc2'] ) ) $field['desc2'] = '';
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
							$output .= '<div class="description">'.wp_kses_post($field['desc']).'</div>';
						}
						
						$output .= '<div class="option clearfix">' ."\n";
						
					} else if ($field['type'] == 'info') {
						$output .= '<div id="'. esc_attr($section_id) .'" class="'. esc_attr($section_class) .' info-wrap clearfix"'. $cond_fields .'>' . "\n";
					}
					
					# Field types
					switch ($field['type']):
					
						case 'heading'     : $output .= DilazPanelFields::fieldHeading($field); break;
						case 'subheading'  : $output .= DilazPanelFields::fieldSubheading($field); break;
						case 'info'        : $output .= DilazPanelFields::fieldInfo($field); break;
						case 'text'        : $output .= DilazPanelFields::fieldText($field); break;
						case 'multitext'   : $output .= DilazPanelFields::fieldMultitext($field); break;
						case 'password'    : $output .= DilazPanelFields::fieldPassword($field); break;
						case 'email'       : $output .= DilazPanelFields::fieldEmail($field); break;
						case 'textarea'    : $output .= DilazPanelFields::fieldTextarea($field); break;
						case 'select'      : $output .= DilazPanelFields::fieldSelect($field); break;
						case 'repeatable'  : $output .= DilazPanelFields::fieldRepeatable($field); break;
						case 'multiselect' : $output .= DilazPanelFields::fieldMultiselect($field); break;
						case 'queryselect' : $output .= DilazPanelFields::fieldQueryselect($field); break;
						case 'radio'       : $output .= DilazPanelFields::fieldRadio($field); break;
						case 'radioimage'  : $output .= DilazPanelFields::fieldRadioimage($field); break;
						case 'buttonset'   : $output .= DilazPanelFields::fieldButtonset($field); break;
						case 'switch'      : $output .= DilazPanelFields::fieldSwitch($field); break;
						case 'checkbox'    : $output .= DilazPanelFields::fieldCheckbox($field); break;
						case 'multicheck'  : $output .= DilazPanelFields::fieldMulticheck($field); break;
						case 'slider'      : $output .= DilazPanelFields::fieldSlider($field); break;
						case 'range'       : $output .= DilazPanelFields::fieldRange($field); break;
						case 'color'       : $output .= DilazPanelFields::fieldColor($field); break;
						case 'multicolor'  : $output .= DilazPanelFields::fieldMulticolor($field); break;
						case 'font'        : $output .= DilazPanelFields::fieldFont($field); break;
						case 'upload'      : $output .= DilazPanelFields::fieldUpload($field); break;
						case 'background'  : $output .= DilazPanelFields::fieldBackground($field); break;
						case 'editor'      : $output .= DilazPanelFields::fieldEditor($field); break;
						case 'export'      : $output .= DilazPanelFields::fieldExport($field); break;
						case 'import'      : $output .= DilazPanelFields::fieldImport($field); break;
						
						# add custom field types via this hook - 'dilaz_panel_FIELD_TYPE_action'
						case $field['type'] : do_action('dilaz_panel_field_'. $field['type'] .'_hook', $field); break;
						
					endswitch; 
					
					if ($field['type'] != 'heading' && $field['type'] != 'subheading' && $field['type'] != 'info') {
						if ($field['type'] != 'checkbox' && $field['type'] != 'info' && $field['desc2'] != '') {
							$output .= '<div class="description desc2">'.wp_kses_post($field['desc2']).'</div>';
						}
						$output .= '</div><!-- .option -->'; # .option
						$output .= '</div><!-- .section_class -->'; # .$section_class
					} else if ($field['type'] == 'info') {
						$output .= '</div>' . "\n"; # .info-wrap
					}
				}
				
				$output .= '</div><!-- tab -->';
			}
			
			return $output;
		}
		
		
		/**
		 * Add default options
		 *
		 * @since  1.0
		 * @access public
		 * @param  string $option_name
		 * @return void
		 */
		public function setDefaults($option_name) {
			
			$values = $this->dafaultValues();
			
			if (isset($values))
				update_option($option_name, $values);
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
		 * @access public
		 * @return void|bool
		 */
		public function setOption($option_name, $option_id, $option_value = FALSE, $option_type = FALSE) {
			
			if (!isset($option_name)) return FALSE;
			if (!isset($option_id)) return FALSE;
			
			# sanitize option id
			$option_id = sanitize_key($option_id);
			
			# get all options
			$options = $this->getOptions($option_name);
			
			# bail if $options are not set
			if (!isset($options) || !is_array($options) || !$options) return FALSE;
			
			# delete the option if its already set
			if (isset($options[$option_id])) unset($options[$option_id]);
			
			# create sanitized options array
			$sanitized_options = [];
			
			# Get sanitiszed options
			$sanitized_options[$option_id] = $this->sanitizeOption($option_type, $option_value, '', TRUE);
			
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
		 * @access public 
		 * @return void|bool
		 */
		public function deleteOption($option_name, $option_id) {
			
			if (!isset($option_name)) return FALSE;
			if (!isset($option_id)) return FALSE;
			
			# sanitize option id
			$option_id = sanitize_key($option_id);
			
			# get all options
			$options = $this->getOptions($option_name);
			
			# bail if $options are not set
			if (!isset($options) || !is_array($options) || !$options) return FALSE;
			
			# delete the option if its already set
			if (isset($options[$option_id])) unset($options[$option_id]);
			
			update_option($option_name, $options);
		}
		
		
		/**
		 * Get panel options from file
		 * Used in ajax save
		 *
		 * @since 1.2
		 *
		 * @param string $option_name option name as used in wp_options table
		 *
		 * @return array|bool FALSE if option is not set or option file does not exist
		 */
		public function getOptionsFromFile($option_name) {
			
			if (!isset($option_name)) return FALSE;
			
			$saved_options = get_option($option_name);
			
			if ($saved_options && isset($saved_options['panel-atts']['files']) && isset($saved_options['panel-atts']['params'])) {
				
				$parameters = $saved_options['panel-atts']['params'];
				
				# include default options file
				if (is_file($saved_options['panel-atts']['files'][0]) && $this->_params['default_options']) {
					include $saved_options['panel-atts']['files'][0];
				}
				
				# include custom options file
				if (is_file($saved_options['panel-atts']['files'][1]) && $this->_params['custom_options']) {
					include $saved_options['panel-atts']['files'][1];
				}
				
				# include main options file
				if (is_file($saved_options['panel-atts']['files'][2]))
					include $saved_options['panel-atts']['files'][2];
				
				# set attributes
				$panel_atts['panel-atts'] = $this->panelAttsReduced();
				
				# merge attributes to options
				return wp_parse_args($panel_atts, $options);
				
			} else {
				return FALSE;
			}
		}
		
		
		/**
		 * Get single saved option
		 *
		 * @since 1.0
		 *
		 * @param string $option_name option name as used in wp_options table
		 * @param string $option_id   option key or unique identifier
		 *
		 * @return mixed|string|array|bool FALSE if option is not set
		 */
		public static function getOption($option_name, $option_id = FALSE) {
			
			if (!isset($option_name)) return FALSE;
			
			$options = get_option($option_name);
			
			if (isset($options) && isset($options[$option_id]) && !empty($option_id)) {
				return $options[$option_id];
			} else {
				return FALSE;
			}
		}
		
		
		/**
		 * Get all saved options
		 *
		 * @since 1.0
		 *
		 * @param string $option_name option name as used in wp_options table
		 *
		 * @return array|bool FALSE if option is not set
		 */
		public static function getOptions($option_name) {
			
			if (!isset($option_name)) return FALSE;
			
			$options = get_option($option_name);
			
			return (isset($options)) ? $options : FALSE;
		}
		
		
		/**
		 * Get default values
		 *
		 * @since  1.0
		 * @access public
		 * @return array all default values
		 */
		public function dafaultValues($option_name = '') {
			
			$output = [];
			if ($option_name != '') {
				$options    = $this->getOptionsFromFile($option_name);
				$panel_atts = $this->getOptions($option_name)['panel-atts'];
			} else {
				$options = $this->_options;
			}
			
			foreach ( (array) $options as $option ) {
				
				if (!isset($option['id']) || !isset($option['type'])) continue;
				if ($option['type'] == 'heading' || $option['type'] == 'subheading') continue;
				if ($option['type'] == 'export' || $option['type'] == 'import') continue;
				if ($option['type'] == 'info') continue;
				
				$id = sanitize_key($option['id']);
				
				# Standard option
				$option_std = isset($option['std']) ? $option['std'] : '';
				
				# Set checkbox to standard value
				if ('checkbox' == $option['type']) {
					$option_std = $option_std;
				}
				
				# Set all checbox fields to standard value
				if ('multicheck' == $option['type']) {
					
					# current standard option
					$standard = $option_std;
					
					# create an array
					$option_std = [];
					
					foreach ($option['options'] as $key => $value) {
						$option_std[$key] = is_array($standard) && in_array($key, $standard) ? TRUE : FALSE;
					}
				}
				
				# Set all multitext fields to standard value
				if ('multitext' == $option['type']) {
					
					# create an array
					$option_std = [];
					
					foreach ($option['options'] as $key => $value) {
						if (isset($option['options'][$key])) {
							$option_std[$key] = isset($value['default']) ? $value['default'] : '';
						}
					}
				}
				
				# Set all repeatable fields to standard value
				if ('repeatable' == $option['type']) {
					
					# create an array
					$option_std = [];
					
					foreach ($option['options'] as $key => $value) {
						foreach ($value as $k => $v) {
							$option_std[$key][$k] = isset($v['value']) ? $v['value'] : '';
						}
					}
				}
				
				$output[$id] = $this->sanitizeOption($option['type'], $option_std, $option);
			}
			
			if ($option_name != '') {
				$output = wp_parse_args($output, array('panel-atts' => $panel_atts));
			}
			
			return $output;
		}
			
		
		
		/**
		 * Reset options
		 *
		 * @since  1.0
		 *
		 * @param  string $option_name
		 *
		 * @access public
		 * @return void
		 */
		public function resetOptions() {
			
			$response = array();
			
			# verify nonce and proceed
			if (isset($_POST['security']) || wp_verify_nonce($_POST['security'], basename(__FILE__))) {
				
				$option_name = isset($_POST['dilaz_option_name']) ? sanitize_text_field($_POST['dilaz_option_name']) : '';
				$option_page = isset($_POST['dilaz_option_page']) ? sanitize_text_field($_POST['dilaz_option_page']) : '';
				
				# get default values
				$values = $this->dafaultValues($option_name);
				
				if (isset($values)) {
					update_option($option_name, $values);
				}
				
				$response['success']  = 1;
				$response['message']  = esc_html__('Options reset successfully.', 'dilaz-panel');
				$response['redirect'] = admin_url('admin.php?page='. $option_page);
				
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
		 * @since 2.7.8 added user capability check before saving options
		 * @since 2.7.12 saving of all used Google fonts
		 *
		 * @param string $option_name option name as used in wp_options table
		 *
		 * @access public
		 * @return json
		 */
		public function saveOptions() {
			
			$params = $this->_params;
			
			$response = array();
			
			# parse form data query string into array
			parse_str($_POST['form_data'], $form_data);
			
			# verify nonce and proceed
			if (isset($form_data['security']) || wp_verify_nonce($form_data['security'], basename(__FILE__))) {
				
				# set option name
				$option_name = isset($form_data['option_name']) ? sanitize_text_field($form_data['option_name']) : '';
				
				/* 
				 * VERY IMPORTANT!
				 * 
				 * @since 2.7.8
				 * 
				 * There might be use of Dilaz Panel on different plugins or themes,
				 * so we need to check the current panel instance and ignore all the 
				 * other instances whose form is not being saved.
				 */
				if ($this->_optionName != $option_name) return false;
				
				# remove options that should not be saved
				if (isset($form_data['security'])) unset($form_data['security']);
				
				$sanitized_options = array();
				$defined_options   = $this->getOptionsFromFile($option_name);
				$saved_options     = $this->getOptions($option_name);
				
				# get all options from files and those added via filter and then remove duplicates
				$all_options = DilazPanelFunctions::unique_multidimensional_array(array_merge($this->_options, $defined_options), 'id');
				
				foreach ($all_options as $option) {
					
					if (!isset($option['id']) || !isset($option['type'])) continue;
					if ($option['type'] == 'heading' || $option['type'] == 'subheading') continue;
					if ($option['type'] == 'export' || $option['type'] == 'import') continue;
					if ($option['type'] == 'info') continue;
					
					$id = sanitize_key($option['id']);
					
					# Set checkbox to FALSE if not set
					if ('checkbox' == $option['type'] && !isset($form_data[$id])) {
						$form_data[$id] = FALSE;
					}
					
					# Set all checbox fields to FALSE if not set
					if ('multicheck' == $option['type'] && !isset($form_data[$id])) {
						foreach ($option['options'] as $key => $value) {
							$form_data[$id][$key] = FALSE;
						}
					}
					
					# Get sanitiszed options
					if (isset($form_data[$id])) { 
						$sanitized_options[$id] = $this->sanitizeOption($option['type'], $form_data[$id], $option);
					} else if (!isset($form_data[$id]) && isset($saved_options[$id])) {
						$sanitized_options[$id] = $this->sanitizeOption($option['type'], $saved_options[$id], $option);
					} else {
						$sanitized_options[$id] = $this->sanitizeOption($option['type'], '', $option);
					}
					
					# Set any saved Google fonts to be loaded
					if ('font' == $option['type']) {
						if (isset($sanitized_options[$id]['family']) && $sanitized_options[$id]['family'] != '') {
							if (!array_key_exists($sanitized_options[$id]['family'], DilazPanelDefaults::_font_family_defaults())) {
								$google_fonts['saved_google_fonts'][] = $sanitized_options[$id];
							}
						}
					}
					
				}
				
				$panel_atts['panel-atts'] = $this->panelAttsReduced();
				
				$merged_options = array_merge(wp_parse_args($panel_atts, $saved_options), $sanitized_options);
				
				# Remove any default options saved when 
				# 'default_options' parameter is set to FALSE
				if (FALSE == $this->_params['default_options']) {
					foreach($merged_options as $key => $val) {
						
						# ensure we keep panel-atts
						if ($key == 'panel-atts') continue;
						
						if (!isset($form_data[$key])) {
							unset($merged_options[$key]);
						}
					}
				}
				
				# Lets add Google fonts if any have been saved
				if (!empty($google_fonts)) {
					$merged_options = array_merge($merged_options, $google_fonts);
				}
				
				# At first, options are not yet saved
				$options_saved = FALSE;
				
				# Check capability parameter
				if (isset($params['options_save_cap']) && is_array($params['options_save_cap'])) {
					
					# Iterate through the allowed capabilities
					foreach ($params['options_save_cap'] as $cap_key => $cap) {
						
						# Check user capability for saving options
						if (current_user_can($cap)) {
							
							# Proceed only if options haven't been saved
							if (FALSE == $options_saved) {
									update_option($option_name, $merged_options);
									
									$options_saved = TRUE;
								
									$response['success'] = 1;
									$response['message'] = esc_html__('Options saved successfully.', 'dilaz-panel');
							}
							
						} else {
							$response['success'] = 0;
							$response['message'] = esc_html__('Not saved! No permission.', 'dilaz-panel');
						}
					}
					
				} else {
					$response['success'] = 0;
					$response['message'] = esc_html__('Invalid "options_save_cap".', 'dilaz-panel');
				}
				
			} else {
				$response['success'] = 0;
				$response['message'] = esc_html__('Error! Options not saved. Please refresh the page and try again.', 'dilaz-panel');
			}
			
			echo json_encode($response);
			
			exit;
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
		 * @access public
		 * @return void|bool FALSE if option is not saved
		 */
		public function saveOption($option_name, $option_id, $option_value = FALSE, $option_type = FALSE) {
			
			if (!isset($option_name)) return FALSE;
			if (!isset($option_id)) return FALSE;
			
			# sanitize option id
			$option_id = sanitize_key($option_id);
			
			# get all options
			$options = $this->getOptions($option_name);
			
			# bail if $options are not set
			if (!isset($options) || !is_array($options) || !$options) return FALSE;
			
			# delete the option if its already set
			if (isset($options[$option_id])) unset($options[$option_id]);
			
			# create sanitized options array
			$sanitized_options = [];
			
			# Get sanitiszed options
			$sanitized_options[$option_id] = $this->sanitizeOption($option_type, $option_value, '', TRUE);
			
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
		 * @param bool   $set_option whether the option is being set. Default is FALSE
		 *
		 * @access public
		 * @return string|mixed|bool sanitized values
		 */
		public function sanitizeOption($type, $input, $option = '', $set_option = FALSE) {
			
			switch ($type) {
			
				case 'text':
				case 'switch':
				case 'password':
					return sanitize_text_field($input);
					break;
					
				case 'multitext':
					$output = [];
					foreach ((array)$input as $k => $v) {
						if (isset($option['options'][$k]) || $set_option) {
							$output[$k] = $v;
						}
					}
					return !empty($output) ? $output : '';
					break;
					
				case 'email':
					$sanitized_email = sanitize_email($input);
					return is_email($sanitized_email) ? $sanitized_email : '';
					break;
					
				case 'textarea':
					return sanitize_textarea_field($input);
					break;
					
				case 'editor':
					return $input;
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
					$output = [];
					foreach ((array)$input as $k => $v) {
						$output[$k] = absint($v);
					}
					return !empty($output) ? $output : '';
					break;
					
				case 'multiselect':
					$output = [];
					foreach ((array)$input as $k => $v) {
						if (isset($option['options'][$v]) || $set_option) {
							$output[] = $v;
						}
					}
					return !empty($output) ? $output : '';
					break;
					
				case 'checkbox':
					return ($input == '') ? FALSE : (bool)$input;
					break;
					
				case 'multicheck':
					$output = array();
					foreach ((array)$input as $k => $v) {
						if ( ( isset($option['options'][$k]) && $v == TRUE ) || $set_option ) {
							$output[$k] = TRUE;
						} else {
							$output[$k] = FALSE;
						}
					}
					return !empty($output) ? $output : '';
					break;
					
				case 'repeatable':
					$output = [];
					foreach ((array)$input as $key => $value) {
						foreach ($value as $k => $v) {
							$output[$key][$k] = sanitize_text_field($v);
						}
					}
					return !empty($output) ? $output : '';
					break;
					
				case 'color':
					return sanitize_hex_color($input);
					break;
					
				case 'multicolor':
					$output = [];
					foreach ((array)$input as $k => $v) {
						if (isset($option['options'][$k]) || $set_option) {
							$output[$k] = sanitize_hex_color($v);
						}
					}
					return !empty($output) ? $output : '';
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
					return !empty($output) ? $output : '';
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
					$output = array();
					foreach ((array)$input as $k => $v) {
						$output[] = absint($v);
					}
					return sizeof($output) > 1 ? array_filter(array_unique($output)) : $output; // 'array_filter' used to remove zero-value entries
					break;
					
				case 'panel-atts':
					$output = array();
					$files = array();
					$params = array();
					if (isset($option['files'])) {
						foreach ($option['files'] as $k => $v) {
							$output['files'][$k] = sanitize_text_field($v);
						}
					}
					if (isset($option['params'])) {
						foreach ($option['params'] as $k => $v) {
							$k = sanitize_text_field($k);
							$output['params'][$k] = sanitize_text_field($v);
						}
					}
					
					return $output;
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
		 * @since  1.0
		 * @access public
		 * @return void
		 */
		public function exportOptions() {
			
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
		 * @since  1.0
		 * @access public
		 * @return void
		 */
		public function importOptions() {
			
			$response = array();
			
			if (isset($_POST['dilaz_import_nonce']) || wp_verify_nonce($_POST['dilaz_import_nonce'], basename(__FILE__))) {
				
				$import_file   = isset($_POST['dilaz_import_file']) ? sanitize_text_field($_POST['dilaz_import_file']) : '';
				$option_page   = isset($_POST['dilaz_option_page']) ? sanitize_text_field($_POST['dilaz_option_page']) : '';
				$option_name   = isset($_POST['dilaz_option_name']) ? sanitize_text_field($_POST['dilaz_option_name']) : '';
				$valid_formats = array('json'); 
				
				# file upload handler
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					
					$file = isset($_FILES[$import_file]) ? $_FILES[$import_file]['tmp_name'] : NULL;
					
					if ($file != NULL) {
						
						$data = $this->initializeFileSystem($file);
						$data = json_decode($data, TRUE);
						
						if (isset($data['dilaz_panel_backup_time'])) {
							
							unset($data['dilaz_panel_backup_time']);
							
							update_option($option_name, $data);
							
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
		 * Load Google fonts in frontend
		 * 
		 * @since 2.7.12
		 * @return mixed Google fonts head tag code
		 */
		public function loadGoogleFonts() {
			
			if (empty($this->savedGFonts)) return FALSE;
			
			$families = array();
			$subsets  = array();
			
			foreach ($this->savedGFonts as $key => $font) {
				
				if (isset($font['family']) && $font['family'] != '') {
					$weights  = array();
					if (isset($font['weight']) && in_array($font['weight'], ['100', '200', '300', '400', '500', '600', '700', '800', '900'])) {
						$weights[] = $font['weight'];
					}
					
					$font_family = str_replace(' ', '+', $font['family']);
					
					$families[] = $font_family . ':' . implode(',', array_values($weights));
					
					if (isset($font['subset']) && $font['subset'] != '') {
						$subsets[] = $font['subset'];
					}
				}
				
			}
			
			if (!empty($families)) {
				
				$query_args = array(
					'family'  => implode('|', $families),
					'display' => 'swap',
				);
				
				if (!empty($subsets)) {
					$query_args = array_merge($query_args, array('subset' => implode(',', array_values($subsets))));
				}

				$font_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
			
				?>
				
				<!-- Code snippet to speed up Google Fonts rendering: googlefonts.3perf.com --> 
				<link rel="dns-prefetch" href="https://fonts.gstatic.com"> 
				<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous"> 
				<link rel="preload" href="<?php echo $font_url; ?>" as="fetch" crossorigin="anonymous">
				<script type="text/javascript"> !function(e,n,t){"use strict";var o="<?php echo $font_url; ?>",r="__3perf_googleFonts_<?php echo 'dilaz'; ?>";function c(e){(n.head||n.body).appendChild(e)}function a(){var e=n.createElement("link");e.href=o,e.rel="stylesheet",c(e)}function f(e){if(!n.getElementById(r)){var t=n.createElement("style");t.id=r,c(t)}n.getElementById(r).innerHTML=e}e.FontFace&&e.FontFace.prototype.hasOwnProperty("display")?(t[r]&&f(t[r]),fetch(o).then(function(e){return e.text()}).then(function(e){return e.replace(/@font-face {/g,"@font-face{font-display:swap;")}).then(function(e){return t[r]=e}).then(f).catch(a)):a()}(window,document,localStorage); 
				</script> 
				<!-- End of code snippet for Google Fonts -->
				
				<?php
			}
		}
		
		
		/**
		 * Initialize Filesystem object and read file
		 *
		 * @see http://www.webdesignerdepot.com/2012/08/wordpress-filesystem-api-the-right-way-to-operate-with-local-files/
		 * @see http://codex.wordpress.org/Filesystem_API
		 * 
		 * @param  str                $file - file to be read
		 * @global WP_Filesystem_Base $wp_filesystem Subclass
		 * @return string|bool        file content, FALSE on failure
		 */
		public function initializeFileSystem($file) {
			
			$url = wp_nonce_url('admin.php?page='. $this->_params['page_slug']);
			
			# bail if can't get get credentials
			if (FALSE === ($creds = request_filesystem_credentials($url))) {
				return;
			}
			
			# use acquired credentials
			if (!WP_Filesystem($creds)) {
				request_filesystem_credentials($url, '', TRUE, FALSE, NULL);
				return;
			}
			
			global $wp_filesystem;
			
			return $wp_filesystem->get_contents($file);
		}
		
	} // end class
}

/* Add update checker */
require 'includes/update-checker/plugin-update-checker.php';

/* Build the update checker */
$dilazPanelUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/Rodgath/Dilaz-Panel-Plugin/',
	__FILE__,
	'dilaz-panel'
);

/* Update from the "master" branch */
$dilazPanelUpdateChecker->setBranch('master');
