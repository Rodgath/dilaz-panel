/**
|| --------------------------------------------------------------------------------------------
|| Panel JS
|| --------------------------------------------------------------------------------------------
||
|| @package		Dilaz Panel
|| @subpackage	Panel
|| @since		Dilaz Panel 2.6.4
|| @author		WebDilaz Team, http://webdilaz.com, http://themedilaz.com
|| @copyright	Copyright (C) 2018, WebDilaz LTD
|| @link		http://webdilaz.com/panel
|| @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
|| 
*/

var DilazPanelScript = new function() {
	
	"use strict";
	
	/**
	 * Global Variables
	 */
	var $t = this;
	var $ = jQuery.noConflict();
	var $doc = $(document);
	
	
	/**
	 * DoWhen start
	 */
	$t.doWhen = function() {
		$doc.doWhen();
	}
	
	/**
	 * Remove panel border bottom on the last item
	 */
	$t.removeBorderBottom = function(tabsContent) {
		if (typeof tabsContent != 'undefined') {
			tabsContent.find('.dilaz-panel-section:visible').first().css({'border-top':'0px'});
		}
	}
	
	/**
	 * Open first submenu item when parent tab is clicked
	 */
	$t.tabMenuOpenFirst = function() {
		/* setTimeout() makes the trigger('click') work; I don't know why */
		setTimeout(function() { 
			$('.dilaz-panel-menu > ul > li:first-of-type > .trigger').trigger('click')
		}, 100);
	}
	
	/**
	 * Panel tabbed menu
	 */
	$t.tabMenu = function() {
		$('.dilaz-panel-menu').on('click', '.trigger', function(e) {
			
			e.preventDefault();
			
			var $this        = $(this),
				$parent      = $this.parent(),
				$tabsNav     = $this.closest('.dilaz-panel-menu'),
				$tabTarget   = $this.attr('href'),
				$tabsContent = $tabsNav.siblings('.dilaz-panel-fields');
				
			/* toggle submenu */
			if ($parent.hasClass('has_children')) {
				
				var $subMenu        = $parent.find('.submenu'),
					$subMenuFirst   = $subMenu.children('li:first'),
					$subMenuTrigger = $subMenuFirst.find('.trigger'),
					$tabTarget      = $subMenuTrigger.attr('href');
					
				$subMenu.slideToggle();
				$subMenuFirst.addClass('active');
				$subMenuFirst.siblings().removeClass('active');
			}
			
			/* highlight active triggers */
			$parent.addClass('active');
			$parent.siblings().removeClass('active');
			
			/* show only current fields */
			$tabsContent.find($tabTarget).show().siblings().hide();
			
			/* remove bottom border for the first panel section */
			$tabsContent.find('.dilaz-panel-section:visible').first().css({'border-top':'0'});
			
			/* hide all opened submenus */
			$parent.siblings().find('.submenu').slideUp();
		});
	}
	
	/**
	 * File upload
	 */
	$t.fileUpload = function() {
		$('.dilaz-panel-file-upload-button').each(function() {
			
			var imageFrame;
			
			$(this).on('click', function(event) {
				
				event.preventDefault();
				
				var options, attachment;
				
				var $self              = $(event.target),
					$fileUpload        = $self.closest('.dilaz-panel-file-upload'),
					$fileWrapper       = $fileUpload.find('.dilaz-panel-file-wrapper'),
					$fileWrapperParent = $fileUpload.parent(),
					$fileId            = $fileWrapper.data('file-id') || '',
					$fileLibrary       = $self.data('file-library') || '',
					$fileFormat        = $self.data('file-format') || '',
					$fileMime          = $self.data('file-mime') || '',
					$fileSpecific      = $self.data('file-specific') || false,
					$fileMultiple      = $self.data('file-multiple') || false,
					$fileType          = $self.data('file-type') || '',
					$fieldType         = $self.data('field-type') || '',
					$frameTitle        = $self.data('frame-title') || '',
					$frameButtonText   = $self.data('frame-button-text') || '',
					$mediaPreview      = $fileWrapperParent.find('.dilaz-panel-media-file');
				
				/* open the frame if it exists */
				if ( imageFrame ) {
					imageFrame.open();
					return;
				}
				
				/* frame settings */
				imageFrame = wp.media({
					title    : $frameTitle,
					multiple : $fileMultiple,
					library  : {	
						type : $fileType
					},
					button : {
						text : $frameButtonText
					}
				});
				
				/* frame select handler */
				imageFrame.on( 'select', function() {
					
					var selection = imageFrame.state().get('selection');
					
					if (!selection)
						return;
					
					/* loop through the selected files */
					selection.each( function(attachment) {
						
						var $type = attachment.attributes.type;
						
						if ($type == 'image') {
							
							/* if uploaded image is smaller than default thumbnail(250 by 250)
							then get the full image url */
							if (attachment.attributes.sizes.thumbnail !== undefined) {
								var $imageSrc = attachment.attributes.sizes.thumbnail.url;
							} else {
								var $imageSrc = attachment.attributes.url;
							}
						}
						
						/* attachment data */
						var $src     = attachment.attributes.url,
							$id      = attachment.id,
							$title   = attachment.attributes.title,
							$caption = attachment.attributes.caption;
							
						var $fileOutput = '';
						
						$fileOutput += '<div class="dilaz-panel-media-file '+ $fileType +'  '+ ($id != '' ? '' : 'empty') +'" id="file-'+ $fileId +'">';
						if ($fieldType == 'background') {
							$fileOutput += '<input type="hidden" name="'+ $fileId +'[image]" id="file_'+ $fileId +'" class="dilaz-panel-file-id upload" value="'+ $id +'">';
							$fileWrapperParent.find('.background-preview').find('.content').css({'background-image':'url('+ $imageSrc +')'});
						} else {
							$fileOutput += '<input type="hidden" name="'+ $fileId +'[]" id="file_'+ $fileId +'" class="dilaz-panel-file-id upload" value="'+ $id +'">';
						}
						$fileOutput += '<div class="filename '+ $fileType +'">'+ $title +'</div>';
						$fileOutput += '<span class="sort ui-sortable-handle"></span>';
						$fileOutput += '<a href="#" class="remove" title="Remove"><i class="fa fa-close"></i></a>';
						
						switch ( $type ) {
							case 'image':
								$fileOutput += '<img src="'+ $imageSrc +'" class="dilaz-panel-file-preview file-image" alt="">';
								break;
								
							case 'audio':
								$fileOutput += '<img src="'+ dilaz_panel_lang.dilaz_panel_images +'media/audio.png" class="dilaz-panel-file-preview file-audio" alt="">';
								break;
								
							case 'video':
								$fileOutput += '<img src="'+ dilaz_panel_lang.dilaz_panel_images +'media/video.png" class="dilaz-panel-file-preview file-video" alt="">';
								break;
								
							case 'document':
								$fileOutput += '<img src="'+ dilaz_panel_lang.dilaz_panel_images +'media/document.png" class="dilaz-panel-file-preview file-document" alt="">';
								break;
								
							case 'spreadsheet':
								$fileOutput += '<img src="'+ dilaz_panel_lang.dilaz_panel_images +'media/spreadsheet.png" class="dilaz-panel-file-preview file-spreadsheet" alt="">';
								break;
								
							case 'interactive':
								$fileOutput += '<img src="'+ dilaz_panel_lang.dilaz_panel_images +'media/interactive.png" class="dilaz-panel-file-preview file-interactive" alt="">';
								break;
								
							case 'text':
								$fileOutput += '<img src="'+ dilaz_panel_lang.dilaz_panel_images +'media/text.png" class="dilaz-panel-file-preview file-text" alt="">';
								break;
								
							case 'archive':
								$fileOutput += '<img src="'+ dilaz_panel_lang.dilaz_panel_images +'media/archive.png" class="dilaz-panel-file-preview file-archive" alt="">';
								break;
								
							case 'code':
								$fileOutput += '<img src="'+ dilaz_panel_lang.dilaz_panel_images +'media/code.png" class="dilaz-panel-file-preview file-code" alt="">';
								break;
								
						}
						
						$fileOutput += '</div>';
						
						if ($fileMultiple == true) {
							$fileWrapper.append($fileOutput);
						} else {
							$fileWrapper.html($fileOutput);
						}
						
					});
				});
				
				/* open frame */
				imageFrame.open();
			});
		});
	}
	
	/**
	 * Remove file
	 */
	$t.removeFile = function() {
		$doc.on('click', '.remove', function(e) {
			
			e.preventDefault();
			
			var $this = $(this);
			
			$this.siblings('input').attr('value', '');
			$this.closest('.dilaz-panel-media-file').slideUp(500);
			setTimeout(function() {
				$this.closest('.dilaz-panel-media-file').remove();
			}, 1000);
			
			return false;
		});
	}
	
	/**
	 * File sorting, drag-and-drop
	 */
	$t.fileSorting = function() {
		$('.dilaz-panel-file-wrapper').each(function() {
			
			var $this     = $(this),
				$multiple = $this.data('file-multiple');
				
			if ($multiple) {
				$this.sortable({
					opacity     : 0.6,
					revert      : true,
					handle      : '.sort',
					cursor      : 'move',
					// axis        : 'y',
					placeholder : 'ui-sortable-placeholder'
				});
				$('.dilaz-panel-file-wrapper').disableSelection();
			}
		});
	}
	
	/**
	 * UI slider setting
	 */
	$t.uiSlider = function() {
		$('.dilaz-panel-slider').each(function() {
			
			var $this = $(this),
				$min  = parseInt($this.data('min')),
				$max  = parseInt($this.data('max')),
				$step = parseInt($this.data('step')),
				$val  = parseInt($this.data('val'));
				
			$this.slider({
				animate : true,
				range   : 'min',
				value   : $val,
				min     : $min,
				max     : $max,
				step    : $step,
				slide   : function( event, ui ) {
					$this.next($val).find('span').text(ui.value);
					$this.siblings('input').val(ui.value);
				},
				change  : function(event, ui) {
					$this.next($val).find('span').text(ui.value);
					$this.siblings('input').val( ui.value);
				}
			});
		});
	}
	
	/**
	 * UI range setting
	 */
	$t.uiRange = function() {
		$('.dilaz-panel-range').each(function() {
			
			var $this      = $(this),
				$minVal    = parseInt($this.data('min-val')),
				$maxVal    = parseInt($this.data('max-val')),
				$min       = parseInt($this.data('min')),
				$max       = parseInt($this.data('max')),
				$step      = parseInt($this.data('step')),
				$range     = $this.find('.dilaz-panel-slider-range'),
				$optMin    = $this.find('#option-min'),
				$optMinVal = $optMin.val(),
				$optMax    = $this.find('#option-max'),
				$optMaxVal = $optMax.val();
				
			$range.slider({
				range  : true,
				min    : $min,
				max    : $max,
				step   : $step,
				values : [ $minVal, $maxVal ],
				slide  : function( event, ui ) {
					$optMin.val(ui.values[0]);
					$optMin.next('.dilaz-panel-min-val').find('.val').text(ui.values[0]);
					$optMax.val(ui.values[1]);
					$optMax.next('.dilaz-panel-max-val').find('.val').text(ui.values[1]);
				}
			});
		});
	}
	
	/**
	 * Select2
	 */
	$t.select2Field = function() {
		$('.select2single, .select2multiple').each(function() {
			
			var $this = $(this);
			
			$this.select2({
				placeholder : '',
				width       : $this.data('width'),
				allowClear  : true,
			});
		});
	}
	
	/**
	 * Ajax DB query select for posts, terms and users
	 */
	$t.querySelectAjax = function() {
		$('.dilaz-panel-query-select').each(function() {
			
			var $this = $(this);
			
			$this.select2({
				language : 'en',
				placeholder : $this.data('placeholder'),
				multiple : $this.data('multiple'),
				width : $this.data('width'),
				allowClear : true,
				minimumInputLength : $this.data('min-input'), // minimum number of characters
				maximumInputLength : $this.data('max-input'), // maximum number of characters
				delay : 250, // milliseconds before triggering the request
				// debug : true,
				maximumSelectionLength : $this.data('max-options'), // maximum number of options selected
				ajax : {
					type     : 'POST',
					url      : ajaxurl,
					dataType : 'json',
					data     : function (params) {
						return {
							q          : params.term,
							action     : 'dilaz_panel_query_select',
							selected   : $this.val(),
							query_type : $this.data('query-type'),
							query_args : $this.data('query-args'),
						};
					},
					processResults : function(data) {
						
						var items   = [],
							newItem = null;

						for (var thisId in data) {
							
							newItem = {
								'id'   : data[thisId]['id'],
								'text' : data[thisId]['name']
							};

							items.push(newItem);
						}

						return { results : items };
					} 
				}
			});
		});
	}
	
	/**
	 * Radio image selection
	 */
	$t.radioImageField = function() {
		$('.dilaz-panel-fields').on('click', '.dilaz-panel-radio-image-img', function() {
			
			var $this = $(this);
			
			$this.parent().siblings().find('.dilaz-panel-radio-image-img').removeClass('selected');
			$this.addClass('selected');
		});
	}
	
	/**
	 * Switch and Buttonset
	 */
	$t.switchButtonsetField = function() {
		$('.dilaz-panel-fields').on('click', '.dilaz-panel-switch, .dilaz-panel-button-set', function() {
			
			var $this = $(this);
			
			$this.parent().addClass('selected');
			$this.parent().siblings().removeClass('selected');
		});
	}
	
	/**
	 * Checkbox
	 */
	$t.checkboxField = function() {
		$('.dilaz-panel-fields').on('click', '.dilaz-panel-checkbox', function() {
			$(this).toggleClass('focus');
		});
	}
	
	/**
	 * Radio
	 */
	$t.radioField = function() {
		$('.dilaz-panel-fields').on('click', '.dilaz-panel-radio', function() {
			
			var $this = $(this);
			
			$this.addClass('focus');
			$this.parent().siblings().find('.dilaz-panel-radio').removeClass('focus');
		});
	}
	
	/**
	 * Color picker
	 */
	$t.colorPicker = function() {
		$('.dilaz-panel-color').wpColorPicker();
	}
	
	/**
	 * Ajax - reset options
	 */
	$t.resetOptions = function() {
		$('#dilaz-panel-form').on('click', '.reset', function(e) {
			
			e.preventDefault();
			
			if (confirm(dilaz_panel_lang.confirm_reset)) {
			
				var $resetButton = $(this),
					$panelForm   = $resetButton.closest('#dilaz-panel-form'),
					$security    = $('input[name="security"]', $panelForm).val(),
					$optionName  = $panelForm.data('option-name'),
					$optionPage  = $panelForm.data('option-page'),
					$spinner     = $resetButton.siblings('.spinner'),
					$progress    = $resetButton.siblings('.progress'),
					$finished    = $resetButton.siblings('.finished');
					
				$.ajax({
					type     : 'POST',
					url      : ajaxurl,
					dataType : 'json',
					cache	 : false,
					data     : {
						action            : 'dilaz_panel_reset_options',
						security          : $security, 
						dilaz_option_name : $optionName, 
						dilaz_option_page : $optionPage, 
					},
					beforeSend : function() {
						$spinner.show().addClass('is-active');
						$progress.show();
					},
					success : function(response) {
						
						if (response.success) {
							$spinner.delay(1800).hide(290);
							$progress.delay(1800).hide(290);
						}
						
						if (response.success == 1) {
							$finished.empty().append(response.message).css({'color':'green'}).delay(2000).fadeIn(260);
							setTimeout(function() {
								window.location = response.redirect;
							}, 3000);
						} else {
							$finished.empty().append(response.message).css({'color':'red'}).delay(2000).fadeIn(260);
						}
					},
					complete : function() {
						$finished.delay(5000).fadeOut(260);
					}
				});
				
				return false;
			}
		});
	}
	
	/**
	 * Ajax - save options
	 */
	$t.saveOptions = function() {
		$('#dilaz-panel-form').on('click', '.update', function(e) {
			
			e.preventDefault();
			
			/* Autosave tinyMCE wp_editor() because we are using ajax */
			$.each($('.dilaz-panel-section'), function($key, $data) {
				var $id          = $data.id,
					$idHashed    = $('#'+$id),
					$fieldId     = $id.replace('dilaz-panel-section-', ''),
					$isEditor    = $($idHashed).find('.wp-editor-wrap'),
					$editorField = $($idHashed).find('#'+$fieldId);
					
				if ($isEditor.length) {
					var $wpEditorFrame  = $('#'+$fieldId+'_ifr'),
						$editorContents = $('#tinymce', $wpEditorFrame.contents())[0].innerHTML;
						
					$editorField.html($editorContents);
				}
			});
			var $saveButton = $(this),
				$panelForm   = $saveButton.closest('#dilaz-panel-form'),
				$submitButton = $('input[name="update"]', $panelForm),
				$spinner      = $submitButton.siblings('.spinner'),
				$progress     = $submitButton.siblings('.progress'),
				$finished     = $submitButton.siblings('.finished'),
				$formData     = {
					'action'    : 'dilaz_panel_save_options',
					'form_data' : $panelForm.serialize(), 
				};
			
				// var $dataArray = $panelForm.serializeArray(),
					// $formData = {};
				
				// $dataArray.push({ name: 'action', value: 'dilaz_panel_save_options' });

				// $.each($dataArray, function(i, item) {
					// $formData[item.name] = item.value
				// });
				
			$.ajax({
				type       : 'POST',
				url        : ajaxurl,
				dataType   : 'json',
				cache	   : false,
				data       : $formData,
				beforeSend : function() {
					$spinner.show().addClass('is-active');
					$progress.show();
				},
				success : function(response) {
					
					if (response.success) {
						$spinner.delay(1800).hide(290);
						$progress.delay(1800).hide(290);
					}
					
					if (response.success == 1) {
						$finished.empty().append(response.message).css({'color':'green'}).delay(2000).fadeIn(260);
					} else {
						$finished.empty().append(response.message).css({'color':'red'}).delay(2000).fadeIn(260);
					}
				},
				complete : function() {
					$finished.delay(5000).fadeOut(260);
				}
			});
			
			return false;
		});
	}
	
	/**
	 * Ajax - export options
	 */
	$t.exportOptions = function() {
		$('.dilaz-panel-fields').on('click', '.dilaz-panel-export', function() {
			
			var $exportButton = $(this),
				$spinner      = $exportButton.siblings('.spinner'),
				$progress     = $exportButton.siblings('.progress'),
				$finished     = $exportButton.siblings('.finished'),
				$nonce        = $exportButton.parent().data('export-nonce'),
				$optionName   = $exportButton.closest('#dilaz-panel-form').data('option-name');
				
			$.ajax({
				type     : 'POST',
				url      : ajaxurl,
				dataType : 'json',
				cache	 : false,
				data     : {
					action             : 'dilaz_panel_export_options',
					dilaz_export_nonce : $nonce,
					dilaz_option_name  : $optionName,
				},
				beforeSend : function() {
					$spinner.show().addClass('is-active');
					$progress.show();
				},
				success : function(response) {
					
					if (response.success) {
						$spinner.delay(1800).hide(290);
						$progress.delay(1800).hide(290);
					}
					
					if (response.success == 1) {
						window.location = response.exp;
						$finished.css({'color':'green'}).delay(2000).fadeIn(260);
					}
				},
				complete : function() {
					$finished.delay(5000).fadeOut(260);
				}
			});
		});	
	}
	
	/**
	 * Select import file
	 */
	$t.selectImportFile = function() {
		$('.dilaz-panel-fields').on('change', '.dilaz-import-file', function() {
			
			var $this = $(this);
			
			$this.parent().find('span').text($($this)[0].files[0]['name']);
		});
	}
	
	/**
	 * Ajax - import options
	 */
	$t.importOptions = function() {
		$('.dilaz-panel-fields').on('click', '.dilaz-panel-import', function() {
			
			var $importButton = $(this),
				$spinner      = $importButton.siblings('.spinner'),
				$progress     = $importButton.siblings('.progress'),
				$finished     = $importButton.siblings('.finished'),
				$importForm   = $importButton.closest('#dilaz-panel-form'),
				$optionName   = $importForm.data('option-name'),
				$optionPage   = $importForm.data('option-page'),
				$importWrap   = $importButton.closest('#dilaz-panel-import'),
				$nonce        = $importWrap.data('import-nonce'),
				$filesData    = $importWrap.find('.dilaz-import-file'),
				$fileName     = $filesData.attr('name'),
				$formData     = new FormData();
			
			if ($filesData.val() == '') {
				$importButton.parent().siblings('.upload-response').removeClass('hidden').html('<div class="notification error"><p>Please select a file</p></div>');
				return;
			}
			
			$formData.append($fileName, $($filesData)[0].files[0]);
			$formData.append('action', 'dilaz_panel_import_options');
			$formData.append('dilaz_import_nonce', $nonce);
			$formData.append('dilaz_option_page', $optionPage);
			$formData.append('dilaz_option_name', $optionName);
			$formData.append('dilaz_import_file', $fileName);
			
			$.ajax({
				type        : 'POST',
				url         : ajaxurl,
				dataType    : 'json',
				cache	    : false,
				data        : $formData,
				contentType : false,
				processData : false,
				beforeSend  : function() {
					$spinner.addClass('is-active').show();
					$progress.show();
				},
				success : function(response) {
					
					if (response.success) {
						$spinner.delay(1800).fadeOut(290);
						$progress.delay(1800).fadeOut(290);
					}
					
					if (response.success == 1) {
						$finished.empty().append(response.message).css({'color':'green'}).delay(2000).fadeIn(260).delay(5000).fadeOut(260);
						setTimeout(function() {
							window.location = response.redirect;
						}, 3000);
					} else {
						$finished.empty().append(response.message).css({'color':'red'}).delay(2000).fadeIn(260).delay(5000).fadeOut(260);
					}
					
				},
				complete : function() {
					
				}
			});
		});
	}
	
	/**
	 * Set Cookie
	 * @since Dilaz Panel 2.6.8
	 */
	$t.setCookie = function(c_name, value, exdays) {
		var exdate = new Date();
		exdate.setDate(exdate.getDate() + exdays);
		var c_value = escape(value)+((exdays==null) ? "" : ("; expires="+exdate.toUTCString()));
		document.cookie = c_name + "=" + c_value;
	}
	
	/**
	 * Get Cookie
	 * @since Dilaz Panel 2.6.8
	 */
	$t.getCookie = function(c_name) {
		var i, x, y, ARRcookies=document.cookie.split(";");
		for (i = 0; i < ARRcookies.length; i++) {
			x = ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
			y = ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
			x = x.replace(/^\s+|\s+$/g, "");
			if (x == c_name) {
				return unescape(y);
			}
		}
	}
	
	/**
	 * Get JSON
	 * @since Dilaz Panel 2.6.8
	 */
	$t.getJSON = function(file, callback) {
		
		$.getJSON(file).done(function(jasonData) {
			callback(jasonData);
		}).error(function() {
			
			var $alertJsonError = $t.getCookie('DilazAlertJsonError') || '';
			
			/* prevent multiple alert popups */
			if ($alertJsonError != 'yes') {
				$t.setCookie('DilazAlertJsonError', 'yes', (1/(24*60*60)) * 10); // cookie expires after 10 seconds
				alert('DilazPanel Error: Please check your JSON file.');
			}
		});
	}
	
	/**
	 * Get JSON
	 * @since Dilaz Panel 2.6.8
	 */
	$t.updateGoogleFonts = function(sectionId, fontFamily, fontWeight, fontStyle, fontSubset) {
	
		var $linkId    = sectionId+'-'+fontFamily.replace(/ /g, '-').toLowerCase(),
			$links     = document.getElementsByTagName('link'),
			fontURLarr = [],
			fontURL    = '';
		
		/* if Google Font resource link exists, delete it so that it can be updated */
		for (var i = 0; i < $links.length; i++) {
			if ($links[i].id == $linkId) {
				$links[i].remove();
			}
		}
		
		fontURLarr.push('https://fonts.googleapis.com/css?family=');
		fontURLarr.push(fontFamily.replace(/ /g, '+'));
		
		/* import Google Fonts */
		$t.getJSON(dilaz_panel_lang.dilaz_panel_url +'includes/google-fonts.json', function(jasonData) {
			// console.log(Object.keys(jasonData).length);
			// console.log(jasonData);
			// console.log(jasonData[fontFamily]);
			// console.log(jasonData[fontFamily].variants);
			// console.log(jasonData[fontFamily].subsets);
			
			/* Check if its a Google font selected */
			if (jasonData[fontFamily] !== undefined) {
				
				var fontVariants    = jasonData[fontFamily].variants,
					checkFontStyle  = JSON.stringify(fontVariants).indexOf(fontStyle) > -1,
					checkFontWeight = JSON.stringify(fontVariants).indexOf(fontWeight) > -1,
					fontSubsets     = jasonData[fontFamily].subsets,
					checkFontSubset = JSON.stringify(fontSubsets).indexOf(fontSubset) > -1;
					
				if (checkFontStyle || checkFontWeight) {
					var theStyle  = (checkFontStyle) ? fontStyle : '',
						theWeight = (checkFontWeight) ? fontWeight : '';
					if (theStyle !== '' || theWeight !== '') {
						fontURLarr.push(':');
						fontURLarr.push(theStyle+theWeight);
					}
				}
				
				if (checkFontSubset && fontSubset !== '') {
					fontURLarr.push('&subset=');
					fontURLarr.push(fontSubset);
				}
				
				fontURL += fontURLarr.join('');
				
				if ($("link[href*='" + fontFamily + "']").length === 0) {
					$('head>link:last').after('<link id="'+$linkId+'" href="'+fontURL+'" rel="stylesheet" type="text/css">');
				}
			}
		});
	}
	
	/**
	 * Font preview
	 */
	$t.fontPreview = function() {
		$('.dilaz-panel-section-font').each(function() {
			
			var $this        = $(this),
				$fFamily     = $this.find('.family'),
				$fSubset     = $this.find('.subset'),
				$fWeight     = $this.find('.weight'),
				$fStyle      = $this.find('.style'),
				$fCase       = $this.find('.case'),
				$fSize       = $this.find('.f-size'),
				$fHeight     = $this.find('.f-height'),
				$panelColor  = $this.find('.dilaz-panel-color'),
				$resultColor = $this.find('.wp-color-result'),
				$fPreview    = $this.find('.font-preview'),
				$fContent    = $fPreview.find('.content'),
				$fColor      = $resultColor.css('background-color'),
				$bgColor     = $t.bgColorBasedOnTextColor($fColor, '#fbfbfb', '#222'),
				$fSectionId  = $this.closest('.dilaz-panel-section').attr('id');
				
			/* show preview */
			$fPreview.show();
			
			/* render already set values */
			$fContent.css({
				'font-family'      : $fFamily.val(),
				'font-weight'      : $fWeight.val(),
				'font-style'       : $fStyle.val(),
				'text-transform'   : $fCase.val(),
				'font-size'        : $fSize.val() +'px',
				'line-height'      : $fHeight.val() +'px',
				'color'            : $fColor,
				'background-color' : $bgColor,
			});
			
			/**
			 * show Google Font in preview if its saved
			 * @since Dilaz Panel 2.6.8
			 */
			$t.updateGoogleFonts($fSectionId, $fFamily.val(), $fWeight.val(), $fStyle.val(), $fSubset.val());
			
			$fFamily.on('change', function() {
				var $familyVal = $fFamily.val();
				var $defaultFonts = 'arial verdana trebuchet georgia times tahoma palatino helvetica';
				$fContent.css({'font-family':$familyVal});
				if ($defaultFonts.indexOf($familyVal) == -1) {
					$t.updateGoogleFonts($fSectionId, $fFamily.val(), $fWeight.val(), $fStyle.val(), $fSubset.val());
				}
			});
			
			$fSubset.on('change', function() {
				$fContent.css({'font-subset':$fSubset.val()});
				$t.updateGoogleFonts($fSectionId, $fFamily.val(), $fWeight.val(), $fStyle.val(), $fSubset.val());
			});
			
			$fWeight.on('change', function() {
				$fContent.css({'font-weight':$fWeight.val()});
				$t.updateGoogleFonts($fSectionId, $fFamily.val(), $fWeight.val(), $fStyle.val(), $fSubset.val());
			});
			
			$fStyle.on('change', function() {
				$fContent.css({'font-style':$fStyle.val()});
				$t.updateGoogleFonts($fSectionId, $fFamily.val(), $fWeight.val(), $fStyle.val(), $fSubset.val());
			});
			
			$fCase.on('change', function() {
				$fContent.css({'text-transform':$fCase.val()});
			});
			
			$fSize.on('keyup', function() {
				$fContent.css({'font-size':$fSize.val() +'px'});
			});
			
			$fHeight.on('keyup', function() {
				$fContent.css({'line-height':$fHeight.val() +'px'});
			});
			
			$panelColor.wpColorPicker({
				change: function(event, ui) {
					var textColor = ui.color.toString();
					$fContent.css({
						'color': textColor, 
						'background-color': $t.bgColorBasedOnTextColor(textColor, '#fbfbfb', '#222')
					});
				}
			});
		});
	}
	
	/**
	 * Background preview
	 */
	$t.backgroundPreview = function() {
		$('.dilaz-panel-section-background').each(function(){
			
			var $this         = $(this),
				$bgRepeat     = $this.find('.repeat'),
				$bgSize       = $this.find('.size'),
				$bgPosition   = $this.find('.position'),
				$bgPositionX  = $this.find('.position-x'),
				$bgPositionY  = $this.find('.position-y'),
				$bgAttachment = $this.find('.attachment'),
				$bgOrigin     = $this.find('.origin'),
				$bgClip       = $this.find('.clip'),
				$bgColor      = $this.find('.color'),
				$panelColor   = $this.find('.dilaz-panel-color'),
				$resultColor  = $this.find('.wp-color-result'),
				$bgImgPreview = $this.find('.dilaz-panel-file-preview'),
				$bgPreview    = $this.find('.background-preview'),
				$bgContent    = $bgPreview.find('.content');
				
			/* show preview */
			$bgPreview.show();
			
			/* render already set values */
			$bgContent.css({
				'background-image'      : 'url('+$bgImgPreview.attr('src')+')',
				'background-repeat'     : $bgRepeat.val(),
				'background-size'       : $bgSize.val(),
				'background-position'   : $bgPosition.val(),
				'background-position-x' : $bgPositionX.val(),
				'background-position-y' : $bgPositionY.val(),
				'background-origin'     : $bgOrigin.val(),
				'background-clip'       : $bgClip.val(),
				'background-attachment' : $bgAttachment.val(),
				'background-color'      : $resultColor.css('background-color'),
			});
			
			$bgRepeat.on('change', function(){
				$bgContent.css({'background-repeat':$bgRepeat.val()});
			});
			
			$bgSize.on('change', function(){
				$bgContent.css({'background-size':$bgSize.val()});
			});
			
			$bgPosition.on('change', function(){
				$bgContent.css({'background-position':$bgPosition.val()});
			});
			
			$bgPositionX.on('change', function(){
				$bgContent.css({'background-position-x':$bgPositionX.val()});
			});
			
			$bgPositionY.on('change', function(){
				$bgContent.css({'background-position-y':$bgPositionY.val()});
			});
			
			$bgOrigin.on('change', function(){
				$bgContent.css({'background-origin':$bgOrigin.val()});
			});
			
			$bgClip.on('change', function(){
				$bgContent.css({'background-clip':$bgClip.val()});
			});
			
			$bgAttachment.on('change', function(){
				$bgContent.css({'background-attachment':$bgAttachment.val()});
			});
			
			$panelColor.wpColorPicker({
				change:function( event, ui ) {
					$bgContent.css({'background-color':ui.color.toString()});
				}
			});
		});
	}
	
	/**
	 * Repeatable field - sortable
	 */
	$t.repeatableField = function() {
		$('.dilaz-panel-repeatable').sortable({
			opacity: 0.6,
			revert: true,
			handle: '.sort-repeatable',
			cursor: 'move',
			axis: 'y',
			update: function() {
				var i = 0;
				$(this).children().each(function(i) {
					$(this).find('input').attr('name', function(index, name) {
						return name.replace(/\[([^\]])\]/g, function(fullMatch, n) {
							return '['+Number(i)+']';
						});
					});
					i++;
				});
			}
		});
	}
	
	/**
	 * add new repeatable items in the repeatable field
	 */
	$t.addRepeatableField = function() {
		$('.dilaz-panel-add-repeatable-item').on('click', function() {
			var $this     = $(this),
				sorter    = '<span class="sort-repeatable"><i class="dashicons dashicons-move"></i></span>',
				remover   = '<span class="repeatable-remove button"><i class="dashicons dashicons-no-alt"></i></span>',
				rList     = $this.prev('.dilaz-panel-repeatable'),
				sortable  = rList.data('s'),
				nS        = rList.data('ns'),
				removable = rList.data('r'),
				nR        = rList.data('nr'),
				rListItem = rList.find('>li'),
				rClone    = rList.find('>li:last').clone(),
				rItems    = rListItem.length;
				
			rClone.each(function() {
				var $this = $(this);
				
				/* hide so that we can slidedown */
				$this.hide();
				
				/* clear all fields */
				$this.find('input').val('').attr('name', function(index, name) {
					return name.replace(/\[([^\]])\]/g, function(fullMatch, n) {
						return '['+(Number(n) + 1)+']';
					});
				});
				
				/* if items not-sortable is equal to number of shown items */
				if (nS <= rItems) {
					if (!$this.find('.sort-repeatable').length && sortable == true) {
						$this.prepend(sorter);
					}
				}
				
				/* if items not-repeatable is equal to number of shown items */
				if (nR == rItems || nR < 1) {
					if (!$this.find('.repeatable-remove').length && removable == true) {
						$this.append(remover);
					}
				}
			});
			$(rList).append(rClone);
			rClone.slideDown(100);
		});
	}
	
	/**
	 * remove repeatable field
	 */
	$t.removeRepeatableField = function() {
		$doc.on('click', '.repeatable-remove', function(e) {
			e.preventDefault();
			
			var $this = $(this),
				$parent = $this.parent();
			
			/* one item should always remain */
			if ($parent.siblings().length > 0) {
				$parent.slideUp(100);
				setTimeout(function() {
					$parent.remove();
				}, 1000);
			}
			
			return false;
		});
	}
	
	/**
	 * check if color is HEX, RGB, RGBA, HSL, HSLA
	 * 
	 * @since Dilaz Panel 2.6.6
	 * @link https://stackoverflow.com/a/32685393
	 */
	$t.checkColor = function(color) {
		
		/* check HEX */
		var isHex = /^#(?:[A-Fa-f0-9]{3}){1,2}$/i.test(color);
		if (isHex) { return 'hex'; }
		
		/* check RGB */
		var isRgb = /^rgb[(](?:\s*0*(?:\d\d?(?:\.\d+)?(?:\s*%)?|\.\d+\s*%|100(?:\.0*)?\s*%|(?:1\d\d|2[0-4]\d|25[0-5])(?:\.\d+)?)\s*(?:,(?![)])|(?=[)]))){3}[)]$/i.test(color);
		if (isRgb) { return 'rgb'; }
		
		/* check RGBA */
		var isRgba = /^^rgba[(](?:\s*0*(?:\d\d?(?:\.\d+)?(?:\s*%)?|\.\d+\s*%|100(?:\.0*)?\s*%|(?:1\d\d|2[0-4]\d|25[0-5])(?:\.\d+)?)\s*,){3}\s*0*(?:\.\d+|1(?:\.0*)?)\s*[)]$/i.test(color);
		if (isRgba) { return 'rgba'; }
		
		/* check HSL */
		var isHsl = /^hsl[(]\s*0*(?:[12]?\d{1,2}|3(?:[0-5]\d|60))\s*(?:\s*,\s*0*(?:\d\d?(?:\.\d+)?\s*%|\.\d+\s*%|100(?:\.0*)?\s*%)){2}\s*[)]$/i.test(color);
		if (isHsl) { return 'hsl'; }
		
		/* check HSLA */
		var isHsla = /^hsla[(]\s*0*(?:[12]?\d{1,2}|3(?:[0-5]\d|60))\s*(?:\s*,\s*0*(?:\d\d?(?:\.\d+)?\s*%|\.\d+\s*%|100(?:\.0*)?\s*%)){2}\s*,\s*0*(?:\.\d+|1(?:\.0*)?)\s*[)]$/i.test(color);
		if (isHsla) { return 'hsla'; }
		
	}
	
	/**
	 * RGB to HEX
	 * 
	 * @since Dilaz Panel 2.6.6
	 */
	$t.rgbToHex = function(red, green, blue) {
		var rgb = blue | (green << 8) | (red << 16);
		return '#' + (0x1000000 + rgb).toString(16).slice(1);
	}
	
	/**
	 * HEX to RGB
	 * 
	 * @since Dilaz Panel 2.6.6
	 * @return Object|String
	 */
	$t.hexToRgb = function(hex) {
		/* Expand shorthand form (e.g. "03F") to full form (e.g. "0033FF") */
		var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
		hex = hex.replace(shorthandRegex, function(m, r, g, b) {
			return r + r + g + g + b + b;
		});

		var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
		return result ? {
			r: parseInt(result[1], 16),
			g: parseInt(result[2], 16),
			b: parseInt(result[3], 16)
		} : null;
	}
	
	/**
	 * HEX to RGBA
	 * 
	 * @return Object|String
	 */
	$t.hexToRgba = function(hex, opacity = 1) {
		
		if ($t.checkColor(hex) != 'hex') return null; 
		
		/* convert the hex to RGB */
		var hexToRgb = $t.hexToRgb(hex);
		
		if (typeof opacity != 'undefined') {
			return $.extend(hexToRgb, {'o':opacity});
		}
		
		return null;
	}
	
	/**
	 * Background color based on text color
	 */
	$t.bgColorBasedOnTextColor = function(textColor, lightColor, darkColor) {
		
		var checkColor = $t.checkColor(textColor),
			rgb = null;
			
		if (checkColor == 'hex') {
			var hexToRgb = $t.hexToRgb(textColor);
			if (typeof(hexToRgb) === 'object' && hexToRgb != null) {
				var red   = hexToRgb.hasOwnProperty('r') ? hexToRgb.r : 0,
					green = hexToRgb.hasOwnProperty('g') ? hexToRgb.g : 0,
					blue  = hexToRgb.hasOwnProperty('b') ? hexToRgb.b : 0,
					rgb   = 'rgb('+red+', '+green+', '+blue+')';
			}
		} else if (checkColor == 'rgb') {
			var rgb = textColor;
		}
		
		if (rgb == null) return null;
		
		// var matches = rgb.match(/rgb\((\d+),\s?(\d+),\s?(\d+)\)/);
		var matches = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
		
		if (!matches) return null;
		
		if (matches != null && matches.length && matches.length > 3) {
			var c = 'rgb(' + matches[1] + ',' + matches[2] + ',' + matches[3] + ')';
			var o = Math.round(((parseInt(matches[1], 10) * 299) + (parseInt(matches[2], 10) * 587) + (parseInt(matches[3], 10) * 114)) / 1000);
			
			return (o > 125) ? darkColor : lightColor;
		}
	}
	
	/**
	 * Init
	 *
	 */
	$t.init = function() {

		$t.doWhen();
		$t.tabMenuOpenFirst();
		$t.tabMenu();
		$t.fileUpload();
		$t.removeFile();
		$t.fileSorting();
		$t.uiSlider();
		$t.uiRange();
		$t.select2Field();
		$t.querySelectAjax();
		$t.radioImageField();
		$t.switchButtonsetField();
		$t.checkboxField();
		$t.radioField();
		$t.colorPicker();
		$t.resetOptions();
		$t.saveOptions();
		$t.exportOptions();
		$t.selectImportFile();
		$t.importOptions();
		$t.fontPreview();
		$t.backgroundPreview();
		$t.repeatableField();
		$t.addRepeatableField();
		$t.removeRepeatableField();

	};
}

jQuery(document).ready(function($) {
	DilazPanelScript.init();
});
