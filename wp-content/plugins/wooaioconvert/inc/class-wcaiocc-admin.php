<?php

/**
 * 
 * Plugin: WooCommerce All in One Currency Converter
 * Author: http://dev49.net
 *
 * WooCommerce_All_in_One_Currency_Converter_Admin class is a backend-class (admin) for the plugin.
 *
 * This class is responsible for all WP-Admin actions - adding plugin configuration UI to WooCommerce Settings page,
 * modifying the database (when applying settings), checking PHP, WooCommerce and WordPress compatibility (along with
 * making sure WooCommerce is active).
 *
 */

// Exit if accessed directly:
if (!defined('ABSPATH')){ 
    exit; 
}

class WooCommerce_All_in_One_Currency_Converter_Admin {
	
	
	private $settings; // We're going to assign Settings object to this property	
	private $id; // Settings tab name
	private $label; // Settings tab label
	
	
	/**
	 * Initiate object: set properties, add appropriate WP and WC filters, register callbacks
	 */
	public function __construct($settings){ // $settings = instance of WooCommerce_All_in_One_Currency_Converter_Settings
		
		// Assign settings object to class property, so we can easily access it from other methods:
		$this->settings = $settings;
		$this->id = 'currency_converter'; // new settings tab name
		
		// WordPress hooks:
		add_action('admin_enqueue_scripts', array($this, 'add_scripts')); // Add css and js files (only for admin dashboard)
		add_action('woocommerce_settings_save_general', array($this, 'check_base_currency'), 9999); // check to see if user hasnt changed his base currency (action after WC general settings save)
		add_filter('plugin_action_links_' . plugin_basename($this->settings->get_plugin_path()), array($this, 'add_settings_link')); // Add settings link on plugins page
		add_action('admin_init', array($this, 'plugin_update'), 9999); // update notification - check for updates
		add_action('add_meta_boxes', array($this, 'add_meta_box_to_order_page')); // add plugin's meta box to order page
		add_action('save_post', array($this, 'save_meta_box_from_order_page')); // used to store currency meta box in the database
		
		// Check if WooCommerce is active:
		if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))){
			// If WC active, add WC filters/hooks/actions:
			add_filter('woocommerce_settings_tabs_array', array($this, 'add_settings_page'), 9999); // Add new WooCommerce settings tab
			add_action('woocommerce_settings_' . $this->id, array($this, 'output'), 9999); // Output settings page
			add_action('woocommerce_settings_save_' . $this->id, array($this, 'save'), 9999); // Save current section
			add_action('woocommerce_sections_' . $this->id, array($this, 'output_sections'), 9999); // Display section list
			add_filter('woocommerce_currency_symbol', array($this, 'custom_currency_symbol'), 9999, 2); // switch currency symbol
			add_filter('wc_price_args', array($this, 'price_formatting'), 1); // price formatting 			
		}
		
	}
	
	
	/**
	 * Add plugin CSS and JS files for admin dashboard
	 */
	public function add_scripts(){

		// Add main admin CSS file:
		if (defined('WCAIOCC_DEBUG')){
			wp_enqueue_style('wcaiocc-admin-style-handle', $this->settings->get_plugin_dir_url() . 'css/wcaiocc-admin.css');
		} else {
			wp_enqueue_style('wcaiocc-admin-style-handle', $this->settings->get_plugin_dir_url() . 'css/wcaiocc-admin.min.css');
		}

		// Add main admin JS file (make sure jquery and jquery-ui-sortable are enqueued as well):		
		if (defined('WCAIOCC_DEBUG')){
			wp_enqueue_script('wcaiocc-admin-script-handle', $this->settings->get_plugin_dir_url() . 'js/wcaiocc-admin.js', array('jquery', 'jquery-ui-sortable', 'jquery-effects-fade')	);
		} else {
			wp_enqueue_script('wcaiocc-admin-script-handle', $this->settings->get_plugin_dir_url() . 'js/wcaiocc-admin.min.js', array('jquery', 'jquery-ui-sortable', 'jquery-effects-fade')	);
		}
		
		// this is probably the safest way to check if WooCommerce is active. We need this function, so if it exsists, we can continue with other stuff:
		if (function_exists('get_woocommerce_currency')){
			// Add variables to be accessed in JS files:
			$js_variables = array(
				'default_currency' => get_woocommerce_currency(),			
				'default_currency_name' => $this->settings->get_currency_name(),
				'default_currency_symbol' => get_woocommerce_currency_symbol(),
				'default_currency_position' => get_option('woocommerce_currency_pos'),
				'default_currency_thousand_separator' => wc_get_price_thousand_separator(),
				'default_currency_decimal_separator' => wc_get_price_decimal_separator(),
				'default_currency_number_decimals' => wc_get_price_decimals(),			
				'default_exchange_rate' => $this->settings->get_exchange_rate(),
				'default_exchange_api' => $this->settings->get_exchange_api(),
				'too_many_currencies' => __('You cannot use more than 40 currencies.', 'woocommerce-all-in-one-currency-converter'),
				'too_few_currencies' => __('You must use at least one currency.', 'woocommerce-all-in-one-currency-converter'),
				'currency_already_on_the_list' => __('This currency is already on the currencies list.', 'woocommerce-all-in-one-currency-converter'),
				'is_default_currency' => __('Default currency', 'woocommerce-all-in-one-currency-converter'),
				'add_currency_to_list' => __('+ Add selected currency to the list', 'woocommerce-all-in-one-currency-converter'),
				'currency_code' => __('Currency code', 'woocommerce-all-in-one-currency-converter'),
				'currency_name' => __('Currency name', 'woocommerce-all-in-one-currency-converter'),
				'currency_symbol' => __('Currency symbol', 'woocommerce-all-in-one-currency-converter'),
				'currency_position' => __('Currency position', 'woocommerce-all-in-one-currency-converter'),
				'thousand_separator' => __('Thousand separator', 'woocommerce-all-in-one-currency-converter'),
				'decimal_separator' => __('Decimal separator', 'woocommerce-all-in-one-currency-converter'),
				'number_decimals' => __('Number of decimals', 'woocommerce-all-in-one-currency-converter'),	
				'remove_currency' => __('Remove currency', 'woocommerce-all-in-one-currency-converter'),				
				'left' => __('Left', 'woocommerce-all-in-one-currency-converter'),
				'right' => __('Right', 'woocommerce-all-in-one-currency-converter'),
				'left_space' => __('Left with space', 'woocommerce-all-in-one-currency-converter'),
				'right_space' => __('Right with space', 'woocommerce-all-in-one-currency-converter'),
				'exchange_api' => __('Currency exchange rate API', 'woocommerce-all-in-one-currency-converter'),
				'exchange_rate' => __('Currency exchange rate', 'woocommerce-all-in-one-currency-converter'),
				'update_rate' => __('Update using API', 'woocommerce-all-in-one-currency-converter'),
				'update_label' => __('Update now &nbsp;&#8635;', 'woocommerce-all-in-one-currency-converter'),
				'update_all_label' => __('Update all exchange rates &nbsp;&#8635;', 'woocommerce-all-in-one-currency-converter'),
				'restore_defaults_button' => __('Restore default settings', 'woocommerce-all-in-one-currency-converter'),
				'change_currencies_button' => __('Change currencies', 'woocommerce-all-in-one-currency-converter'),
				'save_changes_button' => __('Save changes', 'woocommerce-all-in-one-currency-converter'), 
				'country_iso_code' => __('2-letter ISO 3166-1 country code', 'woocommerce-all-in-one-currency-converter'), 
				'currency_iso_code' => __('3-digit ISO 4217 currency code', 'woocommerce-all-in-one-currency-converter'), 
				'add_country_button' => __('Add country', 'woocommerce-all-in-one-currency-converter'), 
				'confirm_restore_defaults_msg' => __('Are you sure you want to restore Currency Converter to its default configuration? This will erase all your plugin data!', 'woocommerce-all-in-one-currency-converter'),
				'operation_could_not_be_completed_msg' => __('Server error occured - operation could not be completed. Please try again later.',  'woocommerce-all-in-one-currency-converter'),
				'error_currency_exchange_rate_update_msg' => __('Error occured while updating the currency exchange rate. Please try using different API(s). The following currencies were not updated: ',  'woocommerce-all-in-one-currency-converter'),
				'success_currency_exchange_rate_update_msg' => __('Exchange rates have been updated successfully.',  'woocommerce-all-in-one-currency-converter'),
				'plugin_dir_url' => $this->settings->get_plugin_dir_url(),
				'wp_nonce' => wp_create_nonce('woocommerce-all-in-one-currency-converter-nonce') // create nonce to verify ajax request
			);
			wp_localize_script('wcaiocc-admin-script-handle', 'wcaiocc_vars_data', $js_variables);
		}
		
	}
	
	
	/**
	 * Update/update notification system
	 */
	public function plugin_update(){
		
		if (!$this->settings->is_plugin_activated()){
			return false;
		} else {
			$plugin_dir = dirname($this->settings->get_plugin_path()); // this gives us full path to our plugin directory
			$dir_name = basename($plugin_dir); // this gives us only last directory in path (plugin directory - woocommerce-all-in-one-currency-converter)
			$file_name = $dir_name . '.php'; 
			$plugin_slug = "$dir_name/$file_name"; // just plugin dir and filename
			$plugin_location = "$plugin_dir/$file_name"; // full absolute path
			
			$plugin_data = get_plugin_data($plugin_location);
			$version = $plugin_data['Version'];
			
			$update_api = 'http://api.dev49.net/edge/get/product/woocommerce-all-in-one-currency-converter/update_data/';	
			$license_key = $this->settings->get_activation_code();
			
			new WooCommerce_All_in_One_Currency_Converter_Update_Notifier($version, $update_api, $plugin_slug, $license_key);
		}		
		
	}
	
	
	/**
	 * Add plugin's meta box to edit order page
	 */
	public function add_meta_box_to_order_page(){
		
		add_meta_box('wcaiocc_currency_meta_box', __('Order currency', 'woocommerce-all-in-one-currency-converter'), 
			array($this, 'display_order_page_meta_box'), 'shop_order', 'side', 'high'
		);		
		
	}
	
	
	/**
	 * Display plugin's meta box on order edit page
	 */
	public function display_order_page_meta_box($post){

		wp_nonce_field('wcaiocc_order_meta_box_save', 'wcaiocc_order_meta_box_nonce');
		
		$order = new WC_Order($post);
		$order_currency_code = $order->get_order_currency();
		if (empty($order_currency_code)){ // if we are creating the order, let's set it to base currency
			$order_currency_code = get_woocommerce_currency();
		}
		$order_id = $order->id; // this is the post id for this order - NOT THE ORDER NUMBER. Order number can be different than its ID!

		$currency_code_options = get_woocommerce_currencies();
		foreach ($currency_code_options as $code => $name) { // form the list similarily to how WooCommerce does it in General settings section
			$currency_code_options[$code] = $code . ' - ' . $name . ' (' . get_woocommerce_currency_symbol($code) . ')';
		}

		if (empty($currency_code_options[$order_currency_code])){ // if currency used for this order is not among WC currencies, let's just add it manually (without name)
			$currency_code_options[$code] = $code;
		}
		
		$currency_list_html = '<select name="wcaiocc_order_currency" id="wcaiocc_order_currency">';

		foreach ($currency_code_options as $code => $name){
			$currency_selected_text = '';
			if ($code == $order_currency_code){
				$currency_selected_text = ' selected';
			}			
			$currency_list_html .= '<option value="' . $code . '"' . $currency_selected_text . '>' . $name . '</option>';
		}

		$currency_list_html .= '</select>';

		$meta_box_content_html = '<h4>';
		$meta_box_content_html .= __('Choose order currency', 'woocommerce-all-in-one-currency-converter');
		$meta_box_content_html .= '<span class="woocommerce-help-tip" data-tip="';
		$meta_box_content_html .= __("Select currency here and click Save Order for change to take effect. Please keep in mind that changing currency WILL NOT convert order items prices.", 'woocommerce-all-in-one-currency-converter');
		$meta_box_content_html .= '"></span></h4>';
		$meta_box_content_html .= $currency_list_html;

		echo $meta_box_content_html;
		
	}
	
	
	/**
	 * Saves data from meta box to DB
	 */
	public function save_meta_box_from_order_page($post_id){

		if (!isset($_POST['wcaiocc_order_meta_box_nonce'])){ // nonce not in POST data
			return;
		}	
		
		$nonce = $_POST['wcaiocc_order_meta_box_nonce'];

		if (!wp_verify_nonce($nonce, 'wcaiocc_order_meta_box_save')){ // verify nonce
			return;
		}

		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
			return;
		}

		if (empty($_POST['post_type']) || $_POST['post_type'] != 'shop_order'){
			return;
		}

		if (!current_user_can('edit_shop_orders', $post_id)){
			return;
		}

		if (empty($_POST['wcaiocc_order_currency'])){
			return;
		}

		$new_order_currency = sanitize_text_field($_POST['wcaiocc_order_currency']);
		
		update_post_meta($post_id, '_order_currency', $new_order_currency);

	}
	
	
	/**
	 * Check to see if user hasnt changed his base currency - if he has, update exchange rates
	 */
	public function check_base_currency(){
		
		$woocommerce_currency = get_option('woocommerce_currency');
		$currency = $this->settings->get_option('woocommerce_base_currency');
		
		if ($woocommerce_currency != $currency){
			
			$this->settings->update_option('woocommerce_base_currency', $woocommerce_currency); // update plugin option
			$currencies_data = $this->settings->get_currency_data();
			$currencies_list = array();
			
			foreach ($currencies_data as $code => $data){
				$currencies_list[$code] = array();
				$currencies_list[$code]['api'] = $this->settings->get_exchange_api();
			}
			
			$update_results = $this->settings->update_exchange_rates($currencies_list); // update exchange rates
			
			$failed_currencies = array(); // array containing currencies code which were not updated
			foreach ($update_results as $currency_code => $currency_data){				
				// First we need to check if there were problems; if there were - dont update
				if ($currency_data['error'] != 0){
					$failed_currencies[] = $currency_code; // add currency code to failed_currencies array
				}
			}
			
			if (empty($failed_currencies)){
				$message = __('WooCommerce base currency has been changed. Exchange rates of your currencies have been automatically updated using default API.',  'woocommerce-all-in-one-currency-converter');
				$message_class = 'updated';
			} else {
				$failed_currencies_txt = '';
				foreach ($failed_currencies as $failed_currency){
					$failed_currencies_txt .= $failed_currency . ', ';
				}
				$failed_currencies_txt = substr($failed_currencies_txt, 0, -2);
				$message = sprintf(__('WooCommerce base currency has been changed. Exchange rates of your currencies have been automatically updated using default API. There were problems with updating the following currencies: %s.',  'woocommerce-all-in-one-currency-converter'), $failed_currencies_txt);
				$message_class = 'error';
			}			
			echo '<div id="wcaiocc_message" class="' . $message_class . ' fade"><p><strong>' . esc_html($message) . '</strong></p></div>';
		}
		
	}
	
	
	/**
	 * Switch currency symbol to the pre-configured one
	 */
	public function custom_currency_symbol($currency_symbol, $currency){
		
		if (get_woocommerce_currency() == $currency){ // if we are filtering default currency, return default settings
			return $currency_symbol;
		}
		
		$currency_data = $this->settings->get_currency_data(); // get all currency data
		
		if (empty($currency_data[$currency])){ // if we do not have this currency data in our array, return default settings
			return $currency_symbol;
		}
		
		$currency_symbol = $currency_data[$currency]['symbol'];
			
		return $currency_symbol;		
		
	}
	
	
	/**
	 * Price formatting (currency position, decimal/thousand separator etc.)
	 */
	public function price_formatting($default_args){
		
		$currency = $default_args['currency'];
			
		if (get_woocommerce_currency() == $currency){ // if we are filtering default currency, return default settings
			return $default_args;
		}
		
		$currency_data = $this->settings->get_currency_data(); // get all currency data
		
		if (empty($currency_data[$currency])){ // if we do not have this currency data in our array, return default settings
			return $default_args;
		}			
			
		$args = array();
			
		switch ($currency_data[$currency]['position']){
			case 'left':
				$format = '%1$s%2$s';
				break;
			case 'right':
				$format = '%2$s%1$s';
				break;
			case 'left_space':
				$format = '%1$s&nbsp;%2$s';
				break;
			case 'right_space':
				$format = '%2$s&nbsp;%1$s';
				break;
			default:
				$format = $default_args['price_format'];
				break;
		}
			
		$args['ex_tax_label'] = $default_args['ex_tax_label'];
		$args['currency'] = $currency;
		$args['decimal_separator'] = $currency_data[$currency]['decimal_separator'];
		$args['thousand_separator'] = $currency_data[$currency]['thousand_separator'];
		$args['decimals'] = $currency_data[$currency]['number_decimals'];
		$args['price_format'] = $format;	
		
		return $args;
		
	}
	
	
	/**
	 * Add settings link under plugin name on Plugins page
	 */
	public function add_settings_link($links){
		
		// add localised Settings link do plugin settings on plugins page:
		$settings_link = '<a href="' . admin_url('admin.php?page=wc-settings&tab=currency_converter') . '">' . __('Settings', 'woocommerce-all-in-one-currency-converter') . '</a>';
		array_unshift($links, $settings_link);
		return $links;
		
    }	
	
	
	/**
	 * Get tab sections
	 */
	public function get_sections(){

		$sections = array(
			'' => __('General', 'woocommerce-all-in-one-currency-converter'),
			'currencies' => __('Currencies', 'woocommerce-all-in-one-currency-converter'),
			'exchange_rates' => __('Exchange rates', 'woocommerce-all-in-one-currency-converter'),
			'display' => __('Display', 'woocommerce-all-in-one-currency-converter'),
			'advanced' => __('Advanced', 'woocommerce-all-in-one-currency-converter')
		);
		
		// Add activation section only if plugin has not been activated yet:
		 if (!$this->settings->is_plugin_activated()){
			$sections['plugin_activation'] = __('<strong style="text-decoration:underline">Plugin activation</strong>', 'woocommerce-all-in-one-currency-converter');
		} 

		return apply_filters('woocommerce_get_sections_' . $this->id, $sections);
		
    }
	
	
	/**
	 * Display current section
	 */
	public function output(){
		
		global $current_section;
		$configuration = $this->get_settings($current_section);
		woocommerce_admin_fields($configuration);
		
    }
	
	
	/**
	 * Save current section settings
	 */
	public function save(){
		
		global $current_section;
		$configuration = $this->get_settings($current_section);
		woocommerce_update_options($configuration);
		
    }
	
	
	/**
	 * Get tab fields for specified section
	 */
	public function get_settings($current_section = ''){
		
		$configuration = null; // initialize empty $configuration var
		
		if ($current_section == 'plugin_activation'){
			
			$activation_code = $this->settings->get_option('plugin_activation_code');
			if (!empty($activation_code)){ // activation code has been entered - let's verify it
				if ($this->settings->verify_activation_code($activation_code)){ // code is correct
					$this->settings->activate_plugin($activation_code);
					echo '<div id="message" class="updated fade"><p><strong>' . __('Plugin has been activated successfully.', 'woocommerce-all-in-one-currency-converter') . '</strong></p></div>';
				} else { // code is incorrect
					$this->settings->deactivate_plugin();
					echo '<div id="message" class="error fade"><p><strong>' . __('Purchase code incorrect. Please try again.', 'woocommerce-all-in-one-currency-converter') . '</strong></p></div>';
				}	
			}
			
			$configuration = apply_filters('woocommerce_' . $this->id . 'plugin_activation', array(
					
					array(
						'title' => __('Plugin activation', 'woocommerce-all-in-one-currency-converter'),
						'type' => 'title',
						'desc' => __('Please activate this plugin using your Envato Marketplace purchase code. You can find your purchase code in Downloads section of your Envato profile and in the e-mail you received right after purchasing this item. Activating the plugin gives you access to free automatic updates with new features as well as security fixes.<br />See <a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Can-I-Find-my-Purchase-Code-">Where Can I Find My Purchase Code?</a> article on Envato.', 'woocommerce-all-in-one-currency-converter'),
						'id' => $this->settings->get_prefix() . 'plugin_activation_options'
					),

					array(
						'title' => __('Your purchase code', 'woocommerce-all-in-one-currency-converter'),
						'type' => 'text',
						'css' => 'min-width:450px;',
						'default' => '',
						'desc_tip' => __('Paste your plugin purchase code here.', 'woocommerce-all-in-one-currency-converter'),
						'id' => $this->settings->get_prefix() . 'plugin_activation_code'	
					),	
					
					array(
						'type' => 'sectionend',
						'id' => $this->settings->get_prefix() . 'plugin_activation'
					)
					
				));	
			
		}
		
		else if ($current_section == 'advanced'){
			
			add_thickbox(); // for countries' currencies

			$currencies = $this->settings->get_currency_data(); // get all currencies
			
			// if json in DB is empty, fill it with default data:
			$json_countries_currencies = $this->settings->get_option('country_list_data');
			if (empty($json_countries_currencies) || $json_countries_currencies == '[]' || $json_countries_currencies == '{}'){
				update_option($this->settings->get_prefix() . 'country_list_data', json_encode($this->settings->countries_currencies));
			} else { // convert json from DB to array, sort by key alphabetically to keep it clean, search for duplicates (and remove) and save back to DB (only if it has been changed):
				$json_countries_currencies_uppercased = strtoupper($json_countries_currencies); // make sure it's uppercase
				$array_countries_currencies = json_decode($json_countries_currencies_uppercased, true);
				ksort($array_countries_currencies, SORT_NATURAL); // sort alphabetically by key	
				$previous_key = '';
				foreach ($array_countries_currencies as $key => $value){ // search for duplicate keys and convert to uppercase
					if ($key === $previous_key){
						unset($array_countries_currencies[$key]); // remove if found
					}
					$previous_key = $key;
				}
				$json_countries_currencies_sorted = json_encode($array_countries_currencies);
				if ($json_countries_currencies_sorted != $json_countries_currencies){
					update_option($this->settings->get_prefix() . 'country_list_data', $json_countries_currencies_sorted);
				}			
			}

			// payment methods configurator:
			$currencies_payment_methods_fields = array();
			if ('checkout' == $this->settings->get_conversion_method()){ // only for checkout conversion
				// get available payment gateways:
				global $woocommerce;
				$payment_methods = array();
				if (!empty($woocommerce->payment_gateways->payment_gateways)){
					foreach ($woocommerce->payment_gateways->payment_gateways as $gateway){
						if ($gateway->enabled == 'yes'){
							$payment_methods[$gateway->id] = $gateway->title;
						}
					}
				}

				$currencies_payment_methods_fields[] = array(
					'title' => __('Payment methods configuration', 'woocommerce-all-in-one-currency-converter'),
					'type' => 'title',
					'desc' => __('Use fields below to configure which payment methods should be available for each currency. Leave the field empty to allow all payment methods to be used.', 'woocommerce-all-in-one-currency-converter'),
					'id' => $this->settings->get_prefix() . 'advanced_payment_methods_options'
				);
				foreach ($currencies as $currency_code => $currency_data){
					$currencies_payment_methods_fields[] = array(
						'title' => $currency_data['name'] . ' (' . $currency_code . ')',
						'type' => 'multiselect',
						'class' => 'wc-enhanced-select',
						'options' => $payment_methods,
						'desc_tip' => sprintf(__('Specify which payment methods should be available when %s is active or leave the field empty to have all payment methods enabled for the currency.', 'woocommerce-all-in-one-currency-converter'), $currency_code),
						'custom_attributes' => array(
							'data-placeholder' => __('Enable all payment methods', 'woocommerce-all-in-one-currency-converter')
						),
						'id' => $this->settings->get_prefix() . 'payment_methods_' . $currency_code
					);
				}
				$currencies_payment_methods_fields[] = array(
					'type' => 'sectionend',
					'id' => $this->settings->get_prefix() . 'advanced_payment_methods_options'
				);

			}

			$startup_currency_array = array();
			foreach ($currencies as $currency_code => $currency_data){
				$startup_currency_array[$currency_code] = $currency_code . ' - ' . $currency_data['name'];
			}

			$advanced_section_currency_settings_output = array(
				array(
					'title' => __('Advanced configuration', 'woocommerce-all-in-one-currency-converter'),
					'type' => 'title',
					'desc' => __('This section is intended to be used by advanced users.', 'woocommerce-all-in-one-currency-converter'),
					'id' => $this->settings->get_prefix() . 'advanced_options'
				),
				array(
					'type' => 'sectionend',
					'id' => $this->settings->get_prefix() . 'advanced_options'
				),
				array(
					'title' => __('Currency configuration', 'woocommerce-all-in-one-currency-converter'),
					'type' => 'title',
					'id' => $this->settings->get_prefix() . 'advanced_currency_data_options'
				),
				array(
					'title' => __('Geolocation currencies', 'woocommerce-all-in-one-currency-converter'),
					'type' => 'text',
					'default' => json_encode($this->settings->countries_currencies),
					'css' => 'display:none',
					'desc_tip' => __("Use this option if you want to specify different default currencies for specific countries. This option is only used when geolocation feature is active.", 'woocommerce-all-in-one-currency-converter'),
					'id' => $this->settings->get_prefix() . 'country_list_data'
				),
				array(
					'title' => __('Startup currency', 'woocommerce-all-in-one-currency-converter'),
					'type' => 'select',
					'options' => $startup_currency_array,
					'default' => $this->settings->get_startup_currency(),
					'class' => 'wc-enhanced-select-nostd',
					'desc_tip' => __("By default, all new visitors will be assigned a base currency. If you want to change that, you can select different currency here. Please keep in mind that this can be overridden by geolocation.", 'woocommerce-all-in-one-currency-converter'),
					'id' => $this->settings->get_prefix() . 'startup_currency'
				),
				array(
					'title' => __('Currency switch GET parameter', 'woocommerce-all-in-one-currency-converter'),
					'type' => 'text',
					'default' => '',
					'desc_tip' => __("If you want to allow user to switch currency via GET parameter in the URL, type the parameter name in this field. If you want to have the currency switched only via POST parameter, leave the field empty.", 'woocommerce-all-in-one-currency-converter'),
					'id' => $this->settings->get_prefix() . 'currency_switch_get_parameter'
				),
				array(
					'type' => 'sectionend',
					'id' => $this->settings->get_prefix() . 'advanced_country_data_options'
				)
			);

			$advanced_section_additional_settings_output = array(
				array(
					'title' => __('Additional options', 'woocommerce-all-in-one-currency-converter'),
					'type' => 'title',
					'id' => $this->settings->get_prefix() . 'advanced_additional_options'
				),
				array(
					'title' => __('Static page cache', 'woocommerce-all-in-one-currency-converter'),
					'desc' => __("Currency switching with page caching support", 'woocommerce-all-in-one-currency-converter'),
					'desc_tip' => __('If you are using a static caching plugin, currency switching may not be working properly. Enabling this feature appends additional query string at the end of the URL (depending on the active currency), which causes cache invalidation.', 'woocommerce-all-in-one-currency-converter'),
					'id' => $this->settings->get_prefix() . 'page_cache_support',
					'type' => 'checkbox',
					'default' => 'no'
				),
				array(
					'title' => __('Restore default settings', 'woocommerce-all-in-one-currency-converter'),
					'type' => 'text',
					'css' => 'display:none',
					'desc_tip' => __("If you experience significant problems with Currency Converter plugin, you can restore plugin to its default settings. Please keep in mind that this function completely erases all your Currency Converter settings!", 'woocommerce-all-in-one-currency-converter'),
					'class' => $this->settings->get_prefix() . 'advanced_additional_restore_defaults_input'
				),
				array(
					'css' => 'display:none',
					'type' => 'text',
				),
				array(
					'type' => 'sectionend',
					'id' => $this->settings->get_prefix() . 'advanced_additional_options'
				)
			);

			$advanced_section_output = array_merge(
				$advanced_section_currency_settings_output,
				$currencies_payment_methods_fields,
				$advanced_section_additional_settings_output
			);

			$configuration = apply_filters('woocommerce_' . $this->id . '_advanced_settings', $advanced_section_output);
			
		}
		
		else if ($current_section == 'display'){

			$switcher_default_themes = array(
				'dropdown' => array(
					'name' => __("Dropdown list",  'woocommerce-all-in-one-currency-converter'),
					'image_url' => plugin_dir_url(__FILE__) . 'img/switcher_themes/dropdown.png'
				)
			);
			$switcher_themes = apply_filters('wcaiocc_currency_switcher_themes', $switcher_default_themes);

			$switcher_themes_options = array();
			foreach ($switcher_themes as $switcher_theme_id => $switcher_theme){
				$switcher_themes_options[$switcher_theme_id] =
					$switcher_theme['name'] .
					'<span class="wcaiocc_switcher_theme_option"><img src="' . $switcher_theme['image_url'] . '" alt="' . $switcher_theme['name'] . '" /></span>';
			}
			
			$configuration = apply_filters('woocommerce_' . $this->id . 'display_settings', array(
				
				array(
					'title' => __('Display options', 'woocommerce-all-in-one-currency-converter'),
					'type' => 'title',
					'desc' => __('Configure how your users see this plugin.', 'woocommerce-all-in-one-currency-converter'),
					'id' => $this->settings->get_prefix() . 'display_options'
				),

				array(
					'title' => __('Currency switcher text', 'woocommerce-all-in-one-currency-converter'),
					'type' => 'text',
					'css' => 'min-width:330px;',
					'default' => __('Choose your preferred currency', 'woocommerce-all-in-one-currency-converter'),
					'desc_tip' => __('Type in the text that will appear above the currency switcher. You can leave this field empty if you do not want any text to appear above the switcher.', 'woocommerce-all-in-one-currency-converter'),
					'id' => $this->settings->get_prefix() . 'currency_switcher_text'	
				),	
				
				array(
					'title' => __('Currency switcher theme', 'woocommerce-all-in-one-currency-converter'),
					'type' => 'radio',
					'default' => 'dropdown',
					'options' => $switcher_themes_options,
					'desc_tip' => __("Select your preferred method of displaying currency switcher. To insert the currency switcher on your page you can use a widget, shortcode or PHP function. See plugin documentation for more information.", 'woocommerce-all-in-one-currency-converter'),
					'id' => $this->settings->get_prefix() . 'currency_switcher_theme'
				),

				array(
					'title' => __('Custom currency template', 'woocommerce-all-in-one-currency-converter'),
					'type' => 'text',
					'css' => 'min-width:330px;',
					'default' => '',
					'desc_tip' => __('Type in the custom template of how the currency should be displayed in currency switcher. Use the following tags: %code%, %name%, %symbol%. Leave empty if you want to use default settings. See plugin documentation for more information.', 'woocommerce-all-in-one-currency-converter'),
					'id' => $this->settings->get_prefix() . 'currency_switcher_display_template'	
				),	

				array(
					'title' => __('Custom CSS rules', 'woocommerce-all-in-one-currency-converter'),
					'desc_tip' => __('Type in additional CSS code if you would like to change how the currency switcher is displayed. Please see plugin documentation for more information.', 'woocommerce-all-in-one-currency-converter'),
					'id' => $this->settings->get_prefix() . 'currency_switcher_css',
					'css' => 'min-width: 450px; min-height: 100px; font-family: monospace;',
					'type' => 'textarea',
					'default' => ''
				),

				array(
					'title' => __('Custom JavaScript code', 'woocommerce-all-in-one-currency-converter'),
					'desc_tip' => __('Type in additional JavaScript code if you whish to increase plugin functionality. This JavaScript code will be injected at the bottom of your site.', 'woocommerce-all-in-one-currency-converter'),
					'id' => $this->settings->get_prefix() . 'currency_switcher_js',
					'css' => 'min-width: 450px; min-height: 100px; font-family: monospace;',
					'type' => 'textarea',
					'default' => ''
				),
				
				array(
					'type' => 'sectionend',
					'id' => $this->settings->get_prefix() . 'display_options'
				)
				
			));	
			
		}
		
		else if ($current_section == 'exchange_rates'){
			
			// Get our currency settings so we can list all currencies currently in use:
			$currencies_data_string = get_option($this->settings->get_prefix() . 'available_currencies');
			$currencies_data = json_decode($currencies_data_string, true);
			$currencies_in_use = array();
			$currency_codes_list = array();
			foreach ($currencies_data as $currency_code => $currency_data){
				$currencies_in_use[$currency_code] = array();
				$currencies_in_use[$currency_code]['name'] = $currency_data['name'];
				$currencies_in_use[$currency_code]['symbol'] = $currency_data['symbol'];
				$currency_codes_list[] = $currency_code;
			}
			$currencies_in_use_json = json_encode($currencies_in_use, JSON_UNESCAPED_UNICODE);
			
			// save it to option:
			update_option($this->settings->get_prefix() . 'inner_use_currencies_in_use', $currencies_in_use_json);
			
			$configuration_array = array(				
				array(
					'title' => __('Currency exchange rates', 'woocommerce-all-in-one-currency-converter'),
					'type' => 'title',
					'desc' => __('Configure exchange rates for your currencies.', 'woocommerce-all-in-one-currency-converter'),
					'id' => $this->settings->get_prefix() . 'exchange_rates_options'		
				),
				
				array(
					'title' => __('Exchange rates update', 'woocommerce-all-in-one-currency-converter'),
					'type' => 'radio',
					'default' => 'update',
					'options' => array(
						'automatic' => __("Automatically update exchange rates once a day using chosen services (schedules WordPress Cron job)",  'woocommerce-all-in-one-currency-converter'),
						'manual' => __("Do not automatically update exchange rates - use fixed exchange rates specified below",  'woocommerce-all-in-one-currency-converter')
					),
					'desc_tip' => __('Choose whether you want to have daily updated exchange rates or fixed exchange rates.', 'woocommerce-all-in-one-currency-converter'),
					'id' => $this->settings->get_prefix() . 'exchange_rates_update_method'
				),
				
				array(
					'title' => __('Your currencies', 'woocommerce-all-in-one-currency-converter'),
					'type' => 'text',
					'css' => 'display:none;',
					'desc_tip' => __("Specify the exchange rate manually or click Update to update exchange rate using one of provided third party services. Exchange rate value is in relation to your store's default currency.", 'woocommerce-all-in-one-currency-converter'),
					'class' => $this->settings->get_prefix() . 'exchange_rates'	
				),	

				array(
					'type' => 'sectionend',
					'id' => $this->settings->get_prefix() . 'exchange_rates_options'
				),
				
				array( // this one lists all currencies semicolon-delimited (with names and symbols)
					'type' => 'text',
					'css' => 'display:none;',
					'id' => $this->settings->get_prefix() . 'inner_use_currencies_in_use'
				)

			);
			
			foreach ($currency_codes_list as $currency_code){
				$configuration_array[] = 
					array(
						'type' => 'text',
						'css' => 'display:none;',
						'default' => '1',
						'id' => $this->settings->get_prefix() . 'exchange_rate_' . $currency_code
					);
				$configuration_array[] = 
					array(
						'type' => 'text',
						'css' => 'display:none;',
						'default' => $this->settings->get_exchange_api(),
						'id' => $this->settings->get_prefix() . 'exchange_api_' . $currency_code
					);
			}
			
			$configuration = apply_filters('woocommerce_' . $this->id . '_exchange_rates_settings', $configuration_array);	
			
		}
		
		else if ($current_section == 'currencies'){
			
			// Get all currencies for our New currency select box:
			$currencies_list = get_woocommerce_currencies();
			$currencies_options_list = array(); // create an array that will be used in settings select field	
			$currency_position = get_option('woocommerce_currency_pos');
			$thousand_separator = wc_get_price_thousand_separator();
			$decimal_separator = wc_get_price_decimal_separator();
			$number_decimals = wc_get_price_decimals();

			foreach ($currencies_list as $code => $name){ // loop through all currencies
				$symbol = get_woocommerce_currency_symbol($code);				
				$option_value = 
					$code . '#data_sep#' . 
					$name . '#data_sep#' . 
					$symbol . '#data_sep#' . 
					$currency_position . '#data_sep#' . 
					$thousand_separator . '#data_sep#' . 
					$decimal_separator. '#data_sep#' . 
					$number_decimals;
				$option_text = $code . ' - ' . $name . ' (' . $symbol . ')';
				$currencies_options_list[$option_value] = $option_text;
			}
			
			$configuration = apply_filters('woocommerce_' . $this->id . '_currency_settings', array(
				
				array(
					'title' => __('Currencies list', 'woocommerce-all-in-one-currency-converter'),
					'type' => 'title',
					'desc' => __('Configure list of currencies available to your users.', 'woocommerce-all-in-one-currency-converter'),
					'id' => $this->settings->get_prefix() . 'currencies_options'		
				),		

				array(
					'title' => __('Available currencies', 'woocommerce-all-in-one-currency-converter'),
					'type' => 'text',
					'css' => 'display:none;',
					'desc_tip' => __('These are currencies available to your users. Drag and drop currencies to control their display order on the frontend.', 'woocommerce-all-in-one-currency-converter'),
					'id' => $this->settings->get_prefix() . 'available_currencies'	
				),	

				array(
					'title' => __('Add new currency', 'woocommerce-all-in-one-currency-converter'),
					'type' => 'select',
					'options' => $currencies_options_list, // assign options from the array extracted from XML file
					'class' => 'wc-enhanced-select-nostd ' . $this->settings->get_prefix() . 'new_currency',
					'css' => 'width:320px;',
					'desc_tip' => __('Choose new currency from the list', 'woocommerce-all-in-one-currency-converter')
				),

				array(
					'type' => 'sectionend',
					'id' => $this->settings->get_prefix() . 'currencies_options'
				)			

			));	
		
		} 
		
		else {
		
			$configuration = apply_filters('woocommerce_' . $this->id . 'general_settings', array(
				
				array(
					'title' => __('General settings', 'woocommerce-all-in-one-currency-converter'),
					'type' => 'title',
					'desc' => __('Configure general Currency Converter settings.', 'woocommerce-all-in-one-currency-converter'),
					'id' => $this->settings->get_prefix() . 'general_options'
				),
				
				array(
					'title' => __('Conversion method', 'woocommerce-all-in-one-currency-converter'),
					'type' => 'radio',
					'default' => 'reference',
					'options' => array(
						'reference' => __("Convert currency for user's reference only (payment in store's <strong>base currency</strong>)",  'woocommerce-all-in-one-currency-converter'),
						'checkout' => __("Convert currency for user's reference and for checkout (payment in <strong>alternative currency</strong>)",  'woocommerce-all-in-one-currency-converter')
					),
					'desc_tip' => __('Choose currency conversion method. Please keep in mind that some currencies may NOT be supported by certain payment gateways. If you are not sure which option to choose, please select the first one.', 'woocommerce-all-in-one-currency-converter'),
					'id' => $this->settings->get_prefix() . 'conversion_method'
				),
				
				 array(
					'title' => __('Display options', 'woocommerce-all-in-one-currency-converter'),
					'desc' => __("Show checkout total in store's base currency (<strong>reference</strong> conversion method only)", 'woocommerce-all-in-one-currency-converter'),
					'desc_tip' => __("In checkout, right before the payment is made, user will see the final amount he will have to pay in store's base currency.", 'woocommerce-all-in-one-currency-converter'),
					'id' => $this->settings->get_prefix() . 'checkout_total_in_base_currency',
					'type' => 'checkbox',
					'default' => 'yes',
					'css' => 'display:none;'
				), 

				array(
					'title' => __('Checkout total text', 'woocommerce-all-in-one-currency-converter'),
					'type' => 'text',
					'css' => 'min-width:330px;',
					'default' => __('Total payment:', 'woocommerce-all-in-one-currency-converter'),
					'desc_tip' => __('If you decided to show total payment amount on checkout page before the actual payment, you can define this text here.', 'woocommerce-all-in-one-currency-converter'),
					'id' => $this->settings->get_prefix() . 'checkout_total_payment_text'	
				),	

				array(
					'title' => __('Your email address', 'woocommerce-all-in-one-currency-converter'),
					'type' => 'text',
					'css' => 'min-width:330px;',
					'default' => get_option('admin_email'),
					'desc_tip' => __('If automatic currency exchange rates update fails, a notification will be sent to this email address. If you do not want to receive the notification, leave this field empty.', 'woocommerce-all-in-one-currency-converter'),
					'id' => $this->settings->get_prefix() . 'email_address'	
				),	
				
				array(
					'title' => __('Additional options', 'woocommerce-all-in-one-currency-converter'),
					'desc' => __("Remember visitor's currency choice", 'woocommerce-all-in-one-currency-converter'),
					'desc_tip' => __('The next time user visits your website, his currency will be automatically changed to the one he has chosen previously (creates a cookie).', 'woocommerce-all-in-one-currency-converter'),
					'id' => $this->settings->get_prefix() . 'remember_user_chosen_currency',
					'type' => 'checkbox',
					'default' => 'yes',
					'checkboxgroup' => 'start'
				),

				array(
					'desc' => __('Enable IP geolocation', 'woocommerce-all-in-one-currency-converter'),
					'id' => $this->settings->get_prefix() . 'geolocation',
					'type' => 'checkbox',
					'default' => 'no',
					'desc_tip' => sprintf(__("When user visits your website, his currency will be automatically switched to currency used in his country. This option will only work if you have enabled this currency in Currencies section. Otherwise, store's startup currency will be used. Currency for every country can be changed in <a href=\"%s\">Advanced</a> section.", 'woocommerce-all-in-one-currency-converter'), admin_url('admin.php?page=wc-settings&tab=currency_converter&section=advanced')),
					'checkboxgroup' => ''
				),
				
				array(
					'type' => 'sectionend',
					'id' => $this->settings->get_prefix() . 'general_options'
				)
				
			));	
		
		}
		
		return apply_filters('woocommerce_get_settings_' . $this->id, $configuration, $current_section);
		
    }
	
	
	/**
	 * Add new tab (page) to WooCommerce Settings page
	 */
	public function add_settings_page($pages){		
		
		// Tab name:
		$this->label = __('Currency Converter', 'woocommerce-all-in-one-currency-converter');
		
		$pages[$this->id] = $this->label;
		return $pages;
		
	}	
	

	/**
	 * Output section list
	 */
	public function output_sections(){
		
		global $current_section;
		
		$sections = $this->get_sections();

		if (empty($sections)){
			return;
		}

		echo '<ul class="subsubsub">';

		$array_keys = array_keys($sections);

		foreach ($sections as $id => $label){ // Display tab sections
			echo '<li><a href="' . admin_url('admin.php?page=wc-settings&tab=' . $this->id . '&section=' . sanitize_title($id)) . '" class="' 
					. ($current_section == $id ? 'current' : '') . '">' . $label . '</a> ' . (end($array_keys) == $id ? '' : '|') . ' </li>';
		}

		echo '</ul><br class="clear" />';
		
	}
	
	
}
