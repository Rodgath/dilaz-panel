<?php 
/*
|| --------------------------------------------------------------------------------------------
|| Admin Panel Functions
|| --------------------------------------------------------------------------------------------
||
|| @package		Dilaz Panel
|| @subpackage	Functions
|| @since		Dilaz Panel 2.0
|| @author		WebDilaz Team, http://webdilaz.com
|| @copyright	Copyright (C) 2017, WebDilaz LTD
|| @link		http://webdilaz.com/panel
|| @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
|| 
*/

defined('ABSPATH') || exit;

class DilazPanelFunctions {
	
	
	function __construct() {
		add_action('wp_ajax_dilaz_panel_query_select', array(&$this, 'querySelect'));
		add_action('wp_ajax_dilaz_panel_get_post_titles', array(&$this, 'getPostTitles'));
	}
	
	
	/**
	 * Query select function
	 *
	 * @since 1.0
	 *
	 * @global wpdb   $wpdb                WordPress database abstraction object
	 * @param  string $_POST['q']          search string
	 * @param  array  $_POST['selected']   selected items
	 * @param  string $_POST['query_type'] 'post', 'user', 'term'
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
		
			# The callback is a closure that needs to use the $search from the current scope
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
	
}