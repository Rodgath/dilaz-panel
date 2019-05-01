<?php 
/*
|| --------------------------------------------------------------------------------------------
|| Admin Panel Fields
|| --------------------------------------------------------------------------------------------
||
|| @package		Dilaz Panel
|| @subpackage	Fields
|| @since		Dilaz Panel 1.0
|| @author		WebDilaz Team, http://webdilaz.com
|| @copyright	Copyright (C) 2017, WebDilaz LTD
|| @link		http://webdilaz.com/panel
|| @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
|| 
*/

defined('ABSPATH') || exit;

if (!class_exists('DilazPanelFields')) {
	class DilazPanelFields {
		
		/**
		 * Heading
		 *
		 * @since  1.0
		 * @access public
		 *
		 * @param  array $field Field arguments
		 * @return html  $output
		 */
		public static function fieldHeading($field) {
			
			extract($field);
			
			$output = '';
			
			if ($counter >= 2) {
				$output .= '</div><!-- tab1 -->';
			}
			
			$target = sanitize_key($name);
			
			$output .= '<div class="dilaz-panel-field" id="'. esc_attr($target) .'" data-tab-content="'. esc_attr($target) .'">';
			$output .= '<h3>'. esc_html($name) .'</h3>';
			
			return $output;
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
		public static function fieldSubheading($field) {
			
			extract($field);
			
			$output = '';
			
			if ($counter >= 2) {
				$output .= '</div><!-- tab2 -->';
			}
			$output .= '<div class="dilaz-panel-field" id="'. esc_attr(sanitize_key($name)) .'">';
			$output .= '<h3>'. esc_html($name) .'</h3>';
			
			return $output;
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
		public static function fieldInfo($field) {
			
			extract($field);
			
			$output = '';
			
			$output .= '<div class="info">';
			$output .= $name != '' ? '<h4>'. $name .'</h4>' : '';
			$output .= $desc != '' ? '<p>'. wp_kses_post($desc) .'</p>' : '';
			$output .= '</div>';
			
			return $output;
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
		public static function fieldText($field) {
			
			extract($field);
			
			return '<input type="text" id="'. esc_attr($id) .'" class="dilaz-panel-input dilaz-panel-text" name="'. esc_attr($id) .'" value="'. esc_attr($value) .'" />';
			
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
		public static function fieldMultitext($field) {
			
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
					
					$output .= '<div class="dilaz-panel-multi-text '. $inline .'" '. $cols .'>';
						$output .= '<div class="dilaz-panel-multi-text-wrap">';
							$output .= '<strong>'. $text_name .'</strong><br />';
							$output .= '<input class="dilaz-panel-text '. $class .'" type="text" name="'. esc_attr($id) .'['. esc_attr($key) .']" id="'. esc_attr($id) .'" value="'. $saved_text .'" />';
						$output .= '</div>';
					$output .= '</div>';
				}
			}
			
			return $output;
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
		public static function fieldTextarea($field) {
			
			extract($field);
			
			$cols = isset($args['cols']) && is_numeric($args['cols']) ? intval($args['cols']) : '50';
			$rows = isset($args['rows']) && is_numeric($args['rows']) ? intval($args['rows']) : '5';
			
			return '<textarea id="'. esc_attr($id) .'" class="dilaz-panel-input dilaz-panel-textarea" name="'. esc_attr($id) .'" cols="'. esc_attr($cols) .'" rows="'. esc_attr($rows) .'">'. esc_textarea($value) .'</textarea>';
			
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
		public static function fieldPassword($field) {
			
			extract($field);
			
			return '<input type="password" id="'. esc_attr($id) .'" class="dilaz-panel-input dilaz-panel-password" name="'. esc_attr($id) .'" value="'. esc_attr($value) .'" size="46" />';
			
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
		public static function fieldEmail($field) {
			
			extract($field);
			
			return '<input type="text" id="'. esc_attr($id) .'" class="dilaz-panel-input dilaz-panel-email" name="'. esc_attr($id) .'" value="'. esc_attr($value) .'" />';
			
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
		public static function fieldSelect($field) {
			
			extract($field);
			
			$output = '';
			
			$select2_class = isset($args['select2']) ? $args['select2'] : '';
			$select2_width = isset($args['select2width']) ? 'data-width="'. sanitize_text_field($args['select2width']) .'"' : 'data-width="100px"';
			
			$output .= '<select id="'. esc_attr($id) .'" class="dilaz-panel-input dilaz-panel-select '. $select2_class .'" name="'. esc_attr($id) .'" '. $select2_width .'>';
				foreach ($options as $key => $option) {
					$selected = (($value != '') && ($value == $key)) ? 'selected="selected"' : '';
					$output .= '<option '. $selected .' value="'. esc_attr($key) .'">'. esc_html($option) .'</option>';
				}
			$output .= '</select>';
			
			return $output;
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
		public static function fieldRepeatable($field) {
			
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
			$output .= '<ul id="'. esc_attr($id) .'" class="dilaz-panel-repeatable '.$class.'" data-ns="'.$not_sortable.'" data-s="'.$sortable.'" data-nr="'.$not_removable.'" data-r="'.$removable.'">';
				if (isset($options)) {
					$i = 0;
					foreach ((array)$options as $option_key => $option_value) {
						$output .= '<li class="dilaz-panel-repeatable-item">'.($not_sortable > $i ? '' : $sorter);
							if (is_array($option_value)) {
								foreach($option_value as $k => $v) {
									
									$saved_value = isset($value[$option_key][$k]) ? $value[$option_key][$k] : $v['value'];
									$label = isset($v['label']) ? $v['label'] : '';
									$field_size = isset($options[0][$k]['size']) ? intval($options[0][$k]['size']) : 30;
									
									$output .= '<div class="dilaz-panel-repeatable-item-wrap inline">';
									if ($label != '') {
										$output .= '<label for="'.esc_attr($id).'"><strong>'.$v['label'].'</strong></label>';
									}
									$output .= '<input type="text" class="'.$k.$i.'" name="'.esc_attr($id).'['.$i.'][]" value="'.$saved_value.'" size="'.$field_size.'" />
									</div>';
								}
							} else {
								$output .= '<input type="text" name="'.esc_attr($id).'['.$i.']" value="'.$option_value.'" size="30" />';
							}
						$output .= ($not_removable > $i || $i < 1 ? '' : $remover).'</li>';
						$i++;
					}
				}
			$output .= '</ul>';
			if ($add_more) {
				$output .= '<span class="dilaz-panel-add-repeatable-item button">'.$add_text.'</span>';
			}
			
			return $output;
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
		public static function fieldMultiselect($field) {
			
			extract($field);
			
			$output = '';
			
			$select2_class = isset($args['select2']) ? $args['select2'] : '';
			$select2_width = isset($args['select2width']) ? 'data-width="'. sanitize_text_field($args['select2width']) .'"' : 'data-width="100px"';
			
			$output .= '<select id="'. esc_attr($id) .'" class="dilaz-panel-input dilaz-panel-select '. $select2_class .'" multiple="multiple" name="'. esc_attr($id) .'[]" '. $select2_width .'>';
				$selected_data = (isset($option_data[$id]) && is_array($option_data[$id])) ? $option_data[$id] : array();
				foreach ($options as $key => $option) {
					$selected = (in_array($key, $selected_data)) ? 'selected="selected"' : '';
					$output .= '<option '. $selected .' value="'. esc_attr($key) .'">'. esc_html($option) .'</option>';
				}
			$output .= '</select>';
			
			return $output;
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
		public static function fieldQueryselect($field) {
			
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
			
			$output .= '<select style="" name="'. esc_attr($id) .'[]" id="'. esc_attr($id) .'" '. $multiple_attr .' class="dilaz-panel-query-select" 
			data-placeholder="'. esc_attr($placeholder) .'" 
			data-min-input="'. esc_attr($min_input) .'" 
			data-max-input="'. esc_attr($max_input) .'" 
			data-max-options="'. esc_attr($max_options) .'" 
			data-query-args="'. esc_attr(base64_encode(serialize($query_args))) .'" 
			data-query-type="'. esc_attr($query_type) .'" 
			data-multiple="'. esc_attr($multiple_bool) .'" 
			data-width="'. esc_attr($select2_width) .'">';
			
			$selected_data = (isset($option_data[$id]) && is_array($option_data[$id])) ? $option_data[$id] : array();
			
			foreach ($selected_data as $key => $item_id) {
				
				if ($query_type == 'post') {
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
			
			$output .= '</select>';
			
			return $output;
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
		public static function fieldRadio($field) {
			
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
			
			return $output;
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
		public static function fieldRadioimage($field) {
			
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
				$output .= '<label for="'. esc_attr($id .'-'. $key) .'"><input type="radio" id="'. esc_attr($id .'-'. $key) .'" class="dilaz-panel-input dilaz-panel-radio-image" name="'. esc_attr($id) .'" value="'. esc_attr($key) .'" '. $checked .' /><img src="'. $option .'" alt="" class="dilaz-panel-radio-image-img '. esc_attr($selected) .'" /></label>';
			}
			
			return $output;
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
		public static function fieldButtonset($field) {
			
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
				$output .= '<label for="'. esc_attr($id .'-'. $key) .'" class="dilaz-panel-button-set-button '. esc_attr($selected) .'"><input type="radio" class="dilaz-panel-input dilaz-panel-button-set" name="'. esc_attr($id) .'" id="'. esc_attr($id .'-'. $key) .'" value="'. esc_attr($key) .'" '. $checked .' /><span>'. esc_html($option) .'</span></label>';
			}
			
			return $output;
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
		public static function fieldSwitch($field) {
			
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
				$output .= '<label for="'. esc_attr($id .'-'. $key) .'" class="dilaz-panel-switch-button '. esc_attr($selected) .' '. esc_attr($state) .'"><input type="radio" class="dilaz-panel-input dilaz-panel-switch" name="'. esc_attr($id) .'" id="'. esc_attr($id .'-'. $key) .'" value="'. esc_attr($key) .'" '. $checked .' /><span>'. esc_html($option) .'</span></label>';
			}
			
			return $output;
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
		public static function fieldCheckbox($field) {
			
			extract($field);
			
			$output = '';
			
			$state = checked($value, TRUE, FALSE) ? 'focus' : '';
			$output .= '<label for="'. esc_attr($id) .'" class="dilaz-option"><input id="'. esc_attr($id) .'" class="dilaz-panel-input dilaz-panel-checkbox '. esc_attr($state) .'" type="checkbox" name="'. esc_attr($id) .'" '. checked($value, TRUE, FALSE) .' /><span class="checkbox"></span><span>'. wp_kses_post($desc) .'</span></label><div class="clear"></div>';
			
			return $output;
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
		public static function fieldMulticheck($field) {
			
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
				$output .= '<label for="'. esc_attr($id.'-'.$key) .'" class="dilaz-option '. esc_attr($inline) .'" style="'. esc_attr($cols) .'"><input type="checkbox" id="'. esc_attr($id.'-'.$key) .'" class="dilaz-panel-input dilaz-panel-checkbox '. esc_attr($state) .' '. $class .'" name="'. esc_attr($id .'['. $key .']') .'" '. $checked .' /><span class="checkbox"></span><span>'. esc_html($option) .'</span></label>';
			}
			
			return $output;
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
		public static function fieldSlider($field) {
			
			extract($field);
			
			$output = '';
			
			$value  = $value != '' ? (int)$value : '0';
			$min    = isset($args['min']) ? (int)$args['min'] : '';
			$max    = isset($args['max']) ? (int)$args['max'] : '';
			$step   = isset($args['step']) ? (int)$args['step'] : '';
			$suffix = isset($args['suffix']) ? sanitize_text_field($args['suffix']) : '';
			$output .= '<input type="hidden" id="'. esc_attr($id) .'" name="'. esc_attr($id) .'" value="'. esc_attr($value) .'" />';
			$output .= '<div class="dilaz-panel-slider" data-val="'. esc_attr($value) .'" data-min="'. esc_attr($min) .'" data-max="'. esc_attr($max) .'" data-step="'. esc_attr($step) .'"></div>';
			$output .= '<div class="dilaz-panel-slider-val"><span>'. esc_attr($value) .'</span>'. $suffix .'</div>';
			
			return $output;
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
		public static function fieldRange($field) {
			
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
				$output .= '<div class="dilaz-panel-min-val"><span class="min">'. $minName .'</span>'. $prefix .'<span class="val">'. esc_attr($min_val) .'</span>'. $suffix .'</div>';
				$output .= '<input type="hidden" class="" name="'. esc_attr($id) .'[max]" id="option-max" value="'. esc_attr($max_val) .'" placeholder="" size="7">';
				$output .= '<div class="dilaz-panel-max-val"><span class="max">'. $maxName .'</span>'. $prefix .'<span class="val">'. esc_attr($max_val) .'</span>'. $suffix .'</div>';
			$output .= '</div>';
			
			return $output;
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
		public static function fieldColor($field) {
			
			extract($field);
			
			$output = '';
			
			$default_color = isset($std) ? $std : '';
			$output .= '<input name="'. esc_attr($id) .'" id="'. esc_attr($id) .'" class="dilaz-panel-color"  type="text" value="'. $value .'" data-default-color="'. esc_attr($default_color) .'" />';
			
			return $output;
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
		public static function fieldMulticolor($field) {
			
			extract($field);
			
			$output = '';
			
			$multicolor_defaults = DilazPanelDefaults::_multicolor();
			$saved_colors = wp_parse_args($value, $multicolor_defaults);
			
			if (isset($options)) {
				foreach ($options as $key => $val) {
					
					$color_name    = isset($val['name']) ? $val['name'] : '';
					$default_color = isset($val['color']) ? $val['color'] : '';
					$saved_color   = isset($saved_colors[$key]) ? $saved_colors[$key] : $default_color;
					
					$output .= '<div class="dilaz-panel-multi-color">';
					$output .= '<strong>'. $color_name .'</strong><br />';
					$default_active = isset($std['active']) ? $std['active'] : '';
					$output .= '<input class="dilaz-panel-color '. (isset($class) ? $class : '') .'" type="text" name="'.  esc_attr($id) .'['. esc_attr($key) .']" id="'.  esc_attr($id) .'" value="'. $saved_color .'" data-default-color="'. $default_color .'" />';
					$output .= '</div>';
				}
			}
			
			return $output;
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
		public static function fieldFont($field) {
			
			extract($field);
			
			$output = '';
			
			$font_defaults = DilazPanelDefaults::_font();
			$saved_fonts   = wp_parse_args($value, $font_defaults);
			
			$fontUnit = isset($args['unit']) ? (string)$args['unit'] : 'px';
			$std      = isset($std) && is_array($std) ? array_map('sanitize_text_field', $std) : array();
			
			/* font family */
			if (isset($options['family']) && $options['family'] !== FALSE) {
				$output .= '<div class="dilaz-panel-font">';
					$output .= '<strong>'. __('Font Family', 'dilaz-panel') .'</strong><br />';
					$output .= '<select id="'. esc_attr($id) .'-family" name="'. esc_attr($id) .'[family]" class="family select2single" data-width="230px">';
					$font_families = is_array($options['family']) ? $options['family'] : DilazPanelDefaults::_font_family();						
					foreach ($font_families as $key => $font_family) {
						if (isset($saved_fonts['family']) && !empty($saved_fonts['family']) && $saved_fonts['family'] !== FALSE) {
							$selected_family = selected(strtolower($saved_fonts['family']), strtolower($key), FALSE);
						} else {
							$selected_family = isset($std['family']) && stripos($key, $std['family']) !== FALSE ? selected(strtolower($std['family']), strtolower($key), FALSE) : '';
						}
						$output .= '<option value="'. $key .'" '. $selected_family .'>'. $font_family .'</option>';
					}
					$output .= '</select>';
				$output .= '</div>';
			}
			
			/* font subset */
			if (isset($options['subset']) && $options['subset'] !== FALSE) {
				$output .= '<div class="dilaz-panel-font">';
					$output .= '<strong>'. __('Font Subset', 'dilaz-panel') .'</strong><br />';
					$output .= '<select id="'. esc_attr($id) .'-subset" name="'. esc_attr($id) .'[subset]" class="subset select2single" data-width="200px">';
					$font_subsets = is_array($options['subset']) ? $options['subset'] : DilazPanelDefaults::_font_subset();						
					foreach ($font_subsets as $key => $font_subset) {
						if (isset($saved_fonts['subset']) && !empty($saved_fonts['subset']) && $saved_fonts['subset'] !== FALSE) {
							$selected_subset = selected(strtolower($saved_fonts['subset']), strtolower($key), FALSE);
						} else {
							$selected_subset = isset($std['subset']) && stripos($key, $std['subset']) !== FALSE ? selected(strtolower($std['subset']), strtolower($key), FALSE) : '';
						}
						$output .= '<option value="'. $key .'" '. $selected_subset .'>'. $font_subset .'</option>';
					}
					$output .= '</select>';
				$output .= '</div>';
			}
			
			/* font weight */
			if (isset($options['weight']) && $options['weight'] !== FALSE) {
				$output .= '<div class="dilaz-panel-font">';
					$output .= '<strong>'. __('Font Weight', 'dilaz-panel') .'</strong><br />';
					$output .= '<select id="'. esc_attr($id) .'-weight" name="'. esc_attr($id) .'[weight]" class="weight select2single" data-width="160px">';
					$font_weights = is_array($options['weight']) ? $options['weight'] : DilazPanelDefaults::_font_weights();
					foreach ($font_weights as $key => $font_weight) {
						if (isset($saved_fonts['weight']) && !empty($saved_fonts['weight']) && $saved_fonts['weight'] !== FALSE) {
							$selected_weight = selected(strtolower($saved_fonts['weight']), strtolower($key), FALSE);
						} else {
							$selected_weight = isset($std['weight']) && stripos($key, $std['weight']) !== FALSE ? selected(strtolower($std['weight']), strtolower($key), FALSE) : '';
						}
						$output .= '<option value="'. $key .'" '. $selected_weight .'>'. $font_weight .'</option>';
					}
					$output .= '</select>';
				$output .= '</div>';
			}
			
			/* font style */
			if (isset($options['style']) && $options['style'] !== FALSE) {
				$output .= '<div class="dilaz-panel-font">';
					$output .= '<strong>'. __('Font Style', 'dilaz-panel') .'</strong><br />';
					$output .= '<select id="'. esc_attr($id) .'-style" name="'. esc_attr($id) .'[style]" class="style select2single" data-width="160px">';
					$font_styles = is_array($options['style']) ? $options['style'] : DilazPanelDefaults::_font_styles();
					foreach ($font_styles as $key => $font_style) {
						if (isset($saved_fonts['style']) && !empty($saved_fonts['style']) && $saved_fonts['style'] !== FALSE) {
							$selected_style = selected(strtolower($saved_fonts['style']), strtolower($key), FALSE);
						} else {
							$selected_style = isset($std['style']) && stripos($key, $std['style']) !== FALSE ? selected(strtolower($std['style']), strtolower($key), FALSE) : '';
						}
						$output .= '<option value="'. $key .'" '. $selected_style .'>'. $font_style .'</option>';
					}
					$output .= '</select>';
				$output .= '</div>';
			}
			
			/* font case - text transform */
			if (isset($options['case']) && $options['case'] !== FALSE) {
				$output .= '<div class="dilaz-panel-font">';
					$output .= '<strong>'. __('Font Case', 'dilaz-panel') .'</strong><br />';
					$output .= '<select id="'. esc_attr($id) .'-case" name="'. esc_attr($id) .'[case]" class="case select2single" data-width="130px">';
					$font_cases = is_array($options['case']) ? $options['case'] : DilazPanelDefaults::_font_cases();
					foreach ($font_cases as $key => $font_case) {
						if (isset($saved_fonts['case']) && !empty($saved_fonts['case']) && $saved_fonts['case'] !== FALSE) {
							$selected_case = selected(strtolower($saved_fonts['case']), strtolower($key), FALSE);
						} else {
							$selected_case = isset($std['case']) && stripos($key, $std['case']) !== FALSE ? selected(strtolower($std['case']), strtolower($key), FALSE) : '';
						}
						$output .= '<option value="'. $key .'" '. $selected_case .'>'. $font_case .'</option>';
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
						$output .= '<input type="text" class="f-size '. esc_attr($id) .'-size" name="'. esc_attr($id) .'[size]" value="'. $font_size .'" size="3" />';
						$output .= '<span class="unit">'. $fontUnit .'</span>';
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
						$output .= '<input type="text" class="f-height '. esc_attr($id) .'-height" name="'. esc_attr($id) .'[height]" value="'. $font_height .'" size="3" />';
						$output .= '<span class="unit">'. $fontUnit .'</span>';
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
					$output .= '<input id="'. esc_attr($id) .'-color" name='. esc_attr($id) .'[color]" class="dilaz-panel-color color" type="text" value="'. $font_color .'" data-default-color="'. $font_color .'" />';
				$output .= '</div>';
			}
			
			$output .= '<div class="dilaz-panel-font font-preview" style="display:none">';
				$output .= '<div class="content">1 2 3 4 5 6 7 8 9 0 A B C D E F G H I J K L M N O P Q R S T U V W X Y Z a b c d e f g h i j k l m n o p q r s t u v w x y z</div>';
			$output .= '</div>';
			
			return $output;
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
		public static function fieldUpload($field) {

			extract($field);
			
			$output = '';
			
			$data_file_multiple = (isset($args['multiple']) && $args['multiple'] == TRUE) ? 'data-file-multiple="true"' : '';
			$file_type          = (isset($args['file_type']) && $args['file_type'] != '') ? strtolower($args['file_type']) : 'image';
			$data_file_type     = $file_type != '' ? 'data-file-type="'. $file_type .'"' : 'data-file-type="image"';
			$data_file_specific = (isset($args['file_specific']) && $args['file_specific'] == TRUE) ? 'data-file-specific="true"' : '';
			$frame_title        = (isset($args['frame_title']) && $args['frame_title'] != '') ? sanitize_text_field($args['frame_title']) : '';
			$frame_button_text  = (isset($args['frame_button_text']) && $args['frame_button_text'] != '') ? sanitize_text_field($args['frame_button_text']) : '';
			
			switch ($file_type) {
				
				case ('image') :
					$data_frame_title = ($frame_title != '') ? 'data-frame-title="'. $frame_title .'"' : 'data-frame-title="'. __('Choose Image', 'dilaz-panel') .'"';
					$data_frame_b_txt = ($frame_button_text != '') ? 'data-frame-button-text="'. $frame_button_text .'"' : 'data-frame-button-text="'. __('Use Selected Image', 'dilaz-panel') .'"';
					break;
					
				case ('audio') :
					$data_frame_title = ($frame_title != '') ? 'data-frame-title="'. $frame_title .'"' : 'data-frame-title="'. __('Choose Audio', 'dilaz-panel') .'"';
					$data_frame_b_txt = ($frame_button_text != '') ? 'data-frame-button-text="'. $frame_button_text .'"' : 'data-frame-button-text="'. __('Use Selected Audio', 'dilaz-panel') .'"';
					break;
					
				case ('video') :
					$data_frame_title = ($frame_title != '') ? 'data-frame-title="'. $frame_title .'"' : 'data-frame-title="'. __('Choose Video', 'dilaz-panel') .'"';
					$data_frame_b_txt = ($frame_button_text != '') ? 'data-frame-button-text="'. $frame_button_text .'"' : 'data-frame-button-text="'. __('Use Selected Video', 'dilaz-panel') .'"';
					break;
					
				case ('document') :
					$data_frame_title = ($frame_title != '') ? 'data-frame-title="'. $frame_title .'"' : 'data-frame-title="'. __('Choose Document', 'dilaz-panel') .'"';
					$data_frame_b_txt = ($frame_button_text != '') ? 'data-frame-button-text="'. $frame_button_text .'"' : 'data-frame-button-text="'. __('Use Selected Document', 'dilaz-panel') .'"';
					break;
					
				case ('spreadsheet') :
					$data_frame_title = ($frame_title != '') ? 'data-frame-title="'. $frame_title .'"' : 'data-frame-title="'. __('Choose Spreadsheet', 'dilaz-panel') .'"';
					$data_frame_b_txt = ($frame_button_text != '') ? 'data-frame-button-text="'. $frame_button_text .'"' : 'data-frame-button-text="'. __('Use Selected Spreadsheet', 'dilaz-panel') .'"';
					break;
					
				case ('interactive') :
					$data_frame_title = ($frame_title != '') ? 'data-frame-title="'. $frame_title .'"' : 'data-frame-title="'. __('Choose Interactive File', 'dilaz-panel') .'"';
					$data_frame_b_txt = ($frame_button_text != '') ? 'data-frame-button-text="'. $frame_button_text .'"' : 'data-frame-button-text="'. __('Use Selected Interactive File', 'dilaz-panel') .'"';
					break;
					
				case ('text') :
					$data_frame_title = ($frame_title != '') ? 'data-frame-title="'. $frame_title .'"' : 'data-frame-title="'. __('Choose Text File', 'dilaz-panel') .'"';
					$data_frame_b_txt = ($frame_button_text != '') ? 'data-frame-button-text="'. $frame_button_text .'"' : 'data-frame-button-text="'. __('Use Selected Text File', 'dilaz-panel') .'"';
					break;
					
				case ('archive') :
					$data_frame_title = ($frame_title != '') ? 'data-frame-title="'. $frame_title .'"' : 'data-frame-title="'. __('Choose Archive File', 'dilaz-panel') .'"';
					$data_frame_b_txt = ($frame_button_text != '') ? 'data-frame-button-text="'. $frame_button_text .'"' : 'data-frame-button-text="'. __('Use Selected Archive File', 'dilaz-panel') .'"';
					break;
					
				case ('code') :
					$data_frame_title = ($frame_title != '') ? 'data-frame-title="'. $frame_title .'"' : 'data-frame-title="'. __('Choose Code File', 'dilaz-panel') .'"';
					$data_frame_b_txt = ($frame_button_text != '') ? 'data-frame-button-text="'. $frame_button_text .'"' : 'data-frame-button-text="'. __('Use Selected Code File', 'dilaz-panel') .'"';
					break;
			}
			
			$output .= '<div class="dilaz-panel-file-upload">';
			
				$output .= '<input type="button" id="upload-'. esc_attr($id) .'" class="dilaz-panel-file-upload-button button" value="'. sprintf(__('Upload %s', 'dilaz-panel'), $file_type) .'" '. $data_file_type.' '. $data_file_specific .' '. $data_file_multiple .' '. $data_frame_title .' '. $data_frame_b_txt .' />';
				
				$output .= '<div class="dilaz-panel-file-wrapper" data-file-id="'. esc_attr($id) .'" '. $data_file_multiple .'>';
				
				if ($value != '') {
					foreach ($value as $key => $attachment_id) {
						
						if ($attachment_id != '' && FALSE !== get_post_status($attachment_id)) {
							
							$file      = wp_get_attachment_image_src($attachment_id, 'thumbnail'); $file = $file[0];
							$file_full = wp_get_attachment_image_src($attachment_id, 'full'); $file_full = $file_full[0];
							
							$output .= '<div class="dilaz-panel-media-file '. $file_type .' '. ($attachment_id != '' ? '' : 'empty') .'" id="file-'. esc_attr($id) .'">';
							
							$output .= '<input type="hidden" name="'. esc_attr($id) .'[]" id="file_'. esc_attr($id) .'" class="dilaz-panel-file-id upload" value="'. 
							$attachment_id .'" size="30" rel"" />';
							
							$output .= sizeof($value) > 1 ? '<span class="sort"></span>' : '';
							
							/* get attachment data */
							$attachment = get_post($attachment_id);
							
							/* get file extension */
							$file_ext = pathinfo($attachment->guid, PATHINFO_EXTENSION);
							
							/* get file type */
							$file_type = wp_ext2type($file_ext);
							
							$output .= '<div class="filename '. $file_type .'">'. $attachment->post_title .'</div>';
							
							$media_remove = '<a href="#" class="remove" title="'. __('Remove', 'dilaz-panel') .'"><span class="mdi mdi-window-close"></span></a>';
							
							switch ($file_type) {
								
								case ('image') :
									$output .= ($file_ext) ? '<img src="'. $file .'" class="dilaz-panel-file-preview file-image" alt="" />'. $media_remove : '';
									break;
									
								case ('audio') :
									$output .= ($file_ext) ? '<img src="'. DILAZ_PANEL_IMAGES .'media/audio.png" class="dilaz-panel-file-preview file-audio" alt="" />'. $media_remove : '';
									break;
									
								case ('video') :
									$output .= ($file_ext) ? '<img src="'. DILAZ_PANEL_IMAGES .'media/video.png" class="dilaz-panel-file-preview file-video" alt="" />'. $media_remove : '';
									break;
									
								case ('document') :
									$output .= ($file_ext) ? '<img src="'. DILAZ_PANEL_IMAGES .'media/document.png" class="dilaz-panel-file-preview file-document" alt="" />'. $media_remove : '';
									break;
									
								case ('spreadsheet') :
									$output .= ($file_ext) ? '<img src="'. DILAZ_PANEL_IMAGES .'media/spreadsheet.png" class="dilaz-panel-file-preview file-spreadsheet" alt="" />'. $media_remove : '';
									break;
									
								case ('interactive') :
									$output .= ($file_ext) ? '<img src="'. DILAZ_PANEL_IMAGES .'media/interactive.png" class="dilaz-panel-file-preview file-interactive" alt="" />'. $media_remove : '';
									break;
									
								case ('text') :
									$output .= ($file_ext) ? '<img src="'. DILAZ_PANEL_IMAGES .'media/text.png" class="dilaz-panel-file-preview file-text" alt="" />'. $media_remove : '';
									break;
									
								case ('archive') :
									$output .= ($file_ext) ? '<img src="'. DILAZ_PANEL_IMAGES .'media/archive.png" class="dilaz-panel-file-preview file-archive" alt="" />'. $media_remove : '';
									break;
									
								case ('code') :	
									$output .= ($file_ext) ? '<img src="'. DILAZ_PANEL_IMAGES .'media/code.png" class="dilaz-panel-file-preview file-code" alt="" />'. $media_remove : '';
									break;
									
							}
							$output .= '</div><!-- .dilaz-panel-media-file -->'; // .dilaz-panel-media-file
						}
					}
				}
				$output .= '</div><!-- .dilaz-panel-file-wrapper -->'; // end .dilaz-panel-file-wrapper
				$output .= '<div class="clear"></div>';
			$output .= '</div><!-- .dilaz-panel-file-upload -->'; // end .dilaz-panel-file-upload
			
			return $output;
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
		public static function fieldBackground($field) {
			
			extract($field);
			
			$output = '';
			
			$bg_defaults = DilazPanelDefaults::_bg();
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
			if (isset($options['image'])) {
				$output .= '<div class="dilaz-panel-file-upload">';
				
					$output .= '<input type="button" id="upload-'. esc_attr($id) .'" class="dilaz-panel-file-upload-button button" value="'. __('Upload image', 'dilaz-panel') .'" data-file-type="image" data-field-type="background" '. $data_frame_title .' '. $data_frame_b_txt .'/>';
					
					$output .= '<div class="dilaz-panel-file-wrapper" data-file-id="'. esc_attr($id) .'">';
					
						if ($saved_bg_image != '' && FALSE !== get_post_status($saved_bg_image)) {
							
							$file      = wp_get_attachment_image_src($saved_bg_image, 'thumbnail'); $file = $file[0];
							$file_full = wp_get_attachment_image_src($saved_bg_image, 'full'); $file_full = $file_full[0];
							
							$output .= '<div class="dilaz-panel-media-file image '. ($saved_bg_image != '' ? '' : 'empty') .'" id="file-'. esc_attr($id) .'">';
							
							$output .= '<input type="hidden" name="'. esc_attr($id) .'[image]" id="file_'. esc_attr($id) .'" class="dilaz-panel-file-id upload" value="'. 
							$saved_bg_image .'" size="30" rel"" />';
							
							$output .= is_array($saved_bg_image) && sizeof($saved_bg_image) > 1 ? '<span class="sort"></span>' : '';
							
							/* get attachment data */
							$attachment = get_post($saved_bg_image);
							
							/* get file extension */
							$file_ext = pathinfo($attachment->guid, PATHINFO_EXTENSION);
							
							/* get file type */
							$file_type = wp_ext2type($file_ext);
							
							$output .= '<div class="filename '. $file_type .'">'. $attachment->post_title .'</div>';
							
							$media_remove = '<a href="#" class="remove" title="'. __('Remove', 'dilaz-panel') .'"><span class="mdi mdi-window-close"></span></a>';					
							
							switch ($file_type) {
								
								case ('image') :
									$output .= ($file_ext) ? '<img src="'. $file .'" class="dilaz-panel-file-preview file-image" alt="" />'. $media_remove : '';
									break;
									
								case ('audio') :
									$output .= ($file_ext) ? '<img src="'. DILAZ_PANEL_IMAGES .'media/audio.png" class="dilaz-panel-file-preview file-audio" alt="" />'. $media_remove : '';
									break;
									
								case ('video') :
									$output .= ($file_ext) ? '<img src="'. DILAZ_PANEL_IMAGES .'media/video.png" class="dilaz-panel-file-preview file-video" alt="" />'. $media_remove : '';
									break;
							}
							$output .= '</div><!-- .dilaz-panel-media-file -->'; // .dilaz-panel-media-file
						}
						
					$output .= '</div><!-- .dilaz-panel-file-wrapper -->'; // end .dilaz-panel-file-wrapper
					$output .= '<div class="clear"></div>';
				$output .= '</div><!-- .dilaz-panel-file-upload -->'; // end .dilaz-panel-file-upload
			}
			
			/* BG repeat */
			if (isset($options['repeat'])) {
				$output .= '<div class="dilaz-panel-background">';
				$output .= '<strong>'. __('Repeat', 'dilaz-panel') .'</strong><br />';
				$output .= '<select id="'. esc_attr($id) .'-repeat" name="'. esc_attr($id) .'[repeat]" class="repeat">';
				$bg_repeats = is_array($options['repeat']) ? $options['repeat'] : $bg_defaults['repeat'];
				foreach ($bg_repeats as $key => $bg_repeat) {
					$output .= '<option value="'. $key .'" ' . selected($saved_bg_repeat, $key, FALSE) . '>'. $bg_repeat .'</option>';
				}
				$output .= '</select>';
				$output .= '</div>';
			}
			
			/* BG size */
			if (isset($options['size'])) {
				$output .= '<div class="dilaz-panel-background">';
				$output .= '<strong>'. __('Size', 'dilaz-panel') .'</strong><br />';
				$output .= '<select id="'. esc_attr($id) .'-size" name="'. esc_attr($id) .'[size]" class="size">';
				$bg_sizes = is_array($options['size']) ? $options['size'] : $bg_defaults['size'];
				foreach ($bg_sizes as $key => $bg_size) {
					$output .= '<option value="'. $key .'" ' . selected($saved_bg_size, $key, FALSE) . '>'. $bg_size .'</option>';
				}
				$output .= '</select>';
				$output .= '</div>';
			}
			
			/* BG position */
			if (isset($options['position'])) {
				$output .= '<div class="dilaz-panel-background">';
				$output .= '<strong>'. __('Position', 'dilaz-panel') .'</strong><br />';
				$output .= '<select id="'. esc_attr($id) .'-position" name="'. esc_attr($id) .'[position]" class="position">';
				$bg_positions = is_array($options['position']) ? $options['position'] : $bg_defaults['position'];
				foreach ($bg_positions as $key => $bg_position) {
					$output .= '<option value="'. $key .'" ' . selected($saved_bg_position, $key, FALSE) . '>'. $bg_position .'</option>';
				}
				$output .= '</select>';
				$output .= '</div>';
			}
			
			/* BG attachment */
			if (isset($options['attachment'])) {
				$output .= '<div class="dilaz-panel-background">';
				$output .= '<strong>'. __('Attachment', 'dilaz-panel') .'</strong><br />';
				$output .= '<select id="'. esc_attr($id) .'-attachment" name="'. esc_attr($id) .'[attachment]" class="attach">';
				$bg_attachments = is_array($options['attachment']) ? $options['attachment'] : $bg_defaults['attachment'];
				foreach ($bg_attachments as $key => $bg_attachment) {
					$output .= '<option value="'. $key .'" ' . selected($saved_bg_attachment, $key, FALSE) . '>'. $bg_attachment .'</option>';
				}
				$output .= '</select>';
				$output .= '</div>';
			}
			
			/* BG origin */
			if (isset($options['origin'])) {
				$output .= '<div class="dilaz-panel-background">';
				$output .= '<strong>'. __('Origin', 'dilaz-panel') .'</strong><br />';
				$output .= '<select id="'. esc_attr($id) .'-origin" name="'. esc_attr($id) .'[origin]" class="origin">';
				$bg_origins = is_array($options['origin']) ? $options['origin'] : $bg_defaults['origin'];
				foreach ($bg_origins as $key => $bg_origin) {
					$output .= '<option value="'. $key .'" ' . selected($saved_bg_origin, $key, FALSE) . '>'. $bg_origin .'</option>';
				}
				$output .= '</select>';
				$output .= '</div>';
			}
			
			/* BG color */
			if (isset($options['color'])) {
				$output .= '<div class="dilaz-panel-background color">';
				$output .= '<strong>'. __('Color', 'dilaz-panel') .'</strong><br />';
				$default_color = isset($std['color']) ? $std['color'] : '';
				$output .= '<input id="'. esc_attr($id) .'-color" name='. esc_attr($id) .'[color]" class="dilaz-panel-color" type="text" value="'. $saved_bg_color .'" data-default-color="'. $default_color .'" />';
				$output .= '</div>';
			}
			
			$output .= '<div class="dilaz-panel-background background-preview" style="display:none">';
				$output .= '<div class="content"></div>';
			$output .= '</div>';
			
			return $output;
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
		public static function fieldEditor($field) {
			
			extract($field);
			
			$output = '';
			
			$default_editor_settings = array(
				'media_buttons' => FALSE,
				'textarea_name' => esc_attr($id),
				'textarea_rows' => 20,
				'editor_class'  => $class,
				'teeny'         => TRUE,
				'tinymce'       => array('plugins' => 'wordpress')
			);
			$editor_settings = [];
			$editor_settings = wp_parse_args($args['editor'], $default_editor_settings);
			ob_start();
			wp_editor($value, $id, $editor_settings);
			return ob_get_clean();
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
		public static function fieldExport($field) {
			
			extract($field);
			
			$output = '';
			
			$output .= '<div id="dilaz-panel-export" data-export-nonce="'. wp_create_nonce(basename(__FILE__)) .'">
				<span class="dilaz-panel-export button button-primary button-hero">'. __('Export Settings', 'dilaz-panel') .'</span>
				<span class="spinner"></span>
				<span class="progress">'. __('Exporting options... Please wait.', 'dilaz-panel') .'</span>
				<span class="finished">'. __('Export finished successfully.', 'dilaz-panel') .'</span>
			</div>';
			
			return $output;
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
		public static function fieldImport($field) {
			
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
			
			return $output;
		}
		
	}
}