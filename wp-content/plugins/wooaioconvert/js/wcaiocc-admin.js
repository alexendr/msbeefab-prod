/**
 * 
 * Plugin: WooCommerce All in One Currency Converter
 * Author: http://dev49.net
 *
 */
 


/** ------------------------ Global start ------------------------  **/


// Count object items:
function wcaiocc_count_items(obj) {
	var count = 0;
	for (var prop in obj) {
		if (obj.hasOwnProperty(prop)) {
			++count;
		}
	}
	return count;
}


// Perform ajax actions:
function wcaiocc_callback_action(action_data) {

	if (typeof action_data === 'string') { // if action_data is a string, we will make it array
		var action_name = action_data;
		action_data = {};
		action_data['name'] = action_name;
	}

	var verification = wcaiocc_vars_data.wp_nonce;
	var post_data = {};

	if (action_data['name'] == null) {

		return false;

	} else if (action_data['name'] == 'restore_defaults') {

		if (confirm(wcaiocc_vars_data.confirm_restore_defaults_msg)) { // if user clicks ok

			// Create POST data array:
			var post_data = {
				action: 'wcaiocc_ajax',
				verification: verification,
				execute: 'restore_defaults'
			};
			// Send Ajax request:
			wcaiocc_block_screen(true); // block screen
			jQuery.post(ajaxurl, post_data, function (response) {
				if (response <= 0) { // error
					alert(wcaiocc_vars_data.operation_could_not_be_completed_msg);
				} else {
					alert(response);
					location.reload(); // reload page after restoring default settings
				}
				wcaiocc_block_screen(false); // unblock screen
			});

		} else {

			return false; // user clicked cancel - terminate function

		}

	} else if (action_data['name'] == 'update_exchange_rates') {

		// Create POST data array:
		var post_data = {
			action: 'wcaiocc_ajax',
			verification: verification,
			execute: 'update_exchange_rates',
			currency_data: action_data['currency_data']
		};
		// Send Ajax request:
		wcaiocc_block_screen(true); // block screen
		jQuery.post(ajaxurl, post_data, function (response) {
			//console.log(response); // debug only
			if (response <= 0) { // error
				alert(wcaiocc_vars_data.operation_could_not_be_completed_msg);
			} else {
				var currency_update_data = jQuery.parseJSON(response); // create array from json-string
				var errors = []; // array containing currencies that caused errors
				var currencies_count = wcaiocc_count_items(currency_update_data); // number of currencies that were updated
				var value = 1;
				var error = 1;
				jQuery.each(currency_update_data, function (currency_code) { // loop through JSON array
					if (currency_update_data[currency_code] != null) {
						value = currency_update_data[currency_code]['value'];
						error = currency_update_data[currency_code]['error'];
					}
					var exchange_rate_object_id = '#wcaiocc_exchange_' + currency_code + '_rate';
					if (error == 0) {
						jQuery(exchange_rate_object_id).val(value); // update field only if there was no error
					} else { // if there was error:
						errors.push(currency_code); // add current currency to error array
					}
				});

				var alert_msg = '';
				if (currencies_count == 1) { // if just one currency was updated...
					if (errors.length > 0) { // error occured with this currency
						alert_msg = wcaiocc_vars_data.error_currency_exchange_rate_update_msg + errors[0];
					}
				} else if (currencies_count > 1) { // bulk updating
					if (errors.length > 0) { // error occured with the currencies
						alert_msg = wcaiocc_vars_data.error_currency_exchange_rate_update_msg;
						jQuery.each(errors, function (index) { // loop through array with error currencies
							alert_msg += errors[index] + ', ';
						});
						alert_msg = alert_msg.slice(0, -2); // remove last 2 chars (', ');
					} else { // no errors on bulk update
						alert_msg = wcaiocc_vars_data.success_currency_exchange_rate_update_msg;
					}
				} else {
					alert_msg = wcaiocc_vars_data.operation_could_not_be_completed_msg;
				}
				if (alert_msg.length > 0) {
					alert(alert_msg);
				}

			}
			wcaiocc_update_data(); // update from objects on screen to data in hidden inputs to be stored in DB
			wcaiocc_block_screen(false); // unblock screen
		});

	} else {

		return false;

	}

}


