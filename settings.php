<?php

require_once 'debug_to_console.php';

//require PLUGIN_FILE;



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
$ran_slug_opt = get_option( $opt_name );


// See if the user has posted us some information
// If they did, this hidden field will be set to 'Y'
if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
    // Read their posted value
    // Save the posted value in the database    
    $ran_slug_update = new_random_slug();
    update_option( 'nbci_random_slug',$ran_slug_update);
  
    $ran_slug_opt = $ran_slug_update;

    
    // Put a "settings saved" message on the screen

?>

<div class="updated"><p><strong><?php _e('Link reset successul. Please copy the new one...', 'menu-test' ); ?></strong></p></div>
<?php

}

// Now display the settings editing screen

echo '<div class="wrap">';

// header

echo "<h2>" . __( 'Client Interface for Wordpress Notification Bar ', 'menu-test' ) . "</h2>";


// settings form
require 'localise.php';
$slug_url_suffix = $localisation["loc_url_suffix"];
$nbci_client_url = get_site_url(null, '/'.$ran_slug_opt.'/' . $slug_url_suffix);

?>
<head>
<script type="text/javascript">
  function copy_text() {
        var copyText = document.getElementById("ran_slug_link");
        copyText.select();
        document.execCommand("Copy");
        alert( "Url copied! "); 
    }
</script>

    <link rel="stylesheet" type="text/css" href="<?= plugins_url( 'nbci_styles.css', __FILE__ ) ?>">
</head>

<form name="form1" method="post" action="">
<input type="hidden" name="<?= $hidden_field_name; ?>" value="Y">

<p><b><?php _e("Please copy this URL for your users: ", 'menu-test' ); ?></b> 



<div class="input-group js-zeroclipboard-container">
        <input size="70" id="ran_slug_link" type="text" name = <?= $data_field_name; ?>  value="<?= $nbci_client_url?>"  class="form-control input-monospace input-sm" readonly="">
        <div class="input-group-button">
          <button onclick="copy_text();"  title="Copy to clipboard" class="btn btn-sm" type="button"><svg aria-hidden="true" class="octicon octicon-clippy" height="16" version="1.1" viewBox="0 0 14 16" width="14"><path fill-rule="evenodd" d="M2 13h4v1H2v-1zm5-6H2v1h5V7zm2 3V8l-3 3 3 3v-2h5v-2H9zM4.5 9H2v1h2.5V9zM2 12h2.5v-1H2v1zm9 1h1v2c-.02.28-.11.52-.3.7-.19.18-.42.28-.7.3H1c-.55 0-1-.45-1-1V4c0-.55.45-1 1-1h3c0-1.11.89-2 2-2 1.11 0 2 .89 2 2h3c.55 0 1 .45 1 1v5h-1V6H1v9h10v-2zM2 5h8c0-.55-.45-1-1-1H8c-.55 0-1-.45-1-1s-.45-1-1-1-1 .45-1 1-.45 1-1 1H3c-.55 0-1 .45-1 1z"></path></svg></button>
        </div>
    </div>

</p><hr />

<p class="submit">
<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Reset') ?>" />
</p>

</form>
</div>

<?php
}
?>