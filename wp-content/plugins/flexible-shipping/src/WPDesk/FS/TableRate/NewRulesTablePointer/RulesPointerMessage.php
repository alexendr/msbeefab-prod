<?php
/**
 * Rules pointer message.
 *
 * @package WPDesk\FS\TableRate\NewRulesTablePointer
 */

namespace WPDesk\FS\TableRate\NewRulesTablePointer;

use FSVendor\WPDesk\PluginBuilder\Plugin\Hookable;
use FSVendor\WPDesk\Pointer\PointerConditions;
use FSVendor\WPDesk\Pointer\PointerMessage;
use FSVendor\WPDesk\Pointer\PointerPosition;
use FSVendor\WPDesk\Pointer\PointersScripts;

/**
 * Can display new rules pointer message.
 */
class RulesPointerMessage implements Hookable {

	const POINTER_ID = 'fs_new_rules_table';

	const NEW_RULES_TABLE_PARAMETER = 'new_rules_table';

	/**
	 * Pattern of option with Flexible Shipping methods.
	 * @var string
	 */
	const FS_METHODS_OPTION_PREFIX = 'flexible_shipping_methods_%d';

	/**
	 * @var RulesPointerOption
	 */
	private $rules_pointer_option;

	/**
	 * RulesPointerMessage constructor.
	 *
	 * @param RulesPointerOption $rules_pointer_option .
	 */
	public function __construct( RulesPointerOption $rules_pointer_option ) {
		$this->rules_pointer_option = $rules_pointer_option;
	}

	/**
	 * Hooks.
	 */
	public function hooks() {
		add_action( 'admin_init', array( $this, 'add_pointer_messages' ) );
	}

	/**
	 * Should show pointer.
	 */
	private function should_show_pointer() {
		if ( ! ( new \FSVendor\WPDesk_Tracker_Persistence_Consent() )->is_active()
			|| ( intval( get_option( RulesPointerOption::OPTION_NAME, '0' ) ) === 1 )
			|| wpdesk_is_plugin_active( 'flexible-shipping-pro/flexible-shipping-pro.php' )
			|| ! $this->check_is_fs_methods_exists_in_zones() ) {
			return false;
		}

		return true;
	}

	/**
	 * Checks if there are Flexible Shipping methods in the Shipping Zones.
	 *
	 * @return bool Status.
	 */
	private function check_is_fs_methods_exists_in_zones() {
		$zones = \WC_Shipping_Zones::get_zones();
		foreach ( $zones as $zone ) {
			$zone_instance = \WC_Shipping_Zones::get_zone( $zone['zone_id'] );

			if ( $this->check_is_fs_methods_exists_in_zone( $zone_instance ) === true ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Checks if there are Flexible Shipping methods in the Shipping Zone.
	 *
	 * @param \WC_Shipping_Zone $zone_instance Instance of Shipping Zone.
	 *
	 * @return bool Status.
	 */
	private function check_is_fs_methods_exists_in_zone( $zone_instance ) {
		$zone_methods = $zone_instance->get_shipping_methods();
		foreach ( $zone_methods as $zone_method ) {
			if ( $zone_method->id !== 'flexible_shipping' ) {
				continue;
			}

			$option_key       = sprintf( self::FS_METHODS_OPTION_PREFIX, $zone_method->instance_id );
			$shipping_methods = get_option( $option_key, array() );
			if ( $shipping_methods ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Add pointer messages.
	 */
	public function add_pointer_messages() {
		if ( $this->should_show_pointer() ) {
			$this->create_pointer_message();
		}
	}

	private function create_pointer_message() {
		$enable_new_rules_table_link = admin_url( 'admin.php' );
		foreach ( $_GET as $parameter => $value ) {
			$enable_new_rules_table_link = add_query_arg( $parameter, $value, $enable_new_rules_table_link );
		}
		$enable_new_rules_table_link = add_query_arg( self::NEW_RULES_TABLE_PARAMETER, '1', $enable_new_rules_table_link );

		ob_start();
		include __DIR__ . '/views/html-rule-pointer-message.php';
		$content = trim( ob_get_contents() );
		ob_end_clean();

		$pointer_conditions = new PointerConditions( 'woocommerce_page_wc-settings', 'manage_woocommerce' );
		$pointer_message    = new PointerMessage(
			self::POINTER_ID,
			'#woocommerce_flexible_shipping_method_rules_label',
			__( 'Any problems with configuration?', 'flexible-shipping' ),
			$content,
			new PointerPosition( PointerPosition::LEFT, PointerPosition::BOTTOM ),
			'wp-pointer',
			330,
			$pointer_conditions,
			array( 'margin-left' => '10px', 'font-weight' => 'initial' )
		);
	}

}
