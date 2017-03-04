<?php

add_filter('dilaz_panel_options_filter', 'dilaz_panel_default_options');
function dilaz_panel_default_options( array $options ) {
	
	# MAIN TAB - General Settings
	# =============================================================================================
	$options[] = array(
		'name' => __('General Options', 'dilaz-options'),
		'type' => 'heading',
		'icon' => 'fa-home'
	);
		
		# SUB TAB - Simple Options Set
		# *****************************************************************************************
		// $options[] = array(
			// 'name' => __('General', 'dilaz-options'),
			// 'type' => 'subheading',
		// );
			
			# FIELDS - Alpha Tab 1
			# >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
			$options[] = array(
				'id'   => 'range',
				'name' => __('Range:', 'dilaz-metabox'),
				'desc' => __('Estimated calendar date for completing this project. (Optional)', 'dilaz-metabox'),
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
				'name'  => __('Slider', 'dilaz-options'),
				'desc'  => __('Logo top margin value', 'dilaz-options'),
				'type'  => 'slider',
				'args'  => array('min' => 8, 'max' => 100, 'step' => 2, 'suffix' => '%'),
				'std'   => '40',
				'class' => ''
			);
			$options[] = array(
				'id'   => 'switchenable',
				'name' => __('Switch Enable/Disable', 'dilaz-options'),
				'desc' => __('Enable/disable automatically feed links in the <code>&lt;head&gt;</code> section.', 'dilaz-options'),
				'type' => 'switch',
				'options' => array(
					'enable'  => __('Enable', 'dilaz-options'), 
					'disable' => __('Disable', 'dilaz-options'),
				),
				'std'  => 'disable',
				'class' => ''
			);
			$options[] = array(
				'id'   => 'switch',
				'name' => __('Switch', 'dilaz-options'),
				'desc' => __('Enable/disable automatically feed links in the <code>&lt;head&gt;</code> section.', 'dilaz-options'),
				'type' => 'switch',
				'options' => array(
					1 => __('On', 'dilaz-options'), 
					0 => __('Off', 'dilaz-options'),
				),
				'std'  => 0,
				'class' => ''
			);
			$options[] = array(
				'id'   => 'buttonset',
				'name' => __('Button Set', 'dilaz-options'),
				'desc' => __('Enable/disable automatically feed links in the <code>&lt;head&gt;</code> section.', 'dilaz-options'),
				'type' => 'buttonset',
				'options' => array(
					'yes'   => __('Yes', 'dilaz-options'), 
					'no'    => __('No', 'dilaz-options'),
					'maybe' => __('Maybe', 'dilaz-options')
				),
				'std'  => 'no',
				'class' => ''
			);
			$options[] = array(
				'id'   => 'background',
				'name' => __('Background', 'dilaz-options'),
				'desc' => __('The global text style.', 'dilaz-options'),
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
				'id'   => 'font',
				'name' => __('Font', 'dilaz-options'),
				'desc' => __('The global text style.', 'dilaz-options'),
				'type' => 'font',
				'options' => array( 
					// 'face'   => $typography_mixed_fonts, 
					'size'   => false, 
					'height' => false, 
					'style'  => false, 
					'case'   => false, 
					'color'  => false
				),
				'class' => ''
			);
			$options[] = array(
				'id'    => 'textarea',
				'name'  => __('Textarea', 'dilaz-options'),
				'desc'  => __('Enter your top info content, HTML tags are allowed.', 'dilaz-options'),
				'type'  => 'textarea',
				'args'  => array('rows' => 5),
				'std'   => 'Textarea content goes here.',
				'class' => ''
			);
	
	# MAIN TAB - Media Options
	# =============================================================================================
	$options[] = array(
		'name' => __('Media Options', 'dilaz-options'),
		'type' => 'heading',
		'icon' => 'fa-home'
	);
		
		# SUB TAB - Image
		# *****************************************************************************************
		$options[] = array(
			'name' => __('Image', 'dilaz-options'),
			'type' => 'subheading',
		);
			
			# FIELDS - Image options
			# >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
			$options[] = array(
				'id'   => 'image_multiple',
				'name' => __('Image File (Multiple):', 'dilaz-metabox'),
				'desc' => __('Upload or paste URL to the .ogv video file. The OGV format is a video OGG.', 'dilaz-metabox'),
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
				'desc' => __('Upload or paste URL to the .ogv video file. The OGV format is a video OGG.', 'dilaz-metabox'),
				'type' => 'upload',
				'std'  => '',
				'args' => array(
					'file_type' => 'image',
				),
			);
		
		# SUB TAB - Audio
		# *****************************************************************************************
		$options[] = array(
			'name' => __('Audio', 'dilaz-options'),
			'type' => 'subheading',
		);
			
			# FIELDS - Audio options
			# >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
			$options[] = array(
				'id'   => 'audio_multiple',
				'name' => __('Audio File (Multiple):', 'dilaz-metabox'),
				'desc' => __('Upload or paste URL to the .ogv video file. The OGV format is a video OGG.', 'dilaz-metabox'),
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
				'desc' => __('Upload or paste URL to the .ogv video file. The OGV format is a video OGG.', 'dilaz-metabox'),
				'type' => 'upload',
				'std'  => '',
				'args' => array(
					'file_type' => 'audio',
				),
			);
		
		# SUB TAB - Video
		# *****************************************************************************************
		$options[] = array(
			'name' => __('Video', 'dilaz-options'),
			'type' => 'subheading',
		);
			
			# FIELDS - Video options
			# >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
			$options[] = array(
				'id'   => 'video_multiple',
				'name' => __('Video File (Multiple):', 'dilaz-metabox'),
				'desc' => __('Upload or paste URL to the .ogv video file. The OGV format is a video OGG.', 'dilaz-metabox'),
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
				'desc' => __('Upload or paste URL to the .ogv video file. The OGV format is a video OGG.', 'dilaz-metabox'),
				'type' => 'upload',
				'std'  => '',
				'args' => array(
					'file_type' => 'video',
				),
			);
	
	# MAIN TAB - Color Options
	# =============================================================================================
	$options[] = array(
		'name' => __('Color Options', 'dilaz-options'),
		'type' => 'heading',
		'icon' => 'fa-home'
	);
		
		# SUB TAB - Color
		# *****************************************************************************************
		// $options[] = array(
			// 'name' => __('Color', 'dilaz-options'),
			// 'type' => 'subheading',
		// );
			
			# FIELDS - Color options
			# >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
			$options[] = array(
				'id'   => 'link',
				'name' => __('Link Example:', 'dilaz-options'),
				'desc' => __('Set the menu link color properties.', 'dilaz-options'),
				'type' => 'multicolor',
				'options' => array(
					'regular' => array('color' => '#111111', 'name' => __('Regular', 'dilaz-options')),
					'hover'   => array('color' => '#333333', 'name' => __('Hover', 'dilaz-options')),
					'visited' => array('color' => '#555555', 'name' => __('Visited', 'dilaz-options')),
					'active'  => array('color' => '#999999', 'name' => __('Active', 'dilaz-options')),
				),
			);
			$options[] = array(
				'id'   => 'multicolor',
				'name' => __('Multicolor:', 'dilaz-options'),
				'desc' => __('Set the menu link color properties.', 'dilaz-options'),
				'type' => 'multicolor',
				'options' => array(
					'color1' => array('color' => '#111111', 'name' => __('Color 1', 'dilaz-options')),
					'color2' => array('color' => '#333333', 'name' => __('Color 2', 'dilaz-options')),
					'color3' => array('color' => '#555555', 'name' => __('Color 3', 'dilaz-options')),
					'color4' => array('color' => '#777777', 'name' => __('Color 4', 'dilaz-options')),
					'color5' => array('color' => '#999999', 'name' => __('Color 4', 'dilaz-options')),
				),
			);
			$options[] = array(
				'id'   => 'color',
				'name' => __('Color', 'dilaz-options'),
				'desc' => __('Select a color for global color scheme.', 'dilaz-options'),
				'type' => 'color', 
				'std'  => '#ff2211',
				'class' => ''
			);
	
	# MAIN TAB - Choice Options
	# =============================================================================================
	$options[] = array(
		'name' => __('Choice Options', 'dilaz-options'),
		'type' => 'heading',
		'icon' => 'fa-home'
	);
		
		# SUB TAB - Choice
		# *****************************************************************************************
		// $options[] = array(
			// 'name' => __('Choice', 'dilaz-options'),
			// 'type' => 'subheading',
		// );
			
			# FIELDS - Choice options
			# >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
			$options[] = array(
				'id'   => 'radioimage',
				'name' => __('Radio Image', 'dilaz-options'),
				'desc' => __('Select the preferred layout type.', 'dilaz-options'),
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
				'name' => __('Radio', 'dilaz-options'),
				'desc' => __('Select the preferred layout type.', 'dilaz-options'),
				'type' => 'radio',
				'options' => array(
					'one'   => __('One', 'dilaz-options'), 
					'two'   => __('Two', 'dilaz-options'),
					'three' => __('Three', 'dilaz-options')
				),
				'std'   => 'two',
				'class' => ''
			);
			$options[] = array(
				'id'   => 'multicheck',
				'name' => __('Multicheck', 'dilaz-options'),
				'desc' => __('Select the preferred layout type.', 'dilaz-options'),
				'type' => 'multicheck',
				'options' => array(
					'one'   => __('One', 'dilaz-options'), 
					'two'   => __('Two', 'dilaz-options'),
					'three' => __('Three', 'dilaz-options')
				),
				'std'   => 'two',
				'class' => ''
			);
			$options[] = array(
				'id'    => 'checkbox',
				'name'  => __('Checkbox', 'dilaz-options'),
				'desc'  => __('Select the preferred layout type.', 'dilaz-options'),
				'type'  => 'checkbox',
				'std'   => 0,
				'class' => ''
			);
			$options[] = array(
				'id'   => 'term_select',
				'name' => __('Term Select:', 'dilaz-metabox'),
				'desc' => '',
				'type' => 'queryselect',
				'std'  => '',
				'args' => array(
					'select2'     => 'select2multiple',
					'query_type'  => 'term',
					'placeholder' => __('Select category', 'dilaz-metabox'),
					'width'       => '50%',
					'min_input'   => 1,
					'max_input'   => 100,
					'max_options' => 10,
					'query_args'  => array(
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
					'select2'     => 'select2multiple',
					'query_type'  => 'user',
					'placeholder' => __('Select user', 'dilaz-metabox'),
					'width'       => '50%',
					'min_input'   => 1,
					'max_input'   => 100,
					'max_options' => 10,
					'query_args'  => array(
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
					'select2'     => 'select2multiple',
					'query_type'  => 'post',
					'placeholder' => __('Type to select a post', 'dilaz-metabox'),
					'width'       => '50%',
					'min_input'   => 1,
					'max_input'   => 100,
					'max_options' => 10,
					'query_args'  => array(
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
				'name' => __('"Select2" Multi-Select Field', 'dilaz-options'),
				'desc' => __('Select the preferred header type', 'dilaz-options'),
				'type' => 'multiselect',
				'options' => array( 
					'one'   => __('One', 'dilaz-options'), 
					'two'   => __('Two', 'dilaz-options'),
					'three' => __('Three', 'dilaz-options'),
					'four'  => __('Four', 'dilaz-options')
				),
				'args'  => array( 'select2' => 'select2multiple' ),
				'std'   => 'normal',
				'class' => ''
			);
			$options[] = array(
				'id'   => 'select_multiple_one',
				'name' => __('Default Milti-Select Field', 'dilaz-options'),
				'desc' => __('Select the preferred header type', 'dilaz-options'),
				'type' => 'multiselect',
				'options' => array( 
					'one'   => __('One', 'dilaz-options'), 
					'two'   => __('Two', 'dilaz-options'),
					'three' => __('Three', 'dilaz-options'),
					'four'  => __('Four', 'dilaz-options')
				),
				'std'   => 'normal',
				'class' => ''
			);
			$options[] = array(
				'id'   => 'select_two',
				'name' => __('"Select2" Select Field', 'dilaz-options'),
				'desc' => __('Select the preferred header type', 'dilaz-options'),
				'type' => 'select',
				'options' => array( 
					'one'   => __('One', 'dilaz-options'), 
					'two'   => __('Two', 'dilaz-options'),
					'three' => __('Three', 'dilaz-options'),
					'four'  => __('Four', 'dilaz-options')
				),
				'args'  => array( 'select2' => 'select2single' ),
				'std'   => 'normal',
				'class' => ''
			);
			$options[] = array(
				'id'   => 'select_one',
				'name' => __('Default Select Field', 'dilaz-options'),
				'desc' => __('Select the preferred header type', 'dilaz-options'),
				'type' => 'select',
				'options' => array( 
					'one'   => __('One', 'dilaz-options'), 
					'two'   => __('Two', 'dilaz-options'),
					'three' => __('Three', 'dilaz-options'),
					'four'  => __('Four', 'dilaz-options')
				),
				'std'   => 'normal',
				'class' => ''
			);
	
	return $options;
}