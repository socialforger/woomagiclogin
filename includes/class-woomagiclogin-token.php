<?php
namespace Woomagiclogin;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Token {

    public static function generate_token( $user_id ) {
        $token  = wp_generate_password( 48, false );
        $expiry = time() + HOUR_IN_SECONDS;

        update_user_meta( $user_id, 'wml_login_token', $token );
        update_user_meta( $user_id, 'wml_login_token_expiry', $expiry );

        return $token;
    }

    public static function validate_token( $token ) {
        $user_query = new \WP_User_Query( [
            'meta_key'   => 'wml_login_token',
            'meta_value' => $token,
            'number'     => 1,
            'fields'     => 'ID',
        ] );

        $users = $user_query->get_results();
        if ( empty( $users ) ) {
            return false;
        }

        $user_id = (int) $users[0];
        $expiry  = (int) get_user_meta( $user_id, 'wml_login_token_expiry', true );

        if ( $expiry < time() ) {
            delete_user_meta( $user_id, 'wml_login_token' );
            delete_user_meta( $user_id, 'wml_login_token_expiry' );
            return false;
        }

        delete_user_meta( $user_id, 'wml_login_token' );
        delete_user_meta( $user_id, 'wml_login_token_expiry' );

        return $user_id;
    }
}
