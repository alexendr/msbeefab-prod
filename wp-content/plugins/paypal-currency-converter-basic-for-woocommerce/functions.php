<?php
/* Functions for PayPal Currency Converter BASIC for WooCommerce
 */
 
// Multisite handling
// see if site is network activated
if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
	// Makes sure the plugin is defined before trying to use it
	require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
}
if (is_plugin_active_for_network(plugin_basename(__FILE__))) {  // path to plugin folder and main file
	define("PPCC_NETWORK_ACTIVATED", true);
	
}
else {
	define("PPCC_NETWORK_ACTIVATED", false);
}

//constant PPCC options name
$option_name = 'ppcc-options';

// Wordpress function 'get_site_option' and 'get_option'
function get_ppcc_option($option_name) {

	if(PPCC_NETWORK_ACTIVATED == true) {

		// Get network site option
		return get_site_option($option_name);
	}
	else {

		// Get blog option
		if(function_exists('get_blog_option')){
			return get_blog_option(get_current_blog_id(),$option_name);			
		}
		else{
			return get_option($option_name);
		}
	}
}

// Wordpress function 'update_site_option' and 'update_option'
function update_ppcc_option($option_name, $option_value) {

	if(PPCC_NETWORK_ACTIVATED== true) {

		// Update network site option
		return update_site_option($option_name, $option_value);
	}
	else {

	// Update blog option
	return update_option($option_name, $option_value);
	}
}

// Wordpress function 'delete_site_option' and 'delete_option'
function delete_ppcc_option($option_name) {

	if(PPCC_NETWORK_ACTIVATED== true) {

		// Delete network site option
		return delete_site_option($option_name);
	}
	else {

	// Delete blog option
	return delete_option($option_name);
	}
}
/*check CURL*/
function ppcc_is_curl_installed() {
    if  (in_array  ('curl', get_loaded_extensions())) {
        return true;
    }
    else {
        return false;
    }
}

 
//retrieve EX data from the api
function get_exchangerate($from,$to) {
	global $option_name;
	//update the retrieval counter
	$options = get_ppcc_option($option_name);
	$options['retrieval_count'] = $options['retrieval_count'] + 1;
	update_ppcc_option( $option_name, $options );
	$precision = $options['precision'];

	switch ($options['api_selection']) {
	    case "custom":
	        return $options['conversion_rate'];
	        break;    
	    default:
	        echo '<div class="error settings-error"><p>Please select EXR Source first</p></div>';
			return 1;
			exit;
	} //end of switch
	
}

	
	
/**
 * Checks if WooCommerce is active
 * @return bool true if WooCommerce is active, false otherwise
 */
 
if(!function_exists ( 'is_woocommerce_active' )){
	function is_woocommerce_active() {

		$active_plugins = (array) get_ppcc_option( 'active_plugins', array() );

		if ( is_multisite() )
			$active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );

		return in_array( 'woocommerce/woocommerce.php', $active_plugins ) || array_key_exists( 'woocommerce/woocommerce.php', $active_plugins );
	}	
}
?>