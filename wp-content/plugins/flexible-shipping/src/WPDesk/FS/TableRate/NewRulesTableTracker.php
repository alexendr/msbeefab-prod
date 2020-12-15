<?php
/**
 *
 */

namespace WPDesk\FS\TableRate;


use FSVendor\WPDesk\PluginBuilder\Plugin\Hookable;
use WPDesk\FS\TableRate\NewRulesTablePointer\RulesPointerOption;
use WPDesk\FS\TableRate\NewRulesTablePointer\ShippingMethodNewRuleTableSetting;

class NewRulesTableTracker implements Hookable {

	const NEW_USERS_AFTER_THIS_DATE = '2020-07-07 01:00:00';

	const PRIORITY_AFTER_FS_TRACKER = 12;
	const TRACKER_DATA_FLEXIBLE_SHIPPING = 'flexible_shipping';

	public function hooks() {
		add_filter( 'wpdesk_tracker_data', array( $this, 'append_new_rules_table_data_to_tracker' ), self::PRIORITY_AFTER_FS_TRACKER );
	}

	/**
	 * If this a old user? If so then FS should work like always.
	 *
	 * @return bool
	 */
	private function is_new_installation() {
		return strtotime( self::NEW_USERS_AFTER_THIS_DATE ) < $this->activation_date_according_to_wpdesk_helper();
	}

	/**
	 * Activation date according to wpdesk helper.
	 *
	 * @return int timestamp
	 */
	private function activation_date_according_to_wpdesk_helper() {
		$option_name     = 'plugin_activation_flexible-shipping/flexible-shipping.php';
		$activation_date = get_option( $option_name, current_time( 'mysql' ) );

		if ( ! $activation_date ) {
			return time();
		}

		return strtotime( $activation_date );
	}

	private function get_new_rules_table_enabled() {
		$shipping_method_settings = get_option( ShippingMethodNewRuleTableSetting::SHIPPING_METHOD_SETTINGS_OPTION, array() );
		if ( isset( $shipping_method_settings[ ShippingMethodNewRuleTableSetting::SETTINGS_OPTION ] ) ) {
			return $shipping_method_settings[ ShippingMethodNewRuleTableSetting::SETTINGS_OPTION ];
		}
		return 'no';
	}

	private function append_user_feedback_data( $data, $user_feedback ) {
		if ( isset( $user_feedback['selected_option'] ) ) {
			$data['feedback_option'] = $user_feedback['selected_option'];
		}
		if ( isset( $user_feedback['additional_info'] ) ) {
			$data['feedback_additional_info'] = $user_feedback['additional_info'];
		}

		return $data;
	}

	public function append_new_rules_table_data_to_tracker( $data ) {
		$new_rules_table_data = array();

		$new_rules_table_data['new_installation'] = $this->is_new_installation() ? 'yes' : 'no';
		$new_rules_table_data['pointer_clicked']  = get_option( RulesPointerOption::OPTION_NAME, '0' ) === '1' ? 'yes' : 'no';
		$new_rules_table_data['table_enabled']          = $this->get_new_rules_table_enabled();
		$new_rules_table_data['was_disabled']     = get_option( ShippingMethodNewRuleTableSetting::OPTION_NEW_RULES_DISABLED, '0' ) === '1' ? 'yes' : 'no';

		$user_feedback = get_option( UserFeedback::USER_FEEDBACK_OPTION );

		if ( is_array( $user_feedback ) ) {
			$new_rules_table_data = $this->append_user_feedback_data( $new_rules_table_data, $user_feedback );
		}

		$data['flexible_shipping']['new_rules_table'] = $new_rules_table_data;

		return $data;
	}

}