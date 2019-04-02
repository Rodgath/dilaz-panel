# CHANGELOG

## Version 2
##### v2.7.7
```
= FIXED - 'multitext' field sanitize option bug
= FIXED - 'queryselect' field sanitize option bug
= FIXED - 'range' field sanitize option bug
= FIXED - 'multiselect' field sanitize option bug
= FIXED - 'repeatable' field sanitize option bug
= FIXED - 'multicolor' field sanitize option bug
```
##### v2.7.6
```
= IMPROVED - saveOptions() method; don't save default options on live site when 'default_options' parameter is set to FALSE
= ADDED - new method 'find_array_key_by_value' to 'DilazPanelFunctions' object
= ADDED - new method 'insert_array_adjacent_to_key' to 'DilazPanelFunctions' object
= ADDED - new method 'unique_multidimensional_array' to 'DilazPanelFunctions' object
= ADDED - new method 'remove_target_tab_fields' to 'DilazPanelFunctions' object
= ADDED - new method 'get_tab_content' to 'DilazPanelFunctions' object
= ADDED - new method 'insert_field' to 'DilazPanelFunctions' object
```
#### v2.7.5
```
= FIXED - info box field display issue
```
#### v2.7.4
```
= ADDED - Sidebar submenu using add_submenu_page()
```
#### v2.7.3
```
= REMOVED - Font Awesome webfont icons for tab icons
= ADDED - Material Design webfont icons for tab icons
= ADDED - Tab content preloader effect
```
#### v2.7.2
```
= CHANGED - Renamed DilazPanelScript method from $t.tabMenuOpenFirst to $t.tabMenuOpenHashed 
= ADDED - Added $t.adminBarTabMenu method in DilazPanelScript in admin.js
= ADDED - Panel tabs added to admin bar menu drop down in adminBar() method in DilazPanel class
```
#### v2.7.1
```
= FIXED - Export settings not working
= FIXED - Description 2 layout
= IMPROVED - Scripts and styles version caching
```
#### v2.7.0
```
= ADDED - compatibility with WordPress version 5.x
= REMOVED - reset query argument ?reset=true
= FIXED - reset button and the reset AJAX process
= FIXED - Google fonts undefined error
```
#### v2.6.8
```
= ADDED - Google fonts integration
```
#### v2.6.7
```
= FIXED - Multiple file upload not working
```
#### v2.6.6
```
= ADDED - Font preview background color change based on font text color
= FIXED - Repeatable field saving new option values problem
```
#### v2.6.5
```
= FIXED - Font field bugs
= FIXED - Panel attributes were not being updated during options 'Save' and 'Reset'. This is important especially if 'dir_url' changes when admin direcory is changed.
= ADDED - Password field
```
#### v2.6.4
```
= ADDED - repeatable field
= IMPROVED - Method, variable and array naming conventions for consistency purposes
```
#### v2.6.3
```
= FIXED - multitext field - standard values added to defaultValues() method
```
#### v2.6.2
```
= FIXED - Email field
= FIXED - Select2 field ajax problem; All query types work perfectly
= ADDED - Page query type in select2 field; Pages can be queried now
```
#### v2.6.1
```
= ADDED - refresh options page after resetting options
```
#### v2.6
```
= added new field - WP Editor
```
#### v2.5
```
= added sanitizeParams() method to clean up admin parameters
= added add_submenu_page() support to allow adding admin menu under a top level parent menu
```
#### v2.4
```
= fixed multitext field input sanitization
= fixed getOptionsFromFile() method errors
= fixed saveOptions() method default options saving
= fixed _multitext() method errors
```
#### v2.3
```
= added multitext field
```
#### v2.2
```
= improved code
= removed some bugs
```
#### v2.1
```
= added $option_args as the only parameter in DilazPanel class
= added panel attributes (panel-atts) to options in DB
= Improved ajax save to include panel-atts
= Improved ajax reset to include panel-atts
= Updated ajax export
= Updated ajax import
= Removed unnecessary functional methods and variables from DilazPanel class
```
## Version 1
#### v1.0
```
Initial release.
