<?php
namespace Woomagiclogin;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Email {

    public static function send_magic_link( $user_id ) {
        $user = get_user_by( 'id', $user_id );
        if ( ! $user ) {
            return;
        }

        $email = $user->user_email;
        $token = Token::generate_token( $user_id );

        $login_url = add_query_arg(
            [
                'wml'   => 'login',
                'token' => $token,
            ],
            wc_get_page_permalink( 'myaccount' )
        );

        $subject = __( 'Accedi alla piattaforma', 'woomagiclogin' );

        $message  = "Ciao,\n\n";
        $message .= "hai richiesto l’accesso alla piattaforma.\n\n";
        $message .= "Per entrare, clicca sul link qui sotto:\n\n";
        $message .= $login_url . "\n\n";
        $message .= "-----------------------------\n";
        $message .= "Nota importante sull’adesione\n\n";
        $message .= "L’accesso alla piattaforma comporta la possibilità di aderire all’associazione che la gestisce.\n";
        $message .= "Per completare l’adesione ti verrà chiesto di inserire alcuni dati aggiuntivi nella tua area personale.\n\n";
        $message .= "Se non hai richiesto tu questo accesso, puoi ignorare questa email.\n";

        wp_mail( $email, $subject, $message );
    }
}
