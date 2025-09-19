# CHANGELOG

## Version 3

###### v3.0.3 - Sep 19, 2025
```
= FIXED - Theme URI when child theme is in use
```

###### v3.0.2 - Aug 2, 2025
```
= IMPROVED - Increased font sizes for the field 'Name' and field 'Description'
```

###### v3.0.1 - Apr 1, 2025
```
= UPDATED - New saving/resetting AJAX style
= FIXED - 'queryselect' field std(default) value setup
= FIXED - Minor bugs
```

###### v3.0.0 - Feb 3, 2024
```
= ADDED - PHP Namespace to fix conflict issues when multiple themes/plugins are using Dilaz Panel in the same WP installation
```

## Version 2

###### v2.8.43 - Aug 15, 2023
```
= FIXED: Creation of dynamic property DilazPanel::$args is deprecated
= FIXED: Deprecated: trim(): Passing null to parameter #1 ($string) of type string is deprecated
```
###### v2.8.42 - Aug 14, 2022
```
= UPDATED - sellect2 JS library
= ADDED - select2 package.json file to fix XSS potential security issue
= FIXED - "querySelect" field bugs
= FIXED - "queryselect" & "range" fields' sanitization
= FIXED - Other minor PHP bugs
= UPDATED - Readme
```
###### v2.8.41 - Jun 1, 2021
```
= UPDATED - changed update checker path
```
###### v2.8.4 - Aug 8, 2019
```
= IMPROVED - upload field saving error
= IMPROVED - background field error
= ADDED - 'item_url' integration in panel parameters
```
###### v2.8.3 - Jul 23, 2019
```
= FIXED - js AJAX error on saveoptions caused by WP Editor frame with empty content
= FIXED - font subset sanitization error
= FIXED - radioimage field - image width extends beyond panel layout
= UPDATED - section 'id' bug fix for info section
= UPDATED - section 'class' bug fix for info section
= IMPROVED - radioimage field - we can now use 'alt' and 'src' attributes separately
```
###### v2.8.2 - Jul 1, 2019
```
= FIXED - Repeatable field error
= FIXED - WP custom editor sanitization when saving
= FIXED - media upload field display bugs
= UPDATED - fieldEditor method in DilazPanelFields class
= IMPROVED - fieldFonts with multiple selector for font subsets
= MOVED - DilazPanelFunctions class into DilazPanel init()
= ADDED - code field
= ADDED - new init() method for DilazPanel class
= ADDED - Ability to load Google fonts in frontend using loadGoogleFonts() method
= ADDED - $savedGFonts parameter
= ADDED - Google fonts preload helper script: googlefonts.3perf.com
= ADDED - separately saving of all used Google fonts in saveOptions() method
= ADDED - Stacks for font family defaults using _font_family_defaults_stacks() method in DilazPanelDefaults class
```
###### v2.8.1 - Jun 7, 2019
```
= ADDED - editorStyles() method for custom WP editor styles
= ADDED - permissions to 'view' capability for admin bar menu dropdown
= FIXED - IE Method default parameter bug. Its a feature in ES6 not supported by IE, so I converted code to ES5.
```
###### v2.8.0 - Apr 21, 2019
```
= ADDED - Update checker
```
###### v2.7.9 - Apr 16, 2019
```
= FIXED - 'info' field can now be used as child field of any conditional field
```
###### v2.7.8 - Apr 13, 2019
```
= ADDED - 'options_view_cap' capability check to panel display
= ADDED - 'options_save_cap' capability check while saving options
```
###### v2.7.7 - Apr 2, 2019
```
= FIXED - 'multitext' field sanitize option bug
= FIXED - 'queryselect' field sanitize option bug
= FIXED - 'range' field sanitize option bug
= FIXED - 'multiselect' field sanitize option bug
= FIXED - 'repeatable' field sanitize option bug
= FIXED - 'multicolor' field sanitize option bug
```
###### v2.7.6 - Mar 20, 2019
```
= IMPROVED - saveOptions() method; don't save default options on live site when 'default_options' parameter is set to FALSE
= ADDED - new method 'find_array_key_by_value' to 'DilazPanelFunctions' object
= ADDED - new method 'insert_array_adjacent_to_key' to 'DilazPanelFunctions' object
= ADDED - new method 'unique_multidimensional_array' to 'DilazPanelFunctions' object
= ADDED - new method 'remove_target_tab_fields' to 'DilazPanelFunctions' object
= ADDED - new method 'get_tab_content' to 'DilazPanelFunctions' object
= ADDED - new method 'insert_field' to 'DilazPanelFunctions' object
```
###### v2.7.5 - Mar 11, 2019
```
= FIXED - info box field display issue
```
###### v2.7.4 - Jan 31, 2019
```
= ADDED - Sidebar submenu using add_submenu_page()
```
###### v2.7.3 - Jan 29, 2019
```
= REMOVED - Font Awesome webfont icons for tab icons
= ADDED - Material Design webfont icons for tab icons
= ADDED - Tab content preloader effect
```
###### v2.7.2 - Jan 28, 2019
```
= CHANGED - Renamed DilazPanelScript method from $t.tabMenuOpenFirst to $t.tabMenuOpenHashed
= ADDED - Added $t.adminBarTabMenu method in DilazPanelScript in admin.js
= ADDED - Panel tabs added to admin bar menu drop down in adminBar() method in DilazPanel class
```
###### v2.7.1 - Jan 26, 2019
```
= FIXED - Export settings not working
= FIXED - Description 2 layout
= IMPROVED - Scripts and styles version caching
```
###### v2.7.0 - Jan 16, 2019
```
= ADDED - compatibility with WordPress version 5.x
= REMOVED - reset query argument ?reset=true
= FIXED - reset button and the reset AJAX process
= FIXED - Google fonts undefined error
```
###### v2.6.8 - Jan 14, 2019
```
= ADDED - Google fonts integration
```
###### v2.6.7 - Jan 14, 2019
```
= FIXED - Multiple file upload not working
```
###### v2.6.6 - Jan 14, 2019
```
= ADDED - Font preview background color change based on font text color
= FIXED - Repeatable field saving new option values problem
```
###### v2.6.5 - Jan 14, 2019
```
= FIXED - Font field bugs
= FIXED - Panel attributes were not being updated during options 'Save' and 'Reset'. This is important especially if 'dir_url' changes when admin direcory is changed.
= ADDED - Password field
```
###### v2.6.4 - Jan 14, 2019
```
= ADDED - repeatable field
= IMPROVED - Method, variable and array naming conventions for consistency purposes
```
###### v2.6.3 - Jan 14, 2019
```
= FIXED - multitext field - standard values added to defaultValues() method
```
###### v2.6.2 - Jan 13, 2019
```
= FIXED - Email field
= FIXED - Select2 field ajax problem; All query types work perfectly
= ADDED - Page query type in select2 field; Pages can be queried now
```
###### v2.6.1 - Jan 13, 2019
```
= ADDED - refresh options page after resetting options
```
###### v2.6.0 - Jan 12, 2019
```
= ADDED - new field - WP Editor
```
###### v2.5 - Jan 11, 2019
```
= ADDED - sanitizeParams() method to clean up admin parameters
= ADDED - add_submenu_page() support to allow adding admin menu under a top level parent menu
```
###### v2.4 - Jan 9, 2019
```
= FIXED - multitext field input sanitization
= FIXED - getOptionsFromFile() method errors
= FIXED - saveOptions() method default options saving
= FIXED - _multitext() method errors
```
###### v2.3 - Jan 4, 2019
```
= added multitext field
```
###### v2.2 - Jan 2, 2019
```
= improved code
= removed some bugs
```
###### v2.1 - Dec 19, 2018
```
= ADDED - $option_args as the only parameter in DilazPanel class
= ADDED - panel attributes (panel-atts) to options in DB
= IMPROVED - ajax save to include panel-atts
= IMPROVED - ajax reset to include panel-atts
= UPDATED - ajax export
= UPDATED - ajax import
= REMOVED - unnecessary functional methods and variables from DilazPanel class
```
###### v2.0 - Jan 31, 2018
```
= Add files via upload
```
## Version 1
###### v1.0 - Jan 31, 2018
```
Initial release.
