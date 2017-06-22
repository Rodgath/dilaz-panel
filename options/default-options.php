<?php
/*
|| --------------------------------------------------------------------------------------------
|| Default Panel Option Fields
|| --------------------------------------------------------------------------------------------
||
|| @package		Dilaz Panel
|| @subpackage	Default Options
|| @since		Dilaz Panel 1.1
|| @author		WebDilaz Team, http://webdilaz.com
|| @copyright	Copyright (C) 2017, WebDilaz LTD
|| @link		http://webdilaz.com/panel
|| @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
|| 
*/

defined('ABSPATH') || exit;

/**
 * Define the options' fields
 *
 * @param	array $options
 * @return	array
 */
add_filter('dilaz_panel_options_filter', 'dilaz_panel_default_options');
function dilaz_panel_default_options( array $options ) {
	
	# MAIN TAB - General Settings
	# =============================================================================================
	$options[] = array(
		'name' => __('General Options', 'dilaz-metabox'),
		'type' => 'heading',
		'icon' => 'fa-cog'
	);
		
		# SUB TAB - Simple Options Set
		# *****************************************************************************************
		// $options[] = array(
			// 'name' => __('General', 'dilaz-metabox'),
			// 'type' => 'subheading',
		// );
			
			# FIELDS - Alpha Tab 1
			# >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
			$options[] = array(
				'id'   => 'range',
				'name' => __('Range:', 'dilaz-metabox'),
				'desc' => __('Set range between two minimum and maximum values.', 'dilaz-metabox'),
				'type' => 'range',
				'args' => array(
					'min'    => array( 8, 	__('Min', 'dilaz-metabox') ), 
					'max'    => array( 100,	__('Max', 'dilaz-metabox') ), 
					'step'   => '2', 
					'prefix' => '',
					'suffix' => '%'
				),
				'std' => array('min_std' => 20, 'max_std' => 45),
			);
			$options[] = array(
				'id'    => 'slider',
				'name'  => __('Slider:', 'dilaz-metabox'),
				'desc'  => __('Select value from range slider.', 'dilaz-metabox'),
				'type'  => 'slider',
				'args'  => array('min' => 8, 'max' => 100, 'step' => 2, 'suffix' => '%'),
				'std'   => '40',
				'class' => ''
			);
			$options[] = array(
				'id'   => 'switchenable',
				'name' => __('Switch Enable/Disable:', 'dilaz-metabox'),
				'desc' => __('Enable/disable switch option.', 'dilaz-metabox'),
				'type' => 'switch',
				'options' => array(
					'enable'  => __('Enable', 'dilaz-metabox'), 
					'disable' => __('Disable', 'dilaz-metabox'),
				),
				'std'  => 'disable',
				'class' => ''
			);
			$options[] = array(
				'id'   => 'switch',
				'name' => __('Switch:', 'dilaz-metabox'),
				'desc' => __('On/Off switch option.', 'dilaz-metabox'),
				'type' => 'switch',
				'options' => array(
					1 => __('On', 'dilaz-metabox'), 
					0 => __('Off', 'dilaz-metabox'),
				),
				'std'  => 0,
				'class' => ''
			);
			$options[] = array(
				'id'   => 'buttonset',
				'name' => __('Button Set:', 'dilaz-metabox'),
				'desc' => __('Set multiple options using buttonset.', 'dilaz-metabox'),
				'type' => 'buttonset',
				'options' => array(
					'yes'   => __('Yes', 'dilaz-metabox'), 
					'no'    => __('No', 'dilaz-metabox'),
					'maybe' => __('Maybe', 'dilaz-metabox')
				),
				'std'  => 'no',
				'class' => ''
			);
			$options[] = array(
				'id'   => 'background',
				'name' => __('Background:', 'dilaz-metabox'),
				'desc' => __('Background style.', 'dilaz-metabox'),
				'type' => 'background',
				'options' => array( 
					'image'      => false, 
					'repeat'     => false,
					'size'       => false,
					'position'   => false,
					'attachment' => false,
					'origin'     => false,
					'color'      => false, 
				),
				'std'   => array( 
					'image'      => '', 
					'repeat'     => '',
					'size'       => '',
					'position'   => '',
					'attachment' => '',
					'origin'     => '',
					'color'      => '', 
				),
				'class' => ''
			);
			$options[] = array(
				'id'    => 'textarea',
				'name'  => __('Textarea:', 'dilaz-metabox'),
				'desc'  => __('Enter text content. HTML tags are enabled.', 'dilaz-metabox'),
				'type'  => 'textarea',
				'args'  => array('rows' => 5),
				'std'   => 'Sample textarea content goes here.',
				'class' => ''
			);
	
	# MAIN TAB - Media Options
	# =============================================================================================
	$options[] = array(
		'name' => __('Media Options', 'dilaz-metabox'),
		'type' => 'heading',
		'icon' => 'fa-tv'
	);
		
		# SUB TAB - Image
		# *****************************************************************************************
		$options[] = array(
			'name' => __('Image', 'dilaz-metabox'),
			'type' => 'subheading',
		);
			
			# FIELDS - Image options
			# >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
			$options[] = array(
				'id'   => 'image_multiple',
				'name' => __('Image File (Multiple):', 'dilaz-metabox'),
				'desc' => __('Select/Upload multiple image files from media library.', 'dilaz-metabox'),
				'type' => 'upload',
				'std'  => '',
				'args' => array(
					'file_type' => 'image', 
					'multiple'  => true
				),
			);
			$options[] = array( 
				'id'   => 'image',
				'name' => __('Image File:', 'dilaz-metabox'),
				'desc' => __('Select/Upload single image file from media library.', 'dilaz-metabox'),
				'type' => 'upload',
				'std'  => '',
				'args' => array(
					'file_type' => 'image',
				),
			);
		
		# SUB TAB - Audio
		# *****************************************************************************************
		$options[] = array(
			'name' => __('Audio', 'dilaz-metabox'),
			'type' => 'subheading',
		);
			
			# FIELDS - Audio options
			# >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
			$options[] = array(
				'id'   => 'audio_multiple',
				'name' => __('Audio File (Multiple):', 'dilaz-metabox'),
				'desc' => __('Select/Upload multiple audio files from media library.', 'dilaz-metabox'),
				'type' => 'upload',
				'std'  => '',
				'args' => array(
					'file_type' => 'audio',  
					'multiple'  => true
				),
			);
			$options[] = array(
				'id'   => 'audio',
				'name' => __('Audio File:', 'dilaz-metabox'),
				'desc' => __('Select/Upload single audio file from media library.', 'dilaz-metabox'),
				'type' => 'upload',
				'std'  => '',
				'args' => array(
					'file_type' => 'audio',
				),
			);
		
		# SUB TAB - Video
		# *****************************************************************************************
		$options[] = array(
			'name' => __('Video', 'dilaz-metabox'),
			'type' => 'subheading',
		);
			
			# FIELDS - Video options
			# >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
			$options[] = array(
				'id'   => 'video_multiple',
				'name' => __('Video File (Multiple):', 'dilaz-metabox'),
				'desc' => __('Select/Upload multiple video files from media library.', 'dilaz-metabox'),
				'type' => 'upload',
				'std'  => '',
				'args' => array(
					'file_type' => 'video',
					'multiple'  => true
				),
			);
			$options[] = array(
				'id'   => 'video',
				'name' => __('Video File:', 'dilaz-metabox'),
				'desc' => __('Select/Upload single video file from media library.', 'dilaz-metabox'),
				'type' => 'upload',
				'std'  => '',
				'args' => array(
					'file_type' => 'video',
				),
			);
	
	# MAIN TAB - Color Options
	# =============================================================================================
	$options[] = array(
		'name' => __('Color Options', 'dilaz-metabox'),
		'type' => 'heading',
		'icon' => 'fa-paint-brush'
	);
		
		# SUB TAB - Color
		# *****************************************************************************************
		// $options[] = array(
			// 'name' => __('Color', 'dilaz-metabox'),
			// 'type' => 'subheading',
		// );
			
			# FIELDS - Color options
			# >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
			$options[] = array(
				'id'   => 'link',
				'name' => __('Link Example:', 'dilaz-metabox'),
				'desc' => __('Link multiple color properties.', 'dilaz-metabox'),
				'type' => 'multicolor',
				'options' => array(
					'regular' => array('color' => '#111111', 'name' => __('Regular', 'dilaz-metabox')),
					'hover'   => array('color' => '#333333', 'name' => __('Hover', 'dilaz-metabox')),
					'visited' => array('color' => '#555555', 'name' => __('Visited', 'dilaz-metabox')),
					'active'  => array('color' => '#999999', 'name' => __('Active', 'dilaz-metabox')),
				),
			);
			$options[] = array(
				'id'   => 'multicolor',
				'name' => __('Multicolor:', 'dilaz-metabox'),
				'desc' => __('General multiple color properties.', 'dilaz-metabox'),
				'type' => 'multicolor',
				'options' => array(
					'color1' => array('color' => '#111111', 'name' => __('Color 1', 'dilaz-metabox')),
					'color2' => array('color' => '#333333', 'name' => __('Color 2', 'dilaz-metabox')),
					'color3' => array('color' => '#555555', 'name' => __('Color 3', 'dilaz-metabox')),
					'color4' => array('color' => '#777777', 'name' => __('Color 4', 'dilaz-metabox')),
					'color5' => array('color' => '#999999', 'name' => __('Color 5', 'dilaz-metabox')),
				),
			);
			$options[] = array(
				'id'   => 'color',
				'name' => __('Color:', 'dilaz-metabox'),
				'desc' => __('Single color option.', 'dilaz-metabox'),
				'type' => 'color', 
				'std'  => '#ff2211',
				'class' => ''
			);
	
	# MAIN TAB - Typography Options
	# =============================================================================================
	$options[] = array(
		'name' => __('Typography Options', 'dilaz-metabox'),
		'type' => 'heading',
		'icon' => 'fa-font'
	);
		
		# SUB TAB - Typography
		# *****************************************************************************************
		// $options[] = array(
			// 'name' => __('Typography', 'dilaz-metabox'),
			// 'type' => 'subheading',
		// );
			
			# FIELDS - Typography options
			# >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
			$options[] = array(
				'id'   => 'font',
				'name' => __('Font:', 'dilaz-metabox'),
				'desc' => __('Typography style with many option properties.', 'dilaz-metabox'),
				'type' => 'font',
				'options' => array( 
					'family' => false, 
					'subset' => false, 
					'weight' => false, 
					'size'   => false, 
					'height' => false, 
					'style'  => false, 
					'case'   => false, 
					'color'  => false
				),
				'class' => ''
			);
			$options[] = array(
				'id'   => 'font_2',
				'name' => __('Font:', 'dilaz-metabox'),
				'desc' => __('Typography style with few option properties.', 'dilaz-metabox'),
				'type' => 'font',
				'options' => array( 
					'family' => false, 
					// 'subset' => false, 
					// 'weight' => false, 
					'size'   => false, 
					'height' => false, 
					'style'  => false, 
					'case'   => false, 
					'color'  => false
				),
				'class' => ''
			);
	
	# MAIN TAB - Choice Options
	# =============================================================================================
	$options[] = array(
		'name' => __('Choice Options', 'dilaz-metabox'),
		'type' => 'heading',
		'icon' => 'fa-sliders'
	);
		
		# SUB TAB - Choice
		# *****************************************************************************************
		// $options[] = array(
			// 'name' => __('Choice', 'dilaz-metabox'),
			// 'type' => 'subheading',
		// );
			
			# FIELDS - Choice options
			# >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
			$options[] = array(
				'id'   => 'radioimage',
				'name' => __('Radio Image:', 'dilaz-metabox'),
				'desc' => __('Images used as radio option fields.', 'dilaz-metabox'),
				'type' => 'radioimage',
				'options' => array(
					'teal.css'  => DILAZ_PANEL_IMAGES .'colors/teal.png',
					'cyan.css'  => DILAZ_PANEL_IMAGES .'colors/cyan.png',
					'amber.css' => DILAZ_PANEL_IMAGES .'colors/amber.png',
				),
				'std'   => 'amber.css',
				'class' => ''
			);
			$options[] = array(
				'id'   => 'radio',
				'name' => __('Radio:', 'dilaz-metabox'),
				'desc' => __('Tiled radio options selection.', 'dilaz-metabox'),
				'type' => 'radio',
				'options' => array(
					'one'   => __('One', 'dilaz-metabox'), 
					'two'   => __('Two', 'dilaz-metabox'),
					'three' => __('Three', 'dilaz-metabox')
				),
				'std'   => 'two',
				'class' => '',
			);
			$options[] = array(
				'id'   => 'radio_inline',
				'name' => __('Radio Inline:', 'dilaz-metabox'),
				'desc' => __('Inline radio options selection.', 'dilaz-metabox'),
				'type' => 'radio',
				'options' => array(
					'one'   => __('One', 'dilaz-metabox'),
					'two'   => __('Two', 'dilaz-metabox'),
					'three' => __('Three', 'dilaz-metabox'),
				),
				'std'   => 'two',
				'class' => '',
				'args'  => array('inline' => true),
			);
			$options[] = array(
				'id'   => 'multicheck',
				'name' => __('Multicheck:', 'dilaz-metabox'),
				'desc' => __('Tiled multiple checkbox options selection.', 'dilaz-metabox'),
				'type' => 'multicheck',
				'options' => array(
					'mon' => __('Monday', 'dilaz-metabox'),
					'tue' => __('Tuesday', 'dilaz-metabox'),
					'wed' => __('Wednesday', 'dilaz-metabox'),
					'thu' => __('Thursday', 'dilaz-metabox'),
					'fri' => __('Friday', 'dilaz-metabox'),
					'sat' => __('Saturday', 'dilaz-metabox'),
					'sun' => __('Sunday', 'dilaz-metabox')
				),
				'std'   => array('thu', 'sat', 'sun'),
				'class' => '',
			);
			$options[] = array(
				'id'   => 'multicheck_inline',
				'name' => __('Multicheck Inline:', 'dilaz-metabox'),
				'desc' => __('Inline multiple checkbox options selection.', 'dilaz-metabox'),
				'type' => 'multicheck',
				'options' => array(
					'mon' => __('Monday', 'dilaz-metabox'),
					'tue' => __('Tuesday', 'dilaz-metabox'),
					'wed' => __('Wednesday', 'dilaz-metabox'),
					'thu' => __('Thursday', 'dilaz-metabox'),
					'fri' => __('Friday', 'dilaz-metabox'),
					'sat' => __('Saturday', 'dilaz-metabox'),
					'sun' => __('Sunday', 'dilaz-metabox')
				),
				'std'   => array('tue', 'fri'),
				'class' => '',
				'args'  => array('inline' => true, 'cols' => 4),
			);
			$options[] = array(
				'id'    => 'checkbox',
				'name'  => __('Checkbox:', 'dilaz-metabox'),
				'desc'  => __('Select the preferred layout type.', 'dilaz-metabox'),
				'type'  => 'checkbox',
				'std'   => true,
				'class' => ''
			);
			$options[] = array(
				'id'   => 'term_select',
				'name' => __('Term Select:', 'dilaz-metabox'),
				'desc' => '',
				'type' => 'queryselect',
				'std'  => '',
				'args' => array(
					'select2'      => 'select2multiple',
					'query_type'   => 'term',
					'placeholder'  => __('Select category', 'dilaz-metabox'),
					'select2width' => '50%',
					'min_input'    => 1,
					'max_input'    => 100,
					'max_options'  => 10,
					'query_args'   => array(
						'taxonomy'   => 'category',
						'hide_empty' => false,
						'orderby'    => 'term_id',
						'order'      => 'ASC',
					),
				),
			);
			$options[] = array(
				'id'   => 'user_select',
				'name' => __('User Select:', 'dilaz-metabox'),
				'desc' => '',
				'type' => 'queryselect',
				'std'  => '',
				'args' => array(
					'select2'      => 'select2multiple',
					'query_type'   => 'user',
					'placeholder'  => __('Select user', 'dilaz-metabox'),
					'select2width' => '50%',
					'min_input'    => 1,
					'max_input'    => 100,
					'max_options'  => 10,
					'query_args'   => array(
						'orderby' => 'ID',
						'order'   => 'ASC',
					),
				),
			);
			$options[] = array(
				'id'   => 'post_select',
				'name' => __('Post Select:', 'dilaz-metabox'),
				'desc' => '',
				'type' => 'queryselect',
				'std'  => '',
				'args' => array(
					'select2'      => 'select2multiple',
					'query_type'   => 'post',
					'placeholder'  => __('Type to select a post', 'dilaz-metabox'),
					'select2width' => '50%',
					'min_input'    => 1,
					'max_input'    => 100,
					'max_options'  => 10,
					'query_args'   => array(
						'posts_per_page' => -1,
						'post_status'    => array('publish'),
						'post_type'      => array('post'),
						'order'          => 'ASC',
						'orderby'        => 'ID',
					),
				),
			);
			$options[] = array(
				'id'   => 'select_multiple_two',
				'name' => __('"Select2" Multi-Select Field:', 'dilaz-metabox'),
				'desc' => __('Select the preferred header type', 'dilaz-metabox'),
				'type' => 'multiselect',
				'options' => array( 
					'one'   => __('One', 'dilaz-metabox'), 
					'two'   => __('Two', 'dilaz-metabox'),
					'three' => __('Three', 'dilaz-metabox'),
					'four'  => __('Four', 'dilaz-metabox')
				),
				'args'  => array( 'select2' => 'select2multiple' ),
				'std'   => 'normal',
				'class' => ''
			);
			$options[] = array(
				'id'   => 'select_multiple_one',
				'name' => __('Default Milti-Select Field:', 'dilaz-metabox'),
				'desc' => __('Select the preferred header type', 'dilaz-metabox'),
				'type' => 'multiselect',
				'options' => array( 
					'one'   => __('One', 'dilaz-metabox'), 
					'two'   => __('Two', 'dilaz-metabox'),
					'three' => __('Three', 'dilaz-metabox'),
					'four'  => __('Four', 'dilaz-metabox')
				),
				'std'   => 'normal',
				'class' => ''
			);
			$options[] = array(
				'id'   => 'select_two',
				'name' => __('"Select2" Select Field:', 'dilaz-metabox'),
				'desc' => __('Select the preferred header type', 'dilaz-metabox'),
				'type' => 'select',
				'options' => array( 
					'one'   => __('One', 'dilaz-metabox'), 
					'two'   => __('Two', 'dilaz-metabox'),
					'three' => __('Three', 'dilaz-metabox'),
					'four'  => __('Four', 'dilaz-metabox')
				),
				'args'  => array( 'select2' => 'select2single' ),
				'std'   => 'normal',
				'class' => ''
			);
			$options[] = array(
				'id'   => 'select_one',
				'name' => __('Default Select Field:', 'dilaz-metabox'),
				'desc' => __('Select the preferred header type', 'dilaz-metabox'),
				'type' => 'select',
				'options' => array( 
					'one'   => __('One', 'dilaz-metabox'), 
					'two'   => __('Two', 'dilaz-metabox'),
					'three' => __('Three', 'dilaz-metabox'),
					'four'  => __('Four', 'dilaz-metabox')
				),
				'std'   => 'normal',
				'class' => ''
			);
			
	# TAB - Conditionals
	# =============================================================================================
	$options[] = array(
		'name' => __('Conditionals', 'dilaz-metabox'),
		'type' => 'heading',
		'icon' => 'fa-toggle-on'
	);
		
		# SUB TAB - Conditionals
		# *****************************************************************************************
		// $options[] = array(
			// 'name' => __('Conditionals', 'dilaz-metabox'),
			// 'type' => 'subheading',
		// );
			
			# FIELDS - Conditional options
			# >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
			$options[] = array(
				'id'	  => 'continent',
				'name'	  => __('Continent:', 'dilaz-metabox'),
				'desc'	  => '',
				'type'	  => 'select',
				'options' => array(
					''   => __('Select Continent', 'dilaz-metabox'),
					'eu' => __('Europe', 'dilaz-metabox'),
					'na' => __('North America', 'dilaz-metabox'),
				),
				'std'  => 'default',
				'args' => array('inline' => true),
			);
			$options[] = array(
				'id'      => 'eu_country',
				'name'    => __('Europe Country:', 'dilaz-metabox'),
				'desc'    => '',
				'type'    => 'radio',
				'options' => array(
					'de' => __('Germany', 'dilaz-metabox'),
					'gb' => __('United Kingdom', 'dilaz-metabox'),
				),
				'std'      => 'default',
				'args'     => array('inline' => true),
				'req_args' => array(
					'continent' => 'eu'
				),
				'req_action' => 'show',
			);
			$options[] = array(
				'id'      => 'na_country',
				'name'    => __('North America Country:', 'dilaz-metabox'),
				'desc'    => '',
				'type'    => 'radio',
				'options' => array(
					'us' => __('United States', 'dilaz-metabox'),
					'ca' => __('Canada', 'dilaz-metabox'),
				),
				'std'      => 'default',
				'args'     => array('inline' => true),
				'req_args' => array(
					'continent' => 'na'
				),
				'req_cond'   => 'AND',
				'req_action' => 'show',
			);
			$options[] = array(
				'id'      => 'de_division',
				'name'    => __('Germany Division:', 'dilaz-metabox'),
				'desc'    => '',
				'type'    => 'multicheck',
				'options' => array(
					'hh' => __('Hamburg', 'dilaz-metabox'),
					'be' => __('Berlin', 'dilaz-metabox'),
					'sh' => __('Schleswig-Holstein', 'dilaz-metabox'),
				),
				'std'      => 'default',
				'args'     => array('inline' => true),
				'req_args' => array(
					'continent'  => 'eu',
					'eu_country' => 'de'
				),
				'req_cond'   => 'AND',
				'req_action' => 'show',
			);
			$options[] = array(
				'id'      => 'gb_division',
				'name'    => __('United Kingdom Division:', 'dilaz-metabox'),
				'desc'    => '',
				'type'    => 'multicheck',
				'options' => array(
					'abd' => __('Aberdeen City', 'dilaz-metabox'),
					'bir' => __('Birmingham', 'dilaz-metabox'),
					'lce' => __('Leicester', 'dilaz-metabox'),
					'man' => __('Manchester', 'dilaz-metabox'),
				),
				'std'      => 'default',
				'args'     => array('inline' => true),
				'req_args' => array(
					'continent'  => 'eu',
					'eu_country' => 'gb'
				),
				'req_cond'   => 'AND',
				'req_action' => 'show',
			);
			$options[] = array(
				'id'      => 'us_division',
				'name'    => __('US State:', 'dilaz-metabox'),
				'desc'    => '',
				'type'    => 'multicheck',
				'options' => array(
					'wa' => __('Washington', 'dilaz-metabox'),
					'oh' => __('Ohio', 'dilaz-metabox'),
					'mt' => __('Montana', 'dilaz-metabox'),
					'ga' => __('Georgia', 'dilaz-metabox'),
				),
				'std'      => 'default',
				'args'     => array('inline' => true),
				'req_args' => array(
					'continent'  => 'na',
					'na_country' => 'us'
				),
				'req_cond'   => 'AND',
				'req_action' => 'show',
			);
			$options[] = array(
				'id'      => 'us_division',
				'name'    => __('Canada Division:', 'dilaz-metabox'),
				'desc'    => '',
				'type'    => 'multicheck',
				'options' => array(
					'on' => __('Ontario', 'dilaz-metabox'),
					'sk' => __('Saskatchewan', 'dilaz-metabox'),
					'qc' => __('Quebec', 'dilaz-metabox'),
				),
				'std'      => 'default',
				'args'     => array('inline' => true),
				'req_args' => array(
					'continent'  => 'na',
					'na_country' => 'ca'
				),
				'req_cond'   => 'AND',
				'req_action' => 'show',
			);
		
	return $options;
}