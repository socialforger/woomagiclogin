<?php
namespace Woomagiclogin;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once WML_PLUGIN_DIR . 'includes/class-woomagiclogin-token.php';
require_once WML_PLUGIN_DIR . 'includes/class-woomagiclogin-email.php';
require_once WML_PLUGIN_DIR . 'includes/class-woomagiclogin-auth.php';
require_once WML_PLUGIN_DIR . 'includes/class-woomagiclogin-woocommerce.php';

class Plugin {

    private static $instance = null;

    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->load_textdomain();

        add_action( 'init', [ $this, 'register_query_vars' ] );
        add_action( 'template_redirect', [ $this, 'handle_magic_login_request' ] );

        add_shortcode( 'woomagiclogin_register', [ $this, 'render_register_form_shortcode' ] );
        add_shortcode( 'woomagiclogin_login', [ $this, 'render_login_form_shortcode' ] );

        new WooCommerce_Integration();
    }

    private function load_textdomain() {
        load_plugin_textdomain(
            'woomagiclogin',
            false,
            dirname( plugin_basename( WML_PLUGIN_DIR . 'woomagiclogin.php' ) ) . '/languages'
        );
    }

    public function register_query_vars() {
        add_rewrite_tag( '%wml%', '([^&]+)' );
        add_rewrite_tag( '%wml_token%', '([^&]+)' );
    }

    public function handle_magic_login_request() {
        if ( ! isset( $_GET['wml'] ) || 'login' !== $_GET['wml'] ) {
            return;
        }

        $token = isset( $_GET['token'] ) ? sanitize_text_field( wp_unslash( $_GET['token'] ) ) : '';

        if ( empty( $token ) ) {
            Auth::render_invalid_token();
            exit;
        }

        $user_id = Token::validate_token( $token );
        if ( ! $user_id ) {
            Auth::render_invalid_token();
            exit;
        }

        Auth::login_user( $user_id );
    }

    public function render_register_form_shortcode() {
        ob_start();
        wc_print_notices();
        include WML_PLUGIN_DIR . 'templates/form-register.php';
        return ob_get_clean();
    }

    public function render_login_form_shortcode() {
        ob_start();
        wc_print_notices();
        include WML_PLUGIN_DIR . 'templates/form-login.php';
        return ob_get_clean();
    }
}
