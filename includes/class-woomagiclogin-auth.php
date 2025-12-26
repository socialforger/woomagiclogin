<?php
namespace Woomagiclogin;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Auth {

    public static function login_user( $user_id ) {
        wp_set_current_user( $user_id );
        wp_set_auth_cookie( $user_id );

        do_action( 'wml_user_logged_in', $user_id );

        wp_safe_redirect( wc_get_page_permalink( 'myaccount' ) );
        exit;
    }

    public static function render_invalid_token() {
        wp_die( __( 'Link di accesso non valido o scaduto.', 'woomagiclogin' ) );
    }
}
