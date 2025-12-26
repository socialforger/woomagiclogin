<?php
/**
 * Plugin Name: Woo Magic Login
 * Description: Registrazione e accesso con magic link per WooCommerce.
 * Version: 0.3.0
 * Author: Socialforger
 * Text Domain: woomagiclogin
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'WML_PLUGIN_VERSION', '0.3.0' );
define( 'WML_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WML_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * Carica il plugin principale
 */
require_once WML_PLUGIN_DIR . 'includes/class-woomagiclogin-plugin.php';

/**
 * Inizializza il plugin
 */
function wml_init_plugin() {
    \Woomagiclogin\Plugin::instance();
}
add_action( 'plugins_loaded', 'wml_init_plugin' );
