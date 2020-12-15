<?php
/**
 * @package WPDesk\FS\TableRate
 */

namespace WPDesk\FS\TableRate;

use FSVendor\WPDesk\Forms\Field;

/**
 * Class RulesSettings
 */
class RulesSettingsField {

	/**
	 * @var string
	 */
	private $settings_field_id;

	/**
	 * @var string
	 */
	private $field_key;

	/**
	 * @var string
	 */
	private $settings_field_name;

	/**
	 * @var array
	 */
	private $data;

	/**
	 * RulesSettings constructor.
	 *
	 * @param string $settings_field_name .
	 * @param string $field_key .
	 * @param string $settings_field_title .
	 * @param array $settings .
	 */
	public function __construct( $settings_field_id, $field_key, $settings_field_name, $data ) {
		$this->settings_field_id   = $settings_field_id;
		$this->field_key           = $field_key;
		$this->settings_field_name = $settings_field_name;
		$this->data                = $data;
	}

	/**
	 * Render settings.
	 *
	 * @return string
	 */
	public function render() {
		ob_start();
		$field_key = $this->field_key;
		$data = $this->data;
		include __DIR__ . '/views/shipping-method-settings-rules.php';
		return ob_get_clean();
	}

}
