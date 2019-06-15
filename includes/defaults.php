<?php 
/*
|| --------------------------------------------------------------------------------------------
|| Admin Panel Defaults
|| --------------------------------------------------------------------------------------------
||
|| @package		Dilaz Panel
|| @subpackage	Defaults
|| @since		Dilaz Panel 2.0
|| @author		Rodgath, https://github.com/Rodgath
|| @copyright	Copyright (C) 2017, Rodgath LTD
|| @link		https://github.com/Rodgath/Dilaz-Panel-Plugin
|| @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
|| 
*/

defined('ABSPATH') || exit;

class DilazPanelDefaults {
	
	function __construct() {
		
	}
	
	/**
	 * Background defaults
	 *
	 * @since 1.0
	 *
	 * @return array
	 */
	public static function _bg() {
		
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
	
	
	/**
	 * Multicolor defaults
	 *
	 * @since 1.0
	 *
	 * @return array
	 */
	public static function _multicolor() {
		$multicolor_defaults = array();
		$multicolor_defaults = apply_filters('dilaz_panel_multicolor_defaults', $multicolor_defaults);
		$multicolor_defaults = array_map('sanitize_hex_color', $multicolor_defaults);
		return $multicolor_defaults;
	}
	
	
	/**
	 * Get Google Fonts
	 *
	 * @since 2.6.8
	 *
	 * @return array
	 */
	public static function _getGoogleFonts() {
		
		$g_fonts_array = array();
		$get_g_fonts = file_get_contents(dirname(__FILE__).'/google-fonts.json');
		if ($get_g_fonts !== false && !empty($get_g_fonts)) {
			$g_fonts_array = json_decode($get_g_fonts, true);
			foreach ((array)$g_fonts_array as $font => &$atts) {
				foreach ($atts['variants'] as $key => &$val) {
					foreach ($val as $k => &$v) {
						if (isset($v['url']))
							unset($v['url']);
					}
				}
			}
		}
		
		return apply_filters('dilaz_panel_get_google_fonts', $g_fonts_array);
	}
	
	
	/**
	 * Google Fonts
	 *
	 * @since 2.6.8
	 *
	 * @return array
	 */
	public static function _googleFonts() {
		
		$g_fonts = DilazPanelDefaults::_getGoogleFonts();
		$g_font_names = [];
		
		foreach ((array)$g_fonts as $font_name => &$atts) {
			$g_font_names[$font_name] = $font_name;
		}
		
		return apply_filters('dilaz_panel_google_fonts', $g_font_names);
	}
	
	
	/**
	 * Font defaults
	 *
	 * @since 1.0
	 *
	 * @return array
	 */
	public static function _font() {
		$font_defaults = array(
			'family' => 'verdana', 
			'subset' => '', 
			'size'   => 'normal', 
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
	
	
	/**
	 * Stacks for font family defaults 
	 *
	 * @since 2.7.12
	 *
	 * @return array
	 */
	public static function _font_family_defaults_stacks() {
		$font_family_stacks = array(
			'arial'           => 'Arial, Helvetica Neue, Helvetica, sans-serif',
			'calibri'         => 'Calibri, Candara, Segoe, Segoe UI, Optima, Arial, sans-serif',
			'consolas'        => 'Consolas, monaco, monospace',
			'courier-new'     => 'Courier New, Courier, Lucida Sans Typewriter, Lucida Typewriter, monospace',
			'georgia'         => 'Georgia, Times, Times New Roman, serif',
			'helvetica'       => 'Helvetica Neue, Helvetica, Arial, sans-serif',
			'lucida-grande'   => 'Lucida Grande, Lucida Sans Unicode, Lucida Sans, Geneva, Verdana, sans-serif',
			'palatino'        => 'Palatino, Palatino Linotype, Palatino LT STD, Book Antiqua, Georgia, serif',
			'tahoma'          => 'Tahoma, Verdana, Segoe, sans-serif',
			'times-new-roman' => 'TimesNewRoman, Times New Roman, Times, Baskerville, Georgia, serif',
			'trebuchet'       => 'Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif',
			'verdana'         => 'Verdana, Geneva, sans-serif;',
		);
		$font_family_stacks = apply_filters('dilaz_panel_font_family_defaults_stacks', $font_family_stacks);
		$font_family_stacks = array_map('sanitize_text_field', $font_family_stacks);
		return $font_family_stacks;
	}
	
	
	/**
	 * Font family defaults
	 *
	 * @since 1.0
	 *
	 * @return array
	 */
	public static function _font_family_defaults() {
		$font_family = array(
			''                => '',
			'arial'           => 'Arial',
			'calibri'         => 'Calibri',
			'consolas'        => 'Consolas',
			'courier-new'     => 'Courier New',
			'georgia'         => 'Georgia',
			'helvetica'       => 'Helvetica',
			'lucida-grande'   => 'Lucida Grande',
			'palatino'        => 'Palatino',
			'tahoma'          => 'Tahoma',
			'times-new-roman' => 'Times New Roman',
			'trebuchet'       => 'Trebuchet',
			'verdana'         => 'Verdana',
		);
		$font_family = apply_filters('dilaz_panel_font_family_defaults', $font_family);
		$font_family = array_map('sanitize_text_field', $font_family);
		return $font_family;
	}
	
	
	/**
	 * Font family all
	 *
	 * @since 1.0
	 *
	 * @return array
	 */
	public static function _font_family() {
		$font_family = wp_parse_args(DilazPanelDefaults::_googleFonts(), DilazPanelDefaults::_font_family_defaults());
		$font_family = apply_filters('dilaz_panel_font_family', $font_family);
		$font_family = array_map('sanitize_text_field', $font_family);
		return $font_family;
	}
	
	
	/**
	 * Font subset defaults
	 *
	 * @since 1.0
	 *
	 * @return array
	 */
	public static function _font_subset() {
		$font_subset = array(
			'arabic'       => 'arabic',
			'bengali'      => 'bengali',
			'cyrillic'     => 'cyrillic',
			'cyrillic-ext' => 'cyrillic-ext',
			'devanagari'   => 'devanagari',
			'greek'        => 'greek',
			'greek-ext'    => 'greek-ext',
			'gujarati'     => 'gujarati',
			'gurmukhi'     => 'gurmukhi',
			'hebrew'       => 'hebrew',
			'kannada'      => 'kannada',
			'khmer'        => 'khmer',
			'latin'        => 'latin',
			'latin-ext'    => 'latin-ext',
			'malayalam'    => 'malayalam',
			'myanmar'      => 'myanmar',
			'oriya'        => 'oriya',
			'sinhala'      => 'sinhala',
			'tamil'        => 'tamil',
			'telugu'       => 'telugu',
			'thai'         => 'thai',
			'vietnamese'   => 'vietnamese',
		);
		$font_subset = apply_filters('dilaz_panel_font_subset', $font_subset);
		$font_subset = array_map('sanitize_text_field', $font_subset);
		return $font_subset;
	}
	
	
	/**
	 * Font size defaults
	 *
	 * @since 1.0
	 *
	 * @return array
	 */
	public static function _font_sizes() {
		$font_sizes = range(6, 100);
		$font_sizes = apply_filters('dilaz_panel_font_sizes', $font_sizes);
		$font_sizes = array_map('absint', $font_sizes);
		return $font_sizes;
	}
	
	
	/**
	 * Font height defaults
	 *
	 * @since 1.0
	 *
	 * @return array
	 */
	public static function _font_heights() {
		$font_heights = range(10, 70);
		$font_heights = apply_filters('dilaz_panel_font_heights', $font_heights);
		$font_heights = array_map('absint', $font_heights);
		return $font_heights;
	}
	
	
	/**
	 * Font weight defaults
	 *
	 * @since 1.0
	 *
	 * @return array
	 */
	public static function _font_weights() {
		$font_weights = array(
			''        => '',
			'100'     => 'Thin 100',
			'200'     => 'ExtraLight 200',
			'300'     => 'Light 300',
			'400'     => 'Normal 400',
			'500'     => 'Medium 500',
			'600'     => 'SemiBold 600',
			'700'     => 'Bold 700',
			'800'     => 'ExtraBold 800',
			'900'     => 'UltraBold 900',
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
	
	
	/**
	 * Font style defaults
	 *
	 * @since 1.0
	 *
	 * @return array
	 */
	public static function _font_styles() {
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
	
	
	/**
	 * Font case defaults
	 *
	 * @since 1.0
	 *
	 * @return array
	 */
	 
	public static function _font_cases() {
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