// block screen waiting for ajax
function wcaiocc_block_screen(block) {

	if (block == true) {
		jQuery('<div id="wcaiocc-block-div"></div>').appendTo('body');
		jQuery('#wcaiocc-block-div').css({ opacity: 0, width: jQuery(document).width(), height: jQuery(document).height() });
		jQuery('#wcaiocc-block-div').addClass('wcaiocc-block-div');
		jQuery('#wcaiocc-block-div').animate({ opacity: 0.4 }, 150);
	} else {
		jQuery('#wcaiocc-block-div').animate({ opacity: 0 }, 150, function () {
			jQuery('#wcaiocc-block-div').remove();
		});
	}

}


/** ------------------------ Global end ------------------------  **/


/** ------------------------ General section start ------------------------  **/


jQuery(document).ready(function ($) {

	if ($('#wcaiocc_remember_user_chosen_currency').length > 0) { // we're using this condition to check if we are in General section

		wcaiocc_conversion_mode_change($("input[type=radio][name='wcaiocc_conversion_method']:checked").val());

		$("input[type=radio][name='wcaiocc_conversion_method']").on('change', function () { // enable/disable checkout currency checkboxes/checkout text on changing conversion method radio
			wcaiocc_conversion_mode_change($(this).val());
		});

		$("input[type=checkbox][name='wcaiocc_checkout_total_in_base_currency']").on('change', function () { // enable/disable checkout text on changing base currency payment checkbox
			if ($(this).is(":checked")) {
				$("#wcaiocc_checkout_total_payment_text").removeAttr('disabled');
			} else {
				$("#wcaiocc_checkout_total_payment_text").attr('disabled', true);
			}
		});

		$("input[type=submit][name='save']").on('click', function () { // on submit button click
			$("#wcaiocc_checkout_total_payment_text").removeAttr('disabled'); // we have to re-enable checkout text to make it possible to save in DB
			$("#wcaiocc_checkout_total_in_base_currency").removeAttr('disabled'); // ...and total in base currency
		});

	}

});


// enable/disable fields depending on conversion method
function wcaiocc_conversion_mode_change(conversion_method) {

	switch (conversion_method) {
		case 'reference':
			jQuery("#wcaiocc_checkout_total_in_base_currency").removeAttr('disabled');
			if (jQuery("input[type=checkbox][name='wcaiocc_checkout_total_in_base_currency']:checked").length > 0) {
				jQuery("#wcaiocc_checkout_total_payment_text").removeAttr('disabled');
			} else {
				jQuery("#wcaiocc_checkout_total_payment_text").attr('disabled', true);
			}
			break;
		case 'checkout':
			jQuery("#wcaiocc_checkout_total_in_base_currency").attr('disabled', true);
			jQuery("#wcaiocc_checkout_total_payment_text").attr('disabled', true);
			break;
		default:
			break;
	}

}


/** ------------------------ General section end ------------------------  **/


/** ------------------------ Currencies section start ------------------------  **/


