<?php 
/*
|| --------------------------------------------------------------------------------------------
|| Admin Panel Functions
|| --------------------------------------------------------------------------------------------
||
|| @package		Dilaz Panel
|| @subpackage	Functions
|| @since		Dilaz Panel 2.0
|| @author		Rodgath, https://github.com/Rodgath
|| @copyright	Copyright (C) 2017, Rodgath LTD
|| @link		https://github.com/Rodgath/Dilaz-Panel-Plugin
|| @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
|| 
*/

defined('ABSPATH') || exit;

if (!class_exists('DilazPanelFunctions')) {
	class DilazPanelFunctions {
		
		
		function __construct() {
			add_action('wp_ajax_dilaz_panel_query_select', array(&$this, 'querySelect'), 2);
			add_action('wp_ajax_dilaz_panel_get_post_titles', array(&$this, 'getPostTitles'));
		}
		
		
		/**
		 * Query select function
		 *
		 * @since 1.0
		 * @since 2.6.2 added 'page' query type
		 *
		 * @global wpdb   $wpdb                WordPress database abstraction object
		 * @param  string $_POST['q']          search string
		 * @param  array  $_POST['selected']   selected items
		 * @param  string $_POST['query_type'] 'post', 'page', 'user', 'term'
		 * @param  array  $_POST['query_args'] query arguments
		 *
		 * @return json.data
		 */
		function querySelect() {
			
			global $wpdb;
			
			$search     = isset($_POST['q']) ? $wpdb->esc_like($_POST['q']) : '';
			$selected   = isset($_POST['selected']) ? (array)$_POST['selected'] : '';
			$query_type = isset($_POST['query_type']) ? sanitize_text_field($_POST['query_type']) : '';
			$query_args = isset($_POST['query_args']) ? $_POST['query_args'] : '';
			
			$data = array();
			
			if ($query_type == 'post') {
			
				/* The callback is a closure that needs to use the $search from the current scope */
				add_filter('posts_where', function ($where) use ($search) {
					$where .= (' AND post_title LIKE "%'. $search .'%"');
					return $where;
				});
				
				$default_args = array(
					'post__not_in'     => $selected,
					'suppress_filters' => false,
				);
				
				$query = wp_parse_args( $default_args, unserialize(base64_decode($query_args)) );
				$posts = get_posts($query);
				
				foreach ($posts as $post) {
					$data[] = array(
						'id'   => $post->ID,
						'name' => $post->post_title,
					);
				}
				
			} else if ($query_type == 'page') {
			
				/* The callback is a closure that needs to use the $search from the current scope */
				add_filter('posts_where', function ($where) use ($search) {
					$where .= (' AND post_title LIKE "%'. $search .'%"');
					return $where;
				});
				
				$default_args = array(
					'post__not_in'     => $selected,
					'suppress_filters' => false,
				);
				
				$query = wp_parse_args( $default_args, unserialize(base64_decode($query_args)) );
				$posts = get_posts($query);
				
				foreach ($posts as $post) {
					$data[] = array(
						'id'   => $post->ID,
						'name' => $post->post_title,
					);
				}
				
			} else if ($query_type == 'user') {
				
				$default_args = array(
					'search'  => '*'. $search .'*',
					'exclude' => $selected
				);
				
				$query = wp_parse_args( $default_args, unserialize(base64_decode($query_args)) );
				$users = get_users($query);
				
				foreach ($users as $user) {
					$data[] = array(
						'id'   => $user->ID,
						'name' => $user->nickname,
					);
				}
				
			} else if ($query_type == 'term') {
				
				$default_args = array(
					'name__like' => $search,
					'exclude'    => $selected
				);
				
				$query = wp_parse_args( $default_args, unserialize(base64_decode($query_args)) );
				$terms = get_terms($query);
				
				foreach ($terms as $term) {
					$data[] = array(
						'id'   => $term->term_id,
						'name' => $term->name,
					);
				}
			}
			
			echo json_encode($data);
			
			die();
		}
		
		
		/**
		 * Get post titles
		 *
		 * @since 1.0
		 *
		 * @param array $_POST['selected'] selected items
		 *
		 * @return json.data
		 */
		function getPostTitles() {
			
			$result = array();
			
			$selected = isset($_POST['selected']) ? (array)$_POST['selected'] : '';

			if (is_array($selected) && !empty($selected)) {
				$posts = get_posts(array(
					'posts_per_page' => -1,
					'post_status'    => array('publish', 'draft', 'pending', 'future', 'private'),
					'post__in'       => $selected,
					'post_type'      => 'any'
				));
				
				foreach ($posts as $post) {
					$result[] = array(
						'id'    => $post->ID,
						'title' => $post->post_title,
					);
				}
			}

			echo json_encode($result);

			die;
		}
		
		
		/**
		 * Find position of array using its key and value
		 *
		 * @param array  $array	array to be searched through
		 * @param string $field	key of the array
		 * @param string $value	value of the array
		 * @since 2.7.6
		 *
		 * @return integer|bool
		 */
		public static function find_array_key_by_value($array, $field, $value) {
			foreach ($array as $key => $array_item) {
				if ($array_item[$field] === $value)
					return $key;
			}
			
			return false;
		}
		
		
		/**
		 * Insert an array before the key of another array
		 *
		 * @param array  $array           array to insert into
		 * @param array  $data            array to be inserted
		 * @param string $key_offset      key position of the array to be inserted
		 * @param string $insert_position 'before' or 'after' or 'last', default: before
		 * @since 2.7.6
		 *
		 * @return array|bool
		 */
		public static function insert_array_adjacent_to_key($array, $data, $key_offset, $insert_position = 'before') {
			
			if (!is_array($data)) return false;
			
			switch ($insert_position) {
				case 'before' : $offset = $key_offset; break;
				case 'after'  : $offset = $key_offset+1; break;
				case 'last'   : $offset = count($array); break; # usually used when inserting a tab to be the last one
				default       : $offset = $key_offset; break;
			}
			
			foreach ($data as $item) {
				$new_array = array_merge( array_slice($array, 0, $offset, true), (array) $item, array_slice($array, $offset, NULL, true) );  
			}
			
			return $new_array;  
		}
		
		
		/**
		 * Insert an array before the key of another array
		 *
		 * @param array  $array multidimensional array
		 * @param string $key   field to check e.g. 'id', 'name', 'num' etc
		 * @since 2.7.6
		 *
		 * @return array
		 */
		public static function unique_multidimensional_array($array, $key) {
			$temp_array = array();
			$i = 0;
			$key_array = array();
			
			foreach($array as $val) {
				if (!in_array($val[$key], $key_array)) {
					$key_array[$i] = $val[$key];
					$temp_array[$i] = $val;
				}
				$i++;
			}
			
			return $temp_array;
		}
		
		
		/**
		 * Remove target tab fields to avoid before adding modified fields
		 * after custom field insertion is completed
		 *
		 * @param array $options    options
		 * @param array $tab_fields tab option fields
		 * @since 2.7.6
		 *
		 * @return array
		 */
		public static function remove_target_tab_fields($options, $tab_fields) {
			
			$tab_fields_ids = [];
			
			foreach ($tab_fields as $k => $v) {
				$tab_fields_ids[] = $v['id'];
			}
			
			foreach ($options as $key => $value) {
				if (isset($value['id']) && in_array($value['id'], $tab_fields_ids)) {
					unset($options[$key]);
				}
			}
			
			return $options;
		}
		
		
		/**
		 * Get all fields within an options tab (both heading tabe and subheading tab)
		 *
		 * @param array  $options       all options array
		 * @param string $option_tab_id option set id
		 * @since 2.7.6
		 *
		 * @return array
		 */
		public static function get_tab_content($options, $option_tab_id) {
			
			$set_id = 0;
			$tab_content = array();
			
			foreach ($options as $key => $val) {
				
				if (!isset($val['type'])) continue;
				
				/* remove panel attributes */
				if ($val['type'] == 'panel-atts') continue;
				
				if (isset($val['type'])) {
					if ($val['type'] == 'heading') {
						if (isset($val['id'])) {
							$set_id = sanitize_key($val['id']);
						}
					}
				}
				
				if ($set_id == $option_tab_id) {
					$tab_content['fields'][] = $val;
				}
			}
			
			return $tab_content;
		}
		
		
		/**
		 * Add/Insert option field before a specific field
		 *
		 * @param array  $options         all options array
		 * @param string $option_tab_id   target options set id
		 * @param string $target_field_id target option field id
		 * @param string $context         tabs or fields, default: fields
		 * @param array  $insert_data     option fields to be inserted
		 * @param string $insert_position 'before' or 'after'
		 * @since 2.7.6
		 *
		 * @return array|void
		 */
		public static function insert_field($options, $option_tab_id, $target_field_id, $insert_data, $insert_position) {
			
			$tab_content = self::get_tab_content($options, $option_tab_id);
			
			/* bail if fields are not found */
			if (!isset($tab_content['fields'])) return;
			
			$tab_fields = $tab_content['fields'];
			
			/* remove all fields of the targeted tab from options
			 * because they will added back after custom field(s) is(are) appended 
			 */
			$options = self::remove_target_tab_fields($options, $tab_fields);
			
			/* get array key position */
			$key_offset = isset($tab_fields) ? self::find_array_key_by_value($tab_fields, 'id', $target_field_id) : '';
			
			/* new array after another array has been inserted  */
			$new_array_modified = isset($tab_fields) ? self::insert_array_adjacent_to_key($tab_fields, array($insert_data), $key_offset, $insert_position) : $options;
			
			/* merge the new array with the entire panel options array */
			$new_meta_boxes = ($new_array_modified != false) ? array_merge($options, $new_array_modified) : $options;
			
			return $new_meta_boxes;
		}
		
	}
	
	new DilazPanelFunctions;
}