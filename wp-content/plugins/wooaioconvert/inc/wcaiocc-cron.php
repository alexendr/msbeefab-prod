<?php

/**
 * 
 * Plugin: WooCommerce All in One Currency Converter
 * Author: http://dev49.net
 *
 * This file contains cron job function definition
 *
 */

// Exit if accessed directly:
if (!defined('ABSPATH')){ 
    exit; 
}

// Cron job function definition:
function wcaiocc_cron_currency_exchange_rate_update(){
	
	global $woocommerce_all_in_one_currency_converter;
	$action_data = array();
	$action_data['name'] = 'update_exchange_rates';
	$action_data['currency_data'] = array();	
	
	$available_currencies_json = get_option('wcaiocc_available_currencies');
	$available_currencies = json_decode($available_currencies_json, true);
	$requested_currencies_data = array();
	
	foreach ($available_currencies as $code => $currency_data){
		$requested_currencies_data[$code] = array();
		$exchange_api = get_option('wcaiocc_exchange_api_' . $code);
		$requested_currencies_data[$code]['api'] = $exchange_api;
	}
	
	$action_data['currency_data'] = $requested_currencies_data;
	
	$woocommerce_all_in_one_currency_converter->callbacks->execute_action($action_data, true); // execute rates update
	
	return true;
	
}
