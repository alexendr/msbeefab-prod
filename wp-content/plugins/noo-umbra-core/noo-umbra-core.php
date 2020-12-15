<?php
/**
 * @package noo-umbra-core
 */
/*
Plugin Name: NOO Umbra Core
Plugin URI: http://nootheme.com/
Description: Plugin that adds all post types needed by our theme.
Version: 1.4.2
Author: NooTheme
Author URI: http://nootheme.com/
License: GPLv2 or later
*/
if ( !class_exists('Noo_Umbra_Core') ):

    class Noo_Umbra_Core{

        /*
         * This method loads other methods of the class.
         */
        public function __construct(){
            /* load languages */
            $this -> load_languages();

            /*load all nootheme*/
            $this -> load_nootheme();

            /*auto update version*/
            $this->load_check_version();
        }

        /*
         * Load the languages before everything else.
         */
        private function load_languages(){
            add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
        }

        /*
         * Load the text domain.
         */
        public function load_textdomain(){

            load_plugin_textdomain(  'noo-umbra-core', false, plugin_basename( dirname( __FILE__ ) ).'/languages' );
        }

        /*
         * Load Nootheme on the 'after_setup_theme' action. Then filters will
         */
        public function load_nootheme(){

            $this -> constants();

            $this -> includes();
        }

        /*
         * Load Nootheme on the 'after_setup_theme' action. Then filters will
         */
        public function load_check_version(){

            if( !class_exists('Noo_Check_Version_Child') ) {
                require_once( NOO_PLUGIN_SERVER_PATH.'/admin/noo-check-version-child.php' );
            }

            $check_version = new Noo_Check_Version_Child(
                'noo-umbra-core',
                'NOO umbra Core',
                'noo-umbra',
                'http://update.nootheme.com/api/license-manager/v1',
                'plugin',
                __FILE__
            );
        }

        /**
         * Constants
         */
        private function constants(){

            if( !defined( 'NOO_PLUGIN_PATH' ) ) define('NOO_PLUGIN_PATH', plugin_dir_url( __FILE__ ));

            if( !defined( 'NOO_PLUGIN_ASSETS_URI' ) ) define('NOO_PLUGIN_ASSETS_URI', plugin_dir_url( __FILE__ ) . '/assets');

            if( !defined( 'NOO_ADMIN_ASSETS_URI' ) ) define('NOO_ADMIN_ASSETS_URI', plugin_dir_url( __FILE__ ) . 'admin_assets' );

            if( !defined( 'NOO_PLUGIN_SERVER_PATH' ) ) define('NOO_PLUGIN_SERVER_PATH', dirname( __FILE__ ) );

            if( !defined( 'NOO_FRAMEWORK' ) ) define('NOO_FRAMEWORK', dirname( __FILE__ ) . '/framework' );

            if( !defined( 'NOO_FRAMEWORK_URI' ) ) define('NOO_FRAMEWORK_URI', plugin_dir_url( __FILE__ ) . '/framework' );

        }

        /*
         * Require file
         */
        private function  includes(){
             require_once NOO_PLUGIN_SERVER_PATH . '/admin/importer/noo-setup-install.php';
            require_once NOO_PLUGIN_SERVER_PATH . '/admin/post-type/function-init.php';
            require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/vc_init.php';

            // Init Framework.
            require_once NOO_FRAMEWORK . '/_init.php';
            require_once NOO_FRAMEWORK . '/woo_extensions.php';
        }


    }
    $oj_nooplugin = new Noo_Umbra_Core();

endif;

// Add NOO-Customizer Menu
function noo_umbra_add_customizer_menu() {
    $customizer_icon = 'dashicons-admin-customizer';

    add_menu_page( esc_html__( 'Customizer', 'noo-umbra' ), esc_html__( 'Customizer', 'noo-umbra' ), 'edit_theme_options', 'customize.php', null, $customizer_icon, 61 );
    add_submenu_page( 'options.php', '', '', 'edit_theme_options', 'export_settings', 'noo_customizer_export_theme_settings' );
}
add_action( 'admin_menu', 'noo_umbra_add_customizer_menu' );

require_once dirname( __FILE__ ) . '/admin/smk-sidebar-generator/smk-sidebar-generator.php';
require_once dirname( __FILE__ ) . '/admin/twitter/twitteroauth.php';