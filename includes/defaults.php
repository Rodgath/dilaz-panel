<?php 
/*
|| --------------------------------------------------------------------------------------------
|| Admin Panel Defaults
|| --------------------------------------------------------------------------------------------
||
|| @package		Dilaz Panel
|| @subpackage	Defaults
|| @since		Dilaz Panel 2.0
|| @author		WebDilaz Team, http://webdilaz.com
|| @copyright	Copyright (C) 2017, WebDilaz LTD
|| @link		http://webdilaz.com/panel
|| @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
|| 
*/

defined('ABSPATH') || exit;


class DilazPanelDefaults {
	
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
	 * Font family defaults
	 *
	 * @since 1.0
	 *
	 * @return array
	 */
	public static function _font_family() {
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
	
	
	/**
	 * Font subset defaults
	 *
	 * @since 1.0
	 *
	 * @return array
	 */
	public static function _font_subset() {
		$font_subset = array(
			''      => '',
			'latin' => 'Latin',
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