jQuery(document).ready(function ($) {

	if ($('#wcaiocc_available_currencies').length > 0) { // we're using this condition to check if we are in Currencies section

		// Add button to add new currency:
		$('.wcaiocc_new_currency').after(
			'<a class="button" href="#onclick_action" style="width:320px;" onclick="wcaiocc_add_new_currency_blob(jQuery(\'select.wcaiocc_new_currency\').val());">' + wcaiocc_vars_data.add_currency_to_list + '</a>'
		);

		// Add currencies sortable table:
		$('#wcaiocc_available_currencies').after(
			'<table class="wcaiocc-currency-table" id="wcaiocc_currency_table"></table>'
		);

		// Add header row:
		$('#wcaiocc_currency_table').append(
			'<thead><tr>' +
			'<th class="wcaiocc_currency_cell_code">' + wcaiocc_vars_data.currency_code + '</th>' +
			'<th class="wcaiocc_currency_cell_name">' + wcaiocc_vars_data.currency_name + '</th>' +
			'<th class="wcaiocc_currency_cell_symbol">' + wcaiocc_vars_data.currency_symbol + '</th>' +
			'<th class="wcaiocc_currency_cell_position">' + wcaiocc_vars_data.currency_position + '</th>' +
			'<th class="wcaiocc_currency_cell_thousand">' + wcaiocc_vars_data.thousand_separator + '</th>' +
			'<th class="wcaiocc_currency_cell_decimal">' + wcaiocc_vars_data.decimal_separator + '</th>' +
			'<th class="wcaiocc_currency_cell_number">' + wcaiocc_vars_data.number_decimals + '</th>' +
			'<th class="wcaiocc_currency_cell_remove">' + wcaiocc_vars_data.remove_currency + '</th>' +
			'</tr></thead>'
		);

		// Add tbody section:
		$('#wcaiocc_currency_table').append(
			'<tbody></tbody>'
		);

		// Make table sortable (with small table fix):
		// Return a helper with preserved width of cells
		var fixHelper = function(e, tr){
			var $originals = tr.children();
			var $helper = tr.clone();
			$helper.children().each(function (index) {
				$(this).width($originals.eq(index).width())
			});
			return $helper;
		};

		$("#wcaiocc_currency_table tbody").sortable({
			helper: fixHelper,
			placeholder: 'wcaiocc_currencies_highlight',
			axis: 'y',
			update: function () {
				wcaiocc_update_currencies_list();
			}
		}); 

		// Add rows from DB:
		var available_currencies = jQuery.parseJSON($('#wcaiocc_available_currencies').val()); // create JSON-object from string from DB
		$.each(available_currencies, function (currency_code) { // loop through JSON array
			wcaiocc_add_new_currency(currency_code, available_currencies[currency_code], true); // trigger function with only one currency data
		});

	}

});


// Add new currency to the list/table from a select box:
function wcaiocc_add_new_currency_blob(row_data_blob) {

	var row_data = row_data_blob.split('#data_sep#'); // string split to array
	var currency_code = row_data[0];
	var currency_data = {};
	currency_data['name'] = row_data[1];
	currency_data['symbol'] = row_data[2];
	currency_data['position'] = row_data[3];
	currency_data['thousand_separator'] = row_data[4];
	currency_data['decimal_separator'] = row_data[5];
	currency_data['number_decimals'] = row_data[6];

	wcaiocc_add_new_currency(currency_code, currency_data, false);

}


