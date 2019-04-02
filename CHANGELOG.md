# CHANGELOG

## Version 2
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
