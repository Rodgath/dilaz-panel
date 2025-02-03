<?php 
/*
|| --------------------------------------------------------------------------------------------
|| Admin Panel Fields
|| --------------------------------------------------------------------------------------------
||
|| @package    Dilaz Panel
|| @subpackage Fields
|| @since      Dilaz Panel 1.0
|| @author     Rodgath, https://github.com/Rodgath
|| @copyright  Copyright (C) 2017, Rodgath LTD
|| @link       https://github.com/Rodgath/Dilaz-Panel
|| @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
|| 
*/

namespace DilazPanel\DilazPanelFields;

defined('ABSPATH') || exit;

use DilazPanel\DilazPanelDefaults;

if (!class_exists('DilazPanelFields')) {
	
	/**
	 * DilazPanelFields class
	 *
	 * @since 1.0
	 * @since 2.8.2 - changed to use 'echo' instead of 'return'
	 * 
	 */
	class DilazPanelFields
	{
		
		/**
		 * Heading
		 *
		 * @since  1.0
		 * @access public
		 *
		 * @param  array $field Field arguments
		 * @return html  $output
		 */
		public static function fieldHeading($field)
		{
			
			extract($field);
			
			$output = '';
			
			if ($counter >= 2) {
				$output .= '</div><!-- tab1 -->';
			}
			
			$target = sanitize_key($name);
			
			$output .= '<div class="dilaz-panel-field" id="'. esc_attr($target) .'" data-tab-content="'. esc_attr($target) .'">';
			$output .= '<h3>'. esc_html($name) .'</h3>';
			
			echo $output;
		}
		
		/**
		 * Subheading
		 *
		 * @since  1.0
		 * @access public
		 *
		 * @param  array $field Field arguments
		 * @return html  $output
		 */
		public static function fieldSubheading($field)
		{
			
			extract($field);
			
			$output = '';
			
			if ($counter >= 2) {
				$output .= '</div><!-- tab2 -->';
			}
			$output .= '<div class="dilaz-panel-field" id="'. esc_attr(sanitize_key($name)) .'">';
			$output .= '<h3>'. esc_html($name) .'</h3>';
			
			echo $output;
		}
		
		/**
		 * Info
		 *
		 * @since  1.0
		 * @access public
		 *
		 * @param  array $field Field arguments
		 * @return html  $output
		 */
		public static function fieldInfo($field)
		{
			
			extract($field);
			
			$output = '';
			
			$output .= '<div class="info">';
			$output .= $name != '' ? '<h4>'. wp_kses_post($name) .'</h4>' : '';
			$output .= $desc != '' ? '<p>'. wp_kses_post($desc) .'</p>' : '';
			$output .= '</div>';
			
			echo $output;
		}
		
		/**
		 * Text
		 *
		 * @since  1.0
		 * @access public
		 *
		 * @param  array $field Field arguments
		 * @return html  $output
		 */
		public static function fieldText($field)
		{
			
			extract($field);
			
			echo '<input type="text" id="'. esc_attr($id) .'" class="dilaz-panel-input dilaz-panel-text" name="'. esc_attr($id) .'" value="'. esc_attr($value) .'" />';
			
		}
		
		/**
		 * Multiple Text Input
		 *
		 * @since  2.3
		 * @access public
		 *
		 * @param  array $field Field arguments
		 * @return html  $output
		 */
		public static function fieldMultitext($field)
		{
			
			extract($field);
			
			$class = isset($class) ? sanitize_html_class($class) : '';
			
			$saved_texts = $value;
			
			$output = '';
			
			if (isset($options)) {
				foreach ($options as $key => $val) {
					
					$text_name    = isset($val['name']) ? $val['name'] : '';
					$default_text = isset($val['default']) ? $val['default'] : '';
					$saved_text   = isset($saved_texts[$key]) ? $saved_texts[$key] : $default_text;
					$inline       = isset($args['inline']) && $args['inline'] == TRUE ? 'inline' : '';
					
					if ($inline == '') {
						$cols = 'style="width:100%;display:block"'; # set width to 100% if fields are not inline
					} else {
						$cols = isset($args['cols']) ? 'style="width:'. (100/intval($args['cols'])) .'%"' : 'style="width:30%"';
					}
					
					$output .= '<div class="dilaz-panel-multi-text '. esc_attr($inline) .'" '. wp_kses_post($cols) .'>';
						$output .= '<div class="dilaz-panel-multi-text-wrap">';
							$output .= '<strong>'. wp_kses_post($text_name) .'</strong><br />';
							$output .= '<input class="dilaz-panel-text '. esc_attr($class) .'" type="text" name="'. esc_attr($id) .'['. esc_attr($key) .']" id="'. esc_attr($id) .'" value="'. esc_attr($saved_text) .'" />';
						$output .= '</div>';
					$output .= '</div>';
				}
			}
			
			echo $output;
		}
		
		/**
		 * Textarea
		 *
		 * @since  1.0
		 * @access public
		 *
		 * @param  array $field Field arguments
		 * @return html  $output
		 */
		public static function fieldTextarea($field)
		{
			
			extract($field);
			
			$cols = isset($args['cols']) && is_numeric($args['cols']) ? intval($args['cols']) : '50';
			$rows = isset($args['rows']) && is_numeric($args['rows']) ? intval($args['rows']) : '5';
			
			echo '<textarea id="'. esc_attr($id) .'" class="dilaz-panel-input dilaz-panel-textarea" name="'. esc_attr($id) .'" cols="'. esc_attr($cols) .'" rows="'. esc_attr($rows) .'">'. esc_textarea($value) .'</textarea>';
			
		}
		
		/**
		 * Code
		 *
		 * @since  2.8.2
		 * @access public
		 *
		 * @param  array $field Field arguments
		 * @return html  $output
		 */
		public static function fieldCode($field)
		{
			
			extract($field);
			
			$cols = isset($args['cols']) && is_numeric($args['cols']) ? intval($args['cols']) : '50';
			$rows = isset($args['rows']) && is_numeric($args['rows']) ? intval($args['rows']) : '5';
			
			echo '<pre><textarea id="'. esc_attr($id) .'" class="dilaz-panel-input dilaz-panel-code" name="'. esc_attr($id) .'" cols="'. esc_attr($cols) .'" rows="'. esc_attr($rows) .'">'. esc_textarea($value) .'</textarea></pre>';
			
		}
		
		/**
		 * Password
		 *
		 * @since  2.6.5
		 * @access public
		 *
		 * @param  array $field Field arguments
		 * @return html  $output
		 */
		public static function fieldPassword($field)
		{
			
			extract($field);
			
			echo '<input type="password" id="'. esc_attr($id) .'" class="dilaz-panel-input dilaz-panel-password" name="'. esc_attr($id) .'" value="'. esc_attr($value) .'" size="46" />';
			
		}
		
		/**
		 * Email
		 *
		 * @since  1.0
		 * @access public
		 *
		 * @param  array $field Field arguments
		 * @return html  $output
		 */
		public static function fieldEmail($field)
		{
			
			extract($field);
			
			echo '<input type="text" id="'. esc_attr($id) .'" class="dilaz-panel-input dilaz-panel-email" name="'. esc_attr($id) .'" value="'. esc_attr($value) .'" />';
			
		}
		
		/**
		 * Select
		 *
		 * @since  1.0
		 * @access public
		 *
		 * @param  array $field Field arguments
		 * @return html  $output
		 */
		public static function fieldSelect($field)
		{
			
			extract($field);
			
			$output = '';
			
			$select2_class = isset($args['select2']) ? $args['select2'] : '';
			$select2_width = isset($args['select2width']) ? sanitize_text_field($args['select2width']) : '100px';
			
			$output .= '<select id="'. esc_attr($id) .'" class="dilaz-panel-input dilaz-panel-select '. esc_attr($select2_class) .'" name="'. esc_attr($id) .'" data-width="'. esc_attr($select2_width) .'">';
				foreach ($options as $key => $option) {
					$selected = (($value != '') && ($value == $key)) ? 'selected="selected"' : '';
					$output .= '<option '. wp_kses_post($selected) .' value="'. esc_attr($key) .'">'. esc_html($option) .'</option>';
				}
			$output .= '</select>';
			
			echo $output;
		}
		
		/**
		 * Repeatable
		 *
		 * @since  2.6.4
		 * @access public
		 *
		 * @param  array $field Field arguments
		 * @return html  $output
		 */
		public static function fieldRepeatable($field)
		{
			
			extract($field);
			
			$sortable = isset($args['sortable']) ? wp_validate_boolean($args['sortable']) : TRUE;
			$sorter = $sortable ? '<span class="sort-repeatable"><i class="dashicons dashicons-move"></i></span>' : '';
			$not_sortable = isset($args['not_sortable']) ? intval($args['not_sortable']) : 0;
			$removable = isset($args['removable']) ? wp_validate_boolean($args['removable']) : TRUE;
			$remover = $removable ? '<span class="repeatable-remove button"><i class="dashicons dashicons-no-alt"></i></span>' : '';
			$not_removable = isset($args['not_removable']) ? intval($args['not_removable']) : 0;
			$add_more = isset($args['add_more']) ? wp_validate_boolean($args['add_more']) : TRUE;
			$add_text = isset($args['add_text']) ? sanitize_text_field($args['add_text']) : __('Add New', 'dilaz-panel');
			$class = isset($class) ? sanitize_html_class($class) : '';
			$inline = isset($args['inline']) && $args['inline'] == TRUE ? 'inline' : '';
			
			$output = '';
			$output .= '<ul id="'. esc_attr($id) .'" class="dilaz-panel-repeatable '. esc_attr($class) .'" data-ns="'. esc_attr($not_sortable) .'" data-s="'. esc_attr($sortable) .'" data-nr="'. esc_attr($not_removable) .'" data-r="'. esc_attr($removable) .'">';
				$i = 0;	
				$i = 0;	
				if ($value != '') {
					foreach($value as $key => $val) {
						$output .= '<li class="dilaz-panel-repeatable-item">'. ($not_sortable > $i ? '' : $sorter);
							if (is_array($val)) {
								foreach($val as $k => $v) {
									$label = isset($options[0][$k]['label']) ? $options[0][$k]['label'] : '';
									$field_size = isset($options[0][$k]['size']) ? intval($options[0][$k]['size']) : 30;
									$output .= '<div class="dilaz-panel-repeatable-item-wrap inline">';
									if ($label != '') {
										$output .= '<label for="'. esc_attr($id) .'"><strong>'. wp_kses_post($label) .'</strong></label>';
									}
									$output .= '<input type="text" class="'. esc_attr($k) . esc_attr($i) .'" name="'. esc_attr($id) .'['. esc_attr($i) .'][]" value="'. esc_attr($v) .'" size="'. esc_attr($field_size) .'" />
									</div>';
								}
							} else {
								$output .= '<input type="text" name="'. esc_attr($id) .'['. esc_attr($i) .']" value="'. esc_attr($val) .'" size="30" />';
							}
						$output .= ($not_removable > $i || $i < 1 ? '' : $remover).'</li>';
						$i++;
					}
				} else {
					foreach ((array)$options as $option_key => $option_value) {
						$output .= '<li class="dilaz-panel-repeatable-item">'. ($not_sortable > $i ? '' : $sorter);
							if (is_array($option_value)) {
								foreach($option_value as $k => $v) {
									
									$label = isset($v['label']) ? $v['label'] : '';
									$field_size = isset($options[0][$k]['size']) ? intval($options[0][$k]['size']) : 30;
									
									$output .= '<div class="dilaz-panel-repeatable-item-wrap inline">';
									if ($label != '') {
										$output .= '<label for="'. esc_attr($id) .'"><strong>'. esc_attr($v['label']) .'</strong></label>';
									}
									$output .= '<input type="text" class="'. esc_attr($k) . esc_attr($i) .'" name="'. esc_attr($id) .'['. esc_attr($i) .'][]" value="'. esc_attr($v['value']) .'" size="'. esc_attr($field_size) .'" />
									</div>';
								}
							} else {
								$output .= '<input type="text" name="'. esc_attr($id) .'['. esc_attr($i) .']" value="'. esc_attr($option_value) .'" size="30" />';
							}
						$output .= ($not_removable > $i || $i < 1 ? '' : $remover).'</li>';
						$i++;
					}
				}
			$output .= '</ul>';
			if ($add_more) {
				$output .= '<span class="dilaz-panel-add-repeatable-item button">'. wp_kses_post($add_text) .'</span>';
			}
			
			echo $output;
		}
		
		/**
		 * Multiselect
		 *
		 * @since  1.0
		 * @access public
		 *
		 * @param  array $field Field arguments
		 * @return html  $output
		 */
		public static function fieldMultiselect($field)
		{
			
			extract($field);
			
			$output = '';
			
			$select2_class = isset($args['select2']) ? $args['select2'] : '';
			$select2_width = isset($args['select2width']) ? 'data-width="'. sanitize_text_field($args['select2width']) .'"' : 'data-width="100px"';
			
			$output .= '<select id="'. esc_attr($id) .'" class="dilaz-panel-input dilaz-panel-select '. esc_attr($select2_class) .'" multiple="multiple" name="'. esc_attr($id) .'[]" '. wp_kses_post($select2_width) .'>';
				$selected_data = (isset($option_data[$id]) && is_array($option_data[$id])) ? $option_data[$id] : array();
				foreach ($options as $key => $option) {
					$selected = (in_array($key, $selected_data)) ? 'selected="selected"' : '';
					$output .= '<option '. wp_kses_post($selected) .' value="'. esc_attr($key) .'">'. esc_html($option) .'</option>';
				}
			$output .= '</select>';
			
			echo $output;
		}
		
		/**
		 * Query select - 'post', 'term', 'user'
		 *
		 * @since  1.0
		 * @access public
		 *
		 * @param  array $field Field arguments
		 * @return html  $output
		 */
		public static function fieldQueryselect($field)
		{
			
			extract($field);
			
			$output = '';
			
			$query_type    = isset($args['query_type']) ? sanitize_text_field($args['query_type']) : '';
			$query_args    = isset($args['query_args']) ? (array)$args['query_args'] : array();
			$placeholder   = isset($args['placeholder']) ? sanitize_text_field($args['placeholder']) : __('Select a post', 'dilaz-panel');
			$min_input     = isset($args['min_input']) ? intval($args['min_input']) : 3;
			$max_input     = isset($args['max_input']) ? intval($args['max_input']) : 0;
			$max_options   = isset($args['max_options']) ? intval($args['max_options']) : 0;
			$select2_width = isset($args['select2width']) ? sanitize_text_field($args['select2width']) : '100px';
			$select2       = isset($args['select2']) ? sanitize_html_class($args['select2']) : '';
			$multiple_attr = $select2 == 'select2multiple' ? 'multiple="multiple"' : '';
			$multiple_bool = $select2 == 'select2multiple' ? 'true' : 'false';
			
			// if (wp_script_is('select2script', 'enqueued')) {
				// wp_localize_script('select2script', 'dilaz_panel_post_select_lang', array(
					// 'dilaz_panel_pref' => $query_args,
				// ));
			// }
			
			$output .= '<select style="" name="'. esc_attr($id) .'[]" id="'. esc_attr($id) .'" '. wp_kses_post($multiple_attr) .' class="dilaz-panel-query-select" 
			data-placeholder="'. esc_attr($placeholder) .'" 
			data-min-input="'. esc_attr($min_input) .'" 
			data-max-input="'. esc_attr($max_input) .'" 
			data-max-options="'. esc_attr($max_options) .'" 
			data-query-args="'. esc_attr(base64_encode(serialize($query_args))) .'" 
			data-query-type="'. esc_attr($query_type) .'" 
			data-multiple="'. esc_attr($multiple_bool) .'" 
			data-width="'. esc_attr($select2_width) .'">';
			
			$selected_data = (isset($option_data[$id]) && is_array($option_data[$id])) ? $option_data[$id] : array();
			
			if (is_array($selected_data)) {
				foreach ($selected_data as $key => $item_id) {
					
					if ($query_type == 'post' || $query_type == 'page') {
						$name = get_post_field('post_title', $item_id);
					} else if ($query_type == 'user') {
						$user_data = get_userdata($item_id);
						$name = ($user_data && !is_wp_error($user_data)) ? $user_data->nickname : '';
					} else if ($query_type == 'term') {
						$term_data = get_term($item_id);
						$name = ($term_data && !is_wp_error($term_data)) ? $term_data->name : '';
					} else {
						$name = 'Add query type';
					}
					
					$output .= '<option selected="selected" value="'. esc_attr($item_id) .'">'. esc_html($name) .'</option>';
				}
			}
			
			$output .= '</select>';
			
			echo $output;
		}
		
		/**
		 * Radio
		 *
		 * @since  1.0
		 * @access public
		 *
		 * @param  array $field Field arguments
		 * @return html  $output
		 */
		public static function fieldRadio($field)
		{
			
			extract($field);
			
			$class  = isset($args['class']) ? sanitize_html_class($args['class']) : '';
			$inline = isset($args['inline']) && $args['inline'] == TRUE ? 'inline' : '';
			
			if ($inline == '') {
				$cols = 'width:100%;display:block;'; # set width to 100% if fields are not inline
			} else {
				$cols = isset($args['cols']) ? 'width:'. ceil(100/intval($args['cols'])) .'%;' : 'width:30%;';
			}
			
			$output = '';
			
			foreach ($options as $key => $option) {
				$state = checked($value, $key, FALSE) ? 'focus' : '';
				$output .= '<label for="'. esc_attr($id .'-'. $key) .'" class="dilaz-option '. esc_attr($inline) .'"  style="'. esc_attr($cols) .'"><input type="radio" class="dilaz-panel-input dilaz-panel-radio '. esc_attr($state) .'" name="'. esc_attr($id) .'" id="'. esc_attr($id .'-'. $key) .'" value="'. esc_attr($key) .'" '. checked($value, $key, FALSE) .' /><span class="radio"></span><span>'. esc_html($option) .'</span></label>';
			}
			
			echo $output;
		}
		
		/**
		 * Radio Image
		 *
		 * @since  1.0
		 * @access public
		 *
		 * @param  array $field Field arguments
		 * @return html  $output
		 */
		public static function fieldRadioimage($field)
		{
			
			extract($field);
			
			$output = '';
			$is_tiled_bg = isset($args['tiled_bg']) && $args['tiled_bg'] == TRUE ? TRUE : FALSE;
			
			$value = isset($value) ? $value : '';
			foreach ($options as $key => $option) {
				$option_src = is_array($option) && isset($option['src']) ? $option['src'] : $option;
				$option_alt = is_array($option) && isset($option['alt']) ? $option['alt'] : '';
				$checked  = '';
				$selected = '';
				if (null != checked($value, $key, FALSE)) {
					$checked  = checked($value, $key, FALSE);
					$selected = 'selected';  
				}
				$output .= '<label for="'. esc_attr($id .'-'. $key) .'"><input type="radio" id="'. esc_attr($id .'-'. $key) .'" class="dilaz-panel-input dilaz-panel-radio-image" name="'. esc_attr($id) .'" value="'. esc_attr($key) .'" '. $checked .' />';
				if ($is_tiled_bg) {
					$output .= '<div class="tiled-tooltip dilaz-panel-radio-image-img '. esc_attr($selected) .'" title="'. esc_attr($option_alt) .'" style="background-image: url('. esc_attr($option_src) .')"><span style="background-image: url('. esc_attr($option_src) .')"></span></div>';
				} else {
					$output .= '<img src="'. esc_attr($option_src) .'" title="'. esc_attr($option_alt) .'" alt="'. esc_attr($option_alt) .'" class="dilaz-panel-radio-image-img '. esc_attr($selected) .'" />';
				}
				$output .= '</label>';
			}
			
			echo $output;
		}
		
		/**
		 * Buttonset
		 *
		 * @since  1.0
		 * @access public
		 *
		 * @param  array $field Field arguments
		 * @return html  $output
		 */
		public static function fieldButtonset($field)
		{
			
			extract($field);
			
			$output = '';
			
			$value = isset($value) ? $value : '';
			foreach ($options as $key => $option) {
				$checked  = '';
				$selected = '';
				if (null != checked($value, $key, FALSE)) {
					$checked  = checked($value, $key, FALSE);
					$selected = 'selected';  
				}
				$output .= '<label for="'. esc_attr($id .'-'. $key) .'" class="dilaz-panel-button-set-button '. esc_attr($selected) .'"><input type="radio" class="dilaz-panel-input dilaz-panel-button-set" name="'. esc_attr($id) .'" id="'. esc_attr($id .'-'. $key) .'" value="'. esc_attr($key) .'" '. wp_kses_post($checked) .' /><span>'. esc_html($option) .'</span></label>';
			}
			
			echo $output;
		}
		
		/**
		 * Switch
		 *
		 * @since  1.0
		 * @access public
		 *
		 * @param  array $field Field arguments
		 * @return html  $output
		 */
		public static function fieldSwitch($field)
		{
			
			extract($field);
			
			$output = '';
			
			$value = isset($value) ? $value : '';
			$i = 0;
			foreach ($options as $key => $option) {
				$i++;
				$checked  = '';
				$selected = '';
				if (null != checked($value, $key, FALSE)) {
					$checked  = checked($value, $key, FALSE);
					$selected = 'selected';  
				}
				$state = ($i == 1) ? 'switch-on' : 'switch-off';
				$output .= '<label for="'. esc_attr($id .'-'. $key) .'" class="dilaz-panel-switch-button '. esc_attr($selected) .' '. esc_attr($state) .'"><input type="radio" class="dilaz-panel-input dilaz-panel-switch" name="'. esc_attr($id) .'" id="'. esc_attr($id .'-'. $key) .'" value="'. esc_attr($key) .'" '. wp_kses_post($checked) .' /><span>'. esc_html($option) .'</span></label>';
			}
			
			echo $output;
		}
		
		/**
		 * Checkbox
		 *
		 * @since  1.0
		 * @access public
		 *
		 * @param  array $field Field arguments
		 * @return html  $output
		 */
		public static function fieldCheckbox($field)
		{
			
			extract($field);
			
			$output = '';
			
			$state = checked($value, TRUE, FALSE) ? 'focus' : '';
			$output .= '<label for="'. esc_attr($id) .'" class="dilaz-option"><input id="'. esc_attr($id) .'" class="dilaz-panel-input dilaz-panel-checkbox '. esc_attr($state) .'" type="checkbox" name="'. esc_attr($id) .'" '. checked($value, TRUE, FALSE) .' /><span class="checkbox"></span><span>'. wp_kses_post($desc) .'</span></label><div class="clear"></div>';
			
			echo $output;
		}
		
		/**
		 * Multicheck
		 *
		 * @since  1.0
		 * @access public
		 *
		 * @param  array $field Field arguments
		 * @return html  $output
		 */
		public static function fieldMulticheck($field)
		{
			
			extract($field);
			
			$class  = isset($args['class']) ? sanitize_html_class($args['class']) : '';
			$std    = isset($std) && is_array($std) ? array_map('sanitize_text_field', $std) : array();
			$inline = isset($args['inline']) && $args['inline'] == TRUE ? 'inline' : '';
			
			if ($inline == '') {
				$cols = 'width:100%;display:block;'; # set width to 100% if fields are not inline
			} else {
				$cols = isset($args['cols']) ? 'width:'. ceil(100/intval($args['cols'])) .'%;' : 'width:30%;';
			}
			
			$output = '';
			
			foreach ($options as $key => $option) {
				
				$key = sanitize_key($key);
				
				$checked = isset($value[$key]) ? checked($value[$key], TRUE, FALSE) : '';
				
				$state = $checked ? 'focus' : '';
				$output .= '<label for="'. esc_attr($id.'-'.$key) .'" class="dilaz-option '. esc_attr($inline) .'" style="'. esc_attr($cols) .'"><input type="checkbox" id="'. esc_attr($id.'-'.$key) .'" class="dilaz-panel-input dilaz-panel-checkbox '. esc_attr($state) .' '. esc_attr($class) .'" name="'. esc_attr($id .'['. $key .']') .'" '. wp_kses_post($checked) .' /><span class="checkbox"></span><span>'. esc_html($option) .'</span></label>';
			}
			
			echo $output;
		}
		
		/**
		 * Slidebar
		 *
		 * @since  1.0
		 * @access public
		 *
		 * @param  array $field Field arguments
		 * @return html  $output
		 */
		public static function fieldSlider($field)
		{
			
			extract($field);
			
			$output = '';
			
			$value  = $value != '' ? (int)$value : '0';
			$min    = isset($args['min']) ? (int)$args['min'] : '';
			$max    = isset($args['max']) ? (int)$args['max'] : '';
			$step   = isset($args['step']) ? (int)$args['step'] : '';
			$suffix = isset($args['suffix']) ? sanitize_text_field($args['suffix']) : '';
			$output .= '<input type="hidden" id="'. esc_attr($id) .'" name="'. esc_attr($id) .'" value="'. esc_attr($value) .'" />';
			$output .= '<div class="dilaz-panel-slider" data-val="'. esc_attr($value) .'" data-min="'. esc_attr($min) .'" data-max="'. esc_attr($max) .'" data-step="'. esc_attr($step) .'"></div>';
			$output .= '<div class="dilaz-panel-slider-val"><span>'. esc_attr($value) .'</span>'. wp_kses_post($suffix) .'</div>';
			
			echo $output;
		}
		
		/**
		 * Range
		 *
		 * @since  1.0
		 * @access public
		 *
		 * @param  array $field Field arguments
		 * @return html  $output
		 */
		public static function fieldRange($field)
		{
			
			extract($field);
			
			$output = '';
			
			$minStd  = isset($std['min_std']) ? (int)$std['min_std'] : 0;
			$maxStd  = isset($std['max_std']) ? (int)$std['max_std'] : 0;
			$value   = $value != '' ? (array)$value : '0';
			$min_val = is_array($value) && isset($value['min']) ? (int)$value['min'] : $minStd;
			$max_val = is_array($value) && isset($value['max']) ? (int)$value['max'] : $maxStd;
			$min     = isset($args['min'][0]) ? (int)$args['min'][0] : 0;
			$max     = isset($args['max'][0]) ? (int)$args['max'][0] : 0;
			$minName = isset($args['min'][1]) ? (string)$args['min'][1] : '';
			$maxName = isset($args['max'][1]) ? (string)$args['max'][1] : '';
			$step    = isset($args['step']) ? (int)$args['step'] : '';
			$prefix  = isset($args['prefix']) && $args['prefix'] != '' ? sanitize_text_field($args['prefix']) : '';
			$suffix  = isset($args['suffix']) && $args['suffix'] != '' ? sanitize_text_field($args['suffix']) : '';
			
			$output .= '<div class="dilaz-panel-range" data-min-val="'. esc_attr($min_val) .'" data-max-val="'. esc_attr($max_val) .'" data-min="'. esc_attr($min) .'" data-max="'. esc_attr($max) .'" data-step="'. esc_attr($step) .'">';
				$output .= '<div class="dilaz-panel-slider-range"></div>';
				$output .= '<input type="hidden" class="" name="'. esc_attr($id) .'[min]" id="option-min" value="'. esc_attr($min_val) .'" placeholder="" size="7">';
				$output .= '<div class="dilaz-panel-min-val"><span class="min">'. wp_kses_post($minName) .'</span>'. wp_kses_post($prefix) .'<span class="val">'. esc_attr($min_val) .'</span>'. wp_kses_post($suffix) .'</div>';
				$output .= '<input type="hidden" class="" name="'. esc_attr($id) .'[max]" id="option-max" value="'. esc_attr($max_val) .'" placeholder="" size="7">';
				$output .= '<div class="dilaz-panel-max-val"><span class="max">'. wp_kses_post($maxName) .'</span>'. wp_kses_post($prefix) .'<span class="val">'. esc_attr($max_val) .'</span>'. wp_kses_post($suffix) .'</div>';
			$output .= '</div>';
			
			echo $output;
		}
		
		/**
		 * Color Picker
		 *
		 * @since  1.0
		 * @access public
		 *
		 * @param  array $field Field arguments
		 * @return html  $output
		 */
		public static function fieldColor($field)
		{
			
			extract($field);
			
			$output = '';
			
			$default_color = isset($std) ? $std : '';
			$output .= '<input name="'. esc_attr($id) .'" id="'. esc_attr($id) .'" class="dilaz-panel-color"  type="text" value="'.  esc_attr($value) .'" data-default-color="'. esc_attr($default_color) .'" />';
			
			echo $output;
		}
		
		/**
		 * Multiple Colors
		 *
		 * @since  1.0
		 * @access public
		 *
		 * @param  array $field Field arguments
		 * @return html  $output
		 */
		public static function fieldMulticolor($field)
		{
			
			extract($field);
			
			$output = '';
			
			$multicolor_defaults = DilazPanelDefaults\DilazPanelDefaults::multicolor();
			$saved_colors = wp_parse_args($value, $multicolor_defaults);
			
			if (isset($options)) {
				foreach ($options as $key => $val) {
					
					$color_name    = isset($val['name']) ? $val['name'] : '';
					$default_color = isset($val['color']) ? $val['color'] : '';
					$saved_color   = isset($saved_colors[$key]) ? $saved_colors[$key] : $default_color;
					
					$output .= '<div class="dilaz-panel-multi-color">';
					$output .= '<strong>'. $color_name .'</strong><br />';
					$default_active = isset($std['active']) ? $std['active'] : '';
					$output .= '<input class="dilaz-panel-color '. (isset($class) ? esc_attr($class) : '') .'" type="text" name="'.  esc_attr($id) .'['. esc_attr($key) .']" id="'.  esc_attr($id) .'" value="'. $saved_color .'" data-default-color="'.esc_attr($default_color) .'" />';
					$output .= '</div>';
				}
			}
			
			echo $output;
		}
		
		/**
		 * Font
		 *
		 * @since  1.0
		 * @access public
		 *
		 * @param  array $field Field arguments
		 * @return html  $output
		 */
		public static function fieldFont($field)
		{
			
			extract($field);
			
			$output = '';
			
			$font_defaults = DilazPanelDefaults\DilazPanelDefaults::font();
			$saved_fonts   = wp_parse_args($value, $font_defaults);
			
			$fontUnit = isset($args['unit']) ? (string)$args['unit'] : 'px';
			$std      = isset($std) && is_array($std) ? array_map('sanitize_text_field', $std) : array();
			
			/* font family */
			if (isset($options['family']) && $options['family'] !== FALSE) {
				$output .= '<div class="dilaz-panel-font">';
					$output .= '<strong>'. __('Font Family', 'dilaz-panel') .'</strong><br />';
					$output .= '<select id="'. esc_attr($id) .'-family" name="'. esc_attr($id) .'[family]" class="family select2single" data-width="230px">';
					$font_families = is_array($options['family']) ? $options['family'] : DilazPanelDefaults\DilazPanelDefaults::fontFamily();						
					foreach ($font_families as $key => $font_family) {
						if (isset($saved_fonts['family']) && !empty($saved_fonts['family']) && $saved_fonts['family'] !== FALSE) {
							$selected_family = selected(strtolower($saved_fonts['family']), strtolower($key), FALSE);
						} else {
							$selected_family = isset($std['family']) && stripos($key, $std['family']) !== FALSE ? selected(strtolower($std['family']), strtolower($key), FALSE) : '';
						}
						$output .= '<option value="'. esc_attr($key) .'" '. wp_kses_post($selected_family) .'>'. wp_kses_post($font_family) .'</option>';
					}
					$output .= '</select>';
				$output .= '</div>';
			}
			
			/* font weight */
			if (isset($options['weight']) && $options['weight'] !== FALSE) {
				$output .= '<div class="dilaz-panel-font">';
					$output .= '<strong>'. __('Font Weight', 'dilaz-panel') .'</strong><br />';
					$output .= '<select id="'. esc_attr($id) .'-weight" name="'. esc_attr($id) .'[weight]" class="weight select2single" data-width="130px">';
					$font_weights = is_array($options['weight']) ? $options['weight'] : DilazPanelDefaults\DilazPanelDefaults::fontWeights();
					foreach ($font_weights as $key => $font_weight) {
						if (isset($saved_fonts['weight']) && !empty($saved_fonts['weight']) && $saved_fonts['weight'] !== FALSE) {
							$selected_weight = selected(strtolower($saved_fonts['weight']), strtolower($key), FALSE);
						} else {
							$selected_weight = isset($std['weight']) && stripos($key, $std['weight']) !== FALSE ? selected(strtolower($std['weight']), strtolower($key), FALSE) : '';
						}
						$output .= '<option value="'. esc_attr($key) .'" '. wp_kses_post($selected_weight) .'>'. wp_kses_post($font_weight) .'</option>';
					}
					$output .= '</select>';
				$output .= '</div>';
			}
			
			/* font style */
			if (isset($options['style']) && $options['style'] !== FALSE) {
				$output .= '<div class="dilaz-panel-font">';
					$output .= '<strong>'. __('Font Style', 'dilaz-panel') .'</strong><br />';
					$output .= '<select id="'. esc_attr($id) .'-style" name="'. esc_attr($id) .'[style]" class="style select2single" data-width="110px">';
					$font_styles = is_array($options['style']) ? $options['style'] : DilazPanelDefaults\DilazPanelDefaults::fontStyles();
					foreach ($font_styles as $key => $font_style) {
						if (isset($saved_fonts['style']) && !empty($saved_fonts['style']) && $saved_fonts['style'] !== FALSE) {
							$selected_style = selected(strtolower($saved_fonts['style']), strtolower($key), FALSE);
						} else {
							$selected_style = isset($std['style']) && stripos($key, $std['style']) !== FALSE ? selected(strtolower($std['style']), strtolower($key), FALSE) : '';
						}
						$output .= '<option value="'. esc_attr($key) .'" '. wp_kses_post($selected_style) .'>'. wp_kses_post($font_style) .'</option>';
					}
					$output .= '</select>';
				$output .= '</div>';
			}
			
			/* font case - text transform */
			if (isset($options['case']) && $options['case'] !== FALSE) {
				$output .= '<div class="dilaz-panel-font">';
					$output .= '<strong>'. __('Font Case', 'dilaz-panel') .'</strong><br />';
					$output .= '<select id="'. esc_attr($id) .'-case" name="'. esc_attr($id) .'[case]" class="case select2single" data-width="110px">';
					$font_cases = is_array($options['case']) ? $options['case'] : DilazPanelDefaults\DilazPanelDefaults::fontCases();
					foreach ($font_cases as $key => $font_case) {
						if (isset($saved_fonts['case']) && !empty($saved_fonts['case']) && $saved_fonts['case'] !== FALSE) {
							$selected_case = selected(strtolower($saved_fonts['case']), strtolower($key), FALSE);
						} else {
							$selected_case = isset($std['case']) && stripos($key, $std['case']) !== FALSE ? selected(strtolower($std['case']), strtolower($key), FALSE) : '';
						}
						$output .= '<option value="'. esc_attr($key) .'" '. wp_kses_post($selected_case) .'>'. wp_kses_post($font_case) .'</option>';
					}
					$output .= '</select>';
				$output .= '</div>';
			}
			
			/* font stack backup */
			if (isset($options['backup']) && $options['backup'] !== FALSE) {
				$output .= '<div class="dilaz-panel-font">';
					$output .= '<strong>'. __('Font Backup Stack', 'dilaz-panel') .'</strong><br />';
					$output .= '<select id="'. esc_attr($id) .'-backup" name="'. esc_attr($id) .'[backup]" class="backup select2single" data-width="230px">';
					$font_backups = is_array($options['backup']) ? $options['backup'] : DilazPanelDefaults\DilazPanelDefaults::fontFamilyDefaultsStacks();						
					foreach ($font_backups as $key => $font_backup) {
						if (isset($saved_fonts['backup']) && !empty($saved_fonts['backup']) && $saved_fonts['backup'] !== FALSE) {
							$selected_backup = selected($saved_fonts['backup'], $key, FALSE);
						} else {
							$selected_backup = isset($std['backup']) && stripos($key, $std['backup']) !== FALSE ? selected($std['backup'], $key, FALSE) : '';
						}
						$output .= '<option value="'. esc_attr($key) .'" '. wp_kses_post($selected_backup) .'>'. wp_kses_post($font_backup) .'</option>';
					}
					$output .= '</select>';
				$output .= '</div>';
			}
			
			/* font size */
			if (isset($options['size']) && $options['size'] !== FALSE) {
				$output .= '<div class="dilaz-panel-font">';
					$output .= '<strong>'. __('Font Size', 'dilaz-panel') .'</strong><br />';
					$output .= '<div id="'. esc_attr($id) .'-size">';
						if (isset($saved_fonts['size']) && $saved_fonts['size'] > 0) {
							$font_size = intval($saved_fonts['size']);
						} else if (isset($std['size']) && $std['size'] > 0) {
							$font_size = intval($std['size']);
						} else if (isset($font_defaults['size']) && $font_defaults['size'] > 0) {
							$font_size = intval($font_defaults['size']);
						} else {
							$font_size = 14;
						}
						$output .= '<input type="text" class="f-size '. esc_attr($id) .'-size" name="'. esc_attr($id) .'[size]" value="'. esc_attr($font_size) .'" size="3" />';
						$output .= '<span class="unit">'. wp_kses_post($fontUnit) .'</span>';
					$output .= '</div>';
				$output .= '</div>';
			}
			
			/* line height */
			if (isset($options['height']) && $options['height'] !== FALSE) {
				$output .= '<div class="dilaz-panel-font">';
					$output .= '<strong>'. __('Line Height', 'dilaz-panel') .'</strong><br />';
					$output .= '<div id="'. esc_attr($id) .'-height">';
						if (isset($saved_fonts['height']) && $saved_fonts['height'] > 0 && $saved_fonts['height'] !== FALSE) {
							$font_height = intval($saved_fonts['height']);
						} else if (isset($std['height']) && $std['height'] > 0) {
							$font_height = intval($std['height']);
						} else if (isset($font_defaults['height']) && $font_defaults['height'] > 0) {
							$font_height = intval($font_defaults['height']);
						} else {
							$font_height = 16;
						}
						$output .= '<input type="text" class="f-height '. esc_attr($id) .'-height" name="'. esc_attr($id) .'[height]" value="'. esc_attr($font_height) .'" size="3" />';
						$output .= '<span class="unit">'. wp_kses_post($fontUnit) .'</span>';
					$output .= '</div>';
				$output .= '</div>';
			}
			
			/* font color */
			if (isset($options['color']) && $options['color'] !== FALSE) {
				$output .= '<div class="dilaz-panel-font">';
					$output .= '<strong>'. __('Color', 'dilaz-panel') .'</strong><br />';
					if (isset($saved_fonts['color']) && $saved_fonts['color'] != '' && $saved_fonts['color'] !== FALSE) {
						$font_color = sanitize_hex_color($saved_fonts['color']);
					} else if (isset($std['color']) && $std['color'] != '') {
						$font_color = sanitize_hex_color($std['color']);
					} else if (isset($font_defaults['color']) && $font_defaults['color'] > 0) {
						$font_color = sanitize_hex_color($font_defaults['color']);
					} else {
						$font_color = '#333';
					}
					$output .= '<input id="'. esc_attr($id) .'-color" name='. esc_attr($id) .'[color]" class="dilaz-panel-color color" type="text" value="'. wp_kses_post($font_color) .'" data-default-color="'. esc_attr($font_color) .'" />';
				$output .= '</div>';
			}
			
			/* font subset */
			if (isset($options['subset']) && $options['subset'] !== FALSE) {
				$output .= '<div class="dilaz-panel-font">';
					$output .= '<strong>'. __('Font Subset', 'dilaz-panel') .'</strong><br />';
					$output .= '<select id="'. esc_attr($id) .'-subset" name="'. esc_attr($id) .'[subset][]" class="subset select2multiple" data-width="320px" multiple="multiple">';
					$font_subsets = is_array($options['subset']) ? $options['subset'] : DilazPanelDefaults\DilazPanelDefaults::fontSubset();						
					foreach ($font_subsets as $key => $font_subset) {
						$selected_subset = is_array($saved_fonts['subset']) ? (isset($std['subset']) && in_array($key, $saved_fonts['subset']) ? 'selected="selected"' : '') : '';
						$output .= '<option value="'. esc_attr($key) .'" '. wp_kses_post($selected_subset) .'>'. wp_kses_post($font_subset) .'</option>';
					}
					$output .= '</select>';
				$output .= '</div>';
			}
			
			$output .= '<div class="dilaz-panel-font font-preview" style="display:none">';
				$output .= '<div class="content">1 2 3 4 5 6 7 8 9 0 A B C D E F G H I J K L M N O P Q R S T U V W X Y Z a b c d e f g h i j k l m n o p q r s t u v w x y z</div>';
			$output .= '</div>';
			
			echo $output;
		}
		
		/**
		 * File Upload
		 *
		 * @since  1.0
		 * @access public
		 *
		 * @param  array $field Field arguments
		 * @return html  $output
		 */
		public static function fieldUpload($field)
		{

			extract($field);
			
			$output = '';
			
			$show_thumb         = isset($args['show_thumb']) && $args['show_thumb'] == FALSE ? 'false' : 'true';
			$data_file_thumb    = 'data-file-thumb="'. $show_thumb .'"';
			$is_file_multiple   = isset($args['multiple']) && $args['multiple'] == TRUE ? TRUE : FALSE;
			$data_file_multiple = $is_file_multiple ? 'data-file-multiple="true"' : '';
			$file_type          = (isset($args['file_type']) && $args['file_type'] != '') ? strtolower($args['file_type']) : 'image';
			$data_file_type     = $file_type != '' ? 'data-file-type="'. $file_type .'"' : 'data-file-type="image"';
			$data_file_specific = (isset($args['file_specific']) && $args['file_specific'] == TRUE) ? 'data-file-specific="true"' : '';
			$frame_title        = (isset($args['frame_title']) && $args['frame_title'] != '') ? sanitize_text_field($args['frame_title']) : '';
			$frame_button_text  = (isset($args['frame_button_text']) && $args['frame_button_text'] != '') ? sanitize_text_field($args['frame_button_text']) : '';
			
			switch ($file_type) {
				
				case ('image') :
					$data_frame_title = ($frame_title != '') ? 'data-frame-title="'. esc_attr($frame_title) .'"' : 'data-frame-title="'. __('Choose Image', 'dilaz-panel') .'"';
					$data_frame_b_txt = ($frame_button_text != '') ? 'data-frame-button-text="'. esc_attr($frame_button_text) .'"' : 'data-frame-button-text="'. __('Use Selected Image', 'dilaz-panel') .'"';
					break;
					
				case ('audio') :
					$data_frame_title = ($frame_title != '') ? 'data-frame-title="'. esc_attr($frame_title) .'"' : 'data-frame-title="'. __('Choose Audio', 'dilaz-panel') .'"';
					$data_frame_b_txt = ($frame_button_text != '') ? 'data-frame-button-text="'. esc_attr($frame_button_text) .'"' : 'data-frame-button-text="'. __('Use Selected Audio', 'dilaz-panel') .'"';
					break;
					
				case ('video') :
					$data_frame_title = ($frame_title != '') ? 'data-frame-title="'. esc_attr($frame_title) .'"' : 'data-frame-title="'. __('Choose Video', 'dilaz-panel') .'"';
					$data_frame_b_txt = ($frame_button_text != '') ? 'data-frame-button-text="'. esc_attr($frame_button_text) .'"' : 'data-frame-button-text="'. __('Use Selected Video', 'dilaz-panel') .'"';
					break;
					
				case ('document') :
					$data_frame_title = ($frame_title != '') ? 'data-frame-title="'. esc_attr($frame_title) .'"' : 'data-frame-title="'. __('Choose Document', 'dilaz-panel') .'"';
					$data_frame_b_txt = ($frame_button_text != '') ? 'data-frame-button-text="'. esc_attr($frame_button_text) .'"' : 'data-frame-button-text="'. __('Use Selected Document', 'dilaz-panel') .'"';
					break;
					
				case ('spreadsheet') :
					$data_frame_title = ($frame_title != '') ? 'data-frame-title="'. esc_attr($frame_title) .'"' : 'data-frame-title="'. __('Choose Spreadsheet', 'dilaz-panel') .'"';
					$data_frame_b_txt = ($frame_button_text != '') ? 'data-frame-button-text="'. esc_attr($frame_button_text) .'"' : 'data-frame-button-text="'. __('Use Selected Spreadsheet', 'dilaz-panel') .'"';
					break;
					
				case ('interactive') :
					$data_frame_title = ($frame_title != '') ? 'data-frame-title="'. esc_attr($frame_title) .'"' : 'data-frame-title="'. __('Choose Interactive File', 'dilaz-panel') .'"';
					$data_frame_b_txt = ($frame_button_text != '') ? 'data-frame-button-text="'. esc_attr($frame_button_text) .'"' : 'data-frame-button-text="'. __('Use Selected Interactive File', 'dilaz-panel') .'"';
					break;
					
				case ('text') :
					$data_frame_title = ($frame_title != '') ? 'data-frame-title="'. esc_attr($frame_title) .'"' : 'data-frame-title="'. __('Choose Text File', 'dilaz-panel') .'"';
					$data_frame_b_txt = ($frame_button_text != '') ? 'data-frame-button-text="'. esc_attr($frame_button_text) .'"' : 'data-frame-button-text="'. __('Use Selected Text File', 'dilaz-panel') .'"';
					break;
					
				case ('archive') :
					$data_frame_title = ($frame_title != '') ? 'data-frame-title="'. esc_attr($frame_title) .'"' : 'data-frame-title="'. __('Choose Archive File', 'dilaz-panel') .'"';
					$data_frame_b_txt = ($frame_button_text != '') ? 'data-frame-button-text="'. esc_attr($frame_button_text) .'"' : 'data-frame-button-text="'. __('Use Selected Archive File', 'dilaz-panel') .'"';
					break;
					
				case ('code') :
					$data_frame_title = ($frame_title != '') ? 'data-frame-title="'. esc_attr($frame_title) .'"' : 'data-frame-title="'. __('Choose Code File', 'dilaz-panel') .'"';
					$data_frame_b_txt = ($frame_button_text != '') ? 'data-frame-button-text="'. esc_attr($frame_button_text) .'"' : 'data-frame-button-text="'. __('Use Selected Code File', 'dilaz-panel') .'"';
					break;
			}
			
			$output .= '<div class="dilaz-panel-file-upload">';
				
				if (!empty($value)) {
					if (is_array($value) && isset($value[0]['url'])) {
						$the_file_url = $value[0]['url'];
					} else if (is_array($value) && isset($value['url'])) {
						$the_file_url = $value['url'];
					} else if (!is_array($value)) {
						$the_file_url = '';
					}
				}
				
				$output .= '<input type="'. (!$is_file_multiple ? "text" : "hidden") .'" name="'. esc_attr($id) .'[url][]" id="file_url_'. esc_attr($id) .'" class="dilaz-panel-input dilaz-panel-text dilaz-panel-file-url upload" value="'. esc_url($the_file_url) .'" size="0" rel="" placeholder="Choose file" />';
				
				$output .= '<input type="button" id="upload-'. esc_attr($id) .'" class="dilaz-panel-file-upload-button button" value="'. sprintf(__('Upload %s', 'dilaz-panel'), $file_type) .'" '. wp_kses_post($data_file_type) .' '. wp_kses_post($data_file_specific) .' '. wp_kses_post($data_file_multiple) .' '. wp_kses_post($data_frame_title) .' '. wp_kses_post($data_frame_b_txt) .' '. wp_kses_post($data_file_thumb) .' />';
				
				$output .= '<div class="dilaz-panel-file-wrapper" data-file-id="'. esc_attr($id) .'" '. wp_kses_post($data_file_multiple) .'>';
				
				$output .= '<input type="hidden" name="'. esc_attr($id) .'[id][]" id="file_id_'. esc_attr($id) .'" class="dilaz-panel-file-id upload" value="" size="0" rel="" />';
				
				if ($value != '' && is_array($value)) {
					foreach ($value as $key => $file_data) {
						
						if ( $key == 'url' || (isset($file_data['url']) && $file_data['url'] != '') ) {
							
							$attachment_url = is_array($file_data) && isset($file_data['url']) ? $file_data['url'] : (!empty($file_data) ? $file_data : '');
							$attachment_id  = isset($file_data['id']) && $file_data['id'] != '' ? attachment_url_to_postid($attachment_url) : '';
							
							if (!empty($attachment_url)) {
								
								if (FALSE !== get_post_status($attachment_id)) {
									$file = wp_get_attachment_image_src($attachment_id, 'thumbnail'); $file = $file[0];
								} else {
									$file = $attachment_url;
								}
								
								$output .= '<div class="dilaz-panel-media-file '. esc_attr($file_type) .' '. ($attachment_id != '' ? '' : 'empty') .'" id="file-'. esc_attr($id) .'">';
								
								$output .= '<input type="hidden" name="'. esc_attr($id) .'[url][]" id="file_url_'. esc_attr($id) .'" class="dilaz-panel-input dilaz-panel-text dilaz-panel-file-url upload" value="'. esc_url($attachment_url) .'" size="0" rel="" placeholder="Choose file" />';
								
								$output .= '<input type="hidden" name="'. esc_attr($id) .'[id][]" id="file_id_'. esc_attr($id) .'" class="dilaz-panel-file-id upload" value="'. esc_attr($attachment_id) .'" size="30" rel="" />';
								
								$output .= sizeof($value) > 1 ? '<span class="sort"></span>' : '';
						
								/* get attachment data */
								$attachment = get_post($attachment_id);
								
								/* get file extension */
								$file_ext = is_object($attachment) ? pathinfo($attachment->guid, PATHINFO_EXTENSION) : pathinfo($attachment_url, PATHINFO_EXTENSION);
								
								/* get file title */
								$file_title = is_object($attachment) ? $attachment->post_title : pathinfo($attachment_url, PATHINFO_FILENAME);
								
								/* get file type */
								$file_type = wp_ext2type($file_ext);
								
								$output .= '<div class="filename '. esc_attr($file_type) .'">'. wp_kses_post($file_title) .'</div>';
								
								$media_remove = '<a href="#" class="remove" title="'. __('Remove', 'dilaz-panel') .'"><span class="mdi mdi-window-close"></span></a>';
								
								switch ($file_type) {
									
									case ('image') :
										$output .= ($file_ext) ? '<img src="'. esc_url($file) .'" class="dilaz-panel-file-preview file-image" alt="" />'. wp_kses_post($media_remove) : '';
										break;
										
									case ('audio') :
										$output .= ($file_ext) ? '<img src="'. esc_url(DILAZ_PANEL_IMAGES) .'media/audio.png" class="dilaz-panel-file-preview file-audio" alt="" />'. wp_kses_post($media_remove) : '';
										break;
										
									case ('video') :
										$output .= ($file_ext) ? '<img src="'. esc_url(DILAZ_PANEL_IMAGES) .'media/video.png" class="dilaz-panel-file-preview file-video" alt="" />'. wp_kses_post($media_remove) : '';
										break;
										
									case ('document') :
										$output .= ($file_ext) ? '<img src="'. esc_url(DILAZ_PANEL_IMAGES) .'media/document.png" class="dilaz-panel-file-preview file-document" alt="" />'. wp_kses_post($media_remove) : '';
										break;
										
									case ('spreadsheet') :
										$output .= ($file_ext) ? '<img src="'. esc_url(DILAZ_PANEL_IMAGES) .'media/spreadsheet.png" class="dilaz-panel-file-preview file-spreadsheet" alt="" />'. wp_kses_post($media_remove) : '';
										break;
										
									case ('interactive') :
										$output .= ($file_ext) ? '<img src="'. esc_url(DILAZ_PANEL_IMAGES) .'media/interactive.png" class="dilaz-panel-file-preview file-interactive" alt="" />'. wp_kses_post($media_remove) : '';
										break;
										
									case ('text') :
										$output .= ($file_ext) ? '<img src="'. esc_url(DILAZ_PANEL_IMAGES) .'media/text.png" class="dilaz-panel-file-preview file-text" alt="" />'. wp_kses_post($media_remove) : '';
										break;
										
									case ('archive') :
										$output .= ($file_ext) ? '<img src="'. esc_url(DILAZ_PANEL_IMAGES) .'media/archive.png" class="dilaz-panel-file-preview file-archive" alt="" />'. wp_kses_post($media_remove) : '';
										break;
										
									case ('code') :	
										$output .= ($file_ext) ? '<img src="'. esc_url(DILAZ_PANEL_IMAGES) .'media/code.png" class="dilaz-panel-file-preview file-code" alt="" />'. wp_kses_post($media_remove) : '';
										break;
										
								}
								$output .= '</div><!-- .dilaz-panel-media-file -->'; // .dilaz-panel-media-file
							}
						}
					}
					
				}
				
				$output .= '</div><!-- .dilaz-panel-file-wrapper -->'; // end .dilaz-panel-file-wrapper
				$output .= '<div class="clear"></div>';
				
			$output .= '</div><!-- .dilaz-panel-file-upload -->'; // end .dilaz-panel-file-upload
			
			echo $output;
		}
		
		/**
		 * Background
		 *
		 * @since  1.0
		 * @access public
		 *
		 * @param  array $field Field arguments
		 * @return html  $output
		 */
		public static function fieldBackground($field)
		{
			
			extract($field);
			
			$output = '';
			
			$bg_defaults = DilazPanelDefaults\DilazPanelDefaults::bg();
			$saved_bg = isset($value) ? $value : $std;
			
			$saved_bg_image      = isset($saved_bg['image']) ? $saved_bg['image'] : '';
			$saved_bg_repeat     = isset($saved_bg['repeat']) ? $saved_bg['repeat'] : '';
			$saved_bg_size       = isset($saved_bg['size']) ? $saved_bg['size'] : '';
			$saved_bg_position   = isset($saved_bg['position']) ? $saved_bg['position'] : '';
			$saved_bg_attachment = isset($saved_bg['attachment']) ? $saved_bg['attachment'] : '';
			$saved_bg_origin     = isset($saved_bg['origin']) ? $saved_bg['origin'] : '';
			$saved_bg_color      = isset($saved_bg['color']) ? $saved_bg['color'] : '';
			$frame_title         = (isset($args['frame_title']) && $args['frame_title'] != '') ? sanitize_text_field($args['frame_title']) : '';
			$frame_button_text   = (isset($args['frame_button_text']) && $args['frame_button_text'] != '') ? sanitize_text_field($args['frame_button_text']) : '';
			
			$data_frame_title = ($frame_title != '') ? 'data-frame-title="'. $frame_title .'"' : 'data-frame-title="'. __('Choose Image', 'dilaz-panel') .'"';
			$data_frame_b_txt = ($frame_button_text != '') ? 'data-frame-button-text="'. $frame_button_text .'"' : 'data-frame-button-text="'. __('Use Selected Image', 'dilaz-panel') .'"';
			
			/* BG image */
			if (isset($options['image']) && $options['image'] !== FALSE) {
				$output .= '<div class="dilaz-panel-background">';
				$output .= '<strong>'. __('Image', 'dilaz-panel') .'</strong><br />';
					$output .= '<div class="dilaz-panel-file-upload image">';
					
						$output .= '<input type="text" name="'. esc_attr($id) .'[image]" id="file_'. esc_attr($id) .'" class="dilaz-panel-input dilaz-panel-text dilaz-panel-file-url dilaz-panel-file-id upload" value="'. esc_attr($saved_bg_image) .'" size="40" rel="" placeholder="No image selected" />';
						
						$output .= '<input type="button" id="upload-'. esc_attr($id) .'" class="dilaz-panel-file-upload-button button" value="'. __('Upload image', 'dilaz-panel') .'" data-file-type="image" data-field-type="background" '. wp_kses_post($data_frame_title) .' '. wp_kses_post($data_frame_b_txt) .'/>';
						
						$output .= '<input type="button" id="upload-remove" class="hidden remove remove-image button" value="'. __('Remove image', 'dilaz-panel') .'" />';
						
					$output .= '<div class="clear"></div>';
					$output .= '</div><!-- .dilaz-panel-file-upload -->'; // end .dilaz-panel-file-upload
				$output .= '</div><!-- .dilaz-panel-background -->'; // end .dilaz-panel-background
			}
			
			/* BG repeat */
			if (isset($options['repeat']) && $options['repeat'] !== FALSE) {
				$output .= '<div class="dilaz-panel-background">';
				$output .= '<strong>'. __('Repeat', 'dilaz-panel') .'</strong><br />';
				$output .= '<select id="'. esc_attr($id) .'-repeat" name="'. esc_attr($id) .'[repeat]" class="repeat">';
				$bg_repeats = is_array($options['repeat']) ? $options['repeat'] : $bg_defaults['repeat'];
				foreach ($bg_repeats as $key => $bg_repeat) {
					$output .= '<option value="'. esc_attr($key) .'" ' . selected($saved_bg_repeat, $key, FALSE) . '>'. wp_kses_post($bg_repeat) .'</option>';
				}
				$output .= '</select>';
				$output .= '</div>';
			}
			
			/* BG size */
			if (isset($options['size']) && $options['size'] !== FALSE) {
				$output .= '<div class="dilaz-panel-background">';
				$output .= '<strong>'. __('Size', 'dilaz-panel') .'</strong><br />';
				$output .= '<select id="'. esc_attr($id) .'-size" name="'. esc_attr($id) .'[size]" class="size">';
				$bg_sizes = is_array($options['size']) ? $options['size'] : $bg_defaults['size'];
				foreach ($bg_sizes as $key => $bg_size) {
					$output .= '<option value="'. esc_attr($key) .'" ' . selected($saved_bg_size, $key, FALSE) . '>'. wp_kses_post($bg_size) .'</option>';
				}
				$output .= '</select>';
				$output .= '</div>';
			}
			
			/* BG position */
			if (isset($options['position']) && $options['position'] !== FALSE) {
				$output .= '<div class="dilaz-panel-background">';
				$output .= '<strong>'. __('Position', 'dilaz-panel') .'</strong><br />';
				$output .= '<select id="'. esc_attr($id) .'-position" name="'. esc_attr($id) .'[position]" class="position">';
				$bg_positions = is_array($options['position']) ? $options['position'] : $bg_defaults['position'];
				foreach ($bg_positions as $key => $bg_position) {
					$output .= '<option value="'. esc_attr($key) .'" ' . selected($saved_bg_position, $key, FALSE) . '>'. wp_kses_post($bg_position) .'</option>';
				}
				$output .= '</select>';
				$output .= '</div>';
			}
			
			/* BG attachment */
			if (isset($options['attachment']) && $options['attachment'] !== FALSE) {
				$output .= '<div class="dilaz-panel-background">';
				$output .= '<strong>'. __('Attachment', 'dilaz-panel') .'</strong><br />';
				$output .= '<select id="'. esc_attr($id) .'-attachment" name="'. esc_attr($id) .'[attachment]" class="attach">';
				$bg_attachments = is_array($options['attachment']) ? $options['attachment'] : $bg_defaults['attachment'];
				foreach ($bg_attachments as $key => $bg_attachment) {
					$output .= '<option value="'. esc_attr($key) .'" ' . selected($saved_bg_attachment, $key, FALSE) . '>'. wp_kses_post($bg_attachment) .'</option>';
				}
				$output .= '</select>';
				$output .= '</div>';
			}
			
			/* BG origin */
			if (isset($options['origin']) && $options['origin'] !== FALSE) {
				$output .= '<div class="dilaz-panel-background">';
				$output .= '<strong>'. __('Origin', 'dilaz-panel') .'</strong><br />';
				$output .= '<select id="'. esc_attr($id) .'-origin" name="'. esc_attr($id) .'[origin]" class="origin">';
				$bg_origins = is_array($options['origin']) ? $options['origin'] : $bg_defaults['origin'];
				foreach ($bg_origins as $key => $bg_origin) {
					$output .= '<option value="'. esc_attr($key) .'" ' . selected($saved_bg_origin, $key, FALSE) . '>'. wp_kses_post($bg_origin) .'</option>';
				}
				$output .= '</select>';
				$output .= '</div>';
			}
			
			/* BG color */
			if (isset($options['color']) && $options['color'] !== FALSE) {
				$output .= '<div class="dilaz-panel-background color">';
				$output .= '<strong>'. __('Color', 'dilaz-panel') .'</strong><br />';
				$default_color = isset($std['color']) ? $std['color'] : '';
				$output .= '<input id="'. esc_attr($id) .'-color" name='. esc_attr($id) .'[color]" class="dilaz-panel-color" type="text" value="'. esc_attr($saved_bg_color) .'" data-default-color="'. esc_attr($default_color) .'" />';
				$output .= '</div>';
			}
			
			$output .= '<div class="dilaz-panel-background background-preview" style="display:none">';
				$output .= '<div class="content"></div>';
			$output .= '</div>';
			
			echo $output;
		}
		
		/**
		 * Editor
		 *
		 * @since  2.6
		 * @access public
		 *
		 * @param  array $field Field arguments
		 * @return html  $output
		 */
		public static function fieldEditor($field)
		{
			
			extract($field);
			
			$output = '';
			
			$tinyMCE_plugins = array(
				'charmap',
				'colorpicker',
				'hr',
				'lists',
				'media',
				'paste',
				'tabfocus',
				'textcolor',
				'fullscreen',
				'wordpress',
				'wpautoresize',
				'wpeditimage',
				'wpemoji',
				'wpgallery',
				'wplink',
				'wpdialogs',
				'wptextpattern',
				'wpview',
			);
			
			$default_editor_settings = array(
				'media_buttons' => FALSE,
				'textarea_name' => esc_attr($id),
				'textarea_rows' => 20,
				'editor_class'  => 'dilaz-wp-editor '. esc_attr($class),
				'teeny'         => FALSE,
				'tinymce'       => array(
					'autoresize_min_height' => 100,
					'wp_autoresize_on'      => true,
					'plugins'               => implode(',', $tinyMCE_plugins),
					'body_class'            => 'dilaz-mce-editor'
				)
			);
			$editor_settings = [];
			$editor_settings = wp_parse_args($args['editor'], $default_editor_settings);
			ob_start();
			wp_editor($value, $id, $editor_settings);
			echo ob_get_clean();
		}
		
		/**
		 * Export
		 *
		 * @since  1.0
		 * @access public
		 *
		 * @param  array $field Field arguments
		 * @return html  $output
		 */
		public static function fieldExport($field)
		{
			
			extract($field);
			
			$output = '';
			
			$output .= '<div id="dilaz-panel-export" data-export-nonce="'. wp_create_nonce(basename(__FILE__)) .'">
				<span class="dilaz-panel-export button button-primary button-hero">'. __('Export Settings', 'dilaz-panel') .'</span>
				<span class="spinner"></span>
				<span class="progress">'. __('Exporting options... Please wait.', 'dilaz-panel') .'</span>
				<span class="finished">'. __('Export finished successfully.', 'dilaz-panel') .'</span>
			</div>';
			
			echo $output;
		}
		
		/**
		 * Import
		 *
		 * @since  1.0
		 * @access public
		 *
		 * @param  array $field Field arguments
		 * @return html  $output
		 */
		public static function fieldImport($field)
		{
			
			extract($field);
			
			$output = '';
			
			$output .= '<div id="dilaz-panel-import" data-import-nonce="'. wp_create_nonce(basename(__FILE__)) .'"">
				<label class="dilaz-import-select button" for="dilaz_panel_import">
					<input type="file" class="dilaz-import-file" name="dilaz_panel_import" accept="json" />
					<i class="fa fa-upload"></i>&nbsp;&nbsp;<span>Select file&hellip;</span>
				</label>
				</span>
				<span class="dilaz-panel-import button button-primary">'. __('Import Settings', 'dilaz-panel') .'</span>
				<div class="clear"></div>
				<span class="spinner"></span>
				<span class="progress">'. __('Importing options... Please wait.', 'dilaz-panel') .'</span>
				<span class="finished"></span>
			</div>';
			
			echo $output;
		}
		
	}
}