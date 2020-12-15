<?php


/**
 * 
 * Plugin: WooCommerce All in One Currency Converter
 * Author: http://dev49.net
 *
 * WooCommerce_All_in_One_Currency_Converter_Widget class is a currency switcher widget class.
 *
 */

// Exit if accessed directly:
if (!defined('ABSPATH')){ 
    exit; 
}

class WooCommerce_All_in_One_Currency_Converter_Widget extends WP_Widget {
	
	
	private $settings; // we're going to assign Settings object to this property
	

	/**
	 * Register widget with WordPress
	 */
	function __construct() {
		
		global $woocommerce_all_in_one_currency_converter;
		$this->settings = $woocommerce_all_in_one_currency_converter->settings;
		
		parent::__construct(
			'wcaiocc_widget', // Base ID
			__('Currency Converter', 'woocommerce-all-in-one-currency-converter'), // Name
			array( // Args
				'description' => __('WooCommerce All in One Currency Converter widget', 'woocommerce-all-in-one-currency-converter'),
			) 
		);
		
	}
	

	/**
	 * Front-end display of widget
	 */
	public function widget($args, $instance){
		
		echo $args['before_widget'];
		
		if (!empty($instance['title'])){
			echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
		}
		
		wcaiocc_switcher();
		
		echo $args['after_widget'];
		
	}

	
	/**
	 * Back-end widget form
	 */
	public function form($instance){
		
		$title =  __('Change currency', 'woocommerce-all-in-one-currency-converter');
		if (isset($instance['title'])){			
			$title = $instance['title'];
		}		
		
		?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'woocommerce-all-in-one-currency-converter'); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
			</p>
			<p>
				<?php 
					echo sprintf(
						__(
							'Currency switcher will appear in this widget. To change the way switcher is displayed, please go to WooCommerce All in One Currency Converter <a href="%s">Currency switcher display settings</a>.', 
							'woocommerce-all-in-one-currency-converter'
						), 
						admin_url(
							'admin.php?page=wc-settings&tab=currency_converter&section=display'
						)
					); 
				?>
			</p>
		<?php 
		
	}

	
	/**
	 * Sanitize widget form values as they are saved
	 */
	public function update($new_instance, $old_instance){
		
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';

		return $instance;
		
	}
	

}
