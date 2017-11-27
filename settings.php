<?php

require_once 'debug_to_console.php';
/* function get_NB_settings(){

   $options = get_option('seed_wnb_settings_1', array());
}
 */

/* Fuctions for slug-creation */

function new_random_slug(){
  return bin2hex(openssl_random_pseudo_bytes(10));
}




function plugin_add_settings_link( $links ) {
/* Create a link to the Settings*/   
    $settings_link = '<a href="options-general.php?page=nbci_options">' . __( 'Settings' ) . '</a>';
    array_unshift( $links, $settings_link );
    return $links;
 }
add_filter( 'plugin_action_links_' . plugin_basename(PLUGIN_FILE), 'plugin_add_settings_link' );
add_action( 'admin_menu', 'nbci_add_menu' );


function nbci_add_menu() 
/* Creating the menue for the plugin */
{
  $options = array(
    "random_slug" => new_random_slug()
  );

  add_options_page('Client Interface for NB Optionen', 'Client Interface for NB','manage_options' , 'nbci_options', 'nbci_option_page');
}


function nbci_option_page() {
    
if (!current_user_can('manage_options'))
{
  wp_die( __('You do not have sufficient permissions to access this page.') );
}

// variables for the field and option names 
$opt_name = 'nbci_random_slug';
$hidden_field_name = 'nbci_submit_hidden';
$data_field_name = 'nbci_random_slug';

// Read in existing option value from database
$opt_val = get_option( $opt_name );

// See if the user has posted us some information
// If they did, this hidden field will be set to 'Y'
if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
    // Read their posted value
    $opt_val = $_POST[ $data_field_name ];

    // Save the posted value in the database
    update_option( $opt_name, $opt_val );

    // Put a "settings saved" message on the screen

?>

<div class="updated"><p><strong><?php _e('settings saved.', 'menu-test' ); ?></strong></p></div>
<?php

}

// Now display the settings editing screen

echo '<div class="wrap">';

// header

echo "<h2>" . __( 'Client Interface for Wordpress Notification Bar ', 'menu-test' ) . "</h2>";

// settings form

?>

<form name="form1" method="post" action="">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

<p><?php _e("Random Slag", 'menu-test' ); ?> 
<input type="text" name="<?php echo $data_field_name; ?>" value="<?php echo $opt_val; ?>" size="40">
</p><hr />

<p class="submit">
<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
</p>

</form>
</div>

<?php
}
?>