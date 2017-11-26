<!-- wordpress-notification-bar-client-interface.php -->
<?php
/*
Plugin Name:  Client Interface for Wordpress Notification Bar 
Plugin URI:   
Description:    Adds a page in the frontend for the client to toggle the Notification
                Bar, and change the text. It is an addon to Notofication Bar Plugin by SeedProd
                found here: https://wordpress.org/plugins/wordpress-notification-bar/

Version:      20171125
Author:       Leonid Sokolov
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  wporg
Domain Path:  /languages
*/

/**
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 */





defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
define( 'PLUGIN_PATH', plugin_dir_path(__FILE__ ));
define( 'PLUGIN_FILE', PLUGIN_PATH . 'wordpress-notification-bar-client-interface.php');

require "debug_to_console.php";
require "wordpress-virtual-page.php";
require "settings.php";

/*GLOBAL - remove later: */

define( 'THE_SLUG', 'cfaae88737603c70355c/info_einstellen');



// Name of the slug
$NBCI_SLUG = 'info_einstellen';

/** Creation of the Page **/

    /* Creating a random part for the slug: */
    $random_slug = bin2hex(openssl_random_pseudo_bytes(10));
    debug_to_console( 'RandomSlug: '.$random_slug );
    
    //$slug = $random_slug . '/' . $NBCI_SLUG;
    $slug = THE_SLUG;


$args = array(
    'slug' => $slug,
    'post_title' => 'Info einstellen',
    'post content' => 'Hier kommt das Template'
);


new WP_EX_PAGE_ON_THE_FLY($args);

//wp_reset_query();
/* Overriding the original Template */
add_filter( 'template_include',  'override_template');

function override_template( $original_template) {
debug_to_console( 'Function-Slug: '. THE_SLUG );
    if ( is_page(THE_SLUG) ) {
   return PLUGIN_PATH . '/' . 'nbci_template.php';
 } else {
   return $original_template;
 }
}