<?php
namespace Woomagiclogin;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class WooCommerce_Integration {

    public function __construct() {
        add_action( 'init', [ $this, 'maybe_handle_register_form' ] );
        add_action( 'init', [ $this, 'maybe_handle_login_form' ] );
    }

    protected function generate_internal_username() {
        $prefix = 'wml_';
        $length = 10;
        $chars  = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        do {
            $random = '';
            for ( $i = 0; $i < $length; $i++ ) {
                $random .= substr( $chars, wp_rand( 0, strlen( $chars ) - 1 ), 1 );
            }
            $username = $prefix . $random;
        } while ( username_exists( $username ) );

        return $username;
    }

    public function maybe_handle_register_form() {
        if ( 'POST' !== $_SERVER['REQUEST_METHOD'] ) {
            return;
        }

        if ( ! isset( $_POST['wml_register_nonce'] ) || ! wp_verify_nonce( $_POST['wml_register_nonce'], 'wml_register' ) ) {
            return;
        }

        $this->handle_register_submission();
    }

    protected function handle_register_submission() {
        $email = isset( $_POST['wml_email'] ) ? sanitize_email( wp_unslash( $_POST['wml_email'] ) ) : '';

        if ( empty( $email ) || ! is_email( $email ) ) {
            wc_add_notice( __( 'Inserisci una email valida.', 'woomagiclogin' ), 'error' );
            return;
        }

        $existing = get_user_by( 'email', $email );
        if ( $existing ) {
            Email::send_magic_link( $existing->ID );
            wc_add_notice( __( 'Ti abbiamo inviato un link di accesso via email.', 'woomagiclogin' ), 'success' );
            wp_safe_redirect( wc_get_page_permalink( 'myaccount' ) );
            exit;
        }

        $username = $this->generate_internal_username();

        $user_id = wp_create_user(
            $username,
            wp_generate_password( 32, true ),
            $email
        );

        if ( is_wp_error( $user_id ) ) {
            wc_add_notice( __( 'Errore nella creazione dell’utente.', 'woomagiclogin' ), 'error' );
            return;
        }

        // profilo da completare: wooassociation aggiornerà questo flag
        update_user_meta( $user_id, 'wml_profile_complete', 'no' );

        do_action( 'wml_user_registered', $user_id );

        Email::send_magic_link( $user_id );
        wc_add_notice( __( 'Ti abbiamo inviato un link di accesso via email.', 'woomagiclogin' ), 'success' );
        wp_safe_redirect( wc_get_page_permalink( 'myaccount' ) );
        exit;
    }

    public function maybe_handle_login_form() {
        if ( 'POST' !== $_SERVER['REQUEST_METHOD'] ) {
            return;
        }

        if ( ! isset( $_POST['wml_login_nonce'] ) || ! wp_verify_nonce( $_POST['wml_login_nonce'], 'wml_login' ) ) {
            return;
        }

        $this->handle_login_submission();
    }

    protected function handle_login_submission() {
        $email = isset( $_POST['wml_login_email'] ) ? sanitize_email( wp_unslash( $_POST['wml_login_email'] ) ) : '';

        if ( empty( $email ) || ! is_email( $email ) ) {
            wc_add_notice( __( 'Inserisci una email valida.', 'woomagiclogin' ), 'error' );
            return;
        }

        $user = get_user_by( 'email', $email );

        if ( ! $user ) {
            wc_add_notice( __( 'Nessun account trovato con questa email.', 'woomagiclogin' ), 'error' );
            return;
        }

        Email::send_magic_link( $user->ID );

        wc_add_notice( __( 'Ti abbiamo inviato un link di accesso via email.', 'woomagiclogin' ), 'success' );
        wp_safe_redirect( wc_get_page_permalink( 'myaccount' ) );
        exit;
    }
}
