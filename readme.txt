=== Dilaz Panel ===
Contributors: Rodgath
Tags: options, settings, options panel, admin panel, admin options, theme settings, theme options, plugin settings, plugin options, customization, configuration,
Requires at least: 5.0
Tested up to: 6.3
Stable tag: 2.8.43
Requires PHP: 5.6
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Elevate your WordPress themes and plugins with the power of Dilaz Panel – an intuitive, versatile, and feature-rich options/settings panel that enhances the control and customization of your WordPress projects.

== Description ==

Dilaz Panel revolutionizes the way you handle settings and options for your WordPress themes and plugins. With its seamless integration and user-friendly interface, you can effortlessly create and manage various configuration options, ensuring a tailored and immersive user experience.

_**Note:** Before installation, ensure that your theme or plugin is designed to integrate with Dilaz Panel. This is because Dilaz Panel serves as an options framework and it needs to be integrated to your chosen theme or plugin. Instructions are provided in [Dilaz Panel Options](https://github.com/Rodgath/dilaz-panel-options) page._

#### Illustrative Implementation (Geared towards Developers)

1. **In a theme**: Checkout [Demo Theme](https://github.com/Rodgath/Dilaz-Demo-Theme) to see an example on how to integrate this **dilaz panel** into your WordPress theme.
2. **In a plugin**:  Checkout [Demo Plugin](https://github.com/Rodgath/Dilaz-Demo-Plugin) to see an example on how to integrate this **dilaz panel** into your WordPress plugin.


### General Features:

Dilaz Panel stands out as the go-to solution for options and settings management due to its exceptional features:

* __Fault Tolerant__ - Even in the presence of faulty components, Dilaz Panel remains operational, ensuring consistent functionality.
* __Backward Compatible__ - Compatible with older versions of WordPress and your legacy option settings, making the transition smooth and seamless.
* __Extendability__ - Designed for easy updates and the addition of new features, ensuring that your panel remains adaptable to future needs.
* __Reliability__ - Operational under a wide range of WordPress conditions, offering predictability and consistency without surprises.
* __Maintainability__ - Effortlessly maintain, update, fix defects, or repair faulty components, minimizing downtime and maximizing efficiency.
* __Easy updating__ - Your settings remain separate from core files, simplifying the updating process without disrupting your customizations.
* __AddOns availability__ - Harness the power of hooks and filters to create AddOns that extend Dilaz Panel's capabilities, ensuring endless possibilities.
* __Both Plugins & Themes__ - Whether you're working on a WordPress theme or plugin, Dilaz Panel seamlessly integrates to enhance customization.


### Option Fields
Dilaz Panel offers an extensive array of option fields to cater to your diverse needs:

* Heading
* Sub-heading
* Info
* Text
* Textarea
* Dropdown Select
* Multiselect/Multiple Select
* Post Select
* Term/Taxonomy/Category Select
* User Select
* Radio Select
* Image Select
* Button & Buttonset
* Switch Buttons
* Checkbox
* Multicheck/Multiple Checkboxes
* Slider Select
* Range Slider Select
* Color Picker
* Multiple Color Picker
* Font Select
* File Upload - *Image, Audio, Video, Document, Spreadsheet, Interactive, Text, Archive, Code*
* Background Select
	* Files - *Image, Audio, Video, Document, Spreadsheet, Interactive, Text, Archive, Code*
	* Attributes - *Size, Repeat, Position, Attachment, Origin, Color*
* WordPress Editor
* Import
* Export

= Please Vote On This Plugin =
Your feedback and votes make a difference. Thank you for choosing Dilaz Panel to enhance your WordPress experience.

== Installation ==
Follow these steps to integrate Dilaz Panel into your WordPress project:

1. Download and unzip the latest release zip file.
2. Using WordPress plugin uploader, upload **dilaz-panel.zip** plugin zip file to your WordPress site OR upload the entire plugin directory `'dilaz-panel'` to the `'/wp-content/plugins/'` directory.
3. Activate the plugin through the 'Plugins' menu in WordPress administration panel.

== Frequently Asked Questions ==

= How do I use Dilaz Panel in my theme? =
To integrate Dilaz Panel into your theme, utilize [Dilaz Panel Options](https://github.com/Rodgath/dilaz-panel-options) and incorporate it into your WordPress theme to define your custom setting parameters. For a practical example, refer to the [Demo Theme](https://github.com/Rodgath/Dilaz-Demo-Theme).

= How do I use Dilaz Panel in my plugin? =
Checkout [Demo Plugin](https://github.com/Rodgath/Dilaz-Demo-Plugin) to see an example on how to To integrate Dilaz Panel into your plugin, utilize [Dilaz Panel Options](https://github.com/Rodgath/dilaz-panel-options) and incorporate it into your WordPress plugin to define your custom setting parameters. For a practical example, refer to the [Demo Plugin](https://github.com/Rodgath/Dilaz-Demo-Plugin).

== Screenshots ==

1.

== Changelog ==

#### v2.8.43
FIX: Creation of dynamic property DilazPanel::$args is deprecated
FIX: Deprecated: trim(): Passing null to parameter #1 ($string) of type string is deprecated

#### v2.8.42
UPDATED - sellect2 JS library
ADDED - select2 package.json file to fix XSS potential security issue
FIXED - "querySelect" field bugs
FIXED - "queryselect" & "range" fields' sanitization
FIXED - Other minor PHP bugs
UPDATED - Readme

#### v2.8.41
UPDATED - changed update checker path

#### v2.8.4
IMPROVED - upload field saving error
IMPROVED - background field error
ADDED - 'item_url' integration in panel parameters

#### v2.8.3
FIXED - js AJAX error on saveoptions caused by WP Editor frame with empty content
FIXED - font subset sanitization error
FIXED - radioimage field - image width extends beyond panel layout
UPDATED - section 'id' bug fix for info section
UPDATED - section 'class' bug fix for info section
IMPROVED - radioimage field - we can now use 'alt' and 'src' attributes separately

#### v2.8.2
FIXED - Repeatable field error
FIXED - WP custom editor sanitization when saving
FIXED - media upload field display bugs
UPDATED - fieldEditor method in DilazPanelFields class
IMPROVED - fieldFonts with multiple selector for font subsets
MOVED - DilazPanelFunctions class into DilazPanel init()
ADDED - code field
ADDED - new init() method for DilazPanel class
ADDED - Ability to load Google fonts in frontend using loadGoogleFonts() method
ADDED - $savedGFonts parameter
ADDED - Google fonts preload helper script: googlefonts.3perf.com
ADDED - separately saving of all used Google fonts in saveOptions() method
ADDED - Stacks for font family defaults using _font_family_defaults_stacks() method in DilazPanelDefaults class

#### v2.8.1
ADDED - editorStyles() method for custom WP editor styles
ADDED - permissions to 'view' capability for admin bar menu dropdown
FIXED - IE Method default parameter bug. Its a feature in ES6 not supported by IE, so I converted code to ES5.

#### v2.8.0
ADDED - Update checker

#### v2.7.9
FIXED - 'info' field can now be used as child field of any conditional field

#### v2.7.8
ADDED - 'options_view_cap' capability check to panel display
ADDED - 'options_save_cap' capability check while saving options

#### v2.7.7
FIXED - 'multitext' field sanitize option bug
FIXED - 'queryselect' field sanitize option bug
FIXED - 'range' field sanitize option bug
FIXED - 'multiselect' field sanitize option bug
FIXED - 'repeatable' field sanitize option bug
FIXED - 'multicolor' field sanitize option bug

#### v2.7.6
IMPROVED - saveOptions() method; don't save default options on live site when 'default_options' parameter is set to FALSE
ADDED - new method 'find_array_key_by_value' to 'DilazPanelFunctions' object
ADDED - new method 'insert_array_adjacent_to_key' to 'DilazPanelFunctions' object
ADDED - new method 'unique_multidimensional_array' to 'DilazPanelFunctions' object
ADDED - new method 'remove_target_tab_fields' to 'DilazPanelFunctions' object
ADDED - new method 'get_tab_content' to 'DilazPanelFunctions' object
ADDED - new method 'insert_field' to 'DilazPanelFunctions' object

#### v2.7.5
FIXED - info box field display issue

#### v2.7.4
ADDED - Sidebar submenu using add_submenu_page()

#### v2.7.3
REMOVED - Font Awesome webfont icons for tab icons
ADDED - Material Design webfont icons for tab icons
ADDED - Tab content preloader effect

#### v2.7.2
CHANGED - Renamed DilazPanelScript method from $t.tabMenuOpenFirst to $t.tabMenuOpenHashed
ADDED - Added $t.adminBarTabMenu method in DilazPanelScript in admin.js
ADDED - Panel tabs added to admin bar menu drop down in adminBar() method in DilazPanel class

#### v2.7.1
FIXED - Export settings not working
FIXED - Description 2 layout
IMPROVED - Scripts and styles version caching

#### v2.7.0
ADDED - compatibility with WordPress version 5.x
REMOVED - reset query argument ?reset=true
FIXED - reset button and the reset AJAX process
FIXED - Google fonts undefined error

#### v2.6.8
ADDED - Google fonts integration

#### v2.6.7
FIXED - Multiple file upload not working

#### v2.6.6
ADDED - Font preview background color change based on font text color
FIXED - Repeatable field saving new option values problem

#### v2.6.5
FIXED - Font field bugs
FIXED - Panel attributes were not being updated during options 'Save' and 'Reset'. This is important especially if 'dir_url' changes when admin direcory is changed.
ADDED - Password field

#### v2.6.4
ADDED - repeatable field
IMPROVED - Method, variable and array naming conventions for consistency purposes

#### v2.6.3
FIXED - multitext field - standard values added to defaultValues() method

#### v2.6.2
FIXED - Email field
FIXED - Select2 field ajax problem; All query types work perfectly
ADDED - Page query type in select2 field; Pages can be queried now

#### v2.6.1
ADDED - refresh options page after resetting options

#### v2.6.0
ADDED - new field - WP Editor

#### v2.5
ADDED - sanitizeParams() method to clean up admin parameters
ADDED - add_submenu_page() support to allow adding admin menu under a top level parent menu

#### v2.4
FIXED - multitext field input sanitization
FIXED - getOptionsFromFile() method errors
FIXED - saveOptions() method default options saving
FIXED - _multitext() method errors

#### v2.3
added multitext field

#### v2.2
improved code
removed some bugs

#### v2.1
ADDED - $option_args as the only parameter in DilazPanel class
ADDED - panel attributes (panel-atts) to options in DB
IMPROVED - ajax save to include panel-atts
IMPROVED - ajax reset to include panel-atts
UPDATED - ajax export
UPDATED - ajax import
REMOVED - unnecessary functional methods and variables from DilazPanel class

#### v1.0
Initial release.