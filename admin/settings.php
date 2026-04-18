<?php
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'admin_menu', function() {
    add_options_page(
        'Cookie Consent',
        'Cookie Consent',
        'manage_options',
        'dfc-settings',
        'dfc_render_settings_page'
    );
} );

add_action( 'admin_init', function() {
    register_setting( 'dfc_options_group', 'dfc_options', [
        'sanitize_callback' => 'dfc_sanitize_options',
    ] );
} );

function dfc_sanitize_options( $input ) {
    $fields = [ 'title', 'text', 'accept_label', 'reject_label', 'privacy_url', 'cookies_url', 'terms_url', 'returns_url' ];
    $clean = [];
    foreach ( $fields as $field ) {
        $clean[ $field ] = isset( $input[ $field ] ) ? sanitize_text_field( $input[ $field ] ) : '';
    }
    return $clean;
}

function dfc_render_settings_page() {
    $options = get_option( 'dfc_options', [] );
    $defaults = [
        'title'        => 'Ta strona używa plików cookies',
        'text'         => 'Używamy plików cookies, aby zapewnić najlepszą jakość korzystania z naszej strony. Klikając „Akceptuj", wyrażasz zgodę na ich użycie.',
        'accept_label' => 'Akceptuj wszystkie',
        'reject_label' => 'Odrzuć',
        'privacy_url'  => '/polityka-prywatnosci',
        'cookies_url'  => '/polityka-cookies',
        'terms_url'    => '/regulamin',
        'returns_url'  => '/polityka-zwrotow',
    ];
    $o = wp_parse_args( $options, $defaults );
    ?>
    <div class="wrap">
        <h1>Ustawienia Cookie Consent</h1>
        <form method="post" action="options.php">
            <?php settings_fields( 'dfc_options_group' ); ?>
            <table class="form-table">
                <tr>
                    <th><label for="dfc_title">Tytuł banera</label></th>
                    <td><input type="text" id="dfc_title" name="dfc_options[title]" value="<?php echo esc_attr( $o['title'] ); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th><label for="dfc_text">Treść banera</label></th>
                    <td><textarea id="dfc_text" name="dfc_options[text]" rows="4" class="large-text"><?php echo esc_textarea( $o['text'] ); ?></textarea></td>
                </tr>
                <tr>
                    <th><label for="dfc_accept">Etykieta przycisku Akceptuj</label></th>
                    <td><input type="text" id="dfc_accept" name="dfc_options[accept_label]" value="<?php echo esc_attr( $o['accept_label'] ); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th><label for="dfc_reject">Etykieta przycisku Odrzuć</label></th>
                    <td><input type="text" id="dfc_reject" name="dfc_options[reject_label]" value="<?php echo esc_attr( $o['reject_label'] ); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th><label for="dfc_privacy_url">URL Polityki prywatności</label></th>
                    <td><input type="text" id="dfc_privacy_url" name="dfc_options[privacy_url]" value="<?php echo esc_attr( $o['privacy_url'] ); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th><label for="dfc_cookies_url">URL Polityki cookies</label></th>
                    <td><input type="text" id="dfc_cookies_url" name="dfc_options[cookies_url]" value="<?php echo esc_attr( $o['cookies_url'] ); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th><label for="dfc_terms_url">URL Regulaminu</label></th>
                    <td><input type="text" id="dfc_terms_url" name="dfc_options[terms_url]" value="<?php echo esc_attr( $o['terms_url'] ); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th><label for="dfc_returns_url">URL Polityki zwrotów</label></th>
                    <td><input type="text" id="dfc_returns_url" name="dfc_options[returns_url]" value="<?php echo esc_attr( $o['returns_url'] ); ?>" class="regular-text" /></td>
                </tr>
            </table>
            <?php submit_button( 'Zapisz ustawienia' ); ?>
        </form>
    </div>
    <?php
}
