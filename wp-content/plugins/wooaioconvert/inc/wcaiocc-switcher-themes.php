<?php

/**
 *
 * Plugin: WooCommerce All in One Currency Converter
 * Author: http://dev49.net
 *
 * This file contains code responsible for currency switchers
 *
 */


// Exit if accessed directly:
if (!defined('ABSPATH')){
	exit;
}


// Register themes:
add_filter('wcaiocc_currency_switcher_themes', 'wcaiocc_register_base_themes', 10);
// Add themes (css and js code is in css and js folders):
add_filter('wcaiocc_currency_switcher_theme_dropdown', 'wcaiocc_theme_dropdown', 10, 2);
add_filter('wcaiocc_currency_switcher_theme_buttons', 'wcaiocc_theme_buttons', 10, 2);


// Register themes:
function wcaiocc_register_base_themes($themes = array()){

	$replace_rule = 'inc/'; // this will be removed
	$replace_rule = preg_quote($replace_rule, '/'); // necessary to deal with slash in the URL
	$plugin_url = plugin_dir_url(__FILE__);
	$plugin_url = preg_replace('/(' . $replace_rule . ')+$/', '', $plugin_url); // remove $replace rule only when it is at the end of the string

	// Add base themes to themes array:
	$themes['dropdown'] = array(
		'name' => __("Dropdown list",  'woocommerce-all-in-one-currency-converter'),
		'image_url' => $plugin_url . 'img/switcher_themes/dropdown.png'
	);
	$themes['buttons'] = array(
		'name' => __("Buttons",  'woocommerce-all-in-one-currency-converter'),
		'image_url' => $plugin_url . 'img/switcher_themes/buttons.png'
	);

	return $themes;

}


// Dropdown theme:
function wcaiocc_theme_dropdown($html_output = '', $params = array()){

	if (!empty($params)){

		$currency = $params['active_currency'];
		$available_currencies = $params['available_currencies'];
		$default_currency = $params['base_currency'];
		$currency_data = $params['currencies_data'];
		$currency_switcher_text = $params['currency_switcher_text'];
		$currency_switcher_display_template = $params['currency_display_template'];

		ob_start(); // buffer the HTML code (later it's being outputted by echoing it or just returning it, depending on what called the function)
		?>

		<div class="wcaiocc-switcher-dropdown wcaiocc-container">
			<p class="wcaiocc-text"><?php echo $currency_switcher_text; ?></p>
			<select class="wcaiocc-select" name="wcaiocc_change_currency_code" title="Currency">
				<?php
				foreach ($available_currencies as $currency_code):
					$currency_option = '<option class="wcaiocc-option" value="' . $currency_code . '" ';
					if ($currency == $currency_code){
						$currency_option .='selected'; // if this is active currency, select it in dropdown list
					}
					$currency_option .= '>';
					if (empty($currency_switcher_display_template)){ // if user didnt specify a template...
						$currency_option .= $currency_data[$currency_code]['name'] . ' (' . $currency_code . ')'; // ...use default one
					} else { // otherwise, use the one specified by the user
						$custom_currency_display = $currency_switcher_display_template;
						$custom_currency_display = str_replace('%code%', $currency_code, $custom_currency_display);
						$custom_currency_display = str_replace('%name%', $currency_data[$currency_code]['name'], $custom_currency_display);
						$custom_currency_display = str_replace('%symbol%', $currency_data[$currency_code]['symbol'], $custom_currency_display);
						$currency_option .= $custom_currency_display;
					}
					$currency_option .= '</option>';
					echo $currency_option;
				endforeach;
				?>
			</select>
		</div>

		<?php
		$html_output = ob_get_clean();

	}

	return $html_output;

}


// Buttons theme:
function wcaiocc_theme_buttons($html_output = '', $params = array()) {

	if (!empty($params)){

		$currency = $params['active_currency'];
		$available_currencies = $params['available_currencies'];
		$default_currency = $params['base_currency'];
		$currency_data = $params['currencies_data'];
		$currency_switcher_text = $params['currency_switcher_text'];
		$currency_switcher_display_template = $params['currency_display_template'];

		ob_start(); // buffer the HTML code (later it's being outputted by echoing it or just returning it, depending on what called the function)
		?>

		<div class="wcaiocc-switcher-buttons wcaiocc-container">
			<p class="wcaiocc-text"><?php echo $currency_switcher_text; ?></p>
			<ul class="wcaiocc-list">
				<?php
				foreach ($available_currencies as $currency_code):
					$currency_option = '<li class="wcaiocc-list-item">';
					$currency_option .= '<a data-wcaiocc-currency="' . $currency_code . '" class="wcaiocc-list-item-link ';
					if ($currency == $currency_code){ // if this is active currency, add selected class to it
						$currency_option .= 'selected';
					}
					$currency_option .= '" href="" onclick="return false;">';
					if (empty($currency_switcher_display_template)){ // if user didnt specify a template...
						$currency_option .= $currency_code; // ...use default one
					} else { // otherwise, use the one specified by the user
						$custom_currency_display = $currency_switcher_display_template;
						$custom_currency_display = str_replace('%code%', $currency_code, $custom_currency_display);
						$custom_currency_display = str_replace('%name%', $currency_data[$currency_code]['name'], $custom_currency_display);
						$custom_currency_display = str_replace('%symbol%', $currency_data[$currency_code]['symbol'], $custom_currency_display);
						$currency_option .= $custom_currency_display;
					}
					$currency_option .= '</a></li>';
					echo $currency_option;
				endforeach;
				?>
			</ul>
		</div>

		<?php
		$html_output = ob_get_clean();

	}

	return $html_output;

}
