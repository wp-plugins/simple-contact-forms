(function( $ ) {
	'use strict';

	/**
	 * All of the code for your Dashboard-specific JavaScript source
	 * should reside in this file.
	 *
	 * Note that this assume you're going to use jQuery, so it prepares
	 * the $ function reference to be used within the scope of this
	 * function.
	 *
	 * From here, you're able to define handlers for when the DOM is
	 * ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * Or when the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and so on.
	 *
	 * Remember that ideally, we should not attach any more than a single DOM-ready or window-load handler
	 * for any particular page. Though other scripts in WordPress core, other plugins, and other themes may
	 * be doing this, we should try to minimize doing that in our own work.
	 */
	$(document).ready(function() {

		function scf_do_hidden_stuff(that) {

			if( that.attr('type') == 'checkbox' ) {
				if( that.is(':checked') ) {
					console.log('changing', that.attr('id') + '_true')
					$( '.show_' + that.attr('id') + '_true' ).show();
					$( '.hide_' + that.attr('id') + '_true' ).hide();
				} else {
					console.log('changing', that.attr('id') + '_false')
					$( '.show_' + that.attr('id') + '_false' ).show();
					$( '.hide_' + that.attr('id') + '_false' ).hide();
				}
			} else {
				console.log('changing', that.attr('id'), that.val())
				$( '.show_' + that.attr('id') + '_' + that.val() ).show();
				$( '.hide_' + that.attr('id') + '_' + that.val() ).hide();
				$( '.show_' + that.attr('id') ).hide();
				$( '.hide_' + that.attr('id') ).hide();
			}

		}

		$('.do_hide').change(function(){
			scf_do_hidden_stuff( $(this) );
		});

		$(window).load(function() {
			$('.do_hide').each(function() {
				scf_do_hidden_stuff( $(this) );
			})
		});


		/*
		 * Do all the fields table generation and handling
		 */

 		//var table = '.field_table';
 		var table = '#the-list';

		$(".wp-list-table tbody").sortable({
			cursor:'move',
			handle: '.handle',
			placeholder: 'dropping-gap',
			stop:function(event, ui){
				updateRowNumbers();
			}
		});

		$(".wp-list-table tbody").disableSelection();



		var scf_getRowNumber = function() {
			return $('.fields_row').length + 1;
		};

		var scf_getOptionNumber = function(row) {
			return $('#fields_' + row + ' .option-field').length + 1;
		};

		var scf_optionTemplate = function(rN, oN, val) {
			if( !val ) val = '';
			return '<div class="option-field" id="options_' + oN + '"><input name="fields[' + rN + '][options][' + oN + ']" value="' + val + '" class="all-options" /><input type="button" class="delete-option button-secondary" value="-" /></div>';
		};

		var scf_rowTemplate = function(rN, vals) {
			if( !vals ) vals = {
				label: '',
				type: 'text',
				required: true,
			};
			return '<tr id="fields_' + rN + '" class="alternate fields_row">' +
				'<td class="column-col_link_id form-field handle">' + rN + '</td>' +
				'<td class="column-col_link_label form-field"><input type="text" value="' + vals['label'] + '" class="all-options" name="fields['+rN+'][label]" /></td>' +
				'<td class="column-col_link_type form-field"><select class="type-field" name="fields['+rN+'][type]" value="' + vals['type'] + '" id="">' +
					'<option value="select"' + (vals['type'] == 'select' ? ' selected' : '') + '>Dropdown' +
					'<option value="email"' + (vals['type'] == 'email' ? ' selected' : '') + '>Email Address' +
					'<option value="textarea"' + (vals['type'] == 'textarea' ? ' selected' : '') + '>Large Text Block' +
					'<option value="name"' + (vals['type'] == 'name' ? ' selected' : '') + '>Name Field' +
					'<option value="text"' + (vals['type'] == 'text' ? ' selected' : '') + '>Text Field' +
				'</select></td>' +
				'<td class="column-col_link_options"><div id="options" style="display:none;">' +
					'<div class="option_fields"></div><input type="button" class="button-secondary add-option" value="+" />' + 
					'<p class="description">Note: The top option will be the default option</p>' +
				'</div></td>' +
				'<td class="column-col_link_required"><input type="checkbox" ' + (vals['required'] ? 'checked' : '') + ' value="checked" name="fields['+rN+'][required]" /></td>' +
				'<td class="column-col_link_exclude"><input type="checkbox" ' + (vals['exclude'] ? 'checked' : '') + ' value="exclude" name="fields['+rN+'][exclude]" /></td>' +
				'<td class="column-col_link_delete form-field"><a class="delete-field">Delete</a></td>' +
			'</tr>';
		}

		function scf_updateRowNumbers() {
			$(table).find('.fields_row').each(function(r) {
				var el = $(this),
					IDtemp = el.attr('id').split("_")[0],
					oldNo = el.attr('id').split("_")[1],
					newNo = el.index();

				el.attr('id', IDtemp + '_' + newNo);
				el.find('.handle').html(newNo);
				el.find('input, select').each(function(i) {
					if($(this).attr('type') != 'button') $(this).attr('name', $(this).attr('name').replace('[' + oldNo + ']', '[' + newNo + ']') );
				});
			})
		}

		function scf_updateOptionNumbers(row) {
			$(table + ' #fields_' + row + ' .option_fields').find('.option-field').each(function(r) {
				var el = $(this),
					IDtemp = el.attr('id').split("_")[0],
					oldNo = el.attr('id').split("_")[1],
					newNo = el.index() + 1;

				el.attr('id', IDtemp + '_' + newNo);
				el.find('input').attr('name', el.find('input').attr('name').replace('[options][' + oldNo + ']', '[options][' + newNo + ']') )
			})
		}

		function scf_addRow(vals) {
			var no = scf_getRowNumber();
			$(table).append(scf_rowTemplate(no, vals));
		}

		function scf_addOption(cl, row, optionNo, vals) {
			var Ono = (optionNo ? optionNo : scf_getOptionNumber(row));
			$('#fields_'+row+' .' + cl).append(scf_optionTemplate(row, Ono, vals));
		}

		function scf_showHideOptions(that, no, vals) {
        	var thisRow = (no ? no : that.closest('.fields_row').attr('id').split("_")[1]);
			if(that.val() == 'select') {
				$('#fields_'+thisRow+' #options').show();
				if(vals) {
					for(var o in vals.options) {
						scf_addOption('option_fields', thisRow, o, vals.options[o]);
					}
				}
			} else {
				$('#fields_'+thisRow+' #options').hide();
				$('#fields_'+thisRow+' #options .option-field').remove();
			}
		}


		$(document.body).on('click', '.add-field', function() {
			scf_addRow(false);
			if($(table).find('.no-items').length > 0) $('.no-items').remove();
		})

		$(document.body).on('click', '.delete-field', function() {
	        $(this).closest('.fields_row').remove();
			scf_updateRowNumbers();
		})

		$(document.body).on('change', '.type-field', function() {
			scf_showHideOptions( $(this), false, false );
		})

		$(document.body).on('click', '.add-option', function() {
        	var thisRow = $(this).closest('.fields_row').attr('id').split("_")[1];
			scf_addOption('option_fields', thisRow, false, false);
		})

		$(document.body).on('click', '.delete-option', function() {
        	var thisRow = $(this).closest('.fields_row').attr('id').split("_")[1];
	        $(this).closest('.option-field').remove();
	        scf_updateOptionNumbers(thisRow);
		})

		$(window).load(function() {
			if (typeof fields_arr !== 'undefined' && fields_arr) {
				for (var i in fields_arr) {
				    if (fields_arr[i]) {
						scf_addRow(fields_arr[i]);
						scf_showHideOptions( $('#fields_' + i + ' .type-field'), i, fields_arr[i] );
				    }
				}
			}
		})



	});

})( jQuery );