// Add new currency to the list/table:
function wcaiocc_add_new_currency(currency_code, currency_data, currency_from_db) { // Print out new table row:

	// If too many currencies already:
	if (jQuery('#wcaiocc_currency_table tr').length > 40){
		alert(wcaiocc_vars_data.too_many_currencies);
		return;
	}

	var currency_name = currency_data['name'];
	var currency_symbol = currency_data['symbol'];
	var currency_position = currency_data['position'];
	var thousand_separator = currency_data['thousand_separator'];
	var decimal_separator = currency_data['decimal_separator'];
	var number_decimals = currency_data['number_decimals'];

	var default_currency = false;
	var disabled_field = ' ';
	if (wcaiocc_vars_data.default_currency == currency_code) {
		default_currency = true;
		disabled_field = ' disabled';
	} else {
		default_currency = false;
		disabled_field = ' ';
	}

	// Change parameters, if we are adding default currency:
	if (default_currency == true) {
		currency_name = wcaiocc_vars_data.default_currency_name;
		currency_symbol = wcaiocc_vars_data.default_currency_symbol;
		currency_position = wcaiocc_vars_data.default_currency_position;
		thousand_separator = wcaiocc_vars_data.default_currency_thousand_separator;
		decimal_separator = wcaiocc_vars_data.default_currency_decimal_separator;
		number_decimals = wcaiocc_vars_data.default_currency_number_decimals;
	}

	if (jQuery("tr[data-wcaiocc-currency-code='" + currency_code + "']").length > 0) {
		alert(wcaiocc_vars_data.currency_already_on_the_list);
		return;
	}

	var row_html = '<tr data-wcaiocc-currency-code="' + currency_code + '">';

	row_html += '<td><div id="wcaiocc_currency_' + currency_code + '_code">' + currency_code + '</div></td>';
	
	row_html += '<td><input id="wcaiocc_currency_' + currency_code + '_name" type="text" value="' + currency_name + '"' + disabled_field + '/></td>';
	
	row_html += '<td><input id="wcaiocc_currency_' + currency_code + '_symbol" type="text" value="' + currency_symbol + '"' + disabled_field + ' /></td>';

	var selected_left = ' ';
	var selected_right = ' ';
	var selected_left_space = ' ';
	var selected_right_space = ' ';
	if (currency_position == 'left'){
		selected_left = ' selected';
	} else if (currency_position == 'right'){
		selected_right = ' selected';
	} else if (currency_position == 'left_space') {
		selected_left_space = ' selected';
	} else if (currency_position == 'right_space') {
		selected_right_space = ' selected';
	}
	row_html += '<td><select id="wcaiocc_currency_' + currency_code + '_currency_position"' + disabled_field + '>';
	row_html += '<option value="left"' + selected_left + '>' + wcaiocc_vars_data.left + ' (' + currency_symbol + '99)</option>';
	row_html += '<option value="right"' + selected_right + '>' + wcaiocc_vars_data.right + ' (99' + currency_symbol + ')</option>';
	row_html += '<option value="left_space"' + selected_left_space + '>' + wcaiocc_vars_data.left_space + ' (' + currency_symbol + ' 99)</option>';
	row_html += '<option value="right_space"' + selected_right_space + '>' + wcaiocc_vars_data.right_space + ' (99 ' + currency_symbol + ')</option>';
	row_html += '</select></td>';
	
	row_html += '<td><input id="wcaiocc_currency_' + currency_code + '_thousand_separator" type="text" value="' + thousand_separator + '"' + disabled_field + ' /></td>';

	row_html += '<td><input id="wcaiocc_currency_' + currency_code + '_decimal_separator" type="text" value="' + decimal_separator + '"' + disabled_field + ' /></td>';

	row_html += '<td><input id="wcaiocc_currency_' + currency_code + '_number_decimals" type="number" value="' + number_decimals + '"' + disabled_field + ' /></td>';

	row_html += '<td>';
	row_html += '<div><a data-wcaiocc-currency-code="' + currency_code + '" class="button" href="#onclick_action" onclick="wcaiocc_remove_currency_from_list(this.getAttribute(\'data-wcaiocc-currency-code\'));">' + wcaiocc_vars_data.remove_currency + '</a></div>';
	row_html += '</td>';

	jQuery('#wcaiocc_currency_table tbody').append(row_html);

	wcaiocc_update_currencies_list();

	// If only one currency left (default one) disable sorting else - enable it again:
	if (jQuery('#wcaiocc_currency_table tr').length <= 2) {
		jQuery("#wcaiocc_currency_table tbody").sortable("disable");
	} else {
		jQuery("#wcaiocc_currency_table tbody").sortable("enable");
	}

	// Add callback to update currencies on changing inputs/selects
	// We need to add it to this function to make sure all inputs and selects already exist
	jQuery("input[id^=wcaiocc_currency_], select[id^=wcaiocc_currency_]").on('change', function () { // attach callback to our inputs and selects
		wcaiocc_update_currencies_list();
	});

	if (currency_from_db == false && default_currency == false) { // if this currency is a new one and not default one
		// silently try to get its rate and save to db:
		// Create POST data array:
		var verification = wcaiocc_vars_data.wp_nonce;
		var action_data = {};
		action_data['currency_data'] = {};
		action_data['currency_data'][currency_code] = {};
		action_data['currency_data'][currency_code]['api'] = wcaiocc_vars_data.default_exchange_api;
		var post_data = {
			action: 'wcaiocc_ajax',
			verification: verification,
			execute: 'update_exchange_rates',
			currency_data: action_data['currency_data']
		};
		// Send Ajax request:
		wcaiocc_block_screen(true); // block screen
		jQuery.post(ajaxurl, post_data, function (response) {
			wcaiocc_block_screen(false); // unblock screen
		});
	}

}


