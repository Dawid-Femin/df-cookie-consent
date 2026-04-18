<?php
/**
 * Plugin Name: DF Cookie Consent
 * Description: Baner zgody na pliki cookies zgodny z RODO.
 * Version: 1.0.0
 * Author: Dawid Femin
 * Text Domain: df-cookie-consent
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'DFC_VERSION', '1.0.0' );
define( 'DFC_URL', plugin_dir_url( __FILE__ ) );

function dfc_enqueue_assets() {
    wp_enqueue_style( 'dfc-style', DFC_URL . 'assets/css/cookie-consent.css', [], DFC_VERSION );
    wp_enqueue_script( 'dfc-script', DFC_URL . 'assets/js/cookie-consent.js', [], DFC_VERSION, true );

    $options = get_option( 'dfc_options', [] );
    wp_localize_script( 'dfc-script', 'dfcData', [
        'title'           => $options['title']           ?? 'Ta strona używa plików cookies',
        'text'            => $options['text']            ?? 'Używamy plików cookies, aby zapewnić najlepszą jakość korzystania z naszej strony. Klikając „Akceptuj", wyrażasz zgodę na ich użycie.',
        'accept_label'    => $options['accept_label']    ?? 'Akceptuj wszystkie',
        'reject_label'    => $options['reject_label']    ?? 'Odrzuć',
        'privacy_url'     => $options['privacy_url']     ?? '/polityka-prywatnosci',
        'cookies_url'     => $options['cookies_url']     ?? '/polityka-cookies',
        'terms_url'       => $options['terms_url']       ?? '/regulamin',
        'returns_url'     => $options['returns_url']     ?? '/polityka-zwrotow',
        'cookie_name'     => 'dfc_consent',
        'cookie_days'     => 365,
    ] );
}
add_action( 'wp_enqueue_scripts', 'dfc_enqueue_assets' );

require_once plugin_dir_path( __FILE__ ) . 'admin/settings.php';
