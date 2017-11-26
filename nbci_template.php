<!-- template.php -->
</br></br></br>
<?php 

/* Localisation */
$loc_main_header= "Einstellungen";
$loc_toggle		= ["Aus","An"];
$loc_save 		= "Speichern";
$loc_saved		= "Änderungen gespeichert.";



/* loading the options from database*/
$nb_options = get_option('seed_wnb_settings_1', array());
echo "NBOPTIONS: " ;
var_dump( $nb_options );

$is_note = isset($nb_options["enabled"][0]);
$is_note_checked = $is_note ? 'checked' : '';

function save_nb_to_db($enable, $new_msg){
	global $nb_options;
	global $msg_to_user;
	global $loc_saved;

	if ($enable){
		debug_to_console('Turned NB -- ON');
		$nb_options['enabled']=['1'];
	} 
	else { // disable nb
		debug_to_console('Turned NB -- OFF');
		unset($nb_options['enabled']);
		}
	
	
	if ($nb_options['msg'] == $new_msg){
		$msg_to_user = $loc_saved;
	} else {
		$msg_to_user = $loc_saved ." (Text wurde geändert)";
		$nb_options['msg'] = $new_msg;
	}

	
	//update weather we added or removed "enabled"
	update_option('seed_wnb_settings_1',$nb_options );
	
}





/******** Incoming for $Post *********/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	//$data = $sanitize_text_field( $_POST['data'] );
	
	var_dump( $_POST );
	
	if ($_POST['enabled'] == "on"){
		$is_enabled = true;
	}
	elseif ($_POST['enabled'] == "off"){
		$is_enabled = false;
	}
	else {
		wp_die("There was a 'post', but Post data was corrupt. Please retry.");
	}

	$new_msg = sanitize_text_field($_POST['nbci_msg']);
	$is_note_checked = $is_enabled ? 'checked' : '';
	
	
	debug_to_console( "is note on?: ".(isset($nb_options["enabled"][0]) ? 'true' : 'false')."\n" );


	save_nb_to_db($is_enabled, $new_msg);
} 
else {
	debug_to_console('Loaded template with no post request');
}

?>


<!-- The Html Output -->

<html>

<style>
.text input:checked + .slider:after {
	/* Text hinter dem FlipFlop-Schalter */
	content: "<?= $loc_toggle[1] ?>" !important;

}
.text input + .slider:after {
	/* Text hinter dem FlipFlop-Schalter */
	content: "<?= $loc_toggle[0] ?>" !important;
}
</style>


<head>
    <link rel="stylesheet" type="text/css" href="<?= plugins_url( 'nbci_styles.css', __FILE__ ) ?>">
</head>

<body>

	<div id='container'> 
		
	<!-- Display message if there is one -->
		<?php if (isset($msg_to_user)): ?>
		<div id="msg_to_user"><?=$msg_to_user ?></div>
		<?php endif; ?>
	<!-- Prepare the form -->	
		<form method="post" action="http://127.0.0.1/mamas_wp/cfaae88737603c70355c/info_einstellen/">	
		<h1><?= $loc_main_header ?></h1>
			<div class="group">   
				<label>Info:</label>
				<br/>   
				<textarea type="text" class="nbci_textarea" name="nbci_msg" rows="3" ><?= $nb_options['msg']; ?> </textarea>
			</div>
			
			<div class="toggle text inline">
				<label>
					<input type="hidden" name="enabled" value="off">
					<input type="checkbox" name="enabled" <?= $is_note_checked?>>
					<span class="slider inline"></span>	
					<button class="button inline"><?= $loc_save ?></button>			
				</label>
				
			</div>
		</form>
	</div>
</body>

</html>