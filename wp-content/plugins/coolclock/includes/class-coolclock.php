<?php

/**
 * CoolClock Class
 */

class CoolClock {

	static $plugin_version;

	static $script_version = '3.2.2';

	private static $plugin_url;

	private static $plugin_basename;

	private static $min = '.min';

	static $add_script = false;

	private static $done_excanvas = false;

	static $defaults = array(
		'skin' => 'swissrail',
		'radius' => 100,
		'noseconds' => false,	// true to hide second hand
		'gmtoffset' => '',		// GMT offset
		'showdigital' => '',	// show digital time or date
		'scale' => '',			// Define alternative clock type: 'logClock' logarithmic or 'logClockRev' reversed
		'font' => '',			// Define font size and family for digital time, default '15px monospace'
		'fontcolor' => ''		// Define font color for digital time, default '#333'
	);

	static $showdigital_options = array(
		'' => '',
		'digital12' => 'showDigital'
	);

	static $advanced_defaults = array(
		'subtext' => '',
		'align' => 'center'
	);

	static $more_skins_config = array();

	static $advanced_skins_config = array();

	static $skins_config = array();

	/**
	 * DEPRICATED ARGUMENTS
	 * keep these for backward compatibility with old advanced extension
	 */
	static $default_skins = array('swissRail');
	static $more_skins = array();
	static $advanced_skins = array();
	static $advanced = false;
	/* end unused arguments */

	static $clock_types = array(
		'linear' => '',
		'logclock' => 'logClock',
		'logclockrev' => 'logClockRev'
	);

	static $allowed_tags = array(
		'a' => array(
			'href' => array(),
			'title' => array(),
			'target' => array()
		),
		'br' => array(),
		'em' => array(),
		'strong' => array(),
	);

	/**
	 * INIT
	 */

	public function __construct( $plugin_file, $plugin_version )
	{
 		// VARS
 		self::$plugin_url = plugins_url( '/', $plugin_file );
 		self::$plugin_basename = plugin_basename( $plugin_file );
		self::$plugin_version = $plugin_version;

 		if ( defined('WP_DEBUG') && WP_DEBUG ) {
 			self::$min = '';
 		}

		// text domain
		add_action( 'plugins_loaded', array( __CLASS__, 'textdomain' ) );

		// widgets
		add_action( 'widgets_init', array( __CLASS__, 'register_widget' ) );

		// enqueue scripts but only if shortcode or widget has been used
		// so it has to be done as late as the wp_footer action
		add_action( 'wp_footer', array( __CLASS__, 'enqueue_scripts' ), 1 );

		add_filter( 'plugin_row_meta', array( __CLASS__, 'plugin_meta_links' ), 10, 2);

		// backward compat
		add_filter( 'coolclock_shortcode', array( __CLASS__, 'filter_shortcode'), 10, 3 );
		add_filter( 'coolclock_widget', array( __CLASS__, 'filter_widget'), 10, 3 );

		/**************
		 *  SHORTCODE
		 **************/

		add_shortcode( 'coolclock', array( 'CoolClock_Shortcode', 'handle_shortcode' ) );

		// prevent texturizing shortcode content
		add_filter( 'no_texturize_shortcodes', array( 'CoolClock_Shortcode', 'no_wptexturize') );
 	}

	/**
	 * METHODS
	 */

	/**
	* Build canvas output
	*
	* @since 2.0
	*
	* @param array $atts Array of sanitized attributes
	*
	* @return string Canvas tag
	*/

