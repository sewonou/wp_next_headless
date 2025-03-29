<?php


use function Env\env;

function disable_frontend_access() {
    if (!is_admin() && !wp_doing_ajax() && !defined('REST_REQUEST')) {
        wp_redirect(constant('FRONTEND_URL'));
        exit;
    }
}
add_action('template_redirect', 'disable_frontend_access');

