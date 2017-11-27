<?php /* wordpress-notification-bar-client-interface.php */

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




function wpbar_activate() {
    /* ACTIVATION of the Plugin - will create a random_slag */  
    // variables for the field and option names 
      $ran_slug = new_random_slug();
      debug_to_console( "Activation " . $ran_slug);
      update_option( 'nbci_random_slug', $ran_slug );     
    }
    
    register_activation_hook( __FILE__, 'wpbar_activate' );

    function wpbar_deactivate() {
        /* ACTIVATION of the Plugin - will create a random_slag */  
        // variables for the field and option names 
        
          debug_to_console( "DE_activation" );         
         // update_option( $opt_name, new_random_slug() );
            
        }

    register_deactivation_hook( __FILE__, 'wpbar_deactivate');
    



defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
define( 'PLUGIN_PATH', plugin_dir_path(__FILE__ ));
define( 'PLUGIN_FILE', __FILE__);


require "debug_to_console.php";
require "wordpress-virtual-page.php";
require "settings.php";
require_once 'localise.php';

/*GLOBAL - remove later: */

define( 'THE_SLUG', get_option('nbci_random_slug').'/'.$localisation["loc_url_suffix"]);

/** Creation of the Page **/

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
        debug_to_console( '----> Template redirection! To: '. THE_SLUG );
   return PLUGIN_PATH . '/' . 'nbci_template.php';
 } else {
   return $original_template;
 }
}

/*********** Find Erorrs when activating Plugin ************** */

//update_option( 'plugin_error',  '' );
/*ERROR HANDLING */

//update_option( 'plugin_error',  '' );
/* 
function tl_save_error() {
    update_option( 'plugin_error',  ob_get_contents() );
}


add_action( 'activated_plugin', 'tl_save_error' );
add_action( 'deactivated_plugin', 'tl_save_error' );


/* Then to display the error message: */
/* echo get_option( 'plugin_error' ); */

/* Or you could do the following: */
//file_put_contents( 'C:\errors' , ob_get_contents() ); // or any suspected variable


?>