	public static function canvas( $atts )
	{
		/**
		* ARRAY VALUES
		* skin			@param string		Skin ID. Must be one of these: 'swissRail' (default skin), 'chunkySwiss', 'chunkySwissOnBlack', 'fancy', 'machine', 'simonbaird_com', 'classic', 'modern', 'simple', 'securephp', 'Tes2', 'Lev', 'Sand', 'Sun', 'Tor', 'Cold', 'Babosa', 'Tumb', 'Stone', 'Disc', 'watermelon' or 'mister'.
		* 									If the Advanced extension is activated, there is also 'minimal' available.
		* radius		@param int			Define the clock radius.
		* noseconds		@param bool			True to hide the second hand.
		* gmtoffset		@param float		Timezone offset relative the Greenwhich Mean Time
		* showdigital	@param string|bool	Set to 'digital12' to show the time in 12h digital format (with am/pm).
		* font			@param string		Set to a font size, family and style for the digital time
		* fontcolor		@param string		Set to a color value to change the digital time color
		* scale			@param string		Optional alternative clock scale 'logClock' or 'logClockRev'
		* subtext		@param string		Optional text, centered below the clock
		* align			@param string	 	Sets floating of the clock: 'left', 'right' or 'center'
		*/

		// get defaults for missing attributes
		$defaults = array_merge( self::$defaults, self::$advanced_defaults );

		$atts = apply_filters( 'coolclock_atts', $atts, $defaults );

		// CoolClock fields array
		$fields = array();
		$fields[] = 'CoolClock';
		// skin id
		$fields[] = !empty( $atts['skin'] ) ? $atts['skin'] : $defaults['skin'];
		// radius
		$fields[] = !empty( $atts['radius'] ) && is_numeric($atts['radius']) ? (int) $atts['radius'] : $defaults['radius'];
		// noseconds
		$noseconds = isset( $atts['noseconds'] ) ? (bool) $atts['noseconds'] : $defaults['noseconds'];
		$fields[] = $noseconds ? 'noSeconds' : '';
		// gmt offset
		$fields[] = isset( $atts['gmtoffset'] ) && is_numeric( $atts['gmtoffset'] ) ? (float) $atts['gmtoffset'] : $defaults['gmtoffset'];
		// show digital
		$showdigital = isset($atts['showdigital']) ? $atts['showdigital'] : $defaults['showdigital'];
		if ( true === $showdigital )
			$showdigital = 'digital12';
		$fields[] = isset( self::$showdigital_options[$showdigital] ) ? self::$showdigital_options[$showdigital] : '';
		// clock type
		$scale = isset( $atts['scale'] ) ? strtolower( $atts['scale'] ) : $defaults['scale'];
		$fields[] = isset( self::$clock_types[$scale] ) ? self::$clock_types[$scale] : '';
		// set font color
		$fields[] = isset( $atts['fontcolor'] ) ? $atts['fontcolor'] : $defaults['fontcolor'];

		$fields = apply_filters( 'coolclock_fields_array', $fields, $atts, $defaults );

		// build output
		$output = '';

		if ( ! self::$done_excanvas ){
			$output .= '<!--[if lte IE 8]>';
			$output .= '<script type="text/javascript" src="'. self::$plugin_url . 'js/excanvas' . self::$min . '.js"></script>';
			$output .= '<![endif]-->' . PHP_EOL;
			self::$done_excanvas = true;
		}

		$styles = apply_filters( 'coolclock_canvas_styles',  array(), $atts, $defaults );

		// canvas parameters
		$output .= '<canvas class="' . implode(':',$fields) . '"' . CoolClock::inline_style( $styles ) . '></canvas>';

		// sub text
		$subtext = ( isset( $atts['subtext'] ) ) ? $atts['subtext'] : $defaults['subtext'];
		if ( !empty( $subtext ) )
		 	$output .= '<div class="coolclock-subtext">' . $subtext . '</div>';

		return $output;
	}

	/**
	* Create inline style attribute from array
	*
	* @since 4.3
	*
	* @param array $styles array with style parameters and their values
	*
	* @return string inline style attribute style="..." complete with leading space
	*/

	public static function inline_style( $styles )
	{
		$style_arr = array();

		foreach ( $styles as $key => $value ) {
			$style_arr[] = $key . ':' . $value;
		}

		$style = ! empty($style_arr) ? ' style="' . implode( ';', $style_arr ) . '"' : '';

		return $style;
	}

	/**
	* Parse skin name and user skin parameters
	*
	* @since 3.2.0
	*
	* @param string $skin_name skin name
	* @param string $skin_parms skin parameters, preferably in JSON format
	*
	* @return string either found matching skin name or 'invalid_or_missing_skin' on failure
	*/

	public static function parse_skin( $skin_name, $skin_parms = '' )
	{
		$skin = strtolower($skin_name);
		$skin_array = array();

		// check for empty or default skin first
		if ( empty($skin) || $skin == self::$defaults['skin'] )
			// return the matching skin name
			return self::$defaults['skin'];

		// short-circuit if skin name is already in the config array
		if ( array_key_exists( $skin, self::$skins_config ) )
			// return the matching skin name
			return $skin;

		// search in the more_skins and advanced_skins arrays
		$all_skins = self::get_all_skins();
		if ( array_key_exists( $skin, $all_skins ) ) {
			// fetch parameters from skins array
			$skin_array = is_array( $all_skins[$skin] ) ? $all_skins[$skin] : self::skin_array( $all_skins[$skin] );
		}
		// try to build a skin config from passed parameters
		else {
			// fetch parameters from custom skin user input
			$skin_array = self::skin_array( $skin_parms );

			if ( empty( $skin_array ) )
				// set faulty skin name
				return 'no_skin_found';
		}

		// add found skin parameters to the config array
		self::$skins_config[$skin] = $skin_array;

		// return the matching skin name
		return $skin;
	}

	public static function get_all_skins() {

		if ( empty( self::$more_skins_config ) ) {

			include COOLCLOCK_DIR . 'includes/moreskins.php';

			self::$more_skins_config = $more_skins;

		}

		return array_merge( self::$more_skins_config, self::$advanced_skins_config );
	}

