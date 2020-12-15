<?php
/**
 * CoolClock Widget Class
 */

class CoolClock_Widget extends WP_Widget {

	/** PHP5+ constructor */
	public function __construct()
	{
		parent::__construct(
			'coolclock-widget',
			__('Analog Clock', 'coolclock'),
			array(
				'classname' => 'coolclock',
				'description' => __('Add an analog clock to your sidebar.', 'coolclock')
			),
			array(
				'width' => 300,
				'id_base' => 'coolclock-widget'
			)
		);
	}

	/** @see WP_Widget::widget -- do not rename this */
	public function widget( $args, $instance )
	{
		extract( $args );

		$defaults = array_merge( array('title'=>'','custom_skin'=>''), CoolClock::$defaults, CoolClock::$advanced_defaults );

		// backward compat
		if ( isset($instance['digitalcolor']) && !isset($instance['fontcolor']) ) $instance['fontcolor'] = $instance['digitalcolor'];

		$title = !empty($instance['title']) ? apply_filters( 'widget_title', $instance['title'] ) : '';
		$number = $this->number;

		// set footer script flags
		CoolClock::$add_script = true;

		// Print output
		echo $before_widget;

		if ( $title )
			echo $before_title . $title . $after_title;

		// set skin
		$instance['skin'] = CoolClock::parse_skin(
			!empty( $instance['skin'] ) ? $instance['skin'] : $defaults['skin'],
			!empty( $instance['custom_skin'] ) ? $instance['custom_skin'] : ''
		);

		// radius, used in wrapper style and coolclock fields
		$instance['radius'] = !empty( $instance['radius'] ) && is_numeric( $instance['radius'] ) ? (int) $instance['radius'] : $defaults['radius'];
		if ( 10 > $instance['radius'] ) $instance['radius'] = 10; // absolute minimum size 20x20

		$align = !empty( $instance['align'] ) ? $instance['align'] : $defaults['align'];
		$styles = array(
			'width' => 2 * $instance['radius'] . 'px',
			'height' => 'auto',
		);
		if ( in_array( $align, array('left','center') ) ) {
		 	$styles['margin-right'] = 'auto';
			if ( 'left' == $align ) $styles['margin-left'] = '0';
		}
		if ( in_array( $align, array('right','center') ) ) {
		 	$styles['margin-left'] = 'auto';
			if ( 'right' == $align ) $styles['margin-right'] = '0';
		}
		$styles = apply_filters( 'coolclock_container_styles', $styles, $instance, $defaults );

		// Build output
		// begin wrapper
		$output = '<div class="coolclock-container"' . CoolClock::inline_style( $styles ) . '>';
		// add canvas
		$output .= CoolClock::canvas( $instance );
		// end wrapper
		$output .= '</div>';

		// Print filtered output
		echo apply_filters( 'coolclock_widget', $output, $args, $instance );

		echo $after_widget;
	}

	/** @see WP_Widget::update -- do not rename this */
	public function update( $new_instance, $old_instance )
	{
		// parse custom skin code
		$skin_array = !empty($new_instance['custom_skin']) ? CoolClock::skin_array( wp_strip_all_tags( $new_instance['custom_skin'] ) ) : array();

		$instance['title'] = !empty($new_instance['title']) ? wp_strip_all_tags( $new_instance['title'] ) : '';
		$instance['skin'] = !empty($new_instance['skin']) ? wp_strip_all_tags( $new_instance['skin'] ) : '';
		$instance['custom_skin'] = !empty($skin_array) ? wp_json_encode( $skin_array ) : '';
		$instance['radius'] = ( empty($new_instance['radius']) || (int) $new_instance['radius'] < 5 ) ? 5 : (int) $new_instance['radius'];
		$instance['noseconds'] = !empty($new_instance['noseconds']) ? '1' : '';
		$instance['gmtoffset'] = isset($new_instance['gmtoffset']) && $new_instance['gmtoffset'] !== '' ? (float) $new_instance['gmtoffset'] : '';
		$instance['showdigital'] = !empty($new_instance['showdigital']) ? wp_strip_all_tags( $new_instance['showdigital'] ) : '';
		$instance['fontcolor'] = !empty($new_instance['fontcolor']) ? CoolClock::colorval( $new_instance['fontcolor'] ) : '';
		$instance['scale'] = !empty($new_instance['scale']) ? wp_strip_all_tags( $new_instance['scale'] ) : '';
		$instance['align'] = !empty($new_instance['align']) ? wp_strip_all_tags( $new_instance['align'] ) : '';
		$instance['subtext'] = wp_kses( $new_instance['subtext'], CoolClock::$allowed_tags );

		return apply_filters( 'coolclock_widget_update_advanced', $instance, $new_instance );
	}

