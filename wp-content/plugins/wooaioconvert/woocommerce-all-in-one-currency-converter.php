<?php

/**
 * Plugin Name: WooCommerce All in One Currency Converter
 * Version: 2.7
 * Plugin URI: http://dev49.net
 * Description: Feature-packed currency converter plugin for WordPress WooCommerce stores.
 * Tags: woocommerce, currency, currency converter, currency switcher, woocommerce convert currency, woocommerce switch currency
 * Author: Dev49.net
 * Author URI: http://dev49.net
 * Requires at least: 4.5
 * Tested up to: 4.5.3
 * WC requires at least: 2.5.0
 * WC tested up to: 2.6.2
 */


/** WooCommerce All in One Currency Converter **/


// Exit if accessed directly:
if (!defined('ABSPATH')){ 
    exit; 
}


//define('WCAIOCC_DEBUG', true);


// Require all classes and scripts:
require('inc/class-wcaiocc-main.php'); // main plugin class (kind of a wrapper)
require('inc/class-wcaiocc-frontend.php'); // frontend plugin class (for website visitors)
require('inc/class-wcaiocc-admin.php'); // back-end plugin class (for site admin)
require('inc/class-wcaiocc-callbacks.php'); // callbacks (updating rates, restoring settings / ajax functionality)
require('inc/class-wcaiocc-settings.php'); // settings class (for loading/verifying data)
require('inc/class-wcaiocc-widget.php'); // currency switcher widget class
require('inc/class-wcaiocc-update-notifier.php'); // update notifier class
require('inc/wcaiocc-shortcodes.php'); // shortcodes, including currency switcher display
require('inc/wcaiocc-switcher-themes.php'); // currency switcher themes
require('inc/wcaiocc-cron.php'); // cron job


if (empty($woocommerce_all_in_one_currency_converter)){
    $woocommerce_all_in_one_currency_converter = new WooCommerce_All_in_One_Currency_Converter_Main(__FILE__); // Initiate the plugin by instantiating main class (we're passing the plugin root path)
}