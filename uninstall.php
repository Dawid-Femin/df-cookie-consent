<?php
/**
 * Uninstall script - runs when plugin is deleted
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

delete_option( 'dfc_options' );
