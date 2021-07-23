# Dilaz Panel
Simple WordPress options panel for themes and plugins.

Feel free to use this admin panel in your __premium__ and __commercial__ projects.

![Demo Screenshot](https://github.com/Rodgath/DilazResources/blob/master/Dilaz-Panel/main-dilaz-panel.png "Demo Screenshot")

## How to use
1. Download and install [Dilaz Panel](https://github.com/Rodgath/Dilaz-Panel/archive/master.zip) plugin.
2. Download [Dilaz Panel Options](https://github.com/Rodgath/Dilaz-Panel-Options) and add it into your WordPress project *(theme or plugin)*. 

## Example of how to use Dilaz Panel in a theme
Download and install [n00b Starter Theme](https://github.com/Rodgath/n00b-Theme) to see a useful example on how to integrate this *dilaz panel* into your WordPress theme development project.

## Features
* __Fault Tolerant__ - Continues to working effectively even when a component is faulty.
* __Backward Compatible__ - Fairly interoperable with WP older legacy versions and your own option settings.
* __Extendability__ - Easy to update or create new functionality. Future growth considered. 
* __Reliability__ - Full operational under stated WP conditions. No surprises.
* __Maintainability__ - Easy to maintain, update, correct defects or repair faulty parts.
* __Easy updating__ - Your settings will not be part of core files. 
* __AddOns availability__ - AddOns created by other software developers.
* __Both Plugins & Themes__ - Can be used with any WordPress theme or plugin.

## Metabox Fields
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

## File Structure
```
wp-content/plugins/dilaz-panel/  # → Dilaz panel root directory
├── assets/                      # → Plugin ssets
│   ├── css/                     # → Stylesheets
│   ├── fonts/                   # → Fonts
│   ├── images/                  # → Images
│   └── js/                      # → JavaScripts
├── includes/                    # → Includes
│   ├── defaults.php             # → Defaults (never edit)
│   ├── export.php               # → Export and Import file for panel options (never edit)
│   ├── fields.php               # → Panel option fields (never edit)
│   └── functions.php            # → Panel functions (never edit)
└── dilaz-panel.php              # → Index file (never edit)
```

## Download 

To get a local working copy of the development repository, do:

    git clone https://github.com/Rodgath/Dilaz-Panel.git

Alternatively, you can download the latest development version as a tarball
as follows:

    wget --content-disposition https://github.com/Rodgath/Dilaz-Panel/tarball/master

OR 

    curl -LJO https://github.com/Rodgath/Dilaz-Panel/tarball/master
    
 