// Update hidden input on various events (sorted table, added item, removed item, modified item...)
function wcaiocc_update_currencies_list() {

	// this function translates the table order and content into JSON to be 
	// stored in hidden input field when saving to DB

	jQuery('#wcaiocc_available_currencies').val(''); // clear input

	var available_currencies = {}; // JSON object with data

	jQuery('#wcaiocc_currency_table tbody tr').each(function (loop_interator) {
		// Get data from objects on screen:
		currency_code = this.getAttribute('data-wcaiocc-currency-code');
		currency_name = jQuery('#wcaiocc_currency_' + currency_code + '_name').val();
		currency_symbol = jQuery('#wcaiocc_currency_' + currency_code + '_symbol').val();
		currency_position = jQuery('#wcaiocc_currency_' + currency_code + '_currency_position').val();
		currency_thousand_separator = jQuery('#wcaiocc_currency_' + currency_code + '_thousand_separator').val();
		currency_decimal_separator = jQuery('#wcaiocc_currency_' + currency_code + '_decimal_separator').val();
		currency_number_decimals = jQuery('#wcaiocc_currency_' + currency_code + '_number_decimals').val();
		// Save data to array (JSON)
		available_currencies[currency_code] = {};
		available_currencies[currency_code]['order'] = loop_interator + 1; // display order (add 1, because loop starts with 0)
		available_currencies[currency_code]['name'] = currency_name;
		available_currencies[currency_code]['symbol'] = currency_symbol;
		available_currencies[currency_code]['position'] = currency_position;
		available_currencies[currency_code]['thousand_separator'] = currency_thousand_separator;
		available_currencies[currency_code]['decimal_separator'] = currency_decimal_separator;
		available_currencies[currency_code]['number_decimals'] = currency_number_decimals;

	});

	// save JSON array to hidden input to be later stored as JSON-string in DB:
	jQuery('#wcaiocc_available_currencies').val(JSON.stringify(available_currencies));

}


// Removes currency from currencies list/table (currency to remove as an argument)
function wcaiocc_remove_currency_from_list(currency_code) {

	if (jQuery('#wcaiocc_currency_table tr').length <= 2) { // if trying to remove the last one, cancel it
		alert(wcaiocc_vars_data.too_few_currencies);
		return false;
	}

	var selector = "tr[data-wcaiocc-currency-code='" + currency_code + "']"; // table row selector (the one to remove)

	jQuery(selector).fadeOut(250, function(){
		jQuery(selector).remove();
		wcaiocc_update_currencies_list();
		// If only one currency left - disable sorting:
		if (jQuery('#wcaiocc_currency_table tr').length <= 2) {
			jQuery("#wcaiocc_currency_table tbody").sortable("disable");
		}
	});

}


/** ------------------------ Currencies section end ------------------------  **/



/** ------------------------ Exchange rates section start ------------------------  **/


jQuery(document).ready(function ($) {

	if ($('input.wcaiocc_exchange_rates').length > 0) { // we're using this condition to check if we are in Exchange rates section

		// Add currency exchange table:
		$('input.wcaiocc_exchange_rates').after(
			'<table class="wcaiocc-exchange-rates-table" id="wcaiocc_exchange_rates_table"></table>'
		);

		// Add header row:
		$('#wcaiocc_exchange_rates_table').append(
			'<thead><tr>' +
			'<th class="wcaiocc_exchange_cell_code">' + wcaiocc_vars_data.currency_code + '</th>' +
			'<th class="wcaiocc_exchange_cell_name">' + wcaiocc_vars_data.currency_name + '</th>' +
			'<th class="wcaiocc_exchange_cell_symbol">' + wcaiocc_vars_data.currency_symbol + '</th>' +
			'<th class="wcaiocc_exchange_cell_api">' + wcaiocc_vars_data.exchange_api + '</th>' +
			'<th class="wcaiocc_exchange_cell_rate">' + wcaiocc_vars_data.exchange_rate + '</th>' +
			'<th class="wcaiocc_exchange_cell_update wcaiocc-center">' + wcaiocc_vars_data.update_rate + '</th>' +
			'</tr></thead>'
		);

		// Add tbody section:
		$('#wcaiocc_exchange_rates_table').append(
			'<tbody></tbody>'
		);

		// Add update all button section:
		$('#wcaiocc_exchange_rates_table').after(
			'<a class="button wcaiocc-update-all-button" href="#onclick_action" onclick="wcaiocc_update_exchange_rates(\'update_all_exchange_rates\');">' + wcaiocc_vars_data.update_all_label + '</a>'
		);		

		// Add rows to table:
		var available_currencies = jQuery.parseJSON($('#wcaiocc_inner_use_currencies_in_use').val()); // create JSON-object from string from DB
		$.each(available_currencies, function (currency_code) { // loop through JSON array
			wcaiocc_add_new_exchange_rate_row(currency_code, available_currencies[currency_code]); // trigger function with only one currency data
		});

	}

});


