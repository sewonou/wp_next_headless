<?php
/**
 * Plugin Name: Rest API hands craft
 * Plugin URI:  https://mon-site.com/mon-super-plugin
 * Description: Une courte description de ce que fait votre plugin.
 * Version:     1.0.0
 * Author:      Djanta dev
 * Author URI:  https://mon-site.com
 * License:     GPL-2.0+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: rest-api
 * Domain Path: /languages
 */
function custom_rest_api_pages() {
    // Ajouter un champ personnalisé à l'API pour récupérer le contenu des blocs
    register_rest_field('page', 'custom_blocks', array(
        'get_callback'    => function ($data) {
            // Vous pouvez récupérer le contenu des blocs comme vous le souhaitez
            $content = get_post_field('post_content', $data['id']);
            $blocks = parse_blocks($content); // Cette fonction analyse le contenu en blocs
            return $blocks; // Retourne les blocs de contenu
        },
        'update_callback' => null, // Pas d'update possible via l'API
        'schema'          => null, // Pas de schéma nécessaire
    ));
}

add_action('rest_api_init', 'custom_rest_api_pages');