<?php
/**
 * Plugin Name: Redirect Plugin
 * Plugin URI:  https://mon-site.com/redirect-plugin
 * Description: Redirige les visiteurs du front-office vers une URL définie.
 * Version:     1.0.0
 * Author:      Djanta  Dev
 * Author URI:  https://mon-site.com
 * License:     GPL-2.0+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: redirect-plugin
 */

if (!defined('ABSPATH')) {
    exit; // Sécurité : empêcher l'accès direct
}

// Ajouter l'option dans les réglages WordPress
function rp_register_settings() {
    add_option('rp_frontend_redirect_url', '');
    register_setting('reading', 'rp_frontend_redirect_url');
}
add_action('admin_init', 'rp_register_settings');

// Ajouter le champ dans "Réglages > Lecture"
function rp_add_settings_field() {
    add_settings_field(
        'rp_frontend_redirect_url',
        'URL de redirection du front-office',
        'rp_render_settings_field',
        'reading',
        'default'
    );
}
add_action('admin_menu', 'rp_add_settings_field');

function rp_render_settings_field() {
    $url = get_option('rp_frontend_redirect_url', '');
    echo '<input type="url" name="rp_frontend_redirect_url" value="' . esc_url($url) . '" class="regular-text">';
}


function rp_redirect_all_users() {
    // Vérifier si c'est une requête AJAX ou API REST
    if (wp_doing_ajax() || defined('REST_REQUEST')) {
        return; // Autoriser ces requêtes
    }

    // Récupérer l'URL de redirection depuis les réglages
    $redirect_url = get_option('rp_frontend_redirect_url');

    // Vérifier que l'URL est bien définie et valide
    if (!empty($redirect_url) && filter_var($redirect_url, FILTER_VALIDATE_URL)) {
        // Rediriger l'utilisateur
        wp_redirect($redirect_url);
        exit;
    }
}
add_action('template_redirect', 'rp_redirect_all_users');