// Add new currency to the list/table:
function wcaiocc_add_new_exchange_rate_row(currency_code, currency_data) {

	var currency_name = currency_data['name'];
	var currency_symbol = currency_data['symbol'];

	var default_currency = false;
	if (wcaiocc_vars_data.default_currency == currency_code) {
		default_currency = true;
	} else {
		default_currency = false;
	}

	// Change parameters, if we are adding default currency:
	if (default_currency == true) {
		currency_name = wcaiocc_vars_data.default_currency_name;
		currency_symbol = wcaiocc_vars_data.default_currency_symbol;
	}

	var exchange_rate = jQuery('#wcaiocc_exchange_rate_' + currency_code).val();
	var exchange_api = jQuery('#wcaiocc_exchange_api_' + currency_code).val();

	var row_html = '<tr data-wcaiocc-currency-code="' + currency_code + '">';

	row_html += '<td><div id="wcaiocc_exchange_' + currency_code + '_code">' + currency_code + '</div></td>';

	row_html += '<td><div id="wcaiocc_exchange_' + currency_code + '_name">' + currency_name + '</div></td>';

	row_html += '<td><div id="wcaiocc_exchange_' + currency_code + '_symbol">' + currency_symbol + '</div></td>';

	row_html += '<td>';
	if (wcaiocc_vars_data.default_currency == currency_code) {
		row_html += '<div class="wcaiocc_default_exchange_label" id="wcaiocc_currency_' + currency_code + '_default_exchange">&mdash;</div>';
	} else {
		var selected_yahoo = ' ';
		var selected_ecb = ' ';
		var selected_fixer = ' ';
		var selected_fcca = ' ';
		var selected_google = ' ';
		var selected_techunits = ' ';
		if (exchange_api == 'yahoo') {
			selected_yahoo = ' selected';
		} else if (exchange_api == 'ecb') {
			selected_ecb = ' selected';
		} else if (exchange_api == 'fixer') {
			selected_fixer = ' selected';
		} else if (exchange_api == 'fcca') {
			selected_fcca = ' selected';
		} else if (exchange_api == 'google') {
			selected_google = ' selected';
		} else if (exchange_api == 'techunits') {
			selected_techunits = ' selected';
		}
		row_html += '<select id="wcaiocc_exchange_' + currency_code + '_api">';
		row_html += '<option value="yahoo"' + selected_yahoo + '>Yahoo Finance</option>';
		row_html += '<option value="ecb"' + selected_ecb + '>European Central Bank</option>';
		row_html += '<option value="fixer"' + selected_fixer + '>Fixer.io</option>';
		row_html += '<option value="fcca"' + selected_fcca + '>Free Currency Converter API</option>';
		row_html += '<option value="google"' + selected_google + '>Google Finance</option>';
		row_html += '<option value="techunits"' + selected_techunits + '>Techunits Currency Exchange</option>';
		row_html += '</select>';
	}
	row_html += '</td>';

	row_html += '<td>';
	if (default_currency == true) {
		row_html += '<input id="wcaiocc_exchange_' + currency_code + '_rate" type="text" value="' + exchange_rate + '" disabled />';
	} else {
		row_html += '<input id="wcaiocc_exchange_' + currency_code + '_rate" type="text" value="' + exchange_rate + '" />';
	}
	row_html += '</td>';

	row_html += '<td class="wcaiocc-center">';
	if (default_currency == true) {
		row_html += '<div class="wcaiocc_default_exchange_label" id="wcaiocc_currency_' + currency_code + '_default_exchange">&mdash;</div>';
	} else {
		row_html += '<div><a data-wcaiocc-currency-code="' + currency_code + '" class="button" href="#onclick_action" onclick="wcaiocc_update_exchange_rates(this.getAttribute(\'data-wcaiocc-currency-code\'));">' + wcaiocc_vars_data.update_label + '</a></div>';
	}
	row_html += '</td>';

	jQuery('#wcaiocc_exchange_rates_table tbody').append(row_html);

	// Add callback to update exchange rates on changing inputs/selects
	// We need to add it to this function to make sure all inputs and selects already exist
	jQuery("input[id^=wcaiocc_exchange_], select[id^=wcaiocc_exchange_]").on('change', function () { // attach callback to our inputs and selects
		wcaiocc_update_data();
	});

}