	public static function enqueue_scripts() {
		// bail if we don't need script
		if ( ! self::$add_script )
			return;

		$script = '';

		if ( !empty( self::$skins_config ) ) {

			/**
			 * Load IE 6/7 specific JSON polyfill
			 */
			wp_enqueue_script( 'json2' );

			$script .=  'CoolClock.config.skins = JSON.parse(\'' . json_encode( self::$skins_config ) . '\');';

		}

		$script .= PHP_EOL . 'if(document.addEventListener){document.addEventListener("DOMContentLoaded",function(){CoolClock.findAndCreateClocks();})}else{CoolClock.findAndCreateClocks();};';

		wp_enqueue_script( 'coolclock', self::$plugin_url . 'js/coolclock' . self::$min . '.js', false, self::$script_version, true );

		wp_add_inline_script( 'coolclock', $script );

		// called late so should end up in the footer
		wp_enqueue_style( 'coolclock', self::$plugin_url . 'css/coolclock' . self::$min . '.css' );
	}

	public static function textdomain() {
		load_plugin_textdomain( 'coolclock', false, dirname(self::$plugin_basename).'/languages' );
	}

	public static function register_widget() {
		register_widget("CoolClock_Widget");
	}

	// add links to plugin's description
	public static function plugin_meta_links($links, $file) {
	  $support_link = '<a target="_blank" href="https://wordpress.org/support/plugin/coolclock/">' . __('Support','coolclock') . '</a>';
	  $rate_link = '<a target="_blank" href="https://wordpress.org/support/plugin/coolclock/reviews/?filter=5#new-post">' . __('Rate ★★★★★','coolclock') . '</a>';

	  if ( $file == self::$plugin_basename ) {
	    $links[] = $support_link;
	    $links[] = $rate_link;
	  }

	  return $links;
	}

	/**
	* Turn custom skin user input into an array
	*
	* @since 2.0
	*
	* @param string $skin
	*
	* @return array array of skin parameters
	*/

	public static function skin_array( $skin )
	{
		// remove everything following a ; to thwart any script injection
		$parts = explode( ';', $skin, 2 );
		$sanitized = $parts[0];
		// strip all kind of whitespace
		$sanitized = preg_replace("/\s+/", '', $sanitized);;
		$sanitized = ltrim( $sanitized, '{' );
		$sanitized = rtrim( $sanitized, '}' ) . '}';
		// by now, the string should start with a double quote
		if ( 0 !== strpos( $sanitized, '"' ) ) {
			// regex for (re)wrapping all keys in double quotes
			$sanitized = preg_replace( "/(['\"])?([a-zA-Z0-9_]+)(['\"])?:([^\/])/", '"$2":$4', $sanitized );
		}

		// fist attempt to decode json string
		$skin_array = json_decode( '{' . $sanitized . '}', true );

		// not valid json? then do it the hard way
		if ( null === $skin_array ) :

			// remove all spaces and tabs
			$sanitized = str_replace( array( ' ', "\t", '"', "'" ), '', $sanitized );

			// break it all up in little parts
			// this converts valid skin javascript object into json, but messes up all else :/
			$elements = explode( '},', $sanitized );

			// start fresh
			$skin_array = array();

			// and build array
			foreach( $elements as $element ) {
				$pair = explode( ':{', $element );
				// validate key
				$part = str_replace( '{', '', $pair[0] );
				if ( ! in_array( $part, array('outerBorder','smallIndicator','largeIndicator','hourHand','minuteHand','secondHand','secondDecoration') ) )
					continue;
				// constuct value
				$value = array();
				$parameters = explode( ',', $pair[1] );
				for( $i=0; $i < count( $parameters ); $i++ ) {
					$pairs = explode( ':', $parameters[$i] );
					$parm_val = str_replace( '}', '', $pairs[1] );
					$value[$pairs[0]] = is_numeric($parm_val) ? (float) $parm_val : (string) $parm_val;
				}
				$skin_array[$part] = $value;
			}

		endif;

		return $skin_array;
	}

	/**
	* Sanitize color value user input
	*
	* @since 4.2
	*
	* @param string $color
	*
	* @return string hex color value or text for named color
	*/

	public static function colorval( $color )
	{
		$color = wp_strip_all_tags( $color );
		$color = trim( $color );

		if ( substr($color, 0, 1) == '#' ) {
			if ( ctype_xdigit( substr( $color, 1 ) ) )
				return $color;

			return substr( $color, 1 );
		}

		return ctype_xdigit( $color ) ? '#'.$color : $color;
	}

	/**
	* Filter shortcode output
	*
	* @since 4.3
	*
	* @param string 	$output 	output
	* @param array 		$atts 		array of shortcode attributes
	* @param string 	$content 	shortcode content
	*
	* @return string 	output
	*/

	public static function filter_shortcode( $output, $atts, $content )
	{
		// add backward compat filter
		return apply_filters( 'coolclock_shortcode_advanced', $output, $atts, $content );
	}

	/**
	* Filter widget output
	*
	* @since 4.3
	*
	* @param string 	$output 	output
	* @param array 		$args 		array of widget parameters
	* @param array 		$instance 	widget instance array parameters
	*
	* @return string 	output
	*/

	public static function filter_widget( $output, $args, $instance )
	{
		// add backward compat filter
		return apply_filters( 'coolclock_widget_advanced', $output, $args, $instance );
	}

}
