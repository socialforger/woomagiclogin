<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<form method="post" class="wml-register-form">

    <p class="form-row form-row-wide">
        <label for="wml_email"><?php esc_html_e( 'Email', 'woomagiclogin' ); ?> *</label>
        <input type="email" name="wml_email" id="wml_email" required />
    </p>

    <?php wp_nonce_field( 'wml_register', 'wml_register_nonce' ); ?>

    <p class="form-row">
        <button type="submit" class="button">
            <?php esc_html_e( 'Registrati / Accedi', 'woomagiclogin' ); ?>
        </button>
    </p>
</form>