// Get exchange rate of one or all currencies:
function wcaiocc_update_exchange_rates(currency) {

	var currencies_to_update = {}; // list of currencies to be updated
	var api_id = '';

	if (currency == 'update_all_exchange_rates') { // loop through all currencies
		jQuery("#wcaiocc_exchange_rates_table > tbody > tr[data-wcaiocc-currency-code]").each(function (index) {
			currency = jQuery(this).attr('data-wcaiocc-currency-code');
			if (currency == wcaiocc_vars_data.default_currency) { // if current currency is default one...
				currencies_to_update[currency] = {};
				currencies_to_update[currency]['api'] = wcaiocc_vars_data.default_exchange_api;
			} else {
				api_id = '#wcaiocc_exchange_' + currency + '_api';
				currencies_to_update[currency] = {};
				currencies_to_update[currency]['api'] = jQuery(api_id).val();
			}	
		});
	} else {
		api_id = '#wcaiocc_exchange_' + currency + '_api';
		currencies_to_update[currency] = {};
		currencies_to_update[currency]['api'] = jQuery(api_id).val();
	}

	// Create array with data needed to update rates:
	action_data = {};
	action_data['name'] = 'update_exchange_rates';
	action_data['currency_data'] = {};
	action_data['currency_data'] = currencies_to_update;
	
	// Call callback function, which will take care of the rest:
	wcaiocc_callback_action(action_data);

}


// Update data in hidden inputs based on exchange rate table data:
function wcaiocc_update_data() {	

	var currency = null;
	var rate = null;
	var api = null;
	var rate_id = null;
	var api_id = null;
	jQuery("#wcaiocc_exchange_rates_table > tbody > tr[data-wcaiocc-currency-code]").each(function (index) {	
		currency = jQuery(this).attr('data-wcaiocc-currency-code');
		rate_id = '#wcaiocc_exchange_' + currency + '_rate';
		api_id = '#wcaiocc_exchange_' + currency + '_api';
		rate = jQuery(rate_id).val();
		rate = rate.replace(",", "."); // just to be sure - replace colon with coma
		rate = parseFloat(rate); // make sure we are dealing with float here (and trim trailing decimal zeros)
		if (rate !== rate) { // rate field left empty - interestingly, NaN is not equal to itself, so if rate is different than itself, it means it's a NaN
			rate = 1; // therefore, we just make it 1
		}
		jQuery(rate_id).val(rate); // and update the input field
		api = jQuery(api_id).val();
		
		// Populate hidden fields:
		jQuery('#wcaiocc_exchange_rate_' + currency).val(rate);
		jQuery('#wcaiocc_exchange_api_' + currency).val(api);
	});

}


/** ------------------------ Exchange rates section end ------------------------  **/



/** ------------------------ Display section start ------------------------  **/


jQuery(document).ready(function ($) {

	if ($('#wcaiocc_currency_switcher_text').length > 0) { // we're using this condition to check if we are in Display section
		
		// nothing to do here!

	}

});


/** ------------------------ Display section end ------------------------  **/



/** ------------------------ Advanced section start ------------------------  **/


