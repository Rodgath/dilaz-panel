# Dilaz-Panel
Simple WordPress options panel for themes and plugins.

Feel free to use this admin panel in your __premium__ and __commercial__ projects.

## Features
* Extendability - Easy to update or create new functionality 
* Easy updating - Your settings will not be part of core files
* AddOns availability - AddOns created by WebDilaz Team and other developers

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
your-directory/your-admin-folder/     # → Root of your admin panel
├── assets/                           # → Assets
│   ├── css/                          # → Stylesheets
│   ├── fonts/                        # → Fonts
│   ├── images/                       # → Images
│   └── js/                           # → JavaScripts
├── includes/                         # → Includes
│   ├── config-sample.php             # → Sample config file - Rename to "config.php"
│   ├── export.php                    # → Export and Import file for panel options (never edit)
│   ├── fields.php                    # → Panel option fields (never edit)
│   └── functions.php                 # → Panel functions (never edit)
├── options/                          # → Panel Options
│   ├── custom-options-sample.php     # → Sample custom options - Rename to custom-options.php
│   ├── default-options.php           # → Default options (never edit)
│   └── options-sample.php            # → Sample options file - Rename to options.php
└── index.php                         # → Index file (never edit)
```


