<?php

namespace WPDesk\FS\TableRate;

use FSVendor\WPDesk\PluginBuilder\Plugin\Hookable;
use FSVendor\WPDesk\Tracker\UserFeedback\AjaxUserFeedbackDataHandler;
use FSVendor\WPDesk\Tracker\UserFeedback\TrackerFactory;
use FSVendor\WPDesk\Tracker\UserFeedback\UserFeedbackData;
use FSVendor\WPDesk\Tracker\UserFeedback\UserFeedbackOption;
use WPDesk\FS\TableRate\NewRulesTablePointer\RulesPointerOption;
use WPDesk\FS\TableRate\NewRulesTablePointer\ShippingMethodNewRuleTableSetting;

class UserFeedback implements Hookable {

	const THICKBOX_ID = 'new-rules-table';
	const USER_FEEDBACK_OPTION = 'flexible_shipping_new_rules_feedback';

	public function hooks() {
		if ( get_option( RulesPointerOption::OPTION_NAME, '0' ) === '1' ) {
			$user_feedback = $this->prepare_user_feedback();
			$user_feedback->hooks();
		}
		add_action( 'wpdesk_tracker_user_feedback_data_handled', array( $this, 'save_user_feedback' ) );
	}

	/**
	 * @param array $payload .
	 */
	public function save_user_feedback( $payload ) {
		if ( is_array( $payload ) && isset( $payload[ AjaxUserFeedbackDataHandler::FEEDBACK_ID ] ) && $payload[ AjaxUserFeedbackDataHandler::FEEDBACK_ID ] === self::THICKBOX_ID ) {
			update_option( self::USER_FEEDBACK_OPTION, $payload );
		}
	}

	private function prepare_user_feedback() {
		$user_feedback_data = new UserFeedbackData(
			self::THICKBOX_ID,
			__( 'You are disabling new rules table', 'flexible-shipping' ),
			'',
			__( 'What should we do to improve your experience?', 'flexible-shipping' ),
			'woocommerce_page_wc-settings'
		);
		$user_feedback_data->add_feedback_option( new UserFeedbackOption(
			'have_comment',
			'',
			true,
			__( 'Comment', 'flexible-shipping' )
		));

		return TrackerFactory::createCustomTrackerWithoutSender( $user_feedback_data );
	}

}
