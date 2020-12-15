<?php
/*
Plugin Name: CoolClock
Plugin URI: https://status301.net/wordpress-plugins/coolclock/
Description: An analog clock for your site.
Text Domain: coolclock
Domain Path: languages
Version: 4.3.3
Author: RavanH
Author URI: https://status301.net/
*/

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'COOLCLOCK_DIR', plugin_dir_path(__FILE__) );

/**************
 *   CLASSES
 **************/

require COOLCLOCK_DIR . 'includes/class-coolclock.php';
require COOLCLOCK_DIR . 'includes/class-coolclock-widget.php';
require COOLCLOCK_DIR . 'includes/class-coolclock-shortcode.php';

/**************
 *  INITIATE
 **************/

new CoolClock( __FILE__, '4.3.3' );
