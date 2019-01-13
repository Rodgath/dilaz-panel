# Dilaz-Panel
Simple WordPress options panel for themes and plugins.
Feel free to use this admin panel in your __premium__ and __commercial__ projects.

## How to use
1. Download and install [Dilaz Panel](https://github.com/Rodgath/Dilaz-Panel-Plugin/archive/master.zip) plugin
2. Download [Dilaz Panel Options](https://github.com/Rodgath/Dilaz-Panel-Options) and add it into your WordPress project. 

## Example of how to use Dilaz Panel in a theme
Download and install [n00b Starter Theme](https://github.com/Rodgath/n00b) to see a useful example on how to integrate this *dilaz panel plugin* into your WordPress theme development project.

## Features
* __Extendability__ - Easy to update or create new functionality 
* __Easy updating__ - Your settings will not be part of core files
* __AddOns availability__ - AddOns created by WebDilaz Team and other developers

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
wp-includes/plugins/dilaz-panel/  # → Dilaz panel plugin
├── assets/                       # → Plugin ssets
│   ├── css/                      # → Stylesheets
│   ├── fonts/                    # → Fonts
│   ├── images/                   # → Images
│   └── js/                       # → JavaScripts
├── includes/                     # → Includes
│   ├── defaults.php              # → Defaults (never edit)
│   ├── export.php                # → Export and Import file for panel options (never edit)
│   ├── fields.php                # → Panel option fields (never edit)
│   └── functions.php             # → Panel functions (never edit)
└── dilaz-panel.php               # → Index file (never edit)
```