jQuery(document).ready(function ($) {

	if ($('input.wcaiocc_advanced_additional_restore_defaults_input').length > 0) { // we're using this condition to check if we are in Advanced section

		var country_currency_json_string = $("#wcaiocc_country_list_data").val();
		var country_currency_data = jQuery.parseJSON(country_currency_json_string);

		var change_currencies = '<div id="wcaiocc_country_currency_modal" style="display:none;">';

		change_currencies += '<table class="wcaiocc_countries_currencies_table">';
		change_currencies += '<thead><tr>';
		change_currencies += '<td class="wcaiocc_countries_currencies_first_column"><h4>' + wcaiocc_vars_data.country_iso_code + '</h4></td>';
		change_currencies += '<td class="wcaiocc_countries_currencies_second_column"><h4>' + wcaiocc_vars_data.currency_iso_code + '</h4></td>';
		change_currencies += '</tr></thead>';
		change_currencies += '<tbody>';

		$.each(country_currency_data, function (country_code, currency) {
			change_currencies += '<tr class="wcaiocc_country_currency_row">';
			change_currencies += '<td><input type="text" class="wcaiocc_country_currency_country" maxlength="2" value="' + country_code + '" disabled /></td>';
			change_currencies += '<td><input type="text" class="wcaiocc_country_currency_code" maxlength="3" value="' + currency + '" /></td>';
			change_currencies += '</tr>';
		});

		change_currencies += '</tbody>';
		change_currencies += '</table>';

		change_currencies += '<div id="wcaiocc_change_country_currency_buttons_wrapper">';
		change_currencies += '<input id="wcaiocc_change_country_currency_save_changes_button" name="" class="button-primary" type="submit" value="' + wcaiocc_vars_data.save_changes_button + '" />';
		change_currencies += '<a id="wcaiocc_add_country_button" class="button" href="#onclick_action">' + wcaiocc_vars_data.add_country_button + '</a>';
		change_currencies += '</div>';

		change_currencies += '</div>';


		change_currencies += '<a class="button thickbox" title="WooCommerce All in One Currency Converter" href="#TB_inline?height=600&width=310&inlineId=wcaiocc_country_currency_modal">' + wcaiocc_vars_data.change_currencies_button + '</a>';

		// Add button to open countries currencies modal:
		$('#wcaiocc_country_list_data').after(change_currencies);

		$("#wcaiocc_add_country_button").on('click', function () {
			var new_country = '';
			new_country += '<tr class="wcaiocc_country_currency_row">';
			new_country += '<td><input type="text" class="wcaiocc_country_currency_country" maxlength="2" value="" /></td>';
			new_country += '<td><input type="text" class="wcaiocc_country_currency_code" maxlength="3" value="" /></td>';
			new_country += '</tr>';
			$(".wcaiocc_countries_currencies_table > tbody").append(new_country);
			$('#TB_ajaxContent').scrollTop($('#TB_ajaxContent')[0].scrollHeight); // scroll to the bottom
			$("input.wcaiocc_country_currency_country:last-of-type").focus(); // focus on new input
		});

		$("#wcaiocc_change_country_currency_save_changes_button").on('click', function () {
			$("#wcaiocc_country_list_data").val(''); // set woocommerce setting field to empty
			var current_country = '';
			var current_currency = '';
			var all_countries_currencies = {};
			$("tr.wcaiocc_country_currency_row").each(function () { // loop through all countries
				current_country = $(this).find("input.wcaiocc_country_currency_country").val();
				current_currency = $(this).find("input.wcaiocc_country_currency_code").val();
				if (current_country == '' || current_currency == '') {
					return true; // skip iteration if one of the fields is empty
				}
				all_countries_currencies[current_country] = current_currency;
			});
			var all_countries_currencies_json_string = JSON.stringify(all_countries_currencies);
			$("#wcaiocc_country_list_data").val(all_countries_currencies_json_string); // fill woocommerce settings field with json string
			$('#mainform .submit input[name="save"]').click(); // save page
		});

		var restore_default_settings = '<a class="button" href="#onclick_action" onclick="wcaiocc_callback_action(\'restore_defaults\');">' + wcaiocc_vars_data.restore_defaults_button + '</a>';
		// Add button to restore defaults:
		$('input.wcaiocc_advanced_additional_restore_defaults_input').after(restore_default_settings);

	}

});


/** ------------------------ Advanced section end ------------------------  **/