	/** @see WP_Widget::form -- do not rename this */
	public function form( $instance )
	{
		$output = '';
		$advanced = '';

		// backward compat
		if ( isset($instance['digitalcolor']) && !isset($instance['fontcolor']) ) $instance['fontcolor'] = $instance['digitalcolor'];

		$defaults = array_merge( array('title'=>'','custom_skin'=>''), CoolClock::$defaults, CoolClock::$advanced_defaults );

		$instance = wp_parse_args( (array) $instance, $defaults );

		$title = esc_attr( $instance['title'] );
		$subtext = esc_attr( $instance['subtext'] );
		$custom_skin = esc_attr( $instance['custom_skin'] );

		// Translatable skin names go here
		$skin_names = array (
			'swissrail' => __('Swiss Rail','coolclock'),
			'chunkyswiss' => __('Chunky Swiss','coolclock'),
			'chunkyswissonblack' => __('Chunky Swiss White','coolclock'),
			'fancy' => __('Fancy','coolclock'),
			'machine' => __('Machine','coolclock'),
			'simonbaird_com' => __('SimonBaird.com','coolclock'),
			'classic' => __('Classic by Bonstio','coolclock'),
			'modern' => __('Modern by Bonstio','coolclock'),
			'simple' => __('Simple by Bonstio','coolclock'),
			'securephp' => __('SecurePHP','coolclock'),
			'tes2' => __('Tes2','coolclock'),
			'lev' => __('Lev','coolclock'),
			'sand' => __('Sand','coolclock'),
			'sun' => __('Sun','coolclock'),
			'tor' => __('Tor','coolclock'),
			'cold' => __('Cold','coolclock'),
			'babosa' => __('Babosa','coolclock'),
			'tumb' => __('Tumb','coolclock'),
			'stone' => __('Stone','coolclock'),
			'disc' => __('Disc','coolclock'),
			'watermelon' => __('Watermelon by Yoo Nhe','coolclock'),
			'mister' => __('Mister by Carl Lister','coolclock'),
			'minimal' => __('Minimal','coolclock')
		);

		// Translatable type names go here
		$type_names = array (
			'linear' => __('Linear','coolclock'),
			'logclock' => __('Logarithmic','coolclock'),
			'logclockrev' => __('Logarithmic reversed','coolclock')
		);

		// Translatable show digital options go here
		$showdigital_names = array (
			'' => translate('none'),
			'digital12' => __('time (am/pm)','coolclock'),
			'digital24' => __('time (24h)','coolclock'),
			'date' => __('date','coolclock'),
			'digital12+' => __('time + seconds (am/pm)','coolclock'),
			'digital24+' => __('time + seconds (24h)','coolclock'),
			'text' => __('custom text','coolclock')
		);

		// Misc translations
		$stray = array(
			'extra_settings' => __('Extra settings for the CoolClock widget.', 'coolclock')
		);

		// Title
		$output .= '<style type="text/css">#available-widgets [class*=clock] .widget-title:before{content:"\f469"}</style>
			<p><label for="' . $this->get_field_id('title') . '">' . __('Title:') . '</label> ';
		$output .= '<input class="widefat" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . $title . '" /></p>';

		// Clock settings
		$output .= '<p><strong>' . __('Clock', 'coolclock') . '</strong></p>';
		$output .= '<p><a href="https://premium.status301.com/coolclock-widget-settings/" target="_blank">' . __('CoolClock widget instructions &raquo;', 'coolclock') . '</a></p>';

		$output .= '<p><label for="' . $this->get_field_id('skin') . '">' . __('Skin:', 'coolclock') . '</label> ';
		$output .= '<select class="select" id="' . $this->get_field_id('skin') . '" name="' . $this->get_field_name('skin') . '">';
		$output .= '<option value="' . $defaults['skin'] . '" ' . selected( $defaults['skin'], $instance['skin'], false ) . '>';
		$output .= ( isset($skin_names[$defaults['skin']]) ) ? $skin_names[$defaults['skin']] : $defaults['skin'];
		$output .= '</option>';
		foreach ( CoolClock::get_all_skins() as $skin => $parms ) {
			$output .= '<option value="' . $skin . '" ' . selected( $skin, $instance['skin'], false ) . '>';
			$output .= ( isset($skin_names[$skin]) ) ? $skin_names[$skin] : $skin;
			$output .= '</option>';
		}
		$output .= '<option value="custom_' . $this->number . '" ' . selected( 'custom_'.$this->number, $instance['skin'], false ) . '>';
		$output .= __('Custom (define below)', 'coolclock') . '</option></select></p>';

		// Custom skin field
		$output .= '<p><label for="' . $this->get_field_id('custom_skin') . '">' . __('Custom skin parameters:', 'coolclock') . '</label> ';
		$output .= '<textarea class="widefat" id="' . $this->get_field_id('custom_skin') . '" name="' . $this->get_field_name('custom_skin') . '">' . $custom_skin . '</textarea> ';
		$output .= '<em>' .  sprintf( __('(set Skin to Custom above, then add %s here)', 'coolclock'), '<a href="https://premium.status301.com/coolclock-custom-skin/" target="_blank">' . __('parameters in JSON format', 'coolclock') . '</a>' ) . '</em></p>';

		// Radius
		$output .= '<p><label for="' . $this->get_field_id('radius') . '">' . __('Radius:', 'coolclock') . '</label> ';
		$output .= '<input class="small-text" id="' . $this->get_field_id('radius') . '" name="' . $this->get_field_name('radius') . '" type="number" min="10" value="' . $instance['radius'] . '" /></p>';

		// Second hand
		$output .= '<p><input id="' . $this->get_field_id('noseconds') . '" name="' . $this->get_field_name('noseconds') . '" type="checkbox" value=';
		$output .= ( $instance['noseconds'] ) ? '"true" checked="checked" />' : '"false" />';
		$output .= ' <label for="' . $this->get_field_id('noseconds') . '">' .  __('Hide second hand', 'coolclock') . '</label></p>';

		// Align
		$output .= '<p><label for="' . $this->get_field_id('align') . '">' . __('Align:', 'coolclock') . '</label> ';
		$output .= '<select class="select" id="' . $this->get_field_id('align') . '" name="' . $this->get_field_name('align') . '">';
		$output .= '<option value="">';
		$output .= translate('none') . '</option>';
		$output .= '<option value="left" ' . selected( $instance['align'], 'left', false ) . '>';
		$output .= __('left', 'coolclock') . '</option>';
		$output .= '<option value="right" ' . selected( $instance['align'], 'right', false ) . '>';
		$output .= __('right', 'coolclock') . '</option>';
		$output .= '<option value="center" ' . selected( $instance['align'], 'center', false ) . '>';
		$output .= __('center', 'coolclock') . '</option>';
		$output .= '</select></p>';

		// Subtext
		$output .= '<p><label for="' . $this->get_field_id('subtext') . '">' . __('Subtext:', 'coolclock') . '</label> ';
		$output .= '<input class="widefat" id="' . $this->get_field_id('subtext') . '" name="' . $this->get_field_name('subtext') . '" type="text" value="' . $subtext . '" /> <em>' . __('(basic HTML allowed)', 'coolclock') . '</em></p>';

		$output .= '<div class="coolclock-advanced" style="background-color:rgba(0,0,0,.03);padding:1px 7px;border-radius:5px;margin-bottom:10px">';

		$output .= '<p><strong>' . translate('Advanced') . '</strong></p>';

		// Use GMT offset
		$output .= '<p><label for="' . $this->get_field_id('gmtoffset') . '">' . __('GMT offset:', 'coolclock') . '</label> ';
		$output .= '<input class="small-text" id="' . $this->get_field_id('gmtoffset') . '" name="' . $this->get_field_name('gmtoffset') . '" type="number" step="0.5" value="' . $instance['gmtoffset'] . '" /> <em>' . __('(leave blank for visitor local time)', 'coolclock') . '</em></p>';

		// Scale
		$output .= '<p><label for="' . $this->get_field_id('scale') . '">' . __('Scale:', 'coolclock') . '</label> ';
		$output .= '<select class="select" id="' . $this->get_field_id('scale') . '" name="' . $this->get_field_name('scale') . '">';
		foreach ( CoolClock::$clock_types as $key => $value ) {
			$output .= '<option value="' . $key . '" ' . selected( $key, strtolower($instance['scale']), false ) . '>';
			$output .= ( isset($type_names[$key]) ) ? $type_names[$key] : $value;
			$output .= '</option>';
		}
		$output .= '</select></p>';

		// Show digital
		if ( $instance['showdigital'] == 'true' || $instance['showdigital'] == '1' )
			$instance['showdigital'] = 'digital12'; // backward compat

		$output .= '<p><label for="' . $this->get_field_id('showdigital') . '">' . __('Show digital:', 'coolclock') . '</label> ';
		$output .= '<select class="select" id="' . $this->get_field_id('showdigital') . '" name="' . $this->get_field_name('showdigital') . '">';
		foreach ( CoolClock::$showdigital_options as $key => $value ) {
			$output .= '<option value="' . $key . '" ' . selected( $key, $instance['showdigital'], false ) . '>';
			$output .= ( isset($showdigital_names[$key]) ) ? $showdigital_names[$key] : $value;
			$output .= '</option>';
		}
		$output .= '</select></p>';

		$output .= '<p><label for="' . $this->get_field_id('fontcolor') . '">' . __('Digital font color:', 'coolclock') . '</label> ';
		$output .= '<input id="' . $this->get_field_id('fontcolor') . '" name="' . $this->get_field_name('fontcolor') . '" type="text" value="' . $instance['fontcolor'] . '" /> <em>' . __('(use a valid HTML color code or name)', 'coolclock') . '</em></p>';

		$advanced .= '<p><a href="http://premium.status301.net/downloads/coolclock-advanced/">' . __('More digital font options &raquo;', 'coolclock') . '</a></p>
		<p><strong>' . __('Background') . '</strong></p><p><a href="http://premium.status301.net/downloads/coolclock-advanced/">' . __('Available in the Advanced extension &raquo;', 'coolclock') . '</a></p>';

		// Advanced filter
		$output .= apply_filters( 'coolclock_widget_form_advanced', $advanced, $this, $instance, $defaults );

		$output .= '</div>';

		if ( class_exists( 'CoolClockAdvanced' ) && isset(CoolClockAdvanced::$plugin_version) && version_compare( CoolClockAdvanced::$plugin_version, '7.1', '<' )  ) { // add an upgrade notice
			$output .= '<div class="update-nag"><strong>' . __('Please upgrade the CoolClock - Advanced extension.', 'coolclock') . '</strong> '. ' <a href="http://premium.status301.net/account/" target="_blank">' . __('Please log in with your account credentials here.', 'coolclock') . '</a>' . __('You can download the new version using the link in the downloads list.', 'coolclock') . '</div>';
		}

		echo $output;
	}

}
