<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<form method="post" class="wml-login-form">

    <p class="form-row form-row-wide">
        <label for="wml_login_email"><?php esc_html_e( 'Email', 'woomagiclogin' ); ?> *</label>
        <input type="email" name="wml_login_email" id="wml_login_email" required />
    </p>

    <?php wp_nonce_field( 'wml_login', 'wml_login_nonce' ); ?>

    <p class="form-row">
        <button type="submit" class="button">
            <?php esc_html_e( 'Accedi', 'woomagiclogin' ); ?>
        </button>
    </p>
</form>
